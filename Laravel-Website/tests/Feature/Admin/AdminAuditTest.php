<?php

namespace Tests\Feature\Admin;

use App\Services\Admin\AdminAuditService;

class AdminAuditTest extends AdminTestCase
{
    public function test_super_admin_can_view_audit_log(): void
    {
        $role = $this->superAdminRole();
        $admin = $this->createAdmin($role, 'boss@smevolve.tech');

        app(AdminAuditService::class)->log(
            'settings.update',
            'site_settings',
            'company.name',
            oldValue: 'Old',
            newValue: 'New',
            actor: $admin,
        );

        $this->actingAs($admin, 'admin')
            ->get(route('admin.audit.index'))
            ->assertOk()
            ->assertSee('settings.update')
            ->assertSee('boss@smevolve.tech');
    }

    public function test_audit_log_can_be_filtered_by_action(): void
    {
        $role = $this->superAdminRole();
        $admin = $this->createAdmin($role, 'boss@smevolve.tech');

        app(AdminAuditService::class)->log('quotes.update_status', 'quotes', '1', actor: $admin);
        app(AdminAuditService::class)->log('settings.update', 'site_settings', 'company.name', actor: $admin);

        $this->actingAs($admin, 'admin')
            ->get(route('admin.audit.index', ['action' => 'quotes.update_status']))
            ->assertOk()
            ->assertSee('quotes.update_status')
            ->assertDontSee('site_settings #company.name');
    }
}
