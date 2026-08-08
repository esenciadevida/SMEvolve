@php
    $hours = config('company.hours', []);
    $timezone = $hours['timezone'] ?? 'Africa/Lagos';
    $now = now($timezone);
    $day = (int) $now->format('N');
    $openDays = $hours['schedule']['open_days'] ?? [];
    $openTime = $hours['schedule']['open_time'] ?? '09:00';
    $closeTime = $hours['schedule']['close_time'] ?? '18:00';
    $currentTime = $now->format('H:i');

    $status = in_array($day, $openDays) && $currentTime >= $openTime && $currentTime < $closeTime
        ? 'open'
        : 'closed';

    $summary = $hours['summary'] ?? [];
    $holidayNotice = $hours['holiday_notice'] ?? null;
    $availabilityNotice = $hours['availability_notice'] ?? null;
@endphp

<x-sections.section
    id="business-hours"
    heading="Business Hours"
    description="We're available Monday to Friday and always happy to discuss projects, no matter your time zone."
    variant="surface"
>
    <div class="grid items-stretch gap-6 lg:grid-cols-2">
        <div class="rounded-2xl border border-gray-200/70 bg-white p-6 shadow-sm dark:bg-dark-card sm:p-8">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <span class="flex h-11 w-11 flex-none items-center justify-center rounded-xl bg-gradient-to-br from-primary-600 to-secondary-600 text-white shadow-sm">
                        <x-icon name="clock" class="h-5 w-5" />
                    </span>
                    <h3 class="text-base font-semibold tracking-tight text-gray-900">Business Hours</h3>
                </div>

                <span
                    role="status"
                    @class([
                        'inline-flex items-center gap-2 rounded-full px-3 py-1 text-xs font-semibold',
                        'bg-success-500/10 text-success-700' => $status === 'open',
                        'bg-gray-200/70 text-gray-700' => $status === 'closed',
                    ])
                >
                    <span @class(['h-2 w-2 rounded-full', 'bg-success-600' => $status === 'open', 'bg-gray-500' => $status === 'closed']) aria-hidden="true"></span>
                    {{ $status === 'open' ? 'Currently Open' : 'Currently Closed' }}
                </span>
            </div>

            <ul class="mt-6 space-y-3">
                @foreach ($summary as $row)
                    <li class="flex items-center justify-between gap-4 border-b border-gray-100 pb-3 text-sm last:border-b-0 last:pb-0">
                        <span class="text-gray-600">{{ $row['label'] }}</span>
                        <span class="inline-flex items-center gap-2 font-medium text-gray-900">
                            @if (($row['status'] ?? null) === 'open')
                                <span class="h-1.5 w-1.5 rounded-full bg-success-500" aria-hidden="true"></span>
                            @elseif (($row['status'] ?? null) === 'appointment')
                                <span class="h-1.5 w-1.5 rounded-full bg-warning-500" aria-hidden="true"></span>
                            @else
                                <span class="h-1.5 w-1.5 rounded-full bg-gray-300" aria-hidden="true"></span>
                            @endif
                            {{ $row['value'] }}
                        </span>
                    </li>
                @endforeach
            </ul>

            <p class="mt-6 flex items-center gap-2 text-sm text-gray-500">
                <x-icon name="globe-alt" class="h-4 w-4" />
                Time zone: <span class="font-medium text-gray-700">{{ $hours['timezone_label'] ?? $timezone }}</span>
            </p>

            @if ($holidayNotice)
                <p class="mt-4 rounded-xl bg-warning-500/10 px-4 py-3 text-sm leading-relaxed text-warning-700">{{ $holidayNotice }}</p>
            @endif
        </div>

        <div class="flex flex-col gap-6">
            @if ($availabilityNotice)
                <div class="flex items-start gap-3 rounded-2xl border border-primary-600/20 bg-primary-600/5 p-5">
                    <x-icon name="information-circle" class="mt-0.5 h-5 w-5 flex-none text-primary-600" />
                    <p class="text-sm leading-relaxed text-gray-700">{{ $availabilityNotice }}</p>
                </div>
            @endif
        </div>
    </div>
</x-sections.section>
