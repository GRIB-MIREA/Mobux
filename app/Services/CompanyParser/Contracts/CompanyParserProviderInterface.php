<?php

declare(strict_types=1);

namespace App\Services\CompanyParser\Contracts;

use App\DataTransferObjects\CompanyParser\CompanySearchRequestData;

interface CompanyParserProviderInterface
{
    public function label(): string;

    /**
     * @return array<int, \App\DataTransferObjects\CompanyParser\CompanySearchResultData>
     */
    public function search(CompanySearchRequestData $request): array;
}
