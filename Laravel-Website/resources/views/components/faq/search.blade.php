@props([
    'id' => 'faq-search',
    'heading' => 'Search Our Knowledge Center',
    'description' => 'Find answers instantly, search across questions, answers, categories, and keywords, or browse by topic.',
    'faqs' => [],
    'categories' => [],
])

<section id="{{ $id }}" class="bg-white dark:bg-dark" aria-labelledby="{{ $id }}-heading">
    <div class="mx-auto w-full max-w-site px-6 py-16 lg:px-8 lg:py-20">
        <header class="mx-auto max-w-3xl text-center">
            <p class="text-sm font-semibold uppercase tracking-widest text-primary-600">Search FAQ</p>
            <h2 id="{{ $id }}-heading" class="mt-3 text-balance text-3xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-4xl">{{ $heading }}</h2>
            <p class="mt-4 text-lg leading-relaxed text-gray-600 dark:text-gray-400">{{ $description }}</p>
        </header>

        <div class="mx-auto mt-10 max-w-2xl">
            <label for="faq-search-input" class="sr-only">Search frequently asked questions</label>
            <div class="relative">
                <x-icon name="magnifying-glass" class="pointer-events-none absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 text-gray-400" />
                <input
                    type="search"
                    id="faq-search-input"
                    name="faq-search"
                    x-model="query"
                    @input="onSearchInput()"
                    @focus="track('faq:search:focus')"
                    @keydown.enter="track('faq:search:submit', { query: query })"
                    :placeholder="placeholder"
                    placeholder="Search for answers..."
                    autocomplete="off"
                    class="w-full rounded-2xl border-0 bg-gray-100 py-4 pl-12 pr-12 text-base text-gray-900 shadow-sm ring-1 ring-inset ring-gray-200 transition placeholder:text-gray-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary-600 dark:bg-dark-card dark:text-white dark:ring-gray-700 dark:focus:bg-dark-card"
                />
                <button
                    type="button"
                    x-show="query.length > 0"
                    x-cloak
                    @click="clearSearch()"
                    class="absolute right-3 top-1/2 -translate-y-1/2 rounded-full p-1.5 text-gray-400 transition hover:bg-gray-200 hover:text-gray-600 focus:outline-none focus-visible:ring-2 focus-visible:ring-primary-600 dark:hover:bg-gray-700 dark:hover:text-gray-200"
                    aria-label="Clear search"
                >
                    <x-icon name="x-mark" class="h-4 w-4" />
                </button>
            </div>

            <p class="mt-3 text-sm text-gray-500 dark:text-gray-400" aria-live="polite">
                <span class="font-semibold text-gray-900 dark:text-white" x-text="filtered.length"></span>
                <span x-text="filtered.length === 1 ? ' result found' : ' results found'"></span>
            </p>
        </div>

        <div class="mx-auto mt-8 max-w-4xl">
            <div class="flex flex-wrap justify-center gap-2.5" role="group" aria-label="Filter FAQs by category">
                <template x-for="cat in categories" :key="cat.id">
                    <button
                        type="button"
                        @click="selectCategory(cat.id)"
                        :class="category === cat.id
                            ? 'bg-gradient-to-r from-primary-600 to-secondary-600 text-white shadow-md shadow-primary-600/25 ring-primary-600'
                            : 'bg-white text-gray-700 ring-gray-200 hover:bg-gray-50 hover:text-gray-900 hover:ring-primary-300 dark:bg-dark-card dark:text-gray-300 dark:ring-gray-700 dark:hover:bg-gray-800 dark:hover:text-white'"
                        class="inline-flex items-center gap-2 rounded-full px-4 py-2 text-sm font-semibold ring-1 ring-inset transition focus:outline-none focus-visible:ring-2 focus-visible:ring-primary-600 focus-visible:ring-offset-2 dark:focus-visible:ring-offset-dark"
                        :aria-pressed="category === cat.id"
                    >
                        <span x-text="cat.name"></span>
                        <span
                            class="rounded-full px-2 py-0.5 text-xs font-semibold"
                            :class="category === cat.id ? 'bg-white/20 text-white' : 'bg-gray-100 text-gray-500 dark:bg-gray-700 dark:text-gray-300'"
                            x-text="categoryCount(cat.id)"
                            aria-hidden="true"
                        ></span>
                    </button>
                </template>
            </div>
        </div>

        <div class="mx-auto mt-12 max-w-3xl space-y-4 text-left" @faq-toggle.window="track('faq:question:toggle', { group: $event.detail.group, question: $event.detail.id })">
            @foreach ($faqs as $item)
                <div x-show="matchesSearch({{ Js::from($item) }})" x-transition:enter="transition duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                    <x-faq.accordion
                        :question="$item['question']"
                        :answer="$item['answer']"
                        :links="$item['related_pages'] ?? []"
                        :question-id="$item['id']"
                        group="faq-page"
                        :open="$loop->first"
                    />
                </div>
            @endforeach
        </div>

        <div x-show="filtered.length === 0" x-cloak class="mx-auto mt-12 max-w-2xl text-center">
            <template x-if="query.trim() !== ''">
                <div class="rounded-3xl border border-gray-200 bg-white px-6 py-12 shadow-sm dark:border-gray-700 dark:bg-dark-card">
                    <span class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-primary-600/10">
                        <x-icon name="magnifying-glass" class="h-6 w-6 text-primary-600" />
                    </span>
                    <h3 class="mt-5 text-xl font-bold tracking-tight text-gray-900 dark:text-white">Can&#39;t find the answer you&#39;re looking for?</h3>
                    <p class="mt-2 text-base leading-relaxed text-gray-600 dark:text-gray-400">No matching questions found. Try checking your spelling or using different keywords, or contact our team and we&#39;ll help directly.</p>
                    <ul class="mx-auto mt-4 max-w-sm space-y-1.5 text-left text-sm text-gray-600 dark:text-gray-400">
                        <li class="flex items-start gap-2">
                            <x-icon name="check-circle" class="mt-0.5 h-4 w-4 flex-none text-accent-500" />
                            Check your spelling or try different keywords.
                        </li>
                        <li class="flex items-start gap-2">
                            <x-icon name="check-circle" class="mt-0.5 h-4 w-4 flex-none text-accent-500" />
                            Browse the categories above to explore related topics.
                        </li>
                        <li class="flex items-start gap-2">
                            <x-icon name="check-circle" class="mt-0.5 h-4 w-4 flex-none text-accent-500" />
                            Contact our team for a personal answer.
                        </li>
                    </ul>
                    <div class="mt-7 flex flex-wrap justify-center gap-3">
                        <x-buttons.primary-button href="{{ route('contact') }}" data-track="faq:no-results:contact">Contact Support</x-buttons.primary-button>
                        <x-buttons.secondary-button href="{{ route('quote') }}" data-track="faq:no-results:quote">Request a Quote</x-buttons.secondary-button>
                    </div>
                </div>
            </template>

            <template x-if="query.trim() === ''">
                <div class="rounded-3xl border border-gray-200 bg-white px-6 py-12 shadow-sm dark:border-gray-700 dark:bg-dark-card">
                    <span class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-primary-600/10">
                        <x-icon name="information-circle" class="h-6 w-6 text-primary-600" />
                    </span>
                    <h3 class="mt-5 text-xl font-bold tracking-tight text-gray-900 dark:text-white">No questions are currently available in this category.</h3>
                    <p class="mt-2 text-base leading-relaxed text-gray-600 dark:text-gray-400">Browse all questions below or contact our team, we&#39;re happy to help you find the answer.</p>
                    <div class="mt-7 flex flex-wrap justify-center gap-3">
                        <x-buttons.primary-button href="{{ route('contact') }}" data-track="faq:empty:contact">Contact Our Team</x-buttons.primary-button>
                        <x-buttons.secondary-button @click="selectCategory('all')" data-track="faq:empty:view-all">View All Questions</x-buttons.secondary-button>
                    </div>
                </div>
            </template>
        </div>
    </div>
</section>
