<x-emails::layouts.smevolve
    :title="$subjectLine"
    label="Security alert"
    subtitle="SMEvolve detected a failed sign-in attempt on the Admin Portal."
>
    @foreach ($messageLines as $line)
        <p style="margin:0 0 10px;">{{ $line }}</p>
    @endforeach

    @if (count($details) > 0)
        <x-emails::components.info-card :rows="$details" />
    @endif

    @if ($actionUrl)
        <x-emails::components.button :url="$actionUrl" :text="$actionText ?? 'Review the audit log'" />
    @endif

    <x-emails::components.alert tone="danger" title="What to do next">
        {{ $note }}
    </x-emails::components.alert>
</x-emails::layouts.smevolve>
