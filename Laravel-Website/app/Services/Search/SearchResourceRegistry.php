<?php

namespace App\Services\Search;

use App\Models\Administrator;
use InvalidArgumentException;

class SearchResourceRegistry
{
    /**
     * @var array<string, SearchContract>
     */
    private array $providers = [];

    public function register(SearchContract $provider): void
    {
        $this->providers[$provider->key()] = $provider;
    }

    public function get(string $key): SearchContract
    {
        if (! isset($this->providers[$key])) {
            throw new InvalidArgumentException("No search provider registered for key [{$key}].");
        }

        return $this->providers[$key];
    }

    /**
     * @return array<string, SearchContract>
     */
    public function all(): array
    {
        return $this->providers;
    }

    /**
     * Return only the providers the given administrator is authorized to use.
     *
     * @return array<string, SearchContract>
     */
    public function forAdministrator(Administrator $administrator): array
    {
        return array_filter(
            $this->providers,
            fn (SearchContract $provider) => $provider->canSearch($administrator)
        );
    }
}
