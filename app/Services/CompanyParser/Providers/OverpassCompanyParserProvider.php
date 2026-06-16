<?php

declare(strict_types=1);

namespace App\Services\CompanyParser\Providers;

use App\DataTransferObjects\CompanyParser\CompanySearchRequestData;
use App\DataTransferObjects\CompanyParser\CompanySearchResultData;
use App\Services\CompanyParser\Contracts\CompanyParserProviderInterface;
use Illuminate\Http\Client\ConnectionException;
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

        $location = $this->resolveCityLocation($city);
        $lastErrorMessage = null;

        foreach ($this->buildSearchAttempts() as $attempt) {
            try {
                $payload = $this->executeOverpassQuery(
                    $attempt['endpoint'],
                    $this->buildQuery($location, $category, max(1, $limit), $attempt['radius'])
                );

                return $this->mapResults($payload, $city, $category, max(1, $limit));
            } catch (RequestException|ConnectionException $exception) {
                $lastErrorMessage = $this->formatAttemptError(
                    $attempt['endpoint'],
                    $attempt['radius'],
                    $exception
                );

                if (!$this->shouldRetry($exception)) {
                    break;
                }

                usleep($this->retrySleepMicroseconds());
            }
        }

        throw new InvalidArgumentException(
            'Overpass API is temporarily unavailable. Try again later, use a smaller limit, or reduce the search area.'
            .($lastErrorMessage !== null ? ' Last error: '.$lastErrorMessage : '')
        );
    }

    /**
     * @param array{elements?:array<int, array<string, mixed>>} $payload
     * @return array<int, CompanySearchResultData>
     */
    private function mapResults(array $payload, string $city, string $category, int $limit): array
    {
        $elements = $payload['elements'] ?? [];
        $lookupEntries = $this->fetchLookupEntries(array_slice($elements, 0, max(1, $limit)));
        $results = [];

        foreach (array_slice($elements, 0, max(1, $limit)) as $item) {
            $normalized = $this->normalize($item);
            $lookupKey = $this->buildLookupKeyFromItem($item);

            if ($lookupKey !== null) {
                $normalized = $this->mergeLookupData($normalized, $lookupEntries[$lookupKey] ?? null);
            }

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
                latitude: $normalized['latitude'],
                longitude: $normalized['longitude'],
                sourceUrl: $normalized['source_url'],
                rawPayload: [
                    'provider' => 'overpass',
                    'normalized' => $normalized,
                    'lookup' => $lookupKey !== null ? ($lookupEntries[$lookupKey] ?? null) : null,
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
     *     latitude:?float,
     *     longitude:?float,
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
                $this->firstNonEmptyTag($tags, ['website', 'contact:website', 'url', 'contact:url'])
            ),
            'phone' => $this->normalizeNullableString(
                $this->firstNonEmptyTag($tags, ['phone', 'contact:phone', 'mobile', 'contact:mobile'])
            ),
            'address' => $this->buildAddress($tags),
            'latitude' => $this->extractLatitude($item),
            'longitude' => $this->extractLongitude($item),
            'source_url' => $this->buildSourceUrl($type, $id),
        ];
    }

    /**
     * @param array{lat:float,lon:float} $location
     */
    private function buildQuery(array $location, string $category, int $limit, int $radius): string
    {
        $categoryFilter = $this->buildCategoryFilter($category);
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

    /**
     * @return array<int, array{endpoint:string,radius:int}>
     */
    private function buildSearchAttempts(): array
    {
        $attempts = [];

        foreach ($this->searchRadii() as $radius) {
            foreach ($this->overpassEndpoints() as $endpoint) {
                $attempts[] = [
                    'endpoint' => $endpoint,
                    'radius' => $radius,
                ];
            }
        }

        return array_slice($attempts, 0, max(1, (int) config('company_parser.overpass.max_attempts', 4)));
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
     * @return array<int, string>
     */
    private function overpassEndpoints(): array
    {
        $configured = config('company_parser.overpass.endpoints', []);

        if (!is_array($configured)) {
            return [];
        }

        $endpoints = array_values(array_unique(array_filter(
            array_map(
                static fn (mixed $endpoint): string => is_string($endpoint) ? trim($endpoint) : '',
                $configured
            )
        )));

        return $endpoints !== [] ? $endpoints : ['https://overpass-api.de/api/interpreter'];
    }

    /**
     * @return array<int, int>
     */
    private function searchRadii(): array
    {
        $primary = max(500, (int) config('company_parser.overpass.radius_meters', 10000));
        $fallback = max(500, (int) config('company_parser.overpass.fallback_radius_meters', 5000));
        $final = max(500, (int) config('company_parser.overpass.final_radius_meters', 2500));

        return array_values(array_unique([$final, $fallback, $primary]));
    }

    /**
     * @return array{elements?:array<int, array<string, mixed>>}
     */
    private function executeOverpassQuery(string $endpoint, string $query): array
    {
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
            ->post($endpoint, [
                'data' => $query,
            ]);

        $response->throw();

        /** @var array{elements?:array<int, array<string, mixed>>} $payload */
        $payload = $response->json();

        return $payload;
    }

    private function shouldRetry(RequestException|ConnectionException $exception): bool
    {
        if ($exception instanceof ConnectionException) {
            return true;
        }

        $status = $exception->response?->status();

        return in_array($status, [408, 409, 425, 429, 500, 502, 503, 504], true);
    }

    private function retrySleepMicroseconds(): int
    {
        return max(0, (int) config('company_parser.overpass.retry_sleep_milliseconds', 750)) * 1000;
    }

    private function formatAttemptError(string $endpoint, int $radius, RequestException|ConnectionException $exception): string
    {
        $host = parse_url($endpoint, PHP_URL_HOST) ?: $endpoint;

        if ($exception instanceof RequestException) {
            return sprintf(
                '%s (radius=%dm, status=%s)',
                $host,
                $radius,
                (string) $exception->response?->status()
            );
        }

        return sprintf('%s (radius=%dm, connection error)', $host, $radius);
    }

    /**
     * @param array<int, array<string, mixed>> $items
     * @return array<string, array{address:?string,phone:?string,website:?string}>
     */
    private function fetchLookupEntries(array $items): array
    {
        $osmIds = [];

        foreach (array_slice($items, 0, max(1, (int) config('company_parser.overpass.lookup_batch_size', 20))) as $item) {
            $osmId = $this->buildNominatimOsmId($item);

            if ($osmId !== null) {
                $osmIds[] = $osmId;
            }
        }

        if ($osmIds === []) {
            return [];
        }

        try {
            $response = $this->http
                ->acceptJson()
                ->timeout((int) config('company_parser.overpass.timeout', 12))
                ->withHeaders([
                    'User-Agent' => (string) config('company_parser.overpass.user_agent', 'Mobux Company Parser/1.0'),
                ])
                ->withOptions([
                    'verify' => config('company_parser.overpass.verify', true),
                ])
                ->get((string) config('company_parser.overpass.nominatim_lookup_endpoint'), [
                    'osm_ids' => implode(',', array_values(array_unique($osmIds))),
                    'format' => 'jsonv2',
                    'addressdetails' => 1,
                    'extratags' => 1,
                    'namedetails' => 0,
                ]);

            $response->throw();
        } catch (RequestException|ConnectionException) {
            return [];
        }

        /** @var array<int, array<string, mixed>> $payload */
        $payload = $response->json();
        $entries = [];

        foreach ($payload as $entry) {
            $lookupKey = $this->buildLookupKeyFromLookupEntry($entry);

            if ($lookupKey === null) {
                continue;
            }

            /** @var array<string, mixed> $extratags */
            $extratags = is_array($entry['extratags'] ?? null) ? $entry['extratags'] : [];

            $entries[$lookupKey] = [
                'address' => $this->buildLookupAddress($entry),
                'phone' => $this->normalizeNullableString(
                    $this->firstNonEmptyTag($extratags, ['phone', 'contact:phone', 'mobile', 'contact:mobile'])
                ),
                'website' => $this->normalizeNullableString(
                    $this->firstNonEmptyTag($extratags, ['website', 'contact:website', 'url', 'contact:url'])
                ),
            ];
        }

        return $entries;
    }

    /**
     * @param array{
     *     external_id:?string,
     *     name:string,
     *     website:?string,
     *     phone:?string,
     *     address:?string,
     *     latitude:?float,
     *     longitude:?float,
     *     source_url:?string
     * } $normalized
     * @param array{address:?string,phone:?string,website:?string}|null $lookupEntry
     * @return array{
     *     external_id:?string,
     *     name:string,
     *     website:?string,
     *     phone:?string,
     *     address:?string,
     *     latitude:?float,
     *     longitude:?float,
     *     source_url:?string
     * }
     */
    private function mergeLookupData(array $normalized, ?array $lookupEntry): array
    {
        if ($lookupEntry === null) {
            return $normalized;
        }

        if ($normalized['website'] === null && $lookupEntry['website'] !== null) {
            $normalized['website'] = $lookupEntry['website'];
        }

        if ($normalized['phone'] === null && $lookupEntry['phone'] !== null) {
            $normalized['phone'] = $lookupEntry['phone'];
        }

        if ($normalized['address'] === null && $lookupEntry['address'] !== null) {
            $normalized['address'] = $lookupEntry['address'];
        }

        return $normalized;
    }

    /**
     * @param array<string, mixed> $item
     */
    private function buildNominatimOsmId(array $item): ?string
    {
        $type = isset($item['type']) ? (string) $item['type'] : null;
        $id = isset($item['id']) ? (string) $item['id'] : null;

        if ($type === null || $id === null) {
            return null;
        }

        $prefix = match ($type) {
            'node' => 'N',
            'way' => 'W',
            'relation' => 'R',
            default => null,
        };

        return $prefix !== null ? $prefix.$id : null;
    }

    /**
     * @param array<string, mixed> $item
     */
    private function buildLookupKeyFromItem(array $item): ?string
    {
        $type = isset($item['type']) ? (string) $item['type'] : null;
        $id = isset($item['id']) ? (string) $item['id'] : null;

        if ($type === null || $id === null) {
            return null;
        }

        return $type.'-'.$id;
    }

    /**
     * @param array<string, mixed> $entry
     */
    private function buildLookupKeyFromLookupEntry(array $entry): ?string
    {
        $type = isset($entry['osm_type']) ? (string) $entry['osm_type'] : null;
        $id = isset($entry['osm_id']) ? (string) $entry['osm_id'] : null;

        if ($type === null || $id === null) {
            return null;
        }

        return $type.'-'.$id;
    }

    /**
     * @param array<string, mixed> $entry
     */
    private function buildLookupAddress(array $entry): ?string
    {
        /** @var array<string, mixed> $address */
        $address = is_array($entry['address'] ?? null) ? $entry['address'] : [];

        $parts = array_filter([
            $this->normalizeNullableString((string) ($address['road'] ?? '')),
            $this->normalizeNullableString((string) ($address['house_number'] ?? '')),
            $this->normalizeNullableString((string) ($address['suburb'] ?? '')),
            $this->normalizeNullableString((string) ($address['neighbourhood'] ?? '')),
            $this->normalizeNullableString((string) ($address['city'] ?? $address['town'] ?? $address['village'] ?? '')),
        ]);

        if ($parts !== []) {
            return implode(', ', array_values(array_unique($parts)));
        }

        return $this->normalizeNullableString((string) ($entry['display_name'] ?? ''));
    }

    /**
     * @param array<string, mixed> $item
     */
    private function extractLatitude(array $item): ?float
    {
        if (isset($item['lat']) && is_numeric($item['lat'])) {
            return (float) $item['lat'];
        }

        if (is_array($item['center'] ?? null) && isset($item['center']['lat']) && is_numeric($item['center']['lat'])) {
            return (float) $item['center']['lat'];
        }

        return null;
    }

    /**
     * @param array<string, mixed> $item
     */
    private function extractLongitude(array $item): ?float
    {
        if (isset($item['lon']) && is_numeric($item['lon'])) {
            return (float) $item['lon'];
        }

        if (is_array($item['center'] ?? null) && isset($item['center']['lon']) && is_numeric($item['center']['lon'])) {
            return (float) $item['center']['lon'];
        }

        return null;
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
