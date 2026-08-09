<x-layouts.admin-portal :title="'AI Analytics'">
    <x-admin.page-header title="AI Analytics" subtitle="Requests, tokens and provider performance." />

    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <x-admin.stat-card label="Total Requests" :value="number_format($aiMetrics['total_requests'])" icon="sparkles" tone="primary" />
        <x-admin.stat-card label="Success Rate" :value="$aiMetrics['success_rate'] . '%'" icon="check-circle" tone="success" />
        <x-admin.stat-card label="Total Tokens" :value="number_format($aiMetrics['total_tokens'])" icon="cube" tone="secondary" />
        <x-admin.stat-card label="Avg Response" :value="number_format($aiMetrics['avg_response_time_ms']) . 'ms'" icon="clock" tone="info" />
    </div>

    <div class="mt-6 grid gap-6 lg:grid-cols-2">
        <x-admin.card title="Requests" subtitle="Last 30 days">
            <x-admin.bars-chart :data="$aiTrend" value-key="requests" color="bg-secondary-500" empty="No AI requests yet." />
        </x-admin.card>

        <x-admin.card title="Top endpoints">
            @if (count($aiEndpoints) === 0)
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
                        @foreach ($aiEndpoints as $endpoint)
                            <tr>
                                <td class="py-2 pr-3"><code>{{ $endpoint['label'] }}</code></td>
                                <td class="py-2 pr-3">{{ number_format($endpoint['value']) }}</td>
                                <td class="py-2">{{ number_format($endpoint['tokens']) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </x-admin.card>
    </div>

    <div class="mt-6">
        <x-admin.card title="Models used">
            @if (count($aiModels) === 0)
                <p class="py-6 text-center text-sm text-slate-400 dark:text-slate-500">No data yet.</p>
            @else
                <div class="flex flex-wrap gap-3">
                    @foreach ($aiModels as $model)
                        <div class="rounded-xl border border-slate-100 px-4 py-3 dark:border-slate-800">
                            <p class="text-sm font-medium text-slate-800 dark:text-slate-200">{{ $model['label'] }}</p>
                            <p class="text-xs text-slate-500 dark:text-slate-400">{{ number_format($model['value']) }} requests</p>
                        </div>
                    @endforeach
                </div>
            @endif
        </x-admin.card>
    </div>
</x-layouts.admin-portal>
