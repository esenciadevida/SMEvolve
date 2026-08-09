<?php

namespace Tests\Feature\Admin;

use App\Mail\SecurityAlert;
use App\Models\Administrator;
use App\Models\AdminNotification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;

class AdminPasswordResetTest extends AdminTestCase
{
    private function createTargetAdmin(): Administrator
    {
        return $this->createAdmin($this->superAdminRole(), 'target@smevolve.tech');
    }

    public function test_super_admin_can_send_password_reset_link(): void
    {
        Mail::fake();

        $actor = $this->createAdmin($this->superAdminRole(), 'boss@smevolve.tech');
        $target = $this->createTargetAdmin();

        $this->actingAs($actor, 'admin')
            ->post(route('admin.administrators.password-reset', $target))
            ->assertRedirect()
            ->assertSessionHas('status', "Password reset link sent to {$target->email}.");

        $this->assertDatabaseHas('admin_password_reset_tokens', [
            'email' => $target->email,
        ]);

        $this->assertDatabaseHas('admin_audit_logs', [
            'administrator_id' => $actor->id,
            'action' => 'security.password_reset_requested',
            'resource_type' => 'administrators',
            'resource_id' => (string) $target->id,
        ]);

        $this->assertDatabaseHas('admin_notifications', [
            'administrator_id' => $target->id,
            'event' => 'security.password_reset',
        ]);

        Mail::assertSent(SecurityAlert::class, fn (SecurityAlert $mail) => $mail->hasTo($target->email));
    }

    public function test_administrator_without_update_permission_cannot_send_reset_link(): void
    {
        $actor = $this->createAdmin($this->editorRole(), 'editor@smevolve.tech');
        $target = $this->createTargetAdmin();

        $this->actingAs($actor, 'admin')
            ->post(route('admin.administrators.password-reset', $target))
            ->assertForbidden();

        $this->assertDatabaseMissing('admin_password_reset_tokens', [
            'email' => $target->email,
        ]);
    }

    public function test_reset_form_is_public_and_prefilled_with_email(): void
    {
        $target = $this->createTargetAdmin();

        $this->get(route('admin.password.reset.show', ['token' => 'abc123', 'email' => $target->email]))
            ->assertOk()
            ->assertSee('Reset your password')
            ->assertSee($target->email, false);
    }

    public function test_admin_can_reset_password_with_valid_token(): void
    {
        $target = $this->createTargetAdmin();
        $token = Password::broker('admins')->createToken($target);

        $this->from(route('admin.password.reset.show', ['token' => $token, 'email' => $target->email]))
            ->post(route('admin.password.reset.store'), [
                'token' => $token,
                'email' => $target->email,
                'password' => 'new-secret-password',
                'password_confirmation' => 'new-secret-password',
            ])
            ->assertRedirect(route('admin.login'))
            ->assertSessionHas('status');

        $this->assertTrue(Hash::check('new-secret-password', $target->fresh()->getAuthPassword()));

        $this->assertDatabaseHas('admin_audit_logs', [
            'administrator_id' => $target->id,
            'action' => 'security.password_reset',
            'resource_type' => 'administrators',
            'resource_id' => (string) $target->id,
        ]);

        $this->assertDatabaseHas('admin_notifications', [
            'administrator_id' => $target->id,
            'event' => 'security.password_reset',
            'subject' => 'Administrator password reset',
        ]);

        $this->assertDatabaseMissing('admin_password_reset_tokens', [
            'email' => $target->email,
        ]);
    }

    public function test_reset_rejects_invalid_token(): void
    {
        $target = $this->createTargetAdmin();

        $this->from(route('admin.password.reset.show', ['token' => 'invalid', 'email' => $target->email]))
            ->post(route('admin.password.reset.store'), [
                'token' => 'invalid',
                'email' => $target->email,
                'password' => 'new-secret-password',
                'password_confirmation' => 'new-secret-password',
            ])
            ->assertRedirect()
            ->assertSessionHasErrors('email');

        $this->assertTrue(Hash::check('password', $target->fresh()->getAuthPassword()));
        $this->assertSame(0, AdminNotification::where('event', 'security.password_reset')->count());
    }

    public function test_reset_requires_matching_confirmation(): void
    {
        $target = $this->createTargetAdmin();
        $token = Password::broker('admins')->createToken($target);

        $this->post(route('admin.password.reset.store'), [
            'token' => $token,
            'email' => $target->email,
            'password' => 'new-secret-password',
            'password_confirmation' => 'does-not-match',
        ])->assertSessionHasErrors('password');

        $this->assertTrue(Hash::check('password', $target->fresh()->getAuthPassword()));
    }

    public function test_disabled_administrator_can_still_reset_password(): void
    {
        $target = $this->createAdmin($this->superAdminRole(), 'disabled@smevolve.tech', false);
        $token = Password::broker('admins')->createToken($target);

        $this->post(route('admin.password.reset.store'), [
            'token' => $token,
            'email' => $target->email,
            'password' => 'new-secret-password',
            'password_confirmation' => 'new-secret-password',
        ])->assertRedirect(route('admin.login'));

        $this->assertTrue(Hash::check('new-secret-password', $target->fresh()->getAuthPassword()));
    }
}
