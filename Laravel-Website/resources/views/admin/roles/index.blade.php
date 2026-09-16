<x-layouts.admin-portal :title="'Roles & Permissions'">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="text-xl font-semibold">Roles &amp; Permissions</h1>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Define the permission sets that control access to the Admin Portal.</p>
        </div>
        @if ($canManage)
            <a href="{{ route('admin.roles.create') }}" class="rounded-lg bg-primary-600 px-4 py-2 text-sm font-semibold text-white hover:bg-primary-700">
                Create role
            </a>
        @endif
    </div>

    <div class="mb-6 grid gap-4 sm:grid-cols-3">
        <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <p class="text-xs font-medium uppercase tracking-wide text-slate-500">Total roles</p>
            <p class="mt-1 text-2xl font-semibold">{{ $roles->count() }}</p>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <p class="text-xs font-medium uppercase tracking-wide text-slate-500">Core roles</p>
            <p class="mt-1 text-2xl font-semibold">{{ collect($coreRoles)->count() }}</p>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <p class="text-xs font-medium uppercase tracking-wide text-slate-500">Permissions available</p>
            <p class="mt-1 text-2xl font-semibold">{{ count(config('admin_permissions', [])) }}</p>
        </div>
    </div>

    <div class="overflow-x-auto rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
        @if ($roles->isEmpty())
            <p class="p-6 text-sm text-slate-500">No roles found.</p>
        @else
            <table class="w-full min-w-[720px] text-sm">
                <thead class="border-b border-slate-200 bg-slate-50 text-left text-xs uppercase text-slate-500 dark:border-slate-800 dark:bg-slate-900">
                    <tr>
                        <th class="px-4 py-3">Role</th>
                        <th class="hidden px-4 py-3 md:table-cell">Description</th>
                        <th class="px-4 py-3">Permissions</th>
                        <th class="px-4 py-3">Administrators</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @foreach ($roles as $role)
                        @php
                            $isCore = in_array($role->name, $coreRoles, true);
                            $isOwnRole = (int) $role->id === (int) auth('admin')->user()?->role_id;
                            $canDelete = $canManage && ! $isCore && $role->administrators_count === 0 && ! $isOwnRole;
                        @endphp
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50">
                            <td class="px-4 py-3">
                                <a href="{{ route('admin.roles.edit', $role) }}" class="font-medium text-primary-600 hover:underline">{{ $role->label }}</a>
                                <div class="mt-1 flex flex-wrap items-center gap-1.5">
                                    @if ($isCore)
                                        <x-admin.badge tone="info">Core role</x-admin.badge>
                                    @endif
                                    @if ($isOwnRole)
                                        <x-admin.badge tone="warning">Your role</x-admin.badge>
                                    @endif
                                </div>
                            </td>
                            <td class="hidden max-w-xs px-4 py-3 text-slate-500 md:table-cell dark:text-slate-400">
                                {{ $role->description ?: '—' }}
                            </td>
                            <td class="px-4 py-3">
                                <x-admin.badge tone="slate">{{ count($role->permissions ?? []) }} of {{ count(config('admin_permissions', [])) }}</x-admin.badge>
                            </td>
                            <td class="px-4 py-3">
                                @if ($role->administrators_count > 0)
                                    <a href="{{ route('admin.administrators.index') }}" class="text-slate-600 hover:underline dark:text-slate-300">{{ $role->administrators_count }}</a>
                                @else
                                    <span class="text-slate-400">0</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.roles.edit', $role) }}" class="inline-flex items-center gap-1 rounded-lg border border-slate-300 px-3 py-1.5 text-xs font-medium hover:bg-slate-50 dark:border-slate-700 dark:hover:bg-slate-800">
                                        <x-icon name="pencil" class="h-3.5 w-3.5" /> Edit
                                    </a>
                                    @if ($canDelete)
                                        <form method="POST" action="{{ route('admin.roles.destroy', $role) }}" onsubmit="return confirm('Delete the role &quot;{{ $role->label }}&quot;? This cannot be undone.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center gap-1 rounded-lg border border-error-500/30 px-3 py-1.5 text-xs font-medium text-error-600 hover:bg-error-500/10 dark:text-error-400">
                                                <x-icon name="trash" class="h-3.5 w-3.5" /> Delete
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <div class="mt-6 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900">
        <p class="text-xs font-medium uppercase tracking-wide text-slate-500">Risk legend</p>
        <div class="mt-3 flex flex-wrap gap-3">
            <x-admin.badge tone="success">Low risk</x-admin.badge>
            <x-admin.badge tone="warning">Medium risk</x-admin.badge>
            <x-admin.badge tone="error">High risk</x-admin.badge>
        </div>
        <p class="mt-3 text-xs text-slate-500 dark:text-slate-400">
            Core roles are seeded from the approved baseline matrix and cannot be deleted. Role management itself is restricted to Super Administrators.
        </p>
    </div>
</x-layouts.admin-portal>
