@props([
    'for' => null,
    'required' => false,
    'optional' => false,
])

<label
    @if ($for) for="{{ $for }}" @endif
    {{ $attributes->merge(['class' => 'block text-sm font-semibold text-gray-800']) }}
>
    {{ $slot }}

    @if ($required)
        <span class="text-error-500" aria-hidden="true"> *</span>
    @elseif ($optional)
        <span class="ml-1 text-xs font-normal text-gray-400">(optional)</span>
    @endif
</label>
