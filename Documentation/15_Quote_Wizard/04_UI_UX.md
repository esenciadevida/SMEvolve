# SMEvolve Quote Wizard

## Part 04 – UI/UX Specification

**Project:** SMEvolve

**Module:** Quote Wizard

**Version:** 1.0

**Document Type:** UI/UX Design Specification

---

# Objective

Design a modern, professional, simple, and conversion-focused Quote Wizard for SMEvolve.

The interface should feel like a guided conversation rather than a long form.

The experience must be:

* Clean.
* Modern.
* Professional.
* Trustworthy.
* Easy to understand.
* Fast.
* Mobile-first.
* Accessible.
* Consistent with the SMEvolve Design System.

---

# Design Principles

The Quote Wizard should follow these principles:

## 1. One Decision at a Time

Avoid overwhelming users with large forms.

Present related information progressively.

---

## 2. Clear Progress

Users should always understand:

* Where they are.
* What they have completed.
* What remains.
* How to move forward.

---

## 3. Minimal Friction

Do not ask unnecessary questions.

Optional fields should clearly appear optional.

---

## 4. Trust

The interface should make users comfortable providing project and contact information.

Use:

* Clear explanations.
* Professional typography.
* Consistent spacing.
* Privacy messaging.
* Secure form behaviour.

---

## 5. User Control

Users must be able to:

* Go back.
* Edit answers.
* Skip optional questions.
* Review everything.
* Correct mistakes.

---

# Global Layout

The Quote Wizard should use the existing SMEvolve global layout where appropriate.

Recommended structure:

```text
┌─────────────────────────────────────────┐
│ SMEvolve Logo              Need Help?   │
├─────────────────────────────────────────┤
│                                         │
│             Progress                    │
│                                         │
│             Question                    │
│                                         │
│             Input                       │
│                                         │
│             Help / Context              │
│                                         │
│             Navigation                  │
│                                         │
└─────────────────────────────────────────┘
```

The design should avoid unnecessary navigation distractions.

---

# Header

The header should remain minimal.

Recommended:

```text
Logo
                         Need Help?
```

Depending on the global design system, the normal site navigation may be reduced or removed during the wizard.

---

# Exit Behaviour

Provide a clear way to return to the website.

Example:

```text
← Back to SMEvolve
```

If the user has entered significant information, leaving may trigger a lightweight confirmation.

Example:

```text
Leave this quote?

Your progress may be lost.

[Stay]
[Leave]
```

If draft persistence is implemented, the message should reflect that progress can be restored.

---

# Progress Indicator

The wizard should include a visible progress indicator.

Preferred pattern:

```text
Project
●────●────○────○────○
```

or:

```text
Step 3
Project Details
```

Avoid overly complicated progress diagrams.

---

# Dynamic Progress

Because conditional questions can change the number of steps, the progress system should not claim an inaccurate total.

For example:

```text
Step 4
Requirements
```

rather than:

```text
Step 4 of exactly 12
```

when the remaining flow is dynamic.

---

# Question Layout

Each step should generally contain:

```text
Question Heading

Short explanation

Input

Optional supporting text

Navigation
```

Example:

```text
What are you looking to build?

Choose the option that best describes your project.

[ Website                 ]
[ E-commerce              ]
[ Web Application         ]
[ Mobile Application      ]
[ Custom Software         ]
[ UI/UX Design            ]
[ Other                   ]

                         [Continue →]
```

---

# Question Heading

Question headings should be:

* Large enough to establish hierarchy.
* Short.
* Direct.
* Human-readable.

Avoid technical terminology.

---

# Supporting Text

Supporting descriptions should answer:

> Why am I being asked this?

without creating unnecessary text.

Example:

```text
Your budget helps our team understand the likely
scope of your project. It is not a final quotation.
```

---

# Input Controls

Use the appropriate control for each question.

Examples:

```text
Single choice → Cards / Radio buttons
Multiple choice → Checkboxes
Short answer → Text input
Long answer → Textarea
Email → Email input
Phone → Phone input
URL → URL input
Budget → Range selection
```

---

# Selection Cards

For major project types, use selectable cards.

Example:

```text
┌─────────────────────┐
│ 🌐                  │
│ Website             │
│                     │
│ Build a professional│
│ business website.   │
└─────────────────────┘
```

The selected state must be visually obvious.

---

# Selection States

Every selectable control should support:

```text
Default
Hover
Focus
Selected
Disabled
Error
```

---

# Selected State

The selected option should have:

* Strong visual distinction.
* Accessible state.
* Keyboard indication.
* Clear check/selection indicator.

Do not rely on colour alone.

---

# Multi-Select

For feature selection:

```text
☐ Customer Accounts
☐ Online Payments
☐ Booking
☐ Notifications
☐ Admin Dashboard
```

Users should be able to select multiple items.

---

# "Other" Option

Whenever an Other option is available:

```text
Other
```

selecting it should reveal:

```text
Please specify
[________________________]
```

---

# Text Input

Inputs should have:

* Visible label.
* Clear placeholder where helpful.
* Adequate height.
* Accessible focus state.
* Error state.

Avoid using placeholder text as the only label.

---

# Textarea

Use textarea for:

* Project descriptions.
* Additional requirements.
* Business descriptions.
* Existing application descriptions.

Provide an appropriate maximum length.

---

# Character Count

For long text fields, a character count may be shown.

Example:

```text
0 / 2,000
```

The counter should not distract from the question.

---

# Navigation

Every normal step should provide:

```text
Back
Continue
```

Recommended layout:

```text
← Back                    Continue →
```

On the first step:

```text
Back
```

may be replaced with:

```text
Exit
```

or omitted.

---

# Primary CTA

The primary button should use action-oriented language.

Examples:

```text
Continue
Review Quote
Submit Quote Request
```

Avoid:

```text
Next
Click Here
Submit
```

where a more descriptive label is possible.

---

# Button States

Buttons must support:

```text
Default
Hover
Focus
Pressed
Loading
Disabled
```

---

# Loading State

When processing an action:

```text
Submitting...
```

or:

```text
Saving...
```

The interface must prevent accidental duplicate submissions.

---

# Validation

Validation should occur as close as possible to the relevant input.

Example:

```text
Email address

[invalid-email]

Please enter a valid email address.
```

Do not wait until the final screen to reveal basic errors.

---

# Validation Summary

If multiple errors exist, provide a summary at the top.

Example:

```text
Please correct the following:

• Enter your email address
• Select a project type
```

Each error should link or move focus to the relevant field where appropriate.

---

# Error Design

Errors should be:

* Clear.
* Specific.
* Non-technical.
* Accessible.

Avoid:

```text
ValidationException: field.email.invalid
```

Use:

```text
Please enter a valid email address.
```

---

# AI UI

AI should feel like an assistant, not the primary controller of the wizard.

AI suggestions should appear as contextual assistance.

Example:

```text
┌────────────────────────────────────┐
│ ✦ Suggested Features               │
│                                    │
│ Based on your description, you may │
│ need:                              │
│                                    │
│ ✓ Customer accounts                │
│ ✓ Online payments                  │
│ ✓ Booking                          │
│                                    │
│ [Use Suggestions] [Review]         │
└────────────────────────────────────┘
```

---

# AI Suggestion Actions

AI suggestions should support:

```text
Accept
Edit
Reject
```

Never silently insert AI-generated information.

---

# AI Disclaimer

Where appropriate:

```text
AI suggestions are based on the information you've
provided. Please review them before continuing.
```

Keep the disclaimer concise.

---

# AI Loading State

When AI is processing:

```text
Understanding your project...
```

Avoid technical wording such as:

```text
Calling Groq API...
```

The provider name should not be exposed unnecessarily.

---

# AI Failure

If AI cannot respond:

```text
We couldn't provide suggestions right now.

You can continue manually.
```

CTA:

```text
Continue Manually
```

The wizard must remain usable.

---

# AI Conversation Integration

If the visitor arrives from the AI Assistant with information already collected, the wizard may display:

```text
We've already captured some information
about your project.

Please review it before continuing.
```

The user must be able to edit imported information.

---

# Imported AI Information

Imported information should not look identical to manually entered information if that distinction is important.

Possible subtle indicator:

```text
Suggested from your conversation
```

Avoid technical source labels in the main interface.

---

# Draft Persistence

If draft restoration is supported:

```text
Your progress has been saved.
```

This should be subtle and reassuring.

Do not constantly interrupt the user with save notifications.

---

# Mobile UX

Mobile is a primary design target.

Recommended structure:

```text
┌──────────────────────────┐
│ SMEvolve          3/8    │
│ ────────────────         │
│                          │
│ What are you building?   │
│                          │
│ [ Website ]              │
│ [ E-commerce ]           │
│ [ Mobile App ]           │
│ [ Web App ]              │
│                          │
│                          │
│ Continue                 │
└──────────────────────────┘
```

---

# Mobile Navigation

The primary CTA should remain easy to reach.

Avoid requiring users to scroll excessively to find:

```text
Continue
```

For long pages, consider a sticky bottom action area.

---

# Touch Targets

Interactive elements should have sufficiently large touch areas.

Avoid tiny checkboxes or links.

---

# Desktop UX

On larger screens, the wizard may use a centered content container.

Recommended:

```text
             ┌─────────────────────────┐
             │ Question                │
             │                         │
             │ Input                   │
             │                         │
             │                         │
             │ Back        Continue →  │
             └─────────────────────────┘
```

Do not stretch form content across the entire screen.

---

# Content Width

Legal and long-form content should not be used as the width reference.

The Quote Wizard should use a focused form width.

Recommended approximate range:

```text
560px – 760px
```

depending on the step.

---

# Desktop AI Layout

For AI-heavy steps, a secondary panel may be used.

Example:

```text
┌───────────────────────┬─────────────────────┐
│                       │                     │
│ Question / Form       │ AI Assistance       │
│                       │                     │
│                       │ Suggestions         │
│                       │                     │
└───────────────────────┴─────────────────────┘
```

This should only be used where it genuinely improves the experience.

---

# Review Screen

The review screen should present information in clear sections.

Example:

```text
PROJECT
E-commerce Website
                          Edit

BUSINESS
Fashion Retail
                          Edit

FEATURES
Payments
Customer Accounts
Delivery
                          Edit

TIMELINE
1–3 months
                          Edit

BUDGET
₦500,000 – ₦1,000,000
                          Edit

CONTACT
Samuel
email@example.com
07000000000
                          Edit
```

---

# Review Screen Requirements

Users must be able to:

* See all major information.
* Identify missing information.
* Edit answers.
* Understand that submission is a request, not a final contract.

---

# Consent Area

The final screen should include privacy consent.

Example:

```text
☐ I agree that SMEvolve may use the information I
provide to respond to my project enquiry.

Privacy Policy
```

Marketing consent must remain separate.

---

# Submit CTA

Recommended:

```text
Submit Quote Request
```

Supporting text:

```text
We'll review your information and get back to you
with the appropriate next step.
```

---

# Confirmation Screen

The confirmation screen should be positive but professional.

Example:

```text
✓

Quote Request Received

Thank you for sharing your project with SMEvolve.

Our team will review your request and contact you
using the details you provided.

Reference
SME-2026-001245

[Back to SMEvolve]
[Contact Us]
```

---

# Confirmation Design

Do not:

* Overload the screen.
* Promise a specific response time unless configured.
* Present an unapproved price.
* Suggest a contract has been created.

---

# Empty / Unavailable States

If a service configuration cannot be loaded:

```text
We're unable to start the quote process right now.

Please try again or contact us directly.
```

Provide a contact option using centralized SMEvolve contact settings.

---

# Network Error

Example:

```text
Something went wrong.

Please check your connection and try again.

[Try Again]
```

Entered data should remain available.

---

# Accessibility

The UI must support:

* Semantic HTML.
* Keyboard navigation.
* Focus management.
* Screen readers.
* Visible focus indicators.
* Accessible labels.
* Accessible error states.
* Accessible selected states.
* Reduced-motion preferences.

---

# Focus Management

When moving to a new step:

```text
Next
 ↓
New Step
 ↓
Focus Question Heading / First Relevant Input
```

When an error occurs:

```text
Validation
 ↓
Focus First Invalid Field
```

---

# Keyboard Navigation

Users should be able to complete the wizard without a mouse.

Expected flow:

```text
Tab
Shift + Tab
Enter
Space
Arrow Keys
```

where appropriate for controls.

---

# Reduced Motion

Animations should respect:

```text
prefers-reduced-motion
```

Avoid unnecessary transitions.

---

# Micro-Interactions

Use subtle interactions for:

* Selecting options.
* Completing a step.
* Showing AI suggestions.
* Saving progress.
* Submission.
* Confirmation.

Avoid excessive animation.

---

# Animation Principles

Animations should:

* Be quick.
* Communicate state.
* Never block interaction.
* Never hide important information.

---

# Typography

Use the existing SMEvolve Design System.

The Quote Wizard should not introduce an unrelated typography system.

Hierarchy should distinguish:

```text
Page / Wizard Title
Question
Description
Input Label
Helper Text
Error
Button
```

---

# Colour

Use SMEvolve's existing design tokens.

Do not introduce arbitrary colours.

Ensure sufficient contrast for:

* Text.
* Buttons.
* Borders.
* Errors.
* Selected states.
* Focus indicators.

---

# Icons

Icons should support the content rather than replace it.

Do not rely on icons alone to communicate meaning.

---

# Form Accessibility

Every input requires:

```text
Label
Input
Description if necessary
Error if applicable
```

Use appropriate ARIA relationships where required.

---

# Responsive Breakpoints

The implementation should follow the existing SMEvolve responsive system.

At minimum verify:

```text
Mobile
Tablet
Desktop
Large Desktop
```

---

# Browser Compatibility

The UI should work across modern:

* Chrome.
* Edge.
* Safari.
* Firefox.

---

# Conversion Principles

The Quote Wizard should reduce abandonment.

Important principles:

* Keep steps focused.
* Avoid unnecessary required fields.
* Make progress clear.
* Provide useful defaults where appropriate.
* Allow correction.
* Avoid surprising questions.
* Preserve information.
* Make submission reassuring.

---

# Do Not Use

Avoid:

```text
Huge forms
Tiny inputs
Unclear buttons
Hidden required fields
Technical AI terminology
Aggressive sales language
Fake urgency
Fake countdowns
Unnecessary popups
Unnecessary animations
```

---

# UI Component Structure

The implementation should support reusable components such as:

```text
components/
└── quote/
    ├── wizard.blade.php
    ├── progress.blade.php
    ├── question.blade.php
    ├── option-card.blade.php
    ├── text-field.blade.php
    ├── textarea.blade.php
    ├── navigation.blade.php
    ├── ai-suggestion.blade.php
    ├── review-section.blade.php
    ├── consent.blade.php
    └── confirmation.blade.php
```

Actual component names may follow the existing SMEvolve architecture.

---

# Design System Integration

The Quote Wizard must reuse:

* Buttons.
* Inputs.
* Typography.
* Spacing.
* Cards.
* Alerts.
* Icons.
* Colour tokens.
* Breakpoints.
* Focus styles.

Do not create a separate visual language.

---

# User Experience States

Every important component should consider:

```text
Default
Hover
Focus
Selected
Disabled
Loading
Success
Error
Empty
```

---

# Final UX Flow

```text
Start
 ↓
Question
 ↓
Answer
 ↓
Validation
 ↓
Next
 ↓
Conditional Questions
 ↓
AI Assistance if useful
 ↓
Review
 ↓
Consent
 ↓
Submit
 ↓
Confirmation
```

---

# Success Criteria

The UI/UX implementation is successful when:

✓ The wizard feels simple rather than form-heavy.

✓ Users understand what is being asked.

✓ Progress is visible.

✓ Conditional questions do not feel confusing.

✓ AI assistance is helpful but unobtrusive.

✓ Users can edit information.

✓ Errors are understandable.

✓ Mobile interaction is comfortable.

✓ Desktop layout remains focused.

✓ Accessibility requirements are met.

✓ Review and confirmation are clear.

✓ The interface uses the existing SMEvolve Design System.

---

# Stop Condition

This document defines the Quote Wizard visual and interaction experience.

It does not define:

* Pricing calculations.
* AI provider implementation.
* Database schema.
* API endpoints.
* Admin Portal.
* Email notifications.
* Security architecture.
* Final testing procedures.

Those are handled by subsequent Quote Wizard documentation.
