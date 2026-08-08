# SMEvolve Quote Wizard

## Part 13 – Data Model & Database Architecture

**Project:** SMEvolve

**Framework:** Laravel 12

**Database:** Laravel-supported relational database

**Frontend:** Blade, Vite, Alpine.js

**AI Provider:** Groq

**Module:** Quote Wizard

**Version:** 1.0

**Document Type:** Data Model & Database Architecture Specification

---

# Objective

Define the data architecture required to support the SMEvolve Quote Wizard.

The database must support:

* Quote sessions.
* User answers.
* Contact information.
* Project requirements.
* AI interactions.
* AI suggestions.
* Quote submissions.
* Status tracking.
* Consent records.
* Future Admin Portal management.

The architecture must remain flexible enough for the Quote Wizard to evolve without requiring major database restructuring.

---

# Core Data Principle

The database must distinguish between:

```text
User-provided information
        ↓
AI-generated suggestions
        ↓
User-confirmed requirements
        ↓
Admin/internal information
```

These must not be treated as the same type of data.

---

# High-Level Architecture

```text
Quote Session
      │
      ├── Answers
      │
      ├── Requirements
      │
      ├── AI Interactions
      │
      ├── Consent
      │
      └── Quote Submission
                │
                └── Contact Information
```

---

# Core Entities

Initial entities:

```text
quote_sessions
quote_answers
quote_requirements
ai_interactions
quote_consents
quote_submissions
```

The exact table names may follow existing SMEvolve naming conventions.

---

# 1. Quote Sessions

The Quote Session represents the user's progress through the wizard.

Suggested table:

```text
quote_sessions
```

---

# Purpose

Stores:

* Session identity.
* Wizard progress.
* Session status.
* Creation time.
* Last activity.
* Expiration information.

---

# Suggested Fields

```text
id
public_token
status
current_step
last_activity_at
expires_at
created_at
updated_at
```

---

# Primary Key

Use a standard internal database primary key.

The internal ID must not be exposed as the public session identifier.

---

# Public Token

Use a secure random token.

Example:

```text
public_token
```

Purpose:

Allow the application to associate public requests with the correct quote session without exposing sequential IDs.

---

# Session Status

Initial statuses:

```text
draft
in_progress
review
submitted
abandoned
expired
```

Future statuses may be introduced.

---

# Status Flow

```text
draft
  ↓
in_progress
  ↓
review
  ↓
submitted
```

Alternative:

```text
in_progress
  ↓
abandoned
```

or:

```text
in_progress
  ↓
expired
```

---

# Current Step

Store the user's current logical wizard step.

Example:

```text
current_step = 4
```

This allows session recovery.

---

# Activity Timestamp

Track:

```text
last_activity_at
```

This supports:

* Session expiration.
* Abandonment analysis.
* Security monitoring.

---

# 2. Quote Answers

Suggested table:

```text
quote_answers
```

Purpose:

Store answers provided during the wizard.

---

# Why Separate Answers?

The wizard contains dynamic questions.

A rigid database structure containing columns such as:

```text
project_type
budget
timeline
...
```

would make future questions difficult to add.

Instead, use a flexible answer architecture.

---

# Suggested Fields

```text
id
quote_session_id
question_key
answer_type
answer_value
source
created_at
updated_at
```

---

# Question Key

Example:

```text
project_type
project_description
target_audience
timeline
budget
```

The key should correspond to the configured question.

---

# Answer Type

Examples:

```text
single_choice
multiple_choice
text
textarea
number
email
phone
boolean
```

---

# Answer Value

The answer value may be stored in a suitable serialized/JSON representation where necessary.

Examples:

Single choice:

```text
web_application
```

Multiple choice:

```json
[
    "payments",
    "notifications",
    "user_accounts"
]
```

Text:

```text
I want to build an online booking platform.
```

---

# Source

The system must distinguish where an answer originated.

Possible values:

```text
user
ai
system
admin
```

However, AI-generated information should not automatically become a confirmed user answer.

---

# Confirmed Answers

A more precise architecture may use:

```text
source
status
```

Example:

```text
source = ai
status = suggested
```

and after user confirmation:

```text
source = ai
status = accepted
```

The final implementation should preserve this distinction.

---

# 3. Quote Requirements

Suggested table:

```text
quote_requirements
```

Purpose:

Store project features or requirements that become part of the client's confirmed project scope.

---

# Why Separate Requirements?

A selected feature such as:

```text
Online Payments
```

is conceptually different from a free-text answer.

Separating requirements makes future admin assessment easier.

---

# Suggested Fields

```text
id
quote_session_id
requirement_key
name
description
source
status
created_at
updated_at
```

---

# Requirement Source

Possible values:

```text
user
ai
admin
```

---

# Requirement Status

Initial values:

```text
suggested
confirmed
removed
```

---

# Requirement Flow

```text
AI suggests feature
       ↓
suggested
       ↓
User accepts
       ↓
confirmed
```

If rejected:

```text
suggested
       ↓
removed
```

---

# Requirement Example

```text
requirement_key:
online_payments

name:
Online Payments

source:
ai

status:
confirmed
```

---

# 4. AI Interactions

Suggested table:

```text
ai_interactions
```

Purpose:

Record AI requests and their outcomes.

---

# Suggested Fields

```text
id
quote_session_id
operation
provider
model
prompt_version
request_hash
status
input_tokens
output_tokens
response_data
error_code
created_at
updated_at
```

Some fields may depend on the final Groq integration.

---

# Operation

Examples:

```text
description_assistance
feature_suggestions
clarification
project_analysis
project_summary
```

---

# Provider

Initial:

```text
groq
```

This allows future provider expansion.

---

# Model

Store the model used for the request.

Example:

```text
configured-model-name
```

Do not hardcode the model name into business logic.

---

# Prompt Version

Example:

```text
description_assistance_v1
```

This allows AI behavior to be traced over time.

---

# Request Hash

An optional hash can help detect duplicate AI requests.

Example:

```text
request_hash
```

The hash must not itself expose sensitive information.

---

# AI Status

Possible values:

```text
pending
processing
completed
failed
timeout
rate_limited
```

---

# Token Metadata

If Groq provides token usage information, it may be stored for monitoring and cost analysis.

Example:

```text
input_tokens
output_tokens
```

These fields are optional and should only be stored if useful.

---

# AI Response

Structured AI output may be stored as JSON.

Example:

```json
{
    "summary": "...",
    "suggestions": [],
    "missing_information": []
}
```

Do not store raw provider responses unless there is a clear operational reason.

---

# AI Error

Store safe internal error information.

Example:

```text
error_code:
provider_timeout
```

Do not store API credentials or unnecessary sensitive provider payloads.

---

# 5. Quote Consent

Suggested table:

```text
quote_consents
```

Purpose:

Record legal consent associated with the quote submission.

---

# Suggested Fields

```text
id
quote_session_id
consent_type
consent_version
given
given_at
created_at
updated_at
```

---

# Consent Type

Examples:

```text
terms
privacy
```

A future consent type can be added if required.

---

# Consent Version

The legal document version accepted by the user must be recorded.

Example:

```text
privacy_version = 1.0
terms_version = 1.0
```

This supports future legal document changes.

---

# Consent Timestamp

Store:

```text
given_at
```

Use the server-side timestamp.

Do not rely solely on the browser's local time.

---

# 6. Quote Submissions

Suggested table:

```text
quote_submissions
```

Purpose:

Represent the final quote request submitted by the user.

---

# Why Separate Submission From Session?

A user may begin a session without submitting it.

The submission represents the completed request.

This makes reporting and administration clearer.

---

# Suggested Fields

```text
id
quote_session_id
reference
status
submitted_at
created_at
updated_at
```

---

# Reference

Example:

```text
SME-2026-001245
```

The reference must be unique.

It is intended for communication and administration.

It is not an authentication credential.

---

# Submission Status

Initial values:

```text
new
reviewing
contacted
qualified
quoted
won
lost
cancelled
```

These statuses are particularly useful for the future Admin Portal.

---

# Status Ownership

The public Quote Wizard may create:

```text
new
```

Administrative statuses should be controlled by the Admin Portal.

The public user must never be able to set:

```text
won
lost
quoted
qualified
```

---

# 7. Contact Information

Contact information may be stored either directly on `quote_submissions` or in a separate table.

For the initial architecture, a dedicated contact entity may be preferable if the data is expected to evolve.

Possible table:

```text
quote_contacts
```

---

# Suggested Fields

```text
id
quote_submission_id
full_name
email
phone
preferred_contact_method
preferred_contact_time
created_at
updated_at
```

---

# Contact Information Principle

Contact information should only be collected near the end of the wizard.

It should not be unnecessarily sent to AI.

---

# 8. Relationships

High-level relationship:

```text
QuoteSession
    │
    ├── hasMany QuoteAnswer
    │
    ├── hasMany QuoteRequirement
    │
    ├── hasMany AIInteraction
    │
    ├── hasMany QuoteConsent
    │
    └── hasOne QuoteSubmission
              │
              └── hasOne QuoteContact
```

---

# Laravel Model Relationships

Conceptually:

```php
QuoteSession
    ->hasMany(QuoteAnswer::class)

QuoteSession
    ->hasMany(QuoteRequirement::class)

QuoteSession
    ->hasMany(AIInteraction::class)

QuoteSession
    ->hasMany(QuoteConsent::class)

QuoteSession
    ->hasOne(QuoteSubmission::class)
```

The exact implementation should follow existing model conventions.

---

# 9. Data Ownership

The system must distinguish:

## Customer Data

```text
Contact
Project description
Answers
Requirements
```

---

## AI Data

```text
Suggestions
Summaries
AI metadata
```

---

## Administrative Data

Future Admin Portal may contain:

```text
Internal notes
Assessment
Assigned staff
Internal pricing
Follow-up status
```

Administrative information must not be stored as ordinary public answers.

---

# 10. Public vs Internal Data

Public-facing data:

```text
Project information
Confirmed requirements
Submission reference
```

Internal data:

```text
AI analysis
Internal notes
Assessment
Staff assignment
Internal pricing
```

The public Quote Wizard must not expose internal information.

---

# 11. JSON Usage

JSON may be used where the structure is genuinely dynamic.

Good use:

```text
Multiple-choice answer values
AI structured response
Configurable metadata
```

Avoid putting the entire quote into one giant JSON column.

---

# 12. Normalization

Core relational information should remain queryable.

For example:

Do not store the entire quote as:

```json
{
    "project_type": "...",
    "budget": "...",
    "timeline": "..."
}
```

inside one database field if those values need to be filtered, reported, or administered regularly.

Use structured records where appropriate.

---

# 13. Question Configuration

Questions should remain configuration-driven.

The database should store answers using:

```text
question_key
```

rather than requiring a new database column for every new question.

---

# 14. Indexing

Important indexes should include:

```text
quote_sessions.public_token
quote_sessions.status
quote_sessions.last_activity_at
quote_answers.quote_session_id
quote_answers.question_key
quote_requirements.quote_session_id
ai_interactions.quote_session_id
ai_interactions.status
quote_submissions.reference
quote_submissions.status
quote_submissions.submitted_at
```

The exact indexes should be optimized after implementation.

---

# 15. Unique Constraints

Potential unique constraints:

```text
quote_sessions.public_token
quote_submissions.reference
```

Depending on answer strategy, the system may also enforce uniqueness for:

```text
quote_session_id + question_key
```

if only one active answer per question is expected.

---

# 16. Foreign Keys

Relationships should use database foreign keys.

Examples:

```text
quote_answers.quote_session_id
    → quote_sessions.id
```

and:

```text
quote_submissions.quote_session_id
    → quote_sessions.id
```

---

# 17. Delete Behavior

Quote data should not be casually deleted.

The final implementation must consider retention requirements.

Potential behavior:

```text
Quote Session
   ↓
Answers
   ↓
Requirements
   ↓
AI Interactions
```

should remain consistent when a session is deleted or anonymized.

---

# 18. Soft Deletes

Soft deletes may be appropriate for administrative records.

They should not be added blindly to every table.

The decision should consider:

* Privacy.
* Legal retention.
* Reporting.
* Operational requirements.

---

# 19. Data Retention

Retention periods should be configurable according to SMEvolve's privacy requirements.

Potential categories:

```text
Active Quote Data
Submitted Quote Data
Abandoned Sessions
AI Interaction Records
Consent Records
```

The final retention policy should align with the Legal module.

---

# 20. Data Anonymization

Where retention requires preservation of statistics without personal information, the system may anonymize contact information while retaining non-identifying quote data.

Example:

```text
Contact
    ↓
Anonymized

Project Statistics
    ↓
Retained
```

---

# 21. Auditability

Important administrative changes should eventually be auditable.

Examples:

```text
Status changed
Requirement changed
Admin note added
Quote assigned
```

A future audit architecture may be added with the Admin Portal.

---

# 22. Timestamps

All major entities should use:

```text
created_at
updated_at
```

Relevant entities should also have business timestamps such as:

```text
submitted_at
last_activity_at
expires_at
given_at
```

---

# 23. Timezone

Store timestamps consistently using the application's configured timezone strategy.

Avoid relying on browser-local timestamps for authoritative records.

---

# 24. Database Transactions

Critical operations should use database transactions.

Especially:

```text
Quote Submission
Consent Recording
Final Requirement Confirmation
```

---

# 25. Submission Transaction

The final submission should conceptually be:

```text
BEGIN TRANSACTION

Validate session
Validate answers
Validate consent
Create submission
Create contact
Finalize requirements
Update session status

COMMIT
```

If something fails:

```text
ROLLBACK
```

The user should not receive a false success response.

---

# 26. Idempotency

Final submission must be protected against duplicate requests.

Possible mechanism:

```text
quote_session_id
+
submission state
+
idempotency protection
```

Only one final submission should normally be created for a quote session.

---

# 27. Data Validation

Database constraints should complement Laravel validation.

Application validation:

```text
Required
Format
Business Rules
```

Database constraints:

```text
Foreign Keys
Unique Values
Not Null
```

Neither layer should be relied upon exclusively.

---

# 28. Privacy

Only necessary information should be stored.

Do not create fields simply because they might be useful later.

---

# 29. Security

Sensitive information must not appear in:

* Public URLs.
* Error messages.
* Logs unnecessarily.
* AI prompts unnecessarily.

---

# 30. Future Admin Portal Compatibility

The database must support the future Admin Portal without requiring a redesign.

Admin should eventually be able to:

```text
View submissions
View project details
View requirements
View contact information
View AI-assisted analysis
Change quote status
Add internal notes
Assign follow-up
```

These capabilities must remain separated from public Quote Wizard permissions.

---

# 31. Future Pricing Engine Compatibility

The database should not assume that AI determines pricing.

Future architecture may introduce:

```text
QuoteSubmission
      ↓
Assessment
      ↓
Pricing Engine
      ↓
Admin Review
      ↓
Official Quote
```

No official pricing engine is implemented by this document.

---

# 32. Future Email Integration

The architecture should allow future records such as:

```text
quote_notifications
```

or integration with the global notification system.

Do not create unnecessary email tables now if the existing application already has a notification architecture.

---

# 33. Example Data Flow

A client starts:

```text
QuoteSession
status = draft
```

Client answers questions:

```text
QuoteAnswers
```

Client selects:

```text
QuoteRequirements
```

AI provides suggestions:

```text
AIInteractions
```

Client confirms requirements:

```text
QuoteRequirements
status = confirmed
```

Client accepts terms/privacy:

```text
QuoteConsents
```

Client submits:

```text
QuoteSubmission
status = new
```

Contact details are stored:

```text
QuoteContact
```

Session becomes:

```text
QuoteSession
status = submitted
```

---

# 34. Example Entity Map

```text
┌──────────────────────┐
│    quote_sessions    │
├──────────────────────┤
│ id                   │
│ public_token         │
│ status               │
│ current_step         │
│ last_activity_at     │
│ expires_at           │
└──────────┬───────────┘
           │
     ┌─────┼─────────────┬──────────────┐
     │     │             │              │
     ▼     ▼             ▼              ▼
 Answers Requirements AI Interactions Consents
     │
     │
     ▼
 Submission
     │
     ▼
 Contact
```

---

# 35. Model Naming

Suggested Laravel models:

```text
QuoteSession
QuoteAnswer
QuoteRequirement
AIInteraction
QuoteConsent
QuoteSubmission
QuoteContact
```

Names should be adjusted if SMEvolve already has equivalent domain models.

---

# 36. Migration Strategy

Create migrations in dependency order:

```text
1. quote_sessions
2. quote_answers
3. quote_requirements
4. ai_interactions
5. quote_consents
6. quote_submissions
7. quote_contacts
```

Foreign keys must reference tables that already exist.

---

# 37. Seed Data

The database should not require extensive seed data for user submissions.

Question content should preferably come from configuration/content architecture.

Only essential development/testing seed data should be introduced.

---

# 38. Testing Data

Development environments may contain:

```text
Test quote sessions
Test answers
Test AI interactions
Test submissions
```

Production must never contain artificial test submissions.

---

# 39. Data Model Success Criteria

The architecture is successful when:

✓ Quote sessions can be created and resumed.

✓ Answers can support dynamic questions.

✓ Requirements can be tracked separately.

✓ AI suggestions are distinguishable from user-confirmed data.

✓ Contact information is protected.

✓ Consent versions are recorded.

✓ Final submissions have unique references.

✓ Submission statuses support future administration.

✓ Duplicate submissions are prevented.

✓ Database relationships are clear.

✓ Data retention can be implemented.

✓ Future Admin Portal requirements are supported.

✓ Future pricing functionality can be added without redesigning the Quote Wizard.

✓ AI provider changes do not require a database redesign.

✓ Public and internal information remain logically separated.

---

# Stop Condition

This document defines the Quote Wizard data model and database architecture.

It does not implement:

* Laravel migrations.
* Eloquent models.
* Controllers.
* Routes.
* Blade components.
* Groq integration.
* Admin Portal.
* Pricing engine.
* Email system.

Those will be handled by subsequent implementation documents.
