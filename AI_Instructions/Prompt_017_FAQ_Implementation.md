# SMEvolve Execution Prompt
## Phase 17 – FAQ Knowledge Center Implementation

**Project:** SMEvolve

**Framework:** Laravel 12

**Frontend:** Blade, Vite, Alpine.js

---

# Objective

Implement the complete SMEvolve FAQ Knowledge Center.

The FAQ module should provide visitors with a modern, searchable, category-based knowledge system that answers common questions about SMEvolve services, pricing, development processes, support, and engagement.

The implementation must follow the existing reusable architecture and serve as the single source of truth for all FAQ sections across the website.

---

# Required Reading

Before writing any code, read:

## AI Foundation

AI_Instructions/00_AI_Constitution.md

---

## Core Documentation

Documentation/01_PRD/

Documentation/02_Information_Architecture.md

Documentation/03_Design_System/

Documentation/04_Content_Architecture/

---

## Global Systems

Documentation/13_Global_Features/

---

## FAQ Module

Documentation/11_FAQ/

Read all files:

- 01_Overview.md
- 02_Page_Hero.md
- 03_Search.md
- 04_Categories.md
- 05_FAQ_System.md
- 06_Content_Structure.md
- 07_Contact_CTA.md
- 08_SEO.md
- 09_Acceptance_Criteria.md

---

# Scope

Implement:

- FAQ route
- FAQ controller
- FAQ data structure
- FAQ search
- Category filtering
- FAQ accordion
- Contact CTAs
- Final CTA
- SEO metadata
- Structured data

Do not implement:

- Admin management
- AI chatbot
- Client portal

unless required for architecture compatibility.

---

# Architecture Requirements

The implementation must:

- Reuse existing layouts.
- Reuse existing components.
- Follow the Design System.
- Avoid duplicated FAQ logic.
- Keep FAQ content separate from presentation.

---

# Route

Create:

GET /faq

Named route:

faq.index

---

# Controller

Create or update:

FaqController

Responsibilities:

- Load FAQ data.
- Load categories.
- Apply filters.
- Prepare SEO metadata.
- Provide structured data.

Keep controller logic minimal.

Business data should remain outside the controller.

---

# FAQ Data Source

Create:

config/faqs.php

The configuration should support:

- id
- question
- answer
- category
- tags
- priority
- featured
- related pages
- status

Example structure:

```php
[
    'id' => 'pricing-001',
    'question' => '',
    'answer' => '',
    'category' => 'pricing',
    'tags' => [],
    'priority' => 1,
    'featured' => true,
    'status' => 'active'
]
```

---

# FAQ Page Sections

Implement in this order:

## 1. Hero

Reuse:

Global Hero component.

Include:

- Breadcrumb
- Heading
- Description
- Search input
- CTA buttons

---

## 2. Search System

Implement:

- Live search
- Keyword filtering
- Search suggestions
- Result count
- Clear button
- No results state

Search should work without page reload.

Use Alpine.js where appropriate.

---

## 3. Categories

Implement:

- Category filters
- Active state
- Question counts

Categories should come from configuration.

---

## 4. FAQ Accordion

Create reusable component:

components/faq/accordion.blade.php

Requirements:

- Expand/collapse animation
- One open item at a time
- Accessible controls
- Keyboard support

---

## 5. Contact CTA

Implement:

No results CTA:

"Can't find what you need?"

Buttons:

- Contact Team
- Start Quote Wizard

---

## 6. Final CTA

Reuse:

Global Final CTA component.

Load FAQ-specific content from configuration.

---

# Components

Create or reuse:

Suggested components:

```
components/
├── faq/
│   ├── accordion.blade.php
│   ├── category-filter.blade.php
│   ├── search.blade.php
│   └── result-count.blade.php
```

Do not create duplicate components.

---

# Search Implementation

Initial version:

Client-side filtering.

Requirements:

- Fast response.
- No unnecessary requests.
- Works with existing FAQ dataset.

Architecture should allow future:

- Database search.
- Laravel Scout.
- AI search.

---

# SEO Implementation

Implement:

Metadata:

- Title
- Description
- Canonical URL

Structured data:

- FAQPage
- BreadcrumbList
- WebPage

Reuse global SEO utilities.

---

# Internal Linking

FAQ answers should support links to:

- Services
- Packages
- Portfolio
- Contact
- Quote Wizard

---

# Accessibility

Verify:

- Semantic HTML
- Keyboard navigation
- Search accessibility
- Accordion ARIA states
- Focus indicators
- Screen reader support

---

# Responsive Design

Verify:

Mobile:

- Search usability
- Category scrolling
- Accordion interaction

Tablet:

- Proper spacing

Desktop:

- Comfortable reading width

---

# Performance

Prioritize:

- Minimal JavaScript.
- Optimised rendering.
- Lazy loading where required.
- Efficient filtering.

---

# Analytics Preparation

Prepare tracking for:

- FAQ searches
- Category selections
- FAQ expansions
- Contact clicks
- Quote Wizard clicks

---

# Testing

Verify:

## Functional

✓ FAQ page loads

✓ Search works

✓ Categories work

✓ Accordion works

✓ CTAs work


## Technical

✓ Routes work

✓ Configuration loads

✓ SEO metadata renders

✓ Structured data validates


## Responsive

✓ Mobile

✓ Tablet

✓ Desktop


## Accessibility

✓ Keyboard navigation

✓ Screen reader support

✓ Focus states

---

# Deliverables

After implementation provide:

## Implementation Summary

Explain what was built.

---

## Files Created

List all new files.

---

## Files Modified

List modified files.

---

## Components Created

List reusable components.

---

## Configuration Changes

List:

- FAQ configuration
- SEO configuration
- CTA configuration

---

## Testing Summary

Include:

- Functional testing
- Responsive testing
- Accessibility testing

---

## Future Recommendations

Mention possible future upgrades:

- Admin FAQ manager
- AI-powered search
- Help center articles
- User feedback system

---

# Stop Condition

Stop after completing the FAQ Knowledge Center.

Do not start:

- Legal
- Quote Wizard
- Admin
- Deployment

Those modules will be handled in future execution phases.