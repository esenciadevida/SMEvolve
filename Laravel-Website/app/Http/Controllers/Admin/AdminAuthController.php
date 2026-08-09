<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminLoginRequest;
use App\Services\Admin\AdminAuditService;
use App\Services\Admin\AdminNotificationService;
use App\Services\Security\RequestMetaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function __construct(
        private readonly AdminAuditService $auditService,
        private readonly AdminNotificationService $notifications,
        private readonly RequestMetaService $meta,
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

            $this->sendFailedLoginAlert($request, (string) $request->validated('email'));

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

            $this->sendFailedLoginAlert($request, (string) $request->validated('email'));

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
            details: $this->securityDetails($request, [
                ['label' => 'Administrator', 'value' => $administrator->email],
                ['label' => 'Action', 'value' => 'Successful login'],
            ]),
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

    /**
     * Send a failed-login alert, debounced per event so repeated attacks do
     * not flood the mailbox. Every attempt is still audit-logged regardless.
     */
    private function sendFailedLoginAlert(Request $request, string $email): void
    {
        if ($this->notifications->hasRecent('security.login_failed', 15)) {
            return;
        }

        $this->notifications->notify(
            'security.login_failed',
            'Failed administrator login attempt',
            ['A failed administrator login attempt was detected on the SMEvolve Admin Portal.'],
            details: $this->securityDetails($request, [
                ['label' => 'Email', 'value' => $email],
                ['label' => 'Action', 'value' => 'Failed login'],
            ]),
            actionUrl: route('admin.audit.index'),
            actionText: 'Review the audit log',
        );
    }

    /**
     * Standard security-context rows for administrator security emails.
     * Location is only resolved when geolocation is enabled; otherwise it is
     * reported as "Not determined" and never blocks the notification.
     *
     * @param  array<int, array{label: string, value: string}>  $extra
     * @return array<int, array{label: string, value: string}>
     */
    private function securityDetails(Request $request, array $extra = []): array
    {
        $meta = $this->meta->capture($request);

        return [
            ...$extra,
            ['label' => 'Date', 'value' => now()->toDateString()],
            ['label' => 'Time', 'value' => now()->toDateTimeString()],
            ['label' => 'IP address', 'value' => (string) ($request->ip() ?? 'unknown')],
            ['label' => 'Device', 'value' => ucfirst((string) ($meta['device_type'] ?? 'Not determined'))],
            ['label' => 'Browser', 'value' => (string) ($meta['browser'] ?? 'Not determined')],
            ['label' => 'Operating System', 'value' => (string) ($meta['os'] ?? 'Not determined')],
            ['label' => 'Location', 'value' => (string) ($meta['location'] ?? 'Not determined')],
        ];
    }
}
