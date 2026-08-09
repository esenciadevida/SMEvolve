<?php

namespace Tests\Feature\Ai;

use App\Models\Administrator;
use App\Models\AiPrompt;
use App\Models\Role;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AdminConsoleTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_console_requires_admin_authentication(): void
    {
        $this->get(route('admin.ai.dashboard'))->assertRedirect(route('admin.login'));
    }

    public function test_admin_without_ai_permission_is_denied(): void
    {
        $admin = $this->admin('support');

        $this->actingAs($admin, 'admin')
            ->get(route('admin.ai.dashboard'))
            ->assertForbidden();
    }

    public function test_admin_can_view_dashboard_and_config_pages(): void
    {
        $admin = $this->admin('super_admin');

        $this->actingAs($admin, 'admin')->get(route('admin.ai.dashboard'))->assertOk();
        $this->actingAs($admin, 'admin')->get(route('admin.ai.config'))->assertOk();
        $this->actingAs($admin, 'admin')->get(route('admin.ai.prompts'))->assertOk();
        $this->actingAs($admin, 'admin')->get(route('admin.ai.knowledge.index'))->assertOk();
        $this->actingAs($admin, 'admin')->get(route('admin.ai.usage'))->assertOk();
        $this->actingAs($admin, 'admin')->get(route('admin.ai.health'))->assertOk();
    }

    public function test_admin_can_update_configuration(): void
    {
        $admin = $this->admin('super_admin');

        $this->actingAs($admin, 'admin')->post(route('admin.ai.config.update'), [
            'values' => [
                'assistant.welcome_message' => 'Hello, welcome!',
                'quote.enabled' => '0',
            ],
        ])->assertRedirect()->assertSessionHasNoErrors();

        $this->assertDatabaseHas('ai_configurations', ['key' => 'assistant.welcome_message', 'value' => 'Hello, welcome!']);
    }

    public function test_admin_can_create_prompt_version(): void
    {
        $admin = $this->admin('super_admin');

        $prompt = AiPrompt::create([
            'key' => 'test_prompt_'.uniqid(),
            'name' => 'Test Prompt',
        ]);

        $this->actingAs($admin, 'admin')->post(route('admin.ai.prompts.versions.store', $prompt), [
            'version' => '1.0',
            'content' => 'Test content',
            'activate' => '1',
        ])->assertRedirect()->assertSessionHasNoErrors();

        $this->assertDatabaseHas('ai_prompt_versions', ['prompt_id' => $prompt->id, 'version' => '1.0', 'status' => 'active']);
        $this->assertSame($prompt->fresh()->active_version_id, $prompt->versions()->where('version', '1.0')->first()->id);
    }

    public function test_admin_can_create_knowledge_item(): void
    {
        $admin = $this->admin('super_admin');

        $this->actingAs($admin, 'admin')->post(route('admin.ai.knowledge.store'), [
            'type' => 'custom',
            'title' => 'Refund Policy',
            'content' => 'Refunds are issued within 7 business days.',
            'status' => 'published',
            'priority' => 'high',
            'keywords_input' => 'refund, money back',
        ])->assertRedirect()->assertSessionHasNoErrors();

        $this->assertDatabaseHas('knowledge_items', [
            'title' => 'Refund Policy',
            'status' => 'published',
        ]);
    }

    private function admin(string $roleName): Administrator
    {
        $role = Role::updateOrCreate(
            ['name' => $roleName],
            [
                'label' => ucfirst(str_replace('_', ' ', $roleName)),
                'permissions' => config("admin.roles.{$roleName}", []),
            ]
        );

        return Administrator::factory()->create([
            'role_id' => $role->id,
            'email' => "{$roleName}@example.com",
            'is_active' => true,
        ]);
    }
}
