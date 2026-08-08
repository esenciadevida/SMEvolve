# SMEvolve Admin Portal

## 13 – Admin Profile

**Project:** SMEvolve

**Module:** Admin Portal

**Documentation Path:** `Documentation/17_Admin_Portal/`

**Framework:** Laravel 12

**Frontend:** Blade, Vite, Alpine.js

**Version:** 1.0

**Document Type:** Administrator Profile & Account Security Specification

---

# 1. Objective

Define the authenticated administrator's personal profile and account-management experience within the SMEvolve Admin Portal.

The profile module allows administrators to manage their own permitted account information and security settings without exposing administrative controls belonging to other users.

---

# 2. Scope

The module includes:

* Profile information.
* Email management.
* Password management.
* Account security.
* Session visibility where supported.
* Profile preferences where applicable.
* Profile validation.
* Security-sensitive confirmations.

It does not include:

* Managing other administrators.
* Role management.
* Permission management.
* System-wide settings.

Those functions belong to separate Admin Portal modules.

---

# 3. Route

Recommended route:

```text id="a5m8x3"
/admin/profile
```

Named route:

```text id="p7q2v9"
admin.profile.index
```

Additional routes may include:

```text id="m4x8c2"
/admin/profile/edit
/admin/profile/password
```

---

# 4. Access Control

The profile page should be accessible only to an authenticated administrator.

Recommended permission:

```text id="r6n3k8"
profile.view
profile.update
profile.password.update
```

An administrator should be able to manage their own profile without requiring permission to manage other administrators.

---

# 5. Profile Overview

The profile page should display:

```text id="c8v2m5"
Name
Email
Role
Account Status
Created Date
Last Login
```

Role information should be read-only.

---

# 6. Editable Information

The administrator may update approved profile information.

Typical editable fields:

```text id="x4q7n9"
Name
Email
```

Additional fields should only be introduced if required by the SMEvolve administrator model.

---

# 7. Name

The name field should:

* Be required.
* Have an appropriate maximum length.
* Be validated server-side.
* Be safely escaped on output.

The application should follow the project's existing naming conventions.

---

# 8. Email

The email field should:

* Be required.
* Be validated.
* Remain unique.
* Follow the application's email normalization rules.

Changing the email address is a security-sensitive action.

---

# 9. Email Verification

If the authentication architecture supports email verification, changing an administrator's email should trigger the appropriate verification flow.

Recommended:

```text id="n3m8q5"
Change Email
      ↓
Verification Required
      ↓
New Email Confirmed
      ↓
Account Updated
```

---

# 10. Email Change Security

The system should not immediately trust an unverified new email address if verification is required.

The administrator should not accidentally lose access because of an invalid or mistyped email.

---

# 11. Role Display

The administrator's current role may be displayed.

Example:

```text id="v7c4x2"
Role
Super Admin
```

The role must be read-only from the profile page.

---

# 12. Role Protection

Administrators must not be able to change their own role through profile settings.

Role management remains part of:

```text id="j5m8q3"
Administrator Management
```

---

# 13. Account Status

The profile may show:

```text id="q2x6r8"
Status
Active
```

The administrator must not be able to disable their own account through the profile interface.

---

# 14. Password Management

Administrators should be able to change their own password.

The password form should include:

```text id="w4p7m9"
Current Password
New Password
Confirm New Password
```

---

# 15. Current Password

The current password should be verified before allowing a password change.

This protects an authenticated session from being used to silently change the password if the session is compromised.

---

# 16. New Password

The new password must follow the application's configured password policy.

The policy should be enforced server-side.

Requirements may include:

* Minimum length.
* Confirmation match.
* Common-password protection.
* Appropriate complexity where required.

Do not create a separate password policy for the Admin Profile module.

---

# 17. Password Confirmation

The new password and confirmation must match.

Example validation:

```text id="c9m2x7"
The password confirmation does not match.
```

---

# 18. Password Security

Passwords must:

* Never be stored in plaintext.
* Never be displayed.
* Never be included in logs.
* Never be included in audit metadata.
* Use Laravel's approved password hashing mechanisms.

---

# 19. Password Change Flow

```text id="s6q3v8"
Administrator
      ↓
Enter Current Password
      ↓
Enter New Password
      ↓
Validate
      ↓
Verify Current Password
      ↓
Hash New Password
      ↓
Update Account
      ↓
Invalidate Appropriate Sessions
      ↓
Audit Event
      ↓
Success
```

---

# 20. Session Invalidation

After a password change, the application should invalidate other active sessions where supported by the authentication architecture.

The current session may be preserved or re-authenticated according to the application's security design.

---

# 21. Security Confirmation

Password changes are security-sensitive.

The interface should provide clear confirmation after a successful update.

Example:

```text id="m8x4q2"
Your password has been updated successfully.
```

---

# 22. Active Sessions

If the authentication architecture supports session tracking, the profile page may display active sessions.

Example:

| Device           | Location | Last Active |
| ---------------- | -------- | ----------- |
| Chrome – Windows | Current  | Now         |
| Chrome – Android | —        | 2 hours ago |

Exact location information should only be displayed if reliably available and appropriate.

---

# 23. Session Revocation

If session management is implemented, administrators may be able to revoke other sessions.

Example:

```text id="r5c8n3"
Revoke
```

The current session should require an explicit confirmation before being terminated.

---

# 24. Logout All Other Sessions

A useful security control may be:

```text id="q7m3x9"
Log out of all other sessions
```

This should invalidate all other sessions while preserving the current authenticated session where supported.

---

# 25. Session Security

Session controls must:

* Require authentication.
* Use CSRF protection.
* Verify ownership.
* Avoid exposing session tokens.
* Never display raw session identifiers.

---

# 26. Profile Preferences

The profile module may eventually support personal preferences.

Potential examples:

```text id="n8v4c6"
Notification Preferences
Timezone
Interface Preferences
```

Only settings that are genuinely user-specific should be included.

System-wide preferences belong elsewhere.

---

# 27. Notification Preferences

If notification preferences are implemented, administrators may control eligible non-critical notifications.

Examples:

```text id="x2q7m4"
Email notifications
Quote notifications
System notifications
```

Critical security notifications should not be silently disabled where operational policy requires delivery.

---

# 28. Timezone

If the system supports administrator-specific timezones, the profile may allow the administrator to choose one.

The application should use a standardized timezone strategy for stored timestamps and convert them for display.

---

# 29. Profile Update Flow

```text id="v6m2p8"
Administrator
      ↓
Edit Profile
      ↓
Validation
      ↓
Authorization
      ↓
Update
      ↓
Audit Event
      ↓
Success
```

---

# 30. Audit Logging

Important profile changes should generate audit events.

Examples:

```text id="b4x8r2"
Profile name changed
Email changed
Password changed
Notification preferences changed
Timezone changed
Other sessions revoked
```

Passwords themselves must never be logged.

---

# 31. Sensitive Changes

The following should be treated as security-sensitive:

* Email changes.
* Password changes.
* Session revocation.
* Security preference changes.

Additional verification may be required according to the authentication architecture.

---

# 32. Validation Errors

Validation errors should be clear and field-specific.

Example:

```text id="c7m2q5"
Email
Please enter a valid email address.
```

Avoid exposing database or authentication internals.

---

# 33. Success Messages

Examples:

```text id="p5x8n3"
Profile updated successfully.

Password updated successfully.

Other sessions have been signed out.
```

---

# 34. Failure Handling

If an update fails:

* Preserve the existing valid profile state.
* Display a safe error message.
* Log technical details internally where appropriate.

Do not expose stack traces.

---

# 35. Account Lockout

The profile page must not provide controls that bypass the application's authentication lockout or security mechanisms.

Administrators must continue to be subject to the platform's authentication security policies.

---

# 36. Two-Factor Authentication

Two-factor authentication is not required for the initial profile implementation unless already supported by the SMEvolve authentication architecture.

The profile architecture should remain extensible for future 2FA support.

Possible future flow:

```text id="q8v3m6"
Profile
   ↓
Security
   ↓
Two-Factor Authentication
```

---

# 37. Password Reset vs Password Change

These are separate flows.

### Password Change

Administrator knows the current password.

### Password Reset

Administrator has lost access to the current password.

The profile module handles password changes.

The authentication system handles password resets.

---

# 38. Accessibility

The profile interface must provide:

* Proper form labels.
* Semantic headings.
* Keyboard navigation.
* Visible focus states.
* Accessible validation messages.
* Accessible password controls.
* Screen-reader compatibility.

Password visibility toggles, if implemented, must be keyboard accessible and properly labeled.

---

# 39. Responsive Design

### Desktop

Profile information and security settings may use separate cards or sections.

### Tablet

Sections should adapt without unnecessary horizontal scrolling.

### Mobile

Forms should use a single-column layout with appropriately sized controls.

---

# 40. Performance

The profile module should remain lightweight.

Avoid unnecessary:

* JavaScript.
* API requests.
* Session queries.
* Database relationships.

Security-sensitive operations should remain server-side.

---

# 41. Security Requirements

The module must enforce:

✓ Authentication.

✓ Authorization.

✓ CSRF protection.

✓ Server-side validation.

✓ Password hashing.

✓ Current-password verification.

✓ Email uniqueness.

✓ Email verification where required.

✓ Session protection.

✓ Audit logging.

✓ Secret protection.

✓ Output escaping.

---

# 42. Acceptance Criteria

The module is accepted when:

✓ Authenticated administrators can view their profile.

✓ Administrators can update permitted profile information.

✓ Email uniqueness is enforced.

✓ Email verification works where required.

✓ Role information is read-only.

✓ Self-role changes are impossible.

✓ Self-disabling is impossible.

✓ Administrators can securely change their password.

✓ Current password verification works.

✓ Passwords are never exposed or logged.

✓ Other sessions can be revoked where supported.

✓ Security-sensitive changes are audited.

✓ Validation errors are accessible.

✓ Mobile, tablet, and desktop layouts work.

✓ The profile interface is keyboard accessible.

---

# 43. Integration Requirements

The module integrates with:

```text id="h5x9q2"
Authentication
Administrator Management
Roles & Permissions
Notifications
Audit Log
Session Management
Mail / Verification
```

The module must reuse the existing authentication and administrator architecture.

---

# 44. Future Recommendations

Possible future enhancements include:

* Two-factor authentication.
* Passkeys.
* Login history.
* Trusted devices.
* Advanced session management.
* Personal notification preferences.
* Security activity dashboard.
* Recovery codes.

These should be implemented only after the underlying authentication architecture supports them securely.

---

# 45. Next Document

The next document is:

```text id="u3m7x9"
Documentation/17_Admin_Portal/14_Admin_Dashboard.md
```

This will define the main Admin Portal dashboard, including KPI cards, quote activity, operational alerts, chatbot/AI status, recent activity, quick actions, permissions, responsive layout, and dashboard performance.
