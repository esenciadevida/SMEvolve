<?php

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class LegalPageTest extends TestCase
{
    /**
     * @return array<int, array{path: string, route: string}>
     */
    public static function legalPageProvider(): array
    {
        return [
            ['path' => '/privacy-policy', 'route' => 'privacy-policy.index'],
            ['path' => '/terms', 'route' => 'terms.index'],
            ['path' => '/cookies', 'route' => 'cookies.index'],
        ];
    }

    #[DataProvider('legalPageProvider')]
    public function test_legal_pages_return_a_successful_response(string $path, string $route): void
    {
        $this->get($path)->assertOk()->assertViewIs('pages.legal');
    }

    #[DataProvider('legalPageProvider')]
    public function test_legal_pages_have_valid_routes(string $path, string $route): void
    {
        $this->assertSame(url($path), route($route));
    }

    #[DataProvider('legalPageProvider')]
    public function test_legal_pages_use_configurable_metadata(string $path, string $route): void
    {
        $document = collect(config('legal.documents', []))->first(
            fn ($item) => ($item['route'] ?? null) === $route
        );

        $this->assertNotNull($document, "Expected a configured document for route [{$route}].");

        $this->get($path)
            ->assertOk()
            ->assertSee('<title>'.e($document['meta']['title']).'</title>', false)
            ->assertSee(e($document['meta']['description']), false);
    }

    #[DataProvider('legalPageProvider')]
    public function test_legal_pages_render_document_content(string $path, string $route): void
    {
        $document = collect(config('legal.documents', []))->first(
            fn ($item) => ($item['route'] ?? null) === $route
        );

        $response = $this->get($path)->assertOk();

        $response->assertSee($document['title']);
        $response->assertSee($document['hero']['description']);
        $response->assertSee($document['updated_date']);

        $sections = $document['sections'] ?? [];
        $this->assertNotEmpty($sections, "Expected the document [{$route}] to define sections.");

        foreach ($sections as $section) {
            $response->assertSee($section['heading']);
        }
    }

    #[DataProvider('legalPageProvider')]
    public function test_legal_pages_emit_structured_data(string $path, string $route): void
    {
        $this->get($path)
            ->assertOk()
            ->assertSee('application/ld+json')
            ->assertSee('WebPage')
            ->assertSee('BreadcrumbList')
            ->assertSee('Organization');
    }

    #[DataProvider('legalPageProvider')]
    public function test_legal_pages_render_footer_links(string $path, string $route): void
    {
        $response = $this->get($path)->assertOk();

        $response->assertSee('Privacy Policy');
        $response->assertSee('Terms & Conditions');
        $response->assertSee('Cookie Policy');
    }

    public function test_inactive_legal_document_returns_404(): void
    {
        config()->set('legal.documents.privacy-policy.status', 'draft');

        $this->get('/privacy-policy')->assertNotFound();
    }
}
