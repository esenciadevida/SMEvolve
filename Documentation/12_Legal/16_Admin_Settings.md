# SMEvolve Admin Portal

## 16 – Admin Settings

**Project:** SMEvolve

**Module:** Admin Portal

**Documentation Path:** `Documentation/17_Admin_Portal/`

**Framework:** Laravel 12

**Frontend:** Blade, Vite, Alpine.js

**Version:** 1.0

**Document Type:** Administrative Settings & Configuration Specification

---

# 1. Objective

Define the centralized settings architecture for the SMEvolve Admin Portal.

The settings system allows authorized administrators to manage approved application configuration without modifying source code or deployment environment variables.

The architecture must clearly separate:

* Editable business configuration.
* Application configuration.
* Security configuration.
* Secrets.
* Environment variables.

Not every configuration value should be exposed through the Admin Portal.

---

# 2. Scope

The initial settings module includes:

* General settings.
* Business information.
* Contact information.
* Website settings.
* Quote-related settings where applicable.
* Notification settings.
* Chatbot settings where appropriate.
* Approved integration settings.
* Settings validation.
* Settings audit logging.

It does not provide direct management of:

* Environment variables.
* Database credentials.
* API secrets.
* Server configuration.
* Deployment configuration.

---

# 3. Route

Recommended route:

```text id="c7m4x9"
/admin/settings
```

Named route:

```text id="p8q3v6"
admin.settings.index
```

Additional section routes may be introduced only if needed.

Prefer a centralized settings interface over unnecessary separate pages.

---

# 4. Access Control

Settings must be permission-aware.

Recommended permissions:

```text id="x5m8r2"
settings.view
settings.update
settings.manage_integrations
```

Sensitive settings may require additional permissions.

---

# 5. Settings Categories

Recommended categories:

```text id="n4q7c8"
General
Business
Contact
Website
Quotes
Notifications
Chatbot
Integrations
```

Only categories supported by the actual application should be displayed.

---

# 6. General Settings

General settings may include:

* Application name.
* Business display name.
* Default language where supported.
* Default timezone where appropriate.

The settings should use the project's existing configuration architecture.

---

# 7. Business Information

Business settings may include:

```text id="v6m3x8"
Business Name
Business Description
Business Address
Business Registration Information
```

Only information required by the application should be stored.

---

# 8. Contact Information

Contact settings may include:

```text id="r5q8m2"
Primary Email
Phone Number
WhatsApp Number
Business Address
```

These values may be consumed by:

* Website footer.
* Contact page.
* Quote communication.
* Notifications.

---

# 9. Website Settings

Approved website settings may include:

* Site title.
* Default metadata.
* Support contact.
* Footer information.

SEO-specific configuration should continue to use the global SEO architecture.

---

# 10. Quote Settings

If supported by the Quote Management module, configurable settings may include:

* Quote response message.
* Default quote validity period.
* Internal notification behavior.
* Approved business contact information.

Quote workflow rules should not be duplicated here if they already belong to Quote Management.

---

# 11. Notification Settings

Administrative notification settings may include approved configuration such as:

* Notification recipient rules.
* Email notification enablement.
* System alert configuration.

Personal notification preferences belong to the Admin Profile module.

---

# 12. Chatbot Settings

Approved chatbot settings may include:

* Enable/disable state.
* Display configuration.
* Approved chatbot behavior settings.
* Business contact information used by the chatbot.

Actual chatbot architecture and AI configuration remain under the Chatbot module.

---

# 13. Integration Settings

Integration settings may include non-secret configuration such as:

```text id="m7x3q9"
Provider
Endpoint
Environment
Feature Enabled
```

Sensitive credentials must not be treated as ordinary settings.

---

# 14. Secrets

The Admin Settings interface must never expose raw secrets such as:

* API keys.
* Private keys.
* Database passwords.
* OAuth client secrets.
* Authentication tokens.

If secret management is required, it should use a dedicated secure mechanism.

---

# 15. Environment Variables

The Admin Portal must not provide a generic interface for editing `.env` values.

For example, administrators must not be able to submit:

```text id="q8c4m2"
APP_KEY
DB_PASSWORD
AWS_SECRET_ACCESS_KEY
```

through a generic settings form.

These remain deployment/infrastructure configuration.

---

# 16. Configuration Boundaries

The architecture should distinguish:

```text id="x4m7p8"
Admin Settings
    ↓
Business/application configuration

Environment
    ↓
Infrastructure/secrets

Code Configuration
    ↓
Developer-defined behavior
```

This prevents unsafe configuration exposure.

---

# 17. Settings Storage

A database-backed settings architecture may be used for administrator-editable values.

A conceptual structure may include:

```text id="n6r3x9"
key
value
type
group
description
updated_by
updated_at
```

The actual implementation should follow the existing application's data architecture.

---

# 18. Typed Settings

Settings should preserve their expected data type.

Examples:

```text id="v5q8m3"
Boolean
String
Integer
URL
Email
JSON
```

The system must not treat every value as arbitrary plaintext.

---

# 19. Validation

Every editable setting must have appropriate validation.

Examples:

### Email

```text id="c7m4x2"
Valid email address
```

### URL

```text id="p8x3n6"
Valid HTTPS/HTTP URL where permitted
```

### Boolean

```text id="r5m7q9"
true / false
```

### Integer

```text id="x4c8m2"
Valid numeric range
```

---

# 20. Settings Form

The interface should display:

* Setting label.
* Current value.
* Description.
* Validation requirements.
* Save action.

Example:

```text id="n7q3v8"
Primary Contact Email

The email address displayed to customers.

[ admin@example.com ]

[Save Changes]
```

---

# 21. Sensitive Settings UI

Where a sensitive configuration value must be managed, do not display its existing value in plaintext.

Prefer:

```text id="m4x8c2"
API Key
••••••••••••

[Replace Key]
```

The backend should ensure the value is never accidentally returned to the browser.

---

# 22. Secret Rotation

If secret management is eventually required, support replacement rather than retrieval.

Example:

```text id="v8q3m5"
Existing Secret
      ↓
Replace
      ↓
New Secret
      ↓
Secure Storage
```

Administrators should not be able to reveal the previous secret.

---

# 23. Setting Updates

The update flow should be:

```text id="x6m2r8"
Administrator
      ↓
Edit Setting
      ↓
Authorization
      ↓
Validation
      ↓
Save
      ↓
Audit Event
      ↓
Success
```

---

# 24. Authorization Per Setting

High-impact settings may require stronger permissions.

For example:

```text id="q7m4x9"
settings.view
        ↓
View general settings

settings.update
        ↓
Update general settings

settings.manage_integrations
        ↓
Manage approved integrations
```

---

# 25. Self-Service vs System Settings

Personal settings should not be duplicated in the global Admin Settings.

For example:

```text id="c5x8m3"
Admin Profile
→ Personal notification preferences

Admin Settings
→ Global notification configuration
```

---

# 26. Audit Logging

Every meaningful settings change should generate an audit event.

Example:

```text id="r8m2q6"
Event:
settings.updated

Setting:
contact.primary_email

Previous:
old@example.com

New:
new@example.com
```

Sensitive values must be masked or omitted.

---

# 27. Audit Privacy

Never include:

* Passwords.
* API keys.
* Tokens.
* Private keys.
* Full secret values.

Audit logs should identify that a secret was changed without exposing it.

Example:

```text id="v4x7n2"
AI API credential updated.
```

---

# 28. Configuration Cache

If settings are cached, updating a setting must invalidate the relevant cache.

Example:

```text id="m8q3c5"
Save Setting
      ↓
Database Updated
      ↓
Cache Invalidated
      ↓
Application Reads New Value
```

---

# 29. Configuration Consistency

The application must have a clear source of truth.

Avoid situations where:

```text id="x6r2p8"
Database Setting
       +
.env Setting
       +
Hardcoded Setting
```

all attempt to control the same behavior without a documented precedence rule.

---

# 30. Application Restart

Settings should not require an application restart unless they control infrastructure-level behavior.

Database-backed business settings should take effect according to the application's caching strategy.

---

# 31. Settings Reset

A generic "Reset All Settings" action should not be provided.

Resetting settings could cause significant operational problems.

Individual settings may provide a safe default reset only where explicitly supported.

---

# 32. Confirmation

Confirmation should be used for high-impact changes.

Examples:

* Disabling chatbot.
* Changing critical notification configuration.
* Replacing integration credentials.
* Changing important business configuration.

---

# 33. Success Messages

Examples:

```text id="q4m8x3"
Settings updated successfully.
```

For specific sections:

```text id="r7c2n5"
Contact settings updated successfully.
```

---

# 34. Error Handling

Errors should be safe and actionable.

Example:

```text id="m5x8q2"
The contact email address is invalid.
```

Do not display:

```text id="v3q7c9"
SQLSTATE...
```

or stack traces.

---

# 35. Settings Dependencies

Some settings may depend on others.

For example:

```text id="n8m4x6"
Chatbot Enabled
      ↓
Chatbot Configuration Required
```

The UI should clearly communicate dependencies.

The backend must validate them as well.

---

# 36. Disabled Features

If a module is not installed or enabled, its settings should not appear as if they are functional.

Example:

```text id="c6r2m8"
Chatbot module unavailable
```

The system should avoid exposing controls that cannot work.

---

# 37. Settings Search

The global Admin Search may index setting names that the administrator is authorized to view.

It must never index secret values.

---

# 38. Accessibility

The settings interface must provide:

* Semantic headings.
* Proper labels.
* Descriptive help text.
* Keyboard navigation.
* Visible focus states.
* Accessible switches.
* Accessible validation messages.

Boolean settings must not rely solely on color.

---

# 39. Responsive Design

### Desktop

Use grouped settings sections.

### Tablet

Maintain readable form widths.

### Mobile

Use a single-column layout with accessible controls.

Long descriptions should wrap naturally without causing horizontal scrolling.

---

# 40. Performance

Settings pages should:

* Load only relevant configuration.
* Avoid unnecessary queries.
* Avoid loading secrets.
* Use caching where appropriate.
* Avoid unnecessary JavaScript.

---

# 41. Security

The settings module must enforce:

✓ Authentication.

✓ Authorization.

✓ CSRF protection.

✓ Server-side validation.

✓ Safe output escaping.

✓ Secret protection.

✓ Audit logging.

✓ Permission-aware settings.

✓ No generic `.env` editing.

✓ No raw credential exposure.

---

# 42. Controller

Recommended controller:

```text id="p7m3x9"
AdminSettingsController
```

Responsibilities:

* Load permitted settings.
* Validate updates.
* Save configuration.
* Trigger cache invalidation.
* Record appropriate audit events.

The controller should remain lightweight.

---

# 43. Settings Service

A dedicated service may centralize settings operations.

Recommended abstraction:

```text id="x4q8m2"
SettingsService
```

Responsibilities may include:

* Get setting.
* Update setting.
* Validate type.
* Clear relevant cache.
* Apply defaults.

---

# 44. Component Architecture

Recommended components:

```text id="n5c7r3"
components/admin/settings/
├── section.blade.php
├── field.blade.php
├── toggle.blade.php
└── secret-field.blade.php
```

Actual component naming should follow the project's established architecture.

---

# 45. Integration Requirements

The Admin Settings module integrates with:

```text id="v8m3q6"
Admin Dashboard
Administrator Management
Audit Log
Notifications
Quote Management
Chatbot
AI Services
SEO
Global Configuration
```

It must reuse existing services instead of duplicating configuration logic.

---

# 46. Acceptance Criteria

The module is accepted when:

✓ Authorized administrators can access settings.

✓ Unauthorized administrators cannot modify restricted settings.

✓ Settings are grouped logically.

✓ Editable values are validated.

✓ Typed settings are handled correctly.

✓ Settings changes are persisted.

✓ Relevant caches are invalidated.

✓ Settings changes are audited.

✓ Secrets are never exposed.

✓ `.env` values cannot be edited through the portal.

✓ High-impact changes use confirmation where appropriate.

✓ Settings dependencies are enforced.

✓ Search does not expose secret values.

✓ Responsive layouts work.

✓ Accessibility requirements are satisfied.

✓ Errors are safely handled.

---

# 47. Future Recommendations

Potential future enhancements:

* Settings version history.
* Configuration rollback.
* Advanced integration management.
* Secret-management integration.
* Environment-specific configuration visibility.
* Settings import/export.
* Configuration validation dashboard.
* Approval workflow for high-risk settings.

Any future import/export functionality must exclude secrets by default.

---

# 48. Next Document

The next document is:

```text id="q6m9x3"
Documentation/17_Admin_Portal/17_Admin_Notifications_Email.md
```

This will define the administrative email-notification layer, including transactional admin emails, recipient resolution, templates, queueing, delivery failures, security, preferences, and integration with the in-app notification system.
