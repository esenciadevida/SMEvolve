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

<section data-hero aria-labelledby="hero-heading" class="relative flex min-h-svh flex-col overflow-hidden bg-dark text-white">
    <div aria-hidden="true" class="pointer-events-none absolute inset-0">
        <div class="absolute inset-0 bg-grid-dark mask-fade-edges opacity-70"></div>
        <div class="absolute -top-32 right-0 h-[30rem] w-[30rem] rounded-full bg-primary-600/25 blur-3xl"></div>
        <div class="absolute -left-24 top-1/3 h-80 w-80 rounded-full bg-secondary-600/20 blur-3xl"></div>
        <div class="absolute bottom-0 left-1/3 h-64 w-64 rounded-full bg-accent-500/10 blur-3xl"></div>

        <svg data-hero-paths class="absolute inset-0 h-full w-full" viewBox="0 0 1200 800" fill="none" preserveAspectRatio="xMidYMid slice">
            <path data-path class="dashed-path dashed-path-drift" d="M-60 640 C 240 520, 360 720, 640 560 S 980 360, 1280 470" stroke="rgb(139 92 246 / 0.55)" stroke-width="1.5" />
            <path data-path class="dashed-path dashed-path-drift" d="M-60 230 C 210 150, 430 310, 680 210 S 1030 70, 1280 180" stroke="rgb(56 189 248 / 0.5)" stroke-width="1.5" style="animation-duration: 4.5s" />
            <path data-path class="dashed-path" d="M880 -60 C 1040 130, 890 320, 1130 400 S 1310 590, 1170 760" stroke="rgb(236 72 153 / 0.4)" stroke-width="1.5" />
            <circle data-path-dot cx="640" cy="560" r="4" fill="#8b5cf6" />
            <circle data-path-dot cx="680" cy="210" r="4" fill="#38bdf8" />
            <circle data-path-dot cx="1130" cy="400" r="4" fill="#ec4899" />
        </svg>
    </div>

    <div class="relative mx-auto my-auto grid w-full max-w-site items-center gap-14 px-6 py-20 lg:grid-cols-2 lg:px-8 lg:py-28">
        <div>
            <span data-hero-eyebrow class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-3.5 py-1.5 text-xs font-semibold uppercase tracking-[0.18em] text-primary-200">
                <span class="h-1.5 w-1.5 rounded-full bg-accent-500"></span>
                Digital Solutions Partner
            </span>

            <h1 data-hero-title id="hero-heading" class="mt-6 text-balance text-4xl font-bold tracking-tight sm:text-5xl lg:text-6xl">
                {{ $heading }}
            </h1>

            <p data-hero-copy class="mt-6 max-w-xl text-pretty text-lg leading-relaxed text-slate-300">
                {{ $description }}
            </p>

            <div data-hero-cta class="mt-8 flex flex-col gap-3 sm:flex-row">
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
                <ul data-hero-trust class="mt-10 grid gap-3 sm:grid-cols-2">
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

        <div data-hero-visual class="relative flex justify-center lg:justify-end">
            <x-hero-visual />
        </div>
    </div>
</section>
