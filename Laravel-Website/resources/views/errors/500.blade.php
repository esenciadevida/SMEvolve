<x-layouts.app :title="'Something Went Wrong'">
    <section class="mx-auto flex max-w-site flex-col items-center px-6 py-24 text-center lg:px-8 lg:py-32">
        <div class="flex h-20 w-20 items-center justify-center rounded-3xl bg-error-500/10">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-10 w-10 text-error-600" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9.303 3.376c.866 1.5.217 3.374-1.948 3.374H4.645c-2.165 0-2.814-1.875-1.948-3.374L10.052 3.865c.866-1.5 3.032-1.5 3.898 0l7.353 12.861Z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 15.75h.007v.008H12v-.008Z" />
            </svg>
        </div>

        <p class="mt-8 text-sm font-semibold uppercase tracking-widest text-error-600">Error 500</p>

        <h1 class="mt-4 text-4xl font-bold tracking-tight text-gray-900 sm:text-5xl">Something Went Wrong</h1>

        <p class="mt-4 max-w-lg text-lg leading-relaxed text-gray-500">
            An unexpected error occurred while loading this page. Please try again in a moment.
            If the problem continues, contact us and we'll look into it.
        </p>

        <div class="mt-8 flex flex-col items-center gap-3 sm:flex-row">
            <x-buttons.button href="{{ route('home') }}" data-track="500:home">
                <x-icon name="home" class="h-4 w-4" />
                Back to Homepage
            </x-buttons.button>

            <x-buttons.button href="{{ route('contact') }}" variant="secondary" data-track="500:contact">
                Contact Support
            </x-buttons.button>
        </div>

        <nav aria-label="Popular pages" class="mt-12">
            <p class="text-xs font-semibold uppercase tracking-widest text-gray-400">Popular pages</p>
            <ul class="mt-4 flex flex-wrap items-center justify-center gap-x-8 gap-y-3">
                @foreach (config('navigation.main') as $item)
                    @unless (($item['children'] ?? false))
                        <li>
                            <a
                                href="{{ route($item['route']) }}"
                                class="text-sm font-semibold text-primary-600 transition hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300"
                                data-track="500:nav"
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
