<?php

namespace Tests\Feature\Admin;

use App\Models\PortfolioCategory;
use App\Models\PortfolioProject;

class AdminPortfolioTest extends AdminTestCase
{
    private function category(array $attributes = []): PortfolioCategory
    {
        return PortfolioCategory::factory()->create($attributes);
    }

    public function test_super_admin_can_list_portfolio_projects(): void
    {
        $role = $this->superAdminRole();
        $admin = $this->createAdmin($role, 'boss@smevolve.tech');
        $category = $this->category();
        $project = PortfolioProject::factory()->create(['portfolio_category_id' => $category->id]);

        $this->actingAs($admin, 'admin')
            ->get(route('admin.portfolio.index'))
            ->assertOk()
            ->assertSee($project->title);
    }

    public function test_super_admin_can_create_project(): void
    {
        $role = $this->superAdminRole();
        $admin = $this->createAdmin($role, 'boss@smevolve.tech');
        $category = $this->category();

        $this->actingAs($admin, 'admin')
            ->post(route('admin.portfolio.store'), [
                'title' => 'Warehouse Management System',
                'slug' => 'warehouse-management-system',
                'portfolio_category_id' => $category->id,
                'status' => 'Delivered 2026',
                'short_description' => 'A stock tracking platform for a growing retailer.',
                'summary' => 'A full inventory platform.',
                'technologies' => 'Laravel, MySQL',
                'services_slugs' => ['custom-software'],
                'featured' => '1',
                'is_published' => '1',
            ])
            ->assertRedirect(route('admin.portfolio.index'));

        $this->assertDatabaseHas('portfolio_projects', [
            'slug' => 'warehouse-management-system',
            'title' => 'Warehouse Management System',
            'portfolio_category_id' => $category->id,
            'is_published' => true,
            'featured' => true,
        ]);

        $this->assertDatabaseHas('admin_audit_logs', [
            'administrator_id' => $admin->id,
            'action' => 'portfolio.create',
            'resource_type' => 'portfolio_projects',
        ]);
    }

    public function test_super_admin_can_update_project(): void
    {
        $role = $this->superAdminRole();
        $admin = $this->createAdmin($role, 'boss@smevolve.tech');
        $project = PortfolioProject::factory()->create();

        $this->actingAs($admin, 'admin')
            ->put(route('admin.portfolio.update', $project), [
                'title' => 'Renamed Project',
                'slug' => $project->slug,
                'portfolio_category_id' => $project->portfolio_category_id,
                'status' => 'Ongoing',
                'short_description' => $project->short_description,
                'featured' => '0',
                'is_published' => '1',
            ])
            ->assertRedirect(route('admin.portfolio.index'));

        $this->assertDatabaseHas('portfolio_projects', [
            'id' => $project->id,
            'title' => 'Renamed Project',
            'status' => 'Ongoing',
        ]);

        $this->assertDatabaseHas('admin_audit_logs', [
            'administrator_id' => $admin->id,
            'action' => 'portfolio.update',
        ]);
    }

    public function test_super_admin_can_toggle_publish(): void
    {
        $role = $this->superAdminRole();
        $admin = $this->createAdmin($role, 'boss@smevolve.tech');
        $project = PortfolioProject::factory()->create(['is_published' => true]);

        $this->actingAs($admin, 'admin')
            ->post(route('admin.portfolio.publish', $project))
            ->assertRedirect();

        $this->assertDatabaseHas('portfolio_projects', [
            'id' => $project->id,
            'is_published' => false,
        ]);
    }

    public function test_super_admin_can_delete_project(): void
    {
        $role = $this->superAdminRole();
        $admin = $this->createAdmin($role, 'boss@smevolve.tech');
        $project = PortfolioProject::factory()->create();

        $this->actingAs($admin, 'admin')
            ->delete(route('admin.portfolio.destroy', $project))
            ->assertRedirect(route('admin.portfolio.index'));

        $this->assertDatabaseMissing('portfolio_projects', ['id' => $project->id]);

        $this->assertDatabaseHas('admin_audit_logs', [
            'administrator_id' => $admin->id,
            'action' => 'portfolio.delete',
        ]);
    }

    public function test_slug_must_be_unique(): void
    {
        $role = $this->superAdminRole();
        $admin = $this->createAdmin($role, 'boss@smevolve.tech');
        PortfolioProject::factory()->create(['slug' => 'duplicate-slug']);

        $this->actingAs($admin, 'admin')
            ->post(route('admin.portfolio.store'), [
                'title' => 'Another Project',
                'slug' => 'duplicate-slug',
                'status' => 'Active',
                'short_description' => 'Should fail.',
            ])
            ->assertSessionHasErrors('slug');
    }

    public function test_non_array_section_payload_is_rejected(): void
    {
        $role = $this->superAdminRole();
        $admin = $this->createAdmin($role, 'boss@smevolve.tech');

        $this->actingAs($admin, 'admin')
            ->post(route('admin.portfolio.store'), [
                'title' => 'Broken JSON Project',
                'slug' => 'broken-json-project',
                'status' => 'Active',
                'short_description' => 'Should fail.',
                'challenge' => 'not a structured section',
            ])
            ->assertSessionHasErrors('challenge');
    }

    public function test_super_admin_can_save_structured_sections(): void
    {
        $role = $this->superAdminRole();
        $admin = $this->createAdmin($role, 'boss@smevolve.tech');
        $category = $this->category();

        $this->actingAs($admin, 'admin')
            ->post(route('admin.portfolio.store'), [
                'title' => 'Structured Project',
                'slug' => 'structured-project',
                'portfolio_category_id' => $category->id,
                'status' => 'Delivered 2026',
                'short_description' => 'A project with structured sections.',
                'challenge' => [
                    'heading' => 'The Challenge',
                    'description' => 'A hard problem.',
                    'points' => "Point one\nPoint two",
                ],
                'solution' => [
                    'heading' => 'The Solution',
                    'description' => 'We fixed it.',
                    'points' => "Fix one\nFix two",
                ],
                'outcome' => [
                    'heading' => 'Results',
                    'description' => 'Great results.',
                    'points' => "Result one\nResult two",
                ],
                'features' => [
                    ['icon' => 'chart-bar', 'title' => 'Live stock', 'description' => 'Real time levels.'],
                    ['icon' => '', 'title' => '', 'description' => ''],
                ],
                'gallery' => [
                    ['label' => 'Dashboard', 'type' => 'Overview', 'image' => 'https://example.com/dash.png'],
                ],
                'meta' => [
                    'title' => 'Structured project SEO title',
                    'description' => 'Structured project SEO description',
                ],
            ])
            ->assertRedirect(route('admin.portfolio.index'));

        $project = PortfolioProject::where('slug', 'structured-project')->firstOrFail();

        $this->assertSame('The Challenge', $project->challenge['heading']);
        $this->assertSame(['Point one', 'Point two'], $project->challenge['points']);
        $this->assertSame(['Fix one', 'Fix two'], $project->solution['points']);
        $this->assertSame(['Result one', 'Result two'], $project->outcome['points']);
        $this->assertCount(1, $project->features);
        $this->assertSame('Live stock', $project->features[0]['title']);
        $this->assertCount(1, $project->gallery);
        $this->assertSame('Dashboard', $project->gallery[0]['label']);
        $this->assertSame('Structured project SEO title', $project->meta['title']);
    }

    public function test_blank_sections_are_stored_as_null(): void
    {
        $role = $this->superAdminRole();
        $admin = $this->createAdmin($role, 'boss@smevolve.tech');

        $this->actingAs($admin, 'admin')
            ->post(route('admin.portfolio.store'), [
                'title' => 'Minimal Project',
                'slug' => 'minimal-project',
                'status' => 'Active',
                'short_description' => 'A minimal project.',
                'challenge' => ['heading' => '', 'description' => '', 'points' => ''],
                'features' => [],
                'meta' => ['title' => '', 'description' => ''],
            ])
            ->assertRedirect(route('admin.portfolio.index'));

        $project = PortfolioProject::where('slug', 'minimal-project')->firstOrFail();

        $this->assertNull($project->challenge);
        $this->assertNull($project->features);
        $this->assertNull($project->meta);
    }

    public function test_structured_sections_render_on_public_project_page(): void
    {
        $category = $this->category(['slug' => 'custom-software', 'name' => 'Custom Software']);
        PortfolioProject::factory()->create([
            'slug' => 'public-structured-project',
            'title' => 'Public Structured Project',
            'portfolio_category_id' => $category->id,
            'is_published' => true,
            'challenge' => ['heading' => 'The Challenge', 'description' => 'A hard problem.', 'points' => ['Point one']],
            'meta' => ['title' => 'Structured SEO title', 'description' => 'Structured SEO description'],
        ]);

        $this->get(route('portfolio.show', 'public-structured-project'))
            ->assertOk()
            ->assertSee('The Challenge')
            ->assertSee('Structured SEO title');
    }

    public function test_editor_cannot_publish_projects(): void
    {
        $role = $this->editorRole();
        $admin = $this->createAdmin($role, 'editor@smevolve.tech');
        $project = PortfolioProject::factory()->create();

        $this->actingAs($admin, 'admin')
            ->post(route('admin.portfolio.publish', $project))
            ->assertForbidden();
    }

    public function test_editor_cannot_delete_projects(): void
    {
        $role = $this->editorRole();
        $admin = $this->createAdmin($role, 'editor@smevolve.tech');
        $project = PortfolioProject::factory()->create();

        $this->actingAs($admin, 'admin')
            ->delete(route('admin.portfolio.destroy', $project))
            ->assertForbidden();

        $this->assertDatabaseHas('portfolio_projects', ['id' => $project->id]);
    }

    public function test_support_role_cannot_view_portfolio(): void
    {
        $role = $this->supportRole();
        $admin = $this->createAdmin($role, 'support@smevolve.tech');

        $this->actingAs($admin, 'admin')
            ->get(route('admin.portfolio.index'))
            ->assertForbidden();
    }

    public function test_super_admin_can_manage_categories(): void
    {
        $role = $this->superAdminRole();
        $admin = $this->createAdmin($role, 'boss@smevolve.tech');

        $this->actingAs($admin, 'admin')
            ->post(route('admin.portfolio.categories.store'), [
                'slug' => 'data-systems',
                'name' => 'Data Systems',
                'description' => 'Data and integration projects.',
                'sort_order' => '8',
                'is_published' => '1',
            ])
            ->assertRedirect(route('admin.portfolio.categories.index'));

        $category = PortfolioCategory::where('slug', 'data-systems')->firstOrFail();

        $this->actingAs($admin, 'admin')
            ->put(route('admin.portfolio.categories.update', $category), [
                'slug' => 'data-systems',
                'name' => 'Data & Systems',
                'description' => 'Updated.',
                'sort_order' => '9',
                'is_published' => '1',
            ])
            ->assertRedirect(route('admin.portfolio.categories.index'));

        $this->assertDatabaseHas('portfolio_categories', [
            'id' => $category->id,
            'name' => 'Data & Systems',
        ]);

        $this->actingAs($admin, 'admin')
            ->delete(route('admin.portfolio.categories.destroy', $category))
            ->assertRedirect(route('admin.portfolio.categories.index'));

        $this->assertDatabaseMissing('portfolio_categories', ['id' => $category->id]);
    }

    public function test_super_admin_can_view_create_and_edit_forms(): void
    {
        $role = $this->superAdminRole();
        $admin = $this->createAdmin($role, 'boss@smevolve.tech');
        $category = $this->category();
        $project = PortfolioProject::factory()->create(['portfolio_category_id' => $category->id]);

        $this->actingAs($admin, 'admin')
            ->get(route('admin.portfolio.create'))
            ->assertOk()
            ->assertSee('Add Project');

        $this->actingAs($admin, 'admin')
            ->get(route('admin.portfolio.edit', $project))
            ->assertOk()
            ->assertSee('Edit Project');

        $this->actingAs($admin, 'admin')
            ->get(route('admin.portfolio.categories.create'))
            ->assertOk()
            ->assertSee('Add Category');

        $this->actingAs($admin, 'admin')
            ->get(route('admin.portfolio.categories.edit', $category))
            ->assertOk()
            ->assertSee('Edit Category');
    }

    public function test_published_db_project_appears_on_public_portfolio(): void
    {
        $category = $this->category(['slug' => 'custom-software', 'name' => 'Custom Software']);
        PortfolioProject::factory()->create([
            'slug' => 'real-client-project',
            'title' => 'Real Client Project',
            'portfolio_category_id' => $category->id,
            'is_published' => true,
        ]);

        $this->get(route('portfolio'))
            ->assertOk()
            ->assertSee('Real Client Project');

        $this->get(route('portfolio.show', 'real-client-project'))
            ->assertOk()
            ->assertSee('Real Client Project');
    }
}
