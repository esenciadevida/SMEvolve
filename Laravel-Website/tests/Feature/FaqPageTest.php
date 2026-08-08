<?php

namespace Tests\Feature;

use Tests\TestCase;

class FaqPageTest extends TestCase
{
    public function test_faq_page_returns_a_successful_response(): void
    {
        $this->get('/faq')->assertStatus(200);
    }

    public function test_faq_page_renders_hero_sections(): void
    {
        $response = $this->get('/faq');

        $response->assertOk()
            ->assertSee('KNOWLEDGE CENTER')
            ->assertSee('Find Answers to Your Questions')
            ->assertSee('Start Searching')
            ->assertSee('Contact Our Team')
            ->assertSee('Start Quote Wizard');
    }

    public function test_faq_page_renders_search_and_categories(): void
    {
        $response = $this->get('/faq');

        $response->assertOk()
            ->assertSee('faq-search-input')
            ->assertSee('Search for answers...')
            ->assertSee('Search Our Knowledge Center')
            ->assertSee('All Questions')
            ->assertSee('Pricing')
            ->assertSee('Development Process')
            ->assertSee('Support \\u0026 Maintenance', false);
    }

    public function test_faq_page_renders_faq_questions_from_configuration(): void
    {
        $faq = collect(config('faqs.items', []))
            ->where('status', 'active')
            ->first();

        $this->assertNotNull($faq, 'Expected at least one active FAQ.');

        $this->get('/faq')
            ->assertOk()
            ->assertSee($faq['question'])
            ->assertSee($faq['answer']);
    }

    public function test_faq_page_excludes_draft_questions(): void
    {
        $items = collect(config('faqs.items', []));
        $draft = $items->first();

        $this->assertNotNull($draft, 'Expected at least one FAQ to mark as draft.');

        config()->set('faqs.items', $items->map(function ($item) use ($draft) {
            return $item['id'] === $draft['id']
                ? [...$item, 'status' => 'draft']
                : $item;
        })->all());

        $this->get('/faq')
            ->assertOk()
            ->assertDontSee($draft['question']);
    }

    public function test_faq_page_emits_structured_data(): void
    {
        $response = $this->get('/faq');

        $response->assertOk()
            ->assertSee('application/ld+json')
            ->assertSee('WebPage')
            ->assertSee('BreadcrumbList')
            ->assertSee('FAQPage');
    }

    public function test_faq_page_uses_configurable_metadata(): void
    {
        $title = config('faqs.meta.title');

        $this->get('/faq')
            ->assertOk()
            ->assertSee('<title>'.e($title).'</title>', false)
            ->assertSee(e(config('faqs.meta.description')), false);
    }

    public function test_faq_page_renders_final_cta(): void
    {
        $this->get('/faq')
            ->assertOk()
            ->assertSee(config('cta.faq.heading'))
            ->assertSee('Start Quote Wizard')
            ->assertSee('Contact SMEvolve');
    }
}
