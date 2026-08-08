# SMEvolve Contact Page Specification
## Part 7 – FAQ Preview

**Project Name:** SMEvolve

**Website:** https://smevolve.tech

**Version:** 1.0

**Document Type:** FAQ Preview Specification

---

# Purpose

This document defines the FAQ Preview section displayed on the Contact page.

The goal is to answer the most common pre-contact questions, reduce uncertainty, and encourage visitors to proceed with confidence.

This section is a preview only and should link to the dedicated FAQ page for additional information.

---

# AI Implementation Instructions

Before implementing this section:

1. Read the AI Constitution.
2. Read the Contact Overview.
3. Read the FAQ documentation (when available).
4. Reuse the global FAQ Accordion component.

Do not duplicate FAQ logic or maintain separate FAQ content for this page.

---

# Business Goals

This section should:

- Reduce repetitive enquiries.
- Build confidence.
- Improve user experience.
- Encourage visitors to complete the contact process.

---

# User Goals

Visitors should quickly find answers to common questions before reaching out.

The preview should reassure them without overwhelming them.

---

# Layout

Recommended layout:

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

FREQUENTLY ASKED QUESTIONS

---

# Heading

Suggested:

Have Questions Before Contacting Us?

Alternative:

Answers to Common Questions

---

# Supporting Text

Example:

We've answered some of the questions we receive most often. If you don't find what you're looking for, feel free to contact us directly.

---

# Number of Questions

Display:

4–6 FAQs

Avoid displaying the entire FAQ database.

---

# Suggested Questions

## How quickly will I receive a response?

---

## Do you work with clients outside Nigeria?

---

## Can I request a free consultation?

---

## What information should I prepare before contacting you?

---

## Do you provide ongoing support after project completion?

---

## Which communication method is fastest?

These should come from the main FAQ data source.

---

# Accordion Behaviour

Requirements:

- One question open at a time.
- Smooth expand/collapse animation.
- Keyboard accessible.
- Preserve accessibility standards.

Reuse the global accordion component.

---

# CTA

Display beneath the FAQ list.

Button:

View All FAQs

Destination:

/faq

---

# Visual Design

The section should:

- Feel light and uncluttered.
- Encourage scanning.
- Use generous spacing.
- Match the global FAQ styling.

---

# Accessibility

The accordion must:

- Support keyboard navigation.
- Use semantic button elements.
- Expose expanded/collapsed state.
- Meet WCAG AA standards where practical.

---

# Responsive Behaviour

Desktop

Two-column layout.

Mobile

Single-column layout.

Accordion should remain easy to interact with on touch devices.

---

# Analytics

Track:

- FAQ expansion.
- FAQ link clicks.
- View All FAQ clicks.

---

# Acceptance Criteria

This section is complete when:

- FAQ content is sourced from the shared FAQ system.
- Accordion behaviour is consistent.
- Accessibility requirements are met.
- Responsive behaviour is verified.
- Navigation to the full FAQ page is provided.

---

# Revision Policy

The Contact page should always display a curated subset of the global FAQ content without maintaining a separate FAQ dataset.