@props([
    'packages' => [],
    'features' => [],
    'cta' => ['label' => 'Request Quote', 'route' => 'quote'],
    'recommended' => null,
])

@php
    $ctaHref = isset($cta['route']) ? route($cta['route']) : route('quote');
    $ctaLabel = $cta['label'] ?? 'Request Quote';
@endphp

<div class="overflow-x-auto rounded-2xl border border-gray-200/70 bg-white shadow-sm dark:bg-dark-card">
    <table class="w-full min-w-[640px] border-collapse text-left">
        <caption class="sr-only">
            Comparison of SMEvolve website packages across features, pricing, and support.
        </caption>

        <thead>
            <tr>
                <th scope="col" class="w-44 px-6 py-5 text-sm font-semibold uppercase tracking-widest text-gray-400">
                    Compare Packages
                </th>

                @foreach ($packages as $package)
                    @php $highlight = $recommended === ($package['slug'] ?? null); @endphp
                    <th scope="col" class="px-4 py-5 align-top {{ $highlight ? 'bg-primary-50/60 dark:bg-primary-600/10' : '' }}">
                        <span class="flex flex-col items-start gap-2">
                            <span class="text-base font-semibold tracking-tight text-gray-900">{{ $package['name'] }}</span>

                            @if (! empty($package['badge']))
                                <span class="rounded-full bg-gradient-to-r from-primary-600 to-secondary-600 px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-wide text-white">{{ $package['badge'] }}</span>
                            @endif
                        </span>
                    </th>
                @endforeach
            </tr>
        </thead>

        <tbody class="divide-y divide-gray-100">
            @foreach ($features as $row)
                <tr>
                    <th scope="row" class="px-6 py-4 text-sm font-semibold text-gray-900">{{ $row['label'] }}</th>

                    @foreach ($packages as $package)
                        @php $highlight = $recommended === ($package['slug'] ?? null); @endphp
                        <td class="px-4 py-4 align-top {{ $highlight ? 'bg-primary-50/60 dark:bg-primary-600/10' : '' }}">
                            <x-comparison.value :value="$row['values'][$package['slug'] ?? null] ?? null" />
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>

        <tfoot class="border-t border-gray-200 bg-surface">
            <tr>
                <th scope="row" class="px-6 py-5 text-sm font-semibold text-gray-900">Ready to start?</th>

                @foreach ($packages as $package)
                    @php $highlight = $recommended === ($package['slug'] ?? null); @endphp
                    <td class="px-4 py-5 {{ $highlight ? 'bg-primary-50/60 dark:bg-primary-600/10' : '' }}">
                        <x-buttons.button
                            :href="$ctaHref"
                            :variant="$highlight ? 'primary' : 'secondary'"
                            class="w-full whitespace-nowrap"
                            data-track="packages:compare:cta"
                            data-track-data="{{ json_encode(['package' => $package['slug'] ?? null]) }}"
                        >
                            {{ $ctaLabel }}
                        </x-buttons.button>
                    </td>
                @endforeach
            </tr>
        </tfoot>
    </table>
</div>
