<?php

namespace Tests\Feature;

use Tests\TestCase;

class NavigationTest extends TestCase
{
    public function test_main_navigation_excludes_the_html_sitemap(): void
    {
        $routes = collect(config('navigation.main'))->pluck('route')->all();

        $this->assertNotContains('sitemap.page', $routes);
        $this->assertContains('contact', $routes, 'Contact must remain the final main nav item.');
    }

    public function test_footer_resources_do_not_link_to_the_html_sitemap(): void
    {
        $routes = collect(config('navigation.footer.resources'))->pluck('route')->all();

        $this->assertNotContains('sitemap.page', $routes);
    }
}