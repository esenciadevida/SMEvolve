# SMEvolve Global Features Specification
## Part 6 – Breadcrumb Navigation

**Project Name:** SMEvolve

**Website:** https://smevolve.tech

**Version:** 1.0

**Document Type:** Breadcrumb Navigation Specification

---

# Purpose

This document defines the structure, behaviour, accessibility, SEO requirements, and implementation standards for breadcrumb navigation across the SMEvolve website.

Breadcrumbs should help visitors understand where they are within the website hierarchy while improving internal linking and search engine understanding.

---

# AI Implementation Instructions

Before implementing breadcrumbs:

1. Read the AI Constitution.
2. Read the PRD.
3. Read the Information Architecture.
4. Read the Design System.
5. Read the Global Features Overview.
6. Follow this document exactly.

Reuse a single breadcrumb component across the entire website.

---

# Business Goals

Breadcrumbs should:

- Improve navigation.
- Increase page discoverability.
- Improve internal linking.
- Support SEO.
- Improve accessibility.

---

# User Goals

Visitors should always know:

- Where they are.
- How they arrived there.
- How to move back to higher-level pages.

Breadcrumbs should reduce navigation friction.

---

# Display Rules

Display breadcrumbs on:

- About
- Services
- Individual Service Pages
- Portfolio
- Individual Project Pages
- Blog
- Blog Categories
- Blog Articles
- Packages
- FAQ
- Contact
- Quote Wizard (except during active form steps)
- Legal Pages

Do **not** display breadcrumbs on the Homepage.

---

# Structure

Breadcrumbs should always begin with:

Home

↓

Current Section

↓

Current Page (if applicable)

---

# Examples

## About

Home

>

About

---

## Services

Home

>

Services

---

## Individual Service

Home

>

Services

>

Laravel Development

---

## Portfolio

Home

>

Portfolio

---

## Project

Home

>

Portfolio

>

Laboratory Management System

---

## Blog Article

Home

>

Blog

>

How Custom Software Improves Business Efficiency

---

## Privacy Policy

Home

>

Privacy Policy

---

# Behaviour

All breadcrumb items except the final item should be clickable.

The current page should:

- Not be clickable.
- Be visually distinguished.

---

# Visual Design

The breadcrumb should:

- Appear below the page hero.
- Use subtle typography.
- Include sufficient spacing.
- Avoid drawing attention away from page content.

Suggested separator:

>

or

/

Use one separator consistently throughout the website.

---

# Accessibility

Breadcrumbs must:

- Use a semantic `<nav>` element.
- Include `aria-label="Breadcrumb"`.
- Use an ordered list (`<ol>`).
- Support keyboard navigation.
- Maintain visible focus states.

---

# SEO

Implement structured data using:

**BreadcrumbList**

Each breadcrumb should include:

- Position
- Name
- URL

Use canonical URLs only.

---

# Responsive Behaviour

Desktop

Display the complete breadcrumb path.

Mobile

Allow wrapping to multiple lines if required.

Do not truncate important page names.

---

# Components

Create a reusable Blade component.

Suggested component:

```blade
<x-breadcrumbs />
```

The component should automatically build breadcrumb trails from route data where practical.

Avoid manually duplicating breadcrumb markup.

---

# Analytics

Track:

- Breadcrumb link clicks
- Navigation path usage (future enhancement)

---

# Acceptance Criteria

Breadcrumb implementation is complete when:

- Breadcrumbs appear on all applicable pages.
- Homepage excludes breadcrumbs.
- Structured data is implemented.
- Accessibility requirements are met.
- Responsive behaviour is verified.
- Component reuse is achieved.

---

# Revision Policy

Future pages should automatically integrate with the breadcrumb system without requiring custom implementations.