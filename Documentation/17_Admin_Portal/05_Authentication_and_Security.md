# SMEvolve Admin Portal

## 05 – Authentication & Security

**Project:** SMEvolve

**Module:** Admin Portal

**Documentation Path:** `Documentation/17_Admin_Portal/`

**Framework:** Laravel 12

**Frontend:** Blade, Vite, Alpine.js

**Version:** 1.0

**Document Type:** Authentication, Authorization & Security Specification

---

# 1. Objective

Define the authentication and security architecture required to protect the SMEvolve Admin Portal.

The Admin Portal contains operational information, customer information, website configuration, quote submissions, and potentially sensitive AI configuration.

Security must therefore be treated as a core architectural requirement rather than an interface feature.

---

# 2. Security Principles

The Admin Portal must follow:

* Least privilege.
* Secure by default.
* Defense in depth.
* Deny by default.
* Data minimization.
* Server-side authorization.
* Secure session management.
* Secure credential handling.
* Auditability.
* Fail-safe behavior.

---

# 3. Security Boundary

The Admin Portal is a protected application area.

Conceptually:

```text id="9q6k2x"
Public Internet
      ↓
Public Website
      │
      │
      └──── Admin Authentication
                    ↓
              Admin Portal
                    ↓
             Authorization
                    ↓
          Protected Resources
```

No administrative resource should be publicly accessible.

---

# 4. Authentication Architecture

Administrators must authenticate before accessing protected Admin Portal functionality.

Authentication should use Laravel's established authentication mechanisms and existing SMEvolve application conventions.

The authentication system must support:

* Login.
* Logout.
* Session management.
* Password management.
* Account status validation.

---

# 5. Login Flow

The standard login flow should be:

```text id="8j4p7c"
Admin opens /admin/login
        ↓
Login form
        ↓
Credentials submitted
        ↓
Validation
        ↓
Authentication
        ↓
Account status check
        ↓
Session regeneration
        ↓
Redirect to Dashboard
```

Failed authentication must not expose sensitive information.

---

# 6. Login Route

The login route should be isolated from authenticated Admin Portal routes.

Conceptually:

```text id="z5f2n8"
/admin/login
```

Named route:

```text id="r8x3m6"
admin.login
```

The exact route names may be adjusted during implementation to match the application's existing conventions.

---

# 7. Protected Routes

Administrative routes should exist beneath a protected namespace.

Conceptually:

```text id="v4k9s2"
/admin
/admin/settings
/admin/quotes
/admin/chatbot
/admin/administrators
/admin/audit
```

All protected routes must require authentication.

---

# 8. Account Status

Before allowing administrative access, the system must verify that the administrator account is active.

Possible account states:

```text id="y7c2q4"
Active
Disabled
```

A disabled administrator must not be allowed to authenticate.

---

# 9. Session Security

Successful login must regenerate the session identifier to prevent session fixation.

On logout:

* The session must be invalidated.
* Authentication state must be cleared.
* Session token regeneration should follow Laravel security practices.

---

# 10. Session Timeout

The Admin Portal should follow an appropriate session lifetime.

The application should support configurable session expiration.

For sensitive environments, administrators should be required to reauthenticate after prolonged inactivity.

The exact timeout should be configured according to the deployment environment and operational requirements.

---

# 11. Concurrent Sessions

The initial implementation does not need complex session management unless required.

However, the architecture should allow future support for:

* Viewing active sessions.
* Revoking sessions.
* Logging out other devices.

---

# 12. Password Security

Passwords must be stored using Laravel's secure password hashing mechanisms.

The application must never store plaintext passwords.

Password requirements should include:

* Appropriate minimum length.
* Secure hashing.
* Password confirmation for sensitive changes.
* Protection against common weak-password patterns where appropriate.

---

# 13. Password Reset

If password recovery is implemented, the flow must:

* Use secure, expiring reset tokens.
* Avoid revealing whether an account exists.
* Invalidate tokens after successful use.
* Never send passwords through email.

---

# 14. Brute-Force Protection

The login endpoint must be rate limited.

Repeated failed attempts should trigger increasing protection.

The system should protect against:

* Credential stuffing.
* Brute-force attacks.
* Automated login attempts.

The exact rate limits should be configured according to the production environment.

---

# 15. Login Error Messages

Do not reveal whether an email/account exists.

Avoid:

```text id="n5m8x2"
This email does not exist.
```

Prefer:

```text id="g2v7p4"
The provided credentials are incorrect.
```

This reduces account enumeration risk.

---

# 16. CSRF Protection

All state-changing web requests must use Laravel's CSRF protection.

This includes:

* Settings updates.
* Quote status changes.
* Administrator management.
* Chatbot configuration.
* AI configuration.
* Account changes.

CSRF protection must remain active for Alpine.js/AJAX requests where applicable.

---

# 17. Authorization

Authentication determines **who** the administrator is.

Authorization determines **what** they can do.

Every protected operation must therefore enforce the permission model defined in:

```text id="x7q4m9"
04_Admin_Roles_and_Permissions.md
```

---

# 18. Authorization Flow

Protected actions should follow:

```text id="a8c2v6"
Request
   ↓
Authentication
   ↓
Account Active?
   ↓
Permission Check
   ↓
Validation
   ↓
Business Logic
   ↓
Response
```

Failure at any security stage must stop the operation.

---

# 19. Deny by Default

If the application cannot determine whether a user has permission, access must be denied.

Do not implement:

```text id="u4p7k2"
Unknown permission → allow
```

Use:

```text id="r6m9x3"
Unknown permission → deny
```

---

# 20. Privilege Escalation Protection

Administrators must not be able to increase their own privileges.

Examples of prohibited behavior:

* Changing own role to Super Admin.
* Granting own permissions.
* Modifying authorization records to gain access.

Such operations must require appropriate independent authorization.

---

# 21. Super Admin Protection

The system must prevent accidental removal of the final active Super Admin unless an approved recovery process exists.

Examples:

* Disabling the last Super Admin should be blocked.
* Downgrading the last Super Admin should be blocked.

This prevents administrative lockout.

---

# 22. Administrator Account Creation

Creating a new administrator must require the appropriate permission.

The creation flow should include:

```text id="p9x4c7"
Name
Email
Role
Account Status
```

The initial account credentials should be handled through a secure mechanism.

Do not display or expose generated passwords unnecessarily.

---

# 23. Administrator Disabling

Disabling an administrator must:

1. Require appropriate authorization.
2. Confirm the action.
3. Change the account state.
4. Invalidate active access where practical.
5. Record an audit event.

---

# 24. Role Changes

Changing an administrator's role is a sensitive action.

It must:

* Require appropriate authorization.
* Validate the new role.
* Prevent unauthorized privilege escalation.
* Record the old and new role.
* Create an audit record.

---

# 25. Sensitive Operations

Certain actions may require additional verification.

Potential sensitive operations include:

* Role changes.
* Administrator disabling.
* AI configuration changes.
* Security settings.
* Application-wide settings.

The architecture should support reauthentication or additional confirmation if required later.

---

# 26. Secrets Management

Sensitive credentials must remain outside the normal Admin Portal.

Examples:

```text id="c7m4z1"
GROQ_API_KEY
APP_KEY
DATABASE_PASSWORD
MAIL_PASSWORD
AWS credentials
```

These must be stored using the application's secure environment/deployment configuration.

---

# 27. AI Credential Protection

The Admin Portal may show:

```text id="j5q8v2"
AI Provider: Groq
Model: Approved Model
Status: Connected
```

It must never show:

```text id="w3f6n9"
GROQ_API_KEY=xxxxxxxx
```

Even highly privileged administrators should not normally retrieve raw API credentials through the application interface.

---

# 28. Input Validation

All administrative input must be validated server-side.

Examples:

* Email.
* Phone.
* URL.
* Text.
* Status.
* Role.
* Configuration values.

Validation must occur before data reaches business logic or persistence.

---

# 29. Output Escaping

Administrative data displayed in Blade templates must be safely escaped.

Avoid unsafe HTML rendering unless content has been explicitly sanitized and is intended to support HTML.

This is particularly important for:

* Quote submissions.
* Administrator-entered content.
* Chatbot configuration.
* Website settings.

---

# 30. Cross-Site Scripting Protection

The application must protect against stored and reflected XSS.

User-controlled values must never be treated as trusted HTML by default.

Example risk areas:

```text id="n8v3k7"
Quote name
Quote requirements
Contact messages
Admin settings
Chatbot messages
```

---

# 31. SQL Injection Protection

Database operations must use Laravel's query builder, Eloquent, or parameterized queries.

Do not construct SQL queries using raw untrusted input.

---

# 32. Mass Assignment Protection

Models receiving administrator-controlled input must use appropriate Laravel mass-assignment protection.

Only approved fields should be assignable.

This prevents an administrator or malicious request from modifying fields that were not intended to be editable.

---

# 33. IDOR Protection

The application must protect against insecure direct object references.

For example:

```text id="m4x8r1"
/admin/quotes/123
```

Changing `123` to `124` must not allow access to a resource the administrator is not authorized to view.

Authorization must be checked against the actual resource.

---

# 34. Quote Data Protection

Quote information may contain personal and business information.

The Admin Portal must:

* Restrict access.
* Avoid unnecessary exposure.
* Avoid unnecessary logging.
* Avoid exposing sensitive data in URLs where practical.
* Restrict exports unless explicitly approved.

---

# 35. Audit Logging

Security-sensitive administrative operations must be auditable.

Events should include:

* Login.
* Logout where appropriate.
* Failed login.
* Administrator creation.
* Administrator disabling.
* Role changes.
* Settings changes.
* Quote status changes.
* Chatbot changes.
* AI configuration changes.

---

# 36. Audit Data

An audit record should contain appropriate information such as:

```text id="y2k7p5"
Actor
Action
Resource
Resource ID
Timestamp
Result
Relevant Metadata
```

Do not store:

* Passwords.
* API keys.
* Session secrets.
* Full sensitive request bodies.

---

# 37. Technical Logs vs Audit Logs

These systems should remain conceptually separate.

### Technical Application Log

Used for:

* Exceptions.
* Infrastructure errors.
* Integration failures.
* Debugging.

### Audit Log

Used for:

* Who changed what.
* When it changed.
* Administrative actions.

Do not use technical logs as a replacement for audit records.

---

# 38. Error Handling

Production errors must not expose internal implementation details.

Never display:

* Stack traces.
* SQL statements.
* File system paths.
* Environment variables.
* API credentials.
* Framework internals.

Provide a safe user-facing message.

---

# 39. Security Headers

The production application should use appropriate security headers according to the deployment architecture.

Potential controls include:

* Content Security Policy.
* X-Content-Type-Options.
* Referrer-Policy.
* Frame protection.
* Secure cookie configuration.

The exact header configuration should be finalized during deployment/security hardening.

---

# 40. Secure Cookies

Authentication cookies should use secure attributes appropriate to production.

Where applicable:

* Secure.
* HttpOnly.
* SameSite.

Cookie settings must be aligned with the actual deployment architecture.

---

# 41. HTTPS

The production Admin Portal must operate over HTTPS.

Administrative credentials and authenticated sessions must never be transmitted over unsecured HTTP in production.

HTTP requests should be redirected to HTTPS where appropriate.

---

# 42. Rate Limiting

Rate limiting should be applied to sensitive endpoints such as:

* Login.
* Password reset.
* AI requests.
* Administrative APIs.
* Other high-cost operations.

Limits should balance security with legitimate administrative use.

---

# 43. AI Abuse Protection

The chatbot/AI integration should have controls against excessive usage.

Potential protections:

* Rate limits.
* Request validation.
* Maximum message length.
* Approved model list.
* Usage monitoring.
* Failure handling.

The Admin Portal must not provide a configuration path that unintentionally removes all safeguards.

---

# 44. File Upload Security

If future Admin Portal features introduce uploads, uploaded files must be:

* Validated.
* Type restricted.
* Size restricted.
* Safely stored.
* Renamed where appropriate.
* Prevented from executing as server-side code.

File uploads are not part of the initial Admin Portal unless another module requires them.

---

# 45. Database Security

The application database must not be directly exposed to administrators.

Administrators interact through approved application services and interfaces.

No Admin Portal feature should provide arbitrary SQL execution.

---

# 46. Environment Security

Production environment variables must not be exposed through:

* Admin pages.
* Debug screens.
* Error messages.
* API responses.
* Logs.

Production debugging must remain disabled.

---

# 47. Dependency Security

The project should keep Laravel and dependencies updated according to the project's maintenance policy.

Security vulnerabilities in dependencies should be reviewed before production deployment.

---

# 48. Backup Security

Backups containing administrative or customer data must be protected.

The Admin Portal does not directly manage backup infrastructure, but the application architecture must remain compatible with secure backup and recovery procedures.

---

# 49. Security Testing

Before production, test:

### Authentication

✓ Invalid login.

✓ Brute-force protection.

✓ Logout.

✓ Session invalidation.

### Authorization

✓ Role restrictions.

✓ Direct URL protection.

✓ AJAX authorization.

✓ Privilege escalation attempts.

### Data Protection

✓ XSS.

✓ SQL injection.

✓ IDOR.

✓ Mass assignment.

✓ Sensitive information exposure.

### Administrative Security

✓ Role changes.

✓ Account disabling.

✓ Audit logging.

✓ Secret protection.

---

# 50. Security Incident Considerations

The architecture should support investigation of suspicious activity through:

* Audit records.
* Authentication logs.
* Application logs.
* Administrative activity.

Logs must contain enough information for investigation without unnecessarily storing sensitive data.

---

# 51. Security Acceptance Criteria

The security architecture is accepted when:

✓ Admin routes require authentication.

✓ Disabled administrators cannot access the portal.

✓ Permissions are enforced server-side.

✓ Direct URL access cannot bypass authorization.

✓ AJAX requests are protected.

✓ CSRF protection is enabled.

✓ Login attempts are rate limited.

✓ Passwords are securely hashed.

✓ Sessions are securely managed.

✓ Secrets remain outside the Admin Portal.

✓ AI credentials are protected.

✓ Sensitive administrative actions are audited.

✓ Privilege escalation is prevented.

✓ Production errors do not expose sensitive information.

✓ HTTPS is required for production.

✓ Administrative and customer data is appropriately protected.

---

# 52. Next Document

The next document is:

```text id="6z3q9n"
Documentation/17_Admin_Portal/06_Dashboard.md
```

This will define the Admin Dashboard structure, metrics, widgets, data requirements, states, and administrative workflows.
