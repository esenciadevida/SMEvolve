New Contact Message

A new contact message was submitted on the SMEvolve website.

Name: {{ $enquiry->name }}
Company: {{ $enquiry->company ?? 'Not supplied' }}
Email: {{ $enquiry->email }}
Phone: {{ $enquiry->phone ?? 'Not supplied' }}
Subject: {{ $enquiry->subjectLabel() }}
Contact method: {{ $enquiry->contactMethodLabel() }}
Received: {{ \App\Support\EmailFormat::format($enquiry->created_at) }}

Message:
{{ $enquiry->message }}

View Message:
{{ route('admin.contact.show', $enquiry) }}

This is an automated notification from SMEvolve.

Copyright (c) {{ date('Y') }} SMEvolve. All rights reserved.
smevolve.tech
