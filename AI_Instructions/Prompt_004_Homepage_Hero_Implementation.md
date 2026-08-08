# SMEvolve Execution Prompt
## Phase 4 - Homepage Hero Section Implementation

Project:
SMEvolve

Framework:
Laravel 12

---

# First Instruction

Before writing code, read:

AI_Instructions/00_AI_Constitution.md


Then read:

Documentation/01_PRD.md

Documentation/02_Information_Architecture.md

Documentation/03_Design_System.md

Documentation/04_Content_Architecture/01_Brand_Messaging.md

Documentation/05_Homepage/01_Homepage_Master_Specification.md

Documentation/05_Homepage/03_Hero_Section.md


Follow all instructions from these documents.

---

# Objective

Implement the SMEvolve Homepage Hero Section.

This is the first homepage section after the global Header.

The implementation must match the documented:

- Brand messaging
- Design system
- Content structure
- SEO requirements
- Accessibility requirements

---

# Location

The Hero Section belongs on:

```
resources/views/home.blade.php
```

Create it as a reusable Blade component.

---

# Component Creation

Create:

```
resources/views/components/sections/hero.blade.php
```

The component should be reusable and configurable.

---

# Hero Structure

The section should contain:

```
Hero Section

    Heading

    Supporting Description

    CTA Group

    Hero Visual
```

---

# Content Requirements

## Main Heading (H1)

Use:

```
Building Digital Solutions That Help Businesses Grow
```

Requirements:

- Only one H1 on homepage.
- Clear business value.
- No exaggerated claims.

---

## Supporting Text

Use:

```
SMEvolve helps businesses build modern websites, custom software, mobile applications, and automation solutions designed around their unique goals.
```

---

# CTA Buttons

Primary:

Text:

```
Get a Free Quote
```

Link:

```
/quote
```

Use:

```
<x-buttons.primary-button />
```

---

Secondary:

Text:

```
View Our Services
```

Link:

```
/services
```

Use:

```
<x-buttons.secondary-button />
```

---

# Hero Visual

Prepare structure for:

- Illustration
- Product mockup
- Technology graphic

Do not use random stock images.

If an asset does not exist:

Create a placeholder component.

Example:

```
<x-hero-visual />
```

---

# Design Requirements

Follow:

Documentation/03_Design_System.md


The Hero should feel:

- Modern
- Premium
- Clean
- Professional

Use:

- Proper spacing
- Typography hierarchy
- Balanced layout

Avoid:

- Excessive animations
- Clutter
- Generic templates

---

# Responsive Behaviour

Desktop:

Two-column layout:

```
Content | Visual
```

Mobile:

Order:

```
Heading

Description

CTA Buttons

Visual
```

---

# Accessibility Requirements

Implement:

- Semantic section element.
- Correct heading hierarchy.
- Accessible buttons.
- Image alt text.
- Keyboard navigation support.

---

# SEO Requirements

The Hero should naturally support:

Primary topics:

- Web Development Company Nigeria
- Custom Software Development
- Business Website Development
- Digital Solutions

Implement:

- Proper H1.
- Descriptive content.
- Semantic HTML.

---

# Performance Requirements

Optimize:

- Images.
- Assets.
- CSS usage.

Avoid:

- Large unoptimized files.
- Heavy JavaScript.

---

# Integration

Add Hero component to:

```
resources/views/home.blade.php
```

Example:

```
<x-sections.hero />
```

---

# Testing

Verify:

Homepage loads correctly.

Hero displays on desktop.

Hero displays on mobile.

Buttons work.

No Blade errors.

Run:

```
php artisan serve
```

---

# Completion Report

Provide:

## Summary

What was implemented.

## Files Created

List files.

## Files Modified

List changes.

## Components Added

List components.

## SEO Improvements

List improvements.

## Issues

List problems.

## Next Step

Recommend Phase 5.

---

Stop after completing this phase.

Do not implement other homepage sections.