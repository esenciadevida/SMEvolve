<?php

namespace Tests\Feature\Admin;

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
}
