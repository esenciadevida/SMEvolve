<?php

namespace Tests\Feature\Admin;

use App\Models\KnowledgeItem;
use App\Models\QuoteSession;
use App\Models\QuoteSubmission;
use App\Models\Role;
use App\Services\Admin\AdminAuditService;
use Illuminate\Support\Str;

class AdminSearchTest extends AdminTestCase
{
    public function test_guests_are_redirected_to_login(): void
    {
        $this->get(route('admin.search'))->assertRedirect(route('admin.login'));
    }

    public function test_super_admin_can_open_the_search_page(): void
    {
        $role = $this->superAdminRole();
        $admin = $this->createAdmin($role);

        $this->actingAs($admin, 'admin')
            ->get(route('admin.search'))
            ->assertOk()
            ->assertSee('Search across the admin portal');
    }

    public function test_search_page_finds_quotes(): void
    {
        $role = $this->superAdminRole();
        $admin = $this->createAdmin($role);
        $quote = $this->createSubmission('SME-SEARCH-1');

        $this->actingAs($admin, 'admin')
            ->get(route('admin.search', ['q' => 'SME-SEARCH-1']))
            ->assertOk()
            ->assertSee('SME-SEARCH-1')
            ->assertSee(route('admin.quotes.show', $quote), false);
    }

    public function test_autocomplete_returns_quotes_as_json(): void
    {
        $role = $this->superAdminRole();
        $admin = $this->createAdmin($role);
        $this->createSubmission('SME-SEARCH-2');

        $response = $this->actingAs($admin, 'admin')
            ->withHeaders(['Accept' => 'application/json'])
            ->getJson(route('admin.search.autocomplete', ['q' => 'SME-SEARCH-2']))
            ->assertOk()
            ->assertJsonPath('total', 1);

        $this->assertSame('SME-SEARCH-2', $response->json('results.quotes.0.title'));
    }

    public function test_support_role_never_sees_administrators_in_results(): void
    {
        $role = $this->supportRole();
        $admin = $this->createAdmin($role);

        $this->actingAs($admin, 'admin')
            ->withHeaders(['Accept' => 'application/json'])
            ->getJson(route('admin.search.autocomplete', ['q' => 'example']))
            ->assertOk()
            ->assertJsonPath('results.administrators', null);
    }

    public function test_editor_role_sees_only_settings_and_results_are_limited(): void
    {
        $role = $this->editorRole();
        $admin = $this->createAdmin($role);

        $this->actingAs($admin, 'admin')
            ->withHeaders(['Accept' => 'application/json'])
            ->getJson(route('admin.search.autocomplete', ['q' => 'company']))
            ->assertOk()
            ->assertJsonPath('results.quotes', null)
            ->assertJsonPath('results.administrators', null)
            ->assertJsonPath('total', 5)
            ->assertJsonCount(5, 'results.settings');
    }

    public function test_search_page_shows_only_authorized_filter_chips(): void
    {
        $role = $this->editorRole();
        $admin = $this->createAdmin($role);

        $this->actingAs($admin, 'admin')
            ->get(route('admin.search'))
            ->assertOk()
            ->assertSee('Settings')
            ->assertDontSee('Quotes')
            ->assertDontSee('Administrators');
    }

    public function test_super_admin_sees_knowledge_in_results(): void
    {
        $role = $this->superAdminRole();
        $admin = $this->createAdmin($role);

        KnowledgeItem::create([
            'title' => 'Pricing Overview',
            'slug' => 'pricing-overview',
            'type' => 'knowledge',
            'content' => 'Guidance on how projects are priced.',
            'status' => 'published',
            'priority' => 'normal',
            'published_at' => now(),
        ]);

        $response = $this->actingAs($admin, 'admin')
            ->withHeaders(['Accept' => 'application/json'])
            ->getJson(route('admin.search.autocomplete', ['q' => 'pricing overview']))
            ->assertOk()
            ->assertJsonPath('results.knowledge.0.title', 'Pricing Overview');

        $this->assertStringContainsString(
            route('admin.ai.knowledge.index'),
            $response->json('results.knowledge.0.url')
        );
    }

    public function test_super_admin_sees_audit_logs_in_results(): void
    {
        $role = $this->superAdminRole();
        $admin = $this->createAdmin($role, 'boss@smevolve.tech');

        app(AdminAuditService::class)->log(
            'settings.update',
            'site_settings',
            'company.name',
            actor: $admin,
        );

        $this->actingAs($admin, 'admin')
            ->withHeaders(['Accept' => 'application/json'])
            ->getJson(route('admin.search.autocomplete', ['q' => 'company.name']))
            ->assertOk()
            ->assertJsonPath('results.audit_logs.0.title', 'Settings Update');
    }

    public function test_editor_role_never_sees_knowledge_or_audit_results(): void
    {
        $role = $this->editorRole();
        $admin = $this->createAdmin($role);

        $this->actingAs($admin, 'admin')
            ->withHeaders(['Accept' => 'application/json'])
            ->getJson(route('admin.search.autocomplete', ['q' => 'settings']))
            ->assertOk()
            ->assertJsonPath('results.knowledge', null)
            ->assertJsonPath('results.audit_logs', null);
    }

    public function test_role_without_search_permissions_is_forbidden(): void
    {
        $role = Role::create([
            'name' => 'limited',
            'label' => 'Limited',
            'permissions' => ['dashboard.view'],
        ]);
        $admin = $this->createAdmin($role);

        $this->actingAs($admin, 'admin')
            ->get(route('admin.search'))
            ->assertForbidden();
    }

    public function test_autocomplete_validates_minimum_query_length(): void
    {
        $role = $this->superAdminRole();
        $admin = $this->createAdmin($role);

        $this->actingAs($admin, 'admin')
            ->withHeaders(['Accept' => 'application/json'])
            ->getJson(route('admin.search.autocomplete', ['q' => 'a']))
            ->assertUnprocessable()
            ->assertJsonValidationErrors('q');
    }

    public function test_autocomplete_validates_maximum_query_length(): void
    {
        $role = $this->superAdminRole();
        $admin = $this->createAdmin($role);

        $this->actingAs($admin, 'admin')
            ->withHeaders(['Accept' => 'application/json'])
            ->getJson(route('admin.search.autocomplete', ['q' => Str::repeat('a', 101)]))
            ->assertUnprocessable()
            ->assertJsonValidationErrors('q');
    }

    public function test_autocomplete_rejects_unknown_resource_filters(): void
    {
        $role = $this->superAdminRole();
        $admin = $this->createAdmin($role);

        $this->actingAs($admin, 'admin')
            ->withHeaders(['Accept' => 'application/json'])
            ->getJson(route('admin.search.autocomplete', ['q' => 'sme', 'type' => 'unknown']))
            ->assertUnprocessable()
            ->assertJsonValidationErrors('type');
    }

    public function test_autocomplete_is_rate_limited(): void
    {
        config()->set('admin.search_rate_limit', 2);

        $role = $this->superAdminRole();
        $admin = $this->createAdmin($role);

        for ($i = 0; $i < 2; $i++) {
            $this->actingAs($admin, 'admin')
                ->withHeaders(['Accept' => 'application/json'])
                ->getJson(route('admin.search.autocomplete', ['q' => 'sme']))
                ->assertOk();
        }

        $this->actingAs($admin, 'admin')
            ->withHeaders(['Accept' => 'application/json'])
            ->getJson(route('admin.search.autocomplete', ['q' => 'sme']))
            ->assertStatus(429);
    }

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
}
