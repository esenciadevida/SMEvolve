# SMEvolve Quote Wizard

## Part 17 – UI/UX & Alpine.js Interaction Architecture

**Project:** SMEvolve

**Framework:** Laravel 12

**Frontend:** Blade, Vite, Alpine.js

**AI Provider:** Groq

**Module:** Quote Wizard

**Version:** 1.0

**Document Type:** UI/UX & Interaction Architecture Specification

---

# Objective

Define the complete user interface and interaction architecture for the SMEvolve Quote Wizard.

The Quote Wizard should feel:

* Simple.
* Professional.
* Modern.
* Fast.
* Guided.
* Trustworthy.
* Human-friendly.

The experience must work equally well on:

* Mobile.
* Tablet.
* Desktop.

---

# UX Principle

The user should feel that they are having a guided conversation rather than filling out a long form.

The experience should therefore use:

```text
One clear question
        ↓
Simple answer
        ↓
Next relevant question
        ↓
Progress
        ↓
Review
        ↓
Submit
```

---

# Primary CTA

The Quote Wizard is accessed through:

> Get a Quote

The CTA should be consistently available from relevant SMEvolve website locations.

---

# Entry Experience

When the user clicks:

> Get a Quote

display a short introduction.

Example:

> Let's understand what you're looking to build.

Supporting text:

> Answer a few questions about your project. You don't need to know any technical terms.

Primary button:

> Start Your Quote

Secondary option:

> Back to Website

---

# Wizard Shell

The main wizard should use a dedicated layout.

Conceptually:

```text
┌─────────────────────────────────────────┐
│ SMEvolve                                │
│                                         │
│ Progress                                │
│ ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━           │
│                                         │
│ Question                                │
│                                         │
│ Answer                                  │
│                                         │
│                         Continue →      │
└─────────────────────────────────────────┘
```

---

# Desktop Layout

Desktop should use a centered content container.

Recommended structure:

```text
┌──────────────────────────────────────────────────┐
│                 SMEvolve                         │
│                                                  │
│       ┌──────────────────────────────────┐       │
│       │ Progress                         │       │
│       │                                  │       │
│       │ Question                         │       │
│       │                                  │       │
│       │ Answer controls                  │       │
│       │                                  │       │
│       │ Back              Continue       │       │
│       └──────────────────────────────────┘       │
│                                                  │
└──────────────────────────────────────────────────┘
```

---

# Mobile Layout

Mobile should prioritize the question and answer.

```text
┌──────────────────────────┐
│ SMEvolve                 │
│                          │
│ Step 2 of 8              │
│ ━━━━━━━━━━━━━            │
│                          │
│ What are you building?   │
│                          │
│ [ Website             ]  │
│ [ Mobile App          ]  │
│ [ Web App             ]  │
│                          │
│ [ Continue             ] │
└──────────────────────────┘
```

---

# Progress Indicator

The wizard should show progress.

Example:

> Step 3 of 8

and a visual progress bar.

The progress indicator should represent the logical journey rather than simply counting every conditional question.

---

# Progress Calculation

Conditional questions should not cause confusing progress jumps.

Example:

If a user selects Website:

```text
Step 1 of 7
Step 2 of 7
Step 3 of 7
```

If another user selects Mobile App and receives one additional relevant step, the system may adapt the total logically.

The user should never see unexplained changes such as:

```text
Step 3 of 8
↓
Step 4 of 12
```

---

# Question Layout

Each question should contain:

```text
Question
Supporting explanation
Answer control
Optional AI assistance
Validation message
Navigation
```

---

# Question Heading

Use a clear heading.

Example:

> What would you like to build?

Avoid technical language.

---

# Supporting Text

Use short explanations only where they improve understanding.

Example:

> Choose the option that best describes your project.

---

# Answer Cards

For common choices, use cards.

Example:

```text
┌─────────────────────────┐
│ 🌐                      │
│ Website                 │
│ A website for your      │
│ business or service.    │
└─────────────────────────┘
```

---

# Card Interaction

Cards should:

* Be keyboard accessible.
* Have visible focus states.
* Show selected state.
* Have sufficient touch area.
* Avoid excessive animation.

---

# Single Selection

For single-choice questions:

```text
Click card
   ↓
Selected
   ↓
Continue
```

The system should not automatically advance unless the UX intentionally calls for it.

The default behavior should use an explicit Continue action to reduce accidental selections.

---

# Multiple Selection

For multi-choice questions:

```text
☐ Payments
☐ Notifications
☐ User Accounts
☐ Analytics
```

The user selects multiple options and continues.

---

# Text Input

Use text inputs for short answers.

Example:

> What is your name?

---

# Textarea

Use textarea for:

* Project description.
* Additional information.
* Business context.

---

# Input Placeholder

Use examples rather than generic placeholder text.

Example:

> I want an online platform where customers can book cleaning services.

---

# Placeholder Principle

Placeholder text must never be the only field label.

Inputs must have accessible labels.

---

# Required Fields

Required fields should be clearly identified.

Avoid excessive required fields.

---

# Optional Fields

Use:

> Optional

where useful.

Do not make users guess whether a field is required.

---

# Validation

Validation should happen:

* Immediately where helpful.
* On Continue.
* Again on the server.

---

# Validation Messages

Messages should be human-friendly.

Bad:

> The project_type field is required.

Better:

> Please choose a project type.

---

# Error Position

Display the error close to the relevant field.

For a question with multiple cards, display the message directly beneath the question.

---

# Navigation

Primary controls:

```text
Back
Continue
```

---

# Button Hierarchy

Primary:

> Continue

Secondary:

> Back

Final:

> Request My Quote

---

# Back Button

Back should:

* Return to the previous relevant step.
* Preserve answers.
* Not reset the session.
* Not trigger unnecessary AI calls.

---

# Continue Button

Continue should:

1. Validate the current answer.
2. Save it.
3. Determine the next relevant question.
4. Transition to the next step.

---

# Loading State

During server requests:

```text
Continue
```

becomes:

```text
Saving...
```

The button should be disabled during submission.

---

# Double-Click Protection

Prevent multiple simultaneous requests.

Example:

```text
Continue
   ↓
Saving...
   ↓
Disabled
```

---

# Alpine.js Responsibility

Alpine.js should handle lightweight interaction.

Examples:

* Current UI state.
* Selected cards.
* Loading states.
* Expand/collapse.
* AI suggestion visibility.
* Progress transitions.
* Client-side interaction.

---

# Alpine.js Must Not Own Business Logic

Do not place critical business rules only in Alpine.js.

For example:

Incorrect:

```text
if projectType === 'mobile'
    allow submission
```

The server must independently validate this.

---

# Alpine Component

The wizard may use a component such as:

```text
quoteWizard
```

Possible state:

```text
currentStep
answers
loading
error
aiLoading
aiSuggestion
```

Only state necessary for the UI should be stored client-side.

---

# Sensitive Data in Alpine

Do not unnecessarily expose:

* Internal quote information.
* AI credentials.
* Administrative data.
* Private server metadata.

---

# AI Interaction

AI assistance should appear contextually.

Example:

```text
Need help explaining your idea?

[ ✨ Help me explain it ]
```

---

# AI Button

The AI button should not dominate the primary workflow.

Primary:

> Continue

Secondary:

> ✨ Help me explain this

The user should be able to complete the entire wizard without AI.

---

# AI Loading

When AI is processing:

```text
✨ Preparing a suggestion...
```

The AI button should become temporarily disabled.

---

# AI Suggestion Card

Example:

```text
┌──────────────────────────────────────┐
│ ✨ AI suggestion                     │
│                                      │
│ I want to build an online booking    │
│ platform for cleaning services.      │
│                                      │
│ [Use Suggestion] [Keep Original]     │
└──────────────────────────────────────┘
```

---

# AI Suggestion Rules

The suggestion must never silently replace user content.

Actions:

```text
Use Suggestion
Keep Original
Dismiss
```

---

# Feature Suggestions

AI feature suggestions should use selectable cards.

Example:

```text
✨ Suggested features

[ ] Customer Accounts
    Customers can manage bookings.

[ ] Notifications
    Customers can receive booking reminders.

[ ] Payments
    Customers can pay online.
```

---

# AI Suggestion Confirmation

The user explicitly selects:

> Add

The backend then stores the requirement as:

```text
confirmed
```

---

# AI Errors

If AI fails:

```text
We couldn't generate a suggestion right now.

You can continue without AI.
```

Do not block the user.

---

# Question Transitions

Transitions should be subtle.

Recommended:

```text
fade
slide
```

Avoid excessive animation.

---

# Transition Requirements

Transitions must:

* Be fast.
* Not delay the workflow.
* Respect reduced-motion preferences.

---

# Reduced Motion

Respect:

```text
prefers-reduced-motion
```

Users who prefer reduced motion should not receive unnecessary animated transitions.

---

# Step Completion

After saving an answer, the next question should appear quickly.

Avoid unnecessary confirmation screens between every step.

---

# Session Saving

Answers should be persisted progressively.

Example:

```text
Answer
 ↓
Save
 ↓
Next Question
```

This reduces the risk of losing progress.

---

# Save Indicator

Where appropriate:

```text
Saved
```

may be shown subtly.

Do not make the user wait for a visible "Saved" confirmation before continuing if the request has already completed successfully.

---

# Network Failure

If saving fails:

```text
We couldn't save that answer.
Please try again.
```

The current input should remain available.

---

# Offline Behavior

Full offline functionality is not required.

However, the frontend should avoid unnecessarily destroying unsaved input when a network request fails.

---

# Session Recovery

When the user returns:

```text
Continue your quote
```

where supported by the session architecture.

---

# Review Screen

The review screen is the final major step before submission.

---

# Review Layout

```text
Your Project

Project
Website

Description
Online platform for...

Requirements
• Booking
• Payments
• Notifications

Timeline
1–3 months

Budget
₦1,000,000 – ₦3,000,000

Contact
Samuel
email@example.com

[Edit] [Request My Quote]
```

---

# Review Sections

Use cards or grouped sections.

Recommended:

```text
Project
Requirements
Business
Timeline
Budget
Additional Information
Contact
```

---

# Edit Actions

Every section should have:

> Edit

Selecting Edit returns the user to the relevant step.

---

# Review Accuracy

The review page must be generated from server-confirmed data.

Do not rely exclusively on browser state.

---

# Consent

Before submission:

```text
☐ I agree to the Terms & Conditions and acknowledge the Privacy Policy.
```

Links should open appropriately without destroying wizard progress.

---

# Consent UX

The checkbox must be:

* Keyboard accessible.
* Clearly labelled.
* Easy to interact with.
* Required before submission.

---

# Submission CTA

Use:

> Request My Quote

Avoid:

> Submit Form

The CTA should communicate the purpose of the action.

---

# Submission Loading

After clicking:

> Request My Quote

show:

```text
Sending your request...
```

Disable the button.

Prevent duplicate submissions.

---

# Submission Success

The confirmation screen should be positive but professional.

Example:

> Your quote request has been received.

Supporting text:

> Thank you for sharing your project with SMEvolve. Our team will review your requirements and get back to you.

Reference:

> Quote Reference: SME-2026-001245

---

# Confirmation CTA

Possible:

```text
Back to SMEvolve
```

or:

```text
Return to Website
```

---

# Do Not Overpromise

Avoid:

> We'll get back to you within 30 minutes.

unless SMEvolve has formally established that service-level commitment.

---

# Mobile UX

The wizard must be designed mobile-first.

---

# Mobile Requirements

✓ Large touch targets.

✓ Comfortable text size.

✓ Minimal horizontal scrolling.

✓ Cards stack vertically.

✓ Buttons remain easy to reach.

✓ Inputs use appropriate mobile keyboard types.

---

# Mobile Keyboard

Use appropriate input types.

Email:

```text
type="email"
```

Phone:

```text
type="tel"
```

URL:

```text
type="url"
```

---

# Mobile Navigation

Do not place important buttons where browser UI or keyboard interaction makes them difficult to reach.

---

# Sticky Navigation

A sticky bottom action bar may be used on mobile if it improves usability.

Example:

```text
┌──────────────────────────┐
│ Back       Continue →    │
└──────────────────────────┘
```

It must not obscure content or keyboard input.

---

# Tablet

Tablet layouts should use the desktop structure with appropriate spacing.

---

# Desktop

Desktop should take advantage of larger screen space without making the form unnecessarily wide.

---

# Typography

The Quote Wizard should reuse SMEvolve's design system.

Do not introduce a separate typography system.

---

# Colors

Use existing SMEvolve design tokens.

Do not hardcode arbitrary colors in the Quote Wizard.

---

# Components

Reuse global components where available.

Potential Quote Wizard components:

```text
quote/
├── shell.blade.php
├── progress.blade.php
├── question.blade.php
├── option-card.blade.php
├── text-input.blade.php
├── textarea.blade.php
├── ai-assistant.blade.php
├── ai-suggestion.blade.php
├── navigation.blade.php
├── review.blade.php
├── consent.blade.php
└── confirmation.blade.php
```

The final implementation should reuse existing components whenever possible.

---

# Accessibility

The wizard must support:

* Keyboard navigation.
* Screen readers.
* Visible focus states.
* Semantic HTML.
* Accessible form labels.
* Accessible error messages.
* Proper heading hierarchy.
* Sufficient contrast.
* Reduced motion.

---

# Choice Cards Accessibility

Choice cards should use appropriate semantic controls.

Do not create clickable `<div>` elements that behave like buttons without proper accessibility.

---

# Keyboard Navigation

Users should be able to:

```text
Tab
Shift + Tab
Space
Enter
Arrow keys
```

where appropriate for the control type.

---

# Focus Management

When moving between steps, focus should move to the new question heading or first appropriate interactive element.

This is especially important for screen-reader users.

---

# Error Focus

When validation fails, focus should move to the first relevant error.

---

# Screen Reader Announcements

Dynamic state changes such as:

```text
Saving...
AI suggestion ready
Quote submitted
```

should be announced appropriately where necessary.

Use accessible live regions carefully.

---

# Browser Back Button

The Quote Wizard should have a predictable relationship with browser navigation.

The preferred behavior is to avoid losing saved answers.

If browser history integration is implemented, it must not create confusing duplicate states.

---

# Refresh

Refreshing an active step should not destroy saved answers.

The server should be able to reconstruct the current session.

---

# Leaving the Wizard

If the user tries to leave with unsaved information, a browser confirmation may be considered.

Do not show unnecessary browser prompts when all data is already saved.

---

# Error Page

If the quote session cannot be loaded:

> We couldn't find that quote session.

Provide:

> Start a New Quote

---

# 404 Behavior

Invalid quote tokens should not expose whether another valid session exists.

Use a generic response.

---

# 429 Behavior

If rate limited:

> You're moving a little too quickly. Please wait a moment and try again.

Do not expose internal rate-limit information.

---

# Visual Hierarchy

Every screen should prioritize:

```text
1. Question
2. Answer
3. Help
4. Navigation
```

Do not allow decorative elements to compete with the question.

---

# Empty States

Where no optional data exists, do not show empty sections.

Example:

Avoid:

```text
Additional Information
None
```

unless useful.

---

# Error States

Errors should be:

* Clear.
* Localized to the relevant action.
* Recoverable.
* Non-technical.

---

# Success States

Success messages should confirm the user's action.

Avoid exaggerated animations or unnecessary celebration.

---

# Analytics Integration

The UI may emit global analytics events such as:

```text
quote_started
quote_step_viewed
quote_step_completed
quote_ai_used
quote_review_viewed
quote_submitted
```

Do not send:

* Email.
* Phone.
* Full free-text descriptions.

as analytics properties unless explicitly approved.

---

# Performance

The UI should minimize JavaScript.

Alpine.js should be used for interaction rather than a large SPA framework.

---

# Progressive Enhancement

Where practical, the core Quote Wizard should remain understandable even if JavaScript fails.

Critical business operations must remain server-side.

---

# Alpine.js State Boundaries

Alpine should manage:

```text
Selection state
Loading state
UI visibility
Transitions
AI suggestion display
```

Laravel should manage:

```text
Validation
Persistence
Conditional rules
Authorization
AI calls
Submission
```

---

# UI Security

Never trust:

```text
x-data
x-model
hidden fields
JavaScript state
```

for authoritative information.

The backend must validate all submitted values.

---

# UI Testing

## Desktop

Test:

* Chrome.
* Edge.
* Firefox.
* Safari where applicable.

---

## Mobile

Test:

* iOS Safari.
* Android Chrome.

---

## Accessibility

Test:

* Keyboard-only navigation.
* Screen reader.
* Focus management.
* Reduced motion.
* Zoom.

---

# UI Success Criteria

The Quote Wizard UI is successful when:

✓ Users understand each question.

✓ The interface does not feel like a long form.

✓ Progress is clear.

✓ Relevant questions appear dynamically.

✓ AI assistance is optional.

✓ AI suggestions are clearly labelled.

✓ Users can edit answers.

✓ Answers persist between steps.

✓ Validation is clear.

✓ Submission cannot be duplicated accidentally.

✓ Mobile experience is excellent.

✓ Accessibility requirements are satisfied.

✓ The interface uses SMEvolve's existing design system.

✓ JavaScript remains lightweight.

✓ The wizard remains usable without AI.

---

# Stop Condition

This document defines the Quote Wizard UI/UX and Alpine.js interaction architecture.

It does not implement:

* Blade components.
* Alpine.js code.
* CSS.
* Routes.
* Controllers.
* Groq integration.
* Database migrations.
* Automated tests.
* Admin Portal.

Those will be handled by subsequent implementation documents.
