<?php

namespace Tests\Unit\Search;

use App\Data\Portfolio\PortfolioData;
use App\Models\PortfolioCategory;
use App\Models\PortfolioProject;
use App\Services\Search\PortfolioSearchProvider;
use Tests\TestCase;

class PortfolioSearchProviderTest extends TestCase
{
    public function test_finds_project_by_exact_title(): void
    {
        $this->seedProject();

        $results = $this->provider()->search('inventory management system', 5);

        $this->assertNotEmpty($results);
        $this->assertSame('sample-inventory-system', $results[0]['id']);
        $this->assertSame('portfolio', $results[0]['type']);
    }

    public function test_finds_project_by_technology(): void
    {
        $this->seedProject();

        $results = $this->provider()->search('alpine', 5);

        $this->assertNotEmpty($results);
    }

    public function test_finds_project_by_category(): void
    {
        $this->seedProject();

        $results = $this->provider()->search('custom software', 10);

        $this->assertNotEmpty($results);
    }

    public function test_result_url_links_to_the_project(): void
    {
        $this->seedProject();

        $results = $this->provider()->search('inventory management system', 5);

        $this->assertNotEmpty($results);
        $this->assertSame(route('portfolio.show', 'sample-inventory-system'), $results[0]['url']);
    }

    private function seedProject(): void
    {
        $category = PortfolioCategory::factory()->create([
            'slug' => 'custom-software',
            'name' => 'Custom Software',
            'is_published' => true,
        ]);

        PortfolioProject::factory()->create([
            'slug' => 'sample-inventory-system',
            'title' => 'Inventory Management System',
            'short_description' => 'A custom inventory platform for tracking stock and orders.',
            'portfolio_category_id' => $category->id,
            'technologies' => ['Laravel', 'MySQL', 'Tailwind CSS', 'Alpine.js'],
            'services' => ['custom-software'],
            'services_slugs' => ['custom-software'],
        ]);
    }

    private function provider(): PortfolioSearchProvider
    {
        return new PortfolioSearchProvider(app(PortfolioData::class));
    }
}
