<x-emails::layouts.smevolve
    :title="$subjectLine"
    label="System notification"
    :subtitle="$summary"
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

    @if ($note)
        <x-emails::components.alert tone="info" title="Note">
            {{ $note }}
        </x-emails::components.alert>
    @endif
</x-emails::layouts.smevolve>
