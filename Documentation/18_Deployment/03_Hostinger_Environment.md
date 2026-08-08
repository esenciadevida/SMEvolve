# SMEvolve Deployment

## 03 – Hostinger Environment

**Project:** SMEvolve

**Module:** Deployment

**Documentation Path:** `Documentation/18_Deployment/`

**Framework:** Laravel 12

**Frontend:** Blade, Vite, Alpine.js

**Source Control:** GitHub

**Production Hosting:** Hostinger

**Document Version:** 1.0

**Status:** Draft

---

# 1. Purpose

This document defines the production hosting environment required to run SMEvolve on Hostinger.

It establishes the minimum technical requirements for:

* PHP.
* Laravel.
* Composer.
* Node.js and Vite.
* MySQL.
* Web server.
* HTTPS.
* SSH.
* Git.
* Cron.
* Queues.
* Storage.
* File permissions.
* Environment variables.
* Application caching.
* Logs.
* Backups.

The objective is to ensure that the selected Hostinger environment can support SMEvolve before production deployment begins.

---

# 2. Hosting Provider

SMEvolve will be deployed to:

**Hostinger**

Hostinger is the primary production hosting provider for the initial production environment.

The exact Hostinger plan must be confirmed before deployment because available capabilities vary by hosting tier.

---

# 3. Hosting Plan Verification

Before deployment, verify that the selected Hostinger plan supports the requirements of the SMEvolve application.

At minimum, verify:

```text
✓ PHP 8.2+ / required Laravel-compatible PHP version
✓ MySQL
✓ HTTPS / SSL
✓ Custom domain
✓ SSH access where required
✓ Git deployment/access
✓ Composer support or deployable Composer workflow
✓ Cron jobs
✓ Sufficient storage
✓ Sufficient memory
✓ Sufficient CPU resources
✓ Required PHP extensions
✓ Laravel-compatible server configuration
```

The final PHP version should be selected based on the Laravel 12 compatibility requirements and the actual Hostinger environment.

---

# 4. Production Architecture

The Hostinger production environment should follow:

```text
                         GitHub
                           │
                           │
                     Deployment
                           │
                           ▼
                    ┌─────────────┐
                    │  Hostinger  │
                    └──────┬──────┘
                           │
             ┌─────────────┼─────────────┐
             ▼             ▼             ▼
        Web Server      MySQL         Storage
             │
             ├── Laravel
             ├── Vite Assets
             ├── Scheduler
             └── Queue Processing
                           │
                           ▼
                  External Services
             ┌────────────┼─────────────┐
             ▼            ▼             ▼
          Email        Analytics       AI/API
```

---

# 5. Web Server

Hostinger must provide a web server capable of serving the Laravel application correctly.

The application must be configured so that the public web root points to Laravel's:

```text
public/
```

directory.

The entire Laravel project should not be exposed directly as a public web directory.

---

# 6. Laravel Public Directory

The following directories must not be publicly accessible:

```text
app/
bootstrap/
config/
database/
resources/
routes/
storage/
vendor/
```

Only Laravel's public assets and entry point should be directly exposed.

The production web root should effectively point to:

```text
/project/public
```

or the equivalent Hostinger-compatible configuration.

---

# 7. PHP

The production environment must use a PHP version supported by Laravel 12 and compatible with all installed SMEvolve dependencies.

The selected PHP version must be verified against:

* Laravel requirements.
* Composer dependencies.
* Required PHP extensions.
* Third-party packages.

Do not choose a PHP version solely because it is the newest available.

---

# 8. PHP Extensions

The production environment must provide the PHP extensions required by Laravel and SMEvolve.

The exact list should be determined from:

```text
composer.json
```

and the requirements of the application's installed packages.

Common requirements may include:

```text
BCMath
Ctype
cURL
DOM
Fileinfo
JSON
Mbstring
OpenSSL
PDO
PDO_MySQL
Tokenizer
XML
```

Additional extensions may be required by specific integrations.

---

# 9. Composer

Composer is required for installing Laravel's PHP dependencies.

The production environment should support Composer directly through SSH where possible.

The deployment process should use the committed:

```text
composer.lock
```

to ensure reproducible dependency installation.

Preferred production installation:

```text
composer install --no-dev --optimize-autoloader
```

The exact command should be verified against the Hostinger environment.

---

# 10. Composer Version

The Composer version used in production should be compatible with the project.

The deployment process should not unexpectedly upgrade Composer dependencies during production deployment.

The version should be verified before deployment.

---

# 11. Node.js

Node.js is required if the production environment builds SMEvolve's Vite assets on Hostinger.

The required Node.js version should be determined from:

```text
package.json
```

and the project's Vite dependencies.

If Hostinger does not provide a suitable Node.js environment for production builds, assets may instead be built through another controlled environment before deployment.

---

# 12. Vite

SMEvolve uses Vite for frontend asset compilation.

Production assets should be generated using:

```text
npm run build
```

The resulting production assets must be served from Laravel's public asset structure.

---

# 13. Frontend Build Strategy

The project must choose one of two supported approaches:

### Option A — Build on Hostinger

```text
GitHub
   ↓
Hostinger
   ↓
npm ci
   ↓
npm run build
   ↓
Production assets
```

### Option B — Build before deployment

```text
Developer / CI
      ↓
npm ci
      ↓
npm run build
      ↓
Production assets
      ↓
Hostinger
```

The final approach should be selected after verifying Hostinger's Node.js and deployment capabilities.

---

# 14. MySQL Database

Hostinger must provide a production MySQL-compatible database supported by Laravel.

The database must be:

* Separate from development.
* Protected by credentials.
* Accessible only through approved application configuration.
* Backed up regularly.

---

# 15. Database Credentials

Database credentials must be stored in the production environment.

They must not appear in:

* GitHub.
* `.env.example`.
* Documentation.
* Frontend code.
* Public configuration.

---

# 16. Database Connection

The application should use environment configuration similar to:

```text
DB_CONNECTION=mysql
DB_HOST=
DB_PORT=3306
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
```

Actual production values must only exist in the production environment.

---

# 17. Database Character Set

The production database should use an appropriate Unicode configuration.

Recommended:

```text
utf8mb4
```

The exact collation should be compatible with Laravel and the application's data requirements.

This is particularly important if SMEvolve accepts:

* Customer names.
* Business names.
* International characters.
* User-generated content.

---

# 18. Database Migrations

Production database structures must be created and modified using Laravel migrations.

The deployment process must not depend on manually recreating tables.

Before a migration:

```text
Backup
  ↓
Review migration
  ↓
Run migration
  ↓
Verify application
```

---

# 19. Storage

Hostinger storage must be sufficient for:

* Laravel application files.
* User uploads.
* Generated files.
* Logs.
* Temporary files.
* Backups where applicable.

Storage requirements should be reviewed as the application grows.

---

# 20. Laravel Storage Link

If SMEvolve uses Laravel's public storage disk, the production environment must support the required storage link.

Typical configuration:

```text
php artisan storage:link
```

The exact Hostinger filesystem configuration must be verified before executing the command.

---

# 21. File Permissions

Laravel requires appropriate filesystem permissions.

The deployment must ensure that Laravel can write to required directories such as:

```text
storage/
bootstrap/cache/
```

Permissions should be as restrictive as possible while allowing the application to operate.

Do not make the entire Laravel project world-writable.

---

# 22. SSH Access

SSH access is strongly preferred for SMEvolve deployment.

SSH may be required for:

* Git operations.
* Composer.
* Artisan commands.
* Database migrations.
* Cache management.
* Queue management.
* Scheduler configuration.
* Troubleshooting.

If the selected Hostinger plan does not provide required SSH capabilities, the deployment procedure must use an appropriate alternative.

---

# 23. Git Access

Where Hostinger supports Git-based deployment, the production environment should connect to the SMEvolve GitHub repository through a secure mechanism.

Possible approaches include:

* SSH deployment key.
* GitHub integration.
* Hostinger Git deployment.
* CI/CD deployment.

The selected approach will be documented separately.

---

# 24. Production Directory

The Laravel application should be placed in a controlled production directory.

A conceptual structure may be:

```text
/home/account/
│
├── domains/
│   └── smevolve-domain/
│       └── public_html/
│
└── smevolve/
    ├── app/
    ├── bootstrap/
    ├── config/
    ├── database/
    ├── resources/
    ├── routes/
    ├── storage/
    └── vendor/
```

The actual Hostinger directory structure will depend on the hosting configuration.

---

# 25. Public Web Root

The domain's document root should point to the Laravel `public` directory.

This is critical for protecting application internals.

Do not expose the project root directly.

---

# 26. Environment File Protection

The production `.env` file must be stored outside the publicly accessible web root where the Hostinger configuration permits this.

If the environment requires `.env` within the Laravel project directory, web-server configuration must prevent direct access.

A browser must never be able to retrieve:

```text
.env
```

---

# 27. Application Key

Laravel requires a valid production:

```text
APP_KEY
```

The production key must be generated securely and stored only in the production environment.

Do not regenerate the production application key during ordinary deployments.

Changing the key can invalidate encrypted application data and sessions.

---

# 28. Application Environment

Production configuration should include:

```text
APP_ENV=production
APP_DEBUG=false
```

Debug mode must never be enabled on the public production environment.

---

# 29. Application URL

The production configuration should define the official SMEvolve HTTPS URL:

```text
APP_URL=https://[PRODUCTION-DOMAIN]
```

The final domain will be inserted during deployment.

---

# 30. Cache

Laravel production caching should be configured appropriately.

Potential commands include:

```text
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

These commands must be executed only when the application configuration and route structure support them.

---

# 31. OPcache

Where supported by Hostinger, PHP OPcache should be enabled for production.

OPcache can improve PHP execution performance by reducing repeated script compilation.

The exact configuration depends on Hostinger's server environment.

---

# 32. Cron Jobs

Hostinger must support scheduled tasks for Laravel.

The scheduler should execute Laravel's scheduling mechanism at the required interval.

The exact command will be defined in:

```text
09_Storage_Queues_Scheduler.md
```

The scheduler must be monitored for failures.

---

# 33. Queue Processing

If SMEvolve uses Laravel queues, Hostinger must support the chosen queue strategy.

Possible implementations include:

* Persistent queue worker.
* Cron-based queue processing.
* Database queue.
* Redis where supported.
* External queue worker.

The final strategy must be based on the selected Hostinger plan and actual application requirements.

---

# 34. Redis

Redis should not be introduced automatically.

It should be used only if SMEvolve requires it for:

* Queue processing.
* Caching.
* Rate limiting.
* Session management.
* Other performance requirements.

If the selected Hostinger plan does not provide suitable Redis support, another queue/cache strategy should be used.

---

# 35. Email

Hostinger must support the chosen production email configuration.

The application should use a reliable SMTP or transactional email provider rather than depending on the server's basic PHP mail functionality.

The detailed configuration is defined in:

```text
10_Email_Configuration.md
```

---

# 36. DNS

The Hostinger environment must be connected to the SMEvolve domain.

Required DNS records may include:

```text
A
CNAME
MX
TXT
```

SPF, DKIM, and DMARC records will be defined according to the selected email provider.

---

# 37. SSL

Hostinger must provide a valid SSL certificate for the production domain.

Verify:

```text
https://smevolve-domain
```

works correctly.

HTTP requests should redirect to HTTPS where appropriate.

---

# 38. Security Headers

The production application should implement appropriate security headers.

Depending on the final architecture, these may include:

* Strict-Transport-Security.
* Content-Security-Policy.
* X-Content-Type-Options.
* Referrer-Policy.
* Permissions-Policy.

Headers must be tested to ensure they do not break legitimate application functionality.

---

# 39. Error Pages

The production environment should provide user-friendly error pages.

At minimum:

```text
404
403
419
429
500
503
```

Technical stack traces must not be exposed to users.

---

# 40. Logs

Hostinger and Laravel logs should be available for troubleshooting.

Relevant logs may include:

```text
Laravel application logs
Web-server errors
PHP errors
Queue failures
Cron failures
```

Sensitive information must not be written into logs.

---

# 41. Resource Monitoring

The Hostinger environment should be monitored for:

* CPU usage.
* Memory usage.
* Storage usage.
* Database usage.
* Process limits.
* Traffic.
* PHP execution limits.

If resource limits are repeatedly reached, the hosting plan should be reviewed.

---

# 42. PHP Limits

The production environment must be reviewed for limits such as:

* `memory_limit`
* `max_execution_time`
* `max_input_vars`
* `upload_max_filesize`
* `post_max_size`

The values should be sufficient for actual SMEvolve requirements.

Do not increase limits unnecessarily.

---

# 43. File Uploads

If SMEvolve accepts file uploads, verify:

* Maximum file size.
* Allowed MIME types.
* File validation.
* Storage location.
* Filename handling.
* Malware/security considerations.
* Access control.

Uploaded files must never be trusted solely because their extension appears safe.

---

# 44. Scheduled Maintenance

The Hostinger environment should support routine maintenance such as:

* Laravel cache clearing.
* Log rotation.
* Temporary file cleanup.
* Database maintenance.
* Backup verification.

The actual schedule will be defined in the maintenance documentation.

---

# 45. Backups

Hostinger backups may provide an additional recovery layer, but they must not necessarily be treated as the only backup strategy.

SMEvolve should maintain a documented independent backup strategy for critical production data.

---

# 46. Hostinger Access Security

Hostinger account access should use:

* Strong credentials.
* Two-factor authentication where available.
* Restricted account access.
* Secure SSH keys.
* Least privilege.

Production access should be limited to authorized personnel.

---

# 47. Development vs Production

The following environments must remain logically separated:

```text
Development
    ↓
Testing
    ↓
Production
```

Development:

```text
APP_ENV=local
APP_DEBUG=true
```

Production:

```text
APP_ENV=production
APP_DEBUG=false
```

Production credentials must never be used in local development.

---

# 48. Production Dependencies

Production should not install development-only dependencies unless explicitly required.

Composer should use:

```text
--no-dev
```

where appropriate.

This reduces:

* Attack surface.
* Storage usage.
* Deployment size.

---

# 49. Hostinger Pre-Deployment Verification

Before deploying SMEvolve, verify:

```text
✓ Hostinger account active
✓ Correct hosting plan selected
✓ Domain available/configured
✓ PHP version compatible
✓ Required PHP extensions available
✓ MySQL available
✓ Database can be created
✓ SSH available or alternative confirmed
✓ Git access available or alternative confirmed
✓ Composer available or deployment strategy confirmed
✓ Node.js available or external build strategy confirmed
✓ Cron available
✓ Queue strategy confirmed
✓ Storage sufficient
✓ SSL available
✓ Resource limits reviewed
✓ File permissions understood
✓ Backup capability confirmed
```

---

# 50. Acceptance Criteria

This document is complete when:

✓ Hostinger is confirmed as the production hosting environment.

✓ Required Laravel infrastructure is identified.

✓ PHP requirements are defined.

✓ Database requirements are defined.

✓ Composer requirements are defined.

✓ Vite/Node requirements are defined.

✓ SSH requirements are defined.

✓ Git deployment requirements are defined.

✓ Public web-root requirements are defined.

✓ Storage requirements are defined.

✓ File-permission requirements are defined.

✓ Cron requirements are defined.

✓ Queue requirements are defined.

✓ Email requirements are referenced.

✓ DNS and SSL requirements are defined.

✓ Production environment requirements are defined.

✓ Resource requirements are identified.

✓ Backup requirements are identified.

✓ Hostinger pre-deployment verification is defined.

---

# 51. Next Document

The next document is:

```text
04_Domain_DNS_SSL.md
```

This document will define the complete production domain setup, DNS records, HTTPS/SSL configuration, redirects, email-related DNS records, and verification procedures.
