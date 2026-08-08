<?php

namespace Tests\Unit\Search;

use App\Services\Search\SiteSettingSearchProvider;
use Tests\TestCase;

class SiteSettingSearchProviderTest extends TestCase
{
    public function test_finds_setting_by_label(): void
    {
        $results = (new SiteSettingSearchProvider)->search('company name', 5);

        $this->assertNotEmpty($results);
        $this->assertSame('Company Name', $results[0]['title']);
        $this->assertSame('company.name', $results[0]['subtitle']);
    }

    public function test_finds_setting_by_key(): void
    {
        $results = (new SiteSettingSearchProvider)->search('company.contact.email', 5);

        $this->assertNotEmpty($results);
        $this->assertSame('company.contact.email', $results[0]['subtitle']);
        $this->assertSame(route('admin.settings.index', ['group' => 'contact']), $results[0]['url']);
    }

    public function test_exact_key_match_ranks_first(): void
    {
        $results = (new SiteSettingSearchProvider)->search('social_links.platforms', 5);

        $this->assertSame('social_links.platforms', $results[0]['subtitle']);
    }

    public function test_exact_label_match_ranks_first(): void
    {
        $results = (new SiteSettingSearchProvider)->search('business hours summary', 5);

        $this->assertSame('Business Hours Summary', $results[0]['title']);
    }

    public function test_search_matches_partial_keys(): void
    {
        $results = (new SiteSettingSearchProvider)->search('hours', 10);

        $subtitles = array_column($results, 'subtitle');

        $this->assertContains('company.hours.summary_string', $subtitles);
        $this->assertContains('company.hours.holiday_notice', $subtitles);
    }

    public function test_exact_key_match_outranks_contains_match(): void
    {
        $results = (new SiteSettingSearchProvider)->search('hours.summary_string', 10);

        $this->assertSame('company.hours.summary_string', $results[0]['subtitle']);
        $this->assertCount(1, $results);
    }

    public function test_results_never_expose_setting_values(): void
    {
        $results = (new SiteSettingSearchProvider)->search('company', 10);

        $this->assertNotEmpty($results);

        foreach ($results as $result) {
            $this->assertArrayNotHasKey('value', $result);
            $this->assertArrayNotHasKey('value', $result['metadata']);
        }
    }
}
