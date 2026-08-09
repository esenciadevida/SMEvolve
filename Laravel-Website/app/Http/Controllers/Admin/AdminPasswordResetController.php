<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminPasswordResetRequest;
use App\Models\Administrator;
use App\Services\Admin\AdminAuditService;
use App\Services\Admin\AdminNotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class AdminPasswordResetController extends Controller
{
    public function __construct(
        private readonly AdminAuditService $auditService,
        private readonly AdminNotificationService $notifications,
    ) {}

    public function showResetForm(Request $request, string $token)
    {
        return view('admin.auth.reset-password', [
            'token' => $token,
            'email' => $request->string('email')->toString(),
        ]);
    }

    public function store(AdminPasswordResetRequest $request)
    {
        $status = Password::broker('admins')->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (Administrator $administrator, string $password) use ($request): void {
                $administrator->update(['password' => $password]);

                $this->auditService->log(
                    'security.password_reset',
                    'administrators',
                    (string) $administrator->id,
                    actor: $administrator,
                    request: $request,
                );

                $this->notifications->notify(
                    'security.password_reset',
                    'Administrator password reset',
                    ['The password for your SMEvolve administrator account was reset successfully.'],
                    recipients: [$administrator],
                    details: [
                        ['label' => 'IP address', 'value' => (string) ($request->ip() ?? 'unknown')],
                        ['label' => 'Time', 'value' => now()->toDateTimeString()],
                    ],
                    actionUrl: route('admin.login'),
                    actionText: 'Sign in',
                );
            }
        );

        return match ($status) {
            Password::PASSWORD_RESET => redirect()->route('admin.login')->with('status', __('passwords.reset')),
            Password::INVALID_USER => back()->withErrors(['email' => __('passwords.user')]),
            default => back()->withErrors(['email' => __('passwords.token')]),
        };
    }
}
