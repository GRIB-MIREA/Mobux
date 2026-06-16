<?php

declare(strict_types=1);

namespace App\DataTransferObjects\CompanyParser;

final class CompanySearchRequestData
{
    public function __construct(
        public readonly string $city,
        public readonly string $category,
        public readonly string $provider,
        public readonly int $limit = 20,
    ) {
    }

    /**
     * @param array{city:string,category:string,provider:string,limit?:int|string} $data
     */
    public static function fromArray(array $data): self
    {
        $limit = $data['limit'] ?? 20;

        if ($limit === null || $limit === '') {
            $limit = 20;
        }

        return new self(
            city: trim($data['city']),
            category: trim($data['category']),
            provider: trim($data['provider']),
            limit: max(1, (int) $limit),
        );
    }
}
