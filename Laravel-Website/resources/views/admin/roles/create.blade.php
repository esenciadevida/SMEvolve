<x-layouts.admin-portal :title="'Create Role'">
    <div class="mb-6">
        <a href="{{ route('admin.roles.index') }}" class="text-xs text-primary-600 hover:underline">← Back to roles</a>
        <h1 class="mt-1 text-xl font-semibold">Create Role</h1>
        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Define a new permission set for the Admin Portal.</p>
    </div>

    <form method="POST" action="{{ route('admin.roles.store') }}" class="max-w-4xl space-y-6">
        @csrf

        <div class="space-y-4 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <div>
                <label for="label" class="block text-sm font-medium">Role name</label>
                <input
                    type="text"
                    id="label"
                    name="label"
                    value="{{ old('label') }}"
                    required
                    placeholder="e.g. Content Manager"
                    class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/30 dark:border-slate-700 dark:bg-slate-800"
                >
                <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">The internal identifier is generated from this name automatically.</p>
            </div>

            <div>
                <label for="description" class="block text-sm font-medium">Description</label>
                <textarea
                    id="description"
                    name="description"
                    rows="2"
                    placeholder="What is this role responsible for?"
                    class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/30 dark:border-slate-700 dark:bg-slate-800"
                >{{ old('description') }}</textarea>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <h2 class="text-sm font-semibold text-slate-900 dark:text-slate-100">Permissions</h2>
            <p class="mt-1 mb-4 text-xs text-slate-500 dark:text-slate-400">
                Grant only the access this role needs. You can only grant permissions you hold yourself.
            </p>

            @include('admin.roles._permission_editor', [
                'permissionGroups' => $permissionGroups,
                'selected' => old('permissions', []),
            ])
        </div>

        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('admin.roles.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm hover:bg-slate-50 dark:border-slate-700 dark:hover:bg-slate-800">Cancel</a>
            <button type="submit" class="rounded-lg bg-primary-600 px-4 py-2 text-sm font-semibold text-white hover:bg-primary-700">
                Create role
            </button>
        </div>
    </form>
</x-layouts.admin-portal>
