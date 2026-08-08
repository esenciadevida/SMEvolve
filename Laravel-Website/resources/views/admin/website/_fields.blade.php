@foreach ($definitions as $key => $definition)
    @php
        $label = $definition['label'] ?? $key;
        $type = $definition['type'] ?? 'string';
        $current = $values[$key] ?? null;
        $parts = explode('.', $key);
        $fieldName = array_shift($parts).(count($parts) ? '['.implode('][', $parts).']' : '');
        $fieldId = 'field-'.str_replace('.', '-', $key);
    @endphp

    <div>
        <label for="{{ $fieldId }}" class="block text-sm font-medium">{{ $label }}</label>

        @if ($type === 'textarea')
            <textarea
                id="{{ $fieldId }}"
                name="{{ $fieldName }}"
                rows="3"
                class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/30 dark:border-slate-700 dark:bg-slate-800"
            >{{ old($key, (string) $current) }}</textarea>
        @else
            <input
                type="text"
                id="{{ $fieldId }}"
                name="{{ $fieldName }}"
                value="{{ old($key, $current !== null ? (string) $current : '') }}"
                class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500/30 dark:border-slate-700 dark:bg-slate-800"
            >
        @endif
    </div>
@endforeach
