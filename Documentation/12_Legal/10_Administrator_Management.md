# SMEvolve Admin Portal

## 10 – Administrator Management

**Project:** SMEvolve

**Module:** Admin Portal

**Documentation Path:** `Documentation/17_Admin_Portal/`

**Framework:** Laravel 12

**Frontend:** Blade, Vite, Alpine.js

**Version:** 1.0

**Document Type:** Administrator Management Functional & Security Specification

---

# 1. Objective

Define how authorized administrators manage other administrator accounts within the SMEvolve Admin Portal.

The module must provide controlled management of:

* Administrator accounts.
* Roles.
* Account status.
* Access permissions.
* Administrator creation.
* Administrator disabling.
* Role changes.
* Security-sensitive actions.

The system must prevent privilege escalation and accidental administrative lockout.

---

# 2. Scope

The module includes:

* Administrator listing.
* Administrator search.
* Administrator creation.
* Administrator details.
* Role assignment.
* Account status.
* Account disabling.
* Account reactivation.
* Role changes.
* Permission-aware actions.
* Audit logging.

The module does not include:

* Public user account management.
* Customer account management.
* Full identity-provider administration.

---

# 3. Route

Recommended route:

```text
/admin/administrators
```

Named route:

```text
admin.administrators.index
```

Additional routes may include:

```text
/admin/administrators/create
/admin/administrators/{administrator}
/admin/administrators/{administrator}/edit
```

---

# 4. Access Control

Recommended permissions:

```text
administrators.view
administrators.create
administrators.update
administrators.disable
administrators.change_role
```

Permissions must be enforced server-side.

Hiding a button is not sufficient authorization.

---

# 5. Administrator List

The administrator list should display:

| Field         | Description                     |
| ------------- | ------------------------------- |
| Name          | Administrator name              |
| Email         | Login email                     |
| Role          | Assigned role                   |
| Status        | Active/Disabled                 |
| Last Activity | Recent activity where available |
| Created       | Account creation date           |
| Action        | View/Edit                       |

Sensitive authentication information must never appear.

---

# 6. Search

Administrators should be searchable by:

* Name.
* Email.

Search should be performed efficiently at the database level.

The system should not load every administrator into memory.

---

# 7. Filtering

The list should support useful filters.

Recommended:

```text
Role
Status
```

Example:

```text
Status: Active
Role: Administrator
```

---

# 8. Pagination

Administrator lists should be paginated.

Do not load every administrator into the browser.

A reasonable default page size should be used.

---

# 9. Administrator Details

The detail page should display:

* Name.
* Email.
* Role.
* Status.
* Created date.
* Updated date.
* Relevant activity.

Do not display:

* Password.
* Password hash.
* Session secrets.
* API keys.
* Authentication tokens.

---

# 10. Administrator Creation

Authorized administrators may create additional administrator accounts.

The creation form should contain:

```text
Name
Email
Role
Status
```

The initial implementation should use a secure account activation/invitation mechanism where practical.

---

# 11. Email Uniqueness

Administrator email addresses must be unique.

The system must prevent duplicate administrator accounts.

Email comparison should follow the application's authentication conventions.

---

# 12. Account Activation

A newly created administrator should not receive a password through insecure channels.

Preferred flow:

```text
Admin creates account
        ↓
Invitation / activation
        ↓
Administrator sets password
        ↓
Account becomes active
```

The exact invitation implementation may follow the authentication architecture.

---

# 13. Invitation Security

Invitation links should:

* Be cryptographically secure.
* Expire.
* Be single-use.
* Be invalidated after successful activation.
* Never contain plaintext credentials.

---

# 14. Administrator Role

Each administrator must have an assigned role.

Roles should follow the architecture defined in:

```text
04_Admin_Roles_and_Permissions.md
```

The Administrator Management module must not create a separate role system.

---

# 15. Role Assignment

When creating an administrator, only roles the current administrator is authorized to assign should be available.

Example:

```text
Super Admin
    ↓
May assign approved roles

Limited Administrator
    ↓
May not assign Super Admin
```

---

# 16. Role Changes

Changing an administrator's role is a sensitive operation.

It requires:

```text
administrators.change_role
```

The system must verify:

* Current administrator's permission.
* Target role validity.
* Whether the current user may assign that role.
* Whether the change would create an administrative lockout.

---

# 17. Self Role Change

Administrators must not be able to arbitrarily change their own role.

A user should not be able to:

```text
Administrator
     ↓
Change own role
     ↓
Super Admin
```

Such behavior must be blocked.

---

# 18. Account Status

Initial account states:

```text
Active
Disabled
```

The status must determine whether the administrator is allowed to authenticate.

---

# 19. Disabling an Administrator

Disabling an administrator requires:

```text
administrators.disable
```

The action should require confirmation.

Example:

```text
Disable this administrator?

They will no longer be able to access the Admin Portal.

[Cancel] [Disable]
```

---

# 20. Disabling Current User

An administrator should not be able to disable their own account through ordinary account management.

This prevents accidental self-lockout.

---

# 21. Last Super Admin Protection

The system must prevent disabling or downgrading the final active Super Admin unless a secure recovery process exists.

Example:

```text
Only active Super Admin
        ↓
Attempt disable
        ↓
BLOCK
```

This is a critical safety rule.

---

# 22. Reactivation

Authorized administrators may reactivate disabled accounts.

The action requires:

```text
administrators.update
```

or the appropriate dedicated permission.

Reactivation should be audited.

---

# 23. Password Management

Administrators should not be able to view another administrator's password.

Where appropriate, an authorized administrator may trigger a password reset rather than directly setting or viewing the password.

---

# 24. Password Reset

The reset flow should use the application's secure password reset system.

Administrators must not send passwords manually through:

* Email.
* Chat.
* Internal notes.
* Admin messages.

---

# 25. Email Changes

Changing an administrator's login email is a sensitive action.

The system should:

* Validate the new email.
* Ensure uniqueness.
* Require appropriate authorization.
* Audit the change.
* Consider requiring verification.

---

# 26. Account Deletion

Permanent administrator deletion should not be exposed by default.

Disabling the account preserves:

* Audit history.
* Historical ownership.
* Accountability.

If permanent deletion is required later, it must consider audit and legal requirements.

---

# 27. Audit History

Administrator management actions must be audited.

Examples:

```text
Administrator created
Role changed
Account disabled
Account reactivated
Email changed
Password reset requested
```

---

# 28. Audit Information

An administrator audit event should identify:

* Actor.
* Target administrator.
* Action.
* Timestamp.
* Relevant previous state.
* Relevant new state.

Do not record passwords or authentication secrets.

---

# 29. Self-Protection Rules

The system should enforce:

```text
Cannot disable self
Cannot elevate self
Cannot assign unauthorized role to self
Cannot remove final Super Admin
```

These rules must be enforced in backend business logic.

---

# 30. Privilege Escalation Protection

Never rely on a submitted role ID alone.

The server must determine whether:

```text
Current Admin
      ↓
Can assign
      ↓
Requested Role
```

If not, reject the operation.

---

# 31. Direct Request Protection

An unauthorized administrator must not gain access by manually submitting:

```text
POST /admin/administrators/{id}/role
```

or equivalent endpoints.

All administrative operations require authorization.

---

# 32. Validation

Administrator fields require server-side validation.

### Name

* Required.
* Appropriate length.
* Safe text handling.

### Email

* Required.
* Valid email.
* Unique.

### Role

* Required.
* Valid configured role.
* Assignable by current administrator.

### Status

* Valid configured status.

---

# 33. Account Creation Flow

The complete creation flow should be:

```text
Administrator
      ↓
Create Account
      ↓
Authorization
      ↓
Validation
      ↓
Role Assignment Check
      ↓
Create Account
      ↓
Generate Invitation
      ↓
Audit Event
      ↓
Success
```

---

# 34. Account Disable Flow

```text
Administrator
      ↓
Select Account
      ↓
Disable
      ↓
Authorization
      ↓
Safety Checks
      ↓
Update Status
      ↓
Invalidate Access
      ↓
Audit Event
      ↓
Success
```

---

# 35. Session Invalidation

When an administrator is disabled, active authenticated sessions should be invalidated where the application's session architecture supports it.

The goal is to prevent a disabled administrator from continuing to use an existing authenticated session.

---

# 36. Account Reactivation Flow

```text
Administrator
      ↓
Select Disabled Account
      ↓
Reactivate
      ↓
Authorization
      ↓
Validation
      ↓
Update Status
      ↓
Audit Event
      ↓
Success
```

---

# 37. Role Change Flow

```text
Administrator
      ↓
Select New Role
      ↓
Authorization
      ↓
Role Assignment Validation
      ↓
Safety Checks
      ↓
Update Role
      ↓
Audit Event
      ↓
Success
```

---

# 38. Confirmation Requirements

Confirmation should be used for:

* Disabling an administrator.
* Changing a highly privileged role.
* Other irreversible or high-impact actions.

Do not require confirmation for routine page navigation.

---

# 39. Success Messages

After successful actions, display clear feedback.

Examples:

```text
Administrator created successfully.

Administrator disabled successfully.

Role updated successfully.
```

Messages should not expose sensitive details.

---

# 40. Error Messages

Errors should be actionable.

Example:

```text
This administrator cannot be disabled because they are the only active Super Admin.
```

Avoid technical errors such as:

```text
SQLSTATE[23000]...
```

---

# 41. Empty State

If no administrator accounts match the search:

```text
No administrators found.
```

If the system has no additional administrators:

```text
No additional administrators have been created.
```

---

# 42. Responsive Design

The module must support:

### Desktop

Table-based administrator management.

### Tablet

Responsive table or card presentation.

### Mobile

Stacked administrator cards with accessible actions.

---

# 43. Accessibility

The module must provide:

* Semantic headings.
* Proper form labels.
* Keyboard navigation.
* Visible focus states.
* Accessible confirmation dialogs.
* Accessible status indicators.
* Screen-reader-friendly validation.

Status must not rely on color alone.

---

# 44. Performance

The module should:

* Paginate administrators.
* Search at database level.
* Avoid N+1 queries.
* Avoid loading unnecessary relationship data.
* Use indexed email/name fields where appropriate.

---

# 45. Security

Administrator Management must enforce:

✓ Authentication.

✓ Authorization.

✓ CSRF protection.

✓ Input validation.

✓ Secure invitation handling.

✓ Password protection.

✓ Privilege escalation prevention.

✓ Self-protection rules.

✓ Last Super Admin protection.

✓ Audit logging.

✓ Session invalidation.

---

# 46. Integration

The module must integrate with:

```text
Authentication
Authorization
Roles & Permissions
Audit Log
Admin Dashboard
Settings
Notification/Mail System
```

It must use the application's existing administrator model and authentication architecture rather than introducing duplicate account systems.

---

# 47. Acceptance Criteria

The module is accepted when:

✓ Authorized users can list administrators.

✓ Administrators can be searched.

✓ Administrators can be filtered.

✓ Administrators can be created securely.

✓ Invitation/activation is secure.

✓ Roles can be assigned according to permissions.

✓ Unauthorized role assignments are blocked.

✓ Administrators can be disabled by authorized users.

✓ Disabled users cannot access the Admin Portal.

✓ Authorized users can reactivate accounts.

✓ Self-disabling is blocked.

✓ Self-privilege escalation is blocked.

✓ The final active Super Admin is protected.

✓ Role changes are audited.

✓ Account changes are audited.

✓ Passwords and secrets are never exposed.

✓ Responsive layouts work.

✓ Accessibility requirements are satisfied.

---

# 48. Next Document

The next document is:

```text
Documentation/17_Admin_Portal/11_Audit_Log.md
```

This will define the centralized administrative audit system, including event structure, tracked actions, filtering, search, retention, security, privacy, and administrator visibility.
