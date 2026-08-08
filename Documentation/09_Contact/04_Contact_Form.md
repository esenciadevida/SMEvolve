# SMEvolve Contact Page Specification
## Part 4 – Contact Form

**Project Name:** SMEvolve

**Website:** https://smevolve.tech

**Version:** 1.0

**Document Type:** Contact Form Specification

---

# Purpose

This document defines the structure, behaviour, validation, accessibility, and submission flow for the SMEvolve Contact Form.

The Contact Form is designed for general enquiries, support requests, partnership discussions, and project enquiries that do not require the structured Quote Wizard.

It should be simple, professional, and frictionless while collecting enough information for the SMEvolve team to respond effectively.

---

# AI Implementation Instructions

Before implementing this form:

1. Read the AI Constitution.
2. Read the Contact Overview.
3. Read Global Features → Forms & Validation.
4. Reuse all existing form components.
5. Use Laravel Form Requests.
6. Never duplicate validation logic.

---

# Business Goals

The form should:

- Generate qualified enquiries.
- Reduce spam.
- Encourage completion.
- Build confidence.
- Support future CRM integration.

---

# User Goals

Visitors should be able to:

- Complete the form quickly.
- Understand every field.
- Receive immediate confirmation.
- Correct mistakes easily.

---

# Form Layout

Recommended layout:

Desktop

Two-column layout where appropriate.

Mobile

Single-column layout.

Maintain generous spacing between fields.

---

# Form Fields

## Full Name

Required

Placeholder:

John Doe

---

## Business Name

Optional

Placeholder:

ABC Company Ltd.

---

## Email Address

Required

Type:

Email

Placeholder:

john@example.com

---

## Phone Number

Optional

Type:

Telephone

Placeholder:

+234 XXX XXX XXXX

---

## Preferred Contact Method

Required

Options:

- Email
- Phone
- WhatsApp

---

## Subject

Required

Dropdown options:

- General Enquiry
- New Project
- Website Development
- Custom Software
- Mobile App
- AI Solutions
- Business Automation
- Support
- Partnership
- Other

---

## Estimated Budget

Optional

Dropdown:

- Under ₦500,000
- ₦500,000 – ₦1,000,000
- ₦1M – ₦5M
- ₦5M+
- Prefer not to say

The values should remain configurable.

---

## Message

Required

Textarea

Placeholder:

Tell us about your project or enquiry...

Recommended minimum:

30 characters.

---

## Privacy Consent

Required

Checkbox

Label:

I agree to the Privacy Policy and consent to SMEvolve using my information to respond to this enquiry.

---

# Submit Button

Label:

Send Message

Loading state:

Sending...

Disable while processing.

---

# Validation

Validate:

- Required fields
- Email format
- Phone format
- Message minimum length
- Maximum field lengths

Preserve user input after validation failures.

---

# Spam Protection

Implement:

- CSRF Protection
- Honeypot Field
- Rate Limiting

Reserve support for future CAPTCHA integration.

---

# Success Flow

After successful submission:

Display:

Thank you!

We've received your message.

A member of the SMEvolve team will respond as soon as possible.

Provide buttons for:

- Return Home
- Explore Services

---

# Error Handling

Display:

Field-specific validation messages.

General errors should be friendly.

Never expose technical details.

---

# Notifications

Prepare architecture for:

- Email notification to SMEvolve
- Email confirmation to visitor

Implementation may vary depending on the configured mail provider.

---

# CRM Preparation

Structure the submission process so future integration with:

- HubSpot
- Zoho CRM
- Salesforce
- Custom CRM

can be added without redesigning the form.

---

# Security

Always:

- Validate server-side.
- Escape output.
- Sanitize input.
- Protect against XSS.
- Protect against spam.

---

# Accessibility

The form must:

- Associate labels with every field.
- Support keyboard navigation.
- Display accessible validation messages.
- Maintain visible focus states.
- Meet WCAG AA standards where practical.

---

# Analytics

Track:

- Form started
- Form submitted
- Validation failures
- Submission success
- Submission errors

---

# Components

Reuse or create:

- Text Input
- Select
- Textarea
- Checkbox
- Submit Button
- Validation Alert
- Success Alert

Avoid duplicate implementations.

---

# Acceptance Criteria

The Contact Form is complete when:

- Validation works correctly.
- Spam protection is implemented.
- Accessibility requirements are met.
- Responsive behaviour is verified.
- Confirmation messaging is displayed.
- Architecture supports future CRM integration.

---

# Revision Policy

Future fields or integrations should extend this specification while preserving simplicity and usability.