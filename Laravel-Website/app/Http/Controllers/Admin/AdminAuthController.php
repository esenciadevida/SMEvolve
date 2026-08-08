<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminLoginRequest;
use App\Services\Admin\AdminAuditService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function __construct(private readonly AdminAuditService $auditService) {}

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
            return back()
                ->withErrors(['email' => 'The provided credentials are incorrect.'])
                ->withInput($request->only('email'));
        }

        $administrator = Auth::guard('admin')->user();

        if (! $administrator->is_active) {
            Auth::guard('admin')->logout();
            $request->session()->regenerate();

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
