<?php

namespace App\Services\Search;

class PublicSearchResourceRegistry
{
    /** @var array<string, PublicSearchContract> */
    private array $providers = [];

    public function register(PublicSearchContract $provider): void
    {
        $this->providers[$provider->key()] = $provider;
    }

    /**
     * @return array<string, PublicSearchContract>
     */
    public function all(): array
    {
        return $this->providers;
    }
}
