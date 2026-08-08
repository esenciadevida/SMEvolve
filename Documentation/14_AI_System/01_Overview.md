# SMEvolve AI System
## Part 1 – AI Architecture Overview

**Project Name:** SMEvolve

**Website:** https://smevolve.tech

**Version:** 1.0

**Document Type:** AI System Architecture

---

# Purpose

This document defines the architecture, responsibilities, boundaries, and future direction of the SMEvolve AI system.

The SMEvolve AI system will provide intelligent assistance across the website while remaining tightly integrated with the company's services, FAQ content, packages, portfolio, contact information, and Quote Wizard.

The system must be designed as a reusable AI infrastructure rather than a standalone chatbot.

---

# Core Principle

AI should assist the visitor and the business.

It should not replace human decision-making where professional judgment is required.

The AI system should:

- Answer questions.
- Explain services.
- Guide visitors.
- Collect project requirements.
- Qualify leads.
- Recommend appropriate solutions.
- Assist with project discovery.
- Route users to human support when necessary.

---

# AI Provider

Primary AI provider:

**Groq**

Groq will provide the inference layer used by the SMEvolve AI system.

The architecture must not tightly couple the application directly to a specific Groq model.

---

# AI Service Layer

All AI requests must pass through an internal SMEvolve AI service layer.

Architecture:

```text
Website
   ↓
SMEvolve AI Service
   ↓
Groq API
   ↓
Selected AI Model
   ↓
SMEvolve AI Service
   ↓
Website
```

The application should never scatter direct Groq API calls throughout controllers or Blade components.

---

# AI Applications

The AI Engine will initially support two primary applications.

## 1. AI Website Assistant

Purpose:

Help website visitors understand SMEvolve.

Capabilities:

- Answer FAQs.
- Explain services.
- Explain packages.
- Answer basic project questions.
- Recommend relevant services.
- Guide visitors through the website.
- Direct users to Contact or Quote Wizard.
- Capture qualified leads.

---

## 2. AI Quote Assistant

Purpose:

Assist users during the Quote Wizard.

Capabilities:

- Ask project discovery questions.
- Understand requirements.
- Identify project type.
- Identify required features.
- Determine approximate complexity.
- Recommend suitable services.
- Identify missing information.
- Generate an internal project summary.
- Assist with lead qualification.

---

# Shared Intelligence

Both applications must use the same knowledge sources.

```text
                    SMEvolve AI Engine
                           │
             ┌─────────────┴─────────────┐
             │                           │
       Website Assistant            Quote Assistant
             │                           │
             └─────────────┬─────────────┘
                           │
                    Knowledge Base
```

This prevents inconsistent answers.

---

# Knowledge Sources

The AI system may use information from:

- Company information
- Services
- Packages
- Portfolio
- FAQ
- Contact information
- Website policies
- Quote Wizard configuration

---

# Single Source of Truth

AI must not invent business information.

For example:

If the official package configuration says:

```text
Business Website
₦XXX
```

the AI should use the configured information.

It must not invent:

```text
₦YYY
```

---

# Dynamic Business Information

The AI system should eventually retrieve dynamic information from the Admin Portal.

Examples:

- Phone number
- Email
- WhatsApp
- Business hours
- Services
- Packages
- FAQ
- Company information

This means changes made in the Admin Portal can automatically become available to the AI.

---

# AI Response Rules

The AI should:

- Be helpful.
- Be concise.
- Be professional.
- Use SMEvolve's brand voice.
- Ask useful follow-up questions.
- Avoid unnecessary technical language.
- Clearly state when it does not know something.

---

# No Hallucination Policy

The AI must never knowingly invent:

- Prices
- Services
- Discounts
- Guarantees
- Company information
- Client information
- Project timelines
- Legal claims

When information is unavailable, it should say so and offer an appropriate next step.

Example:

> "I don't have the current pricing for that service. I can help you request a quote from the SMEvolve team."

---

# Human Handoff

The AI must be able to direct visitors to human assistance.

Triggers may include:

- Complex requirements.
- Pricing negotiation.
- Complaints.
- Legal questions.
- Highly specific technical requirements.
- User explicitly requesting a human.

Primary actions:

- Contact SMEvolve.
- Start Quote Wizard.
- WhatsApp.

---

# AI Conversation Architecture

Conversation flow:

```text
User
 ↓
Message
 ↓
AI Service
 ↓
Context Retrieval
 ↓
Prompt Construction
 ↓
Groq
 ↓
Response Validation
 ↓
User
```

---

# Conversation Context

The AI should maintain appropriate conversation context during a session.

Context may include:

- Previous user questions.
- Relevant answers.
- Current service being discussed.
- Quote Wizard progress.

Context must be limited to what is necessary.

---

# Privacy

AI conversations may contain personal or business information.

The system must:

- Minimize unnecessary data collection.
- Avoid exposing private information.
- Protect stored conversations.
- Avoid sending unnecessary data to AI providers.
- Follow the Privacy Policy.

---

# Sensitive Information

Users should not be encouraged to submit:

- Passwords.
- Payment card information.
- Authentication credentials.
- Highly sensitive personal information.

If such information is provided, the system should avoid retaining or unnecessarily processing it.

---

# AI Cost Management

The system should control AI usage.

Possible controls:

- Maximum tokens per request.
- Maximum conversation length.
- Request rate limiting.
- Model selection.
- Response length limits.
- Usage monitoring.

---

# Error Handling

If Groq is unavailable:

The website must remain functional.

The AI should display a graceful fallback:

> "I'm temporarily unable to assist. You can contact the SMEvolve team directly or request a quote."

Never display raw API errors.

---

# AI Availability

The AI system should be independently enabled or disabled.

The Admin Portal should eventually support:

```text
AI Assistant: ON / OFF

Quote AI: ON / OFF
```

---

# Analytics

Track AI usage without unnecessarily storing sensitive content.

Potential metrics:

- Conversations started.
- Questions asked.
- Quote Wizard starts.
- Quote Wizard completions.
- AI-assisted conversions.
- Human handoffs.
- AI errors.
- AI response latency.

---

# Security

The system must:

- Store API credentials server-side.
- Never expose Groq API keys to the browser.
- Validate requests.
- Rate-limit AI endpoints.
- Sanitize user-generated content.
- Prevent prompt injection from directly controlling system behaviour.
- Protect conversation data.

---

# Future AI Capabilities

The architecture should allow future features such as:

- AI proposal generation.
- AI project brief generation.
- AI lead scoring.
- AI email drafting.
- AI customer support.
- AI content assistance.
- AI service recommendations.

These should be added without replacing the core AI service layer.

---

# Technology Architecture

Initial architecture:

```text
Laravel Application
        │
        ├── AI Service Layer
        │
        ├── Knowledge Service
        │
        ├── Conversation Service
        │
        └── Lead Qualification Service
                    │
                    ↓
                 Groq API
```

---

# Important Architectural Rule

Do not build:

```text
Chatbot → Groq directly
```

and:

```text
Quote Wizard → Groq directly
```

Instead build:

```text
Chatbot
    ↓
AI Service
    ↓
Groq

Quote Wizard
    ↓
AI Service
    ↓
Groq
```

This keeps the architecture maintainable and provider-independent.

---

# Admin Portal Integration

The future Admin Portal should control:

- AI enabled/disabled state.
- AI welcome message.
- AI model.
- AI usage limits.
- Knowledge sources.
- System instructions.
- Conversation settings.

API credentials must remain server-side and should not be editable through normal public website interfaces.

---

# Acceptance Criteria

The AI architecture is complete when:

✓ Groq is defined as the initial provider.

✓ AI Service Layer is defined.

✓ Chatbot and Quote Wizard share the same AI infrastructure.

✓ Knowledge sources are centralized.

✓ Hallucination controls are defined.

✓ Human handoff is supported.

✓ Security requirements are defined.

✓ Privacy requirements are defined.

✓ Error handling is defined.

✓ Future provider changes are possible.

---

# Revision Policy

The AI architecture should be reviewed whenever SMEvolve introduces:

- New AI models.
- New AI features.
- New data sources.
- New customer-facing AI functionality.
- Major changes to the Quote Wizard.
- Major changes to the Admin Portal.