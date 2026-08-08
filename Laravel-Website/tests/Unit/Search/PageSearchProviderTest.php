<?php

namespace Tests\Unit\Search;

use App\Services\Search\PageSearchProvider;
use Tests\TestCase;

class PageSearchProviderTest extends TestCase
{
    public function test_finds_page_by_exact_title(): void
    {
        $results = (new PageSearchProvider)->search('privacy policy', 5);

        $this->assertNotEmpty($results);
        $this->assertSame('Privacy Policy', $results[0]['title']);
        $this->assertSame(route('privacy-policy.index'), $results[0]['url']);
    }

    public function test_finds_page_by_keyword(): void
    {
        $results = (new PageSearchProvider)->search('estimate', 5);

        $this->assertNotEmpty($results);
        $this->assertSame('quote', $results[0]['id']);
    }

    public function test_no_match_returns_empty_results(): void
    {
        $this->assertSame([], (new PageSearchProvider)->search('zzz-nonexistent-zzz', 5));
    }

    public function test_result_shape_is_normalized(): void
    {
        $results = (new PageSearchProvider)->search('faq', 5);

        $this->assertNotEmpty($results);
        $result = collect($results)->firstWhere('id', 'faq');

        $this->assertNotNull($result);
        $this->assertSame('page', $result['type']);
        $this->assertSame(route('faq'), $result['url']);
        $this->assertArrayHasKey('icon', $result['metadata']);
    }
}
