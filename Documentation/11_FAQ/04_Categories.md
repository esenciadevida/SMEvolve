# SMEvolve FAQ Specification
## Part 4 – FAQ Categories

**Project Name:** SMEvolve

**Website:** https://smevolve.tech

**Version:** 1.0

**Document Type:** FAQ Categories Specification

---

# Purpose

This document defines the category navigation for the SMEvolve Knowledge Center.

Categories allow visitors to quickly browse related questions without relying solely on search. They also provide a scalable structure for organising the FAQ dataset as new content is added.

---

# AI Implementation Instructions

Before implementing this section:

1. Read the FAQ Overview.
2. Read the FAQ Search specification.
3. Read the Design System.
4. Reuse shared navigation and button components where appropriate.

Categories should be driven by configuration rather than hard-coded values.

---

# Business Goals

The category system should:

- Improve content discoverability.
- Reduce time spent searching.
- Organise FAQs logically.
- Support future expansion.

---

# User Goals

Visitors should be able to:

- Browse FAQs by topic.
- Instantly switch between categories.
- Understand what each category contains.
- Quickly locate relevant information.

---

# Section Layout

Desktop

Display categories as horizontal filter chips above the FAQ list.

Mobile

Allow chips to wrap onto multiple lines or become horizontally scrollable.

---

# Suggested Categories

The default categories are:

- All Questions
- General
- Services
- Pricing
- Development Process
- Support & Maintenance
- Technical
- Payments
- Quote Wizard
- Policies

---

# Category Cards (Optional Future Enhancement)

Future versions may display categories as cards with:

- Icon
- Category Name
- Number of Questions

Example:

💰 Pricing

12 Questions

---

# Category Behaviour

Selecting a category should:

- Filter the FAQ list instantly.
- Update the visible question count.
- Highlight the active category.
- Preserve the current search term if one exists.

No page reload should occur.

---

# Active State

The selected category should include:

- Brand accent background.
- High-contrast text.
- Visible focus state.
- Clear hover feedback.

---

# Empty Category State

If no questions exist for a category:

Display:

"No questions are currently available in this category."

Provide buttons:

- View All Questions
- Contact Our Team

---

# Configuration

Categories should be loaded from configuration.

Suggested file:

config/faqs.php

Example structure:

- id
- name
- icon
- description
- display_order

Avoid hard-coded categories.

---

# Visual Design

The category navigation should:

- Be lightweight.
- Feel interactive.
- Match the Design System.
- Scale gracefully as categories increase.

---

# Accessibility

Ensure:

- Categories are keyboard accessible.
- Active category is announced to assistive technologies.
- Visible focus indicators are provided.
- Buttons have descriptive labels.

---

# Responsive Behaviour

Desktop

Horizontal chip navigation.

Tablet

Wrapped chips.

Mobile

Wrapped or horizontally scrollable chips with touch-friendly spacing.

---

# Analytics

Track:

- Category selections.
- Most visited categories.
- Time spent within categories.

---

# Acceptance Criteria

The category system is complete when:

- Categories are configurable.
- Filtering is instant.
- Active state is visually clear.
- Empty states are handled gracefully.
- Responsive behaviour is verified.
- Accessibility requirements are met.

---

# Revision Policy

Future categories should be added through configuration without requiring layout or component changes.