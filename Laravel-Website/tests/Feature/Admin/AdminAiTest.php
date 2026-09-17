<?php

namespace Tests\Feature\Admin;

use App\Models\Role;
use App\Services\AI\AiConfigService;
use Illuminate\Support\Facades\Http;

class AdminAiTest extends AdminTestCase
{
    public function test_super_admin_can_view_ai_settings(): void
    {
        $role = $this->superAdminRole();
        $admin = $this->createAdmin($role);

        $this->actingAs($admin, 'admin')
            ->get(route('admin.ai.settings'))
            ->assertOk()
            ->assertSee('Enable AI')
            ->assertSee('Model');
    }

    public function test_super_admin_can_view_ai_status(): void
    {
        $role = $this->superAdminRole();
        $admin = $this->createAdmin($role);

        $this->actingAs($admin, 'admin')
            ->get(route('admin.ai.status'))
            ->assertOk()
            ->assertSee('AI Status')
            ->assertSee('Provider');
    }

    public function test_super_admin_can_update_ai_settings(): void
    {
        config()->set('ai.groq.approved_models', ['llama-3.3-70b-versatile' => 'Llama 3.3 70B']);

        $role = $this->superAdminRole();
        $admin = $this->createAdmin($role);

        $this->actingAs($admin, 'admin')
            ->post(route('admin.ai.update'), [
                'enabled' => '1',
                'model' => 'llama-3.3-70b-versatile',
                'max_output_tokens' => '2048',
                'temperature' => '0.5',
            ])
            ->assertRedirect(route('admin.ai.settings'));

        $this->assertDatabaseHas('ai_configurations', [
            'key' => 'groq.max_output_tokens',
            'value' => '2048',
        ]);

        $this->assertDatabaseHas('ai_configurations', [
            'key' => 'groq.temperature',
            'value' => '0.5',
        ]);

        $this->assertDatabaseHas('admin_audit_logs', [
            'administrator_id' => $admin->id,
            'action' => 'ai.update',
        ]);
    }

    public function test_admin_role_can_view_but_not_update_ai_settings(): void
    {
        $role = $this->adminRole();
        $admin = $this->createAdmin($role);

        $this->actingAs($admin, 'admin')
            ->get(route('admin.ai.settings'))
            ->assertOk();

        $this->actingAs($admin, 'admin')
            ->post(route('admin.ai.update'), [
                'model' => 'llama-3.3-70b-versatile',
            ])
            ->assertForbidden();
    }

    public function test_updated_ai_settings_take_effect_at_runtime(): void
    {
        config()->set('ai.groq.approved_models', ['llama-3.3-70b-versatile' => 'Llama 3.3 70B']);
        config()->set('ai.groq.model', 'config-model');
        config()->set('ai.groq.max_output_tokens', 1024);
        config()->set('ai.groq.temperature', 0.3);
        config()->set('ai.enabled', true);

        $role = $this->superAdminRole();
        $admin = $this->createAdmin($role);

        $this->actingAs($admin, 'admin')
            ->post(route('admin.ai.update'), [
                'enabled' => '1',
                'model' => 'llama-3.3-70b-versatile',
                'max_output_tokens' => '2048',
                'temperature' => '0.7',
            ])
            ->assertRedirect(route('admin.ai.settings'));

        $service = app(AiConfigService::class);

        $this->assertSame('llama-3.3-70b-versatile', $service->model());
        $this->assertSame(2048, $service->maxOutputTokens());
        $this->assertSame(0.7, $service->temperature());
        $this->assertTrue($service->enabled());
        $this->assertTrue($service->featureEnabled('assistant'));
    }

    public function test_disabling_ai_globally_disables_all_features(): void
    {
        $role = $this->superAdminRole();
        $admin = $this->createAdmin($role);

        $this->actingAs($admin, 'admin')
            ->post(route('admin.ai.update'), [
                'enabled' => '0',
            ])
            ->assertRedirect(route('admin.ai.settings'));

        $service = app(AiConfigService::class);

        $this->assertFalse($service->enabled());
        $this->assertFalse($service->featureEnabled('assistant'));
        $this->assertFalse($service->featureEnabled('quote'));
    }

    public function test_super_admin_can_run_live_connection_check(): void
    {
        config()->set('ai.groq.api_key', 'test-key');

        Http::fake([
            'api.groq.com/*' => Http::response([
                'id' => 'chatcmpl-test',
                'model' => 'openai/gpt-oss-120b',
                'choices' => [['message' => ['role' => 'assistant', 'content' => 'OK']]],
                'usage' => ['prompt_tokens' => 5, 'completion_tokens' => 1],
            ], 200),
        ]);

        $role = $this->superAdminRole();
        $admin = $this->createAdmin($role);

        $this->actingAs($admin, 'admin')
            ->post(route('admin.ai.check'))
            ->assertRedirect()
            ->assertSessionHas('status');
    }

    public function test_live_connection_check_reports_provider_failure(): void
    {
        Http::fake([
            'api.groq.com/*' => Http::response(['error' => ['message' => 'boom']], 500),
        ]);

        $role = $this->superAdminRole();
        $admin = $this->createAdmin($role);

        $this->actingAs($admin, 'admin')
            ->post(route('admin.ai.check'))
            ->assertRedirect()
            ->assertSessionHasErrors('check');
    }

    public function test_live_connection_check_requires_ai_view_permission(): void
    {
        $role = Role::updateOrCreate(
            ['name' => 'no_ai_access'],
            ['label' => 'No AI Access', 'permissions' => ['settings.view']]
        );
        $admin = $this->createAdmin($role);

        $this->actingAs($admin, 'admin')
            ->post(route('admin.ai.check'))
            ->assertForbidden();
    }
}
