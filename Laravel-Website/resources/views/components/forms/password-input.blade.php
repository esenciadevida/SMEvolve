@props([
    'name' => 'password',
    'id' => null,
    'label' => null,
    'autocomplete' => 'new-password',
    'required' => false,
    'placeholder' => null,
])

@php
    $id = $id ?? $name;
    $hasError = $errors->has($name);
@endphp

<div x-data="{ show: false }">
    @if ($label)
        <label for="{{ $id }}" class="block text-sm font-medium text-slate-700 dark:text-slate-300">{{ $label }}</label>
    @endif

    <div class="relative {{ $label ? 'mt-1.5' : '' }}">
        <input
            type="password"
            x-bind:type="show ? 'text' : 'password'"
            name="{{ $name }}"
            id="{{ $id }}"
            @if ($placeholder) placeholder="{{ $placeholder }}" @endif
            @if ($autocomplete) autocomplete="{{ $autocomplete }}" @endif
            @if ($required) required @endif
            aria-invalid="{{ $hasError ? 'true' : 'false' }}"
            @if ($hasError) aria-describedby="{{ $id }}-error" @endif
            class="w-full rounded-xl border bg-white px-3.5 py-2.5 pr-11 text-sm text-slate-900 shadow-sm transition placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-primary-500/30 {{ $hasError ? 'border-error-500 focus:border-error-500' : 'border-slate-300 focus:border-primary-500 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100 dark:placeholder:text-slate-500' }}"
        >

        <button
            type="button"
            x-on:click="show = ! show"
            class="absolute inset-y-0 right-0 flex w-11 items-center justify-center rounded-xl text-slate-400 transition hover:text-slate-600 focus:outline-none focus:ring-2 focus:ring-primary-500/30 dark:text-slate-500 dark:hover:text-slate-300"
            :aria-pressed="show.toString()"
            :aria-label="show ? 'Hide password' : 'Show password'"
        >
            <x-icon name="eye" class="h-5 w-5" x-show="! show" x-cloak />
            <x-icon name="eye-slash" class="h-5 w-5" x-show="show" x-cloak />
        </button>
    </div>

    @if ($hasError)
        <p id="{{ $id }}-error" class="mt-1 text-sm text-error-600 dark:text-error-500">
            {{ $errors->first($name) }}
        </p>
    @endif
</div>
