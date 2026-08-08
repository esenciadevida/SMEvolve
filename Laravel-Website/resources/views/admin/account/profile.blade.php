<x-layouts.admin-portal :title="'My Profile'">
    <div class="mb-6">
        <h1 class="text-xl font-semibold">My Profile</h1>
        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Update your name and email address.</p>
    </div>

    <form method="POST" action="{{ route('admin.profile.update') }}" class="max-w-2xl space-y-4 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
        @csrf

        <div>
            <label for="name" class="block text-sm font-medium">Name</label>
            <input
                type="text"
                id="name"
                name="name"
                value="{{ old('name', $administrator->name) }}"
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
                value="{{ old('email', $administrator->email) }}"
                required
                class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/30 dark:border-slate-700 dark:bg-slate-800"
            >
        </div>

        <div class="flex items-center justify-end gap-3 pt-2">
            <button type="submit" class="rounded-lg bg-primary-600 px-4 py-2 text-sm font-semibold text-white hover:bg-primary-700">
                Save changes
            </button>
        </div>
    </form>
</x-layouts.admin-portal>
