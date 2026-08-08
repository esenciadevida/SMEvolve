@php
    $items = collect(config('navigation.main'))->sortBy('order');
@endphp

<nav aria-label="Primary" class="hidden xl:block">
    <ul class="flex items-center gap-0.5">
        @foreach ($items as $item)
            <li class="shrink-0">
                @if (($item['children'] ?? false))
                    <x-navigation.services-dropdown :active="request()->routeIs($item['active'])" />
                @else
                    <a
                        href="{{ route($item['route']) }}"
                        @class([
                            'nav-link inline-flex items-center whitespace-nowrap rounded-full px-3 py-2 text-sm font-medium transition duration-150',
                            'bg-primary-600/10 text-primary-700 dark:text-primary-400' => request()->routeIs($item['active']),
                            'text-gray-600 hover:bg-gray-100 hover:text-gray-900' => ! request()->routeIs($item['active']),
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
