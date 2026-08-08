<div
    x-data="{ mobileOpen: false }"
    @keydown.escape.window="mobileOpen = false"
    class="relative z-50"
>
    <header
        class="fixed inset-x-0 top-0 z-50 border-b border-gray-200/60 bg-white/80 shadow-sm shadow-slate-900/5 backdrop-blur-xl transition duration-300 dark:border-gray-600/50 dark:bg-dark-card/80"
    >
        <div aria-hidden="true" class="h-0.5 bg-gradient-to-r from-primary-600 via-secondary-500 to-accent-500"></div>

        <div class="mx-auto flex h-22 max-w-site items-center justify-between gap-6 px-6 lg:px-8">
            <div class="shrink-0">
                <x-logo />
            </div>

            <x-navigation.menu variant="desktop" />

            <div class="flex shrink-0 items-center gap-2">
                <a
                    href="{{ route('search') }}"
                    class="hidden items-center justify-center rounded-full p-2.5 text-gray-600 transition hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus-visible:ring-2 focus-visible:ring-primary-600 focus-visible:ring-offset-2 sm:inline-flex xl:hidden"
                    aria-label="Search the website"
                    title="Search the website"
                    data-track="search:header:link"
                >
                    <x-icon name="magnifying-glass" class="h-5 w-5" />
                </a>

                <button
                    type="button"
                    @click="$store.theme.toggle()"
                    class="inline-flex items-center justify-center rounded-full p-2.5 text-gray-600 transition hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus-visible:ring-2 focus-visible:ring-primary-600 focus-visible:ring-offset-2"
                    aria-label="Toggle dark mode"
                    data-track="theme:toggle"
                >
                    <x-icon name="sun" class="h-5 w-5" x-show="! $store.theme.dark" x-cloak />
                    <x-icon name="moon" class="h-5 w-5" x-show="$store.theme.dark" x-cloak />
                </button>

                <x-search.site-search-box class="hidden xl:block" />

                <x-buttons.button href="{{ route('quote') }}" class="hidden sm:inline-flex" data-track="cta:quote:header">
                    Get a Free Quote
                </x-buttons.button>

                <button
                    type="button"
                    class="-mr-2 inline-flex items-center justify-center rounded-xl p-2.5 text-gray-600 transition hover:bg-gray-100 hover:text-gray-900 xl:hidden"
                    @click="mobileOpen = !mobileOpen"
                    :aria-expanded="mobileOpen.toString()"
                    aria-controls="mobile-menu"
                    aria-label="Toggle navigation menu"
                    data-track="nav:mobile:toggle"
                >
                    <svg x-show="! mobileOpen" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                    <svg x-show="mobileOpen" x-cloak xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </header>

    <x-navigation.mobile-menu />
</div>
