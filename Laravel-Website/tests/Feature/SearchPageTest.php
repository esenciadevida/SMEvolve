<?php

namespace Tests\Feature;

use Illuminate\Support\Str;
use Tests\TestCase;

class SearchPageTest extends TestCase
{
    public function test_search_page_returns_a_successful_response(): void
    {
        $this->get('/search')->assertStatus(200);
    }

    public function test_search_page_renders_hero_and_form(): void
    {
        $response = $this->get('/search');

        $response->assertOk()
            ->assertSee('SEARCH')
            ->assertSee('Find It Across SMEvolve')
            ->assertSee('site-search-page-input')
            ->assertSee('Search');
    }

    public function test_empty_query_shows_search_prompt(): void
    {
        $this->get('/search')
            ->assertOk()
            ->assertSee('Search across the SMEvolve website');
    }

    public function test_search_page_finds_services(): void
    {
        $service = collect(config('website.services'))->firstWhere('slug', 'website-development');

        $this->get('/search?q=website')
            ->assertOk()
            ->assertSee($service['name'])
            ->assertSee(route('services.show', $service['slug']), false);
    }

    public function test_search_page_shows_no_results_state(): void
    {
        $this->get('/search?q=zzz-nonexistent-zzz')
            ->assertOk()
            ->assertSee('No results found');
    }

    public function test_search_page_renders_filter_chips(): void
    {
        $response = $this->get('/search');

        $response->assertOk()
            ->assertSee('All')
            ->assertSee('Services')
            ->assertSee('Packages')
            ->assertSee('FAQs');
    }

    public function test_autocomplete_returns_grouped_json_results(): void
    {
        $service = collect(config('website.services'))->firstWhere('slug', 'website-development');

        $response = $this->withHeaders(['Accept' => 'application/json'])
            ->getJson('/search/autocomplete?q=website')
            ->assertOk()
            ->assertJsonPath('query', 'website')
            ->assertJsonStructure(['results' => ['services' => [['type', 'id', 'title', 'url']]]]);

        $this->assertSame($service['name'], $response->json('results.services.0.title'));
    }

    public function test_autocomplete_can_be_restricted_by_type(): void
    {
        $this->withHeaders(['Accept' => 'application/json'])
            ->getJson('/search/autocomplete?q=website&type=services')
            ->assertOk()
            ->assertJsonStructure(['results' => ['services']])
            ->assertJsonMissingPath('results.packages');
    }

    public function test_autocomplete_validates_minimum_query_length(): void
    {
        $this->withHeaders(['Accept' => 'application/json'])
            ->getJson('/search/autocomplete?q=a')
            ->assertUnprocessable()
            ->assertJsonValidationErrors('q');
    }

    public function test_autocomplete_validates_maximum_query_length(): void
    {
        $this->withHeaders(['Accept' => 'application/json'])
            ->getJson('/search/autocomplete?q='.Str::repeat('a', 121))
            ->assertUnprocessable()
            ->assertJsonValidationErrors('q');
    }

    public function test_autocomplete_rejects_unknown_resource_filters(): void
    {
        $this->withHeaders(['Accept' => 'application/json'])
            ->getJson('/search/autocomplete?q=website&type=unknown')
            ->assertUnprocessable()
            ->assertJsonValidationErrors('type');
    }

    public function test_autocomplete_is_rate_limited(): void
    {
        config()->set('website.search.rate_limit', 2);

        for ($i = 0; $i < 2; $i++) {
            $this->withHeaders(['Accept' => 'application/json'])
                ->getJson('/search/autocomplete?q=website')
                ->assertOk();
        }

        $this->withHeaders(['Accept' => 'application/json'])
            ->getJson('/search/autocomplete?q=website')
            ->assertStatus(429);
    }
}
