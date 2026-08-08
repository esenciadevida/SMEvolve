# SMEvolve Admin Portal

## 02 – Requirements

**Project:** SMEvolve

**Module:** Admin Portal

**Documentation Path:** `Documentation/17_Admin_Portal/`

**Framework:** Laravel 12

**Frontend:** Blade, Vite, Alpine.js

**Version:** 1.0

**Document Type:** Functional & Non-Functional Requirements

---

# 1. Objective

Define the functional and non-functional requirements for the SMEvolve Admin Portal.

This document establishes what the Admin Portal must be capable of doing before the detailed architecture, database, security, UI, and implementation documents are created.

The Admin Portal must provide authorized administrators with secure control over important SMEvolve website operations without exposing sensitive infrastructure credentials or unnecessary customer information.

---

# 2. Product Goals

The Admin Portal must:

1. Provide secure administrative access.
2. Centralize important website settings.
3. Allow administrators to manage quote submissions.
4. Provide controlled chatbot/AI management.
5. Support administrative account management.
6. Record important administrative actions.
7. Reduce the need for direct database or code changes.
8. Protect customer and business information.
9. Provide a responsive and accessible administrative interface.
10. Provide a foundation for future SMEvolve expansion.

---

# 3. User Types

The initial Admin Portal must support an administrator model that can be expanded into multiple roles.

Potential roles include:

```text
Super Admin
Admin
Editor
Support
```

The exact permissions for each role will be defined in:

```text
Documentation/17_Admin_Portal/04_Admin_Roles_and_Permissions.md
```

Do not assume every administrator has unrestricted access.

---

# 4. Authentication Requirements

The Admin Portal must require authentication.

### Requirements

✓ Unauthenticated users cannot access protected Admin Portal routes.

✓ Successful authentication creates a secure authenticated session.

✓ Invalid credentials produce a safe error.

✓ Authentication failures do not reveal whether a specific account exists.

✓ Administrators can log out.

✓ Sessions are invalidated appropriately on logout.

✓ Authentication must follow Laravel security conventions.

---

# 5. Administrative Account Requirements

Authorized administrators should be able to manage administrator accounts according to their permissions.

Potential capabilities include:

* View administrators.
* Create administrator.
* Edit administrator.
* Disable administrator.
* Reactivate administrator.
* Change role.
* Reset access.
* View account status.

A normal administrator must not automatically receive Super Admin privileges.

---

# 6. Account Security

Administrator accounts must support secure credential management.

Requirements include:

✓ Secure password storage.

✓ Password confirmation for sensitive actions where appropriate.

✓ Password reset/recovery where supported.

✓ Protection against brute-force login attempts.

✓ Session invalidation after appropriate security events.

✓ No passwords stored in plaintext.

---

# 7. Dashboard Requirements

The dashboard must provide an operational overview.

It should display useful information such as:

* Total quote submissions.
* Recent quote submissions.
* Quotes requiring attention.
* Recent administrative activity.
* Chatbot/AI status.
* Important system warnings.

Dashboard information must be concise and actionable.

Avoid unnecessary decorative statistics.

---

# 8. Dashboard Data Requirements

Dashboard information must be generated efficiently.

The system must avoid loading complete quote datasets simply to display counts.

Use:

* Aggregated queries.
* Pagination.
* Efficient filtering.
* Appropriate caching where useful.

---

# 9. Website Settings Requirements

Administrators with appropriate permission must be able to manage approved website settings.

Initial settings may include:

### Company

* Company name.
* Company description.
* Logo where supported by the existing architecture.

### Contact

* Primary phone.
* Secondary phone.
* Primary email.
* Secondary email.
* Business address.

### Business

* Business hours.
* Service availability information where approved.

### Social

* Facebook.
* Instagram.
* LinkedIn.
* X/Twitter or other supported platforms.

### Website

* Website URL.
* Public contact information.
* Footer information.

The final fields will be defined in the Site Settings document.

---

# 10. Settings Validation

Every editable setting must have appropriate validation.

Examples:

```text id="4nvx3b"
Email → valid email format
Phone → approved phone format
URL → valid URL
Required text → minimum/maximum length
```

Administrators must receive clear validation feedback.

---

# 11. Settings Persistence

When an administrator saves a setting:

```text id="q4yn1w"
Admin
 ↓
Validation
 ↓
Service
 ↓
Database
 ↓
Cache Invalidation
 ↓
Public Website
```

The updated value should become available to the public website according to the application's caching architecture.

---

# 12. Public Website Integration

Public website components must use the approved settings architecture.

For example:

```text id="sq8j0a"
Admin updates phone number
        ↓
Setting saved
        ↓
Public header/footer
        ↓
Updated phone number
```

Phone numbers, email addresses, and other centralized settings must not be duplicated throughout Blade templates.

---

# 13. Quote Management Requirements

Administrators with permission must be able to access quote submissions.

Required capabilities:

✓ View quote list.

✓ Search quotes.

✓ Filter quotes.

✓ Sort quotes where appropriate.

✓ Paginate results.

✓ Open quote details.

✓ View quote reference.

✓ View submission date.

✓ View project information.

✓ View requirements.

✓ View contact information according to permissions.

✓ View quote status.

---

# 14. Quote Search

Quote search should support appropriate identifiers such as:

* Quote reference.
* Customer name where available.
* Email where permitted.
* Project information where appropriate.

Search must be implemented efficiently.

Do not perform unrestricted full-table scans where avoidable.

---

# 15. Quote Filtering

Administrators should be able to filter quotes by relevant attributes such as:

* Status.
* Submission date.
* Project type.
* Other approved quote attributes.

Filters should be easy to clear and combine.

---

# 16. Quote Status Management

Authorized administrators may change operational quote status.

Potential statuses:

```text
New
Reviewing
Contacted
In Progress
Completed
Cancelled
```

The final status lifecycle will be defined in the Quote Management document.

Status changes must:

* Be validated.
* Be authorized.
* Be recorded in the audit system.

---

# 17. Quote Data Integrity

The Admin Portal must distinguish between:

### Submitted Data

Information supplied by the user at submission.

### Administrative Data

Information created or changed by administrators after submission.

Administrative actions must not silently overwrite immutable submitted information.

If editing submitted data becomes necessary, the behavior must be explicitly defined and auditable.

---

# 18. Quote Details

The quote details page should organize information into logical sections.

Potential sections:

```text
Quote Information
Project Information
Requirements
Timeline
Budget
Contact Information
Submission Information
Administrative Status
Activity History
```

Do not expose unnecessary internal database fields.

---

# 19. Chatbot Requirements

The Admin Portal must provide controlled administration of the existing SMEvolve chatbot.

Potential controls include:

* Enable/disable chatbot.
* Configure welcome message.
* Configure business/contact information.
* Configure approved chatbot behavior.
* Configure escalation/contact behavior.
* View chatbot status.
* View relevant chatbot usage information.

The exact capabilities must follow the already-approved chatbot architecture.

Do not duplicate chatbot business logic inside the Admin Portal.

---

# 20. AI Configuration Requirements

Administrators may be allowed to modify selected AI configuration values.

Examples may include:

* Chatbot enabled state.
* Model selection where explicitly permitted.
* AI feature availability.
* Approved response settings.

The following must **not** be exposed as ordinary editable fields:

```text
GROQ_API_KEY
Database credentials
Application secrets
Encryption keys
Server credentials
```

---

# 21. AI Cost Protection

The Admin Portal must not allow unrestricted AI configuration that could cause uncontrolled usage.

Where appropriate, provide controls for:

* Feature enablement.
* Rate limits.
* Allowed operations.
* Model selection from an approved list.

The final AI administration rules will be defined in the Chatbot/AI Administration document.

---

# 22. Audit Logging Requirements

Important administrative actions must be logged.

At minimum, audit:

* Login.
* Logout where appropriate.
* Administrator creation.
* Administrator role changes.
* Administrator disabling.
* Website setting changes.
* Quote status changes.
* Chatbot configuration changes.
* Sensitive administrative actions.

Audit records should contain appropriate:

* Actor.
* Action.
* Target.
* Timestamp.
* Metadata.

---

# 23. Audit Integrity

Administrators must not be able to casually modify or delete their own audit records.

If audit deletion is ever required, it must be restricted to an appropriately privileged operation and itself be audited.

---

# 24. Search, Pagination & Tables

Administrative datasets must not be rendered as unlimited lists.

Lists should use:

* Pagination.
* Search.
* Filters.
* Sorting where appropriate.

Tables must remain usable on smaller screens.

---

# 25. Notifications

The Admin Portal should provide clear feedback after administrative operations.

Examples:

### Success

```text
Settings saved successfully.
```

### Error

```text
Unable to save settings. Please try again.
```

### Warning

```text
This action cannot be reversed.
```

Notifications must be accessible and understandable.

---

# 26. Confirmation for Sensitive Actions

Potentially destructive or sensitive actions should require confirmation.

Examples:

* Disable administrator.
* Change privileged role.
* Delete content where deletion is permitted.
* Disable important functionality.

Do not rely solely on color to communicate danger.

---

# 27. Authorization Requirements

Every protected administrative action must be authorized server-side.

Frontend restrictions are not sufficient.

For example:

```text id="x7f56r"
Hide button
```

is not authorization.

The backend must independently verify that the administrator has permission to perform the action.

---

# 28. Role-Based Access

The architecture must support role-based access control.

Permissions should be defined around actions rather than only pages.

Examples:

```text
view_dashboard
manage_settings
view_quotes
manage_quotes
manage_chatbot
manage_admins
view_audit_logs
```

The complete permission matrix will be defined separately.

---

# 29. Data Privacy Requirements

Administrators may have access to customer information.

The system must follow data minimization.

Requirements:

✓ Display only required information.

✓ Restrict sensitive information according to permissions.

✓ Do not expose customer information in URLs unnecessarily.

✓ Avoid unnecessary logging of personal data.

✓ Protect exported data if exports are later introduced.

---

# 30. Security Requirements

The Admin Portal must implement:

* CSRF protection.
* Authentication.
* Authorization.
* Session security.
* Rate limiting.
* Input validation.
* Output escaping.
* Secure file handling where applicable.
* Protection against unauthorized resource access.
* Secure error handling.

---

# 31. API and AJAX Security

If Alpine.js or asynchronous requests are used:

✓ Requests must remain authenticated.

✓ CSRF protection must remain active.

✓ Authorization must be checked server-side.

✓ Responses must not expose sensitive fields.

✓ Endpoints must not trust client-supplied permissions.

---

# 32. Accessibility Requirements

The Admin Portal must support:

* Keyboard navigation.
* Screen readers.
* Semantic HTML.
* Form labels.
* Error messaging.
* Visible focus.
* Accessible tables.
* Accessible modals.
* Accessible notifications.
* Logical heading hierarchy.

---

# 33. Responsive Requirements

The Admin Portal must work across:

```text
Mobile
Tablet
Desktop
```

Desktop is the primary administrative environment.

Mobile must still support important operational actions.

---

# 34. Performance Requirements

The Admin Portal should:

✓ Load dashboard data efficiently.

✓ Paginate large datasets.

✓ Avoid N+1 queries.

✓ Avoid unnecessary JavaScript.

✓ Lazy-load expensive information where appropriate.

✓ Cache appropriate site settings.

✓ Avoid unnecessary API calls.

---

# 35. Error Handling Requirements

Errors must be:

* Safe.
* Understandable.
* Actionable.

Never expose:

* SQL errors.
* Stack traces.
* API keys.
* Internal paths.
* Server configuration.

---

# 36. Configuration Requirements

The Admin Portal must distinguish between:

### Environment Configuration

Examples:

```text
GROQ_API_KEY
APP_KEY
DATABASE credentials
MAIL credentials
```

These remain outside administrator-editable settings.

### Website Settings

Examples:

```text
Company name
Phone
Email
Address
Business hours
Social links
```

These may be managed through the Admin Portal.

---

# 37. Backup and Recovery Considerations

The Admin Portal itself does not manage infrastructure backups unless explicitly required.

However, critical administrative data must remain compatible with the application's backup strategy.

Important data includes:

* Website settings.
* Quotes.
* Administrator records.
* Audit records.

---

# 38. Logging Requirements

Application logs should capture important system failures without unnecessarily storing personal information.

Examples:

```text
Authentication failure
Authorization failure
Settings update failure
Quote operation failure
AI service failure
```

Audit logs and technical application logs should remain conceptually separate.

---

# 39. Testing Requirements

The Admin Portal must have automated tests covering:

### Authentication

* Login.
* Logout.
* Invalid login.
* Session behavior.

### Authorization

* Allowed action.
* Denied action.
* Role restrictions.

### Settings

* View.
* Update.
* Validation.
* Cache invalidation.

### Quotes

* List.
* Search.
* Filter.
* View.
* Status changes.

### Chatbot

* Access control.
* Settings.
* AI credential protection.

### Audit

* Required actions logged.

---

# 40. Browser Testing

The completed Admin Portal must be tested through realistic workflows.

Example:

```text id="4l7k72"
Login
 ↓
Dashboard
 ↓
Update Contact Information
 ↓
Verify Public Website
 ↓
Open Quotes
 ↓
Search Quote
 ↓
Open Quote
 ↓
Change Status
 ↓
Verify Audit Log
 ↓
Open Chatbot Settings
 ↓
Logout
```

---

# 41. Non-Functional Requirements

The Admin Portal must be:

### Secure

Unauthorized users must not access administrative information.

### Reliable

Administrative changes must not leave the system in an inconsistent state.

### Maintainable

The architecture must remain modular.

### Scalable

The portal must support increasing numbers of quotes and administrators.

### Accessible

The portal must remain usable with keyboard and assistive technology.

### Responsive

The interface must function across supported screen sizes.

### Performant

Common administrative tasks should respond efficiently.

---

# 42. Future Compatibility

The requirements should allow future addition of:

* Advanced roles.
* Quote assignment.
* Staff notes.
* Email management.
* CRM integration.
* Analytics.
* Notification management.
* Media management.
* CMS functionality.
* Advanced AI analytics.

These are not part of the initial implementation unless separately approved.

---

# 43. Requirements Priority

Requirements should be categorized as:

### Critical

Required for launch.

Examples:

* Authentication.
* Authorization.
* Settings management.
* Quote management.
* Security.
* Audit logging.

### Important

Required for a complete first version.

Examples:

* Dashboard.
* Chatbot management.
* Search/filtering.
* Responsive design.

### Future

Potential later enhancements.

Examples:

* Advanced analytics.
* CRM.
* Full CMS.
* Advanced reporting.

---

# 44. Definition of Success

The Admin Portal requirements are satisfied when:

✓ Authorized administrators can securely access the portal.

✓ Unauthorized users are blocked.

✓ Roles and permissions are enforced.

✓ Vital website information can be managed.

✓ Changes appear correctly on the public website.

✓ Quote submissions can be reviewed and managed.

✓ Chatbot settings can be safely controlled.

✓ Sensitive credentials remain protected.

✓ Important administrative actions are auditable.

✓ The interface works on desktop, tablet, and mobile.

✓ Accessibility requirements are satisfied.

✓ Security requirements are satisfied.

✓ Performance remains acceptable as data grows.

---

# 45. Next Document

The next document is:

```text
Documentation/17_Admin_Portal/03_Information_Architecture.md
```

This will define the Admin Portal navigation, page hierarchy, information organization, and administrator workflow before roles and permissions are finalized.
