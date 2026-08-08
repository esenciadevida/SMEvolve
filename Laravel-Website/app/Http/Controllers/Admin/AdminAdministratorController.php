<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdministratorStoreRequest;
use App\Http\Requests\Admin\AdministratorUpdateRequest;
use App\Models\Administrator;
use App\Models\Role;
use App\Services\Admin\AdminAuditService;
use App\Services\Admin\AdministratorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RuntimeException;

class AdminAdministratorController extends Controller
{
    public function __construct(
        private readonly AdministratorService $administratorService,
        private readonly AdminAuditService $auditService,
    ) {
    }

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

        return back()->with('status', 'Administrator enabled.');
    }
}
