<x-layouts.admin :title="'Dashboard'">
    <div class="grid gap-6 lg:grid-cols-3">
        <div class="lg:col-span-2 space-y-6">
            <div>
                <h1 class="text-xl font-bold">Dashboard</h1>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Overview of the SMEvolve AI system.</p>
            </div>

            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <div class="rounded-xl border border-slate-200 bg-white p-4 dark:border-slate-800 dark:bg-slate-900">
                    <p class="text-xs uppercase tracking-wide text-slate-500 dark:text-slate-400">Total Requests</p>
                    <p class="mt-1 text-2xl font-bold">{{ number_format($metrics['total_requests']) }}</p>
                </div>
                <div class="rounded-xl border border-slate-200 bg-white p-4 dark:border-slate-800 dark:bg-slate-900">
                    <p class="text-xs uppercase tracking-wide text-slate-500 dark:text-slate-400">Total Tokens</p>
                    <p class="mt-1 text-2xl font-bold">{{ number_format($metrics['total_tokens']) }}</p>
                </div>
                <div class="rounded-xl border border-slate-200 bg-white p-4 dark:border-slate-800 dark:bg-slate-900">
                    <p class="text-xs uppercase tracking-wide text-slate-500 dark:text-slate-400">Requests Today</p>
                    <p class="mt-1 text-2xl font-bold">{{ number_format($metrics['requests_today']) }}</p>
                </div>
                <div class="rounded-xl border border-slate-200 bg-white p-4 dark:border-slate-800 dark:bg-slate-900">
                    <p class="text-xs uppercase tracking-wide text-slate-500 dark:text-slate-400">Avg Response</p>
                    <p class="mt-1 text-2xl font-bold">{{ number_format($metrics['avg_response_time_ms']) }}<span class="text-sm font-normal text-slate-400"> ms</span></p>
                </div>
            </div>

            <div class="rounded-xl border border-slate-200 bg-white p-5 dark:border-slate-800 dark:bg-slate-900">
                <h2 class="text-sm font-semibold">Feature Status</h2>
                <dl class="mt-3 space-y-3 text-sm">
                    <div class="flex items-center justify-between">
                        <dt>Website Assistant</dt>
                        <dd>
                            @if ($assistantEnabled)
                                <span class="rounded-full bg-success-500/15 px-2.5 py-0.5 text-xs font-medium text-success-700 dark:text-success-500">Enabled</span>
                            @else
                                <span class="rounded-full bg-error-500/15 px-2.5 py-0.5 text-xs font-medium text-error-700 dark:text-error-500">Disabled</span>
                            @endif
                        </dd>
                    </div>
                    <div class="flex items-center justify-between">
                        <dt>Quote Wizard AI</dt>
                        <dd>
                            @if ($quoteEnabled)
                                <span class="rounded-full bg-success-500/15 px-2.5 py-0.5 text-xs font-medium text-success-700 dark:text-success-500">Enabled</span>
                            @else
                                <span class="rounded-full bg-error-500/15 px-2.5 py-0.5 text-xs font-medium text-error-700 dark:text-error-500">Disabled</span>
                            @endif
                        </dd>
                    </div>
                    <div class="flex items-center justify-between">
                        <dt>Provider ({{ $providerName }})</dt>
                        <dd>
                            @if ($providerConfigured)
                                <span class="rounded-full bg-success-500/15 px-2.5 py-0.5 text-xs font-medium text-success-700 dark:text-success-500">Configured</span>
                            @else
                                <span class="rounded-full bg-warning-500/15 px-2.5 py-0.5 text-xs font-medium text-warning-700 dark:text-warning-500">Not configured</span>
                            @endif
                        </dd>
                    </div>
                </dl>
            </div>

            <div class="rounded-xl border border-slate-200 bg-white p-5 dark:border-slate-800 dark:bg-slate-900">
                <h2 class="text-sm font-semibold">Recent AI Requests</h2>
                @if (count($recentUsage) === 0)
                    <p class="mt-3 text-sm text-slate-500 dark:text-slate-400">No AI requests yet.</p>
                @else
                    <div class="mt-3 overflow-x-auto">
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

        <div class="space-y-6">
            <div class="rounded-xl border border-slate-200 bg-white p-5 dark:border-slate-800 dark:bg-slate-900">
                <h2 class="text-sm font-semibold">Open Handoffs</h2>
                @if (count($openHandoffs) === 0)
                    <p class="mt-3 text-sm text-slate-500 dark:text-slate-400">No open handoff requests.</p>
                @else
                    <ul class="mt-3 space-y-3 text-sm">
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
            </div>

            <div class="rounded-xl border border-slate-200 bg-white p-5 text-sm dark:border-slate-800 dark:bg-slate-900">
                <h2 class="text-sm font-semibold">Quick Actions</h2>
                <div class="mt-3 grid gap-2">
                    <a href="{{ route('admin.ai.prompts') }}" class="rounded-lg border border-slate-200 px-3 py-2 text-center text-xs font-medium hover:bg-slate-50 dark:border-slate-700 dark:hover:bg-slate-800">Manage Prompts</a>
                    <a href="{{ route('admin.ai.knowledge.index') }}" class="rounded-lg border border-slate-200 px-3 py-2 text-center text-xs font-medium hover:bg-slate-50 dark:border-slate-700 dark:hover:bg-slate-800">Manage Knowledge</a>
                    <a href="{{ route('admin.ai.health') }}" class="rounded-lg border border-slate-200 px-3 py-2 text-center text-xs font-medium hover:bg-slate-50 dark:border-slate-700 dark:hover:bg-slate-800">Run Health Check</a>
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin>
