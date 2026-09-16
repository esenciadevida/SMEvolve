@props([
    'title' => null,
    'description' => null,
    'canonical' => null,
    'robots' => null,
])

@php
    $pageTitle = filled($title)
        ? (str_contains($title, config('app.name')) ? $title : $title.', '.config('app.name'))
        : config('app.name');
    $pageDescription = filled($description) ? $description : config('seo.default_description');

    // Always emit the configured canonical domain so www/non-www and other
    // host variations can never self-canonicalise and create duplicates. Even
    // when a page passes its own canonical (built via route()/url()), strip the
    // host it resolved to and rebuild it on the configured domain.
    $canonicalRoot = rtrim(config('seo.url'), '/');
    $canonicalPath = $canonical
        ? trim((string) parse_url($canonical, PHP_URL_PATH), '/')
        : trim(request()->path(), '/');
    $canonicalUrl = $canonicalPath === '' ? $canonicalRoot : $canonicalRoot.'/'.$canonicalPath;
    $robotsValue = $robots ?: config('seo.robots');

    $seo = config('seo');
    $ogImage = $seo['og']['image'] ? url($seo['og']['image']) : null;
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="theme-color" content="#ffffff" media="(prefers-color-scheme: light)">
        <meta name="theme-color" content="#0f172a" media="(prefers-color-scheme: dark)">
        <title>{{ $pageTitle }}</title>
        <meta name="description" content="{{ $pageDescription }}">
        <meta name="robots" content="{{ $robotsValue }}">

        <link rel="icon" type="image/png" sizes="64x64" href="{{ asset('favicon.png') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
        <link rel="preload" as="font" type="font/woff2" href="{{ asset('fonts/inter-var-latin.woff2') }}" crossorigin>

        <link rel="canonical" href="{{ $canonicalUrl }}">

        <meta property="og:site_name" content="{{ $seo['site_name'] ?? config('app.name') }}">
        <meta property="og:locale" content="{{ str_replace('-', '_', app()->getLocale()) }}">
        <meta property="og:type" content="{{ $seo['og']['type'] }}">
        <meta property="og:title" content="{{ $pageTitle }}">
        <meta property="og:url" content="{{ $canonicalUrl }}">
        <meta property="og:description" content="{{ $pageDescription }}">
        @if ($ogImage)
            <meta property="og:image" content="{{ $ogImage }}">
            <meta property="og:image:alt" content="{{ $seo['site_name'] ?? config('app.name') }}">
            <meta property="og:image:width" content="1200">
            <meta property="og:image:height" content="630">
        @endif

        <meta name="twitter:card" content="{{ $seo['twitter']['card'] }}">
        @if (! empty($seo['twitter']['handle']))
            <meta name="twitter:site" content="{{ $seo['twitter']['handle'] }}">
        @endif
        <meta name="twitter:title" content="{{ $pageTitle }}">
        <meta name="twitter:description" content="{{ $pageDescription }}">
        @if ($ogImage)
            <meta name="twitter:image" content="{{ $ogImage }}">
        @endif

        @if (! empty($structuredData))
            {!! $structuredData !!}
        @endif

        <script>
            (function () {
                var stored = null;
                try {
                    stored = localStorage.getItem('theme');
                } catch (e) {}

                var dark = stored === 'dark'
                    || (stored === null && window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches);

                if (dark) {
                    document.documentElement.classList.add('dark');
                }
            })();
        </script>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body id="top" class="flex min-h-screen flex-col bg-white font-sans text-gray-900 antialiased dark:bg-dark">
        <a
            href="#main"
            class="sr-only focus:not-sr-only focus:fixed focus:left-4 focus:top-4 focus:z-[80] focus:rounded-xl focus:bg-primary-600 focus:px-4 focus:py-2 focus:text-sm focus:font-semibold focus:text-white focus:shadow-lg"
        >
            Skip to content
        </a>

        <x-navigation.loading-bar />

        <x-navigation.header />

        <main id="main" class="flex-1 pt-20">
            {{ $slot }}
        </main>

        <x-navigation.footer />

        @unless (request()->routeIs('quote', 'quote.*', 'privacy-policy.index', 'terms.index', 'cookies.index'))
            <x-ai.chat-widget />
        @endunless
    </body>
</html>
