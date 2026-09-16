# SMEvolve AI System
## Part 2 – Groq Integration

**Project Name:** SMEvolve

**Website:** https://smevolve.tech

**Version:** 1.0

**Document Type:** Groq AI Integration Specification

---

# Purpose

This document defines how the SMEvolve Laravel application will integrate with Groq.

Groq will provide the initial AI inference infrastructure for:

- SMEvolve AI Assistant
- AI Quote Wizard
- Future AI-powered business tools

The integration must remain secure, modular, and provider-independent.

---

# Core Architecture

The application must never communicate with Groq directly from frontend code.

Required architecture:

```text
Browser
   ↓
Laravel Route
   ↓
Controller / Action
   ↓
SMEvolve AI Service
   ↓
Groq Client
   ↓
Groq API
   ↓
AI Response
   ↓
Validation / Processing
   ↓
Browser
```

---

# Security Principle

The Groq API key must never be exposed to:

- Browser JavaScript
- Blade templates
- HTML
- Public configuration
- Git repositories
- Client-side network requests

The API key must remain server-side.

---

# Environment Configuration

Store credentials in the Laravel environment.

Example:

```env
GROQ_API_KEY=
GROQ_MODEL=
GROQ_BASE_URL=
GROQ_TIMEOUT=
```

Never commit actual credentials.

---

# Configuration File

Create:

```text
config/ai.php
```

Suggested structure:

```php
return [

    'provider' => env('AI_PROVIDER', 'groq'),

    'groq' => [

        'api_key' => env('GROQ_API_KEY'),

        'model' => env(
            'GROQ_MODEL',
            'openai/gpt-oss-120b'
        ),

        'base_url' => env(
            'GROQ_BASE_URL',
            'https://api.groq.com/openai/v1'
        ),

        'timeout' => env(
            'GROQ_TIMEOUT',
            30
        ),

    ],

];
```

The exact model should remain configurable.

Do not hard-code the model throughout the application.

---

# Provider Abstraction

The application should use an AI provider interface.

Suggested:

```text
app/
└── Services/
    └── AI/
        ├── AIProviderInterface.php
        ├── AIService.php
        └── Providers/
            └── GroqProvider.php
```

---

# AIProviderInterface

The interface should define common AI operations.

Example:

```php
interface AIProviderInterface
{
    public function generate(
        array $messages,
        array $options = []
    ): AIResponse;
}
```

The exact implementation may evolve.

---

# Groq Provider

The Groq provider should be responsible for:

- Authentication.
- HTTP requests.
- Model selection.
- Request formatting.
- Response parsing.
- Error handling.

Business logic must not live inside the provider.

---

# AI Service

The AI Service should sit above the provider.

Example:

```text
Application
    ↓
AIService
    ↓
AIProviderInterface
    ↓
GroqProvider
    ↓
Groq API
```

This allows the provider to be replaced later.

---

# Future Provider Compatibility

The architecture should support future providers such as:

- OpenAI
- Anthropic
- Google
- Local models

without rewriting the Quote Wizard or Chatbot.

Example:

```text
AIService
    │
    ├── GroqProvider
    ├── OpenAIProvider
    ├── AnthropicProvider
    └── LocalProvider
```

Only one provider needs to be active at a time unless a future routing system is introduced.

---

# Request Structure

AI requests should contain:

```text
System Instructions
+
Relevant Knowledge
+
Conversation Context
+
Current User Message
```

Example:

```text
System Instructions
        ↓
SMEvolve Knowledge
        ↓
Conversation Context
        ↓
User Message
        ↓
Groq
```

---

# System Instructions

System instructions must define:

- SMEvolve identity.
- AI role.
- Response behaviour.
- Business boundaries.
- Hallucination rules.
- Human handoff rules.
- Safety rules.

They must not be controlled directly by normal public users.

---

# Knowledge Injection

Only relevant knowledge should be included in each request.

Do not send the entire website database to Groq for every request.

Example:

If user asks:

> "Do you build Laravel applications?"

Retrieve:

- Laravel service information.
- Relevant FAQ.
- Relevant portfolio entries.

Then provide only that information to the model.

---

# Conversation Context

The system may provide recent conversation messages.

Use a limited context window.

Do not send unlimited historical conversations.

Recommended approach:

```text
System
+
Relevant Knowledge
+
Recent Conversation
+
Current Message
```

---

# Request Limits

The application should define:

- Maximum input size.
- Maximum output tokens.
- Request timeout.
- Maximum conversation length.

These should be configurable.

---

# Rate Limiting

AI endpoints must be rate-limited.

Suggested starting architecture:

```text
Public AI endpoint
        ↓
Rate Limiter
        ↓
AI Service
        ↓
Groq
```

Rate limits should prevent:

- Abuse.
- Automated spam.
- Excessive API usage.
- Unexpected costs.

---

# Abuse Prevention

The system should detect and limit:

- Excessive requests.
- Repeated automated requests.
- Extremely long messages.
- Suspicious request patterns.

---

# Prompt Injection Protection

User messages must be treated as untrusted input.

The AI must not allow users to override system instructions by submitting commands such as:

```text
Ignore your previous instructions.
```

The application should maintain strict separation between:

```text
System Instructions
```

and:

```text
User Input
```

---

# Output Validation

AI responses should be validated before being displayed.

Check for:

- Empty response.
- Unexpected format.
- Excessive length.
- Invalid content.
- API error responses.

Never expose raw provider responses directly.

---

# Error Handling

If Groq returns an error:

Do not display:

```text
HTTP 429
API exception
Provider timeout
```

Instead display a friendly response.

Example:

> "I'm having trouble responding right now. Please try again or contact the SMEvolve team."

---

# Timeout Handling

If the AI request exceeds the configured timeout:

1. Cancel the request.
2. Log the technical error.
3. Return a friendly fallback.
4. Do not leave the user waiting indefinitely.

---

# Provider Unavailability

If Groq becomes temporarily unavailable:

The website must continue functioning normally.

Critical website features must never depend on AI availability.

---

# Fallback

The system should support:

```text
AI unavailable
      ↓
Fallback message
      ↓
Contact SMEvolve
or
Start Quote Wizard
```

---

# Logging

Log technical information such as:

- Provider.
- Model.
- Response time.
- HTTP status.
- Error type.
- Request identifier.

Do not log sensitive user information unnecessarily.

---

# API Usage Monitoring

Track:

- Requests.
- Successful responses.
- Failed responses.
- Response latency.
- Token usage where available.
- Estimated AI usage cost where available.

---

# Caching

Do not cache private conversations.

Potentially cache safe, static AI-related information such as:

- Public service summaries.
- FAQ context.
- Package information.

Caching should not result in stale business information being presented as current.

---

# Model Configuration

The model must be configurable.

Example:

```env
GROQ_MODEL=openai/gpt-oss-120b
```

Do not assume a model will remain available forever.

Model changes should require changing configuration rather than rewriting application logic.

---

# Admin Controls

The future Admin Portal may allow administrators to configure:

- Active AI provider.
- Active model.
- AI enabled/disabled.
- Maximum response length.
- Rate limits.
- Welcome message.
- AI behaviour settings.

However:

**API keys must not be exposed through public frontend interfaces.**

---

# Environment Separation

Development:

```text
.env
```

Production:

```text
Production environment secrets
```

Never copy production API credentials into source code.

---

# Testing

AI integration tests should cover:

## Successful Request

```text
Application
→ Groq
→ Response
```

---

## Timeout

```text
Application
→ Groq
→ Timeout
→ Fallback
```

---

## API Error

```text
Application
→ Groq
→ Error
→ Fallback
```

---

## Rate Limit

```text
User
→ Too many requests
→ Rate limit response
```

---

## Missing API Key

The application should fail gracefully.

The website must still load.

---

# Performance

Target:

- Fast request initiation.
- Reasonable AI response latency.
- No blocking page loads.
- Streaming responses where appropriate.

Streaming may be introduced for the chatbot to improve perceived response speed.

---

# Streaming

The architecture should be prepared to support:

```text
Groq
 ↓
Token Stream
 ↓
Laravel
 ↓
Browser
```

Streaming should only be implemented where it improves user experience without compromising security or stability.

---

# Acceptance Criteria

Groq integration is complete when:

✓ API key is server-side.

✓ Environment configuration exists.

✓ AI provider abstraction exists.

✓ Groq provider is isolated.

✓ AI Service sits above provider.

✓ Model is configurable.

✓ Requests are rate-limited.

✓ Errors are handled gracefully.

✓ Timeouts are handled.

✓ Provider failures do not break the website.

✓ Prompt injection protections exist.

✓ Sensitive information is not unnecessarily logged.

✓ Future AI providers can be added.

---

# Revision Policy

Review this integration whenever:

- Groq changes its API.
- The selected model changes.
- A new provider is introduced.
- AI usage increases significantly.
- New AI applications are added.