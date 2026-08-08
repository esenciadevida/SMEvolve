# SMEvolve Quote Wizard

## Part 12 – Content Architecture

**Project:** SMEvolve

**Framework:** Laravel 12

**Frontend:** Blade, Vite, Alpine.js

**AI Provider:** Groq

**Module:** Quote Wizard

**Version:** 1.0

**Document Type:** Content Architecture Specification

---

# Objective

Define the complete content structure, question system, answer options, conditional logic, and conversational flow of the SMEvolve Quote Wizard.

The Quote Wizard must collect enough information for SMEvolve to understand a prospective client's project and prepare an appropriate quote request without making the process unnecessarily long.

The content should be understandable to non-technical users.

---

# Content Principle

The wizard should answer five core questions:

```text
1. What does the client want?
2. Why do they want it?
3. What should it do?
4. When do they need it?
5. How can SMEvolve contact them?
```

Additional questions should only appear when they provide meaningful value.

---

# Content Strategy

The Quote Wizard should progressively collect information.

Instead of showing every possible question:

```text
Project
   ↓
Relevant Questions
   ↓
Additional Requirements
   ↓
Timeline
   ↓
Budget
   ↓
Contact
   ↓
Review
```

---

# Recommended Wizard Structure

The initial structure is:

```text
Step 1 — Project Type
Step 2 — Project Idea
Step 3 — Requirements
Step 4 — Business & Audience
Step 5 — Timeline
Step 6 — Budget
Step 7 — Contact
Step 8 — Review
Step 9 — Submission
```

The system may dynamically skip irrelevant questions.

---

# Step 1 — Project Type

## Question

> What would you like to build?

---

## Options

```text
Website
E-commerce Website
Web Application
Mobile Application
Custom Software
Business Automation
UI/UX Design
Other
Not Sure
```

---

# Project Type Definitions

## Website

For informational or marketing websites.

Examples:

* Company website.
* Portfolio.
* Corporate website.
* Landing page.

---

## E-commerce Website

For online stores and product sales.

Examples:

* Fashion store.
* Electronics store.
* Marketplace.
* Product catalog.

---

## Web Application

For browser-based software.

Examples:

* Booking platform.
* Management system.
* Customer portal.
* SaaS product.

---

## Mobile Application

For iOS, Android, or both.

---

## Custom Software

For specialized business software that does not fit another category.

---

## Business Automation

For automating existing manual processes.

Examples:

* Data processing.
* Notifications.
* Workflow automation.
* Internal operations.

---

## UI/UX Design

For clients primarily seeking product or interface design.

---

## Other

Allows the client to describe another project type.

---

## Not Sure

Allows users to continue without knowing the technical category.

---

# Step 2 — Project Idea

## Question

> Tell us about your idea.

---

## Supporting Text

> Give us a simple explanation of what you want to build. You don't need to use technical terms.

---

## Placeholder

> For example: "I want an online platform where customers can book cleaning services."

---

# AI Assistance

Display:

> Need help explaining your idea?

CTA:

```text
✨ Help me explain it
```

---

# AI Behavior

The AI may:

* Clarify the description.
* Improve wording.
* Identify the likely purpose.
* Highlight unclear areas.

It must not change the user's intended meaning.

---

# User Controls

```text
Use Suggestion
Edit
Dismiss
```

---

# Step 3 — Requirements

## Question

> What should your project be able to do?

Supporting text:

> Select everything that sounds relevant. You can always explain more later.

---

# Generic Feature Options

```text
User Accounts
Payments
Booking
Search
Notifications
Messaging
Reviews & Ratings
File Uploads
Reports
Analytics
Admin Dashboard
Customer Dashboard
Subscriptions
Maps / Location
Email Notifications
SMS Notifications
Other
Not Sure
```

---

# Dynamic Features

The available features should adapt based on project type.

---

# Website Features

Potential options:

```text
Contact Form
Services / Products
About Us
Image Gallery
Testimonials
Blog / Articles
Newsletter
Online Booking
Payment
Customer Accounts
```

Important:

The SMEvolve website itself does not require a blog as part of the Quote Wizard.

A blog option should only appear when it is genuinely relevant to the client's requested website.

---

# E-commerce Features

Potential options:

```text
Product Catalogue
Shopping Cart
Checkout
Online Payments
Customer Accounts
Order Tracking
Discount Codes
Inventory Management
Delivery Management
Reviews
Wishlist
Admin Dashboard
```

---

# Booking Platform Features

Potential options:

```text
Service Listings
Availability Calendar
Booking
Rescheduling
Cancellation
Notifications
Payments
Customer Accounts
Provider Dashboard
Admin Dashboard
```

---

# Mobile Application Features

Potential options:

```text
User Accounts
Push Notifications
Payments
Location
Messaging
Camera
File Uploads
Subscriptions
Social Login
Admin Dashboard
```

---

# Custom Software Features

Potential options:

```text
User Management
Dashboard
Reports
Automation
Data Import
Data Export
Notifications
Role-Based Access
Third-Party Integration
Admin Controls
```

---

# AI Feature Assistance

After feature selection:

> Not sure what you need?

CTA:

```text
✨ Suggest features for my project
```

The AI may recommend additional features based on the confirmed project information.

---

# AI Feature Suggestion Display

Example:

```text
Based on your project, you may also need:

☐ Customer accounts
☐ Booking calendar
☐ Payment processing
☐ Notifications
```

Each suggestion should have an explanation when useful.

Example:

> Notifications can remind customers about upcoming bookings.

---

# User Control

Suggested features are not automatically selected.

The user explicitly chooses:

```text
Add
```

or:

```text
Dismiss
```

---

# Step 4 — Business Context

## Question

> Who is this project for?

---

# Options

```text
Myself
My Business
My Employer
A Client
A New Business
Other
```

---

# Business Status

Where relevant:

> What stage is the business at?

Options:

```text
Idea Stage
New Business
Existing Business
Growing Business
Established Business
Not Applicable
```

This question may be skipped for purely personal projects.

---

# Target Audience

## Question

> Who will use this product or service?

Options:

```text
Individuals
Businesses
Both Individuals and Businesses
Internal Staff
Students
Customers
Members
Other
Not Sure
```

Multiple selections may be allowed where appropriate.

---

# Audience Description

Optional:

> Tell us anything important about your users.

Example:

> "Most of our customers are small businesses in Lagos."

---

# Step 5 — Existing System

Only display when relevant.

## Question

> Is there an existing system or website?

Options:

```text
Yes
No
Starting from scratch
Not sure
```

---

# Existing Website

If Yes:

> What is the website address?

The URL must be validated.

---

# Existing Software

If applicable:

> What system are you currently using?

This should be optional.

---

# Migration

For projects involving existing systems:

> Do you need to move existing information to the new system?

Options:

```text
Yes
No
Not Sure
```

---

# Step 6 — Integrations

Only display when relevant.

## Question

> Does your project need to connect with other services?

Options:

```text
Payment Gateway
WhatsApp
Email
SMS
Google Services
Maps
Accounting Software
CRM
Social Media
Other
Not Sure
No Integrations
```

---

# Integration Description

If Other:

> Which service would you like to connect?

---

# Integration AI Assistance

AI may help identify potential integrations based on the user's description.

AI suggestions must remain suggestions.

---

# Step 7 — Platform

Only display when relevant.

## Mobile Application

Question:

> Which platforms should your app support?

Options:

```text
Android
iPhone / iOS
Both
Not Sure
```

---

## Web Application

Question:

> Who should be able to use the application?

Options:

```text
Anyone
Registered Customers
Staff
Administrators
Businesses
Specific Members
Other
```

Multiple selections may be appropriate.

---

# Step 8 — Timeline

## Question

> When would you like to start?

Options:

```text
As soon as possible
Within 1 month
1–3 months
3–6 months
More than 6 months
I'm still planning
Not sure
```

---

# Timeline Principle

The timeline is an indication of the client's preference.

It is not a guaranteed delivery date.

---

# Step 9 — Budget

## Question

> Do you have an estimated budget?

Supporting text:

> An approximate range helps us understand the scale of your project.

---

# Budget Options

Initial configurable ranges:

```text
Under ₦500,000
₦500,000 – ₦1,000,000
₦1,000,000 – ₦3,000,000
₦3,000,000 – ₦5,000,000
₦5,000,000+
I'm not sure yet
I'd rather discuss it
```

---

# Budget Principle

The user should never feel forced to disclose a budget.

The following must always remain available:

```text
I'm not sure yet
```

or:

```text
I'd rather discuss it
```

---

# Budget Configuration

Budget ranges must be configurable.

Do not hardcode them permanently into the frontend.

Future requirements may change the ranges.

---

# Step 10 — Additional Information

## Question

> Is there anything else we should know?

Textarea.

---

# Placeholder

> Tell us about anything important that we haven't asked about.

---

# AI Assistance

Optional:

```text
✨ Help me organize my requirements
```

The AI may turn fragmented notes into a clearer project summary.

The original information must remain available.

---

# Step 11 — Contact

## Question

> How can we contact you?

---

# Fields

```text
Full Name
Email Address
Phone Number
```

---

# Full Name

Required.

---

# Email

Required.

Validate:

* Proper email format.
* Maximum length.
* Normalized representation.

---

# Phone

Required unless business rules specify otherwise.

Support Nigerian phone formats and appropriate international formats if SMEvolve serves international clients.

---

# Preferred Contact Method

Optional:

```text
Phone
Email
WhatsApp
Any
```

---

# Contact Timing

Optional:

> When is the best time to contact you?

Options:

```text
Morning
Afternoon
Evening
Anytime
```

This should only be collected if it provides real operational value.

---

# Step 12 — Consent

Where required:

```text
☐ I agree to the Terms & Conditions and acknowledge the Privacy Policy.
```

Links:

```text
Privacy Policy
Terms & Conditions
```

The user must be able to access the documents without losing quote progress.

---

# Step 13 — Review

The user should see a summary of all confirmed information.

---

# Review Structure

```text
Project
Project Type
Project Description

Requirements
Selected Features

Business
Business Context
Target Audience

Existing System
Existing Website
Migration

Integrations
Selected Integrations

Timeline
Expected Start

Budget
Budget Range

Additional Information
Additional Notes

Contact
Name
Email
Phone
```

---

# Review Rules

Only information relevant to the user's journey should be shown.

Do not display skipped questions as:

```text
Not answered
```

unless the information is required.

---

# Editing

Each section must provide:

```text
Edit
```

The user should return to the appropriate question without losing progress.

---

# Conditional Logic

The Quote Wizard should use a question dependency system.

Conceptually:

```text
Question
   ↓
Answer
   ↓
Condition
   ↓
Next Question
```

---

# Example Logic

```text
IF project_type = mobile_app
THEN show mobile_platform
```

---

# Example

```text
IF project_type = ecommerce
THEN show:
- product catalogue
- checkout
- payments
- inventory
- delivery
```

---

# Example

```text
IF existing_system = yes
THEN show:
- existing website/system
- migration
```

---

# Example

```text
IF integrations = selected
THEN show:
integration selection
```

---

# Question Visibility

Questions should be evaluated dynamically.

Users should not see irrelevant questions.

---

# Not Sure Logic

If the user chooses:

```text
Not Sure
```

the system should continue with a simplified path.

AI may help identify appropriate options.

---

# Other Logic

When:

```text
Other
```

is selected, display an additional text field.

Example:

```text
Other:
[____________________________]
```

---

# Answer Persistence

Answers must remain available while navigating through the wizard.

Example:

```text
Step 1
 ↓
Step 2
 ↓
Step 3
 ↓
Back to Step 2
 ↓
Answer remains
```

---

# AI Content Rules

AI-generated content must be visually distinguished where necessary.

Use language such as:

> AI suggestion

or:

> Suggested based on your answers

---

# AI Content Never Becomes Automatic Fact

AI-generated values must not be stored as confirmed requirements until the user accepts them.

---

# Content Tone

The wizard should sound:

* Helpful.
* Professional.
* Friendly.
* Confident.
* Clear.

Avoid:

* Corporate jargon.
* Excessive technical terminology.
* Legalistic wording.
* Pushy sales language.

---

# Recommended Voice

Example:

> Tell us what you're trying to build.

Better than:

> Please provide a comprehensive description of the proposed digital solution.

---

# Microcopy

## Start

```text
Let's build your project brief.
```

Supporting text:

> Answer a few questions so we can understand what you need and prepare the right next steps.

---

# Progress

```text
Step 3 of 8
```

---

# Saving

```text
Saving...
```

---

# Saved

```text
Saved
```

---

# AI

```text
Need help?
```

or:

```text
✨ Help me explain this
```

---

# Submission

```text
Request My Quote
```

---

# Success

```text
Your quote request has been received.
```

---

# Content Personalization

Where appropriate, use the user's answers.

Example:

> Great — let's learn more about your mobile app.

instead of:

> Next question.

This should be used sparingly.

---

# Avoiding Form Fatigue

The wizard should:

* Ask only relevant questions.
* Use cards for simple selections.
* Use AI assistance when users are stuck.
* Keep text inputs limited.
* Show progress.
* Allow "Not sure".
* Preserve answers.

---

# Maximum Recommended Journey

The default journey should ideally remain within:

```text
6–10 primary steps
```

Conditional questions should not unnecessarily increase the perceived complexity.

---

# Content Configuration

Questions and options should ideally be represented as configurable data rather than hardcoded into Blade templates.

Suggested structure:

```text
config/
└── quote.php
```

or:

```text
app/
└── Quote/
    └── Questions/
```

The final implementation should follow SMEvolve's established architecture.

---

# Question Data Model

Conceptually:

```text
id
key
type
label
description
placeholder
options
validation
conditions
ai_enabled
required
order
```

---

# Example

```php
[
    'key' => 'project_type',
    'type' => 'single_choice',
    'label' => 'What would you like to build?',
    'required' => true,
]
```

The implementation should not expose internal configuration structures directly to users.

---

# Content Localization

The architecture should allow future localization.

Do not build the system in a way that makes translation impossible.

Initial language:

```text
English
```

---

# SEO

The Quote Wizard is primarily an interactive conversion tool.

It should not be treated as a long-form SEO content page.

Avoid unnecessary indexable question URLs.

---

# No Blog Dependency

The Quote Wizard must not depend on a blog or content marketing system.

No blog functionality is required for this module.

---

# Analytics Events

Where the global analytics system supports it, track meaningful events such as:

```text
quote_started
quote_step_completed
ai_assistance_used
quote_reviewed
quote_submitted
quote_abandoned
```

Do not capture sensitive free-text content as analytics event metadata unless explicitly approved.

---

# Abandonment

A quote session may be considered abandoned after a configurable period of inactivity.

The system should preserve the session for the configured retention period where permitted.

---

# Content Success Criteria

The content architecture is successful when:

✓ The wizard captures the core information required for quoting.

✓ Users can complete it without technical knowledge.

✓ Questions adapt to project type.

✓ Irrelevant questions are hidden.

✓ "Not sure" is available where appropriate.

✓ AI can assist without taking control.

✓ Users can review and edit answers.

✓ Budget is optional.

✓ Contact information is collected near the end.

✓ The process does not depend on a blog.

✓ Questions and options can be modified without rebuilding every Blade template.

✓ Content remains consistent with SMEvolve's brand voice.

---

# Stop Condition

This document defines the content and question architecture.

It does not implement:

* Database schema.
* Controllers.
* Routes.
* Blade components.
* Alpine.js.
* Groq API calls.
* Admin Portal.
* Analytics implementation.

Those will be defined in subsequent documents.
