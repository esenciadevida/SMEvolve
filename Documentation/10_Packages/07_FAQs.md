# SMEvolve Packages Specification
## Part 7 – Pricing FAQs

**Project Name:** SMEvolve

**Website:** https://smevolve.tech

**Version:** 1.0

**Document Type:** Packages FAQ Specification

---

# Purpose

This document defines the Frequently Asked Questions (FAQ) section displayed on the SMEvolve Packages page.

The purpose of this section is to answer the most common pricing and package-related questions, helping visitors make informed decisions before requesting a quotation.

This section is a curated subset of the global FAQ system and should not duplicate the dedicated FAQ page.

---

# AI Implementation Instructions

Before implementing this section:

1. Read the Packages Overview.
2. Read the Pricing Philosophy.
3. Read the Global FAQ documentation.
4. Reuse the shared FAQ Accordion component.

Do not create a separate FAQ implementation for this page.

---

# Business Goals

The FAQ section should:

- Reduce pricing-related enquiries.
- Build confidence.
- Address common objections.
- Encourage visitors to request a quote.

---

# User Goals

Visitors should quickly understand:

- Why some services have fixed pricing.
- Why custom projects require quotations.
- Whether packages can be customised.
- What happens after requesting a quote.

---

# Layout

Desktop

Two-column layout.

Left

- Section introduction
- Link to full FAQ page

Right

- FAQ Accordion

Mobile

Single-column layout.

---

# Section Label

Suggested:

PRICING QUESTIONS

---

# Heading

Suggested:

Frequently Asked Questions About Our Packages

Alternative:

Everything You Need to Know Before Choosing a Package

---

# Supporting Text

Example:

We've answered the questions we hear most often about our packages and pricing. If you need additional guidance, our team is happy to help.

---

# Suggested Questions

## Why don't all services have fixed prices?

---

## Can I customise a website package?

---

## Which package is right for my business?

---

## Do your packages include hosting and domain registration?

---

## What happens after I request a quote?

---

## Can I upgrade my package later?

---

## Do you offer ongoing maintenance and support?

---

## How long does a typical website project take?

---

# Data Source

Package FAQs should be loaded from the shared FAQ data source.

Suggested tag:

packages

The Packages page should automatically display FAQs tagged for package and pricing topics.

---

# Accordion Behaviour

Requirements:

- One item expanded at a time.
- Smooth expand/collapse animation.
- Keyboard accessible.
- Reuse the shared accordion component.

---

# CTA

Display beneath the accordion.

Primary Button

View All FAQs

Destination:

/faq

Secondary Button

Still Have Questions?

Destination:

/contact

---

# Visual Design

The FAQ section should:

- Feel light and uncluttered.
- Match the global FAQ styling.
- Encourage scanning.
- Maintain generous spacing.

---

# Accessibility

Ensure:

- Semantic button elements.
- Keyboard navigation.
- Proper ARIA attributes.
- Visible focus states.
- WCAG AA compliance where practical.

---

# Responsive Behaviour

Desktop

Two-column layout.

Mobile

Single-column stacked layout.

Accordion interactions should remain touch-friendly.

---

# Analytics

Track:

- FAQ expansion.
- View All FAQs clicks.
- Contact CTA clicks.

---

# Acceptance Criteria

This section is complete when:

- FAQ content comes from the shared FAQ source.
- Accordion behaviour is consistent.
- Pricing-related questions are displayed.
- Responsive behaviour is verified.
- Accessibility requirements are met.

---

# Revision Policy

Future pricing questions should be added to the shared FAQ dataset and tagged appropriately, allowing this page to update automatically without changing the layout or component implementation.