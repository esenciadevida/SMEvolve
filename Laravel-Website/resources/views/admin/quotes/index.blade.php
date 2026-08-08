<x-layouts.admin-portal :title="'Quotes'">
    <div class="mb-6">
        <h1 class="text-xl font-semibold">Quote Requests</h1>
        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Review and manage customer quote requests.</p>
    </div>

    <form method="GET" action="{{ route('admin.quotes.index') }}" class="mb-6 grid gap-3 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:grid-cols-2 lg:grid-cols-5 dark:border-slate-800 dark:bg-slate-900">
        <input
            type="search"
            name="q"
            value="{{ $filters['query'] }}"
            placeholder="Search reference or contact"
            class="rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/30 dark:border-slate-700 dark:bg-slate-800"
        >
        <select name="status" class="rounded-lg border border-slate-300 px-3 py-2 text-sm dark:border-slate-700 dark:bg-slate-800">
            <option value="">All statuses</option>
            @foreach ($statuses as $value => $label)
                <option value="{{ $value }}" {{ ($filters['status'] ?? null) === $value ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </select>
        <input type="date" name="from" value="{{ $filters['from'] ?? '' }}" class="rounded-lg border border-slate-300 px-3 py-2 text-sm dark:border-slate-700 dark:bg-slate-800">
        <input type="date" name="to" value="{{ $filters['to'] ?? '' }}" class="rounded-lg border border-slate-300 px-3 py-2 text-sm dark:border-slate-700 dark:bg-slate-800">
        <div class="flex gap-2">
            <button type="submit" class="flex-1 rounded-lg bg-primary-600 px-4 py-2 text-sm font-semibold text-white hover:bg-primary-700">Filter</button>
            <a href="{{ route('admin.quotes.index') }}" class="rounded-lg border border-slate-300 px-3 py-2 text-sm hover:bg-slate-50 dark:border-slate-700 dark:hover:bg-slate-800">Reset</a>
        </div>
    </form>

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
        @if ($quotes->isEmpty())
            <p class="p-6 text-sm text-slate-500">No quotes found.</p>
        @else
            <table class="w-full text-sm">
                <thead class="border-b border-slate-200 bg-slate-50 text-left text-xs uppercase text-slate-500 dark:border-slate-800 dark:bg-slate-900">
                    <tr>
                        <th class="px-4 py-3">Reference</th>
                        <th class="px-4 py-3">Contact</th>
                        <th class="px-4 py-3">Project</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Submitted</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @foreach ($quotes as $quote)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50">
                            <td class="px-4 py-3">
                                <a href="{{ route('admin.quotes.show', $quote) }}" class="font-medium text-primary-600 hover:underline">{{ $quote->reference }}</a>
                            </td>
                            <td class="px-4 py-3">
                                <p class="font-medium">{{ $quote->contact_name }}</p>
                                <p class="text-xs text-slate-500">{{ $quote->contact_email }}</p>
                            </td>
                            <td class="px-4 py-3 text-slate-600 dark:text-slate-300">
                                {{ $quote->quoteSession?->project_type ?? '-' }}
                            </td>
                            <td class="px-4 py-3">
                                <span class="rounded-full bg-slate-100 px-2 py-0.5 text-xs text-slate-600 dark:bg-slate-800 dark:text-slate-300">
                                    {{ $statuses[$quote->status] ?? $quote->status }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-slate-500">
                                {{ optional($quote->submitted_at)->format('M j, Y H:i') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <div class="mt-4">
        {{ $quotes->links() }}
    </div>
</x-layouts.admin-portal>
