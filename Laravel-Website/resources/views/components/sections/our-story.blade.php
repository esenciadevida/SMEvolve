@props(['id' => 'our-story'])

@php
    $story = (new \App\Data\AboutData())->story();
    $principles = (new \App\Data\AboutData())->principles();
@endphp

<section id="{{ $id }}" class="bg-white dark:bg-dark" aria-labelledby="{{ $id }}-heading">
    <div class="mx-auto grid max-w-site gap-16 px-6 py-16 lg:grid-cols-2 lg:gap-20 lg:px-8 lg:py-24">
        <div>
            <h2 id="{{ $id }}-heading" class="text-balance text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                Built on a Simple Belief
            </h2>

            <div class="mt-8 space-y-5 text-lg leading-relaxed text-gray-600">
                @foreach ($story as $paragraph)
                    <p>{{ $paragraph }}</p>
                @endforeach
            </div>

            <p class="mt-8 font-medium leading-relaxed text-primary-700 dark:text-primary-400">
                Everything we do is guided by a clear mission, a forward-looking vision, and the values we hold ourselves to.
            </p>
        </div>

        <div>
            <h3 class="text-sm font-semibold uppercase tracking-widest text-primary-600">Key Principles</h3>

            <ul class="mt-6 space-y-4">
                @foreach ($principles as $principle)
                    <li class="flex items-start gap-4">
                        <span class="flex h-11 w-11 flex-none items-center justify-center rounded-xl bg-gradient-to-br from-primary-600 to-secondary-600 text-white shadow-md shadow-primary-600/20">
                            <x-icon :name="$principle['icon']" class="h-5 w-5" />
                        </span>
                        <p class="pt-2.5 text-base font-medium leading-relaxed text-gray-900">{{ $principle['statement'] }}</p>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</section>
