<?php

namespace Tests\Feature;

use Tests\TestCase;

class PackagesPageTest extends TestCase
{
    public function test_packages_page_returns_a_successful_response(): void
    {
        $this->get('/packages')->assertStatus(200);
    }

    public function test_packages_page_renders_key_sections(): void
    {
        $response = $this->get('/packages');

        $response->assertOk()
            ->assertSee('Flexible Packages for Every Stage of Your Business')
            ->assertSee('Transparent Pricing. Tailored Solutions.')
            ->assertSee('Professional Websites Built for Business Growth')
            ->assertSee('Custom Solutions', false)
            ->assertSee('Find the Package That Fits Your Business')
            ->assertSee('Frequently Asked Questions About Our Packages')
            ->assertSee('Let\'s Find the Right Solution for Your Business');
    }

    public function test_packages_page_renders_package_cards_from_configuration(): void
    {
        $response = $this->get('/packages');

        $response->assertOk()
            ->assertSee('Starter Website')
            ->assertSee('Business Website')
            ->assertSee('Professional Website')
            ->assertSee('E-Commerce Website')
            ->assertSee('Most Popular');
    }

    public function test_packages_page_renders_custom_solutions_from_configuration(): void
    {
        $response = $this->get('/packages');

        $response->assertOk()
            ->assertSee('Custom Software Development')
            ->assertSee('AI Solutions')
            ->assertSee('Business Automation')
            ->assertSee('Mobile Applications')
            ->assertSee('API Development & Integration')
            ->assertSee('Enterprise Platforms')
            ->assertSee('Discovery Call')
            ->assertSee('Project Kickoff');
    }

    public function test_packages_page_renders_packages_tagged_faqs(): void
    {
        $faq = collect(config('faqs.items', []))
            ->where('tag', 'packages')
            ->first();

        $this->assertNotNull($faq, 'Expected at least one package-tagged FAQ.');

        $this->get('/packages')
            ->assertOk()
            ->assertSee($faq['question']);
    }

    public function test_packages_page_emits_structured_data(): void
    {
        $response = $this->get('/packages');

        $response->assertOk()
            ->assertSee('application/ld+json')
            ->assertSee('WebPage')
            ->assertSee('BreadcrumbList')
            ->assertSee('FAQPage');
    }

    public function test_packages_page_uses_configurable_metadata(): void
    {
        $title = config('packages.meta.title');

        $this->get('/packages')
            ->assertOk()
            ->assertSee('<title>'.e($title).'</title>', false)
            ->assertSee(e(config('packages.meta.description')), false);
    }
}
