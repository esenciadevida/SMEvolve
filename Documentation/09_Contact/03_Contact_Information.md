# SMEvolve Contact Page Specification
## Part 3 – Contact Information

**Project Name:** SMEvolve

**Website:** https://smevolve.tech

**Version:** 1.0

**Document Type:** Contact Information Specification

---

# Purpose

This document defines how SMEvolve's contact information should be presented on the Contact page.

Rather than displaying plain contact details, this section should make every communication option easy to understand, accessible, and actionable.

Visitors should immediately know how to reach SMEvolve using their preferred communication method.

---

# AI Implementation Instructions

Before implementing this section:

1. Read the AI Constitution.
2. Read the Contact Overview.
3. Read the Global Features documentation.
4. Reuse existing Card and Section components.

Avoid hard-coding business information inside Blade templates.

Business information should be configurable.

---

# Business Goals

This section should:

- Increase communication.
- Build confidence.
- Make contact effortless.
- Support multiple communication channels.

---

# User Goals

Visitors should quickly find:

- Phone Number
- Email Address
- WhatsApp
- Office Address
- Business Hours
- Social Media

Every item should be immediately actionable where applicable.

---

# Layout

Display the information using responsive contact cards.

Recommended layout:

Desktop

2 × 3 Grid

Mobile

Single Column

Cards should maintain equal height where practical.

---

# Contact Methods

## Phone

Display:

- Business phone number
- Click-to-call link
- Availability

Example:

Monday – Friday

9:00 AM – 6:00 PM

---

## Email

Display:

Business email address

Use:

mailto:

Example response expectation:

Replies within one business day.

---

## WhatsApp

Display:

Primary WhatsApp number

Include:

Chat on WhatsApp button

Explain:

Fastest way to reach SMEvolve.

---

## Office Location

Display:

Office Address

Include:

View on Google Maps

Do not embed a map in this section.

The interactive map belongs to the next section.

---

## Business Hours

Display:

Working Days

Opening Time

Closing Time

Holiday notice if applicable.

---

## Social Media

Display only active business profiles.

Supported platforms:

- LinkedIn
- Facebook
- Instagram
- X (Twitter)

Hide platforms that have not been configured.

---

# Contact Card Design

Every card should contain:

- Icon
- Title
- Primary Information
- Supporting Information
- Action Button (where applicable)

Examples:

Call Now

Send Email

Open WhatsApp

Get Directions

---

# Configuration

Business information should come from configuration.

Suggested file:

config/company.php

Example values:

- Company Name
- Phone
- WhatsApp
- Email
- Address
- Business Hours
- Google Maps URL
- Social Links

Avoid hard-coded values.

---

# Trust Indicators

Below the contact cards, display a short reassurance section.

Examples:

✓ Friendly support

✓ Fast response times

✓ No obligation consultation

✓ Secure communication

---

# Visual Design

Cards should:

- Match the Design System.
- Use subtle hover effects.
- Maintain consistent spacing.
- Include meaningful icons.

Avoid visual clutter.

---

# Accessibility

Every card must:

- Support keyboard navigation.
- Include descriptive ARIA labels.
- Maintain visible focus states.
- Meet WCAG AA standards where practical.

---

# Responsive Behaviour

Desktop

Multi-column layout.

Tablet

Two-column layout.

Mobile

Single-column stacked layout.

Action buttons should remain easy to tap.

---

# Analytics

Track:

- Phone clicks.
- Email clicks.
- WhatsApp clicks.
- Google Maps clicks.
- Social profile clicks.

---

# Acceptance Criteria

This section is complete when:

- All configured contact methods are displayed.
- Contact information is configurable.
- Cards are reusable.
- Responsive behaviour is verified.
- Accessibility standards are met.
- Analytics events are documented.

---

# Revision Policy

Future communication channels should be added by updating configuration rather than redesigning the layout.