@props([
    'items' => [],
    'variant' => 'light',
])

@php
    $muted = $variant === 'dark' ? 'text-slate-400' : 'text-gray-500';
    $current = $variant === 'dark' ? 'text-white' : 'text-gray-900';
    $link = $variant === 'dark' ? 'hover:text-primary-300' : 'hover:text-primary-600';
    $chevron = $variant === 'dark' ? 'text-slate-600' : 'text-gray-400';
@endphp

<nav aria-label="Breadcrumb">
    <ol class="flex flex-wrap items-center gap-1.5 text-sm {{ $muted }}">
        <li>
            <a href="{{ route('home') }}" class="transition {{ $link }}">Home</a>
        </li>

        @foreach ($items as $item)
            <li class="flex items-center gap-1.5">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4 {{ $chevron }}" aria-hidden="true">
                    <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 0 1 .02-1.06L11.168 10 7.23 6.29a.75.75 0 1 1 1.04-1.08l4.5 4.25a.75.75 0 0 1 0 1.08l-4.5 4.25a.75.75 0 0 1-1.06-.02Z" clip-rule="evenodd" />
                </svg>

                @if (isset($item['url']))
                    <a href="{{ $item['url'] }}" class="transition {{ $link }}">{{ $item['label'] }}</a>
                @else
                    <span aria-current="page" class="{{ $current }}">{{ $item['label'] }}</span>
                @endif
            </li>
        @endforeach
    </ol>
</nav>
