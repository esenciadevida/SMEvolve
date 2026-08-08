<?php

namespace Tests\Feature\Admin;

use App\Models\AdminAuditLog;
use App\Models\SiteSetting;
use App\Services\Admin\SiteSettingsService;

class AdminSettingsTest extends AdminTestCase
{
    public function test_super_admin_can_view_general_settings(): void
    {
        $role = $this->superAdminRole();
        $admin = $this->createAdmin($role);

        $this->actingAs($admin, 'admin')
            ->get(route('admin.settings.index', ['group' => 'general']))
            ->assertOk()
            ->assertSee('Company Name')
            ->assertSee('Company Tagline');
    }

    public function test_super_admin_can_update_general_settings(): void
    {
        $role = $this->superAdminRole();
        $admin = $this->createAdmin($role);

        $this->actingAs($admin, 'admin')
            ->post(route('admin.settings.update', ['group' => 'general']), [
                'company' => [
                    'name' => 'SMEvolve Updated',
                    'tagline' => 'Build fast',
                    'description' => 'We build websites.',
                ],
                'footer' => [
                    'company' => [
                        'tagline' => '',
                        'description' => '',
                    ],
                ],
            ])
            ->assertRedirect(route('admin.settings.index', ['group' => 'general']));

        $this->assertDatabaseHas('site_settings', [
            'key' => 'company.name',
            'value' => 'SMEvolve Updated',
        ]);

        $this->assertDatabaseHas('admin_audit_logs', [
            'administrator_id' => $admin->id,
            'action' => 'settings.update',
            'resource_type' => 'site_settings',
            'resource_id' => 'company.name',
        ]);
    }

    public function test_settings_are_merged_into_config(): void
    {
        $role = $this->superAdminRole();
        $admin = $this->createAdmin($role);

        $this->actingAs($admin, 'admin')
            ->post(route('admin.settings.update', ['group' => 'general']), [
                'company' => [
                    'name' => 'Merged Company',
                    'tagline' => '',
                    'description' => '',
                ],
                'footer' => [
                    'company' => [
                        'tagline' => '',
                        'description' => '',
                    ],
                ],
            ]);

        app(SiteSettingsService::class)->loadIntoConfig();

        $this->assertSame('Merged Company', config('company.name'));
    }

    public function test_super_admin_can_update_social_links(): void
    {
        $role = $this->superAdminRole();
        $admin = $this->createAdmin($role);

        $this->actingAs($admin, 'admin')
            ->post(route('admin.settings.update', ['group' => 'social']), [
                'platforms' => [
                    'linkedin' => ['platform' => 'linkedin', 'href' => 'https://linkedin.com/company/smevolve', 'enabled' => '1'],
                    'facebook' => ['platform' => 'facebook', 'href' => '', 'enabled' => ''],
                ],
            ])
            ->assertRedirect(route('admin.settings.index', ['group' => 'social']));

        $row = SiteSetting::where('key', 'social_links.platforms')->first();
        $this->assertNotNull($row);

        $platforms = json_decode((string) $row->value, true);
        $this->assertIsArray($platforms);

        $linkedin = collect($platforms)->firstWhere('platform', 'linkedin');
        $this->assertSame('https://linkedin.com/company/smevolve', $linkedin['href']);
        $this->assertTrue($linkedin['enabled']);
    }

    public function test_unchanged_social_settings_do_not_create_audit_entries(): void
    {
        $role = $this->superAdminRole();
        $admin = $this->createAdmin($role);

        $payload = [
            'platforms' => [
                'linkedin' => ['platform' => 'linkedin', 'href' => 'https://linkedin.com/company/smevolve', 'enabled' => '1'],
                'facebook' => ['platform' => 'facebook', 'href' => '', 'enabled' => ''],
            ],
        ];

        $this->actingAs($admin, 'admin')
            ->post(route('admin.settings.update', ['group' => 'social']), $payload)
            ->assertRedirect(route('admin.settings.index', ['group' => 'social']))
            ->assertSessionHas('status', 'Social links updated successfully.');

        $this->assertSame(1, $this->countSocialSettingsAuditRows());

        $this->actingAs($admin, 'admin')
            ->post(route('admin.settings.update', ['group' => 'social']), $payload)
            ->assertRedirect(route('admin.settings.index', ['group' => 'social']))
            ->assertSessionHas('status', 'No changes were made.');

        $this->assertSame(1, $this->countSocialSettingsAuditRows());
    }

    public function test_changed_social_settings_create_a_new_audit_entry(): void
    {
        $role = $this->superAdminRole();
        $admin = $this->createAdmin($role);

        $payload = fn (string $href) => [
            'platforms' => [
                'linkedin' => ['platform' => 'linkedin', 'href' => $href, 'enabled' => '1'],
                'facebook' => ['platform' => 'facebook', 'href' => '', 'enabled' => ''],
            ],
        ];

        $this->actingAs($admin, 'admin')
            ->post(route('admin.settings.update', ['group' => 'social']), $payload('https://linkedin.com/company/smevolve'))
            ->assertRedirect(route('admin.settings.index', ['group' => 'social']));

        $this->actingAs($admin, 'admin')
            ->post(route('admin.settings.update', ['group' => 'social']), $payload('https://linkedin.com/company/smevolve-2'))
            ->assertRedirect(route('admin.settings.index', ['group' => 'social']));

        $this->assertSame(2, $this->countSocialSettingsAuditRows());
    }

    private function countSocialSettingsAuditRows(): int
    {
        return AdminAuditLog::where('action', 'settings.update')
            ->where('resource_type', 'site_settings')
            ->where('resource_id', 'social_links.platforms')
            ->count();
    }
}
