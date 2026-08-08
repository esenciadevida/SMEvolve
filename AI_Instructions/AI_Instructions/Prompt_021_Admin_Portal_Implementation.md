# SMEvolve Execution Prompt

## Phase 19 – Admin Portal Implementation

**Project:** SMEvolve

**Framework:** Laravel 12

**Frontend:** Blade, Vite, Alpine.js

---

# Objective

Implement the complete SMEvolve Admin Portal.

The Admin Portal should provide a secure, professional, scalable administrative environment for managing the operational areas of SMEvolve.

The implementation must reuse the existing SMEvolve architecture, authentication system, authorization system, design system, global components, services, and database structures wherever applicable.

The Admin Portal must be modular so future administrative features can be added without creating duplicate architectures.

---

# Required Reading

Before implementation, read:

## AI Foundation

```text
AI_Instructions/00_AI_Constitution.md
```

---

## Core Documentation

Read the relevant project documentation under:

```text
Documentation/01_PRD/

Documentation/02_Information_Architecture.md

Documentation/03_Design_System/

Documentation/04_Content_Architecture/
```

---

## Global Features

Read:

```text
Documentation/13_Global_Features/
```

Pay particular attention to:

* Authentication.
* Authorization.
* Navigation.
* Notifications.
* SEO.
* Accessibility.
* Error handling.
* Audit logging.
* Security.
* Global UI components.

---

# Admin Portal Documentation

Read every document in:

```text
Documentation/17_Admin_Portal/
```

The Admin Portal documentation is numbered:

```text
01–17
```

Do not skip documents.

The documentation set defines the complete Admin Portal architecture and should be treated as the source of truth for implementation.

---

# Implementation Principle

Do not implement the Admin Portal as an isolated application.

It must integrate into the existing SMEvolve application.

Reuse:

* Existing layouts.
* Existing authentication.
* Existing middleware.
* Existing authorization.
* Existing services.
* Existing database conventions.
* Existing design tokens.
* Existing components.
* Existing notification architecture.
* Existing audit architecture.
* Existing SEO architecture.

Do not create duplicate systems when an existing project service already provides the required functionality.

---

# Scope

Implement the complete Admin Portal documented in:

```text
Documentation/17_Admin_Portal/
```

This includes the documented administrative architecture covering:

* Admin authentication/access.
* Admin navigation.
* Admin dashboard.
* Admin profile.
* Admin search.
* Admin settings.
* Admin notifications and email.
* Administrator management.
* Roles and permissions.
* Quote administration.
* Audit functionality.
* Other administrative functionality defined by the Admin Portal documentation.

The exact implementation must follow the documentation rather than assumptions.

---

# Architecture Requirements

The implementation must:

* Follow Laravel 12 conventions.
* Use Blade for server-rendered UI.
* Use Vite for frontend assets.
* Use Alpine.js only where interaction requires it.
* Reuse existing application services.
* Keep controllers lightweight.
* Separate business logic from presentation.
* Use services for complex operations.
* Use policies/gates for authorization.
* Use Form Requests where appropriate.
* Use reusable Blade components.
* Avoid duplicate templates.
* Avoid unnecessary JavaScript.
* Avoid unnecessary API endpoints.
* Maintain clear module boundaries.

---

# Admin Route Architecture

All administrative routes should use the project's established admin prefix.

Expected base:

```text
/admin
```

Use named routes consistently.

Examples documented in the Admin Portal specifications include:

```text
admin.dashboard

admin.profile.index

admin.search

admin.settings.index

admin.notifications.index
```

Do not create duplicate routes if equivalent routes already exist.

---

# Authentication

The Admin Portal must be protected by the existing authentication architecture.

Unauthenticated users must not access administrative pages.

Use the project's existing:

* Authentication middleware.
* Session handling.
* Login flow.
* Password protection.
* Email verification where applicable.
* Security controls.

Do not create a second authentication system.

---

# Authorization

Authorization is mandatory throughout the Admin Portal.

Use:

* Gates.
* Policies.
* Permissions.
* Roles.

according to the existing architecture and documentation.

Never rely only on hiding buttons or navigation items.

Every sensitive controller action must independently verify authorization.

---

# Permission-Aware UI

Administrative interfaces must respect permissions.

For example:

```text
Permission
    ↓
Controller authorization
    ↓
Service authorization
    ↓
UI visibility
```

UI hiding is only a usability feature.

It must never replace backend authorization.

---

# Admin Dashboard

Implement the documented Admin Dashboard.

The dashboard should provide:

* KPI summaries.
* Quote activity.
* Pending actions.
* Notifications.
* System health.
* Chatbot/AI status where applicable.
* Recent activity.
* Quick actions.

Avoid loading unnecessary data.

Use optimized aggregate queries and existing services.

Do not duplicate complete module interfaces inside the dashboard.

---

# Admin Profile

Implement the documented administrator profile functionality.

Support the documented capabilities for:

* Profile information.
* Email management.
* Password management.
* Security.
* Session management where supported.
* Personal preferences where documented.

Protect sensitive operations with appropriate verification.

Never expose:

* Passwords.
* Tokens.
* API keys.
* Session identifiers.

---

# Administrator Management

Implement the administrator-management functionality defined by the Admin Portal documentation.

Administrators with the appropriate permissions should be able to manage administrative accounts according to the documented rules.

The implementation must distinguish between:

```text
Authentication
Authorization
Administrator Management
```

Do not combine these responsibilities into a single controller or service.

---

# Roles & Permissions

Implement the documented role and permission architecture.

The system must support:

* Role assignment.
* Permission evaluation.
* Permission-aware navigation.
* Permission-aware actions.
* Secure authorization checks.

Do not hardcode permission checks throughout Blade templates.

Centralize permission definitions where the project architecture requires it.

---

# Admin Search

Implement the global Admin Search architecture.

The search system must:

* Search only authorized resources.
* Support documented searchable entities.
* Provide efficient queries.
* Support result ranking where specified.
* Support autocomplete where specified.
* Support keyboard navigation.
* Work responsively.

Search must never reveal unauthorized records.

---

# Admin Settings

Implement the documented Admin Settings architecture.

Support only settings explicitly intended to be administrator-editable.

Do not create a generic `.env` editor.

Never expose:

```text
APP_KEY
DB_PASSWORD
API_SECRET
PRIVATE_KEY
ACCESS_TOKEN
```

or equivalent secrets through the Admin Portal.

Use the project's existing configuration architecture.

---

# Notifications

Implement the documented Admin notification system.

Support:

* In-app notifications.
* Read/unread state.
* Notification center.
* Notification preferences where documented.
* Permission-aware recipients.
* Notification links.
* Appropriate retention.

Notifications must respect administrator ownership and permissions.

---

# Email Notifications

Implement documented administrative email notifications.

Use Laravel's existing notification/mail architecture.

Email notifications should:

* Use reusable templates.
* Use the configured mail system.
* Be queued where appropriate.
* Support retries.
* Handle failures safely.
* Avoid exposing sensitive information.

Do not create a separate email delivery framework.

---

# Audit Logging

Reuse the existing audit architecture.

Important administrative actions should be recorded according to the documentation.

Examples may include:

* Administrator changes.
* Role changes.
* Permission changes.
* Settings changes.
* Security changes.
* Important quote actions.
* Integration changes.

Never log:

* Passwords.
* API keys.
* Authentication tokens.
* Private credentials.

---

# Chatbot & AI Integration

Where the Admin Portal documentation exposes chatbot or AI status/configuration:

Reuse the existing Chatbot implementation.

Do not rebuild the chatbot.

Do not duplicate AI service logic.

Administrative controls must respect permissions and existing service boundaries.

AI credentials must never be exposed through the interface.

---

# Quote Integration

Where the Admin Portal interacts with quotes:

Reuse the existing Quote architecture.

Do not create a second quote database model or workflow.

Administrative quote actions must respect the Quote Management specification.

---

# Database Requirements

Before creating migrations:

1. Inspect the existing schema.
2. Determine whether the required table/model already exists.
3. Reuse existing structures where possible.
4. Only create new migrations when necessary.

Avoid duplicate tables representing the same business entity.

All migrations must be reversible where practical.

---

# Models

Models must:

* Follow Laravel conventions.
* Define appropriate relationships.
* Use appropriate casts.
* Avoid exposing sensitive attributes.
* Follow existing project naming conventions.

Do not place complex business logic inside Eloquent models unless consistent with the established architecture.

---

# Controllers

Controllers should remain lightweight.

Responsibilities should generally include:

```text
Request
↓
Authorization
↓
Validation
↓
Service
↓
Response
```

Do not place large business workflows directly inside controllers.

---

# Form Requests

Use Form Requests for complex validation.

Validation must occur server-side even when frontend validation exists.

Never trust:

* Hidden fields.
* Disabled fields.
* JavaScript validation.
* Client-side permission checks.

---

# Services

Use service classes for complex operations.

Examples:

```text
AdminDashboardService

AdminSearchService

SettingsService

AdminNotificationService
```

Reuse existing services where equivalent functionality already exists.

Do not create services merely for trivial CRUD operations.

---

# Blade Components

Use reusable Blade components for repeated administrative UI.

Examples may include:

```text
KPI cards

Status badges

Admin tables

Search results

Settings fields

Notification items

Confirmation dialogs
```

Follow the project's existing component architecture.

---

# Alpine.js

Use Alpine.js only where interaction requires it.

Appropriate uses may include:

* Dropdowns.
* Modals.
* Search autocomplete.
* Toggles.
* Confirmation interfaces.
* Mobile navigation.

Do not build the Admin Portal as a JavaScript-heavy SPA.

---

# Frontend Styling

Follow the SMEvolve Design System.

Do not introduce unrelated:

* Colors.
* Typography.
* Spacing systems.
* Component styles.

Reuse existing design tokens and components.

---

# Accessibility

Verify:

* Semantic HTML.
* Correct heading hierarchy.
* Keyboard navigation.
* Visible focus states.
* Screen-reader labels.
* Accessible forms.
* Accessible tables.
* Accessible modals.
* Accessible dropdowns.
* Accessible status indicators.

Never rely on color alone to communicate status.

---

# Responsive Design

The entire Admin Portal must work on:

```text
Mobile
Tablet
Desktop
```

Administrative tables should have an intentional mobile strategy rather than causing uncontrolled horizontal overflow.

Forms should remain usable on small screens.

---

# Security

The implementation must enforce:

✓ Authentication.

✓ Authorization.

✓ CSRF protection.

✓ Server-side validation.

✓ Output escaping.

✓ Secure password handling.

✓ Session protection.

✓ Permission checks.

✓ Policy checks.

✓ Secret protection.

✓ Safe file handling where applicable.

✓ Safe redirects.

✓ Audit logging.

---

# Sensitive Data

Never expose sensitive information through:

* Blade views.
* JSON responses.
* Search results.
* Notifications.
* Email.
* Logs.
* Audit records.

Sensitive values must be masked or omitted.

---

# Error Handling

Use the project's global error-handling architecture.

Do not expose:

* Stack traces.
* SQL queries.
* Internal paths.
* Credentials.
* Infrastructure details.

Provide useful administrator-facing error messages.

---

# Performance

Prioritize:

* Efficient database queries.
* Pagination.
* Query aggregation.
* Eager loading where appropriate.
* Minimal JavaScript.
* Small frontend payloads.
* Queued email.
* Appropriate caching.

Avoid:

* N+1 queries.
* Large unbounded queries.
* Unnecessary polling.
* Unnecessary external API requests.

---

# Search Performance

Search must use appropriate:

* Indexes.
* Query constraints.
* Result limits.
* Debouncing.

If the dataset requires full-text search later, the architecture should allow it without redesigning the Admin Portal.

---

# Email Queue

Administrative email should not unnecessarily block HTTP requests.

Use Laravel queues according to the existing project queue architecture.

Verify:

* Queue configuration.
* Retry behavior.
* Failure handling.
* Duplicate prevention.

---

# Configuration

Do not introduce hardcoded configuration where the project already has a configuration system.

Use:

```text
config/
.env
database settings
services
```

according to the project's established boundaries.

Never expose `.env` editing through the Admin Portal.

---

# SEO

The Admin Portal is authenticated/private application content.

Do not make administrative pages publicly indexable.

Use appropriate:

```text
noindex
```

behavior where applicable.

Do not treat Admin Portal pages as public SEO pages.

---

# Navigation

Implement the documented Admin navigation.

Navigation items must be:

* Permission-aware.
* Consistent.
* Accessible.
* Responsive.

Do not expose navigation links to unauthorized modules.

However, remember that hiding navigation does not replace backend authorization.

---

# Breadcrumbs

Where specified, implement reusable Admin breadcrumbs.

Breadcrumbs should:

* Reflect actual hierarchy.
* Use named routes.
* Be accessible.
* Work responsively.

---

# Testing

Before considering the Admin Portal complete, test:

## Functional

✓ Admin authentication works.

✓ Admin routes are protected.

✓ Dashboard loads.

✓ KPIs display correctly.

✓ Profile works.

✓ Password changes work.

✓ Administrator management works.

✓ Roles work.

✓ Permissions work.

✓ Search works.

✓ Settings work.

✓ Notifications work.

✓ Email notifications work.

✓ Audit events are recorded.

---

## Authorization

Test:

✓ Authorized administrator.

✓ Unauthorized administrator.

✓ Restricted role.

✓ Direct URL access.

✓ Restricted resource access.

✓ Restricted search results.

✓ Restricted settings.

---

## Security

Verify:

✓ CSRF protection.

✓ Password hashing.

✓ Session protection.

✓ Secret protection.

✓ Output escaping.

✓ No sensitive data in logs.

✓ No sensitive data in emails.

✓ No unauthorized API responses.

---

## Accessibility

Verify:

✓ Keyboard navigation.

✓ Focus states.

✓ Heading hierarchy.

✓ Form labels.

✓ Screen-reader compatibility.

✓ Accessible modals.

✓ Accessible notifications.

✓ Accessible tables.

---

## Responsive

Test:

✓ Mobile.

✓ Tablet.

✓ Desktop.

Verify:

* Navigation.
* Dashboard.
* Forms.
* Tables.
* Search.
* Notifications.
* Settings.

---

## Performance

Verify:

✓ No obvious N+1 queries.

✓ Pagination works.

✓ Dashboard queries are optimized.

✓ Search queries are constrained.

✓ Emails are queued.

✓ No unnecessary polling.

---

# Documentation Compliance

After implementation, compare the completed implementation against every document in:

```text
Documentation/17_Admin_Portal/
```

Verify that every documented requirement has either:

1. Been implemented, or
2. Been explicitly identified as dependent on another module.

Do not silently omit requirements.

---

# Regression Protection

Before completing the phase:

Run the existing application test suite.

Verify that Admin Portal implementation has not broken:

* Public website.
* Authentication.
* Legal pages.
* Quote functionality.
* Chatbot.
* Global navigation.
* Notifications.
* SEO.
* Existing components.

Fix regressions before completion.

---

# Deliverables

After implementation provide:

## Summary

Explain the Admin Portal functionality implemented.

---

## Files Created

List all newly created:

* Controllers.
* Models.
* Migrations.
* Policies.
* Form Requests.
* Services.
* Components.
* Views.
* Notifications.
* Mailables.
* Tests.

---

## Files Modified

List all modified project files and explain why each was modified.

---

## Routes

List:

* New routes.
* Named routes.
* Middleware.
* Authorization requirements.

---

## Database Changes

List:

* New migrations.
* Modified models.
* New relationships.
* Indexes.

---

## Components Created

List reusable Admin components.

---

## Services Created

List new Admin services and their responsibilities.

---

## Security Implementation

Explain:

* Authentication.
* Authorization.
* Permission checks.
* Password security.
* Session security.
* Secret protection.
* Audit logging.

---

## Testing Results

Provide:

### Functional

Results for all Admin Portal functions.

### Authorization

Results for role and permission testing.

### Security

Results for security verification.

### Accessibility

Results for accessibility testing.

### Responsive

Results for mobile, tablet, and desktop.

### Performance

Results for query and rendering checks.

---

# Future Recommendations

Mention potential future upgrades such as:

* Advanced analytics.
* Two-factor authentication.
* Passkeys.
* Advanced search.
* Real-time notifications.
* Notification escalation.
* Advanced audit reporting.
* Configuration version history.
* Advanced integration management.
* Admin activity analytics.

Do not implement future recommendations unless explicitly included in the current documentation.

---

# Stop Condition

Stop after completing the Admin Portal implementation.

Do not begin:

* Deployment.
* Infrastructure configuration.
* Production deployment.
* Server provisioning.
* CI/CD setup.

Those activities will be handled separately.

---

# Final Instruction

The Admin Portal must be implemented as a secure extension of the existing SMEvolve application.

Do not rebuild existing functionality.

Do not introduce unnecessary architecture.

Do not skip documented requirements.

Do not expose sensitive information.

Do not make assumptions where existing SMEvolve documentation already provides the required behavior.

When a conflict exists between implementation assumptions and the project documentation, follow the project documentation and AI Constitution.

Complete the Admin Portal, verify it, document the changes, and stop at the defined stop condition.
