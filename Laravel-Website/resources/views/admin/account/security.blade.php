<x-layouts.admin-portal :title="'Security'">
    <div class="mb-6">
        <h1 class="text-xl font-semibold">Security</h1>
        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Change your password. Other active sessions will be signed out.</p>
    </div>

    <form method="POST" action="{{ route('admin.security.password') }}" class="max-w-2xl space-y-4 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
        @csrf

        <div>
            <label for="current_password" class="block text-sm font-medium">Current password</label>
            <input
                type="password"
                id="current_password"
                name="current_password"
                required
                class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/30 dark:border-slate-700 dark:bg-slate-800"
            >
        </div>

        <div>
            <label for="password" class="block text-sm font-medium">New password</label>
            <input
                type="password"
                id="password"
                name="password"
                required
                class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/30 dark:border-slate-700 dark:bg-slate-800"
            >
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-medium">Confirm new password</label>
            <input
                type="password"
                id="password_confirmation"
                name="password_confirmation"
                required
                class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/30 dark:border-slate-700 dark:bg-slate-800"
            >
        </div>

        <div class="flex items-center justify-end gap-3 pt-2">
            <button type="submit" class="rounded-lg bg-primary-600 px-4 py-2 text-sm font-semibold text-white hover:bg-primary-700">
                Change password
            </button>
        </div>
    </form>
</x-layouts.admin-portal>
