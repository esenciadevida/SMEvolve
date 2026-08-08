# SMEvolve Quote Wizard

## Phase 22 – Alpine.js & AI/Groq Integration

**Project:** SMEvolve

**Framework:** Laravel 12

**Frontend:** Blade, Vite, Alpine.js

**AI Provider:** Groq

**Module:** Quote Wizard

**Version:** 1.0

**Document Type:** Frontend Interaction & AI Integration Architecture

---

# 1. Objective

Define the client-side interaction architecture and AI integration for the SMEvolve Quote Wizard.

This phase establishes how:

* Alpine.js manages interactive UI behavior.
* Laravel remains the authoritative application layer.
* Groq provides AI assistance.
* AI prompts are constructed securely.
* AI responses are validated.
* AI suggestions are presented to users.
* Users remain in control of their information.
* AI failures do not prevent normal quote submission.

The implementation must remain lightweight and compatible with the existing SMEvolve architecture.

---

# 2. Core Principle

The Quote Wizard follows:

```text id="9z4s2c"
User
 ↓
Blade UI
 ↓
Alpine.js
 ↓
Laravel Endpoint
 ↓
AI Service
 ↓
Groq
 ↓
AI Service
 ↓
Laravel Response
 ↓
Alpine.js
 ↓
User
```

Alpine.js must never communicate directly with Groq.

---

# 3. Why Groq Is Used

Groq provides the AI infrastructure for Quote Wizard assistance.

Potential uses include:

* Project description assistance.
* Requirement suggestions.
* Clarification.
* Project summarization.
* Intelligent guidance through the wizard.

Groq should remain behind the application's AI abstraction layer.

The Quote Wizard must not become permanently coupled to one provider.

---

# 4. AI Provider Architecture

The application should use:

```text id="zq54d4"
QuoteAIController
        ↓
AIService
        ↓
QuoteContextBuilder
        ↓
QuotePromptBuilder
        ↓
GroqService
        ↓
Groq API
```

The browser never receives the Groq API key.

---

# 5. Environment Configuration

Provider credentials must be stored in environment configuration.

Example:

```text id="nd3v4f"
GROQ_API_KEY=
GROQ_MODEL=
GROQ_TIMEOUT=
```

The exact environment variables should follow the final implementation conventions.

Secrets must never be committed to source control.

---

# 6. Configuration Layer

AI configuration should be centralized.

Recommended:

```text id="x7d4xq"
config/ai.php
```

Possible structure:

```php
return [

    'default' => env('AI_PROVIDER', 'groq'),

    'providers' => [
        'groq' => [
            'model' => env('GROQ_MODEL'),
            'timeout' => env('GROQ_TIMEOUT', 20),
        ],
    ],

];
```

The exact implementation may differ according to the application's existing configuration architecture.

---

# 7. Provider Abstraction

The Quote Wizard should interact with:

```text id="v5h0cw"
AIService
```

rather than directly depending on:

```text id="z9vypj"
GroqService
```

This allows future providers to be introduced without rewriting the Quote Wizard.

---

# 8. AI Operations

The initial AI architecture should support:

```text id="1m2zme"
description_assistance
feature_suggestions
clarification
project_summary
```

Additional operations may be added later.

---

# 9. Description Assistance

The user may provide a rough description such as:

> I need a website where customers can book appointments.

The AI may transform this into a clearer project description.

The AI must preserve the user's intent.

It must not invent major requirements.

---

# 10. Feature Suggestions

The AI may identify likely requirements from the user's project description.

Example:

```text id="9q3q9n"
Project:
Online appointment booking website
```

Potential suggestions:

```text id="9y0m1q"
Customer accounts
Appointment booking
Notifications
Admin dashboard
Payment integration
```

These remain suggestions until the user confirms them.

---

# 11. Clarification

The AI may help identify information that would improve the quote.

Example:

```text id="4y6g4w"
User:
"I want an ecommerce website."

AI:
"Will customers need to pay online?"
```

The AI should ask focused questions rather than generating unnecessary conversation.

---

# 12. Project Summary

Near the review stage, AI may generate a concise project summary from confirmed information.

Example:

```text id="t3m5f8"
The client requires an ecommerce platform
with customer accounts, online payments,
product management, order tracking and
an administrative dashboard.
```

The summary should be treated as generated assistance, not the authoritative quote record.

---

# 13. AI Prompt Architecture

Prompts should be separated into:

```text id="n4xk60"
System Instructions
+
Operation Instructions
+
Quote Context
+
User Input
+
Output Requirements
```

---

# 14. System Instructions

System instructions define the AI's role.

Example principles:

```text id="1g1k8x"
You are an assistant helping users describe
software projects for a professional quotation.

You must:
- remain factual,
- avoid inventing requirements,
- ask useful clarification questions,
- distinguish assumptions from confirmed information,
- produce concise professional output.
```

The final production prompt should be stored and versioned according to the project's AI prompt architecture.

---

# 15. Prompt Versioning

Every production prompt must have a version.

Examples:

```text id="q7w7i3"
description_assistance_v1
feature_suggestions_v1
clarification_v1
project_summary_v1
```

When prompts materially change:

```text id="u5k2j1"
feature_suggestions_v1
        ↓
feature_suggestions_v2
```

Do not silently change a production prompt while retaining the same version identifier.

---

# 16. Quote Context

The AI should receive only information required for the operation.

Example:

```json id="2kq6c9"
{
    "project_type": "web_application",
    "description": "Online booking platform",
    "confirmed_requirements": [
        "customer_accounts",
        "payments"
    ]
}
```

---

# 17. Information Excluded From AI Context

The following should not be sent unless there is a specific justified requirement:

* Passwords.
* Authentication credentials.
* API keys.
* Internal administrative notes.
* Payment credentials.
* Unnecessary contact information.
* Internal database IDs.
* Sensitive operational information.

---

# 18. Contact Information

Contact information such as:

```text id="a7q3x8"
name
email
phone
```

should not be included in AI prompts by default.

AI assistance should normally operate on project information rather than identity information.

---

# 19. User Input

User-generated AI input must be:

* Validated.
* Length-limited.
* Contextually bounded.

The browser must not be allowed to submit an arbitrary system prompt.

---

# 20. Prompt Injection Protection

Users may deliberately or accidentally enter text such as:

```text id="m2l8c3"
Ignore previous instructions...
```

The AI architecture must treat user-provided text as data, not instructions that override the system prompt.

---

# 21. Structured AI Output

Where practical, AI should return structured output.

For feature suggestions:

```json id="q2e5kp"
{
    "suggestions": [
        {
            "key": "customer_accounts",
            "reason": "Allows customers to manage bookings."
        },
        {
            "key": "notifications",
            "reason": "Useful for appointment reminders."
        }
    ]
}
```

The application must validate the response before presenting it as actionable data.

---

# 22. AI Output Validation

Never assume AI output is valid simply because it is JSON.

Laravel must verify:

* Required fields.
* Data types.
* Allowed requirement keys.
* Maximum lengths.
* Expected operation structure.

---

# 23. Unknown Requirements

If AI suggests a requirement that does not exist in the SMEvolve requirement catalog:

```text id="n4l1tx"
AI
 ↓
Unknown requirement
 ↓
Reject / ignore suggestion
```

Do not automatically create a new database requirement from AI output.

---

# 24. AI Suggestions

The UI should clearly distinguish:

```text id="g1l1e8"
Confirmed Requirement
```

from:

```text id="k4y0x2"
AI Suggested Requirement
```

AI suggestions require user confirmation.

---

# 25. Alpine.js Architecture

Alpine.js is responsible for UI behavior only.

Recommended Alpine components:

```text id="h0a8t5"
quoteWizard
aiAssistant
aiSuggestion
characterCounter
```

The exact component names may follow SMEvolve naming conventions.

---

# 26. quoteWizard Component

Responsible for lightweight UI state such as:

```text id="v8x4g5"
loading
saving
current UI state
```

It must not replace Laravel's quote session state.

---

# 27. aiAssistant Component

Responsible for:

* Triggering AI requests.
* Showing loading state.
* Displaying results.
* Handling errors.
* Allowing the user to accept/reject suggestions.

---

# 28. AI Request Flow

Example:

```text id="5a3g1v"
User clicks "Improve Description"

        ↓

Alpine sets loading = true

        ↓

POST /quote/{quote}/ai/description

        ↓

Laravel validates request

        ↓

AIService

        ↓

Groq

        ↓

Validated response

        ↓

JSON response

        ↓

Alpine updates suggestion

        ↓

loading = false
```

---

# 29. CSRF

AI requests made through browser JavaScript must include Laravel CSRF protection.

The application should use the existing Laravel CSRF mechanism rather than creating a custom authentication system for AI requests.

---

# 30. AI Request Rate Limiting

AI endpoints must be rate limited.

This protects:

* Groq usage.
* SMEvolve infrastructure.
* Quote sessions.
* Cost.
* Abuse prevention.

The limit should be configurable.

---

# 31. Duplicate AI Requests

The UI should prevent accidental rapid repeated requests.

Example:

```text id="0z9k3s"
Generate
 ↓
Generating...
```

The Generate button should not trigger multiple simultaneous requests.

Server-side rate limiting remains mandatory.

---

# 32. AI Loading State

The interface should clearly communicate:

```text id="1y5m3x"
Generating suggestion...
```

The loading state should be accessible.

---

# 33. AI Success State

After a successful response:

```text id="0f4n3y"
Suggested improvement

[Use suggestion]
[Try again]
```

The original user input should remain available.

---

# 34. Accepting an AI Suggestion

When the user clicks:

```text id="k9r3a8"
Use suggestion
```

Alpine may place the suggestion into the appropriate field.

The user must still be able to edit it.

The application should not treat AI-generated text as automatically confirmed until the user submits/saves it through the normal Quote Wizard flow.

---

# 35. Rejecting a Suggestion

The user may dismiss a suggestion without modifying their existing answer.

---

# 36. Regenerating

A user may request another suggestion.

The application should:

* Respect rate limits.
* Avoid unnecessary repeated context.
* Maintain the user's original input.

---

# 37. AI Failure

If Groq is unavailable:

```text id="l7v8a1"
We couldn't generate a suggestion right now.
You can continue manually.
```

The Quote Wizard must continue functioning.

---

# 38. Timeout

AI requests must have a reasonable timeout.

A slow AI request must not keep the browser waiting indefinitely.

---

# 39. Provider Errors

Provider-specific errors must be translated into application-level responses.

Do not expose:

```text id="v4p0za"
API key errors
Raw provider responses
Internal stack traces
Infrastructure details
```

---

# 40. AI Retry

Automatic retries should be conservative.

Retry only when the error is appropriate for retrying.

Do not repeatedly retry:

* Invalid input.
* Authentication failures.
* Permanently invalid requests.

---

# 41. AI Availability

AI assistance should be treated as an enhancement.

The core flow must work without AI.

Therefore:

```text id="2s8h3c"
AI unavailable
       ↓
Quote Wizard still works
```

---

# 42. AI Interaction Logging

Record useful metadata in:

```text id="k4p7q5"
quote_ai_interactions
```

Possible information:

* Operation.
* Provider.
* Model.
* Prompt version.
* Status.
* Duration.
* Token usage.
* Timestamp.

Avoid storing unnecessary sensitive prompt content.

---

# 43. AI Cost Control

The system should monitor:

* Requests per session.
* Requests per IP/session where appropriate.
* Token usage.
* Average response size.

This helps prevent uncontrolled AI expenditure.

---

# 44. AI Context Size

Only include relevant quote information.

Do not send the entire database record to Groq.

Use:

```text id="g1c9y2"
QuoteContextBuilder
```

to construct the minimal useful context.

---

# 45. AI Model Configuration

The model should be configurable through environment/configuration.

Do not hardcode the model throughout controllers or Blade templates.

---

# 46. AI Provider Abstraction

Future providers may include another AI API.

The application should allow:

```text id="6m4d3q"
Groq
 ↓
AIService
 ↓
Alternative Provider
```

without rewriting the Quote Wizard UI.

---

# 47. AI Security Boundary

The security boundary is:

```text id="2s4c5v"
Browser
   X
   |
   | No direct Groq access
   |
Laravel
   ↓
AI Service
   ↓
Groq
```

The Groq key exists only server-side.

---

# 48. AI and Privacy

AI processing must be consistent with the SMEvolve Privacy Policy.

Users should be informed where necessary that AI assistance is being used.

The application should avoid sending unnecessary personal information to third-party AI infrastructure.

---

# 49. AI Disclosure

The UI may include a concise disclosure near AI functionality.

Example:

```text id="n5j7p1"
AI assistance may be used to help refine
your project description and suggest features.
Please review AI-generated suggestions before
using them.
```

The final wording should align with the approved SMEvolve legal/content documentation.

---

# 50. AI and Quote Accuracy

AI output must never be represented as:

* Final pricing.
* Binding quotation.
* Confirmed project scope.
* Contractual commitment.

The AI is an assistance layer.

---

# 51. AI and Pricing

The initial Quote Wizard AI should not independently determine a binding project price.

If SMEvolve later introduces AI-assisted estimation, that should be a separately documented feature with appropriate business rules and safeguards.

---

# 52. AI and Requirement Confirmation

The correct process is:

```text id="a5p8k0"
AI Suggestion
      ↓
User Review
      ↓
User Confirmation
      ↓
Confirmed Requirement
```

Never:

```text id="x8n2e4"
AI Suggestion
      ↓
Automatically Confirmed
```

---

# 53. Character Counters

Alpine.js may provide character counters for long text fields.

Example:

```text id="7m1l4d"
Project Description

234 / 2000
```

The server remains authoritative for the actual limit.

---

# 54. Client-Side Validation

Alpine.js may provide immediate UI feedback.

However:

```text id="y4w1j8"
Client validation
≠
Server validation
```

Laravel must always validate submitted data.

---

# 55. Accessibility for AI

AI interactions must support:

* Keyboard access.
* Screen readers.
* Visible focus.
* Loading announcements.
* Error announcements.

AI output should be presented in a semantic container.

---

# 56. Mobile AI Experience

On mobile:

* AI controls must remain easy to access.
* Suggestions should not overwhelm the form.
* Loading states must be obvious.
* The original input must remain easy to edit.

---

# 57. Performance

Alpine.js should be loaded through the existing Vite pipeline.

Avoid introducing:

* React.
* Vue.
* jQuery.
* Large UI libraries.

unless already required by the wider SMEvolve application.

---

# 58. Testing

## Alpine.js

Test:

✓ Loading state.

✓ Success state.

✓ Error state.

✓ Accept suggestion.

✓ Reject suggestion.

✓ Retry.

✓ Duplicate-click prevention.

---

# AI Integration Tests

Test:

✓ Correct provider selection.

✓ Correct model configuration.

✓ Prompt construction.

✓ Context construction.

✓ Structured response validation.

✓ Unknown requirement rejection.

✓ Provider failure handling.

✓ Timeout handling.

✓ Rate limiting.

---

# Security Tests

Verify:

✓ Groq API key never reaches browser.

✓ AI endpoints require CSRF.

✓ AI endpoints are rate limited.

✓ User input cannot override system instructions.

✓ AI output is escaped.

✓ Personal information is not unnecessarily sent to AI.

---

# Privacy Tests

Verify:

✓ Contact information is excluded from AI context by default.

✓ Sensitive fields are excluded.

✓ AI interaction retention follows application policy.

✓ AI disclosure is visible where required.

---

# 59. Acceptance Criteria

The AI/Alpine architecture is complete when:

✓ Groq is accessed only server-side.

✓ AI provider abstraction exists.

✓ AI prompts are versioned.

✓ AI context is minimized.

✓ AI output is validated.

✓ AI suggestions require user confirmation.

✓ AI cannot create arbitrary requirements.

✓ AI failures do not block quote submission.

✓ AI requests are rate limited.

✓ Alpine.js manages UI state only.

✓ Core Quote Wizard functionality works without AI.

✓ AI functionality is accessible.

✓ AI functionality is responsive.

✓ No provider secrets are exposed.

✓ AI behavior is compatible with the SMEvolve Privacy Policy.

---

# 60. Stop Condition

This document defines the Alpine.js and Groq AI architecture.

It does not implement:

* Alpine components.
* Groq API client.
* AI prompt files.
* Laravel services.
* Database migrations.
* Blade templates.
* Admin Portal.
* Deployment.

These will be implemented in the subsequent Quote Wizard implementation phase.
