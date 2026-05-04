<?php

namespace App\Console\Commands;

use App\Models\Card;
use App\Models\Category;
use App\Models\Promocode;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImportPerfluencePromocodes extends Command
{
    protected $signature = 'perfluence:import {--keep-missing : Do not delete imported promocodes missing from the feed} {--refresh-images : Download logos again}';

    protected $description = 'Import shops and promocodes from Perfluence JSON API';

    private array $seenPromocodeIds = [];

    public function handle(): int
    {
        $key = config('services.perfluence.promocode_api_key');
        if (!$key) {
            $this->error('PERFLUENCE_PROMOCODE_API_KEY is not configured.');
            return self::FAILURE;
        }

        $response = Http::timeout(30)->get(config('services.perfluence.promocode_api_url'), [
            'key' => $key,
        ]);

        if (!$response->successful()) {
            $this->error("Perfluence API returned HTTP {$response->status()}.");
            return self::FAILURE;
        }

        $payload = $response->json();
        if (($payload['success'] ?? false) !== true || !is_array($payload['data'] ?? null)) {
            $this->error('Perfluence API response has unexpected format.');
            return self::FAILURE;
        }

        $stats = [
            'projects' => 0,
            'categories' => 0,
            'cards' => 0,
            'promocodes' => 0,
            'deleted_promocodes' => 0,
        ];

        foreach ($payload['data'] as $item) {
            DB::transaction(function () use ($item, &$stats) {
                $this->importProject($item, $stats);
            });
        }

        if (!$this->option('keep-missing')) {
            $stats['deleted_promocodes'] = Promocode::query()
                ->whereNotNull('perfluence_promocode_id')
                ->whereNotIn('perfluence_promocode_id', $this->seenPromocodeIds ?: [0])
                ->delete();
        }

        $this->components->info(
            "Imported {$stats['projects']} projects, {$stats['categories']} categories, {$stats['cards']} cards, {$stats['promocodes']} promocodes. Deleted {$stats['deleted_promocodes']} stale promocodes."
        );

        return self::SUCCESS;
    }

    private function importProject(array $item, array &$stats): void
    {
        $project = $item['project'] ?? null;
        if (!$project || empty($project['id']) || empty($project['name'])) {
            return;
        }

        $stats['projects']++;

        $category = $this->upsertCategory($project);
        $stats['categories']++;

        $card = $this->upsertCard($project, $category);
        $stats['cards']++;

        foreach (($item['groups'] ?? []) as $group) {
            $landing = $group['landing'] ?? [];
            $link = $this->subscriberLink($group, $landing, $project);

            foreach (($group['promocodes'] ?? []) as $promo) {
                if (empty($promo['id']) || empty($promo['code'])) {
                    continue;
                }

                $this->seenPromocodeIds[] = (int) $promo['id'];
                $this->upsertPromocode($promo, $landing, $link, $card);
                $stats['promocodes']++;
            }
        }
    }

    private function upsertCategory(array $project): Category
    {
        $categoryId = $project['category_id'] ?? null;
        $title = trim($project['category_name'] ?? '') ?: 'Другое';

        $category = Category::withTrashed()
            ->where('perfluence_category_id', $categoryId)
            ->when(!$categoryId, fn ($query) => $query->where('title', $title))
            ->first();

        if (!$category) {
            $category = new Category([
                'position' => ((int) Category::query()->max('position')) + 1,
            ]);
        }

        $category->fill([
            'perfluence_category_id' => $categoryId,
            'title' => $title,
        ]);
        if ($category->exists && $category->trashed()) {
            $category->restore();
        }
        $category->save();

        return $category;
    }

    private function upsertCard(array $project, Category $category): Card
    {
        $projectId = (int) $project['id'];
        $description = $this->plainText($project['product_info'] ?? '');
        $rules = $this->plainText($project['subscribers_condition'] ?? '');

        $card = Card::withTrashed()->firstOrNew(['perfluence_project_id' => $projectId]);
        $image = $card->image;

        if (!$image || $this->option('refresh-images')) {
            $image = $this->downloadLogo($project['logo_widget'] ?? $project['logo'] ?? null, $projectId) ?: $image;
        }

        $card->fill([
            'title' => trim($project['name']),
            'description' => $description,
            'rules' => $rules,
            'image' => $image,
            'link' => $project['site'] ?? null,
            'perfluence_site' => $project['site'] ?? null,
            'position' => $card->position ?: (((int) Card::query()->max('position')) + 1),
            'category_id' => $category->id,
        ]);
        if ($card->exists && $card->trashed()) {
            $card->restore();
        }
        $card->save();

        return $card;
    }

    private function upsertPromocode(array $promo, array $landing, ?string $link, Card $card): Promocode
    {
        return Promocode::updateOrCreate(
            ['perfluence_promocode_id' => (int) $promo['id']],
            [
                'perfluence_landing_id' => $landing['id'] ?? null,
                'title' => trim($promo['code']),
                'reward' => $this->plainText($promo['name'] ?? '') ?: null,
                'promo_terms' => $this->plainText($promo['promo_terms'] ?? '') ?: null,
                'region_promo' => $this->regionToString($promo['region_promo'] ?? null),
                'is_hit' => (bool) ($promo['is_hit'] ?? false),
                'is_universal' => (bool) ($promo['is_universal'] ?? false),
                'repeat_order' => (bool) ($promo['repeat_order'] ?? false),
                'link' => $link,
                'expiration_date' => $this->parseDate($promo['date'] ?? null),
                'card_id' => $card->id,
            ]
        );
    }

    private function subscriberLink(array $group, array $landing, array $project): ?string
    {
        $links = $group['links_for_subscribers'] ?? [];
        if (!empty($links[0]['link'])) {
            return $links[0]['link'];
        }

        return $landing['link'] ?? $project['site'] ?? null;
    }

    private function downloadLogo(?string $url, int $projectId): ?string
    {
        if (!$url) {
            return null;
        }

        $response = Http::timeout(20)->get($url);
        if (!$response->successful()) {
            return null;
        }

        $extension = $this->imageExtension($response->header('Content-Type'), $url);
        $path = "images/perfluence/{$projectId}.{$extension}";

        Storage::disk('public')->put($path, $response->body());

        return $path;
    }

    private function imageExtension(?string $contentType, string $url): string
    {
        return match (true) {
            str_contains((string) $contentType, 'jpeg') => 'jpg',
            str_contains((string) $contentType, 'png') => 'png',
            str_contains((string) $contentType, 'webp') => 'webp',
            default => Str::of(parse_url($url, PHP_URL_PATH) ?: 'logo.png')->afterLast('.')->lower()->value() ?: 'png',
        };
    }

    private function parseDate(?string $date): ?string
    {
        if (!$date) {
            return null;
        }

        try {
            return Carbon::createFromFormat('d.m.Y', $date)->toDateString();
        } catch (\Throwable) {
            return null;
        }
    }

    private function plainText(?string $value): string
    {
        $value = html_entity_decode((string) $value, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $value = preg_replace('/<br\s*\/?>/i', "\n", $value);
        $value = preg_replace('/<\/(p|div|li|h[1-6])>/i', "\n", $value);
        $value = strip_tags($value);
        $value = preg_replace("/[ \t]+\n/", "\n", $value);
        $value = preg_replace("/\n{3,}/", "\n\n", $value);

        return trim($value);
    }

    private function regionToString(mixed $region): ?string
    {
        if (is_array($region)) {
            return implode(', ', array_filter($region));
        }

        if (is_string($region) && $region !== '') {
            return $region;
        }

        return null;
    }
}
