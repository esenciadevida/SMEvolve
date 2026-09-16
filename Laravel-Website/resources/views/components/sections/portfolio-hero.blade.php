@props([
    'id' => 'portfolio-hero',
    'eyebrow' => 'Our Work',
    'heading',
    'description' => null,
    'breadcrumb' => [],
    'projects' => [],
    'badge' => null,
])

@php
    $previews = collect($projects)->take(3)->values();
    $gradients = [
        'from-primary-500 to-secondary-500',
        'from-accent-500 to-primary-600',
        'from-secondary-500 to-indigo-600',
    ];
    $statusColors = [
        'Completed' => 'bg-accent-500',
        'Ongoing' => 'bg-primary-500',
    ];
@endphp

<section id="{{ $id }}" class="relative flex min-h-svh flex-col overflow-hidden bg-dark text-white" aria-labelledby="{{ $id }}-heading">
    <div aria-hidden="true" class="pointer-events-none absolute inset-0">
        <div class="absolute inset-0 bg-[linear-gradient(to_right,rgb(255_255_255/0.04)_1px,transparent_1px),linear-gradient(to_bottom,rgb(255_255_255/0.04)_1px,transparent_1px)] bg-[size:3rem_3rem] [mask-image:radial-gradient(ellipse_70%_60%_at_50%_0%,#000_70%,transparent_110%)]"></div>
        <div class="absolute -top-32 right-0 h-[28rem] w-[28rem] rounded-full bg-primary-600/25 blur-3xl"></div>
        <div class="absolute -left-24 bottom-0 h-80 w-80 rounded-full bg-secondary-600/20 blur-3xl"></div>
    </div>

    <div class="relative mx-auto my-auto w-full max-w-site px-6 pt-10 lg:px-8 lg:pt-14">
        @if (filled($breadcrumb))
            <x-breadcrumbs :items="$breadcrumb" variant="dark" />
        @endif

        <div class="grid items-center gap-14 py-14 lg:grid-cols-2 lg:py-20">
            <div>
                <p class="text-sm font-semibold uppercase tracking-widest text-primary-400">{{ $eyebrow }}</p>

                <h1 id="{{ $id }}-heading" class="mt-3 text-balance text-4xl font-bold tracking-tight sm:text-5xl">
                    {{ $heading }}
                </h1>

                @if ($description)
                    <p class="mt-6 max-w-xl text-lg leading-relaxed text-slate-300">{{ $description }}</p>
                @endif

                @if (! $slot->isEmpty())
                    <div class="mt-8 flex flex-wrap gap-3">{{ $slot }}</div>
                @endif
            </div>

            <div class="relative mx-auto w-full max-w-md lg:max-w-none">
                <div class="grid grid-cols-2 gap-4">
                    @foreach ($previews as $project)
                        <a
                            href="{{ $project['url'] }}"
                            class="group block rounded-2xl bg-white p-3 shadow-xl shadow-black/20 dark:bg-dark-card ring-1 ring-white/20 backdrop-blur transition duration-300 hover:-translate-y-1 hover:shadow-2xl"
                        >
                            <div class="relative aspect-[16/9] overflow-hidden rounded-xl bg-gradient-to-br {{ $gradients[$loop->index] }}">
                                @if ($project['image'] ?? null)
                                    <x-media.image
                                        :src="$project['image']"
                                        :alt="$project['title'].' project screenshot'"
                                        icon="photo"
                                        wrapperClass="h-full w-full"
                                        imgClass="h-full w-full object-cover"
                                    />
                                @endif
                            </div>

                            <div class="flex items-center justify-between gap-3 px-1 pb-1 pt-3">
                                <div class="min-w-0">
                                    <p class="truncate text-[11px] font-semibold uppercase tracking-wider text-primary-600">{{ $project['category'] }}</p>
                                    <h3 class="mt-0.5 truncate text-sm font-semibold text-gray-900">{{ $project['title'] }}</h3>
                                </div>
                                <span class="flex flex-none items-center gap-1.5 rounded-full bg-slate-100 px-2 py-1 text-[10px] font-semibold text-slate-600">
                                    <span class="h-1.5 w-1.5 rounded-full {{ $statusColors[$project['status']] ?? 'bg-slate-400' }}" aria-hidden="true"></span>
                                    {{ $project['status'] }}
                                </span>
                            </div>
                        </a>
                    @endforeach
                </div>

                @if ($badge)
                    <div class="absolute -right-3 -top-6 animate-float rounded-2xl bg-white px-4 py-3 shadow-card-hover ring-1 ring-gray-100 dark:bg-dark-card lg:-right-6">
                        <p class="flex items-center gap-2.5 text-sm font-semibold text-gray-900">
                            <span class="flex h-8 w-8 flex-none items-center justify-center rounded-full bg-primary-600/10">
                                <x-icon name="rectangle-stack" class="h-4 w-4 text-primary-600" />
                            </span>
                            {{ $badge }}
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
