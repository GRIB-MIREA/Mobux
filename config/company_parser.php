<?php

declare(strict_types=1);

use App\Services\CompanyParser\Providers\MockCompanyParserProvider;

return [
    'default_provider' => env('COMPANY_PARSER_PROVIDER', 'mock'),
    'queue' => env('COMPANY_PARSER_QUEUE', 'company-parser'),
    'providers' => [
        'mock' => MockCompanyParserProvider::class,
    ],
];
