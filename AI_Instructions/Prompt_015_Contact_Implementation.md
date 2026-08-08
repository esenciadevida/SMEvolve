# SMEvolve Execution Prompt
## Phase 15 – Contact Page Implementation

**Project:** SMEvolve

**Framework:** Laravel 12

**Frontend:** Blade, Vite, Alpine.js

---

# Objective

Implement the complete Contact module for the SMEvolve website.

The Contact page should provide a seamless, trustworthy, and conversion-focused experience that enables potential clients to communicate with SMEvolve through multiple channels.

The implementation should prioritize usability, accessibility, maintainability, scalability, and performance while reusing the shared architecture established throughout the project.

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

## Previously Implemented Modules

Documentation/05_Homepage/

Documentation/06_About/

Documentation/07_Services/

Documentation/08_Portfolio/

Documentation/13_Global_Features/

---

## Contact Module

Documentation/09_Contact/

- 01_Overview.md
- 02_Page_Hero.md
- 03_Contact_Information.md
- 04_Contact_Form.md
- 05_Map_and_Service_Area.md
- 06_Business_Hours.md
- 07_FAQ_Preview.md
- 08_Final_CTA.md
- 09_SEO.md
- 10_Acceptance_Criteria.md

---

# Scope

Implement only the Contact module.

This includes:

- Contact Hero
- Contact Information
- Contact Form
- Map & Service Area
- Business Hours
- FAQ Preview
- Final CTA
- Contact SEO

Do not implement:

- Packages
- FAQ Page
- Blog
- Quote Wizard
- Admin
- Deployment

unless minor integration is required.

---

# Architecture Requirements

The implementation must:

- Reuse shared Blade components.
- Reuse Global Features.
- Reuse shared layouts.
- Avoid duplicated markup.
- Keep business information configurable.

Maintain consistency with the entire SMEvolve architecture.

---

# Contact Hero

Implement:

- Breadcrumb
- Small label
- Heading
- Supporting paragraph
- Primary CTA
- Secondary CTA
- Hero illustration
- Trust indicators

Reuse the global Hero component.

---

# Contact Information

Display configurable:

- Phone Number
- Email Address
- WhatsApp
- Office Address
- Business Hours
- Social Links

Implement responsive contact cards.

Every contact action should function correctly.

---

# Contact Form

Implement:

- Laravel Form Request validation
- Shared form components
- Server-side validation
- Friendly validation messages
- Success confirmation
- Loading state
- Spam protection
- CSRF protection
- Honeypot field
- Rate limiting preparation

Prepare architecture for future CRM integration.

---

# Map & Service Area

Implement:

- Service Area section
- Configurable office location
- Lazy-loaded map
- Get Directions button

Business location should come from configuration.

---

# Business Hours

Implement configurable:

- Working days
- Opening hours
- Time zone
- Response expectations
- Holiday notice

Support a dynamic "Currently Open / Currently Closed" status based on the configured schedule.

---

# FAQ Preview

Reuse the shared FAQ Accordion component.

Display:

- 4–6 contact-related FAQs
- View All FAQ button

Do not duplicate FAQ data.

Prepare for future dynamic filtering by FAQ category or tag.

---

# Final CTA

Reuse the shared Final CTA component.

Display:

- Heading
- Supporting text
- Quote CTA
- WhatsApp CTA

Do not create page-specific CTA components.

---

# SEO

Implement:

- Unique metadata
- Canonical URL
- Open Graph
- Twitter Cards
- ContactPage structured data
- Breadcrumb schema

Reuse the shared SEO infrastructure.

---

# Configuration

Business information should come from configuration.

Suggested files:

config/company.php

config/social_links.php

config/seo.php

Avoid hard-coded values.

---

# Blade Components

Reuse or create components where necessary.

Examples include:

components/sections/contact-information

components/forms/contact-form

components/cards/contact-card

components/business-hours

components/map

components/faq-preview

components/final-cta

Reuse existing buttons, alerts, breadcrumbs, and layout components.

---

# Controllers

Implement or update:

ContactController

Responsibilities include:

- Display Contact page.
- Handle Contact Form submission.
- Return validation errors.
- Display success state.
- Prepare for future email notifications.

Keep controllers thin by using Form Requests and service classes where appropriate.

---

# Routing

Verify routes:

GET /contact

POST /contact

Use named routes.

---

# Validation

Create a dedicated Laravel Form Request.

Validate:

- Name
- Email
- Subject
- Preferred Contact Method
- Message
- Privacy Consent

Return friendly validation messages.

---

# Security

Implement:

- CSRF protection
- Server-side validation
- Escaped output
- Sanitised input
- Honeypot protection
- Rate limiting

Never trust client-side validation alone.

---

# Accessibility

Verify:

- Semantic HTML
- Keyboard navigation
- Form labels
- ARIA attributes where appropriate
- Focus indicators
- Accessible accordion
- Accessible buttons

Aim for WCAG AA compliance.

---

# Responsive Behaviour

Verify:

- Mobile
- Tablet
- Laptop
- Desktop

Ensure:

- Contact cards stack correctly.
- Form remains usable.
- CTA buttons remain accessible.
- Map behaves correctly.

---

# Performance

Prioritize:

- Lazy-loaded map
- Optimized images
- Minimal JavaScript
- Efficient Blade rendering
- Component reuse

Target Lighthouse scores above 90 where practical.

---

# Analytics

Prepare event tracking for:

- Contact form started
- Contact form submitted
- Validation failures
- Phone clicks
- Email clicks
- WhatsApp clicks
- Directions clicks
- CTA clicks

Do not integrate third-party analytics yet.

Prepare the architecture only.

---

# Testing

Verify:

- Contact page loads correctly.
- Contact information is displayed.
- Form validation works.
- Form submission works.
- Success message appears.
- Responsive layouts function.
- Accessibility requirements are satisfied.
- SEO metadata is generated.
- Structured data is valid.

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

List every reusable Blade component.

---

## Controllers

List all controller changes.

---

## Form Requests

List every Form Request created.

---

## Configuration Files

List configuration updates.

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

Stop after the complete Contact module has been implemented.

Do not begin implementing:

- Packages
- FAQ
- Blog
- Quote Wizard
- Admin
- Deployment

Those modules will be implemented in future execution phases.