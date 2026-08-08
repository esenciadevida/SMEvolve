<x-layouts.admin-portal :title="'Add Administrator'">
    <div class="mb-6">
        <a href="{{ route('admin.administrators.index') }}" class="text-xs text-primary-600 hover:underline">← Back to administrators</a>
        <h1 class="mt-1 text-xl font-semibold">Add Administrator</h1>
    </div>

    <form method="POST" action="{{ route('admin.administrators.store') }}" class="max-w-2xl space-y-4 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
        @csrf

        <div>
            <label for="name" class="block text-sm font-medium">Name</label>
            <input
                type="text"
                id="name"
                name="name"
                value="{{ old('name') }}"
                required
                class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/30 dark:border-slate-700 dark:bg-slate-800"
            >
        </div>

        <div>
            <label for="email" class="block text-sm font-medium">Email</label>
            <input
                type="email"
                id="email"
                name="email"
                value="{{ old('email') }}"
                required
                class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/30 dark:border-slate-700 dark:bg-slate-800"
            >
        </div>

        <div>
            <label for="role_id" class="block text-sm font-medium">Role</label>
            <select
                id="role_id"
                name="role_id"
                required
                class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/30 dark:border-slate-700 dark:bg-slate-800"
            >
                @foreach ($roles as $role)
                    <option value="{{ $role->id }}" {{ (string) old('role_id') === (string) $role->id ? 'selected' : '' }}>{{ $role->label }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="password" class="block text-sm font-medium">Password</label>
            <input
                type="password"
                id="password"
                name="password"
                required
                class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/30 dark:border-slate-700 dark:bg-slate-800"
            >
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-medium">Confirm password</label>
            <input
                type="password"
                id="password_confirmation"
                name="password_confirmation"
                required
                class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/30 dark:border-slate-700 dark:bg-slate-800"
            >
        </div>

        <div class="flex items-center justify-end gap-3 pt-2">
            <a href="{{ route('admin.administrators.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm hover:bg-slate-50 dark:border-slate-700 dark:hover:bg-slate-800">Cancel</a>
            <button type="submit" class="rounded-lg bg-primary-600 px-4 py-2 text-sm font-semibold text-white hover:bg-primary-700">
                Create administrator
            </button>
        </div>
    </form>
</x-layouts.admin-portal>
