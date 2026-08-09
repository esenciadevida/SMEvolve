# SMEvolve

## Prompt 025 – Hostinger Production Environment Setup

**Project:** SMEvolve

**Document Number:** 025

**Module:** Hostinger Production Infrastructure

**Source Control:** GitHub

**Production Hosting:** Hostinger

**Purpose:** Prepare the Hostinger production environment for SMEvolve without performing the final public deployment.

**Status:** Implementation Instruction

---

# 1. OBJECTIVE

Prepare the Hostinger environment required to run SMEvolve in production.

The architecture is:

```text
Developer
    ↓
GitHub
    ↓
Verified Code
    ↓
Hostinger
    ↓
Production Environment
    ↓
SMEvolve
```

This phase establishes the infrastructure.

It does **not** complete the final public launch.

---

# 2. IMPORTANT RESTRICTION

Do not:

* Delete existing Hostinger websites.
* Delete existing databases.
* Change unrelated domains.
* Change unrelated DNS records.
* Replace an existing production application.
* Modify another website hosted on the account.
* Expose credentials.
* Commit Hostinger credentials to GitHub.

If an action could affect an existing service, stop and request confirmation.

---

# 3. BEFORE STARTING

Inspect the Hostinger account and determine:

```text
Hosting plan
Domain
Current website
Available storage
Available databases
PHP support
Node.js support
SSH availability
Git support
Cron support
SSL support
Email hosting
DNS management
```

Record the relevant environment details.

Do not assume Hostinger features are identical across plans.

---

# 4. HOSTINGER ACCOUNT

Confirm that the user has access to the correct Hostinger account.

Verify:

```text
Account
Hosting plan
Domain
Control panel
Server
```

Do not share passwords or authentication codes with the AI.

---

# 5. DOMAIN

Identify the intended SMEvolve production domain.

Do not change DNS yet unless specifically instructed.

The domain should eventually point to the Hostinger production environment.

For now:

```text
Domain
   ↓
Existing configuration
```

remains unchanged unless setup requires otherwise.

---

# 6. HOSTING LOCATION

Determine where SMEvolve will be hosted.

The recommended architecture is:

```text
Hostinger
└── SMEvolve
    ├── Application
    ├── Public files
    ├── Storage
    └── Database
```

Use a dedicated directory where practical.

Do not place SMEvolve inside another application's directory.

---

# 7. APPLICATION DIRECTORY

Create or identify the appropriate application directory.

Example:

```text
/home/account/smevolve/
```

The actual Hostinger path must be determined from the account.

Do not invent server paths.

---

# 8. DOCUMENT ROOT

For a Laravel application, the public-facing document root should point to:

```text
project/public
```

rather than exposing the entire Laravel project directory.

This is critical.

Do not expose:

```text
.env
app/
config/
database/
storage/
vendor/
```

directly through the web server.

---

# 9. PHP VERSION

Determine the PHP version required by SMEvolve.

The Hostinger PHP version must be compatible with:

```text
composer.json
Laravel version
Application dependencies
```

Do not upgrade PHP simply because a newer version is available.

If the required PHP version is unavailable on the selected Hostinger plan, document the compatibility problem before continuing.

---

# 10. PHP EXTENSIONS

Verify the PHP extensions required by SMEvolve.

Depending on the application, these may include:

```text
OpenSSL
PDO
Mbstring
Tokenizer
XML
Ctype
JSON
Fileinfo
BCMath
Curl
```

Only enable extensions actually required by the project.

---

# 11. COMPOSER

Verify whether Composer is available through Hostinger SSH.

If available, verify:

```text
composer --version
```

Use the project's `composer.lock`.

Do not run unrestricted dependency upgrades in production.

---

# 12. NODE.JS

Determine whether production deployment requires Node.js.

If frontend assets are prebuilt before deployment, Node.js may not be required on the production server.

Prefer the simplest reliable architecture.

Do not install unnecessary server-side tooling.

---

# 13. DATABASE

Determine the database required by SMEvolve.

Verify Hostinger supports the required database engine and version.

For a Laravel application, this will commonly be MySQL/MariaDB.

Do not create the production database yet unless the deployment sequence requires it.

---

# 14. PRODUCTION DATABASE

When the database is created, use:

```text
Dedicated database
Dedicated database user
Strong password
Minimum required privileges
```

Do not use a shared database account unnecessarily.

---

# 15. DATABASE CREDENTIALS

Production database credentials must:

```text
Never be committed to GitHub
Never be placed in source code
Never be placed in documentation
Never be exposed in screenshots
```

They belong in the production environment configuration.

---

# 16. ENVIRONMENT CONFIGURATION

SMEvolve production configuration will use a production `.env`.

The production `.env` must remain on Hostinger.

It must not be committed to GitHub.

Required values will be configured during the deployment phase.

---

# 17. APPLICATION ENVIRONMENT

Production must use:

```text
APP_ENV=production
APP_DEBUG=false
```

Do not enable production debug mode.

---

# 18. APPLICATION URL

The production application URL must use the actual SMEvolve domain.

Do not hard-code a temporary localhost URL.

The final value should be configured during production deployment.

---

# 19. APP KEY

Laravel requires a production application key.

A secure production key must be generated/configured for SMEvolve.

Do not reuse:

```text
Development APP_KEY
Testing APP_KEY
Another application's APP_KEY
```

---

# 20. STORAGE PERMISSIONS

Verify that Laravel's required directories are writable.

Typically:

```text
storage/
bootstrap/cache/
```

must have appropriate permissions.

Do not make the entire application directory globally writable.

Avoid insecure permissions such as:

```text
777
```

unless there is a very specific, documented reason.

---

# 21. SYMBOLIC LINKS

If SMEvolve uses Laravel public storage, ensure the appropriate storage link exists.

Typically:

```text
public/storage
    ↓
storage/app/public
```

Use the deployment method appropriate to the Hostinger environment.

---

# 22. WEB SERVER

Determine whether Hostinger uses Apache, LiteSpeed, or another supported web server configuration for the selected hosting plan.

The application must be configured according to the actual Hostinger environment.

Do not assume server configuration.

---

# 23. LARAVEL REWRITES

Verify that Laravel routing works correctly through the Hostinger web server.

Requests such as:

```text
/
/login
/admin
/api/...
```

must be routed correctly.

The server must not expose Laravel source files.

---

# 24. HTTPS

SMEvolve production must use HTTPS.

SSL will be configured as part of the domain and production deployment process.

Do not treat HTTP as the final production state.

---

# 25. SSL

Determine the SSL option available through Hostinger.

The final production configuration should ensure:

```text
https://domain
```

works correctly.

Certificate renewal should be automatic where supported.

---

# 26. REDIRECT HTTP → HTTPS

After SSL is active, configure the application/server so normal HTTP traffic redirects to HTTPS.

Do not create redirect loops.

---

# 27. SECURITY HEADERS

Review appropriate production security headers.

Depending on the application architecture, consider:

```text
Content-Security-Policy
X-Content-Type-Options
Referrer-Policy
Permissions-Policy
Strict-Transport-Security
```

Only implement headers compatible with SMEvolve.

Do not break legitimate application functionality.

---

# 28. DIRECTORY EXPOSURE

Verify that users cannot directly browse:

```text
.env
storage/
vendor/
config/
app/
database/
```

The public document root must be properly configured.

---

# 29. LOGGING

Production logging must remain enabled at an appropriate level.

Do not expose application logs publicly.

Laravel logs should remain within protected server storage.

---

# 30. ERROR PAGES

Production should display user-friendly error pages.

Users should not receive:

```text
Stack traces
Database credentials
File paths
Debug information
Environment variables
```

---

# 31. CRON

Determine whether SMEvolve requires scheduled tasks.

If Laravel Scheduler is used, configure the appropriate Hostinger cron job.

Typical architecture:

```text
Hostinger Cron
      ↓
Laravel Scheduler
      ↓
Scheduled Tasks
```

Use the actual command required by the project.

Do not create unnecessary cron jobs.

---

# 32. QUEUES

Determine whether SMEvolve uses Laravel queues.

If queues are required:

```text
Queue Driver
    ↓
Worker
    ↓
Jobs
```

Determine how Hostinger will maintain the worker.

Possible mechanisms depend on the hosting plan.

Do not assume long-running workers are supported.

---

# 33. QUEUE FAILURE HANDLING

If queues are used, verify:

```text
Failed jobs
Retry behavior
Logging
Worker restart strategy
```

Do not silently discard failed jobs.

---

# 34. FILE STORAGE

Determine how SMEvolve stores uploaded files.

Potential options include:

```text
Hostinger local storage
Object storage
Third-party storage
```

Use the architecture already approved in the project documentation.

---

# 35. EMAIL INFRASTRUCTURE

SMEvolve requires email notifications.

Determine the production email provider.

Possible architecture:

```text
SMEvolve
   ↓
SMTP / Email Provider
   ↓
Recipient
```

Do not use personal credentials.

Use a dedicated application email account or approved transactional email provider.

---

# 36. EMAIL CREDENTIALS

Production email credentials must remain outside GitHub.

Configure them through the Hostinger production environment.

Do not place them in:

```text
README
Documentation
GitHub Actions
Source code
```

unless they are non-sensitive public configuration values.

---

# 37. GOOGLE ANALYTICS

Google Analytics remains separate from the Admin Portal.

The architecture is:

```text
SMEvolve Website
      ↓
Google Analytics 4
      ↓
Google Analytics Dashboard
```

Do not create a Google Analytics dashboard inside the SMEvolve Admin Portal.

GA4 production configuration will be completed during the appropriate application configuration phase.

---

# 38. CHATBOT

The chatbot must use production-safe configuration.

External AI credentials must remain outside GitHub.

Configure production AI credentials only through secure environment configuration.

Do not use development credentials in production.

---

# 39. SEARCH

The production search engine must use the approved search architecture.

Do not connect production to a development/test search index.

Search credentials must remain secure.

---

# 40. ADMIN PORTAL

The Admin Portal must be protected.

Production administrators must authenticate through the application's approved authentication system.

Do not create a universal default administrator password.

---

# 41. ADMIN SECURITY

Verify:

```text
Authentication
Authorization
Role permissions
Session security
Password security
CSRF protection
Rate limiting where appropriate
```

Do not expose administrative routes unnecessarily.

---

# 42. BACKUPS

Before production launch, verify Hostinger backup functionality.

Determine:

```text
Backup frequency
Retention
Database backup
File backup
Restore procedure
```

Do not assume that having backups means the restore procedure has been tested.

---

# 43. BACKUP PRINCIPLE

The production system should have a recovery strategy:

```text
Production
    ↓
Backup
    ↓
Restore capability
```

A backup that cannot be restored reliably should not be treated as a complete disaster-recovery solution.

---

# 44. MONITORING

Determine what Hostinger monitoring is available.

At minimum, monitor:

```text
Website availability
Application errors
Database health
Disk usage
Resource usage
SSL status
```

---

# 45. RESOURCE LIMITS

Check Hostinger resource limits relevant to SMEvolve:

```text
CPU
RAM
Storage
Database connections
PHP workers
Execution time
Cron limits
Email limits
```

Document any limitations that could affect the application.

---

# 46. PERFORMANCE

Before launch, verify:

```text
Application caching
Configuration caching
Route caching where appropriate
Frontend asset optimization
Database indexing
Compression
```

Do not enable caching blindly if the application requires dynamic behavior.

---

# 47. CACHE SAFETY

After deployment, clear stale caches when appropriate.

Do not cache:

```text
User-specific data
Admin-specific pages
Sensitive responses
```

unless the application architecture explicitly supports safe caching.

---

# 48. DNS

Do not change DNS until the application is ready for the production domain.

The DNS process will eventually be:

```text
Domain
   ↓
Hostinger
   ↓
Production application
```

Use the DNS records provided by Hostinger.

Do not invent IP addresses.

---

# 49. SUBDOMAIN OPTION

If staging is required, consider:

```text
staging.example.com
```

rather than testing directly on the production domain.

If staging is not required, do not create unnecessary infrastructure.

---

# 50. STAGING ENVIRONMENT

If Hostinger resources allow it and the project requires staging:

```text
GitHub
  ├── Production
  │      ↓
  │   Hostinger
  │
  └── Staging
         ↓
      Hostinger
```

Do not allow staging credentials to access production services.

---

# 51. DEPLOYMENT USER

Where possible, use an appropriate deployment account or SSH user rather than sharing the main Hostinger account credentials.

Never put Hostinger passwords into GitHub.

---

# 52. SSH

If SSH is available:

Verify:

```text
SSH access
Authentication method
PHP CLI
Composer
Git
Required commands
```

Use SSH keys where supported.

Do not expose private SSH keys.

---

# 53. GITHUB → HOSTINGER

The final deployment connection may use:

```text
Git
SSH
Hostinger Git deployment
CI/CD
Manual deployment
```

The exact method should be selected based on Hostinger's capabilities and the approved deployment architecture.

Do not automatically implement a deployment pipeline yet.

---

# 54. DEPLOYMENT METHOD

Before selecting the final deployment mechanism, evaluate:

```text
Hostinger Git support
SSH availability
GitHub integration
CI/CD requirements
Application complexity
Rollback requirements
```

Select the simplest reliable method.

---

# 55. ROLLBACK

The production deployment strategy must allow rollback.

At minimum:

```text
Known stable Git commit
        ↓
Deployment
        ↓
Problem
        ↓
Rollback to known stable version
```

Do not deploy without understanding how the previous stable version can be restored.

---

# 56. PRODUCTION DATABASE MIGRATIONS

Do not run production migrations blindly.

Before applying migrations:

```text
Backup database
Review migration
Test migration
Confirm compatibility
Apply migration
Verify application
```

The detailed database deployment process belongs to the next deployment phase.

---

# 57. PRODUCTION DATA

Never overwrite existing production data during deployment.

If a production database already exists, treat it as protected infrastructure.

---

# 58. EMAIL TESTING

Before final launch, verify:

```text
Password reset email
Contact notifications
System notifications
Admin notifications
Other configured transactional emails
```

Use test recipients before switching fully to production recipients.

---

# 59. EXTERNAL SERVICES

Create a production configuration checklist for:

```text
Google Analytics
Email
AI/chatbot
Search
Payment services if applicable
Storage
Other APIs
```

Every service should have:

```text
Production credentials
Secure configuration
Failure behavior
Monitoring
```

---

# 60. ENVIRONMENT VARIABLE CHECKLIST

Prepare the production configuration list.

Typical categories:

```text
Application
Database
Mail
AI
Search
Storage
Analytics
Third-party APIs
```

Only variables actually used by SMEvolve should be included.

---

# 61. DO NOT COMMIT PRODUCTION ENVIRONMENT

The production `.env` must never be pushed to GitHub.

The repository should contain:

```text
.env.example
```

not:

```text
.env
```

---

# 62. PRODUCTION DEBUGGING

Never solve production problems by leaving:

```text
APP_DEBUG=true
```

enabled permanently.

If debugging is temporarily required:

```text
Enable carefully
Investigate
Disable
Verify
```

---

# 63. SECURITY INCIDENT PRINCIPLE

If a production credential is exposed:

```text
Revoke
Rotate
Replace
Audit
```

Do not simply delete the value from the current file.

---

# 64. HOSTINGER SETUP CHECKLIST

Before moving to final deployment:

```text
☐ Correct Hostinger account
☐ Correct hosting plan
☐ Correct domain
☐ Application directory prepared
☐ Document root identified
☐ PHP version confirmed
☐ Required PHP extensions confirmed
☐ Composer availability checked
☐ Node requirement determined
☐ Database compatibility confirmed
☐ SSL capability confirmed
☐ SSH capability checked
☐ Cron requirement identified
☐ Queue requirement identified
☐ Storage requirement identified
☐ Email requirement identified
☐ Backup capability checked
☐ Resource limits reviewed
```

---

# 65. DO NOT LAUNCH YET

At the end of Prompt 025, the environment should be **prepared**, not necessarily publicly live.

The next stage will handle:

```text
GitHub
   ↓
Hostinger
   ↓
Application Deployment
   ↓
Database
   ↓
Environment Variables
   ↓
Domain
   ↓
SSL
   ↓
Production Verification
```

---

# 66. SUCCESS CRITERIA

Prompt 025 is complete when:

```text
Hostinger
    │
    ├── Correct hosting environment
    ├── Correct PHP environment
    ├── Correct application directory
    ├── Database capability confirmed
    ├── SSL capability confirmed
    ├── SSH/Git capability confirmed
    ├── Email capability confirmed
    ├── Cron/queue requirements identified
    ├── Backup capability confirmed
    └── Resource limits understood
```

No destructive production changes should have occurred.

---

# 67. COMPLETION REPORT

After completing this prompt, report:

```text
Hostinger Setup Status:
[Complete / Incomplete]

Hosting Plan:
[Plan]

Domain:
[Domain]

PHP Version:
[Version]

Laravel Compatibility:
[Confirmed / Issue]

Composer:
[Available / Not Available]

Node.js:
[Required / Not Required / Version]

Database:
[Available / Issue]

SSH:
[Available / Not Available]

Git:
[Available / Not Available]

SSL:
[Available / Not Configured]

Cron:
[Required / Not Required]

Queue:
[Required / Not Required]

Storage:
[Configuration]

Email:
[Provider / Configuration Status]

Backups:
[Available / Configuration]

Resource Limits:
[Summary]

DNS:
[Not Changed / Changed]

Production Deployment:
[Not Started]

Issues:
[List]

Next Step:
[Production Deployment & Database Configuration]
```

---

# 68. FINAL INSTRUCTION

Prepare the Hostinger infrastructure carefully.

Do not:

* Expose credentials.
* Commit production secrets.
* Delete existing applications.
* Delete existing databases.
* Change unrelated DNS.
* Enable production debug mode.
* Deploy prematurely.
* Connect CI directly to production.
* Use development credentials in production.

The objective is to reach:

```text
GitHub
   ↓
Verified SMEvolve
   ↓
Prepared Hostinger Environment
```

The next phase will perform the controlled **SMEvolve production deployment to Hostinger**.
