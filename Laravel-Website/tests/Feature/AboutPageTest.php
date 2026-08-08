<?php

namespace Tests\Feature;

use Tests\TestCase;

class AboutPageTest extends TestCase
{
    public function test_about_page_returns_a_successful_response(): void
    {
        $this->get('/about')->assertStatus(200);
    }

    public function test_about_page_renders_key_sections(): void
    {
        $response = $this->get('/about');

        $response->assertOk()
            ->assertSee('A Technology Company Built Around Your Business')
            ->assertSee('Who We Are')
            ->assertSee('Built on a Simple Belief')
            ->assertSee('Key Principles')
            ->assertSee('Our Mission, Vision & Values')
            ->assertSee('What We Stand For')
            ->assertSee('Why Businesses Choose SMEvolve')
            ->assertSee('The People Behind SMEvolve')
            ->assertSee('Ready to Build Something Great?');
    }

    public function test_about_page_renders_mission_vision_and_values_content(): void
    {
        $response = $this->get('/about');

        $response->assertOk()
            ->assertSee('Our Purpose')
            ->assertSee('Where We\'re Going')
            ->assertSee('To help businesses grow through practical, dependable digital solutions')
            ->assertSee('To become a trusted technology partner for businesses')
            ->assertSee('Core Values')
            ->assertSee('Business First')
            ->assertSee('Continuous Improvement');
    }

    public function test_about_page_no_longer_renders_ghost_numbers(): void
    {
        $response = $this->get('/about');

        $response->assertOk()
            ->assertDontSee('class="text-4xl font-extrabold tracking-tight text-gray-100', false)
            ->assertDontSee('text-4xl font-extrabold tracking-tight', false);
    }

    public function test_about_page_emits_structured_data(): void
    {
        $this->get('/about')
            ->assertOk()
            ->assertSee('application/ld+json')
            ->assertSee('Organization');
    }
}
