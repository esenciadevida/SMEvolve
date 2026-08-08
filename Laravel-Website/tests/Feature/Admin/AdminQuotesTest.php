<?php

namespace Tests\Feature\Admin;

use App\Models\QuoteSession;
use App\Models\QuoteSubmission;
use Illuminate\Support\Str;

class AdminQuotesTest extends AdminTestCase
{
    private function createSubmission(string $reference = 'SME-TEST-1'): QuoteSubmission
    {
        $session = QuoteSession::create([
            'uuid' => (string) Str::uuid(),
            'session_id' => (string) Str::uuid(),
            'status' => 'submitted',
            'project_type' => 'Website development',
            'business_name' => 'Acme Ltd',
            'started_at' => now(),
            'last_activity_at' => now(),
        ]);

        return QuoteSubmission::create([
            'quote_session_id' => $session->id,
            'reference' => $reference,
            'status' => QuoteSubmission::STATUS_SUBMITTED,
            'contact_name' => 'Jane Doe',
            'contact_email' => 'jane@example.com',
            'contact_phone' => '+27700000000',
            'preferred_contact_method' => 'email',
            'submitted_at' => now(),
        ]);
    }

    public function test_super_admin_can_list_quotes(): void
    {
        $role = $this->superAdminRole();
        $admin = $this->createAdmin($role);
        $this->createSubmission();

        $this->actingAs($admin, 'admin')
            ->get(route('admin.quotes.index'))
            ->assertOk()
            ->assertSee('SME-TEST-1')
            ->assertSee('Jane Doe');
    }

    public function test_super_admin_can_view_quote(): void
    {
        $role = $this->superAdminRole();
        $admin = $this->createAdmin($role);
        $quote = $this->createSubmission();

        $this->actingAs($admin, 'admin')
            ->get(route('admin.quotes.show', $quote))
            ->assertOk()
            ->assertSee($quote->reference)
            ->assertSee('Project Details');
    }

    public function test_super_admin_can_update_status(): void
    {
        $role = $this->superAdminRole();
        $admin = $this->createAdmin($role);
        $quote = $this->createSubmission();

        $this->actingAs($admin, 'admin')
            ->post(route('admin.quotes.status', $quote), [
                'status' => QuoteSubmission::STATUS_UNDER_REVIEW,
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('quote_submissions', [
            'id' => $quote->id,
            'status' => QuoteSubmission::STATUS_UNDER_REVIEW,
        ]);

        $this->assertDatabaseHas('admin_audit_logs', [
            'administrator_id' => $admin->id,
            'action' => 'quotes.update_status',
            'resource_type' => 'quotes',
            'resource_id' => (string) $quote->id,
        ]);
    }

    public function test_support_role_can_view_and_update_status(): void
    {
        $role = $this->supportRole();
        $admin = $this->createAdmin($role);
        $quote = $this->createSubmission();

        $this->actingAs($admin, 'admin')
            ->get(route('admin.quotes.show', $quote))
            ->assertOk();

        $this->actingAs($admin, 'admin')
            ->post(route('admin.quotes.status', $quote), [
                'status' => QuoteSubmission::STATUS_COMPLETED,
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('quote_submissions', [
            'id' => $quote->id,
            'status' => QuoteSubmission::STATUS_COMPLETED,
        ]);
    }
}
