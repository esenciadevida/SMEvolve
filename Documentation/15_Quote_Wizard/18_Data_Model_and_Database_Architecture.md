# SMEvolve Quote Wizard

## Part 18 – Data Model & Database Architecture

**Project:** SMEvolve

**Framework:** Laravel 12

**Database:** Laravel-compatible relational database

**Frontend:** Blade, Vite, Alpine.js

**AI Provider:** Groq

**Module:** Quote Wizard

**Version:** 1.0

**Document Type:** Data Model & Database Architecture Specification

---

# Objective

Define the database architecture required to support the SMEvolve Quote Wizard.

The architecture must support:

* Quote sessions.
* Progressive answers.
* Dynamic requirements.
* Contact information.
* AI-assisted interactions.
* Review and submission.
* Consent records.
* Quote references.
* Future administrative management.

The database must remain flexible enough to support future changes without requiring a complete redesign.

---

# Architecture Principles

The database must follow:

1. Normalized relational design.
2. Clear foreign-key relationships.
3. Minimal duplication.
4. Server-side data integrity.
5. Configurable wizard questions.
6. Support for conditional questions.
7. Secure public references.
8. AI interaction separation.
9. Consent versioning.
10. Future Admin Portal compatibility.

---

# Core Entities

The initial Quote Wizard data model consists of:

```text
Quote Session
Question
Question Option
Answer
Requirement
Quote Requirement
AI Interaction
Quote Submission
Consent
```

Conceptually:

```text
Quote Session
     │
     ├── Answers
     │
     ├── Requirements
     │
     ├── AI Interactions
     │
     ├── Submission
     │
     └── Consent
```

---

# 1. Quote Sessions

Primary table:

```text
quote_sessions
```

This represents a user's active Quote Wizard journey.

---

# Quote Session Fields

Recommended fields:

```text
id
public_id
status
current_step
project_type
started_at
last_activity_at
completed_at
expires_at
created_at
updated_at
```

---

# Primary Key

Use an internal database ID:

```text
id
```

The internal ID must not be exposed publicly.

---

# Public ID

Use:

```text
public_id
```

for public-facing quote references/session identifiers.

It must be:

* Unique.
* Unpredictable.
* Non-sequential.
* Free from personal information.

---

# Session Status

Recommended statuses:

```text
draft
review
submitted
expired
abandoned
```

Future statuses may be added through controlled application logic.

---

# Current Step

Store the user's current logical wizard position.

Example:

```text
current_step = 4
```

This allows the wizard to resume progress.

---

# Project Type

The initial project type may be stored directly on the quote session.

Examples:

```text
website
web_application
mobile_application
software
ecommerce
other
```

The actual values must follow the final Quote Wizard configuration.

---

# Session Timestamps

Maintain:

```text
started_at
last_activity_at
completed_at
expires_at
```

These support:

* Session recovery.
* Abandonment tracking.
* Retention.
* Analytics.
* Administrative reporting.

---

# Session Expiration

A draft session should have a configurable expiration period.

Expired sessions must not remain indefinitely accessible.

---

# 2. Questions

Primary table:

```text
quote_questions
```

This stores the questions used by the wizard.

---

# Question Fields

Recommended:

```text
id
key
type
label
description
placeholder
validation_rules
options_source
is_required
is_active
sort_order
created_at
updated_at
```

---

# Question Key

Every question should have a stable key.

Examples:

```text
project_type
project_description
business_name
target_users
required_features
timeline
budget
contact_name
contact_email
contact_phone
additional_notes
```

The key should remain stable even if the visible question changes.

---

# Question Type

Possible values:

```text
single_choice
multiple_choice
text
textarea
email
phone
number
```

Additional types may be introduced later.

---

# Validation Rules

Validation requirements should be defined centrally.

Where appropriate, configuration may contain:

```text
required
min
max
email
regex
```

However, critical validation must ultimately be enforced by Laravel.

---

# Active Questions

Use:

```text
is_active
```

rather than deleting questions that may have historical relevance.

This helps preserve historical quote data.

---

# Question Ordering

Use:

```text
sort_order
```

for the default question sequence.

Conditional logic determines whether a question is actually shown.

---

# 3. Question Options

Primary table:

```text
quote_question_options
```

This stores selectable answers for choice-based questions.

---

# Option Fields

Recommended:

```text
id
question_id
key
label
description
icon
sort_order
is_active
created_at
updated_at
```

---

# Example

Question:

```text
project_type
```

Options:

```text
website
web_application
mobile_application
ecommerce
custom_software
```

---

# Stable Option Keys

Use stable keys rather than relying on labels.

Example:

```text
key = mobile_application
label = Mobile App
```

The label may change later without breaking historical data.

---

# 4. Answers

Primary table:

```text
quote_answers
```

This stores answers provided during a quote session.

---

# Answer Fields

Recommended:

```text
id
quote_session_id
question_id
value
created_at
updated_at
```

---

# Answer Value

The `value` field may use JSON where necessary.

This supports:

### Single choice

```json
"website"
```

### Multiple choice

```json
[
    "payments",
    "notifications",
    "accounts"
]
```

### Text

```json
"An online booking platform..."
```

---

# Why JSON?

JSON provides flexibility for different answer types without creating a separate table for every input type.

However, frequently queried business information should still be represented through proper relational columns where appropriate.

---

# Answer Uniqueness

A session should normally have one current answer per question.

Recommended constraint:

```text
unique(
    quote_session_id,
    question_id
)
```

Updating an answer should modify the existing record rather than create unnecessary duplicates.

---

# Historical Answer Changes

The initial implementation does not require complete answer version history.

However, the architecture should allow future support for:

```text
old value
new value
changed_at
changed_by
```

if audit requirements increase.

---

# 5. Requirements

Primary table:

```text
quote_requirements
```

This represents standardized features/requirements that can be selected by users or suggested by AI.

---

# Requirement Fields

Recommended:

```text
id
key
name
description
category
is_active
sort_order
created_at
updated_at
```

---

# Example Requirements

```text
customer_accounts
payments
notifications
booking
analytics
admin_dashboard
search
reviews
```

The actual catalog should be controlled by SMEvolve's Quote Wizard configuration.

---

# Requirement Categories

Potential categories:

```text
user_features
business_features
payments
communication
administration
analytics
integrations
security
```

---

# Requirement Status

A requirement in the catalog does not automatically mean the client selected it.

Selection belongs to the relationship between:

```text
quote_session
```

and:

```text
quote_requirement
```

---

# 6. Quote Requirements

Primary table:

```text
quote_session_requirements
```

This links requirements to a specific quote session.

---

# Fields

Recommended:

```text
id
quote_session_id
quote_requirement_id
source
status
notes
created_at
updated_at
```

---

# Source

Possible values:

```text
user
ai
system
```

---

# Status

Possible values:

```text
suggested
selected
confirmed
removed
```

---

# AI Requirement Flow

Example:

```text
AI suggests:
Payments

source = ai
status = suggested
```

User accepts:

```text
source = ai
status = confirmed
```

This preserves the distinction between AI suggestion and confirmed requirement.

---

# User Requirement

If the user directly selects a feature:

```text
source = user
status = confirmed
```

---

# Removed Requirement

If a user removes a previously selected feature:

```text
status = removed
```

Depending on the final implementation, historical records may be retained rather than physically deleted.

---

# 7. AI Interactions

Primary table:

```text
quote_ai_interactions
```

This records AI-assisted operations associated with a quote session.

---

# Fields

Recommended:

```text
id
quote_session_id
operation
provider
model
prompt_version
status
input_hash
input_tokens
output_tokens
duration_ms
created_at
completed_at
```

---

# AI Operation

Examples:

```text
description_assistance
feature_suggestions
clarification
project_analysis
project_summary
```

---

# AI Provider

Example:

```text
groq
```

Do not assume Groq will always be the only provider.

---

# AI Model

Store the model used for the interaction.

This supports future auditing and comparison.

---

# Prompt Version

Example:

```text
feature_suggestions_v1
```

This is important for determining which instructions produced a response.

---

# AI Status

Recommended:

```text
pending
completed
failed
timeout
rate_limited
```

---

# Input Hash

A hash may be stored to identify repeated identical requests without storing unnecessary copies of the full prompt.

Example:

```text
input_hash
```

---

# Token Usage

Where the provider exposes usage information, store:

```text
input_tokens
output_tokens
```

These support:

* Cost monitoring.
* Usage analysis.
* Optimization.

---

# AI Response Storage

Raw AI responses should not automatically be stored indefinitely.

If the application needs the response for the active interaction, it may be stored in a controlled field or separate response structure.

Potential future field:

```text
response
```

If stored, it must follow the retention and privacy requirements.

---

# AI Privacy

Do not store unnecessary:

* Contact information.
* Sensitive information.
* Authentication data.

---

# 8. Quote Submission

Primary table:

```text
quote_submissions
```

A submission represents the final request sent to SMEvolve.

---

# Fields

Recommended:

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

The reference should be:

* Unique.
* Human-readable.
* Safe to share.
* Not based directly on a database ID.

---

# Submission Status

Recommended:

```text
submitted
under_review
quoted
completed
cancelled
```

Future statuses may be added.

---

# One Submission Per Session

A quote session should normally produce one official submission.

Use database/application constraints to prevent accidental duplicates.

---

# Idempotency

The final submission operation must be idempotent.

If the user clicks the button twice:

```text
Request My Quote
Request My Quote
```

only one submission should be created.

---

# 9. Contact Information

Contact details may initially live within the quote submission/session architecture.

Recommended fields:

```text
contact_name
contact_email
contact_phone
preferred_contact_method
```

The final implementation should avoid duplicating these fields unnecessarily across multiple tables.

---

# Recommended Approach

Because contact information belongs to the quote request, it may be stored in:

```text
quote_submissions
```

rather than being repeated in every answer record.

---

# Contact Email

Store normalized email where appropriate.

Validation must occur server-side.

---

# Contact Phone

Store the submitted phone number in a normalized format where practical.

The application should not silently alter a user's number in a way that changes its meaning.

---

# Contact Data Security

Contact data must not appear in:

* Public URLs.
* Analytics events.
* AI prompts by default.
* Public API responses.

---

# 10. Consent

Primary table:

```text
quote_consents
```

This stores legal acknowledgements associated with a quote submission.

---

# Fields

Recommended:

```text
id
quote_session_id
quote_submission_id
consent_type
document
document_version
accepted
accepted_at
created_at
```

---

# Consent Type

Examples:

```text
terms
privacy
```

---

# Document

Example:

```text
terms
privacy_policy
```

---

# Document Version

Example:

```text
1.0
```

This allows SMEvolve to know which legal version the user accepted.

---

# Accepted

Store explicit acceptance:

```text
accepted = true
```

Do not infer consent merely because the user submitted a quote.

---

# Consent Timestamp

Store:

```text
accepted_at
```

using a consistent server-side timestamp.

---

# 11. Conditional Logic

The database should support dynamic question flows.

Example:

```text
Project Type = Mobile App
        ↓
Show:
App Platforms
App Features
App Distribution
```

Where:

```text
Project Type = Website
```

those questions may not appear.

---

# Conditional Rules

Conditional logic should not require modifying database schema every time a new condition is introduced.

Possible future structure:

```text
quote_question_rules
```

Fields:

```text
id
question_id
depends_on_question_id
operator
value
action
```

---

# Initial Recommendation

If the first Quote Wizard contains relatively few conditional rules, logic may initially remain in application configuration rather than introducing a complex rule engine.

The architecture should allow migration to a rule table if complexity grows.

---

# 12. Soft Deletes

Use soft deletes selectively.

Potential candidates:

```text
quote_questions
quote_question_options
quote_requirements
```

This protects historical references.

Do not automatically soft-delete transactional quote records unless there is a clear business requirement.

---

# 13. Timestamps

All core tables should use Laravel timestamps:

```text
created_at
updated_at
```

Transactional entities may also require domain-specific timestamps.

---

# 14. Foreign Keys

Relationships should use foreign keys.

Examples:

```text
quote_answers.quote_session_id
    → quote_sessions.id

quote_answers.question_id
    → quote_questions.id

quote_question_options.question_id
    → quote_questions.id

quote_session_requirements.quote_session_id
    → quote_sessions.id

quote_session_requirements.quote_requirement_id
    → quote_requirements.id

quote_ai_interactions.quote_session_id
    → quote_sessions.id

quote_submissions.quote_session_id
    → quote_sessions.id

quote_consents.quote_session_id
    → quote_sessions.id
```

---

# Referential Integrity

Foreign keys should prevent orphaned transactional records.

Deletion behavior must be chosen carefully.

For example, deleting a quote session should not accidentally destroy required legal records unless explicitly intended.

---

# 15. Indexing

Important indexes include:

```text
quote_sessions.public_id
quote_sessions.status
quote_sessions.expires_at

quote_questions.key
quote_questions.is_active

quote_question_options.question_id

quote_answers.quote_session_id
quote_answers.question_id

quote_requirements.key
quote_requirements.is_active

quote_session_requirements.quote_session_id

quote_ai_interactions.quote_session_id
quote_ai_interactions.operation
quote_ai_interactions.created_at

quote_submissions.quote_session_id
quote_submissions.reference
quote_submissions.status

quote_consents.quote_session_id
quote_consents.quote_submission_id
```

---

# Unique Constraints

Recommended:

```text
quote_sessions.public_id
quote_questions.key
quote_question_options.(question_id, key)
quote_requirements.key
quote_submissions.reference
quote_answers.(quote_session_id, question_id)
```

---

# 16. Example Relationship Structure

```text
QuoteSession
│
├── hasMany Answers
│       │
│       └── belongsTo Question
│
├── belongsToMany Requirements
│       │
│       └── through QuoteSessionRequirement
│
├── hasMany AIInteractions
│
├── hasOne Submission
│       │
│       └── hasMany Consents
│
└── hasMany Consents
```

---

# 17. Laravel Models

Suggested models:

```text
app/Models/
├── QuoteSession.php
├── QuoteQuestion.php
├── QuoteQuestionOption.php
├── QuoteAnswer.php
├── QuoteRequirement.php
├── QuoteSessionRequirement.php
├── QuoteAIInteraction.php
├── QuoteSubmission.php
└── QuoteConsent.php
```

---

# 18. Model Relationships

## QuoteSession

Should provide relationships to:

```text
answers()
requirements()
aiInteractions()
submission()
consents()
```

---

## QuoteQuestion

Should provide:

```text
options()
answers()
```

---

## QuoteAnswer

Should provide:

```text
session()
question()
```

---

## QuoteRequirement

Should provide:

```text
quoteSessions()
```

through the relationship table.

---

## QuoteAIInteraction

Should provide:

```text
session()
```

---

## QuoteSubmission

Should provide:

```text
session()
consents()
```

---

# 19. Database Transactions

Critical operations should use database transactions.

Especially:

```text
Final quote submission
Consent recording
Requirement confirmation
```

---

# Submission Transaction

Conceptually:

```text
BEGIN
 ↓
Validate session
 ↓
Validate answers
 ↓
Validate consent
 ↓
Create submission
 ↓
Create consent records
 ↓
Mark session submitted
 ↓
COMMIT
```

If any critical operation fails:

```text
ROLLBACK
```

---

# 20. Draft Persistence

Answers should be persisted progressively.

Example:

```text
Step 1
 ↓
Save

Step 2
 ↓
Save

Step 3
 ↓
Save
```

This prevents loss of progress.

---

# 21. Data Integrity

The server must ensure that:

* Question IDs are valid.
* Option IDs belong to the correct question.
* Requirements exist.
* Requirements are active where required.
* Answers match expected question types.
* Submission belongs to the correct session.
* Consent belongs to the relevant submission/session.

---

# 22. Historical Data

Submitted quote data should remain understandable even if configuration changes later.

For example, if the label:

```text
Mobile Application
```

changes to:

```text
Mobile App Development
```

historical submissions should still retain enough information to understand what the user selected.

Stable keys are therefore essential.

---

# 23. Snapshot Strategy

For important final submission information, consider storing a snapshot of the final confirmed quote information.

This protects historical records from future configuration changes.

Possible future field:

```text
submission_snapshot
```

stored as JSON.

---

# Snapshot Contents

A final snapshot may contain:

```text
Project Type
Project Description
Confirmed Requirements
Timeline
Budget
Contact Details
Additional Information
```

The snapshot should be created at submission time.

---

# 24. Why Snapshot Data Matters

Suppose:

```text
2026:
Requirement = Customer Accounts
```

Later:

```text
2027:
Requirement renamed
```

The original submission should still clearly show what the client requested in 2026.

---

# 25. Privacy and Retention

The database architecture must support:

* Retention periods.
* Data deletion.
* Anonymization.
* Consent records.
* Expired sessions.

Personal information must not be retained indefinitely without a valid purpose.

---

# 26. Admin Compatibility

The database should be designed so the future Admin Portal can manage:

```text
Quote submissions
Quote status
Requirements
AI usage
Contact information
Internal notes
```

However, the Quote Wizard database must not depend on the Admin Portal being implemented.

---

# 27. Internal Notes

Internal administrative notes should not be stored in public Quote Wizard answer fields.

Future table:

```text
quote_internal_notes
```

may be introduced for Admin functionality.

This should be handled separately from user-provided data.

---

# 28. Future Quote Lifecycle

The architecture should support:

```text
Draft
  ↓
Submitted
  ↓
Under Review
  ↓
Quoted
  ↓
Accepted / Declined
  ↓
Completed
```

The Quote Wizard itself only needs to create the initial submission.

---

# 29. Migration Order

Recommended migration order:

```text
1. quote_sessions
2. quote_questions
3. quote_question_options
4. quote_answers
5. quote_requirements
6. quote_session_requirements
7. quote_ai_interactions
8. quote_submissions
9. quote_consents
```

This order respects core relationships.

---

# 30. Seed Data

The implementation should provide seeders for:

* Questions.
* Question options.
* Requirements.

Seed data should use stable keys.

Example:

```text
project_type
project_description
timeline
budget
contact_name
contact_email
contact_phone
```

---

# 31. Configuration vs Database

Not everything needs to be stored in the database.

Use configuration for:

```text
Wizard flow rules
AI prompt versions
Provider configuration
Default UI behavior
```

Use database records for:

```text
User answers
Quote sessions
Submissions
Consent
AI interaction metadata
```

This avoids turning the database into an unnecessary CMS.

---

# 32. JSON Usage Rules

JSON should be used where the structure is genuinely variable.

Good:

```text
Multiple-choice answer values
Submission snapshots
Flexible AI metadata
```

Avoid using JSON for information that requires frequent relational querying.

---

# 33. Security Requirements

Database implementation must ensure:

✓ No public sequential identifiers.

✓ Mass assignment protection.

✓ Foreign-key integrity.

✓ Server-side validation.

✓ Protected contact data.

✓ No API secrets stored in quote records.

✓ No unnecessary AI prompt storage.

✓ Restricted administrative access.

---

# 34. Testing Requirements

Database tests must verify:

### Sessions

✓ Session creation.

✓ Unique public ID.

✓ Status transitions.

✓ Expiration.

---

### Questions

✓ Question creation.

✓ Option relationships.

✓ Active/inactive behavior.

---

### Answers

✓ Correct session relationship.

✓ Correct question relationship.

✓ Duplicate answer prevention.

✓ JSON values.

---

### Requirements

✓ Requirement catalog.

✓ Session requirement relationship.

✓ AI suggestion status.

✓ User confirmation.

---

### AI

✓ Interaction creation.

✓ Provider/model recording.

✓ Prompt version.

✓ Status changes.

---

### Submission

✓ Unique reference.

✓ One submission per session.

✓ Duplicate submission protection.

✓ Transaction rollback.

---

### Consent

✓ Correct document version.

✓ Acceptance timestamp.

✓ Submission relationship.

---

# 35. Success Criteria

The data architecture is successful when:

✓ Quote sessions can be created and resumed.

✓ Answers can be saved progressively.

✓ Questions and options are configurable.

✓ Conditional flows can be supported.

✓ Requirements are separated from user selections.

✓ AI suggestions are distinguishable from confirmed requirements.

✓ AI interactions can be tracked safely.

✓ Final submissions have unique references.

✓ Consent versions are recorded.

✓ Historical submissions remain understandable.

✓ Database relationships maintain integrity.

✓ The architecture supports the future Admin Portal.

✓ The design does not unnecessarily lock SMEvolve into Groq.

✓ Personal information can be managed according to the Privacy Policy.

---

# Stop Condition

This document defines the Quote Wizard database and data architecture.

It does not implement:

* Migrations.
* Models.
* Seeders.
* Controllers.
* Blade components.
* Alpine.js.
* Groq API integration.
* Admin Portal.
* Deployment.

Those will be handled in subsequent implementation documents.
