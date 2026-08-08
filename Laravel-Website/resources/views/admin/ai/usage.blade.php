<x-layouts.admin :title="'Usage'">
    <div class="space-y-6">
        <div>
            <h1 class="text-xl font-bold">Usage</h1>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Token and request metrics for the last 30 days.</p>
        </div>

        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <div class="rounded-xl border border-slate-200 bg-white p-4 dark:border-slate-800 dark:bg-slate-900">
                <p class="text-xs uppercase tracking-wide text-slate-500 dark:text-slate-400">Requests (30d)</p>
                <p class="mt-1 text-2xl font-bold">{{ number_format($metrics['total_requests']) }}</p>
                <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">{{ number_format($metrics['failed_requests']) }} failed</p>
            </div>
            <div class="rounded-xl border border-slate-200 bg-white p-4 dark:border-slate-800 dark:bg-slate-900">
                <p class="text-xs uppercase tracking-wide text-slate-500 dark:text-slate-400">Tokens (30d)</p>
                <p class="mt-1 text-2xl font-bold">{{ number_format($metrics['total_tokens']) }}</p>
                <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">{{ number_format($metrics['total_input_tokens']) }} in / {{ number_format($metrics['total_output_tokens']) }} out</p>
            </div>
            <div class="rounded-xl border border-slate-200 bg-white p-4 dark:border-slate-800 dark:bg-slate-900">
                <p class="text-xs uppercase tracking-wide text-slate-500 dark:text-slate-400">Requests Today</p>
                <p class="mt-1 text-2xl font-bold">{{ number_format($metricsToday['total_requests']) }}</p>
            </div>
            <div class="rounded-xl border border-slate-200 bg-white p-4 dark:border-slate-800 dark:bg-slate-900">
                <p class="text-xs uppercase tracking-wide text-slate-500 dark:text-slate-400">Records</p>
                <p class="mt-1 text-2xl font-bold">{{ number_format($conversationCount) }}</p>
                <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">{{ number_format($quoteSessionCount) }} quote sessions</p>
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-2">
            <div class="rounded-xl border border-slate-200 bg-white p-5 dark:border-slate-800 dark:bg-slate-900">
                <h2 class="text-sm font-semibold">Top Endpoints</h2>
                @if (count($topEndpoints) === 0)
                    <p class="mt-3 text-sm text-slate-500 dark:text-slate-400">No data yet.</p>
                @else
                    <table class="mt-3 w-full text-left text-sm">
                        <thead>
                            <tr class="text-xs uppercase tracking-wide text-slate-500 dark:text-slate-400">
                                <th class="pb-2 pr-3 font-medium">Endpoint</th>
                                <th class="pb-2 pr-3 font-medium">Requests</th>
                                <th class="pb-2 font-medium">Tokens</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                            @foreach ($topEndpoints as $endpoint)
                                <tr>
                                    <td class="py-2 pr-3"><code>{{ $endpoint['endpoint'] }}</code></td>
                                    <td class="py-2 pr-3">{{ number_format($endpoint['requests']) }}</td>
                                    <td class="py-2">{{ number_format($endpoint['tokens']) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>

            <div class="rounded-xl border border-slate-200 bg-white p-5 dark:border-slate-800 dark:bg-slate-900">
                <h2 class="text-sm font-semibold">Recent Requests</h2>
                @if (count($recentUsage) === 0)
                    <p class="mt-3 text-sm text-slate-500 dark:text-slate-400">No data yet.</p>
                @else
                    <div class="mt-3 max-h-96 overflow-y-auto">
                        <table class="w-full text-left text-sm">
                            <thead class="sticky top-0 bg-white dark:bg-slate-900">
                                <tr class="text-xs uppercase tracking-wide text-slate-500 dark:text-slate-400">
                                    <th class="pb-2 pr-3 font-medium">Time</th>
                                    <th class="pb-2 pr-3 font-medium">Endpoint</th>
                                    <th class="pb-2 pr-3 font-medium">Tokens</th>
                                    <th class="pb-2 font-medium">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                                @foreach ($recentUsage as $item)
                                    <tr>
                                        <td class="py-2 pr-3 text-xs text-slate-500 dark:text-slate-400">{{ $item['created_at'] }}</td>
                                        <td class="py-2 pr-3 text-xs"><code>{{ $item['endpoint'] }}</code></td>
                                        <td class="py-2 pr-3 text-xs">{{ number_format($item['total_tokens']) }}</td>
                                        <td class="py-2 text-xs">
                                            @if ($item['status'] === 'success')
                                                <span class="text-success-600 dark:text-success-500">Success</span>
                                            @else
                                                <span class="text-error-600 dark:text-error-500">{{ $item['error_type'] ?? 'Error' }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layouts.admin>
