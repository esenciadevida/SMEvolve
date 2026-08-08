<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class AdminRoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = config('admin.roles', []);

        foreach ($roles as $name => $permissions) {
            $label = match ($name) {
                'super_admin' => 'Super Admin',
                'admin' => 'Admin',
                'editor' => 'Editor',
                'support' => 'Support',
                default => ucfirst(str_replace('_', ' ', $name)),
            };

            Role::updateOrCreate(
                ['name' => $name],
                [
                    'label' => $label,
                    'description' => "{$label} role with a fixed set of Admin Portal permissions.",
                    'permissions' => array_values(array_unique($permissions)),
                ]
            );
        }
    }
}
