<?php

namespace Tests\Unit\Search;

use App\Models\Administrator;
use App\Models\Role;
use App\Services\Search\SearchContract;
use App\Services\Search\SearchResourceRegistry;
use App\Services\Search\SearchService;
use PHPUnit\Framework\TestCase;
use stdClass;

class SearchServiceTest extends TestCase
{
    public function test_normalize_trims_and_lowercases(): void
    {
        $service = new SearchService(new SearchResourceRegistry());

        $this->assertSame('smevolve', $service->normalize('  SMEvolve  '));
    }

    public function test_empty_query_returns_no_results(): void
    {
        $service = new SearchService(new SearchResourceRegistry());

        $this->assertSame([], $service->search($this->administrator([]), '   '));
    }

    public function test_search_returns_grouped_results_from_authorized_providers(): void
    {
        $registry = new SearchResourceRegistry();

        $registry->register($this->provider('quotes', 'Quotes', 'quotes.search', [['type' => 'quote', 'id' => 1]]));
        $registry->register($this->provider('settings', 'Settings', 'settings.view', [['type' => 'setting', 'id' => 'company.name']]));

        $service = new SearchService($registry);

        $results = $service->search($this->administrator(['quotes.search', 'settings.view']), 'SME');

        $this->assertArrayHasKey('quotes', $results);
        $this->assertArrayHasKey('settings', $results);
    }

    public function test_search_skips_unauthorized_providers(): void
    {
        $registry = new SearchResourceRegistry();

        $registry->register($this->provider('quotes', 'Quotes', 'quotes.search', [['type' => 'quote', 'id' => 1]]));
        $registry->register($this->provider('administrators', 'Administrators', 'administrators.view', [['type' => 'administrator', 'id' => 2]]));

        $service = new SearchService($registry);

        $results = $service->search($this->administrator(['quotes.search']), 'SME');

        $this->assertArrayHasKey('quotes', $results);
        $this->assertArrayNotHasKey('administrators', $results);
    }

    public function test_search_can_restrict_to_a_resource_subset(): void
    {
        $registry = new SearchResourceRegistry();

        $registry->register($this->provider('quotes', 'Quotes', 'quotes.search', [['type' => 'quote', 'id' => 1]]));
        $registry->register($this->provider('settings', 'Settings', 'settings.view', [['type' => 'setting', 'id' => 'company.name']]));

        $service = new SearchService($registry);

        $results = $service->search($this->administrator(['quotes.search', 'settings.view']), 'SME', ['quotes']);

        $this->assertArrayHasKey('quotes', $results);
        $this->assertArrayNotHasKey('settings', $results);
    }

    public function test_search_normalizes_the_query_before_forwarding_it(): void
    {
        $capture = new stdClass();
        $registry = new SearchResourceRegistry();

        $registry->register($this->provider('quotes', 'Quotes', 'quotes.search', [['type' => 'quote', 'id' => 1]], $capture));

        $service = new SearchService($registry);
        $service->search($this->administrator(['quotes.search']), '  SMEvolve  ');

        $this->assertSame('smevolve', $capture->query);
    }

    public function test_search_forwards_the_limit_to_providers(): void
    {
        $capture = new stdClass();
        $registry = new SearchResourceRegistry();

        $registry->register($this->provider('quotes', 'Quotes', 'quotes.search', [['type' => 'quote', 'id' => 1]], $capture));

        $service = new SearchService($registry);
        $service->search($this->administrator(['quotes.search']), 'SME', [], 3);

        $this->assertSame(3, $capture->limit);
    }

    public function test_available_resources_reflect_permissions(): void
    {
        $registry = new SearchResourceRegistry();

        $registry->register($this->provider('quotes', 'Quotes', 'quotes.search', []));
        $registry->register($this->provider('settings', 'Settings', 'settings.view', []));

        $service = new SearchService($registry);

        $this->assertSame(['settings'], array_keys($service->availableResources($this->administrator(['settings.view']))));
    }

    private function provider(string $key, string $label, ?string $permission, array $results = [], ?stdClass $capture = null): SearchContract
    {
        return new class($key, $label, $permission, $results, $capture) implements SearchContract {
            public function __construct(
                private readonly string $key,
                private readonly string $label,
                private readonly ?string $permission,
                private readonly array $results,
                private readonly ?stdClass $capture,
            ) {
            }

            public function key(): string
            {
                return $this->key;
            }

            public function label(): string
            {
                return $this->label;
            }

            public function permission(): ?string
            {
                return $this->permission;
            }

            public function canSearch(Administrator $administrator): bool
            {
                return $this->permission === null || $administrator->hasPermission($this->permission);
            }

            public function search(string $query, int $limit = 5): array
            {
                if ($this->capture !== null) {
                    $this->capture->query = $query;
                    $this->capture->limit = $limit;
                }

                return $this->results;
            }
        };
    }

    private function administrator(array $permissions): Administrator
    {
        $role = new Role(['permissions' => $permissions]);
        $administrator = new Administrator(['name' => 'Test Admin']);
        $administrator->setRelation('role', $role);

        return $administrator;
    }
}
