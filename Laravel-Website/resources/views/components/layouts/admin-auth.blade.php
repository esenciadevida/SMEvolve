@props([
    'title' => 'Admin Login',
])

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
    <body class="flex min-h-screen bg-slate-50 font-sans text-slate-900 antialiased dark:bg-slate-950">
        <div class="flex min-h-screen w-full">
            <!-- Brand panel -->
            <div class="relative hidden w-1/2 flex-col justify-between overflow-hidden bg-slate-900 p-10 lg:flex">
                <div class="pointer-events-none absolute -top-32 -right-32 h-96 w-96 rounded-full bg-primary-600/20 blur-3xl"></div>
                <div class="pointer-events-none absolute -bottom-40 -left-24 h-96 w-96 rounded-full bg-secondary-600/20 blur-3xl"></div>

                <x-logo dark size="h-9" />

                <div class="relative">
                    <h2 class="max-w-md text-3xl font-semibold leading-tight text-white">Manage your website from one secure place.</h2>
                    <p class="mt-3 max-w-md text-sm leading-relaxed text-slate-400">
                        Quotes, AI services, settings and more, everything you need to run SMEvolve, all in one dashboard.
                    </p>
                </div>

                <ul class="relative space-y-3">
                    @foreach ([['Real-time dashboard & analytics', 'chart-bar'], ['Quote & enquiry management', 'clipboard-document-list'], ['AI service controls & audit trail', 'shield-check']] as $feature)
                        <li class="flex items-center gap-3 text-sm text-slate-300">
                            <span class="inline-flex h-7 w-7 items-center justify-center rounded-lg bg-primary-500/15 text-primary-400">
                                <x-icon :name="$feature[1]" class="h-4 w-4" />
                            </span>
                            {{ $feature[0] }}
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Form panel -->
            <div class="flex flex-1 items-center justify-center px-4 py-10 sm:px-6">
                <div class="w-full max-w-md">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
