<?php

namespace Tests\Feature;

use App\Data\Portfolio\PortfolioData;
use App\Data\ServicesData;
use App\Models\PortfolioCategory;
use App\Models\PortfolioProject;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class HtmlSitemapTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Cache::flush();
    }

    public function test_html_sitemap_page_is_served(): void
    {
        $this->get('/sitemap')
            ->assertOk()
            ->assertSee('Explore every public page on SMEvolve', false)
            ->assertSee('XML Sitemap', false)
            ->assertSee('Robots.txt', false);
    }

    public function test_html_sitemap_includes_service_pages(): void
    {
        $service = app(ServicesData::class)->catalog()->first();

        $this->get('/sitemap')
            ->assertSee(route('services.show', $service['slug']), false);
    }

    public function test_html_sitemap_includes_portfolio_project_pages(): void
    {
        $this->seedProject();

        $project = app(PortfolioData::class)->projects()->first();

        $this->get('/sitemap')
            ->assertSee(route('portfolio.show', $project['slug']), false);
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
            'is_published' => true,
        ]);
    }
}
