# SMEvolve AI System
## Part 7 – AI Conversation System

**Project Name:** SMEvolve

**Website:** https://smevolve.tech

**Version:** 1.0

**Document Type:** AI Conversation & Session Architecture

---

# Purpose

This document defines how SMEvolve manages AI conversations across the website.

The conversation system provides the infrastructure required for:

- The floating AI Assistant.
- Chat sessions.
- Conversation history.
- AI context.
- Quote Wizard handoff.
- Conversation persistence.
- Conversation recovery.
- AI usage controls.

The conversation system must remain independent from the visual chatbot interface.

---

# Core Principle

The AI conversation system manages the conversation.

The chatbot UI only displays and interacts with it.

Architecture:

```text
Chatbot UI
    ↓
Conversation API
    ↓
Conversation Service
    ↓
AI Service
    ↓
Groq
```

---

# Conversation Lifecycle

A conversation follows:

```text
New Visitor
     ↓
AI Bubble
     ↓
Open Chat
     ↓
Start Session
     ↓
Send Message
     ↓
AI Response
     ↓
Continue Conversation
     ↓
Close / Leave
```

---

# Conversation States

A conversation may have:

```text
New
Active
Idle
Completed
Abandoned
Archived
```

---

# New

The visitor has opened the AI Assistant but has not yet meaningfully interacted.

---

# Active

The visitor is actively communicating with the assistant.

---

# Idle

The conversation has temporarily stopped receiving messages.

---

# Completed

The conversation reached a meaningful conclusion.

Examples:

- User received the required information.
- User started a quote.
- User contacted SMEvolve.

---

# Abandoned

The user left without completing the conversation.

---

# Archived

The conversation is retained for internal purposes according to the configured retention policy but is no longer active.

---

# Session Identification

Each conversation should have a unique identifier.

Example:

```text
conversation_id
```

The system may also use:

```text
session_id
```

These identifiers must not expose sensitive information.

---

# Anonymous Visitors

The AI Assistant should work without requiring account creation.

A visitor may start a conversation anonymously.

The system can associate the conversation with a temporary session.

---

# Optional Visitor Information

If the visitor voluntarily provides:

- Name
- Email
- Phone

the information may be associated with the conversation where appropriate.

Do not require personal information simply to use the chatbot.

---

# Conversation Structure

Suggested database structure:

```text
conversations
----------------
id
session_id
status
channel
started_at
last_message_at
completed_at
created_at
updated_at
```

---

# Messages

Suggested structure:

```text
messages
----------------
id
conversation_id
role
content
metadata
created_at
```

---

# Message Roles

Supported roles:

```text
system
user
assistant
```

The application should control system messages.

Users must never be allowed to create system messages.

---

# Message Metadata

Metadata may contain:

```text
model
provider
response_time
token_usage
source
```

Do not store unnecessary sensitive information.

---

# Conversation Context

AI requests should use relevant conversation history.

Example:

```text
System Instructions
+
Relevant Knowledge
+
Recent Messages
+
Current User Message
```

---

# Context Window

Do not send unlimited history to Groq.

Use a configurable context window.

Example:

```text
Recent 10–20 messages
```

The exact limit should be configurable.

---

# Long Conversations

For long conversations, use summarization.

Architecture:

```text
Long Conversation
       ↓
Conversation Summary
       ↓
Recent Messages
       ↓
Groq
```

The summary should contain useful information without retaining unnecessary details.

---

# Conversation Summary

A summary may include:

```text
User intent
Business type
Project type
Requirements
Questions already answered
Important preferences
Current objective
```

---

# Summary Security

The AI-generated summary must be treated as untrusted generated data.

It must not:

- Become system instructions.
- Override business rules.
- Grant permissions.
- Change user roles.

---

# Context Relevance

Not every previous message needs to be included.

The system should prioritize:

1. Current user request.
2. Current task.
3. Relevant recent conversation.
4. Relevant knowledge.

---

# Conversation Recovery

If a visitor refreshes the page:

The conversation may be restored when a valid session exists.

The user should not unexpectedly lose an active conversation.

---

# Browser Storage

A temporary conversation identifier may be stored client-side.

Do not store:

- Groq API keys.
- Sensitive internal data.
- System prompts.

---

# Session Expiration

Anonymous sessions should eventually expire.

The duration should be configurable.

Example:

```text
24 hours
7 days
```

The final retention period should be determined by SMEvolve's privacy requirements.

---

# New Conversation

The user should be able to start a new conversation.

Action:

```text
New Chat
```

This should create a new conversation rather than mixing unrelated conversations.

---

# Closing Conversation

The user may close the chatbot at any time.

Closing the UI does not necessarily delete the conversation.

The conversation remains subject to the configured retention policy.

---

# Delete Conversation

If deletion is supported:

```text
Delete Conversation
```

should remove or anonymize the appropriate conversation data according to the application's retention policy.

---

# Chatbot Reopening

If an active session exists:

```text
Open AI Bubble
     ↓
Restore Conversation
```

If no active session exists:

```text
Open AI Bubble
     ↓
Start New Conversation
```

---

# Quote Wizard Handoff

The AI Assistant should be able to hand the user into the Quote Wizard.

Example:

```text
User:
I need a custom booking platform.

AI:
I can help you work through the requirements.
Would you like to start a quote?

[Start Quote]
```

---

# Quote Handoff Data

When transitioning to the Quote Wizard, pass only relevant information.

Possible data:

```text
project_type
business_type
requirements
conversation_summary
```

---

# Handoff Architecture

```text
AI Conversation
      ↓
Relevant Information
      ↓
Quote Wizard
      ↓
Structured Fields
```

The Quote Wizard must allow the user to review and edit transferred information.

---

# Quote Wizard Does Not Trust AI Data

AI-generated information must be treated as suggestions.

Example:

```text
AI:
Project type = ecommerce

Quote Wizard:
[ Ecommerce ▼ ]
```

The user can change it.

---

# Conversation → Lead

A conversation should not automatically become a lead merely because the visitor uses the chatbot.

A lead should be created when the visitor:

- Submits a quote.
- Provides sufficient contact information and explicitly requests contact.
- Completes an approved lead-generation action.

---

# Lead Creation

Architecture:

```text
Conversation
     ↓
User Intent
     ↓
Explicit Action
     ↓
Lead Creation
```

---

# AI Does Not Create Leads Arbitrarily

The AI should not decide:

> "This person is a lead, therefore create a lead."

Lead creation must follow application rules.

---

# Human Handoff

The AI may initiate a human handoff.

Example:

```text
AI:
This request would be better handled by the SMEvolve team.

[Contact SMEvolve]
[WhatsApp]
[Request a Quote]
```

---

# Handoff Tracking

The system may record:

```text
handoff_requested
handoff_reason
handoff_timestamp
```

---

# Floating AI Bubble

The SMEvolve website should provide a persistent floating AI Assistant entry point.

Recommended location:

```text
Bottom-right corner
```

The bubble should remain accessible across the website.

---

# Floating Bubble Behaviour

Default state:

```text
● AI
```

or an approved SMEvolve AI icon.

On hover:

```text
Chat with SMEvolve
```

On click:

```text
Open AI Assistant
```

---

# Bubble Visibility

The floating bubble should:

- Appear consistently across public pages.
- Avoid covering important controls.
- Respect mobile safe areas.
- Respect accessibility requirements.
- Adapt to dark mode.

---

# Bubble Animation

Use subtle animation only.

Possible:

```text
Fade
Scale
Soft pulse
```

Avoid aggressive or distracting animation.

---

# First Visit

The bubble may display a small welcome prompt.

Example:

```text
Need help?
Ask the SMEvolve AI Assistant.
```

This should not automatically open the entire chatbot.

---

# Welcome Prompt Frequency

Do not repeatedly interrupt users.

The system may show the prompt:

```text
Once per session
```

or according to a configurable display rule.

---

# Mobile Bubble

On mobile:

- Keep the bubble touch-friendly.
- Avoid covering important buttons.
- Respect browser safe areas.
- Keep the chat panel within the viewport.

---

# Chat Panel

The chat interface should contain:

```text
Header
Conversation
Suggested Actions
Input
Send Button
Close Button
```

---

# Chat Header

Recommended:

```text
SMEvolve AI Assistant
AI-powered
```

Optional:

```text
New Chat
Close
```

---

# Suggested Actions

Suggested actions may include:

```text
Explore Services

Get A Quote

View Packages

Contact SMEvolve
```

These should be context-aware where possible.

---

# Typing Indicator

When AI is generating a response:

```text
AI is typing...
```

or an equivalent subtle indicator.

Do not make the user believe a human is typing.

---

# Streaming Responses

The system should support future streaming.

Example:

```text
Groq
 ↓
Stream
 ↓
Laravel
 ↓
Chat UI
```

Streaming should improve perceived response speed.

---

# Failed Message

If a user message fails to send:

Provide:

```text
Message couldn't be sent.
[Try Again]
```

Do not erase the user's typed message.

---

# Failed AI Response

If Groq fails:

```text
I'm temporarily unable to respond.
Please try again or contact the SMEvolve team.
```

---

# Offline / Network Failure

If the browser loses connectivity:

```text
You're offline.
Check your connection and try again.
```

The current input should remain available where technically possible.

---

# Accessibility

The chatbot must support:

- Keyboard navigation.
- Screen readers.
- Focus management.
- Visible focus indicators.
- Accessible labels.
- Escape-to-close.
- Proper dialog semantics.

---

# Chat Window Focus

When opened:

```text
Focus → Chat input
```

When closed:

```text
Focus → Floating AI button
```

This ensures logical keyboard navigation.

---

# Reduced Motion

If the user enables reduced motion:

Disable or reduce:

- Bubble pulse.
- Chat opening animation.
- Message animations.

---

# Conversation Analytics

Track non-sensitive events such as:

```text
chat_opened
chat_started
message_sent
message_received
quote_started
human_handoff
chat_closed
```

---

# Analytics Privacy

Analytics should avoid unnecessarily recording full conversation content.

Where possible, use event metadata instead.

---

# Performance

The chatbot should not significantly affect page performance.

Recommended:

- Lazy-load chat interface.
- Lazy-load AI functionality.
- Avoid loading unnecessary scripts on initial page load.
- Keep the floating bubble lightweight.

---

# AI Availability

If AI is disabled by an administrator:

The floating bubble should either:

1. Be hidden, or
2. Display a controlled fallback contact experience.

The preferred behaviour should be configurable.

---

# Admin Controls

Future Admin Portal controls may include:

```text
AI Assistant ON/OFF

Welcome Message

Bubble Visibility

Bubble Position

Welcome Prompt Frequency

Conversation Retention

AI Availability Message
```

---

# Conversation Data Protection

Conversation data must follow the AI Security specification.

The system must:

- Protect access.
- Minimize storage.
- Follow retention rules.
- Prevent public exposure.
- Prevent cross-user access.

---

# Acceptance Criteria

The conversation system is complete when:

✓ Conversations have unique identifiers.

✓ Anonymous visitors can use the assistant.

✓ Messages have defined roles.

✓ Context is controlled.

✓ Long conversations can be summarized.

✓ Conversations can be recovered.

✓ Quote handoff is supported.

✓ AI cannot arbitrarily create leads.

✓ Human handoff is supported.

✓ Floating AI bubble is defined.

✓ Mobile behaviour is defined.

✓ Accessibility is defined.

✓ Failure states are defined.

✓ Conversation analytics are defined.

✓ AI can be disabled from the Admin Portal.

✓ Performance requirements are defined.

---

# Revision Policy

Review this document whenever:

- Chatbot UI changes.
- Quote Wizard changes.
- AI provider changes.
- Conversation storage changes.
- New AI capabilities are introduced.
- Admin controls expand.