# SMEvolve Quote Wizard

## Part 05 – Quote Logic

**Project:** SMEvolve

**Module:** Quote Wizard

**Version:** 1.0

**Document Type:** Quote Assessment & Business Logic Specification

---

# Objective

Define how SMEvolve processes information collected through the Quote Wizard.

The Quote Wizard should transform user responses into a structured project assessment that helps the SMEvolve team understand:

* What the client wants.
* How complex the project may be.
* Which SMEvolve services are relevant.
* What features may affect project scope.
* The client's expected timeline.
* The client's indicative budget.
* What information may still be required.

The system must **not automatically create a binding quotation** unless a future approved pricing system explicitly introduces that capability.

---

# Core Principle

The Quote Wizard is primarily a:

```text
Quote Request
+
Project Assessment
+
Lead Qualification
```

system.

It is not initially a:

```text
Binding Pricing Engine
```

---

# Quote Processing Flow

```text
User Answers
      ↓
Validation
      ↓
Normalization
      ↓
Project Classification
      ↓
Scope Assessment
      ↓
Service Matching
      ↓
Complexity Assessment
      ↓
Budget Comparison
      ↓
Timeline Assessment
      ↓
AI Summary
      ↓
Admin Review
      ↓
Human Quote / Proposal
```

---

# Quote Request vs Final Quote

The distinction must be explicit.

## Quote Request

Created when the visitor submits the wizard.

Contains:

* Project information.
* Requirements.
* Budget range.
* Timeline.
* Contact details.
* AI analysis where available.

---

## Final Quote

Created later by SMEvolve staff through an approved business process.

May include:

* Final scope.
* Final price.
* Payment terms.
* Delivery timeline.
* Milestones.
* Additional terms.

The Quote Wizard must not represent the initial submission as a final quotation.

---

# Pricing Authority

Pricing must never be determined solely by AI.

The authoritative pricing source should eventually be:

```text
Approved SMEvolve Pricing Rules
+
Admin Configuration
+
Human Review
```

AI is not a pricing authority.

---

# AI Pricing Restriction

The AI must not:

* Invent prices.
* Guarantee prices.
* Offer unauthorized discounts.
* Promise fixed costs.
* Change approved pricing.
* Commit to payment terms.
* Guarantee delivery dates.

---

# Project Classification

The system should classify each request into a primary project type.

Initial types:

```text
Website
E-commerce Website
Web Application
Mobile Application
Custom Software
UI/UX Design
Other
```

---

# Multiple Services

A project may involve multiple SMEvolve services.

Example:

```text
Primary:
E-commerce Website

Additional:
UI/UX Design
Payment Integration
Admin Dashboard
```

The system should support multiple service associations.

---

# Service Matching

Based on user responses, the system may identify relevant SMEvolve services.

Example:

```text
User:
I need a platform where customers can book
services and pay online.

System:
Primary Service:
Web Application

Possible Services:
UI/UX Design
Payment Integration
Backend Development
```

The final service classification remains subject to SMEvolve review.

---

# Scope Assessment

The system should identify major scope factors.

Examples:

```text
Number of features
User accounts
Payment integration
Third-party integrations
Admin dashboard
Messaging
Notifications
External APIs
Custom workflows
Existing-system migration
```

---

# Complexity

The system may classify project complexity as:

```text
Low
Medium
High
Very High
```

This classification is for internal assessment.

It should not automatically be presented to the customer unless intentionally designed.

---

# Complexity Factors

Possible factors include:

## Low Complexity

Examples:

```text
Simple informational website
Basic landing page
Simple UI design
Basic contact form
```

---

## Medium Complexity

Examples:

```text
CMS-based website
Booking system
Basic e-commerce
Customer accounts
Basic admin dashboard
```

---

## High Complexity

Examples:

```text
Custom web application
Advanced e-commerce
Multiple integrations
Role-based systems
Complex dashboards
Payment workflows
```

---

## Very High Complexity

Examples:

```text
Large custom platform
Multiple user roles
Complex automation
Multiple external integrations
Real-time systems
Large migration
Highly customized business workflows
```

These are guidelines rather than automatic final classifications.

---

# Scope Score

The system may internally calculate a scope indicator.

Example:

```text
scope_score
```

The exact scoring model should remain configurable.

Possible factors:

```text
Feature Count
Integration Count
User Role Count
Payment Requirements
Data Complexity
Existing System Complexity
Custom Workflow Requirements
```

---

# Scope Score Principle

A scope score should assist administrators.

It must not automatically determine the final price.

Example:

```text
Scope Score: 72
Complexity: High
```

This information is primarily for internal use.

---

# Feature Weighting

Features may have different scope impact.

Example:

```text
Contact Form
→ Low

Customer Accounts
→ Medium

Online Payments
→ Medium / High

Real-Time Messaging
→ High

Complex External Integration
→ High
```

Weights should be configurable.

---

# Integration Assessment

If the user selects integrations, identify them.

Examples:

```text
Payment Gateway
Google Maps
WhatsApp
Email Platform
CRM
Accounting Software
Shipping Provider
Social Login
Third-Party API
```

---

# Unknown Integration

If the user says:

```text
Other
```

provide an opportunity to describe it.

The system should not assume what the integration involves.

---

# Payment Assessment

If online payment is selected, identify:

```text
Payment Required
```

The system may later ask:

```text
Preferred Payment Provider
Currency
Subscription or One-Time Payment
```

only if those questions are approved in the final question configuration.

---

# Timeline Assessment

Timeline should be classified as:

```text
Immediate
Short Term
Medium Term
Long Term
Unknown
```

based on the user's selection.

---

# Timeline Risk

If the requested timeline appears unusually short for the identified scope, the system may flag it internally.

Example:

```text
Scope:
High

Timeline:
As soon as possible

Internal Flag:
Timeline requires review
```

The system must not tell the client:

```text
Your project cannot be completed.
```

unless a human has reviewed it.

---

# Budget Assessment

Budget should be compared against the project scope where approved pricing information exists.

Possible internal states:

```text
Budget Unknown
Budget Potentially Suitable
Budget Requires Review
Budget Appears Below Expected Scope
Budget Appears Above Expected Scope
```

---

# Budget Handling

If no approved pricing framework exists, the system must not claim that a budget is too low or too high.

Instead:

```text
Budget:
₦500,000 – ₦1,000,000

Assessment:
Requires Human Review
```

---

# Budget Privacy

Budget information should be treated as lead information.

Do not expose internal interpretations to the customer unless explicitly designed.

---

# AI Project Summary

AI may generate an internal summary.

Example:

```text
Project:
E-commerce platform for a fashion retailer.

Core Requirements:
- Product catalogue
- Customer accounts
- Online payments
- Order management
- Delivery integration

Expected Timeline:
1–3 months

Budget:
₦500,000 – ₦1,000,000

Potential Complexity:
Medium–High

Items Requiring Clarification:
- Payment provider
- Delivery integration
- Product catalogue size
```

---

# AI Summary Rules

AI summaries must:

* Use information supplied by the user.
* Clearly identify uncertainty.
* Avoid invented facts.
* Avoid invented prices.
* Avoid promises.
* Avoid legal commitments.

---

# Missing Information Detection

The system may identify information that would help an administrator evaluate the request.

Example:

```text
Missing:
Preferred payment gateway
Expected number of products
Required user roles
```

These should be treated as clarification points rather than failures.

---

# AI Clarification

The AI may ask follow-up questions where useful.

Example:

```text
Do you already have a payment provider in mind?
```

However, the wizard should avoid turning into an endless AI conversation.

---

# Maximum Clarification Principle

AI should ask only questions that materially improve understanding of the project.

Avoid:

```text
Unnecessary technical questions
Repeated questions
Questions already answered
Questions irrelevant to the project
```

---

# User Answer Priority

When conflicting information exists:

```text
Latest User Confirmation
        ↓
Previous User Answer
        ↓
AI Suggestion
        ↓
System Inference
```

---

# Scope Changes

If the user changes an answer during review:

```text
Old Answer
    ↓
New Answer
    ↓
Recalculate Assessment
```

Any dependent fields should update accordingly.

---

# Example

Initial:

```text
Project:
Website
```

Features:

```text
Contact Form
Gallery
```

Assessment:

```text
Low Complexity
```

User changes project to:

```text
E-commerce Website
```

The system should recalculate:

```text
Features
Scope
Complexity
Potential Integrations
```

---

# Quote Request Status

Initial status after submission:

```text
New
```

The Admin Portal may later change it to:

```text
Contacted
Qualified
Proposal Sent
Won
Lost
Archived
```

---

# Quote Request Priority

The system may support internal priority:

```text
Low
Normal
High
Urgent
```

Priority should be based on configurable business rules or administrator judgment.

AI may suggest a priority but should not make it authoritative.

---

# Example Priority Factors

Potential factors:

```text
Urgent timeline
High project value
Existing client relationship
Complex project
Strong project fit
```

These are internal considerations.

---

# Lead Qualification

The Quote Wizard may produce qualification indicators such as:

```text
Project Clarity
Scope Completeness
Budget Information
Timeline Information
Contact Completeness
```

Example:

```text
Project Clarity: High
Scope Completeness: Medium
Budget: Provided
Timeline: Provided
Contact: Complete
```

---

# Qualification Score

A future configurable score may be supported.

Example:

```text
qualification_score
```

However, the score must not be treated as an objective measure of client value.

It should be an internal operational aid.

---

# No Automatic Rejection

The system must not automatically reject a lead solely because:

* Budget is low.
* Timeline is short.
* Scope is unclear.
* Project is unusual.
* AI confidence is low.

Such requests should normally be flagged for human review.

---

# Quote Calculation Architecture

The architecture should allow a future pricing engine.

Potential future flow:

```text
Requirements
      ↓
Approved Pricing Rules
      ↓
Base Price
      ↓
Feature Adjustments
      ↓
Integration Costs
      ↓
Timeline / Priority Adjustments
      ↓
Discount Rules
      ↓
Human Approval
      ↓
Final Quote
```

This is **future compatibility only** unless separately approved.

---

# Currency

The Quote Wizard should support the business's configured currency.

The initial implementation should use:

```text
NGN / ₦
```

where applicable to the SMEvolve business configuration.

Currency should not be hardcoded throughout the application.

---

# Tax

The initial Quote Wizard should not automatically calculate taxes unless an approved business rule exists.

If taxation is introduced later, it should be handled by an explicit pricing system.

---

# Discounts

The Quote Wizard must not automatically generate discounts.

Discounts should be:

```text
Admin Controlled
```

or:

```text
Approved Pricing Rule
```

---

# Delivery Estimate

The Quote Wizard may collect the customer's desired timeline.

It must not convert that into a guaranteed delivery date.

---

# Proposal Generation

The Quote Wizard should not generate a binding proposal during initial submission.

Future functionality may allow:

```text
Lead
 ↓
Admin Review
 ↓
Proposal
 ↓
Client Communication
```

---

# Internal Notes

Administrators may later add internal notes.

These notes must never be shown to the customer by default.

---

# Data Separation

Separate:

```text
Customer Provided Data
AI Analysis
Internal Assessment
Admin Notes
Final Quote
```

These should not be treated as one undifferentiated text field.

---

# Recommended Internal Structure

```text
Quote Request
│
├── Customer Data
│
├── Project Data
│
├── Requirements
│
├── Budget
│
├── Timeline
│
├── AI Analysis
│
├── Scope Assessment
│
├── Qualification
│
└── Admin Information
```

---

# Example Assessment

```text
Quote Request
────────────────────────────

Project:
E-commerce Website

Business:
Fashion Retailer

Core Features:
✓ Product Catalogue
✓ Customer Accounts
✓ Online Payments
✓ Order Management
✓ Delivery

Timeline:
1–3 months

Budget:
₦500,000 – ₦1,000,000

Scope:
High

Potential Integrations:
Payment Gateway
Delivery Provider

AI Summary:
Client wants an e-commerce platform for a
fashion business with customer purchasing,
payments and delivery management.

Clarification Required:
- Number of products
- Preferred payment provider
- Delivery integration
```

---

# Admin Review Principle

The Admin Portal should present the assessment as:

```text
Decision Support
```

not:

```text
Automatic Decision
```

The administrator remains responsible for final commercial decisions.

---

# AI Failure

If AI analysis fails:

```text
Quote Request
      ↓
Normal Structured Data
      ↓
Admin Review
```

The lead remains valid.

---

# AI Uncertainty

If AI cannot confidently classify something:

```text
Classification:
Requires Review
```

rather than inventing a classification.

---

# Logic Configuration

Business rules should eventually be configurable.

Potential structure:

```text
config/
└── quote.php
```

Possible configuration:

```text
project_types
features
feature_weights
budget_ranges
timeline_options
complexity_rules
qualification_rules
```

The exact architecture should follow SMEvolve's existing configuration patterns.

---

# Auditability

Important automated assessments should be traceable.

Where appropriate store:

```text
assessment_version
calculated_at
ai_analysis_version
rule_version
```

This allows future administrators to understand how an assessment was generated.

---

# Versioning

Quote logic should be versioned.

Example:

```text
Quote Logic v1
Quote Logic v2
```

Historical quote requests should retain the version used when they were processed.

---

# Security

Never expose internal fields such as:

```text
scope_score
qualification_score
internal_priority
internal_notes
AI confidence
pricing rules
```

to unauthenticated public users.

---

# Performance

The initial submission should not depend on multiple slow AI requests.

Prefer:

```text
User Submission
 ↓
Save Lead
 ↓
Return Success
 ↓
Background AI Processing
```

where the application's architecture supports background processing.

If AI analysis is required synchronously, the system must still provide a reliable fallback.

---

# Success Criteria

Quote Logic is successful when:

✓ User answers become structured project information.

✓ Projects can be classified.

✓ Relevant services can be identified.

✓ Scope factors can be assessed.

✓ Complexity can be estimated internally.

✓ Budget and timeline can be evaluated without making unauthorized promises.

✓ AI can summarize the project.

✓ Missing information can be identified.

✓ User-confirmed information overrides AI suggestions.

✓ No automatic lead rejection occurs without approved business rules.

✓ AI cannot independently determine binding pricing.

✓ Future pricing-engine integration is possible.

✓ Human administrators remain responsible for final commercial decisions.

---

# Stop Condition

This document defines Quote Wizard assessment and business logic.

It does not implement:

* Groq integration.
* AI prompts.
* Database tables.
* API endpoints.
* Admin Portal.
* Email notifications.
* Security implementation.
* Testing.

Those are defined in subsequent documentation.
