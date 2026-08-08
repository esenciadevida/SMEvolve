# SMEvolve Contact Page Specification
## Part 5 – Map & Service Area

**Project Name:** SMEvolve

**Website:** https://smevolve.tech

**Version:** 1.0

**Document Type:** Map & Service Area Specification

---

# Purpose

This document defines how SMEvolve presents its business location and service coverage.

The goal is not simply to display a map, but to reassure visitors that SMEvolve serves clients both locally and remotely.

The map should support credibility while the service area should communicate flexibility and accessibility.

---

# AI Implementation Instructions

Before implementing this section:

1. Read the AI Constitution.
2. Read the Contact Overview.
3. Read the Global Features documentation.
4. Reuse existing Section and Card components.

Do not hard-code business location information.

---

# Business Goals

This section should:

- Build trust.
- Show that SMEvolve serves clients beyond a physical office.
- Help visitors locate the business if necessary.
- Support local SEO.

---

# User Goals

Visitors should quickly understand:

- Where SMEvolve is located.
- Whether SMEvolve serves their area.
- That remote collaboration is available.
- How to obtain directions.

---

# Layout

Recommended layout:

Desktop

Two-column layout.

Left

- Service Area
- Coverage Information
- Direction Button

Right

- Interactive Map

Mobile

Single-column layout.

Service Area should appear before the map.

---

# Service Area

Display a short introduction.

Example:

SMEvolve works with businesses across Nigeria and internationally.

Whether you're nearby or located anywhere in the world, we can collaborate remotely using modern communication and project management tools.

---

# Coverage

Highlight:

- Local Clients
- National Clients
- International Clients

Suggested cards:

🌍 Remote Worldwide

🇳🇬 Nigeria

🏢 On-site Consultation (where applicable)

Avoid making claims that cannot be supported operationally.

---

# Interactive Map

Support embedding:

Google Maps

or

OpenStreetMap

Display:

- Office Location
- Zoom Controls
- Directions Link

The map should load efficiently and not block page rendering.

---

# Get Directions

Provide a clear CTA:

Get Directions

This should open the preferred mapping application in a new tab.

---

# Configuration

Business location should come from configuration.

Suggested:

config/company.php

Values may include:

- Office Name
- Street Address
- City
- State
- Country
- Latitude
- Longitude
- Maps URL

Avoid hard-coded values.

---

# Local SEO

The location should support:

- Organization Schema
- LocalBusiness Schema (if applicable)
- Consistent business information

Business Name, Address, and Contact Information should remain consistent across the website.

---

# Visual Design

The section should:

- Feel spacious.
- Use modern cards.
- Include meaningful icons.
- Keep the map visually balanced with surrounding content.

Avoid oversized maps.

---

# Accessibility

The map section must:

- Provide descriptive headings.
- Include accessible links.
- Ensure embedded maps do not prevent keyboard navigation.
- Meet WCAG AA standards where practical.

---

# Performance

Lazy-load the embedded map.

Do not load third-party map resources until needed.

Prefer deferred loading where practical.

---

# Analytics

Track:

- Map interactions.
- Get Directions clicks.
- External map opens.

---

# Acceptance Criteria

The section is complete when:

- Service coverage is clearly communicated.
- Office location is displayed.
- Map loads efficiently.
- Directions work correctly.
- Configuration is used.
- Accessibility requirements are met.

---

# Revision Policy

Future office locations or additional service regions should be added through configuration without redesigning the page.