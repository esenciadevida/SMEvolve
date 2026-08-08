# SMEvolve Quote Wizard

## Part 02 – User Flow

**Project:** SMEvolve

**Module:** Quote Wizard

**Version:** 1.0

**Document Type:** User Flow & Journey Specification

---

# Objective

Define the complete user journey through the SMEvolve Quote Wizard.

The flow must be simple enough for a first-time visitor while collecting enough structured information for the SMEvolve team to understand the project.

The wizard should behave as a guided consultation rather than a traditional long-form questionnaire.

---

# Primary User Journey

```text
Visitor
   ↓
Get a Quote
   ↓
Quote Wizard Introduction
   ↓
Project Type
   ↓
Business Information
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
Consent
   ↓
Submit Quote Request
   ↓
Confirmation
```

---

# Entry Points

Users may enter the Quote Wizard through:

```text
Header
Homepage
Services Page
Individual Service Page
Contact Page
AI Assistant
Other approved CTA locations
```

All entry points should lead to the same underlying Quote Wizard architecture.

---

# Entry Point With AI

A user may begin through the AI Assistant.

Example:

```text
User
 ↓
AI Assistant
 ↓
Project discussion
 ↓
AI identifies quote opportunity
 ↓
Start Quote
 ↓
Quote Wizard
```

Where sufficient information has already been collected, the AI may pass relevant information into the draft Quote Session.

---

# Direct Entry

A user may also enter directly:

```text
Get a Quote
     ↓
Quote Wizard
```

No AI conversation is required.

---

# Step 0 – Introduction

The first screen should explain what the wizard does.

Example:

```text
Let's Talk About Your Project

Tell us a little about what you're looking to build.
We'll use your answers to understand your needs and
help our team prepare the right next step.

Estimated time: 3–5 minutes

[Start My Quote]
```

The exact copy should follow the approved content and design system.

---

# Introduction Requirements

The introduction should communicate:

* Purpose.
* Approximate completion time.
* No obligation to submit.
* Information can be reviewed before submission.

Avoid unnecessary legal or technical language.

---

# Step 1 – Project Type

Ask:

```text
What are you looking to build?
```

Possible options:

```text
Website
E-commerce Website
Web Application
Mobile Application
Custom Software
UI/UX Design
Other
```

The final options must correspond to approved SMEvolve services.

---

# Project Type Selection

The user should select one primary project type initially.

If multiple services are required, the wizard should provide a later opportunity to indicate additional requirements.

---

# Other Project Type

If the user selects:

```text
Other
```

display:

```text
Tell us what you have in mind.
```

Allow a short description.

---

# Step 2 – Business Information

Ask:

```text
Tell us about your business.
```

Possible fields:

```text
Business Name
Industry
Business Description
```

Business Name may be optional depending on the final UX.

---

# Industry

Provide common categories where appropriate.

Example:

```text
Technology
Retail
Healthcare
Education
Finance
Hospitality
Real Estate
Logistics
Professional Services
Other
```

Allow:

```text
Other
```

with a custom response.

---

# Step 3 – Project Description

Ask:

```text
What would you like us to build?
```

Provide a larger text area.

The user should be able to explain the project naturally.

Example:

```text
I want an online platform where customers can
book and pay for cleaning services.
```

---

# AI Assistance

The AI may help interpret the project description.

Example:

```text
Your description suggests you may need:

• Customer booking
• Online payments
• Service management

[Review Suggestions]
```

The user must be able to edit or reject the suggestions.

---

# Step 4 – Requirements

Based on the project type, display relevant requirements.

For a website:

```text
Company Information
Services
Contact Forms
Blog / Articles
Gallery
Booking
Payments
Customer Accounts
```

For an e-commerce project:

```text
Product Catalogue
Shopping Cart
Checkout
Payments
Customer Accounts
Order Management
Delivery
```

For a mobile application:

```text
User Accounts
Push Notifications
Payments
Location
Messaging
Admin Dashboard
```

The exact options should be maintained in the Quote Wizard configuration.

---

# Conditional Requirements

Requirements should change based on the selected project type.

Example:

```text
Project Type:
E-commerce

↓

Show:
Products
Cart
Checkout
Payments
Orders
Delivery
```

Do not display irrelevant requirements.

---

# Step 5 – Existing Assets

Ask:

```text
Do you already have anything we can work with?
```

Possible options:

```text
Logo
Brand Guidelines
Website
Domain
Hosting
Content
Designs / Mockups
Existing Application
Nothing yet
```

Allow multiple selections.

---

# Existing Website

If selected:

```text
Do you currently have a website?
```

Optional:

```text
Website URL
```

---

# Existing Application

If selected:

```text
Tell us about your existing application.
```

This can help determine whether the project is:

```text
New Build
Redesign
Upgrade
Migration
Maintenance
```

---

# Step 6 – Timeline

Ask:

```text
When would you like to start?
```

Possible options:

```text
As soon as possible
Within 1 month
1–3 months
3–6 months
More than 6 months
I'm not sure
```

---

# Timeline Interpretation

Timeline information is indicative only.

The wizard must not promise:

```text
Guaranteed delivery date
Guaranteed start date
Guaranteed completion date
```

---

# Step 7 – Budget

Ask:

```text
Do you have a budget range in mind?
```

Options should be configured according to SMEvolve's approved pricing structure.

Example:

```text
Under ₦250,000
₦250,000 – ₦500,000
₦500,000 – ₦1,000,000
₦1,000,000 – ₦2,500,000
₦2,500,000+
Not sure yet
Prefer not to say
```

The actual ranges must come from the approved Quote Wizard configuration.

---

# Budget Disclaimer

Clearly communicate:

```text
Your budget helps us understand the scope of the project.
It does not represent a final quotation.
```

---

# Step 8 – Additional Information

Ask:

```text
Is there anything else you'd like us to know?
```

Optional free-text field.

Examples:

```text
Special requirements
Technical constraints
Competitor references
Preferred technologies
Important deadlines
Other concerns
```

---

# Step 9 – Contact Information

Collect:

```text
Full Name
Email
Phone Number
```

Optional:

```text
Company Name
Preferred Contact Method
```

---

# Contact Validation

Validate:

```text
Name
Email
Phone
```

The backend remains authoritative.

---

# Preferred Contact Method

Possible options:

```text
Email
Phone
WhatsApp
Any
```

Only show options supported by the current SMEvolve contact configuration.

---

# Step 10 – Review

Display all important information before submission.

Example:

```text
Project
E-commerce Website

Business
Fashion Retail

Requirements
Product Catalogue
Payments
Customer Accounts

Timeline
1–3 months

Budget
₦500,000 – ₦1,000,000

Contact
Samuel
example@email.com
07000000000
```

---

# Edit Behaviour

Each section should have:

```text
Edit
```

Selecting Edit should take the user directly to the relevant step.

After editing, the user should be able to return to Review.

---

# Step Navigation

The wizard must provide:

```text
Back
Next
```

The user should not lose entered information when moving backward.

---

# Progress Indicator

Display progress without creating unnecessary pressure.

Example:

```text
Step 4 of 9
```

or:

```text
██████░░░
```

The final UI should follow the design system.

---

# Dynamic Step Count

Because conditional questions may appear, the displayed progress should not falsely imply a fixed number of screens if the actual number changes.

The implementation may use:

```text
Current Step
```

rather than promising an exact total when the flow is dynamic.

---

# Required Fields

Only essential information should be mandatory.

Required fields should generally include:

```text
Project Type
Project Description
Name
Email
Phone
```

The final required-field configuration should be defined in the Questions & Fields document.

---

# Optional Fields

Where possible:

```text
Business Name
Industry
Budget
Timeline
Existing Assets
Additional Information
```

may remain optional depending on the project type.

---

# AI-Assisted Path

The AI may identify missing information.

Example:

```text
AI:
It looks like you'll need online payments.
Would you like to include that?

[Yes]
[No]
```

The user must make the final selection.

---

# AI Suggestion States

Every AI suggestion should support:

```text
Accept
Edit
Reject
```

---

# AI Confidence

The frontend should not expose technical confidence scores unless intentionally designed.

Instead use understandable language:

```text
We think this may be relevant to your project.
```

---

# AI Failure Path

If AI fails:

```text
AI unavailable
      ↓
Continue manually
```

The user must not be blocked.

---

# Quote Draft

As the user progresses, the system should maintain a draft Quote Session.

```text
Draft
 ↓
Progress
 ↓
Review
```

---

# Refresh Behaviour

If the user refreshes the page:

```text
Restore Draft
```

when a valid active session exists.

---

# Abandonment

If the user leaves before submission:

```text
Quote Session
=
Draft / Abandoned
```

Do not treat it as a submitted lead.

---

# Return to Draft

If a recoverable draft exists, provide:

```text
Continue Your Quote
```

where appropriate.

---

# Submission

The final flow is:

```text
Review
 ↓
Consent
 ↓
Submit Quote Request
 ↓
Processing
 ↓
Success
```

---

# Submission Protection

During submission:

```text
Submit Button
↓
Disabled
```

Prevent duplicate requests.

The backend must also protect against duplicate submissions.

---

# Submission Success

Display:

```text
Your Quote Request Has Been Received
```

Include:

```text
Reference Number
```

and the next step.

---

# Suggested Confirmation

Example:

```text
Thanks for reaching out to SMEvolve.

We've received your project request and our team
will review the information you provided.

Reference:
SME-2026-001245
```

---

# Contact After Submission

Provide:

```text
Contact SMEvolve
Return to Website
```

Use current centralized contact information.

---

# Error During Submission

If submission fails:

```text
We couldn't submit your request.
Please try again.
```

Preserve the entered information.

---

# Network Failure

The user should not lose the form because of a temporary network problem.

Provide:

```text
Retry
```

---

# Browser Back Button

The wizard should handle browser navigation gracefully.

The implementation should avoid unexpectedly losing progress.

---

# Mobile User Flow

On mobile:

```text
One primary question/section per screen
```

Avoid dense multi-column forms.

---

# Desktop User Flow

Desktop may use:

```text
Question
+
Context / Help
```

while maintaining a focused experience.

---

# Accessibility Flow

Every step must have:

* Clear page/step heading.
* Accessible labels.
* Keyboard navigation.
* Focus movement to the new question.
* Accessible error messages.
* Accessible progress indication.

---

# Data Source Priority

When the same information exists from multiple sources:

```text
User Confirmed Data
        ↓
AI Suggestion
        ↓
System Inference
```

User-confirmed data always takes priority.

---

# Lead Creation

A lead should only be created as a completed quote request after successful submission.

Before submission:

```text
Quote Session
```

After submission:

```text
Lead / Quote Request
```

---

# Admin Notification

After successful submission, the Admin Portal should receive the new lead.

Optional email notification may also be triggered.

The notification system will be defined separately.

---

# Analytics Events

Track:

```text
quote_started
quote_step_viewed
quote_step_completed
quote_ai_used
quote_ai_suggestion_accepted
quote_ai_suggestion_rejected
quote_review_viewed
quote_submitted
quote_abandoned
```

Do not send unnecessary personal information to analytics services.

---

# Complete Flow Diagram

```text
                    ┌───────────────┐
                    │    Visitor    │
                    └───────┬───────┘
                            │
                     Get a Quote
                            │
                            ▼
                  ┌──────────────────┐
                  │   Introduction   │
                  └────────┬─────────┘
                           │
                           ▼
                  ┌──────────────────┐
                  │  Project Type    │
                  └────────┬─────────┘
                           │
                           ▼
                  ┌──────────────────┐
                  │ Business Details │
                  └────────┬─────────┘
                           │
                           ▼
                  ┌──────────────────┐
                  │ Project Details  │
                  └────────┬─────────┘
                           │
                           ▼
                  ┌──────────────────┐
                  │ Requirements     │
                  └────────┬─────────┘
                           │
                           ▼
                  ┌──────────────────┐
                  │ Existing Assets  │
                  └────────┬─────────┘
                           │
                           ▼
                  ┌──────────────────┐
                  │    Timeline      │
                  └────────┬─────────┘
                           │
                           ▼
                  ┌──────────────────┐
                  │     Budget       │
                  └────────┬─────────┘
                           │
                           ▼
                  ┌──────────────────┐
                  │ Additional Info  │
                  └────────┬─────────┘
                           │
                           ▼
                  ┌──────────────────┐
                  │ Contact Details  │
                  └────────┬─────────┘
                           │
                           ▼
                  ┌──────────────────┐
                  │      Review      │
                  └────────┬─────────┘
                           │
                           ▼
                  ┌──────────────────┐
                  │     Consent      │
                  └────────┬─────────┘
                           │
                           ▼
                  ┌──────────────────┐
                  │     Submit       │
                  └────────┬─────────┘
                           │
                     ┌─────┴─────┐
                     │           │
                   Error       Success
                     │           │
                   Retry         ▼
                     │    ┌──────────────┐
                     └───►│ Confirmation │
                          └──────────────┘
```

---

# Stop Condition

This document defines the Quote Wizard user flow only.

Detailed field definitions, conditional rules, UI design, pricing logic, AI integration, lead management, database structure, APIs, security, and testing will be defined in their respective Quote Wizard documents.
