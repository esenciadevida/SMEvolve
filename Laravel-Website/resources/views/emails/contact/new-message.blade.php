<x-emails::layouts.smevolve
    :title="'New Contact Message'"
    label="Business notification"
    subtitle="A new contact message was submitted on the SMEvolve website."
>
    <p style="margin:0 0 6px;">A new enquiry has arrived through the website contact form.</p>

    <x-emails::components.info-card :rows="[
        ['label' => 'Name', 'value' => $enquiry->name],
        ['label' => 'Company', 'value' => $enquiry->company ?? 'Not supplied'],
        ['label' => 'Email', 'value' => $enquiry->email],
        ['label' => 'Phone', 'value' => $enquiry->phone ?? 'Not supplied'],
        ['label' => 'Subject', 'value' => $enquiry->subjectLabel()],
        ['label' => 'Contact method', 'value' => $enquiry->contactMethodLabel()],
        ['label' => 'Received', 'value' => $enquiry->created_at],
    ]" />

    <p style="margin:22px 0 4px;font-size:12px;font-weight:600;letter-spacing:0.04em;text-transform:uppercase;color:#64748b;">Message</p>
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="margin:6px 0 0;border:1px solid #e2e8f0;border-radius:8px;background:#f8fafc;">
        <tr>
            <td style="padding:14px 16px;font-size:13px;line-height:1.6;color:#0f172a;white-space:pre-wrap;">{{ $enquiry->message }}</td>
        </tr>
    </table>

    <x-emails::components.button :url="route('admin.contact.show', $enquiry)" text="View Message" />

    <x-emails::components.alert tone="info" title="Next step">
        Reply to this enquiry from the Admin Portal.
    </x-emails::components.alert>
</x-emails::layouts.smevolve>
