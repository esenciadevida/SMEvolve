@props([
    'question' => [],
    'answers' => [],
])

@php
    $key = $question['key'];
    $type = $question['type'] ?? 'text';
    $label = $question['label'] ?? '';
    $required = (bool) ($question['required'] ?? false);
    $placeholder = $question['placeholder'] ?? null;
    $options = $question['options'] ?? [];
    $id = 'question-'.$key;

    $value = $answers[$key] ?? null;
    $valueArray = $value !== null && $value !== '' ? array_values(array_filter(array_map('trim', explode(',', (string) $value)))) : [];

    $old = old($key);
    if ($type === 'multiple_choice' && is_array($old) && $old !== []) {
        $valueArray = array_values($old);
    } elseif (is_string($old) && $old !== '') {
        if ($type === 'multiple_choice') {
            $valueArray = array_values(array_filter(array_map('trim', explode(',', $old))));
        } else {
            $value = $old;
        }
    }

    $inputType = match ($type) {
        'email' => 'email',
        'url' => 'url',
        'phone' => 'tel',
        default => 'text',
    };

    $autocomplete = match ($key) {
        'full_name' => 'name',
        'email' => 'email',
        'phone' => 'tel',
        'company_name', 'business_name' => 'organization',
        default => null,
    };
@endphp

<div class="space-y-2">
    @if ($type !== 'single_choice' && $type !== 'multiple_choice')
        <x-forms.label :for="$id" :required="$required" :optional="! $required">
            {{ $label }}
        </x-forms.label>
    @endif

    @if ($type === 'single_choice')
        <fieldset>
            <legend class="text-sm font-semibold text-gray-800">
                {{ $label }}
                @if ($required)
                    <span class="text-error-500" aria-hidden="true"> *</span>
                @else
                    <span class="ml-1 text-xs font-normal text-gray-400">(optional)</span>
                @endif
            </legend>

            <div class="mt-3 grid gap-2.5 sm:grid-cols-2">
                @foreach ($options as $option)
                    <label class="flex cursor-pointer items-start gap-3 rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 transition hover:border-primary-500 hover:bg-primary-50/40 focus-within:ring-2 focus-within:ring-primary-600/20 dark:border-gray-600 dark:bg-dark-card">
                        <input
                            type="radio"
                            name="{{ $key }}"
                            value="{{ $option['key'] }}"
                            class="mt-0.5 h-4 w-4 flex-none rounded-full border-gray-300 text-primary-600 shadow-sm focus:ring-2 focus:ring-primary-600/20"
                            @checked((string) ($value ?? '') === (string) $option['key'])
                        >
                        <span class="font-medium">{{ $option['label'] }}</span>
                    </label>
                @endforeach
            </div>
        </fieldset>
    @elseif ($type === 'multiple_choice')
        <fieldset>
            <legend class="text-sm font-semibold text-gray-800">
                {{ $label }}
                @if ($required)
                    <span class="text-error-500" aria-hidden="true"> *</span>
                @else
                    <span class="ml-1 text-xs font-normal text-gray-400">(optional)</span>
                @endif
            </legend>

            @php
                $grouped = collect($options)->groupBy(fn ($option) => $option['category'] ?? 'general');
            @endphp

            <div class="mt-3 space-y-4">
                @foreach ($grouped as $category => $categoryOptions)
                    <div>
                        @if ($category !== 'general')
                            <p class="mb-2 text-xs font-semibold uppercase tracking-wider text-gray-500">{{ $category }}</p>
                        @endif
                        <div class="grid gap-2.5 sm:grid-cols-2">
                            @foreach ($categoryOptions as $option)
                                <label class="flex cursor-pointer items-start gap-3 rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 transition hover:border-primary-500 hover:bg-primary-50/40 focus-within:ring-2 focus-within:ring-primary-600/20 dark:border-gray-600 dark:bg-dark-card">
                                    <input
                                        type="checkbox"
                                        name="{{ $key }}[]"
                                        value="{{ $option['key'] }}"
                                        class="mt-0.5 h-4 w-4 flex-none rounded border-gray-300 text-primary-600 shadow-sm focus:ring-2 focus:ring-primary-600/20"
                                        @checked(in_array($option['key'], $valueArray, true))
                                    >
                                    <span class="font-medium">{{ $option['label'] }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </fieldset>
    @elseif ($type === 'textarea')
        <x-forms.textarea
            :name="$key"
            :id="$id"
            :rows="$question['rows'] ?? 5"
            :value="$value"
            :placeholder="$placeholder"
            :required="$required"
            :maxlength="$question['max'] ?? null"
        />
    @else
        <x-forms.input
            :name="$key"
            :id="$id"
            :type="$inputType"
            :value="$value"
            :placeholder="$placeholder"
            :autocomplete="$autocomplete"
            :required="$required"
            :maxlength="$question['max'] ?? null"
            @if ($inputType === 'tel') inputmode="tel" @endif
            @if ($inputType === 'email') inputmode="email" @endif
        />
    @endif

    <x-forms.error :for="$id" :message="$errors->first($key)" />

    @if ($key === 'phone')
        <p class="text-xs text-gray-500">Include your country code, e.g. +234 800 000 0000.</p>
    @endif
</div>
