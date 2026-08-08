# SMEvolve Admin Portal

## 04 – Admin Roles & Permissions

**Project:** SMEvolve

**Module:** Admin Portal

**Documentation Path:** `Documentation/17_Admin_Portal/`

**Framework:** Laravel 12

**Frontend:** Blade, Vite, Alpine.js

**Version:** 1.0

**Document Type:** Roles, Permissions & Authorization Specification

---

# 1. Objective

Define the roles, permissions, privilege boundaries, and authorization rules for the SMEvolve Admin Portal.

The authorization system must ensure that administrators can only access and perform actions appropriate to their assigned responsibilities.

Security must be enforced on the server.

Hiding a navigation item or button must never be considered sufficient authorization.

---

# 2. Authorization Principles

The Admin Portal must follow:

* Least privilege.
* Deny by default.
* Explicit permissions.
* Server-side authorization.
* Separation of sensitive functions.
* Auditable privilege changes.
* Secure defaults.

An administrator should receive only the permissions necessary to perform their assigned duties.

---

# 3. Initial Role Model

The architecture should support the following roles:

```text
Super Admin
Admin
Editor
Support
```

These roles provide a foundation for future expansion.

Not every role must be used immediately if the first deployment only requires a smaller administrative team.

---

# 4. Super Admin

The Super Admin is the highest administrative role.

The Super Admin may manage:

* Administrators.
* Roles and permissions.
* Website settings.
* Quotes.
* Chatbot.
* AI configuration.
* Audit logs.
* Administrative security settings.

The Super Admin must still be subject to application security controls and audit logging.

---

# 5. Admin

The Admin role is intended for general operational management.

The Admin may manage:

* Website settings.
* Contact information.
* Business information.
* Social links.
* Quotes.
* Chatbot settings where approved.
* Operational dashboard information.

The Admin should not automatically manage:

* Administrator accounts.
* Role assignments.
* Security configuration.
* Environment secrets.

---

# 6. Editor

The Editor role is intended for approved website information/content management.

The Editor may have access to:

* General website information.
* Business information.
* Contact information.
* Social links.

The Editor should normally have read-only access to:

* Quotes.
* AI configuration.
* Administrators.
* Audit logs.

---

# 7. Support

The Support role is intended for quote and customer-support operations.

The Support role may access:

* Dashboard.
* Quotes.
* Quote details.
* Quote status where authorized.

The Support role should not manage:

* Website configuration.
* AI settings.
* Administrator accounts.
* Security settings.
* Audit configuration.

---

# 8. Permission-Based Authorization

Roles should map to granular permissions.

Example:

```text id="q6k1pl"
Role
 ↓
Permissions
 ↓
Authorized Actions
```

This is preferable to scattering role-name checks throughout controllers.

Avoid implementation patterns such as:

```text
if user.role == "admin"
```

throughout the application.

Use centralized authorization policies/gates/permissions instead.

---

# 9. Permission Naming Convention

Permissions should use clear action-oriented names.

Recommended format:

```text id="7s8d9j"
resource.action
```

Examples:

```text
quotes.view
quotes.update_status

settings.view
settings.update

chatbot.view
chatbot.update

ai.view
ai.update

administrators.view
administrators.create
administrators.update
administrators.disable

audit.view
```

---

# 10. Dashboard Permissions

Permission:

```text id="r2m5u7"
dashboard.view
```

Users with this permission can access the administrative dashboard.

Dashboard information should still respect the user's other permissions.

For example, a Support user should not receive sensitive administrative metrics simply because they can view the dashboard.

---

# 11. Website Permissions

Recommended permissions:

```text id="9z0j2x"
settings.view
settings.update
```

`settings.view` allows viewing approved website settings.

`settings.update` allows modifying approved settings.

Sensitive application configuration must remain outside this permission.

---

# 12. Quote Permissions

Recommended permissions:

```text id="k1q8m2"
quotes.view
quotes.search
quotes.update_status
quotes.add_note
```

`quotes.add_note` should only exist if administrative notes are implemented.

The system must distinguish quote viewing from quote modification.

---

# 13. Quote Data Access

A user with `quotes.view` may view quote information permitted by their role.

Sensitive information should be restricted where necessary.

For example:

```text id="n3c5x7"
Support
 ↓
Quote
 ↓
Required customer information
```

The system should avoid exposing unrelated internal information.

---

# 14. Quote Status Permission

Changing quote status should require:

```text id="m4q8z1"
quotes.update_status
```

A user who can view quotes must not automatically be able to change their status.

---

# 15. Chatbot Permissions

Recommended permissions:

```text id="b8f1s4"
chatbot.view
chatbot.update
```

`chatbot.view` permits access to chatbot settings.

`chatbot.update` permits modification of approved chatbot configuration.

---

# 16. AI Permissions

Recommended permissions:

```text id="c5n7k2"
ai.view
ai.update
```

AI permissions must be highly restricted.

`ai.update` must only expose safe configuration values.

It must never provide direct access to:

* API keys.
* Environment variables.
* Server secrets.
* Database credentials.

---

# 17. Administrator Permissions

Recommended permissions:

```text id="w4j8p3"
administrators.view
administrators.create
administrators.update
administrators.disable
administrators.change_role
```

These permissions should normally be restricted to Super Admin.

---

# 17a. Portfolio Permissions

The portfolio section covers the projects and categories shown on the public portfolio page.

Recommended permissions:

```text id="pf1"
portfolio.view
portfolio.create
portfolio.update
portfolio.publish
portfolio.delete
```

`portfolio.view` allows viewing portfolio projects and categories in the Admin Portal.

`portfolio.create` allows creating projects and categories.

`portfolio.update` allows editing projects and categories.

`portfolio.publish` allows publishing and unpublishing projects. This affects the public site, so it is deliberately separated from editing.

`portfolio.delete` permanently removes projects or categories and is classified as high risk.

These permissions support the documented role model:

* **Super Admin:** all portfolio permissions.
* **Admin:** view, create, update, publish (no delete).
* **Editor:** view, create, update (no publish, no delete). An Editor prepares content; a role with `portfolio.publish` approves it for the public site.
* **Support:** none.

All portfolio changes are recorded in the administrative audit log (`portfolio.create`, `portfolio.update`, `portfolio.delete`, `portfolio.publish`, `portfolio_categories.create`, `portfolio_categories.update`, `portfolio_categories.delete`).

---

# 18. Self-Privilege Protection

Administrators must not be able to escalate their own privileges.

For example:

```text id="u6m2v8"
Admin
 ↓
Changes own role
 ↓
Super Admin
```

This must be prohibited.

Role changes should require appropriate authorization and should generally target another administrator.

---

# 19. Super Admin Protection

The system should protect against accidental removal of the final Super Admin.

For example:

```text id="r9k3x5"
Only Super Admin
        ↓
Attempt to disable self
        ↓
Denied
```

The application should maintain at least one valid highly privileged administrative account unless an approved recovery process exists.

---

# 20. Audit Permissions

Recommended permission:

```text id="p3d7q9"
audit.view
```

Only appropriately privileged administrators should access the Audit Log.

Audit logs may contain sensitive operational information.

---

# 21. Audit Restrictions

Administrators should not normally be able to:

* Modify audit records.
* Alter timestamps.
* Rewrite actors.
* Remove evidence of their own actions.

If audit maintenance is required, it should use a separate highly restricted mechanism.

---

# 22. Account Permissions

The authenticated administrator should be able to manage their own basic account information.

Examples:

```text id="z4x8c2"
profile.view
profile.update
security.password_update
```

These permissions should not grant administrative privileges.

---

# 23. Role Permission Matrix

Initial proposed matrix:

| Permission             | Super Admin | Admin | Editor | Support |
| ---------------------- | ----------: | ----: | -----: | ------: |
| Dashboard View         |           ✓ |     ✓ |      ✓ |       ✓ |
| Settings View          |           ✓ |     ✓ |      ✓ |       — |
| Settings Update        |           ✓ |     ✓ |      ✓ |       — |
| Quotes View            |           ✓ |     ✓ |      — |       ✓ |
| Quote Search           |           ✓ |     ✓ |      — |       ✓ |
| Quote Status Update    |           ✓ |     ✓ |      — |       ✓ |
| Portfolio View         |           ✓ |     ✓ |      ✓ |       — |
| Portfolio Create       |           ✓ |     ✓ |      ✓ |       — |
| Portfolio Update       |           ✓ |     ✓ |      ✓ |       — |
| Portfolio Publish      |           ✓ |     ✓ |      — |       — |
| Portfolio Delete       |           ✓ |     — |      — |       — |
| Chatbot View           |           ✓ |     ✓ |      — |       — |
| Chatbot Update         |           ✓ |     ✓ |      — |       — |
| AI View                |           ✓ |     ✓ |      — |       — |
| AI Update              |           ✓ |     — |      — |       — |
| Administrators View    |           ✓ |     — |      — |       — |
| Administrators Create  |           ✓ |     — |      — |       — |
| Administrators Update  |           ✓ |     — |      — |       — |
| Administrators Disable |           ✓ |     — |      — |       — |
| Change Roles           |           ✓ |     — |      — |       — |
| Audit View             |           ✓ |     — |      — |       — |
| Profile Update         |           ✓ |     ✓ |      ✓ |       ✓ |
| Password Update        |           ✓ |     ✓ |      ✓ |       ✓ |

This matrix is the baseline and may be refined after the security architecture is finalized.

---

# 24. Sensitive Permission Classification

Permissions should be classified according to risk.

### Low Risk

Examples:

```text
dashboard.view
profile.update
settings.view
```

### Medium Risk

Examples:

```text
settings.update
quotes.update_status
chatbot.update
```

### High Risk

Examples:

```text
ai.update
administrators.create
administrators.change_role
administrators.disable
audit.view
```

High-risk permissions require greater administrative control.

---

# 25. Permission Enforcement

Permissions must be enforced at multiple levels where appropriate:

```text id="d2g6h8"
Route
 ↓
Controller / Action
 ↓
Policy / Permission
 ↓
Service
 ↓
Database
```

The exact implementation may use Laravel policies, gates, middleware, or a dedicated permission layer.

---

# 26. Route Protection

Administrative routes must require authentication.

Sensitive routes should additionally require the relevant permission.

Conceptually:

```text id="v9n2s4"
/admin/quotes
        ↓
Authenticated?
        ↓
Has quotes.view?
        ↓
Allow / Deny
```

---

# 27. Controller Authorization

Controllers must not assume that reaching a controller means the user is authorized.

Authorization should be explicitly enforced.

Example flow:

```text id="q7m4c1"
Request
 ↓
Authentication
 ↓
Authorization
 ↓
Validation
 ↓
Service
```

---

# 28. Service-Level Authorization

Sensitive business operations should not depend solely on UI-level restrictions.

Where appropriate, service-layer operations should ensure that the requested operation is authorized by the calling application context.

This provides additional protection against accidental misuse.

---

# 29. Direct URL Protection

An administrator without permission must not gain access by manually entering a URL.

Example:

```text id="s8p3y6"
/admin/administrators
```

must remain inaccessible to a Support user even if the navigation item is hidden.

---

# 30. AJAX Authorization

Asynchronous requests must use the same authorization rules as normal page requests.

A user must not gain additional privileges simply because an endpoint is called through JavaScript.

---

# 31. Permission-Aware UI

The frontend should hide actions that the administrator cannot perform.

For example:

```text id="n4x6c9"
No quotes.update_status
        ↓
Hide "Change Status"
```

However, this is only a usability measure.

Backend authorization remains mandatory.

---

# 32. Role Management

Role assignment should be controlled.

Only administrators with the appropriate permission should be able to assign roles.

The system should prevent:

* Self-escalation.
* Unauthorized role assignment.
* Assignment of privileges beyond the assigning administrator's authority.

---

# 32a. Role Management Console (Implemented)

The Admin Portal provides a full role management console under **System → Roles & Permissions** (`admin/roles/*`).

Because the approved permission set has no dedicated role-management permission, role management is gated by the existing Administrators permissions:

* **View roles:** `administrators.view`
* **Create / edit / delete roles:** `administrators.update`

Only Super Admin holds these, so role management remains restricted to the highest privilege level.

## Screens

* **Index** (`admin.roles.index`): lists every role with its display name, description, permission count, and assigned administrator count. Core roles are flagged and protected.
* **Create** (`admin.roles.create` / `admin.roles.store`): builds a new role from a display name, description, and permission set. The internal `name` (slug) is auto-generated from the display name.
* **Edit** (`admin.roles.edit` / `admin.roles.update`): changes the display name, description, and permission set. The internal `name` is immutable after creation.
* **Delete** (`admin.roles.destroy`): permanently removes an unused custom role.

## Permission Editor

The create and edit screens render every registered permission from `config/admin_permissions.php`, grouped by `config/admin.php → permission_groups` (Dashboard, Website Settings, Portfolio, Quotes, Chatbot, AI, Administrators, Audit, Account).

Each permission row shows:

* Its readable display label — the raw permission key is never shown in the UI.
* Its documented description.
* A risk badge derived from its classification (Low / Medium / High).

A live counter shows how many of the total permissions are granted, and each group has a "Select all" toggle.

## Server-Side Safeguards

All safety rules are enforced in `App\Services\Admin\RoleService` (never only in the UI):

* **No privilege escalation:** an actor can only grant permissions they hold themselves. A role manager without `portfolio.delete` cannot create a role that has it.
* **Super Admin integrity:** the Super Admin role must always keep `dashboard.view` and `administrators.view`, so the final super administrator can never be locked out.
* **Reserved names:** the core role names (`super_admin`, `admin`, `editor`, `support`) cannot be reused for new roles.
* **Core role protection:** core roles cannot be deleted.
* **In-use protection:** a role assigned to administrator accounts cannot be deleted.
* **Own-role protection:** an administrator cannot delete their own role.
* **Known keys only:** unknown or invalid permission keys are rejected by validation and stripped by the service.

## Auditing

Every role mutation is recorded in the administrative audit log:

* `roles.create`
* `roles.update`
* `roles.delete`

The audit entries capture the actor, affected role id, and before/after permission sets (no secrets are stored).

## Behavioural Notes

* Permission changes take effect immediately for every administrator assigned to the role; permission checks always read the current role from the database.
* When a Super Admin removes privileges from their own role, the change applies immediately to their next request, which is why essential permissions are protected at the service layer.

---

# 33. Permission Inheritance

The initial implementation should avoid unnecessary complex permission inheritance.

Roles should provide predictable permission sets.

If custom permission combinations are introduced later, they should be documented and audited.

---

# 34. Disabled Administrators

When an administrator account is disabled:

* New login must be blocked.
* Existing sessions should be invalidated where practical.
* Existing permissions must no longer provide access.
* The action must be audited.

---

# 35. Administrator Deletion

Permanent deletion of administrator accounts should generally be avoided in the initial system.

Prefer:

```text id="x5j2p8"
Active
Inactive
```

This preserves historical references in audit logs.

If deletion becomes necessary later, it must account for audit integrity and data relationships.

---

# 36. Permission Changes

Changes to administrator roles or permissions must be audited.

Example:

```text id="f7v3k1"
Super Admin
 ↓
Changes John from Editor → Admin
 ↓
Audit record created
```

The audit record should capture the relevant before/after information without storing unnecessary sensitive data.

---

# 37. Security Events

The following should be treated as security-relevant events:

* Failed authentication.
* Successful authentication.
* Account disabled.
* Role changed.
* Privileged permission granted.
* Privileged permission removed.
* Sensitive AI configuration changed.
* Administrative account created.

---

# 38. Default Access

New administrators must not receive unrestricted access automatically.

The system should require an explicit role assignment.

If no valid role is assigned, administrative access should be denied.

---

# 39. Unknown Permissions

The application should deny access when a permission is:

* Missing.
* Invalid.
* Unknown.
* Misconfigured.

Fail securely rather than granting access.

---

# 40. Permission Documentation

Every permission introduced into the application must have:

* Name.
* Description.
* Risk classification.
* Allowed roles.
* Protected resources.
* Relevant audit behavior.

Avoid undocumented permissions.

---

# 41. Future Role Expansion

The architecture should support future roles such as:

```text id="m7r1s3"
Finance
Sales
Operations
Content Manager
AI Manager
```

These must only be introduced when required.

Do not create unnecessary roles during the first implementation.

---

# 42. Acceptance Criteria

The authorization architecture is accepted when:

✓ Roles are defined.

✓ Permissions are granular.

✓ Server-side authorization is mandatory.

✓ Navigation respects permissions.

✓ Direct URL access is protected.

✓ AJAX requests are protected.

✓ Sensitive AI settings are restricted.

✓ Administrator management is restricted.

✓ Self-privilege escalation is prevented.

✓ Role changes are auditable.

✓ Disabled accounts lose access.

✓ Audit access is restricted.

✓ The architecture supports future roles.

---

# 43. Next Document

The next document is:

```text id="k3f8w2"
Documentation/17_Admin_Portal/05_Authentication_and_Security.md
```

This document will define the authentication architecture, session security, login protection, password security, CSRF protection, rate limiting, administrative security controls, and other security requirements before implementation begins.
