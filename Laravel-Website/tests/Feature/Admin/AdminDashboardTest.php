<?php

namespace Tests\Feature\Admin;

use App\Models\Administrator;
use App\Models\QuoteSubmission;
use App\Models\Role;

class AdminDashboardTest extends AdminTestCase
{
    public function test_super_admin_sees_quote_metrics(): void
    {
        $role = $this->superAdminRole();
        $admin = $this->createAdmin($role);

        $session = \App\Models\QuoteSession::create([
            'uuid' => (string) \Illuminate\Support\Str::uuid(),
            'session_id' => (string) \Illuminate\Support\Str::uuid(),
            'status' => 'completed',
            'started_at' => now(),
            'last_activity_at' => now(),
        ]);

        QuoteSubmission::create([
            'quote_session_id' => $session->id,
            'reference' => 'SME-0001',
            'status' => QuoteSubmission::STATUS_SUBMITTED,
            'contact_name' => 'Jane Doe',
            'contact_email' => 'jane@example.com',
            'submitted_at' => now(),
        ]);

        $this->actingAs($admin, 'admin')
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Total Quotes')
            ->assertSee('Jane Doe')
            ->assertSee('Chatbot Assistant')
            ->assertSee('AI Service');
    }

    public function test_editor_dashboard_hides_quote_metrics(): void
    {
        $role = $this->editorRole();
        $admin = $this->createAdmin($role);

        $response = $this->actingAs($admin, 'admin')
            ->get(route('admin.dashboard'))
            ->assertOk();

        $response->assertDontSee('Total Quotes');
        $response->assertDontSee('Recent Quotes');
    }
}
