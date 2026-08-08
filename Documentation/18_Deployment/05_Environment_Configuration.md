# SMEvolve Deployment

## 05 – Environment Configuration

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

This document defines how SMEvolve's production environment configuration must be created, secured, maintained, and deployed.

The objective is to ensure that:

* Development and production environments remain separated.
* Production secrets are protected.
* Laravel receives the correct production configuration.
* Third-party services are configured securely.
* Environment changes are controlled.
* Credentials are never committed to GitHub.
* Configuration changes can be traced and reproduced.

---

# 2. Environment Model

SMEvolve should distinguish between the following environments:

```text
Local Development
       ↓
Testing / Validation
       ↓
Production
```

Where a dedicated staging environment is introduced later:

```text
Local
  ↓
Staging
  ↓
Production
```

Each environment must have its own configuration and credentials.

---

# 3. Development Environment

Development should use:

```text
APP_ENV=local
APP_DEBUG=true
```

Development may use:

* Local database.
* Test email configuration.
* Development API credentials.
* Local URLs.
* Development analytics settings where required.

Development credentials must never be used for production services unless explicitly intended.

---

# 4. Production Environment

Production should use:

```text
APP_ENV=production
APP_DEBUG=false
```

Production configuration must point to:

* Production domain.
* Production database.
* Production email provider.
* Production API credentials.
* Production analytics configuration.
* Production storage.
* Production integrations.

---

# 5. `.env` File

Laravel's production environment configuration should be stored in the production `.env` file or through the hosting platform's supported environment configuration mechanism.

The production `.env` must never be committed to GitHub.

---

# 6. `.env.example`

The repository must contain a safe `.env.example`.

It should document required variables without exposing real credentials.

Example:

```text id="3o1u6g"
APP_NAME=SMEvolve
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

LOG_CHANNEL=stack
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=

SESSION_DRIVER=
SESSION_LIFETIME=120

CACHE_STORE=
QUEUE_CONNECTION=

MAIL_MAILER=
MAIL_HOST=
MAIL_PORT=
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=
MAIL_FROM_ADDRESS=
MAIL_FROM_NAME=

GOOGLE_ANALYTICS_ID=

AI_API_KEY=
```

Only variables actually used by the application should remain in the final file.

---

# 7. Production `.env` Security

The production environment file must be protected from:

* Git.
* Public HTTP access.
* Unauthorized Hostinger users.
* Screenshots.
* Documentation.
* Logs.

A browser must never be able to access:

```text
/.env
```

---

# 8. Application Identity

The production application should define:

```text id="r0q3cz"
APP_NAME=SMEvolve
```

The name should remain consistent across:

* Application metadata.
* Emails.
* Notifications.
* Logs.
* Administrative interfaces.

---

# 9. Application URL

Production should use the official HTTPS domain:

```text id="1dr5jx"
APP_URL=https://[PRODUCTION-DOMAIN]
```

The placeholder must be replaced with the actual SMEvolve production domain.

---

# 10. Application Key

Production requires:

```text id="8g1n9m"
APP_KEY=
```

The production key must be generated securely.

Once generated and deployed, it should not be regenerated during routine deployments.

Changing `APP_KEY` may invalidate encrypted data and authenticated sessions.

---

# 11. Debug Configuration

Production must use:

```text id="f8h2m3"
APP_DEBUG=false
```

Debug mode must never be enabled on the public production website.

A production error must not expose:

* Stack traces.
* Environment variables.
* Database information.
* File paths.
* API credentials.

---

# 12. Logging Configuration

Production logging should use an appropriate log channel.

Example:

```text id="w3k6gq"
LOG_CHANNEL=stack
LOG_LEVEL=warning
```

The final values must be based on the application's monitoring requirements.

Logs should contain enough information for troubleshooting without exposing sensitive information.

---

# 13. Database Configuration

Production database configuration should resemble:

```text id="n8k6d2"
DB_CONNECTION=mysql
DB_HOST=
DB_PORT=3306
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
```

Actual credentials must only exist in the production environment.

---

# 14. Database Security

Database credentials must:

* Use a dedicated production database user.
* Use a strong password.
* Have only required privileges.
* Never be committed to GitHub.
* Never be exposed to frontend JavaScript.

---

# 15. Database Host

The production `DB_HOST` must be obtained from Hostinger.

Do not assume that the production database host is:

```text
127.0.0.1
```

or:

```text
localhost
```

unless Hostinger's actual environment confirms it.

---

# 16. Database Port

The default MySQL port is generally:

```text id="9b9uwm"
3306
```

However, the actual Hostinger database configuration must be verified.

---

# 17. Session Configuration

The production session configuration must use an appropriate secure session driver.

The selected driver should be based on:

* Hostinger capabilities.
* Expected traffic.
* Application architecture.
* Security requirements.

Session cookies must be configured securely for HTTPS.

---

# 18. Cache Configuration

The cache driver must be supported by Hostinger.

Possible strategies include:

```text id="2tb0ji"
Database
File
Redis
```

Redis should only be used if the selected Hostinger environment supports it and SMEvolve benefits from it.

---

# 19. Queue Configuration

The production queue connection must match the queue architecture selected for SMEvolve.

Potential options include:

```text id="3g3j0m"
database
redis
sync
```

The `sync` driver should not automatically be used for operations that may be slow or resource-intensive.

The final queue strategy will be documented in:

```text id="t7k1m3"
09_Storage_Queues_Scheduler.md
```

---

# 20. Mail Configuration

Production mail configuration should use the selected SMTP or transactional email provider.

Example structure:

```text id="0p7e4j"
MAIL_MAILER=smtp
MAIL_HOST=
MAIL_PORT=
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=

MAIL_FROM_ADDRESS=
MAIL_FROM_NAME="${APP_NAME}"
```

Actual credentials must never appear in source control.

---

# 21. Mail Sender

The sender address must belong to an authorized SMEvolve domain.

Example:

```text id="g1k5xe"
MAIL_FROM_ADDRESS=notifications@example.com
```

The final address will be defined during email configuration.

---

# 22. Mail Reply-To

Where customer communication requires responses, a dedicated reply-to address may be configured.

For example:

```text id="6m7v0b"
support@example.com
```

The actual address must be defined by the project requirements.

---

# 23. Email Credentials

Email credentials must be treated as production secrets.

Never include:

```text id="3g4n8p"
SMTP password
API key
OAuth secret
Private key
```

in:

* GitHub.
* `.env.example`.
* Documentation.
* Frontend code.

---

# 24. Google Analytics Configuration

If the application stores the Google Analytics measurement ID in environment configuration, it may use a variable such as:

```text id="2f8w5e"
GOOGLE_ANALYTICS_ID=
```

The actual measurement ID should be the production property ID.

Do not place secret credentials into browser analytics configuration.

---

# 25. Google Analytics Security

Google Analytics identifiers are not equivalent to server secrets.

However, the application must still avoid sending sensitive information to Google Analytics.

Never send:

* Passwords.
* API tokens.
* Payment information.
* Sensitive personal information.
* Private customer form contents.

---

# 26. Search Console Configuration

Google Search Console verification does not necessarily require a Laravel environment variable.

If DNS verification is used, the verification record should remain in DNS.

If HTML verification is used, the implementation must follow Google's current verification requirements.

---

# 27. Third-Party API Configuration

Each external API must have dedicated production configuration.

Example:

```text id="g6o0n3"
SERVICE_API_KEY=
SERVICE_API_SECRET=
SERVICE_ENDPOINT=
```

Only variables actually required by SMEvolve should be created.

---

# 28. AI Integration Configuration

If SMEvolve uses an AI service, its production credentials must be server-side only.

Example:

```text id="o3g1h7"
AI_API_KEY=
```

The key must never be embedded in:

* Blade templates.
* JavaScript bundles.
* Public API responses.
* HTML source.

---

# 29. Frontend Environment Variables

Only values explicitly intended to be public may be exposed to the frontend.

Any Vite environment variable exposed through the frontend build must be treated as publicly visible.

Never expose:

```text id="a2g5d7"
Database passwords
SMTP passwords
AI API keys
Private API secrets
```

through frontend variables.

---

# 30. Environment Variable Naming

Use consistent naming conventions.

Examples:

```text id="11u9qp"
APP_*
DB_*
MAIL_*
GOOGLE_*
AI_*
```

Do not create duplicate variables for the same configuration.

---

# 31. Configuration Validation

Before deployment, verify that all required variables exist.

The application should fail clearly during deployment if a mandatory configuration value is missing rather than silently using an insecure default.

---

# 32. Configuration Defaults

Production configuration should not depend on unsafe defaults.

Examples of values that must be explicitly verified:

```text id="p9g7qu"
APP_ENV
APP_DEBUG
APP_URL
APP_KEY
DB credentials
MAIL credentials
QUEUE connection
CACHE driver
```

---

# 33. Environment Separation

The following must remain separate:

| Configuration | Development      | Production          |
| ------------- | ---------------- | ------------------- |
| `APP_ENV`     | `local`          | `production`        |
| `APP_DEBUG`   | `true`           | `false`             |
| Database      | Development      | Production          |
| Mail          | Test/Development | Production          |
| API keys      | Development      | Production          |
| Domain        | Local/staging    | Official domain     |
| Analytics     | Optional/test    | Production property |
| Storage       | Local/test       | Production          |

---

# 34. Production Configuration Changes

Production configuration changes should be controlled.

When changing configuration:

1. Identify the required change.
2. Verify the impact.
3. Update the production environment.
4. Clear/rebuild affected Laravel caches.
5. Test the application.
6. Document the change.

---

# 35. Laravel Configuration Cache

After production environment changes, Laravel configuration cache may need to be rebuilt.

Typical commands:

```text id="g4yqv0"
php artisan config:clear
php artisan config:cache
```

These commands must be executed carefully.

A cached configuration can cause changes to appear ineffective until the cache is refreshed.

---

# 36. Route and View Cache

Where appropriate, production deployment may also use:

```text id="6g7q1z"
php artisan route:cache
php artisan view:cache
```

Only use route caching if the application's routes are compatible with Laravel's route caching requirements.

---

# 37. Secret Rotation

Production credentials should be rotated when:

* A credential is exposed.
* An employee loses access.
* A service provider requires rotation.
* Security policy requires rotation.
* Suspicious activity occurs.

After rotation:

1. Update the production environment.
2. Clear/rebuild configuration cache where necessary.
3. Test the affected service.
4. Revoke the old credential.

---

# 38. Environment Backup

Production `.env` values should be recoverable through a secure administrative process.

Do not place a backup `.env` file inside:

```text id="7w9x0g"
public_html/
```

Do not store environment backups in GitHub.

Secure password-management or secret-management systems should be used where available.

---

# 39. Access Control

Only authorized personnel should have access to production environment variables.

Access should be limited to people responsible for:

* Deployment.
* Infrastructure.
* Security.
* Application administration.

---

# 40. Environment File Permissions

Where `.env` is stored on the server, filesystem permissions must prevent unauthorized users from reading it.

The file should not be writable by the public web process unless required.

---

# 41. Production Configuration Audit

Before launch, review the production environment for:

```text id="4s8a9z"
✓ Correct APP_ENV
✓ APP_DEBUG disabled
✓ Correct APP_URL
✓ APP_KEY configured
✓ Database credentials valid
✓ Mail credentials valid
✓ Queue configured
✓ Cache configured
✓ Storage configured
✓ Third-party APIs configured
✓ Analytics configured
✓ No development credentials
✓ No test endpoints
✓ No exposed secrets
```

---

# 42. Environment Security Checklist

```text id="v2b7h4"
✓ .env excluded from Git
✓ .env.example contains no secrets
✓ Production credentials stored securely
✓ APP_DEBUG=false
✓ APP_KEY generated
✓ Database password secured
✓ SMTP/API credentials secured
✓ AI credentials secured
✓ Frontend does not expose private keys
✓ Environment file protected
✓ Production access restricted
✓ Configuration changes documented
```

---

# 43. Deployment Sequence

Production environment configuration should follow:

```text id="s4b7qk"
Hostinger Environment
        ↓
Create Database
        ↓
Configure Domain
        ↓
Configure Production .env
        ↓
Deploy Application
        ↓
Install Dependencies
        ↓
Run Migrations
        ↓
Build Assets
        ↓
Cache Configuration
        ↓
Configure Scheduler / Queue
        ↓
Test Application
```

---

# 44. Failure Handling

If required production configuration is missing:

```text id="m6k8q1"
Deployment
    ↓
Configuration validation
    ↓
Missing required value
    ↓
STOP DEPLOYMENT
```

The deployment must not continue with missing critical credentials or insecure defaults.

---

# 45. Configuration Documentation

The documentation should describe:

* What each variable does.
* Whether it is secret.
* Where it is obtained.
* Which environment uses it.
* Whether it requires rotation.

Actual secret values must never be documented.

---

# 46. Example Configuration Classification

| Variable              |       Secret? | Environment          |
| --------------------- | ------------: | -------------------- |
| `APP_NAME`            |            No | All                  |
| `APP_URL`             |            No | Environment-specific |
| `APP_ENV`             |            No | Environment-specific |
| `APP_DEBUG`           |            No | Environment-specific |
| `APP_KEY`             |       **Yes** | Production           |
| `DB_HOST`             | No/Restricted | Production           |
| `DB_DATABASE`         | No/Restricted | Production           |
| `DB_USERNAME`         |    Restricted | Production           |
| `DB_PASSWORD`         |       **Yes** | Production           |
| `MAIL_HOST`           | No/Restricted | Production           |
| `MAIL_USERNAME`       |    Restricted | Production           |
| `MAIL_PASSWORD`       |       **Yes** | Production           |
| `GOOGLE_ANALYTICS_ID` |            No | Production           |
| `AI_API_KEY`          |       **Yes** | Production           |

---

# 47. Acceptance Criteria

This document is complete when:

✓ Development and production environments are clearly separated.

✓ Production `.env` handling is defined.

✓ `.env.example` requirements are defined.

✓ Application identity configuration is defined.

✓ Application URL configuration is defined.

✓ `APP_KEY` requirements are defined.

✓ Debug configuration is defined.

✓ Database configuration is defined.

✓ Mail configuration is defined.

✓ Queue configuration is defined.

✓ Cache configuration is defined.

✓ Google Analytics configuration is defined.

✓ Third-party API configuration is defined.

✓ AI credential handling is defined.

✓ Frontend secret protection is defined.

✓ Configuration caching requirements are defined.

✓ Secret rotation is defined.

✓ Production access control is defined.

✓ Environment security checklist is defined.

---

# 48. Next Document

The next document is:

```text
06_Database_Setup.md
```

It will define the production database creation, credentials, Laravel migrations, database character set, indexes, backup-before-migration procedure, database security, verification, and recovery considerations.
