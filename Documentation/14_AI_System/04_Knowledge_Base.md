# SMEvolve AI System
## Part 4 – Knowledge Base

**Project Name:** SMEvolve

**Website:** https://smevolve.tech

**Version:** 1.0

**Document Type:** AI Knowledge Base Architecture

---

# Purpose

This document defines the information architecture, sources, access rules, update mechanisms, and data priorities for the SMEvolve AI Knowledge Base.

The Knowledge Base is the primary source of verified business information used by:

- SMEvolve AI Assistant
- AI Quote Wizard
- Future AI-powered business tools

Its primary purpose is to reduce hallucinations and ensure that AI responses reflect current SMEvolve information.

---

# Core Principle

The AI should answer questions using verified SMEvolve information whenever the question concerns the company.

The AI must not invent missing business information.

---

# Knowledge Architecture

The system should follow:

```text
SMEvolve Data
      ↓
Knowledge Sources
      ↓
Knowledge Service
      ↓
Relevant Context
      ↓
AI Service
      ↓
Groq
```

The AI should receive only the information relevant to the current request.

---

# Knowledge Categories

The initial Knowledge Base should contain:

```text
Company
Services
Packages
Portfolio
FAQ
Contact
Business Settings
Legal
Quote Configuration
AI Instructions
```

---

# 1. Company Knowledge

Contains:

- Company name
- Company description
- Mission
- Vision
- Business focus
- Target customers
- Industries served
- Company values

The information should come from approved SMEvolve content.

---

# 2. Services Knowledge

Contains information about every active SMEvolve service.

Each service should support:

```text
Name
Slug
Short Description
Full Description
Features
Benefits
Technology
Target Audience
Use Cases
Related Services
Status
```

---

# Service Status

Each service should have a status:

```text
Active
Draft
Archived
```

Only active services should normally be presented as current offerings.

---

# 3. Packages Knowledge

Package information should include:

```text
Package Name
Description
Price
Pricing Type
Features
Recommended Flag
Target Audience
Status
```

---

# Pricing Rules

The AI must never invent pricing.

If a package has a configured price:

Use the current configured price.

If pricing is unavailable:

Say:

> "Pricing depends on your requirements. I can help you request a tailored quote."

---

# 4. Portfolio Knowledge

Portfolio entries may include:

```text
Project Name
Description
Industry
Services Used
Technologies
Project URL
Featured Status
```

Only approved portfolio entries should be accessible to the public AI Assistant.

---

# 5. FAQ Knowledge

FAQ entries should contain:

```text
Question
Answer
Category
Priority
Published Status
```

Only published FAQs should be used.

---

# FAQ Priority

If multiple answers exist for a similar question:

Use the highest-priority approved answer.

---

# 6. Contact Knowledge

Contact information should be centralized.

Possible fields:

```text
Phone
Email
WhatsApp
Address
Business Hours
Social Links
```

The AI must retrieve these values dynamically.

Do not hard-code contact information inside AI prompts.

---

# 7. Business Settings

Business settings may include:

```text
Company Name
Tagline
Default Currency
Timezone
Business Hours
Contact Information
Social Media
```

These values should be controlled through the Admin Portal.

---

# 8. Legal Knowledge

Legal information may include references to:

- Privacy Policy
- Terms & Conditions
- Cookie Policy

The AI should provide links to the appropriate legal page where applicable.

The AI should not provide legal advice.

---

# 9. Quote Configuration

The Knowledge Base should support Quote Wizard configuration.

Possible information:

```text
Service Types
Project Categories
Available Features
Budget Ranges
Timeline Options
Qualification Questions
Scoring Rules
```

---

# 10. AI Instructions

AI instructions should define:

- Assistant role
- Communication style
- Business boundaries
- Safety rules
- Escalation rules

These instructions are separate from business knowledge.

---

# Knowledge Priority

When multiple sources contain information, use this priority:

```text
1. Current Admin Configuration
2. Published Knowledge Base Data
3. Approved Website Content
4. Approved Static Documentation
5. General Knowledge
```

Business-specific information must always prioritize official SMEvolve sources.

---

# Knowledge Freshness

Each knowledge item should support:

```text
created_at
updated_at
status
```

This allows the AI system to identify current information.

---

# Draft Information

Draft information must not be provided to normal website visitors.

Example:

```text
Service:
AI Automation

Status:
Draft
```

The AI should not say:

> "SMEvolve offers AI Automation."

until the service is published.

---

# Archived Information

Archived information should not normally be presented as a current offering.

If historical information is relevant, the system may explicitly identify it as historical.

---

# Knowledge Service

Create a dedicated service for retrieving AI context.

Suggested:

```text
app/
└── Services/
    └── AI/
        └── KnowledgeService.php
```

Responsibilities:

- Search knowledge.
- Filter published information.
- Retrieve relevant content.
- Apply business rules.
- Prepare AI context.

---

# Context Retrieval

The system should retrieve only relevant information.

Example:

User asks:

> "Do you build ecommerce websites?"

Retrieve:

```text
Relevant Services
Relevant FAQ
Relevant Portfolio
Relevant Package
```

Do not retrieve unrelated information such as:

```text
Cookie Policy
Office Address
Other Services
```

unless necessary.

---

# Search Strategy

Initial implementation may use:

- Keyword matching.
- Database filtering.
- Service categories.
- FAQ categories.
- Tags.

The architecture should allow future semantic search.

---

# Future Semantic Search

The Knowledge Base should be designed to support:

```text
User Question
      ↓
Embedding
      ↓
Vector Search
      ↓
Relevant Knowledge
      ↓
Groq
```

This can be introduced later if the Knowledge Base becomes large.

---

# Knowledge Context Format

Retrieved information should be transformed into a structured AI context.

Example:

```text
SERVICE:
Name: Laravel Development

Description:
Custom Laravel applications for businesses.

Features:
- Authentication
- Dashboards
- APIs
- Database systems
```

The AI should receive structured information rather than raw database records.

---

# Context Size

Do not send excessive knowledge to Groq.

Use:

```text
Relevant Context
+
Recent Conversation
+
Current User Message
```

Avoid sending the entire Knowledge Base with every request.

---

# Data Ownership

SMEvolve owns and controls business knowledge.

The Admin Portal should eventually allow authorized administrators to update:

- Services
- Packages
- FAQs
- Portfolio
- Contact details
- Business information

---

# Admin Updates

When an administrator updates information:

```text
Admin Update
      ↓
Database
      ↓
Knowledge Service
      ↓
Next AI Request
```

The AI should use the updated information without requiring source-code changes.

---

# Knowledge Validation

Before publishing knowledge:

Verify:

- Content accuracy.
- Business approval.
- Correct pricing.
- Correct contact information.
- Correct service status.

---

# Sensitive Information

The following must never be included in public AI context:

- API keys.
- Passwords.
- Database credentials.
- Admin credentials.
- Internal security configuration.
- Private client information.
- Confidential business information.

---

# Client Information

Private client information must not become general AI knowledge.

For example:

```text
Client A project details
```

must not become accessible to:

```text
Website Visitor B
```

---

# Knowledge Isolation

Public AI context should be separated from private administrative information.

Architecture:

```text
                    Knowledge System
                          │
             ┌────────────┴────────────┐
             │                         │
       Public Knowledge          Private Knowledge
             │                         │
        Website AI                Admin Only
```

---

# AI Context Rules

The AI should:

1. Use retrieved knowledge.
2. Respect knowledge status.
3. Respect access permissions.
4. Avoid unsupported claims.
5. Ask for clarification when necessary.

---

# Unknown Information

If relevant information does not exist:

The AI should not guess.

Example:

> "I don't have that information available right now. I can connect you with the SMEvolve team."

---

# Knowledge Links

Where appropriate, retrieved knowledge should include the relevant page URL.

Examples:

```text
/services
/packages
/portfolio
/faq
/contact
```

The AI may direct visitors to those pages.

---

# Knowledge Analytics

The system may eventually track:

- Most requested services.
- Most common questions.
- Missing knowledge topics.
- Failed AI queries.
- Frequently requested information.

This can help SMEvolve improve its website and services.

---

# Knowledge Improvement Loop

The system should support:

```text
User Question
      ↓
AI Answer
      ↓
Was information available?
      ↓
     No
      ↓
Log Knowledge Gap
      ↓
Admin Review
      ↓
Add / Update Knowledge
      ↓
Future AI Response Improves
```

---

# Future Knowledge Sources

The architecture should eventually support:

- Website content
- Database records
- Admin-managed content
- Internal documentation
- Service documentation
- FAQ
- Portfolio
- Approved PDFs
- Structured business data

Only approved sources should become public AI knowledge.

---

# Acceptance Criteria

The Knowledge Base is complete when:

✓ Business information has defined sources.

✓ Services have structured data.

✓ Packages have structured data.

✓ FAQs have structured data.

✓ Portfolio information has defined structure.

✓ Contact information is centralized.

✓ Draft content is excluded.

✓ Archived content is controlled.

✓ Private information is isolated.

✓ AI context is filtered.

✓ Knowledge Service is defined.

✓ Future semantic search is possible.

✓ Admin updates can flow into AI.

✓ Hallucination risks are minimized.

---

# Revision Policy

Review this document whenever:

- New services are added.
- Packages change.
- Pricing changes.
- Business information changes.
- New AI features are introduced.
- Admin Portal functionality expands.
- Semantic search is introduced.