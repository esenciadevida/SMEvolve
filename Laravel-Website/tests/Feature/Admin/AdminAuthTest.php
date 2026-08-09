<?php

namespace Tests\Feature\Admin;

use App\Models\AdminAuditLog;
use App\Models\AdminNotification;

class AdminAuthTest extends AdminTestCase
{
    public function test_login_page_is_public(): void
    {
        $this->get(route('admin.login'))
            ->assertOk()
            ->assertSee('Admin Login');
    }

    public function test_login_page_has_password_visibility_toggle(): void
    {
        $this->get(route('admin.login'))
            ->assertOk()
            ->assertSee('show = ! show', false)
            ->assertSee('type="password"', false);
    }

    public function test_dashboard_redirects_to_login_when_unauthenticated(): void
    {
        $this->get(route('admin.dashboard'))
            ->assertRedirect(route('admin.login'));
    }

    public function test_login_rejects_invalid_credentials(): void
    {
        $this->from(route('admin.login'))
            ->post(route('admin.login.store'), [
                'email' => 'nobody@example.com',
                'password' => 'wrong-password',
            ])
            ->assertRedirect(route('admin.login'))
            ->assertSessionHasErrors('email');
    }

    public function test_login_accepts_valid_credentials(): void
    {
        $role = $this->superAdminRole();
        $admin = $this->createAdmin($role, 'boss@smevolve.tech');

        $this->post(route('admin.login.store'), [
            'email' => 'boss@smevolve.tech',
            'password' => 'password',
        ])->assertRedirect(route('admin.dashboard'));

        $this->assertDatabaseHas('administrators', [
            'id' => $admin->id,
            'last_login_ip' => '127.0.0.1',
        ]);

        $this->assertDatabaseHas('admin_audit_logs', [
            'administrator_id' => $admin->id,
            'action' => 'admin.login',
        ]);
    }

    public function test_disabled_administrator_cannot_login(): void
    {
        $role = $this->superAdminRole();
        $this->createAdmin($role, 'disabled@smevolve.tech', false);

        $this->from(route('admin.login'))
            ->post(route('admin.login.store'), [
                'email' => 'disabled@smevolve.tech',
                'password' => 'password',
            ])
            ->assertRedirect(route('admin.login'))
            ->assertSessionHasErrors('email');

        $this->assertDatabaseMissing('admin_audit_logs', [
            'action' => 'admin.login',
        ]);
    }

    public function test_failed_login_is_audited_every_attempt_but_alert_is_debounced(): void
    {
        $this->from(route('admin.login'))
            ->post(route('admin.login.store'), [
                'email' => 'nobody@example.com',
                'password' => 'wrong-password',
            ])
            ->assertRedirect(route('admin.login'))
            ->assertSessionHasErrors('email');

        $this->from(route('admin.login'))
            ->post(route('admin.login.store'), [
                'email' => 'nobody@example.com',
                'password' => 'wrong-password-again',
            ])
            ->assertRedirect(route('admin.login'))
            ->assertSessionHasErrors('email');

        $this->assertSame(2, AdminAuditLog::where('action', 'admin.login.failed')->count());
        $this->assertSame(1, AdminNotification::where('event', 'security.login_failed')->count());
    }

    public function test_successful_login_creates_security_notification(): void
    {
        $role = $this->superAdminRole();
        $admin = $this->createAdmin($role, 'boss@smevolve.tech');

        $this->post(route('admin.login.store'), [
            'email' => 'boss@smevolve.tech',
            'password' => 'password',
        ])->assertRedirect(route('admin.dashboard'));

        $this->assertDatabaseHas('admin_notifications', [
            'administrator_id' => $admin->id,
            'event' => 'security.login_success',
        ]);
    }

    public function test_logout_invalidates_session(): void
    {
        $role = $this->superAdminRole();
        $admin = $this->createAdmin($role);

        $this->actingAs($admin, 'admin')
            ->post(route('admin.logout'))
            ->assertRedirect(route('admin.login'));

        $this->assertGuest('admin');
    }
}
