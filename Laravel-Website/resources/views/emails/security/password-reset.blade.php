<x-emails::layouts.smevolve
    :title="$subjectLine"
    label="Password reset"
    subtitle="SMEvolve administrator account security notice."
>
    @foreach ($messageLines as $line)
        <p style="margin:0 0 10px;">{{ $line }}</p>
    @endforeach

    @if (count($details) > 0)
        <x-emails::components.info-card :rows="$details" />
    @endif

    @if ($actionUrl)
        <x-emails::components.button :url="$actionUrl" :text="$actionText ?? 'Reset Password'" />
    @endif

    <x-emails::components.alert tone="warning" title="Security notice">
        {{ $note }}
    </x-emails::components.alert>
</x-emails::layouts.smevolve>
