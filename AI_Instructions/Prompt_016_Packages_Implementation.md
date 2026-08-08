# SMEvolve Execution Prompt
## Phase 16 – Packages Page Implementation

**Project:** SMEvolve

**Framework:** Laravel 12

**Frontend:** Blade, Vite, Alpine.js

---

# Objective

Implement the complete Packages module for the SMEvolve website.

The Packages page should help prospective clients understand SMEvolve's service offerings, pricing philosophy, and engagement models. It should present website packages, explain custom solutions, and guide visitors toward requesting a tailored quote.

The implementation must follow the reusable architecture established throughout the project.

---

# Required Reading

Before writing any code, read the following documentation in order.

## AI Constitution

AI_Instructions/00_AI_Constitution.md

---

## Core Documentation

Documentation/01_PRD/

Documentation/02_Information_Architecture.md

Documentation/03_Design_System/

Documentation/04_Content_Architecture/

---

## Previously Implemented Modules

Documentation/05_Homepage/

Documentation/06_About/

Documentation/07_Services/

Documentation/08_Portfolio/

Documentation/09_Contact/

Documentation/13_Global_Features/

---

## Packages Module

Documentation/10_Packages/

- 01_Overview.md
- 02_Page_Hero.md
- 03_Pricing_Philosophy.md
- 04_Website_Packages.md
- 05_Custom_Solutions.md
- 06_Comparison_Table.md
- 07_FAQs.md
- 08_Final_CTA.md
- 09_SEO.md
- 10_Acceptance_Criteria.md

---

# Scope

Implement only the Packages module.

This includes:

- Hero
- Pricing Philosophy
- Website Packages
- Custom Solutions
- Comparison Table
- Pricing FAQs
- Final CTA
- SEO

Do not implement:

- FAQ Page
- Quote Wizard
- Admin
- Deployment

unless minor integration is required.

---

# Architecture Requirements

The implementation must:

- Reuse existing Blade components.
- Reuse Global Features.
- Reuse shared layouts.
- Avoid duplicated markup.
- Keep package data configurable.

Maintain consistency with the SMEvolve architecture.

---

# Hero

Reuse the global Hero component.

Include:

- Breadcrumb
- Label
- Heading
- Supporting text
- Primary CTA
- Secondary CTA
- Hero illustration
- Trust indicators

---

# Pricing Philosophy

Implement:

- Standard Packages card
- Custom Solutions card
- Pricing explanation
- Factors affecting pricing
- Quote Wizard recommendation
- Trust indicators

Reuse shared Section and Card components.

---

# Website Packages

Display configurable package cards.

Each package should include:

- Name
- Description
- Target audience
- Feature summary
- Optional starting price
- Badge
- CTA

Load package data from configuration.

---

# Custom Solutions

Display configurable service cards.

Include:

- Custom Software
- AI Solutions
- Business Automation
- Mobile Applications
- API Integrations
- Enterprise Platforms

Include the four-step discovery process.

Promote the Quote Wizard.

---

# Comparison Table

Implement:

- Responsive comparison table
- Mobile comparison cards
- Configurable feature matrix
- Highlight recommended package

Do not hard-code comparison data.

---

# Pricing FAQs

Reuse the shared FAQ Accordion.

Load FAQs by category/tag:

packages

Display:

- 6 package-related FAQs
- View All FAQs button
- Contact CTA

---

# Final CTA

Reuse the global Final CTA component.

Load Packages-specific content from configuration.

Primary CTA:

Start Quote Wizard

Secondary CTA:

Talk to an Expert

---

# Configuration

Load package information from configuration.

Suggested files:

config/packages.php

config/cta.php

config/faqs.php

Avoid hard-coded business information.

---

# Blade Components

Reuse existing components where possible.

Suggested reusable components:

- package-card
- pricing-card
- comparison-table
- comparison-card
- service-card
- faq-accordion
- final-cta

Avoid page-specific implementations unless necessary.

---

# Controller

Implement or update:

PackagesController

Responsibilities:

- Display packages.
- Load configuration.
- Load FAQs.
- Prepare SEO metadata.

Keep the controller thin.

---

# Routing

Verify:

GET /packages

Use named routes.

---

# Accessibility

Verify:

- Semantic HTML
- Keyboard navigation
- Accessible comparison table
- Accessible accordion
- Focus indicators
- WCAG AA compliance where practical

---

# Responsive Behaviour

Verify:

- Mobile
- Tablet
- Laptop
- Desktop

Ensure comparison tables adapt correctly.

---

# Performance

Prioritize:

- Lazy loading
- Optimized assets
- Efficient Blade rendering
- Component reuse
- Minimal JavaScript

---

# SEO

Implement:

- Unique metadata
- Canonical URL
- Open Graph
- Twitter Cards
- Breadcrumb schema
- Service schema
- Offer schema (where applicable)

Reuse the global SEO infrastructure.

---

# Analytics

Prepare event tracking for:

- Package selection
- Comparison interactions
- Quote Wizard clicks
- Contact clicks
- CTA clicks

Prepare the architecture only.

---

# Testing

Verify:

- Packages page loads correctly.
- Package cards render correctly.
- Comparison table functions.
- FAQ accordion works.
- Responsive layouts work.
- Accessibility requirements are satisfied.
- SEO metadata is generated.

Run the application locally before completion.

---

# Deliverables

After implementation provide:

## Summary

Overall implementation summary.

---

## Files Created

List every new file.

---

## Files Modified

List every modified file.

---

## Blade Components Created

List reusable components.

---

## Controllers

List controller changes.

---

## Configuration Files

List configuration changes.

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

Stop after the complete Packages module has been implemented.

Do not begin implementing:

- FAQ
- Quote Wizard
- Admin
- Deployment

Those modules will be implemented in future execution phases.