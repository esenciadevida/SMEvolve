<?php

namespace Tests\Feature\Admin;

use App\Models\Administrator;
use App\Models\Role;

class AdminRolesTest extends AdminTestCase
{
    public function test_super_admin_can_list_roles(): void
    {
        $admin = $this->createAdmin($this->superAdminRole(), 'boss@smevolve.tech');

        $this->actingAs($admin, 'admin')
            ->get(route('admin.roles.index'))
            ->assertOk()
            ->assertSee('Super Admin')
            ->assertSee('Create role');
    }

    public function test_create_and_edit_pages_render(): void
    {
        $admin = $this->createAdmin($this->superAdminRole(), 'boss@smevolve.tech');
        $customRole = Role::updateOrCreate(
            ['name' => 'content_manager'],
            ['label' => 'Content Manager', 'permissions' => ['dashboard.view', 'portfolio.view']]
        );

        $this->actingAs($admin, 'admin')
            ->get(route('admin.roles.create'))
            ->assertOk()
            ->assertSee('permissions[]')
            ->assertSee('View Dashboard');

        $this->actingAs($admin, 'admin')
            ->get(route('admin.roles.edit', $customRole))
            ->assertOk()
            ->assertSee('Content Manager');
    }

    public function test_create_page_displays_friendly_permission_labels(): void
    {
        $admin = $this->createAdmin($this->superAdminRole(), 'boss@smevolve.tech');

        $this->actingAs($admin, 'admin')
            ->get(route('admin.roles.create'))
            ->assertOk()
            ->assertSee('View Dashboard')
            ->assertSee('Publish Portfolio')
            ->assertSee('View Settings');
    }

    public function test_administrator_without_role_access_gets_403(): void
    {
        $admin = $this->createAdmin($this->editorRole(), 'editor@smevolve.tech');

        $this->actingAs($admin, 'admin')
            ->get(route('admin.roles.index'))
            ->assertForbidden();
    }

    public function test_super_admin_can_create_custom_role(): void
    {
        $admin = $this->createAdmin($this->superAdminRole(), 'boss@smevolve.tech');

        $this->actingAs($admin, 'admin')
            ->post(route('admin.roles.store'), [
                'label' => 'Content Manager',
                'description' => 'Manages website content.',
                'permissions' => ['dashboard.view', 'portfolio.view', 'portfolio.update'],
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('roles', [
            'name' => 'content_manager',
            'label' => 'Content Manager',
        ]);

        $role = Role::where('name', 'content_manager')->firstOrFail();
        $this->assertSame(['dashboard.view', 'portfolio.view', 'portfolio.update'], $role->permissions);

        $this->assertDatabaseHas('admin_audit_logs', [
            'administrator_id' => $admin->id,
            'action' => 'roles.create',
            'resource_type' => 'roles',
            'resource_id' => (string) $role->id,
        ]);
    }

    public function test_reserved_super_admin_display_name_is_rejected(): void
    {
        $admin = $this->createAdmin($this->superAdminRole(), 'boss@smevolve.tech');
        $before = Role::count();

        $this->actingAs($admin, 'admin')
            ->post(route('admin.roles.store'), [
                'label' => 'Super Admin',
                'permissions' => ['dashboard.view'],
            ])
            ->assertSessionHasErrors('role');

        $this->assertSame($before, Role::count());
    }

    public function test_reserved_admin_display_name_is_rejected(): void
    {
        $admin = $this->createAdmin($this->superAdminRole(), 'boss@smevolve.tech');

        $this->actingAs($admin, 'admin')
            ->post(route('admin.roles.store'), [
                'label' => 'Admin',
                'permissions' => ['dashboard.view'],
            ])
            ->assertSessionHasErrors('role');
    }

    public function test_unknown_permission_key_is_rejected(): void
    {
        $admin = $this->createAdmin($this->superAdminRole(), 'boss@smevolve.tech');

        $this->actingAs($admin, 'admin')
            ->post(route('admin.roles.store'), [
                'name' => 'content_manager',
                'label' => 'Content Manager',
                'permissions' => ['dashboard.view', 'not.a.real.permission'],
            ])
            ->assertSessionHasErrors('permissions.1');
    }

    public function test_super_admin_can_update_custom_role_permissions(): void
    {
        $admin = $this->createAdmin($this->superAdminRole(), 'boss@smevolve.tech');
        $role = Role::updateOrCreate(
            ['name' => 'content_manager'],
            ['label' => 'Content Manager', 'permissions' => ['dashboard.view']]
        );

        $this->actingAs($admin, 'admin')
            ->put(route('admin.roles.update', $role), [
                'label' => 'Content Manager',
                'description' => 'Updated description.',
                'permissions' => ['dashboard.view', 'portfolio.view', 'portfolio.update', 'portfolio.publish'],
            ])
            ->assertRedirect(route('admin.roles.edit', $role));

        $this->assertSame(
            ['dashboard.view', 'portfolio.view', 'portfolio.update', 'portfolio.publish'],
            $role->fresh()->permissions
        );

        $this->assertDatabaseHas('admin_audit_logs', [
            'administrator_id' => $admin->id,
            'action' => 'roles.update',
            'resource_id' => (string) $role->id,
        ]);
    }

    public function test_permission_changes_take_effect_for_assigned_administrators(): void
    {
        $super = $this->createAdmin($this->superAdminRole(), 'boss@smevolve.tech');
        $role = Role::updateOrCreate(
            ['name' => 'content_manager'],
            ['label' => 'Content Manager', 'permissions' => ['dashboard.view']]
        );
        $manager = $this->createAdmin($role, 'manager@smevolve.tech');

        $this->actingAs($manager, 'admin')
            ->get(route('admin.portfolio.index'))
            ->assertForbidden();

        $this->actingAs($super, 'admin')
            ->put(route('admin.roles.update', $role), [
                'label' => 'Content Manager',
                'permissions' => ['dashboard.view', 'portfolio.view'],
            ])
            ->assertRedirect();

        $this->actingAs(Administrator::findOrFail($manager->id), 'admin')
            ->get(route('admin.portfolio.index'))
            ->assertOk();
    }

    public function test_super_admin_role_must_keep_essential_permissions(): void
    {
        $admin = $this->createAdmin($this->superAdminRole(), 'boss@smevolve.tech');
        $superRole = $this->superAdminRole();
        $permissions = array_values(array_filter(
            $superRole->permissions,
            fn ($permission) => $permission !== 'dashboard.view'
        ));

        $this->actingAs($admin, 'admin')
            ->put(route('admin.roles.update', $superRole), [
                'label' => 'Super Admin',
                'permissions' => $permissions,
            ])
            ->assertSessionHasErrors('role');

        $this->assertContains('dashboard.view', $superRole->fresh()->permissions);
    }

    public function test_actor_cannot_grant_permission_they_do_not_hold(): void
    {
        $roleManagerRole = Role::updateOrCreate(
            ['name' => 'role_manager'],
            ['label' => 'Role Manager', 'permissions' => ['dashboard.view', 'administrators.view', 'administrators.update', 'profile.update']]
        );
        $roleManager = $this->createAdmin($roleManagerRole, 'manager@smevolve.tech');

        $this->actingAs($roleManager, 'admin')
            ->post(route('admin.roles.store'), [
                'name' => 'risky_role',
                'label' => 'Risky Role',
                'permissions' => ['dashboard.view', 'portfolio.create'],
            ])
            ->assertSessionHasErrors('role');

        $this->assertDatabaseMissing('roles', ['name' => 'risky_role']);
    }

    public function test_core_role_cannot_be_deleted(): void
    {
        $admin = $this->createAdmin($this->superAdminRole(), 'boss@smevolve.tech');
        $editorRole = $this->editorRole();

        $this->actingAs($admin, 'admin')
            ->delete(route('admin.roles.destroy', $editorRole))
            ->assertSessionHasErrors('role');

        $this->assertDatabaseHas('roles', ['id' => $editorRole->id]);
    }

    public function test_role_with_administrators_cannot_be_deleted(): void
    {
        $admin = $this->createAdmin($this->superAdminRole(), 'boss@smevolve.tech');
        $customRole = Role::updateOrCreate(
            ['name' => 'content_manager'],
            ['label' => 'Content Manager', 'permissions' => ['dashboard.view']]
        );
        $this->createAdmin($customRole, 'manager@smevolve.tech');

        $this->actingAs($admin, 'admin')
            ->delete(route('admin.roles.destroy', $customRole))
            ->assertSessionHasErrors('role');

        $this->assertDatabaseHas('roles', ['id' => $customRole->id]);
    }

    public function test_custom_role_without_administrators_can_be_deleted(): void
    {
        $admin = $this->createAdmin($this->superAdminRole(), 'boss@smevolve.tech');
        $customRole = Role::updateOrCreate(
            ['name' => 'content_manager'],
            ['label' => 'Content Manager', 'permissions' => ['dashboard.view']]
        );

        $this->actingAs($admin, 'admin')
            ->delete(route('admin.roles.destroy', $customRole))
            ->assertRedirect(route('admin.roles.index'));

        $this->assertDatabaseMissing('roles', ['id' => $customRole->id]);

        $this->assertDatabaseHas('admin_audit_logs', [
            'administrator_id' => $admin->id,
            'action' => 'roles.delete',
            'resource_id' => (string) $customRole->id,
        ]);
    }

    public function test_administrator_cannot_delete_own_role(): void
    {
        $admin = $this->createAdmin($this->superAdminRole(), 'boss@smevolve.tech');
        $superRole = $this->superAdminRole();

        $this->actingAs($admin, 'admin')
            ->delete(route('admin.roles.destroy', $superRole))
            ->assertSessionHasErrors('role');

        $this->assertDatabaseHas('roles', ['id' => $superRole->id]);
    }
}
