<?php

namespace Tests\Feature\Admin;

class AdminChatbotTest extends AdminTestCase
{
    public function test_super_admin_can_view_chatbot_settings(): void
    {
        $role = $this->superAdminRole();
        $admin = $this->createAdmin($role);

        $this->actingAs($admin, 'admin')
            ->get(route('admin.chatbot.index'))
            ->assertOk()
            ->assertSee('Enable chatbot')
            ->assertSee('Welcome message');
    }

    public function test_super_admin_can_update_chatbot_settings(): void
    {
        $role = $this->superAdminRole();
        $admin = $this->createAdmin($role);

        $this->actingAs($admin, 'admin')
            ->post(route('admin.chatbot.update'), [
                'enabled' => '1',
                'welcome_message' => 'Hello, welcome to SMEvolve!',
                'availability_message' => 'We are away right now.',
            ])
            ->assertRedirect(route('admin.chatbot.index'));

        $this->assertDatabaseHas('ai_configurations', [
            'key' => 'assistant.enabled',
            'value' => '1',
            'updated_by' => (string) $admin->id,
        ]);

        $this->assertDatabaseHas('ai_configurations', [
            'key' => 'assistant.welcome_message',
            'value' => 'Hello, welcome to SMEvolve!',
        ]);

        $this->assertDatabaseHas('admin_audit_logs', [
            'administrator_id' => $admin->id,
            'action' => 'chatbot.update',
        ]);
    }
}
