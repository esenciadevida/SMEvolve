@props([
    'title' => 'AI Admin',
])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="robots" content="noindex, nofollow">
        <title>{{ $title }}, SMEvolve AI Console</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="flex min-h-screen flex-col bg-slate-100 font-sans text-slate-900 antialiased dark:bg-slate-950 dark:text-slate-100">
        <header class="border-b border-slate-200 bg-white dark:border-slate-800 dark:bg-slate-900">
            <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-4 py-3 sm:px-6 lg:px-8">
                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.ai.dashboard') }}" class="flex items-center gap-2 text-sm font-semibold">
                        <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-primary-600 text-white">AI</span>
                        <span class="hidden sm:inline">SMEvolve AI Console</span>
                    </a>
                </div>

                <div class="flex items-center gap-2">
                    <a href="{{ route('home') }}" class="text-xs text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-200">View site</a>
                    <form method="POST" action="{{ route('admin.ai.logout') }}">
                        @csrf
                        <button type="submit" class="rounded-lg border border-slate-300 px-3 py-1.5 text-xs font-medium hover:bg-slate-50 dark:border-slate-700 dark:hover:bg-slate-800">Logout</button>
                    </form>
                </div>
            </div>

            <nav class="mx-auto flex max-w-7xl gap-1 overflow-x-auto px-4 pb-2 text-sm sm:px-6 lg:px-8">
                @php
                    $tabs = [
                        'admin.ai.dashboard' => ['label' => 'Dashboard', 'route' => route('admin.ai.dashboard')],
                        'admin.ai.config' => ['label' => 'Configuration', 'route' => route('admin.ai.config')],
                        'admin.ai.prompts' => ['label' => 'Prompts', 'route' => route('admin.ai.prompts')],
                        'admin.ai.knowledge.index' => ['label' => 'Knowledge', 'route' => route('admin.ai.knowledge.index')],
                        'admin.ai.usage' => ['label' => 'Usage', 'route' => route('admin.ai.usage')],
                        'admin.ai.health' => ['label' => 'Health', 'route' => route('admin.ai.health')],
                    ];
                @endphp
                @foreach ($tabs as $name => $tab)
                    <a
                        href="{{ $tab['route'] }}"
                        class="whitespace-nowrap rounded-lg px-3 py-1.5 {{ request()->routeIs($name) ? 'bg-primary-600 text-white' : 'text-slate-600 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800' }}"
                    >
                        {{ $tab['label'] }}
                    </a>
                @endforeach
            </nav>
        </header>

        <main class="mx-auto w-full max-w-7xl flex-1 px-4 py-6 sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="mb-4 rounded-lg border border-success-500/30 bg-success-500/10 px-4 py-3 text-sm text-success-700 dark:text-success-500">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 rounded-lg border border-error-500/30 bg-error-500/10 px-4 py-3 text-sm text-error-700 dark:text-error-500">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            {{ $slot }}
        </main>
    </body>
</html>
