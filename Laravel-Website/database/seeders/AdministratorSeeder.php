<?php

namespace Database\Seeders;

use App\Models\Administrator;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdministratorSeeder extends Seeder
{
    public function run(): void
    {
        $name = config('admin.first_admin.name');
        $email = config('admin.first_admin.email');
        $password = config('admin.first_admin.password');

        if (! is_string($email) || $email === '' || ! is_string($password) || $password === '') {
            return;
        }

        $role = Role::where('name', 'super_admin')->first();

        if ($role === null) {
            return;
        }

        Administrator::updateOrCreate(
            ['email' => $email],
            [
                'role_id' => $role->id,
                'name' => is_string($name) ? $name : 'SMEvolve Administrator',
                'password' => Hash::make($password),
                'is_active' => true,
            ]
        );
    }
}
