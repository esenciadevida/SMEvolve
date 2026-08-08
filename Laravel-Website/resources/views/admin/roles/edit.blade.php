<x-layouts.admin-portal :title="'Edit '.$role->label">
    <div class="mb-6">
        <a href="{{ route('admin.roles.index') }}" class="text-xs text-primary-600 hover:underline">← Back to roles</a>
        <h1 class="mt-1 text-xl font-semibold">Edit Role</h1>
        <p class="mt-1 flex flex-wrap items-center gap-2 text-sm text-slate-500 dark:text-slate-400">
            {{ $role->label }}
            @if ($isCoreRole)
                <x-admin.badge tone="info">Core role</x-admin.badge>
            @endif
        </p>
    </div>

    <form method="POST" action="{{ route('admin.roles.update', $role) }}" class="max-w-4xl space-y-6">
        @csrf
        @method('PUT')

        <div class="space-y-4 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <div>
                <label for="label" class="block text-sm font-medium">Display name</label>
                <input
                    type="text"
                    id="label"
                    name="label"
                    value="{{ old('label', $role->label) }}"
                    required
                    class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/30 dark:border-slate-700 dark:bg-slate-800"
                >
            </div>

            <div>
                <label for="description" class="block text-sm font-medium">Description</label>
                <textarea
                    id="description"
                    name="description"
                    rows="2"
                    placeholder="What is this role responsible for?"
                    class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/30 dark:border-slate-700 dark:bg-slate-800"
                >{{ old('description', $role->description) }}</textarea>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <h2 class="text-sm font-semibold text-slate-900 dark:text-slate-100">Permissions</h2>
            <p class="mt-1 mb-4 text-xs text-slate-500 dark:text-slate-400">
                Grant only the access this role needs. You can only grant permissions you hold yourself.
            </p>

            @if ($role->name === 'super_admin')
                <div class="mb-4 flex items-start gap-3 rounded-xl border border-warning-500/30 bg-warning-500/10 px-4 py-3 text-sm text-warning-700 dark:text-warning-500">
                    <x-icon name="exclamation-triangle" class="mt-0.5 h-5 w-5 shrink-0" />
                    <p>
                        The Super Admin role must always keep the
                        <strong>{{ config('admin_permissions')['dashboard.view']['label'] ?? 'View Dashboard' }}</strong>
                        and
                        <strong>{{ config('admin_permissions')['administrators.view']['label'] ?? 'View Administrators' }}</strong>
                        permissions so the final super administrator is never locked out.
                    </p>
                </div>
            @endif

            @include('admin.roles._permission_editor', [
                'permissionGroups' => $permissionGroups,
                'selected' => old('permissions', $role->permissions ?? []),
            ])
        </div>

        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('admin.roles.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm hover:bg-slate-50 dark:border-slate-700 dark:hover:bg-slate-800">Cancel</a>
            <button type="submit" class="rounded-lg bg-primary-600 px-4 py-2 text-sm font-semibold text-white hover:bg-primary-700">
                Save changes
            </button>
        </div>
    </form>

    @if (! $isCoreRole)
        <div class="mt-8 max-w-4xl rounded-2xl border border-error-500/30 bg-white p-6 shadow-sm dark:bg-slate-900">
            <h2 class="text-sm font-semibold text-error-600 dark:text-error-400">Danger zone</h2>
            <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                Deleting a role cannot be undone. A role with administrator accounts assigned to it cannot be deleted.
            </p>
            <form method="POST" action="{{ route('admin.roles.destroy', $role) }}" onsubmit="return confirm('Delete the role &quot;{{ $role->label }}&quot;? This cannot be undone.')" class="mt-3">
                @csrf
                @method('DELETE')
                <button type="submit" class="inline-flex items-center gap-1.5 rounded-lg border border-error-500/30 px-4 py-2 text-sm font-medium text-error-600 hover:bg-error-500/10 dark:text-error-400">
                    <x-icon name="trash" class="h-4 w-4" /> Delete role
                </button>
            </form>
        </div>
    @endif
</x-layouts.admin-portal>
