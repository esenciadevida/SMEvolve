# SMEvolve Admin Portal

## 12 – Notifications

**Project:** SMEvolve

**Module:** Admin Portal

**Documentation Path:** `Documentation/17_Admin_Portal/`

**Framework:** Laravel 12

**Frontend:** Blade, Vite, Alpine.js

**Version:** 1.0

**Document Type:** Notification System Functional & Technical Specification

---

# 1. Objective

Define the notification system for the SMEvolve Admin Portal.

The system should provide administrators with timely, relevant information about events requiring attention without overwhelming them with unnecessary alerts.

The notification architecture must be centralized and extensible so future notification channels can be introduced without redesigning the core system.

---

# 2. Scope

The initial notification system includes:

* New quote notifications.
* Quote status-related administrative notifications.
* System warnings.
* Chatbot status notifications.
* AI service notifications.
* Security-related notifications where appropriate.
* Read/unread state.
* Notification listing.
* Notification dismissal where appropriate.
* Permission-aware delivery.

It does not initially require:

* SMS notifications.
* WhatsApp notifications.
* Push notifications.
* Customer notification management.

These may be added later.

---

# 3. Architecture

The recommended architecture is:

```text id="e2q5r8"
Application Event
      ↓
Notification Service
      ↓
Notification Record
      ↓
Admin Portal
      ↓
Notification UI
```

Future channels can extend the architecture:

```text id="m7c3x9"
Notification
 ├── In-App
 ├── Email
 ├── SMS
 └── Push
```

---

# 4. Notification Route

The primary notification interface may use:

```text id="r4v8k2"
/admin/notifications
```

Named route:

```text id="x9m3p6"
admin.notifications.index
```

The notification dropdown may be available globally in the Admin Portal header.

---

# 5. Notification Permissions

Normal administrative notifications should follow the recipient's existing resource permissions.

For example:

```text id="c5q7n2"
New Quote
    ↓
Recipient requires
quotes.view
```

Security-sensitive notifications should only be delivered to appropriate administrators.

---

# 6. Notification Types

The initial system should support:

```text id="k8r2m5"
New Quote
Quote Attention
System Warning
Chatbot Alert
AI Alert
Security Alert
```

Additional notification types can be introduced later.

---

# 7. New Quote Notification

When a new quote is successfully submitted, an appropriate administrator may receive:

```text id="f4x9c7"
New quote received

Quote SME-2026-000124 is ready for review.
```

The notification should link directly to the quote where the recipient has permission.

---

# 8. Quote Attention

The system may notify administrators about quote conditions requiring attention.

Examples:

* New quote awaiting review.
* Quote approaching an internal follow-up threshold.
* Quote requiring action.

The initial implementation should only include conditions explicitly supported by the business workflow.

---

# 9. System Warning

System warnings should communicate important operational problems.

Examples:

```text id="v6p3m8"
AI service is unavailable.
```

or:

```text id="n5x8q2"
Required chatbot configuration is missing.
```

Warnings should be actionable.

---

# 10. Chatbot Alerts

The system may notify authorized administrators when the chatbot becomes unavailable or encounters an important operational condition.

Example:

```text id="q7m4c9"
Chatbot unavailable

The chatbot service requires attention.
```

Avoid sending repeated notifications for the same ongoing failure.

---

# 11. AI Alerts

AI service notifications may include:

* AI service unavailable.
* Configuration missing.
* Connection failure.
* Provider errors requiring administrative attention.

Notifications should not expose credentials or sensitive provider responses.

---

# 12. Security Alerts

Security notifications may include events such as:

* Suspicious administrative activity.
* Repeated failed administrator logins.
* Important account changes.
* Privileged role changes.

The exact security events should be defined by the application's security architecture.

---

# 13. Notification Data Structure

A conceptual notification record may contain:

```text id="b8m3x7"
id
recipient_id
type
title
message
action_url
read_at
created_at
```

Additional metadata may be stored where necessary.

---

# 14. Notification Model

The implementation should use Laravel's existing notification capabilities where they satisfy the requirements.

A custom notification table should not be created if the framework's database notification architecture already provides the required behavior.

---

# 15. Notification Title

Every notification should have a concise title.

Examples:

```text id="r6q2k8"
New Quote Received
AI Service Unavailable
Administrator Role Changed
Chatbot Disabled
```

Titles should quickly communicate the event.

---

# 16. Notification Message

The message should explain:

* What happened.
* Why it matters.
* What action may be required.

Keep messages concise.

Example:

```text id="c4x9p7"
Quote SME-2026-000124 was submitted and is waiting for review.
```

---

# 17. Notification Action

Where appropriate, a notification should provide a direct action.

Example:

```text id="m7q3v8"
View Quote →
```

The action URL must be generated using authorized application routes.

---

# 18. Authorization on Action URLs

A notification must never grant access to a resource.

For example, if a user receives:

```text id="x5p8k2"
/admin/quotes/123
```

the quote endpoint must still perform normal authorization.

---

# 19. Read State

Notifications should support:

```text id="n4r7c3"
Unread
Read
```

Unread notifications may be visually emphasized.

Color must not be the only indicator.

---

# 20. Mark as Read

Administrators should be able to mark a notification as read.

Possible behavior:

```text id="v8m2q5"
Open notification
      ↓
Mark as read
      ↓
Navigate to resource
```

The exact behavior should remain consistent throughout the interface.

---

# 21. Mark All as Read

The notification page may provide:

```text id="p6x3r9"
Mark all as read
```

This action should only affect notifications belonging to the authenticated administrator.

---

# 22. Unread Count

The Admin Portal header may display an unread notification count.

Example:

```text id="z7q4m1"
Notifications  ● 3
```

The count should be retrieved efficiently.

Avoid querying every notification record on every page request.

---

# 23. Notification Dropdown

The global header may provide a compact notification dropdown.

Recommended structure:

```text id="h8c5x2"
Notifications
──────────────
New quote received
5 minutes ago

AI service unavailable
1 hour ago

View all notifications →
```

Only a limited number of recent notifications should be displayed.

---

# 24. Notification Page

The full notification page should provide:

* Notification list.
* Read/unread state.
* Date/time.
* Action links.
* Mark-as-read actions.
* Mark-all-as-read action.

---

# 25. Pagination

The full notification list must be paginated.

Do not load a user's entire notification history into memory.

---

# 26. Notification Filtering

The initial version does not require advanced filtering.

A future implementation may support:

* Type.
* Read/unread.
* Date.

Keep the first version simple.

---

# 27. Dismissal

Dismissal is different from marking a notification as read.

The initial system does not require permanent dismissal unless there is a clear operational need.

If introduced, dismissal must be scoped to the current administrator.

---

# 28. Duplicate Notifications

The notification system should avoid generating unnecessary duplicates.

For example, if an AI service remains unavailable for several minutes, the system should not generate a new notification every few seconds.

Notification generation should support deduplication or throttling where appropriate.

---

# 29. Notification Frequency

Notifications should be event-driven rather than polling-driven where possible.

Preferred:

```text id="s3m8q7"
Quote Created
      ↓
Event
      ↓
Notification
```

Avoid:

```text id="c7x2n5"
Every 10 seconds
      ↓
Check database
      ↓
Maybe notify
```

---

# 30. Notification Queue

Notifications that require external delivery, such as email, should use Laravel's queue infrastructure where appropriate.

In-app database notifications may be created synchronously when the operation is simple and reliability is acceptable.

---

# 31. Email Notifications

Email notifications are outside the minimum in-app notification scope.

However, the architecture should allow future email delivery.

Example:

```text id="k4p9r2"
Notification
      ↓
In-App
      +
Email
```

without changing the originating business event.

---

# 32. Notification Preferences

The initial version does not require a complete per-administrator notification preference system.

A future preference system may allow administrators to control:

* Email alerts.
* Quote alerts.
* System alerts.
* AI alerts.

---

# 33. Critical Notifications

Certain events may be considered critical.

Examples:

```text id="x6m3q8"
Security Alert
AI service unavailable
Chatbot disabled unexpectedly
```

Critical notifications should not be silently suppressed by ordinary preferences if they are essential to system operation.

---

# 34. Notification Priority

The system may support:

```text id="r5c8n2"
Informational
Warning
Critical
```

Priority should influence presentation but should not rely solely on color.

---

# 35. Notification Expiration

Some notifications may become irrelevant after a period.

For example:

```text id="m2q7x4"
Temporary system warning
```

The initial implementation does not require automatic expiration unless necessary.

If introduced, expiration must not destroy audit information.

---

# 36. Notification Data Privacy

Notifications should contain the minimum information required.

For example:

```text id="b9v4k6"
New quote received: SME-2026-000124
```

is preferable to embedding the customer's complete contact information.

---

# 37. Notification Security

Notifications must not expose:

* Passwords.
* API keys.
* Authentication tokens.
* Private system configuration.
* Unnecessary customer information.

---

# 38. Notification URL Security

Action URLs should use named routes and signed URLs only where appropriate.

Do not construct unsafe URLs directly from user-controlled values.

---

# 39. Notification Service

Notification creation should be centralized through the application's notification architecture.

Recommended conceptual flow:

```text id="w3p7m9"
Business Event
      ↓
Notification Service
      ↓
Determine recipients
      ↓
Check permissions
      ↓
Create notification
```

---

# 40. Recipient Selection

Recipients should be determined based on:

* Role.
* Permissions.
* Responsibility.
* Notification type.

For example:

```text id="q8m4x2"
New Quote
   ↓
Administrators with quotes.view
```

The system should avoid notifying every administrator indiscriminately.

---

# 41. Notification Ownership

Each in-app notification must belong to a specific administrator recipient.

One administrator marking a notification as read must not mark another administrator's copy as read.

---

# 42. Notification Creation Failure

Failure to create a non-critical notification should not normally cause the primary business transaction to fail.

Example:

```text id="c5r8m1"
Quote submission
      ↓
Quote successfully saved
      ↓
Notification creation fails
```

The quote should normally remain successfully created while the notification failure is logged.

Critical operational alerts may require different handling.

---

# 43. Notification Logging

Notification failures should be logged through the application's standard logging system.

Do not expose raw exception details to administrators.

---

# 44. Accessibility

The notification interface must provide:

* Accessible notification labels.
* Screen-reader-friendly unread state.
* Keyboard navigation.
* Visible focus states.
* Accessible action links.
* Accessible status messages.

Example:

```text id="n7x3q5"
"3 unread notifications"
```

should be available to assistive technology.

---

# 45. Responsive Design

### Desktop

Notification dropdown and full notification page.

### Tablet

Responsive dropdown and notification list.

### Mobile

Notifications should remain easily accessible from the global navigation.

---

# 46. Performance

The notification system should:

* Efficiently count unread notifications.
* Limit dropdown results.
* Paginate full notification history.
* Avoid unnecessary polling.
* Use indexes on recipient/read state/time.
* Queue expensive external notifications.

---

# 47. Cleanup

Old read notifications may eventually be cleaned up according to an approved retention policy.

The initial implementation should not automatically delete notification records without a defined policy.

---

# 48. Acceptance Criteria

The Notification module is accepted when:

✓ New quote notifications can be generated.

✓ Relevant administrators receive appropriate notifications.

✓ Notifications respect permissions.

✓ Notifications have read/unread states.

✓ Unread count works.

✓ Notification dropdown works.

✓ Full notification page works.

✓ Notifications can be marked as read.

✓ Mark-all-as-read works.

✓ Notification actions respect authorization.

✓ Duplicate notifications are controlled.

✓ Sensitive data is not exposed.

✓ Notification failures are handled safely.

✓ Responsive layouts work.

✓ Accessibility requirements are satisfied.

---

# 49. Integration Requirements

Notifications must integrate with:

```text id="v6m2r8"
Quote Management
Admin Dashboard
Administrator Management
Chatbot Management
AI Services
Authentication
Authorization
Audit Log
Laravel Queue / Mail Infrastructure
```

The system should use a centralized notification architecture rather than independent notification logic in each module.

---

# 50. Next Document

The next document is:

```text id="7xq3m1"
Documentation/17_Admin_Portal/13_Admin_Profile.md
```

This will define the authenticated administrator's own profile management, including profile information, password management, security controls, session visibility, and account preferences.
