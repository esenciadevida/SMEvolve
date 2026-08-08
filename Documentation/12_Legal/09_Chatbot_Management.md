# SMEvolve Admin Portal

## 09 – Chatbot Management

**Project:** SMEvolve

**Module:** Admin Portal

**Documentation Path:** `Documentation/17_Admin_Portal/`

**Framework:** Laravel 12

**Frontend:** Blade, Vite, Alpine.js

**Version:** 1.0

**Document Type:** Chatbot Management Functional & Technical Specification

---

# 1. Objective

Define the administrative management layer for the SMEvolve chatbot.

The chatbot itself has already been implemented as part of the SMEvolve platform.

This module provides authorized administrators with controlled visibility and operational controls over the existing chatbot system.

The Admin Portal must not duplicate the chatbot implementation.

---

# 2. Scope

The Chatbot Management module includes:

* Chatbot status.
* Operational configuration.
* Basic behavior configuration where supported.
* AI provider status.
* Model status.
* Usage visibility.
* Service health.
* Administrative controls.
* Conversation-related administration where required.
* Audit logging.
* Security controls.

It does not replace the existing chatbot frontend or AI service architecture.

---

# 3. Architecture

The architecture should remain:

```text
Public Chatbot
      ↓
Existing Chatbot Service
      ↓
AI / Knowledge / Application Services
      ↓
Admin Chatbot Management
```

The Admin Portal should interact with the existing chatbot services rather than create a second implementation.

---

# 4. Route

Recommended route:

```text id="w7k3p9"
/admin/chatbot
```

Named route:

```text id="f2m8x4"
admin.chatbot.index
```

Additional routes may be introduced for configuration actions where necessary.

---

# 5. Access Control

Recommended permissions:

```text id="c9q5v2"
chatbot.view
chatbot.update
chatbot.test
```

The exact permissions must remain consistent with the Admin Roles and Permissions architecture.

---

# 6. Chatbot Dashboard

The Chatbot Management page should provide a concise overview.

Recommended structure:

```text id="n6r3x8"
Chatbot Management
        ↓
Status
        ↓
Configuration
        ↓
AI Service
        ↓
Usage / Health
        ↓
Administrative Controls
```

---

# 7. Chatbot Status

The administrator should be able to see the current chatbot state.

Possible states:

```text id="k4p7m2"
Active
Disabled
Unavailable
Configuration Required
```

Status should be communicated through both text and visual indicators.

---

# 8. Active

`Active` means the chatbot is configured and available to public users.

Example:

```text id="s8x2q5"
● Active
The chatbot is available to visitors.
```

---

# 9. Disabled

`Disabled` means the chatbot has intentionally been switched off.

The public chatbot should respond according to the approved disabled-state behavior.

---

# 10. Unavailable

`Unavailable` indicates that the chatbot service cannot currently operate correctly.

Potential causes include:

* AI provider failure.
* Configuration failure.
* Service timeout.
* Dependency failure.

Technical details should not be exposed unnecessarily to public users.

---

# 11. Configuration Required

This state indicates that required chatbot or AI configuration is incomplete.

The administrator should receive a clear explanation of what action is required.

---

# 12. Enable / Disable Control

Authorized administrators may be able to enable or disable the chatbot.

The action requires:

```text id="m5v9c3"
chatbot.update
```

The backend must enforce the permission even if the UI control is hidden.

---

# 13. Disable Confirmation

Disabling the chatbot is a consequential operational action.

The UI should require confirmation.

Example:

```text id="x2q8n6"
Disable chatbot?

Visitors will no longer be able to use the chatbot.

[Cancel] [Disable]
```

---

# 14. Re-enable

Re-enabling should be straightforward.

Example:

```text id="p7m4r9"
Enable chatbot?
```

The system should verify that required dependencies are available before marking the chatbot operational.

---

# 15. AI Provider

The administrator may see the configured AI provider.

Example:

```text id="j8c3x6"
AI Provider
Groq
```

The provider name may be displayed.

---

# 16. AI Credentials

Raw AI credentials must never be displayed.

Do not show:

```text id="a6v9m2"
GROQ_API_KEY=...
```

Instead, show a safe status:

```text id="q4r7x1"
API Configuration
Configured
```

or:

```text id="n3k8p5"
API Configuration
Not Configured
```

---

# 17. Model Information

The administrator may see the currently configured model.

Example:

```text id="w5m2c8"
Model
Configured production model
```

The exact model name may be shown where operationally useful.

Model changes should require appropriate permission.

---

# 18. Model Changes

If model selection is exposed in the Admin Portal, only approved models should be available.

The administrator must not be able to enter arbitrary provider configuration that could create security or cost risks.

---

# 19. AI Configuration Validation

Before saving AI configuration, the system should validate:

* Provider.
* Model.
* Required configuration.
* Supported values.

The system should reject unsupported combinations.

---

# 20. AI Connection Test

Where supported, an authorized administrator may run a connection test.

Example:

```text id="h7p3m9"
[Test AI Connection]
```

The result should be:

```text id="e4x8q2"
Connection successful.
```

or:

```text id="v6c2k5"
Connection failed.
Please review the AI configuration.
```

Do not expose raw provider credentials or internal exception details.

---

# 21. AI Test Security

Connection tests must:

* Require authorization.
* Be rate limited.
* Avoid excessive AI usage.
* Avoid exposing secrets.
* Be auditable where appropriate.

---

# 22. Chatbot Configuration

The chatbot configuration interface may support approved operational settings.

Potential settings:

```text id="b8m4q7"
Enabled
Welcome Message
Maximum Message Length
Fallback Behavior
```

Only settings already supported by the chatbot architecture should be exposed.

---

# 23. Welcome Message

If the chatbot supports a configurable welcome message, administrators may update it.

The value must:

* Have a maximum length.
* Be validated.
* Be safely escaped.
* Support only approved formatting.

Do not permit arbitrary unsafe HTML.

---

# 24. Fallback Behavior

The system may provide controlled fallback behavior when the AI service is unavailable.

Example:

```text id="c5x9r2"
The assistant is currently unavailable.
Please contact our team for assistance.
```

Fallback messages should not reveal internal technical failures.

---

# 25. Maximum Message Length

If configurable, the administrator may set a maximum chatbot input length.

The value must have:

* Minimum allowed value.
* Maximum allowed value.
* Server-side validation.

This helps protect the AI service from abusive or excessive requests.

---

# 26. Knowledge / Content Boundary

If the existing chatbot uses a knowledge base, the Admin Portal may display its current status.

However, knowledge-base editing should not be introduced unless it is part of the existing chatbot architecture.

Potential status:

```text id="m7q2v5"
Knowledge Base
Available
```

---

# 27. Conversation Management

If conversation storage exists, the Admin Portal may provide appropriate administrative visibility.

Possible capabilities:

* Conversation count.
* Recent conversation activity.
* Conversation status.

The initial implementation should avoid unnecessary access to complete conversation transcripts.

---

# 28. Conversation Privacy

Chatbot conversations may contain personal information.

Administrative access to transcripts must therefore be permission-controlled.

Recommended permission:

```text id="x4n8c1"
chatbot.conversations.view
```

This should be separate from general chatbot management.

---

# 29. Conversation Deletion

Conversation deletion should not be exposed unless explicitly required.

If introduced later, deletion must account for:

* Data retention.
* Audit requirements.
* Privacy requirements.
* Legal obligations.

---

# 30. Usage Metrics

The chatbot dashboard may show basic operational metrics.

Examples:

```text id="z3q7m8"
Messages Today
Conversations Today
Messages This Month
```

These should be aggregate metrics rather than unnecessary personal data.

---

# 31. AI Usage Visibility

Where provider usage information is available, the system may display:

```text id="r5m2x9"
Requests
Tokens
Errors
```

Provider-specific billing information should not be assumed unless the provider integration explicitly supports it.

---

# 32. Health Status

The chatbot page should provide a high-level health state.

Potential states:

```text id="k8c4p1"
Healthy
Degraded
Unavailable
```

The health status should be based on meaningful application checks.

---

# 33. Health Check

A health check may verify:

```text id="n6x3r7"
Application Configuration
        ↓
Chatbot Service
        ↓
AI Provider
```

The health check should not unnecessarily generate expensive AI requests.

---

# 34. Error Monitoring

Operational failures should be recorded through the application's logging architecture.

The Admin Portal should present safe summaries rather than raw exceptions.

Example:

```text id="v7m2q5"
AI service experiencing connection problems.
```

Not:

```text id="s4x8c9"
GuzzleHttp\Exception\ConnectException ...
```

---

# 35. Rate Limiting

Administrative chatbot testing and configuration endpoints should be rate limited.

Public chatbot rate limiting remains part of the chatbot architecture itself.

The Admin Portal must not accidentally bypass public chatbot protections.

---

# 36. Audit Logging

Important chatbot administrative actions should be audited.

Examples:

```text id="p9c4m6"
Chatbot enabled
Chatbot disabled
Welcome message updated
Model configuration changed
AI connection tested
Chatbot configuration updated
```

---

# 37. Sensitive Audit Data

Audit records must not contain:

* API keys.
* Authentication credentials.
* Full sensitive conversation transcripts.
* Environment variables.

Record the action rather than the secret.

---

# 38. Configuration Update Flow

The standard flow should be:

```text id="f6q2x8"
Administrator
      ↓
Edit configuration
      ↓
Authorization
      ↓
Validation
      ↓
Chatbot Service
      ↓
Persist configuration
      ↓
Invalidate relevant cache
      ↓
Audit event
      ↓
Success
```

---

# 39. Configuration Persistence

Configuration should use the application's approved configuration/settings architecture.

Do not modify `.env` files through the Admin Portal.

Production secrets remain deployment-level configuration.

---

# 40. Cache Invalidation

If chatbot configuration is cached, changing a setting must automatically invalidate the relevant cache.

Administrators should not need shell access to clear caches.

---

# 41. Public Website Integration

Changes made through Chatbot Management should propagate safely to the existing public chatbot.

Example:

```text id="q5m8c3"
Admin updates welcome message
        ↓
Configuration saved
        ↓
Cache invalidated
        ↓
Public chatbot uses new message
```

---

# 42. Failure Safety

If a configuration update fails:

* The previous valid configuration should remain intact.
* The administrator should receive a clear error.
* The failure should be logged appropriately.

Avoid leaving the chatbot in a partially configured state.

---

# 43. Transaction Safety

Changes involving multiple configuration values should use appropriate transactional behavior.

For example:

```text id="x8p3m7"
Provider
Model
Status
```

should not be partially updated if the configuration operation fails.

---

# 44. Public Failure Behavior

If the chatbot becomes unavailable, the public interface should fail gracefully.

Visitors should receive a helpful fallback message rather than:

* Stack traces.
* Provider errors.
* Configuration details.
* Internal service information.

---

# 45. Accessibility

The Chatbot Management interface must provide:

* Semantic headings.
* Accessible form labels.
* Keyboard navigation.
* Visible focus states.
* Accessible status indicators.
* Accessible confirmation dialogs.
* Screen-reader-friendly feedback.

---

# 46. Responsive Design

The management interface must support:

### Desktop

Full configuration layout.

### Tablet

Reduced columns and stacked configuration groups.

### Mobile

Single-column configuration and accessible action controls.

---

# 47. Performance

The module should:

* Avoid unnecessary AI requests.
* Avoid polling by default.
* Use cached configuration where appropriate.
* Use aggregate usage queries.
* Load conversation data only when explicitly requested.

---

# 48. Security Requirements

The module must enforce:

✓ Authentication.

✓ Authorization.

✓ CSRF protection.

✓ Input validation.

✓ Output escaping.

✓ Rate limiting.

✓ Secret protection.

✓ Audit logging.

✓ Resource-level access control.

---

# 49. Acceptance Criteria

The module is accepted when:

✓ Authorized administrators can view chatbot status.

✓ Unauthorized users cannot access chatbot management.

✓ Authorized users can enable/disable the chatbot.

✓ Disable actions require confirmation.

✓ AI provider status is visible safely.

✓ Raw API credentials are never displayed.

✓ Approved model information can be displayed.

✓ AI configuration is validated.

✓ Connection testing is protected.

✓ Chatbot configuration is safely persisted.

✓ Cache invalidation works.

✓ Usage metrics are accurate where available.

✓ Health states are meaningful.

✓ Administrative changes are audited.

✓ Public chatbot behavior updates correctly.

✓ Failure states are safe.

✓ Mobile layout works.

✓ Accessibility requirements are satisfied.

---

# 50. Integration Requirements

Chatbot Management must integrate with:

```text id="r4m8x2"
Existing Chatbot
AI Service
Authentication
Authorization
Settings
Audit Log
Admin Dashboard
Logging
```

The module must reuse existing chatbot services rather than introduce duplicate AI logic.

---

# 51. Next Document

The next document is:

```text id="x7p3m9"
Documentation/17_Admin_Portal/10_Administrator_Management.md
```

This will define administrator account management, roles, account status, invitations/creation, disabling accounts, role changes, security restrictions, and administrative workflows.
