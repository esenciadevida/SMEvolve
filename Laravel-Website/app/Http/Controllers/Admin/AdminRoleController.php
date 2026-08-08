<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RoleStoreRequest;
use App\Http\Requests\Admin\RoleUpdateRequest;
use App\Models\Role;
use App\Services\Admin\AdminAuditService;
use App\Services\Admin\RoleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RuntimeException;

class AdminRoleController extends Controller
{
    public function __construct(
        private readonly RoleService $roleService,
        private readonly AdminAuditService $auditService,
    ) {}

    public function index()
    {
        $this->authorize('admin.roles.view');

        $roles = Role::query()
            ->withCount('administrators')
            ->orderByRaw(
                "CASE WHEN name = 'super_admin' THEN 0
                       WHEN name = 'admin' THEN 1
                       WHEN name = 'editor' THEN 2
                       WHEN name = 'support' THEN 3
                       ELSE 4 END, id"
            )
            ->get();

        return view('admin.roles.index', [
            'roles' => $roles,
            'permissionGroups' => $this->permissionGroups(),
            'coreRoles' => RoleService::CORE_ROLES,
            'canManage' => Auth::guard('admin')->user()->hasPermission('administrators.update'),
        ]);
    }

    public function create()
    {
        $this->authorize('admin.roles.create');

        return view('admin.roles.create', [
            'permissionGroups' => $this->permissionGroups(),
        ]);
    }

    public function store(RoleStoreRequest $request)
    {
        $this->authorize('admin.roles.create');

        $actor = Auth::guard('admin')->user();

        try {
            $role = $this->roleService->create($request->validated(), $actor);
        } catch (RuntimeException $e) {
            return back()->withErrors(['role' => $e->getMessage()])->withInput();
        }

        $this->auditService->log(
            'roles.create',
            'roles',
            (string) $role->id,
            oldValue: null,
            newValue: ['name' => $role->name, 'label' => $role->label, 'permissions' => $role->permissions],
            actor: $actor,
            request: $request,
        );

        return redirect()->route('admin.roles.edit', $role)
            ->with('status', 'Role created successfully.');
    }

    public function edit(Role $role)
    {
        $this->authorize('admin.roles.update');

        return view('admin.roles.edit', [
            'role' => $role,
            'permissionGroups' => $this->permissionGroups(),
            'isCoreRole' => in_array($role->name, RoleService::CORE_ROLES, true),
        ]);
    }

    public function update(RoleUpdateRequest $request, Role $role)
    {
        $this->authorize('admin.roles.update');

        $actor = Auth::guard('admin')->user();
        $old = ['label' => $role->label, 'description' => $role->description, 'permissions' => $role->permissions];

        try {
            $this->roleService->update($role, $request->validated(), $actor);
        } catch (RuntimeException $e) {
            return back()->withErrors(['role' => $e->getMessage()])->withInput();
        }

        $this->auditService->log(
            'roles.update',
            'roles',
            (string) $role->id,
            oldValue: $old,
            newValue: ['label' => $role->label, 'description' => $role->description, 'permissions' => $role->permissions],
            actor: $actor,
            request: $request,
        );

        return redirect()->route('admin.roles.edit', $role)
            ->with('status', 'Role updated successfully.');
    }

    public function destroy(Request $request, Role $role)
    {
        $this->authorize('admin.roles.delete');

        $actor = Auth::guard('admin')->user();

        try {
            $this->roleService->destroy($role, $actor);
        } catch (RuntimeException $e) {
            return back()->withErrors(['role' => $e->getMessage()]);
        }

        $this->auditService->log(
            'roles.delete',
            'roles',
            (string) $role->id,
            oldValue: ['name' => $role->name, 'label' => $role->label],
            newValue: null,
            actor: $actor,
            request: $request,
        );

        return redirect()->route('admin.roles.index')
            ->with('status', 'Role deleted.');
    }

    /**
     * Build the ordered permission groups with their documented metadata for
     * the permission editor and role index screens.
     *
     * @return array<string, list<array{key: string, label: string, description: string, risk: string}>>
     */
    private function permissionGroups(): array
    {
        $groups = config('admin.permission_groups', []);
        $definitions = config('admin_permissions', []);
        $result = [];

        foreach ($groups as $groupLabel => $permissions) {
            foreach ($permissions as $permission) {
                $result[$groupLabel][] = [
                    'key' => $permission,
                    'label' => $definitions[$permission]['label'] ?? $permission,
                    'description' => $definitions[$permission]['description'] ?? '',
                    'risk' => $definitions[$permission]['risk'] ?? 'low',
                ];
            }
        }

        return $result;
    }
}
