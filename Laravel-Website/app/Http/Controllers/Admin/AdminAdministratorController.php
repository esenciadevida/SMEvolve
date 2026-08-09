<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdministratorStoreRequest;
use App\Http\Requests\Admin\AdministratorUpdateRequest;
use App\Models\Administrator;
use App\Models\Role;
use App\Services\Admin\AdminAuditService;
use App\Services\Admin\AdministratorService;
use App\Services\Admin\AdminNotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use RuntimeException;

class AdminAdministratorController extends Controller
{
    public function __construct(
        private readonly AdministratorService $administratorService,
        private readonly AdminAuditService $auditService,
        private readonly AdminNotificationService $notifications,
    ) {}

    public function index(Request $request)
    {
        $this->authorize('admin.administrators.view');

        $administrators = Administrator::query()
            ->with('role:id,name,label')
            ->when($request->string('q')->trim()->value(), function ($query, $term) {
                $query->where(function ($q) use ($term) {
                    $q->where('name', 'like', "%{$term}%")
                        ->orWhere('email', 'like', "%{$term}%");
                });
            })
            ->when($request->string('status')->trim()->value(), fn ($query, $status) => $query->where('is_active', $status === 'active'))
            ->orderBy('id')
            ->paginate(25)
            ->withQueryString();

        return view('admin.administrators.index', [
            'administrators' => $administrators,
            'roles' => Role::orderBy('id')->get(['id', 'name', 'label']),
        ]);
    }

    public function create()
    {
        $this->authorize('admin.administrators.create');

        return view('admin.administrators.create', [
            'roles' => Role::orderBy('id')->get(['id', 'name', 'label']),
        ]);
    }

    public function store(AdministratorStoreRequest $request)
    {
        $this->authorize('admin.administrators.create');

        $administrator = $this->administratorService->create($request->validated());
        $actor = Auth::guard('admin')->user();

        $this->auditService->log(
            'administrators.create',
            'administrators',
            (string) $administrator->id,
            oldValue: null,
            newValue: ['name' => $administrator->name, 'email' => $administrator->email, 'role_id' => $administrator->role_id],
            actor: $actor,
            request: $request,
        );

        $this->notifications->notify(
            'administrators.created',
            'New administrator account created',
            ['A new administrator account was created on the SMEvolve Admin Portal.'],
            details: [
                ['label' => 'Name', 'value' => $administrator->name],
                ['label' => 'Email', 'value' => $administrator->email],
                ['label' => 'Role', 'value' => $administrator->role?->label ?? '—'],
                ['label' => 'Created by', 'value' => (string) ($actor->name ?? 'unknown')],
                ['label' => 'Time', 'value' => now()->toDateTimeString()],
            ],
            actionUrl: route('admin.administrators.show', $administrator),
            actionText: 'View the new account',
        );

        return redirect()->route('admin.administrators.show', $administrator)
            ->with('status', 'Administrator created successfully.');
    }

    public function show(Request $request, Administrator $administrator)
    {
        $this->authorize('admin.administrators.view');

        $administrator->load('role');

        return view('admin.administrators.show', [
            'administrator' => $administrator,
            'roles' => Role::orderBy('id')->get(['id', 'name', 'label']),
            'canChangeRole' => Auth::guard('admin')->user()->hasPermission('administrators.change_role'),
            'canDisable' => Auth::guard('admin')->user()->hasPermission('administrators.disable'),
            'canUpdate' => Auth::guard('admin')->user()->hasPermission('administrators.update'),
        ]);
    }

    public function edit(Request $request, Administrator $administrator)
    {
        $this->authorize('admin.administrators.update');

        return view('admin.administrators.edit', [
            'administrator' => $administrator,
            'roles' => Role::orderBy('id')->get(['id', 'name', 'label']),
            'canChangeRole' => Auth::guard('admin')->user()->hasPermission('administrators.change_role'),
        ]);
    }

    public function update(AdministratorUpdateRequest $request, Administrator $administrator)
    {
        $this->authorize('admin.administrators.update');

        $actor = Auth::guard('admin')->user();
        $roleChanged = (int) $administrator->role_id !== (int) $request->validated('role_id');

        if ($roleChanged) {
            $this->authorize('admin.administrators.changeRole');
        }

        $old = ['name' => $administrator->name, 'email' => $administrator->email, 'role_id' => $administrator->role_id];

        try {
            $this->administratorService->update($administrator, $request->validated(), $actor);
        } catch (RuntimeException $e) {
            return back()->withErrors(['role_id' => $e->getMessage()])->withInput();
        }

        $this->auditService->log(
            'administrators.update',
            'administrators',
            (string) $administrator->id,
            oldValue: $old,
            newValue: ['name' => $administrator->name, 'email' => $administrator->email, 'role_id' => $administrator->role_id],
            actor: $actor,
            request: $request,
        );

        if ($roleChanged) {
            $this->notifications->notify(
                'administrators.role_changed',
                'Administrator role changed',
                ['The role of an administrator account was changed.'],
                details: [
                    ['label' => 'Account', 'value' => $administrator->name.' <'.$administrator->email.'>'],
                    ['label' => 'New role', 'value' => $administrator->role?->label ?? '—'],
                    ['label' => 'Changed by', 'value' => (string) ($actor->name ?? 'unknown')],
                    ['label' => 'Time', 'value' => now()->toDateTimeString()],
                ],
                actionUrl: route('admin.administrators.show', $administrator),
                actionText: 'View the account',
            );
        }

        return redirect()->route('admin.administrators.show', $administrator)
            ->with('status', 'Administrator updated successfully.');
    }

    public function disable(Request $request, Administrator $administrator)
    {
        $this->authorize('admin.administrators.disable');

        $actor = Auth::guard('admin')->user();

        try {
            $this->administratorService->disable($administrator, $actor);
        } catch (RuntimeException $e) {
            return back()->withErrors(['administrator' => $e->getMessage()]);
        }

        $this->auditService->log(
            'administrators.disable',
            'administrators',
            (string) $administrator->id,
            oldValue: true,
            newValue: false,
            actor: $actor,
            request: $request,
        );

        $this->notifications->notify(
            'administrators.disabled',
            'Administrator account disabled',
            ['An administrator account was disabled on the SMEvolve Admin Portal.'],
            details: [
                ['label' => 'Account', 'value' => $administrator->name.' <'.$administrator->email.'>'],
                ['label' => 'Disabled by', 'value' => (string) ($actor->name ?? 'unknown')],
                ['label' => 'Time', 'value' => now()->toDateTimeString()],
            ],
            actionUrl: route('admin.administrators.show', $administrator),
            actionText: 'View the account',
        );

        return back()->with('status', 'Administrator disabled.');
    }

    public function enable(Request $request, Administrator $administrator)
    {
        $this->authorize('admin.administrators.disable');

        $actor = Auth::guard('admin')->user();

        $this->administratorService->enable($administrator);

        $this->auditService->log(
            'administrators.enable',
            'administrators',
            (string) $administrator->id,
            oldValue: false,
            newValue: true,
            actor: $actor,
            request: $request,
        );

        $this->notifications->notify(
            'administrators.disabled',
            'Administrator account reactivated',
            ['A disabled administrator account was reactivated on the SMEvolve Admin Portal.'],
            details: [
                ['label' => 'Account', 'value' => $administrator->name.' <'.$administrator->email.'>'],
                ['label' => 'Enabled by', 'value' => (string) ($actor->name ?? 'unknown')],
                ['label' => 'Time', 'value' => now()->toDateTimeString()],
            ],
            actionUrl: route('admin.administrators.show', $administrator),
            actionText: 'View the account',
        );

        return back()->with('status', 'Administrator enabled.');
    }

    /**
     * Trigger a secure password reset for an administrator. The reset link is
     * emailed to the target account; no password is ever set or transmitted by
     * the requesting administrator.
     */
    public function sendPasswordReset(Request $request, Administrator $administrator)
    {
        $this->authorize('admin.administrators.update');

        $actor = Auth::guard('admin')->user();
        $token = Password::broker('admins')->createToken($administrator);
        $resetUrl = route('admin.password.reset.show', [
            'token' => $token,
            'email' => $administrator->email,
        ]);

        $this->auditService->log(
            'security.password_reset_requested',
            'administrators',
            (string) $administrator->id,
            actor: $actor,
            request: $request,
        );

        $this->notifications->notify(
            'security.password_reset',
            'Administrator password reset requested',
            ['A password reset link was requested for your SMEvolve administrator account.'],
            recipients: [$administrator],
            details: [
                ['label' => 'Account', 'value' => $administrator->name.' <'.$administrator->email.'>'],
                ['label' => 'Requested by', 'value' => (string) ($actor->name ?? 'unknown')],
                ['label' => 'Link expires', 'value' => now()->addMinutes((int) config('auth.passwords.admins.expire', 60))->toDateTimeString()],
                ['label' => 'Time', 'value' => now()->toDateTimeString()],
            ],
            actionUrl: $resetUrl,
            actionText: 'Reset your password',
        );

        return back()->with('status', 'Password reset link sent to '.$administrator->email.'.');
    }
}
