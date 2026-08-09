@props([
    'title' => '',
    'subtitle' => null,
    'label' => null,
    'preheader' => null,
])

@php
    $brand = config('mail.brand', []);
@endphp
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="x-apple-disable-message-reformatting">
    <meta name="color-scheme" content="light">
    <meta name="supported-color-schemes" content="light">
    <title>{{ $title }}</title>
    <!--[if mso]>
    <noscript>
        <xml>
            <o:OfficeDocumentSettings>
                <o:PixelsPerInch>96</o:PixelsPerInch>
            </o:OfficeDocumentSettings>
        </xml>
    </noscript>
    <style>
        table, td, a { font-family: Arial, sans-serif; }
    </style>
    <![endif]-->
    <style>
        @media (max-width: 620px) {
            .smev-content { padding: 24px 20px !important; }
            .smev-inner { width: 100% !important; }
        }
        @media (prefers-color-scheme: dark) {
            .smev-outer { background: #0f172a !important; }
            .smev-card { background: #1e293b !important; }
            .smev-card h1, .smev-card p { color: #f8fafc !important; }
            .smev-footer, .smev-footer a { color: #94a3b8 !important; }
        }
        @media (prefers-color-scheme: light) {
            .smev-outer { background: #f1f5f9 !important; }
        }
    </style>
</head>
<body style="margin:0;padding:0;background:#f1f5f9;" class="smev-outer">
    @if ($preheader)
        <div style="display:none;font-size:1px;line-height:1px;max-height:0;max-width:0;opacity:0;overflow:hidden;mso-hide:all;">
            {{ $preheader }}
        </div>
    @endif

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#f1f5f9;">
        <tr>
            <td align="center" style="padding:32px 16px;">
                <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="600" class="smev-inner" style="width:600px;max-width:600px;">
                    <tr>
                        <td>
                            <x-emails::components.header />
                        </td>
                    </tr>
                    <tr>
                        <td class="smev-card" style="background:#ffffff;border-radius:12px;padding:32px 36px;box-shadow:0 1px 3px rgba(15,23,42,0.06);border:1px solid #e2e8f0;">

                            @if ($label)
                                <p style="margin:0 0 6px;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Arial,sans-serif;font-size:12px;font-weight:600;letter-spacing:0.08em;text-transform:uppercase;color:{{ $brand['primary'] ?? '#2563eb' }};">
                                    {{ $label }}
                                </p>
                            @endif

                            <h1 style="margin:0;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Arial,sans-serif;font-size:22px;font-weight:700;line-height:1.3;color:#0f172a;">
                                {{ $title }}
                            </h1>

                            @if ($subtitle)
                                <p style="margin:8px 0 0;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Arial,sans-serif;font-size:14px;line-height:1.6;color:#64748b;">
                                    {{ $subtitle }}
                                </p>
                            @endif

                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td class="smev-content" style="padding:24px 0 0;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Arial,sans-serif;font-size:14px;line-height:1.6;color:#334155;">
                                        {{ $slot }}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <x-emails::components.footer />
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
