@php
    $searchMeta = [
        'title' => 'Search SMEvolve',
        'description' => 'Search SMEvolve for services, packages, portfolio projects, FAQs, and pages across the website.',
    ];
@endphp

<x-layouts.app
    :title="$searchMeta['title']"
    :description="$searchMeta['description']"
    :canonical="route('search')"
    robots="noindex, follow"
>
    <x-sections.page-hero
        id="search"
        eyebrow="SEARCH"
        heading="Find It Across SMEvolve"
        description="Search our services, packages, portfolio projects, FAQs, and pages. Can't find what you need? Our team is happy to help."
        variant="automation"
        :visual="false"
        :full="false"
        :breadcrumb="[['label' => 'Search']]"
    >
        <x-buttons.button variant="primary" :href="route('contact')" data-track="search:hero:contact">
            Contact Our Team
        </x-buttons.button>

        <x-buttons.button variant="outline-white" :href="route('quote')" data-track="search:hero:quote">
            Start Quote Wizard
        </x-buttons.button>
    </x-sections.page-hero>

    <x-sections.section id="search-results" variant="surface">
        <div class="mx-auto max-w-3xl">
            <form method="GET" action="{{ route('search') }}" role="search">
                <div class="flex gap-3">
                    <div class="relative flex-1">
                        <x-icon name="magnifying-glass" class="pointer-events-none absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 text-gray-400" />
                        <label for="site-search-page-input" class="sr-only">Search</label>
                        <input
                            id="site-search-page-input"
                            name="q"
                            type="search"
                            value="{{ $query }}"
                            placeholder="Try &quot;website&quot;, &quot;ecommerce&quot;, or &quot;pricing&quot;..."
                            autocomplete="off"
                            class="w-full rounded-2xl border border-gray-200 bg-white py-4 pl-12 pr-4 text-base text-gray-900 shadow-sm transition placeholder:text-gray-400 focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/30 dark:border-gray-700 dark:bg-dark-card dark:text-white"
                        />
                    </div>

                    <button
                        type="submit"
                        class="inline-flex shrink-0 items-center gap-2 rounded-2xl bg-primary-600 px-6 text-sm font-semibold text-white transition hover:bg-primary-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-primary-600 focus-visible:ring-offset-2 dark:focus-visible:ring-offset-dark"
                        data-track="search:submit"
                    >
                        <x-icon name="magnifying-glass" class="h-4 w-4" />
                        Search
                    </button>
                </div>

                @if (count($availableTypes) > 0)
                    <div class="mt-5 flex flex-wrap items-center gap-2">
                        <span class="text-xs font-medium uppercase tracking-wider text-gray-400">Filter:</span>

                        <a
                            href="{{ route('search', $query !== '' ? ['q' => $query] : []) }}"
                            @class([
                                'rounded-full px-3 py-1 text-xs font-medium transition',
                                'bg-primary-600 text-white shadow-sm' => $activeType === null,
                                'bg-white text-gray-600 ring-1 ring-gray-200 hover:bg-gray-50 hover:text-gray-900 dark:bg-dark-card dark:text-gray-300 dark:ring-gray-700 dark:hover:bg-gray-800' => $activeType !== null,
                            ])
                        >
                            All
                        </a>

                        @foreach ($availableTypes as $key => $label)
                            <a
                                href="{{ route('search', array_filter(['q' => $query, 'type' => $key])) }}"
                                @class([
                                    'rounded-full px-3 py-1 text-xs font-medium transition',
                                    'bg-primary-600 text-white shadow-sm' => $activeType === $key,
                                    'bg-white text-gray-600 ring-1 ring-gray-200 hover:bg-gray-50 hover:text-gray-900 dark:bg-dark-card dark:text-gray-300 dark:ring-gray-700 dark:hover:bg-gray-800' => $activeType !== $key,
                                ])
                            >
                                {{ $label }}
                            </a>
                        @endforeach
                    </div>
                @endif
            </form>

            <div class="mt-10">
                @if ($query === '')
                    <x-search.empty-state
                        icon="magnifying-glass"
                        title="Search across the SMEvolve website"
                        subtitle="Enter a service name, package, project, question, or page to find what you are looking for."
                    />
                @elseif ($totalResults === 0)
                    <x-search.empty-state
                        icon="exclamation-triangle"
                        title="No results found"
                        :subtitle="'No results found for &quot;' . e($query) . '&quot;. Try a different keyword, or contact our team and we&#39;ll help directly.'"
                    />
                @else
                    <p class="mb-4 text-sm text-gray-500 dark:text-gray-400">
                        {{ $totalResults }} result(s) for
                        <strong class="font-semibold text-gray-900 dark:text-white">&quot;{{ $query }}&quot;</strong>
                    </p>

                    <x-search.results :results="$results" :labels="$availableTypes" />
                @endif
            </div>
        </div>
    </x-sections.section>

    <x-sections.final-cta context="search" />
</x-layouts.app>
