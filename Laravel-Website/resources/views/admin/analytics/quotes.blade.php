<x-layouts.admin-portal :title="'Quotes Analytics'">
    <x-admin.page-header title="Quotes Analytics" subtitle="Quote submission performance and funnel activity." />

    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <x-admin.stat-card label="Total Quotes" :value="number_format($quoteMetrics['total'])" icon="clipboard-document-list" tone="primary" />
        <x-admin.stat-card label="New" :value="number_format($quoteMetrics['new'])" icon="trending-up" tone="info" />
        <x-admin.stat-card label="In Progress" :value="number_format($quoteMetrics['in_progress'])" icon="clock" tone="warning" />
        <x-admin.stat-card label="Completed" :value="number_format($quoteMetrics['completed'])" icon="check-circle" tone="success" />
    </div>

    <div class="mt-6 grid gap-6 lg:grid-cols-2">
        <x-admin.card title="Quote submissions" subtitle="Last 30 days">
            <x-admin.bars-chart :data="$quoteTrend" color="bg-primary-500" empty="No quote submissions yet." />
        </x-admin.card>

        <x-admin.card title="By status">
            <x-admin.donut-chart :data="$quoteStatus" empty="No quotes yet." />
        </x-admin.card>
    </div>

    <div class="mt-6">
        <x-admin.card title="Quote funnel" subtitle="Visitor journeys">
            <div class="grid gap-6 sm:grid-cols-3">
                @foreach ($funnel as $stage)
                    <div class="rounded-xl border border-slate-100 p-4 dark:border-slate-800">
                        <p class="text-2xl font-semibold tabular-nums text-slate-900 dark:text-slate-100">{{ number_format($stage['value']) }}</p>
                        <p class="mt-0.5 text-sm text-slate-500 dark:text-slate-400">{{ $stage['label'] }}</p>
                    </div>
                @endforeach
            </div>
        </x-admin.card>
    </div>
</x-layouts.admin-portal>
