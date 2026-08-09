@php
    $brand = config('mail.brand', []);
@endphp

<table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
    <tr>
        <td style="padding:24px 0 0;">
            <div style="border-top:1px solid {{ $brand['border'] ?? '#e2e8f0' }};"></div>
        </td>
    </tr>
</table>
