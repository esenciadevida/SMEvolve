# SMEvolve Packages Specification
## Part 8 – Final Call To Action

**Project Name:** SMEvolve

**Website:** https://smevolve.tech

**Version:** 1.0

**Document Type:** Packages Final CTA Specification

---

# Purpose

This document defines the Final Call To Action (CTA) for the SMEvolve Packages page.

After reviewing available packages and custom solutions, visitors should be encouraged to take the next step by requesting a tailored quote or speaking with the SMEvolve team.

This section reuses the global Final CTA component while providing Packages-specific messaging.

---

# AI Implementation Instructions

Before implementing this section:

1. Read the AI Constitution.
2. Read the Packages Overview.
3. Read the Global Features documentation.
4. Reuse the shared Final CTA component.

Do not create a page-specific CTA implementation.

---

# Business Goals

The CTA should:

- Increase quote requests.
- Encourage consultations.
- Convert interested visitors into qualified leads.
- Reinforce SMEvolve's consultative approach.

---

# User Goals

Visitors should leave the page knowing:

- They don't need to choose the perfect package alone.
- SMEvolve will help recommend the best solution.
- Getting started is quick and straightforward.

---

# CTA Configuration

The following content should be configurable.

---

## Small Label

READY TO BUILD?

---

## Heading

Recommended:

Let's Find the Right Solution for Your Business

Alternative options:

- Ready to Start Your Next Project?
- Your Ideal Digital Solution Starts Here
- Let's Build Something That Grows With Your Business

---

## Supporting Text

Example:

Whether you've found the right package or need a fully customised solution, we're ready to help. Tell us about your project and we'll recommend the best approach for your business and budget.

---

## Primary CTA

Label:

Start Quote Wizard

Destination:

/quote

This should be the primary conversion action.

---

## Secondary CTA

Label:

Talk to an Expert

Destination:

/contact

---

# Optional Trust Indicators

Display concise reassurance such as:

✓ Free initial consultation

✓ Tailored recommendations

✓ Transparent project planning

✓ Scalable solutions

---

# Visual Design

The CTA should:

- Match the global Final CTA component.
- Use the SMEvolve brand colours.
- Include generous spacing.
- Clearly highlight the primary action.

Avoid excessive animations.

---

# Responsive Behaviour

Desktop

Centered content with horizontally aligned buttons where space permits.

Mobile

Buttons stack vertically with full-width tap targets.

---

# Accessibility

Ensure:

- Proper heading hierarchy.
- Descriptive button labels.
- Keyboard accessibility.
- Visible focus indicators.
- WCAG AA compliance where practical.

---

# Configuration

CTA content should be loaded from:

config/cta.php

Suggested structure:

packages =>

- label
- heading
- description
- primary_button
- secondary_button
- trust_indicators

Avoid hard-coded CTA content.

---

# Analytics

Track:

- Quote Wizard CTA clicks.
- Contact CTA clicks.
- CTA impressions (optional future enhancement).

---

# Acceptance Criteria

This section is complete when:

- The global CTA component is reused.
- Packages-specific messaging is configured.
- Buttons function correctly.
- Responsive behaviour is verified.
- Accessibility requirements are met.
- Analytics events are identified.

---

# Revision Policy

Future campaigns may customise CTA messaging through configuration without modifying the reusable Final CTA component.