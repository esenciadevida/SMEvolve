@props([
    'actionUrl' => null,
    'viewAllUrl' => null,
    'placeholder' => 'Search services, packages, FAQs...',
    'minQueryLength' => 2,
    'enableShortcuts' => true,
])

<div
    x-data="siteSearchBox({
        actionUrl: @js($actionUrl ?? route('search.autocomplete')),
        viewAllUrl: @js($viewAllUrl ?? route('search')),
        placeholder: @js($placeholder),
        minQueryLength: @js((int) $minQueryLength),
        enableShortcuts: @js((bool) $enableShortcuts),
    })"
    x-on:click.outside="close()"
    {{ $attributes->merge(['class' => 'relative']) }}
>
    <div class="relative">
        <x-icon name="magnifying-glass" class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400" />
        <input
            x-ref="input"
            type="search"
            x-model="query"
            x-on:input="onInput()"
            x-on:keydown.down.prevent="move(1)"
            x-on:keydown.up.prevent="move(-1)"
            x-on:keydown.enter.prevent="select()"
            x-on:keydown.esc="close()"
            x-on:focus="onFocus()"
            x-on:keydown.window="openOnSlash($event)"
            role="combobox"
            :aria-expanded="open"
            aria-controls="site-search-results"
            aria-autocomplete="list"
            aria-label="Search the website"
            :placeholder="placeholder"
            class="no-native-clear w-64 rounded-xl border border-gray-200 bg-white py-2 pl-9 pr-12 text-sm text-gray-900 shadow-sm transition placeholder:text-gray-400 focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/30 dark:border-gray-700 dark:bg-dark-card dark:text-white"
        >
    </div>

    <div
        id="site-search-results"
        x-show="open"
        x-cloak
        x-transition
        role="listbox"
        class="absolute right-0 top-full z-40 mt-2 w-[28rem] max-w-[90vw] overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-card-hover dark:border-gray-700 dark:bg-dark-card"
    >
        <template x-if="loading">
            <p class="px-4 py-6 text-center text-sm text-gray-500 dark:text-gray-400">Searching...</p>
        </template>

        <template x-if="! loading && error">
            <p class="px-4 py-6 text-center text-sm text-gray-500 dark:text-gray-400">Search is temporarily unavailable. Please try again.</p>
        </template>

        <template x-if="! loading && ! error && groupKeys.length === 0 && hasQuery">
            <p class="px-4 py-6 text-center text-sm text-gray-500 dark:text-gray-400" x-text="`No results found for &quot;${query}&quot;.`"></p>
        </template>

        <template x-if="! loading && ! error && groupKeys.length > 0">
            <div class="max-h-96 overflow-y-auto p-2">
                <template x-for="(items, group) in results" :key="group">
                    <div>
                        <p class="px-3 pb-1 pt-2 text-[11px] font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-500" x-text="group"></p>
                        <template x-for="item in items" :key="item.type + ':' + item.id">
                            <a
                                :href="item.url"
                                role="option"
                                :aria-selected="isHighlighted(item._searchIndex)"
                                class="flex items-center gap-3 rounded-xl px-3 py-2.5 transition"
                                :class="isHighlighted(item._searchIndex) ? 'bg-gray-100 dark:bg-gray-800' : 'hover:bg-gray-50 dark:hover:bg-gray-800/50'"
                                x-on:mouseenter="highlightIndex = item._searchIndex"
                            >
                                <span class="min-w-0 flex-1">
                                    <span class="block truncate text-sm font-medium text-gray-900 dark:text-white" x-text="item.title"></span>
                                    <span class="block truncate text-xs text-gray-500 dark:text-gray-400" x-text="item.subtitle"></span>
                                </span>
                                <x-icon name="arrow-right" class="h-4 w-4 shrink-0 text-gray-300 dark:text-gray-600" />
                            </a>
                        </template>
                    </div>
                </template>
            </div>
        </template>

        <div class="flex items-center justify-between gap-3 border-t border-gray-100 px-3 py-2 dark:border-gray-800">
            <a :href="viewAllLink()" class="text-xs font-medium text-primary-600 transition hover:underline dark:text-primary-400">View all results</a>
            <span class="text-[11px] text-gray-400 dark:text-gray-500">↑↓ navigate · ↵ open · esc close</span>
        </div>
    </div>
</div>
