<?php

namespace Tests\Feature\Admin;

use App\Models\Administrator;

class AdminAdministratorsTest extends AdminTestCase
{
    public function test_super_admin_can_list_administrators(): void
    {
        $role = $this->superAdminRole();
        $admin = $this->createAdmin($role, 'boss@smevolve.tech');

        $this->actingAs($admin, 'admin')
            ->get(route('admin.administrators.index'))
            ->assertOk()
            ->assertSee('boss@smevolve.tech');
    }

    public function test_administrator_show_page_displays_friendly_permission_labels(): void
    {
        $role = $this->superAdminRole();
        $admin = $this->createAdmin($role, 'boss@smevolve.tech');

        $this->actingAs($admin, 'admin')
            ->get(route('admin.administrators.show', $admin))
            ->assertOk()
            ->assertSee('Publish Portfolio')
            ->assertSee('View Administrators')
            ->assertSee('View Audit Log');
    }

    public function test_super_admin_can_create_administrator(): void
    {
        $role = $this->superAdminRole();
        $admin = $this->createAdmin($role, 'boss@smevolve.tech');
        $editorRole = $this->editorRole();

        $this->actingAs($admin, 'admin')
            ->post(route('admin.administrators.store'), [
                'name' => 'New Editor',
                'email' => 'editor@example.com',
                'role_id' => $editorRole->id,
                'password' => 'secret-password-1',
                'password_confirmation' => 'secret-password-1',
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('administrators', [
            'email' => 'editor@example.com',
            'name' => 'New Editor',
            'role_id' => $editorRole->id,
        ]);

        $this->assertDatabaseHas('admin_audit_logs', [
            'administrator_id' => $admin->id,
            'action' => 'administrators.create',
        ]);
    }

    public function test_super_admin_can_update_administrator(): void
    {
        $role = $this->superAdminRole();
        $admin = $this->createAdmin($role, 'boss@smevolve.tech');
        $target = $this->createAdmin($this->editorRole(), 'editor@example.com');

        $this->actingAs($admin, 'admin')
            ->put(route('admin.administrators.update', $target), [
                'name' => 'Renamed Editor',
                'email' => 'renamed@example.com',
                'role_id' => $target->role_id,
            ])
            ->assertRedirect(route('admin.administrators.show', $target));

        $this->assertDatabaseHas('administrators', [
            'id' => $target->id,
            'name' => 'Renamed Editor',
            'email' => 'renamed@example.com',
        ]);
    }

    public function test_super_admin_cannot_disable_own_account(): void
    {
        $role = $this->superAdminRole();
        $admin = $this->createAdmin($role, 'boss@smevolve.tech');

        $this->actingAs($admin, 'admin')
            ->post(route('admin.administrators.disable', $admin))
            ->assertSessionHasErrors('administrator');

        $this->assertDatabaseHas('administrators', [
            'id' => $admin->id,
            'is_active' => true,
        ]);
    }

    public function test_super_admin_can_disable_another_super_admin(): void
    {
        $role = $this->superAdminRole();
        $super = $this->createAdmin($role, 'boss@smevolve.tech');
        $target = $this->createAdmin($role, 'co-boss@smevolve.tech');
        $third = $this->createAdmin($role, 'third@smevolve.tech');

        $this->actingAs($super, 'admin')
            ->post(route('admin.administrators.disable', $target))
            ->assertRedirect();

        $this->assertDatabaseHas('administrators', [
            'id' => $target->id,
            'is_active' => false,
        ]);
    }

    public function test_super_admin_can_enable_disabled_administrator(): void
    {
        $role = $this->superAdminRole();
        $super = $this->createAdmin($role, 'boss@smevolve.tech');
        $target = $this->createAdmin($role, 'co-boss@smevolve.tech', false);

        $this->actingAs($super, 'admin')
            ->post(route('admin.administrators.enable', $target))
            ->assertRedirect();

        $this->assertDatabaseHas('administrators', [
            'id' => $target->id,
            'is_active' => true,
        ]);
    }

    public function test_super_admin_cannot_downgrade_self_when_final_super_admin(): void
    {
        $role = $this->superAdminRole();
        $super = $this->createAdmin($role, 'boss@smevolve.tech');
        $editorRole = $this->editorRole();

        $this->actingAs($super, 'admin')
            ->put(route('admin.administrators.update', $super), [
                'name' => $super->name,
                'email' => $super->email,
                'role_id' => $editorRole->id,
            ])
            ->assertSessionHasErrors('role_id');

        $this->assertDatabaseHas('administrators', [
            'id' => $super->id,
            'role_id' => $role->id,
        ]);
    }
}
