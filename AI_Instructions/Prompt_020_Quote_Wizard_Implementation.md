# SMEvolve Execution Prompt

## Phase 19 – Quote Wizard Implementation

**Project:** SMEvolve

**Framework:** Laravel 12

**Frontend:** Blade, Vite, Alpine.js

**AI Provider:** Groq

---

# Objective

Implement the complete SMEvolve Quote Wizard according to the approved Quote Wizard architecture and documentation.

The Quote Wizard must provide a professional, accessible, responsive, secure, and scalable process through which users can provide project information and submit a quotation request.

The implementation must integrate the approved:

* Quote Wizard data architecture.
* Question and answer system.
* Conditional flow.
* Validation.
* Review process.
* Submission process.
* Consent handling.
* AI assistance.
* Groq integration.
* Alpine.js interactions.
* Security controls.
* Accessibility requirements.
* Responsive design.
* Testing requirements.

The implementation must use the existing SMEvolve architecture rather than introducing an independent application structure.

---

# Required Reading

Before implementation, read:

## AI Foundation

```text
AI_Instructions/00_AI_Constitution.md
```

---

## Core Documentation

```text
Documentation/01_PRD/

Documentation/02_Information_Architecture.md

Documentation/03_Design_System/

Documentation/04_Content_Architecture/
```

---

## Global Features

Read the relevant documentation within:

```text
Documentation/13_Global_Features/
```

---

## Legal Module

Read:

```text
Documentation/12_Legal/
```

The Quote Wizard must remain compatible with the approved Privacy Policy, Terms & Conditions, and Cookie Policy.

---

## Quote Wizard Documentation

Read **all approved Quote Wizard documentation** before implementation:

```text
Documentation/15_Quote_Wizard/
```

This includes:

```text
18_Data_Model_and_Database_Architecture.md

19_Routes_Controllers_and_Request_Validation.md

20_Laravel_Service_Layer_and_Business_Logic.md

21_Blade_Component_Architecture_and_View_Implementation.md

22_Alpine_JS_and_AI_Groq_Integration.md

23_Quote_Wizard_Implementation_and_Testing.md

24_Quote_Wizard_Acceptance_Criteria.md
```

If the actual filenames differ, use the corresponding approved Quote Wizard documents present in the project.

---

# Implementation Principle

Do not begin coding immediately.

First inspect the existing SMEvolve codebase and understand:

* Existing Laravel structure.
* Existing routes.
* Existing controllers.
* Existing models.
* Existing migrations.
* Existing services.
* Existing Blade layouts.
* Existing Blade components.
* Existing JavaScript architecture.
* Existing Vite configuration.
* Existing CSS/design system.
* Existing validation patterns.
* Existing SEO implementation.
* Existing testing conventions.

Reuse existing architecture wherever appropriate.

Do not create duplicate systems where an existing SMEvolve implementation can be reused.

---

# Scope

Implement:

* Quote Wizard database architecture.
* Quote models.
* Quote services.
* Quote routes.
* Quote controllers.
* Form Requests.
* Question rendering.
* Answer persistence.
* Conditional flow.
* Progress/navigation.
* Review page.
* Consent.
* Quote submission.
* Quote reference generation.
* Confirmation page.
* Alpine.js interactions.
* AI assistance.
* Groq integration.
* AI prompt architecture.
* AI output validation.
* AI rate limiting.
* Error handling.
* Accessibility.
* Responsive behavior.
* Security.
* Automated tests.
* Integration tests.
* Regression testing.

---

# Do Not Implement

Do not implement:

* Client Portal.
* Admin Portal.
* Subscription system.
* Deployment infrastructure.
* Full CRM.
* Contract generation.
* Advanced AI pricing.
* Legal CMS.

These are separate future modules unless explicitly required by an existing SMEvolve specification.

---

# Architecture Requirements

The implementation must:

* Follow Laravel 12 conventions.
* Reuse global layouts.
* Reuse existing components.
* Separate business logic from presentation.
* Use service classes for business workflows.
* Use Form Requests for validation where appropriate.
* Keep controllers lightweight.
* Keep Blade templates presentation-focused.
* Keep Alpine.js focused on UI interaction.
* Keep Groq access server-side.
* Use configuration rather than hardcoded provider settings.
* Avoid unnecessary dependencies.
* Avoid duplicated business logic.

---

# Database Implementation

Implement all approved Quote Wizard migrations.

Verify:

* Relationships.
* Foreign keys.
* Indexes.
* Unique constraints.
* Status fields.
* JSON fields.
* Timestamps.
* Required nullable behavior.

Run migrations and verify that the resulting schema matches the approved architecture.

Do not introduce undocumented database structures without a clear implementation requirement.

---

# Models

Implement the approved Quote Wizard Eloquent models.

Models must include appropriate:

* Relationships.
* Casts.
* Fillable/guarded configuration.
* Scopes where required.

Do not place large business workflows inside models.

---

# Quote Session

Implement the approved quote session lifecycle.

Support:

```text
Start
 ↓
Active
 ↓
Completed
```

with the appropriate expired/submitted states defined by the documentation.

Users must not be able to access or modify another user's quote session.

---

# Quote Flow

Implement the approved wizard flow.

The system must support:

* Sequential steps.
* Back navigation.
* Forward navigation.
* Conditional questions.
* Required questions.
* Answer persistence.
* Invalid-step protection.

The server must remain authoritative for flow decisions.

---

# Question System

Implement the approved question architecture.

Support all documented question types.

Use reusable Blade components rather than creating separate full-page templates for each question.

Adding another supported question type in the future should not require rebuilding the entire wizard.

---

# Validation

Implement server-side validation for all Quote Wizard inputs.

Validate:

* Required fields.
* Question identifiers.
* Answer types.
* Allowed options.
* Character limits.
* Email.
* Phone.
* Consent.
* Session state.
* Submission state.

Never rely exclusively on Alpine.js or HTML validation.

---

# Conditional Logic

Implement conditional question logic according to the approved documentation.

Conditional logic must be enforced server-side.

Do not rely solely on JavaScript to determine which questions are valid.

---

# Routes

Implement all approved Quote Wizard routes.

Use named routes.

Do not hardcode URLs in Blade templates or JavaScript.

Protect routes against:

* Invalid sessions.
* Expired sessions.
* Unauthorized access.
* Invalid steps.
* Submitted-session modification.

---

# Controllers

Create or implement the required Quote Wizard controllers.

Controllers must remain lightweight.

Responsibilities should generally be limited to:

```text
Request
 ↓
Validation
 ↓
Service
 ↓
Response
```

Do not place large business workflows directly inside controllers.

---

# Service Layer

Implement the approved Quote Wizard services.

Services should handle:

* Session management.
* Flow management.
* Answer persistence.
* Requirement management.
* Review preparation.
* Submission.
* Reference generation.
* AI context creation.

Use database transactions where required.

---

# Review

Implement the Quote Wizard review page.

The review must display authoritative server-side data for:

* Project information.
* Requirements.
* Additional project details.
* Timeline.
* Budget where applicable.
* Contact information.
* Consent.

Allow users to return to the appropriate step to make corrections.

---

# Consent

Implement the approved consent mechanism.

The user must explicitly provide required consent before final submission.

Validate consent server-side.

Provide appropriate links to:

```text
Privacy Policy
Terms & Conditions
```

Use named routes.

---

# Quote Submission

Implement the complete submission transaction.

The submission process must:

1. Validate the quote.
2. Validate consent.
3. Verify session state.
4. Create the submission.
5. Generate the public quote reference.
6. Create the required snapshot.
7. Update the quote/session status.
8. Record required consent information.
9. Complete the transaction.
10. Redirect to confirmation.

Use a database transaction where required.

---

# Duplicate Submission

Prevent duplicate quote submissions.

Handle situations such as:

* Double-clicking submit.
* Browser refresh.
* Repeated POST requests.
* Network retries.
* Returning to a completed session.

---

# Quote Reference

Generate a unique public quote reference according to the approved architecture.

Do not expose internal sequential database IDs where a public identifier is required.

---

# Confirmation

Implement the confirmation page.

It should provide:

* Success message.
* Quote reference.
* Appropriate next steps.

Do not expose internal administrative information.

---

# Alpine.js

Implement Alpine.js for UI interactions only.

Use it for:

* Loading states.
* Character counters.
* UI toggles.
* AI interactions.
* Suggestion acceptance.
* Suggestion dismissal.
* Non-critical client-side behavior.

Do not move authoritative business rules into Alpine.js.

---

# AI Integration

Implement the approved AI architecture using Groq.

The browser must never communicate directly with Groq.

The architecture must follow:

```text
Blade
 ↓
Alpine.js
 ↓
Laravel AI Endpoint
 ↓
AIService
 ↓
QuoteContextBuilder
 ↓
QuotePromptBuilder
 ↓
GroqService
 ↓
Groq
```

---

# AI Configuration

Use server-side environment configuration.

Support configuration such as:

```text
AI_PROVIDER=
GROQ_API_KEY=
GROQ_MODEL=
GROQ_TIMEOUT=
```

Do not hardcode credentials or provider settings.

---

# AI Provider Abstraction

The Quote Wizard must communicate with the AI abstraction layer rather than directly coupling all application logic to Groq.

The architecture should allow a future AI provider to be introduced without rebuilding the Quote Wizard frontend.

---

# AI Operations

Implement the approved operations, including where documented:

* Description assistance.
* Feature suggestions.
* Clarification.
* Project summary.

Do not introduce undocumented AI functionality unless required to complete an approved workflow.

---

# AI Prompt Architecture

Implement the approved prompt structure.

Prompts must separate:

```text
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

Production prompts must be versioned.

Do not place large production prompts directly inside controllers.

---

# AI Context

Only send the minimum information required for the requested AI operation.

Do not unnecessarily send:

* Passwords.
* API keys.
* Authentication data.
* Payment credentials.
* Internal administrative notes.
* Unnecessary personal information.
* Internal identifiers.

Contact information should not be included in AI context unless explicitly required.

---

# Prompt Injection Protection

Treat user-provided content as data.

The system must prevent user input from overriding system-level AI instructions.

AI prompts must clearly separate trusted instructions from untrusted user content.

---

# AI Output

AI output must be validated before being returned to the frontend.

Where structured output is required:

* Parse the response.
* Validate its schema.
* Validate allowed values.
* Reject invalid output.
* Normalize accepted output.

Never blindly trust AI-generated JSON.

---

# AI Suggestions

AI-generated suggestions must remain suggestions.

The flow must be:

```text
AI Suggestion
 ↓
User Review
 ↓
User Confirmation
 ↓
Confirmed Requirement
```

AI must never automatically create or confirm a requirement.

---

# Unknown Requirements

If AI produces an unsupported requirement:

```text
AI
 ↓
Unknown Requirement
 ↓
Reject / Ignore
```

Do not automatically create database requirements from arbitrary AI output.

---

# AI Rate Limiting

Protect AI endpoints using appropriate Laravel rate limiting.

Prevent:

* Excessive requests.
* Accidental request loops.
* Abuse.
* Uncontrolled Groq costs.

The limits should be configurable where appropriate.

---

# AI Error Handling

If Groq fails:

```text
AI unavailable
```

the Quote Wizard must remain functional.

Display a user-friendly message and allow the user to continue manually.

Do not expose:

* API keys.
* Stack traces.
* Raw provider errors.
* Internal infrastructure details.

---

# AI Logging

Where required, record appropriate AI interaction metadata such as:

* Operation.
* Provider.
* Model.
* Prompt version.
* Status.
* Duration.
* Token usage where available.
* Timestamp.

Avoid logging unnecessary sensitive user information.

---

# Security

Implement:

* CSRF protection.
* Server-side validation.
* Session ownership checks.
* Rate limiting.
* Secure identifiers.
* Safe output escaping.
* Duplicate submission protection.
* Submitted-session protection.
* AI credential protection.

Never expose Groq credentials to the browser.

---

# Accessibility

Verify:

* Semantic HTML.
* Correct labels.
* Keyboard navigation.
* Visible focus states.
* Accessible errors.
* Correct heading hierarchy.
* Accessible progress indicator.
* Accessible buttons.
* Screen-reader-compatible AI status messages.

AI interactions must not depend exclusively on visual indicators.

---

# Responsive Design

Test and implement for:

```text
Mobile
Tablet
Desktop
```

Verify:

* No horizontal overflow.
* Readable typography.
* Usable form controls.
* Accessible navigation.
* Usable AI interface.
* Readable review page.

Follow the existing SMEvolve Design System.

Do not introduce unrelated styling systems.

---

# Performance

Prioritize:

* Minimal JavaScript.
* Existing Vite architecture.
* Reusable components.
* Efficient database queries.
* Lightweight Blade rendering.
* No unnecessary dependencies.

AI requests should not block normal Quote Wizard navigation.

---

# SEO

Apply the existing SMEvolve SEO architecture where appropriate.

Quote session data must never become publicly indexable.

If Quote Wizard pages are intended to be non-indexable, implement the appropriate noindex strategy.

Do not expose private quote information through search engines.

---

# Testing

Implement and run appropriate tests.

## Functional

Verify:

✓ Quote starts.

✓ Session persists.

✓ Steps load.

✓ Answers save.

✓ Conditional logic works.

✓ Back navigation works.

✓ Review works.

✓ Consent works.

✓ Submission works.

✓ Reference generation works.

✓ Confirmation works.

✓ Duplicate submission is prevented.

---

## Validation

Verify:

✓ Required fields.

✓ Invalid answers.

✓ Invalid options.

✓ Invalid question identifiers.

✓ Character limits.

✓ Invalid contact information.

✓ Missing consent.

---

## AI

Verify:

✓ Groq configuration.

✓ AI provider abstraction.

✓ Prompt construction.

✓ Context construction.

✓ Output validation.

✓ Invalid AI output.

✓ AI timeout.

✓ AI failure.

✓ Rate limiting.

✓ Unknown requirement handling.

Automated tests must mock/fake external AI calls rather than depend on the live Groq API.

---

## Security

Verify:

✓ CSRF.

✓ Session access.

✓ Session ownership.

✓ Rate limiting.

✓ AI key protection.

✓ Output escaping.

✓ Duplicate submission protection.

✓ Submitted-session protection.

---

## Accessibility

Verify:

✓ Keyboard navigation.

✓ Focus states.

✓ Form labels.

✓ Error announcements.

✓ Heading structure.

✓ AI loading/error announcements.

---

## Responsive

Verify:

✓ Mobile.

✓ Tablet.

✓ Desktop.

---

## Regression

Run the existing SMEvolve test suite and verify that the Quote Wizard does not break existing functionality.

At minimum verify:

* Global navigation.
* Footer.
* Legal pages.
* Shared components.
* Existing forms.
* SEO system.
* Existing JavaScript.
* Existing database functionality.

---

# Acceptance Criteria

The Quote Wizard implementation is accepted only when:

✓ All required routes work.

✓ Quote sessions work correctly.

✓ All documented question types work.

✓ Answers persist correctly.

✓ Conditional flow works.

✓ Review works.

✓ Consent is enforced.

✓ Quote submission is transactional.

✓ Unique reference is generated.

✓ Confirmation works.

✓ Duplicate submission is prevented.

✓ Groq AI works through the server-side architecture.

✓ AI failures do not block quote completion.

✓ AI suggestions require user confirmation.

✓ AI output is validated.

✓ AI rate limiting works.

✓ No AI credentials are exposed.

✓ Accessibility requirements pass.

✓ Responsive requirements pass.

✓ Security requirements pass.

✓ Automated tests pass.

✓ Regression tests pass.

✓ No critical unresolved implementation issues remain.

---

# Deliverables

After implementation provide:

## Summary

Explain what was implemented.

---

## Files Created

List all new files.

---

## Files Modified

List all modified files.

---

## Database Changes

List:

* Migrations.
* Tables.
* Relationships.
* Indexes.

---

## Models

List all Quote Wizard models created or modified.

---

## Services

List all services created or modified.

---

## Controllers

List all controllers created or modified.

---

## Routes

List all Quote Wizard routes implemented.

---

## Components

List:

* Blade components.
* Alpine.js components.
* Shared components reused.

---

## AI Implementation

List:

* AI services.
* Groq integration.
* Prompt files.
* Prompt versions.
* AI endpoints.
* AI validation.
* Rate limiting.

---

## Configuration

List:

* Environment variables.
* AI configuration.
* Quote Wizard configuration.
* Any other configuration changes.

Do not expose secret values.

---

## Testing Results

Provide:

* Functional results.
* Validation results.
* AI results.
* Security results.
* Accessibility results.
* Responsive results.
* Performance results.
* Regression results.

Clearly identify:

```text
PASS
FAIL
BLOCKED
```

---

# Implementation Rules

The AI implementation system must:

1. Read all required documentation before implementation.

2. Inspect the existing codebase before creating files.

3. Reuse existing architecture where appropriate.

4. Avoid unnecessary dependencies.

5. Follow Laravel 12 conventions.

6. Follow the existing SMEvolve design system.

7. Keep controllers lightweight.

8. Keep business logic in services.

9. Keep presentation logic in Blade.

10. Keep UI behavior in Alpine.js.

11. Keep Groq credentials server-side.

12. Validate all AI output.

13. Never automatically trust AI-generated requirements.

14. Preserve user control over AI suggestions.

15. Never compromise the core Quote Wizard when AI is unavailable.

16. Never expose sensitive information in errors or logs.

17. Run tests before declaring completion.

18. Do not mark incomplete functionality as complete.

---

# Future Compatibility

The implementation should leave room for future:

* Admin quote management.
* Quote status management.
* Internal notes.
* Official quotation generation.
* CRM integrations.
* Email automation.
* Additional AI providers.
* AI analytics.
* Advanced estimation systems.

Do not implement these unless explicitly included in the current approved scope.

---

# Stop Condition

Stop after completing and testing the Quote Wizard.

Do not begin:

* Admin Portal.
* Client Portal.
* Deployment.
* Subscription system.
* CRM.
* Contract generation.

Those modules will be handled separately.

The Quote Wizard implementation is complete only after the acceptance criteria have been verified and the implementation/testing report has been provided.
