<x-layouts.admin-portal :title="'AI Usage'">
    <x-admin.page-header title="Usage" subtitle="Token and request metrics for the last 30 days." />

    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <x-admin.stat-card label="Requests (30d)" :value="number_format($metrics['total_requests'])" icon="sparkles" tone="primary" hint="{{ number_format($metrics['failed_requests']) }} failed" />
        <x-admin.stat-card label="Tokens (30d)" :value="number_format($metrics['total_tokens'])" icon="cube" tone="secondary" hint="{{ number_format($metrics['total_input_tokens']) }} in / {{ number_format($metrics['total_output_tokens']) }} out" />
        <x-admin.stat-card label="Requests Today" :value="number_format($metricsToday['total_requests'])" icon="arrow-trending-up" tone="success" />
        <x-admin.stat-card label="Records" :value="number_format($conversationCount)" icon="chat-bubble-left-right" tone="info" hint="{{ number_format($quoteSessionCount) }} quote sessions" />
    </div>

    <div class="mt-6 grid gap-6 lg:grid-cols-2">
        <x-admin.card title="Top Endpoints">
            @if (count($topEndpoints) === 0)
                <p class="py-6 text-center text-sm text-slate-400 dark:text-slate-500">No data yet.</p>
            @else
                <table class="w-full text-left text-sm">
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
        </x-admin.card>

        <x-admin.card title="Recent Requests">
            @if (count($recentUsage) === 0)
                <p class="py-6 text-center text-sm text-slate-400 dark:text-slate-500">No data yet.</p>
            @else
                <div class="max-h-96 overflow-y-auto">
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
        </x-admin.card>
    </div>
</x-layouts.admin-portal>
