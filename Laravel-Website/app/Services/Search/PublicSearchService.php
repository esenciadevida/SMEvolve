<?php

namespace App\Services\Search;

class PublicSearchService
{
    public function __construct(
        private readonly PublicSearchResourceRegistry $registry,
    ) {
    }

    /**
     * Search public resources and return results grouped by resource.
     *
     * @param  array<int, string>  $resources  Optional subset of provider keys.
     * @return array<string, array<int, array<string, mixed>>>
     */
    public function search(string $query, array $resources = [], int $limit = 5): array
    {
        $query = $this->normalize($query);

        if ($query === '') {
            return [];
        }

        $providers = $this->registry->all();

        if ($resources !== []) {
            $providers = array_intersect_key($providers, array_flip($resources));
        }

        $results = [];

        foreach ($providers as $key => $provider) {
            $group = $provider->search($query, $limit);

            if ($group !== []) {
                $results[$key] = $group;
            }
        }

        return $results;
    }

    /**
     * Normalize search input without altering its meaning: trim whitespace
     * and lower-case for case-insensitive matching.
     */
    public function normalize(string $query): string
    {
        return trim(mb_strtolower($query));
    }

    /**
     * Map of resource keys a visitor can search.
     *
     * @return array<string, string>
     */
    public function availableResources(): array
    {
        $available = [];

        foreach ($this->registry->all() as $key => $provider) {
            $available[$key] = $provider->label();
        }

        return $available;
    }

    /**
     * @param  array<string, array<int, array<string, mixed>>>  $results
     */
    public function total(array $results): int
    {
        return collect($results)->flatten(1)->count();
    }
}
