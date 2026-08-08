<?php

namespace Database\Factories;

use App\Models\Administrator;
use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<Administrator>
 */
class AdministratorFactory extends Factory
{
    protected $model = Administrator::class;

    protected static ?string $password;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'role_id' => Role::factory(),
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => static::$password ??= Hash::make('password'),
            'is_active' => true,
            'remember_token' => Str::random(10),
        ];
    }

    public function superAdmin(): static
    {
        return $this->state(fn () => [
            'role_id' => Role::factory()->superAdmin(),
        ]);
    }

    public function admin(): static
    {
        return $this->state(fn () => [
            'role_id' => Role::factory()->admin(),
        ]);
    }

    public function editor(): static
    {
        return $this->state(fn () => [
            'role_id' => Role::factory()->editor(),
        ]);
    }

    public function support(): static
    {
        return $this->state(fn () => [
            'role_id' => Role::factory()->support(),
        ]);
    }

    public function disabled(): static
    {
        return $this->state(fn () => [
            'is_active' => false,
        ]);
    }
}
