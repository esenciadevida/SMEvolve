# SMEvolve Global Features Specification
## Part 2 – Header & Navigation

**Project Name:** SMEvolve

**Website:** https://smevolve.tech

**Version:** 1.0

**Document Type:** Header & Navigation Specification

---

# Purpose

This document defines the structure, behaviour, accessibility, responsiveness, and implementation requirements for the global website header and navigation.

The header is one of the most frequently used interface elements and should remain consistent across the entire SMEvolve website.

---

# AI Implementation Instructions

Before implementing the header:

1. Read the AI Constitution.
2. Read the PRD.
3. Read the Information Architecture.
4. Read the Design System.
5. Read the Global Features Overview.
6. Reuse existing Blade components where possible.

Do not create multiple versions of the header unless explicitly required.

---

# Business Goals

The header should:

- Help visitors navigate quickly.
- Reinforce SMEvolve branding.
- Encourage quote requests.
- Keep important actions always accessible.
- Maintain consistency across every page.

---

# User Goals

Visitors should be able to:

- Reach any major page within one click.
- Understand their current location.
- Access services quickly.
- Request a quote at any time.
- Open the mobile menu easily on smaller devices.

---

# Header Structure

The header should contain the following elements from left to right.

## Left

- SMEvolve Logo

---

## Centre

Primary Navigation

- Home
- About
- Services
- Packages
- Portfolio
- Blog
- FAQ
- Contact

---

## Right

- Dark Mode Toggle
- Get a Free Quote Button
- Mobile Menu Button (mobile only)

---

# Sticky Behaviour

The header should:

- Remain fixed to the top while scrolling.
- Use a transparent background when positioned over the homepage hero.
- Transition smoothly to a solid background after scrolling.
- Add a subtle shadow once detached from the hero.

Transitions should remain subtle and performant.

---

# Navigation Behaviour

## Desktop

Navigation should remain fully visible.

Current page should be clearly highlighted.

Hover states should be consistent with the Design System.

---

## Mobile

Use a full-screen slide-in drawer.

The drawer should include:

- Logo
- Close button
- Navigation links
- Services submenu
- Get a Free Quote button
- WhatsApp shortcut

Large touch targets should be used throughout.

---

# Services Dropdown

The Services navigation item should support a dropdown.

Suggested items:

- Website Development
- E-commerce Development
- Custom Software
- Mobile App Development
- Laravel Development
- WordPress Development
- API Development
- AI Solutions
- Business Automation
- Website Maintenance

Dropdowns should support keyboard navigation and close automatically when focus leaves the menu.

---

# Active Navigation

The current page should be visually distinguished using:

- Accent colour
- Font weight
- Underline or indicator

Only one primary navigation item should appear active at a time.

---

# Search Preparation

Reserve space within the header architecture for a future search feature.

Do not implement search at this stage.

---

# CTA Button

Primary CTA:

Get a Free Quote

This button should remain visible on desktop.

On mobile it should appear inside the navigation drawer.

---

# Responsive Behaviour

### Desktop

- Full navigation
- Dropdown menus
- Quote button visible

### Tablet

- Responsive spacing
- Collapsible navigation if required

### Mobile

- Hamburger menu
- Full-screen drawer
- Sticky header
- Quote button inside drawer

---

# Accessibility

The header must:

- Use semantic `<header>` and `<nav>` elements.
- Support keyboard navigation.
- Include ARIA labels where appropriate.
- Provide visible focus states.
- Announce expanded and collapsed navigation states to assistive technologies.

---

# SEO

Navigation should:

- Use descriptive anchor text.
- Link only to canonical URLs.
- Avoid duplicate navigation links.
- Support internal linking best practices.

---

# Analytics

Track:

- Navigation link clicks
- Dropdown usage
- Mobile menu opens
- Mobile menu closes
- Quote button clicks

---

# Components

Reuse or create the following Blade components:

- Header
- Navigation Menu
- Navigation Item
- Services Dropdown
- Mobile Drawer
- Mobile Navigation Item
- Quote Button

---

# Acceptance Criteria

The header is complete when:

- Navigation is consistent across all pages.
- Sticky behaviour works correctly.
- Mobile navigation functions smoothly.
- Dropdown menus are accessible.
- Active page highlighting works.
- CTA is always accessible.
- Keyboard navigation is fully supported.

---

# Revision Policy

Future navigation items or service pages should extend this structure without requiring a redesign of the header.