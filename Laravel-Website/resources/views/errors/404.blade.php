<x-layouts.app :title="'Page Not Found'">
    <section class="mx-auto flex max-w-site flex-col items-center px-6 py-24 text-center lg:px-8 lg:py-32">
        <div class="flex h-20 w-20 items-center justify-center rounded-3xl bg-primary-600/10">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-10 w-10 text-primary-600" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 0 0 5.636 5.636m12.728 12.728A9 9 0 0 1 5.636 5.636m12.728 12.728L5.636 5.636" />
            </svg>
        </div>

        <p class="mt-8 text-sm font-semibold uppercase tracking-widest text-primary-600">Error 404</p>

        <h1 class="mt-4 text-4xl font-bold tracking-tight text-gray-900 sm:text-5xl">Page Not Found</h1>

        <p class="mt-4 max-w-lg text-lg leading-relaxed text-gray-500">
            The page you are looking for doesn't exist, was moved, or is temporarily unavailable.
            Let's get you back on track.
        </p>

        <div class="mt-8 flex flex-col items-center gap-3 sm:flex-row">
            <x-buttons.button href="{{ route('home') }}" data-track="404:home">
                <x-icon name="home" class="h-4 w-4" />
                Back to Homepage
            </x-buttons.button>

            <x-buttons.button href="{{ route('contact') }}" variant="secondary" data-track="404:contact">
                Contact Support
            </x-buttons.button>
        </div>

        <a
            href="{{ route('search') }}"
            class="mt-10 flex w-full max-w-md items-center gap-3 rounded-2xl border border-gray-200 bg-white px-4 py-3 shadow-sm transition hover:border-primary-300 hover:shadow-card-hover dark:border-gray-600 dark:bg-dark-card dark:hover:border-primary-600"
            data-track="404:search"
        >
            <x-icon name="magnifying-glass" class="h-5 w-5 flex-none text-gray-400" />
            <span class="text-sm text-gray-600 dark:text-gray-300">Search the site instead</span>
            <x-icon name="arrow-right" class="ml-auto h-4 w-4 flex-none text-gray-400" />
        </a>

        <nav aria-label="Popular pages" class="mt-12">
            <p class="text-xs font-semibold uppercase tracking-widest text-gray-400">Popular pages</p>
            <ul class="mt-4 flex flex-wrap items-center justify-center gap-x-8 gap-y-3">
                @foreach (config('navigation.main') as $item)
                    @unless (($item['children'] ?? false))
                        <li>
                            <a
                                href="{{ route($item['route']) }}"
                                class="text-sm font-semibold text-primary-600 transition hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300"
                                data-track="404:nav"
                            >
                                {{ $item['label'] }}
                            </a>
                        </li>
                    @endunless
                @endforeach
            </ul>
        </nav>
    </section>
</x-layouts.app>
