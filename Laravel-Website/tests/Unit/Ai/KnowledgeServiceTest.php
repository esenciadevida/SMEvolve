<?php

namespace Tests\Unit\Ai;

use App\Services\AI\KnowledgeService;
use Tests\TestCase;

class KnowledgeServiceTest extends TestCase
{
    public function test_company_block_contains_contact_details(): void
    {
        $block = app(KnowledgeService::class)->companyBlock();

        $this->assertStringContainsString(config('company.name'), $block);
        $this->assertStringContainsString(config('company.contact.email'), $block);
    }

    public function test_services_block_contains_catalog_services(): void
    {
        $block = app(KnowledgeService::class)->servicesBlock();

        $this->assertStringContainsString('Website Development', $block);
        $this->assertStringContainsString('E-commerce Development', $block);
    }

    public function test_packages_block_contains_website_packages(): void
    {
        $block = app(KnowledgeService::class)->packagesBlock();

        $this->assertStringContainsString('Starter Website', $block);
        $this->assertStringContainsString('E-Commerce Website', $block);
        $this->assertStringContainsString('CUSTOM SOLUTIONS', $block);
    }

    public function test_faq_block_contains_active_questions(): void
    {
        $faq = collect(config('faqs.items', []))->where('status', 'active')->first();

        $this->assertNotNull($faq);

        $block = app(KnowledgeService::class)->faqBlock();

        $this->assertStringContainsString($faq['question'], $block);
    }

    public function test_context_for_returns_combined_blocks(): void
    {
        $context = app(KnowledgeService::class)->contextFor('do you build websites?');

        $this->assertStringContainsString('COMPANY', $context);
        $this->assertStringContainsString('SERVICES', $context);
        $this->assertStringContainsString('PACKAGES', $context);
        $this->assertStringContainsString('FREQUENTLY ASKED QUESTIONS', $context);
    }
}
