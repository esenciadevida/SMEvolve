<?php

namespace Tests\Feature;

use App\Mail\NewContactMessage;
use App\Models\ContactMessage;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ContactPageTest extends TestCase
{
    private function validPayload(array $overrides = []): array
    {
        return array_merge([
            'name' => 'Jane Doe',
            'company' => 'Acme Ltd',
            'email' => 'jane@example.com',
            'phone' => '+2348000000000',
            'contact_method' => 'email',
            'subject' => 'general_enquiry',
            'budget' => '500k_1m',
            'message' => 'I would like to know more about building a website for my business.',
            'consent' => '1',
            'website' => '',
            'contact_token' => (string) session('contact_token', ''),
        ], $overrides);
    }

    private function visitContactForm(): self
    {
        $this->get(route('contact'))->assertOk();

        return $this;
    }

    public function test_contact_page_renders(): void
    {
        $this->get(route('contact'))
            ->assertOk()
            ->assertSee('Send Us a Message');
    }

    public function test_valid_enquiry_is_stored_and_notifies_admins(): void
    {
        Mail::fake();

        $this->visitContactForm()->post(route('contact'), $this->validPayload())
            ->assertRedirect(route('contact'))
            ->assertSessionHas('contact_success');

        $this->assertDatabaseHas('contact_messages', [
            'name' => 'Jane Doe',
            'company' => 'Acme Ltd',
            'email' => 'jane@example.com',
            'phone' => '+2348000000000',
            'contact_method' => 'email',
            'subject' => 'general_enquiry',
            'budget' => '500k_1m',
            'is_read' => false,
        ]);

        $message = ContactMessage::where('email', 'jane@example.com')->firstOrFail();

        $this->assertSame('I would like to know more about building a website for my business.', $message->message);

        $this->assertDatabaseHas('admin_notifications', [
            'event' => 'business.contact_message',
            'subject' => 'New contact message',
        ]);

        Mail::assertSent(NewContactMessage::class, fn (NewContactMessage $mail) => $mail->enquiry->is($message));
    }

    public function test_invalid_token_rejects_submission(): void
    {
        $this->get(route('contact'))->assertOk();

        $this->post(route('contact'), $this->validPayload([
            'contact_token' => 'not-the-session-token',
        ]))
            ->assertRedirect()
            ->assertSessionHasErrors('contact_token');

        $this->assertDatabaseCount('contact_messages', 0);
    }

    public function test_honeypot_field_rejects_submission(): void
    {
        Mail::fake();

        $this->visitContactForm()->post(route('contact'), $this->validPayload([
            'website' => 'https://spam.example.com',
        ]))->assertSessionHasErrors('website');

        $this->assertDatabaseCount('contact_messages', 0);
    }

    public function test_contact_method_and_subject_must_be_valid_options(): void
    {
        $this->visitContactForm()->post(route('contact'), $this->validPayload([
            'contact_method' => 'not_a_method',
            'subject' => 'not_a_subject',
        ]))->assertSessionHasErrors(['contact_method', 'subject']);
    }

    public function test_consent_is_required(): void
    {
        $this->visitContactForm()->post(route('contact'), $this->validPayload([
            'consent' => null,
        ]))->assertSessionHasErrors('consent');

        $this->assertDatabaseCount('contact_messages', 0);
    }
}
