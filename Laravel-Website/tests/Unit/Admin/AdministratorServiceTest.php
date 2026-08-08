<?php

namespace Tests\Unit\Admin;

use App\Models\Administrator;
use App\Models\Role;
use App\Services\Admin\AdministratorService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use RuntimeException;
use Tests\TestCase;

class AdministratorServiceTest extends TestCase
{
    use DatabaseTransactions;

    private AdministratorService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = app(AdministratorService::class);
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

    private function makeAdmin(Role $role, bool $active = true): Administrator
    {
        return Administrator::factory()->create([
            'role_id' => $role->id,
            'is_active' => $active,
        ]);
    }

    public function test_cannot_disable_own_account(): void
    {
        $role = $this->superRole();
        $admin = $this->makeAdmin($role);

        $this->expectException(RuntimeException::class);

        $this->service->disable($admin, $admin);
    }

    public function test_cannot_disable_last_active_super_admin(): void
    {
        $role = $this->superRole();
        $last = $this->makeAdmin($role);
        $actor = $this->makeAdmin($this->editorRole());

        $this->expectException(RuntimeException::class);

        $this->service->disable($last, $actor);
    }

    public function test_can_disable_when_another_active_super_admin_exists(): void
    {
        $role = $this->superRole();
        $actor = $this->makeAdmin($role);
        $target = $this->makeAdmin($role);
        $this->makeAdmin($role);

        $this->service->disable($target, $actor);

        $this->assertFalse($target->fresh()->is_active);
    }

    public function test_cannot_escalate_own_privileges(): void
    {
        $editor = $this->makeAdmin($this->editorRole());
        $superRole = $this->superRole();

        $this->expectException(RuntimeException::class);

        $this->service->changeRole($editor, $superRole->id, $editor);
    }

    public function test_cannot_downgrade_final_active_super_admin(): void
    {
        $role = $this->superRole();
        $super = $this->makeAdmin($role);
        $editorRole = $this->editorRole();

        $this->expectException(RuntimeException::class);

        $this->service->changeRole($super, $editorRole->id, $super);
    }

    public function test_can_change_role_of_another_administrator(): void
    {
        $role = $this->superRole();
        $actor = $this->makeAdmin($role);
        $target = $this->makeAdmin($this->editorRole());
        $editorRole = $this->editorRole();

        $this->service->changeRole($target, $editorRole->id, $actor);

        $this->assertSame($editorRole->id, $target->fresh()->role_id);
    }
}
