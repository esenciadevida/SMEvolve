# SMEvolve Execution Prompt
## Phase 9 - Development Process Section Implementation

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


Follow all project standards.

---

# Objective

Implement the SMEvolve Homepage Development Process Section.

The purpose of this section is to show visitors how projects move from idea to completion.

It should answer:

"How does SMEvolve handle my project?"

---

# Implementation Location

Create:

Section:

```
resources/views/components/sections/development-process.blade.php
```

Step Card:

```
resources/views/components/cards/process-step.blade.php
```

Integrate into:

```
resources/views/home.blade.php
```

---

# Component Usage

Use:

```
<x-sections.development-process />
```

---

# Section Structure

Create:

```
Development Process

    Heading

    Introduction

    Process Timeline

        Step Card

        Step Card

        Step Card

        Step Card

        Step Card

        Step Card

        Step Card

    CTA
```

---

# Section Heading

Use:

```
A Simple Process From Idea To Launch
```

---

# Introduction Text

Use:

```
We follow a structured development process that keeps projects clear, transparent, and focused on achieving business goals.
```

---

# Process Data

Create structured data.

Store:

```
config/process.php
```

Do not hard-code repeated markup.

---

# Process Steps

## Step 1

Title:

```
Discovery & Consultation
```

Description:

```
We learn about your business, goals, challenges, and requirements to understand the right solution.
```

Icon:

```
search
```

---

## Step 2

Title:

```
Planning & Strategy
```

Description:

```
We define project requirements, features, technology choices, timeline, and development approach.
```

Icon:

```
planning
```

---

## Step 3

Title:

```
Design & User Experience
```

Description:

```
We create intuitive designs focused on usability, customer experience, and business objectives.
```

Icon:

```
design
```

---

## Step 4

Title:

```
Development
```

Description:

```
Our developers build the solution using modern technologies and industry best practices.
```

Icon:

```
code
```

---

## Step 5

Title:

```
Testing & Quality Assurance
```

Description:

```
We test functionality, performance, security, and usability before launch.
```

Icon:

```
testing
```

---

## Step 6

Title:

```
Launch & Deployment
```

Description:

```
We help deploy your solution and ensure everything is ready for your users.
```

Icon:

```
rocket
```

---

## Step 7

Title:

```
Support & Improvement
```

Description:

```
We continue supporting your digital solution through maintenance, updates, and improvements.
```

Icon:

```
support
```

---

# Process Card Requirements

Each card must contain:

```
Step Number

Icon

Title

Description
```

Component accepts:

```
number

title

description

icon
```

---

# Design Requirements

Follow:

Documentation/03_Design_System.md


The section should feel:

- Structured.
- Professional.
- Trustworthy.

Recommended layouts:

Desktop:

```
Horizontal timeline
```

or

```
Grid process steps
```

Mobile:

```
Vertical timeline
```

Avoid:

- Overly complex animations.
- Too much text.

---

# Responsive Behaviour

Desktop:

```
Timeline/Grid layout
```

Tablet:

```
Two-column layout
```

Mobile:

```
Single-column timeline
```

---

# Accessibility Requirements

Implement:

- Semantic ordered list where appropriate.
- Proper heading hierarchy.
- Accessible icons.
- Keyboard support.

---

# SEO Requirements

Support naturally:

- Web development process.
- Software development process.
- Custom software development.

Content should explain the process clearly for users and search engines.

---

# Performance Requirements

Ensure:

- Lightweight icons.
- Minimal JavaScript.
- Efficient rendering.

---

# Testing

Verify:

Process steps display correctly.

Timeline works on mobile.

Data loads correctly.

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

Recommend Phase 10.

---

Stop after completing this phase.

Do not implement Portfolio yet.