<x-layouts.admin-portal :title="'Traffic & Engagement'">
    <x-admin.page-header title="Traffic & Engagement" subtitle="Anonymous page-view analytics from server-side tracking." />

    <form method="GET" action="{{ route('admin.analytics.traffic') }}" class="mb-6 flex items-center gap-2">
        <select
            name="days"
            onchange="this.form.submit()"
            class="rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100"
            aria-label="Date range"
        >
            @foreach ([7 => 'Last 7 days', 14 => 'Last 14 days', 30 => 'Last 30 days', 90 => 'Last 90 days'] as $value => $label)
                <option value="{{ $value }}" @selected($days === $value)>{{ $label }}</option>
            @endforeach
        </select>
    </form>

    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <x-admin.stat-card label="Visitors" :value="number_format($summary['visitors'])" icon="users" tone="primary" />
        <x-admin.stat-card label="Page Views" :value="number_format($summary['page_views'])" icon="eye" tone="info" />
        <x-admin.stat-card label="Views / Visitor" :value="number_format($summary['avg_views_per_visitor'], 1)" icon="chart-bar" tone="secondary" />
        <x-admin.stat-card label="Views Today" :value="number_format($summary['views_today'])" icon="bolt" tone="success" />
    </div>

    <div class="mt-6 grid gap-6 lg:grid-cols-2">
        <x-admin.card title="Page views" subtitle="Selected period">
            <x-admin.bars-chart :data="$trend" color="bg-info-500" empty="No page views recorded yet." />
        </x-admin.card>

        <div class="space-y-6">
            <x-admin.card title="Top pages">
                @if (count($topPages) === 0)
                    <p class="py-6 text-center text-sm text-slate-400 dark:text-slate-500">No data yet.</p>
                @else
                    <ul class="space-y-2">
                        @foreach ($topPages as $page)
                            <li class="flex items-center justify-between gap-4 text-sm">
                                <span class="truncate font-medium text-slate-700 dark:text-slate-300">{{ $page['label'] }}</span>
                                <x-admin.badge tone="primary">{{ number_format($page['value']) }}</x-admin.badge>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </x-admin.card>

            <x-admin.card title="Top referrers">
                @if (count($topReferrers) === 0)
                    <p class="py-6 text-center text-sm text-slate-400 dark:text-slate-500">No external referrers recorded.</p>
                @else
                    <ul class="space-y-2">
                        @foreach ($topReferrers as $referrer)
                            <li class="flex items-center justify-between gap-4 text-sm">
                                <span class="truncate font-medium text-slate-700 dark:text-slate-300">{{ $referrer['label'] }}</span>
                                <x-admin.badge tone="slate">{{ number_format($referrer['value']) }}</x-admin.badge>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </x-admin.card>
        </div>
    </div>

    <div class="mt-6 grid gap-6 lg:grid-cols-3">
        <x-admin.card title="Devices">
            <x-admin.donut-chart :data="$devices" empty="No device data yet." />
        </x-admin.card>
        <x-admin.card title="Browsers">
            <x-admin.donut-chart :data="$browsers" empty="No browser data yet." />
        </x-admin.card>
        <x-admin.card title="Operating systems">
            <x-admin.donut-chart :data="$oss" empty="No OS data yet." />
        </x-admin.card>
    </div>

    <p class="mt-6 text-xs text-slate-400 dark:text-slate-500">
        Tracking is anonymous: raw IP addresses are never stored. Bots are filtered and per-visitor volume is rate-limited.
    </p>
</x-layouts.admin-portal>
