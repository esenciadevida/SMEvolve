<?php

namespace Tests\Feature\Admin;

use App\Models\Administrator;

class AdminSessionTest extends AdminTestCase
{
    public function test_expired_admin_session_is_rejected(): void
    {
        config()->set('admin.session_lifetime_minutes', 1);

        $role = $this->superAdminRole();
        $admin = $this->createAdmin($role);

        $this->withSession(['admin_last_activity' => now()->subHours(2)->timestamp])
            ->actingAs($admin, 'admin')
            ->get(route('admin.dashboard'))
            ->assertRedirect(route('admin.login'))
            ->assertSessionHasErrors('email');

        $this->assertGuest('admin');
    }

    public function test_active_admin_session_is_accepted(): void
    {
        config()->set('admin.session_lifetime_minutes', 120);

        $role = $this->superAdminRole();
        $admin = $this->createAdmin($role);

        $this->withSession(['admin_last_activity' => now()->timestamp])
            ->actingAs($admin, 'admin')
            ->get(route('admin.dashboard'))
            ->assertOk();
    }

    public function test_disabled_account_session_is_rejected(): void
    {
        $role = $this->superAdminRole();
        $admin = Administrator::factory()->create([
            'role_id' => $role->id,
            'is_active' => false,
        ]);

        $this->withSession(['admin_last_activity' => now()->timestamp])
            ->actingAs($admin, 'admin')
            ->get(route('admin.dashboard'))
            ->assertRedirect(route('admin.login'))
            ->assertSessionHasErrors('email');

        $this->assertGuest('admin');
    }
}
