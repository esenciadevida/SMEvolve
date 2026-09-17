<?php

namespace Tests\Feature;

use App\Data\ServicesData;
use Tests\TestCase;

class ServicesPageTest extends TestCase
{
    public function test_services_index_returns_a_successful_response(): void
    {
        $this->get('/services')->assertStatus(200);
    }

    public function test_services_index_renders_catalog_services(): void
    {
        $catalog = app(ServicesData::class)->catalog();

        foreach ($catalog as $service) {
            $this->get('/services')
                ->assertSee($service['name'], false)
                ->assertSee(route('services.show', $service['slug']), false);
        }
    }

    public function test_every_service_page_renders_successfully(): void
    {
        $catalog = app(ServicesData::class)->catalog();

        foreach ($catalog as $service) {
            $this->get(route('services.show', $service['slug']))
                ->assertOk()
                ->assertSee($service['name'], false);
        }
    }

    public function test_service_page_emits_structured_data(): void
    {
        $response = $this->get(route('services.show', 'website-development'));

        $response->assertOk()
            ->assertSee('application/ld+json', false)
            ->assertSee('"@type":"Service"', false)
            ->assertSee('"@type":"FAQPage"', false);
    }

    public function test_unknown_service_returns_404(): void
    {
        $this->get('/services/this-service-does-not-exist')->assertStatus(404);
    }
}
