<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomePageTest extends TestCase
{
    public function test_homepage_returns_a_successful_response(): void
    {
        $this->get('/')->assertStatus(200);
    }

    public function test_homepage_renders_the_skeleton_loader(): void
    {
        $response = $this->get('/');

        $response->assertOk()
            ->assertSee('id="site-skeleton"', false);
    }

    public function test_homepage_has_no_scroll_reveal_attributes(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertDontSee('data-reveal', false);
    }

    public function test_homepage_renders_ai_showcase_icons(): void
    {
        $response = $this->get('/');

        $response->assertOk()
            ->assertSee('M8.625 9.75C8.625 9.95711', false)
            ->assertSee('M9.59356 3.94014', false);
    }
}