# SMEvolve Execution Prompt
## Phase 18 – Legal Module Implementation

**Project:** SMEvolve

**Framework:** Laravel 12

**Frontend:** Blade, Vite, Alpine.js

---

# Objective

Implement the complete SMEvolve Legal module.

The legal system should provide professional, accessible, and scalable legal pages covering privacy, terms, and cookies.

The implementation must use a shared architecture so future legal documents can be added without creating duplicate page structures.

---

# Required Reading

Before implementation, read:

## AI Foundation

AI_Instructions/00_AI_Constitution.md

---

## Core Documentation

Documentation/01_PRD/

Documentation/02_Information_Architecture.md

Documentation/03_Design_System/

Documentation/04_Content_Architecture/

---

## Global Features

Documentation/13_Global_Features/

---

## Legal Module

Documentation/12_Legal/

Read:

- 01_Overview.md
- 02_Privacy_Policy.md
- 03_Terms_Conditions.md
- 04_Cookie_Policy.md
- 05_Legal_SEO.md
- 06_Acceptance_Criteria.md

---

# Scope

Implement:

- Legal page architecture
- Privacy Policy page
- Terms & Conditions page
- Cookie Policy page
- Shared legal layout
- SEO metadata
- Breadcrumb navigation

Do not implement:

- Legal admin management
- CMS editing
- Contract generation

unless required for future compatibility.

---

# Architecture Requirements

The implementation must:

- Reuse global layouts.
- Reuse components.
- Separate content from presentation.
- Avoid duplicate templates.

---

# Routes

Create:

```
/privacy-policy

/terms

/cookies
```

Named routes:

```
privacy-policy.index

terms.index

cookies.index
```

---

# Controller

Create:

LegalController

Responsibilities:

- Load legal documents.
- Select requested document.
- Prepare metadata.
- Generate breadcrumbs.

Keep controller lightweight.

---

# Legal Data Structure

Create configurable legal content.

Suggested:

config/legal.php

Support:

```
title

slug

content

version

effective_date

updated_date

status
```

---

# Shared Components

Create or reuse:

```
components/
└── legal/
    ├── hero.blade.php
    ├── content.blade.php
    ├── metadata.blade.php
```

---

# Legal Layout

Every legal page should contain:

1. Breadcrumb

2. Hero

3. Last Updated Date

4. Legal Content

5. Contact Section

6. Final CTA

7. Footer

---

# Privacy Policy

Implement sections:

- Introduction
- Information Collection
- Data Usage
- Quote Wizard Data
- Contact Form Data
- Cookies
- Third Parties
- Security
- User Rights
- Retention
- Updates

---

# Terms & Conditions

Implement sections:

- Website Usage
- Services
- Quotations
- Agreements
- Payments
- Delivery
- Client Responsibilities
- Intellectual Property
- Third Parties
- Liability
- Updates

---

# Cookie Policy

Implement sections:

- Cookie Explanation
- Cookie Purpose
- Cookie Categories
- Third Parties
- Cookie Management
- Duration
- Updates

---

# SEO Implementation

Each legal page must support:

Metadata:

- Title
- Description
- Canonical URL

Structured Data:

- WebPage Schema
- BreadcrumbList Schema

Reuse global SEO services.

---

# Navigation

Ensure legal pages appear in:

Footer:

- Privacy Policy
- Terms
- Cookies

---

# Accessibility

Verify:

- Semantic HTML.
- Correct headings.
- Readable typography.
- Keyboard navigation.
- Screen-reader compatibility.
- Accessible links.

---

# Responsive Design

Test:

Mobile

Tablet

Desktop

Legal text should maintain readable width.

---

# Performance

Prioritize:

- Minimal JavaScript.
- Fast rendering.
- Optimized assets.
- Lightweight pages.

---

# Security

Ensure:

- Legal content is escaped safely.
- No unsafe HTML rendering.
- Future CMS content can be sanitized.

---

# Testing

Verify:

## Functional

✓ All routes load.

✓ All legal documents display.

✓ Footer links work.

✓ Breadcrumbs work.


## SEO

✓ Metadata exists.

✓ Structured data validates.

✓ Canonical URLs work.


## Accessibility

✓ Keyboard navigation.

✓ Focus states.

✓ Heading structure.


## Responsive

✓ Mobile.

✓ Tablet.

✓ Desktop.

---

# Deliverables

After implementation provide:

## Summary

Explain what was implemented.

---

## Files Created

List all new files.

---

## Files Modified

List modified files.

---

## Components Created

List reusable legal components.

---

## Configuration Changes

List:

- Legal configuration
- SEO changes

---

## Testing Results

Provide:

- Functional results
- Accessibility results
- Responsive results

---

## Future Recommendations

Mention possible upgrades:

- Legal CMS
- Document version history
- Client agreements
- AI policy
- Subscription terms

---

# Stop Condition

Stop after completing the Legal module.

Do not begin:

- Quote Wizard
- Admin
- Deployment

Those modules will be handled separately.