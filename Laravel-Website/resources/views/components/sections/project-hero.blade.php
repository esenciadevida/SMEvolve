@props([
    'project' => [],
    'id' => null,
])

@php
    $title = $project['title'] ?? 'Project';
    $category = $project['category'] ?? '';
    $status = $project['status'] ?? '';
    $industry = $project['industry'] ?? '';
    $summary = $project['summary'] ?? '';
    $technologies = $project['technologies'] ?? [];
    $image = $project['image'] ?? null;
    $statusColors = [
        'Completed' => 'bg-accent-500',
        'Ongoing' => 'bg-primary-400',
        'Concept Project' => 'bg-secondary-500',
        'Sample Project' => 'bg-primary-400',
    ];
@endphp

<section id="{{ $id ?? Str::slug($title) }}-hero" class="relative flex min-h-svh flex-col overflow-hidden bg-dark text-white" aria-labelledby="{{ $id ?? Str::slug($title) }}-heading">
    <div aria-hidden="true" class="pointer-events-none absolute inset-0">
        <div class="absolute inset-0 bg-[linear-gradient(to_right,rgb(255_255_255/0.04)_1px,transparent_1px),linear-gradient(to_bottom,rgb(255_255_255/0.04)_1px,transparent_1px)] bg-[size:3rem_3rem] [mask-image:radial-gradient(ellipse_70%_60%_at_50%_0%,#000_70%,transparent_110%)]"></div>
        <div class="absolute -top-32 right-0 h-[28rem] w-[28rem] rounded-full bg-primary-600/25 blur-3xl"></div>
        <div class="absolute -left-24 bottom-0 h-80 w-80 rounded-full bg-secondary-600/20 blur-3xl"></div>
    </div>

    <div class="relative mx-auto my-auto w-full max-w-site px-6 pt-10 lg:px-8 lg:pt-14">
        <x-breadcrumbs
            :items="[
                ['label' => 'Portfolio', 'url' => route('portfolio')],
                ['label' => $category, 'url' => route('portfolio.category', $project['categorySlug'])],
                ['label' => $title],
            ]"
            variant="dark"
        />

        <div class="grid items-center gap-14 py-14 lg:grid-cols-2 lg:py-20">
            <div>
                <div class="flex items-center gap-3">
                    <span class="text-sm font-semibold uppercase tracking-widest text-primary-400">{{ $category }}</span>
                    <span class="flex items-center gap-1.5 rounded-full bg-white/10 px-3 py-1 text-xs font-semibold text-slate-300">
                        <span class="h-1.5 w-1.5 rounded-full {{ $statusColors[$status] ?? 'bg-slate-400' }}" aria-hidden="true"></span>
                        {{ $status }}
                    </span>
                </div>

                <h1 id="{{ $id ?? Str::slug($title) }}-heading" class="mt-3 text-balance text-4xl font-bold tracking-tight sm:text-5xl">
                    {{ $title }}
                </h1>

                <p class="mt-6 max-w-xl text-lg leading-relaxed text-slate-300">{{ $summary }}</p>

                <ul class="mt-8 grid gap-3 sm:grid-cols-2">
                    <li class="flex items-center gap-3 rounded-xl bg-white/5 px-4 py-3 ring-1 ring-inset ring-white/10">
                        <x-icon name="building-library" class="h-5 w-5 flex-none text-primary-400" />
                        <span class="text-sm text-slate-300">
                            <span class="block text-[11px] font-semibold uppercase tracking-wider text-slate-500">Industry</span>
                            {{ $industry }}
                        </span>
                    </li>
                    <li class="flex items-center gap-3 rounded-xl bg-white/5 px-4 py-3 ring-1 ring-inset ring-white/10">
                        <x-icon name="clock" class="h-5 w-5 flex-none text-primary-400" />
                        <span class="text-sm text-slate-300">
                            <span class="block text-[11px] font-semibold uppercase tracking-wider text-slate-500">Status</span>
                            {{ $status }}
                        </span>
                    </li>
                </ul>

                <div class="mt-8 flex flex-wrap gap-3">
                    <x-buttons.button variant="white" href="{{ route('quote') }}">
                        Start a Project Like This
                    </x-buttons.button>
                    <x-buttons.button variant="outline-white" href="{{ route('portfolio') }}">
                        Back to Portfolio
                    </x-buttons.button>
                </div>
            </div>

            <div class="relative">
                <div class="relative aspect-video w-full overflow-hidden rounded-3xl bg-gradient-to-br from-primary-800 to-secondary-700 shadow-2xl shadow-black/30 ring-1 ring-inset ring-white/15">
                    @if ($image)
                        <x-media.image :src="$image" :alt="$title.' project screenshot'" loading="eager" fetchpriority="high" wrapperClass="h-full w-full" imgClass="h-full w-full object-cover" />
                    @else
                        <div class="absolute inset-0 flex items-center justify-center" role="img" aria-label="{{ $title }} project preview placeholder">
                            <x-icon name="photo" class="h-16 w-16 text-white/25" />
                        </div>
                    @endif

                    @if (filled($technologies))
                        <div class="absolute bottom-4 left-4 flex flex-wrap gap-2">
                            @foreach ($technologies as $technology)
                                <span class="rounded-full bg-white/15 px-3 py-1 text-xs font-semibold text-white backdrop-blur">{{ $technology }}</span>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="absolute -bottom-6 -right-4 hidden animate-float rounded-2xl bg-white px-4 py-3 shadow-card-hover ring-1 ring-gray-100 dark:bg-dark-card sm:block lg:-right-6">
                    <p class="flex items-center gap-2.5 text-sm font-semibold text-gray-900">
                        <span class="flex h-8 w-8 flex-none items-center justify-center rounded-full bg-primary-600/10">
                            <x-icon name="sparkles" class="h-4 w-4 text-primary-600" />
                        </span>
                        {{ $status }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
