# SMEvolve Admin Portal

## 14 – Admin Dashboard

**Project:** SMEvolve

**Module:** Admin Portal

**Documentation Path:** `Documentation/17_Admin_Portal/`

**Framework:** Laravel 12

**Frontend:** Blade, Vite, Alpine.js

**Version:** 1.0

**Document Type:** Dashboard Functional & UX Specification

---

# 1. Objective

Define the main dashboard for the SMEvolve Admin Portal.

The dashboard should provide administrators with a concise operational overview immediately after authentication.

It should answer:

* What requires attention?
* What is happening today?
* Are important services healthy?
* What recent activity occurred?
* What actions can I take quickly?

The dashboard must remain focused and should not become a duplicate of every Admin Portal module.

---

# 2. Scope

The dashboard includes:

* KPI summary.
* Quote activity.
* Pending actions.
* Notifications.
* System health.
* Chatbot/AI status.
* Recent administrative activity.
* Quick actions.
* Permission-aware widgets.

It does not replace dedicated management pages.

---

# 3. Route

Recommended route:

```text id="q6m2x8"
/admin
```

Named route:

```text id="r4v9c3"
admin.dashboard
```

If the project already defines an Admin Portal home route, the existing route should be reused.

---

# 4. Dashboard Architecture

Recommended structure:

```text id="m8x3p7"
Admin Dashboard
      ↓
Summary
      ↓
Attention Required
      ↓
Operational Health
      ↓
Activity
      ↓
Quick Actions
```

---

# 5. Permission-Aware Dashboard

Dashboard widgets must respect administrator permissions.

For example:

```text id="v5c8q2"
quotes.view
    ↓
Show Quote KPI

chatbot.view
    ↓
Show Chatbot Status

audit.view
    ↓
Show Audit Activity
```

An administrator should not see information from modules they are not authorized to access.

---

# 6. Dashboard Header

The dashboard should provide:

```text id="n7m3x9"
Dashboard
Good morning, [Administrator Name]
```

The greeting should remain simple and professional.

---

# 7. KPI Summary

The dashboard may display high-value metrics such as:

```text id="c4x8r2"
New Quotes
Pending Quotes
Quotes This Month
Unread Notifications
```

Additional KPIs should only be added if they provide genuine operational value.

---

# 8. KPI Cards

Each KPI should contain:

* Metric label.
* Current value.
* Optional comparison.
* Link to relevant module.

Example:

```text id="p6q2m8"
New Quotes
12

View Quotes →
```

---

# 9. Quote KPI

The quote KPI should represent the current quote workflow.

Potential metrics:

```text id="x3v7c5"
New
Under Review
Quoted
Completed
```

The exact metrics should match the Quote Management specification.

---

# 10. Pending Actions

The dashboard should surface items requiring administrative attention.

Examples:

```text id="q8m4r2"
5 Quotes Awaiting Review
1 System Warning
2 Unread Critical Notifications
```

These should link to the relevant pages.

---

# 11. Avoid Duplicate Information

The dashboard should not display complete quote lists, complete audit logs, or complete notification histories.

Instead:

```text id="b5x9m3"
Dashboard
   ↓
Summary
   ↓
Dedicated Module
```

This keeps the dashboard useful and fast.

---

# 12. Recent Quotes

A small recent quote section may display:

| Quote           | Status       | Date      |
| --------------- | ------------ | --------- |
| SME-2026-000124 | New          | Today     |
| SME-2026-000123 | Under Review | Today     |
| SME-2026-000122 | Quoted       | Yesterday |

The list should remain limited.

---

# 13. Quote Privacy

The dashboard should avoid displaying unnecessary customer information.

Prefer:

```text id="n6q3x8"
SME-2026-000124
New
```

rather than displaying full customer details on the dashboard.

---

# 14. System Health

A system health widget should provide a high-level overview.

Example:

```text id="r7m2c5"
System Health

Application       Healthy
Chatbot           Healthy
AI Service        Healthy
```

The exact checks should follow the application's health architecture.

---

# 15. Chatbot Status

If the administrator has chatbot permissions, show:

```text id="v4x8q1"
Chatbot
● Active
```

If unavailable:

```text id="m9c3r7"
Chatbot
● Attention Required
```

A link may lead to Chatbot Management.

---

# 16. AI Status

If the administrator has appropriate access, display a safe AI service status.

Example:

```text id="p2q7x5"
AI Service
Operational
```

Do not display:

* API keys.
* Provider credentials.
* Internal stack traces.

---

# 17. Notifications

The dashboard may display a small summary:

```text id="c8m4v2"
Notifications
3 unread
```

A link should open the full notification interface.

The dashboard should not duplicate the notification dropdown.

---

# 18. Recent Activity

A limited recent activity section may display important administrative events.

Example:

```text id="x7r3m8"
Recent Activity

Quote status updated
Admin User
10 minutes ago

Chatbot configuration updated
Admin User
1 hour ago
```

Only events the administrator is authorized to see should appear.

---

# 19. Audit Integration

Recent activity may use the centralized Audit Log.

The dashboard must not create a separate activity logging system.

---

# 20. Activity Limit

Only a small number of recent events should be loaded.

Example:

```text id="q5m8c3"
Latest 5
```

A link can lead to the complete Audit Log.

---

# 21. Quick Actions

The dashboard may provide commonly used actions.

Examples:

```text id="n3x7r9"
Create Quote
View Quotes
Manage Chatbot
View Notifications
Manage Administrators
```

Actions must be permission-aware.

---

# 22. Create Quote

If the system allows administrators to create quotes manually and the user has the relevant permission, provide:

```text id="v8q2m4"
Create Quote
```

If manual quote creation is not part of the Quote Management architecture, do not expose this action.

---

# 23. Quick Action Security

Quick actions are navigation conveniences.

They must not bypass:

* Authorization.
* Validation.
* CSRF protection.
* Resource policies.

---

# 24. Dashboard Refresh

The dashboard should normally load current data when opened.

It does not require continuous polling.

A manual refresh action may be provided if useful.

---

# 25. Real-Time Updates

Real-time dashboard updates are not required for the initial implementation.

Future options may include:

* Laravel broadcasting.
* WebSockets.
* Server-sent events.

These should only be introduced when there is a demonstrated operational need.

---

# 26. Loading State

If dashboard data requires asynchronous loading, use a clear loading state.

Avoid displaying incorrect zero values while data is being retrieved.

---

# 27. Empty State

If a widget has no data:

```text id="m4x8c7"
No recent activity.
```

or:

```text id="p9q3v5"
No quotes require attention.
```

Empty states should be informative rather than alarming.

---

# 28. Error State

If an individual widget fails, it should fail independently where practical.

Example:

```text id="x6r2m8"
Unable to load quote statistics.
```

A failure in one dashboard widget should not necessarily prevent the entire dashboard from rendering.

---

# 29. Dashboard Data Layer

Dashboard calculations should be performed efficiently.

Avoid loading large datasets into PHP merely to calculate simple counts.

Prefer:

* Database aggregates.
* Indexed queries.
* Existing service methods.
* Cached values where appropriate.

---

# 30. Query Optimization

The dashboard must avoid N+1 queries.

For example, recent quotes should retrieve required relationships efficiently rather than triggering additional queries for every row.

---

# 31. Caching

Frequently used metrics may be cached where appropriate.

Caching must not make operational information misleading.

Critical status information should favor freshness over aggressive caching.

---

# 32. Dashboard Performance

Target:

* Fast initial rendering.
* Minimal JavaScript.
* Limited database queries.
* Small result sets.
* No unnecessary external API calls.

The dashboard must never make expensive AI requests merely to display status.

---

# 33. Mobile Layout

On mobile:

```text id="r3m8x6"
Header
↓
Priority Alerts
↓
KPIs
↓
Health
↓
Recent Activity
↓
Quick Actions
```

Cards should stack vertically.

---

# 34. Tablet Layout

Tablet layouts may use two-column card arrangements where space allows.

Content must remain readable without excessive horizontal scrolling.

---

# 35. Desktop Layout

Desktop may use:

```text id="c5x8m2"
┌──────────────┬──────────────┬──────────────┐
│ KPI          │ KPI          │ KPI          │
└──────────────┴──────────────┴──────────────┘

┌────────────────────────┬───────────────────┐
│ Quote Activity         │ System Health     │
└────────────────────────┴───────────────────┘

┌────────────────────────┬───────────────────┐
│ Recent Activity        │ Quick Actions     │
└────────────────────────┴───────────────────┘
```

The actual visual implementation must follow the SMEvolve Design System.

---

# 36. Accessibility

The dashboard must provide:

* Logical heading hierarchy.
* Semantic landmarks.
* Accessible KPI labels.
* Keyboard navigation.
* Visible focus states.
* Accessible links.
* Screen-reader-friendly status information.

Icons must not be the only means of communicating meaning.

---

# 37. Status Indicators

Health and status indicators should use:

* Text.
* Appropriate semantic labels.
* Optional visual indicators.

Do not communicate status through color alone.

---

# 38. Security

The dashboard must enforce:

✓ Authentication.

✓ Authorization.

✓ Permission-aware widgets.

✓ Safe output escaping.

✓ No sensitive credentials.

✓ No unauthorized resource information.

✓ CSRF protection for actions.

---

# 39. Data Privacy

Dashboard information should follow data minimization.

Do not expose unnecessary:

* Customer contact details.
* Full quote contents.
* Private conversations.
* Authentication information.

---

# 40. Auditability

Actions performed from the dashboard must be audited by the underlying module.

The dashboard should not create duplicate audit events simply because an action originated from the dashboard.

---

# 41. Dashboard Components

Recommended reusable components:

```text id="q7m3x8"
components/admin/dashboard/
├── kpi-card.blade.php
├── attention-card.blade.php
├── health-card.blade.php
├── recent-activity.blade.php
└── quick-actions.blade.php
```

Actual component names should follow the project's established component conventions.

---

# 42. Controller

Recommended controller:

```text id="m8c4v2"
AdminDashboardController
```

Responsibilities:

* Prepare dashboard metrics.
* Retrieve relevant summaries.
* Prepare recent activity.
* Prepare health information.

The controller should remain lightweight.

Business logic should remain in appropriate services.

---

# 43. Service Layer

Where dashboard calculations become complex, use dedicated services.

Possible abstraction:

```text id="x5r9q3"
AdminDashboardService
```

This service may aggregate:

```text id="v2m7c8"
Quote statistics
Notification counts
Health status
Recent activity
```

---

# 44. Failure Isolation

Where possible, dashboard sections should be independently resilient.

For example:

```text id="p4x8m2"
Quote statistics unavailable
```

should not prevent:

```text id="n7q3r6"
System Health
Recent Activity
```

from loading.

---

# 45. Acceptance Criteria

The dashboard is accepted when:

✓ Authorized administrators can access the dashboard.

✓ Unauthorized users cannot access it.

✓ KPIs display correctly.

✓ Quote summaries reflect the actual quote workflow.

✓ Pending actions are visible.

✓ Notifications summary works.

✓ System health is displayed safely.

✓ Chatbot status is displayed where authorized.

✓ AI status is displayed safely where authorized.

✓ Recent activity is available where authorized.

✓ Quick actions respect permissions.

✓ Dashboard does not expose unnecessary customer information.

✓ Dashboard does not expose secrets.

✓ No unnecessary AI requests are made.

✓ Database queries are optimized.

✓ Responsive layouts work.

✓ Accessibility requirements are satisfied.

---

# 46. Integration Requirements

The dashboard integrates with:

```text id="f6m2x9"
Quote Management
Notifications
Audit Log
Chatbot Management
Administrator Management
Authentication
Authorization
System Health
```

It must consume existing module services rather than duplicate business logic.

---

# 47. Future Recommendations

Potential future dashboard enhancements:

* Advanced analytics.
* Quote conversion metrics.
* Revenue reporting.
* Lead-source analytics.
* AI usage analytics.
* Custom dashboard widgets.
* Date-range comparisons.
* Exportable reports.
* Real-time operational monitoring.

These should be introduced only when supported by the underlying modules and business requirements.

---

# 48. Next Document

The next document is:

```text id="k8q4m2"
Documentation/17_Admin_Portal/15_Admin_Search.md
```

This will define global Admin Portal search, including searchable resources, permissions, result ranking, keyboard interaction, filtering, privacy, and performance.
