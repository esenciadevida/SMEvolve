# SMEvolve Execution Prompt
## Phase 13 – Portfolio Module Implementation

**Project:** SMEvolve

**Framework:** Laravel 12

---

# Objective

Implement the complete Portfolio module for the SMEvolve website.

The Portfolio module has already been fully documented.

Build every page exactly as specified while reusing existing components wherever possible.

Do not invent projects, client names, testimonials, business metrics, statistics, or measurable outcomes.

If no real projects currently exist, create clearly labelled placeholder projects that can easily be replaced later.

---

# Required Reading

Before writing any code, read the following documentation in order.

## AI Constitution

AI_Instructions/00_AI_Constitution.md

---

## Core Project Documentation

Documentation/01_PRD/

Documentation/02_Information_Architecture.md

Documentation/03_Design_System/

Documentation/04_Content_Architecture/

---

## Homepage

Documentation/05_Homepage/

---

## About

Documentation/06_About/

---

## Services

Documentation/07_Services/

---

## Portfolio

Documentation/08_Portfolio/

- 01_Portfolio_Master_Specification.md
- 02_Portfolio_Listing_Page.md
- 03_Project_Detail_Page.md
- 04_Case_Study_Template.md
- 05_Project_Categories.md
- 06_Final_CTA.md

---

# Scope

Implement only the Portfolio module.

This includes:

- Portfolio listing page
- Individual project pages
- Project categories
- Case study layout
- Portfolio navigation
- Related project functionality
- Portfolio CTA section

Do not begin implementing:

- Blog
- Quote Wizard
- Admin
- Deployment

unless minor integration changes are required.

---

# Required Routes

Implement the following routes.

```text
/portfolio

/portfolio/{slug}

/portfolio/category/{category}
```

Use clean, SEO-friendly URLs.

---

# Required Controllers

Reuse the existing PortfolioController where practical.

Extend it with additional methods if required.

Avoid unnecessary controller duplication.

---

# Required Blade Components

Reuse existing components whenever possible.

Create reusable components where necessary.

Suggested components include:

```blade
<x-sections.portfolio-hero />

<x-sections.portfolio-introduction />

<x-sections.featured-projects />

<x-sections.project-gallery />

<x-sections.project-features />

<x-sections.project-technologies />

<x-sections.related-projects />

<x-sections.portfolio-final-cta />
```

Suggested cards:

```blade
<x-cards.project-card />

<x-cards.featured-project-card />

<x-cards.category-card />

<x-cards.technology-badge />
```

Avoid duplicate markup.

---

# Data Architecture

Do not hard-code repeated content inside Blade templates.

Create reusable data providers.

Suggested structure:

```text
app/Data/

Portfolio/

PortfolioData.php

ProjectCategories.php

Projects/

SampleProjectOne.php

SampleProjectTwo.php

SampleProjectThree.php
```

Each provider should expose structured content for:

- Hero
- Summary
- Challenge
- Solution
- Features
- Technologies
- Gallery
- Related Services
- Related Projects
- SEO Metadata

Design these providers so they can later be replaced by database models or a CMS without changing the UI.

---

# Portfolio Content

If real projects are unavailable:

Create sample projects clearly labelled as:

- Concept Project
- Demonstration Project
- Sample Project

Do not imply these were completed for real clients.

---

# Navigation

Portfolio should be accessible from:

- Homepage
- Services
- About
- Primary Navigation
- Footer
- Related Projects
- CTA sections

Maintain navigation consistency across the website.

---

# Accessibility

Every Portfolio page must:

- Use semantic HTML
- Follow heading hierarchy
- Support keyboard navigation
- Include descriptive image alt text
- Include visible focus states
- Meet WCAG AA standards where practical

Accessibility is mandatory.

---

# SEO

Every Portfolio page should support:

- Unique page title
- Meta description
- Canonical URL
- Open Graph tags
- Twitter Card tags
- Structured data where appropriate
- Internal linking
- Clean URLs

Write primarily for users, then optimize for search engines.

---

# Performance

Prioritize:

- Optimized images
- Lazy loading
- Blade component reuse
- Minimal JavaScript
- Efficient rendering

Target Lighthouse scores above 90 where practical.

---

# Responsive Behaviour

Verify layouts for:

- Mobile
- Tablet
- Laptop
- Desktop

Project galleries, cards, and navigation should adapt smoothly across all screen sizes.

---

# Testing

Verify:

- Portfolio listing page renders correctly.
- Project pages render correctly.
- Category pages function correctly.
- Related projects work.
- CTA buttons function.
- Internal links work.
- Navigation works.
- No duplicate Blade markup exists.
- No routing or rendering errors exist.

Run the application locally before completion.

---

# Deliverables

After implementation provide:

## Summary

Overall work completed.

---

## Files Created

List every new file.

---

## Files Modified

List every modified file.

---

## Components Created

List every reusable Blade component.

---

## Data Providers Created

List every file inside:

```text
app/Data/Portfolio/
```

---

## Routes Added

List all new routes.

---

## Accessibility Notes

Summarize accessibility improvements.

---

## SEO Notes

Summarize SEO implementation.

---

## Performance Notes

Summarize performance optimizations.

---

## Future Recommendations

Recommend improvements outside the scope of this implementation.

---

# Stop Condition

Stop after the complete Portfolio module has been implemented.

Do not begin implementing:

- Blog
- Quote Wizard
- Admin
- Deployment

Those modules will be implemented in future execution phases.