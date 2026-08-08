<?php

namespace Tests\Unit\Admin;

use App\Models\Administrator;
use App\Models\Role;
use App\Services\Admin\RoleService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use RuntimeException;
use Tests\TestCase;

class RoleServiceTest extends TestCase
{
    use DatabaseTransactions;

    private RoleService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = app(RoleService::class);
    }

    private function superRole(): Role
    {
        return Role::updateOrCreate(
            ['name' => 'super_admin'],
            ['label' => 'Super Admin', 'permissions' => config('admin.roles.super_admin', [])]
        );
    }

    private function editorRole(): Role
    {
        return Role::updateOrCreate(
            ['name' => 'editor'],
            ['label' => 'Editor', 'permissions' => config('admin.roles.editor', [])]
        );
    }

    private function makeAdmin(Role $role): Administrator
    {
        return Administrator::factory()->create([
            'role_id' => $role->id,
            'is_active' => true,
        ]);
    }

    public function test_actor_cannot_grant_permission_they_do_not_hold(): void
    {
        $limited = Role::updateOrCreate(
            ['name' => 'limited'],
            ['label' => 'Limited', 'permissions' => ['dashboard.view', 'administrators.update']]
        );
        $actor = $this->makeAdmin($limited);

        $this->expectException(RuntimeException::class);

        $this->service->create([
            'name' => 'risky',
            'label' => 'Risky',
            'permissions' => ['dashboard.view', 'portfolio.delete'],
        ], $actor);
    }

    public function test_super_admin_role_must_keep_essential_permissions(): void
    {
        $superRole = $this->superRole();
        $actor = $this->makeAdmin($superRole);
        $permissions = array_values(array_filter(
            $superRole->permissions,
            fn ($permission) => $permission !== 'administrators.view'
        ));

        $this->expectException(RuntimeException::class);

        $this->service->update($superRole, [
            'label' => 'Super Admin',
            'permissions' => $permissions,
        ], $actor);
    }

    public function test_core_role_cannot_be_deleted(): void
    {
        $editorRole = $this->editorRole();
        $actor = $this->makeAdmin($this->superRole());

        $this->expectException(RuntimeException::class);

        $this->service->destroy($editorRole, $actor);
    }

    public function test_role_with_administrators_cannot_be_deleted(): void
    {
        $customRole = Role::updateOrCreate(
            ['name' => 'content_manager'],
            ['label' => 'Content Manager', 'permissions' => ['dashboard.view']]
        );
        $this->makeAdmin($customRole);
        $actor = $this->makeAdmin($this->superRole());

        $this->expectException(RuntimeException::class);

        $this->service->destroy($customRole, $actor);
    }

    public function test_cannot_delete_own_role(): void
    {
        $superRole = $this->superRole();
        $actor = $this->makeAdmin($superRole);

        $this->expectException(RuntimeException::class);

        $this->service->destroy($superRole, $actor);
    }

    public function test_can_create_and_delete_custom_role(): void
    {
        $actor = $this->makeAdmin($this->superRole());

        $role = $this->service->create([
            'label' => 'Content Manager',
            'description' => 'Manages content.',
            'permissions' => ['dashboard.view', 'portfolio.view'],
        ], $actor);

        $this->assertSame('content_manager', $role->name);
        $this->assertSame(['dashboard.view', 'portfolio.view'], $role->permissions);

        $this->service->destroy($role, $actor);

        $this->assertNull(Role::find($role->id));
    }

    public function test_slug_is_generated_from_display_name(): void
    {
        $actor = $this->makeAdmin($this->superRole());

        $role = $this->service->create([
            'label' => 'Content &  SEO  Manager',
            'permissions' => ['dashboard.view'],
        ], $actor);

        $this->assertSame('content_seo_manager', $role->name);

        $role = $this->service->create([
            'label' => '2026 Reports',
            'permissions' => ['dashboard.view'],
        ], $actor);

        $this->assertSame('role_2026_reports', $role->name);
    }

    public function test_reserved_label_is_rejected(): void
    {
        $actor = $this->makeAdmin($this->superRole());

        $this->expectException(RuntimeException::class);

        $this->service->create([
            'label' => 'Super Admin',
            'permissions' => ['dashboard.view'],
        ], $actor);
    }

    public function test_duplicate_generated_slug_is_rejected(): void
    {
        Role::updateOrCreate(
            ['name' => 'content_manager'],
            ['label' => 'Content Manager', 'permissions' => ['dashboard.view']]
        );
        $actor = $this->makeAdmin($this->superRole());

        $this->expectException(RuntimeException::class);

        $this->service->create([
            'label' => 'content_manager',
            'permissions' => ['dashboard.view'],
        ], $actor);
    }

    public function test_unknown_permissions_are_filtered_out(): void
    {
        $actor = $this->makeAdmin($this->superRole());

        $role = $this->service->create([
            'name' => 'safe_role',
            'label' => 'Safe Role',
            'permissions' => ['dashboard.view', 'does.not.exist'],
        ], $actor);

        $this->assertSame(['dashboard.view'], $role->permissions);
    }
}
