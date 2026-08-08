# SMEvolve Deployment

## 07 – Laravel Application Deployment

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

This document defines the standard procedure for deploying the SMEvolve Laravel application from GitHub to the Hostinger production environment.

It covers:

* GitHub repository deployment.
* Server preparation.
* Application code retrieval.
* Composer dependencies.
* Environment configuration.
* File permissions.
* Laravel storage.
* Database migrations.
* Vite assets.
* Application caching.
* Deployment verification.
* Rollback considerations.

The objective is to provide a repeatable and controlled production deployment process.

---

# 2. Deployment Architecture

The deployment flow is:

```text
Developer
    │
    ▼
GitHub Repository
    │
    │ Production Deployment
    ▼
Hostinger
    │
    ├── Laravel Application
    ├── Composer Dependencies
    ├── Vite Assets
    ├── Storage
    └── Configuration
    │
    ▼
Production Database
```

GitHub is the source of truth for application code.

Production environment secrets remain outside the GitHub repository.

---

# 3. Source Repository

The SMEvolve source code will be maintained in a private GitHub repository.

The repository should contain:

```text
app/
bootstrap/
config/
database/
public/
resources/
routes/
storage/
tests/
composer.json
composer.lock
package.json
package-lock.json
vite.config.*
artisan
.env.example
.gitignore
```

The exact repository structure may differ depending on the final project implementation.

---

# 4. Files That Must Not Be Deployed From Git

The following must not contain production secrets:

```text
.env
```

The following should normally not be committed:

```text
/vendor/
/node_modules/
/.env
```

The repository's `.gitignore` must be reviewed before the first production deployment.

---

# 5. Required Hostinger Access

Before deployment, confirm access to:

```text
✓ Hostinger account
✓ Hosting control panel
✓ SSH
✓ GitHub repository
✓ Domain
✓ Production database
✓ Production environment variables
```

The person performing deployment must have the required permissions.

---

# 6. Server Preparation

Before deploying the application, verify the Hostinger environment.

Required components include:

```text
PHP
Composer
MySQL
Git
Node.js / npm where required
SSH
Cron
SSL
```

The versions must be compatible with the SMEvolve project.

---

# 7. PHP Verification

Verify the active PHP version:

```text
php -v
```

The version must satisfy Laravel 12 and all installed Composer dependencies.

---

# 8. Composer Verification

Verify Composer:

```text
composer --version
```

If Composer is not available globally, the deployment process must use the Hostinger-supported Composer installation method.

---

# 9. Node.js Verification

If production assets are built on Hostinger, verify:

```text
node -v
npm -v
```

The versions must be compatible with `package.json`.

If Node.js is not suitable on Hostinger, Vite assets should be built before deployment or through CI/CD.

---

# 10. Git Verification

Verify:

```text
git --version
```

Git must be available if the Hostinger server retrieves the application directly from GitHub.

---

# 11. GitHub Authentication

The production server must authenticate securely with GitHub.

Preferred methods include:

* SSH deploy key.
* Hostinger's supported Git integration.
* CI/CD deployment credentials.

Production GitHub credentials must not be placed in application source files.

---

# 12. GitHub Repository Access

The repository should preferably remain private.

Production access should be limited to the deployment mechanism.

A deployment key should have the minimum permissions required.

If the server only needs to pull code, read-only repository access is preferred.

---

# 13. Production Directory

The Laravel application should be placed in a controlled server directory.

Example:

```text
/home/account/smevolve/
```

The actual path depends on Hostinger's hosting structure.

The Laravel project root should not automatically become the public document root.

---

# 14. Public Directory

The web server should expose only:

```text
smevolve/public/
```

The application root should not be directly accessible through the browser.

Correct architecture:

```text
smevolve/
├── app/
├── bootstrap/
├── config/
├── database/
├── resources/
├── routes/
├── storage/
├── vendor/
└── public/  ← Public web root
```

---

# 15. Initial Code Deployment

The initial deployment should retrieve the production branch from GitHub.

Conceptually:

```text
GitHub
   ↓
Clone repository
   ↓
Hostinger application directory
```

The exact Git commands should use the project's actual repository URL and branch.

---

# 16. Production Branch

A dedicated production branch or controlled deployment branch should be used according to the project's Git workflow.

For example:

```text
main
```

may represent production-ready code.

Do not deploy arbitrary feature branches directly to production.

---

# 17. Deployment Commit

Every production deployment should correspond to a known Git commit.

Record:

```text
Commit SHA
Branch
Deployment date
Deployed version
```

This allows the deployed version to be identified later.

---

# 18. Composer Installation

After retrieving the application code, install production dependencies.

Recommended:

```text
composer install --no-dev --optimize-autoloader
```

The installation must use the committed:

```text
composer.lock
```

to ensure consistent dependency versions.

---

# 19. Composer Security

Composer dependencies should be reviewed regularly.

Before deployment:

```text
composer validate
```

may be used to validate the Composer configuration.

Security vulnerabilities in dependencies should be addressed according to project policy.

---

# 20. Environment Configuration

Create or configure the production environment file.

The production environment must contain the required variables defined in:

```text
05_Environment_Configuration.md
```

The `.env` file must not be copied from a developer's machine if doing so could expose development credentials or incorrect settings.

---

# 21. Application Configuration

Verify:

```text
APP_NAME=SMEvolve
APP_ENV=production
APP_DEBUG=false
APP_URL=https://[PRODUCTION-DOMAIN]
```

The actual production domain must be used.

---

# 22. Database Configuration

Verify that the production `.env` contains the correct:

```text
DB_CONNECTION
DB_HOST
DB_PORT
DB_DATABASE
DB_USERNAME
DB_PASSWORD
```

The database must be tested before proceeding with migrations.

---

# 23. Application Key

Verify that the production:

```text
APP_KEY
```

exists.

Do not generate a new key during every deployment.

If the application already has a valid production key, preserve it.

---

# 24. Mail Configuration

Verify production mail settings before enabling customer-facing notifications.

The configuration must use the approved email provider.

Required values may include:

```text
MAIL_MAILER
MAIL_HOST
MAIL_PORT
MAIL_USERNAME
MAIL_PASSWORD
MAIL_ENCRYPTION
MAIL_FROM_ADDRESS
MAIL_FROM_NAME
```

---

# 25. Storage Permissions

Laravel must be able to write to the required directories.

At minimum:

```text
storage/
bootstrap/cache/
```

must be writable by the appropriate application process.

Do not make the entire project writable by everyone.

---

# 26. Storage Link

If SMEvolve uses Laravel's public storage disk, create the storage link:

```text
php artisan storage:link
```

Verify that public assets/files are accessible only according to their intended access rules.

---

# 27. Database Migration

After confirming the database connection:

```text
php artisan migrate --force
```

should be used for production migrations.

Migrations must be reviewed before execution.

A backup should be taken before risky migrations.

---

# 28. Production Seeders

Only production-safe seeders may be executed.

Never run development seeders containing:

* Test users.
* Fake customer data.
* Development credentials.
* Test transactions.

---

# 29. Vite Build

If the production server builds frontend assets:

```text
npm ci
npm run build
```

The resulting assets must be verified under the Laravel public asset structure.

If assets are built elsewhere, the deployment must ensure the correct production build artifacts are included.

---

# 30. Node Modules

`node_modules` should not be required at runtime.

If assets are built on Hostinger, `node_modules` may exist temporarily during the build.

Where practical, unnecessary development build dependencies should not remain in the runtime environment.

---

# 31. Laravel Cache

After environment and application configuration are confirmed, production caches may be generated.

Typical commands include:

```text
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

Route caching should only be used when the application's routes support it.

---

# 32. Cache Clearing

When configuration changes require it, clear stale cached configuration before rebuilding:

```text
php artisan config:clear
```

Do not blindly clear production caches during every request or normal application operation.

---

# 33. Optimization

Production deployment should use optimized dependencies and Laravel caches where appropriate.

The goal is to reduce:

* Application startup overhead.
* Repeated configuration loading.
* Unnecessary dependency installation.

---

# 34. Maintenance Mode

For deployments that may temporarily interrupt users, Laravel maintenance mode may be used.

Conceptually:

```text
php artisan down
```

Deploy and verify the application, then:

```text
php artisan up
```

The exact strategy depends on whether the deployment can be performed without downtime.

---

# 35. Zero-Downtime Consideration

SMEvolve's initial Hostinger deployment does not necessarily require a complex zero-downtime architecture.

However, deployments should minimize downtime by:

1. Preparing code.
2. Installing dependencies.
3. Building assets.
4. Preparing migrations.
5. Performing the final deployment steps.
6. Verifying the application.

As traffic increases, a more advanced deployment strategy can be introduced.

---

# 36. Queue Workers

If SMEvolve uses queued jobs, the production queue worker must be started or configured according to the strategy defined in:

```text
09_Storage_Queues_Scheduler.md
```

A deployment must account for currently running workers.

Workers may need to be restarted after code changes.

---

# 37. Queue Restart

Laravel provides mechanisms for safely instructing workers to reload application code.

The exact command should be included in the queue deployment procedure.

The objective is to prevent workers from continuing to execute outdated application code after deployment.

---

# 38. Scheduler

If SMEvolve uses Laravel's scheduler, Hostinger cron must execute the application's scheduler according to the schedule defined in the deployment configuration.

The scheduler must be tested after deployment.

---

# 39. Permissions Verification

After deployment verify:

```text
✓ Application files readable
✓ storage writable
✓ bootstrap/cache writable
✓ Public directory accessible
✓ .env protected
✓ Vendor dependencies readable
```

---

# 40. Production URL Test

After deployment, open:

```text
https://[PRODUCTION-DOMAIN]
```

Verify that the application loads without errors.

---

# 41. Application Smoke Test

At minimum test:

```text
✓ Homepage
✓ Authentication
✓ Login
✓ Logout
✓ User dashboard
✓ Admin Portal
✓ Forms
✓ Database reads
✓ Database writes
✓ Validation
✓ File uploads where applicable
✓ Email notifications
```

The exact list should expand according to the final SMEvolve feature set.

---

# 42. Error Verification

Check the application for:

```text
404 errors
500 errors
JavaScript errors
CSS loading errors
Database errors
Mail errors
Queue failures
```

Production users must not see Laravel debug pages.

---

# 43. Browser Verification

Test the production application using:

* Desktop browser.
* Mobile browser.
* HTTPS.
* Different authenticated roles where applicable.

Verify that Vite-generated assets load correctly.

---

# 44. Database Verification

After deployment:

```text
✓ Laravel connects
✓ Tables exist
✓ Migrations completed
✓ User records load
✓ New records can be created
✓ Existing records can be updated
```

---

# 45. Email Verification

Perform a controlled production email test.

Verify:

```text
✓ Email generated
✓ Email delivered
✓ Sender address correct
✓ Subject correct
✓ Links use HTTPS
✓ No sensitive information exposed
```

The test should use an authorized test recipient.

---

# 46. Analytics Verification

After deployment, verify that Google Analytics is receiving production traffic.

Check:

```text
✓ Correct measurement ID
✓ Production domain
✓ Page views recorded
✓ No development tracking
✓ No sensitive data sent
```

---

# 47. Search Engine Verification

Verify:

```text
✓ robots.txt accessible
✓ sitemap accessible
✓ Canonical URLs correct
✓ HTTPS URLs used
✓ Production site is not accidentally blocked
```

Search Console should be checked after the site is publicly accessible.

---

# 48. Deployment Logs

Each deployment should record:

```text
Deployment date:
Deployed commit:
Branch:
Database migration status:
Asset build status:
Queue restart status:
Scheduler status:
Smoke test result:
Deployed by:
```

---

# 49. Failed Deployment

If deployment fails:

```text
Stop
 ↓
Identify failure
 ↓
Check logs
 ↓
Determine whether database changed
 ↓
Correct issue
 ↓
Retry or rollback
```

Do not repeatedly run deployment commands without identifying the cause.

---

# 50. Rollback Strategy

A rollback may involve:

```text
Application code rollback
Database rollback
Configuration rollback
Asset rollback
```

Application code can generally be returned to a previous Git commit.

Database rollback requires greater caution because data may already have been modified.

---

# 51. Git-Based Rollback

Because production code originates from GitHub, a known-good commit should always be identifiable.

Conceptually:

```text
Current Production
       ↓
Problem detected
       ↓
Known-good commit
       ↓
Deploy previous version
       ↓
Verify
```

---

# 52. Database Rollback

Do not automatically run:

```text
php artisan migrate:rollback
```

during an incident.

Determine:

* Which migrations were executed.
* Whether data has changed.
* Whether the migration is reversible.
* Whether a backup is required.

A database restoration may be safer for serious failures.

---

# 53. Security Verification

After deployment confirm:

```text
✓ APP_DEBUG=false
✓ .env inaccessible
✓ HTTPS active
✓ No credentials exposed
✓ Production APIs protected
✓ Admin Portal protected
✓ File permissions correct
✓ Database not publicly exposed
```

---

# 54. Performance Verification

Verify:

* Page load.
* Database response.
* Asset loading.
* PHP execution.
* Memory usage.
* Hostinger resource usage.

Any unexpected resource spike should be investigated.

---

# 55. Final Deployment Checklist

```text
SOURCE
✓ Correct GitHub repository
✓ Correct production branch
✓ Known commit deployed

SERVER
✓ PHP compatible
✓ Composer available
✓ Git available
✓ Node/npm verified where required
✓ Required extensions available

APPLICATION
✓ Code deployed
✓ Composer dependencies installed
✓ .env configured
✓ APP_DEBUG=false
✓ APP_KEY configured
✓ Storage linked
✓ Permissions correct

DATABASE
✓ Connection verified
✓ Backup completed
✓ Migrations completed
✓ Seed data verified

FRONTEND
✓ Vite assets built
✓ Assets accessible
✓ No JavaScript errors
✓ No missing CSS

SERVICES
✓ Email tested
✓ Queue configured
✓ Scheduler configured
✓ Analytics verified

SECURITY
✓ HTTPS active
✓ .env protected
✓ Secrets not committed
✓ Admin access protected

VERIFICATION
✓ Homepage works
✓ Authentication works
✓ Admin Portal works
✓ Database operations work
✓ Email works
✓ Mobile layout works
```

---

# 56. Deployment Completion Criteria

A deployment is considered successful when:

✓ The intended Git commit is running in production.

✓ Laravel dependencies are installed successfully.

✓ Production environment variables are configured.

✓ Database connection works.

✓ Required migrations are complete.

✓ Vite production assets are available.

✓ Laravel storage is correctly configured.

✓ Cache configuration is valid.

✓ Queue and scheduler are operational where required.

✓ HTTPS is working.

✓ Email notifications work.

✓ Google Analytics is receiving production traffic.

✓ The Admin Portal is accessible to authorized users.

✓ No critical errors are present.

---

# 57. Next Document

The next document is:

```text
08_Frontend_Assets_And_Build.md
```

This document will define the production Vite/Node build process, asset compilation, JavaScript/CSS deployment, cache-busting, static assets, build verification, and handling of frontend assets when Hostinger is used.
