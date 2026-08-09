@props(['tone' => 'info', 'title' => null])

@php
    $tones = [
        'info' => ['bg' => '#eff6ff', 'border' => '#2563eb', 'text' => '#1e3a8a'],
        'success' => ['bg' => '#f0fdf4', 'border' => '#16a34a', 'text' => '#14532d'],
        'warning' => ['bg' => '#fffbeb', 'border' => '#d97706', 'text' => '#78350f'],
        'danger' => ['bg' => '#fef2f2', 'border' => '#dc2626', 'text' => '#7f1d1d'],
    ];
    $palette = $tones[$tone] ?? $tones['info'];
@endphp

<table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="margin:20px 0 0;">
    <tr>
        <td style="background:{{ $palette['bg'] }};border-left:4px solid {{ $palette['border'] }};border-radius:8px;padding:14px 16px;">
            @if ($title)
                <p style="margin:0 0 4px;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Arial,sans-serif;font-size:12px;font-weight:600;letter-spacing:0.04em;text-transform:uppercase;color:{{ $palette['border'] }};">
                    {{ $title }}
                </p>
            @endif
            <div style="font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Arial,sans-serif;font-size:13px;line-height:1.6;color:{{ $palette['text'] }};">
                {{ $slot }}
            </div>
        </td>
    </tr>
</table>
