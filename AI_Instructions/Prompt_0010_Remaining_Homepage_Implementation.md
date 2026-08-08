# SMEvolve Execution Prompt
## Phase 9 – Remaining Homepage Implementation

Project:
SMEvolve

Framework:
Laravel 12

---

# Objective

Implement all remaining homepage sections for SMEvolve.

The homepage specifications have already been completed.

Build each section exactly as documented.

Do not invent content or deviate from the specifications.

---

# Required Reading

Before writing any code, read the following documents in order.

## AI Constitution

AI_Instructions/00_AI_Constitution.md

---

## Project Documentation

Documentation/01_PRD.md

Documentation/02_Information_Architecture.md

Documentation/03_Design_System.md

Documentation/04_Content_Architecture/01_Brand_Messaging.md

Documentation/05_Homepage/01_Homepage_Master_Specification.md

---

## Homepage Specifications

Documentation/05_Homepage/08_Development_Process.md

Documentation/05_Homepage/09_Portfolio_Preview.md

Documentation/05_Homepage/10_FAQ.md

Documentation/05_Homepage/11_Blog_Preview.md

Documentation/05_Homepage/12_Final_CTA.md

---

# Scope

Implement only these remaining homepage sections:

1. Development Process

2. Portfolio Preview

3. FAQ

4. Blog Preview

5. Final Call To Action

Do not modify previously completed sections unless required for integration.

---

# Implementation Requirements

Follow all project standards.

Use:

- Laravel 12
- Blade Components
- Tailwind CSS v4
- Alpine.js only where lightweight interactivity is required
- Heroicons
- Inter font

---

# Component Requirements

Create reusable Blade components wherever appropriate.

Suggested components include:

```
<x-sections.development-process />

<x-sections.portfolio-preview />

<x-sections.faq />

<x-sections.blog-preview />

<x-sections.final-cta />
```

Reusable cards should also be created where appropriate.

Examples:

```
<x-cards.process-step />

<x-cards.portfolio-card />

<x-cards.blog-card />

<x-faq.accordion />
```

Avoid duplicated markup.

---

# Data Architecture

Do not hard-code repeated content inside Blade templates.

Where structured data improves maintainability, create reusable data providers inside:

```
app/Data/
```

For example:

```
ProcessData.php

PortfolioData.php

FAQData.php

BlogData.php
```

These should expose clean methods for retrieving section data.

Design them so they can later be replaced by database models without requiring changes to the Blade components.

---

# Homepage Integration

Integrate each completed section into:

```
resources/views/home.blade.php
```

Maintain the homepage order:

```
Header

Hero

Technology Stack

Services

Why Choose SMEvolve

Industries We Serve

Development Process

Portfolio Preview

FAQ

Blog Preview

Final CTA

Footer
```

---

# Accessibility

Ensure:

- Semantic HTML
- Keyboard navigation
- Correct heading hierarchy
- Visible focus states
- ARIA attributes where appropriate
- WCAG AA compliance where practical

---

# SEO

Follow the Homepage Master Specification.

Support:

- Proper heading hierarchy
- Internal links
- Descriptive anchor text
- Optimized semantic structure

Do not keyword stuff.

---

# Performance

Prioritize:

- Reusable Blade components
- Lazy-loaded images
- Minimal JavaScript
- Efficient rendering
- Clean component architecture

---

# Testing

After implementation verify:

- Homepage renders successfully.
- All components load correctly.
- Mobile layout works.
- Tablet layout works.
- Desktop layout works.
- FAQ accordion functions correctly.
- Portfolio empty state functions correctly.
- Blog empty state functions correctly.
- CTA buttons function correctly.
- No Blade errors exist.

Run:

```
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

List every reusable component.

---

## Data Providers Created

List every file inside:

```
app/Data/
```

---

## Accessibility Notes

Explain accessibility considerations.

---

## SEO Notes

Explain SEO improvements.

---

## Performance Notes

Explain performance optimizations.

---

## Future Recommendations

Recommend improvements that are outside the scope of this implementation.

---

# Stop Condition

Stop after all remaining homepage sections have been implemented.

Do not begin implementing any other website pages.

Do not begin Services pages, About page, Contact page, Blog page, Portfolio page, Quote Wizard, or any additional features.