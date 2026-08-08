# SMEvolve Quote Wizard

## Part 08 – API Architecture

**Project:** SMEvolve

**Framework:** Laravel 12

**Frontend:** Blade, Vite, Alpine.js

**Module:** Quote Wizard

**Version:** 1.0

**Document Type:** API Architecture Specification

---

# Objective

Define the backend API architecture required by the SMEvolve Quote Wizard.

The API layer must provide a secure and maintainable interface between:

```text
Quote Wizard Frontend
        ↓
Laravel Backend
        ↓
Quote Services
        ↓
Database
        ↓
AI Service
```

The architecture must support:

* Quote sessions.
* Step progression.
* Answer storage.
* Conditional questions.
* AI assistance.
* Quote submission.
* Validation.
* Future Admin Portal integration.

---

# Core Principle

The frontend must never directly control business-critical operations.

The browser may request an operation.

Laravel must:

```text
Validate
 ↓
Authorize
 ↓
Process
 ↓
Store
 ↓
Respond
```

---

# API Architecture

Recommended:

```text
Browser
   │
   ├── GET Quote Wizard
   │
   ├── POST/PUT Answers
   │
   ├── POST AI Assistance
   │
   └── POST Submission
   │
   ▼
Laravel
   │
   ├── Validation
   ├── Quote Services
   ├── AI Services
   └── Database
```

---

# Route Location

Public Quote Wizard routes should follow Laravel conventions.

Possible route files:

```text
routes/
├── web.php
└── api.php
```

The implementation should use `web.php` for normal Blade wizard navigation where possible and dedicated API endpoints only where asynchronous functionality requires them.

---

# Route Naming

Use descriptive named routes.

Examples:

```text id="k8p4ms"
quote.index
quote.start
quote.step
quote.answer
quote.ai
quote.review
quote.submit
quote.confirmation
```

Actual naming should follow the project's existing route conventions.

---

# Public Wizard Routes

Recommended:

```text id="z6v3qa"
GET /quote
```

Starts or resumes the Quote Wizard.

---

# Start Session

```text id="q3m8vx"
POST /quote/start
```

Purpose:

Create a new quote session.

---

# Start Response

Example:

```json id="m8x2la"
{
  "success": true,
  "session": {
    "token": "secure-session-token",
    "current_step": "project_type"
  }
}
```

The actual response must not expose internal database IDs unnecessarily.

---

# Session Retrieval

Where resume functionality is supported:

```text id="p7v4cn"
GET /quote/session/{token}
```

The endpoint must verify that the requester is authorized to access the session.

A session token must not be sufficient to expose another user's information if additional security controls are required.

---

# Step Endpoint

The frontend may request the current step configuration.

Example:

```text id="n6b2xz"
GET /quote/session/{token}/step
```

Response:

```json id="j4r8kp"
{
  "step": "project_details",
  "questions": []
}
```

---

# Question Configuration

The server should determine which questions are available.

The frontend should not independently decide which conditional questions are valid.

Example:

```text id="g2w7vd"
Server:
project_type = ecommerce

↓

Available Questions:
product_count
payment_provider
delivery_method
```

---

# Answer Submission

Recommended:

```text id="r5k9mx"
POST /quote/session/{token}/answers
```

Purpose:

Save one or more answers.

---

# Answer Request

Example:

```json id="y8q3vn"
{
  "answers": {
    "project_type": "ecommerce",
    "project_description": "I want an online fashion store."
  }
}
```

---

# Answer Response

Example:

```json id="h5c7zr"
{
  "success": true,
  "saved": [
    "project_type",
    "project_description"
  ],
  "next_step": "requirements"
}
```

---

# Validation

Every answer must be validated server-side.

Frontend validation improves UX but is not sufficient for security or data integrity.

---

# Validation Rules

Validation should consider:

* Required fields.
* Data type.
* Maximum length.
* Allowed options.
* Conditional requirements.
* Format.
* Business rules.

---

# Allowed Options

The server must validate selections against approved configuration.

Example:

```text id="b8f4mw"
project_type:
website
ecommerce
web_application
mobile_application
custom_software
ui_ux
other
```

A client must not be able to submit arbitrary values simply by modifying browser requests.

---

# Conditional Validation

If:

```text id="z7q3la"
project_type = ecommerce
```

the server may require or allow:

```text id="x1c6pq"
payment_requirements
product_information
delivery_requirements
```

The exact requirements depend on the question configuration.

---

# Navigation Validation

The server should prevent users from bypassing required steps through direct requests.

Example:

```text id="m4k8yx"
User attempts:
POST /quote/submit

without required contact information.
```

Laravel must reject the submission with a useful validation response.

---

# AI Endpoint

Where interactive AI assistance is required:

```text id="s2v6nb"
POST /quote/session/{token}/ai
```

---

# AI Request

Example:

```json id="q8n3dc"
{
  "operation": "feature_suggestions"
}
```

The backend determines the appropriate prompt and context.

The browser must not submit its own system prompt.

---

# AI Context

Laravel constructs the AI context from trusted stored data.

Conceptually:

```text id="u7m1vp"
Stored Quote Answers
       +
Approved AI Prompt
       +
Operation
       ↓
AI Service
       ↓
Groq
```

---

# AI Response

Example:

```json id="x9q2lm"
{
  "success": true,
  "suggestions": [
    {
      "key": "customer_accounts",
      "label": "Customer Accounts"
    },
    {
      "key": "online_payments",
      "label": "Online Payments"
    }
  ]
}
```

---

# AI Response Validation

The backend must validate the Groq response before returning it to the browser.

Invalid AI output must not be passed directly to the frontend.

---

# AI Rate Limiting

AI endpoints must be rate-limited.

Example:

```text id="v4p8sx"
Maximum:
Configurable requests per session
```

The exact limit should be defined in implementation/security documentation.

---

# AI Error Response

If AI fails:

```json id="t2k6mr"
{
  "success": false,
  "fallback": true,
  "message": "AI assistance is temporarily unavailable."
}
```

The frontend should allow the user to continue manually.

---

# AI Security

The endpoint must never return:

* API keys.
* Provider credentials.
* Internal prompts.
* Internal pricing rules.
* Admin information.
* Debug stack traces.

---

# Review Endpoint

Optional endpoint:

```text id="n5x8qb"
GET /quote/session/{token}/review
```

This returns only information the user is allowed to review.

---

# Review Data

Example:

```json id="g7r2yc"
{
  "project": {
    "type": "ecommerce",
    "description": "Online fashion store"
  },
  "requirements": [
    "customer_accounts",
    "online_payments"
  ],
  "timeline": "1-3_months",
  "budget": "500000-1000000"
}
```

---

# User Edit During Review

The user should be able to update an answer.

Example:

```text id="f6m9vz"
PATCH /quote/session/{token}/answers
```

or use the existing answer endpoint.

Avoid unnecessary duplicate endpoints if one clean answer-update mechanism is sufficient.

---

# Submission Endpoint

Final submission:

```text id="r8c3wl"
POST /quote/session/{token}/submit
```

---

# Submission Requirements

Before submission, Laravel must:

1. Validate the session.
2. Validate all required answers.
3. Validate contact information.
4. Validate consent.
5. Confirm session is not already submitted.
6. Create the quote request.
7. Generate quote reference.
8. Mark session submitted.
9. Dispatch post-submission processing.
10. Return confirmation.

---

# Submission Request

Example:

```json id="k7w4nx"
{
  "consent": true
}
```

The server should retrieve the remaining quote information from the session rather than trusting the browser to resend everything.

---

# Submission Response

Example:

```json id="z4m8qp"
{
  "success": true,
  "quote_reference": "SME-2026-001245",
  "status": "new"
}
```

---

# Duplicate Submission Protection

A submitted session must not be submitted again.

Example:

```text id="p5x7vr"
Session:
submitted

↓

Second request

↓

Rejected safely
```

---

# Idempotency

Where appropriate, final submission should use an idempotency mechanism to protect against network retries and duplicate requests.

---

# HTTP Status Codes

Use appropriate HTTP status codes.

Examples:

```text id="c8v2lm"
200
Successful request

201
Resource created

400
Malformed request

401
Unauthenticated where applicable

403
Forbidden

404
Resource not found

409
Conflict / duplicate submission

422
Validation failure

429
Rate limited

500
Unexpected server error

503
Temporary service unavailable
```

---

# Validation Response

Example:

```json id="n3q8wb"
{
  "message": "Please correct the highlighted fields.",
  "errors": {
    "email": [
      "Please enter a valid email address."
    ]
  }
}
```

The response should use Laravel's standard validation conventions where appropriate.

---

# Error Response Standard

API errors should have a consistent structure.

Example:

```json id="v6m2qa"
{
  "success": false,
  "message": "Unable to process your request.",
  "code": "QUOTE_PROCESSING_ERROR"
}
```

Do not expose internal exceptions.

---

# Debug Information

Detailed exception information must only be available through appropriate server-side logging and development tooling.

Never return:

```text id="j7q4xs"
Stack traces
SQL queries
API keys
Environment variables
```

to public users.

---

# Session Security

Quote session tokens must be:

* Random.
* Unpredictable.
* Non-sequential.
* Expirable where appropriate.

---

# Session Ownership

If the wizard uses browser/session-based authentication, associate the quote session with the appropriate session context.

If anonymous quote requests are supported, use additional protections against session-token enumeration.

---

# CSRF

For browser-based state-changing requests using Laravel's web stack, use Laravel's CSRF protection.

The implementation must follow the project's established Laravel security configuration.

---

# CORS

Do not enable broad CORS permissions unnecessarily.

If the Quote Wizard is served from the same SMEvolve application, cross-origin API access should not be required.

---

# Mass Assignment

Laravel models must use appropriate:

```text id="f4m9xy"
fillable
guarded
```

configuration.

Do not blindly assign request payloads to models.

---

# Request Classes

Use dedicated Laravel Form Request classes where appropriate.

Suggested:

```text id="h8x2vr"
app/
└── Http/
    └── Requests/
        └── Quote/
            ├── StartQuoteRequest.php
            ├── SaveQuoteAnswersRequest.php
            └── SubmitQuoteRequest.php
```

Exact organization should follow existing project architecture.

---

# Controllers

Controllers should remain lightweight.

Suggested:

```text id="p3k7mv"
QuoteController
QuoteSessionController
QuoteAiController
```

The exact controller separation should follow SMEvolve conventions.

---

# Service Layer

Business logic should not be placed inside controllers.

Suggested:

```text id="z5r1qx"
app/
└── Services/
    └── Quote/
        ├── QuoteSessionService.php
        ├── QuoteAnswerService.php
        ├── QuoteAssessmentService.php
        └── QuoteSubmissionService.php
```

---

# AI Service

AI calls should be isolated:

```text id="a7x4nm"
app/
└── Services/
    └── AI/
        ├── AIService.php
        └── GroqService.php
```

---

# Queue Processing

Post-submission AI analysis should preferably use Laravel queues.

Conceptually:

```text id="m8v2zc"
Quote Submission
      ↓
Queue Job
      ↓
AI Analysis
      ↓
Store Result
```

Suggested job:

```text id="k3q9pl"
ProcessQuoteAIAnalysis
```

---

# Queue Failure

Failed jobs should not invalidate the submitted quote.

Laravel's failed-job handling should be used where appropriate.

---

# Notifications

Quote submission may eventually trigger:

```text id="b5n7cx"
Admin Notification
Customer Confirmation
```

However, notification implementation is outside this API architecture unless already supported globally.

---

# Admin API

The Admin Portal will later require authenticated endpoints.

Example future structure:

```text id="q4m8zy"
GET    /admin/quotes
GET    /admin/quotes/{id}
PATCH  /admin/quotes/{id}
POST   /admin/quotes/{id}/status
```

These are placeholders for the future Admin Portal specification.

Do not implement them as part of the public Quote Wizard.

---

# Public vs Admin Boundary

Public endpoints:

```text id="x9c5mr"
Start Quote
Save Answers
AI Assistance
Review
Submit
```

Admin endpoints:

```text id="j6v3pq"
View Quote
Change Status
Add Notes
Override Assessment
Manage Quote
```

The two areas must remain clearly separated.

---

# Data Exposure

Public API responses must not expose:

```text id="e2m8vz"
scope_score
qualification_score
internal_priority
admin_notes
AI confidence
internal pricing
AI prompt versions
provider configuration
```

unless explicitly required by the user-facing experience.

---

# API Versioning

The initial implementation may use:

```text id="m7q2xc"
/api/...
```

or another architecture already established by SMEvolve.

If a formal API versioning strategy exists, follow it.

Avoid adding versioning solely for appearance.

---

# Content Type

JSON API endpoints should use:

```text id="r3x7vn"
application/json
```

where applicable.

---

# Request Size Limits

Limit request payload sizes.

This protects against:

* Abuse.
* Oversized descriptions.
* Memory consumption.
* Unexpected AI costs.

---

# Input Limits

Examples:

```text id="k5v9pd"
Project description:
Maximum configurable length

Additional requirements:
Maximum configurable length

AI request:
Maximum configurable size
```

---

# AI Input Protection

The backend should construct AI prompts from validated stored values.

Do not allow users to directly submit:

```text id="p8x2la"
system_prompt
model
provider
temperature
```

unless these are explicitly controlled backend configuration values.

---

# AI Model Selection

The frontend must not choose the Groq model.

The backend determines the model using configuration.

---

# AI Operation Selection

The frontend may request:

```text id="v3m8qx"
operation = feature_suggestions
```

but the backend must validate the operation against an approved whitelist.

---

# Logging

API operations should log useful operational information.

Example:

```text id="c6n9wr"
request ID
endpoint
status
latency
quote session
error type
```

Do not log unnecessary sensitive data.

---

# Monitoring

The architecture should allow monitoring of:

* API failures.
* AI failures.
* Submission failures.
* Response times.
* Rate limits.
* Queue failures.

---

# Performance

The API layer should prioritize:

* Minimal requests.
* Fast validation.
* Efficient database queries.
* Asynchronous AI processing.
* No unnecessary repeated AI calls.

---

# Complete API Flow

```text id="y8r3mf"
GET /quote
     ↓
POST /quote/start
     ↓
GET /quote/session/{token}/step
     ↓
POST /quote/session/{token}/answers
     ↓
POST /quote/session/{token}/ai
     ↓
POST /quote/session/{token}/answers
     ↓
GET /quote/session/{token}/review
     ↓
POST /quote/session/{token}/submit
     ↓
Confirmation
```

The actual number of calls may vary depending on implementation.

---

# Graceful Degradation

If AI is unavailable:

```text id="u5m9zk"
Quote Wizard
     ↓
AI unavailable
     ↓
Manual flow
     ↓
Quote submission
```

If a non-critical endpoint fails, the user should not lose already saved information.

---

# Testing Requirements

## Session

✓ Session creation.

✓ Session retrieval.

✓ Invalid token rejection.

✓ Expired session handling.

---

## Answers

✓ Valid answer.

✓ Invalid answer.

✓ Missing required answer.

✓ Conditional answer.

✓ Unauthorized field modification.

---

## AI

✓ Valid AI request.

✓ Invalid operation.

✓ Rate limit.

✓ AI timeout.

✓ AI failure.

✓ Malformed AI response.

---

## Submission

✓ Successful submission.

✓ Missing required information.

✓ Missing consent.

✓ Duplicate submission.

✓ Invalid session.

✓ Database failure handling.

---

## Security

✓ CSRF protection.

✓ Input validation.

✓ Authorization boundaries.

✓ Mass-assignment protection.

✓ No secret exposure.

✓ Rate limiting.

---

# Success Criteria

The API architecture is successful when:

✓ The browser cannot bypass server-side validation.

✓ Quote sessions are securely managed.

✓ Answers are validated before storage.

✓ AI requests are controlled by Laravel.

✓ Groq credentials never reach the browser.

✓ AI output is validated before use.

✓ Final submission is protected against duplication.

✓ AI failure does not prevent quote submission.

✓ Public endpoints expose only appropriate information.

✓ Business logic remains inside services rather than controllers.

✓ The architecture is compatible with Laravel 12.

✓ Future Admin Portal integration is possible.

---

# Stop Condition

This document defines the Quote Wizard API architecture.

It does not implement:

* Controllers.
* Routes.
* Form Requests.
* Database migrations.
* Eloquent models.
* Groq API code.
* Queue jobs.
* Admin endpoints.
* Email notifications.
* Deployment.

Those will be handled by subsequent Quote Wizard documentation.
