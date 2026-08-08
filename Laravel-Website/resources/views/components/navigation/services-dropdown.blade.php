@props(['active' => false])

@php
    $services = collect(config('website.services', []));
@endphp

<div
    x-data="{ open: false }"
    class="relative"
    @keydown.escape.window="open = false"
    @mouseenter="open = true"
    @mouseleave="open = false"
    @click.outside="open = false"
    @focusout="if (! $el.contains($event.relatedTarget)) open = false"
>
    <button
        type="button"
        @click="open = true"
        :aria-expanded="open.toString()"
        aria-haspopup="menu"
        @class([
            'nav-link inline-flex items-center gap-1 whitespace-nowrap rounded-full px-3 py-2 text-sm font-medium transition duration-150 focus:outline-none focus-visible:ring-2 focus-visible:ring-primary-600 focus-visible:ring-offset-2',
            'bg-primary-600/10 text-primary-700 dark:text-primary-400' => $active,
            'text-gray-600 hover:bg-gray-100 hover:text-gray-900' => ! $active,
        ])
        :class="open && ! $active ? 'bg-gray-100 text-gray-900' : ''"
        data-track="nav:services:open"
    >
        Services
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4 transition-transform duration-200" :class="open ? 'rotate-180' : ''" aria-hidden="true">
            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 11.168l3.71-3.938a.75.75 0 1 1 1.08 1.04l-4.25 4.5a.75.75 0 0 1-1.08 0l-4.25-4.5a.75.75 0 0 1 .02-1.06Z" clip-rule="evenodd" />
        </svg>
    </button>

    <div class="absolute left-0 top-full z-50 pt-2">
        <div
            x-show="open"
            x-cloak
            x-transition:enter="transition duration-200 ease-out"
            x-transition:enter-start="opacity-0 translate-y-1 scale-[0.98]"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
            x-transition:leave="transition duration-150 ease-in"
            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
            x-transition:leave-end="opacity-0 translate-y-1 scale-[0.98]"
            class="w-[42rem] max-w-[calc(100vw-2.5rem)] origin-top-left rounded-2xl border border-gray-200/70 bg-white shadow-card-hover dark:bg-dark-card"
            role="menu"
            aria-label="Services"
        >
            <div class="flex items-center justify-between border-b border-gray-100 px-5 pb-3 pt-4">
                <p class="text-xs font-semibold uppercase tracking-widest text-gray-500">Our Services</p>
                <a
                    href="{{ route('services.index') }}"
                    class="group inline-flex items-center gap-1 text-xs font-semibold text-primary-600 transition hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300"
                    role="menuitem"
                    data-track="nav:services:all"
                >
                    View All Services
                    <x-icon name="arrow-right" class="h-3.5 w-3.5 transition-transform duration-150 group-hover:translate-x-0.5" />
                </a>
            </div>

            <div class="grid grid-cols-2 gap-1 p-3">
                @foreach ($services as $service)
                    @php
                        $isActive = request()->routeIs('services.show') && request()->route('service') === $service['slug'];
                    @endphp
                    <a
                        href="{{ route('services.show', $service['slug']) }}"
                        role="menuitem"
                        @class([
                            'group flex items-start gap-3 rounded-xl px-3 py-2.5 transition duration-150',
                            'bg-primary-600/5 ring-1 ring-primary-600/20' => $isActive,
                            'hover:bg-surface' => ! $isActive,
                        ])
                        data-track="nav:services:item"
                        data-track-data="{{ json_encode(['service' => $service['slug']]) }}"
                    >
                        <span class="flex h-9 w-9 flex-none items-center justify-center rounded-lg bg-primary-600/10 text-primary-600 transition duration-150 group-hover:bg-gradient-to-br group-hover:from-primary-600 group-hover:to-secondary-600 group-hover:text-white">
                            <x-icon :name="$service['icon']" class="h-4.5 w-4.5" />
                        </span>
                        <span class="min-w-0 flex-1">
                            <span class="flex items-center justify-between gap-2">
                                <span class="truncate text-sm font-semibold text-gray-900">{{ $service['name'] }}</span>
                                <x-icon name="arrow-right" class="h-3.5 w-3.5 flex-none text-primary-600 opacity-0 transition duration-150 group-hover:translate-x-0.5 group-hover:opacity-100" />
                            </span>
                            <span class="mt-0.5 block line-clamp-2 text-xs leading-relaxed text-gray-500">{{ $service['description'] }}</span>
                        </span>
                    </a>
                @endforeach
            </div>

            <div class="border-t border-gray-100 p-3">
                <a
                    href="{{ route('quote') }}"
                    class="group relative flex items-center gap-4 overflow-hidden rounded-xl bg-gradient-to-br from-primary-600 via-secondary-600 to-secondary-700 p-4"
                    role="menuitem"
                    data-track="nav:services:cta"
                >
                    <span class="pointer-events-none absolute -right-8 -top-10 h-24 w-24 rounded-full bg-white/10 blur-2xl" aria-hidden="true"></span>
                    <span class="relative flex h-10 w-10 flex-none items-center justify-center rounded-lg bg-white/15 text-white">
                        <x-icon name="sparkles" class="h-5 w-5" />
                    </span>
                    <span class="relative min-w-0 flex-1">
                        <span class="block text-sm font-semibold text-white">Not sure where to start?</span>
                        <span class="mt-0.5 block text-xs leading-relaxed text-white/70">Tell us your goal and we'll recommend the right solution.</span>
                    </span>
                    <span class="relative inline-flex flex-none items-center gap-1 rounded-lg bg-white px-3 py-2 text-xs font-semibold text-primary-700 transition group-hover:bg-primary-50">
                        Get a Free Quote
                        <x-icon name="arrow-right" class="h-3.5 w-3.5 transition-transform duration-150 group-hover:translate-x-0.5" />
                    </span>
                </a>
            </div>
        </div>
    </div>
</div>
