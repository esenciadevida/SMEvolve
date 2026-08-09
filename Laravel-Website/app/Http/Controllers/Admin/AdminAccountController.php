<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminPasswordRequest;
use App\Http\Requests\Admin\AdminProfileRequest;
use App\Services\Admin\AdminAuditService;
use App\Services\Admin\AdminNotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAccountController extends Controller
{
    public function __construct(
        private readonly AdminAuditService $auditService,
        private readonly AdminNotificationService $notifications,
    ) {}

    public function profile(Request $request)
    {
        return view('admin.account.profile', [
            'administrator' => Auth::guard('admin')->user(),
        ]);
    }

    public function updateProfile(AdminProfileRequest $request)
    {
        $this->authorize('admin.profile.update');

        $administrator = Auth::guard('admin')->user();

        $administrator->update($request->only('name', 'email'));

        $this->auditService->log(
            'profile.update',
            'administrators',
            (string) $administrator->id,
            actor: $administrator,
            request: $request,
        );

        return redirect()->route('admin.profile.index')->with('status', 'Profile updated successfully.');
    }

    public function security(Request $request)
    {
        $administrator = Auth::guard('admin')->user();

        return view('admin.account.security', [
            'administrator' => $administrator,
            'recentSignIns' => $this->auditService->recentForAdministrator($administrator, 10),
            'failedAttempts' => $request->ip() !== null
                ? $this->auditService->failedLoginCountForIp($request->ip(), 60)
                : 0,
        ]);
    }

    public function updatePassword(AdminPasswordRequest $request)
    {
        $this->authorize('admin.security.password');

        $administrator = Auth::guard('admin')->user();

        $administrator->update([
            'password' => $request->validated('password'),
        ]);

        Auth::guard('admin')->logoutOtherDevices($request->validated('password'));

        $this->auditService->log(
            'security.password_change',
            'administrators',
            (string) $administrator->id,
            actor: $administrator,
            request: $request,
        );

        $this->notifications->notify(
            'security.password_changed',
            'Administrator password changed',
            ['The password for your SMEvolve administrator account was changed.'],
            recipients: [$administrator],
            details: [
                ['label' => 'IP address', 'value' => (string) ($request->ip() ?? 'unknown')],
                ['label' => 'Time', 'value' => now()->toDateTimeString()],
            ],
            actionUrl: route('admin.security.index'),
            actionText: 'Review account security',
        );

        return redirect()->route('admin.security.index')->with('status', 'Password changed successfully.');
    }
}
