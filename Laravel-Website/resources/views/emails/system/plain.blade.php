{{ $subjectLine }}

System notification

{{ $summary }}

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

@if ($note)
{{ $note }}
@endif

This is an automated notification from SMEvolve.

Copyright (c) {{ date('Y') }} SMEvolve. All rights reserved.
smevolve.tech
