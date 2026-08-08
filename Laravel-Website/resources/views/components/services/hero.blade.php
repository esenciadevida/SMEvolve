@props([
    'service' => [],
    'id' => null,
])

@php
    $name = $service['name'] ?? 'Service';
    $icon = $service['icon'] ?? 'code';
    $hero = $service['hero'] ?? [];
    $heading = $hero['heading'] ?? $name;
    $supporting = $hero['supporting'] ?? '';
    $primary = $hero['primaryCta'] ?? ['label' => 'Get a Free Quote', 'href' => 'quote'];
    $secondary = $hero['secondaryCta'] ?? ['label' => 'Contact Us', 'href' => 'contact'];
    $trust = $hero['trust'] ?? [];
@endphp

<section id="{{ $id }}" class="relative flex min-h-svh flex-col overflow-hidden bg-dark text-white" aria-labelledby="{{ $id }}-heading">
    <div aria-hidden="true" class="pointer-events-none absolute inset-0">
        <div class="absolute inset-0 bg-[linear-gradient(to_right,rgb(255_255_255/0.04)_1px,transparent_1px),linear-gradient(to_bottom,rgb(255_255_255/0.04)_1px,transparent_1px)] bg-[size:3rem_3rem] [mask-image:radial-gradient(ellipse_65%_55%_at_50%_0%,#000_70%,transparent_110%)]"></div>
        <div class="absolute -top-32 right-0 h-[28rem] w-[28rem] rounded-full bg-primary-600/25 blur-3xl"></div>
        <div class="absolute -left-24 top-1/3 h-80 w-80 rounded-full bg-secondary-600/20 blur-3xl"></div>
    </div>

    <div class="relative mx-auto my-auto w-full max-w-site px-6 pt-10 lg:px-8 lg:pt-14">
        <x-breadcrumbs :items="[['label' => 'Services', 'url' => route('services.index')], ['label' => $name]]" variant="dark" />

        <div class="grid items-center gap-12 py-14 lg:grid-cols-2 lg:py-20">
            <div>
                <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br from-primary-600 to-secondary-600 text-white shadow-md shadow-primary-600/20">
                    <x-icon :name="$icon" class="h-7 w-7" />
                </div>

                <h1 id="{{ $id }}-heading" class="mt-6 text-balance text-4xl font-bold tracking-tight sm:text-5xl">
                    {{ $heading }}
                </h1>

                <p class="mt-6 max-w-xl text-pretty text-lg leading-relaxed text-slate-300">
                    {{ $supporting }}
                </p>

                <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                    <x-buttons.primary-button :href="route($primary['href'] ?? 'quote')" class="w-full sm:w-auto">
                        {{ $primary['label'] ?? 'Get a Free Quote' }}
                        <x-icon name="arrow-right" class="h-4 w-4" />
                    </x-buttons.primary-button>

                    <x-buttons.button :href="route($secondary['href'] ?? 'contact')" variant="outline-white" class="w-full sm:w-auto">
                        {{ $secondary['label'] ?? 'Contact Us' }}
                    </x-buttons.button>
                </div>

                @if (filled($trust))
                    <ul class="mt-10 grid gap-3 sm:grid-cols-2">
                        @foreach ($trust as $item)
                            <li class="flex items-center gap-2.5 rounded-xl bg-white/5 px-4 py-3 text-sm font-medium text-slate-300 ring-1 ring-inset ring-white/10">
                                <span class="flex h-6 w-6 flex-none items-center justify-center rounded-full bg-accent-500/10">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4 text-accent-500" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd" />
                                    </svg>
                                </span>
                                {{ $item }}
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            <div class="relative flex justify-center lg:justify-end">
                <x-hero-visual />
            </div>
        </div>
    </div>
</section>
