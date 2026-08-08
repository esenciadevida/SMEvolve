# SMEvolve Packages Specification
## Part 6 – Package Comparison Table

**Project Name:** SMEvolve

**Website:** https://smevolve.tech

**Version:** 1.0

**Document Type:** Package Comparison Table Specification

---

# Purpose

This document defines the package comparison table displayed on the SMEvolve Packages page.

The comparison table provides visitors with a side-by-side overview of the standard website packages, helping them identify the most suitable option based on features, business needs, and expected outcomes.

The objective is to simplify decision-making rather than overwhelm visitors with technical details.

---

# AI Implementation Instructions

Before implementing this section:

1. Read the Packages Overview.
2. Read the Pricing Philosophy.
3. Read the Website Packages documentation.
4. Reuse shared Table and Card components where appropriate.

Do not hard-code package data.

---

# Business Goals

This section should:

- Help visitors compare packages.
- Reduce confusion.
- Encourage quote requests.
- Increase confidence in package selection.

---

# User Goals

Visitors should quickly compare:

- Target audience
- Included features
- Support level
- Suitable business size
- Expansion options

The table should answer the question:

"Which package is right for me?"

---

# Section Label

Suggested:

COMPARE PACKAGES

---

# Heading

Suggested:

Find the Package That Fits Your Business

---

# Supporting Text

Example:

Compare our standard website packages side by side. If your requirements go beyond these options, our team can prepare a customised solution.

---

# Comparison Structure

Columns:

- Starter
- Business
- Professional
- E-Commerce

Rows should represent comparison categories.

---

# Comparison Categories

Suggested rows:

## Ideal For

---

## Number of Pages

---

## Responsive Design

---

## Contact Forms

---

## Basic SEO

---

## Advanced SEO

---

## Blog Ready

---

## Image Gallery

---

## Testimonials

---

## Team Profiles

---

## Analytics Integration

---

## CMS

---

## E-Commerce Features

---

## Payment Gateway Support

---

## Performance Optimisation

---

## Security Best Practices

---

## Technical Support

---

## Maintenance Options

---

## Starting Price

Optional.

Load from configuration.

---

## Primary CTA

Each column should end with:

Request Quote

---

# Visual Indicators

Use:

✓ Included

—

Not Included

or

Optional

Avoid large blocks of text inside the table.

---

# Mobile Behaviour

Do not display a large horizontal table.

Instead:

Display comparison cards.

Each package becomes its own expandable comparison card.

Users should not need horizontal scrolling.

---

# Recommended Package

Support highlighting one package.

Example:

Most Popular

This badge should be configurable.

---

# Configuration

Load package data from:

config/packages.php

Suggested structure:

- Name
- Features
- Badge
- Target Audience
- CTA
- Price (optional)

Avoid hard-coded values.

---

# Accessibility

Ensure:

- Proper table semantics.
- Accessible comparison cards.
- Keyboard navigation.
- Visible focus states.
- WCAG AA compliance where practical.

---

# Visual Design

The comparison section should:

- Feel clean.
- Be easy to scan.
- Highlight differences.
- Match the Design System.

Avoid overly complex pricing matrices.

---

# Analytics

Track:

- Package selection.
- CTA clicks.
- Comparison interactions.

---

# Acceptance Criteria

The comparison section is complete when:

- Package data is configurable.
- Desktop and mobile layouts are optimised.
- Recommended package is highlighted.
- Accessibility requirements are met.
- Responsive behaviour is verified.

---

# Revision Policy

Future packages or comparison categories should be added through configuration without redesigning the comparison component.