@php
    $serviceArea = config('company.service_area', []);
    $maps = config('company.maps', []);
    $address = config('company.address', []);
    $location = $address['formatted'] ?? null;
    $directions = $maps['directions_url'] ?? null;
    $embed = $maps['embed_url'] ?? null;
@endphp

<x-sections.section
    id="map-and-service-area"
    heading="Where We Work"
    description="SMEvolve serves businesses in Lagos and across Nigeria, delivering projects remotely using modern communication and project management tools."
    variant="surface"
>
    <div class="grid items-stretch gap-10 lg:grid-cols-2">
        <div class="flex flex-col">
            @if (filled($serviceArea['introduction'] ?? null))
                <p class="max-w-xl text-base leading-relaxed text-gray-600">{{ $serviceArea['introduction'] }}</p>
            @endif

            @if (filled($serviceArea['coverage'] ?? null))
                <ul class="mt-8 space-y-4">
                    @foreach ($serviceArea['coverage'] as $coverage)
                        <li class="flex items-start gap-4 rounded-2xl border border-gray-200/70 bg-white p-5 shadow-sm dark:bg-dark-card">
                            <span class="flex h-11 w-11 flex-none items-center justify-center rounded-xl bg-primary-600/10 text-primary-600">
                                <x-icon :name="$coverage['icon']" class="h-5 w-5" />
                            </span>
                            <div>
                                <h3 class="text-sm font-semibold tracking-tight text-gray-900">{{ $coverage['title'] }}</h3>
                                <p class="mt-1 text-sm leading-relaxed text-gray-500">{{ $coverage['description'] }}</p>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif

            @if (filled($location))
                <p class="mt-8 text-sm text-gray-600">
                    <span class="font-semibold text-gray-900">Office:</span>
                    {{ $location }}
                </p>
            @endif

            @if ($directions)
                <div class="mt-auto pt-8">
                    <x-buttons.button href="{{ $directions }}" variant="secondary" target="_blank" rel="noopener" data-track="contact:directions">
                        <x-icon name="map-pin" class="h-5 w-5" />
                        Get Directions
                    </x-buttons.button>
                </div>
            @endif
        </div>

        <div class="lg:min-h-[26rem]">
            @if ($embed)
                <div
                    x-data="mapLoader"
                    class="relative h-full min-h-[24rem] overflow-hidden rounded-2xl border border-gray-200/70 bg-white shadow-sm dark:bg-dark-card"
                >
                    <div
                        x-show="! loaded"
                        class="absolute inset-0 flex flex-col items-center justify-center gap-4 p-6 text-center"
                        aria-label="Map placeholder"
                    >
                        <span class="flex h-14 w-14 items-center justify-center rounded-2xl bg-primary-600/10 text-primary-600">
                            <x-icon name="map" class="h-7 w-7" />
                        </span>
                        <p class="max-w-xs text-sm leading-relaxed text-gray-500">Load the interactive map to explore our service area.</p>
                        <button
                            type="button"
                            @click="load()"
                            class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-primary-600 to-secondary-600 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-primary-600/25 transition hover:from-primary-700 hover:to-secondary-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-primary-600 focus-visible:ring-offset-2"
                            data-track="contact:map:load"
                        >
                            <x-icon name="map-pin" class="h-5 w-5" />
                            Show Map
                        </button>
                    </div>

                    <template x-if="loaded">
                        <iframe
                            src="{{ $embed }}"
                            title="SMEvolve office location map"
                            loading="lazy"
                            allowfullscreen
                            referrerpolicy="no-referrer-when-downgrade"
                            class="h-full min-h-[24rem] w-full border-0"
                        ></iframe>
                    </template>
                </div>
            @endif
        </div>
    </div>
</x-sections.section>
