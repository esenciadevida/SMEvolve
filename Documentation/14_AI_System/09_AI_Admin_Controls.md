# SMEvolve AI System
## Part 9 – AI Admin Controls

**Project Name:** SMEvolve

**Website:** https://smevolve.tech

**Version:** 1.0

**Document Type:** AI Administration & Control Specification

---

# Purpose

This document defines the AI-related controls available to authorized SMEvolve administrators.

The Admin Portal should provide centralized control over important AI and business information while maintaining strict security boundaries.

The Admin Portal controls the AI system.

The AI system does not control the Admin Portal.

---

# Core Principle

The Admin Portal should allow authorized administrators to manage operational AI settings without requiring source-code changes for routine configuration.

However, sensitive infrastructure credentials and dangerous system-level operations must remain outside normal admin interfaces.

---

# Architecture

```text
Administrator
      ↓
Admin Portal
      ↓
Authorization
      ↓
AI Configuration
      ↓
Database / Application Configuration
      ↓
AI Service
      ↓
Groq
```

---

# Admin Access

Only authenticated and authorized administrators may access AI controls.

The public website must never expose these controls.

---

# Recommended Admin Roles

The initial system may support:

```text
Super Admin
Admin
Editor
```

---

# Super Admin

May manage:

- AI settings.
- AI availability.
- AI configuration.
- Knowledge.
- Prompts.
- Quote configuration.
- Business settings.
- Other administrative functions.

---

# Admin

May manage approved operational settings according to assigned permissions.

---

# Editor

May manage content such as:

- FAQs.
- Services.
- Packages.
- Portfolio.

Editor access should not automatically include:

- AI security settings.
- API credentials.
- Prompt system settings.
- Administrator management.

---

# AI Dashboard

The Admin Portal should provide an AI overview.

Possible metrics:

```text
AI Conversations
AI Messages
Quote AI Sessions
Quote Completions
Human Handoffs
AI Errors
AI Availability
```

---

# AI Status

Display:

```text
AI Assistant: ON

Quote AI: ON

Groq: Connected
```

The exact provider status should be determined by a secure server-side health check.

---

# AI Assistant Toggle

Admin may enable or disable:

```text
Website AI Assistant
```

Possible states:

```text
Enabled
Disabled
```

---

# Quote AI Toggle

Admin may independently control:

```text
AI Quote Assistant
```

This allows the Quote Wizard to continue operating as a normal form even when AI assistance is disabled.

---

# Global AI Availability

A global switch may be provided:

```text
AI System
ON / OFF
```

If disabled:

- AI Assistant stops responding.
- Quote AI stops responding.
- Normal website functionality remains available.

---

# Welcome Message

Admin may configure the chatbot welcome message.

Example:

> "Hi! I'm the SMEvolve AI Assistant. How can I help you today?"

The message should be stored as configurable content.

---

# Bubble Configuration

Admin may configure selected floating AI bubble settings.

Possible settings:

```text
Visible
Hidden
Welcome Prompt Enabled
```

Position should normally remain a design-system setting rather than an arbitrary admin setting.

---

# AI Availability Message

When AI is temporarily disabled:

Admin may configure a fallback message.

Example:

> "Our AI Assistant is temporarily unavailable. You can still contact the SMEvolve team or request a quote."

---

# AI Model

The active Groq model may be configurable.

Example:

```text
Current Model:
[Configured Groq Model]
```

Changing the model should be restricted to authorized administrators.

---

# Important Model Rule

The Admin Portal should not assume that every arbitrary model name is valid.

Model configuration must be validated.

---

# API Credentials

The Groq API key must **not** be displayed in plaintext.

Do not provide:

```text
Current API Key:
gsk_xxxxxxxxxxxxx
```

Instead display:

```text
Groq API:
Connected
```

or:

```text
Groq API:
Not Configured
```

---

# API Key Management

API credentials should preferably be managed through:

- Server environment variables.
- Hosting secret manager.
- Deployment configuration.

If an administrative secret-management interface is introduced later, it must be heavily restricted and must never expose existing secret values.

---

# AI Usage Limits

Admin may configure operational limits such as:

```text
Maximum requests per session
Maximum message length
Maximum conversation length
Rate limit
```

---

# Cost Controls

Possible controls:

```text
Daily request limit
Monthly request limit
Alert threshold
Maximum output length
```

These controls help prevent unexpected AI usage.

---

# AI Knowledge Controls

Administrators should be able to manage the information available to the AI.

Examples:

```text
Services
Packages
FAQ
Portfolio
Company Information
Contact Information
Business Hours
```

---

# Knowledge Publishing

Content should support:

```text
Draft
Published
Archived
```

Only published content should normally be available to public AI.

---

# Service Management

Admin may manage:

```text
Service Name
Description
Features
Benefits
Status
Related Services
```

Changes should automatically become available to the Knowledge Service after publication.

---

# Package Management

Admin may manage:

```text
Package Name
Description
Price
Pricing Type
Features
Recommended
Status
```

Changes to pricing should immediately affect future AI responses once published.

---

# Pricing Safety

The AI should never retain an outdated price after an updated package becomes active.

The Knowledge Service must always retrieve current published pricing.

---

# FAQ Management

Admin may:

```text
Create FAQ
Edit FAQ
Publish FAQ
Unpublish FAQ
Archive FAQ
```

FAQ entries should be searchable by the Knowledge Service.

---

# Contact Information

The Admin Portal should control centralized business contact information.

Possible fields:

```text
Phone
Email
WhatsApp
Address
Business Hours
```

These values should be reused throughout the website.

This includes:

- Header.
- Footer.
- Contact page.
- Quote confirmation.
- AI Assistant.

---

# Social Media

Admin may manage:

```text
Facebook
Instagram
LinkedIn
X
TikTok
YouTube
```

Only configured links should be displayed.

---

# Business Information

Admin may manage:

```text
Company Name
Tagline
Description
Mission
Vision
```

This information may be used by the website and AI.

---

# AI Prompt Management

Authorized administrators may eventually manage approved AI prompts.

Possible controls:

```text
View Current Prompt
Create New Version
Activate Version
Deactivate Version
Rollback Version
```

---

# Prompt Permissions

Prompt editing should be restricted.

Recommended:

```text
Super Admin → Full access

Admin → Optional limited access

Editor → No access
```

---

# Prompt Version History

Every prompt version should include:

```text
Version
Status
Created By
Created At
Activated At
```

---

# Prompt Rollback

If a prompt causes problems:

```text
Current Prompt
      ↓
Problem Detected
      ↓
Rollback
      ↓
Previous Approved Prompt
```

---

# AI Configuration Audit Log

Important changes should be logged.

Examples:

```text
AI enabled
AI disabled
Model changed
Prompt activated
Prompt rolled back
Rate limit changed
Knowledge published
Package price changed
```

---

# Audit Log Information

Suggested:

```text
admin_id
action
resource
old_value
new_value
timestamp
ip_address
```

Sensitive values such as API keys must never be written to audit logs.

---

# Knowledge Audit

Changes to business knowledge should be traceable.

Example:

```text
Package:
Business Website

Old Price:
X

New Price:
Y

Changed By:
Administrator

Date:
...
```

---

# AI Health Check

The Admin Portal may provide:

```text
Groq Connection
Knowledge Service
AI Service
Database
```

Possible states:

```text
Healthy
Warning
Unavailable
```

---

# Health Check Security

Health checks must not expose:

- API keys.
- Internal server details.
- Stack traces.
- Database credentials.

---

# AI Error Monitoring

The Admin Portal may display:

```text
AI Requests
Successful
Failed
Timeouts
Rate Limits
```

---

# Conversation Analytics

Admin may view aggregate information such as:

```text
Conversations Started
Conversations Completed
Average Messages
Quote Handoffs
Human Handoffs
```

---

# Privacy Restrictions

Administrators should not automatically have access to every conversation.

Conversation access should be permission-controlled.

Where possible, show aggregate analytics rather than full private conversations.

---

# Quote Lead Integration

AI-generated quote information should appear in the Admin Portal as structured lead information.

Example:

```text
Lead

Project:
Ecommerce Website

Complexity:
Moderate

Budget:
Configured Range

Requirements:
...

AI Summary:
...
```

---

# AI Recommendations

AI recommendations should be clearly labelled:

```text
AI Recommendation
```

They must not be presented as final business decisions.

---

# Admin Approval

Important AI-assisted business actions should require human approval.

Examples:

```text
Final Quote
Proposal
Discount
Contract
Project Acceptance
```

---

# Dangerous Controls

The normal Admin Portal must not provide unrestricted controls for:

- Database deletion.
- Server command execution.
- API key exposure.
- Arbitrary code execution.
- AI tool execution with unrestricted permissions.

---

# Security Boundaries

The Admin Portal should follow:

```text
Admin
 ↓
Authorized Action
 ↓
Application Validation
 ↓
Database
```

Never:

```text
Admin
 ↓
Direct Database Command
```

---

# Admin Confirmation

Destructive actions should require confirmation.

Example:

```text
Archive Package?

[Cancel]

[Confirm]
```

---

# Two-Factor Authentication

The architecture should support optional or recommended 2FA for privileged administrator accounts.

Especially:

```text
Super Admin
```

---

# Session Security

Admin sessions should use:

- Secure cookies.
- HTTPS.
- Appropriate session expiration.
- CSRF protection.
- Authorization middleware.

---

# Admin Notifications

Important AI events may notify administrators.

Examples:

```text
Groq unavailable
AI usage limit reached
High error rate
Prompt changed
Critical configuration changed
```

---

# Configuration Cache

Where appropriate, frequently accessed settings may be cached.

However:

When an administrator changes critical business information:

```text
Admin Update
 ↓
Invalidate Cache
 ↓
New Configuration
```

The AI must not continue using stale information.

---

# Emergency AI Disable

The system should provide a fast way to disable public AI.

Example:

```text
Emergency AI Disable
```

This should immediately prevent new AI requests while keeping the website operational.

---

# AI Disable Behaviour

When disabled:

```text
Chatbot
 ↓
Fallback
 ↓
Contact / Quote
```

The Quote Wizard should continue to work without AI.

---

# Acceptance Criteria

AI Admin Controls are complete when:

✓ AI can be enabled/disabled.

✓ Quote AI can be independently enabled/disabled.

✓ Model configuration is controlled.

✓ API credentials remain protected.

✓ AI usage limits are configurable.

✓ Knowledge can be managed.

✓ Services can be managed.

✓ Packages can be managed.

✓ FAQs can be managed.

✓ Contact information is centralized.

✓ Prompt versions can be controlled.

✓ Important changes are audited.

✓ AI health can be monitored.

✓ AI analytics are available.

✓ Sensitive information is protected.

✓ Emergency AI disable exists.

✓ Admin authorization is enforced.

---

# Revision Policy

Review this document whenever:

- Admin Portal capabilities change.
- New AI features are added.
- New administrators or roles are introduced.
- New business configuration is added.
- AI provider changes.
- Security requirements change.