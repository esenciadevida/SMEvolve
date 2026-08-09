<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use SimpleXMLElement;
use Tests\TestCase;

class SitemapTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Cache::flush();
    }

    public function test_sitemap_returns_xml_with_expected_content_type(): void
    {
        $this->get('/sitemap.xml')
            ->assertOk()
            ->assertHeader('Content-Type', 'application/xml; charset=UTF-8');
    }

    public function test_sitemap_contains_all_static_public_pages(): void
    {
        $response = $this->get('/sitemap.xml');

        foreach (['home', 'about', 'services.index', 'packages', 'portfolio', 'faq', 'contact'] as $routeName) {
            $response->assertSee(route($routeName), false);
        }
    }

    public function test_sitemap_contains_service_and_portfolio_urls(): void
    {
        $service = app(\App\Data\ServicesData::class)->catalog()->first();
        $project = app(\App\Data\Portfolio\PortfolioData::class)->projects()->first();

        $this->get('/sitemap.xml')
            ->assertOk()
            ->assertSee(route('services.show', $service['slug']), false)
            ->assertSee(route('portfolio.show', $project['slug']), false);
    }

    public function test_sitemap_excludes_private_and_system_routes(): void
    {
        $response = $this->get('/sitemap.xml');

        $response->assertOk()
            ->assertDontSee('/admin', false)
            ->assertDontSee('/api/', false)
            ->assertDontSee('/search', false)
            ->assertDontSee('/quote', false)
            ->assertDontSee('login', false)
            ->assertDontSee('/password', false);
    }

    public function test_sitemap_is_valid_xml_without_duplicate_or_localhost_urls(): void
    {
        $content = $this->get('/sitemap.xml')->getContent();

        $this->assertIsObject(simplexml_load_string($content), 'sitemap must be well-formed XML');

        preg_match_all('/<loc>(.*?)<\/loc>/', $content, $matches);

        $locs = $matches[1];

        $this->assertNotEmpty($locs, 'sitemap must contain at least one URL');
        $this->assertSame(count($locs), count(array_unique($locs)), 'sitemap must not contain duplicate URLs');

        foreach ($locs as $loc) {
            $this->assertStringStartsWith('https://', $loc, "URL [$loc] must use HTTPS");
            $this->assertStringNotContainsString('localhost', $loc);
            $this->assertStringNotContainsString('127.0.0.1', $loc);
        }
    }

    public function test_sitemap_static_routes_actually_exist(): void
    {
        foreach (config('seo.sitemap.static_routes') as $routeName) {
            $this->assertTrue(Route::has($routeName), "Route [$routeName] does not exist");
        }
    }
}
