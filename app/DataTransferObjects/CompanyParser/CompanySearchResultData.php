<?php

declare(strict_types=1);

namespace App\DataTransferObjects\CompanyParser;

final class CompanySearchResultData
{
    /**
     * @param array<string, mixed> $rawPayload
     */
    public function __construct(
        public readonly ?string $externalId,
        public readonly string $name,
        public readonly string $city,
        public readonly string $category,
        public readonly ?string $website,
        public readonly ?string $phone,
        public readonly ?string $address,
        public readonly ?float $latitude,
        public readonly ?float $longitude,
        public readonly ?string $sourceUrl,
        public readonly array $rawPayload = [],
    ) {
    }
}
