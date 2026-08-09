@php
    $brand = config('mail.brand', []);
    $homeUrl = config('app.url', '/');
    $domain = parse_url($homeUrl, PHP_URL_HOST) ?: 'smevolve.tech';
    $year = date('Y');
@endphp

<table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
    <tr>
        <td align="center" class="smev-footer" style="padding:26px 8px 4px;">
            <p style="margin:0;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Arial,sans-serif;font-size:13px;font-weight:700;color:{{ $brand['text'] ?? '#0f172a' }};">
                {{ $brand['name'] ?? 'SMEvolve' }}
            </p>
            <p style="margin:6px 0 0;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Arial,sans-serif;font-size:12px;line-height:1.5;color:{{ $brand['muted'] ?? '#64748b' }};">
                <a href="{{ $homeUrl }}" style="color:{{ $brand['muted'] ?? '#64748b' }};text-decoration:none;">{{ $domain }}</a>
            </p>
            <p style="margin:6px 0 0;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Arial,sans-serif;font-size:11px;line-height:1.5;color:{{ $brand['faint'] ?? '#94a3b8' }};">
                &copy; {{ $year }} {{ $brand['name'] ?? 'SMEvolve' }}. All rights reserved.
            </p>
        </td>
    </tr>
</table>
