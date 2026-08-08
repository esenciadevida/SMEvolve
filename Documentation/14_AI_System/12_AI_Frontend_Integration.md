# SMEvolve AI System
## Part 12 – AI Frontend Integration

**Project Name:** SMEvolve

**Website:** https://smevolve.tech

**Version:** 1.0

**Document Type:** AI Frontend Integration Specification

---

# Purpose

This document defines how the SMEvolve website frontend integrates with the AI backend.

It covers:

- Floating AI Assistant.
- Chat interface.
- Conversation lifecycle.
- Message states.
- API communication.
- Loading states.
- Streaming.
- Errors.
- Quote Wizard integration.
- Mobile behaviour.
- Accessibility.
- AI availability.
- Frontend security.

---

# Core Principle

The frontend is responsible for presentation and user interaction.

The backend is responsible for:

- AI processing.
- Business rules.
- Knowledge retrieval.
- Prompt construction.
- Groq communication.
- Validation.
- Security.

Architecture:

```text
Frontend
   ↓
Laravel API
   ↓
AI Services
   ↓
Groq
```

The browser must never communicate directly with Groq.

---

# Frontend Components

Recommended component structure:

```text
AIWidget
├── AIBubble
├── AIWelcomePrompt
├── AIChatPanel
│   ├── AIChatHeader
│   ├── AIMessageList
│   ├── AIMessage
│   ├── AITypingIndicator
│   ├── AISuggestedActions
│   └── AIInput
└── AIErrorState
```

---

# AIWidget

The top-level component controls:

- AI bubble.
- Chat panel.
- Conversation state.
- Session state.
- API communication.

---

# AI Bubble

The floating AI bubble is the primary entry point.

Recommended location:

```text
Bottom-right
```

It must:

- Remain visible on public pages.
- Be touch-friendly.
- Avoid blocking important controls.
- Respect mobile safe areas.
- Be keyboard accessible.

---

# Bubble States

The bubble may have:

```text
Default
Hover
Focused
Unread
Disabled
Loading
```

---

# Default

Display:

```text
SMEvolve AI
```

or the approved AI icon.

---

# Hover

Display a subtle tooltip:

```text
Chat with SMEvolve
```

---

# Focus

Provide a clearly visible keyboard focus state.

---

# Unread

If the AI has an active conversation response waiting:

```text
Unread indicator
```

Do not use aggressive animation.

---

# Disabled

If AI is disabled:

The bubble may:

1. Be hidden, or
2. Open a fallback contact experience.

The behaviour should follow the AI configuration.

---

# Welcome Prompt

The frontend may display a small prompt beside the bubble.

Example:

```text
Need help?
Chat with our AI Assistant.
```

The prompt should not automatically open the full chat window.

---

# Welcome Prompt Frequency

The prompt should be shown according to the configured frequency.

Examples:

```text
Once per session
Once per visitor
Disabled
```

---

# Chat Panel

The chat panel should include:

```text
Header
Message Area
Suggested Actions
Input Area
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

Actions:

```text
New Chat
Close
```

---

# Conversation Area

Messages should be displayed chronologically.

Example:

```text
User
   ↓
AI
   ↓
User
   ↓
AI
```

---

# User Message

User messages should visually distinguish themselves from AI responses.

Do not make the interface resemble a human-to-human chat in a misleading way.

---

# AI Message

AI responses should include a clear AI identity.

Example:

```text
SMEvolve AI
```

---

# Message Formatting

Support:

```text
Paragraphs
Bullets
Numbered lists
Basic emphasis
Links
```

Do not render arbitrary HTML returned by the AI.

---

# Markdown

If Markdown is supported:

Only allow a safe subset.

The frontend must sanitize rendered output.

---

# Links

AI-generated links must be validated.

External links should use appropriate security attributes.

---

# Suggested Actions

The chatbot may display contextual actions.

Examples:

```text
Get a Quote
Explore Services
View Packages
Contact SMEvolve
```

---

# Suggested Action Behaviour

Example:

```text
Get a Quote
     ↓
Start Quote Session
```

Another:

```text
Contact SMEvolve
     ↓
Contact Page
```

---

# Conversation Initialization

When the user opens the AI Assistant:

```text
Check existing session
        ↓
Existing conversation?
   ┌────┴────┐
  YES       NO
   ↓         ↓
Restore    Create
```

---

# Create Conversation

Frontend request:

```text
POST /api/v1/ai/conversations
```

Request:

```json
{
    "channel": "website"
}
```

Store the returned conversation identifier securely in the frontend session.

---

# Conversation Storage

The frontend may store a temporary conversation identifier using an appropriate browser mechanism.

Do not store:

```text
Groq API keys
System prompts
Admin credentials
Private backend secrets
```

---

# Send Message

When the user submits:

```text
Validate Input
      ↓
Disable Duplicate Submission
      ↓
Show User Message
      ↓
Show AI Loading State
      ↓
Send API Request
```

---

# Optimistic UI

The user's message may appear immediately in the interface before the server response returns.

If the request fails:

```text
Message
 ↓
Failed
 ↓
Retry
```

The user's text should not be lost.

---

# Input Validation

Frontend validation should include:

```text
Required
Maximum length
Empty message prevention
```

Backend validation remains authoritative.

---

# Send Button

When empty:

```text
Disabled
```

When valid:

```text
Enabled
```

While sending:

```text
Loading
```

---

# Enter Key

Desktop:

```text
Enter → Send
```

For multiline input:

```text
Shift + Enter → New Line
```

---

# Mobile Input

The input should:

- Expand appropriately.
- Remain visible above the keyboard.
- Avoid being covered by the mobile browser UI.
- Maintain focus appropriately.

---

# Typing Indicator

While waiting for the AI:

```text
SMEvolve AI is thinking...
```

Use a subtle animation.

---

# Streaming

If streaming is enabled:

```text
User Message
      ↓
Request
      ↓
AI response begins
      ↓
Text progressively appears
```

The frontend should append streamed content safely.

---

# Streaming Failure

If streaming fails:

```text
Response interrupted.
[Try Again]
```

Do not display raw technical errors.

---

# Standard Response Mode

If streaming is unavailable:

```text
User sends message
      ↓
Loading indicator
      ↓
Complete AI response
      ↓
Display message
```

---

# Error States

The frontend should support:

```text
AI unavailable
Network error
Rate limited
Invalid request
Conversation expired
Server error
```

---

# AI Unavailable

Display:

```text
The AI Assistant is temporarily unavailable.
Please try again or contact the SMEvolve team.
```

Actions:

```text
Try Again
Contact SMEvolve
```

---

# Rate Limited

Display:

```text
You've reached the current chat limit.
Please try again later or contact the SMEvolve team.
```

---

# Network Error

Display:

```text
We couldn't connect to the AI Assistant.
Please check your internet connection and try again.
```

---

# Conversation Expired

If the backend indicates that the conversation has expired:

```text
This conversation has expired.
[Start New Chat]
```

Do not silently attach the user to an unrelated conversation.

---

# Retry

Failed AI messages should provide:

```text
Retry
```

The retry should create a controlled new request rather than repeatedly firing requests automatically.

---

# New Chat

The user should be able to start a new conversation.

Flow:

```text
New Chat
   ↓
Confirm if necessary
   ↓
Create Conversation
   ↓
Clear Current UI
```

---

# Conversation Completion

When the user finishes:

```text
Complete Conversation
```

The frontend may call:

```text
POST /api/v1/ai/conversations/{conversation}/complete
```

This is optional when simply closing the chat.

Closing the panel should not automatically mean the conversation is completed.

---

# Closing the Chat

When the user clicks close:

```text
Chat Panel
    ↓
Hidden
    ↓
Conversation remains available
```

---

# Reopening

When reopened:

```text
Restore Active Conversation
```

unless the conversation has expired or been completed.

---

# Quote Wizard Integration

The AI Assistant and Quote Wizard should feel like one connected experience.

Example:

```text
AI Assistant
     ↓
User describes project
     ↓
AI identifies opportunity
     ↓
"Would you like to get a quote?"
     ↓
[Start Quote]
     ↓
Quote Wizard
```

---

# Starting Quote from AI

The frontend should create a Quote Session.

```text
POST /api/v1/ai/quote-sessions
```

If the conversation exists:

```json
{
    "conversation_id": "uuid"
}
```

---

# AI-to-Quote Context

The backend may transfer relevant conversation information.

Possible information:

```text
Project Type
Business Type
Requirements
Goals
Features
Timeline
Budget
```

---

# User Confirmation

AI-derived information must be shown as editable.

Example:

```text
Project Type
[ E-commerce Website ▼ ]

AI detected this from your conversation.
You can change it.
```

---

# Quote Wizard Independence

The Quote Wizard must continue functioning if:

```text
AI disabled
Groq unavailable
AI request fails
```

The normal form must remain usable.

---

# Quote AI Assistance

Inside the Quote Wizard, AI may provide:

```text
Clarification
Suggestions
Requirement extraction
Project summary
```

---

# AI Assistance Indicator

Clearly identify AI-generated suggestions.

Example:

```text
AI Suggestion
```

Do not make AI suggestions appear to be confirmed user data.

---

# Confirm AI Data

Where AI fills a field:

```text
AI Suggestion
[Use This]
[Edit]
```

The user should remain in control.

---

# Quote Analysis

When enough information exists:

```text
Analyze Project
```

The frontend requests:

```text
POST /api/v1/ai/quote-sessions/{quoteSession}/analyze
```

---

# Quote Analysis Loading

Display:

```text
Analyzing your requirements...
```

Do not display fake progress percentages.

---

# Quote Analysis Result

Display:

```text
Project Summary
Recommended Service
Requirements
Complexity
```

---

# Pricing

The frontend must never calculate final project pricing from AI output.

If pricing is available:

```text
Use approved backend pricing data.
```

AI recommendations are not final prices.

---

# Quote Submission

Before submitting:

```text
Review
   ↓
Confirm Information
   ↓
Consent
   ↓
Submit
```

---

# Duplicate Submission Protection

The submit button should become disabled while the request is processing.

The backend must also enforce idempotency.

---

# Success State

After successful quote submission:

```text
Quote Submitted
```

Show:

```text
Reference Number
Next Steps
Contact Information
```

---

# Navigation After Quote

Possible actions:

```text
Return to Website
Contact SMEvolve
Continue Browsing
```

Do not force the user into another marketing action.

---

# AI Contact Handoff

If the user requests a human:

```text
AI
 ↓
Contact SMEvolve
```

Possible actions:

```text
WhatsApp
Email
Phone
Contact Form
```

The actual contact details must come from centralized website configuration.

---

# Frontend Security

Never expose:

```text
Groq API Key
AI system prompt
Admin API credentials
Database credentials
Internal configuration secrets
```

---

# XSS Protection

Never inject raw AI output into the DOM.

Sanitize:

```text
Markdown
HTML
Links
URLs
```

---

# CSRF

State-changing requests must use the application's CSRF protection strategy where applicable.

---

# Rate Limit Feedback

If the API returns:

```text
429
```

show a user-friendly message.

Do not expose internal rate-limit configuration unless intentionally designed.

---

# Accessibility

The AI interface must support:

- Keyboard navigation.
- Screen readers.
- Focus management.
- Accessible labels.
- Visible focus states.
- Escape-to-close.
- Appropriate dialog semantics.

---

# Chat Focus

When opening:

```text
Focus → Chat input
```

When closing:

```text
Focus → AI bubble
```

---

# Screen Reader Behaviour

New AI responses should be announced appropriately without causing excessive interruptions.

Use appropriate live-region behaviour.

---

# Reduced Motion

Respect:

```text
prefers-reduced-motion
```

Reduce:

- Bubble animation.
- Typing animation.
- Message transitions.

---

# Mobile Layout

The chat panel should:

- Fit the viewport.
- Respect safe areas.
- Avoid keyboard overlap.
- Avoid blocking navigation.
- Maintain readable text.
- Keep the input accessible.

---

# Desktop Layout

Recommended:

```text
Floating panel
Bottom-right
Responsive width
Maximum height
```

It should not dominate the entire screen.

---

# Loading States

Required loading states:

```text
Creating conversation
Sending message
AI generating response
Starting quote
Analyzing quote
Submitting quote
```

---

# Empty State

New conversation:

```text
Hi, I'm the SMEvolve AI Assistant.

I can help you explore our services,
answer questions, or start a quote.

How can I help?
```

---

# Session Persistence

If the user refreshes the page:

```text
Restore conversation
```

when a valid active session exists.

---

# Cross-Page Persistence

The AI widget should remain available as users navigate across public pages.

The conversation should not automatically reset when changing routes.

---

# Page Navigation

The AI state may be maintained through:

```text
Global application state
```

or an equivalent architecture appropriate to the frontend framework.

---

# API Client

Create a centralized AI API client.

Example:

```text
aiApi
```

Responsibilities:

```text
createConversation()
getConversation()
sendMessage()
startQuote()
getQuote()
saveQuoteAnswer()
analyzeQuote()
submitQuote()
requestHandoff()
completeConversation()
```

Do not scatter raw fetch/HTTP requests across components.

---

# AI State Management

Recommended state:

```text
conversationId
messages
conversationStatus
isOpen
isLoading
isStreaming
error
quoteSessionId
```

---

# State Separation

Separate:

```text
UI State
```

from:

```text
Server State
```

Example:

```text
UI:
isChatOpen

Server:
conversationStatus
messages
```

---

# Caching

Do not aggressively cache dynamic AI responses.

Conversation state should remain synchronized with the backend.

---

# API Race Conditions

Prevent situations where:

```text
User sends Message A
User sends Message B
```

before Message A has been processed unless the backend explicitly supports concurrent messages.

Recommended initial behaviour:

```text
One active request at a time.
```

---

# Message Ordering

Messages must be rendered according to server timestamps or sequence identifiers.

Do not rely only on frontend insertion order.

---

# Duplicate Messages

The frontend should use server-generated message IDs to prevent duplicate rendering.

---

# Analytics

Track non-sensitive events:

```text
ai_bubble_opened
ai_conversation_started
ai_message_sent
ai_response_received
ai_error
quote_started_from_ai
quote_completed
human_handoff_requested
```

Avoid sending complete conversation text to analytics platforms.

---

# Performance

The AI interface should be lazy-loaded where appropriate.

The initial website load should not be unnecessarily delayed by AI functionality.

---

# Failure Isolation

If AI fails:

```text
Main Website
      ↓
Continues Working
```

AI failure must never break:

- Navigation.
- Services.
- Contact page.
- Quote Wizard.
- Other core website functions.

---

# Browser Compatibility

The AI interface should support the browsers defined by the main SMEvolve frontend browser-support policy.

---

# Testing

Frontend tests should cover:

```text
Open chatbot
Close chatbot
Create conversation
Send message
Receive response
Retry failure
Rate limit
Network failure
Restore conversation
Start new chat
Start quote
Transfer AI context
Edit AI suggestion
Submit quote
Human handoff
Mobile layout
Keyboard navigation
Screen reader behaviour
```

---

# Acceptance Criteria

The AI frontend integration is complete when:

✓ Floating AI bubble works.

✓ Chat panel works.

✓ Conversation state persists.

✓ Messages are displayed correctly.

✓ Loading states exist.

✓ Error states exist.

✓ Retry works.

✓ Streaming is supported or cleanly abstracted.

✓ Quote Wizard integration works.

✓ AI suggestions remain editable.

✓ AI cannot determine final pricing.

✓ Human handoff works.

✓ Mobile layout works.

✓ Accessibility requirements are implemented.

✓ AI output is safely rendered.

✓ API calls are centralized.

✓ AI failure cannot break the main website.

✓ Analytics avoid unnecessary conversation-content collection.

---

# Revision Policy

Review this document whenever:

- Chat UI changes.
- API endpoints change.
- Quote Wizard changes.
- Frontend framework changes.
- AI provider changes.
- Accessibility requirements change.