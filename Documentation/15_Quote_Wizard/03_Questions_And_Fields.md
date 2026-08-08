# SMEvolve Quote Wizard

## Part 03 – Questions & Fields

**Project:** SMEvolve

**Module:** Quote Wizard

**Version:** 1.0

**Document Type:** Questions, Fields & Conditional Logic Specification

---

# Objective

Define every question and field used by the SMEvolve Quote Wizard.

The wizard must collect enough information for SMEvolve to understand a potential project without making the process unnecessarily long.

Fields should be:

* Relevant.
* Easy to understand.
* Mobile-friendly.
* Accessible.
* Validated.
* Structured for Admin Portal use.
* Compatible with AI assistance.

---

# Field Principles

The Quote Wizard should follow these principles:

1. Ask only useful questions.
2. Use simple language.
3. Avoid technical terminology unless necessary.
4. Prefer selectable options where appropriate.
5. Use free-text fields when the user's own explanation is valuable.
6. Keep sensitive information to a minimum.
7. Make optional fields clearly optional.
8. Allow users to edit all answers before submission.
9. Never require an account.
10. AI suggestions must remain editable.

---

# Field Source

Every answer should be capable of identifying its source.

Supported sources:

```text
user
ai
system
```

Where AI suggests an answer, the user should confirm it before it becomes authoritative user data.

---

# Question Structure

Each question should support:

```text
id
label
description
type
required
options
placeholder
validation
conditional_logic
order
ai_enabled
```

---

# Question Types

Supported field types:

```text
single_select
multi_select
text
textarea
email
phone
url
number
currency_range
timeline
checkbox
```

Additional types may be introduced if required.

---

# SECTION 1 – Project Information

## Field: project_type

**Label:**

```text
What are you looking to build?
```

**Type:**

```text
single_select
```

**Required:**

```text
Yes
```

---

## Options

Initial options:

```text
Website
E-commerce Website
Web Application
Mobile Application
Custom Software
UI/UX Design
Other
```

These options must correspond to services currently offered by SMEvolve.

The Admin Portal should eventually be able to manage these options.

---

# Field: project_type_other

**Label:**

```text
Tell us what you have in mind.
```

**Type:**

```text
textarea
```

**Required:**

```text
Only when project_type = Other
```

**Maximum Length:**

Recommended:

```text
2000 characters
```

---

# Field: project_description

**Label:**

```text
What would you like us to build?
```

**Type:**

```text
textarea
```

**Required:**

```text
Yes
```

**Placeholder:**

```text
Tell us about your idea, what you want the product
to do, or the problem you want it to solve.
```

---

# AI Behaviour

The project description may be analyzed by AI.

The AI may extract:

```text
Project Type
Features
Business Context
User Types
Possible Integrations
```

The AI must not silently modify the user's answer.

---

# SECTION 2 – Business Information

## Field: business_name

**Label:**

```text
What's your business name?
```

**Type:**

```text
text
```

**Required:**

```text
No
```

---

# Field: industry

**Label:**

```text
What industry are you in?
```

**Type:**

```text
single_select
```

**Required:**

```text
No
```

---

## Initial Industry Options

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
Entertainment
Manufacturing
Other
```

---

# Field: industry_other

**Label:**

```text
Please specify your industry.
```

**Type:**

```text
text
```

**Required:**

```text
Only when industry = Other
```

---

# Field: business_description

**Label:**

```text
Tell us briefly about your business.
```

**Type:**

```text
textarea
```

**Required:**

```text
No
```

**Maximum Length:**

```text
2000 characters
```

---

# SECTION 3 – Project Requirements

The exact questions in this section should adapt based on `project_type`.

---

# Website Requirements

If:

```text
project_type = Website
```

show:

```text
required_website_features
```

---

## Field: website_features

**Label:**

```text
What would you like your website to include?
```

**Type:**

```text
multi_select
```

**Required:**

```text
No
```

---

## Options

```text
Company Information
Services
Contact Forms
Gallery
Blog / Articles
Booking
Online Payments
Customer Accounts
Maps / Location
Testimonials
Newsletter
Social Media Integration
Other
```

Note:

The presence of a Blog option here does **not** mean SMEvolve's website itself requires a blog. It is simply a possible client requirement for projects where a client wants one.

---

# E-commerce Requirements

If:

```text
project_type = E-commerce Website
```

show:

```text
ecommerce_features
```

---

## Field: ecommerce_features

**Label:**

```text
Which features do you need?
```

**Type:**

```text
multi_select
```

---

## Options

```text
Product Catalogue
Shopping Cart
Checkout
Online Payments
Customer Accounts
Order Management
Delivery / Shipping
Discounts
Inventory Management
Reviews
Wishlist
Product Search
Other
```

---

# Web Application Requirements

If:

```text
project_type = Web Application
```

show:

```text
web_app_features
```

---

## Options

```text
User Accounts
Admin Dashboard
Payments
Booking
Messaging
Notifications
Reports
File Uploads
Search
Role-Based Access
Third-Party Integrations
API Integration
Other
```

---

# Mobile Application Requirements

If:

```text
project_type = Mobile Application
```

show:

```text
mobile_app_features
```

---

## Options

```text
User Accounts
Push Notifications
Payments
Location / Maps
Messaging
Camera
File Uploads
Social Login
Subscriptions
Admin Dashboard
API Integration
Other
```

---

# Custom Software Requirements

If:

```text
project_type = Custom Software
```

show:

```text
custom_software_features
```

---

## Options

```text
User Management
Admin Dashboard
Reports
Automation
Payments
Inventory
CRM
Staff Management
Notifications
Integrations
API
Other
```

---

# UI/UX Design Requirements

If:

```text
project_type = UI/UX Design
```

show:

```text
design_requirements
```

---

## Options

```text
Website Design
Mobile App Design
Web Application Design
Dashboard Design
Design System
Wireframes
Prototype
User Research
Usability Review
Redesign
Other
```

---

# Additional Features

## Field: additional_features

**Label:**

```text
Are there any other features you need?
```

**Type:**

```text
textarea
```

**Required:**

```text
No
```

---

# SECTION 4 – Existing Assets

## Field: existing_assets

**Label:**

```text
Do you already have anything we can work with?
```

**Type:**

```text
multi_select
```

**Required:**

```text
No
```

---

## Options

```text
Logo
Brand Guidelines
Website
Domain
Hosting
Content
Designs / Mockups
Existing Application
Existing Database
Nothing Yet
Other
```

---

# Field: existing_website_url

**Label:**

```text
What's your current website address?
```

**Type:**

```text
url
```

**Required:**

```text
Only when Website is selected
```

---

# Field: existing_application_description

**Label:**

```text
Tell us about your existing application.
```

**Type:**

```text
textarea
```

**Required:**

```text
Only when Existing Application is selected
```

---

# Field: project_stage

**Label:**

```text
What stage is the project currently at?
```

**Type:**

```text
single_select
```

**Required:**

```text
No
```

---

## Options

```text
Just an Idea
Planning
Design Started
Development Started
Existing Product
Redesign / Upgrade
Migration
```

---

# SECTION 5 – Timeline

## Field: timeline

**Label:**

```text
When would you like to start?
```

**Type:**

```text
timeline
```

**Required:**

```text
No
```

---

## Options

```text
As soon as possible
Within 1 month
1–3 months
3–6 months
More than 6 months
I'm not sure
```

---

# Timeline Rule

Timeline is indicative.

It must never be interpreted as a guaranteed delivery commitment.

---

# SECTION 6 – Budget

## Field: budget_range

**Label:**

```text
Do you have a budget range in mind?
```

**Type:**

```text
currency_range
```

**Required:**

```text
No
```

---

# Budget Options

The final values must be configured from approved SMEvolve pricing/business settings.

Example initial ranges:

```text
Under ₦250,000
₦250,000 – ₦500,000
₦500,000 – ₦1,000,000
₦1,000,000 – ₦2,500,000
₦2,500,000+
Not sure yet
Prefer not to say
```

---

# Budget Disclaimer

Display near the field:

```text
Your budget helps us understand the scope of the project.
It does not represent a final quotation.
```

---

# SECTION 7 – Additional Information

## Field: additional_information

**Label:**

```text
Is there anything else you'd like us to know?
```

**Type:**

```text
textarea
```

**Required:**

```text
No
```

**Maximum Length:**

```text
3000 characters
```

---

# Suggested Information

The interface may provide examples:

```text
Special requirements
Important deadlines
Technical constraints
Preferred integrations
Reference websites
Other considerations
```

---

# SECTION 8 – Contact Information

## Field: full_name

**Label:**

```text
What's your name?
```

**Type:**

```text
text
```

**Required:**

```text
Yes
```

---

# Field: email

**Label:**

```text
What's your email address?
```

**Type:**

```text
email
```

**Required:**

```text
Yes
```

---

# Field: phone

**Label:**

```text
What's your phone number?
```

**Type:**

```text
phone
```

**Required:**

```text
Yes
```

---

# Field: company_name

**Label:**

```text
Company / Business Name
```

**Type:**

```text
text
```

**Required:**

```text
No
```

---

# Field: preferred_contact_method

**Label:**

```text
How would you prefer us to contact you?
```

**Type:**

```text
single_select
```

**Required:**

```text
No
```

---

## Options

```text
Email
Phone
WhatsApp
Any
```

Only display contact methods currently supported by SMEvolve.

---

# SECTION 9 – Consent

## Field: privacy_consent

**Label:**

```text
I agree that SMEvolve may use the information I provide
to respond to my project enquiry.
```

**Type:**

```text
checkbox
```

**Required:**

```text
Yes
```

The checkbox must link to the current Privacy Policy.

---

# Marketing Consent

Marketing consent should remain separate from quote-request consent.

Do not make marketing consent mandatory for submitting a quote.

---

# SECTION 10 – AI Metadata

AI-related metadata should not normally be displayed to the user.

The system may store:

```text
ai_used
ai_suggestion_count
ai_suggestion_accepted
ai_suggestion_rejected
ai_summary
ai_detected_project_type
ai_detected_features
```

---

# AI Source Tracking

Every AI-derived value should support source tracking.

Example:

```text
field:
project_type

value:
E-commerce Website

source:
ai

confirmed:
true
```

---

# User Confirmation

An AI-derived value should not become confirmed user information until:

```text
User Accepts
```

or:

```text
User Manually Confirms
```

---

# Field Priority

If conflicting values exist:

```text
User Confirmed
      ↓
User Entered
      ↓
AI Confirmed
      ↓
AI Suggested
      ↓
System Inferred
```

---

# Conditional Logic

The Quote Wizard must support rules such as:

```text
IF project_type = Website
THEN show website_features
```

```text
IF project_type = E-commerce Website
THEN show ecommerce_features
```

```text
IF existing_assets contains Website
THEN show existing_website_url
```

```text
IF industry = Other
THEN show industry_other
```

```text
IF project_type = Other
THEN show project_type_other
```

---

# Multiple Conditions

The system should support multiple conditions.

Example:

```text
IF
project_type = E-commerce Website
AND
ecommerce_features contains Online Payments

THEN

show:
preferred_payment_requirements
```

This capability should be supported architecturally even if advanced conditions are not enabled initially.

---

# Question Ordering

Questions should generally follow:

```text
Project
 ↓
Business
 ↓
Requirements
 ↓
Assets
 ↓
Timeline
 ↓
Budget
 ↓
Additional Information
 ↓
Contact
 ↓
Consent
```

Conditional questions may appear within the relevant section.

---

# Required Field Behaviour

If a required field is incomplete:

```text
Next
 ↓
Validation Error
```

The interface should:

* Identify the field.
* Explain the error.
* Move focus appropriately.
* Preserve entered information.

---

# Validation Rules

## Name

Must:

* Be present.
* Contain reasonable characters.
* Respect maximum length.

---

## Email

Must:

* Be present.
* Match valid email format.
* Respect maximum length.

---

## Phone

Must:

* Be present.
* Accept appropriate international formats.
* Be normalized before storage where appropriate.

---

## URL

Must:

* Be a valid URL.
* Use an appropriate protocol where required.

---

## Textareas

Must:

* Respect maximum length.
* Reject unsafe executable content.
* Preserve normal punctuation.

---

# Security Validation

Frontend validation must never replace backend validation.

The backend must validate all submitted fields again.

---

# Data Normalization

Where appropriate:

```text
Email → lowercase / normalized
Phone → normalized
URL → normalized
Whitespace → trimmed
```

Do not modify the meaning of user-entered free text.

---

# Field Configuration

Questions and options should be designed so that future versions can be configured without rewriting the entire Quote Wizard.

Potential configuration structure:

```text
id
section
label
description
type
required
options
conditions
validation_rules
order
active
```

---

# Admin Compatibility

The data structure should support future Admin Portal controls for:

```text
Add Question
Edit Question
Disable Question
Reorder Question
Add Option
Remove Option
Change Required Status
Configure Conditional Logic
```

These controls should not be implemented in this document unless covered by the Admin Controls specification.

---

# Accessibility Requirements

Every field must have:

* Accessible label.
* Appropriate input type.
* Error association.
* Keyboard accessibility.
* Visible focus state.

Select and multi-select controls must be usable without a mouse.

---

# Mobile Requirements

Fields must:

* Fit the viewport.
* Avoid unnecessary horizontal scrolling.
* Use appropriate mobile keyboards.
* Have sufficiently large touch targets.

For example:

```text
email → email keyboard
phone → phone keyboard
url → URL keyboard
```

where supported.

---

# Data Model Mapping

Each field should map to a defined Quote Session attribute or answer record.

Example:

```text
project_type
project_description
business_name
industry
website_features
existing_assets
timeline
budget_range
additional_information
full_name
email
phone
company_name
preferred_contact_method
privacy_consent
```

---

# Minimum Submission Dataset

A quote cannot normally be submitted without:

```text
project_type
project_description
full_name
email
phone
privacy_consent
```

---

# Quote Wizard Field Summary

| Field                            | Type           | Required    |
| -------------------------------- | -------------- | ----------- |
| project_type                     | Single Select  | Yes         |
| project_type_other               | Textarea       | Conditional |
| project_description              | Textarea       | Yes         |
| business_name                    | Text           | No          |
| industry                         | Single Select  | No          |
| industry_other                   | Text           | Conditional |
| business_description             | Textarea       | No          |
| website_features                 | Multi Select   | Conditional |
| ecommerce_features               | Multi Select   | Conditional |
| web_app_features                 | Multi Select   | Conditional |
| mobile_app_features              | Multi Select   | Conditional |
| custom_software_features         | Multi Select   | Conditional |
| design_requirements              | Multi Select   | Conditional |
| additional_features              | Textarea       | No          |
| existing_assets                  | Multi Select   | No          |
| existing_website_url             | URL            | Conditional |
| existing_application_description | Textarea       | Conditional |
| project_stage                    | Single Select  | No          |
| timeline                         | Timeline       | No          |
| budget_range                     | Currency Range | No          |
| additional_information           | Textarea       | No          |
| full_name                        | Text           | Yes         |
| email                            | Email          | Yes         |
| phone                            | Phone          | Yes         |
| company_name                     | Text           | No          |
| preferred_contact_method         | Single Select  | No          |
| privacy_consent                  | Checkbox       | Yes         |

---

# Success Criteria

The Questions & Fields system is complete when:

✓ Every core Quote Wizard question is defined.

✓ Required and optional fields are identified.

✓ Conditional questions are defined.

✓ Project-specific features are supported.

✓ AI-derived values can be tracked.

✓ User confirmation overrides AI suggestions.

✓ Backend validation is supported.

✓ Fields are accessible.

✓ Fields are mobile-friendly.

✓ Data can map cleanly to the Quote Session model.

✓ Future question configuration is possible.

---

# Stop Condition

This document defines Quote Wizard questions, fields, validation requirements, and conditional logic.

Detailed UI/UX, pricing logic, AI implementation, lead management, notifications, database architecture, API design, security, SEO, and testing will be defined in their respective documents.
