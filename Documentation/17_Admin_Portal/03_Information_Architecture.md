# SMEvolve Admin Portal

## 03 – Information Architecture

**Project:** SMEvolve

**Module:** Admin Portal

**Documentation Path:** `Documentation/17_Admin_Portal/`

**Framework:** Laravel 12

**Frontend:** Blade, Vite, Alpine.js

**Version:** 1.0

**Document Type:** Information Architecture & Navigation Specification

---

# 1. Objective

Define how information, functionality, and navigation are organized within the SMEvolve Admin Portal.

The Admin Portal should allow authorized administrators to quickly locate and manage important operational information without unnecessary complexity.

The architecture must provide a clear separation between:

* Website management.
* Quote management.
* Chatbot/AI management.
* Administration.
* Security.
* Account management.

---

# 2. Information Architecture Principles

The Admin Portal must follow these principles:

### 2.1 Task-Oriented

Navigation should be organized around what administrators need to do.

### 2.2 Simple

Frequently used functions should be easy to reach.

### 2.3 Predictable

Similar information should follow consistent structures.

### 2.4 Permission-Aware

Users should only see navigation items for functionality they are authorized to access.

### 2.5 Scalable

The navigation must allow additional administrative modules without requiring a complete redesign.

### 2.6 Consistent

The Admin Portal should use the SMEvolve design system and shared UI components.

---

# 3. High-Level Architecture

The Admin Portal will follow:

```text id="i1m6k4"
Admin Portal
│
├── Dashboard
│
├── Website
│   ├── General Settings
│   ├── Contact Information
│   ├── Business Information
│   └── Social Links
│
├── Quotes
│   ├── All Quotes
│   └── Quote Details
│
├── Chatbot & AI
│   ├── Chatbot Settings
│   ├── AI Settings
│   └── AI Status
│
├── Administration
│   ├── Administrators
│   └── Audit Log
│
└── Account
    ├── Profile
    └── Security
```

This is the initial information architecture.

Individual modules may gain additional pages later.

---

# 4. Primary Navigation

The primary navigation should contain:

```text id="o2xj9r"
Dashboard
Website
Quotes
Chatbot & AI
Administration
Account
```

The navigation must not become overloaded with individual actions.

---

# 5. Dashboard

The Dashboard is the default landing page after successful authentication.

Route concept:

```text id="q4e5n7"
/admin
```

Named route:

```text id="4g1j0q"
admin.dashboard
```

The dashboard provides an operational overview rather than being a complete reporting system.

---

# 6. Dashboard Information

The dashboard may contain:

### Quote Overview

* Total quotes.
* New quotes.
* Quotes requiring attention.
* Recently submitted quotes.

### System Status

* Chatbot status.
* AI provider status.
* Important configuration warnings.

### Recent Activity

* Recent administrative actions.

The exact metrics will be defined in the Dashboard document.

---

# 7. Website Section

The Website section contains settings that affect the public SMEvolve website.

Structure:

```text id="p6x9pl"
Website
│
├── General Settings
├── Contact Information
├── Business Information
└── Social Links
```

The purpose is to centralize routine public-facing information.

---

# 8. General Settings

General Settings may contain:

* Company name.
* Company description.
* Website name.
* Website URL.
* Logo configuration where supported.
* Footer-related settings where appropriate.

Only approved settings should be exposed.

---

# 9. Contact Information

Contact Information contains:

* Primary phone.
* Secondary phone.
* Primary email.
* Secondary email.
* Business address.
* Contact availability information where applicable.

These values may be consumed by:

* Header.
* Footer.
* Contact page.
* Quote Wizard.
* Chatbot.

The system should use a centralized settings source.

---

# 10. Business Information

Business Information may include:

* Business hours.
* Service availability.
* Business location information.
* Public business description.
* Other approved operational information.

The final fields will be defined in the Site Settings documentation.

---

# 11. Social Links

Administrators with permission may manage supported social profiles.

Potential platforms include:

* Facebook.
* Instagram.
* LinkedIn.
* X/Twitter.
* Other approved platforms.

Each link must be validated before saving.

---

# 12. Quotes Section

The Quotes section is responsible for administrative access to Quote Wizard submissions.

Structure:

```text id="e8z0kh"
Quotes
│
└── All Quotes
      │
      └── Quote Details
```

---

# 13. All Quotes

The All Quotes page provides a searchable and filterable list.

It should display concise information such as:

* Quote reference.
* Project/customer identifier where appropriate.
* Project type.
* Status.
* Submission date.
* Last activity.

The list should not expose excessive customer information.

---

# 14. Quote Details

Quote Details provides the complete administrative view permitted by the administrator's role.

Possible sections:

```text id="h1pk0j"
Quote Summary
Project Information
Requirements
Timeline
Budget
Contact Information
Submission Information
Administrative Status
Activity
```

Information must be grouped logically rather than presented as one large data block.

---

# 15. Quote Detail Navigation

If a quote contains many sections, use internal navigation or clearly separated sections.

Example:

```text id="zzpzz8"
Summary
Project
Requirements
Contact
Activity
```

Avoid unnecessary page complexity.

---

# 16. Quote Actions

Available actions depend on permissions.

Potential actions:

* Change status.
* Add administrative note if later implemented.
* Mark as contacted.
* Mark as completed.
* Return to list.

Destructive actions should not be presented as normal primary actions.

---

# 17. Chatbot & AI Section

The Chatbot & AI section manages the existing SMEvolve chatbot and approved AI functionality.

Structure:

```text id="8wzyaf"
Chatbot & AI
│
├── Chatbot Settings
├── AI Settings
└── AI Status
```

This section must remain tightly controlled.

---

# 18. Chatbot Settings

Potential settings include:

* Enabled/disabled.
* Welcome message.
* Contact escalation settings.
* Business information used by the chatbot.
* Approved chatbot behavior.

The exact configuration will follow the existing chatbot architecture.

---

# 19. AI Settings

Only safe, approved AI settings should be visible.

Potential settings:

* AI feature enabled/disabled.
* Approved model selection.
* AI feature limits.
* Response configuration where supported.

Never display:

```text id="bqv7p3"
GROQ_API_KEY
APP_KEY
DATABASE credentials
```

or any other secrets.

---

# 20. AI Status

The AI Status page may show operational information such as:

* Provider.
* Configured model.
* Service availability.
* Last successful check.
* Current feature status.

It must not display credentials.

---

# 21. Administration Section

The Administration section contains privileged administrative functionality.

Structure:

```text id="k1j2mi"
Administration
│
├── Administrators
└── Audit Log
```

Access should be restricted by permission.

---

# 22. Administrators

The Administrators page manages authorized Admin Portal users.

Possible information:

* Name.
* Email.
* Role.
* Account status.
* Last login.
* Created date.

Potential actions:

* Create.
* Edit.
* Disable.
* Enable.
* Change role.

The ability to perform each action depends on permissions.

---

# 23. Administrator Details

The administrator detail page should show:

* Name.
* Email.
* Role.
* Account status.
* Last login.
* Account creation date.
* Relevant security information.

Passwords must never be displayed.

---

# 24. Audit Log

The Audit Log provides a historical record of important administrative actions.

Potential columns:

* Date/time.
* Administrator.
* Action.
* Target.
* Result.

Administrators should be able to search and filter audit records where appropriate.

---

# 25. Audit Log Privacy

Audit logs should not unnecessarily display:

* Passwords.
* API keys.
* Full sensitive request payloads.
* Unnecessary personal information.

Only information required for auditability should be retained/displayed.

---

# 26. Account Section

The Account section contains functionality relating to the currently authenticated administrator.

Structure:

```text id="d7n6a0"
Account
│
├── Profile
└── Security
```

---

# 27. Profile

The administrator can view and, where permitted, update personal administrative information.

Potential fields:

* Name.
* Email.

Do not allow ordinary profile editing to change administrative privileges.

---

# 28. Security

Security settings may include:

* Change password.
* Session management where supported.
* Security information.

Future security enhancements may include:

* Two-factor authentication.
* Login history.
* Active session management.

These should not be implemented unless included in the approved security scope.

---

# 29. Sidebar Behavior

The primary navigation should remain visible on desktop.

On smaller screens:

```text id="t1f3xm"
Sidebar
   ↓
Collapsible / Mobile Navigation
```

The navigation must remain keyboard accessible.

---

# 30. Active Navigation State

The current section/page must be clearly indicated.

For example:

```text id="q9g6s8"
Dashboard      active
Website
Quotes
Chatbot & AI
Administration
Account
```

Do not rely solely on color to indicate the active state.

---

# 31. Breadcrumbs

Administrative pages should use breadcrumbs where they improve navigation.

Example:

```text id="6q3gch"
Dashboard
  /
Quotes
  /
Quote #SME-2026-0001
```

The dashboard itself does not require a breadcrumb.

---

# 32. Page Structure

Administrative pages should generally follow:

```text id="2a4s9y"
Page Header
    ↓
Description / Context
    ↓
Actions
    ↓
Filters / Search where applicable
    ↓
Main Content
    ↓
Pagination / Secondary Actions
```

---

# 33. Page Titles

Every administrative page should have a clear title.

Examples:

```text id="e4gj3n"
Dashboard
Website Settings
Contact Information
Quotes
Quote Details
Chatbot Settings
Administrators
Audit Log
```

Titles should match navigation terminology.

---

# 34. Tables

Administrative tables should:

* Use meaningful column headings.
* Support keyboard interaction.
* Remain readable on smaller screens.
* Avoid unnecessary columns.
* Provide clear row actions.

Large datasets must be paginated.

---

# 35. Forms

Administrative forms should:

* Use clear labels.
* Group related fields.
* Display validation errors.
* Preserve submitted values after validation failure.
* Provide clear save/cancel actions.
* Confirm successful saves.

---

# 36. Destructive Actions

Destructive or high-impact actions should use confirmation.

Examples:

```text id="bbv7rj"
Disable administrator
Delete setting
Disable chatbot
```

The confirmation should explain the consequence.

---

# 37. Permission-Aware Navigation

Navigation must respect authorization.

For example:

```text id="u7ck0r"
Admin without manage_admins permission
        ↓
Administrators menu hidden
```

However, hiding navigation is only a usability feature.

The backend must still enforce authorization.

---

# 38. Deep-Link Protection

A user must not gain access simply by manually entering an administrative URL.

Example:

```text id="rjz8st"
User lacks permission
        ↓
Direct URL request
        ↓
Authorization denied
```

---

# 39. Public/Admin Separation

The public website and Admin Portal should remain logically separated.

Conceptually:

```text id="0qj0pp"
Public
├── /
├── /services
├── /contact
├── /quote
└── /privacy-policy

Admin
├── /admin
├── /admin/settings
├── /admin/quotes
├── /admin/chatbot
└── /admin/administrators
```

The exact route structure will be defined later.

---

# 40. Information Ownership

The Admin Portal should not become the owner of every piece of SMEvolve business logic.

Instead:

```text id="h2n9uw"
Module
   ↓
Owns its business logic
   ↓
Admin Portal
   ↓
Provides authorized management interface
```

For example, Quote Wizard remains the owner of quote workflow logic.

The Admin Portal provides administrative access to that functionality.

---

# 41. Search Architecture

Search should be contextual.

For example:

```text id="x7h9p5"
Quotes → Quote search
Administrators → Administrator search
Audit Log → Audit search
```

Avoid creating one global search system unless there is a real requirement.

---

# 42. Empty States

Administrative pages must have useful empty states.

Example:

```text id="j4b1b0"
No quotes found.

Try changing your search or filter.
```

Empty states should distinguish between:

* No data exists.
* Search returned no results.
* Data could not be loaded.

---

# 43. Loading States

Where asynchronous operations are used, provide appropriate loading feedback.

Examples:

```text id="wq3l1c"
Saving...
Loading quotes...
Checking AI status...
```

Loading indicators must be accessible.

---

# 44. Error States

Each page should have a defined error state.

Example:

```text id="x1jv0d"
Unable to load quotes.

Please try again.
```

Do not expose technical implementation details.

---

# 45. Success States

Successful operations should provide clear feedback.

Examples:

```text id="4lq3os"
Settings saved successfully.
Quote status updated.
Administrator created successfully.
```

Messages should be brief and accessible.

---

# 46. Information Architecture Rules

The following rules apply:

1. No unnecessary top-level navigation items.
2. Related functions should be grouped.
3. Sensitive functionality should be permission-controlled.
4. Frequently used functions should require minimal navigation.
5. Large datasets must use pagination.
6. Navigation terminology must remain consistent.
7. Public and administrative interfaces must remain separated.
8. Each module must retain ownership of its business logic.

---

# 47. Proposed Navigation

The initial final navigation proposal is:

```text id="7j7b8a"
ADMIN PORTAL

Dashboard

Website
  General Settings
  Contact Information
  Business Information
  Social Links

Quotes
  All Quotes

Chatbot & AI
  Chatbot Settings
  AI Settings
  AI Status

Administration
  Administrators
  Audit Log

Account
  Profile
  Security
```

The navigation may be reduced for administrators with limited permissions.

---

# 48. Future Navigation

Future modules may be added without changing the fundamental architecture.

Potential future sections:

```text id="yq6p0f"
Communications
Analytics
CRM
Notifications
Content
Media
```

These must only be introduced when the corresponding modules are approved.

---

# 49. Acceptance Criteria

This Information Architecture document is accepted when:

✓ Primary navigation is defined.

✓ Dashboard location is defined.

✓ Website management structure is defined.

✓ Quote management structure is defined.

✓ Chatbot/AI structure is defined.

✓ Administration structure is defined.

✓ Account structure is defined.

✓ Permission-aware navigation is established.

✓ Public/Admin separation is established.

✓ Mobile navigation behavior is defined.

✓ Breadcrumb behavior is defined.

✓ Tables, forms, states, and navigation conventions are established.

---

# 50. Next Document

The next document is:

```text id="8w4j7p"
Documentation/17_Admin_Portal/04_Admin_Roles_and_Permissions.md
```

This document will define administrator roles, permissions, privilege boundaries, and authorization rules before implementation architecture is finalized.
