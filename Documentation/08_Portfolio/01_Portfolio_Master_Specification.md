# SMEvolve Portfolio Specification
## Part 1 – Portfolio Master Specification

**Project Name:** SMEvolve

**Website:** https://smevolve.tech

**Version:** 1.0

**Document Type:** Portfolio Master Specification

---

# Purpose

This document defines the objectives, content strategy, page structure, design principles, implementation standards, and conversion goals for the SMEvolve Portfolio module.

The Portfolio exists to demonstrate SMEvolve's capabilities through real projects, build trust with potential clients, and encourage qualified enquiries.

This document serves as the master reference for all portfolio-related pages.

---

# Business Goal

The Portfolio should demonstrate the quality of SMEvolve's work and encourage visitors to move from interest to enquiry.

Rather than simply displaying screenshots, the Portfolio should explain the business problems addressed, the solutions delivered, and the outcomes achieved.

---

# Primary Objectives

The Portfolio should:

- Showcase completed projects.
- Demonstrate technical expertise.
- Build credibility and trust.
- Highlight different industries served.
- Explain the thinking behind each solution.
- Encourage visitors to request similar solutions.

---

# Target Audience

Primary

- SMEs
- Startups
- Entrepreneurs

Secondary

- Schools
- Hospitals
- NGOs
- Law Firms
- Logistics Companies
- Retail Businesses
- Professional Service Firms

---

# User Intent

Visitors typically want to answer questions such as:

- What kind of work has SMEvolve completed?
- Can SMEvolve build something similar for my business?
- What technologies are used?
- What industries does SMEvolve serve?
- How do I start a project?

---

# Portfolio Structure

The Portfolio module should include:

1. Portfolio Listing Page
2. Individual Project Pages
3. Case Study Layout
4. Project Categories
5. Final Call To Action

---

# Navigation

The Portfolio should be accessible from:

- Primary Navigation
- Homepage
- Services
- Footer
- Related Content

---

# Conversion Strategy

Primary Conversion

- Get a Free Quote

Secondary Conversions

- Contact Us
- Book a Consultation
- Chat on WhatsApp

Every portfolio page should encourage visitors to discuss a similar project.

---

# Design Principles

Portfolio pages should feel:

- Modern
- Professional
- Visual
- Easy to scan
- Trustworthy
- Consistent with the Homepage and About page

Use high-quality imagery and generous whitespace.

---

# Shared Components

Reuse components where possible, including:

- Hero
- Project cards
- Technology badges
- CTA banners
- Image galleries
- Related project cards
- Buttons

Avoid duplicate layouts.

---

# Accessibility

Every portfolio page must:

- Use semantic HTML.
- Support keyboard navigation.
- Include descriptive image alt text.
- Follow heading hierarchy.
- Meet WCAG AA standards where practical.

---

# SEO Goals

Every portfolio page should:

- Have a unique title.
- Have a unique meta description.
- Include descriptive headings.
- Link to related services.
- Support internal linking.
- Focus on helpful content rather than keyword repetition.

---

# Performance

Pages should:

- Lazy-load images.
- Optimize image sizes.
- Reuse Blade components.
- Minimize JavaScript.
- Target Lighthouse scores above 90 where practical.

---

# Analytics Goals

Track:

- Portfolio views
- Project detail views
- CTA clicks
- Quote requests
- Related service clicks

---

# Acceptance Criteria

The Portfolio module is complete when:

- All portfolio pages follow this specification.
- Navigation is consistent.
- Components are reusable.
- SEO requirements are met.
- Accessibility standards are satisfied.
- Conversion opportunities are present throughout.

---

# Content Source & Seeding

Portfolio content is managed from the Admin Portal (`admin/portfolio/*`) and stored in the `portfolio_projects` and `portfolio_categories` tables.

Project content resolution (`App\Data\Portfolio\PortfolioData::providers()`) is database-first:

1. If published database projects exist, they are shown.
2. Otherwise, three code providers (`App\Data\Portfolio\Projects\*`) render sample/concept projects so a fresh install is never empty.

The `Database\Seeders\PortfolioProjectSeeder` seeds the three sample providers into the database (mapped to the database schema), so the Admin Portal and the public site show exactly the same content. The samples are clearly labelled and can be edited, unpublished, or deleted from the Admin Portal at any time.

---

# Revision Policy

Future portfolio projects should follow this specification unless an approved revision is made.