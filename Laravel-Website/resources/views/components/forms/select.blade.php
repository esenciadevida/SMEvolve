@props([
    'name',
    'id' => null,
    'options' => [],
    'placeholder' => null,
    'selected' => null,
    'required' => false,
])

@php
    $id = $id ?? $name;
    $hasError = $errors->has($name);
    $finalSelected = old($name, $selected);
@endphp

<select
    name="{{ $name }}"
    id="{{ $id }}"
    @if ($required) required @endif
    aria-invalid="{{ $hasError ? 'true' : 'false' }}"
    @if ($hasError) aria-describedby="{{ $id }}-error" @endif
    {{ $attributes->class([
        'block w-full appearance-none rounded-xl border bg-white px-4 py-2.5 text-sm text-gray-900 shadow-sm transition focus:outline-none focus:ring-2 dark:bg-dark-card',
        'border-gray-300 focus:border-primary-600 focus:ring-primary-600/20' => ! $hasError,
        'border-error-500 bg-error-500/5 focus:border-error-500 focus:ring-error-500/20' => $hasError,
    ]) }}
>
    @if ($placeholder)
        <option value="" @disabled(is_null($finalSelected))>{{ $placeholder }}</option>
    @endif

    @foreach ($options as $optionValue => $optionLabel)
        <option value="{{ $optionValue }}" @selected((string) $finalSelected === (string) $optionValue)>
            {{ $optionLabel }}
        </option>
    @endforeach
</select>
