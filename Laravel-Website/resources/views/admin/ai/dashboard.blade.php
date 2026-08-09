<x-layouts.admin-portal :title="'AI Management'">
    <x-admin.page-header title="AI Management" subtitle="Overview of the SMEvolve AI system." />

    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <x-admin.stat-card label="Total Requests" :value="number_format($metrics['total_requests'])" icon="sparkles" tone="primary" />
        <x-admin.stat-card label="Total Tokens" :value="number_format($metrics['total_tokens'])" icon="cube" tone="secondary" />
        <x-admin.stat-card label="Requests Today" :value="number_format($metrics['requests_today'])" icon="arrow-trending-up" tone="success" />
        <x-admin.stat-card label="Avg Response" :value="number_format($metrics['avg_response_time_ms']) . 'ms'" icon="clock" tone="info" />
    </div>

    <div class="mt-6 grid gap-6 lg:grid-cols-3">
        <div class="space-y-6 lg:col-span-2">
            <x-admin.card title="Feature Status" subtitle="Current AI feature configuration">
                <dl class="space-y-3 text-sm">
                    <div class="flex items-center justify-between">
                        <dt class="text-slate-600 dark:text-slate-300">Website Assistant</dt>
                        <dd>
                            <x-admin.badge :tone="$assistantEnabled ? 'success' : 'error'" dot>
                                {{ $assistantEnabled ? 'Enabled' : 'Disabled' }}
                            </x-admin.badge>
                        </dd>
                    </div>
                    <div class="flex items-center justify-between">
                        <dt class="text-slate-600 dark:text-slate-300">Quote Wizard AI</dt>
                        <dd>
                            <x-admin.badge :tone="$quoteEnabled ? 'success' : 'error'" dot>
                                {{ $quoteEnabled ? 'Enabled' : 'Disabled' }}
                            </x-admin.badge>
                        </dd>
                    </div>
                    <div class="flex items-center justify-between">
                        <dt class="text-slate-600 dark:text-slate-300">Provider ({{ $providerName }})</dt>
                        <dd>
                            <x-admin.badge :tone="$providerConfigured ? 'success' : 'warning'" dot>
                                {{ $providerConfigured ? 'Configured' : 'Not configured' }}
                            </x-admin.badge>
                        </dd>
                    </div>
                </dl>
            </x-admin.card>

            <x-admin.card title="Recent AI Requests" subtitle="Latest provider activity">
                @if (count($recentUsage) === 0)
                    <p class="py-6 text-center text-sm text-slate-400 dark:text-slate-500">No AI requests yet.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm">
                            <thead>
                                <tr class="text-xs uppercase tracking-wide text-slate-500 dark:text-slate-400">
                                    <th class="pb-2 pr-3 font-medium">Time</th>
                                    <th class="pb-2 pr-3 font-medium">Endpoint</th>
                                    <th class="pb-2 pr-3 font-medium">Model</th>
                                    <th class="pb-2 pr-3 font-medium">Tokens</th>
                                    <th class="pb-2 font-medium">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                                @foreach ($recentUsage as $item)
                                    <tr>
                                        <td class="py-2 pr-3 text-slate-500 dark:text-slate-400">{{ $item['created_at'] }}</td>
                                        <td class="py-2 pr-3">{{ $item['endpoint'] }}</td>
                                        <td class="py-2 pr-3 text-slate-500 dark:text-slate-400">{{ $item['model'] }}</td>
                                        <td class="py-2 pr-3">{{ number_format($item['total_tokens']) }}</td>
                                        <td class="py-2">
                                            <x-admin.badge :tone="$item['status'] === 'success' ? 'success' : 'error'">
                                                {{ $item['status'] === 'success' ? 'Success' : ($item['error_type'] ?? 'Error') }}
                                            </x-admin.badge>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </x-admin.card>
        </div>

        <div class="space-y-6">
            <x-admin.card title="Open Handoffs" subtitle="Requests waiting for a human">
                @if (count($openHandoffs) === 0)
                    <p class="py-6 text-center text-sm text-slate-400 dark:text-slate-500">No open handoff requests.</p>
                @else
                    <ul class="space-y-3 text-sm">
                        @foreach ($openHandoffs as $handoff)
                            <li class="rounded-lg border border-slate-200 p-3 dark:border-slate-700">
                                <p class="font-medium">{{ ucwords(str_replace('_', ' ', $handoff['reason'])) }}</p>
                                <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                                    {{ $handoff['requested_at'] }}, {{ $handoff['conversation']['status'] ?? 'unknown' }}
                                </p>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </x-admin.card>

            <x-admin.card title="Quick Actions">
                <div class="grid gap-2">
                    <a href="{{ route('admin.ai.prompts') }}" class="rounded-lg border border-slate-200 px-3 py-2 text-center text-xs font-medium hover:bg-slate-50 dark:border-slate-700 dark:hover:bg-slate-800">Manage Prompts</a>
                    <a href="{{ route('admin.ai.knowledge.index') }}" class="rounded-lg border border-slate-200 px-3 py-2 text-center text-xs font-medium hover:bg-slate-50 dark:border-slate-700 dark:hover:bg-slate-800">Manage Knowledge</a>
                    <a href="{{ route('admin.ai.health') }}" class="rounded-lg border border-slate-200 px-3 py-2 text-center text-xs font-medium hover:bg-slate-50 dark:border-slate-700 dark:hover:bg-slate-800">Run Health Check</a>
                    <a href="{{ route('admin.ai.settings') }}" class="rounded-lg border border-slate-200 px-3 py-2 text-center text-xs font-medium hover:bg-slate-50 dark:border-slate-700 dark:hover:bg-slate-800">Provider Settings</a>
                </div>
            </x-admin.card>
        </div>
    </div>
</x-layouts.admin-portal>
