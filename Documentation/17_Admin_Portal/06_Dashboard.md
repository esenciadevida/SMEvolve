# SMEvolve Admin Portal

## 06 – Dashboard

**Project:** SMEvolve

**Module:** Admin Portal

**Documentation Path:** `Documentation/17_Admin_Portal/`

**Framework:** Laravel 12

**Frontend:** Blade, Vite, Alpine.js

**Version:** 1.0

**Document Type:** Dashboard Functional & UI Specification

---

# 1. Objective

Define the structure, functionality, data requirements, and behavior of the SMEvolve Admin Dashboard.

The dashboard is the primary landing page for authenticated administrators.

Its purpose is to provide a concise operational overview of the website and direct administrators toward actions requiring attention.

The dashboard should prioritize useful information over excessive statistics.

---

# 2. Dashboard Route

Recommended route:

```text id="1d7z5m"
/admin
```

Named route:

```text id="v3x8q1"
admin.dashboard
```

The exact naming may be adjusted to match the final route architecture.

---

# 3. Dashboard Access

Access requires:

```text id="k6r2p9"
Authentication
+
dashboard.view
```

Dashboard content must also respect the administrator's other permissions.

A dashboard must not expose information merely because the user has access to the dashboard itself.

---

# 4. Dashboard Layout

The dashboard should follow this general structure:

```text id="j8m4c2"
Admin Header
     ↓
Page Header
     ↓
Summary Cards
     ↓
Operational Overview
     ↓
Recent Quotes
     ↓
Recent Activity
     ↓
System / AI Status
```

The exact arrangement may be refined during UI implementation.

---

# 5. Page Header

The dashboard header should contain:

```text id="f5q1r7"
Dashboard
Overview of your SMEvolve operations.
```

The page should not contain unnecessary introductory text.

---

# 6. Summary Cards

The first dashboard section should provide high-level operational figures.

Potential cards:

```text id="z2x7n4"
Total Quotes
New Quotes
Quotes In Progress
Completed Quotes
```

The exact cards displayed should depend on the available quote workflow.

---

# 7. Total Quotes

Displays the total number of quote submissions available to the administrator.

Example:

```text id="s4m8k2"
Total Quotes
248
```

The value should be calculated efficiently.

Do not load every quote record into application memory simply to calculate a count.

---

# 8. New Quotes

Displays the number of newly submitted quotes requiring attention.

Example:

```text id="c7p3y9"
New Quotes
18
```

The definition of "New" must follow the approved Quote status workflow.

---

# 9. In-Progress Quotes

Displays the number of quotes currently being handled.

Example:

```text id="m9q5v2"
In Progress
31
```

This allows administrators to quickly understand current workload.

---

# 10. Completed Quotes

Displays the number of completed quotes.

Example:

```text id="b6r1k8"
Completed
127
```

The metric should use the approved quote status.

---

# 11. Permission-Aware Metrics

Dashboard cards must respect permissions.

For example:

```text id="t3j7x5"
Support User
      ↓
Quote metrics visible

Editor
      ↓
Quote metrics restricted or omitted
```

Administrators should only see data they are authorized to access.

---

# 12. Quote Overview

The dashboard should provide a concise quote overview.

Possible information:

* Quote status distribution.
* Recent submissions.
* Quotes requiring attention.

Avoid building a full analytics system into the initial dashboard.

---

# 13. Recent Quotes

Display a small number of recent quote submissions.

Recommended information:

| Field     | Purpose              |
| --------- | -------------------- |
| Reference | Identify quote       |
| Project   | Identify project     |
| Status    | Show current state   |
| Date      | Show submission time |
| Action    | Open details         |

The number of records should be limited.

---

# 14. Recent Quotes Action

The recent quotes section should provide:

```text id="y4c8m1"
View All Quotes
```

This should navigate to the complete Quotes page.

---

# 15. Quote Attention

The dashboard may highlight quotes that require administrative attention.

Examples:

* New.
* Awaiting review.
* Recently submitted.

The exact criteria will follow the Quote Management documentation.

---

# 16. Recent Administrative Activity

The dashboard may display a short list of recent administrative actions.

Examples:

```text id="w2p6r9"
Settings updated
Quote status changed
Administrator created
Chatbot settings updated
```

This should be a summary only.

The complete history belongs in the Audit Log.

---

# 17. Activity Information

Each activity item may contain:

* Administrator.
* Action.
* Target.
* Time.

Example:

```text id="n8c4x7"
Admin
Updated contact phone number
12 minutes ago
```

Avoid displaying unnecessary sensitive metadata.

---

# 18. Audit Permission

Recent activity should only be displayed when the administrator has appropriate audit visibility.

If the user lacks:

```text id="q7m3z5"
audit.view
```

the dashboard should either:

* Hide the activity section, or
* Display only non-sensitive operational activity.

The final behavior should be consistent across the application.

---

# 19. Chatbot Status

The dashboard may provide a simple chatbot status indicator.

Example:

```text id="h5x9p2"
Chatbot
Active
```

Possible states:

```text id="u6c3m8"
Active
Disabled
Unavailable
```

The dashboard should not expose technical credentials or internal provider information unnecessarily.

---

# 20. AI Status

The dashboard may show a simple AI service status.

Example:

```text id="e3k7v1"
AI Service
Operational
```

Potential states:

```text id="r9m4x6"
Operational
Configuration Required
Unavailable
Disabled
```

Detailed AI information belongs in the AI Status page.

---

# 21. System Warnings

The dashboard may display important warnings.

Examples:

```text id="p2y8c4"
AI service unavailable.

Review configuration.
```

or:

```text id="k7n3m9"
No active administrator recovery account configured.
```

Warnings should only be shown when they require meaningful action.

Avoid unnecessary warning messages.

---

# 22. Dashboard Quick Actions

The dashboard may include quick actions for common administrative tasks.

Examples:

```text id="x8q2m5"
View Quotes
Website Settings
Chatbot Settings
Administrators
```

Quick actions must respect permissions.

---

# 23. Dashboard Navigation

Each dashboard element that represents an actionable resource should link to the relevant page.

Examples:

```text id="s5f9k2"
New Quotes
   ↓
/admin/quotes?status=new
```

or equivalent named route.

---

# 24. Dashboard Refresh

The dashboard should load current information when opened.

The initial implementation does not require real-time updates.

Avoid unnecessary polling.

If real-time functionality is introduced later, it should be justified by a real operational requirement.

---

# 25. Date and Time

Administrative timestamps should use a consistent application timezone strategy.

The application should define how timestamps are:

* Stored.
* Retrieved.
* Displayed.

The implementation should avoid mixing inconsistent timezone assumptions.

---

# 26. Recent Activity Time Format

Recent activity may use human-readable timestamps.

Examples:

```text id="h3r8p6"
Just now
5 minutes ago
2 hours ago
Yesterday
```

Full timestamps should remain available where precision is required.

---

# 27. Empty Dashboard

If the system contains no quotes or activity:

```text id="b5x1n7"
No recent activity.
```

The dashboard should remain useful even when the system is new.

Do not display misleading zero-value information as if it were an error.

---

# 28. Error State

If dashboard data fails to load:

```text id="m7q4c2"
Some dashboard information could not be loaded.

Please try again.
```

The failure of one optional dashboard component should not necessarily prevent the entire dashboard from rendering.

---

# 29. Loading State

Where asynchronous dashboard components are used, show an accessible loading state.

Example:

```text id="z8c3p5"
Loading dashboard information...
```

Avoid excessive animated loading effects.

---

# 30. Performance

Dashboard queries must be optimized.

Requirements:

✓ Use aggregate queries for counts.

✓ Limit recent records.

✓ Avoid N+1 queries.

✓ Avoid loading complete quote collections.

✓ Use appropriate database indexes.

✓ Cache stable information where useful.

---

# 31. Dashboard Service

Dashboard business logic should not be placed entirely inside the controller.

Recommended architecture:

```text id="q5m9r2"
DashboardController
       ↓
DashboardService
       ↓
Repositories / Models / Services
       ↓
Database
```

The exact architecture should follow the project's existing service-layer conventions.

---

# 32. Controller Responsibility

The Dashboard Controller should remain lightweight.

It should:

* Authorize access.
* Request dashboard data.
* Prepare the view.
* Return the dashboard response.

It should not contain large database queries or business logic.

---

# 33. Dashboard Data Object

The implementation may use a structured dashboard data object/view model to organize information.

Conceptually:

```text id="c4x7p1"
DashboardData
├── quoteMetrics
├── recentQuotes
├── recentActivity
├── chatbotStatus
└── aiStatus
```

The exact implementation should follow Laravel project conventions.

---

# 34. Dashboard Components

Reusable components should be used for repeated dashboard UI.

Potential components:

```text id="n6v2q8"
components/admin/stat-card.blade.php
components/admin/recent-list.blade.php
components/admin/status-card.blade.php
components/admin/empty-state.blade.php
components/admin/alert.blade.php
```

Do not create components solely for one trivial element unless reuse is expected.

---

# 35. Stat Card Requirements

A dashboard statistic card should contain:

* Label.
* Value.
* Optional contextual information.
* Optional link.

Example:

```text id="j9x4m6"
Total Quotes
248
View quotes →
```

The value must remain visually prominent.

---

# 36. Status Indicators

Status indicators must not rely solely on color.

For example:

```text id="u3p7k2"
● Active
```

should also communicate status through text.

This supports accessibility.

---

# 37. Responsive Dashboard

### Desktop

Use the full dashboard layout with multiple cards/columns.

### Tablet

Reduce the number of columns while preserving hierarchy.

### Mobile

Stack cards and sections vertically.

Important actions should remain easy to reach.

---

# 38. Accessibility

The dashboard must provide:

* Semantic headings.
* Accessible cards.
* Keyboard-accessible links.
* Screen-reader-friendly status indicators.
* Accessible tables.
* Visible focus states.

Decorative icons must not interfere with screen readers.

---

# 39. Security

Dashboard responses must only include authorized information.

Do not expose:

* API credentials.
* Environment variables.
* Internal secrets.
* Unnecessary customer information.
* Sensitive technical diagnostics.

---

# 40. Dashboard Caching

Caching may be used for expensive or relatively stable metrics.

However, quote counts and operational information must remain sufficiently current for administrative use.

The implementation should favor correctness over premature caching.

---

# 41. Dashboard Analytics Boundary

The dashboard is not a full analytics platform.

Do not initially implement:

* Complex charts.
* Revenue forecasting.
* Conversion analytics.
* Advanced business intelligence.
* Custom report builders.

These can be separate future modules.

---

# 42. Mobile Administrative Workflow

A mobile administrator should be able to:

```text id="f6m2r8"
Login
 ↓
View Dashboard
 ↓
See New Quotes
 ↓
Open Quote
 ↓
Review Details
 ↓
Update Status
```

The interface should not require desktop-only interactions for these essential tasks.

---

# 43. Dashboard Acceptance Criteria

The dashboard is accepted when:

✓ Authenticated administrators can access it.

✓ Unauthorized users cannot access it.

✓ Summary metrics display correctly.

✓ Metrics respect permissions.

✓ Recent quotes are displayed correctly.

✓ Recent activity is appropriately restricted.

✓ Chatbot/AI status is displayed safely.

✓ Quick actions respect permissions.

✓ Loading states work.

✓ Empty states work.

✓ Error states work.

✓ Mobile layout is usable.

✓ Accessibility requirements are satisfied.

✓ Dashboard queries are efficient.

✓ No sensitive credentials are exposed.

---

# 44. Next Document

The next document is:

```text id="r4x8m2"
Documentation/17_Admin_Portal/07_Site_Settings.md
```

This will define the centralized website settings architecture, including company information, phone numbers, email addresses, business information, social links, persistence, validation, caching, and public website integration.
