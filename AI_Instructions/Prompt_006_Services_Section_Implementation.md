# SMEvolve Execution Prompt
## Phase 6 - Homepage Services Section Implementation

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

Documentation/05_Homepage/05_Services_Section.md


Follow all project rules.

---

# Objective

Implement the SMEvolve Homepage Services Section.

The purpose of this section is to clearly communicate SMEvolve's main digital solutions and guide visitors toward requesting a project.

The section should answer:

"What can SMEvolve build for my business?"

---

# Implementation Location

Create reusable components.

Section:

```
resources/views/components/sections/services.blade.php
```

Card:

```
resources/views/components/cards/service-card.blade.php
```

Integrate into:

```
resources/views/home.blade.php
```

---

# Component Usage

The homepage should use:

```
<x-sections.services />
```

---

# Section Structure

The section contains:

```
Services Section

    Heading

    Description

    Services Grid

        Service Card

        Service Card

        Service Card

        Service Card

        Service Card

        Service Card

        Service Card

        Service Card


    CTA Button
```

---

# Section Content

## Heading

Use:

```
Digital Solutions Built Around Your Business Needs
```

---

## Description

Use:

```
From professional websites to custom software and automation solutions, SMEvolve helps businesses use technology to improve operations, reach customers, and grow.
```

---

# Services Data

Create structured service data.

Do not hard-code repeated card markup.

Store data in:

```
config/services.php
```

---

# Services List

## 1. Website Development

Description:

```
Modern, responsive websites designed to showcase your business, attract customers, and improve your online visibility.
```

URL:

```
/services/web-development
```

---

## 2. E-commerce Development

Description:

```
Secure online stores with customer-friendly shopping experiences and business management features.
```

URL:

```
/services/ecommerce-development
```

---

## 3. Custom Software Development

Description:

```
Custom applications and business systems created to improve efficiency and solve specific operational challenges.
```

URL:

```
/services/custom-software-development
```

---

## 4. Laravel Development

Description:

```
Secure Laravel applications designed for businesses that need reliable backend systems and custom functionality.
```

URL:

```
/services/laravel-development
```

---

## 5. WordPress Development

Description:

```
Professional WordPress websites optimized for performance, usability, and search visibility.
```

URL:

```
/services/wordpress-development
```

---

## 6. Mobile App Development

Description:

```
Cross-platform mobile applications designed to improve customer engagement and business operations.
```

URL:

```
/services/mobile-development
```

---

## 7. AI Solutions

Description:

```
AI-powered tools and intelligent solutions that improve productivity, automation, and customer experiences.
```

URL:

```
/services/ai-solutions
```

---

## 8. Business Automation

Description:

```
Automation solutions that help businesses save time, reduce manual work, and improve efficiency.
```

URL:

```
/services/business-automation
```

---

# Service Card Requirements

Each card must include:

```
Icon

Service Name

Description

Learn More Link
```

---

# Card Component Rules

The service card must be:

- Reusable.
- Configurable.
- Accessible.
- Responsive.

Accept:

```
title

description

icon

url
```

---

# Design Requirements

Follow:

Documentation/03_Design_System.md


The section should feel:

- Premium.
- Clear.
- Professional.

Use:

- Clean cards.
- Consistent spacing.
- Clear hierarchy.

Avoid:

- Overloading users with text.
- Technical explanations.
- Generic marketing phrases.

---

# CTA

Add after service cards:

Primary:

```
Get a Free Quote
```

Link:

```
/quote
```

Secondary:

```
View All Services
```

Link:

```
/services
```

---

# Responsive Behaviour

Desktop:

```
4-column grid
```

Tablet:

```
2-column grid
```

Mobile:

```
1-column stacked cards
```

---

# Accessibility Requirements

Implement:

- Semantic section element.
- Correct heading hierarchy.
- Accessible links.
- Keyboard navigation.
- Descriptive icons.

---

# SEO Requirements

Support:

Primary:

- Web Development Company Nigeria
- Laravel Development Nigeria
- WordPress Development Nigeria
- Custom Software Development

Secondary:

- Mobile App Development
- API Development
- AI Solutions

Implementation:

Each service card must link to future dedicated SEO pages.

---

# Performance Requirements

Ensure:

- Optimized icons.
- No unnecessary JavaScript.
- Efficient Blade rendering.

---

# Testing

Verify:

Services display correctly.

Cards are reusable.

Links work.

Responsive layout works.

No Blade errors.

Run:

```
php artisan serve
```

---

# Completion Report

Provide:

## Summary

Work completed.

## Files Created

List files.

## Files Modified

List files.

## Components Added

List reusable components.

## SEO Improvements

List improvements.

## Issues

List problems.

## Next Step

Recommend Phase 7.

---

Stop after completing this phase.

Do not implement Why Choose SMEvolve yet.