# SMEvolve FAQ Specification
## Part 2 – Page Hero

**Project Name:** SMEvolve

**Website:** https://smevolve.tech

**Version:** 1.0

**Document Type:** FAQ Hero Specification

---

# Purpose

This document defines the hero section of the SMEvolve FAQ page.

The hero introduces the Knowledge Center, allowing visitors to quickly search for answers, browse categories, and navigate to relevant information without unnecessary scrolling.

The hero should immediately communicate that finding answers is quick and easy.

---

# AI Implementation Instructions

Before implementing this section:

1. Read the FAQ Overview.
2. Read the Design System.
3. Read the Global Features documentation.
4. Reuse the shared Hero component.

Do not create a page-specific hero implementation.

---

# Business Goals

The hero should:

- Encourage visitors to search before contacting support.
- Reduce repetitive enquiries.
- Improve self-service.
- Increase engagement with the knowledge base.

---

# User Goals

Visitors should immediately understand:

- They can search for answers.
- FAQs are organised into categories.
- Support is available if they cannot find an answer.

---

# Layout

Desktop

Two-column layout.

Left

- Breadcrumb
- Label
- Heading
- Supporting text
- Primary CTA
- Secondary CTA

Right

- Knowledge-themed illustration
- Search preview

Mobile

Single-column layout.

---

# Small Label

KNOWLEDGE CENTER

---

# Heading

Suggested:

Find Answers to Your Questions

Alternative:

Everything You Need to Know About Working with SMEvolve

---

# Supporting Paragraph

Example:

Browse our frequently asked questions, search for answers instantly, or explore topics covering services, pricing, development, support, and more.

---

# Search Preview

The hero should prominently feature a search input.

Placeholder:

Search for answers...

Example searches:

- Website packages
- Custom software
- Payment methods
- Development timeline

The search field should encourage interaction even before users scroll.

---

# Primary CTA

Label:

Start Searching

Action:

Focus the FAQ search input.

---

# Secondary CTA

Label:

Contact Our Team

Destination:

/contact

---

# Trust Indicators

Display:

✓ Instant Search

✓ Organised Categories

✓ Regularly Updated

✓ Expert Support

---

# Hero Illustration

Illustrate:

- Knowledge
- Search
- Documentation
- Customer Support

Avoid generic customer service stock imagery.

---

# Visual Design

The hero should feel:

- Helpful
- Clean
- Modern
- Spacious

Maintain consistency with the global Hero component.

---

# Responsive Behaviour

Desktop

Text left.

Illustration and search preview right.

Mobile

Search input immediately below the heading.

Buttons stacked vertically.

---

# Accessibility

Ensure:

- Proper heading hierarchy.
- Accessible search input.
- Keyboard navigation.
- Screen-reader friendly labels.
- WCAG AA compliance where practical.

---

# SEO

The H1 should clearly describe the page.

Only one H1 should exist.

---

# Analytics

Track:

- Search input focus.
- Search submissions.
- Contact CTA clicks.

---

# Acceptance Criteria

The hero is complete when:

- Search is prominently featured.
- CTA buttons work correctly.
- Illustration reinforces the Knowledge Center.
- Responsive behaviour is verified.
- Accessibility requirements are met.

---

# Revision Policy

Future enhancements may expand the search experience while preserving the reusable Hero architecture.