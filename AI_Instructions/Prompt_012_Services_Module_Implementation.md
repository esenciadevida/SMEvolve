# SMEvolve Execution Prompt
## Phase 12 – Services Module Implementation

**Project:** SMEvolve

**Framework:** Laravel 12

---

# Objective

Implement the complete Services module for the SMEvolve website.

The Services module has already been fully documented.

Build every page exactly as specified while reusing components wherever possible.

Do not invent pricing, delivery timelines, guarantees, certifications, client names, testimonials, or unsupported claims.

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

- 01_Services_Master_Specification.md
- 02_Service_Page_Template.md
- 03_Website_Development.md
- 04_Ecommerce_Development.md
- 05_Custom_Software.md
- 06_Laravel_Development.md
- 07_WordPress_Development.md
- 08_Mobile_App_Development.md
- 09_AI_Solutions.md
- 10_Business_Automation.md
- 11_API_Development.md
- 12_Website_Maintenance.md

---

# Scope

Implement only the Services module.

This includes:

- Services listing page
- Individual service pages
- Navigation integration
- Internal service linking
- Shared service components

Do not begin implementing:

- Portfolio
- Blog
- Quote Wizard
- Admin
- Deployment

unless minor integration changes are required.

---

# Required Routes

Implement the following routes.

```text
/services

/services/website-development

/services/ecommerce-development

/services/custom-software

/services/laravel-development

/services/wordpress-development

/services/mobile-app-development

/services/ai-solutions

/services/business-automation

/services/api-development

/services/website-maintenance
```

Use clean, SEO-friendly URLs.

---

# Required Controllers

Reuse the existing ServicesController where practical.

Create additional methods if needed.

Avoid unnecessary controller duplication.

---

# Required Blade Components

Reuse existing Homepage components whenever appropriate.

Create reusable components for service-specific content.

Suggested components include:

```blade
<x-sections.service-hero />

<x-sections.service-overview />

<x-sections.problems-we-solve />

<x-sections.our-solution />

<x-sections.service-features />

<x-sections.service-benefits />

<x-sections.service-technologies />

<x-sections.related-services />

<x-sections.service-faq />

<x-sections.service-final-cta />
```

Reusable cards should include:

```blade
<x-cards.feature-card />

<x-cards.benefit-card />

<x-cards.related-service-card />

<x-cards.technology-card />
```

Do not duplicate markup across service pages.

---

# Data Architecture

Do not hard-code repeated data inside Blade templates.

Create reusable data providers.

Suggested structure:

```text
app/Data/

Services/

ServiceData.php

WebsiteDevelopmentData.php

EcommerceDevelopmentData.php

CustomSoftwareData.php

LaravelDevelopmentData.php

WordPressDevelopmentData.php

MobileAppDevelopmentData.php

AISolutionsData.php

BusinessAutomationData.php

APIDevelopmentData.php

WebsiteMaintenanceData.php
```

Each provider should expose structured content for:

- Hero
- Overview
- Problems
- Solution
- Features
- Benefits
- Technologies
- FAQs
- Related Services
- SEO metadata

Design the providers so they can later be replaced by database models or a CMS without changing the UI.

---

# Navigation

Ensure Services is accessible from:

- Primary Navigation
- Homepage
- Footer
- Related Services
- Internal links
- CTA buttons

Maintain consistent navigation throughout the website.

---

# Accessibility

Every page must:

- Use semantic HTML
- Follow heading hierarchy
- Support keyboard navigation
- Include visible focus states
- Include meaningful alt text
- Meet WCAG AA standards where practical

Accessibility is mandatory.

---

# SEO

Every service page must support:

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

- Blade component reuse
- Efficient rendering
- Lazy-loaded images
- Minimal JavaScript
- Optimized assets

Target Lighthouse scores above 90 where practical.

---

# Responsive Behaviour

Verify layouts for:

- Mobile
- Tablet
- Laptop
- Desktop

All cards, grids, buttons, and navigation should adapt smoothly across screen sizes.

---

# Testing

Verify:

- All service pages render correctly.
- Navigation works.
- Internal links work.
- CTA buttons function.
- Related Services links work.
- FAQ accordions function correctly.
- No duplicated Blade markup exists.
- No Blade or routing errors exist.

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
app/Data/Services/
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

Stop after the complete Services module has been implemented.

Do not begin implementing:

- Portfolio
- Blog
- Quote Wizard
- Admin
- Deployment

Those modules will be implemented in future execution phases.