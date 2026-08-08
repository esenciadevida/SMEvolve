# SMEvolve Deployment

## 12 – Security, SSL & Backups

**Project:** SMEvolve

**Module:** Deployment

**Documentation Path:** `Documentation/18_Deployment/`

**Framework:** Laravel 12

**Source Control:** GitHub

**Production Hosting:** Hostinger

**Document Version:** 1.0

**Status:** Draft

---

# 1. Purpose

This document defines the production security, HTTPS/SSL, backup, restoration, and disaster-recovery requirements for SMEvolve.

It covers:

* SSL/TLS.
* HTTPS.
* Production secrets.
* Server security.
* Laravel security.
* Database security.
* File security.
* GitHub security.
* Backups.
* Backup retention.
* Restoration.
* Disaster recovery.
* Security verification.

The objective is to protect the SMEvolve application and ensure that the system can be recovered after data loss, configuration errors, security incidents, or infrastructure failure.

---

# 2. Security Architecture

The production security model is:

```text
                        Internet
                           │
                           ▼
                     HTTPS / TLS
                           │
                           ▼
                       Hostinger
                           │
              ┌────────────┴────────────┐
              ▼                         ▼
        Laravel Application         Database
              │
       ┌──────┼───────┐
       ▼      ▼       ▼
    Secrets  Storage  Queues
```

Security must be applied at every layer rather than relying on a single security mechanism.

---

# 3. SSL/TLS

The production SMEvolve website must use HTTPS.

Example:

```text
https://yourdomain.com
```

HTTP traffic should redirect to the preferred HTTPS URL.

---

# 4. Hostinger SSL

The production domain should have a valid SSL/TLS certificate configured through Hostinger.

Before launch verify:

```text
✓ Certificate active
✓ Certificate matches domain
✓ Certificate has not expired
✓ HTTPS loads successfully
✓ HTTP redirects appropriately
```

---

# 5. SSL Renewal

Certificate renewal should be monitored.

If Hostinger provides automatic certificate renewal, confirm that it is enabled.

Do not assume renewal is working without checking the hosting configuration.

---

# 6. HTTPS Verification

Verify the following URLs:

```text id="z4m8s1"
https://yourdomain.com
https://www.yourdomain.com
```

using whichever canonical domain strategy SMEvolve adopts.

---

# 7. Mixed Content

The production website must not load important resources over HTTP.

Check for:

```text id="r8x2k6"
HTTP images
HTTP JavaScript
HTTP CSS
HTTP API requests
HTTP fonts
```

Any mixed-content warnings should be resolved.

---

# 8. Application Environment

Production Laravel configuration should include:

```text id="c3p7m5"
APP_ENV=production
APP_DEBUG=false
```

Debug mode must never be enabled on the public production website.

---

# 9. Production Secrets

Production secrets include:

* `APP_KEY`.
* Database password.
* SMTP credentials.
* API keys.
* AI service credentials.
* Third-party service secrets.
* Authentication secrets.

These values must remain outside GitHub source code.

---

# 10. Environment File

The production `.env` file must not be committed to GitHub.

The repository should contain:

```text id="k7n4q2"
.env.example
```

containing safe configuration examples without production secrets.

---

# 11. GitHub Security

The GitHub repository should remain private unless there is an explicit reason for public access.

Repository access should be limited to authorized team members.

---

# 12. GitHub Authentication

Developers should use secure authentication methods.

Where applicable:

* SSH keys.
* Personal access tokens.
* Organization access controls.
* Two-factor authentication.

Credentials should never be shared through chat, email, or source files.

---

# 13. GitHub Secrets

If CI/CD is later introduced, production secrets should be stored using the CI/CD platform's encrypted secret-management system.

They must not be placed directly in workflow files.

---

# 14. Server Access

Hostinger SSH access should be restricted to authorized personnel.

SSH credentials must not be shared.

Where supported, use:

* SSH keys.
* Strong authentication.
* Restricted users.
* Least-privilege access.

---

# 15. Least Privilege

Users and services should receive only the permissions required to perform their tasks.

Examples:

```text id="q5j8v3"
Developer → Development access
Deployment → Deployment access
Application → Application resources
Database → Required database only
Admin → Administrative functions
```

---

# 16. Database Security

The production database must not be publicly accessible unless specifically required by the architecture.

Database credentials must remain private.

The application should connect using a dedicated database user with only the required privileges.

---

# 17. Database Credentials

Database credentials should be stored in the production environment.

Never place them in:

```text id="f2v6k8"
GitHub
Frontend JavaScript
Public configuration
HTML
Logs
Documentation
```

---

# 18. Database Backups

Production database backups are mandatory.

Backups should be performed regularly according to the application's recovery requirements.

At minimum, establish a reliable automated backup process.

---

# 19. Backup Types

The backup strategy should consider:

```text id="p8n3r5"
Database backup
Application file backup
Uploaded file backup
Configuration backup
```

Source code is already maintained in GitHub and therefore does not replace the need for database and user-file backups.

---

# 20. Database Backup Frequency

The exact frequency depends on production usage.

A reasonable initial policy may include:

```text id="u5q2m7"
Daily database backup
```

Higher-frequency backups may be required as transaction volume increases.

---

# 21. File Backup

If SMEvolve stores important user-generated files, those files must be included in the backup strategy.

Examples:

```text id="h4m8q1"
Uploaded documents
Generated reports
Important media
Application-managed files
```

---

# 22. Backup Location

Backups should not exist only on the same server containing the production application.

If the Hostinger server fails, a same-server backup may become unavailable.

Prefer:

```text id="n6p3x9"
Production
    ↓
Backup
    ↓
Separate storage/location
```

---

# 23. Backup Retention

Backups should have a defined retention policy.

Example:

```text id="s8k4v2"
Daily backups → short-term retention
Weekly backups → medium-term retention
Monthly backups → long-term retention
```

The exact retention period should be determined by the project's business and legal requirements.

---

# 24. Backup Encryption

Backups containing sensitive data should be protected appropriately.

Where supported, use encryption both:

* During transmission.
* At rest.

Backup credentials must also be protected.

---

# 25. Backup Integrity

A successful backup command does not necessarily mean the backup is usable.

Backup processes should verify:

```text id="c7m2p8"
✓ Backup completed
✓ Backup file exists
✓ Expected size
✓ No obvious corruption
✓ Storage location available
```

---

# 26. Database Restore Testing

Backups must periodically be tested by restoring them in a safe environment.

Example:

```text id="m5r9q3"
Backup
  ↓
Test Environment
  ↓
Restore
  ↓
Verify Tables
  ↓
Verify Data
```

A backup that has never been restored should not be considered fully verified.

---

# 27. File Restore Testing

If user files are backed up, periodically verify that files can actually be restored.

Check:

```text id="x3k7v5"
✓ Files restored
✓ Permissions correct
✓ Laravel can access files
✓ Public/private storage works
```

---

# 28. Disaster Recovery

A production failure may result from:

* Server failure.
* Database corruption.
* Accidental deletion.
* Application deployment failure.
* Security incident.
* Hosting outage.
* Human error.

SMEvolve should have a documented recovery process.

---

# 29. Recovery Process

The general recovery flow is:

```text id="q8m4s6"
Incident
   ↓
Assess damage
   ↓
Secure environment
   ↓
Identify last known-good backup
   ↓
Restore infrastructure/data
   ↓
Deploy known-good application
   ↓
Verify
   ↓
Return to production
```

---

# 30. Application Rollback

If the issue is caused by application code, identify the last known-good GitHub commit.

Then:

```text id="j3v9k5"
Current Version
      ↓
Known-Good Commit
      ↓
Deploy
      ↓
Verify
```

---

# 31. Database Recovery

Database recovery requires additional caution.

Before restoring:

1. Identify the affected period.
2. Determine whether new data must be preserved.
3. Identify the latest valid backup.
4. Confirm restoration strategy.
5. Restore to a controlled environment where possible.
6. Validate the restored data.
7. Perform production recovery.

---

# 32. Migration Safety

Database migrations must be reviewed before production execution.

Potentially destructive migrations should have:

* A backup.
* A rollback plan.
* A recovery procedure.

Do not assume every migration can safely be reversed.

---

# 33. Backup Before Major Changes

Create or verify a current backup before:

* Major database migrations.
* Large application upgrades.
* Infrastructure changes.
* Destructive data operations.
* Major configuration changes.

---

# 34. Laravel Security

The Laravel application should follow secure production practices.

Verify:

```text id="u2k6p9"
✓ APP_DEBUG=false
✓ APP_KEY configured
✓ Production dependencies installed
✓ Security updates applied
✓ CSRF protection active
✓ Authentication protected
✓ Authorization enforced
✓ Input validation active
```

---

# 35. Authentication Security

Authentication should use Laravel's established security mechanisms.

Requirements include:

* Secure password hashing.
* Session protection.
* CSRF protection.
* Appropriate session expiration.
* Login rate limiting where appropriate.

---

# 36. Authorization

Authentication confirms who a user is.

Authorization determines what the user can access.

Admin functionality must use authorization controls in addition to authentication.

---

# 37. Admin Portal Security

The Admin Portal must:

```text id="w4j8p2"
✓ Require authentication
✓ Require appropriate role/permission
✓ Protect administrative routes
✓ Protect administrative APIs
✓ Protect sensitive records
✓ Prevent unauthorized actions
```

---

# 38. API Security

Any production API endpoints should be protected according to their purpose.

Consider:

* Authentication.
* Authorization.
* Rate limiting.
* Input validation.
* Request size limits.
* CORS configuration where applicable.

---

# 39. Rate Limiting

Rate limits should be applied to sensitive or abuse-prone endpoints.

Potential targets include:

```text id="a7k3m9"
Login
Password reset
Contact forms
Search
Public APIs
Chatbot endpoints
```

The exact limits should reflect legitimate usage.

---

# 40. File Upload Security

Uploaded files must be:

* Validated.
* Size-limited.
* Stored appropriately.
* Renamed safely.
* Protected from unauthorized access.

Executable uploads should be prevented where they are not required.

---

# 41. Error Handling

Production users should receive generic error pages.

Detailed errors should remain in protected application logs.

Production must not expose:

```text id="v5n8q3"
Stack traces
Database queries
Filesystem paths
Environment variables
API credentials
```

---

# 42. Security Headers

Where appropriate, configure security-related HTTP headers.

Potential headers include:

```text id="x9p4k7"
Content-Security-Policy
X-Content-Type-Options
Referrer-Policy
Permissions-Policy
Strict-Transport-Security
```

The exact policy must be tested carefully to avoid breaking legitimate application functionality.

---

# 43. HSTS

If SMEvolve is fully committed to HTTPS, HTTP Strict Transport Security may be enabled.

HSTS configuration must be introduced carefully because browsers can enforce HTTPS for the configured domain.

---

# 44. Dependency Security

PHP and JavaScript dependencies should be kept reasonably current.

Regularly review:

```text id="f8m3r6"
composer dependencies
npm dependencies
Laravel
PHP
Vite
```

Security vulnerabilities should be assessed and patched according to severity.

---

# 45. Hostinger Security

Hostinger's available security controls should be reviewed.

Depending on the hosting plan, this may include:

* SSL.
* Firewall/WAF.
* Malware scanning.
* Account security.
* Backup systems.
* Access controls.

Only features actually available on the selected Hostinger plan should be relied upon.

---

# 46. Domain Security

The production domain account should use strong account security.

Where supported:

* Two-factor authentication.
* Strong password.
* Limited administrative access.
* Recovery methods.

---

# 47. DNS Security

DNS changes should be restricted to authorized personnel.

Important records include:

```text id="h7k2m5"
A / AAAA
CNAME
MX
TXT
SPF
DKIM
DMARC
```

Unnecessary DNS records should not be created.

---

# 48. Incident Response

If a security incident occurs:

```text id="n4x8q2"
Detect
  ↓
Contain
  ↓
Investigate
  ↓
Recover
  ↓
Verify
  ↓
Document
```

The affected credentials should be rotated where appropriate.

---

# 49. Credential Rotation

Rotate credentials when:

* A secret is accidentally exposed.
* An employee loses access.
* A suspicious login occurs.
* A third-party service is compromised.
* A security incident occurs.

Do not simply delete a compromised secret from the latest Git commit and assume it is no longer exposed.

---

# 50. Exposed GitHub Secret

If a production credential is accidentally committed:

```text id="s5v9k3"
1. Revoke/rotate the credential immediately.
2. Verify unauthorized usage.
3. Remove the secret from repository history if required.
4. Update production configuration.
5. Review access logs.
```

The most important action is invalidating the exposed credential.

---

# 51. Backup Incident

If backups fail:

```text id="g8m2q6"
Detect failure
    ↓
Identify cause
    ↓
Restore backup process
    ↓
Create new backup
    ↓
Verify backup
    ↓
Record incident
```

A system without recent verified backups should be treated as a higher operational risk.

---

# 52. Recovery Point Objective

The project should define how much data loss is acceptable.

Example:

```text id="p4k7s9"
RPO = 24 hours
```

would mean the project aims to recover with no more than approximately one day's data loss.

The final RPO must be approved based on business requirements.

---

# 53. Recovery Time Objective

The project should also define how quickly the system should be restored.

Example:

```text id="w6m3q8"
RTO = 4 hours
```

would mean the target is to restore the service within approximately four hours after a major outage.

The actual target must be approved by the project owner.

---

# 54. Initial Recovery Strategy

For the initial SMEvolve deployment, recovery should prioritize simplicity and reliability:

```text id="r7x4m2"
GitHub
  ↓
Known-good application version
  +
Verified database backup
  +
Verified file backup
  ↓
Hostinger
  ↓
Restore
  ↓
Verify
```

---

# 55. Security Checklist

```text id="k3p8v6"
SSL
✓ HTTPS active
✓ Certificate valid
✓ HTTP redirects to HTTPS
✓ No mixed content

APPLICATION
✓ APP_ENV=production
✓ APP_DEBUG=false
✓ APP_KEY protected
✓ Authentication secure
✓ Authorization enforced
✓ CSRF protection active
✓ Rate limiting configured
✓ File uploads protected

SERVER
✓ SSH secured
✓ Access restricted
✓ Hosting security features reviewed
✓ File permissions correct

DATABASE
✓ Credentials protected
✓ Public database access restricted
✓ Backups enabled
✓ Restore tested

BACKUPS
✓ Database backup
✓ File backup
✓ Off-server backup
✓ Retention policy
✓ Backup verification
✓ Restore procedure

GITHUB
✓ Repository access restricted
✓ Secrets excluded
✓ Authentication secured
✓ Deployment access controlled
```

---

# 56. Disaster Recovery Checklist

```text id="j5q8m3"
✓ Identify incident
✓ Secure affected environment
✓ Identify last known-good Git commit
✓ Identify latest verified database backup
✓ Identify latest verified file backup
✓ Restore application
✓ Restore database if required
✓ Restore files if required
✓ Verify configuration
✓ Verify SSL
✓ Verify application
✓ Verify database
✓ Verify email
✓ Verify Admin Portal
✓ Verify critical functions
✓ Document incident
```

---

# 57. Acceptance Criteria

This document is complete when:

✓ SSL/TLS requirements are defined.

✓ HTTPS requirements are defined.

✓ Production Laravel security settings are defined.

✓ Secret management requirements are defined.

✓ GitHub security requirements are defined.

✓ Server access requirements are defined.

✓ Database security is defined.

✓ Database backup requirements are defined.

✓ File backup requirements are defined.

✓ Backup retention is defined.

✓ Backup verification is defined.

✓ Database restoration is defined.

✓ File restoration is defined.

✓ Disaster recovery is defined.

✓ RPO and RTO are defined.

✓ Security incident handling is defined.

✓ Credential rotation is defined.

✓ Production security checklist is defined.

---

# 58. Next Document

The next document is:

```text
Documentation/18_Deployment/13_Domain_DNS_Configuration.md
```

This will cover **the SMEvolve domain, Hostinger DNS, A/AAAA records, CNAME, MX, SPF, DKIM, DMARC, subdomains, www/non-www handling, SSL DNS requirements, email DNS, and final DNS verification**.
