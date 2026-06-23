<?php

declare(strict_types=1);

use App\Services\CompanyParser\Providers\GooglePlacesCompanyParserProvider;
use App\Services\CompanyParser\Providers\OverpassCompanyParserProvider;
use App\Services\CompanyParser\Providers\MockCompanyParserProvider;
use App\Services\CompanyParser\Providers\YandexPlacesCompanyParserProvider;

return [
    'default_provider' => env('COMPANY_PARSER_PROVIDER', 'overpass'),
    'default_limit' => (int) env('COMPANY_PARSER_LIMIT', 50),
    'queue' => env('COMPANY_PARSER_QUEUE', 'company-parser'),
    'google' => [
        'endpoint' => env('COMPANY_PARSER_GOOGLE_ENDPOINT', 'https://places.googleapis.com/v1/places:searchText'),
        'api_key' => env('COMPANY_PARSER_GOOGLE_API_KEY', ''),
        'field_mask' => env(
            'COMPANY_PARSER_GOOGLE_FIELD_MASK',
            'places.id,places.displayName,places.formattedAddress,places.websiteUri,places.nationalPhoneNumber,places.internationalPhoneNumber,places.location,places.googleMapsUri,nextPageToken'
        ),
        'language_code' => env('COMPANY_PARSER_GOOGLE_LANGUAGE_CODE', 'ru'),
        'timeout' => (int) env('COMPANY_PARSER_GOOGLE_TIMEOUT', 15),
        'verify' => filter_var(env('COMPANY_PARSER_GOOGLE_VERIFY', true), FILTER_VALIDATE_BOOL),
    ],
    'overpass' => [
        'endpoint' => env('COMPANY_PARSER_OVERPASS_ENDPOINT', 'https://overpass-api.de/api/interpreter'),
        'endpoints' => array_values(array_filter(array_map(
            static fn (string $endpoint): string => trim($endpoint),
            explode(',', (string) env(
                'COMPANY_PARSER_OVERPASS_ENDPOINTS',
                'https://overpass-api.de/api/interpreter,https://overpass.kumi.systems/api/interpreter,https://lz4.overpass-api.de/api/interpreter'
            ))
        ))),
        'nominatim_endpoint' => env('COMPANY_PARSER_NOMINATIM_ENDPOINT', 'https://nominatim.openstreetmap.org/search'),
        'nominatim_lookup_endpoint' => env('COMPANY_PARSER_NOMINATIM_LOOKUP_ENDPOINT', 'https://nominatim.openstreetmap.org/lookup'),
        'timeout' => (int) env('COMPANY_PARSER_OVERPASS_TIMEOUT', 12),
        'radius_meters' => (int) env('COMPANY_PARSER_OVERPASS_RADIUS_METERS', 10000),
        'fallback_radius_meters' => (int) env('COMPANY_PARSER_OVERPASS_FALLBACK_RADIUS_METERS', 5000),
        'final_radius_meters' => (int) env('COMPANY_PARSER_OVERPASS_FINAL_RADIUS_METERS', 2500),
        'max_attempts' => (int) env('COMPANY_PARSER_OVERPASS_MAX_ATTEMPTS', 4),
        'lookup_batch_size' => (int) env('COMPANY_PARSER_OVERPASS_LOOKUP_BATCH_SIZE', 20),
        'retry_sleep_milliseconds' => (int) env('COMPANY_PARSER_OVERPASS_RETRY_SLEEP_MILLISECONDS', 750),
        'user_agent' => env('COMPANY_PARSER_OVERPASS_USER_AGENT', 'Mobux Company Parser/1.0'),
        'verify' => filter_var(env('COMPANY_PARSER_OVERPASS_VERIFY', true), FILTER_VALIDATE_BOOL),
    ],
    'yandex' => [
        'endpoint' => env('COMPANY_PARSER_YANDEX_ENDPOINT', 'https://search-maps.yandex.ru/v1/'),
        'api_key' => env('COMPANY_PARSER_YANDEX_API_KEY', ''),
        'lang' => env('COMPANY_PARSER_YANDEX_LANG', 'ru_RU'),
        'timeout' => (int) env('COMPANY_PARSER_YANDEX_TIMEOUT', 15),
        'verify' => filter_var(env('COMPANY_PARSER_YANDEX_VERIFY', true), FILTER_VALIDATE_BOOL),
    ],
    'providers' => [
        'google' => GooglePlacesCompanyParserProvider::class,
        'overpass' => OverpassCompanyParserProvider::class,
        'mock' => MockCompanyParserProvider::class,
        'yandex' => YandexPlacesCompanyParserProvider::class,
    ],
];
