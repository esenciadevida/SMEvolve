<?php

namespace App\Services\Admin;

use App\Models\Administrator;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class AdministratorService
{
    /**
     * @param  array{name: string, email: string, password: string, role_id: int}  $data
     */
    public function create(array $data): Administrator
    {
        return DB::transaction(function () use ($data) {
            return Administrator::create([
                'role_id' => $data['role_id'],
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password'],
                'is_active' => true,
            ]);
        });
    }

    /**
     * @param  array{name: string, email: string, role_id: int}  $data
     */
    public function update(Administrator $administrator, array $data, ?Administrator $actor = null): Administrator
    {
        $roleChanged = (int) $administrator->role_id !== (int) $data['role_id'];

        if ($roleChanged) {
            $this->assertRoleChangeAllowed($administrator, $data['role_id'], $actor);
        }

        $administrator->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'role_id' => $data['role_id'],
        ]);

        return $administrator;
    }

    public function disable(Administrator $administrator, ?Administrator $actor = null): Administrator
    {
        if ($actor !== null && $actor->is($administrator)) {
            throw new RuntimeException('You cannot disable your own administrator account.');
        }

        if ($administrator->is_active && $this->isLastActiveSuperAdmin($administrator)) {
            throw new RuntimeException('The final active Super Admin cannot be disabled.');
        }

        $administrator->update(['is_active' => false]);

        return $administrator;
    }

    public function enable(Administrator $administrator): Administrator
    {
        $administrator->update(['is_active' => true]);

        return $administrator;
    }

    public function changeRole(Administrator $administrator, int $roleId, ?Administrator $actor = null): Administrator
    {
        if ($actor !== null) {
            $this->assertRoleChangeAllowed($administrator, $roleId, $actor);
        }

        $administrator->update(['role_id' => $roleId]);

        return $administrator;
    }

    /**
     * Protect against self-privilege escalation and removal of the final
     * active Super Admin.
     */
    private function assertRoleChangeAllowed(Administrator $administrator, int $newRoleId, ?Administrator $actor = null): void
    {
        $currentRoleName = $administrator->role?->name;
        $newRole = Role::find($newRoleId);

        if ($newRole === null) {
            throw new RuntimeException('The selected role is invalid.');
        }

        if ($actor !== null && $actor->is($administrator) && $newRole->name === 'super_admin' && $currentRoleName !== 'super_admin') {
            throw new RuntimeException('You cannot escalate your own privileges.');
        }

        if ($currentRoleName === 'super_admin' && $administrator->is_active && $newRole->name !== 'super_admin') {
            if ($this->isLastActiveSuperAdmin($administrator)) {
                throw new RuntimeException('The final active Super Admin cannot be downgraded.');
            }
        }
    }

    private function isLastActiveSuperAdmin(Administrator $administrator): bool
    {
        $count = Administrator::query()
            ->where('is_active', true)
            ->whereHas('role', fn ($q) => $q->where('name', 'super_admin'))
            ->count();

        return $count <= 1 && $administrator->isSuperAdmin();
    }
}
