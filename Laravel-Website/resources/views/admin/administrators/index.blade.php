<x-layouts.admin-portal :title="'Administrators'">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="text-xl font-semibold">Administrators</h1>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Manage who can access the Admin Portal.</p>
        </div>
        @if (auth('admin')->user()->hasPermission('administrators.create'))
            <a href="{{ route('admin.administrators.create') }}" class="rounded-lg bg-primary-600 px-4 py-2 text-sm font-semibold text-white hover:bg-primary-700">
                Add administrator
            </a>
        @endif
    </div>

    <form method="GET" action="{{ route('admin.administrators.index') }}" class="mb-6 flex flex-wrap items-center gap-3 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900">
        <input
            type="search"
            name="q"
            value="{{ request('q') }}"
            placeholder="Search by name or email"
            class="flex-1 rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/30 dark:border-slate-700 dark:bg-slate-800"
        >
        <select name="status" class="rounded-lg border border-slate-300 px-3 py-2 text-sm dark:border-slate-700 dark:bg-slate-800">
            <option value="">All statuses</option>
            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
            <option value="disabled" {{ request('status') === 'disabled' ? 'selected' : '' }}>Disabled</option>
        </select>
        <button type="submit" class="rounded-lg bg-primary-600 px-4 py-2 text-sm font-semibold text-white hover:bg-primary-700">Filter</button>
    </form>

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
        @if ($administrators->isEmpty())
            <p class="p-6 text-sm text-slate-500">No administrators found.</p>
        @else
            <table class="w-full text-sm">
                <thead class="border-b border-slate-200 bg-slate-50 text-left text-xs uppercase text-slate-500 dark:border-slate-800 dark:bg-slate-900">
                    <tr>
                        <th class="px-4 py-3">Name</th>
                        <th class="px-4 py-3">Email</th>
                        <th class="px-4 py-3">Role</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Last login</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @foreach ($administrators as $administrator)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50">
                            <td class="px-4 py-3">
                                <a href="{{ route('admin.administrators.show', $administrator) }}" class="font-medium text-primary-600 hover:underline">{{ $administrator->name }}</a>
                            </td>
                            <td class="px-4 py-3 text-slate-600 dark:text-slate-300">{{ $administrator->email }}</td>
                            <td class="px-4 py-3">{{ $administrator->role?->label }}</td>
                            <td class="px-4 py-3">
                                <span class="rounded-full px-2 py-0.5 text-xs {{ $administrator->is_active ? 'bg-success-500/10 text-success-700 dark:text-success-500' : 'bg-error-500/10 text-error-700 dark:text-error-500' }}">
                                    {{ $administrator->is_active ? 'Active' : 'Disabled' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-slate-500">
                                {{ optional($administrator->last_login_at)->diffForHumans() ?? 'Never' }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <div class="mt-4">
        {{ $administrators->links() }}
    </div>
</x-layouts.admin-portal>
