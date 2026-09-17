<?php

namespace Tests\Feature\Admin;

use App\Models\Administrator;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminCreateCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_creates_a_super_admin_with_provided_options(): void
    {
        $this->artisan('smevolve:admin:create', [
            '--name' => 'SMEvolve Owner',
            '--email' => 'owner@smevolve.tech',
            '--password' => 'Strong#Passw0rd!2026',
            '--no-interaction' => true,
        ])->assertSuccessful();

        $admin = Administrator::where('email', 'owner@smevolve.tech')->first();

        $this->assertNotNull($admin);
        $this->assertSame('SMEvolve Owner', $admin->name);
        $this->assertTrue($admin->is_active);
        $this->assertSame('super_admin', Role::find($admin->role_id)->name);
        $this->assertNotSame('Strong#Passw0rd!2026', $admin->password);
    }

    public function test_updates_an_existing_administrator_when_confirmed(): void
    {
        $role = Role::factory()->create(['name' => 'super_admin']);
        Administrator::factory()->create([
            'name' => 'Old Name',
            'email' => 'owner@smevolve.tech',
            'role_id' => $role->id,
        ]);

        $this->artisan('smevolve:admin:create', [
            '--name' => 'New Name',
            '--email' => 'owner@smevolve.tech',
            '--password' => 'Strong#Passw0rd!2026',
        ])
            ->expectsConfirmation('An administrator with that email already exists. Update their details instead?', 'yes')
            ->assertSuccessful();

        $admin = Administrator::where('email', 'owner@smevolve.tech')->first();
        $this->assertSame('New Name', $admin->name);
        $this->assertCount(1, Administrator::where('email', 'owner@smevolve.tech')->get());
    }

    public function test_aborts_when_duplicate_email_is_not_confirmed(): void
    {
        $role = Role::factory()->create(['name' => 'super_admin']);
        $existing = Administrator::factory()->create([
            'name' => 'Owner',
            'email' => 'owner@smevolve.tech',
            'role_id' => $role->id,
        ]);

        $this->artisan('smevolve:admin:create', [
            '--name' => 'Intruder',
            '--email' => 'owner@smevolve.tech',
            '--password' => 'Strong#Passw0rd!2026',
        ])
            ->expectsConfirmation('An administrator with that email already exists. Update their details instead?', 'no')
            ->assertFailed();

        $this->assertSame('Owner', $existing->fresh()->name);
    }

    public function test_rejects_a_password_that_is_too_short(): void
    {
        $this->artisan('smevolve:admin:create', [
            '--name' => 'Weak',
            '--email' => 'weak@smevolve.tech',
            '--password' => 'short',
            '--no-interaction' => true,
        ])->assertFailed();

        $this->assertDatabaseCount('administrators', 0);
    }

    public function test_rejects_an_invalid_email(): void
    {
        $this->artisan('smevolve:admin:create', [
            '--name' => 'Invalid',
            '--email' => 'not-an-email',
            '--password' => 'Strong#Passw0rd!2026',
            '--no-interaction' => true,
        ])->assertFailed();

        $this->assertDatabaseCount('administrators', 0);
    }

    public function test_requires_a_password_in_non_interactive_mode(): void
    {
        $this->artisan('smevolve:admin:create', [
            '--name' => 'Automated',
            '--email' => 'auto@smevolve.tech',
            '--no-interaction' => true,
        ])->assertFailed();

        $this->assertDatabaseCount('administrators', 0);
    }
}
