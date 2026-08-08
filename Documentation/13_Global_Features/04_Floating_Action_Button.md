# SMEvolve Global Features Specification
## Part 4 – Smart Floating Action Hub

**Project Name:** SMEvolve

**Website:** https://smevolve.tech

**Version:** 1.0

**Document Type:** Floating Action Hub Specification

---

# Purpose

This document defines the global Smart Floating Action Hub used throughout the SMEvolve website.

Unlike a traditional floating WhatsApp button, this feature acts as a centralized contact and quick-action hub that gives visitors immediate access to the website's most important actions.

It should remain lightweight, accessible, responsive, and consistent with SMEvolve's premium brand identity.

---

# AI Implementation Instructions

Before implementing this feature:

1. Read the AI Constitution.
2. Read the PRD.
3. Read the Information Architecture.
4. Read the Design System.
5. Read the Global Features Overview.
6. Follow this document exactly.

Do not introduce unnecessary animations or distracting behaviour.

---

# Business Goals

The Smart Action Hub should:

- Increase conversions.
- Reduce friction when contacting SMEvolve.
- Keep important actions available everywhere.
- Encourage quote requests.
- Improve mobile usability.

---

# User Goals

Visitors should always be able to:

- Chat on WhatsApp.
- Request a quote.
- Contact SMEvolve.
- Return to the top of the page.
- Access important actions without scrolling.

---

# Availability

Display on all public pages except:

- Quote Wizard (during completion steps)
- Privacy Policy
- Terms & Conditions

The component should remain consistent across the site.

---

# Layout

The Smart Action Hub consists of:

Primary Floating Button

↓

Expandable Action Menu

---

# Primary Button

Default state:

A circular floating button displaying the SMEvolve accent colour.

Recommended icon:

Conversation / Support icon.

The button should clearly communicate that help and contact options are available.

---

# Expansion Behaviour

Desktop

- Expand horizontally.
- Open on click.
- Close when clicking outside or pressing Escape.

Mobile

- Expand vertically upward.
- Leave enough spacing for comfortable touch interaction.
- Avoid covering browser navigation or system UI.

Only one state (expanded or collapsed) should exist at a time.

---

# Available Actions

The hub should include:

## 1. WhatsApp

Primary contact method.

Label:

Chat on WhatsApp

---

## 2. Get a Free Quote

Navigate to:

/quote

---

## 3. Contact Us

Navigate to:

/contact

---

## 4. Call SMEvolve

Use a tel: link when a phone number is available.

Hide this action if no business phone number has been configured.

---

## 5. Email SMEvolve

Use a mailto: link.

Hide if no email address has been configured.

---

## 6. Back to Top

Only display after the visitor has scrolled approximately 500px.

Selecting this action should smoothly return the visitor to the top of the page.

---

# Behaviour

The hub should:

- Remain fixed while scrolling.
- Never block important content.
- Close automatically after navigation.
- Close when clicking outside.
- Close with Escape key.
- Remember nothing between page loads.

---

# Animation

Use subtle animations only.

Examples:

- Fade
- Scale
- Slide

Duration:

200–300 ms.

Avoid bouncing, spinning, or exaggerated effects.

---

# Position

Default:

Bottom-right corner.

Maintain safe spacing from screen edges.

Avoid overlapping cookie notices or browser controls.

---

# Mobile Behaviour

Buttons should be:

- Large enough for touch.
- Clearly labelled or accompanied by tooltips where appropriate.
- Easy to reach using one hand.

Maintain adequate spacing between actions.

---

# Accessibility

The Smart Action Hub must:

- Support keyboard navigation.
- Include ARIA labels.
- Provide visible focus states.
- Announce expanded/collapsed state.
- Meet WCAG AA standards where practical.

Every action must have an accessible name.

---

# Performance

Requirements:

- Minimal JavaScript.
- Lightweight animations.
- Efficient rendering.
- No unnecessary dependencies.

Alpine.js is sufficient.

---

# Analytics

Track:

- Hub opened
- Hub closed
- WhatsApp clicks
- Quote clicks
- Contact clicks
- Phone clicks
- Email clicks
- Back to Top clicks

---

# Components

Suggested Blade components:

- Floating Action Hub
- Floating Action Button
- Floating Action Item
- Back to Top Button

Avoid duplicate implementations.

---

# Future Expansion

The architecture should allow future additions such as:

- Live Chat
- Client Portal
- Support Tickets
- Calendar Booking
- Language Switcher

New actions should be configurable without redesign.

---

# Acceptance Criteria

The Smart Action Hub is complete when:

- It appears consistently across public pages.
- Expansion behaves correctly on desktop and mobile.
- All configured actions function correctly.
- Accessibility requirements are met.
- Responsive behaviour is verified.
- Analytics events are documented.
- Performance impact is minimal.

---

# Revision Policy

Future actions may be added provided they support SMEvolve's business goals and do not compromise usability or performance.