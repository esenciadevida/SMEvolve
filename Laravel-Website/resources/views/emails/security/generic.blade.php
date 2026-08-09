<x-emails::layouts.smevolve
    :title="$subjectLine"
    label="Notification"
    subtitle="SMEvolve administrator notification."
>
    @foreach ($messageLines as $line)
        <p style="margin:0 0 10px;">{{ $line }}</p>
    @endforeach

    @if (count($details) > 0)
        <x-emails::components.info-card :rows="$details" />
    @endif

    @if ($actionUrl)
        <x-emails::components.button :url="$actionUrl" :text="$actionText ?? 'Open Admin Portal'" />
    @endif

    <x-emails::components.alert tone="info" title="Note">
        {{ $note }}
    </x-emails::components.alert>
</x-emails::layouts.smevolve>
