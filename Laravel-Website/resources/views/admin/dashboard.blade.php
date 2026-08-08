<x-layouts.admin-portal :title="'Dashboard'">
    @php
        $hour = (int) now()->format('G');
        $greeting = $hour < 12 ? 'Good morning' : ($hour < 18 ? 'Good afternoon' : 'Good evening');
        $hasSections = $quoteMetrics !== null || $chatbotStatus !== null || $aiStatus !== null || $recentQuotes !== null || $recentActivity !== null || ! empty($aiTrend);
    @endphp

    <x-admin.page-header
        :title="$greeting . ', ' . (auth('admin')->user()->name ?: 'there') . '.'"
        :subtitle="'Here\'s what\'s happening with SMEvolve today, ' . now()->format('l, j F Y')"
    />

    @if (! empty($warnings))
        <div class="mb-6 flex items-start gap-3 rounded-xl border border-warning-500/30 bg-warning-500/10 px-4 py-3 text-sm text-warning-700 dark:text-warning-500">
            <x-icon name="exclamation-triangle" class="mt-0.5 h-5 w-5 shrink-0" />
            <div class="space-y-1">
                @foreach ($warnings as $warning)
                    <p>{{ $warning }}</p>
                @endforeach
            </div>
        </div>
    @endif

    @if ($quoteMetrics !== null)
        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <x-admin.stat-card label="Total Quotes" :value="$quoteMetrics['total']" icon="clipboard-document-list" tone="primary" />
            <x-admin.stat-card label="New" :value="$quoteMetrics['new']" icon="trending-up" tone="info" />
            <x-admin.stat-card label="In Progress" :value="$quoteMetrics['in_progress']" icon="clock" tone="warning" />
            <x-admin.stat-card label="Completed" :value="$quoteMetrics['completed']" icon="check-circle" tone="success" />
        </div>
    @endif

    @if ($quoteMetrics !== null || ! empty($aiTrend))
        <div class="mt-6 grid gap-6 lg:grid-cols-2">
            @if ($quoteMetrics !== null)
                <x-admin.card title="Quote submissions" subtitle="Last 14 days">
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

    @if ($chatbotStatus !== null || $aiStatus !== null)
        <div class="mt-6 grid gap-6 lg:grid-cols-2">
            @if ($chatbotStatus !== null)
                <x-admin.card title="Chatbot Assistant">
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-slate-500 dark:text-slate-400">Status</span>
                            <x-admin.badge :tone="$chatbotStatus['state'] === 'active' ? 'success' : 'slate'" dot>
                                {{ $chatbotStatus['label'] }}
                            </x-admin.badge>
                        </div>
                        <a
                            href="{{ route('admin.chatbot.index') }}"
                            class="inline-flex items-center gap-1.5 text-sm font-medium text-primary-600 hover:text-primary-700 dark:text-primary-400"
                        >
                            Manage chatbot
                            <x-icon name="arrow-right" class="h-4 w-4" />
                        </a>
                    </div>
                </x-admin.card>
            @endif

            @if ($aiStatus !== null)
                <x-admin.card title="AI Service">
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-slate-500 dark:text-slate-400">Status</span>
                            <x-admin.badge
                                :tone="$aiStatus['state'] === 'active' ? 'success' : ($aiStatus['state'] === 'warning' ? 'warning' : 'slate')"
                                dot
                            >
                                {{ $aiStatus['label'] }}
                            </x-admin.badge>
                        </div>
                        <a
                            href="{{ route('admin.ai.settings') }}"
                            class="inline-flex items-center gap-1.5 text-sm font-medium text-primary-600 hover:text-primary-700 dark:text-primary-400"
                        >
                            Configure AI
                            <x-icon name="arrow-right" class="h-4 w-4" />
                        </a>
                    </div>
                </x-admin.card>
            @endif
        </div>
    @endif

    @if ($recentQuotes !== null || $recentActivity !== null)
        <div class="mt-6 grid gap-6 lg:grid-cols-2">
            @if ($recentQuotes !== null)
                <x-admin.card title="Recent Quotes" subtitle="Latest submissions">
                    @if ($recentQuotes->isEmpty())
                        <p class="py-8 text-center text-sm text-slate-400 dark:text-slate-500">No quotes yet.</p>
                    @else
                        <ul class="divide-y divide-slate-100 dark:divide-slate-800">
                            @foreach ($recentQuotes as $quote)
                                <li class="flex items-center justify-between gap-4 py-3 first:pt-0 last:pb-0">
                                    <div class="min-w-0">
                                        <p class="truncate text-sm font-medium text-slate-900 dark:text-slate-100">{{ $quote->contact_name }}</p>
                                        <p class="text-xs text-slate-500 dark:text-slate-400">{{ $quote->reference }}</p>
                                    </div>
                                    <div class="flex shrink-0 items-center gap-3">
                                        <x-admin.badge tone="primary">{{ ucwords(str_replace('_', ' ', $quote->status)) }}</x-admin.badge>
                                        <a
                                            href="{{ route('admin.quotes.show', $quote) }}"
                                            class="text-slate-400 transition hover:text-primary-600 dark:text-slate-500 dark:hover:text-primary-400"
                                            aria-label="View quote {{ $quote->reference }}"
                                        >
                                            <x-icon name="arrow-right" class="h-4 w-4" />
                                        </a>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </x-admin.card>
            @endif

            @if ($recentActivity !== null)
                <x-admin.card title="Recent Activity" subtitle="Latest admin actions">
                    @if ($recentActivity->isEmpty())
                        <p class="py-8 text-center text-sm text-slate-400 dark:text-slate-500">No activity yet.</p>
                    @else
                        <ul class="space-y-4">
                            @foreach ($recentActivity as $activity)
                                <li class="flex items-start gap-3">
                                    <span class="mt-1.5 h-2 w-2 shrink-0 rounded-full bg-primary-500"></span>
                                    <div class="min-w-0">
                                        <p class="text-sm font-medium text-slate-800 dark:text-slate-200">{{ $activity->action }}</p>
                                        <p class="text-xs text-slate-500 dark:text-slate-400">
                                            {{ $activity->administrator?->name ?? 'System' }}
                                            &middot; {{ $activity->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </x-admin.card>
            @endif
        </div>
    @endif

    @if (! $hasSections)
        <x-admin.card>
            <div class="flex flex-col items-center py-10 text-center">
                <span class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-primary-500/10 text-primary-600 dark:text-primary-400">
                    <x-icon name="sparkles" class="h-6 w-6" />
                </span>
                <h2 class="mt-4 text-base font-semibold text-slate-900 dark:text-slate-100">Welcome to your dashboard</h2>
                <p class="mt-1 max-w-sm text-sm text-slate-500 dark:text-slate-400">
                    Your administrator role has limited access. Contact a Super Admin if you believe you should see more here.
                </p>
            </div>
        </x-admin.card>
    @endif
</x-layouts.admin-portal>
