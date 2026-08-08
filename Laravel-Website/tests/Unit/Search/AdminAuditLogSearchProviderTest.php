<?php

namespace Tests\Unit\Search;

use App\Models\AdminAuditLog;
use App\Models\Administrator;
use App\Models\Role;
use App\Services\Search\AdminAuditLogSearchProvider;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AdminAuditLogSearchProviderTest extends TestCase
{
    use DatabaseTransactions;

    public function test_finds_audit_log_by_administrator_name(): void
    {
        $admin = $this->administrator();
        $admin->save();

        $this->log($admin, 'quotes.update_status', 'quotes', '42');

        $results = (new AdminAuditLogSearchProvider())->search($admin->name, 5);

        $this->assertNotEmpty($results);
    }

    public function test_finds_audit_log_by_action(): void
    {
        $admin = $this->administrator();
        $admin->save();

        $this->log($admin, 'settings.update', 'site_settings', 'company.name');
        $this->log($admin, 'quotes.update_status', 'quotes', '7');

        $results = (new AdminAuditLogSearchProvider())->search('settings.update', 5);

        $this->assertNotEmpty($results);
        $this->assertSame('Settings Update', $results[0]['title']);
    }

    public function test_finds_audit_log_by_resource_id(): void
    {
        $admin = $this->administrator();
        $admin->save();

        $this->log($admin, 'quotes.update_status', 'quotes', '99');

        $results = (new AdminAuditLogSearchProvider())->search('99', 5);

        $this->assertNotEmpty($results);
        $this->assertSame(route('admin.audit.index', ['q' => '99']), $results[0]['url']);
    }

    public function test_result_shape_is_normalized(): void
    {
        $admin = $this->administrator();
        $admin->save();

        $log = $this->log($admin, 'settings.update', 'site_settings', 'company.name', ['name' => 'SMEvolve']);

        $results = (new AdminAuditLogSearchProvider())->search('smevolve', 5);

        $this->assertNotEmpty($results);
        $result = collect($results)->firstWhere('id', $log->id);

        $this->assertNotNull($result);
        $this->assertSame('audit_log', $result['type']);
        $this->assertSame('Settings Update', $result['title']);
        $this->assertSame('Site Settings', $result['metadata']['group']);
    }

    public function test_permission_requires_audit_view(): void
    {
        $provider = new AdminAuditLogSearchProvider();

        $this->assertSame('audit.view', $provider->permission());
        $this->assertTrue($provider->canSearch($this->inMemoryAdministrator(['audit.view'])));
        $this->assertFalse($provider->canSearch($this->inMemoryAdministrator(['dashboard.view'])));
    }

    private function inMemoryAdministrator(array $permissions): Administrator
    {
        $role = new Role(['permissions' => $permissions]);
        $administrator = new Administrator(['name' => 'Test Admin']);
        $administrator->setRelation('role', $role);

        return $administrator;
    }

    private function log(Administrator $admin, string $action, string $resourceType, string $resourceId, mixed $newValue = null): AdminAuditLog
    {
        return AdminAuditLog::create([
            'administrator_id' => $admin->id,
            'action' => $action,
            'resource_type' => $resourceType,
            'resource_id' => $resourceId,
            'new_value' => is_array($newValue) ? json_encode($newValue) : $newValue,
        ]);
    }

    private function administrator(array $permissions = []): Administrator
    {
        $role = Role::create([
            'name' => 'test',
            'label' => 'Test',
            'permissions' => $permissions,
        ]);

        return Administrator::factory()->create([
            'role_id' => $role->id,
            'name' => 'Audit Admin',
            'email' => 'audit@example.com',
        ]);
    }
}
