<?php

namespace Tests\Feature\Admin;

use App\Models\ContactMessage;

class AdminContactTest extends AdminTestCase
{
    private function createMessage(string $email = 'jane@example.com', bool $read = false): ContactMessage
    {
        return ContactMessage::create([
            'name' => 'Jane Doe',
            'company' => 'Acme Ltd',
            'email' => $email,
            'phone' => '+2348000000000',
            'contact_method' => 'email',
            'subject' => 'general_enquiry',
            'budget' => '500k_1m',
            'message' => 'I would like to know more about building a website for my business.',
            'is_read' => $read,
            'read_at' => $read ? now() : null,
        ]);
    }

    public function test_super_admin_can_list_messages(): void
    {
        $role = $this->superAdminRole();
        $admin = $this->createAdmin($role);
        $this->createMessage();

        $this->actingAs($admin, 'admin')
            ->get(route('admin.contact.index'))
            ->assertOk()
            ->assertSee('Jane Doe')
            ->assertSee('Unread');
    }

    public function test_super_admin_can_filter_unread_messages(): void
    {
        $role = $this->superAdminRole();
        $admin = $this->createAdmin($role);
        $this->createMessage('read@example.net', read: true);
        $this->createMessage('unread@example.com');

        $this->actingAs($admin, 'admin')
            ->get(route('admin.contact.index', ['status' => 'unread']))
            ->assertOk()
            ->assertSee('unread@example.com')
            ->assertDontSee('read@example.net');
    }

    public function test_viewing_message_marks_it_as_read(): void
    {
        $role = $this->superAdminRole();
        $admin = $this->createAdmin($role);
        $message = $this->createMessage();

        $this->actingAs($admin, 'admin')
            ->get(route('admin.contact.show', $message))
            ->assertOk()
            ->assertSee($message->message);

        $this->assertDatabaseHas('contact_messages', [
            'id' => $message->id,
            'is_read' => true,
        ]);
    }

    public function test_editor_role_cannot_view_messages(): void
    {
        $role = $this->editorRole();
        $admin = $this->createAdmin($role);
        $message = $this->createMessage();

        $this->actingAs($admin, 'admin')
            ->get(route('admin.contact.index'))
            ->assertForbidden();

        $this->actingAs($admin, 'admin')
            ->get(route('admin.contact.show', $message))
            ->assertForbidden();
    }

    public function test_support_role_can_view_messages(): void
    {
        $role = $this->supportRole();
        $admin = $this->createAdmin($role);
        $message = $this->createMessage();

        $this->actingAs($admin, 'admin')
            ->get(route('admin.contact.index'))
            ->assertOk()
            ->assertSee('Jane Doe');

        $this->actingAs($admin, 'admin')
            ->get(route('admin.contact.show', $message))
            ->assertOk();
    }
}
