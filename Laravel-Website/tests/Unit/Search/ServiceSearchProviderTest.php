<?php

namespace Tests\Unit\Search;

use App\Services\Content\ContentService;
use App\Services\Search\ServiceSearchProvider;
use Tests\TestCase;

class ServiceSearchProviderTest extends TestCase
{
    public function test_finds_service_by_exact_name(): void
    {
        $service = collect(config('website.services'))->firstWhere('slug', 'website-development');

        $results = (new ServiceSearchProvider(app(ContentService::class)))->search('website development', 5);

        $this->assertNotEmpty($results);
        $this->assertSame($service['name'], $results[0]['title']);
        $this->assertSame('website-development', $results[0]['id']);
    }

    public function test_search_is_case_insensitive(): void
    {
        $results = (new ServiceSearchProvider(app(ContentService::class)))->search('LARAVEL', 5);

        $this->assertNotEmpty($results);
        $this->assertSame('laravel-development', $results[0]['id']);
    }

    public function test_search_matches_service_descriptions(): void
    {
        $results = (new ServiceSearchProvider(app(ContentService::class)))->search('online stores', 5);

        $this->assertNotEmpty($results);
        $this->assertSame('ecommerce-development', $results[0]['id']);
    }

    public function test_exact_name_ranks_before_contains_match(): void
    {
        $results = (new ServiceSearchProvider(app(ContentService::class)))->search('ai solutions', 10);

        $ids = array_column($results, 'id');

        $this->assertSame('ai-solutions', $ids[0]);
    }

    public function test_per_resource_limit_applies(): void
    {
        $results = (new ServiceSearchProvider(app(ContentService::class)))->search('development', 2);

        $this->assertCount(2, $results);
    }

    public function test_result_shape_is_normalized(): void
    {
        $results = (new ServiceSearchProvider(app(ContentService::class)))->search('mobile app', 5);

        $this->assertNotEmpty($results);
        $result = $results[0];

        $this->assertSame('service', $result['type']);
        $this->assertSame(route('services.show', 'mobile-app-development'), $result['url']);
        $this->assertArrayHasKey('icon', $result['metadata']);
    }
}
