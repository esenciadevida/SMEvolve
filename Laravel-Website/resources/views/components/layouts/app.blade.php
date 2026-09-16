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

    // Google Analytics 4 is emitted only when a measurement ID is configured
    // and only in production, so local/staging activity is never tracked.
    $analyticsId = config('analytics.measurement_id');
    $analyticsEnabled = filled($analyticsId)
        && (! config('analytics.production_only') || app()->isProduction());

    $seo = config('seo');
    $ogImage = $seo['og']['image'] ? url($seo['og']['image']) : null;
    $siteVerification = $seo['google_site_verification'] ?? null;
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

        @if (filled($siteVerification))
            <meta name="google-site-verification" content="{{ $siteVerification }}">
        @endif

        @if ($analyticsEnabled)
            <script async src="https://www.googletagmanager.com/gtag/js?id={{ $analyticsId }}"></script>
            <script>
                window.dataLayer = window.dataLayer || [];
                function gtag() { dataLayer.push(arguments); }
                gtag('js', new Date());

                // Consent Mode v2: collection is denied until the visitor opts in.
                gtag('consent', 'default', {
                    ad_storage: 'denied',
                    ad_user_data: 'denied',
                    ad_personalization: 'denied',
                    analytics_storage: 'denied',
                });

                gtag('config', '{{ $analyticsId }}', { anonymize_ip: true });
            </script>
        @endif

        <link rel="icon" type="image/png" sizes="64x64" href="{{ asset('favicon.png') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
        <link rel="preload" as="font" type="font/woff2" href="{{ asset('fonts/inter-var-latin.woff2') }}" crossorigin>

        <style>
            /* First-paint page skeleton. Markup lives in x-skeleton-loader. */
            #site-skeleton {
                position: fixed;
                inset: 0;
                z-index: 9999;
                display: flex;
                flex-direction: column;
                background: #ffffff;
                transition: opacity 0.35s ease, visibility 0.35s ease;
            }

            #site-skeleton.sm-skeleton--done {
                opacity: 0;
                visibility: hidden;
                pointer-events: none;
            }

            html.sm-skeleton-lock {
                overflow: hidden;
            }

            .sm-skeleton__inner {
                width: 100%;
                max-width: 1200px;
                margin: 0 auto;
                padding: 24px;
                flex: 1 1 auto;
            }

            .sm-skeleton__nav {
                display: flex;
                align-items: center;
                gap: 32px;
                padding-bottom: 24px;
                border-bottom: 1px solid #f1f5f9;
            }

            .sm-skeleton__logo {
                width: 120px;
                height: 20px;
                border-radius: 6px;
            }

            .sm-skeleton__nav-links {
                display: flex;
                gap: 24px;
                margin-left: auto;
            }

            .sm-skeleton__nav-link {
                width: 72px;
                height: 10px;
                border-radius: 5px;
            }

            .sm-skeleton__cta {
                width: 96px;
                height: 36px;
                border-radius: 10px;
            }

            .sm-skeleton__hero {
                display: grid;
                grid-template-columns: 1fr;
                gap: 48px;
                align-items: center;
                margin-top: 64px;
            }

            .sm-skeleton__eyebrow {
                width: 140px;
                height: 12px;
                border-radius: 6px;
            }

            .sm-skeleton__title {
                width: 90%;
                height: 28px;
                border-radius: 8px;
                margin-top: 20px;
            }

            .sm-skeleton__title--narrow {
                width: 62%;
            }

            .sm-skeleton__copy {
                width: 100%;
                height: 12px;
                border-radius: 6px;
                margin-top: 16px;
            }

            .sm-skeleton__copy--narrow {
                width: 72%;
                margin-top: 10px;
            }

            .sm-skeleton__buttons {
                display: flex;
                gap: 12px;
                margin-top: 32px;
            }

            .sm-skeleton__button {
                width: 150px;
                height: 44px;
                border-radius: 12px;
                background: rgb(79 70 229 / 0.9) !important;
            }

            .sm-skeleton__button--ghost {
                background: rgb(226 232 240) !important;
            }

            .sm-skeleton__media {
                aspect-ratio: 4 / 3;
                border-radius: 20px;
            }

            .sm-skeleton__cards {
                display: grid;
                grid-template-columns: 1fr;
                gap: 24px;
                margin-top: 56px;
            }

            .sm-skeleton__card {
                padding: 18px;
                border: 1px solid #f1f5f9;
                border-radius: 16px;
            }

            .sm-skeleton__card-media {
                aspect-ratio: 16 / 9;
                border-radius: 12px;
            }

            .sm-skeleton__card-title {
                width: 60%;
                height: 16px;
                border-radius: 6px;
                margin-top: 16px;
            }

            .sm-skeleton__card-line {
                width: 100%;
                height: 10px;
                border-radius: 5px;
                margin-top: 12px;
            }

            .sm-skeleton__card-line--narrow {
                width: 70%;
            }

            html.dark #site-skeleton {
                background: #0b1220;
            }

            html.dark .sm-skeleton__nav,
            html.dark .sm-skeleton__card {
                border-color: rgb(255 255 255 / 0.08);
            }

            html.dark .sm-skeleton__card {
                background: rgb(255 255 255 / 0.03);
            }

            html.dark .sm-skeleton__button--ghost {
                background: rgb(51 65 85 / 0.6) !important;
            }

            @media (max-width: 767px) {
                .sm-skeleton__nav-links {
                    gap: 16px;
                }

                .sm-skeleton__nav-link--optional {
                    display: none;
                }
            }

            @media (prefers-reduced-motion: reduce) {
                #site-skeleton,
                #site-skeleton.sm-skeleton--done {
                    transition: none;
                }

                #site-skeleton .skeleton::after {
                    animation: none;
                }
            }
        </style>

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
        <x-skeleton-loader />

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

        <x-consent-banner :tracked="$analyticsEnabled" />

        @unless (request()->routeIs('quote', 'quote.*', 'privacy-policy.index', 'terms.index', 'cookies.index'))
            <x-ai.chat-widget />
        @endunless
    </body>
</html>
