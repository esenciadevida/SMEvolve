<x-layouts.admin-portal :title="'Dashboard'">
    @php
        $hour = (int) now()->format('G');
        $greeting = $hour < 12 ? 'Good morning' : ($hour < 18 ? 'Good afternoon' : 'Good evening');
        $hasSections = ! empty($kpis) || ! empty($quoteTrend) || ! empty($aiTrend) || ! empty($trafficTrend)
            || $recentQuotes !== null || $recentActivity !== null || ! empty($securityEvents);
    @endphp

    <div class="mb-6 flex flex-wrap items-end justify-between gap-4">
        <x-admin.page-header
            :title="$greeting . ', ' . (auth('admin')->user()->name ?: 'there') . '.'"
            :subtitle="'Here\'s what\'s happening with SMEvolve today, ' . now()->format('l, j F Y')"
        />
        <form method="GET" action="{{ route('admin.dashboard') }}" class="flex items-center gap-2">
            <select
                name="range"
                onchange="this.form.submit()"
                class="rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100"
                aria-label="Date range"
            >
                @foreach (['today' => 'Today', 'yesterday' => 'Yesterday', '7d' => 'Last 7 days', '30d' => 'Last 30 days', '90d' => 'Last 90 days'] as $value => $label)
                    <option value="{{ $value }}" @selected($range === $value)>{{ $label }}</option>
                @endforeach
            </select>
        </form>
    </div>

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

    @if (! empty($kpis))
        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-5">
            @if (isset($kpis['visitors']))
                <x-admin.stat-card label="Visitors" :value="number_format($kpis['visitors'])" :hint="$rangeLabel" icon="users" tone="primary" />
            @endif
            @if (isset($kpis['page_views']))
                <x-admin.stat-card label="Page Views" :value="number_format($kpis['page_views'])" :hint="$rangeLabel" icon="eye" tone="info" />
            @endif
            @if (isset($kpis['quotes']))
                <x-admin.stat-card label="Total Quotes" :value="number_format($kpis['quotes'])" :hint="$rangeLabel" icon="clipboard-document-list" tone="secondary" />
            @endif
            @if (isset($kpis['conversations']))
                <x-admin.stat-card label="Chatbot Conversations" :value="number_format($kpis['conversations'])" :hint="$rangeLabel" icon="chat-bubble-left-right" tone="success" />
            @endif
            @if (isset($kpis['ai_requests']))
                <x-admin.stat-card label="AI Requests" :value="number_format($kpis['ai_requests'])" :hint="$rangeLabel" icon="sparkles" tone="warning" />
            @endif
        </div>
    @endif

    @php
        $charts = array_filter([
            'quote' => ! empty($quoteTrend),
            'ai' => ! empty($aiTrend),
            'traffic' => ! empty($trafficTrend),
        ]);
        $chartCols = count($charts) === 3 ? 'lg:grid-cols-3' : (count($charts) === 2 ? 'lg:grid-cols-2' : 'lg:grid-cols-1');
    @endphp

    @if (count($charts) > 0)
        <div class="mt-6 grid gap-6 {{ $chartCols }}">
            @if (isset($charts['quote']))
                <x-admin.card title="Quote submissions" :subtitle="$rangeLabel">
                    <x-admin.bars-chart :data="$quoteTrend" color="bg-primary-500" empty="No quote submissions yet." />
                </x-admin.card>
            @endif
            @if (isset($charts['ai']))
                <x-admin.card title="AI requests" :subtitle="$rangeLabel">
                    <x-admin.bars-chart :data="$aiTrend" value-key="requests" color="bg-secondary-500" empty="No AI requests yet." />
                </x-admin.card>
            @endif
            @if (isset($charts['traffic']))
                <x-admin.card title="Page views" :subtitle="$rangeLabel">
                    <x-admin.bars-chart :data="$trafficTrend" color="bg-info-500" empty="No page views recorded yet." />
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
                            <x-admin.badge :tone="$chatbotStatus['enabled'] ? 'success' : 'slate'" dot>
                                {{ $chatbotStatus['enabled'] ? 'Enabled' : 'Disabled' }}
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
                                :tone="$aiStatus['configured'] && $aiStatus['enabled'] ? 'success' : ($aiStatus['configured'] ? 'warning' : 'slate')"
                                dot
                            >
                                {{ $aiStatus['enabled'] ? 'Enabled' : 'Disabled' }}
                            </x-admin.badge>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-slate-500 dark:text-slate-400">Provider</span>
                            <span class="text-sm font-medium">{{ $aiStatus['provider'] }}</span>
                        </div>
                        <a
                            href="{{ route('admin.ai.dashboard') }}"
                            class="inline-flex items-center gap-1.5 text-sm font-medium text-primary-600 hover:text-primary-700 dark:text-primary-400"
                        >
                            Open AI console
                            <x-icon name="arrow-right" class="h-4 w-4" />
                        </a>
                    </div>
                </x-admin.card>
            @endif
        </div>
    @endif

    <div class="mt-6 grid gap-6 lg:grid-cols-3">
        <div class="space-y-6 lg:col-span-2">
            @if (! empty($topPages))
                <x-admin.card title="Top pages" :subtitle="$rangeLabel">
                    <ul class="space-y-2">
                        @foreach ($topPages as $page)
                            <li class="flex items-center justify-between gap-4 text-sm">
                                <span class="truncate font-medium text-slate-700 dark:text-slate-300">{{ $page['label'] }}</span>
                                <x-admin.badge tone="primary">{{ number_format($page['value']) }} views</x-admin.badge>
                            </li>
                        @endforeach
                    </ul>
                </x-admin.card>
            @endif

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

        <div class="space-y-6">
            @if (! empty($quickActions))
                <x-admin.card title="Quick actions">
                    <div class="grid gap-2">
                        @foreach ($quickActions as $action)
                            <a
                                href="{{ $action['href'] }}"
                                class="flex items-center gap-3 rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-medium text-slate-700 transition hover:border-primary-500 hover:text-primary-700 dark:border-slate-800 dark:text-slate-300 dark:hover:border-primary-500"
                            >
                                <x-icon :name="$action['icon']" class="h-4 w-4" />
                                {{ $action['label'] }}
                            </a>
                        @endforeach
                    </div>
                </x-admin.card>
            @endif

            @if (! empty($securityEvents))
                <x-admin.card title="Security" subtitle="Recent sign-ins and sensitive changes">
                    <ul class="divide-y divide-slate-100 dark:divide-slate-800">
                        @foreach ($securityEvents as $event)
                            @php $failed = str_starts_with((string) $event->action, 'admin.login.failed'); @endphp
                            <li class="flex items-center gap-3 py-2.5 first:pt-0 last:pb-0">
                                <x-icon :name="$failed ? 'shield-exclamation' : 'shield-check'" :class="$failed ? 'h-4 w-4 shrink-0 text-error-500' : 'h-4 w-4 shrink-0 text-primary-500'" />
                                <div class="min-w-0">
                                    <p class="truncate text-sm text-slate-700 dark:text-slate-300">{{ $event->action }}</p>
                                    <p class="text-xs text-slate-500 dark:text-slate-400">{{ $event->administrator?->email ?? $event->description }} &middot; {{ $event->created_at->diffForHumans() }}</p>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </x-admin.card>
            @endif

            <x-admin.card title="System health">
                <ul class="space-y-2.5">
                    @foreach ($systemHealth as $check)
                        <li class="flex items-center justify-between gap-3">
                            <span class="text-sm text-slate-700 dark:text-slate-300">{{ $check['label'] }}</span>
                            <x-admin.badge
                                :tone="match ($check['status']) {
                                    'operational' => 'success',
                                    'warning' => 'warning',
                                    'not_configured' => 'slate',
                                    default => 'error',
                                }"
                                dot
                            >
                                {{ $check['status'] }}
                            </x-admin.badge>
                        </li>
                    @endforeach
                </ul>
                <p class="mt-3 border-t border-slate-100 pt-3 text-xs text-slate-400 dark:border-slate-800 dark:text-slate-500">
                    Health information reflects the serving environment.
                </p>
            </x-admin.card>
        </div>
    </div>

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
