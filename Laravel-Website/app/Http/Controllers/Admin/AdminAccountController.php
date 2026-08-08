<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminPasswordRequest;
use App\Http\Requests\Admin\AdminProfileRequest;
use App\Services\Admin\AdminAuditService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAccountController extends Controller
{
    public function __construct(private readonly AdminAuditService $auditService)
    {
    }

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
        return view('admin.account.security');
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

        return redirect()->route('admin.security.index')->with('status', 'Password changed successfully.');
    }
}
