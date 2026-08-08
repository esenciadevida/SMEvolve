# SMEvolve Quote Wizard

## Part 20 – Laravel Service Layer & Business Logic Architecture

**Project:** SMEvolve

**Framework:** Laravel 12

**Frontend:** Blade, Vite, Alpine.js

**AI Provider:** Groq

**Module:** Quote Wizard

**Version:** 1.0

**Document Type:** Service Layer & Business Logic Specification

---

# Objective

Define the Laravel application service architecture responsible for the business logic of the SMEvolve Quote Wizard.

The service layer exists to ensure:

* Controllers remain lightweight.
* Business rules are centralized.
* Database operations are consistent.
* AI functionality remains isolated.
* Future Admin Portal integration is possible.
* The system remains maintainable as the Quote Wizard grows.

---

# Service Layer Principle

The application should follow:

```text
HTTP Request

        ↓

Controller

        ↓

Service Layer

        ↓

Models / External Services

        ↓

Database
```

Controllers coordinate.

Services decide.

Models represent data.

---

# Service Architecture

Recommended structure:

```
app/
└── Services/
    ├── Quote/
    │   ├── QuoteWizardService.php
    │   ├── QuoteSessionService.php
    │   ├── QuoteAnswerService.php
    │   ├── QuoteFlowService.php
    │   ├── QuoteRequirementService.php
    │   ├── QuoteReviewService.php
    │   ├── QuoteSubmissionService.php
    │   └── QuoteReferenceService.php
    │
    └── AI/
        ├── AIService.php
        ├── GroqService.php
        ├── QuoteContextBuilder.php
        └── QuotePromptBuilder.php
```

---

# Service Responsibilities

Each service must have one clear responsibility.

Avoid creating:

```text
God Service
```

where one class handles:

* Questions.
* AI.
* Submission.
* Emails.
* Pricing.
* Notifications.

---

# 1. QuoteWizardService

## Responsibility

Coordinates the wizard journey.

It controls:

* Starting the wizard.
* Loading steps.
* Moving forward.
* Moving backward.
* Determining available steps.

---

# Responsibilities

The service handles:

```
Create quote session
Get current step
Get next step
Get previous step
Check step accessibility
Resume quote
```

---

# Example Flow

```
User clicks Continue

        ↓

Controller

        ↓

QuoteWizardService

        ↓

Validate step

        ↓

Save answer

        ↓

Determine next question

        ↓

Return next step
```

---

# Methods

Suggested:

```php
start()

getStep()

getNextStep()

getPreviousStep()

canAccessStep()

completeStep()
```

---

# Service Rule

QuoteWizardService should not:

* Render Blade.
* Call Groq directly.
* Send emails.
* Generate final quotations.

---

# 2. QuoteSessionService

## Responsibility

Manages quote lifecycle.

---

# Responsibilities

Handles:

* Creating sessions.
* Finding sessions.
* Updating activity.
* Expiration.
* Status changes.

---

# Session Lifecycle

```
Created

↓

Draft

↓

Review

↓

Submitted

↓

Completed
```

---

# Methods

Suggested:

```php
create()

findByPublicId()

touch()

markReview()

markSubmitted()

expire()
```

---

# Session Security

The service must ensure:

* Public IDs are used externally.
* Internal IDs remain protected.
* Expired sessions cannot continue.

---

# 3. QuoteFlowService

## Responsibility

Controls dynamic question flow.

---

# Why Separate Flow Logic?

The Quote Wizard is not a simple form.

Different answers create different journeys.

Example:

```
Project Type

Mobile App

↓

Show:

Platforms

App Features

Distribution
```

But:

```
Website

↓

Show:

Pages

CMS

SEO
```

---

# Responsibilities

Handles:

* Conditional questions.
* Question availability.
* Step ordering.
* Dependency evaluation.

---

# Methods

Suggested:

```php
getAvailableSteps()

shouldShowQuestion()

getNextQuestion()

getPreviousQuestion()
```

---

# Flow Rules

Flow logic must exist server-side.

Never trust:

```javascript
if(selected === mobile)
```

as the only decision maker.

---

# 4. QuoteAnswerService

## Responsibility

Manages answers.

---

# Responsibilities

Handles:

* Saving answers.
* Updating answers.
* Normalizing values.
* Retrieving answers.

---

# Methods

Suggested:

```php
saveAnswer()

updateAnswer()

getAnswers()

validateAnswer()

removeInvalidDependentAnswers()
```

---

# Answer Processing

Example:

User selects:

```
Payments
Notifications
Accounts
```

Service stores:

```json
[
"payments",
"notifications",
"accounts"
]
```

---

# Validation

Before saving:

Verify:

* Question exists.
* Question is active.
* Answer type matches.
* Option belongs to question.

---

# 5. QuoteRequirementService

## Responsibility

Manages project requirements.

---

# Requirement Sources

Requirements can originate from:

```
User

AI

System
```

---

# Lifecycle

Example:

```
AI Suggestion

↓

User Reviews

↓

Accepted

↓

Confirmed Requirement
```

---

# Methods

Suggested:

```php
addRequirement()

suggestRequirement()

confirmRequirement()

removeRequirement()

getRequirements()
```

---

# Important Rule

AI suggestions are never automatically confirmed.

---

# Example

Incorrect:

```
AI suggests Payments

↓

Database:
confirmed
```

Correct:

```
AI suggests Payments

↓

Database:
suggested

↓

User accepts

↓

Database:
confirmed
```

---

# 6. QuoteReviewService

## Responsibility

Creates the review screen data.

---

# Responsibilities

Collect:

* Project information.
* Selected requirements.
* Timeline.
* Budget.
* Contact details.
* Consent state.

---

# Methods

Suggested:

```php
buildReview()

validateReviewReady()
```

---

# Review Source

The review must be generated from:

```
Database

NOT

Browser state
```

---

# Why?

Browser state can be:

* Modified.
* Missing.
* Invalid.

The server is authoritative.

---

# 7. QuoteSubmissionService

## Responsibility

Handles final quote submission.

This is one of the most important services.

---

# Responsibilities

Handles:

* Final validation.
* Transaction.
* Submission creation.
* Reference generation.
* Snapshot creation.
* Consent recording.
* Status updates.

---

# Submission Flow

```
Submit Button

↓

Validate

↓

BEGIN TRANSACTION

↓

Create Submission

↓

Generate Reference

↓

Save Consent

↓

Create Snapshot

↓

Mark Session Submitted

↓

COMMIT
```

---

# Transaction Requirement

Must use:

```php
DB::transaction()
```

---

# Failure Example

If:

```
Submission created

BUT

Consent failed
```

The entire operation must rollback.

---

# Duplicate Prevention

The service must check:

```
Does this session already have a submission?
```

before creating another.

---

# 8. QuoteReferenceService

## Responsibility

Generates public quote references.

---

# Example

```
SME-2026-000245
```

---

# Requirements

Reference must be:

* Unique.
* Human readable.
* Shareable.
* Non-sensitive.

---

# It Must Not Use:

```
Database ID only
```

Example:

```
Quote #1245
```

is not acceptable.

---

# Future Compatibility

The reference format may change later without affecting database relationships.

---

# 9. AIService

## Responsibility

Provides AI abstraction.

---

# The Application Talks To:

```
AIService
```

NOT:

```
GroqService
```

directly.

---

# Methods

Suggested:

```php
generate()

suggestFeatures()

improveDescription()

generateSummary()
```

---

# AI Flow

```
Controller

↓

AIService

↓

Prompt Builder

↓

Groq Provider

↓

Validator

↓

Response
```

---

# 10. GroqService

## Responsibility

Handles only provider communication.

---

# Responsibilities

Handles:

* Authentication.
* HTTP requests.
* Model selection.
* Timeout.
* Provider errors.

---

# It Must Not Know:

* Quote questions.
* Requirements.
* User workflow.
* Pricing.

---

# Example

Good:

```
GroqService
"Send this prompt"
```

Bad:

```
GroqService
"Generate mobile app requirements"
```

---

# 11. QuoteContextBuilder

## Responsibility

Creates safe AI context.

---

# Purpose

Prevent sending unnecessary information.

---

# Example Input

Database:

```
Name
Email
Phone
Description
Requirements
```

AI Context:

```json
{
"description":"Online booking platform",
"requirements":[
"payments",
"accounts"
]
}
```

---

# Excluded By Default

Do not send:

* Email.
* Phone.
* Personal details.
* Internal notes.
* Admin information.

---

# 12. QuotePromptBuilder

## Responsibility

Creates controlled AI prompts.

---

# Prompt Structure

```
System Rules

+

Operation Instructions

+

Project Context

+

User Input

+

Output Format
```

---

# Prompt Versioning

Every prompt must have:

Example:

```
feature_suggestion_v1
```

---

# Why?

Allows:

* Testing.
* Comparison.
* Auditing.
* Improvements.

---

# 13. Email/Event Preparation

The Quote Wizard should prepare for future integrations.

Example:

After submission:

```
QuoteSubmitted Event

↓

Email Listener

↓

Admin Notification
```

---

# The Submission Service Should Not:

* Send emails directly.
* Depend on mail provider availability.

---

# Domain Events

Recommended future events:

```
QuoteStarted

QuoteStepCompleted

QuoteSubmitted

QuoteAISuggestionAccepted
```

---

# 14. Error Handling

Services should throw meaningful application exceptions.

Examples:

```
QuoteExpiredException

InvalidStepException

SubmissionAlreadyExistsException

AIUnavailableException
```

---

# Do Not Throw Provider Errors Directly

Bad:

```
GroqTimeoutException
```

inside Quote logic.

Better:

```
AIUnavailableException
```

---

# 15. Database Transactions

Transactions required for:

## Submission

```
Create submission

+

Create consent

+

Update session
```

---

## Requirement Confirmation

```
Confirm requirement

+

Update source/status
```

---

# 16. Caching

Possible cache candidates:

* Question configuration.
* Requirement catalog.

Avoid caching:

* User answers.
* Contact information.
* Submission data.

---

# 17. Service Testing

Each service should have isolated tests.

---

# QuoteSessionService Tests

Verify:

✓ Session creation.

✓ Public ID generation.

✓ Expiration.

✓ Status changes.

---

# QuoteFlowService Tests

Verify:

✓ Correct next step.

✓ Conditional questions.

✓ Invalid step prevention.

---

# QuoteAnswerService Tests

Verify:

✓ Valid answers save.

✓ Invalid answers fail.

✓ Updates work.

---

# Requirement Tests

Verify:

✓ AI suggestions.

✓ User confirmation.

✓ Removal.

---

# Submission Tests

Verify:

✓ Transaction success.

✓ Rollback on failure.

✓ Duplicate prevention.

✓ Reference generation.

✓ Consent recording.

---

# AI Tests

Verify:

✓ Context building.

✓ Prompt versioning.

✓ Provider abstraction.

✓ Error handling.

---

# 18. Service Security Rules

Services must ensure:

✓ User input is validated.

✓ Browser state is not trusted.

✓ AI output is validated.

✓ Contact information is protected.

✓ Public identifiers are secure.

✓ Submission operations are transactional.

✓ Provider secrets remain hidden.

---

# 19. Performance Rules

Avoid:

* Loading unnecessary relationships.
* Calling AI unnecessarily.
* Recalculating static configuration.

Use:

* Eager loading.
* Caching where appropriate.
* Efficient queries.

---

# 20. Future Admin Portal Compatibility

The service layer should allow future Admin features:

```
View quote

Update status

Add internal notes

Send responses

Generate official quote
```

without rewriting Quote Wizard logic.

---

# Success Criteria

The service architecture is successful when:

✓ Controllers remain simple.

✓ Business rules are centralized.

✓ AI is isolated.

✓ Quote flow is flexible.

✓ Dynamic questions are supported.

✓ Requirements are controlled.

✓ Submission is reliable.

✓ Errors are handled consistently.

✓ Future Admin Portal integration is possible.

✓ The system remains maintainable as SMEvolve grows.

---

# Stop Condition

This document defines the Quote Wizard Laravel service architecture.

It does not implement:

* Service classes.
* Models.
* Migrations.
* Blade views.
* Alpine.js.
* Groq API integration.
* Tests.
* Admin Portal.

Those are handled in later implementation phases.
