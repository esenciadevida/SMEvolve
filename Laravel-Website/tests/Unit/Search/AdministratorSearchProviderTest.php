<?php

namespace Tests\Unit\Search;

use App\Models\Administrator;
use App\Models\Role;
use App\Services\Search\AdministratorSearchProvider;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AdministratorSearchProviderTest extends TestCase
{
    use DatabaseTransactions;

    public function test_finds_administrator_by_name(): void
    {
        $role = Role::factory()->create();
        $administrator = Administrator::factory()->create([
            'name' => 'Alice Wonder',
            'role_id' => $role->id,
        ]);

        $results = (new AdministratorSearchProvider())->search('alice', 5);

        $this->assertCount(1, $results);
        $this->assertSame('Alice Wonder', $results[0]['title']);
        $this->assertSame('administrator', $results[0]['type']);
        $this->assertSame(route('admin.administrators.show', $administrator), $results[0]['url']);
    }

    public function test_finds_administrator_by_email(): void
    {
        $role = Role::factory()->create();
        Administrator::factory()->create([
            'name' => 'Bob Builder',
            'email' => 'bob@example.com',
            'role_id' => $role->id,
        ]);

        $results = (new AdministratorSearchProvider())->search('bob@example.com', 5);

        $this->assertCount(1, $results);
        $this->assertSame('bob@example.com', $results[0]['subtitle']);
    }

    public function test_exact_name_ranks_before_contains_match(): void
    {
        $role = Role::factory()->create();
        Administrator::factory()->create(['name' => 'Chris Cole', 'email' => 'cc@example.com', 'role_id' => $role->id]);
        Administrator::factory()->create(['name' => 'Natalie Chris Cole', 'email' => 'cd@example.com', 'role_id' => $role->id]);

        $results = (new AdministratorSearchProvider())->search('chris cole', 5);

        $this->assertCount(2, $results);
        $this->assertSame('Chris Cole', $results[0]['title']);
    }

    public function test_permission_gate_requires_administrators_view(): void
    {
        $role = new Role(['permissions' => ['quotes.search']]);
        $administrator = new Administrator();
        $administrator->setRelation('role', $role);

        $provider = new AdministratorSearchProvider();

        $this->assertFalse($provider->canSearch($administrator));
    }
}
