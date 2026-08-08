# SMEvolve Admin Portal

## 01 – Overview

**Project:** SMEvolve

**Module:** Admin Portal

**Documentation Path:** `Documentation/17_Admin_Portal/`

**Framework:** Laravel 12

**Frontend:** Blade, Vite, Alpine.js

**Authentication:** Laravel-based Admin Authentication

**Version:** 1.0

**Document Type:** Module Overview & Architecture Foundation

---

# 1. Objective

The SMEvolve Admin Portal is the secure administrative interface used by authorized SMEvolve staff to manage the operational information and administrative functions of the website.

The Admin Portal is intended to give administrators centralized control over important website information without requiring direct modification of application code or database records.

The portal must be:

* Secure.
* Simple to operate.
* Responsive.
* Accessible.
* Maintainable.
* Scalable.
* Consistent with the SMEvolve Design System.
* Integrated with the existing Laravel application.

---

# 2. Scope

The Admin Portal will provide authorized administrators with controlled access to important operational areas of SMEvolve.

Core areas include:

* Dashboard.
* Website settings.
* Company information.
* Contact information.
* Business information.
* Social media links.
* Website content/settings where approved.
* Quote submissions.
* Quote management information.
* Chatbot configuration.
* AI-related settings that are safe to expose.
* Administrative activity/audit information.
* Account/security settings.

The exact capabilities of each section will be defined in subsequent Admin Portal documentation.

---

# 3. Important Scope Decision

SMEvolve will **not** implement a Client Portal as part of this architecture.

The system will have:

```text
Public Website
      ↓
Quote Wizard
      ↓
Admin Portal
```

There is no requirement for customers to log into SMEvolve to view or manage their submissions.

Customers interact with the public website and Quote Wizard.

Administrators manage operational information through the Admin Portal.

---

# 4. Administrative Model

The Admin Portal is an internal system.

It must not be treated as another public-facing website.

The architecture must therefore prioritize:

1. Authentication.
2. Authorization.
3. Data protection.
4. Auditability.
5. Administrative usability.
6. Operational reliability.

---

# 5. Admin Portal Architecture

The high-level architecture is:

```text
Administrator
      ↓
Admin Authentication
      ↓
Authorization
      ↓
Admin Portal
      ↓
Admin Controllers
      ↓
Admin Services
      ↓
Models / Database
```

For AI-related functionality:

```text
Admin Portal
      ↓
Admin Service
      ↓
AI Configuration / Service
      ↓
Groq
```

The browser must never receive private AI credentials.

---

# 6. Admin Dashboard

The dashboard will provide administrators with a high-level overview of important website activity.

Potential dashboard information includes:

* Recent quote submissions.
* Quote submission counts.
* Recent administrative activity.
* Website status indicators.
* Important configuration warnings.
* Chatbot/AI status.
* Other operational metrics approved in later documentation.

The dashboard should prioritize useful information rather than becoming a collection of unnecessary statistics.

---

# 7. Website Settings

Administrators should be able to manage important website-wide settings through the Admin Portal.

Potential settings include:

* Company name.
* Company description.
* Primary phone number.
* Secondary phone number.
* Primary email address.
* Secondary email address.
* Physical/business address.
* Business hours.
* Social media links.
* Website URL.
* Footer information.
* General contact information.

The final setting list will be defined in the Admin Settings documentation.

---

# 8. Centralized Site Information

The Admin Portal should provide a centralized source for important public-facing business information.

For example:

```text
Company Name
Phone
Email
Address
Business Hours
Social Links
```

Public website components should consume these values from the approved application settings architecture rather than hardcoding them across multiple Blade files.

This allows administrators to update information from one location.

---

# 9. Quote Management

The Admin Portal must provide appropriate visibility into Quote Wizard submissions.

Administrators should be able to:

* View submitted quotes.
* Search quotes.
* Filter quotes.
* Open quote details.
* View quote reference.
* View submission date.
* View relevant project information.
* View contact information where authorized.
* View requirements.
* View submission status.

The portal should not allow administrators to modify immutable submission data without an explicitly defined business requirement.

---

# 10. Quote Status

Where required, administrators may manage operational quote statuses.

Potential statuses include:

```text
New
Reviewing
Contacted
In Progress
Completed
Cancelled
```

The final status workflow will be defined in the Quote Management documentation.

Status changes must be auditable.

---

# 11. Chatbot Administration

The Admin Portal should provide appropriate controls for the SMEvolve chatbot.

Potential capabilities include:

* Enable/disable chatbot.
* Configure welcome message.
* Configure supported business information.
* Configure contact/lead escalation behavior.
* View chatbot activity where required.
* Configure approved AI behavior.
* View AI service status.

Administrators must not be given unrestricted access to system-level AI instructions unless explicitly required.

---

# 12. AI Security

The Admin Portal must never expose:

* Groq API keys.
* Database credentials.
* Application secrets.
* Encryption keys.
* Server credentials.

Sensitive environment configuration remains outside normal administrator-editable settings.

If an administrator needs to change an AI setting, only explicitly approved configuration values should be exposed.

---

# 13. Authentication

The Admin Portal must require authentication.

Unauthenticated users must not access administrative routes.

The authentication architecture should follow Laravel and existing SMEvolve security conventions.

The system should support secure:

* Login.
* Logout.
* Session handling.
* Password management.
* Account recovery where required.

---

# 14. Authorization

Authentication alone is insufficient.

The Admin Portal must use authorization to determine what an authenticated administrator can access or modify.

The architecture should allow future roles such as:

```text
Super Admin
Admin
Editor
Support
```

if required.

Do not implement unnecessary roles until they are required.

---

# 15. Super Administrator

A Super Admin role may be used for highly sensitive administrative functions.

Potential permissions include:

* Administrator management.
* Security settings.
* Site configuration.
* AI configuration.
* Audit log access.

These permissions must be explicitly defined before implementation.

---

# 16. Administrator Account Management

Where included in scope, authorized administrators should be able to manage administrative accounts.

Potential operations:

* Create administrator.
* Disable administrator.
* Reset administrator access.
* Change role.
* View account status.

An administrator must not be able to escalate their own privileges unless explicitly authorized.

---

# 17. Audit Logging

Important administrative actions should be recorded.

Examples:

```text
Administrator logged in
Administrator logged out
Website setting changed
Quote status changed
Chatbot configuration changed
Administrator account changed
```

Audit records should include appropriate information such as:

* Administrator.
* Action.
* Target.
* Timestamp.
* Relevant metadata.

Avoid storing unnecessary sensitive data.

---

# 18. Security Monitoring

The Admin Portal should provide the foundation for monitoring:

* Failed login attempts.
* Suspicious access.
* Administrative changes.
* Permission changes.
* Sensitive configuration changes.

Detailed monitoring requirements will be defined in the Security documentation.

---

# 19. Data Protection

Administrative users may have access to sensitive customer information.

Therefore:

* Access must be authenticated.
* Access must be authorized.
* Data should only be displayed when required.
* Sensitive information should not appear unnecessarily in lists.
* Sensitive information should not be exposed in URLs.
* Logs must avoid unnecessary personal information.

---

# 20. Public Website Integration

The Admin Portal must integrate cleanly with the public website.

For example:

```text
Admin changes phone number
        ↓
Saved
        ↓
Public website reads current setting
        ↓
Updated phone number displayed
```

The system should avoid requiring code deployment for routine website information changes.

---

# 21. Content Management Boundary

The Admin Portal is **not initially intended to become a full CMS**.

The first implementation should focus on operational settings and essential administrative information.

Avoid introducing:

* Complex page builders.
* Drag-and-drop editors.
* Full content versioning.
* Unnecessary media management.

These can be future enhancements if required.

---

# 22. Admin UI

The Admin Portal should have a dedicated administrative interface.

It should include:

* Sidebar/navigation.
* Header.
* Page title.
* Breadcrumbs where appropriate.
* Content area.
* Notifications/alerts.
* Tables.
* Forms.
* Modals where appropriate.
* Responsive navigation.

The UI must remain consistent with SMEvolve's design system while being optimized for administrative workflows.

---

# 23. Responsive Design

The Admin Portal must support:

```text
Mobile
Tablet
Desktop
```

Desktop should provide the primary administrative experience.

Mobile should remain usable for urgent administrative tasks.

---

# 24. Accessibility

The Admin Portal must support:

* Semantic HTML.
* Keyboard navigation.
* Visible focus states.
* Accessible form labels.
* Accessible validation errors.
* Appropriate ARIA usage.
* Screen-reader compatibility.
* Sufficient contrast.
* Accessible tables and controls.

---

# 25. Performance

The Admin Portal should prioritize operational responsiveness.

Avoid:

* Excessive dashboard queries.
* Large unpaginated datasets.
* Unnecessary JavaScript.
* Repeated database queries.
* Loading large datasets when only summaries are required.

Use pagination, filtering, and efficient queries where appropriate.

---

# 26. Search and Filtering

Administrative lists such as quotes should support appropriate:

* Search.
* Filtering.
* Sorting.
* Pagination.

The exact fields will be defined in the relevant module documentation.

---

# 27. Error Handling

Administrative errors must be handled safely.

Administrators should receive useful messages such as:

```text
Unable to save settings.
Please try again.
```

rather than:

```text
SQLSTATE[...]
```

Production errors must never expose:

* SQL queries.
* Stack traces.
* API credentials.
* File paths.
* Internal infrastructure details.

---

# 28. Validation

All Admin Portal forms must use server-side validation.

Examples include:

* Email addresses.
* Phone numbers.
* URLs.
* Required settings.
* Status values.
* Administrator information.

Client-side validation may improve usability but must never replace server-side validation.

---

# 29. Configuration Architecture

Administrative settings should use an appropriate persistent configuration architecture.

The implementation must distinguish between:

### Application Configuration

Values such as:

```text
API keys
Encryption secrets
Database credentials
```

These remain environment/server configuration.

### Editable Site Settings

Values such as:

```text
Phone
Email
Business hours
Social links
Company information
```

These may be stored in the application's approved settings system.

---

# 30. Caching

If public website settings are cached, the Admin Portal must properly invalidate or refresh the cache after updates.

Example:

```text
Admin changes setting
        ↓
Save
        ↓
Invalidate settings cache
        ↓
Public website receives new value
```

Administrators should not need to manually clear application caches for ordinary settings changes.

---

# 31. Admin Navigation

The initial Admin Portal navigation should be organized around operational tasks.

A potential structure:

```text
Dashboard

Website
 ├── General Settings
 ├── Contact Information
 └── Social Links

Quotes
 ├── All Quotes
 └── Quote Details

Chatbot / AI
 ├── Chatbot Settings
 └── AI Status

Administration
 ├── Administrators
 └── Audit Log

Account
 └── Profile / Security
```

The final navigation will be refined in subsequent documents.

---

# 32. Module Boundaries

The Admin Portal should integrate with existing SMEvolve modules without duplicating their business logic.

For example:

```text
Quote Wizard
     ↓
Quote Services
     ↓
Admin Portal
```

The Admin Portal should call the existing Quote services/models where appropriate rather than creating a second quote system.

The same principle applies to:

* Chatbot.
* AI.
* Website settings.
* Notifications.
* Legal information.

---

# 33. Security Principles

The Admin Portal must follow:

```text
Least Privilege
+
Defense in Depth
+
Secure Defaults
+
Auditability
+
Data Minimization
```

No administrative action should rely solely on frontend restrictions.

---

# 34. Testing Foundation

The Admin Portal must eventually include tests covering:

### Authentication

* Login.
* Logout.
* Invalid credentials.
* Session security.

### Authorization

* Allowed access.
* Denied access.
* Role permissions.

### Settings

* View settings.
* Update settings.
* Validation.
* Cache invalidation.

### Quotes

* List.
* Search.
* Filter.
* View.
* Status changes.

### Chatbot

* Settings.
* Permission restrictions.
* AI configuration protection.

### Audit

* Administrative actions recorded.

---

# 35. Future Expansion

The architecture should support future modules such as:

* Advanced quote management.
* Official quotation generation.
* CRM.
* Customer communication.
* Analytics.
* Notifications.
* Media management.
* Content management.
* Staff roles.
* Subscription management.

These should be added without redesigning the entire Admin Portal.

---

# 36. Documentation Structure

The Admin Portal documentation will be maintained under:

```text
Documentation/17_Admin_Portal/
```

The documents should begin at:

```text
01_Overview.md
```

and continue sequentially.

Potential documentation structure:

```text
17_Admin_Portal/
│
├── 01_Overview.md
├── 02_Requirements.md
├── 03_Information_Architecture.md
├── 04_Admin_Roles_and_Permissions.md
├── 05_Authentication_and_Security.md
├── 06_Dashboard.md
├── 07_Site_Settings.md
├── 08_Quote_Management.md
├── 09_Chatbot_and_AI_Administration.md
├── 10_Audit_Logging.md
├── 11_UI_and_Component_Architecture.md
├── 12_Routes_Controllers_and_Validation.md
├── 13_Service_Layer.md
├── 14_Database_Architecture.md
├── 15_Testing_and_Acceptance.md
└── ...
```

The exact number of documents may be adjusted as the architecture develops.

Do not create unnecessary documents simply to increase document count.

---

# 37. Implementation Philosophy

The Admin Portal should remain:

**Simple enough to operate easily.**

**Powerful enough to control important website functions.**

**Secure enough to protect administrative and customer information.**

**Flexible enough to support future SMEvolve expansion.**

Avoid turning the initial Admin Portal into an unnecessarily complex enterprise management system.

---

# 38. Success Criteria

The Admin Portal architecture is successful when:

✓ Administrators have a secure central control system.

✓ Important website information can be updated without code changes.

✓ Quote submissions can be managed appropriately.

✓ Chatbot/AI functionality can be controlled safely.

✓ Sensitive credentials remain protected.

✓ Administrative actions can be audited.

✓ The system supports appropriate roles and permissions.

✓ The public website integrates cleanly with administrator-controlled settings.

✓ The architecture can expand without major restructuring.

---

# 39. Next Document

The next Admin Portal document is:

```text
Documentation/17_Admin_Portal/02_Requirements.md
```

This document will define the detailed functional and non-functional requirements before we move into the individual Admin Portal architecture areas.
