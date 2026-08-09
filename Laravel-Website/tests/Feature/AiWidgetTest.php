<?php

namespace Tests\Feature;

use Tests\TestCase;

class AiWidgetTest extends TestCase
{
    public function test_ai_chat_widget_renders_on_home_page_when_enabled(): void
    {
        $this->get('/')->assertOk()->assertSee('SMEvolve AI Assistant', false);
    }

    public function test_ai_chat_widget_is_hidden_on_quote_page(): void
    {
        $this->get('/quote')->assertOk()->assertDontSee('SMEvolve AI Assistant', false);
    }

    public function test_ai_console_redirects_unauthenticated_users_to_admin_login(): void
    {
        $this->get(route('admin.ai.dashboard'))->assertRedirect(route('admin.login'));
    }
}
