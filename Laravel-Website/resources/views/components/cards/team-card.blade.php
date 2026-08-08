@props([
    'name',
    'role' => null,
    'bio' => null,
    'image' => null,
    'linkedin' => null,
])

<article {{ $attributes->class('group flex h-full flex-col rounded-2xl border border-gray-200/70 bg-white p-6 text-left shadow-sm dark:bg-dark-card transition duration-300 hover:-translate-y-1 hover:border-primary-600/40 hover:shadow-card-hover') }}>
    @if ($image)
        <x-media.image
            :src="$image"
            :alt="'Photo of '.$name"
            wrapperClass="h-20 w-20 flex-none rounded-2xl ring-1 ring-gray-200"
        />
    @else
        <div class="flex h-20 w-20 items-center justify-center rounded-2xl bg-gradient-to-br from-primary-600 to-secondary-600 text-3xl font-bold text-white shadow-md shadow-primary-600/20" aria-hidden="true">
            {{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($name, 0, 1)) }}
        </div>
    @endif

    <h3 class="mt-5 text-lg font-semibold tracking-tight text-gray-900">{{ $name }}</h3>

    @if ($role)
        <p class="mt-1 text-sm font-medium text-primary-600">{{ $role }}</p>
    @endif

    @if ($bio)
        <p class="mt-3 text-sm leading-relaxed text-gray-600">{{ $bio }}</p>
    @endif

    @if ($linkedin)
        <a href="{{ $linkedin }}" target="_blank" rel="noopener noreferrer" class="mt-4 inline-flex items-center gap-1.5 text-sm font-semibold text-primary-600 transition hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300">
            LinkedIn
            <x-icon name="arrow-right" class="h-4 w-4" />
        </a>
    @endif
</article>
