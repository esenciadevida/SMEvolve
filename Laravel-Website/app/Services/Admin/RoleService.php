<?php

namespace App\Services\Admin;

use App\Models\Administrator;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class RoleService
{
    /**
     * Core roles are seeded from the approved baseline matrix and cannot be
     * deleted from the Admin Portal.
     *
     * @var list<string>
     */
    public const CORE_ROLES = ['super_admin', 'admin', 'editor', 'support'];

    /**
     * Permissions the Super Admin role must always retain so the final super
     * administrator can never be locked out of the portal.
     *
     * @var list<string>
     */
    public const ESSENTIAL_SUPER_ADMIN_PERMISSIONS = ['dashboard.view', 'administrators.view'];

    /**
     * @param  array{label: string, description?: ?string, permissions?: array}  $data
     */
    public function create(array $data, Administrator $actor): Role
    {
        $permissions = $this->normalizePermissions($data['permissions'] ?? []);
        $name = $this->slugFromLabel($data['label']);

        return DB::transaction(function () use ($data, $permissions, $name, $actor) {
            if (in_array($name, self::CORE_ROLES, true)) {
                throw new RuntimeException("'{$data['label']}' is a reserved role name.");
            }

            if (Role::where('name', $name)->exists()) {
                throw new RuntimeException('A role with this name already exists.');
            }

            $this->assertCanGrant($permissions, $actor);

            return Role::create([
                'name' => $name,
                'label' => $data['label'],
                'description' => $data['description'] ?? null,
                'permissions' => $permissions,
            ]);
        });
    }

    /**
     * @param  array{label: string, description?: ?string, permissions?: array}  $data
     */
    public function update(Role $role, array $data, Administrator $actor): Role
    {
        $permissions = $this->normalizePermissions($data['permissions'] ?? []);

        return DB::transaction(function () use ($role, $data, $permissions, $actor) {
            $this->assertCanGrant($permissions, $actor);
            $this->assertSuperAdminIntegrity($role, $permissions);

            $role->update([
                'label' => $data['label'],
                'description' => $data['description'] ?? null,
                'permissions' => $permissions,
            ]);

            return $role;
        });
    }

    public function destroy(Role $role, Administrator $actor): void
    {
        DB::transaction(function () use ($role, $actor) {
            $this->assertCanDelete($role, $actor);

            $role->delete();
        });
    }

    /**
     * Keep only known permission keys, deduplicated and stable.
     *
     * @param  array<int, mixed>  $permissions
     * @return list<string>
     */
    private function normalizePermissions(array $permissions): array
    {
        $known = config('admin_permissions', []);

        $filtered = array_filter(
            array_map(static fn ($permission) => trim((string) $permission), $permissions),
            static fn (string $permission) => array_key_exists($permission, $known),
        );

        return array_values(array_unique($filtered));
    }

    /**
     * Defense in depth: an actor may only grant permissions they hold
     * themselves, preventing privilege escalation through role management.
     *
     * @param  list<string>  $permissions
     */
    private function assertCanGrant(array $permissions, Administrator $actor): void
    {
        $missing = array_values(array_filter(
            $permissions,
            static fn (string $permission) => ! $actor->hasPermission($permission),
        ));

        if ($missing !== []) {
            $labels = array_map(
                static fn (string $permission) => config("admin_permissions.{$permission}.label", $permission),
                $missing,
            );

            throw new RuntimeException(
                'You cannot grant permissions you do not hold yourself: '.implode(', ', $labels).'.'
            );
        }
    }

    /**
     * @param  list<string>  $permissions
     */
    private function assertSuperAdminIntegrity(Role $role, array $permissions): void
    {
        if ($role->name !== 'super_admin') {
            return;
        }

        foreach (self::ESSENTIAL_SUPER_ADMIN_PERMISSIONS as $permission) {
            if (! in_array($permission, $permissions, true)) {
                $label = config("admin_permissions.{$permission}.label", $permission);

                throw new RuntimeException(
                    "The Super Admin role must always keep the {$label} permission."
                );
            }
        }
    }

    private function assertCanDelete(Role $role, Administrator $actor): void
    {
        if (in_array($role->name, self::CORE_ROLES, true)) {
            throw new RuntimeException("The core role {$role->label} cannot be deleted.");
        }

        if ($role->administrators()->exists()) {
            throw new RuntimeException('A role assigned to administrator accounts cannot be deleted.');
        }

        if ($actor->role_id === $role->id) {
            throw new RuntimeException('You cannot delete your own role.');
        }
    }

    /**
     * Derive the internal role identifier from the display name so the Admin
     * Portal never asks administrators for a technical slug.
     */
    private function slugFromLabel(string $label): string
    {
        $slug = strtolower(trim($label));
        $slug = preg_replace('/[^a-z0-9]+/', '_', $slug);
        $slug = preg_replace('/_+/', '_', $slug);
        $slug = trim($slug, '_');

        if ($slug === '' || ! preg_match('/^[a-z]/', $slug)) {
            $slug = 'role_'.$slug;
        }

        return substr($slug, 0, 60);
    }
}
