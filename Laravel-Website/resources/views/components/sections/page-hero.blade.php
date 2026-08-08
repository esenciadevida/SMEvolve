@props([
    'id' => null,
    'eyebrow' => null,
    'heading',
    'description' => null,
    'visual' => true,
    'variant' => 'dashboard',
    'breadcrumb' => [],
    'full' => true,
    'notice' => null,
])

<section
    @class([
        'relative overflow-hidden bg-dark text-white',
        'flex min-h-svh flex-col' => $full,
    ])
    aria-labelledby="{{ $id ?? Str::slug($heading) }}-heading"
>
    <div aria-hidden="true" class="pointer-events-none absolute inset-0">
        <div class="absolute inset-0 bg-[linear-gradient(to_right,rgb(255_255_255/0.04)_1px,transparent_1px),linear-gradient(to_bottom,rgb(255_255_255/0.04)_1px,transparent_1px)] bg-[size:3rem_3rem] [mask-image:radial-gradient(ellipse_65%_55%_at_50%_0%,#000_70%,transparent_110%)]"></div>
        <div class="absolute -top-32 right-0 h-[28rem] w-[28rem] rounded-full bg-primary-600/25 blur-3xl"></div>
        <div class="absolute -left-24 top-1/3 h-80 w-80 rounded-full bg-secondary-600/20 blur-3xl"></div>
    </div>

    <div
        @class([
            'relative mx-auto max-w-site px-6 pt-10 lg:px-8 lg:pt-14',
            'w-full' => $full,
        ])
    >
        @if (filled($breadcrumb))
            <x-breadcrumbs :items="$breadcrumb" variant="dark" />
        @endif

        <div @class([
            'py-14 lg:py-20',
            'grid items-center gap-14 lg:grid-cols-2' => $visual,
            'max-w-3xl' => ! $visual,
        ])>
            <div>
                @if ($eyebrow)
                    <p class="text-sm font-semibold uppercase tracking-widest text-primary-400">{{ $eyebrow }}</p>
                @endif

                <h1 id="{{ $id ?? Str::slug($heading) }}-heading" class="mt-3 text-balance text-4xl font-bold tracking-tight sm:text-5xl">
                    {{ $heading }}
                </h1>

                @if ($description)
                    <p class="mt-6 max-w-xl text-lg leading-relaxed text-slate-300">{{ $description }}</p>
                @endif

                @if (! $slot->isEmpty())
                    <div class="mt-8 flex flex-wrap gap-3">{{ $slot }}</div>
                @endif
            </div>

            @if ($visual)
                <div class="relative flex justify-center lg:justify-end">
                    @if ($visual instanceof \Illuminate\View\ComponentSlot && ! $visual->isEmpty())
                        {{ $visual }}
                    @else
                        <x-hero-visual :variant="$variant" />
                    @endif
                </div>
            @endif
        </div>

        @if ($notice)
            <div class="mt-10 rounded-2xl border border-white/10 bg-white/5 px-5 py-4 backdrop-blur">
                <p class="flex items-start gap-3 text-sm leading-relaxed text-slate-300">
                    <x-icon name="information-circle" class="mt-0.5 h-5 w-5 flex-none text-primary-400" />
                    <span>{{ $notice }}</span>
                </p>
            </div>
        @endif
    </div>
</section>
