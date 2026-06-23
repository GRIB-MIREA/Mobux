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

class GooglePlacesCompanyParserProvider implements CompanyParserProviderInterface
{
    public function __construct(
        private readonly HttpFactory $http,
    ) {
    }

    public function label(): string
    {
        return 'Google Maps / Places API';
    }

    /**
     * @return array<int, CompanySearchResultData>
     */
    public function search(CompanySearchRequestData $request): array
    {
        $apiKey = trim((string) config('company_parser.google.api_key'));

        if ($apiKey === '') {
            throw new InvalidArgumentException('Google Places API key is not configured.');
        }

        $remaining = max(1, $request->limit);
        $pageToken = null;
        $results = [];

        do {
            $pageSize = min($remaining, 20);
            $payload = $this->searchPage($request, $apiKey, $pageSize, $pageToken);

            /** @var array<int, array<string, mixed>> $places */
            $places = is_array($payload['places'] ?? null) ? $payload['places'] : [];

            foreach ($places as $place) {
                $results[] = $this->normalizePlace($place, $request);
                $remaining--;

                if ($remaining <= 0) {
                    break;
                }
            }

            $pageToken = $remaining > 0 && isset($payload['nextPageToken']) && is_string($payload['nextPageToken'])
                ? $payload['nextPageToken']
                : null;
        } while ($pageToken !== null && $remaining > 0);

        return $results;
    }

    /**
     * @param array<string, mixed> $place
     */
    private function normalizePlace(array $place, CompanySearchRequestData $request): CompanySearchResultData
    {
        /** @var array<string, mixed> $displayName */
        $displayName = is_array($place['displayName'] ?? null) ? $place['displayName'] : [];
        /** @var array<string, mixed> $location */
        $location = is_array($place['location'] ?? null) ? $place['location'] : [];

        return new CompanySearchResultData(
            externalId: isset($place['id']) && is_string($place['id']) ? $place['id'] : null,
            name: trim((string) ($displayName['text'] ?? '')),
            city: $request->city,
            category: $request->category,
            website: $this->normalizeNullableString($place['websiteUri'] ?? null),
            phone: $this->normalizeNullableString($place['nationalPhoneNumber'] ?? $place['internationalPhoneNumber'] ?? null),
            address: $this->normalizeNullableString($place['formattedAddress'] ?? null),
            latitude: isset($location['latitude']) && is_numeric($location['latitude']) ? (float) $location['latitude'] : null,
            longitude: isset($location['longitude']) && is_numeric($location['longitude']) ? (float) $location['longitude'] : null,
            sourceUrl: $this->normalizeNullableString($place['googleMapsUri'] ?? null),
            rawPayload: [
                'provider' => 'google',
                'place' => $place,
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
        ?string $pageToken,
    ): array {
        $body = [
            'textQuery' => $this->buildTextQuery($request),
            'pageSize' => $pageSize,
            'languageCode' => (string) config('company_parser.google.language_code', 'ru'),
        ];

        if ($pageToken !== null) {
            $body['pageToken'] = $pageToken;
        }

        try {
            $response = $this->http
                ->acceptJson()
                ->timeout((int) config('company_parser.google.timeout', 15))
                ->withHeaders([
                    'X-Goog-Api-Key' => $apiKey,
                    'X-Goog-FieldMask' => (string) config(
                        'company_parser.google.field_mask',
                        'places.id,places.displayName,places.formattedAddress,places.websiteUri,places.nationalPhoneNumber,places.internationalPhoneNumber,places.location,places.googleMapsUri,nextPageToken'
                    ),
                ])
                ->withOptions([
                    'verify' => config('company_parser.google.verify', true),
                ])
                ->post((string) config('company_parser.google.endpoint'), $body);

            $response->throw();
        } catch (RequestException|ConnectionException $exception) {
            throw new InvalidArgumentException(
                'Google Places API request failed: '.$exception->getMessage(),
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

    private function normalizeNullableString(mixed $value): ?string
    {
        if (!is_string($value)) {
            return null;
        }

        $normalized = trim($value);

        return $normalized === '' ? null : $normalized;
    }
}
