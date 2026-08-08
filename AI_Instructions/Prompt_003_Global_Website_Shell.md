# SMEvolve Execution Prompt
## Phase 3 - Global Website Shell

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

Documentation/05_Homepage/02_Header.md

Follow all existing project rules.

---

# Objective

Build the reusable global website structure for SMEvolve.

This phase creates elements that appear across multiple pages.

Build:

- Header
- Navigation
- Mobile menu
- Footer
- Global buttons

Do not build homepage sections yet.

---

# Implementation Rules

Follow:

- Laravel Blade component standards.
- Tailwind CSS v4.
- Alpine.js only for lightweight interactions.
- Reusable component architecture.

Avoid:

- Page-specific code.
- Duplicate markup.
- Hard-coded repeated content.

---

# 1. Create Main Layout Integration

Update:

```
resources/views/layouts/app.blade.php
```

Replace placeholders with:

```
<x-navigation.header />

<main>
    {{ $slot }}
</main>

<x-navigation.footer />
```

Use reusable components.

---

# 2. Create Header Component

Create:

```
resources/views/components/navigation/header.blade.php
```

The header must include:

## Logo

Requirements:

- Display SMEvolve logo.
- Link to homepage.
- Use optimized asset.

Link:

```
/
```

---

## Desktop Navigation

Create menu items:

```
Home

Services

Solutions

Portfolio

Packages

Blog

About

Contact
```

Use routes prepared in Information Architecture.

If pages do not exist yet, create placeholder links.

---

## Primary CTA

Button:

```
Get a Free Quote
```

Link:

```
/quote
```

Use reusable button component.

---

# 3. Create Mobile Navigation

Use Alpine.js.

Requirements:

- Open menu button.
- Close menu button.
- Smooth transition.
- Accessible controls.

Mobile menu contains:

```
Home

Services

Solutions

Portfolio

Packages

Blog

About

Contact

Get a Free Quote
```

---

# Accessibility Requirements

Header must include:

- Semantic header element.
- Navigation landmark.
- aria-label attributes.
- Keyboard accessibility.
- Visible focus states.

Mobile button requires:

```
aria-expanded
aria-controls
```

---

# 4. Create Footer Component

Create:

```
resources/views/components/navigation/footer.blade.php
```

Footer should include:

## Brand Section

Include:

- SMEvolve name.
- Short description.

Example:

```
Helping businesses grow through reliable technology.
```

---

## Footer Links

Include:

### Company

```
About

Services

Portfolio

Contact
```

### Resources

```
Blog

FAQ

Privacy Policy

Terms
```

### Contact

Include placeholders for:

- Email
- Phone
- WhatsApp

---

## Social Links

Prepare structure for:

- LinkedIn
- Instagram
- Facebook
- X/Twitter

Only include when official links are available.

---

# 5. Create Button Components

Create reusable buttons:

Location:

```
resources/views/components/buttons/
```

Components:

```
primary-button.blade.php

secondary-button.blade.php
```

Requirements:

Support:

- Text
- Link
- Custom classes
- Accessibility attributes

---

# 6. Add Navigation Data Structure

Do not hard-code repeated navigation items.

Create configuration:

Example:

```
config/navigation.php
```

Store:

- Label
- URL
- Order

The Blade component should loop through navigation data.

---

# 7. Responsive Requirements

Desktop:

```
Logo | Navigation | CTA
```

Mobile:

```
Logo | Menu Button
```

---

# 8. SEO Requirements

Header should support:

- Clear internal linking.
- Descriptive anchor text.
- Proper navigation hierarchy.

Footer should support:

- Additional internal links.
- Website discoverability.

---

# 9. Performance Requirements

Ensure:

- No unnecessary JavaScript.
- Optimized logo loading.
- Minimal DOM complexity.

---

# Testing

Verify:

Desktop navigation works.

Mobile menu works.

All links render correctly.

No Blade errors.

Run:

```
php artisan serve
```

---

# Completion Report

Provide:

## Completed

Summary.

## Files Created

List files.

## Files Modified

List changes.

## Components Created

List reusable components.

## Issues

Any problems.

## Next Step

Recommend Phase 4.

---

Stop after completing this phase.

Do not build homepage sections yet.