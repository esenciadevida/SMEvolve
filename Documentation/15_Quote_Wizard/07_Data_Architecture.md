# SMEvolve Quote Wizard

## Part 07 – Data Architecture

**Project:** SMEvolve

**Framework:** Laravel 12

**Module:** Quote Wizard

**Version:** 1.0

**Document Type:** Data Architecture Specification

---

# Objective

Define the data architecture required to support the SMEvolve Quote Wizard.

The architecture must support:

* Multi-step quote sessions.
* User responses.
* Dynamic questions.
* Conditional questions.
* AI analysis.
* AI suggestions.
* User-confirmed information.
* Quote submissions.
* Lead status management.
* Internal assessment.
* Future pricing integration.
* Future Admin Portal integration.

The architecture must remain flexible enough to allow the Quote Wizard to evolve without requiring a complete database redesign.

---

# Core Data Principle

The system must distinguish between:

```text id="p1q7mu"
User-Provided Information
        ↓
AI Suggestions
        ↓
User-Confirmed Information
        ↓
System Assessment
        ↓
Admin Decisions
        ↓
Final Quote
```

These are different types of information and must not be stored as one uncontrolled data object.

---

# High-Level Architecture

```text id="s4j6oa"
Quote Session
      │
      ├── Answers
      │
      ├── AI Analyses
      │
      ├── AI Suggestions
      │
      ├── Assessment
      │
      └── Submission
              │
              └── Admin Processing
```

---

# Main Entities

The initial architecture should support the following entities:

```text id="a7bq0k"
quote_sessions
quote_answers
quote_ai_analyses
quote_assessments
quote_requests
```

Additional entities may be introduced where required by the existing SMEvolve architecture.

---

# 1. Quote Sessions

A quote session represents the user's active wizard journey before or during submission.

Suggested table:

```text id="d8l3w2"
quote_sessions
```

---

# Quote Session Purpose

A session allows the system to:

* Track wizard progress.
* Save answers.
* Resume progress where supported.
* Associate AI processing with a specific wizard attempt.
* Prevent mixing information between users.

---

# Quote Session Fields

Suggested structure:

```text id="9p5q0n"
id
session_token
current_step
status
started_at
last_activity_at
completed_at
created_at
updated_at
```

---

# Session ID

Use the standard database primary key.

The session token should be a separate secure identifier for client-side references where necessary.

Do not expose sequential database IDs unnecessarily.

---

# Session Token

The token should be:

* Cryptographically strong.
* Non-predictable.
* Unique.
* Safe for URL or API usage where necessary.

---

# Session Status

Possible values:

```text id="3w8e2f"
active
abandoned
completed
submitted
expired
```

The exact enum implementation should follow existing project conventions.

---

# Current Step

Store the user's current wizard position.

Example:

```text id="f9h3mz"
project_type
project_details
requirements
budget
timeline
contact
review
```

The implementation may use a step key rather than a numeric index.

A step key is preferable for dynamic flows.

---

# 2. Quote Answers

Suggested table:

```text id="c3x8tq"
quote_answers
```

This table stores answers provided during the wizard.

---

# Answer Fields

Suggested:

```text id="w7k3ra"
id
quote_session_id
question_key
value
value_type
source
is_confirmed
created_at
updated_at
```

---

# Question Key

Questions should use stable identifiers.

Example:

```text id="j1v9ka"
project_type
project_description
business_description
features
integrations
timeline
budget
name
email
phone
```

Do not use question text as the database identifier.

---

# Answer Value

The value may contain:

```text id="v0x8ls"
String
Number
Boolean
Array
JSON Object
```

Depending on the question.

---

# Value Type

Possible values:

```text id="k7m2sx"
string
number
boolean
array
object
```

The exact implementation should follow Laravel/database capabilities and existing project standards.

---

# Answer Source

Every answer should identify its origin.

Possible values:

```text id="v5n1cu"
user
ai
system
admin
```

However, AI-generated values should generally not become confirmed user answers automatically.

---

# Confirmation

The system should distinguish:

```text id="b3s8lp"
is_confirmed = true
```

from:

```text id="4w6p0a"
is_confirmed = false
```

Only confirmed information should be treated as authoritative user requirements.

---

# User Answer Priority

The data model should support:

```text id="x9a4lm"
User Confirmed
      >
AI Suggested
      >
System Inferred
```

---

# Multiple Answers

Some questions may allow multiple values.

Example:

```text id="l2z6qt"
features:
[
    "customer_accounts",
    "online_payments",
    "booking"
]
```

The architecture should support structured JSON where appropriate.

---

# 3. Quote AI Analyses

Suggested table:

```text id="y8k2fd"
quote_ai_analyses
```

This stores AI-generated analysis separately from the user's answers.

---

# Purpose

The table may store:

* Project classification.
* Suggested features.
* Suggested integrations.
* Missing information.
* Project summary.
* Complexity recommendation.
* AI metadata.

---

# AI Analysis Fields

Suggested:

```text id="m4r8cx"
id
quote_session_id
operation
provider
model
prompt_version
status
input_hash
result
confidence
error_code
processed_at
created_at
updated_at
```

---

# Operation

Identify what the AI was asked to do.

Examples:

```text id="e2d7hv"
project_analysis
feature_suggestions
clarification
summary
```

---

# Provider

Example:

```text id="4n7c1a"
groq
```

This makes future provider migration easier.

---

# Model

Store the model used for the AI operation.

Example:

```text id="n2s6pf"
model_name
```

Do not hardcode assumptions about the model.

---

# Prompt Version

Store the version of the prompt used.

Example:

```text id="q7m2yc"
v1.0
```

This provides traceability when prompts change.

---

# Analysis Status

Possible values:

```text id="x0r9mv"
pending
processing
completed
failed
skipped
```

---

# Result

Store structured AI output.

Example:

```json id="n8v5qt"
{
  "project_type": "ecommerce",
  "suggested_features": [
    "customer_accounts",
    "online_payments"
  ],
  "missing_information": [
    "payment_provider"
  ]
}
```

The application must validate this result before using it.

---

# Confidence

If used, store confidence as internal metadata.

Example:

```text id="6x3j1n"
confidence
```

Do not assume that AI confidence represents statistical certainty.

---

# Input Hash

An optional hash can identify the input used for an AI operation without storing duplicated content.

This can assist with:

* Deduplication.
* Debugging.
* Reprocessing.
* Auditing.

---

# AI Errors

Store safe error information.

Example:

```text id="2v8m4c"
error_code
```

Do not store API credentials or sensitive provider responses.

---

# 4. Quote Assessments

Suggested table:

```text id="e9q3xk"
quote_assessments
```

This stores structured system-level analysis of the project.

---

# Assessment Purpose

An assessment may contain:

```text id="q3r7sp"
project_type
complexity
scope_score
qualification_score
timeline_assessment
budget_assessment
missing_information
priority
```

---

# Assessment Fields

Suggested:

```text id="p8d2lv"
id
quote_request_id
project_type
complexity
scope_score
qualification_score
timeline_assessment
budget_assessment
priority
assessment_version
calculated_at
created_at
updated_at
```

---

# Scope Score

A numeric score may be stored internally.

Example:

```text id="m5q1yv"
0–100
```

The scoring model should be configurable.

---

# Qualification Score

If introduced, this should also remain an internal operational metric.

It must not determine the user's worth or automatically reject a request.

---

# Complexity

Possible values:

```text id="u6z3kt"
low
medium
high
very_high
requires_review
```

---

# Budget Assessment

Possible values:

```text id="c7v1xr"
unknown
provided
requires_review
potentially_suitable
```

Additional states can be added when an approved pricing system exists.

---

# Timeline Assessment

Possible values:

```text id="b8p2lm"
unknown
short
medium
long
requires_review
```

---

# Priority

Possible values:

```text id="z4n8cv"
low
normal
high
urgent
```

This is internal.

---

# Assessment Version

Every assessment should identify the rule version used.

Example:

```text id="k2q7sd"
assessment_version = "1.0"
```

This allows the system to understand how historical assessments were generated.

---

# 5. Quote Requests

Suggested table:

```text id="r7c1mv"
quote_requests
```

This represents the submitted quote request.

---

# Purpose

A quote request is the business record created when the user completes the Quote Wizard.

---

# Quote Request Fields

Suggested:

```text id="x4n8qp"
id
quote_reference
quote_session_id
status
name
email
phone
submitted_at
created_at
updated_at
```

---

# Quote Reference

Each submitted request should receive a human-readable reference.

Example:

```text id="v3m9ka"
SME-2026-001245
```

The reference must be unique.

---

# Reference Generation

References should not expose internal database IDs directly.

Use a dedicated reference-generation mechanism.

---

# Quote Status

Initial status:

```text id="f8q2ld"
new
```

Future statuses:

```text id="r2m7xp"
contacted
qualified
proposal_sent
won
lost
archived
```

The exact workflow will be finalized with the Admin Portal specification.

---

# Contact Information

The quote request may store the minimum contact information necessary for business follow-up.

Potential fields:

```text id="w6c3vn"
name
email
phone
```

Only collect information required by the Quote Wizard.

---

# Contact Data Duplication

If SMEvolve later introduces a central contact/lead system, quote requests should be capable of linking to it.

Avoid creating unnecessary duplicate customer records.

---

# Personal Data

Personal information must be handled according to the SMEvolve Privacy Policy and applicable data protection requirements.

---

# Data Separation

The following information must remain logically separate:

```text id="r4q9mc"
Customer Data
      │
      ├── Quote Answers
      │
      ├── AI Analysis
      │
      ├── Assessment
      │
      └── Admin Data
```

---

# Recommended Relationships

```text id="m9q1ws"
Quote Session
    │
    ├── hasMany Quote Answers
    │
    ├── hasMany AI Analyses
    │
    └── hasOne Quote Request

Quote Request
    │
    └── hasOne Quote Assessment
```

---

# Laravel Model Structure

Suggested:

```text id="u3r8zp"
app/
└── Models/
    ├── QuoteSession.php
    ├── QuoteAnswer.php
    ├── QuoteAiAnalysis.php
    ├── QuoteAssessment.php
    └── QuoteRequest.php
```

The final model structure should follow the project's established naming conventions.

---

# Question Configuration

Questions should not necessarily be stored in the database initially.

For the first implementation, question definitions may live in configuration.

Example:

```text id="q5v2lm"
config/
└── quote.php
```

Possible structure:

```php
'steps' => [
    'project_type',
    'project_details',
    'requirements',
    'timeline',
    'budget',
    'contact',
    'review',
],
```

---

# Dynamic Questions

Conditional questions should be driven by configuration and/or application logic.

Example:

```text id="j6x3qa"
If:
project_type = ecommerce

Then:
show payment questions
show product questions
show delivery questions
```

---

# Database vs Configuration

Use configuration for:

```text id="r9p4cy"
Question Definitions
Option Lists
Feature Definitions
Weights
Step Definitions
```

Use database storage for:

```text id="v2k8ns"
User Answers
Submitted Requests
AI Results
Assessments
Admin Decisions
```

This prevents the database from becoming unnecessarily responsible for static application configuration.

---

# Data Types

Prefer structured data over storing everything as free-form text.

For example:

Do not store:

```text id="g4y1nt"
"Website, online payments, customers, booking..."
```

when structured values are possible.

Prefer:

```json id="t8m3pk"
{
  "project_type": "website",
  "features": [
    "online_payments",
    "customer_accounts",
    "booking"
  ]
}
```

---

# JSON Storage

JSON may be used for flexible fields such as:

```text id="k7v1ps"
features
integrations
AI result
missing information
```

However, frequently queried fields should have dedicated columns where appropriate.

---

# Searchability

Important admin-search fields should be directly queryable.

Examples:

```text id="x8m5rv"
quote_reference
status
email
project_type
created_at
```

Do not bury every important field inside JSON.

---

# Data Integrity

The system must enforce:

* Foreign key relationships.
* Required fields.
* Unique quote references.
* Valid status values.
* Valid session relationships.

---

# Deletion

Quote data should not be casually deleted.

Deletion and retention rules should follow:

* Privacy requirements.
* Business requirements.
* Legal requirements.
* SMEvolve retention policy.

---

# Anonymization

Future privacy functionality may allow personal information to be anonymized while retaining non-personal operational statistics.

Example:

```text id="o8s2jf"
Quote Request
     ↓
Personal Data Removed
     ↓
Anonymous Project Statistics
```

---

# Auditability

Important state changes should be auditable.

Potential events:

```text id="n5y3zr"
Quote Submitted
Status Changed
Admin Updated
AI Analysis Completed
Assessment Recalculated
```

The final audit architecture may be shared with the Admin Portal.

---

# Data Ownership

Customer-provided information should remain distinguishable from internally generated information.

Example:

```text id="q2x7vm"
User:
"I need online payment."

AI:
"Payment gateway integration may be required."

System:
"Integration count = 1."

Admin:
"Use Paystack."
```

These are different sources and must not be merged into one field without provenance.

---

# Data Provenance

Where useful, track:

```text id="d7p1xk"
source
created_by
created_at
updated_at
```

Possible source values:

```text id="e3w8zn"
user
ai
system
admin
```

---

# Sensitive Information

The Quote Wizard should minimize sensitive information sent to AI.

Particularly avoid sending:

```text id="h6m2qv"
Passwords
Payment card information
Authentication credentials
API keys
Unnecessary personal information
Internal business information
```

---

# Payment Information

The Quote Wizard should never collect raw card details.

If payment is introduced later, it should use an approved payment provider and appropriate payment architecture.

---

# File Uploads

If file uploads are introduced later:

* Do not store files directly inside quote JSON.
* Store metadata separately.
* Validate file type.
* Validate size.
* Scan uploads where required.
* Use secure storage.
* Prevent executable uploads.

File uploads are outside the initial Quote Wizard scope unless separately approved.

---

# Session Expiration

Inactive sessions may eventually expire.

Example:

```text id="n9k4vz"
Active
 ↓
Inactivity
 ↓
Expired
```

The exact duration should be configurable.

---

# Abandoned Sessions

An abandoned session should not automatically become a submitted quote request.

Only completed submissions create a formal quote request.

---

# Duplicate Submissions

The system should prevent accidental duplicate submissions caused by:

* Double-clicking.
* Browser retries.
* Network retries.

Use appropriate idempotency or submission-state handling.

---

# Transactional Submission

Final submission should be handled safely.

Conceptually:

```text id="f4m8cy"
Validate
 ↓
Create Quote Request
 ↓
Store Final Answers
 ↓
Mark Session Submitted
 ↓
Dispatch AI Processing
 ↓
Commit
```

If a critical database operation fails, the system should avoid creating an incomplete quote request.

---

# AI Processing After Submission

AI processing should preferably not block successful quote creation.

Recommended:

```text id="q6z3wk"
Quote Request Created
       ↓
AI Job Queued
       ↓
Groq Processing
       ↓
AI Analysis Stored
```

---

# AI Failure

If AI processing fails:

```text id="e8v1rx"
Quote Request
Status:
Valid

AI Analysis:
Failed
```

The administrator can still review the request.

---

# Future Pricing Integration

The architecture must allow future pricing functionality.

Potential relationship:

```text id="w1m7cp"
Quote Request
      ↓
Assessment
      ↓
Pricing Engine
      ↓
Quote
```

The initial Quote Wizard does not need to create a final pricing record.

---

# Future Proposal Integration

A future proposal system may reference:

```text id="p5r9dy"
quote_request_id
```

rather than copying the entire quote request.

---

# Data Flow

Complete data flow:

```text id="x4j8nv"
Visitor
   ↓
Quote Session
   ↓
Answers
   ↓
Conditional Questions
   ↓
AI Assistance
   ↓
User Confirmation
   ↓
Review
   ↓
Quote Request
   ↓
AI Analysis
   ↓
Assessment
   ↓
Admin Portal
   ↓
Human Decision
   ↓
Future Proposal / Final Quote
```

---

# Performance

The architecture should avoid:

* Excessive database writes on every keystroke.
* Large unstructured JSON blobs.
* Repeated AI processing.
* Duplicate records.

Autosave should occur at sensible milestones rather than every character typed.

---

# Security

The data layer must support:

* Authorization.
* Validation.
* Secure session identifiers.
* Mass-assignment protection.
* Encryption where appropriate.
* Secure logging.
* Privacy controls.

Admin-only fields must never be returned to public endpoints.

---

# API Serialization

If quote data is exposed through JSON endpoints, use controlled resources/transformers.

Do not return entire database models blindly.

Example:

```text id="e7m2ls"
Public Response
    ↓
Allowed Fields Only
```

---

# Testing Requirements

Data architecture testing should cover:

## Sessions

✓ Session creation.

✓ Session updates.

✓ Session expiration.

✓ Session submission.

---

## Answers

✓ Single answers.

✓ Multiple answers.

✓ Conditional answers.

✓ Answer updates.

✓ Source tracking.

---

## AI

✓ AI result storage.

✓ AI failure.

✓ AI status transitions.

✓ Provider/model tracking.

---

## Requests

✓ Quote request creation.

✓ Unique reference generation.

✓ Duplicate submission prevention.

✓ Status changes.

---

## Relationships

✓ Session → Answers.

✓ Session → AI Analyses.

✓ Session → Request.

✓ Request → Assessment.

---

# Future Compatibility

The architecture should be able to support:

* Admin Portal.
* Pricing Engine.
* Proposal Generator.
* CRM integration.
* Email automation.
* Analytics.
* Quote versioning.
* Client communication.
* Multiple AI providers.

---

# Success Criteria

The data architecture is successful when:

✓ Quote sessions can be tracked independently.

✓ User answers are stored in structured form.

✓ AI output is separated from user data.

✓ Confirmed information can be distinguished from suggestions.

✓ Quote requests have unique references.

✓ Internal assessments are separated from customer-visible data.

✓ AI processing can happen asynchronously.

✓ AI failure does not invalidate the quote request.

✓ Future pricing functionality can be added without redesigning the entire system.

✓ Sensitive information is minimized and protected.

✓ Data relationships are clear and maintainable.

✓ The architecture works naturally with Laravel 12.

---

# Stop Condition

This document defines the Quote Wizard data architecture.

It does not implement:

* Database migrations.
* Eloquent models.
* API controllers.
* Groq service code.
* Admin Portal.
* Email notifications.
* Pricing engine.
* Deployment.

Those are defined in subsequent implementation documentation.
