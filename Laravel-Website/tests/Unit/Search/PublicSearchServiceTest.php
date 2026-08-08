<?php

namespace Tests\Unit\Search;

use App\Services\Search\PublicSearchContract;
use App\Services\Search\PublicSearchResourceRegistry;
use App\Services\Search\PublicSearchService;
use PHPUnit\Framework\TestCase;
use stdClass;

class PublicSearchServiceTest extends TestCase
{
    public function test_normalize_trims_and_lowercases(): void
    {
        $service = new PublicSearchService(new PublicSearchResourceRegistry());

        $this->assertSame('smevolve', $service->normalize('  SMEvolve  '));
    }

    public function test_empty_query_returns_no_results(): void
    {
        $service = new PublicSearchService(new PublicSearchResourceRegistry());

        $this->assertSame([], $service->search('   '));
    }

    public function test_search_returns_grouped_results(): void
    {
        $registry = new PublicSearchResourceRegistry();

        $registry->register($this->provider('services', 'Services', [['type' => 'service', 'id' => 'website-development']]));
        $registry->register($this->provider('pages', 'Pages', [['type' => 'page', 'id' => 'home']]));

        $service = new PublicSearchService($registry);

        $results = $service->search('SME');

        $this->assertArrayHasKey('services', $results);
        $this->assertArrayHasKey('pages', $results);
    }

    public function test_search_can_restrict_to_a_resource_subset(): void
    {
        $registry = new PublicSearchResourceRegistry();

        $registry->register($this->provider('services', 'Services', [['type' => 'service', 'id' => 'website-development']]));
        $registry->register($this->provider('pages', 'Pages', [['type' => 'page', 'id' => 'home']]));

        $service = new PublicSearchService($registry);

        $results = $service->search('SME', ['services']);

        $this->assertArrayHasKey('services', $results);
        $this->assertArrayNotHasKey('pages', $results);
    }

    public function test_search_normalizes_the_query_before_forwarding_it(): void
    {
        $capture = new stdClass();
        $registry = new PublicSearchResourceRegistry();

        $registry->register($this->provider('services', 'Services', [['type' => 'service', 'id' => 'x']], $capture));

        $service = new PublicSearchService($registry);
        $service->search('  SMEvolve  ');

        $this->assertSame('smevolve', $capture->query);
    }

    public function test_search_forwards_the_limit_to_providers(): void
    {
        $capture = new stdClass();
        $registry = new PublicSearchResourceRegistry();

        $registry->register($this->provider('services', 'Services', [['type' => 'service', 'id' => 'x']], $capture));

        $service = new PublicSearchService($registry);
        $service->search('SME', [], 3);

        $this->assertSame(3, $capture->limit);
    }

    public function test_available_resources_maps_keys_to_labels(): void
    {
        $registry = new PublicSearchResourceRegistry();

        $registry->register($this->provider('services', 'Services', []));
        $registry->register($this->provider('packages', 'Packages', []));

        $service = new PublicSearchService($registry);

        $this->assertSame(['services' => 'Services', 'packages' => 'Packages'], $service->availableResources());
    }

    public function test_total_counts_all_results_across_groups(): void
    {
        $registry = new PublicSearchResourceRegistry();

        $registry->register($this->provider('services', 'Services', [
            ['type' => 'service', 'id' => 'a'],
            ['type' => 'service', 'id' => 'b'],
        ]));
        $registry->register($this->provider('pages', 'Pages', [['type' => 'page', 'id' => 'c']]));

        $service = new PublicSearchService($registry);

        $this->assertSame(3, $service->total($service->search('SME')));
    }

    private function provider(string $key, string $label, array $results = [], ?stdClass $capture = null): PublicSearchContract
    {
        return new class($key, $label, $results, $capture) implements PublicSearchContract {
            public function __construct(
                private readonly string $key,
                private readonly string $label,
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
}
