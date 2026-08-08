@props([
    'name',
    'value' => '1',
    'id' => null,
    'checked' => false,
    'label' => null,
    'description' => null,
    'required' => false,
])

@php
    $id = $id ?? $name.'_'.$value;
    $isChecked = (bool) old($name, $checked ? '1' : null);
@endphp

<div class="flex items-start gap-3">
    <input
        type="checkbox"
        name="{{ $name }}"
        value="{{ $value }}"
        id="{{ $id }}"
        @checked($isChecked)
        @if ($required) required @endif
        {{ $attributes->class([
            'mt-0.5 h-4 w-4 flex-none rounded border-gray-300 text-primary-600 shadow-sm transition focus:ring-2 focus:ring-primary-600/20',
        ]) }}
    >

    @if ($label || $slot->isNotEmpty())
        <label for="{{ $id }}" class="text-sm text-gray-700">
            {{ $label ?? $slot }}
            @if ($description)
                <span class="mt-0.5 block text-xs text-gray-500">{{ $description }}</span>
            @endif
        </label>
    @endif
</div>
