@props([
    'name',
    'id' => null,
    'type' => 'text',
    'value' => null,
    'placeholder' => null,
    'autocomplete' => null,
    'required' => false,
    'inputmode' => null,
])

@php
    $id = $id ?? $name;
    $hasError = $errors->has($name);
    $finalValue = in_array($type, ['password', 'number'], true) ? $value : old($name, $value);
@endphp

<input
    type="{{ $type }}"
    name="{{ $name }}"
    id="{{ $id }}"
    value="{{ $finalValue }}"
    @if ($placeholder) placeholder="{{ $placeholder }}" @endif
    @if ($autocomplete) autocomplete="{{ $autocomplete }}" @endif
    @if ($inputmode) inputmode="{{ $inputmode }}" @endif
    @if ($required) required @endif
    aria-invalid="{{ $hasError ? 'true' : 'false' }}"
    @if ($hasError) aria-describedby="{{ $id }}-error" @endif
    {{ $attributes->class([
        'block w-full rounded-xl border px-4 py-2.5 text-sm text-gray-900 placeholder:text-gray-400 shadow-sm transition focus:outline-none focus:ring-2',
        'border-gray-300 bg-white focus:border-primary-600 focus:ring-primary-600/20 dark:border-gray-600 dark:bg-dark-card' => ! $hasError,
        'border-error-500 bg-error-500/5 focus:border-error-500 focus:ring-error-500/20' => $hasError,
    ]) }}
>
