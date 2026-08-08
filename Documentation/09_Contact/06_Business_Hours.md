# SMEvolve Contact Page Specification
## Part 6 – Business Hours

**Project Name:** SMEvolve

**Website:** https://smevolve.tech

**Version:** 1.0

**Document Type:** Business Hours Specification

---

# Purpose

This document defines how SMEvolve communicates its business hours, availability, and expected response times.

Rather than simply listing opening hours, this section should reassure visitors that enquiries are acknowledged promptly and that communication is reliable.

---

# AI Implementation Instructions

Before implementing this section:

1. Read the AI Constitution.
2. Read the Contact Overview.
3. Read the Global Features documentation.
4. Reuse existing Card and Section components.

Business hours should be configurable.

---

# Business Goals

This section should:

- Build trust.
- Set communication expectations.
- Reduce uncertainty.
- Encourage enquiries regardless of time zone.

---

# User Goals

Visitors should quickly understand:

- When SMEvolve is available.
- Expected response times.
- Which communication channel is fastest.
- Whether support is available outside business hours.

---

# Layout

Recommended layout:

Desktop

Two-column layout.

Left

Business Hours

Right

Response Expectations

Mobile

Stack vertically.

---

# Business Hours

Display:

Monday – Friday

9:00 AM – 6:00 PM

Saturday

By Appointment

Sunday

Closed

Business hours should be configurable.

---

# Response Times

Display estimated response times.

Suggested examples:

💬 WhatsApp

Usually within 1 hour during business hours.

---

✉️ Email

Usually within 1 business day.

---

📞 Phone

Available during business hours.

---

📋 Quote Requests

Typically reviewed within one business day.

---

# Time Zone

Display the operating time zone.

Example:

West Africa Time (WAT)

This helps international clients.

---

# Holidays

Provide optional holiday messaging.

Example:

During public holidays, response times may be slightly longer than usual.

Holiday schedules should be configurable.

---

# Availability Notice

Display a reassuring message.

Example:

If you contact us outside business hours, we'll respond as soon as we're back online.

---

# Configuration

Store values in:

config/company.php

Suggested configuration:

- Working Days
- Opening Hours
- Closing Hours
- Time Zone
- Holiday Notice
- Response Time Estimates

Avoid hard-coded values.

---

# Visual Design

Use cards with icons.

Examples:

🕒 Business Hours

💬 WhatsApp

✉️ Email

📞 Phone

Keep the layout clean and easy to scan.

---

# Accessibility

The section must:

- Use semantic headings.
- Support keyboard navigation.
- Maintain visible focus states.
- Meet WCAG AA standards where practical.

---

# Responsive Behaviour

Desktop

Two-column layout.

Tablet

Two-column where space allows.

Mobile

Single-column stacked cards.

---

# Analytics

Track:

- Phone clicks.
- WhatsApp clicks.
- Email clicks.

Business hours themselves do not require tracking.

---

# Acceptance Criteria

The section is complete when:

- Business hours are configurable.
- Response expectations are displayed.
- Time zone is shown.
- Holiday messaging is supported.
- Responsive behaviour is verified.
- Accessibility requirements are met.

---

# Revision Policy

Future office locations or expanded support hours should be accommodated through configuration without redesigning the section.