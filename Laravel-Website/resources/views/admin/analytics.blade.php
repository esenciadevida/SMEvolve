<x-layouts.admin-portal :title="'Analytics'">
    <x-admin.page-header title="Analytics" subtitle="Track quotes, AI usage and activity across SMEvolve." />

    @if ($quoteMetrics !== null || $aiMetrics !== null || $chatbot !== null)
        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            @if ($quoteMetrics !== null)
                <x-admin.stat-card label="Total Quotes" :value="$quoteMetrics['total']" icon="clipboard-document-list" tone="primary" />
            @endif
            @if ($aiMetrics !== null)
                <x-admin.stat-card label="AI Requests" :value="$aiMetrics['total_requests']" icon="sparkles" tone="secondary" />
                <x-admin.stat-card label="Success Rate" :value="$aiMetrics['success_rate'] . '%'" icon="check-circle" tone="success" />
                <x-admin.stat-card label="Avg Response" :value="$aiMetrics['avg_response_time_ms'] . 'ms'" icon="clock" tone="info" />
            @endif
            @if ($chatbot !== null)
                <x-admin.stat-card label="Conversations" :value="$chatbot['conversations']" icon="chat-bubble-left-right" tone="primary" />
            @endif
        </div>
    @endif

    @if ($quoteMetrics !== null || ! empty($aiTrend))
        <div class="mt-6 grid gap-6 lg:grid-cols-2">
            @if ($quoteMetrics !== null)
                <x-admin.card title="Quote submissions" subtitle="Last 30 days">
                    <x-admin.bars-chart :data="$quoteTrend" color="bg-primary-500" empty="No quote submissions yet." />
                </x-admin.card>
            @endif

            @if (! empty($aiTrend))
                <x-admin.card title="AI requests" subtitle="Last 14 days">
                    <x-admin.bars-chart :data="$aiTrend" value-key="requests" color="bg-secondary-500" empty="No AI requests yet." />
                </x-admin.card>
            @endif
        </div>
    @endif

    @if ($quoteMetrics !== null || $aiModels !== [] || $chatbot !== null || $activity !== [])
        <div class="mt-6 grid gap-6 lg:grid-cols-2">
            @if ($quoteMetrics !== null)
                <x-admin.card title="Quote status" subtitle="Current distribution">
                    <x-admin.donut-chart :data="$quoteStatus" empty="No quotes yet." />
                </x-admin.card>
            @endif

            @if (! empty($aiModels))
                <x-admin.card title="AI models" subtitle="Most used models">
                    <ul class="divide-y divide-slate-100 dark:divide-slate-800">
                        @foreach ($aiModels as $model)
                            <li class="flex items-center justify-between gap-4 py-2.5 first:pt-0 last:pb-0">
                                <span class="min-w-0 truncate text-sm font-medium text-slate-800 dark:text-slate-200">{{ $model['label'] }}</span>
                                <span class="flex shrink-0 items-center gap-3">
                                    <span class="text-sm tabular-nums text-slate-500 dark:text-slate-400">{{ $model['value'] }} req</span>
                                    <span class="text-xs tabular-nums text-slate-400 dark:text-slate-500">{{ number_format($model['tokens']) }} tok</span>
                                </span>
                            </li>
                        @endforeach
                    </ul>
                </x-admin.card>
            @endif

            @if ($quoteMetrics !== null)
                <x-admin.card title="Quote funnel" subtitle="From session to completion">
                    <div class="space-y-4">
                        @foreach ($funnel as $stage)
                            <div>
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-slate-600 dark:text-slate-300">{{ $stage['label'] }}</span>
                                    <span class="font-semibold tabular-nums text-slate-900 dark:text-slate-100">{{ $stage['value'] }}</span>
                                </div>
                                <div class="mt-1.5 h-2 overflow-hidden rounded-full bg-slate-100 dark:bg-slate-800">
                                    @php
                                        $funnelMax = max($funnel[0]['value'] ?? 1, 1);
                                        $funnelPct = (int) round((($stage['value'] ?? 0) / $funnelMax) * 100);
                                    @endphp
                                    <div class="h-full rounded-full {{ $loop->first ? 'bg-primary-500' : ($loop->last ? 'bg-success-500' : 'bg-info-500') }}" style="width: {{ max($funnelPct, 2) }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </x-admin.card>
            @endif

            @if (! empty($activity))
                <x-admin.card title="Admin activity" subtitle="Audit events per day, last 14 days">
                    <x-admin.bars-chart :data="$activity" color="bg-slate-400" empty="No activity yet." />
                </x-admin.card>
            @endif

            @if ($chatbot !== null)
                <x-admin.card title="Chatbot usage" subtitle="Conversations and messages">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="rounded-xl bg-slate-50 p-4 dark:bg-slate-800">
                            <p class="text-2xl font-semibold tabular-nums text-slate-900 dark:text-slate-100">{{ $chatbot['messages'] }}</p>
                            <p class="mt-0.5 text-sm text-slate-500 dark:text-slate-400">Messages</p>
                        </div>
                        <div class="rounded-xl bg-slate-50 p-4 dark:bg-slate-800">
                            <p class="text-2xl font-semibold tabular-nums text-slate-900 dark:text-slate-100">{{ $chatbot['handoffs'] }}</p>
                            <p class="mt-0.5 text-sm text-slate-500 dark:text-slate-400">Handoffs to team</p>
                        </div>
                        <div class="rounded-xl bg-slate-50 p-4 dark:bg-slate-800">
                            <p class="text-2xl font-semibold tabular-nums text-slate-900 dark:text-slate-100">{{ $chatbot['user_messages'] }}</p>
                            <p class="mt-0.5 text-sm text-slate-500 dark:text-slate-400">User messages</p>
                        </div>
                        <div class="rounded-xl bg-slate-50 p-4 dark:bg-slate-800">
                            <p class="text-2xl font-semibold tabular-nums text-slate-900 dark:text-slate-100">{{ $chatbot['assistant_messages'] }}</p>
                            <p class="mt-0.5 text-sm text-slate-500 dark:text-slate-400">Assistant messages</p>
                        </div>
                    </div>
                </x-admin.card>
            @endif
        </div>
    @endif

    @if ($quoteMetrics === null && $aiMetrics === null && $chatbot === null)
        <x-admin.card>
            <div class="flex flex-col items-center py-10 text-center">
                <span class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-primary-500/10 text-primary-600 dark:text-primary-400">
                    <x-icon name="chart-pie" class="h-6 w-6" />
                </span>
                <h2 class="mt-4 text-base font-semibold text-slate-900 dark:text-slate-100">No analytics available</h2>
                <p class="mt-1 max-w-sm text-sm text-slate-500 dark:text-slate-400">
                    Your role does not have access to analytics data. Contact a Super Admin if you believe you should see more here.
                </p>
            </div>
        </x-admin.card>
    @endif
</x-layouts.admin-portal>
