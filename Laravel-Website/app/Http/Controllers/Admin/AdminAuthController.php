<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminLoginRequest;
use App\Services\Admin\AdminAuditService;
use App\Services\Admin\AdminNotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function __construct(
        private readonly AdminAuditService $auditService,
        private readonly AdminNotificationService $notifications,
    ) {}

    public function showLogin(Request $request)
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.login');
    }

    public function login(AdminLoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        $remember = (bool) $request->boolean('remember');

        if (! Auth::guard('admin')->attempt($credentials, $remember)) {
            $this->auditService->logFailedLogin(
                $request,
                (string) $request->validated('email'),
                'invalid credentials',
            );

            $this->notifications->notify(
                'security.login_failed',
                'Failed administrator login attempt',
                ['A failed administrator login attempt was detected on the SMEvolve Admin Portal.'],
                details: [
                    ['label' => 'Email', 'value' => (string) $request->validated('email')],
                    ['label' => 'IP address', 'value' => (string) ($request->ip() ?? 'unknown')],
                    ['label' => 'Time', 'value' => now()->toDateTimeString()],
                ],
                actionUrl: route('admin.audit.index'),
                actionText: 'Review the audit log',
            );

            return back()
                ->withErrors(['email' => 'The provided credentials are incorrect.'])
                ->withInput($request->only('email'));
        }

        $administrator = Auth::guard('admin')->user();

        if (! $administrator->is_active) {
            Auth::guard('admin')->logout();
            $request->session()->regenerate();

            $this->auditService->logFailedLogin(
                $request,
                (string) $request->validated('email'),
                'account disabled',
            );

            return back()
                ->withErrors(['email' => 'The provided credentials are incorrect.'])
                ->withInput($request->only('email'));
        }

        $request->session()->regenerate();
        $request->session()->put('admin_last_activity', now()->timestamp);
        $administrator->recordLogin($request->ip() ?? 'unknown');

        $this->auditService->log(
            'admin.login',
            'administrators',
            (string) $administrator->id,
            actor: $administrator,
            request: $request,
        );

        $this->notifications->notify(
            'security.login_success',
            'New administrator login',
            ['A new login was detected on your SMEvolve administrator account.'],
            recipients: [$administrator],
            details: [
                ['label' => 'Email', 'value' => $administrator->email],
                ['label' => 'IP address', 'value' => (string) ($request->ip() ?? 'unknown')],
                ['label' => 'Browser', 'value' => (string) $request->userAgent()],
                ['label' => 'Time', 'value' => now()->toDateTimeString()],
            ],
            actionUrl: route('admin.security.index'),
            actionText: 'Review account security',
        );

        return redirect()->intended(route('admin.dashboard'));
    }

    public function logout(Request $request)
    {
        $administrator = Auth::guard('admin')->user();

        if ($administrator !== null) {
            $this->auditService->log(
                'admin.logout',
                'administrators',
                (string) $administrator->id,
                actor: $administrator,
                request: $request,
            );
        }

        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
