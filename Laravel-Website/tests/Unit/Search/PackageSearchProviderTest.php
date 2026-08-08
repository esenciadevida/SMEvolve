<?php

namespace Tests\Unit\Search;

use App\Services\Search\PackageSearchProvider;
use App\Services\Content\ContentService;
use Tests\TestCase;

class PackageSearchProviderTest extends TestCase
{
    public function test_finds_website_package_by_exact_name(): void
    {
        $results = (new PackageSearchProvider(app(ContentService::class)))->search('starter website', 5);

        $this->assertNotEmpty($results);
        $this->assertSame('Starter Website', $results[0]['title']);
        $this->assertSame('starter', $results[0]['id']);
    }

    public function test_finds_packages_by_feature_keywords(): void
    {
        $results = (new PackageSearchProvider(app(ContentService::class)))->search('payment gateway integration', 5);

        $this->assertNotEmpty($results);
        $this->assertSame('ecommerce', $results[0]['id']);
    }

    public function test_finds_custom_solutions_by_example_keywords(): void
    {
        $results = (new PackageSearchProvider(app(ContentService::class)))->search('crm', 5);

        $this->assertNotEmpty($results);
        $this->assertSame('custom-software-development', $results[0]['id']);
    }

    public function test_package_results_link_to_the_packages_page(): void
    {
        $results = (new PackageSearchProvider(app(ContentService::class)))->search('e-commerce website', 5);

        $this->assertNotEmpty($results);
        $this->assertSame(route('packages') . '#website-packages', $results[0]['url']);
    }

    public function test_result_shape_is_normalized(): void
    {
        $results = (new PackageSearchProvider(app(ContentService::class)))->search('business website', 5);

        $this->assertNotEmpty($results);
        $result = $results[0];

        $this->assertSame('package', $result['type']);
        $this->assertSame('business', $result['id']);
        $this->assertSame('Business Website', $result['title']);
        $this->assertArrayHasKey('features', $result['metadata']);
    }
}
