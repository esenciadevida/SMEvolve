# SMEvolve Quote Wizard

## Part 01 – Overview

**Project:** SMEvolve

**Module:** Quote Wizard

**Version:** 1.0

**Document Type:** Product & Functional Overview

---

# Purpose

The SMEvolve Quote Wizard is a guided quotation and project-enquiry system that allows potential clients to provide information about their project and receive an appropriate next step from SMEvolve.

The Quote Wizard should make it easier for visitors to:

* Explain what they need.
* Identify the appropriate SMEvolve service.
* Provide project requirements.
* Provide budget and timeline information.
* Submit contact details.
* Receive confirmation.
* Request human assistance when necessary.

The system should also provide the SMEvolve team with structured lead information through the Admin Portal.

---

# Core Objective

The primary objective is to convert an uncertain website visitor into a structured project enquiry.

The system should transform:

```text
Visitor
   ↓
Project Idea
   ↓
Guided Questions
   ↓
Structured Requirements
   ↓
AI Assistance
   ↓
Review
   ↓
Quote Request
   ↓
Admin Lead
```

---

# Product Philosophy

The Quote Wizard should not feel like a complicated application form.

It should feel like a guided consultation.

The experience should:

* Ask only useful questions.
* Avoid unnecessary fields.
* Explain why information is requested where appropriate.
* Allow users to go backward.
* Allow users to edit answers.
* Preserve progress.
* Work without requiring an account.
* Work on mobile.
* Provide clear confirmation.

---

# Public Access

The Quote Wizard is a public-facing feature.

Visitors should not need to:

* Create an account.
* Log in.
* Create a client portal.
* Install an application.

A visitor should be able to begin immediately.

---

# Entry Points

The Quote Wizard may be accessed from:

```text
Get a Quote
```

Primary locations may include:

* Header navigation.
* Homepage CTA.
* Services pages.
* AI Assistant.
* Contact page.
* Service-specific CTA sections.

---

# AI Entry Point

The AI Assistant may recommend the Quote Wizard when appropriate.

Example:

```text
Visitor:
I need a website for my business.

SMEvolve AI:
I'd be happy to help you explore that.
Would you like to tell us a little more about your project?

[Get a Quote]
```

The AI should be able to transfer relevant information into the Quote Wizard where technically appropriate.

---

# Quote Wizard Independence

The Quote Wizard must not depend entirely on AI.

The standard flow must work when:

```text
AI disabled
```

or:

```text
Groq unavailable
```

The user should still be able to complete and submit a quote request.

---

# Core User Flow

The initial flow should be:

```text
Landing
   ↓
Project Type
   ↓
Business / Industry
   ↓
Project Requirements
   ↓
Features / Scope
   ↓
Timeline
   ↓
Budget
   ↓
Existing Assets
   ↓
Additional Information
   ↓
Contact Information
   ↓
Review
   ↓
Submit
   ↓
Confirmation
```

The exact question sequence may adapt based on previous answers.

---

# Progressive Disclosure

Do not display every possible question on the first screen.

Instead:

```text
Question
   ↓
Answer
   ↓
Next Relevant Question
```

Only collect information that is useful for the specific project.

---

# Conditional Questions

The wizard should support conditional logic.

Example:

```text
Do you need a website?

YES
 ↓
What type of website?
```

Another:

```text
Do you need online payments?

YES
 ↓
Which payment methods?
```

Questions that are not relevant should not be displayed.

---

# Supported Project Categories

The initial system should support categories such as:

```text
Website
Mobile App
Web Application
E-commerce
Custom Software
UI/UX Design
Digital Product
Other
```

The final categories must be based on the approved SMEvolve Services documentation.

---

# Project Requirements

The wizard should capture the user's actual requirements rather than relying only on a project category.

Example:

```text
Project:
E-commerce Website

Requirements:
- Product catalogue
- Customer accounts
- Online payment
- Order management
- Delivery integration
```

---

# Budget

Budget should be collected as an indicative project budget.

The user should understand that:

```text
Budget provided ≠ Final Quote
```

The information is used to help SMEvolve evaluate the project.

---

# Timeline

Collect the user's expected timeline.

Example options:

```text
As soon as possible
Within 1 month
1–3 months
3–6 months
More than 6 months
Not sure
```

The exact options may be adjusted during UI/UX design.

---

# Existing Assets

Where relevant, ask whether the client already has:

```text
Website
Branding
Logo
Content
Designs
Domain
Hosting
Mobile application
Existing software
```

This helps determine project complexity.

---

# Contact Information

At minimum collect:

```text
Full Name
Email
Phone Number
```

Additional information may include:

```text
Company / Business Name
Preferred Contact Method
```

Only collect information that is necessary.

---

# Review Step

Before submission, show a complete summary.

Example:

```text
Project
E-commerce Website

Business
Fashion

Requirements
Online catalogue
Payment
Customer accounts

Timeline
1–3 months

Budget
₦500,000 – ₦1,000,000

Contact
Samuel Ogundare
example@email.com
```

The user must be able to edit information before submitting.

---

# Submission

The final action should be clearly labelled.

Recommended:

```text
Submit Quote Request
```

Avoid misleading wording such as:

```text
Buy Now
Confirm Price
Accept Quote
```

because the wizard creates a project enquiry rather than a binding contract.

---

# Confirmation

After submission:

```text
Quote Request Received
```

Display:

* Reference number.
* Confirmation message.
* Expected next step.
* SMEvolve contact options.

---

# Reference Number

Each submitted quote should receive a unique reference.

Example:

```text
SME-2026-001245
```

The exact format may be defined during the Data Model stage.

---

# Admin Portal

Every submitted quote should be available to authorized administrators.

The Admin Portal should allow administrators to view:

```text
Lead
Project Type
Requirements
Budget
Timeline
Contact Information
AI Summary
Submission Date
Status
```

---

# Lead Status

Initial statuses:

```text
New
Contacted
Qualified
Proposal Sent
Won
Lost
Archived
```

The final status model should be defined in the Lead Management documentation.

---

# AI Assistance

AI may assist with:

```text
Requirement extraction
Question clarification
Project categorization
Service recommendation
Requirement summary
Missing-information detection
```

---

# AI Boundaries

AI must not:

* Invent client requirements.
* Invent project pricing.
* Promise delivery dates.
* Approve discounts.
* Accept contracts.
* Make binding commitments.
* Submit information without appropriate user confirmation.

---

# AI-Generated Data

When AI extracts information, the system should identify the source.

Example:

```text
Source:
AI Suggestion
```

or:

```text
Source:
User Provided
```

User-provided information should take priority over AI inference.

---

# Human Review

Every submitted quote request should be treated as a lead requiring SMEvolve review.

The Quote Wizard does not automatically create a binding quotation.

---

# Data Ownership

Submitted quote information belongs to the SMEvolve application and should be handled according to the Privacy Policy and applicable data-protection requirements.

---

# No Client Portal

The Quote Wizard does not create a client account.

There is no requirement for:

```text
Client Dashboard
Client Login
Client Project Portal
Client Billing Portal
```

Those may be introduced as separate future products if required.

---

# Admin Control

The Admin Portal should eventually allow authorized administrators to manage important Quote Wizard configuration.

Examples:

```text
Project Categories
Budget Ranges
Timeline Options
Questions
Question Ordering
Conditional Rules
Service Associations
```

The exact administrative scope will be defined later.

---

# Data Persistence

The wizard should preserve progress during an active session.

If the visitor accidentally refreshes the page, the system should attempt to restore the current draft where technically appropriate.

---

# Abandoned Quotes

A visitor may leave before submission.

The system should distinguish:

```text
Draft
Abandoned
Submitted
```

Abandoned records should not be treated as completed leads.

---

# Validation

All important fields must be validated on:

```text
Frontend
Backend
```

Frontend validation improves UX.

Backend validation remains authoritative.

---

# Security

The Quote Wizard must protect:

* Personal information.
* Contact details.
* Project information.
* Internal notes.
* AI-generated information.
* Administrative data.

Users must not be able to access another visitor's quote session.

---

# Accessibility

The Quote Wizard must support:

* Keyboard navigation.
* Screen readers.
* Visible focus states.
* Proper labels.
* Error announcements.
* Logical heading structure.
* Accessible progress indicators.

---

# Responsive Design

The Quote Wizard must work on:

```text
Mobile
Tablet
Desktop
```

Mobile should be treated as a primary experience rather than a reduced desktop version.

---

# Performance

The Quote Wizard should prioritize:

* Fast initial loading.
* Minimal JavaScript.
* Efficient API requests.
* No unnecessary AI requests.
* Small frontend payloads.
* Reliable form persistence.

---

# SEO

The Quote Wizard itself should not necessarily be treated as a major SEO landing page.

The primary SEO goal should remain the public SMEvolve service pages.

The wizard should still have:

* Appropriate page title.
* Description where appropriate.
* Canonical URL.
* No unnecessary duplicate-indexing behaviour.

---

# Analytics

Track useful conversion events such as:

```text
quote_started
quote_step_completed
quote_abandoned
quote_submitted
quote_ai_used
quote_ai_suggestion_accepted
quote_ai_suggestion_rejected
```

Do not send unnecessary personal information to third-party analytics platforms.

---

# Error Handling

If something fails:

```text
Save Failed
```

or:

```text
Submission Failed
```

The user should receive a clear explanation and recovery action.

Example:

```text
We couldn't submit your request.
Your information has not been lost.

Please try again.
```

---

# Future Compatibility

The architecture should allow future features such as:

* File uploads.
* Project attachments.
* More advanced AI analysis.
* Automated proposal generation.
* CRM integrations.
* Email automation.
* WhatsApp notifications.
* Client accounts.

These should not be implemented as part of the initial Quote Wizard unless separately approved.

---

# Success Criteria

The Quote Wizard is successful when:

✓ Visitors can request a quote without creating an account.

✓ The flow is simple and guided.

✓ Questions adapt to the project.

✓ Users can review and edit information.

✓ AI can assist without becoming a dependency.

✓ Submitted information is structured.

✓ Leads appear in the Admin Portal.

✓ Administrators can manage lead status.

✓ Users receive a confirmation and reference number.

✓ The system works on mobile.

✓ The system is accessible.

✓ Personal information is protected.

✓ The wizard does not make binding pricing promises.

✓ The normal quote process continues working when AI is unavailable.

---

# Revision Policy

Review this document whenever:

* Quote Wizard functionality changes.
* SMEvolve services change.
* AI integration changes.
* Lead management changes.
* Admin Portal functionality changes.
* Privacy requirements change.
* Quote submission requirements change.
