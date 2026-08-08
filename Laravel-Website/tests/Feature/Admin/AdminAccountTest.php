<?php

namespace Tests\Feature\Admin;

use Illuminate\Support\Facades\Hash;

class AdminAccountTest extends AdminTestCase
{
    public function test_administrator_can_view_profile(): void
    {
        $role = $this->superAdminRole();
        $admin = $this->createAdmin($role);

        $this->actingAs($admin, 'admin')
            ->get(route('admin.profile.index'))
            ->assertOk()
            ->assertSee('My Profile');
    }

    public function test_administrator_can_update_profile(): void
    {
        $role = $this->superAdminRole();
        $admin = $this->createAdmin($role);

        $this->actingAs($admin, 'admin')
            ->post(route('admin.profile.update'), [
                'name' => 'Updated Name',
                'email' => 'updated@smevolve.tech',
            ])
            ->assertRedirect(route('admin.profile.index'));

        $this->assertDatabaseHas('administrators', [
            'id' => $admin->id,
            'name' => 'Updated Name',
            'email' => 'updated@smevolve.tech',
        ]);

        $this->assertDatabaseHas('admin_audit_logs', [
            'administrator_id' => $admin->id,
            'action' => 'profile.update',
        ]);
    }

    public function test_administrator_can_change_password(): void
    {
        $role = $this->superAdminRole();
        $admin = $this->createAdmin($role);

        $this->actingAs($admin, 'admin')
            ->post(route('admin.security.password'), [
                'current_password' => 'password',
                'password' => 'new-secret-password',
                'password_confirmation' => 'new-secret-password',
            ])
            ->assertRedirect(route('admin.security.index'));

        $this->assertTrue(Hash::check('new-secret-password', $admin->fresh()->getAuthPassword()));

        $this->assertDatabaseHas('admin_audit_logs', [
            'administrator_id' => $admin->id,
            'action' => 'security.password_change',
        ]);
    }

    public function test_password_change_rejects_wrong_current_password(): void
    {
        $role = $this->superAdminRole();
        $admin = $this->createAdmin($role);

        $this->actingAs($admin, 'admin')
            ->post(route('admin.security.password'), [
                'current_password' => 'wrong-current',
                'password' => 'new-secret-password',
                'password_confirmation' => 'new-secret-password',
            ])
            ->assertSessionHasErrors('current_password');

        $this->assertTrue(Hash::check('password', $admin->fresh()->getAuthPassword()));
    }
}
