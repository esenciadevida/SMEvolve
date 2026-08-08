# SMEvolve Quote Wizard

## Part 10 – UI/UX Architecture

**Project:** SMEvolve

**Framework:** Laravel 12

**Frontend:** Blade, Vite, Alpine.js

**Module:** Quote Wizard

**Version:** 1.0

**Document Type:** UI/UX Architecture Specification

---

# Objective

Define the complete user experience and interface architecture for the SMEvolve Quote Wizard.

The Quote Wizard must make it easy for a potential client to explain what they need without requiring technical knowledge.

The experience should feel:

* Professional.
* Simple.
* Modern.
* Trustworthy.
* Conversational.
* Fast.
* Mobile-friendly.

The wizard must avoid feeling like a long traditional form.

---

# Core UX Principle

The Quote Wizard should feel like a guided consultation.

Instead of:

```text
Fill 30-field form
        ↓
Submit
```

the experience should be:

```text
Tell us about your idea
        ↓
Answer a few questions
        ↓
Get helpful suggestions
        ↓
Review your requirements
        ↓
Request your quote
```

---

# Primary User Goal

The user should be able to reach a completed quote request with minimal friction.

The interface should always make clear:

1. Where the user is.
2. What is being asked.
3. Why the information matters when necessary.
4. What happens next.
5. How much remains.
6. How to go back and edit information.

---

# Desktop Layout

Recommended structure:

```text
┌─────────────────────────────────────────────┐
│ SMEvolve Logo                    Help       │
├─────────────────────────────────────────────┤
│                                             │
│             Quote Progress                  │
│                                             │
│      ┌─────────────────────────────┐        │
│      │                             │        │
│      │       Question Area         │        │
│      │                             │        │
│      │       Answer Controls       │        │
│      │                             │        │
│      └─────────────────────────────┘        │
│                                             │
│       Back                    Continue      │
│                                             │
└─────────────────────────────────────────────┘
```

---

# Mobile Layout

The mobile experience must be first-class.

```text
┌─────────────────────┐
│ SMEvolve        ⋯   │
├─────────────────────┤
│ Step 2 of 7         │
│ ███████░░░░░         │
│                     │
│ Question            │
│                     │
│ Answer              │
│                     │
│                     │
│                     │
│ Continue            │
│ Back                │
└─────────────────────┘
```

---

# Wizard Container

The main wizard should use a constrained readable width.

Recommended:

```text
max-width:
720px – 860px
```

The exact value should follow the global SMEvolve design system.

The interface should not stretch excessively across large screens.

---

# Visual Hierarchy

Each screen should prioritize:

```text
Step indicator
      ↓
Question heading
      ↓
Short explanation
      ↓
Input
      ↓
Helpful guidance
      ↓
Navigation
```

---

# Header

The Quote Wizard header should be intentionally minimal.

Include:

* SMEvolve logo.
* Optional help/contact link.
* Optional exit/back-to-site action.

Avoid a full marketing navigation bar inside the wizard.

The purpose is to keep the user focused.

---

# Progress Indicator

The wizard must provide visible progress.

Example:

```text
Step 2 of 7

████████░░░░░░░
```

The indicator should communicate approximate progress rather than creating anxiety.

---

# Progress Labels

Where appropriate:

```text
1. Project
2. Requirements
3. Timeline
4. Budget
5. Contact
6. Review
```

On smaller screens, a compact indicator may be preferable.

---

# Back Navigation

A visible Back action should be available where appropriate.

Back navigation must:

* Preserve answers.
* Not unexpectedly reset the session.
* Return to the previous logical step.

---

# Continue Button

Primary CTA:

```text
Continue
```

Use more specific wording where useful.

Examples:

```text
Continue
See Requirements
Review Project
Get My Quote
```

The final CTA should clearly communicate submission.

---

# Question Architecture

Each question should have:

```text
Question
Optional explanation
Answer control
Optional example
Validation message
```

Avoid unnecessary descriptions.

---

# Question Length

Questions should be concise.

Prefer:

> What are you looking to build?

instead of:

> Please provide a detailed explanation of the particular type of digital product or solution that you are interested in developing.

---

# One Primary Decision

Each screen should generally focus on one major decision.

Avoid overwhelming users with many unrelated fields.

---

# Question Types

The wizard should support:

* Single choice.
* Multiple choice.
* Text input.
* Textarea.
* Number input.
* Currency/budget selection.
* Date/timeline selection.
* Email.
* Phone.
* Confirmation checkbox.

---

# Single Choice

Example:

```text
What would you like to build?

○ Website
○ E-commerce platform
○ Web application
○ Mobile application
○ Custom software
○ Not sure
```

Cards may be used where they improve comprehension.

---

# Multiple Choice

Example:

```text
What should your product include?

☐ User accounts
☐ Payments
☐ Booking
☐ Notifications
☐ Admin dashboard
☐ Not sure
```

Selections should have clear selected states.

---

# Text Input

Use text fields for concise information.

Example:

```text
What is the name of your business?

[________________________]
```

---

# Textarea

Use textareas for project descriptions.

Example:

```text
Tell us about your idea

[                                      ]
[                                      ]
[                                      ]
```

Provide a useful placeholder without putting essential instructions inside the field.

---

# Character Guidance

Where long responses are accepted, show an optional character limit.

Example:

```text
0 / 1,000
```

The limit should prevent abuse while allowing enough detail.

---

# AI Assistance

The AI should feel like an optional assistant, not a separate chatbot that interrupts the wizard.

Example:

```text
Need help describing your idea?

[ ✨ Help me explain it ]
```

When activated:

```text
AI suggestion:

"It sounds like you're looking to build
an online platform where customers can
browse products, create accounts and
make payments."

[Use this]   [Edit]   [Try again]
```

---

# AI Interaction Principle

The user remains in control.

AI suggestions must never silently replace user information.

Correct flow:

```text
AI Suggestion
     ↓
User Reviews
     ↓
User Accepts / Edits / Rejects
     ↓
Confirmed Answer
```

---

# AI Suggestion States

The interface should support:

```text
Idle
Loading
Suggestion Available
Accepted
Rejected
Error
```

---

# AI Loading State

Use a subtle loading state.

Example:

```text
✨ Thinking about that...
```

Avoid unnecessary technical information.

Do not display:

```text
Calling Groq API...
Model: ...
Token count...
```

---

# AI Error State

If AI fails:

```text
We couldn't generate a suggestion right now.

You can continue manually.
```

The user must never be blocked because AI is unavailable.

---

# AI Trust Indicator

Where appropriate, include a subtle message:

> AI suggestions are optional. You can edit them before continuing.

This reinforces user control.

---

# AI Suggested Features

If AI identifies likely features:

```text
Based on your idea, you may need:

✓ Customer accounts
✓ Online payments
✓ Order tracking
✓ Admin dashboard

[Add selected]
```

The user should be able to individually select suggestions.

---

# Conditional Questions

The wizard should dynamically adapt.

Example:

```text
User chooses:

Mobile App

↓

Next questions:

Platform
iOS / Android / Both

↓

Additional:

Login
Payments
Notifications
```

The user should not see irrelevant questions.

---

# Dynamic Flow

Conceptually:

```text
Project Type
      ↓
Requirements
      ↓
System Determines Relevant Questions
      ↓
Additional Questions
      ↓
Timeline
      ↓
Budget
      ↓
Contact
```

---

# "Not Sure" Option

Where appropriate, provide:

```text
Not sure
```

Users should never be forced to invent technical information.

This is especially important for:

* Features.
* Integrations.
* Technology.
* Platform choices.
* Budget.

---

# Technical Terminology

Avoid technical language unless necessary.

Instead of:

> Do you require OAuth authentication?

Prefer:

> Should users be able to sign in with Google or other accounts?

---

# Help Text

Help text should answer:

> Why are you asking me this?

Only show it when the question may otherwise be confusing.

---

# Examples

Examples can be used inside questions.

Example:

```text
Tell us about your project

For example:
"I want an online platform where customers
can book cleaning services."
```

Examples should disappear or remain visually secondary once the user starts typing.

---

# Validation

Validation should happen at the appropriate moment.

Do not aggressively show errors while the user is still typing.

Preferred:

```text
User clicks Continue
        ↓
Validate
        ↓
Show relevant error
```

---

# Validation Message

Use clear language.

Bad:

```text
Invalid input.
```

Better:

```text
Please enter your email address.
```

---

# Error Placement

Place the error close to the relevant input.

Example:

```text
Email address

[abc]

Please enter a valid email address.
```

---

# Error Summary

For screens with several fields, an accessible error summary may appear near the top.

---

# Required Fields

Avoid marking every field as required unnecessarily.

Only require information needed to progress or submit.

---

# Timeline

The timeline question should be easy to understand.

Example:

```text
When would you like to start?

○ As soon as possible
○ Within 1 month
○ 1–3 months
○ 3–6 months
○ More than 6 months
○ Not sure
```

---

# Budget

Budget must not feel like a judgment.

Example:

```text
What is your estimated budget?

○ Under ₦500,000
○ ₦500,000 – ₦1,000,000
○ ₦1,000,000 – ₦3,000,000
○ ₦3,000,000+
○ I'm not sure yet
```

The final ranges should be configurable.

---

# Contact Information

Contact should appear toward the end of the journey.

Example:

```text
Where should we send your quote?

Full name
[________________]

Email
[________________]

Phone
[________________]
```

---

# Contact Explanation

Use a short explanation:

> We'll use these details to follow up on your request and discuss the next steps.

Avoid lengthy legal language.

---

# Consent

Where required:

```text
☐ I agree to the Terms & Conditions and
   acknowledge the Privacy Policy.
```

Links should open the relevant legal pages without losing the quote session.

---

# Review Screen

Before submission, provide a complete summary.

Example:

```text
Review your project

PROJECT
E-commerce platform
Edit

DESCRIPTION
Online fashion store
Edit

FEATURES
Customer accounts
Payments
Order tracking
Edit

TIMELINE
1–3 months
Edit

BUDGET
₦500,000 – ₦1,000,000
Edit

CONTACT
Samuel Ogundare
Edit
```

---

# Edit Actions

Every major section should have:

```text
Edit
```

The user should be returned to the appropriate step without losing other information.

---

# Final CTA

The final button should be explicit.

Preferred:

```text
Request My Quote
```

Alternative:

```text
Submit Quote Request
```

Avoid vague:

```text
Submit
```

---

# Submission Loading State

After clicking the final CTA:

```text
Submitting your request...
```

Disable duplicate submission.

---

# Confirmation Page

After successful submission:

```text
✓ Request received

Thank you. We've received your project
details.

Reference:
SME-2026-001245

We'll review your request and contact you
with the next steps.

[Return to SMEvolve]
```

---

# Quote Reference

The reference should be prominently displayed but should not act as authentication.

---

# Confirmation Actions

Potential actions:

```text
Return Home
Contact SMEvolve
```

Do not overwhelm the confirmation page.

---

# Session Recovery

Where supported, the user should be able to resume an unfinished quote.

The experience should make this seamless without exposing session tokens unnecessarily.

---

# Exit Experience

If the user attempts to leave during an unfinished quote, the system may warn them that progress could be lost.

However, if autosave/session persistence exists, avoid unnecessary warning dialogs.

---

# Mobile UX

The mobile interface must support:

* Large touch targets.
* Sticky or easily accessible navigation.
* No horizontal scrolling.
* Readable text.
* Full-width inputs.
* Comfortable spacing.
* Keyboard-friendly forms.

---

# Touch Targets

Interactive elements should be large enough for comfortable touch interaction.

Follow the global SMEvolve accessibility standards.

---

# Mobile Keyboard

Input types should use appropriate mobile keyboards.

Examples:

```text
email → email keyboard
tel → phone keyboard
number → numeric keyboard
```

---

# Mobile Navigation

The primary Continue action should remain easy to reach.

A sticky bottom action area may be used if it does not obstruct content.

---

# Responsive Breakpoints

Follow the global SMEvolve design system rather than creating unrelated breakpoint values.

The wizard should work across:

```text
Mobile
Tablet
Desktop
Large Desktop
```

---

# Accessibility

The Quote Wizard must support:

* Keyboard navigation.
* Visible focus states.
* Semantic labels.
* Screen-reader announcements.
* Proper heading hierarchy.
* Accessible error messages.
* Accessible progress indicators.
* Sufficient contrast.
* Reduced-motion support.

---

# Focus Management

When moving between wizard steps:

```text
New Step
   ↓
Focus moves to appropriate heading/question
```

Do not leave keyboard users at an unexpected location.

---

# Screen Reader Feedback

Dynamic events should be announced where appropriate.

Examples:

```text
Step changed.
AI suggestion available.
Answer saved.
Validation error.
Submission successful.
```

Use appropriate ARIA mechanisms without overusing ARIA.

---

# Reduced Motion

Animations must respect the user's reduced-motion preference.

Avoid excessive transitions.

---

# Animation

Animations should be subtle.

Appropriate:

```text
Step transition
Progress update
AI suggestion appearance
Selection state
```

Avoid:

* Large page movements.
* Distracting effects.
* Long animations.

---

# Loading States

Every asynchronous action should have a clear state.

Examples:

```text
Saving...
Thinking...
Submitting...
```

---

# Offline / Network Failure

If the network fails while saving:

```text
We couldn't save that answer.
Please check your connection and try again.
```

Previously saved answers should remain available where possible.

---

# Unsaved State

If an answer cannot be saved, do not falsely show:

```text
Saved
```

The interface must communicate the actual state.

---

# Design System Integration

The Quote Wizard must reuse SMEvolve's:

* Typography.
* Colors.
* Buttons.
* Inputs.
* Cards.
* Spacing.
* Icons.
* Focus states.
* Form styles.

Do not create an unrelated visual language.

---

# Components

Potential reusable components:

```text
components/
└── quote/
    ├── wizard.blade.php
    ├── progress.blade.php
    ├── question.blade.php
    ├── option-card.blade.php
    ├── text-input.blade.php
    ├── textarea.blade.php
    ├── ai-assistant.blade.php
    ├── validation.blade.php
    ├── review-section.blade.php
    └── confirmation.blade.php
```

The exact component structure should follow the existing SMEvolve frontend architecture.

---

# Alpine.js Responsibilities

Alpine.js may handle lightweight client-side interactions such as:

* Step transitions.
* Selection states.
* Modal states.
* AI loading states.
* UI feedback.
* Form interaction.

Do not move business rules into Alpine.js.

---

# Laravel Responsibilities

Laravel remains responsible for:

* Validation.
* Question eligibility.
* Session state.
* Business logic.
* AI requests.
* Security.
* Data persistence.
* Submission.

---

# JavaScript Principle

The Quote Wizard should remain functional with minimal JavaScript.

JavaScript should enhance the experience rather than contain the entire application.

---

# Performance

Avoid:

* Large JavaScript bundles.
* Unnecessary dependencies.
* Heavy animations.
* Repeated API calls.
* Duplicate AI requests.

---

# AI Performance

AI should not automatically execute on every field change.

Prefer explicit actions such as:

```text
Help me explain this
Suggest features
Improve my description
```

This reduces:

* Latency.
* Cost.
* Unnecessary requests.

---

# User Journey

Complete intended experience:

```text
Landing
   ↓
Start Quote
   ↓
Project Type
   ↓
Project Description
   ↓
Requirements
   ↓
AI Assistance
   ↓
Conditional Questions
   ↓
Timeline
   ↓
Budget
   ↓
Contact
   ↓
Review
   ↓
Consent
   ↓
Request My Quote
   ↓
Confirmation
```

---

# UX Principles

The Quote Wizard must:

1. Ask only useful questions.
2. Avoid unnecessary technical language.
3. Keep users informed of progress.
4. Allow users to correct answers.
5. Keep AI optional.
6. Never let AI silently modify user information.
7. Preserve progress.
8. Work well on mobile.
9. Remain accessible.
10. Make the final action obvious.

---

# Testing Requirements

## Desktop

✓ Large screen.

✓ Standard laptop.

✓ Tablet landscape.

---

## Mobile

✓ Small phone.

✓ Large phone.

✓ Portrait.

✓ Landscape.

---

## Forms

✓ Keyboard navigation.

✓ Validation.

✓ Error recovery.

✓ Long text.

✓ Multiple selections.

✓ Conditional questions.

---

## AI

✓ Loading state.

✓ Suggestion state.

✓ Accept.

✓ Reject.

✓ Edit.

✓ Failure fallback.

---

## Submission

✓ Review.

✓ Edit.

✓ Consent.

✓ Submission loading.

✓ Duplicate-click protection.

✓ Confirmation.

---

# Success Criteria

The UI/UX architecture is successful when:

✓ Users understand what the wizard is asking.

✓ The experience does not feel like a traditional long form.

✓ Users can complete the process comfortably on mobile.

✓ Progress is always understandable.

✓ Conditional questions reduce unnecessary form fields.

✓ AI helps users without taking control.

✓ Users can review and edit everything before submission.

✓ Validation is clear and accessible.

✓ The final CTA is obvious.

✓ AI failure does not block the user.

✓ The experience follows the SMEvolve design system.

✓ The wizard remains fast and lightweight.

✓ Accessibility is built into the experience rather than added afterward.

---

# Stop Condition

This document defines the Quote Wizard UI/UX architecture.

It does not implement:

* Blade components.
* Alpine.js.
* CSS.
* Routes.
* Controllers.
* Database migrations.
* Groq integration.
* Admin Portal.

Those will be handled by the subsequent implementation documents.
