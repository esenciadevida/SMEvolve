<?php

namespace App\Services\Search;

use App\Models\Administrator;

class SearchService
{
    public function __construct(
        private readonly SearchResourceRegistry $registry,
    ) {}

    /**
     * Search authorized resources and return results grouped by resource.
     *
     * @param  array<int, string>  $resources  Optional subset of provider keys.
     * @return array<string, array<int, array<string, mixed>>>
     */
    public function search(Administrator $administrator, string $query, array $resources = [], int $limit = 5): array
    {
        $query = $this->normalize($query);

        if ($query === '') {
            return [];
        }

        $providers = $this->registry->forAdministrator($administrator);

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
     * Map of resource keys a given administrator is authorized to search.
     *
     * @return array<string, string>
     */
    public function availableResources(Administrator $administrator): array
    {
        $available = [];

        foreach ($this->registry->forAdministrator($administrator) as $key => $provider) {
            $available[$key] = $provider->label();
        }

        return $available;
    }
}
