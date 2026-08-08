# SMEvolve Execution Prompt
## Phase 5 - Homepage Technology Stack Section Implementation

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

Documentation/05_Homepage/04_Technology_Section.md


Follow all instructions from these documents.

---

# Objective

Implement the SMEvolve Homepage Technology Stack Section.

The purpose of this section is to demonstrate technical capability and build visitor confidence.

The section should communicate:

- SMEvolve uses modern technologies.
- Technology choices are based on business needs.
- Projects are built with scalability and reliability in mind.

---

# Implementation Location

Create a reusable Blade component:

```
resources/views/components/sections/technology-stack.blade.php
```

Integrate into:

```
resources/views/home.blade.php
```

---

# Component Structure

Create:

```
<x-sections.technology-stack />
```

The component must be reusable.

---

# Section Structure

The section should contain:

```
Technology Section

    Section Heading

    Introduction Text

    Technology Categories

        Technology Card

        Technology Card

        Technology Card

        Technology Card

        Technology Card

```

---

# Content

## Heading

Use:

```
Built With Modern Technologies
```

---

## Description

Use:

```
We use modern technologies and development practices to create secure, scalable, and reliable digital solutions that support business growth.
```

---

# Technology Categories

Create reusable technology cards.

---

## Web Development

Technologies:

```
Laravel

React

Next.js

Tailwind CSS

JavaScript
```

Description:

```
Modern websites and web platforms designed for performance and usability.
```

---

## Backend & APIs

Technologies:

```
Laravel

PHP

REST APIs

Python
```

Description:

```
Reliable backend systems and integrations that support business operations.
```

---

## Mobile Development

Technologies:

```
React Native

Mobile APIs
```

Description:

```
Cross-platform mobile solutions for businesses and customers.
```

---

## Database & Infrastructure

Technologies:

```
MySQL

PostgreSQL

Cloud Hosting
```

Description:

```
Secure and scalable systems designed for reliable performance.
```

---

## AI & Automation

Technologies:

```
AI APIs

Automation Tools

AI Assistants
```

Description:

```
Intelligent solutions that improve efficiency and business workflows.
```

---

# Component Architecture

Create:

```
resources/views/components/cards/technology-card.blade.php
```

The card should accept:

- title
- description
- technologies
- icon

Example:

```
<x-cards.technology-card />
```

---

# Design Requirements

Follow:

Documentation/03_Design_System.md


The section should feel:

- Professional
- Clean
- Premium
- Modern

Use:

- Cards
- Consistent spacing
- Clear typography

Avoid:

- Developer-only presentation.
- Large walls of logos.
- Excessive technical language.

---

# Responsive Behaviour

Desktop:

```
3-column grid
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

- Semantic section heading.
- Proper heading hierarchy.
- Accessible icons.
- Keyboard-friendly links if used.
- Good colour contrast.

Icons must not replace text.

---

# SEO Requirements

Support keywords naturally:

- Laravel Development Nigeria
- Custom Software Development
- API Development
- Mobile App Development
- AI Business Solutions

Do not keyword stuff.

---

# Performance Requirements

Ensure:

- Lightweight icons.
- No unnecessary JavaScript.
- Optimized assets.

---

# Testing

Verify:

Homepage displays correctly.

Technology cards render correctly.

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

What was implemented.

## Files Created

List files.

## Files Modified

List changes.

## Components Added

List reusable components.

## SEO Improvements

List improvements.

## Issues

List problems.

## Next Step

Recommend Phase 6.

---

Stop after completing this phase.

Do not implement the Services Section yet.