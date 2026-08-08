<x-layouts.admin-portal :title="'Search'">
    <x-admin.page-header
        title="Search"
        subtitle="Find quotes, administrators, settings, knowledge and audit entries across the admin portal."
    />

    <form method="GET" action="{{ route('admin.search') }}" class="mb-8">
        <div class="flex gap-3">
            <x-admin.search.input value="{{ $query }}" />
            <button type="submit" class="inline-flex shrink-0 items-center gap-2 rounded-xl bg-primary-600 px-5 text-sm font-semibold text-white transition hover:bg-primary-700">
                <x-icon name="magnifying-glass" class="h-4 w-4" />
                Search
            </button>
        </div>

        @if (count($availableTypes) > 0)
            <div class="mt-4 flex flex-wrap items-center gap-2">
                <span class="text-xs font-medium uppercase tracking-wider text-slate-400">Filter:</span>
                <a
                    href="{{ route('admin.search', $query !== '' ? ['q' => $query] : []) }}"
                    @class([
                        'rounded-full px-3 py-1 text-xs font-medium transition',
                        'bg-primary-600 text-white shadow-sm' => $activeType === null,
                        'bg-slate-100 text-slate-600 hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700' => $activeType !== null,
                    ])
                >
                    All
                </a>
                @foreach ($availableTypes as $key => $label)
                    <a
                        href="{{ route('admin.search', array_filter(['q' => $query, 'type' => $key])) }}"
                        @class([
                            'rounded-full px-3 py-1 text-xs font-medium transition',
                            'bg-primary-600 text-white shadow-sm' => $activeType === $key,
                            'bg-slate-100 text-slate-600 hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700' => $activeType !== $key,
                        ])
                    >
                        {{ $label }}
                    </a>
                @endforeach
            </div>
        @endif
    </form>

    @if ($query === '')
        <x-admin.search.empty-state
            icon="magnifying-glass"
            title="Search across the admin portal"
            subtitle="Enter a quote reference, customer name, administrator, setting key, knowledge item, or audit entry to find what you are looking for."
        />
    @elseif ($totalResults === 0)
        <x-admin.search.empty-state
            title="No results found"
            :subtitle="'No results found for \"' . e($query) . '\". Try a different name, quote reference, or keyword.'"
        />
    @else
        <p class="mb-4 text-sm text-slate-500 dark:text-slate-400">
            {{ $totalResults }} result(s) for
            <strong class="font-semibold text-slate-900 dark:text-slate-100">&quot;{{ $query }}&quot;</strong>
        </p>

        <x-admin.search.results :results="$results" :labels="$availableTypes" />
    @endif
</x-layouts.admin-portal>
