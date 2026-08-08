# SMEvolve AI System
## Part 10 – AI Data Model

**Project Name:** SMEvolve

**Website:** https://smevolve.tech

**Version:** 1.0

**Document Type:** AI Database & Data Architecture

---

# Purpose

This document defines the database structures required to support the SMEvolve AI ecosystem.

The data model must support:

- AI conversations.
- AI messages.
- Quote Wizard sessions.
- AI-generated project information.
- Knowledge Base content.
- AI prompts.
- AI usage tracking.
- AI configuration.
- AI audit logs.
- Human handoff.
- Lead generation.

---

# Core Principle

AI data must remain structured and separated according to its purpose.

```text
Business Data
      ↓
Knowledge Base

Conversation Data
      ↓
AI Conversation System

Quote Data
      ↓
Quote Wizard

AI Configuration
      ↓
Admin Portal

Security Events
      ↓
Audit System
```

---

# Database Architecture

The AI system should use the application's primary relational database.

Recommended:

```text
MySQL / PostgreSQL
```

The exact production database may be determined during infrastructure setup.

---

# Data Categories

The initial AI data model contains:

```text
1. Conversations
2. Messages
3. Quote Sessions
4. Quote Answers
5. Knowledge Items
6. AI Prompts
7. AI Prompt Versions
8. AI Usage
9. AI Configuration
10. AI Handoffs
11. AI Audit Logs
```

---

# 1. Conversations

Table:

```text
conversations
```

Purpose:

Stores AI conversation sessions.

Suggested fields:

```text
id
uuid
session_id
status
channel
visitor_id
started_at
last_message_at
completed_at
created_at
updated_at
```

---

# Conversation UUID

Public-facing conversation identifiers should use UUIDs or another non-sequential identifier.

Do not expose predictable numeric database IDs where avoidable.

---

# Conversation Status

Allowed values:

```text
new
active
idle
completed
abandoned
archived
```

---

# Conversation Channel

Initial value:

```text
website
```

Future:

```text
website
quote_wizard
whatsapp
mobile_app
```

---

# Visitor Association

Anonymous users may be associated with a temporary session.

Do not require account creation.

If an authenticated user system is introduced later, conversations may optionally reference the user.

---

# 2. Messages

Table:

```text
messages
```

Purpose:

Stores messages associated with conversations.

Suggested fields:

```text
id
uuid
conversation_id
role
content
model
provider
token_input
token_output
response_time_ms
metadata
created_at
updated_at
```

---

# Message Role

Allowed values:

```text
user
assistant
system
```

System messages must only be created by the application.

---

# Message Content

Message content should be stored securely.

Do not expose internal system messages to normal visitors.

---

# AI Provider

Example:

```text
groq
```

This field allows future provider changes.

---

# AI Model

Store the model used for the response.

Example:

```text
configured-model
```

Do not assume the model will remain permanently unchanged.

---

# Token Usage

Where available:

```text
token_input
token_output
```

These values can support cost and usage monitoring.

---

# Response Time

Store:

```text
response_time_ms
```

This allows performance monitoring.

---

# Message Metadata

Metadata should contain only useful structured information.

Example:

```json
{
    "source": "website_assistant",
    "prompt_version": "v1"
}
```

Do not store secrets.

---

# 3. Quote Sessions

Table:

```text
quote_sessions
```

Purpose:

Stores Quote Wizard progress independently of the AI conversation.

Suggested fields:

```text
id
uuid
conversation_id
status
current_step
project_type
business_name
industry
description
budget_range
timeline
recommended_service
recommended_package
complexity
lead_score
ai_summary
started_at
completed_at
created_at
updated_at
```

---

# Quote Session Status

Allowed values:

```text
started
in_progress
completed
abandoned
submitted
```

---

# Quote Session Independence

The Quote Wizard must not depend entirely on the AI conversation.

Example:

```text
AI unavailable
      ↓
Quote Wizard continues
```

---

# 4. Quote Answers

For dynamic Quote Wizard questions, use a separate answer structure.

Table:

```text
quote_answers
```

Suggested fields:

```text
id
quote_session_id
question_key
question
answer
answer_type
source
created_at
updated_at
```

---

# Answer Source

Possible values:

```text
user
ai
system
```

AI-derived answers must be treated as suggestions until confirmed by the user.

---

# Answer Confirmation

Optional field:

```text
confirmed_at
```

This can identify whether the user reviewed and confirmed AI-derived information.

---

# 5. Knowledge Items

Table:

```text
knowledge_items
```

Purpose:

Stores approved information available to the AI.

Suggested fields:

```text
id
uuid
type
title
slug
content
status
priority
metadata
created_by
updated_by
published_at
created_at
updated_at
```

---

# Knowledge Types

Possible values:

```text
company
service
package
faq
portfolio
business
legal
quote
```

---

# Knowledge Status

Allowed values:

```text
draft
published
archived
```

---

# Knowledge Priority

Possible values:

```text
low
normal
high
critical
```

Priority helps resolve conflicts between related information.

---

# Knowledge Metadata

Metadata may contain structured information.

Example:

```json
{
    "service_id": 12,
    "category": "web-development"
}
```

Avoid storing sensitive information in public knowledge records.

---

# 6. AI Prompts

Table:

```text
ai_prompts
```

Purpose:

Defines logical AI prompt profiles.

Suggested fields:

```text
id
key
name
description
active_version_id
created_at
updated_at
```

---

# Prompt Keys

Initial:

```text
website_assistant
quote_assistant
```

Future:

```text
proposal_assistant
support_assistant
internal_assistant
```

---

# 7. AI Prompt Versions

Table:

```text
ai_prompt_versions
```

Purpose:

Stores versioned prompt content.

Suggested fields:

```text
id
prompt_id
version
content
status
created_by
activated_by
activated_at
created_at
updated_at
```

---

# Prompt Version Status

Allowed values:

```text
draft
active
inactive
archived
```

Only one version of a prompt should normally be active at a time.

---

# Prompt Rollback

When a new prompt fails:

```text
Active v3
     ↓
Rollback
     ↓
Active v2
```

---

# 8. AI Usage

Table:

```text
ai_usage
```

Purpose:

Tracks AI usage and operational metrics.

Suggested fields:

```text
id
conversation_id
message_id
provider
model
input_tokens
output_tokens
total_tokens
response_time_ms
status
error_type
created_at
```

---

# Usage Status

Possible values:

```text
success
failed
timeout
rate_limited
blocked
```

---

# Usage Data

Usage data may be used to calculate:

- Request volume.
- Token consumption.
- Error rate.
- Response performance.
- Provider reliability.

---

# 9. AI Configuration

Table:

```text
ai_configurations
```

Purpose:

Stores configurable AI settings that are safe to manage through the Admin Portal.

Suggested fields:

```text
id
key
value
type
description
is_public
updated_by
created_at
updated_at
```

---

# Example Configuration

Possible settings:

```text
ai_assistant_enabled
quote_ai_enabled
welcome_message
max_message_length
rate_limit
max_context_messages
conversation_retention
```

---

# Secrets

Do not store the Groq API key as ordinary configuration data.

Preferred:

```text
Environment / Secret Manager
```

---

# 10. AI Handoffs

Table:

```text
ai_handoffs
```

Purpose:

Tracks situations where AI recommends or initiates human assistance.

Suggested fields:

```text
id
conversation_id
quote_session_id
reason
status
requested_at
resolved_at
created_at
updated_at
```

---

# Handoff Status

Possible values:

```text
requested
in_progress
resolved
cancelled
```

---

# Handoff Reasons

Possible examples:

```text
user_requested
complex_request
pricing_negotiation
complaint
unknown_information
technical_issue
```

---

# 11. AI Audit Logs

Table:

```text
ai_audit_logs
```

Purpose:

Records important administrative and security-related AI events.

Suggested fields:

```text
id
admin_id
action
resource_type
resource_id
old_value
new_value
ip_address
user_agent
created_at
```

---

# Audit Examples

```text
AI enabled

AI disabled

Prompt activated

Prompt rolled back

Knowledge published

Package price changed

AI model changed

Rate limit changed
```

---

# Secret Protection

Never store:

```text
API keys
Passwords
Authentication tokens
Database credentials
```

inside audit logs.

---

# Relationships

High-level relationship:

```text
conversations
      │
      ├── messages
      │
      ├── quote_sessions
      │       │
      │       └── quote_answers
      │
      └── ai_handoffs

ai_prompts
      │
      └── ai_prompt_versions

knowledge_items

ai_usage
      │
      └── messages

ai_configurations

ai_audit_logs
```

---

# Conversation Relationship

One conversation may contain many messages.

```text
Conversation
     │
     ├── Message
     ├── Message
     ├── Message
     └── Message
```

---

# Quote Relationship

One quote session may contain many answers.

```text
Quote Session
      │
      ├── Answer
      ├── Answer
      ├── Answer
      └── Answer
```

---

# Conversation and Quote Relationship

A Quote Session may optionally originate from an AI conversation.

```text
AI Conversation
      ↓
Quote Session
```

The quote session should still function independently.

---

# Knowledge Relationships

Knowledge may reference application entities.

Example:

```text
Knowledge Item
      ↓
Service
```

However, the Knowledge Service should determine the final context sent to AI.

---

# Indexing

Important indexes should include:

```text
conversations.uuid

conversations.session_id

messages.conversation_id

messages.created_at

quote_sessions.uuid

quote_sessions.status

quote_answers.quote_session_id

knowledge_items.type

knowledge_items.status

knowledge_items.slug

ai_usage.created_at

ai_audit_logs.created_at
```

---

# Foreign Keys

Where appropriate, use foreign key constraints.

Examples:

```text
messages.conversation_id
        ↓
conversations.id
```

```text
quote_answers.quote_session_id
        ↓
quote_sessions.id
```

---

# Cascading Rules

Deleting a conversation should not automatically destroy data that must legally or operationally be retained.

Cascading deletion rules must therefore be deliberately defined during implementation.

---

# Soft Deletes

Where appropriate, use soft deletion for:

- Knowledge items.
- Conversations.
- Quote sessions.
- Administrative records.

The final implementation should follow the application's retention requirements.

---

# Data Retention

AI data retention should be configurable.

Potential categories:

```text
Conversations
Messages
Quote Sessions
AI Usage
Audit Logs
```

Audit logs may require longer retention than normal conversations.

---

# Privacy

Personal information should be minimized.

Possible personal information includes:

```text
Name
Email
Phone
Business information
Project information
```

Access must be restricted.

---

# Data Access

Public users:

```text
Own active conversation only
```

Administrators:

```text
Permission-controlled access
```

AI:

```text
Relevant context only
```

---

# AI Database Access

Groq must never have direct database access.

Architecture:

```text
Groq
  X
  │
  │ Direct DB Access
  X
```

Correct:

```text
Application
   ↓
Knowledge Service
   ↓
Selected Context
   ↓
Groq
```

---

# Data Validation

All database writes originating from AI output must pass through application validation.

Example:

```text
AI Output
    ↓
Schema Validation
    ↓
Business Rules
    ↓
Database
```

---

# Quote Lead Creation

A completed Quote Session may produce a Lead record.

The Lead should be part of the broader CRM/lead data model rather than duplicated unnecessarily inside the AI tables.

---

# AI Data and Lead Data

Keep responsibilities separate:

```text
AI System
    ↓
Quote Session
    ↓
Lead System
```

The AI system should not become the CRM.

---

# Migration Strategy

Database migrations should be created for each AI table.

Example:

```text
create_conversations_table

create_messages_table

create_quote_sessions_table

create_quote_answers_table

create_knowledge_items_table

create_ai_prompts_table

create_ai_prompt_versions_table

create_ai_usage_table

create_ai_configurations_table

create_ai_handoffs_table

create_ai_audit_logs_table
```

---

# Naming Convention

Use consistent database naming.

Recommended:

```text
snake_case
plural_table_names
```

---

# Timestamps

All AI tables should use:

```text
created_at
updated_at
```

where appropriate.

Use UTC internally where possible and convert to the configured business timezone for display.

---

# JSON Fields

JSON fields may be used for flexible metadata.

Do not use JSON for information that requires frequent querying or relational integrity.

---

# Scalability

The data model should support future growth.

Potential future features:

```text
WhatsApp AI
Mobile AI
Proposal AI
Support AI
Internal AI
AI Analytics
```

The architecture should avoid hard-coding the system to only the website chatbot.

---

# Acceptance Criteria

The AI Data Model is complete when:

✓ Conversations are structured.

✓ Messages are structured.

✓ Quote sessions are independent.

✓ Quote answers are structured.

✓ Knowledge is stored separately.

✓ Prompts are versioned.

✓ AI usage is trackable.

✓ AI configuration is centralized.

✓ Human handoffs are tracked.

✓ AI administrative actions are audited.

✓ Relationships are defined.

✓ Indexing requirements are defined.

✓ Privacy boundaries are defined.

✓ AI has no direct database access.

✓ AI output is validated before storage.

✓ Data retention is configurable.

✓ Future AI channels are supported.

---

# Revision Policy

Review this document whenever:

- AI features change.
- Quote Wizard changes.
- New AI channels are added.
- Knowledge architecture changes.
- Admin functionality expands.
- Database architecture changes.