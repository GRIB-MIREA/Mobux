<?php

declare(strict_types=1);

use App\Services\CompanyParser\Providers\OverpassCompanyParserProvider;
use App\Services\CompanyParser\Providers\MockCompanyParserProvider;

return [
    'default_provider' => env('COMPANY_PARSER_PROVIDER', 'overpass'),
    'default_limit' => (int) env('COMPANY_PARSER_LIMIT', 50),
    'queue' => env('COMPANY_PARSER_QUEUE', 'company-parser'),
    'overpass' => [
        'endpoint' => env('COMPANY_PARSER_OVERPASS_ENDPOINT', 'https://overpass-api.de/api/interpreter'),
        'nominatim_endpoint' => env('COMPANY_PARSER_NOMINATIM_ENDPOINT', 'https://nominatim.openstreetmap.org/search'),
        'timeout' => (int) env('COMPANY_PARSER_OVERPASS_TIMEOUT', 25),
        'radius_meters' => (int) env('COMPANY_PARSER_OVERPASS_RADIUS_METERS', 10000),
        'user_agent' => env('COMPANY_PARSER_OVERPASS_USER_AGENT', 'Mobux Company Parser/1.0'),
        'verify' => filter_var(env('COMPANY_PARSER_OVERPASS_VERIFY', true), FILTER_VALIDATE_BOOL),
    ],
    'providers' => [
        'overpass' => OverpassCompanyParserProvider::class,
        'mock' => MockCompanyParserProvider::class,
    ],
];
