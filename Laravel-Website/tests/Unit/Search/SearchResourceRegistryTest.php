<?php

namespace Tests\Unit\Search;

use App\Models\Administrator;
use App\Models\Role;
use App\Services\Search\SearchContract;
use App\Services\Search\SearchResourceRegistry;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class SearchResourceRegistryTest extends TestCase
{
    public function test_it_registers_and_resolves_providers_by_key(): void
    {
        $registry = new SearchResourceRegistry();

        $registry->register($this->provider('quotes', 'Quotes', 'quotes.search'));
        $registry->register($this->provider('settings', 'Settings', 'settings.view'));

        $this->assertSame('Quotes', $registry->get('quotes')->label());
        $this->assertSame(['quotes', 'settings'], array_keys($registry->all()));
    }

    public function test_it_rejects_unknown_provider_keys(): void
    {
        $this->expectException(InvalidArgumentException::class);

        (new SearchResourceRegistry())->get('missing');
    }

    public function test_for_administrator_returns_only_authorized_providers(): void
    {
        $registry = new SearchResourceRegistry();

        $registry->register($this->provider('quotes', 'Quotes', 'quotes.search'));
        $registry->register($this->provider('administrators', 'Administrators', 'administrators.view'));
        $registry->register($this->provider('settings', 'Settings', 'settings.view'));

        $admin = $this->administrator(['settings.view']);

        $this->assertSame(['settings'], array_keys($registry->forAdministrator($admin)));
    }

    private function provider(string $key, string $label, ?string $permission): SearchContract
    {
        return new class($key, $label, $permission) implements SearchContract {
            public function __construct(
                private readonly string $key,
                private readonly string $label,
                private readonly ?string $permission,
            ) {
            }

            public function key(): string
            {
                return $this->key;
            }

            public function label(): string
            {
                return $this->label;
            }

            public function permission(): ?string
            {
                return $this->permission;
            }

            public function canSearch(Administrator $administrator): bool
            {
                return $this->permission === null || $administrator->hasPermission($this->permission);
            }

            public function search(string $query, int $limit = 5): array
            {
                return [];
            }
        };
    }

    private function administrator(array $permissions): Administrator
    {
        $role = new Role(['permissions' => $permissions]);
        $administrator = new Administrator(['name' => 'Test Admin']);
        $administrator->setRelation('role', $role);

        return $administrator;
    }
}
