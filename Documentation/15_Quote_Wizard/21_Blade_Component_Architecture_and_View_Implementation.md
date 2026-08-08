# SMEvolve Quote Wizard

## Part 21 – Blade Component Architecture & View Implementation

**Project:** SMEvolve

**Framework:** Laravel 12

**Frontend:** Blade, Vite, Alpine.js

**AI Provider:** Groq

**Module:** Quote Wizard

**Version:** 1.0

**Document Type:** Blade Component Architecture & View Implementation Specification

---

# Objective

Define the frontend presentation architecture for the SMEvolve Quote Wizard.

The Quote Wizard frontend must provide a professional, responsive, accessible, and maintainable experience while keeping presentation separate from business logic.

The implementation must use:

* Laravel Blade.
* Blade components.
* Alpine.js for lightweight interaction.
* Existing SMEvolve design-system components.
* Existing global layouts.
* Existing Vite asset pipeline.

---

# Architecture Principles

The Quote Wizard frontend must:

1. Reuse global layouts.
2. Reuse existing design-system components.
3. Avoid duplicated markup.
4. Keep business logic outside Blade.
5. Keep JavaScript lightweight.
6. Support progressive enhancement.
7. Provide accessible forms.
8. Support mobile, tablet, and desktop.
9. Preserve user progress.
10. Keep AI interactions clearly separated from normal form submission.

---

# View Architecture

Recommended structure:

```text
resources/views/
└── quote/
    ├── index.blade.php
    ├── step.blade.php
    ├── review.blade.php
    ├── confirmation.blade.php
    │
    └── components/
        ├── layout.blade.php
        ├── progress.blade.php
        ├── question.blade.php
        ├── question/
        │   ├── text.blade.php
        │   ├── textarea.blade.php
        │   ├── email.blade.php
        │   ├── phone.blade.php
        │   ├── number.blade.php
        │   ├── single-choice.blade.php
        │   └── multiple-choice.blade.php
        │
        ├── navigation.blade.php
        ├── errors.blade.php
        ├── ai-assistant.blade.php
        ├── review-section.blade.php
        ├── consent.blade.php
        └── session-expired.blade.php
```

The exact folder structure may be adapted to existing SMEvolve conventions.

---

# Global Layout Reuse

The Quote Wizard must reuse the existing SMEvolve application layout wherever appropriate.

Do not create an independent full website layout unless the existing architecture cannot support the wizard.

The Quote Wizard should inherit:

* Global typography.
* Global spacing.
* Global colors.
* Global accessibility behavior.
* Global header/footer rules where applicable.
* Global SEO infrastructure.

---

# Quote Layout

Create a Quote-specific layout component only when needed.

Conceptually:

```text
Global Layout
      ↓
Quote Layout
      ↓
Quote Page
```

The Quote layout should handle:

* Wizard container.
* Progress area.
* Main content region.
* Navigation region.
* Responsive structure.

---

# Quote Landing Page

View:

```text
quote/index.blade.php
```

Purpose:

Introduce the Quote Wizard and allow the user to begin.

---

# Landing Page Structure

Recommended:

```text
Hero
 ↓
What the wizard does
 ↓
What information is needed
 ↓
Estimated completion time
 ↓
Start Quote CTA
```

The page should remain concise.

Do not overwhelm the user before the wizard begins.

---

# Start CTA

Primary action:

```text
Start Your Quote
```

The button should submit through the normal Laravel route:

```text
quote.start
```

---

# Wizard Step Page

View:

```text
quote/step.blade.php
```

This should be the primary reusable wizard page.

It should not contain a separate hardcoded template for every question.

---

# Step Structure

Recommended:

```text
Quote Layout

├── Breadcrumb
│
├── Progress
│
├── Step Heading
│
├── Step Description
│
├── Form
│   └── Question Component
│
├── Validation Errors
│
├── AI Assistance
│
└── Navigation
```

---

# Progress Component

Component:

```text
quote/components/progress.blade.php
```

Responsibilities:

* Display current step.
* Display total progress.
* Indicate completed steps.
* Provide accessible progress information.

---

# Progress Example

```text
Step 3 of 8

████████░░░░
```

The exact visual implementation should follow the SMEvolve design system.

---

# Accessibility

The progress indicator should communicate progress to assistive technologies.

Example semantic information:

```html
aria-label="Quote progress"
```

The current step should be identifiable.

---

# Progress Calculation

The Blade component should receive prepared values:

```text
currentStep
totalSteps
percentage
```

Do not calculate complex flow logic inside Blade.

---

# Question Component

Primary component:

```text
quote/components/question.blade.php
```

Its responsibility is to select the appropriate input component based on the configured question type.

---

# Question Rendering

Conceptually:

```text
Question
   ↓
type
   ↓
Input Component
```

Example:

```text
text
 ↓
question/text.blade.php
```

---

# Supported Question Types

Initially support:

```text
text
textarea
email
phone
number
single_choice
multiple_choice
```

Future question types can be added without rewriting the wizard page.

---

# Text Question

Component:

```text
question/text.blade.php
```

Should support:

* Label.
* Description.
* Placeholder.
* Required indicator.
* Current value.
* Error state.

---

# Textarea Question

Component:

```text
question/textarea.blade.php
```

Should support:

* Multi-line input.
* Character guidance where appropriate.
* Minimum/maximum length messaging.
* Error state.

---

# Email Question

Component:

```text
question/email.blade.php
```

Must use appropriate semantic input:

```html
type="email"
```

Server-side validation remains authoritative.

---

# Phone Question

Component:

```text
question/phone.blade.php
```

Should use an appropriate phone input.

Do not unnecessarily restrict international formats.

---

# Number Question

Component:

```text
question/number.blade.php
```

Should provide:

* Numeric input.
* Appropriate min/max attributes where useful.
* Server-side validation.

---

# Single Choice

Component:

```text
question/single-choice.blade.php
```

Suitable UI:

* Radio buttons.
* Card-style choices.
* Other design-system choice components.

The visual presentation should depend on the final SMEvolve design system.

---

# Multiple Choice

Component:

```text
question/multiple-choice.blade.php
```

Use:

* Checkboxes.
* Accessible labels.
* Clear selected state.

Do not use visual cards that are inaccessible to keyboard or screen-reader users.

---

# Question Labels

Every input must have a corresponding accessible label.

Avoid relying solely on:

```text
placeholder
```

for field identification.

---

# Required Fields

Required questions should communicate required status visually and semantically.

Example:

```text
Project Type *
```

The component should also expose the requirement programmatically where appropriate.

---

# Error Handling

Component:

```text
quote/components/errors.blade.php
```

Responsibilities:

* Display validation summary.
* Display field-specific errors.
* Maintain accessible error associations.

---

# Field Error Association

Where an input has an error, the input should reference its error message.

Example concept:

```text
aria-describedby="project-type-error"
```

---

# Error Summary

A validation summary may be displayed near the top of the form.

It should:

* Clearly explain that corrections are required.
* Link to invalid fields where practical.
* Receive focus after a failed submission where appropriate.

---

# Old Input

Use Laravel's old input mechanism where appropriate.

However, for saved Quote Wizard sessions, the database value should remain the primary source of truth.

---

# Saved Answers

When loading a step:

```text
Database Answer
       ↓
Controller
       ↓
View
       ↓
Input value
```

The Blade template should not query the database directly.

---

# Form Structure

Each wizard step should use a standard Laravel form.

Conceptually:

```html
<form method="POST" action="...">
    @csrf

    <!-- question -->

    <!-- navigation -->
</form>
```

---

# HTTP Method

Step saving uses:

```text
POST
```

as defined by the route architecture.

---

# Navigation Component

Component:

```text
quote/components/navigation.blade.php
```

Should support:

```text
Back
Continue
```

---

# Navigation Rules

On the first step:

```text
Continue
```

may be the only primary navigation action.

On intermediate steps:

```text
Back
Continue
```

On the final data step:

```text
Back
Review Quote
```

---

# Navigation Accessibility

Buttons must:

* Have meaningful labels.
* Be keyboard accessible.
* Have visible focus states.
* Not depend on color alone.

---

# Review Page

View:

```text
quote/review.blade.php
```

Purpose:

Allow the user to verify information before submitting.

---

# Review Structure

Recommended:

```text
Review Your Quote

Project
────────────
Project Type
Description

Requirements
────────────
Feature 1
Feature 2
Feature 3

Timeline
────────────

Budget
────────────

Contact
────────────

Consent
────────────

Submit Quote
```

---

# Review Sections

Create reusable:

```text
review-section.blade.php
```

Each section should support:

* Heading.
* Values.
* Edit action.

---

# Edit Actions

Example:

```text
Project Information     Edit
Requirements             Edit
Timeline                 Edit
Contact Information     Edit
```

Each edit action should return the user to the correct wizard step.

---

# Review Data

The review page receives prepared data from:

```text
QuoteReviewService
```

Blade must not reconstruct the quote from raw database queries.

---

# Empty Values

Optional values should display gracefully.

Example:

```text
Not provided
```

Do not expose:

```text
null
N/A
undefined
```

unless specifically intended by the design.

---

# Consent Component

Component:

```text
quote/components/consent.blade.php
```

Responsibilities:

* Display required legal acknowledgements.
* Link to Privacy Policy.
* Link to Terms.
* Provide explicit acceptance controls.

---

# Legal Links

Use the existing named legal routes:

```text
privacy-policy.index
terms.index
cookies.index
```

Do not hardcode URLs.

---

# Consent UX

The checkbox must be:

* Clearly labelled.
* Keyboard accessible.
* Required where applicable.
* Explicit.

Do not pre-check required legal consent.

---

# AI Assistant Component

Component:

```text
quote/components/ai-assistant.blade.php
```

This provides optional AI assistance inside the Quote Wizard.

The AI should assist rather than control the user's answers.

---

# AI UI Principle

The user remains in control.

Example:

```text
Need help describing your project?

[Describe it for me]
```

AI generates:

```text
Suggested description...
```

Then:

```text
Use this
```

or:

```text
Try again
```

---

# AI Output

AI-generated content must not automatically overwrite the user's existing answer.

Correct:

```text
AI Suggestion

[Use suggestion]
```

Incorrect:

```text
AI generates
↓
Automatically replaces user input
```

---

# AI Loading State

While waiting:

```text
Generating suggestion...
```

The UI should prevent accidental repeated requests where appropriate.

---

# AI Error State

If AI fails:

```text
We couldn't generate a suggestion right now.
You can continue manually.
```

Do not expose provider-specific errors.

---

# AI JavaScript

Use Alpine.js for lightweight interaction.

Avoid introducing a large frontend framework.

---

# Alpine.js Responsibilities

Alpine may manage:

* Loading state.
* Showing/hiding suggestion.
* Applying a suggestion after confirmation.
* Character counts.
* UI-only state.

---

# Alpine Must Not Handle

Alpine must not become the source of truth for:

* Validation.
* Quote status.
* Requirement authorization.
* Step access.
* Consent.
* Submission.

Those remain server-side.

---

# Progressive Enhancement

The wizard should remain usable if non-essential JavaScript fails.

Core operations should continue through normal HTTP requests wherever possible.

AI assistance may be unavailable if JavaScript is disabled.

The primary Quote Wizard should remain functional.

---

# Loading States

Every asynchronous operation must communicate state.

Examples:

```text
Generating...
Saving...
Submitting...
```

Buttons should prevent accidental duplicate actions when necessary.

---

# Disabled Buttons

When an action is processing:

```text
Submit Quote
```

may temporarily become:

```text
Submitting...
```

But the server must still prevent duplicate submissions.

---

# Confirmation Page

View:

```text
quote/confirmation.blade.php
```

Purpose:

Confirm successful submission.

---

# Confirmation Content

Recommended:

```text
Quote Request Submitted

Thank you for contacting SMEvolve.

Your reference:
SME-2026-001245

We will review your request and contact you.
```

---

# Confirmation Actions

Possible:

```text
Return to Home
```

or:

```text
Explore Our Services
```

Do not provide unnecessary administrative information.

---

# Session Expired Component

Component:

```text
quote/components/session-expired.blade.php
```

Purpose:

Provide a friendly recovery experience.

---

# Expired Message

Example:

```text
Your quote session has expired.

Please start a new quote to continue.
```

Provide:

```text
Start New Quote
```

---

# Responsive Design

The Quote Wizard must support:

```text
Mobile
Tablet
Desktop
```

---

# Mobile

Priorities:

* Full-width inputs.
* Large touch targets.
* Minimal visual clutter.
* Clear progress.
* Sticky or easily accessible navigation where appropriate.

---

# Tablet

Use the additional screen width while maintaining a focused form layout.

---

# Desktop

The wizard should remain readable and focused rather than stretching form content across the entire screen.

---

# Content Width

Legal and form text should use readable maximum widths.

The Quote Wizard should avoid excessively wide paragraphs or form fields.

---

# Visual Hierarchy

Each step should have:

```text
Step indicator
      ↓
Question heading
      ↓
Supporting explanation
      ↓
Input
      ↓
Optional AI assistance
      ↓
Navigation
```

---

# Component Reuse

Where existing SMEvolve components exist for:

* Buttons.
* Inputs.
* Cards.
* Alerts.
* Links.
* Typography.

Reuse them.

Do not create duplicate design-system components inside the Quote Wizard.

---

# Component API

Components should receive explicit data.

Example concept:

```blade
<x-quote.question
    :question="$question"
    :value="$value"
    :errors="$errors"
/>
```

Avoid hidden database access inside components.

---

# No Database Queries in Blade

Never do:

```php
Question::find(...)
```

inside a Blade template.

Data must already be prepared.

---

# Escaping

User-provided content must use normal Blade escaping.

Use:

```blade
{{ $value }}
```

for untrusted text.

Avoid:

```blade
{!! $value !!}
```

unless the content has been explicitly sanitized and is intentionally HTML.

---

# AI Output Escaping

AI-generated text must be treated as untrusted content.

Never assume AI output is safe HTML.

---

# SEO

The Quote Wizard should use the existing global SEO architecture.

The landing page should have appropriate:

* Title.
* Description.
* Canonical URL.

Individual dynamic wizard steps generally do not need to be indexed.

---

# Search Engine Indexing

Dynamic quote sessions should not be indexed.

Appropriate SEO handling should prevent public quote session URLs from becoming search results.

---

# Breadcrumbs

Where the global design calls for breadcrumbs:

```text
Home
 →
Get a Quote
 →
Current Step
```

The current step should be represented accessibly.

---

# Accessibility Requirements

Verify:

✓ Semantic HTML.

✓ Correct heading hierarchy.

✓ Every input has a label.

✓ Error messages are associated with fields.

✓ Keyboard navigation works.

✓ Focus states are visible.

✓ Buttons have meaningful names.

✓ Color is not the only status indicator.

✓ AI loading state is announced appropriately.

✓ Dynamic content is accessible.

✓ Touch targets are sufficiently large.

---

# Focus Management

After navigation to a new step, focus should move to the main step heading where appropriate.

After validation failure, focus should move to the error summary or first invalid field.

After an AI response, the suggestion should be announced without unexpectedly moving the user's focus.

---

# Screen Reader Support

Dynamic UI states should use appropriate ARIA patterns.

For example:

```text
aria-live
```

may be used for:

* AI status.
* Submission status.
* Important validation feedback.

Do not add ARIA attributes unnecessarily.

---

# Browser Back Button

The wizard should behave predictably when users navigate backward using the browser.

Server-side state remains authoritative.

The application should avoid allowing stale browser pages to overwrite newer quote state unexpectedly.

---

# Duplicate Submission Protection

The frontend may disable the submit button during submission.

However:

**This is not a security mechanism.**

Server-side idempotency remains mandatory.

---

# Performance

Avoid unnecessary JavaScript.

The Quote Wizard should primarily rely on:

* Blade rendering.
* CSS.
* Alpine.js.

AI requests should only occur when explicitly requested.

---

# Asset Management

Use the existing Vite pipeline.

Do not introduce:

* Separate bundlers.
* Duplicate CSS frameworks.
* Large frontend dependencies.

---

# Testing

## Blade Tests

Verify:

✓ Correct question renders.

✓ Correct input type renders.

✓ Existing values appear.

✓ Validation errors appear.

✓ Navigation renders correctly.

✓ Review sections render.

✓ Consent renders.

---

# Accessibility Testing

Verify:

✓ Keyboard navigation.

✓ Focus states.

✓ Label associations.

✓ Error associations.

✓ Heading hierarchy.

✓ Screen-reader announcements.

---

# Responsive Testing

Verify:

✓ 320px+ mobile layouts.

✓ Tablet layouts.

✓ Desktop layouts.

✓ No horizontal scrolling caused by wizard components.

---

# JavaScript Testing

Verify:

✓ AI loading state.

✓ AI success state.

✓ AI failure state.

✓ Suggestion acceptance.

✓ Duplicate request prevention.

✓ Graceful degradation.

---

# Security Testing

Verify:

✓ User input is escaped.

✓ AI output is escaped.

✓ CSRF is present.

✓ Hidden fields are not trusted.

✓ Public quote IDs are used.

✓ Dynamic steps cannot be bypassed through URL manipulation.

---

# Success Criteria

The Blade architecture is successful when:

✓ Quote pages reuse global SMEvolve layouts.

✓ Questions render dynamically.

✓ Input types are componentized.

✓ Controllers provide prepared data.

✓ Blade contains no business logic.

✓ Alpine handles only frontend interaction.

✓ AI assistance is optional.

✓ User answers remain under user control.

✓ Review data is server-generated.

✓ Consent is explicit.

✓ Pages are accessible.

✓ Pages work responsively.

✓ JavaScript remains lightweight.

✓ The architecture supports future Quote Wizard enhancements.

---

# Stop Condition

This document defines the Blade and frontend presentation architecture.

It does not implement:

* Blade files.
* Alpine.js code.
* CSS implementation.
* Groq integration.
* Database migrations.
* Eloquent models.
* Admin Portal.
* Deployment.

Those will be implemented in subsequent phases.
