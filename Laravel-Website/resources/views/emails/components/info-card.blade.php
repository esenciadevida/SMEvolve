@props(['rows' => []])

@php
    $brand = config('mail.brand', []);
@endphp

@if (count($rows) > 0)
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="margin:20px 0 0;border:1px solid {{ $brand['border'] ?? '#e2e8f0' }};border-radius:10px;background:{{ $brand['surface'] ?? '#f8fafc' }};">
        @foreach ($rows as $row)
            @php
                $label = is_array($row) ? ($row['label'] ?? '') : '';
                $value = is_array($row) ? ($row['value'] ?? '') : $row;
                $last = $loop->last;
            @endphp
            <tr>
                <td width="150" style="padding:11px 16px;vertical-align:top;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Arial,sans-serif;font-size:12px;font-weight:600;color:{{ $brand['muted'] ?? '#64748b' }};border-bottom:{{ $last ? '0' : '1px solid ' . ($brand['border'] ?? '#e2e8f0') }};">
                    {{ $label }}
                </td>
                <td style="padding:11px 16px;vertical-align:top;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Arial,sans-serif;font-size:13px;line-height:1.5;color:#0f172a;border-bottom:{{ $last ? '0' : '1px solid ' . ($brand['border'] ?? '#e2e8f0') }};word-break:break-word;">
                    {{ \App\Support\EmailFormat::format($value) }}
                </td>
            </tr>
        @endforeach
    </table>
@endif
