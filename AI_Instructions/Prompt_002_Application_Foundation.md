# SMEvolve Execution Prompt
## Phase 2 - Application Foundation & Architecture

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

Documentation/05_Homepage/01_Homepage_Master_Specification.md

Follow all existing project rules.

---

# Objective

Create the core Laravel application structure required for SMEvolve.

This phase prepares:

- Layout system
- Blade component architecture
- Asset organization
- Global styling foundation

Do not build homepage sections yet.

---

# Tasks

## 1. Create Main Application Layout

Create:

```
resources/views/layouts/app.blade.php
```

The layout should include:

- HTML document structure
- Language attribute
- SEO metadata placeholders
- Vite asset loading
- Main content slot
- Future header and footer placeholders

Example structure:

```
<html>

<head>

    metadata

    styles

</head>


<body>

    header placeholder

    main content

    footer placeholder


    scripts

</body>

</html>
```

---

# 2. Create Blade Component Structure

Prepare reusable component folders:

```
resources/views/components/

├── layout/

├── navigation/

├── buttons/

├── cards/

├── sections/

├── forms/

└── shared/
```

Do not create unnecessary components yet.

Only create the structure.

---

# 3. Create Global Components

Create foundation components:

## Button Component

Location:

```
components/buttons/
```

Purpose:

Reusable CTA buttons.

Support:

- Primary button
- Secondary button

---

## Section Component

Location:

```
components/sections/
```

Purpose:

Reusable homepage sections.

Should support:

- Heading
- Description
- Content slot

---

# 4. Frontend Asset Structure

Organize:

```
resources/

├── css/

│   └── app.css


├── js/

│   └── app.js


├── images/

└── icons/
```

---

# 5. Global Styling Setup

Configure Tailwind based on:

Documentation/03_Design_System.md


Implement:

- Typography foundation
- Spacing system
- Colour variables
- Responsive rules


Do not create page-specific styles.

---

# 6. Route Foundation

Prepare:

```
routes/web.php
```

Create only:

Homepage placeholder route.

Example:

```
/
```

Return a temporary view.

Do not build homepage content.

---

# 7. Create Temporary Homepage View

Create:

```
resources/views/home.blade.php
```

Only include:

```
SMEvolve Website
Coming Soon
```

This is temporary.

---

# Restrictions

Do not create:

- Header design
- Hero section
- Services section
- Homepage content
- Database
- Models
- Controllers
- Forms

Those belong to later phases.

---

# Testing Requirements

Verify:

Laravel application loads.

Homepage route works.

Assets compile successfully.

Run:

```
php artisan serve
```

and:

```
npm run build
```

---

# Completion Report

Provide:

## Completed

Summary of work.

## Files Created

List files.

## Files Modified

List changes.

## Decisions Made

Explain architecture choices.

## Issues

List problems.

## Next Step

Recommend Phase 3.

---

Stop after completing this phase.
Do not continue to homepage development.