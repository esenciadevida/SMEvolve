# SMEvolve Deployment

## 01 – Deployment Overview

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

This document defines the overall production deployment architecture for SMEvolve.

The deployment architecture establishes how the application moves from local development through source control and into the Hostinger production environment.

It also defines the supporting production services required for a reliable and secure application, including:

* Email notifications.
* Google Analytics.
* Google Search Console.
* DNS.
* SSL.
* Database.
* Storage.
* Scheduled tasks.
* Queues.
* Backups.
* Monitoring.
* Logging.
* Security.
* Third-party integrations.

This document serves as the foundation for the remaining deployment documentation.

---

# 2. Deployment Objectives

The SMEvolve deployment environment must provide:

* Reliable application availability.
* Secure production configuration.
* Controlled source-code deployment.
* Protected credentials.
* Reliable database operation.
* Transactional email delivery.
* Application analytics.
* Search-engine visibility.
* Automated scheduled tasks.
* Background job processing where required.
* Backup and recovery capability.
* Monitoring and error visibility.
* Safe rollback procedures.
* Maintainable production operations.

---

# 3. Deployment Architecture

The primary deployment flow is:

```text
Local Development
        │
        │ Git
        ▼
     GitHub
        │
        │ Deployment
        ▼
    Hostinger
        │
        ├── Laravel Application
        ├── Public Assets
        ├── Database
        ├── Storage
        ├── Scheduled Tasks
        └── Queue Processing
                │
                ├── Email Provider
                ├── Google Analytics
                ├── Google Search Console
                ├── AI Services
                └── Other Approved Integrations
```

---

# 4. Source Control

GitHub is the source-control system for SMEvolve.

The production application must originate from a controlled Git repository.

The repository should contain:

* Application source code.
* Configuration templates.
* Database migrations.
* Seeders where applicable.
* Frontend source.
* Tests.
* Documentation where appropriate.

The repository must not contain production secrets.

---

# 5. GitHub Repository

The SMEvolve GitHub repository should be treated as the authoritative source of application code.

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
package.json
vite.config.*
artisan
```

The exact structure must follow Laravel 12 conventions and the existing SMEvolve codebase.

---

# 6. Git Branching

A simple controlled branching strategy should be used.

Recommended:

```text
main
│
├── feature/*
├── fix/*
└── chore/*
```

The `main` branch represents production-ready code.

Development work should not be performed directly on `main` unless the project workflow explicitly permits it.

---

# 7. Deployment Flow

The standard workflow is:

```text
Developer
   ↓
Local Development
   ↓
Testing
   ↓
Git Commit
   ↓
GitHub
   ↓
Production Verification
   ↓
Hostinger
```

Before production deployment:

* Tests should pass.
* Environment changes should be reviewed.
* Database changes should be identified.
* Asset changes should be identified.
* Third-party integration changes should be identified.

---

# 8. Production Hosting

Hostinger is the production hosting provider for SMEvolve.

The exact Hostinger hosting plan and capabilities should be verified before deployment.

The production environment must provide the resources required by Laravel 12, including the appropriate:

* PHP version.
* Database support.
* Storage.
* SSL.
* Cron support.
* SSH/Git access where available.
* Composer support or an equivalent deployment strategy.
* Required PHP extensions.

Do not assume a Hostinger feature is available without verifying the selected hosting plan.

---

# 9. Production Application

The production application consists of:

```text
Laravel 12
Blade
Vite-built assets
Alpine.js
Database
Storage
Queue processing
Scheduled tasks
Mail integration
External services
```

The application must run in production mode.

---

# 10. Production Environment

Production configuration must be isolated from development configuration.

The application should use:

```text
APP_ENV=production
APP_DEBUG=false
```

Production credentials must never be committed to GitHub.

---

# 11. Environment Variables

Sensitive configuration must be stored through the production environment configuration.

Examples include:

```text
APP_KEY
APP_URL

DB_DATABASE
DB_USERNAME
DB_PASSWORD

MAIL_HOST
MAIL_USERNAME
MAIL_PASSWORD

API credentials
AI provider credentials
Analytics configuration
Third-party service credentials
```

Actual secrets must never be included in documentation or source control.

---

# 12. Application URL

The production application should use the official SMEvolve domain.

The production `APP_URL` must match the canonical application URL.

The application should use HTTPS.

---

# 13. DNS

The SMEvolve domain must point to the Hostinger production environment.

DNS configuration should include the required:

* A records.
* CNAME records where applicable.
* MX records for email.
* SPF records.
* DKIM records.
* DMARC records.

The exact records depend on the selected Hostinger and email configuration.

---

# 14. SSL

Production traffic must use HTTPS.

The deployment must verify:

* Valid SSL certificate.
* HTTP to HTTPS redirection.
* No mixed-content errors.
* Secure cookies.
* HTTPS application URL.

The application should never intentionally serve authenticated content over plain HTTP.

---

# 15. Database

The production database must be separated from development databases.

The deployment process must support:

* Initial database creation.
* Secure credentials.
* Migrations.
* Indexes.
* Seed data where required.
* Backups.
* Recovery.

Production migrations must be reviewed before execution.

---

# 16. Database Migrations

Database changes must be delivered through Laravel migrations.

Do not manually modify production database structures unless necessary for emergency recovery.

Before running migrations:

1. Back up the database.
2. Review the migration.
3. Confirm compatibility.
4. Execute the migration.
5. Verify application functionality.

---

# 17. Storage

Laravel storage must be configured correctly for production.

The deployment must determine whether uploaded assets use:

* Local Hostinger storage.
* Object storage.
* Another approved storage provider.

User-uploaded files must not be stored in insecure publicly writable locations.

---

# 18. Queue Processing

SMEvolve may use queues for operations such as:

* Email notifications.
* Administrative notifications.
* Background processing.
* AI tasks.
* Other long-running operations.

The production queue architecture must be configured according to the Hostinger environment.

If persistent queue workers are not supported by the selected hosting plan, an appropriate alternative must be documented and implemented.

---

# 19. Scheduler

Laravel scheduled tasks must be supported in production where required.

The Hostinger environment should execute Laravel's scheduler using an appropriate cron configuration.

Typical scheduled responsibilities may include:

* Cleanup.
* Notifications.
* Maintenance tasks.
* Data processing.
* Scheduled reports.

The exact tasks must be defined by the application's feature requirements.

---

# 20. Email Notifications

SMEvolve requires reliable transactional email.

Website events may generate emails such as:

* Quote submission confirmation.
* Contact form notifications.
* Quote-related administrative notifications.
* Password/security notifications.
* System notifications.

Production email must use a proper SMTP or transactional email provider.

Do not rely on PHP's basic `mail()` implementation for critical production notifications.

---

# 21. Email Architecture

The email flow should be:

```text
SMEvolve
   ↓
Laravel Mail / Notification
   ↓
Queue where appropriate
   ↓
Email Provider
   ↓
Recipient
```

The exact email provider will be defined in the Email Deployment document.

---

# 22. Email Authentication

Production email should be configured with appropriate:

* SPF.
* DKIM.
* DMARC.

This improves deliverability and protects the SMEvolve domain from unauthorized email use.

---

# 23. Email Testing

Before production launch, verify:

* Emails are successfully sent.
* Emails are successfully received.
* Sender address is correct.
* Reply-to address is correct.
* HTML renders correctly.
* Mobile rendering works.
* Links work.
* Emails do not expose sensitive information.
* Failed delivery is handled appropriately.

---

# 24. Google Analytics

SMEvolve should use Google Analytics 4 for website analytics.

Analytics should measure useful business interactions rather than only page views.

Potential events include:

```text
page_view
quote_wizard_started
quote_wizard_completed
contact_form_submitted
phone_clicked
whatsapp_clicked
chatbot_opened
chatbot_conversation_started
```

Only events that are actually implemented should be reported to analytics.

---

# 25. Analytics Privacy

Analytics implementation must respect the SMEvolve legal and privacy requirements.

Analytics must not intentionally collect:

* Passwords.
* Authentication tokens.
* Payment credentials.
* Sensitive form values.
* Private customer information.

Where consent is legally required, the analytics implementation must integrate with the project's cookie/consent architecture.

---

# 26. Google Search Console

Google Search Console should be configured for SMEvolve.

The production setup should include:

* Domain/property verification.
* Sitemap submission.
* Indexing monitoring.
* Search performance monitoring.
* Coverage/indexing issue monitoring.

Search Console should be configured against the production domain rather than development environments.

---

# 27. Sitemap

The production website should expose a valid sitemap where applicable.

The sitemap should contain only pages intended for search-engine indexing.

Administrative pages must not appear in the public sitemap.

Legal and public website pages should be included where appropriate.

---

# 28. Robots

The production `robots.txt` must be reviewed before launch.

It should prevent indexing of private administrative areas where appropriate.

It must not accidentally block important public SMEvolve pages.

---

# 29. SEO

Production deployment must verify:

* Canonical URLs.
* Sitemap.
* Robots configuration.
* Metadata.
* Structured data.
* HTTPS URLs.
* Redirects.

Deployment must not introduce development URLs into production SEO metadata.

---

# 30. Third-Party Integrations

All external services used by SMEvolve must be documented and configured separately.

Potential integrations include:

* Email provider.
* Google Analytics.
* Google Search Console.
* AI provider.
* Payment provider if applicable.
* Messaging services.
* Other APIs required by the final application.

Each integration must have:

* Production credentials.
* Failure handling.
* Security requirements.
* Monitoring requirements.
* Documentation.

---

# 31. API Credentials

Production API credentials must:

* Be stored securely.
* Never be committed to GitHub.
* Never be displayed in the Admin Portal.
* Never be included in client-side JavaScript.
* Be rotated when necessary.

---

# 32. Error Monitoring

Production errors must be observable.

At minimum, SMEvolve should provide:

* Laravel application logs.
* Queue failure visibility.
* Server error visibility.
* Appropriate uptime monitoring.

A dedicated external error-monitoring service may be introduced if required.

---

# 33. Logging

Production logging must capture useful operational information without exposing secrets.

Do not log:

* Passwords.
* API keys.
* Tokens.
* Database credentials.
* Full sensitive customer information.

Logs should have an appropriate retention policy.

---

# 34. Backups

Production backups must cover critical application data.

At minimum:

```text
Database
Uploaded Files
Critical Configuration
```

Backups must not exist only on the same production server.

Where possible, maintain an independent backup location.

---

# 35. Backup Testing

A backup is not considered reliable until recovery has been tested.

The deployment process should periodically verify:

* Backup creation.
* Backup integrity.
* Database restoration.
* File restoration.

---

# 36. Security Hardening

Before production launch:

* Disable debugging.
* Enforce HTTPS.
* Protect environment files.
* Verify filesystem permissions.
* Review exposed directories.
* Verify authentication.
* Verify authorization.
* Verify CSRF protection.
* Verify rate limits.
* Review security headers.
* Remove development tooling.
* Remove test credentials.

---

# 37. Performance

Production should use appropriate Laravel optimization.

Where appropriate:

* Cache configuration.
* Cache routes.
* Cache views.
* Optimize Composer dependencies.
* Build production Vite assets.
* Optimize images.
* Enable appropriate database indexes.

Do not apply optimizations that conflict with application requirements.

---

# 38. Production Asset Build

Frontend assets must be built for production.

The deployment process must include:

```text
npm install / npm ci
        ↓
npm run build
        ↓
Production Vite assets
```

The exact command must follow the project's `package.json`.

Development assets must not be used as the production asset pipeline.

---

# 39. Maintenance Mode

The deployment architecture should support Laravel maintenance mode for deployments requiring temporary application downtime.

Where possible, deployments should minimize downtime.

Users should receive an appropriate maintenance page rather than technical errors.

---

# 40. Rollback

A production deployment must have a rollback strategy.

Potential rollback components include:

* Git commit rollback.
* Previous application release.
* Database recovery.
* Asset rollback.
* Configuration rollback.

Database migrations require particular care because application rollback and database rollback are not always symmetrical.

---

# 41. Production Monitoring

Monitor:

* Application availability.
* HTTP errors.
* Database health.
* Queue failures.
* Scheduled task failures.
* Email delivery.
* Storage capacity.
* Hosting resource usage.

The exact monitoring tools will be defined in the Monitoring document.

---

# 42. Deployment Security

The deployment process itself must be protected.

GitHub and Hostinger access should use:

* Strong authentication.
* Two-factor authentication where available.
* Least-privilege access.
* Secure credentials.
* Controlled administrator access.

Production credentials must not be shared through insecure channels.

---

# 43. Production Checklist

Before launch, verify:

```text
✓ GitHub repository ready
✓ Production branch confirmed
✓ Hostinger environment ready
✓ PHP version verified
✓ Required PHP extensions available
✓ Database created
✓ Environment variables configured
✓ APP_DEBUG disabled
✓ APP_KEY configured
✓ HTTPS working
✓ Domain configured
✓ DNS verified
✓ SSL verified
✓ Laravel application deployed
✓ Composer dependencies installed
✓ Vite assets built
✓ Database migrations completed
✓ Storage configured
✓ Scheduler configured
✓ Queue processing configured
✓ Email provider configured
✓ SPF configured
✓ DKIM configured
✓ DMARC configured
✓ Google Analytics configured
✓ Google Search Console configured
✓ Sitemap verified
✓ Robots verified
✓ Backups configured
✓ Error logging verified
✓ Security review completed
✓ Mobile testing completed
✓ Production smoke tests passed
```

---

# 44. Deployment Documentation Structure

The remaining deployment documentation should build upon this overview.

Recommended structure:

```text
Documentation/18_Deployment/
│
├── 01_Deployment_Overview.md
├── 02_GitHub_Repository_Setup.md
├── 03_Hostinger_Environment.md
├── 04_Domain_DNS_SSL.md
├── 05_Environment_Configuration.md
├── 06_Database_Setup.md
├── 07_Laravel_Deployment.md
├── 08_Vite_Frontend_Build.md
├── 09_Storage_Queues_Scheduler.md
├── 10_Email_Configuration.md
├── 11_Analytics_Search_Console_SEO.md
├── 12_Third_Party_Integrations.md
├── 13_Backups_Recovery.md
├── 14_Security_Hardening.md
├── 15_Monitoring_Logging.md
├── 16_Performance_Optimization.md
├── 17_Rollback_Disaster_Recovery.md
├── 18_Production_Checklist.md
├── 19_Post_Deployment_Verification.md
└── 20_Acceptance_Criteria.md
```

---

# 45. Future Deployment Evolution

The deployment architecture should allow future migration to:

* Hostinger VPS.
* Cloud infrastructure.
* Managed databases.
* Dedicated Redis.
* Object storage.
* External queue workers.
* CI/CD pipelines.
* Containerized deployment.

These should not be implemented unless required.

---

# 46. Stop Condition

This document defines the deployment architecture only.

Do not perform production deployment from this document.

Detailed implementation procedures will be defined in the subsequent Deployment documents and final deployment implementation prompt.

---

# 47. Acceptance Criteria

This overview is complete when:

✓ GitHub is established as the source-control system.

✓ Hostinger is established as the production hosting environment.

✓ Production architecture is defined.

✓ Database architecture is defined.

✓ Storage requirements are defined.

✓ Queue requirements are defined.

✓ Scheduler requirements are defined.

✓ Email requirements are defined.

✓ Google Analytics requirements are defined.

✓ Google Search Console requirements are defined.

✓ SEO deployment requirements are defined.

✓ DNS and SSL requirements are defined.

✓ Backup requirements are defined.

✓ Monitoring requirements are defined.

✓ Security requirements are defined.

✓ Rollback requirements are defined.

✓ Production verification requirements are defined.

✓ Remaining deployment documentation has a clear structure.

---

# 48. Next Document

The next document is:

```text
02_GitHub_Repository_Setup.md
```

It will define the production GitHub repository, branching, `.gitignore`, secrets protection, repository security, and the GitHub-to-Hostinger deployment relationship.
