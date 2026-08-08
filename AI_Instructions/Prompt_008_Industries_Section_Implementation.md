# SMEvolve Execution Prompt
## Phase 8 - Industries We Serve Section Implementation

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

Documentation/05_Homepage/07_Industries_Section.md


Follow all project standards.

---

# Objective

Implement the SMEvolve Homepage Industries We Serve Section.

The purpose of this section is to show that SMEvolve creates solutions for different business sectors.

It should help visitors answer:

"Does SMEvolve understand businesses like mine?"

---

# Implementation Location

Create:

Section:

```
resources/views/components/sections/industries.blade.php
```

Card:

```
resources/views/components/cards/industry-card.blade.php
```

Integrate into:

```
resources/views/home.blade.php
```

---

# Component Usage

Use:

```
<x-sections.industries />
```

---

# Section Structure

Create:

```
Industries Section

    Heading

    Introduction

    Industry Grid

        Industry Card

        Industry Card

        Industry Card

        Industry Card

        Industry Card

        Industry Card

    CTA
```

---

# Section Heading

Use:

```
Technology Solutions For Different Industries
```

---

# Introduction Text

Use:

```
Every industry has unique challenges. SMEvolve builds digital solutions tailored to the needs of businesses, organisations, and professionals across different sectors.
```

---

# Industry Data

Create structured data.

Store:

```
config/industries.php
```

Do not hard-code repeated markup.

---

# Industry Cards

## 1. Small & Medium Businesses

Description:

```
Helping growing businesses establish an online presence, improve operations, and adopt digital tools.
```

Solutions:

```
Business websites

Custom software

Automation

Digital systems
```

Future URL:

```
/industries/small-businesses
```

---

## 2. Healthcare & Medical Organisations

Description:

```
Digital solutions that help healthcare providers improve communication, patient experience, and operational efficiency.
```

Solutions:

```
Hospital websites

Appointment systems

Management platforms

Patient communication tools
```

Future URL:

```
/industries/healthcare
```

---

## 3. Schools & Educational Organisations

Description:

```
Technology solutions that help educational institutions improve access, communication, and administration.
```

Solutions:

```
School websites

Learning platforms

Management systems

Online portals
```

Future URL:

```
/industries/education
```

---

## 4. Retail & E-commerce Businesses

Description:

```
Helping businesses sell online and improve customer experiences through digital platforms.
```

Solutions:

```
Online stores

Inventory systems

Payment integration

Customer platforms
```

Future URL:

```
/industries/retail
```

---

## 5. Restaurants & Hospitality

Description:

```
Digital solutions that help restaurants and hospitality businesses attract customers and improve services.
```

Solutions:

```
Restaurant websites

Online ordering systems

Booking systems

Customer engagement tools
```

Future URL:

```
/industries/hospitality
```

---

## 6. NGOs & Professional Organisations

Description:

```
Technology solutions that improve visibility, communication, and organisational efficiency.
```

Solutions:

```
Organisation websites

Data systems

Communication platforms

Automation
```

Future URL:

```
/industries/professional-services
```

---

# Industry Card Requirements

Each card must include:

```
Icon

Industry Name

Description

Learn More Link
```

Component accepts:

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

- Inclusive.
- Professional.
- Business-focused.
- Easy to scan.

Avoid:

- Limiting SMEvolve to one industry.
- Generic descriptions.
- Excessive text.

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
- Proper heading hierarchy.
- Accessible links.
- Meaningful icons.
- Keyboard support.

---

# SEO Requirements

This section should support future ranking opportunities:

- Website development for hospitals.
- School website development.
- Restaurant website development.
- Business software solutions.
- NGO website development.

Requirements:

- Use descriptive links.
- Prepare internal linking structure.
- Avoid keyword stuffing.

---

# Performance Requirements

Ensure:

- Optimized icons.
- Minimal JavaScript.
- Efficient Blade rendering.

---

# Testing

Verify:

Industry cards display correctly.

Data loads correctly.

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

Recommend Phase 9.

---

Stop after completing this phase.

Do not implement Development Process yet.