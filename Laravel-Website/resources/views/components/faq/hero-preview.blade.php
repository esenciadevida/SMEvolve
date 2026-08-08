@props([
    'suggestion' => 'Try searching for "website packages"',
])

<div class="relative w-full max-w-md lg:max-w-lg">
    <div class="rounded-3xl border border-white/10 bg-white/95 p-6 shadow-2xl shadow-black/20 backdrop-blur dark:bg-dark-card dark:border-gray-200">
        <div class="flex items-center gap-3">
            <span class="flex h-10 w-10 flex-none items-center justify-center rounded-xl bg-gradient-to-br from-primary-600 to-secondary-600 text-white shadow-lg shadow-primary-600/30">
                <x-icon name="magnifying-glass" class="h-5 w-5" />
            </span>
            <div>
                <p class="text-sm font-semibold text-gray-900 dark:text-white">Knowledge Center</p>
                <p class="text-xs text-gray-500 dark:text-gray-400">Instant answers, whenever you need them</p>
            </div>
            <span class="ml-auto flex items-center gap-1.5 rounded-full bg-accent-500/10 px-2.5 py-1 text-[10px] font-bold text-accent-600 dark:text-accent-400">
                <span class="h-1.5 w-1.5 rounded-full bg-accent-500"></span>
                LIVE
            </span>
        </div>

        <label for="faq-hero-input" class="sr-only">Search frequently asked questions</label>
        <div class="relative mt-5">
            <x-icon name="magnifying-glass" class="pointer-events-none absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400" />
            <input
                type="search"
                id="faq-hero-input"
                x-model="query"
                @input="onSearchInput()"
                @focus="track('faq:search:focus')"
                :placeholder="placeholder"
                placeholder="Search for answers..."
                autocomplete="off"
                aria-label="Search frequently asked questions"
                class="w-full rounded-xl border-0 bg-gray-100 py-3 pl-10 pr-3 text-sm text-gray-900 ring-1 ring-inset ring-gray-200 placeholder:text-gray-400 transition focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary-600 dark:bg-gray-800 dark:text-white dark:ring-gray-700 dark:focus:bg-gray-900"
            />
        </div>

        <p class="mt-3 flex items-center justify-between text-xs text-gray-500 dark:text-gray-400">
            <span aria-live="polite">
                <span class="font-semibold text-gray-900 dark:text-white" x-text="filtered.length"></span>
                <span x-text="filtered.length === 1 ? ' question matches' : ' questions match'"></span>
            </span>
            <span class="hidden sm:inline">{{ $suggestion }}</span>
        </p>

        <div class="mt-4 flex flex-wrap gap-2" role="group" aria-label="Browse FAQ categories">
            <template x-for="cat in quickCategories" :key="cat.id">
                <button
                    type="button"
                    @click="selectCategory(cat.id)"
                    :class="category === cat.id
                        ? 'border-transparent bg-gradient-to-r from-primary-600 to-secondary-600 text-white shadow-md shadow-primary-600/25'
                        : 'border-gray-200 bg-white text-gray-600 hover:border-primary-300 hover:text-gray-900 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:text-white'"
                    class="inline-flex items-center gap-1.5 rounded-full border px-3 py-1.5 text-xs font-semibold transition focus:outline-none focus-visible:ring-2 focus-visible:ring-primary-600 focus-visible:ring-offset-2 dark:focus-visible:ring-offset-gray-900"
                    :aria-pressed="category === cat.id"
                >
                    <span x-text="cat.name"></span>
                </button>
            </template>
        </div>
    </div>

    <div class="absolute -bottom-6 -left-6 hidden animate-float-slow items-center gap-2.5 rounded-2xl border border-gray-100 bg-white/90 px-4 py-3 shadow-xl shadow-slate-900/10 backdrop-blur sm:flex dark:border-gray-200 dark:bg-dark-card/90">
        <span class="flex h-9 w-9 flex-none items-center justify-center rounded-xl bg-gradient-to-br from-primary-600 to-secondary-600 text-white">
            <x-icon name="sparkles" class="h-4 w-4" />
        </span>
        <div>
            <p class="text-sm font-semibold text-gray-900 dark:text-white">Instant Search</p>
            <p class="text-xs text-gray-500 dark:text-gray-400">Answers in seconds</p>
        </div>
    </div>

    <div class="absolute -right-3 -top-3 animate-float">
        <div class="flex items-center gap-1.5 rounded-full bg-gradient-to-r from-accent-500 to-emerald-600 px-4 py-2 text-xs font-bold text-white shadow-lg shadow-accent-500/30">
            <x-icon name="lifebuoy" class="h-3.5 w-3.5" />
            Expert Support
        </div>
    </div>
</div>
