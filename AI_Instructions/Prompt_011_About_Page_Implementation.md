# SMEvolve Execution Prompt
## Phase 11 – About Page Implementation

Project:
SMEvolve

Framework:
Laravel 12

---

# Objective

Implement the complete About page for SMEvolve.

The About page has already been fully documented.

Build the page exactly as specified.

Do not invent company history, statistics, certifications, awards, employee information, or achievements that are not documented.

---

# Required Reading

Before writing any code, read the following documents in order.

## AI Constitution

AI_Instructions/00_AI_Constitution.md

---

## Project Documentation

Documentation/01_PRD/

Documentation/02_Information_Architecture.md

Documentation/03_Design_System/

Documentation/04_Content_Architecture/

---

## About Documentation

Documentation/06_About/

- 01_About_Master_Specification.md
- 02_Hero_and_Company_Overview.md
- 03_Our_Story.md
- 04_Mission_Vision_Values.md
- 05_Why_Choose_and_Team.md
- 06_Final_CTA.md

---

# Scope

Implement only the About page.

Do not modify:

- Homepage
- Services
- Portfolio
- Blog
- Quote Wizard
- Admin
- Deployment

unless minor integration changes are required.

---

# Page Structure

Build the About page using the documented order.

1. Hero
2. Company Overview
3. Our Story
4. Mission, Vision & Values
5. Why Choose SMEvolve
6. Team / Company Philosophy
7. Final Call To Action

---

# Laravel Standards

Follow all project conventions.

Use:

- Laravel 12
- Blade Components
- Tailwind CSS v4
- Alpine.js only where lightweight interaction is needed
- Heroicons
- Inter font

---

# Component Requirements

Reuse existing components whenever possible.

Only create new reusable components if required.

Suggested components include:

```blade
<x-sections.about-hero />

<x-sections.company-overview />

<x-sections.our-story />

<x-sections.mission-values />

<x-sections.why-choose-about />

<x-sections.team />

<x-sections.about-final-cta />
```

Reusable cards may include:

```blade
<x-cards.value-card />

<x-cards.advantage-card />

<x-cards.team-card />
```

Avoid duplicated markup.

---

# Data Architecture

Do not hard-code repeated data inside Blade templates.

Create reusable data providers where appropriate.

Example:

```
app/Data/

AboutData.php

ValuesData.php

AdvantagesData.php
```

These should expose clean methods for supplying page data.

Design them so they can later be replaced with database models without changing the UI.

---

# Navigation

Ensure the About page is linked correctly from:

- Primary Navigation
- Footer
- Homepage
- Related internal links where appropriate

---

# Accessibility

Ensure:

- Semantic HTML
- Proper heading hierarchy
- Keyboard navigation
- Visible focus states
- Accessible buttons
- Meaningful alt text
- WCAG AA compliance where practical

---

# SEO

Support:

- Unique page title
- Meta description
- Canonical URL
- Open Graph tags
- Twitter Card tags
- Structured data where appropriate
- Proper heading hierarchy

Write for people first.

---

# Performance

Prioritize:

- Reusable Blade components
- Efficient rendering
- Lazy-loaded images
- Minimal JavaScript
- Responsive layouts

Target Lighthouse scores above 90 where practical.

---

# Testing

Verify:

- About page renders correctly.
- Navigation works.
- CTA buttons function.
- Mobile layout is responsive.
- Tablet layout is responsive.
- Desktop layout is responsive.
- No Blade errors exist.
- No duplicated components exist.

Run:

```bash
php artisan serve
```

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

List all reusable Blade components.

---

## Data Providers Created

List all files created inside:

```
app/Data/
```

---

## Accessibility Notes

Explain accessibility improvements.

---

## SEO Notes

Explain SEO implementation.

---

## Performance Notes

Explain performance optimizations.

---

## Future Recommendations

Recommend improvements that are outside the scope of this implementation.

---

# Stop Condition

Stop after the About page has been fully implemented.

Do not begin implementing:

- Services
- Portfolio
- Blog
- Quote Wizard
- Admin
- Deployment

Those will be implemented in later execution phases.