@props([
    'title' => 'Admin Portal',
])

@php
    $administrator = auth('admin')->user();

    $groups = [
        'Overview' => [
            ['label' => 'Dashboard', 'icon' => 'home', 'route' => route('admin.dashboard'), 'active' => request()->routeIs('admin.dashboard'), 'visible' => $administrator?->hasPermission('dashboard.view') ?? false],
        ],
        'Analytics' => [
            ['label' => 'Traffic & Engagement', 'icon' => 'chart-bar', 'route' => route('admin.analytics.traffic'), 'active' => request()->routeIs('admin.analytics.traffic'), 'visible' => $administrator?->hasPermission('analytics.view') ?? false],
            ['label' => 'Quotes Analytics', 'icon' => 'clipboard-document-list', 'route' => route('admin.analytics.quotes'), 'active' => request()->routeIs('admin.analytics.quotes'), 'visible' => ($administrator?->hasPermission('analytics.view') && $administrator?->hasPermission('quotes.view')) ?? false],
            ['label' => 'Chatbot Analytics', 'icon' => 'chat-bubble-left-right', 'route' => route('admin.analytics.chatbot'), 'active' => request()->routeIs('admin.analytics.chatbot'), 'visible' => ($administrator?->hasPermission('analytics.view') && $administrator?->hasPermission('chatbot.view')) ?? false],
            ['label' => 'AI Analytics', 'icon' => 'sparkles', 'route' => route('admin.analytics.ai'), 'active' => request()->routeIs('admin.analytics.ai'), 'visible' => ($administrator?->hasPermission('analytics.view') && $administrator?->hasPermission('ai.view')) ?? false],
        ],
        'Management' => [
            ['label' => 'Website', 'icon' => 'globe-alt', 'route' => route('admin.settings.index', ['group' => 'general']), 'active' => request()->routeIs('admin.settings.*'), 'visible' => $administrator?->hasPermission('settings.view') ?? false],
            ['label' => 'Quotes', 'icon' => 'clipboard-document-list', 'route' => route('admin.quotes.index'), 'active' => request()->routeIs('admin.quotes.*'), 'visible' => $administrator?->hasPermission('quotes.view') ?? false],
            ['label' => 'Contact Messages', 'icon' => 'envelope', 'route' => route('admin.contact.index'), 'active' => request()->routeIs('admin.contact.*'), 'visible' => $administrator?->hasPermission('contact.view') ?? false],
            ['label' => 'Portfolio', 'icon' => 'briefcase', 'route' => route('admin.portfolio.index'), 'active' => request()->routeIs('admin.portfolio.*'), 'visible' => $administrator?->hasPermission('portfolio.view') ?? false],
            ['label' => 'Chatbot', 'icon' => 'chat-bubble-left-right', 'route' => route('admin.chatbot.index'), 'active' => request()->routeIs('admin.chatbot.*'), 'visible' => $administrator?->hasPermission('chatbot.view') ?? false],
        ],
        'System' => [
            ['label' => 'AI Console', 'icon' => 'sparkles', 'route' => route('admin.ai.dashboard'), 'active' => request()->routeIs('admin.ai.*'), 'visible' => $administrator?->hasPermission('ai.view') ?? false],
            ['label' => 'Roles & Permissions', 'icon' => 'key', 'route' => route('admin.roles.index'), 'active' => request()->routeIs('admin.roles.*'), 'visible' => $administrator?->hasPermission('administrators.view') ?? false],
            ['label' => 'Administrators', 'icon' => 'user-group', 'route' => route('admin.administrators.index'), 'active' => request()->routeIs('admin.administrators.*'), 'visible' => $administrator?->hasPermission('administrators.view') ?? false],
            ['label' => 'Audit Log', 'icon' => 'shield-check', 'route' => route('admin.audit.index'), 'active' => request()->routeIs('admin.audit.*'), 'visible' => $administrator?->hasPermission('audit.view') ?? false],
        ],
    ];

    $initials = collect(explode(' ', trim((string) $administrator?->name)))
        ->filter()
        ->take(2)
        ->map(fn ($part) => strtoupper(mb_substr($part, 0, 1)))
        ->implode('');
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="robots" content="noindex, nofollow">
        <title>{{ $title }}, SMEvolve Admin</title>

        <link rel="icon" type="image/png" sizes="64x64" href="{{ asset('favicon.png') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body
        class="min-h-screen bg-slate-50 font-sans text-slate-900 antialiased dark:bg-slate-950 dark:text-slate-100"
        x-data="{ sidebarOpen: false }"
    >
        <!-- Mobile overlay -->
        <div
            x-show="sidebarOpen"
            x-cloak
            x-transition.opacity
            class="fixed inset-0 z-40 bg-slate-900/60 backdrop-blur-sm lg:hidden"
            x-on:click="sidebarOpen = false"
        ></div>

        <!-- Sidebar -->
        <aside
            class="fixed inset-y-0 left-0 z-50 flex w-72 flex-col border-r border-slate-200 bg-white text-slate-600 transition-transform duration-200 lg:translate-x-0 dark:border-slate-800 dark:bg-slate-900 dark:text-slate-300"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        >
            <div class="flex h-16 shrink-0 items-center gap-3 border-b border-slate-200 px-5 dark:border-white/10">
                <x-logo href="{{ route('admin.dashboard') }}" size="h-9" />
                <button
                    class="ml-auto rounded-lg p-1.5 text-slate-400 transition hover:bg-slate-100 hover:text-slate-900 lg:hidden dark:hover:bg-white/10 dark:hover:text-white"
                    x-on:click="sidebarOpen = false"
                    aria-label="Close menu"
                >
                    <x-icon name="x-mark" class="h-5 w-5" />
                </button>
            </div>

            <nav class="flex-1 space-y-6 overflow-y-auto px-3 py-6">
                @foreach ($groups as $groupLabel => $items)
                    @php
                        $visibleItems = collect($items)->filter(fn ($item) => $item['visible']);
                    @endphp
                    @if ($visibleItems->isNotEmpty())
                        <div>
                            <p class="px-3 pb-2 text-[11px] font-semibold tracking-wider text-slate-500 uppercase dark:text-slate-500">{{ $groupLabel }}</p>
                            <ul class="space-y-1">
                                @foreach ($visibleItems as $item)
                                    <li>
                                        <a
                                            href="{{ $item['route'] }}"
                                            @class([
                                                'group flex items-center gap-3 rounded-xl px-3 py-2 text-sm font-medium transition-colors',
                                                'bg-primary-600 text-white shadow-lg shadow-primary-600/25' => $item['active'],
                                                'text-slate-500 hover:bg-slate-100 hover:text-slate-900 dark:text-slate-400 dark:hover:bg-white/5 dark:hover:text-white' => ! $item['active'],
                                            ])
                                        >
                                            <x-icon :name="$item['icon']" class="h-5 w-5 shrink-0" />
                                            {{ $item['label'] }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                @endforeach
            </nav>

            <div class="border-t border-slate-200 p-3 dark:border-white/10">
                <div class="flex items-center gap-3 rounded-xl px-2 py-2">
                    <span class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-primary-600 text-sm font-semibold text-white">
                        {{ $initials ?: 'AD' }}
                    </span>
                    <div class="min-w-0 flex-1">
                        <p class="truncate text-sm font-medium text-slate-900 dark:text-white">{{ $administrator?->name }}</p>
                        <a href="{{ route('admin.profile.index') }}" class="block truncate text-xs text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-200">{{ $administrator?->email }}</a>
                    </div>
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button
                            type="submit"
                            class="rounded-lg p-1.5 text-slate-400 transition hover:bg-slate-100 hover:text-slate-900 dark:hover:bg-white/10 dark:hover:text-white"
                            title="Logout"
                            aria-label="Logout"
                        >
                            <x-icon name="arrow-right-start-on-rectangle" class="h-5 w-5" />
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main column -->
        <div class="flex min-h-screen flex-col lg:pl-72">
            <!-- Topbar -->
            <header class="sticky top-0 z-30 border-b border-slate-200 bg-white/80 backdrop-blur dark:border-slate-800 dark:bg-slate-900/80">
                <div class="flex h-16 items-center gap-3 px-4 sm:px-6 lg:px-8">
                    <button
                        class="rounded-lg p-2 text-slate-500 transition hover:bg-slate-100 lg:hidden dark:hover:bg-slate-800"
                        x-on:click="sidebarOpen = true"
                        aria-label="Open menu"
                    >
                        <x-icon name="bars-3" class="h-5 w-5" />
                    </button>

                    <span class="text-sm font-semibold text-slate-900 dark:text-slate-100">{{ $title }}</span>

                    <div class="ml-auto flex items-center gap-1.5">
                        <a
                            href="{{ route('home') }}"
                            class="hidden items-center gap-1.5 rounded-lg px-3 py-2 text-sm font-medium text-slate-500 transition hover:bg-slate-100 hover:text-slate-700 sm:inline-flex dark:text-slate-400 dark:hover:bg-slate-800 dark:hover:text-slate-200"
                            target="_blank"
                            rel="noopener"
                        >
                            View site
                            <x-icon name="arrow-up-right" class="h-4 w-4" />
                        </a>

                        @php
                            $canSearch = $administrator
                                && ($administrator->hasPermission('quotes.search')
                                    || $administrator->hasPermission('administrators.view')
                                    || $administrator->hasPermission('settings.view')
                                    || $administrator->hasPermission('portfolio.view'));
                        @endphp
                        @if ($canSearch)
                            <a
                                href="{{ route('admin.search') }}"
                                class="rounded-lg p-2 text-slate-500 transition hover:bg-slate-100 lg:hidden dark:text-slate-400 dark:hover:bg-slate-800"
                                aria-label="Search"
                            >
                                <x-icon name="magnifying-glass" class="h-5 w-5" />
                            </a>

                            <x-admin.search-box class="mx-1" />
                        @endif

                        <button
                            class="rounded-lg p-2 text-slate-500 transition hover:bg-slate-100 dark:text-slate-400 dark:hover:bg-slate-800"
                            x-on:click="$store.theme.toggle()"
                            aria-label="Toggle theme"
                        >
                            <x-icon name="sun" class="h-5 w-5 dark:hidden" />
                            <x-icon name="moon" class="hidden h-5 w-5 dark:block" />
                        </button>

                        <!-- User dropdown -->
                        <div class="relative" x-data="{ open: false }" x-on:click.outside="open = false">
                            <button
                                class="flex items-center gap-2 rounded-lg p-1.5 text-sm font-medium text-slate-600 transition hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800"
                                x-on:click="open = ! open"
                                aria-haspopup="true"
                                :aria-expanded="open"
                            >
                                <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-primary-600 text-xs font-semibold text-white">
                                    {{ $initials ?: 'AD' }}
                                </span>
                                <span class="hidden md:inline">{{ $administrator?->name }}</span>
                                <x-icon name="chevron-down" class="h-4 w-4" />
                            </button>

                            <div
                                x-show="open"
                                x-cloak
                                x-transition
                                class="absolute right-0 mt-2 w-60 origin-top-right rounded-xl border border-slate-200 bg-white p-1.5 shadow-card dark:border-slate-800 dark:bg-slate-900"
                                x-on:click="open = false"
                            >
                                <div class="border-b border-slate-100 px-3 py-2.5 dark:border-slate-800">
                                    <p class="truncate text-sm font-semibold text-slate-900 dark:text-slate-100">{{ $administrator?->name }}</p>
                                    <p class="truncate text-xs text-slate-500 dark:text-slate-400">{{ $administrator?->email }}</p>
                                </div>

                                <div class="mt-1.5 space-y-0.5">
                                    <a
                                        href="{{ route('admin.profile.index') }}"
                                        class="flex items-center gap-2.5 rounded-lg px-3 py-2 text-sm text-slate-600 transition hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800"
                                    >
                                        <x-icon name="user-circle" class="h-4 w-4" /> My Profile
                                    </a>
                                    <a
                                        href="{{ route('admin.security.index') }}"
                                        class="flex items-center gap-2.5 rounded-lg px-3 py-2 text-sm text-slate-600 transition hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800"
                                    >
                                        <x-icon name="lock-closed" class="h-4 w-4" /> Security
                                    </a>
                                    <a
                                        href="{{ route('admin.settings.index', ['group' => 'general']) }}"
                                        class="flex items-center gap-2.5 rounded-lg px-3 py-2 text-sm text-slate-600 transition hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800"
                                    >
                                        <x-icon name="globe-alt" class="h-4 w-4" /> Website Settings
                                    </a>

                                    <div class="my-1 border-t border-slate-100 dark:border-slate-800"></div>

                                    <form method="POST" action="{{ route('admin.logout') }}">
                                        @csrf
                                        <button
                                            type="submit"
                                            class="flex w-full items-center gap-2.5 rounded-lg px-3 py-2 text-sm text-error-600 transition hover:bg-error-500/10 dark:text-error-400"
                                        >
                                            <x-icon name="arrow-right-start-on-rectangle" class="h-4 w-4" /> Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Flash messages -->
            @if (session('status'))
                <div
                    class="mx-4 mt-4 flex items-start gap-3 rounded-xl border border-success-500/30 bg-success-500/10 px-4 py-3 text-sm text-success-700 sm:mx-6 lg:mx-8 dark:text-success-500"
                    x-data="{ show: true }"
                    x-show="show"
                    x-cloak
                    x-transition
                    x-on:click="show = false"
                >
                    <x-icon name="check-circle" class="mt-0.5 h-5 w-5 shrink-0" />
                    <p class="flex-1">{{ session('status') }}</p>
                    <button class="opacity-60 transition hover:opacity-100" aria-label="Dismiss">
                        <x-icon name="x-mark" class="h-4 w-4" />
                    </button>
                </div>
            @endif

            @if ($errors->any())
                <div class="mx-4 mt-4 flex items-start gap-3 rounded-xl border border-error-500/30 bg-error-500/10 px-4 py-3 text-sm text-error-700 sm:mx-6 lg:mx-8 dark:text-error-500">
                    <x-icon name="exclamation-triangle" class="mt-0.5 h-5 w-5 shrink-0" />
                    <div class="space-y-1">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                </div>
            @endif

            <main class="flex-1 px-4 py-6 sm:px-6 lg:px-8">
                {{ $slot }}
            </main>

            <footer class="px-4 py-6 text-center text-xs text-slate-400 sm:px-6 lg:px-8 dark:text-slate-500">
                &copy; {{ date('Y') }} SMEvolve. All rights reserved.
            </footer>
        </div>
    </body>
</html>
