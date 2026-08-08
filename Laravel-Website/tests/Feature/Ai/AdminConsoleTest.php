<?php

namespace Tests\Feature\Ai;

use App\Models\AiPrompt;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AdminConsoleTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();

        config()->set('ai.admin.enabled', true);
        config()->set('ai.admin.email', 'admin@smevolve.tech');
        config()->set('ai.admin.password', 'secret-admin-password');
    }

    public function test_login_page_is_public(): void
    {
        $this->get(route('admin.ai.login'))->assertOk()->assertSee('AI Console Login');
    }

    public function test_dashboard_redirects_to_login_when_unauthenticated(): void
    {
        $this->get(route('admin.ai.dashboard'))->assertRedirect(route('admin.ai.login'));
    }

    public function test_login_rejects_invalid_credentials(): void
    {
        $this->from(route('admin.ai.login'))
            ->post(route('admin.ai.login.store'), [
                'email' => 'admin@smevolve.tech',
                'password' => 'wrong-password',
            ])
            ->assertRedirect(route('admin.ai.login'))
            ->assertSessionHasErrors('email');
    }

    public function test_login_accepts_valid_credentials(): void
    {
        $this->post(route('admin.ai.login.store'), [
            'email' => 'admin@smevolve.tech',
            'password' => 'secret-admin-password',
        ])->assertRedirect(route('admin.ai.dashboard'));

        $this->get(route('admin.ai.dashboard'))->assertOk()->assertSee('Dashboard');
    }

    public function test_admin_can_view_config_prompts_knowledge_usage_health(): void
    {
        $this->actingAsAdmin();

        $this->get(route('admin.ai.config'))->assertOk();
        $this->get(route('admin.ai.prompts'))->assertOk();
        $this->get(route('admin.ai.knowledge.index'))->assertOk();
        $this->get(route('admin.ai.usage'))->assertOk();
        $this->get(route('admin.ai.health'))->assertOk();
    }

    public function test_admin_can_update_configuration(): void
    {
        $this->actingAsAdmin();

        $this->post(route('admin.ai.config.update'), [
            'values' => [
                'assistant.welcome_message' => 'Hello, welcome!',
                'quote.enabled' => '0',
            ],
        ])->assertRedirect();

        $this->assertDatabaseHas('ai_configurations', ['key' => 'assistant.welcome_message', 'value' => 'Hello, welcome!']);
    }

    public function test_admin_can_create_prompt_version(): void
    {
        $this->actingAsAdmin();

        $prompt = AiPrompt::create([
            'key' => 'test_prompt_'.uniqid(),
            'name' => 'Test Prompt',
        ]);

        $this->post(route('admin.ai.prompts.versions.store', $prompt), [
            'version' => '1.0',
            'content' => 'Test content',
            'activate' => '1',
        ])->assertRedirect()->assertSessionHasNoErrors();

        $this->assertDatabaseHas('ai_prompt_versions', ['prompt_id' => $prompt->id, 'version' => '1.0', 'status' => 'active']);
        $this->assertSame($prompt->fresh()->active_version_id, $prompt->versions()->where('version', '1.0')->first()->id);
    }

    public function test_admin_can_create_knowledge_item(): void
    {
        $this->actingAsAdmin();

        $this->post(route('admin.ai.knowledge.store'), [
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

    private function actingAsAdmin(): void
    {
        $this->post(route('admin.ai.login.store'), [
            'email' => 'admin@smevolve.tech',
            'password' => 'secret-admin-password',
        ])->assertRedirect(route('admin.ai.dashboard'));
    }
}
