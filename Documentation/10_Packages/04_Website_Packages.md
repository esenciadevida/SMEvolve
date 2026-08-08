# SMEvolve Packages Specification
## Part 4 – Website Packages

**Project Name:** SMEvolve

**Website:** https://smevolve.tech

**Version:** 1.0

**Document Type:** Website Packages Specification

---

# Purpose

This document defines the standard website packages offered by SMEvolve.

These packages provide clear, structured solutions for businesses seeking professional websites with predictable scope and pricing.

The goal is to simplify decision-making while encouraging visitors with more advanced requirements to request a custom quotation.

---

# AI Implementation Instructions

Before implementing this section:

1. Read the Packages Overview.
2. Read the Pricing Philosophy.
3. Reuse the shared Package Card component.
4. Do not hard-code package details.

Package information should be loaded from configuration or another reusable data source.

---

# Business Goals

The Website Packages section should:

- Present clear package options.
- Help visitors compare offerings.
- Encourage quote requests.
- Reduce pricing uncertainty.

---

# User Goals

Visitors should quickly understand:

- Which package fits their business.
- What each package includes.
- Which package offers the best value.
- When a custom solution is more appropriate.

---

# Section Label

Suggested:

WEBSITE PACKAGES

---

# Heading

Suggested:

Professional Websites Built for Business Growth

---

# Supporting Text

Example:

Choose from our professionally designed website packages or request a customised solution tailored to your unique business requirements.

---

# Package Layout

Display packages as responsive cards.

Desktop

Four-column grid where space permits.

Tablet

Two-column grid.

Mobile

Single-column layout.

---

# Standard Packages

Suggested packages include:

## Starter Website

Ideal For

- Individuals
- Freelancers
- Personal Brands

Include:

- Responsive Design
- Contact Form
- Basic SEO
- SSL Support
- Google Maps
- Social Links

Primary CTA

Request Quote

---

## Business Website

Ideal For

- SMEs
- Growing Businesses
- Professional Services

Include everything in Starter plus:

- Additional Pages
- Blog Ready (optional future support)
- Enhanced SEO
- Testimonials
- Gallery
- Analytics Integration

Primary CTA

Request Quote

Recommended Badge

Most Popular

---

## Professional Website

Ideal For

- Established Companies
- Organisations
- Multi-service Businesses

Additional features:

- Advanced UI/UX
- Service Catalogue
- Team Profiles
- FAQ
- Advanced Contact Options
- Performance Optimisation

Primary CTA

Request Quote

---

## E-Commerce Website

Ideal For

- Online Stores
- Retail Businesses
- Product-based Companies

Features include:

- Product Catalogue
- Shopping Cart
- Checkout
- Payment Gateway Integration
- Inventory Support
- Order Management

Primary CTA

Request Quote

---

# Package Cards

Each card should contain:

- Package Name
- Short Description
- Ideal For
- Feature List
- Optional Starting Price
- CTA Button

Support highlighting one recommended package.

---

# Feature Lists

Display concise feature summaries.

Avoid listing every technical detail.

Provide links to discuss additional requirements.

---

# Configuration

Package details should come from:

config/packages.php

Suggested fields:

- Name
- Slug
- Description
- Target Audience
- Feature List
- Starting Price
- Badge
- CTA Label

Avoid hard-coded values.

---

# Visual Design

Package cards should:

- Follow the Design System.
- Maintain equal heights.
- Include subtle hover effects.
- Clearly distinguish the recommended package.

---

# Accessibility

Cards must:

- Support keyboard navigation.
- Maintain visible focus states.
- Use semantic HTML.
- Meet WCAG AA standards where practical.

---

# Responsive Behaviour

Desktop

Grid layout.

Tablet

Two-column layout.

Mobile

Single-column stacked layout.

Cards should remain easy to compare.

---

# Analytics

Track:

- Package card clicks.
- CTA clicks.
- Recommended package interactions.

---

# Acceptance Criteria

This section is complete when:

- Packages are configurable.
- Cards are reusable.
- Recommended package is highlighted.
- Responsive behaviour is verified.
- Accessibility requirements are met.

---

# Revision Policy

Future website packages should be added through configuration without requiring layout changes.