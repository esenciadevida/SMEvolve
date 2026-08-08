# SMEvolve Design System
## Part 2 – UI Components

**Project Name:** SMEvolve
**Version:** 1.0
**Document Type:** UI Components

---

# Purpose

This document defines every reusable user interface component used throughout the SMEvolve website.

Every page must reuse these components instead of creating new designs.

Consistency is mandatory.

---

# AI Implementation Instructions

Before creating any UI component:

- Read Part 1 of the Design System.
- Reuse components whenever possible.
- Never duplicate UI.
- Build Blade Components.
- Keep components configurable using props.
- Components must be responsive.
- Components must support dark mode.
- Components must be accessible.

---

# Design Principles

Every component should be:

- Clean
- Modern
- Accessible
- Reusable
- Responsive
- Lightweight

Avoid visual clutter.

---

# Buttons

The website should use only these button types.

## Primary Button

Purpose

Main Call To Action.

Examples

- Get a Quote
- Contact Us
- Book Consultation

Style

- Filled
- Primary Color
- White Text
- Medium Shadow
- Rounded Corners

Hover

- Slight Lift
- Darker Background
- Smooth Transition

---

## Secondary Button

Purpose

Secondary actions.

Style

- Light Background
- Primary Border
- Primary Text

---

## Outline Button

Transparent background.

Primary border.

Primary text.

---

## Ghost Button

No border.

No background.

Text only.

Hover with subtle background.

---

## Danger Button

Used only for admin actions.

Red background.

White text.

---

## Icon Button

Square button.

Centered icon.

Accessible label required.

---

# Button Sizes

Small

Medium

Large

Extra Large

Never create custom button sizes.

---

# Cards

Every card should follow one design language.

Cards should contain:

- Title
- Description
- Optional Icon
- Optional Image
- CTA

Cards should have:

- Rounded corners
- Soft shadow
- Hover elevation
- Padding
- Responsive layout

---

# Service Card

Contains

- Icon
- Service Name
- Description
- Learn More

---

# Portfolio Card

Contains

- Image
- Project Name
- Category
- Technology Stack
- View Details

---

# Pricing Card

Contains

- Package Name
- Price
- Features
- CTA

Support

- Featured Package
- Badge
- Highlight Border

---

# Testimonial Card

Contains

- Client Image
- Client Name
- Company
- Review
- Rating

---

# Blog Card

Contains

- Featured Image
- Category
- Title
- Summary
- Reading Time
- Publish Date

---

# Statistic Card

Contains

- Icon
- Number
- Description

Example

250+

Projects Completed

---

# Forms

All forms should have a consistent appearance.

Fields

- Label
- Input
- Help Text
- Error Message

Validation

Inline validation.

Accessible error messages.

---

# Input Fields

Support

- Text
- Email
- Password
- Phone
- Number
- URL
- Search

---

# Textarea

Resizable vertically only.

---

# Select

Modern dropdown.

Keyboard accessible.

---

# Checkbox

Rounded.

Accessible.

---

# Radio Button

Modern design.

Keyboard accessible.

---

# Toggle Switch

Used for settings.

Animated.

---

# File Upload

Drag and Drop

Browse Button

Progress Indicator

---

# Tables

Responsive.

Sortable.

Searchable.

Pagination support.

Alternating row colors.

---

# Badges

Types

Primary

Success

Warning

Danger

Information

Neutral

---

# Alerts

Types

Success

Warning

Danger

Information

Alerts should include:

- Icon
- Message
- Close Button

---

# Toast Notifications

Position

Top Right

Auto dismiss

Animated

---

# Modal

Features

Overlay

Centered

ESC to Close

Click Outside to Close

Focus Trap

Responsive

---

# Drawer

Slide from:

Left

Right

Used for

Mobile Navigation

Filters

Settings

---

# Accordion

Used for:

FAQ

Documentation

Expandable Content

Only one section open by default.

---

# Tabs

Horizontal Tabs

Responsive

Keyboard accessible

---

# Breadcrumb

Format

Home

>

Services

>

Laravel Development

---

# Pagination

Include

Previous

Page Numbers

Next

Current Page Highlight

---

# Search Bar

Rounded.

Search icon.

Autocomplete ready.

---

# Loading States

Skeleton Loading

Spinner

Progress Bar

Never leave blank screens.

---

# Empty States

Illustration

Message

CTA

Example

"No blog posts found."

---

# Error Pages

404

500

Maintenance

Friendly language.

Helpful CTA.

---

# Newsletter Component

Contains

Title

Description

Email Input

Subscribe Button

Success Message

---

# FAQ Component

Accordion layout.

Smooth animation.

---

# Call To Action Component

Reusable.

Contains

Headline

Description

Primary Button

Secondary Button

Background Illustration

---

# Accessibility

Every component must:

- Support keyboard navigation
- Include ARIA labels where needed
- Have visible focus states
- Meet WCAG AA guidelines

---

# Acceptance Criteria

Implementation is complete when:

- Components are reusable.
- Components are responsive.
- Components are accessible.
- Components support dark mode.
- Components follow the design system.
- No duplicate component styles exist.

---

# Revision Policy

New UI components must follow the existing design language.

Avoid introducing one-off component styles.