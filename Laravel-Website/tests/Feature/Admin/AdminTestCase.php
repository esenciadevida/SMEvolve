<?php

namespace Tests\Feature\Admin;

use App\Models\Administrator;
use App\Models\Role;
use App\Models\SiteSetting;
use App\Services\Admin\SiteSettingsService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

abstract class AdminTestCase extends TestCase
{
    use DatabaseTransactions;

    protected function superAdminRole(): Role
    {
        return $this->role('super_admin');
    }

    protected function adminRole(): Role
    {
        return $this->role('admin');
    }

    protected function editorRole(): Role
    {
        return $this->role('editor');
    }

    protected function supportRole(): Role
    {
        return $this->role('support');
    }

    private function role(string $name): Role
    {
        return Role::updateOrCreate(
            ['name' => $name],
            [
                'label' => ucfirst(str_replace('_', ' ', $name)),
                'permissions' => config("admin.roles.{$name}", []),
            ]
        );
    }

    protected function createAdmin(Role $role, string $email = 'admin@example.com', bool $active = true): Administrator
    {
        return Administrator::factory()->create([
            'role_id' => $role->id,
            'email' => $email,
            'is_active' => $active,
        ]);
    }

    protected function createSiteSetting(string $key, mixed $value): SiteSetting
    {
        return app(SiteSettingsService::class)->set($key, $value, 'test');
    }
}
