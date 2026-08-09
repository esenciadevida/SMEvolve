<?php

namespace Tests\Feature;

use Tests\TestCase;

class RobotsAndSeoTest extends TestCase
{
    public function test_robots_txt_is_served_and_references_the_sitemap(): void
    {
        $this->get('/robots.txt')
            ->assertOk()
            ->assertSee('Sitemap: https://smevolve.tech/sitemap.xml', false)
            ->assertSee('Disallow: /admin/', false)
            ->assertSee('Disallow: /api/', false);
    }

    public function test_homepage_is_indexable(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('<meta name="robots" content="index, follow">', false)
            ->assertDontSee('noindex');
    }

    public function test_public_pages_are_indexable(): void
    {
        foreach (['/about', '/services', '/packages', '/portfolio', '/faq', '/contact'] as $path) {
            $this->get($path)
                ->assertOk()
                ->assertSee('<meta name="robots" content="index, follow">', false);
        }
    }

    public function test_search_page_is_noindex_follow(): void
    {
        $this->get('/search')
            ->assertOk()
            ->assertSee('<meta name="robots" content="noindex, follow">', false);
    }

    public function test_quote_wizard_pages_are_noindex_follow(): void
    {
        $this->get('/quote')
            ->assertOk()
            ->assertSee('<meta name="robots" content="noindex, follow">', false);
    }

    public function test_admin_login_is_not_indexed(): void
    {
        $this->get('/admin/login')
            ->assertOk()
            ->assertSee('noindex');
    }

    public function test_canonical_urls_use_the_canonical_domain(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('<link rel="canonical" href="https://smevolve.tech"', false)
            ->assertDontSee('localhost');

        $this->get('/services')
            ->assertOk()
            ->assertSee('<link rel="canonical" href="https://smevolve.tech/services"', false)
            ->assertDontSee('localhost');
    }

    public function test_search_canonical_is_parameter_free(): void
    {
        $this->get('/search?q=website')
            ->assertOk()
            ->assertSee('<link rel="canonical" href="https://smevolve.tech/search"', false);
    }

    public function test_homepage_has_intentional_title_and_description(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('<title>SMEvolve | Digital Solutions for SMEs in Lagos, Nigeria</title>', false)
            ->assertSee('<meta name="description" content="', false);
    }

    public function test_homepage_includes_organization_and_website_schema(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('"@type":"Organization"', false)
            ->assertSee('"@type":"WebSite"', false);
    }
}
