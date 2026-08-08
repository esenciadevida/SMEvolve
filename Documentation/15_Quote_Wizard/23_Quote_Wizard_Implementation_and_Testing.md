# SMEvolve Quote Wizard

## Phase 23 – Quote Wizard Implementation & Testing

**Project:** SMEvolve

**Framework:** Laravel 12

**Frontend:** Blade, Vite, Alpine.js

**AI Provider:** Groq

**Module:** Quote Wizard

**Version:** 1.0

**Document Type:** Implementation & Testing Specification

---

# 1. Objective

Implement the complete SMEvolve Quote Wizard according to the architecture and requirements defined in the preceding Quote Wizard documentation.

This phase transitions the Quote Wizard from architectural specification into a working Laravel feature.

The implementation must integrate:

* Database structure.
* Eloquent models.
* Routes.
* Controllers.
* Form Requests.
* Services.
* Blade components.
* Alpine.js interactions.
* Groq AI integration.
* Validation.
* Security.
* Accessibility.
* Error handling.
* Automated tests.

The implementation must follow the existing SMEvolve architecture and design system.

---

# 2. Required Reading

Before implementation, the AI/developer must read:

## AI Foundation

```text
AI_Instructions/00_AI_Constitution.md
```

## Core Documentation

```text
Documentation/01_PRD/
Documentation/02_Information_Architecture.md
Documentation/03_Design_System/
Documentation/04_Content_Architecture/
```

## Global Features

```text
Documentation/13_Global_Features/
```

## Legal

```text
Documentation/12_Legal/
```

The Quote Wizard must remain compatible with the implemented Privacy Policy, Terms & Conditions, and Cookie Policy.

---

# 3. Quote Wizard Documentation

Read all previous Quote Wizard specifications before implementation:

```text
15_Quote_Wizard/
```

At minimum:

```text
18_Data_Model_and_Database_Architecture.md
19_Routes_Controllers_and_Request_Validation.md
20_Laravel_Service_Layer_and_Business_Logic.md
21_Blade_Component_Architecture_and_View_Implementation.md
22_Alpine_JS_and_AI_Groq_Integration.md
```

Do not implement against an outdated assumption from an earlier document when a later specification has superseded it.

---

# 4. Implementation Principle

Implementation must follow:

```text
Documentation
      ↓
Existing Project Inspection
      ↓
Database
      ↓
Models
      ↓
Services
      ↓
Controllers
      ↓
Routes
      ↓
Blade Components
      ↓
Alpine.js
      ↓
AI Integration
      ↓
Testing
      ↓
Acceptance
```

Do not build the frontend first and invent backend behavior later.

---

# 5. Pre-Implementation Inspection

Before creating files, inspect the existing project.

Verify:

* Laravel version.
* Existing layouts.
* Existing Blade components.
* Existing routes.
* Existing authentication.
* Existing database conventions.
* Existing service classes.
* Existing Form Requests.
* Existing SEO architecture.
* Existing notification/mail architecture.
* Existing JavaScript structure.
* Existing CSS/design system.
* Existing test framework.
* Existing environment configuration.

---

# 6. Avoid Duplication

Before creating a new component, service, helper, or configuration file, search the project for an existing implementation.

Prefer:

```text
Reuse
```

over:

```text
Duplicate
```

If an existing component is close but insufficient, extend it when doing so does not damage unrelated features.

---

# 7. Implementation Order

Implement in the following order.

---

## Step 1 — Database

Create all required migrations.

Verify:

* Foreign keys.
* Indexes.
* Unique constraints.
* Nullable fields.
* Status fields.
* Timestamps.
* JSON fields where appropriate.

Run migrations only after reviewing generated SQL/schema behavior.

---

# 8. Database Integrity

The database must enforce important constraints where practical.

Examples:

```text
Unique quote reference
Valid quote relationships
Required submission relationships
```

Do not rely entirely on application-level checks for constraints that can safely be enforced at database level.

---

# 9. Step 2 — Eloquent Models

Create the required models.

Models should define:

* Fillable/guarded behavior.
* Casts.
* Relationships.
* Scopes where justified.
* Attribute behavior where justified.

Avoid placing large business workflows inside models.

---

# 10. Model Relationships

Verify all relationships against the approved data architecture.

Example concept:

```text
QuoteSession
 ├── answers
 ├── requirements
 ├── submission
 └── AI interactions
```

Use appropriate Eloquent relationships.

---

# 11. Step 3 — Configuration

Add Quote Wizard and AI configuration.

Potential files:

```text
config/quote.php
config/ai.php
```

Only create these if they fit the existing configuration architecture.

Configuration should control values such as:

* AI provider.
* AI model.
* Timeouts.
* Rate limits.
* Quote session lifetime.
* Feature flags where appropriate.

---

# 12. Step 4 — Environment Variables

Add required environment variables to the example environment file.

Example:

```text
AI_PROVIDER=groq

GROQ_API_KEY=

GROQ_MODEL=

GROQ_TIMEOUT=
```

Never add real credentials to:

* Git.
* Source files.
* Blade.
* JavaScript.
* Public configuration.

---

# 13. Step 5 — Services

Implement the previously defined services.

Primary services include:

```text
QuoteWizardService
QuoteSessionService
QuoteFlowService
QuoteAnswerService
QuoteRequirementService
QuoteReviewService
QuoteSubmissionService
QuoteReferenceService
```

AI services include:

```text
AIService
GroqService
QuoteContextBuilder
QuotePromptBuilder
```

---

# 14. Service Implementation Rules

Services must:

* Validate business rules.
* Coordinate models.
* Handle transactions where required.
* Return predictable results.
* Throw meaningful application exceptions.

Services must not render Blade views.

---

# 15. Step 6 — AI Provider

Implement Groq behind the AI abstraction.

The implementation must:

* Read credentials from environment configuration.
* Use configured model.
* Apply timeout.
* Handle provider failures.
* Validate responses.
* Avoid exposing provider errors.

The browser must never communicate directly with Groq.

---

# 16. AI Prompt Files

Production prompts should be stored separately from controllers.

Recommended:

```text
resources/prompts/
└── quote/
    ├── description_assistance_v1.txt
    ├── feature_suggestions_v1.txt
    ├── clarification_v1.txt
    └── project_summary_v1.txt
```

The exact location may follow existing SMEvolve conventions.

Prompt content must follow the AI Constitution.

---

# 17. AI Prompt Security

Prompt templates must clearly distinguish:

```text
System instructions
```

from:

```text
User-provided content
```

User input must never be interpolated into a position where it can become an unintended system instruction.

---

# 18. Step 7 — Form Requests

Implement dedicated Laravel Form Requests for appropriate operations.

Examples:

```text
StartQuoteRequest
SaveQuoteAnswerRequest
AIRequest
SubmitQuoteRequest
```

The exact classes should follow the route architecture.

---

# 19. Validation

Validation must occur server-side.

Validate:

* Question IDs.
* Answer types.
* Allowed options.
* Required values.
* Maximum lengths.
* Contact information.
* Consent.
* Session state.

---

# 20. Conditional Validation

Validation must respect dynamic question flow.

If a question is not applicable to the current project path, the server should not require an answer for it.

Example:

```text
Mobile App
```

may require:

```text
Platforms
```

while a website flow may not.

---

# 21. Step 8 — Controllers

Implement lightweight controllers.

Primary responsibilities:

```text
Receive request
 ↓
Authorize/access check
 ↓
Call service
 ↓
Return view/response
```

Controllers must not contain large business workflows.

---

# 22. Quote Controller Flow

Conceptually:

```text
GET Start
 ↓
QuoteWizardService
 ↓
Start session
 ↓
Redirect to first step
```

---

# 23. Step Controller Flow

```text
GET Step
 ↓
Verify session
 ↓
Verify step accessibility
 ↓
Load prepared step data
 ↓
Render Blade
```

---

# 24. Answer Submission Flow

```text
POST Step
 ↓
Validate
 ↓
QuoteAnswerService
 ↓
QuoteFlowService
 ↓
Redirect next step
```

Use redirect-after-post behavior.

---

# 25. Review Flow

```text
GET Review
 ↓
QuoteReviewService
 ↓
Validate review readiness
 ↓
Build review data
 ↓
Render review
```

---

# 26. Submission Flow

```text
POST Submit
 ↓
Validate
 ↓
QuoteSubmissionService
 ↓
Database Transaction
 ↓
Create Submission
 ↓
Generate Reference
 ↓
Record Consent
 ↓
Create Snapshot
 ↓
Mark Session Submitted
 ↓
Redirect Confirmation
```

---

# 27. Step 9 — Routes

Register all Quote Wizard routes according to the approved route specification.

Routes must use named routes.

Avoid hardcoded URLs throughout the application.

---

# 28. Route Protection

Verify that users cannot:

* Access another session.
* Skip required steps.
* Modify submitted sessions.
* Submit expired sessions.
* Re-submit completed sessions.

---

# 29. Public Quote Identifiers

External routes should use secure public identifiers where specified.

Do not expose internal sequential database IDs unnecessarily.

---

# 30. Step 10 — Blade Components

Implement the reusable Blade architecture.

At minimum:

```text
quote layout
progress
question
question/text
question/textarea
question/email
question/phone
question/number
question/single-choice
question/multiple-choice
navigation
errors
AI assistant
review section
consent
session expired
```

Reuse existing SMEvolve components where available.

---

# 31. Blade Data Rule

Blade receives prepared data.

Blade must not:

* Query the database.
* Call AI services.
* Contain business rules.
* Calculate complex workflow decisions.

---

# 32. Dynamic Question Rendering

The step view should render the appropriate question component based on prepared question metadata.

Example:

```text
Question Type
      ↓
Component Resolver
      ↓
Blade Component
```

Adding a new question type should not require rewriting the entire wizard.

---

# 33. Step Navigation

Verify:

* Back works.
* Continue works.
* Review navigation works.
* Invalid steps are blocked.
* Completed sessions cannot be modified.

---

# 34. Step Persistence

After a successful answer submission:

```text
Database
```

must contain the current answer before the user proceeds.

Do not depend on browser state as permanent storage.

---

# 35. Step 11 — Alpine.js

Implement Alpine.js only for interactive UI behavior.

Use it for:

* AI interactions.
* Loading states.
* Character counts.
* UI toggles.
* Suggestion acceptance.
* Non-critical client-side interactions.

Do not move business logic into Alpine.js.

---

# 36. AI Assistant UI

Implement:

```text
Generate suggestion
 ↓
Loading
 ↓
Suggestion
 ↓
Use suggestion / Dismiss / Retry
```

The user must remain in control.

---

# 37. AI Endpoint

AI requests should use a Laravel endpoint.

Example conceptual flow:

```text
POST /quote/{quote}/ai/{operation}
```

The exact URI must follow the approved route architecture.

---

# 38. AI Response

Return structured JSON.

Example:

```json
{
    "success": true,
    "data": {
        "suggestion": "..."
    }
}
```

Error responses should follow the application's existing API/JSON conventions.

---

# 39. AI Output Validation

Before returning AI data to the browser:

```text
Groq Response
 ↓
Parse
 ↓
Validate
 ↓
Normalize
 ↓
Return
```

Never return raw provider responses directly.

---

# 40. AI Rate Limiting

Apply Laravel rate limiting to AI endpoints.

The exact limit should be configurable and appropriate for production usage.

---

# 41. AI Failure Handling

If AI fails:

```text
AI unavailable
```

the user should still be able to complete the Quote Wizard manually.

AI is optional.

---

# 42. Step 12 — Review Page

Implement the complete review interface.

The page must display server-generated data for:

* Project details.
* Requirements.
* Timeline.
* Budget.
* Contact information.
* Consent.

---

# 43. Review Editing

Each section should provide an appropriate edit action.

Example:

```text
Project Details      Edit
Requirements         Edit
Timeline             Edit
Contact              Edit
```

The user should return to the relevant wizard step.

---

# 44. Step 13 — Consent

Implement explicit legal consent.

The submission process must verify consent server-side.

Do not rely only on:

```text
required
```

HTML attributes.

---

# 45. Legal Integration

Use named routes for:

```text
Privacy Policy
Terms
Cookies
```

The Quote Wizard must remain consistent with the implemented legal module.

---

# 46. Step 14 — Submission

Implement transactional submission.

Use:

```php
DB::transaction()
```

for operations that must succeed or fail together.

---

# 47. Reference Generation

Generate a unique public quote reference.

Example:

```text
SME-2026-000245
```

The actual production format must follow the approved reference specification.

---

# 48. Submission Snapshot

At submission time, create the required snapshot of the quote information.

This protects the submitted record from later changes to draft answers.

---

# 49. Step 15 — Confirmation

Implement confirmation page.

It should display:

* Successful submission message.
* Quote reference.
* Appropriate next step.
* Return/navigation action.

Do not expose internal administrative information.

---

# 50. Step 16 — Events

Where specified, dispatch:

```text
QuoteStarted
QuoteStepCompleted
QuoteSubmitted
QuoteAISuggestionAccepted
```

Events should prepare the system for future integrations.

---

# 51. Email Integration

Do not tightly couple quote submission to email delivery.

Where the existing architecture supports it:

```text
QuoteSubmitted
 ↓
Notification/Event Listener
 ↓
Email
```

Email failure should not corrupt an otherwise successful quote transaction.

---

# 52. Step 17 — Error Handling

Implement friendly user-facing handling for:

* Expired session.
* Invalid step.
* Invalid answer.
* AI failure.
* Duplicate submission.
* Unexpected application errors.

Never expose:

* Stack traces.
* SQL errors.
* API credentials.
* Internal paths.
* Provider secrets.

---

# 53. Logging

Log useful application information while avoiding sensitive data.

Potential events:

```text
Quote started
Quote submitted
AI request failed
Submission failure
```

Do not log:

* Passwords.
* API keys.
* Full sensitive contact records unnecessarily.
* Raw AI context where inappropriate.

---

# 54. Step 18 — Accessibility Implementation

Verify:

✓ Semantic forms.

✓ Correct labels.

✓ Keyboard navigation.

✓ Visible focus.

✓ Error association.

✓ Accessible progress indicator.

✓ Accessible AI status.

✓ Accessible buttons.

✓ Correct heading hierarchy.

---

# 55. Step 19 — Responsive Implementation

Test:

```text
Mobile
Tablet
Desktop
```

Verify:

* No horizontal overflow.
* Inputs remain usable.
* Navigation remains accessible.
* AI controls remain usable.
* Review page remains readable.

---

# 56. Step 20 — Security Implementation

Verify:

✓ CSRF protection.

✓ Server-side validation.

✓ Authorization/session ownership.

✓ Rate limiting.

✓ Output escaping.

✓ AI key protection.

✓ Secure public identifiers.

✓ Duplicate submission prevention.

✓ Submitted-session protection.

---

# 57. Automated Testing Strategy

Use the project's existing Laravel testing framework.

Tests should cover:

```text
Unit
Feature
Integration
```

where appropriate.

---

# 58. Unit Tests

Test:

### QuoteSessionService

* Creation.
* Expiration.
* Status changes.

### QuoteFlowService

* Step progression.
* Conditional flow.
* Invalid step handling.

### QuoteAnswerService

* Valid answers.
* Invalid answers.
* Answer updates.

### QuoteRequirementService

* Suggestion creation.
* Confirmation.
* Removal.

### QuoteReferenceService

* Reference generation.
* Uniqueness.

### QuoteContextBuilder

* Correct context.
* Sensitive information exclusion.

---

# 59. Feature Tests

Test HTTP behavior.

Examples:

```text
Start quote
View step
Submit answer
Navigate backward
Navigate forward
Open review
Submit quote
Open confirmation
```

---

# 60. Validation Tests

Test:

* Missing required answers.
* Invalid answer types.
* Invalid options.
* Excessive input length.
* Invalid email.
* Invalid phone.
* Missing consent.

---

# 61. Security Tests

Test:

* CSRF.
* Unauthorized session access.
* Session manipulation.
* Expired sessions.
* Submitted sessions.
* Duplicate submissions.
* AI endpoint rate limits.

---

# 62. AI Tests

Test:

* Groq service.
* Provider abstraction.
* Prompt generation.
* Structured response parsing.
* Invalid AI output.
* AI timeout.
* AI provider failure.
* Unknown requirements.

Use mocked/fake provider responses in automated tests.

Tests must not depend on live Groq API calls.

---

# 63. Database Tests

Verify:

* Foreign keys.
* Unique constraints.
* Cascading behavior where intended.
* JSON casting.
* Submission relationships.

---

# 64. Browser/Manual Testing

Where browser testing infrastructure exists, verify the complete user journey.

Test:

```text
Landing
 ↓
Start
 ↓
Step 1
 ↓
Step 2
 ↓
Conditional Step
 ↓
AI Assistance
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

# 65. AI Manual Testing

Verify realistic scenarios:

### Scenario 1

User gives a short project description.

Expected:

AI improves clarity without inventing major features.

### Scenario 2

User provides vague requirements.

Expected:

AI suggests useful clarification.

### Scenario 3

Groq unavailable.

Expected:

User can continue manually.

### Scenario 4

AI suggests unknown requirement.

Expected:

Suggestion is rejected or safely ignored.

---

# 66. Responsive Testing Matrix

| Area         | Mobile | Tablet | Desktop |
| ------------ | -----: | -----: | ------: |
| Landing      |      ✓ |      ✓ |       ✓ |
| Wizard       |      ✓ |      ✓ |       ✓ |
| Inputs       |      ✓ |      ✓ |       ✓ |
| AI Assistant |      ✓ |      ✓ |       ✓ |
| Review       |      ✓ |      ✓ |       ✓ |
| Confirmation |      ✓ |      ✓ |       ✓ |

---

# 67. Accessibility Testing Matrix

| Requirement             | Result    |
| ----------------------- | --------- |
| Keyboard navigation     | Must pass |
| Visible focus           | Must pass |
| Labels                  | Must pass |
| Error association       | Must pass |
| Heading hierarchy       | Must pass |
| Progress accessibility  | Must pass |
| AI status accessibility | Must pass |
| Screen-reader usability | Must pass |

---

# 68. Performance Testing

Verify:

* Initial page load.
* Step navigation speed.
* Database query count.
* AI request latency.
* No unnecessary JavaScript requests.
* No repeated database queries caused by Blade components.

AI latency should not block normal navigation when AI is not being used.

---

# 69. Regression Testing

After implementation, run the existing project test suite.

The Quote Wizard must not break:

* Global navigation.
* Legal pages.
* Existing forms.
* SEO infrastructure.
* Existing services.
* Existing components.

---

# 70. Code Quality

Verify:

✓ Laravel conventions.

✓ PSR-compatible PHP.

✓ Clear class responsibilities.

✓ Meaningful method names.

✓ No duplicated business logic.

✓ No unnecessary dependencies.

✓ No dead code.

✓ No debugging statements.

Remove:

```php
dd()
dump()
ray()
```

and equivalent debugging artifacts before completion.

---

# 71. Documentation During Implementation

Update documentation only when implementation reveals a genuine architectural change.

Do not rewrite documentation simply to describe every line of code.

Documentation should remain the source of intended architecture.

---

# 72. Environment Verification

Before declaring completion, verify:

```text
composer install
npm install
php artisan migrate
npm run build
php artisan test
```

Use the project's actual setup commands where they differ.

---

# 73. Final Functional Checklist

The implementation must verify:

✓ User can start a quote.

✓ User can progress through steps.

✓ Conditional questions work.

✓ Answers persist.

✓ User can navigate backward.

✓ AI assistance works.

✓ AI suggestions require user confirmation.

✓ Review page displays correct data.

✓ Consent is required.

✓ Quote submits successfully.

✓ Reference is generated.

✓ Confirmation is displayed.

✓ Duplicate submission is prevented.

✓ Expired sessions are handled.

---

# 74. Final Security Checklist

Verify:

✓ No Groq key in frontend.

✓ CSRF enabled.

✓ Server-side validation.

✓ Rate limiting.

✓ Secure session access.

✓ Safe output escaping.

✓ AI output validation.

✓ No sensitive AI context.

✓ Duplicate submission protection.

✓ Submitted records protected.

---

# 75. Final Testing Result

Before completion, produce a testing summary containing:

```text
Functional Tests
Security Tests
AI Tests
Database Tests
Accessibility Tests
Responsive Tests
Performance Tests
Regression Tests
```

Each should state:

```text
PASS
FAIL
BLOCKED
```

with an explanation for anything other than PASS.

---

# 76. Known Limitations

Document any legitimate limitations such as:

* AI provider availability.
* Browser compatibility.
* External service limitations.
* Features intentionally deferred to Admin Portal.

Do not mark incomplete functionality as complete.

---

# 77. Future Compatibility

Implementation should leave room for:

* Admin quote management.
* Quote status tracking.
* Internal notes.
* Official quotation generation.
* Email notifications.
* CRM integrations.
* Additional AI providers.
* AI usage analytics.
* Legal/AI policy enhancements.

These are not part of the current Quote Wizard implementation unless explicitly specified elsewhere.

---

# 78. Stop Condition

The implementation phase is complete when:

✓ Database is implemented.

✓ Models are implemented.

✓ Services are implemented.

✓ Controllers are implemented.

✓ Routes are implemented.

✓ Blade components are implemented.

✓ Alpine.js interactions are implemented.

✓ Groq integration is implemented.

✓ Validation is implemented.

✓ Security controls are implemented.

✓ Accessibility requirements are implemented.

✓ Responsive behavior is implemented.

✓ Automated tests pass.

✓ Manual testing passes.

✓ Existing application regression tests pass.

At this point, proceed to the final Quote Wizard acceptance criteria document.

Do not begin:

* Admin Portal.
* Deployment.
* Client Portal.
* Subscription system.

Those remain separate modules.
