<?php

namespace Tests\Unit\Admin;

use App\Models\SiteSetting;
use App\Services\Admin\SiteSettingsService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class SiteSettingsServiceTest extends TestCase
{
    use DatabaseTransactions;

    private SiteSettingsService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = app(SiteSettingsService::class);
    }

    public function test_set_and_get_roundtrip(): void
    {
        $this->service->set('company.name', 'SMEvolve', 'test');
        $this->service->set('company.flags.maintenance', true, 'test');
        $this->service->set('company.stats.visitors', 42, 'test');

        $this->assertSame('SMEvolve', $this->service->get('company.name'));
        $this->assertTrue($this->service->get('company.flags.maintenance'));
        $this->assertSame(42, $this->service->get('company.stats.visitors'));
    }

    public function test_load_into_config_merges_persisted_values(): void
    {
        $this->service->set('company.name', 'Merged Name', 'test');
        $this->service->set('company.contact.email', 'hello@example.com', 'test');

        $this->service->loadIntoConfig();

        $this->assertSame('Merged Name', config('company.name'));
        $this->assertSame('hello@example.com', config('company.contact.email'));
    }

    public function test_forget_removes_setting(): void
    {
        $this->service->set('company.name', 'Temporary', 'test');

        $this->service->forget('company.name');

        $this->assertNull($this->service->get('company.name'));
        $this->assertDatabaseMissing('site_settings', ['key' => 'company.name']);
    }

    public function test_refresh_invalidates_cache(): void
    {
        $this->service->set('company.name', 'Cached Value', 'test');

        $this->service->all();

        SiteSetting::where('key', 'company.name')->delete();

        $this->assertArrayHasKey('company.name', $this->service->all());

        $this->service->refresh();

        $this->assertArrayNotHasKey('company.name', $this->service->all());
    }
}
