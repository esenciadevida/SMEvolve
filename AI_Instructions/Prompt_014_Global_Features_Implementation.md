# SMEvolve Execution Prompt
## Phase 14 – Global Features Implementation

**Project:** SMEvolve

**Framework:** Laravel 12

---

# Objective

Implement the complete Global Features module for the SMEvolve website.

This module defines the shared functionality used across the entire public website. These features should be implemented as reusable, maintainable components that integrate seamlessly with existing pages.

The implementation should prioritize consistency, accessibility, performance, maintainability, and scalability.

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

## Public Website Modules

Documentation/05_Homepage/

Documentation/06_About/

Documentation/07_Services/

Documentation/08_Portfolio/

---

## Global Features

Documentation/13_Global_Features/

- 01_Global_Features_Overview.md
- 02_Header_Navigation.md
- 03_Footer.md
- 04_Floating_Action_Button.md
- 05_Forms_and_Validation.md
- 06_Breadcrumbs.md
- 07_Search_Preparation.md
- 08_404_Page.md
- 09_Success_and_Error_States.md
- 10_Global_SEO_Features.md

---

# Scope

Implement only the Global Features module.

This includes:

- Header & Navigation
- Footer
- Smart Floating Action Hub
- Shared Form Components
- Shared Validation Components
- Breadcrumb System
- 404 Page
- Shared Success, Error & Empty States
- Global SEO Infrastructure

Do not implement:

- Blog
- Quote Wizard
- Admin Panel
- Deployment

unless minor integration changes are required.

---

# Architecture Requirements

Every global feature must be:

- Reusable
- Configurable
- Accessible
- Responsive
- Maintainable

Avoid duplicated layouts, components, JavaScript, or Blade markup.

---

# Header & Navigation

Implement:

- Sticky header
- Transparent hero behaviour
- Scroll transition
- Desktop navigation
- Mobile navigation drawer
- Services dropdown
- Active navigation highlighting
- Dark mode toggle
- Quote CTA

Navigation should be reusable across the website.

---

# Footer

Implement:

- Multi-column footer
- Company information
- Services
- Company links
- Resources
- Contact information
- Social links
- Back to Top button

Use a single reusable footer component.

---

# Smart Floating Action Hub

Implement the Smart Floating Action Hub.

Actions include:

- WhatsApp
- Get a Free Quote
- Contact
- Phone (when configured)
- Email (when configured)
- Back to Top

The hub should:

- Expand horizontally on desktop.
- Expand vertically on mobile.
- Support keyboard navigation.
- Close automatically after interaction.
- Be configurable through a configuration file.

Suggested configuration:

config/floating_actions.php

Avoid hard-coded action lists.

---

# Shared Form Components

Create reusable components for:

- Text Input
- Textarea
- Select
- Checkbox
- Radio Button
- File Upload
- Submit Button
- Validation Messages
- Success Alerts
- Error Alerts

All future forms should reuse these components.

---

# Breadcrumb System

Create a reusable breadcrumb component.

Suggested component:

```blade
<x-breadcrumbs />
```

The breadcrumb system should:

- Support automatic generation where practical.
- Implement BreadcrumbList structured data.
- Exclude the Homepage.
- Follow the documented page hierarchy.

Avoid manually building breadcrumbs for each page.

---

# Search Preparation

Do not implement search.

Prepare only the architecture.

Reserve space in the header for a future search trigger.

---

# 404 Page

Implement:

- Custom layout
- Helpful messaging
- Recovery navigation
- Homepage CTA
- Services CTA

Ensure the correct HTTP 404 status is returned.

Reuse existing layout components.

---

# Success & Error States

Create reusable UI components for:

- Success
- Error
- Warning
- Information
- Empty State
- Loading State
- Skeleton Loader

These components should be reusable across the entire website.

---

# Global SEO Infrastructure

Create reusable SEO support for:

- Meta Title
- Meta Description
- Canonical URL
- Open Graph
- Twitter Cards
- Structured Data
- Breadcrumb Schema

Do not duplicate metadata generation inside Blade templates.

---

# Configuration

Where appropriate, create configuration files for global features.

Suggested examples:

config/navigation.php

config/footer.php

config/floating_actions.php

config/social_links.php

config/seo.php

Avoid hard-coded global content.

---

# Blade Components

Reuse existing components where possible.

Create new reusable components where necessary.

Suggested components include:

layouts/header

layouts/footer

navigation/menu

navigation/mobile-menu

navigation/dropdown

floating/action-hub

floating/action-item

alerts/success

alerts/error

alerts/warning

alerts/info

states/empty

states/loading

states/skeleton

breadcrumbs

seo/meta

seo/schema

Do not duplicate markup.

---

# Alpine.js

Use Alpine.js only where appropriate.

Suitable examples:

- Mobile navigation
- Dropdown menus
- Floating Action Hub
- Dark mode toggle

Avoid complex application state.

---

# Accessibility

Verify:

- Semantic HTML
- Keyboard navigation
- Visible focus indicators
- ARIA attributes
- Accessible menus
- Accessible alerts
- Accessible floating actions

Meet WCAG AA where practical.

---

# Responsive Behaviour

Verify functionality across:

- Mobile
- Tablet
- Laptop
- Desktop

Ensure:

- Navigation adapts correctly.
- Footer stacks appropriately.
- Floating Action Hub behaves correctly.
- Forms remain usable.

---

# Performance

Prioritize:

- Minimal JavaScript
- Lazy loading
- Blade component reuse
- Optimized rendering
- Efficient asset loading

Maintain Lighthouse scores above 90 where practical.

---

# Analytics

Prepare event tracking for:

- Navigation clicks
- CTA clicks
- Floating Action Hub interactions
- Form submissions
- Breadcrumb clicks
- 404 visits

Do not integrate third-party analytics yet.

Prepare the architecture only.

---

# Testing

Verify:

- Header works correctly.
- Navigation works correctly.
- Mobile drawer functions.
- Footer renders correctly.
- Floating Action Hub functions.
- Breadcrumbs render correctly.
- Alerts display correctly.
- 404 page returns the correct status.
- Responsive layouts work correctly.
- Accessibility requirements are met.

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

## Configuration Files

List every configuration file created.

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

Stop after the complete Global Features module has been implemented.

Do not begin implementing:

- Contact
- Packages
- FAQ
- Legal
- Blog
- Quote Wizard
- Admin
- Deployment

Those modules will be implemented in future execution phases.