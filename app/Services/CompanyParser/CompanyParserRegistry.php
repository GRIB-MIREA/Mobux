<?php

declare(strict_types=1);

namespace App\Services\CompanyParser;

use App\Services\CompanyParser\Contracts\CompanyParserProviderInterface;
use InvalidArgumentException;

class CompanyParserRegistry
{
    /**
     * @return array<string, string>
     */
    public function availableProviders(): array
    {
        $providers = [];

        foreach (config('company_parser.providers', []) as $key => $className) {
            $providers[$key] = $this->resolve($key)->label();
        }

        return $providers;
    }

    public function resolve(string $provider): CompanyParserProviderInterface
    {
        $className = config(sprintf('company_parser.providers.%s', $provider));

        if (!is_string($className) || $className === '') {
            throw new InvalidArgumentException(sprintf('Company parser provider [%s] is not configured.', $provider));
        }

        $instance = app($className);

        if (!$instance instanceof CompanyParserProviderInterface) {
            throw new InvalidArgumentException(sprintf('Company parser provider [%s] must implement CompanyParserProviderInterface.', $provider));
        }

        return $instance;
    }
}
