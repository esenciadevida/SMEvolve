<x-mail::message>
# SMEvolve Security Notification

{{ $greeting ?? 'You are receiving this notification because an important security event occurred on the SMEvolve Admin Portal.' }}

@if (count($messageLines) > 0)
@foreach ($messageLines as $line)
{{ $line }}

@endforeach
@endif

@if (count($details) > 0)
| | |
| - | - |
@foreach ($details as $detail)
| {{ $detail['label'] }} | {{ $detail['value'] }} |
@endforeach

@endif

@if ($actionUrl)
<x-mail::button :url="$actionUrl">
{{ $actionText ?? 'Open Admin Portal' }}
</x-mail::button>

@endif

This is an automated security notification. Please contact a Super Administrator if you believe this event was unexpected.

Thanks,<br>
The {{ config('app.name') }} Team
</x-mail::message>
