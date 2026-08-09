{{ $subjectLine }}

{{ $label }}
{{ str_repeat('=', min(mb_strlen($label), 40)) }}

@foreach ($messageLines as $line)
{{ $line }}
@endforeach

@if (count($details) > 0)

@foreach ($details as $detail)
{{ $detail['label'] }}: {{ \App\Support\EmailFormat::format($detail['value']) }}
@endforeach
@endif

@if ($actionUrl)

{{ $actionText ?? 'Open Admin Portal' }}:
{{ $actionUrl }}
@endif

{{ $note }}

This is an automated notification from SMEvolve. If you believe this event was unexpected, contact a Super Administrator.

Copyright (c) {{ date('Y') }} SMEvolve. All rights reserved.
smevolve.tech
