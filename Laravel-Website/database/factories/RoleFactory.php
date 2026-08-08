<?php

namespace Database\Factories;

use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Role>
 */
class RoleFactory extends Factory
{
    protected $model = Role::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->slug(2),
            'label' => fake()->words(2, true),
            'description' => null,
            'permissions' => [],
        ];
    }

    public function superAdmin(): static
    {
        return $this->state(fn () => [
            'name' => 'super_admin',
            'label' => 'Super Admin',
            'permissions' => config('admin.roles.super_admin', []),
        ]);
    }

    public function admin(): static
    {
        return $this->state(fn () => [
            'name' => 'admin',
            'label' => 'Admin',
            'permissions' => config('admin.roles.admin', []),
        ]);
    }

    public function editor(): static
    {
        return $this->state(fn () => [
            'name' => 'editor',
            'label' => 'Editor',
            'permissions' => config('admin.roles.editor', []),
        ]);
    }

    public function support(): static
    {
        return $this->state(fn () => [
            'name' => 'support',
            'label' => 'Support',
            'permissions' => config('admin.roles.support', []),
        ]);
    }
}
