<?php

declare(strict_types=1);

namespace App\Services\CompanyParser\Providers;

use App\DataTransferObjects\CompanyParser\CompanySearchRequestData;
use App\DataTransferObjects\CompanyParser\CompanySearchResultData;
use App\Services\CompanyParser\Contracts\CompanyParserProviderInterface;

class MockCompanyParserProvider implements CompanyParserProviderInterface
{
    public function label(): string
    {
        return 'Mock provider';
    }

    public function search(CompanySearchRequestData $request): array
    {
        $seed = abs(crc32(mb_strtolower($request->city.'|'.$request->category)));
        $prefixes = ['Alpha', 'Nova', 'Urban', 'Smart', 'Vector', 'Prime', 'Metro', 'Golden'];
        $suffixes = ['Group', 'Studio', 'Service', 'Hub', 'Point', 'Works', 'Lab', 'Center'];
        $results = [];

        for ($index = 1; $index <= $request->limit; $index++) {
            $name = sprintf(
                '%s %s %s',
                $prefixes[($seed + $index) % count($prefixes)],
                ucfirst(mb_strtolower($request->category)),
                $suffixes[($seed + ($index * 3)) % count($suffixes)]
            );

            $hasWebsite = $index % 3 !== 0;
            $externalId = sprintf('mock-%u-%d', $seed, $index);

            $results[] = new CompanySearchResultData(
                externalId: $externalId,
                name: $name,
                city: $request->city,
                category: $request->category,
                website: $hasWebsite ? sprintf('https://%s.example.com', strtolower(str_replace(' ', '-', $externalId))) : null,
                phone: sprintf('+7 (900) %03d-%02d-%02d', ($seed + $index) % 1000, ($index * 7) % 100, ($index * 11) % 100),
                address: sprintf('%s, %s, %d', $request->city, ucfirst(mb_strtolower($request->category)).' street', 10 + $index),
                sourceUrl: sprintf('https://mock-source.local/%s', $externalId),
                rawPayload: [
                    'provider' => 'mock',
                    'seed' => $seed,
                    'rank' => $index,
                ],
            );
        }

        return $results;
    }
}
