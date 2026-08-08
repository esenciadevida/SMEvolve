@php
    $items = collect(config('navigation.main'))->sortBy('order');
    $whatsapp = config('company.contact.whatsapp');
@endphp

<div
    x-show="mobileOpen"
    x-cloak
    class="fixed inset-0 z-[60] xl:hidden"
    id="mobile-menu"
    role="dialog"
    aria-modal="true"
    aria-label="Navigation menu"
    x-transition:enter="transition duration-300 ease-out"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition duration-200 ease-in"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
>
    <div class="absolute inset-0 bg-dark/60 backdrop-blur-sm" aria-hidden="true" @click="mobileOpen = false"></div>

    <div
        class="absolute inset-y-0 right-0 flex w-full max-w-sm flex-col overflow-y-auto bg-white shadow-2xl dark:bg-dark-card"
        x-transition:enter="transition duration-300 ease-out"
        x-transition:enter-start="translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transition duration-200 ease-in"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="translate-x-full"
    >
        <div class="flex items-center justify-between border-b border-gray-200/60 px-6 py-4">
            <x-logo />

            <button
                type="button"
                @click="mobileOpen = false"
                class="inline-flex h-10 w-10 items-center justify-center rounded-xl text-gray-600 transition hover:bg-gray-100 hover:text-gray-900"
                aria-label="Close navigation menu"
                data-track="nav:mobile:close"
            >
                <x-icon name="x-mark" class="h-6 w-6" />
            </button>
        </div>

        <div class="border-b border-gray-200/60 px-6 py-4">
            <form method="GET" action="{{ route('search') }}" role="search" @submit="mobileOpen = false">
                <label for="mobile-site-search-input" class="sr-only">Search the website</label>
                <div class="relative">
                    <x-icon name="magnifying-glass" class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400" />
                    <input
                        id="mobile-site-search-input"
                        name="q"
                        type="search"
                        placeholder="Search services, packages, FAQs..."
                        autocomplete="off"
                        class="w-full rounded-xl border border-gray-200 bg-gray-50 py-2.5 pl-9 pr-4 text-sm text-gray-900 transition placeholder:text-gray-400 focus:border-primary-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary-500/30 dark:border-gray-700 dark:bg-dark dark:text-white"
                    />
                </div>
            </form>
        </div>

        <nav aria-label="Mobile" class="flex-1 overflow-y-auto px-4 py-4">
            <ul class="space-y-1">
                @foreach ($items as $item)
                    <li x-data="{ subOpen: false }">
                        @if (($item['children'] ?? false))
                            <button
                                type="button"
                                @click="subOpen = !subOpen"
                                :aria-expanded="subOpen.toString()"
                                @class([
                                    'flex w-full items-center justify-between rounded-xl px-4 py-3 text-base font-semibold transition',
                                    'bg-primary-600/10 text-primary-700 dark:text-primary-400' => request()->routeIs($item['active']),
                                    'text-gray-800 hover:bg-gray-50' => ! request()->routeIs($item['active']),
                                ])
                                data-track="nav:services:open"
                            >
                                {{ $item['label'] }}
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5 transition-transform duration-200" :class="subOpen ? 'rotate-180' : ''" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 11.168l3.71-3.938a.75.75 0 1 1 1.08 1.04l-4.25 4.5a.75.75 0 0 1-1.08 0l-4.25-4.5a.75.75 0 0 1 .02-1.06Z" clip-rule="evenodd" />
                                </svg>
                            </button>

                            <ul
                                x-show="subOpen"
                                x-cloak
                                x-transition:enter="transition duration-200 ease-out"
                                x-transition:enter-start="opacity-0 -translate-y-1"
                                x-transition:enter-end="opacity-100 translate-y-0"
                                x-transition:leave="transition duration-150 ease-in"
                                x-transition:leave-start="opacity-100 translate-y-0"
                                x-transition:leave-end="opacity-0 -translate-y-1"
                                class="mt-1 space-y-0.5 border-l-2 border-primary-600/20 pl-3"
                            >
                                @foreach (config('website.services', []) as $service)
                                    <li>
                                        <a
                                            href="{{ route('services.show', $service['slug']) }}"
                                            @click="mobileOpen = false"
                                            class="block rounded-lg px-3 py-2.5 text-sm font-medium text-gray-600 transition hover:bg-gray-50 hover:text-gray-900"
                                            @class(['bg-primary-50 text-primary-700 dark:bg-primary-600/15 dark:text-primary-400' => request()->routeIs('services.show') && request()->route('service') === $service['slug']])
                                            data-track="nav:services:item"
                                            data-track-data="{{ json_encode(['service' => $service['slug']]) }}"
                                        >
                                            {{ $service['name'] }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <a
                                href="{{ route($item['route']) }}"
                                @click="mobileOpen = false"
                                @class([
                                    'block rounded-xl px-4 py-3 text-base font-semibold transition',
                                    'bg-primary-600/10 text-primary-700 dark:text-primary-400' => request()->routeIs($item['active']),
                                    'text-gray-800 hover:bg-gray-50' => ! request()->routeIs($item['active']),
                                ])
                                @if (request()->routeIs($item['active'])) aria-current="page" @endif
                                data-track="nav:click"
                                data-track-data="{{ json_encode(['label' => $item['label']]) }}"
                            >
                                {{ $item['label'] }}
                            </a>
                        @endif
                    </li>
                @endforeach
            </ul>
        </nav>

        <div class="space-y-3 border-t border-gray-200/60 p-6">
            <x-buttons.button href="{{ route('quote') }}" class="w-full" @click="mobileOpen = false" data-track="cta:quote:mobile">
                Get a Free Quote
            </x-buttons.button>

            @if ($whatsapp)
                <a
                    href="{{ $whatsapp }}"
                    target="_blank"
                    rel="noopener"
                    class="flex w-full items-center justify-center gap-2 rounded-xl border border-accent-500/40 bg-accent-500/5 px-6 py-3 text-sm font-semibold text-accent-700 transition hover:bg-accent-500/10 dark:text-accent-400"
                    data-track="nav:whatsapp"
                >
                    <x-icon name="chat-bubble-left-right" class="h-5 w-5" />
                    Chat on WhatsApp
                </a>
            @endif
        </div>
    </div>
</div>
