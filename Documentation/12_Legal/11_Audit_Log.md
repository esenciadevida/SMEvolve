# SMEvolve Admin Portal

## 11 – Audit Log

**Project:** SMEvolve

**Module:** Admin Portal

**Documentation Path:** `Documentation/17_Admin_Portal/`

**Framework:** Laravel 12

**Frontend:** Blade, Vite, Alpine.js

**Version:** 1.0

**Document Type:** Audit Logging & Security Specification

---

# 1. Objective

Define the centralized audit logging system for the SMEvolve Admin Portal.

The Audit Log provides a reliable record of important administrative and security-sensitive actions.

It should answer:

* Who performed an action?
* What happened?
* What resource was affected?
* When did it happen?
* What was the result?

The system must support accountability, troubleshooting, security investigations, and operational traceability without storing unnecessary sensitive information.

---

# 2. Scope

The Audit Log covers administrative events such as:

* Authentication events.
* Administrator management.
* Role changes.
* Settings changes.
* Quote status changes.
* Chatbot configuration changes.
* AI configuration changes.
* Other security-sensitive administrative actions.

It is not intended to replace:

* Application logs.
* Server logs.
* Error monitoring.
* Database backups.

---

# 3. Architecture

The recommended architecture is:

```text
Admin Action
     ↓
Authorization
     ↓
Business Operation
     ↓
Audit Service
     ↓
Audit Record
     ↓
Audit Database
     ↓
Admin Audit Interface
```

Audit recording should be centralized rather than implemented independently inside every controller.

---

# 4. Audit Route

Recommended route:

```text
/admin/audit
```

Named route:

```text
admin.audit.index
```

A detail route may be introduced if individual audit events require dedicated viewing.

---

# 5. Access Control

Recommended permission:

```text
audit.view
```

Only administrators with appropriate audit access should be able to view audit records.

The ability to view audit logs should not automatically grant permission to modify the underlying resource.

---

# 6. Immutable Records

Audit records should be treated as append-only.

Administrators should not be able to:

* Edit audit records.
* Change timestamps.
* Change actors.
* Rewrite historical actions.
* Delete individual events through the normal Admin Portal.

This preserves audit integrity.

---

# 7. Audit Event Structure

A conceptual audit record may contain:

```text
id
actor_id
event
resource_type
resource_id
description
metadata
ip_address
user_agent
created_at
```

The exact schema should follow the project's database architecture.

---

# 8. Actor

The actor identifies the administrator or system process responsible for an action.

Example:

```text
Actor:
Admin User
```

If an automated system event is recorded, it should clearly identify itself as a system event rather than pretending to be a human administrator.

---

# 9. Event Name

Events should use predictable identifiers.

Examples:

```text
admin.login
admin.logout
admin.created
admin.disabled
admin.reactivated
admin.role_changed

quote.status_changed

settings.updated

chatbot.enabled
chatbot.disabled
chatbot.configuration_updated

ai.configuration_updated
```

The final naming convention should remain consistent across the application.

---

# 10. Resource

An audit event should identify the affected resource when applicable.

Example:

```text
Resource:
Quote
Reference:
SME-2026-000124
```

For a site-wide setting:

```text
Resource:
Site Setting
Key:
contact.primary_phone
```

---

# 11. Timestamp

Every audit event must have a reliable timestamp.

The system should store timestamps consistently and apply the application's defined timezone strategy for display.

---

# 12. Result

Where useful, an event may identify the result.

Possible values:

```text
Success
Failed
Denied
```

This is particularly useful for security-sensitive operations.

---

# 13. Failed Actions

Important failed administrative actions may be logged.

Examples:

```text
Unauthorized role change attempt
Failed administrator login
Rejected privileged operation
```

However, failed events must not contain sensitive request information.

---

# 14. Authentication Events

The audit system may record:

* Successful admin login.
* Failed login.
* Logout.
* Password reset request.
* Account activation.
* Account disabling.

Authentication logging should follow the project's security and privacy requirements.

---

# 15. Administrator Events

Record important administrator management actions:

```text
Administrator created
Administrator disabled
Administrator reactivated
Administrator role changed
Administrator email changed
```

---

# 16. Role Changes

Role changes should contain sufficient information to establish what changed.

Example:

```text
Actor: Super Admin
Target: Admin User
Action: Role changed
Previous Role: Editor
New Role: Administrator
```

Never store authentication credentials in the audit metadata.

---

# 17. Quote Events

Important quote events include:

```text
Quote status changed
Internal note added
```

Additional events may be introduced if required.

The original customer submission should not be copied into every audit event.

---

# 18. Settings Events

Important settings changes should be recorded.

Example:

```text
Event:
settings.updated

Setting:
contact.primary_phone
```

For sensitive settings, the audit record should identify the setting without exposing its complete value.

---

# 19. Chatbot Events

Record actions such as:

```text
Chatbot enabled
Chatbot disabled
Chatbot configuration updated
Welcome message updated
AI connection tested
```

---

# 20. AI Events

AI configuration changes should be auditable.

Example:

```text
AI provider changed
AI model changed
AI configuration updated
```

Do not store:

```text
API keys
Tokens
Secrets
```

---

# 21. Sensitive Metadata

Audit metadata must be carefully controlled.

Never record:

* Passwords.
* Password hashes.
* API keys.
* Authentication tokens.
* Session secrets.
* Environment variables.
* Full sensitive request payloads.

---

# 22. Before and After Values

For suitable configuration changes, before/after values may be recorded.

Example:

```text
Previous:
example@old-domain.com

New:
example@new-domain.com
```

However, sensitive fields should be masked or omitted.

---

# 23. IP Address

The system may record the originating IP address for security-sensitive administrative actions.

This can help investigate suspicious access.

The exact retention and privacy treatment should follow the project's data protection requirements.

---

# 24. User Agent

The system may record the browser/user-agent information associated with an administrative event where useful for security investigation.

This should not be collected unnecessarily for every low-value event if storage minimization is preferred.

---

# 25. Audit Description

Every event should have a human-readable description.

Example:

```text
Admin User changed the quote status from New to Under Review.
```

Descriptions should remain concise.

---

# 26. Audit List

The Admin Audit page should display a structured list.

Recommended fields:

| Field         | Description           |
| ------------- | --------------------- |
| Date          | Event timestamp       |
| Administrator | Actor                 |
| Action        | Event                 |
| Resource      | Affected object       |
| Result        | Success/Denied/Failed |

---

# 27. Audit Search

Administrators with audit access should be able to search audit records.

Searchable fields may include:

* Administrator.
* Event.
* Resource.
* Resource ID.
* Description.

Search must be implemented efficiently.

---

# 28. Audit Filters

Recommended filters:

```text
Administrator
Event Type
Resource Type
Result
Date Range
```

The initial interface should remain focused rather than exposing every possible filter.

---

# 29. Date Range

Useful presets may include:

```text
Today
Last 7 Days
Last 30 Days
This Month
Custom Range
```

The final options should follow the project's common filtering components.

---

# 30. Sorting

Default:

```text
Newest first
```

The audit system should prioritize chronological review.

Older records should remain accessible through pagination and filtering.

---

# 31. Pagination

Audit logs must be paginated.

Do not load the complete audit history into memory or send it to the browser.

---

# 32. Audit Detail

Where individual event inspection is useful, the system may provide a detail view.

A detail view may show:

```text
Actor
Event
Resource
Timestamp
Result
IP Address
User Agent
Safe Metadata
```

Sensitive information must remain hidden.

---

# 33. Audit Integrity

Audit records should be protected from unauthorized modification.

The application should not expose generic CRUD operations for audit records.

The intended model is:

```text
Create → Read
```

rather than:

```text
Create → Read → Update → Delete
```

---

# 34. Audit Service

Audit creation should be centralized.

Recommended abstraction:

```text
AuditService
```

Example conceptual usage:

```text
AuditService::record(...)
```

The implementation should follow the project's existing service architecture.

---

# 35. Event Recording

Business operations should record audit events after successful state changes.

Example:

```text
Update Quote
      ↓
Transaction succeeds
      ↓
Record Audit Event
```

The system must avoid creating misleading "successful" audit events for operations that ultimately failed.

---

# 36. Transaction Handling

Where appropriate, the business operation and audit event should be transactionally consistent.

For example:

```text
Database Update
      +
Audit Record
```

should not produce an audit event claiming success if the actual database update was rolled back.

The final implementation should choose an appropriate Laravel transaction/event strategy.

---

# 37. Audit Failure

Audit failure handling must be deliberate.

For critical security events, failure to create an audit record may need to affect whether the operation succeeds.

For lower-risk events, the application may log the audit failure without blocking the underlying action.

This distinction should be documented in implementation decisions.

---

# 38. Audit Retention

Audit records should be retained according to the project's operational, legal, and privacy requirements.

The initial implementation should not introduce automatic deletion without an approved retention policy.

---

# 39. Audit Cleanup

If retention-based cleanup is introduced later, it must:

* Be automated.
* Be documented.
* Be auditable.
* Respect legal requirements.
* Avoid deleting records needed for active investigations.

---

# 40. Privacy

Audit logging must follow data minimization.

Only information necessary for:

* Accountability.
* Security.
* Troubleshooting.
* Compliance.

should be stored.

Do not copy complete customer records into audit metadata.

---

# 41. Quote Privacy

For quote-related events, audit logs should generally store:

```text
Quote Reference
Action
Administrator
Timestamp
```

rather than duplicating:

```text
Customer Address
Phone
Email
Project Details
```

unless specifically required.

---

# 42. Audit Access Restrictions

Audit access itself should be auditable.

For example:

```text
Admin User
Viewed audit log
```

may be recorded where appropriate.

This is particularly useful for highly sensitive administrative environments.

---

# 43. Security

The audit system must protect against:

* Unauthorized viewing.
* Audit record modification.
* Sensitive information leakage.
* Injection through event descriptions.
* Excessive data collection.

Audit descriptions and metadata must be safely rendered.

---

# 44. XSS Protection

Audit metadata may originate from administrator-controlled values.

Therefore, Blade output must be escaped safely.

Never assume audit metadata is trusted merely because it was generated by the application.

---

# 45. Performance

The audit system should:

* Use indexed timestamps.
* Index actor IDs where appropriate.
* Index event types.
* Paginate results.
* Avoid expensive joins for the main list.
* Avoid loading unnecessary metadata.

---

# 46. Large Audit Volumes

The architecture should support growth.

If the audit table becomes large, future improvements may include:

* Database partitioning.
* Archival.
* Specialized log storage.
* Retention jobs.

These are not required for the initial implementation.

---

# 47. Empty State

If no audit events exist:

```text
No audit activity yet.
```

If filters return no records:

```text
No audit events match your filters.
```

---

# 48. Error State

If the audit page cannot load:

```text
We couldn't load the audit activity.
Please try again.
```

Do not expose database errors or stack traces.

---

# 49. Accessibility

The Audit Log interface must provide:

* Semantic headings.
* Accessible tables.
* Keyboard navigation.
* Visible focus states.
* Accessible filters.
* Screen-reader-friendly status labels.
* Proper pagination controls.

---

# 50. Responsive Design

### Desktop

Use a structured audit table.

### Tablet

Allow appropriate horizontal scrolling or responsive restructuring.

### Mobile

Use stacked event cards where necessary.

The most important information should remain visible without excessive horizontal scrolling.

---

# 51. Export

Audit export is not required for the initial implementation.

If introduced later, it must:

* Require explicit permission.
* Be audited.
* Respect privacy.
* Apply appropriate filtering.
* Avoid exporting secrets.

---

# 52. Audit API

The initial system does not require a public audit API.

If an internal API is later introduced, it must use the same authorization and audit rules.

Audit records must never be exposed publicly.

---

# 53. Acceptance Criteria

The Audit Log is accepted when:

✓ Important administrative actions generate audit events.

✓ Events identify the responsible actor.

✓ Events contain reliable timestamps.

✓ Relevant resources are identified.

✓ Audit records are treated as immutable.

✓ Unauthorized users cannot view audit logs.

✓ Audit records can be searched.

✓ Audit records can be filtered.

✓ Audit records can be paginated.

✓ Sensitive information is excluded.

✓ Role changes are recorded.

✓ Settings changes are recorded.

✓ Quote status changes are recorded.

✓ Chatbot changes are recorded.

✓ AI configuration changes are recorded.

✓ Security-sensitive failures can be recorded.

✓ Audit data is safely rendered.

✓ Mobile and desktop layouts work.

✓ Accessibility requirements are satisfied.

---

# 54. Integration Requirements

The Audit Log integrates with:

```text
Authentication
Authorization
Administrator Management
Site Settings
Quote Management
Chatbot Management
AI Configuration
Admin Dashboard
```

All modules should use the centralized audit architecture instead of creating independent logging systems.

---

# 55. Next Document

The next document is:

```text
Documentation/17_Admin_Portal/12_Notifications.md
```

This will define administrative notifications and alerts, including new quote notifications, system warnings, chatbot/AI alerts, notification states, read/unread behavior, permissions, and future extensibility.
