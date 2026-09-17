<?php

namespace Tests\Feature;

use App\Data\ServicesData;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class PublicRoutesSmokeTest extends TestCase
{
    /**
     * Every static public page must render as HTML and never show the
     * framework error page. Guards against template/parse failures that
     * only surface at render time (e.g. unclosed array brackets).
     */
    public function test_all_static_public_pages_render(): void
    {
        $pages = [
            '/',
            '/about',
            '/services',
            '/packages',
            '/portfolio',
            '/faq',
            '/search',
            '/contact',
            '/sitemap',
            '/privacy-policy',
            '/terms',
            '/cookies',
        ];

        foreach ($pages as $path) {
            $response = $this->get($path);

            $response->assertStatus(200, "GET $path failed");
            $response->assertSee('<!DOCTYPE html>', false);
            $response->assertDontSee('Something Went Wrong', false);
        }
    }

    public function test_every_service_page_renders(): void
    {
        $catalog = app(ServicesData::class)->catalog();

        foreach ($catalog as $service) {
            $response = $this->get(route('services.show', $service['slug']));

            $response->assertStatus(200);
            $response->assertDontSee('Something Went Wrong', false);
        }
    }

    /**
     * Guards against a route being registered without a matching script
     * (e.g. a missing Blade file would surface as a 500 here).
     */
    public function test_public_route_names_all_exist(): void
    {
        $expected = [
            'home', 'about', 'services.index', 'services.show', 'packages',
            'portfolio', 'portfolio.show', 'portfolio.category', 'faq',
            'search', 'contact', 'sitemap', 'sitemap.page', 'quote',
            'privacy-policy.index', 'terms.index', 'cookies.index',
        ];

        foreach ($expected as $route) {
            $this->assertTrue(Route::has($route), "Route [$route] is missing");
        }
    }
}
