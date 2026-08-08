@props([
    'heading' => null,
    'description' => null,
    'primaryText' => null,
    'primaryHref' => '/quote',
    'secondaryText' => null,
    'secondaryHref' => '/services',
    'trust' => null,
])

@php
    $heading = $heading ?? 'Building Digital Solutions That Help Businesses Grow';
    $description = $description ?? 'SMEvolve helps businesses build modern websites, custom software, mobile applications, and automation solutions designed around their unique goals.';
    $primaryText = $primaryText ?? 'Get a Free Quote';
    $secondaryText = $secondaryText ?? 'View Our Services';
    $trust = $trust ?? ['Custom Business Solutions', 'Modern Technologies', 'Transparent Development Process', 'Long-Term Support'];
@endphp

<section aria-labelledby="hero-heading" class="relative flex min-h-svh flex-col overflow-hidden bg-dark text-white">
    <div aria-hidden="true" class="pointer-events-none absolute inset-0">
        <div class="absolute inset-0 bg-[linear-gradient(to_right,rgb(255_255_255/0.04)_1px,transparent_1px),linear-gradient(to_bottom,rgb(255_255_255/0.04)_1px,transparent_1px)] bg-[size:3rem_3rem] [mask-image:radial-gradient(ellipse_65%_55%_at_50%_0%,#000_70%,transparent_110%)]"></div>
        <div class="absolute -top-32 right-0 h-[28rem] w-[28rem] rounded-full bg-primary-600/25 blur-3xl"></div>
        <div class="absolute -left-24 top-1/3 h-80 w-80 rounded-full bg-secondary-600/20 blur-3xl"></div>
        <div class="absolute bottom-0 left-1/3 h-64 w-64 rounded-full bg-accent-500/10 blur-3xl"></div>
    </div>

    <div class="relative mx-auto my-auto grid w-full max-w-site items-center gap-14 px-6 py-20 lg:grid-cols-2 lg:px-8 lg:py-28">
        <div>
            <h1 id="hero-heading" class="text-balance text-4xl font-bold tracking-tight sm:text-5xl lg:text-6xl">
                {{ $heading }}
            </h1>

            <p class="mt-6 max-w-xl text-pretty text-lg leading-relaxed text-slate-300">
                {{ $description }}
            </p>

            <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                <x-buttons.primary-button :href="$primaryHref" class="w-full sm:w-auto">
                    {{ $primaryText }}
                    <x-icon name="arrow-right" class="h-4 w-4" />
                </x-buttons.primary-button>

                <x-buttons.button :href="$secondaryHref" variant="outline-white" class="w-full sm:w-auto">
                    <x-icon name="magnifying-glass" class="h-4 w-4" />
                    {{ $secondaryText }}
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
</section>
