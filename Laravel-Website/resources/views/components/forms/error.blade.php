@props([
    'for' => null,
    'message' => null,
])

@if ($message)
    <p
        @if ($for) id="{{ $for }}-error" @endif
        role="alert"
        {{ $attributes->merge(['class' => 'flex items-start gap-1.5 text-sm text-error-500']) }}
    >
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-width="1.5" stroke="currentColor" class="mt-0.5 h-4 w-4 flex-none" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
        </svg>
        <span>{{ $message }}</span>
    </p>
@endif
