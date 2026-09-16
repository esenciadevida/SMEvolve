<x-layouts.admin-portal :title="'Audit Log'">
    <div class="mb-6">
        <h1 class="text-xl font-semibold">Audit Log</h1>
        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Every administrative action performed in the Admin Portal.</p>
    </div>

    <form method="GET" action="{{ route('admin.audit.index') }}" class="mb-6 grid gap-3 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:grid-cols-2 lg:grid-cols-5 dark:border-slate-800 dark:bg-slate-900">
        <input
            type="search"
            name="q"
            value="{{ $filters['query'] }}"
            placeholder="Search action or resource"
            class="rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/30 dark:border-slate-700 dark:bg-slate-800"
        >
        <select name="action" class="rounded-lg border border-slate-300 px-3 py-2 text-sm dark:border-slate-700 dark:bg-slate-800">
            <option value="">All actions</option>
            @foreach ($actions as $action)
                <option value="{{ $action }}" {{ ($filters['action'] ?? null) === $action ? 'selected' : '' }}>{{ $action }}</option>
            @endforeach
        </select>
        <input type="date" name="from" value="{{ $filters['from'] ?? '' }}" class="rounded-lg border border-slate-300 px-3 py-2 text-sm dark:border-slate-700 dark:bg-slate-800">
        <input type="date" name="to" value="{{ $filters['to'] ?? '' }}" class="rounded-lg border border-slate-300 px-3 py-2 text-sm dark:border-slate-700 dark:bg-slate-800">
        <div class="flex gap-2">
            <button type="submit" class="flex-1 rounded-lg bg-primary-600 px-4 py-2 text-sm font-semibold text-white hover:bg-primary-700">Filter</button>
            <a href="{{ route('admin.audit.index') }}" class="rounded-lg border border-slate-300 px-3 py-2 text-sm hover:bg-slate-50 dark:border-slate-700 dark:hover:bg-slate-800">Reset</a>
        </div>
    </form>

    <div class="overflow-x-auto rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
        @if ($logs->isEmpty())
            <p class="p-6 text-sm text-slate-500">No log entries found.</p>
        @else
            <table class="w-full min-w-[640px] text-sm">
                <thead class="border-b border-slate-200 bg-slate-50 text-left text-xs uppercase text-slate-500 dark:border-slate-800 dark:bg-slate-900">
                    <tr>
                        <th class="px-4 py-3">When</th>
                        <th class="px-4 py-3">Administrator</th>
                        <th class="px-4 py-3">Action</th>
                        <th class="px-4 py-3">Resource</th>
                        <th class="px-4 py-3">IP</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @foreach ($logs as $log)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50">
                            <td class="whitespace-nowrap px-4 py-3 text-slate-500">{{ $log->created_at->format('M j, Y H:i') }}</td>
                            <td class="px-4 py-3 font-medium">
                                {{ $log->administrator?->name ?? 'System' }}
                                @if ($log->administrator?->email)
                                    <span class="block text-xs font-normal text-slate-400">{{ $log->administrator->email }}</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <span class="rounded-full bg-slate-100 px-2 py-0.5 text-xs text-slate-600 dark:bg-slate-800 dark:text-slate-300">{{ $log->action }}</span>
                            </td>
                            <td class="px-4 py-3 text-slate-600 dark:text-slate-300">
                                @if ($log->resource_type)
                                    {{ $log->resource_type }}{{ $log->resource_id ? ' #'.$log->resource_id : '' }}
                                @else
                                   ,
                                @endif
                            </td>
                            <td class="px-4 py-3 text-slate-500">{{ $log->ip_address ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <div class="mt-4">
        {{ $logs->links() }}
    </div>
</x-layouts.admin-portal>
