@props(['dark' => false])

@php
    $brand = config('mail.brand', []);
    $homeUrl = config('app.url', '/');
@endphp

<table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
    <tr>
        <td style="padding:4px 4px 18px;">
            <a href="{{ $homeUrl }}" style="text-decoration:none;">
                <span style="font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Arial,sans-serif;font-size:21px;font-weight:700;letter-spacing:-0.01em;color:#0f172a;">SMEvolve</span>
                <span style="font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Arial,sans-serif;font-size:21px;font-weight:700;color:{{ $brand['primary'] ?? '#2563eb' }};">.</span>
            </a>
        </td>
    </tr>
    <tr>
        <td style="padding:0;">
            <div style="border-top:3px solid {{ $brand['primary'] ?? '#2563eb' }};border-radius:2px;"></div>
        </td>
    </tr>
</table>
