# SMEvolve AI System
## Part 11 – AI API Specification

**Project Name:** SMEvolve

**Website:** https://smevolve.tech

**Version:** 1.0

**Document Type:** AI Backend API Specification

---

# Purpose

This document defines the API architecture required for the SMEvolve AI system.

The API layer connects:

```text
Website
    ↓
Laravel Backend
    ↓
AI Services
    ↓
Groq
```

The frontend must never communicate directly with Groq.

---

# API Architecture

```text
Frontend
   │
   ├── Chat API
   ├── Conversation API
   ├── Quote AI API
   └── AI Status API
          │
          ↓
      Laravel API
          │
          ├── Validation
          ├── Authentication
          ├── Rate Limiting
          ├── Conversation Service
          ├── Quote Service
          ├── Knowledge Service
          └── AI Service
                    │
                    ↓
                  Groq
```

---

# Base URL

Production API:

```text
https://smevolve.tech/api
```

Development URL should be determined by the local development environment.

---

# API Format

All API requests and responses should use:

```text
JSON
```

Content type:

```text
application/json
```

---

# Authentication

Public chatbot endpoints do not require a traditional user account.

However, they must use:

- Session identification.
- Request validation.
- Rate limiting.
- CSRF protection where applicable.
- Abuse prevention.

Admin AI endpoints require authenticated administrator access.

---

# Standard Response Structure

Successful response:

```json
{
    "success": true,
    "data": {}
}
```

Error response:

```json
{
    "success": false,
    "message": "Unable to process request.",
    "errors": {}
}
```

---

# HTTP Status Codes

Use standard HTTP status codes.

```text
200 OK
201 Created
400 Bad Request
401 Unauthorized
403 Forbidden
404 Not Found
422 Validation Error
429 Too Many Requests
500 Server Error
503 Service Unavailable
```

---

# 1. AI Status Endpoint

```text
GET /api/ai/status
```

Purpose:

Determine whether public AI functionality is currently available.

---

# Response

Example:

```json
{
    "success": true,
    "data": {
        "assistant_enabled": true,
        "quote_ai_enabled": true
    }
}
```

Do not expose:

- API keys.
- Internal provider credentials.
- Server configuration.

---

# 2. Create Conversation

```text
POST /api/ai/conversations
```

Purpose:

Create a new anonymous AI conversation.

---

# Request

```json
{
    "channel": "website"
}
```

---

# Response

```json
{
    "success": true,
    "data": {
        "conversation_id": "uuid",
        "status": "new"
    }
}
```

---

# Validation

Allowed channels:

```text
website
quote_wizard
```

Future channels may be added.

---

# 3. Get Conversation

```text
GET /api/ai/conversations/{conversation}
```

Purpose:

Retrieve the current user's active conversation.

---

# Security

A visitor must only be able to retrieve conversations belonging to their own session.

Never allow arbitrary conversation access by ID alone.

---

# Response

```json
{
    "success": true,
    "data": {
        "conversation_id": "uuid",
        "status": "active",
        "messages": []
    }
}
```

---

# 4. Send Chat Message

```text
POST /api/ai/conversations/{conversation}/messages
```

Purpose:

Send a message to the SMEvolve AI Assistant.

---

# Request

```json
{
    "message": "What services does SMEvolve offer?"
}
```

---

# Validation

```text
message:
required
string
maximum configurable length
```

---

# Processing

The backend should:

```text
Receive Message
      ↓
Validate
      ↓
Rate Limit
      ↓
Load Conversation
      ↓
Load Relevant Knowledge
      ↓
Build Prompt
      ↓
Call Groq
      ↓
Validate Response
      ↓
Store Message
      ↓
Return Response
```

---

# Response

```json
{
    "success": true,
    "data": {
        "message": {
            "id": "uuid",
            "role": "assistant",
            "content": "SMEvolve provides..."
        }
    }
}
```

---

# 5. Streaming Chat

Future endpoint:

```text
POST /api/ai/conversations/{conversation}/messages/stream
```

Purpose:

Allow AI responses to appear progressively.

The final implementation may use:

```text
Server-Sent Events
```

or another appropriate streaming mechanism.

---

# Streaming Security

Streaming must use the same:

- Authentication.
- Validation.
- Rate limiting.
- Authorization.

as normal AI requests.

---

# 6. Start Quote Session

```text
POST /api/ai/quote-sessions
```

Purpose:

Create a Quote Wizard session.

---

# Request

```json
{
    "conversation_id": "uuid"
}
```

The conversation ID is optional if the quote begins independently.

---

# Response

```json
{
    "success": true,
    "data": {
        "quote_session_id": "uuid",
        "status": "started"
    }
}
```

---

# 7. Get Quote Session

```text
GET /api/ai/quote-sessions/{quoteSession}
```

Purpose:

Retrieve the current user's Quote Wizard progress.

---

# Security

Users must only access their own quote sessions.

---

# Response

```json
{
    "success": true,
    "data": {
        "quote_session_id": "uuid",
        "status": "in_progress",
        "current_step": 2,
        "answers": []
    }
}
```

---

# 8. Save Quote Answer

```text
POST /api/ai/quote-sessions/{quoteSession}/answers
```

Purpose:

Save an answer from the Quote Wizard.

---

# Request

```json
{
    "question_key": "project_type",
    "answer": "Ecommerce website",
    "answer_type": "text",
    "source": "user"
}
```

---

# Validation

The backend must validate:

```text
question_key
answer
answer_type
source
```

The list of allowed question keys should be controlled by the Quote Wizard configuration.

---

# 9. Update Quote Session

```text
PATCH /api/ai/quote-sessions/{quoteSession}
```

Purpose:

Update structured Quote Wizard information.

---

# Request

```json
{
    "project_type": "web_application",
    "industry": "restaurant",
    "budget_range": "medium"
}
```

Only approved fields may be updated.

---

# 10. AI Quote Analysis

```text
POST /api/ai/quote-sessions/{quoteSession}/analyze
```

Purpose:

Ask the AI to analyze the current quote information.

---

# Processing

```text
Quote Answers
      ↓
Validation
      ↓
Knowledge Retrieval
      ↓
Quote Prompt
      ↓
Groq
      ↓
Structured AI Response
      ↓
Validation
```

---

# Response

Example:

```json
{
    "success": true,
    "data": {
        "project_type": "web_application",
        "complexity": "moderate",
        "recommended_service": "Custom Web Application",
        "requirements": [
            "User authentication",
            "Admin dashboard"
        ],
        "summary": "..."
    }
}
```

---

# Important Rule

AI analysis is advisory.

It must not automatically:

- Set a final price.
- Approve a project.
- Apply a discount.
- Sign a contract.
- Accept a client.

---

# 11. Quote Summary

```text
GET /api/ai/quote-sessions/{quoteSession}/summary
```

Purpose:

Retrieve the current structured quote summary.

---

# Response

```json
{
    "success": true,
    "data": {
        "summary": "...",
        "requirements": [],
        "recommended_service": "..."
    }
}
```

---

# 12. Submit Quote

```text
POST /api/ai/quote-sessions/{quoteSession}/submit
```

Purpose:

Submit a completed Quote Wizard request.

---

# Request

```json
{
    "name": "Client Name",
    "email": "client@example.com",
    "phone": "08000000000",
    "consent": true
}
```

---

# Validation

Required fields should include:

```text
name
email
consent
```

Phone requirements should follow the business rules.

---

# Consent

The user must explicitly agree to the applicable privacy/data-processing terms before submission where required.

---

# Response

```json
{
    "success": true,
    "data": {
        "quote_id": "uuid",
        "status": "submitted"
    }
}
```

---

# 13. Request Human Handoff

```text
POST /api/ai/conversations/{conversation}/handoff
```

Purpose:

Request human assistance.

---

# Request

```json
{
    "reason": "user_requested"
}
```

---

# Response

```json
{
    "success": true,
    "data": {
        "handoff_id": "uuid",
        "status": "requested"
    }
}
```

---

# 14. End Conversation

```text
POST /api/ai/conversations/{conversation}/complete
```

Purpose:

Mark a conversation as completed.

---

# Response

```json
{
    "success": true,
    "data": {
        "status": "completed"
    }
}
```

---

# 15. Start New Conversation

The frontend can create a new conversation through:

```text
POST /api/ai/conversations
```

The previous conversation should remain separate.

---

# 16. Admin AI Configuration

Admin endpoint:

```text
GET /api/admin/ai/config
```

Authentication:

```text
Admin required
```

Purpose:

Retrieve AI configuration available to the administrator.

---

# Response

Example:

```json
{
    "success": true,
    "data": {
        "assistant_enabled": true,
        "quote_ai_enabled": true,
        "max_message_length": 4000,
        "max_context_messages": 15
    }
}
```

---

# 17. Update AI Configuration

```text
PATCH /api/admin/ai/config
```

Purpose:

Update approved AI settings.

---

# Request

```json
{
    "assistant_enabled": true,
    "quote_ai_enabled": true
}
```

---

# Authorization

Only administrators with the appropriate permission may update AI configuration.

---

# 18. AI Health Check

```text
GET /api/admin/ai/health
```

Purpose:

Show AI system health to authorized administrators.

---

# Response

```json
{
    "success": true,
    "data": {
        "ai_service": "healthy",
        "groq": "healthy",
        "knowledge_service": "healthy"
    }
}
```

Never expose credentials.

---

# 19. AI Usage

```text
GET /api/admin/ai/usage
```

Purpose:

Return AI usage metrics.

Possible response:

```json
{
    "success": true,
    "data": {
        "requests": 1250,
        "successful": 1205,
        "failed": 45,
        "tokens": 245000
    }
}
```

---

# 20. AI Conversations Admin

```text
GET /api/admin/ai/conversations
```

Purpose:

Allow authorized administrators to review permitted conversation records.

Access must be permission-controlled.

---

# 21. AI Conversation Details

```text
GET /api/admin/ai/conversations/{conversation}
```

Purpose:

View an individual conversation where administrator permissions allow it.

---

# Privacy

Full conversation access should not automatically be granted to every administrator.

---

# 22. Knowledge API

Public AI should not directly query arbitrary database records.

Instead use an internal Knowledge Service.

Example internal service:

```text
KnowledgeService
```

Responsibilities:

- Search approved knowledge.
- Filter unpublished content.
- Return relevant records.
- Apply priority.
- Remove restricted information.

---

# 23. Internal AI Service

The application should centralize Groq interaction.

Example:

```text
AiService
```

Responsibilities:

```text
Prompt Assembly
Model Selection
Groq Request
Timeout Handling
Response Parsing
Error Handling
Usage Tracking
```

Controllers should not contain raw Groq API logic.

---

# 24. Internal Conversation Service

Example:

```text
ConversationService
```

Responsibilities:

```text
Create Conversation
Load Conversation
Store Message
Build Context
Complete Conversation
Summarize Conversation
```

---

# 25. Internal Quote AI Service

Example:

```text
QuoteAiService
```

Responsibilities:

```text
Analyze Quote
Extract Requirements
Recommend Service
Generate Summary
Validate AI Output
```

---

# 26. Internal Prompt Service

Example:

```text
PromptService
```

Responsibilities:

```text
Load Active Prompt
Load Business Rules
Load Knowledge Context
Build Prompt
Version Prompt
```

---

# 27. Rate Limiting

Public AI endpoints must be rate limited.

Apply limits to:

```text
POST /api/ai/conversations

POST /api/ai/conversations/{conversation}/messages

POST /api/ai/quote-sessions/{quoteSession}/analyze
```

---

# 28. Request Validation

Every public endpoint must validate input before processing.

Never pass raw request data directly to Groq.

---

# 29. Authorization

Conversation ownership should be checked before:

```text
Read
Write
Update
Complete
Delete
```

---

# 30. Error Handling

Example AI provider failure:

```json
{
    "success": false,
    "message": "The AI assistant is temporarily unavailable."
}
```

Do not expose:

```text
Groq error body
API key
Stack trace
Internal exception
```

---

# 31. Idempotency

Important operations such as quote submission should support protection against duplicate requests.

Example:

```text
Idempotency-Key
```

This prevents double submissions caused by:

- Double clicks.
- Network retries.
- Browser refreshes.

---

# 32. Request IDs

Each AI request should have a traceable request identifier.

Example:

```text
request_id
```

This helps administrators investigate errors without exposing sensitive information.

---

# 33. Timeout

AI requests must have a configured timeout.

If Groq does not respond within the allowed period:

```text
Timeout
 ↓
Graceful Error
 ↓
User Retry
```

---

# 34. Retry Policy

Retries should be limited.

Do not repeatedly retry failed AI requests because this can:

- Increase costs.
- Increase latency.
- Create duplicate requests.

Only appropriate transient failures should be retried.

---

# 35. API Versioning

The API should be designed for future versioning.

Recommended:

```text
/api/v1/ai/...
```

The final production route structure should use a consistent versioning strategy.

---

# 36. API Documentation

The completed API should eventually be documented using an API specification such as:

```text
OpenAPI
```

This allows frontend and backend developers to work against the same contract.

---

# 37. Testing

Each endpoint must have automated tests.

Examples:

```text
Create Conversation
Send Message
Retrieve Conversation
Start Quote
Save Answer
Analyze Quote
Submit Quote
Request Handoff
Admin Configuration
AI Health
```

---

# 38. Security Tests

Test:

```text
Unauthorized access
Cross-conversation access
Invalid conversation ID
Rate limiting
Prompt injection
Oversized requests
Duplicate quote submission
Admin permission bypass
```

---

# 39. API Acceptance Criteria

The AI API layer is complete when:

✓ Frontend never calls Groq directly.

✓ Conversation endpoints exist.

✓ Message endpoint exists.

✓ Quote endpoints exist.

✓ AI analysis endpoint exists.

✓ Human handoff exists.

✓ Conversation ownership is enforced.

✓ Admin endpoints are protected.

✓ Rate limiting is implemented.

✓ Validation is implemented.

✓ Error responses are safe.

✓ AI provider failures are handled.

✓ Duplicate quote submission is prevented.

✓ Request tracing is supported.

✓ API versioning is defined.

✓ Automated tests are defined.

✓ OpenAPI documentation is planned.

---

# Revision Policy

Review this document whenever:

- New AI endpoints are introduced.
- Quote Wizard changes.
- Admin Portal changes.
- AI provider changes.
- Authentication architecture changes.
- New AI channels are introduced.