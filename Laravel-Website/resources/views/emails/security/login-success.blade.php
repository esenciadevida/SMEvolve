<x-emails::layouts.smevolve
    :title="$subjectLine"
    label="Security notification"
    subtitle="SMEvolve detected new activity on your administrator account."
>
    @foreach ($messageLines as $line)
        <p style="margin:0 0 10px;">{{ $line }}</p>
    @endforeach

    @if (count($details) > 0)
        <x-emails::components.info-card :rows="$details" />
    @endif

    @if ($actionUrl)
        <x-emails::components.button :url="$actionUrl" :text="$actionText ?? 'Review Admin Activity'" />
    @endif

    <x-emails::components.alert tone="warning" title="What to do next">
        {{ $note }}
    </x-emails::components.alert>
</x-emails::layouts.smevolve>
