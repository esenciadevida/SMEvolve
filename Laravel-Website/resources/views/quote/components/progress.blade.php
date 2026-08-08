@props([
    'steps' => [],
    'currentKey' => '',
    'stepNumber' => 1,
    'totalSteps' => 1,
])

@php
    $keys = collect($steps)->pluck('key')->values();
    $currentIndex = max(0, $keys->search($currentKey) === false ? 0 : $keys->search($currentKey));
@endphp

<div class="w-full">
    <div class="mb-4 flex items-center justify-between text-sm">
        <span class="font-semibold text-gray-900">Step {{ $stepNumber }} of {{ $totalSteps }}</span>
        <span class="text-xs text-gray-500">{{ round(($stepNumber / max(1, $totalSteps)) * 100) }}% complete</span>
    </div>

    <div class="h-2 w-full overflow-hidden rounded-full bg-gray-200 dark:bg-gray-700" role="progressbar" aria-valuenow="{{ $stepNumber }}" aria-valuemin="1" aria-valuemax="{{ $totalSteps }}">
        <div class="h-full rounded-full bg-gradient-to-r from-primary-600 to-secondary-600 transition-all duration-500" style="width: {{ ($stepNumber / max(1, $totalSteps)) * 100 }}%"></div>
    </div>

    <ol class="mt-6 hidden gap-2 md:flex">
        @foreach ($steps as $index => $step)
            @php
                $state = $index < $currentIndex ? 'done' : ($index === $currentIndex ? 'current' : 'todo');
            @endphp
            <li class="flex flex-1 items-center gap-2">
                <span
                    @class([
                        'flex h-7 w-7 flex-none items-center justify-center rounded-full text-xs font-bold',
                        'bg-primary-600 text-white' => $state === 'current',
                        'bg-primary-100 text-primary-700' => $state === 'done',
                        'bg-gray-200 text-gray-500' => $state === 'todo',
                    ])
                >
                    @if ($state === 'done')
                        <x-icon name="check-circle" class="h-4 w-4" />
                    @else
                        {{ $index + 1 }}
                    @endif
                </span>
                <span
                    @class([
                        'truncate text-xs font-medium',
                        'text-primary-700' => $state === 'current',
                        'text-gray-500' => $state === 'todo',
                        'text-gray-700' => $state === 'done',
                    ])
                >
                    {{ $step['label'] }}
                </span>
            </li>
        @endforeach
    </ol>
</div>
