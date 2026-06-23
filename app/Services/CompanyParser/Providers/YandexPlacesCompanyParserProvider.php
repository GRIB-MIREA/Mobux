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

class YandexPlacesCompanyParserProvider implements CompanyParserProviderInterface
{
    public function __construct(
        private readonly HttpFactory $http,
    ) {
    }

    public function label(): string
    {
        return 'Yandex Maps / Places API';
    }

    /**
     * @return array<int, CompanySearchResultData>
     */
    public function search(CompanySearchRequestData $request): array
    {
        $apiKey = trim((string) config('company_parser.yandex.api_key'));

        if ($apiKey === '') {
            throw new InvalidArgumentException('Yandex Places API key is not configured.');
        }

        $remaining = max(1, $request->limit);
        $skip = 0;
        $pageSize = min($remaining, 50);
        $results = [];

        do {
            $payload = $this->searchPage($request, $apiKey, $pageSize, $skip);

            /** @var array<int, array<string, mixed>> $features */
            $features = is_array($payload['features'] ?? null) ? $payload['features'] : [];

            foreach ($features as $feature) {
                $results[] = $this->normalizeFeature($feature, $request);
                $remaining--;

                if ($remaining <= 0) {
                    break;
                }
            }

            $skip += $pageSize;
            $pageSize = min($remaining, 50);
        } while ($remaining > 0 && count($features) === min(50, max(1, $request->limit)));

        return $results;
    }

    /**
     * @param array<string, mixed> $feature
     */
    private function normalizeFeature(array $feature, CompanySearchRequestData $request): CompanySearchResultData
    {
        /** @var array<string, mixed> $properties */
        $properties = is_array($feature['properties'] ?? null) ? $feature['properties'] : [];
        /** @var array<string, mixed> $companyMeta */
        $companyMeta = is_array($properties['CompanyMetaData'] ?? null) ? $properties['CompanyMetaData'] : [];
        /** @var array<int, array<string, mixed>> $phones */
        $phones = is_array($companyMeta['Phones'] ?? null) ? $companyMeta['Phones'] : [];
        /** @var array<string, mixed> $addressData */
        $addressData = is_array($companyMeta['Address'] ?? null) ? $companyMeta['Address'] : [];
        /** @var array<string, mixed> $geometry */
        $geometry = is_array($feature['geometry'] ?? null) ? $feature['geometry'] : [];
        /** @var array<int, mixed> $coordinates */
        $coordinates = is_array($geometry['coordinates'] ?? null) ? $geometry['coordinates'] : [];

        return new CompanySearchResultData(
            externalId: isset($companyMeta['id']) && is_string($companyMeta['id']) ? $companyMeta['id'] : null,
            name: trim((string) ($companyMeta['name'] ?? $properties['name'] ?? '')),
            city: $request->city,
            category: $request->category,
            website: $this->normalizeNullableString($companyMeta['url'] ?? null),
            phone: $this->extractPhone($phones),
            address: $this->normalizeNullableString($addressData['formatted'] ?? $companyMeta['address'] ?? $properties['description'] ?? null),
            latitude: isset($coordinates[1]) && is_numeric($coordinates[1]) ? (float) $coordinates[1] : null,
            longitude: isset($coordinates[0]) && is_numeric($coordinates[0]) ? (float) $coordinates[0] : null,
            sourceUrl: null,
            rawPayload: [
                'provider' => 'yandex',
                'feature' => $feature,
            ],
        );
    }

    /**
     * @return array<string, mixed>
     */
    private function searchPage(
        CompanySearchRequestData $request,
        string $apiKey,
        int $pageSize,
        int $skip,
    ): array {
        try {
            $response = $this->http
                ->acceptJson()
                ->timeout((int) config('company_parser.yandex.timeout', 15))
                ->withOptions([
                    'verify' => config('company_parser.yandex.verify', true),
                ])
                ->get((string) config('company_parser.yandex.endpoint'), [
                    'apikey' => $apiKey,
                    'text' => $this->buildTextQuery($request),
                    'type' => 'biz',
                    'lang' => (string) config('company_parser.yandex.lang', 'ru_RU'),
                    'results' => $pageSize,
                    'skip' => $skip,
                ]);

            $response->throw();
        } catch (RequestException|ConnectionException $exception) {
            throw new InvalidArgumentException(
                'Yandex Places API request failed: '.$exception->getMessage(),
                previous: $exception
            );
        }

        /** @var array<string, mixed> $payload */
        $payload = $response->json();

        return $payload;
    }

    private function buildTextQuery(CompanySearchRequestData $request): string
    {
        return trim($request->category.' '.$request->city);
    }

    /**
     * @param array<int, array<string, mixed>> $phones
     */
    private function extractPhone(array $phones): ?string
    {
        foreach ($phones as $phone) {
            if (isset($phone['formatted']) && is_string($phone['formatted'])) {
                $normalized = trim($phone['formatted']);

                if ($normalized !== '') {
                    return $normalized;
                }
            }
        }

        return null;
    }

    private function normalizeNullableString(mixed $value): ?string
    {
        if (!is_string($value)) {
            return null;
        }

        $normalized = trim($value);

        return $normalized === '' ? null : $normalized;
    }
}
