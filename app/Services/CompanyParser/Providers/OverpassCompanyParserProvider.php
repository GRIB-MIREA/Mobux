<?php

declare(strict_types=1);

namespace App\Services\CompanyParser\Providers;

use App\DataTransferObjects\CompanyParser\CompanySearchRequestData;
use App\DataTransferObjects\CompanyParser\CompanySearchResultData;
use App\Services\CompanyParser\Contracts\CompanyParserProviderInterface;
use Illuminate\Http\Client\Factory as HttpFactory;
use Illuminate\Http\Client\RequestException;
use InvalidArgumentException;

class OverpassCompanyParserProvider implements CompanyParserProviderInterface
{
    public function __construct(
        private readonly HttpFactory $http,
    ) {
    }

    public function label(): string
    {
        return 'OpenStreetMap / Overpass API';
    }

    /**
     * @return array<int, CompanySearchResultData>
     */
    public function search(CompanySearchRequestData|string $request, ?string $category = null, ?int $limit = null): array
    {
        if ($request instanceof CompanySearchRequestData) {
            $city = $request->city;
            $category = $request->category;
            $limit = $request->limit;
        } else {
            $city = trim($request);
            $category = trim((string) $category);
            $limit = $limit ?? (int) config('company_parser.default_limit', 50);
        }

        if ($city === '' || $category === '') {
            throw new InvalidArgumentException('City and category are required for Overpass search.');
        }

        $response = $this->http
            ->asForm()
            ->acceptJson()
            ->timeout((int) config('company_parser.overpass.timeout', 25))
            ->withHeaders([
                'User-Agent' => (string) config('company_parser.overpass.user_agent', 'Mobux Company Parser/1.0'),
            ])
            ->withOptions([
                'verify' => config('company_parser.overpass.verify', true),
            ])
            ->post((string) config('company_parser.overpass.endpoint'), [
                'data' => $this->buildQuery($city, $category, max(1, $limit)),
            ]);

        try {
            $response->throw();
        } catch (RequestException $exception) {
            throw new InvalidArgumentException(
                'Overpass API request failed: '.$exception->getMessage(),
                previous: $exception
            );
        }

        /** @var array{elements?:array<int, array<string, mixed>>} $payload */
        $payload = $response->json();
        $elements = $payload['elements'] ?? [];
        $results = [];

        foreach (array_slice($elements, 0, max(1, $limit)) as $item) {
            $normalized = $this->normalize($item);

            if (($normalized['name'] ?? '') === '') {
                continue;
            }

            $results[] = new CompanySearchResultData(
                externalId: $normalized['external_id'],
                name: $normalized['name'],
                city: $city,
                category: $category,
                website: $normalized['website'],
                phone: $normalized['phone'],
                address: $normalized['address'],
                sourceUrl: $normalized['source_url'],
                rawPayload: [
                    'provider' => 'overpass',
                    'normalized' => $normalized,
                    'osm' => $item,
                ],
            );
        }

        return $results;
    }

    /**
     * @param array<string, mixed> $item
     * @return array{
     *     external_id:?string,
     *     name:string,
     *     website:?string,
     *     phone:?string,
     *     address:?string,
     *     source_url:?string
     * }
     */
    public function normalize(array $item): array
    {
        /** @var array<string, mixed> $tags */
        $tags = is_array($item['tags'] ?? null) ? $item['tags'] : [];
        $type = isset($item['type']) ? (string) $item['type'] : null;
        $id = isset($item['id']) ? (string) $item['id'] : null;

        return [
            'external_id' => ($type !== null && $id !== null) ? $type.'-'.$id : null,
            'name' => trim((string) ($tags['name'] ?? '')),
            'website' => $this->normalizeNullableString(
                $this->firstNonEmptyTag($tags, ['website', 'contact:website'])
            ),
            'phone' => $this->normalizeNullableString(
                $this->firstNonEmptyTag($tags, ['phone', 'contact:phone'])
            ),
            'address' => $this->buildAddress($tags),
            'source_url' => $this->buildSourceUrl($type, $id),
        ];
    }

    private function buildQuery(string $city, string $category, int $limit): string
    {
        $location = $this->resolveCityLocation($city);
        $categoryFilter = $this->buildCategoryFilter($category);
        $radius = (int) config('company_parser.overpass.radius_meters', 10000);
        $lat = number_format($location['lat'], 6, '.', '');
        $lon = number_format($location['lon'], 6, '.', '');

        return <<<OVERPASS
[out:json][timeout:25];
(
  node{$categoryFilter}(around:{$radius},{$lat},{$lon});
  way{$categoryFilter}(around:{$radius},{$lat},{$lon});
  relation{$categoryFilter}(around:{$radius},{$lat},{$lon});
);
out center {$limit};
OVERPASS;
    }

    private function buildCategoryFilter(string $category): string
    {
        $normalized = mb_strtolower(trim($category));

        return match ($normalized) {
            'кофейни', 'кофе', 'coffee', 'cafe' => '["amenity"="cafe"]',
            'рестораны', 'ресторан' => '["amenity"="restaurant"]',
            'бары', 'бар' => '["amenity"="bar"]',
            'стоматологии', 'стоматология', 'dentist' => '["amenity"="dentist"]',
            'аптеки', 'аптека' => '["amenity"="pharmacy"]',
            'автосервис', 'автосервисы', 'car repair' => '["shop"="car_repair"]',
            'салоны красоты', 'салон красоты', 'beauty' => '["shop"="beauty"]',
            'парикмахерские', 'парикмахерская', 'hairdresser' => '["shop"="hairdresser"]',
            'автомойки', 'автомойка' => '["amenity"="car_wash"]',
            'гостиницы', 'отели', 'hotel' => '["tourism"="hotel"]',
            default => '["name"~"'.$this->escapeOverpassRegex($category).'", i]',
        };
    }

    /**
     * @param array<string, mixed> $tags
     * @param array<int, string> $keys
     */
    private function firstNonEmptyTag(array $tags, array $keys): ?string
    {
        foreach ($keys as $key) {
            $value = $tags[$key] ?? null;

            if (is_string($value) && trim($value) !== '') {
                return trim($value);
            }
        }

        return null;
    }

    /**
     * @param array<string, mixed> $tags
     */
    private function buildAddress(array $tags): ?string
    {
        $parts = array_filter([
            $this->normalizeNullableString((string) ($tags['addr:street'] ?? '')),
            $this->normalizeNullableString((string) ($tags['addr:housenumber'] ?? '')),
            $this->normalizeNullableString((string) ($tags['addr:city'] ?? '')),
        ]);

        if ($parts !== []) {
            return implode(', ', $parts);
        }

        return $this->normalizeNullableString((string) ($tags['addr:full'] ?? ''));
    }

    private function buildSourceUrl(?string $type, ?string $id): ?string
    {
        if ($type === null || $id === null) {
            return null;
        }

        return sprintf('https://www.openstreetmap.org/%s/%s', $type, $id);
    }

    private function normalizeNullableString(?string $value): ?string
    {
        if ($value === null) {
            return null;
        }

        $normalized = trim($value);

        return $normalized === '' ? null : $normalized;
    }

    private function escapeOverpassRegex(string $value): string
    {
        $escaped = preg_quote(trim($value), '/');

        return str_replace(['\\', '"'], ['\\\\', '\"'], $escaped);
    }

    /**
     * @return array{lat:float,lon:float}
     */
    private function resolveCityLocation(string $city): array
    {
        $response = $this->http
            ->acceptJson()
            ->timeout((int) config('company_parser.overpass.timeout', 25))
            ->withHeaders([
                'User-Agent' => (string) config('company_parser.overpass.user_agent', 'Mobux Company Parser/1.0'),
            ])
            ->withOptions([
                'verify' => config('company_parser.overpass.verify', true),
            ])
            ->get((string) config('company_parser.overpass.nominatim_endpoint'), [
                'q' => $city,
                'format' => 'jsonv2',
                'limit' => 1,
            ]);

        try {
            $response->throw();
        } catch (RequestException $exception) {
            throw new InvalidArgumentException(
                'OSM geocoding request failed: '.$exception->getMessage(),
                previous: $exception
            );
        }

        /** @var array<int, array{lat?:string,lon?:string}> $payload */
        $payload = $response->json();
        $first = $payload[0] ?? null;

        if (!is_array($first) || !isset($first['lat'], $first['lon'])) {
            throw new InvalidArgumentException(sprintf('City [%s] was not found in OpenStreetMap geocoder.', $city));
        }

        return [
            'lat' => (float) $first['lat'],
            'lon' => (float) $first['lon'],
        ];
    }
}
