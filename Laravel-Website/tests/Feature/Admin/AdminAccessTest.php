<?php

namespace Tests\Feature\Admin;

class AdminAccessTest extends AdminTestCase
{
    public function test_unauthenticated_requests_redirect_to_login(): void
    {
        foreach ([
            'admin.dashboard',
            'admin.settings.index',
            'admin.quotes.index',
            'admin.chatbot.index',
            'admin.ai.settings',
            'admin.analytics.traffic',
            'admin.analytics.quotes',
            'admin.analytics.chatbot',
            'admin.analytics.ai',
            'admin.administrators.index',
            'admin.audit.index',
            'admin.profile.index',
            'admin.security.index',
        ] as $route) {
            $url = $route === 'admin.settings.index'
                ? route($route, ['group' => 'general'])
                : route($route);

            $this->get($url)->assertRedirect(route('admin.login'));
        }
    }

    public function test_editor_cannot_access_quotes(): void
    {
        $role = $this->editorRole();
        $admin = $this->createAdmin($role);

        $this->actingAs($admin, 'admin')
            ->get(route('admin.quotes.index'))
            ->assertForbidden();
    }

    public function test_editor_cannot_update_settings(): void
    {
        $role = $this->editorRole();
        $admin = $this->createAdmin($role);

        $this->actingAs($admin, 'admin')
            ->post(route('admin.settings.update', ['group' => 'general']), [
                'company.name' => 'New Name',
            ])
            ->assertForbidden();
    }

    public function test_support_cannot_update_settings_or_view_administrators(): void
    {
        $role = $this->supportRole();
        $admin = $this->createAdmin($role);

        $this->actingAs($admin, 'admin')
            ->get(route('admin.settings.index', ['group' => 'general']))
            ->assertForbidden();

        $this->actingAs($admin, 'admin')
            ->get(route('admin.administrators.index'))
            ->assertForbidden();
    }

    public function test_support_cannot_access_analytics_section(): void
    {
        $role = $this->supportRole();
        $admin = $this->createAdmin($role);

        $this->actingAs($admin, 'admin')
            ->get(route('admin.analytics.traffic'))
            ->assertForbidden();
    }

    public function test_editor_without_quotes_permission_cannot_view_quote_analytics(): void
    {
        $role = $this->editorRole();
        $admin = $this->createAdmin($role);

        $this->actingAs($admin, 'admin')
            ->get(route('admin.analytics.quotes'))
            ->assertForbidden();
    }

    public function test_admin_role_cannot_view_administrators_or_audit_log(): void
    {
        $role = $this->adminRole();
        $admin = $this->createAdmin($role);

        $this->actingAs($admin, 'admin')
            ->get(route('admin.administrators.index'))
            ->assertForbidden();

        $this->actingAs($admin, 'admin')
            ->get(route('admin.audit.index'))
            ->assertForbidden();
    }

    public function test_admin_role_cannot_update_ai_settings(): void
    {
        $role = $this->adminRole();
        $admin = $this->createAdmin($role);

        $this->actingAs($admin, 'admin')
            ->post(route('admin.ai.update'), [
                'model' => 'llama-3.3-70b-versatile',
                'max_output_tokens' => 1024,
                'temperature' => 0.3,
            ])
            ->assertForbidden();
    }

    public function test_super_admin_can_access_all_sections(): void
    {
        $role = $this->superAdminRole();
        $admin = $this->createAdmin($role);

        $this->actingAs($admin, 'admin')
            ->get(route('admin.dashboard'))
            ->assertOk();

        $this->actingAs($admin, 'admin')
            ->get(route('admin.settings.index', ['group' => 'general']))
            ->assertOk();

        $this->actingAs($admin, 'admin')
            ->get(route('admin.quotes.index'))
            ->assertOk();

        $this->actingAs($admin, 'admin')
            ->get(route('admin.chatbot.index'))
            ->assertOk();

        $this->actingAs($admin, 'admin')
            ->get(route('admin.ai.settings'))
            ->assertOk();

        $this->actingAs($admin, 'admin')
            ->get(route('admin.analytics.traffic'))
            ->assertOk();

        $this->actingAs($admin, 'admin')
            ->get(route('admin.analytics.quotes'))
            ->assertOk();

        $this->actingAs($admin, 'admin')
            ->get(route('admin.analytics.chatbot'))
            ->assertOk();

        $this->actingAs($admin, 'admin')
            ->get(route('admin.analytics.ai'))
            ->assertOk();

        $this->actingAs($admin, 'admin')
            ->get(route('admin.administrators.index'))
            ->assertOk();

        $this->actingAs($admin, 'admin')
            ->get(route('admin.audit.index'))
            ->assertOk();
    }
}
