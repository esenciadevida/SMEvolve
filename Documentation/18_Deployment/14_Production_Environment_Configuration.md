# SMEvolve Deployment

## 14 – Production Environment Configuration

**Project:** SMEvolve

**Module:** Deployment

**Documentation Path:** `Documentation/18_Deployment/`

**Framework:** Laravel 12

**Source Control:** GitHub

**Production Hosting:** Hostinger

**Environment:** Production

**Document Version:** 1.0

**Status:** Draft

---

# 1. Purpose

This document defines the production environment configuration required to run SMEvolve on Hostinger.

It covers:

* Laravel environment configuration.
* PHP configuration.
* Database configuration.
* Application URL.
* Mail configuration.
* Queue configuration.
* Cache configuration.
* Filesystem configuration.
* Session configuration.
* Third-party services.
* Environment variables.
* Production configuration security.
* Configuration validation.

The objective is to provide a single authoritative reference for the SMEvolve production environment.

---

# 2. Production Environment

The production environment is:

```text
GitHub
   ↓
Application Source
   ↓
Hostinger
   ↓
Laravel
   ↓
Database
   ↓
External Services
```

Production must remain separate from local development and testing environments.

---

# 3. Environment Separation

SMEvolve should distinguish between:

```text
Local Development
Staging / Testing
Production
```

Production credentials must never be reused in development.

Development credentials must never be deployed accidentally to production.

---

# 4. Production Server

The production application will be hosted on Hostinger.

The final Hostinger configuration must document:

* Hosting plan.
* Server environment.
* PHP version.
* Database engine/version.
* Document root.
* SSH availability.
* Cron availability.
* Storage limits.
* Resource limits.

Only the actual values from the selected Hostinger plan should be entered.

---

# 5. PHP Version

The production server must use a PHP version compatible with Laravel 12 and all installed project dependencies.

Before deployment:

```text
PHP Version
     ↓
Laravel Requirements
     ↓
Composer Dependencies
     ↓
Compatibility Check
```

The production PHP version must not be selected independently of the application's dependency requirements.

---

# 6. PHP Extensions

Required PHP extensions must be installed and enabled.

The exact list should be determined from:

```text
composer.json
Laravel requirements
Application dependencies
```

Common Laravel requirements may include extensions for:

* PDO.
* Mbstring.
* OpenSSL.
* JSON.
* XML.
* Fileinfo.
* Tokenizer.
* Ctype.
* BCMath where required.

The actual production server should be verified rather than assumed.

---

# 7. Application Directory

The Laravel application should be deployed into an appropriate Hostinger application directory.

The public web root should point to Laravel's:

```text
public/
```

directory.

The entire Laravel project should not be exposed directly as the web root.

---

# 8. Document Root

The production document root should resolve to:

```text
/project/public
```

where `/project` represents the actual Laravel project location.

This prevents sensitive application files from being directly served by the web server.

---

# 9. Laravel Environment File

The production environment file is:

```text
.env
```

It must be created/configured directly on the production environment.

It must not be committed to GitHub.

---

# 10. Application Configuration

The core production configuration should include values similar to:

```text
APP_NAME=SMEvolve
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=https://yourdomain.com
```

Actual production values must be entered during deployment.

---

# 11. Application Key

Laravel requires a valid:

```text
APP_KEY
```

The production application key must be securely generated and stored.

Do not regenerate the production application key unnecessarily after users and encrypted data already exist.

Changing it can invalidate encrypted data and sessions.

---

# 12. Debug Mode

Production must use:

```text
APP_DEBUG=false
```

Debug mode must never be enabled on a publicly accessible production environment.

---

# 13. Application URL

The production URL must use the canonical HTTPS domain.

Example:

```text
APP_URL=https://yourdomain.com
```

The actual production domain must replace the placeholder.

---

# 14. Database Configuration

Laravel's production database configuration should be supplied through environment variables.

Example:

```text
DB_CONNECTION=mysql
DB_HOST=
DB_PORT=3306
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
```

Actual credentials must only exist in the production environment.

---

# 15. Database Host

The database host must match the Hostinger database configuration.

It may be:

```text
localhost
```

or another Hostinger-provided database hostname.

Do not assume the value without checking the active hosting configuration.

---

# 16. Database Security

The application database should use:

* A dedicated database.
* A dedicated database user.
* A strong password.
* Minimum required privileges.

Database credentials must never be exposed to the browser.

---

# 17. Database Character Set

The production database should use a modern Unicode-compatible character set appropriate for the application.

The project's migrations and database configuration should be reviewed to ensure consistent encoding.

---

# 18. Database Migrations

Production migrations must be executed carefully.

Typical deployment command:

```text
php artisan migrate --force
```

The `--force` option allows migrations to run in production without an interactive confirmation.

A verified backup should exist before significant database changes.

---

# 19. Mail Configuration

Production mail settings should be configured using environment variables.

Example:

```text
MAIL_MAILER=smtp
MAIL_HOST=
MAIL_PORT=
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=
MAIL_FROM_ADDRESS=
MAIL_FROM_NAME=SMEvolve
```

The actual values depend on the selected email provider.

---

# 20. Queue Configuration

If SMEvolve uses queued jobs, the production queue driver must be configured.

Example:

```text
QUEUE_CONNECTION=database
```

or another supported production driver.

The selected driver must match the application's queue architecture.

---

# 21. Queue Worker

If a persistent queue worker is required, Hostinger must support the required process model.

If persistent workers are not available on the selected hosting plan, scheduled queue processing may be implemented where appropriate.

The final approach must be validated against Hostinger's capabilities.

---

# 22. Scheduled Tasks

Laravel scheduled tasks may be required.

The application should use Laravel's scheduler rather than creating unnecessary individual scheduled jobs.

A Hostinger cron job can invoke the Laravel scheduler at the required interval.

Typical concept:

```text
Cron
  ↓
Laravel Scheduler
  ↓
Scheduled Tasks
```

---

# 23. Cron Configuration

The actual cron command depends on the Hostinger deployment path.

Conceptually:

```text
php /path/to/project/artisan schedule:run
```

The exact path must be configured using the production application location.

---

# 24. Cache Configuration

Laravel cache configuration should use an appropriate production driver.

Example:

```text
CACHE_STORE=file
```

or another supported driver.

The final choice should reflect application scale and Hostinger capabilities.

---

# 25. Session Configuration

Session storage must be configured appropriately for production.

Example:

```text
SESSION_DRIVER=file
```

The application should use secure session settings when HTTPS is enabled.

---

# 26. Session Security

Production sessions should use secure configuration.

Consider:

```text
SESSION_SECURE_COOKIE=true
```

where appropriate.

Cookie configuration must be tested with the actual production domain.

---

# 27. Filesystem Configuration

Laravel storage configuration must distinguish between:

```text
Public files
Private files
Temporary files
Application-generated files
```

Sensitive files should not be publicly accessible merely because they exist under application storage.

---

# 28. Storage Link

If public storage is required, Laravel's storage link should be created appropriately.

Typical command:

```text
php artisan storage:link
```

The command should only be run where the application's deployment structure supports it.

---

# 29. Third-Party Services

Production configuration may include services such as:

* Google Analytics.
* Google Search Console.
* Email provider.
* AI services.
* Payment services if applicable.
* External APIs.
* File storage services.

Each integration must have separate production configuration.

---

# 30. API Keys

API keys should be stored in environment variables.

Example:

```text
SERVICE_API_KEY=
```

Never place secret API keys directly in:

```text
Blade templates
JavaScript
HTML
GitHub
Public documentation
```

---

# 31. Frontend Environment Variables

Only values intentionally exposed to the frontend should be included in frontend environment configuration.

Public values may include:

```text
Analytics measurement ID
Public API URL
Public application configuration
```

Private credentials must remain server-side.

---

# 32. Vite Production Build

The production frontend should be compiled using the production build process.

Typical command:

```text
npm run build
```

Development commands such as:

```text
npm run dev
```

must not be used as the production frontend process.

---

# 33. Composer Dependencies

Production PHP dependencies should be installed using the project's lock file.

Typical command:

```text
composer install --no-dev --optimize-autoloader
```

This ensures development-only dependencies are not unnecessarily installed in production.

---

# 34. NPM Dependencies

If the application requires Node-based build tools, dependencies should be installed according to the project's lock file.

A production deployment should not unnecessarily expose development tooling.

---

# 35. Laravel Optimization

After deployment, Laravel production caches may be generated.

Common optimization includes:

```text
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

Only commands compatible with the application's route and configuration structure should be used.

---

# 36. Configuration Cache

After changing `.env` values, rebuild Laravel configuration cache where applicable.

Typical process:

```text
php artisan config:clear
php artisan config:cache
```

This ensures cached configuration reflects the current environment.

---

# 37. Application Logging

Production logs should be enabled at an appropriate level.

Logs should provide enough information for troubleshooting without exposing secrets or unnecessary personal information.

---

# 38. Log Rotation

Production logs should not grow indefinitely.

The deployment should use appropriate log rotation or retention mechanisms supported by the hosting environment.

---

# 39. Error Pages

Production should provide user-friendly error pages.

Important examples:

```text
404
403
419
429
500
503
```

Detailed internal errors should remain hidden from public users.

---

# 40. File Permissions

Laravel application files must have appropriate permissions.

The web server needs access to required directories, particularly:

```text
storage/
bootstrap/cache/
```

Permissions should not be made unnecessarily permissive.

Avoid using broad permissions such as:

```text
777
```

unless there is a specific, justified reason and the security implications are understood.

---

# 41. Environment Validation

Before production launch, verify:

```text
✓ APP_ENV=production
✓ APP_DEBUG=false
✓ APP_URL correct
✓ APP_KEY configured
✓ Database connection works
✓ Mail configuration works
✓ Queue configuration works
✓ Cache works
✓ Storage works
✓ Third-party services work
```

---

# 42. Production Configuration Table

The final production environment should maintain a secure configuration inventory.

| Variable              | Purpose            |   Secret? | Required |
| --------------------- | ------------------ | --------: | -------: |
| `APP_NAME`            | Application name   |        No |      Yes |
| `APP_ENV`             | Environment        |        No |      Yes |
| `APP_KEY`             | Laravel encryption |   **Yes** |      Yes |
| `APP_DEBUG`           | Debug mode         |        No |      Yes |
| `APP_URL`             | Production URL     |        No |      Yes |
| `DB_HOST`             | Database host      |        No |      Yes |
| `DB_DATABASE`         | Database name      | Sensitive |      Yes |
| `DB_USERNAME`         | Database user      | Sensitive |      Yes |
| `DB_PASSWORD`         | Database password  |   **Yes** |      Yes |
| `MAIL_HOST`           | Mail server        |        No |      Yes |
| `MAIL_USERNAME`       | Mail account       | Sensitive |      Yes |
| `MAIL_PASSWORD`       | Mail password      |   **Yes** |      Yes |
| `MAIL_FROM_ADDRESS`   | Sender             |        No |      Yes |
| `QUEUE_CONNECTION`    | Queue driver       |        No |  If used |
| `CACHE_STORE`         | Cache driver       |        No |      Yes |
| `SESSION_DRIVER`      | Session driver     |        No |      Yes |
| `GOOGLE_ANALYTICS_ID` | Analytics          |        No |  If used |
| `SERVICE_API_KEY`     | External API       |   **Yes** |  If used |

Actual values must never be stored in this documentation.

---

# 43. Production Deployment Order

The recommended configuration sequence is:

```text
Hostinger Environment
        ↓
PHP Configuration
        ↓
Database
        ↓
Environment Variables
        ↓
Composer Dependencies
        ↓
Frontend Build
        ↓
Database Migration
        ↓
Storage Configuration
        ↓
Laravel Cache
        ↓
Cron / Queue
        ↓
Application Verification
```

---

# 44. Configuration Change Process

When changing production configuration:

1. Identify the required change.
2. Verify the correct value.
3. Update the production environment.
4. Clear/rebuild configuration cache if required.
5. Test the affected functionality.
6. Monitor logs.
7. Document significant changes.

---

# 45. Configuration Backup

Do not back up production `.env` files into GitHub.

If configuration needs to be recoverable, maintain a secure configuration inventory containing:

* Variable names.
* Purpose.
* Service owner.
* Secret location.
* Configuration requirements.

Secrets themselves should remain in secure storage.

---

# 46. Production Health Check

After configuration, verify:

```text
GET /
     ↓
Application
     ↓
Database
     ↓
Cache
     ↓
Storage
     ↓
Mail
     ↓
External Services
```

The application should respond correctly without exposing internal configuration.

---

# 47. Database Health Check

Verify:

* Database connection.
* Migrations.
* Required tables.
* Application queries.
* Database permissions.

A successful connection alone does not guarantee that the application database is correctly configured.

---

# 48. Mail Health Check

Send a controlled production test.

Verify:

```text
✓ SMTP connection
✓ Message accepted
✓ Message delivered
✓ Sender correct
✓ Reply-To correct
✓ Links correct
```

---

# 49. Queue Health Check

If queues are enabled:

```text
Create Job
   ↓
Queue
   ↓
Worker / Scheduler
   ↓
Job Processed
   ↓
Result Verified
```

Failed jobs should be reviewed.

---

# 50. Storage Health Check

Verify:

```text
✓ File upload
✓ File retrieval
✓ File deletion
✓ Correct permissions
✓ Private files protected
✓ Public files accessible where intended
```

---

# 51. Production Security Check

Before launch:

```text
✓ APP_DEBUG=false
✓ HTTPS enabled
✓ Secrets protected
✓ Database protected
✓ Admin protected
✓ Rate limits configured
✓ File uploads secured
✓ Production dependencies installed
✓ Logs protected
```

---

# 52. Hostinger Verification

Before declaring deployment complete, verify the actual Hostinger environment:

```text
✓ Domain connected
✓ SSL active
✓ PHP version correct
✓ Required extensions enabled
✓ Database created
✓ Database credentials valid
✓ Document root correct
✓ Storage permissions correct
✓ Cron configured
✓ Backups configured
```

---

# 53. Production Configuration Checklist

```text
APPLICATION
✓ APP_NAME
✓ APP_ENV
✓ APP_KEY
✓ APP_DEBUG=false
✓ APP_URL

PHP
✓ Compatible PHP version
✓ Required extensions
✓ Production configuration

DATABASE
✓ Database created
✓ Credentials configured
✓ Connection tested
✓ Migrations executed
✓ Backup available

MAIL
✓ Mail provider configured
✓ SMTP/API credentials configured
✓ Sender configured
✓ Delivery tested

QUEUE
✓ Queue driver selected
✓ Worker/scheduler configured
✓ Failed jobs monitored

CACHE
✓ Cache driver configured
✓ Cache tested

SESSION
✓ Session driver configured
✓ Secure cookies configured
✓ HTTPS verified

STORAGE
✓ Storage configured
✓ Permissions correct
✓ Storage link created where required
✓ Uploads tested

FRONTEND
✓ Dependencies installed
✓ Production build generated
✓ Assets loading correctly

SECURITY
✓ Secrets protected
✓ Debug disabled
✓ Admin protected
✓ Logs protected

HOSTINGER
✓ Domain connected
✓ SSL active
✓ Cron configured
✓ Backups active
```

---

# 54. Acceptance Criteria

This document is complete when:

✓ Production environment architecture is defined.

✓ Hostinger requirements are defined.

✓ PHP requirements are defined.

✓ Laravel environment configuration is defined.

✓ Database configuration is defined.

✓ Mail configuration is defined.

✓ Queue configuration is defined.

✓ Cache configuration is defined.

✓ Session configuration is defined.

✓ Filesystem configuration is defined.

✓ Third-party service configuration is defined.

✓ Frontend production build is defined.

✓ Composer production installation is defined.

✓ Configuration caching is defined.

✓ Cron requirements are defined.

✓ Production health checks are defined.

✓ Security verification is defined.

✓ Hostinger verification is defined.

---

# 55. Next Document

The next document is:

```text
Documentation/18_Deployment/15_GitHub_Repository_And_CI_CD.md
```

This will cover the **GitHub repository setup, branch strategy, `.gitignore`, GitHub Actions, deployment workflow to Hostinger, environment secrets, deployment triggers, rollback strategy, and CI/CD verification**.
