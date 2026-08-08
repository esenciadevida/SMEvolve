# SMEvolve Execution Prompt
## Phase 7 - Why Choose SMEvolve Section Implementation

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

Documentation/05_Homepage/06_Why_Choose_SMEvolve.md


Follow all project standards.

---

# Objective

Implement the Why Choose SMEvolve section.

The purpose of this section is to build trust and communicate why businesses should partner with SMEvolve.

It should answer:

"Why should I trust SMEvolve with my project?"

---

# Implementation Location

Create:

Section:

```
resources/views/components/sections/why-choose.blade.php
```

Card:

```
resources/views/components/cards/benefit-card.blade.php
```

Integrate into:

```
resources/views/home.blade.php
```

---

# Component Usage

Use:

```
<x-sections.why-choose />
```

---

# Section Structure

Create:

```
Why Choose SMEvolve

    Heading

    Introduction

    Benefits Grid

        Benefit Card

        Benefit Card

        Benefit Card

        Benefit Card

        Benefit Card

        Benefit Card

```

---

# Section Heading

Use:

```
Why Businesses Choose SMEvolve
```

---

# Introduction Text

Use:

```
Technology projects succeed when they solve real business problems. SMEvolve combines technical expertise with business understanding to create solutions that are practical, scalable, and built for growth.
```

---

# Benefits Data

Create structured data.

Store:

```
config/benefits.php
```

Do not hard-code repeated markup.

---

# Benefit Cards

## 1. Business-First Approach

Description:

```
We begin by understanding your goals, challenges, and customers before recommending the right technology solution.
```

Icon:

```
strategy
```

---

## 2. Custom Solutions

Description:

```
Every business is different. We create solutions tailored to your specific processes, requirements, and objectives.
```

Icon:

```
customization
```

---

## 3. Modern Technology

Description:

```
We use reliable and modern technologies to create secure, scalable, and maintainable digital products.
```

Icon:

```
technology
```

---

## 4. Transparent Communication

Description:

```
We keep clients informed through clear discussions, project updates, and collaborative decision-making.
```

Icon:

```
communication
```

---

## 5. Quality & Performance Focus

Description:

```
We focus on usability, speed, security, and reliability throughout the development process.
```

Icon:

```
quality
```

---

## 6. Long-Term Support

Description:

```
Our relationship continues after launch through maintenance, improvements, and technical support.
```

Icon:

```
support
```

---

# Benefit Card Requirements

Each card must include:

```
Icon

Title

Description
```

The component must accept:

```
title

description

icon
```

---

# Design Requirements

Follow:

Documentation/03_Design_System.md


The section should feel:

- Trustworthy.
- Professional.
- Premium.
- Human-focused.

Avoid:

- Unrealistic claims.
- Fake statistics.
- Generic statements like "best company".

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
1-column stack
```

---

# Accessibility Requirements

Implement:

- Semantic section.
- Proper headings.
- Accessible icons.
- Good contrast.
- Keyboard support.

Icons must support text, not replace it.

---

# SEO Requirements

Support naturally:

- Digital solutions company.
- Software development partner.
- Custom software development.
- Web development services.

Do not keyword stuff.

---

# Performance Requirements

Ensure:

- Lightweight icons.
- Minimal JavaScript.
- Efficient rendering.

---

# Testing

Verify:

Section displays correctly.

Cards render from data.

Responsive design works.

No Blade errors.

Run:

```
php artisan serve
```

---

# Completion Report

Provide:

## Summary

Completed work.

## Files Created

List files.

## Files Modified

List files.

## Components Added

List components.

## SEO Improvements

List improvements.

## Issues

List problems.

## Next Step

Recommend Phase 8.

---

Stop after completing this phase.

Do not implement Industries Section yet.