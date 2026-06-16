<?php

declare(strict_types=1);

namespace App\Services\CompanyParser;

use App\DataTransferObjects\CompanyParser\CompanySearchRequestData;
use App\DataTransferObjects\CompanyParser\CompanySearchResultData;
use App\Jobs\RunCompanyParserJob;
use App\Models\Company;
use App\Models\CompanyParserRun;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Throwable;

class CompanyParserService
{
    public function __construct(
        private readonly CompanyParserRegistry $registry,
    ) {
    }

    public function scheduleRun(CompanySearchRequestData $request, ?int $requestedBy = null): CompanyParserRun
    {
        $run = $this->createRun($request, $requestedBy);

        $this->dispatchRun($run);

        return $run;
    }

    public function createRun(CompanySearchRequestData $request, ?int $requestedBy = null): CompanyParserRun
    {
        return CompanyParserRun::query()->create([
            'requested_by' => $requestedBy,
            'provider' => $request->provider,
            'city' => $request->city,
            'category' => $request->category,
            'result_limit' => $request->limit,
            'status' => CompanyParserRun::STATUS_QUEUED,
        ]);
    }

    public function dispatchRun(CompanyParserRun $run): void
    {
        RunCompanyParserJob::dispatch($run->id)
            ->onQueue((string) config('company_parser.queue', 'default'));
    }

    public function processRun(CompanyParserRun $run): void
    {
        $run->forceFill([
            'status' => CompanyParserRun::STATUS_PROCESSING,
            'started_at' => now(),
            'finished_at' => null,
            'error_message' => null,
        ])->save();

        try {
            $request = new CompanySearchRequestData(
                city: $run->city,
                category: $run->category,
                provider: $run->provider,
                limit: $run->result_limit,
            );

            $results = $this->registry->resolve($run->provider)->search($request);
            $stats = $this->persistResults($run, $results);

            $run->forceFill([
                'status' => CompanyParserRun::STATUS_COMPLETED,
                'results_count' => count($results),
                'new_companies_count' => $stats['created'],
                'updated_companies_count' => $stats['updated'],
                'finished_at' => now(),
            ])->save();
        } catch (Throwable $exception) {
            $run->forceFill([
                'status' => CompanyParserRun::STATUS_FAILED,
                'error_message' => $exception->getMessage(),
                'finished_at' => now(),
            ])->save();

            report($exception);

            throw $exception;
        }
    }

    /**
     * @param array<int, CompanySearchResultData> $results
     * @return array{created:int,updated:int}
     */
    private function persistResults(CompanyParserRun $run, array $results): array
    {
        $created = 0;
        $updated = 0;
        $timestamp = Carbon::now();

        DB::transaction(function () use ($results, $run, $timestamp, &$created, &$updated): void {
            foreach ($results as $result) {
                $dedupeKey = $this->buildDedupeKey($run->provider, $result);

                $company = Company::query()->firstOrNew([
                    'dedupe_key' => $dedupeKey,
                ]);

                $isNew = !$company->exists;

                $company->fill([
                    'last_parser_run_id' => $run->id,
                    'provider' => $run->provider,
                    'external_id' => $result->externalId,
                    'name' => $result->name,
                    'city' => $result->city,
                    'category' => $result->category,
                    'website' => $this->normalizeNullableString($result->website),
                    'phone' => $this->normalizeNullableString($result->phone),
                    'address' => $this->normalizeNullableString($result->address),
                    'source_url' => $this->normalizeNullableString($result->sourceUrl),
                    'last_seen_at' => $timestamp,
                    'raw_payload' => $result->rawPayload,
                ]);

                if ($isNew) {
                    $company->first_seen_at = $timestamp;
                }

                $company->save();

                if ($isNew) {
                    $created++;

                    continue;
                }

                $updated++;
            }
        });

        return [
            'created' => $created,
            'updated' => $updated,
        ];
    }

    private function buildDedupeKey(string $provider, CompanySearchResultData $result): string
    {
        $parts = [
            $provider,
            $result->externalId ?: mb_strtolower($result->name),
            mb_strtolower($result->city),
            mb_strtolower($result->category),
            mb_strtolower((string) $result->address),
        ];

        return sha1(implode('|', $parts));
    }

    private function normalizeNullableString(?string $value): ?string
    {
        if ($value === null) {
            return null;
        }

        $normalized = trim($value);

        return $normalized === '' ? null : $normalized;
    }
}
