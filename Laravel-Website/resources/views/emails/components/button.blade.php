@props(['url' => null, 'text' => '', 'align' => 'left'])

@php
    $brand = config('mail.brand', []);
    $link = $url ?? config('app.url', '/');
    $label = $text !== '' ? $text : 'Open Admin Portal';
@endphp

<table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
    <tr>
        <td align="{{ $align }}" style="padding:20px 0 0;">
            <table role="presentation" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td align="center" style="border-radius:10px;background:{{ $brand['primary'] ?? '#2563eb' }};">
                        <a
                            href="{{ $link }}"
                            style="display:inline-block;padding:13px 30px;border-radius:10px;background:{{ $brand['primary'] ?? '#2563eb' }};font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Arial,sans-serif;font-size:14px;font-weight:600;color:#ffffff;text-decoration:none;line-height:1.4;"
                        >
                            {{ $label }}
                        </a>
                    </td>
                </tr>
            </table>
            @if ($url)
                <p style="margin:12px 0 0;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Arial,sans-serif;font-size:12px;line-height:1.5;color:#94a3b8;word-break:break-all;">
                    If the button does not work, copy this link: <a href="{{ $url }}" style="color:#64748b;">{{ $url }}</a>
                </p>
            @endif
        </td>
    </tr>
</table>
