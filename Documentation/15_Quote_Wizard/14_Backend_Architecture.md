# SMEvolve Quote Wizard

## Part 14 – Backend Architecture

**Project:** SMEvolve

**Framework:** Laravel 12

**Frontend:** Blade, Vite, Alpine.js

**AI Provider:** Groq

**Module:** Quote Wizard

**Version:** 1.0

**Document Type:** Backend Architecture Specification

---

# Objective

Define the backend architecture required to operate the SMEvolve Quote Wizard.

The backend must provide:

* Quote session management.
* Wizard navigation.
* Answer persistence.
* Conditional question handling.
* Server-side validation.
* AI integration.
* Requirement management.
* Consent handling.
* Quote submission.
* Reference generation.
* Security.
* Future Admin Portal compatibility.

The backend must remain independent from the presentation layer.

---

# Core Architecture

```text
Browser
   ↓
Routes
   ↓
Controllers
   ↓
Form Requests / Validation
   ↓
Domain / Services
   ↓
Models
   ↓
Database
```

AI requests follow:

```text
Controller
   ↓
AI Service
   ↓
Prompt Builder
   ↓
Groq Service
   ↓
Response Validator
   ↓
Structured Result
```

---

# Backend Principles

The implementation must:

1. Keep controllers lightweight.
2. Keep business logic outside Blade.
3. Keep AI logic outside controllers.
4. Validate all user input server-side.
5. Never trust browser-provided wizard state.
6. Protect quote sessions from unauthorized access.
7. Keep public and administrative functionality separate.
8. Use Laravel conventions wherever possible.

---

# Suggested Backend Structure

The exact structure should follow the existing SMEvolve architecture.

Suggested:

```text
app/
├── Http/
│   ├── Controllers/
│   │   └── Quote/
│   │       └── QuoteWizardController.php
│   │
│   └── Requests/
│       └── Quote/
│           ├── SaveAnswerRequest.php
│           ├── AIRequest.php
│           └── SubmitQuoteRequest.php
│
├── Models/
│   ├── QuoteSession.php
│   ├── QuoteAnswer.php
│   ├── QuoteRequirement.php
│   ├── AIInteraction.php
│   ├── QuoteConsent.php
│   ├── QuoteSubmission.php
│   └── QuoteContact.php
│
└── Services/
    ├── Quote/
    │   ├── QuoteWizardService.php
    │   ├── QuoteSessionService.php
    │   ├── QuoteAnswerService.php
    │   ├── QuoteRequirementService.php
    │   └── QuoteSubmissionService.php
    │
    └── AI/
        ├── AIService.php
        ├── GroqService.php
        ├── PromptBuilder.php
        └── ResponseValidator.php
```

The actual structure should be adapted to the project's existing architecture.

---

# Routes

The Quote Wizard should use dedicated named routes.

Suggested public routes:

```text
GET  /quote
POST /quote/session
GET  /quote/{token}
POST /quote/{token}/answer
POST /quote/{token}/ai
POST /quote/{token}/requirement
POST /quote/{token}/review
POST /quote/{token}/submit
GET  /quote/{token}/confirmation
```

Exact URLs may be adjusted to match the existing SMEvolve routing conventions.

---

# Named Routes

Recommended names:

```text
quote.index
quote.start
quote.show
quote.answer
quote.ai
quote.requirement
quote.review
quote.submit
quote.confirmation
```

---

# Route Principle

Routes should express user actions.

Avoid exposing internal implementation details.

For example:

Good:

```text
/quote/{token}/submit
```

Avoid:

```text
/api/internal/create-quote-submission
```

for the public wizard unless the global API architecture requires it.

---

# Quote Wizard Controller

Suggested:

```text
QuoteWizardController
```

Responsibilities:

* Display wizard.
* Start session.
* Display current step.
* Save answer.
* Request approved AI operation.
* Confirm requirements.
* Display review.
* Submit quote.
* Display confirmation.

The controller must not contain:

* Prompt construction.
* Groq API calls.
* Complex question dependency logic.
* Pricing logic.

---

# Controller Example Responsibilities

Conceptually:

```text
start()
show()
saveAnswer()
ai()
confirmRequirement()
review()
submit()
confirmation()
```

---

# Session Creation

When the user clicks:

```text
Get a Quote
```

the backend creates a Quote Session.

Initial state:

```text
status = draft
current_step = 1
```

---

# Public Token

A cryptographically secure public token should be generated.

Example:

```text
public_token
```

Do not expose the internal database ID.

---

# Session Ownership

The system must determine that the current browser/session is authorized to access the quote session.

Possible mechanisms include:

* Server session binding.
* Signed URLs.
* Secure quote token.
* Combination of session and token.

The final implementation should use the strongest approach consistent with the existing application.

---

# Token Security

Quote tokens must:

* Be sufficiently random.
* Not be sequential.
* Not reveal internal database IDs.
* Be difficult to guess.
* Never contain personal information.

---

# Session Recovery

If a user returns to an active quote session, the system should restore:

* Current step.
* Answers.
* Requirements.
* Relevant progress.

---

# Expired Sessions

If the session has expired:

```text
Quote session expired.
```

The user should be given a way to start a new quote.

Do not expose the old data unnecessarily.

---

# Step Resolution

The backend should determine the next valid step based on the user's answers.

Example:

```text
Project Type
    ↓
Mobile App
    ↓
Show Mobile Platform
```

Where:

```text
Project Type
    ↓
Website
    ↓
Skip Mobile Platform
```

---

# Conditional Logic

Conditional logic must be server-authoritative.

The browser may hide questions for UX purposes, but the backend must independently validate whether a question is valid for the current session.

---

# Example

If a user manually sends:

```text
mobile_platform = android
```

while:

```text
project_type = website
```

the backend must reject or ignore the invalid answer.

---

# Question Configuration

The backend should retrieve questions from the Quote Wizard content configuration.

Example:

```text
config/quote.php
```

or the project's established content architecture.

---

# Question Service

A dedicated service may determine:

```text
availableQuestions()
currentQuestion()
nextQuestion()
previousQuestion()
isQuestionVisible()
```

This keeps conditional logic out of controllers.

---

# Answer Service

Suggested:

```text
QuoteAnswerService
```

Responsibilities:

* Validate question key.
* Validate answer type.
* Save answer.
* Update existing answer.
* Determine source.
* Trigger relevant state changes.

---

# Answer Update

If a user changes an answer:

```text
Old answer
   ↓
New answer
```

The latest confirmed user answer should become authoritative.

---

# Dependent Answers

When a parent answer changes, dependent answers may become invalid.

Example:

```text
Project Type:
Mobile App
```

causes:

```text
Mobile Platform
```

to appear.

If the user later changes:

```text
Mobile App
```

to:

```text
Website
```

the backend should reassess whether mobile-specific answers remain valid.

---

# Invalidated Data

Do not silently present obsolete answers as active requirements.

The system may:

* Remove them.
* Mark them inactive.
* Recalculate the session.

The selected approach should preserve data integrity.

---

# Server-Side Validation

Every answer must be validated on the server.

Validation should consider:

```text
Field type
Required status
Allowed values
Maximum length
Business rules
Conditional visibility
```

---

# Validation Example

For project type:

```text
Allowed:
website
ecommerce
web_app
mobile_app
custom_software
automation
ui_ux
other
not_sure
```

Anything else must be rejected.

---

# Free-Text Validation

Text fields must have:

* Maximum length.
* Appropriate encoding handling.
* Abuse protection.
* Required/optional validation.

---

# URL Validation

Existing website fields must use proper URL validation.

---

# Email Validation

Contact email must be validated server-side.

---

# Phone Validation

Phone numbers should be normalized and validated using the application's supported format strategy.

---

# Request Classes

Use Laravel Form Requests where appropriate.

Suggested:

```text
SaveAnswerRequest
AIRequest
SubmitQuoteRequest
```

---

# AI Endpoint

The AI endpoint must only accept approved operations.

Example:

```json
{
    "operation": "feature_suggestions"
}
```

The backend determines what information is supplied to the AI.

The browser must not construct the AI prompt.

---

# AI Operation Whitelist

Allowed:

```text
description_assistance
feature_suggestions
clarification
project_analysis
project_summary
```

Any unsupported operation should return a safe validation error.

---

# AI Context Builder

Create a dedicated component/service responsible for assembling AI context.

Example:

```text
QuoteContextBuilder
```

It may collect:

* Project type.
* Confirmed description.
* Confirmed requirements.
* Relevant answers.

It must exclude unnecessary personal information.

---

# AI Request Flow

```text
User
 ↓
POST /quote/{token}/ai
 ↓
Validate operation
 ↓
Validate quote session
 ↓
Build context
 ↓
Build prompt
 ↓
Call AIService
 ↓
GroqService
 ↓
Validate response
 ↓
Store AI interaction
 ↓
Return structured result
```

---

# AI Service

The controller should call:

```text
AIService
```

rather than:

```text
GroqService
```

directly.

---

# Provider Abstraction

Example:

```text
AIService
    ↓
Provider Resolver
    ↓
GroqService
```

This keeps the application provider-independent.

---

# Groq Service

`GroqService` is responsible for:

* API authentication.
* Request formatting.
* Model selection.
* Timeout handling.
* Response retrieval.
* Provider-level error handling.

It must not contain Quote Wizard business logic.

---

# Prompt Builder

The prompt builder creates the final AI request.

It should use:

```text
System Instructions
+
Task
+
Quote Context
+
User Data
+
Output Schema
```

---

# AI Response Validation

Never trust the AI response directly.

Process:

```text
Raw Response
 ↓
Parse
 ↓
Validate Structure
 ↓
Validate Values
 ↓
Sanitize
 ↓
Return
```

---

# AI Response Failure

If invalid:

```text
AI response could not be processed.
```

Do not expose raw provider errors.

---

# AI Retry

A limited retry may be implemented for temporary provider errors.

Retries should not occur for invalid user input.

---

# AI Rate Limiting

AI endpoints must be rate-limited.

Potential key:

```text
User/session/IP
```

The exact strategy should follow global SMEvolve security policies.

---

# AI Abuse Protection

Prevent:

* Excessive requests.
* Huge input payloads.
* Automated repeated requests.
* Prompt abuse.
* Endpoint scraping.

---

# Requirement Service

Suggested:

```text
QuoteRequirementService
```

Responsibilities:

* Add user-selected requirement.
* Add AI suggestion as suggestion.
* Confirm requirement.
* Remove requirement.
* Prevent duplicate requirements.

---

# Requirement Confirmation

AI suggestion:

```text
status = suggested
```

User accepts:

```text
status = confirmed
```

---

# Requirement Removal

If rejected:

```text
status = removed
```

The system must ensure removed suggestions cannot accidentally appear as confirmed requirements.

---

# Review Service

Before submission, the backend should build a canonical quote summary.

Example:

```text
QuoteSummary
```

It should contain:

* Project type.
* Description.
* Requirements.
* Business context.
* Timeline.
* Budget.
* Additional information.
* Contact details.

The summary should be generated from stored data rather than trusting a client-provided summary.

---

# Submission Validation

When submitting:

```text
1. Verify session.
2. Verify required answers.
3. Verify conditional requirements.
4. Verify contact details.
5. Verify consent.
6. Verify session isn't already submitted.
7. Create submission.
8. Create contact.
9. Finalize state.
```

---

# Submission Transaction

Use a database transaction.

Conceptually:

```text
BEGIN
 ↓
Validate
 ↓
Create Quote Submission
 ↓
Create Contact
 ↓
Record Consent
 ↓
Finalize Requirements
 ↓
Update Quote Session
 ↓
COMMIT
```

---

# Duplicate Submission Protection

If a user clicks the submit button multiple times:

```text
Request 1 → Accepted
Request 2 → Existing submission returned
```

Do not create multiple submissions.

---

# Reference Generation

The backend generates the public reference.

Example:

```text
SME-2026-001245
```

The reference must be unique.

---

# Reference Generation Rules

The reference:

* Must not expose database IDs directly.
* Must be unique.
* Must be readable.
* Must be suitable for email communication.

---

# Confirmation

After successful submission:

```text
Quote Submission
       ↓
Reference Generated
       ↓
Confirmation Page
```

The confirmation page should not expose sensitive internal information.

---

# Email Integration

The Quote Wizard may trigger the global notification system after successful submission.

Potential notifications:

```text
Client confirmation
Admin notification
```

If the project already has a notification architecture, reuse it.

Do not build a separate email framework.

---

# Admin Notification

The future Admin Portal should receive:

```text
New quote request
Reference
Project type
Client name
Submission date
```

Avoid sending unnecessary sensitive information in notifications.

---

# Client Confirmation

The user may receive:

> Your quote request has been received.

Include:

* Reference number.
* General next steps.
* Contact information where appropriate.

---

# Logging

Log operational events such as:

```text
Quote started
AI request failed
Quote submitted
```

Logs must not contain:

* API keys.
* Passwords.
* Full sensitive payloads unnecessarily.
* Raw AI prompts containing unnecessary personal data.

---

# Error Handling

Use Laravel's exception handling architecture.

User-facing errors should be friendly.

Internal logs should contain enough technical information for debugging without exposing sensitive data.

---

# HTTP Responses

For standard page requests:

```text
HTTP 200
HTTP 302
HTTP 422
HTTP 404
HTTP 419
HTTP 429
HTTP 500
```

Use appropriate Laravel conventions.

---

# AJAX / Alpine Requests

For AI and interactive operations, structured JSON responses may be used.

Example success:

```json
{
    "success": true,
    "data": {}
}
```

Example error:

```json
{
    "success": false,
    "message": "We couldn't process that request right now."
}
```

Never expose stack traces to the browser.

---

# CSRF Protection

All state-changing browser requests must use Laravel CSRF protection.

This includes:

* Saving answers.
* AI requests.
* Requirement changes.
* Submission.

---

# Authorization

The public Quote Wizard does not require traditional user authentication.

However, access to a quote session must still be authorized through the session/token mechanism.

---

# Admin Separation

The public Quote Wizard must not provide routes that allow:

```text
Change quote status
Edit internal notes
Assign quote
Approve pricing
View other submissions
```

Those belong to the Admin Portal.

---

# Mass Assignment Protection

Models must use safe Laravel mass-assignment practices.

Do not blindly accept arbitrary request fields.

---

# Input Sanitization

Free-text input should be safely handled.

The system must prevent:

* Script injection.
* Unsafe HTML.
* Malicious payloads.

---

# Output Escaping

Quote content displayed in Blade must be escaped by default.

Do not render user-provided content as raw HTML.

---

# File Uploads

File uploads are not part of the initial Quote Wizard unless explicitly introduced later.

If added later, they require separate:

* Validation.
* Storage.
* Malware scanning.
* Access control.
* Retention rules.

---

# Database Transactions

Use transactions around multi-record operations.

Especially:

```text
Final submission
Requirement confirmation where multiple records change
```

---

# Queue Usage

AI requests may initially be synchronous if response times are acceptable.

However, the architecture should allow future queue-based processing for:

* AI analysis.
* Email notifications.
* Administrative notifications.

Do not introduce queues unnecessarily into the interactive user flow if they make the UX worse.

---

# Caching

Cache static Quote Wizard configuration where useful.

Examples:

```text
Question definitions
Feature definitions
Budget ranges
```

Do not cache private quote answers globally.

---

# Performance

Backend should avoid:

* N+1 queries.
* Repeated session lookups.
* Unnecessary AI calls.
* Large database payloads.

Use eager loading where appropriate.

---

# Security Boundaries

The backend must enforce:

```text
Browser
   ↓
Public Quote Permissions
   ↓
Quote Session
```

and separately:

```text
Admin Portal
   ↓
Admin Authentication
   ↓
Administrative Permissions
```

These must never be mixed.

---

# Backend Testing

## Routes

✓ Quote start.

✓ Quote session.

✓ Save answer.

✓ AI endpoint.

✓ Requirement endpoint.

✓ Review.

✓ Submission.

✓ Confirmation.

---

# Session Tests

✓ Session creation.

✓ Valid token.

✓ Invalid token.

✓ Expired token.

✓ Unauthorized session access.

---

# Validation Tests

✓ Required fields.

✓ Invalid choices.

✓ Invalid conditional answers.

✓ Invalid email.

✓ Invalid phone.

✓ Excessive text.

---

# AI Tests

✓ Valid operation.

✓ Invalid operation.

✓ Successful Groq request.

✓ Timeout.

✓ Rate limit.

✓ Invalid AI response.

✓ Provider failure.

✓ Prompt injection attempt.

---

# Submission Tests

✓ Complete submission.

✓ Missing answer.

✓ Missing consent.

✓ Duplicate submission.

✓ Transaction rollback.

✓ Reference generation.

---

# Security Tests

✓ CSRF.

✓ Session authorization.

✓ Mass assignment.

✓ Input validation.

✓ Output escaping.

✓ Rate limiting.

✓ Secret protection.

---

# Backend Success Criteria

The architecture is successful when:

✓ Controllers remain lightweight.

✓ Business logic is service-based.

✓ Questions are configuration-driven.

✓ Conditional logic is server-authoritative.

✓ All user input is validated.

✓ Quote sessions are protected.

✓ Groq is isolated behind an AI service.

✓ AI operations are whitelisted.

✓ AI responses are validated.

✓ AI failure does not break the wizard.

✓ Requirements distinguish AI suggestions from confirmed requirements.

✓ Submission is transactional.

✓ Duplicate submissions are prevented.

✓ Contact data is protected.

✓ Public and Admin functionality remain separate.

✓ The architecture can support the future Admin Portal.

---

# Stop Condition

This document defines the Quote Wizard backend architecture.

It does not implement:

* Laravel routes.
* Controllers.
* Form Requests.
* Eloquent models.
* Database migrations.
* Groq API code.
* Blade templates.
* Alpine.js.
* Admin Portal.
* Deployment.

Those will be handled by the implementation phase.
