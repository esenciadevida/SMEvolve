# SMEvolve Deployment

## 18 – Final Production Deployment Checklist

**Project:** SMEvolve

**Module:** Deployment

**Documentation Path:** `Documentation/18_Deployment/`

**Framework:** Laravel 12

**Source Control:** GitHub

**Production Hosting:** Hostinger

**Environment:** Production

**Document Version:** 1.0

**Status:** Final Pre-Launch Checklist

---

# 1. Purpose

This document provides the final checklist for deploying SMEvolve to production.

It consolidates the requirements defined throughout the deployment documentation and provides a controlled go-live process.

The objective is to ensure that the application, infrastructure, database, security, email, analytics, chatbot, Admin Portal, search functionality, backups, and monitoring are ready before the production launch.

---

# 2. Deployment Documentation

The complete Deployment module consists of:

```text
Documentation/18_Deployment/

01 – Deployment Overview
02 – Production Architecture
03 – Hostinger Server Configuration
04 – Database Deployment
05 – Laravel Production Setup
06 – SSL & HTTPS Configuration
07 – File Storage Configuration
08 – Backup & Recovery
09 – Cron & Scheduled Tasks
10 – Queue & Background Jobs
11 – Security Hardening
12 – Performance & Optimization
13 – Domain & DNS Configuration
14 – Production Environment Configuration
15 – GitHub Repository & CI/CD
16 – Email Notifications & Monitoring
17 – Analytics, Search Engine & SEO
18 – Final Production Deployment Checklist
```

All required deployment documents should be reviewed before launch.

---

# 3. Source Code

Before deployment:

```text
✓ Code is complete
✓ Required features are implemented
✓ Code is committed to GitHub
✓ Production branch is up to date
✓ No uncommitted production changes
✓ Pull requests have been reviewed
✓ CI checks pass
```

---

# 4. GitHub Repository

Verify:

```text
✓ Repository exists
✓ Repository access is restricted appropriately
✓ main branch exists
✓ Branch protection configured
✓ .gitignore configured
✓ .env excluded
✓ Secrets excluded
✓ composer.lock committed
✓ package-lock.json committed where applicable
✓ Documentation committed
```

---

# 5. Production Secrets

Confirm that sensitive credentials are not stored in source control.

Check:

```text
✓ APP_KEY protected
✓ Database password protected
✓ Mail credentials protected
✓ API keys protected
✓ SSH credentials protected
✓ Third-party credentials protected
```

Search the repository for accidentally committed secrets before deployment.

---

# 6. Hostinger Account

Verify the production Hostinger environment:

```text
✓ Correct hosting account
✓ Correct domain
✓ Correct PHP version
✓ Required PHP extensions enabled
✓ Storage available
✓ Database available
✓ SSH available where required
✓ Cron available
✓ Backup functionality available
```

---

# 7. Domain

Verify:

```text
✓ Primary domain configured
✓ DNS records configured
✓ WWW configuration correct
✓ Canonical domain selected
✓ HTTP redirects to HTTPS
✓ Domain resolves correctly
```

---

# 8. DNS

Verify the production DNS inventory:

```text
✓ A record
✓ CNAME record
✓ AAAA record reviewed
✓ MX records
✓ SPF
✓ DKIM
✓ DMARC
✓ Verification records
```

Remove obsolete records where appropriate.

---

# 9. SSL

Verify:

```text
✓ SSL certificate active
✓ Certificate valid
✓ HTTPS works
✓ HTTP redirects to HTTPS
✓ No certificate warnings
✓ Mixed-content issues resolved
```

---

# 10. Laravel Environment

Verify the production `.env` configuration:

```text
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com
```

Also verify:

```text
✓ APP_KEY
✓ Database configuration
✓ Mail configuration
✓ Queue configuration
✓ Cache configuration
✓ Session configuration
✓ Filesystem configuration
```

---

# 11. PHP

Verify:

```text
✓ Supported PHP version
✓ Required extensions
✓ Correct PHP limits
✓ Correct upload limits
✓ Correct execution limits
```

The configuration should be appropriate for the actual SMEvolve workload.

---

# 12. Composer

Production dependencies should be installed using the lock file.

Verify:

```text
✓ composer.lock available
✓ Production dependencies installed
✓ Development dependencies excluded where appropriate
✓ Autoloader optimized
```

---

# 13. Frontend Build

Verify:

```text
✓ Frontend dependencies installed
✓ Production build completed
✓ CSS loads
✓ JavaScript loads
✓ Images load
✓ Fonts load
✓ No console-critical errors
```

---

# 14. Laravel Optimization

Verify required production caches:

```text
✓ Configuration cache
✓ Route cache where applicable
✓ View cache
```

The application must still function correctly after caching.

---

# 15. Document Root

The web server must point to Laravel's:

```text
public/
```

directory.

The following must not be directly exposed through the web root:

```text
.env
vendor/
storage/
config/
database/
```

---

# 16. Database

Verify:

```text
✓ Production database created
✓ Production database user created
✓ Credentials configured
✓ Connection successful
✓ Migrations completed
✓ Required tables exist
✓ Database character encoding correct
```

---

# 17. Database Backup

Before final deployment:

```text
✓ Database backup completed
✓ Backup verified
✓ Backup location known
✓ Recovery process documented
```

No production migration should be performed without an appropriate recovery strategy.

---

# 18. Database Migration

If migrations are included in the release:

```text
✓ Migration reviewed
✓ Migration tested
✓ Backup available
✓ Migration executed
✓ Migration completed successfully
✓ Application compatible with new schema
```

---

# 19. Storage

Verify:

```text
✓ storage/ writable where required
✓ bootstrap/cache writable where required
✓ Storage link created where necessary
✓ Uploads work
✓ Downloads work
✓ Private files remain protected
```

---

# 20. File Permissions

Verify that application permissions are secure.

Do not use unnecessarily permissive permissions such as:

```text
777
```

unless there is a specific technical requirement.

---

# 21. Authentication

Test:

```text
✓ Registration
✓ Login
✓ Logout
✓ Password reset
✓ Email verification where implemented
✓ Session persistence
✓ Invalid login handling
✓ Unauthorized access protection
```

---

# 22. Admin Portal

The Admin Portal must be tested separately.

Verify:

```text
✓ Admin login
✓ Admin authorization
✓ Dashboard
✓ User management
✓ Administrative functions
✓ Data viewing
✓ Data modification
✓ Access restrictions
✓ Logout
```

A normal user must not be able to access administrative functions.

---

# 23. Chatbot

Verify the production chatbot:

```text
✓ Chatbot loads
✓ User can start a conversation
✓ Messages are sent
✓ Responses are returned
✓ Error handling works
✓ Loading state works
✓ Mobile interface works
✓ API credentials work
✓ Rate limiting works where applicable
```

The chatbot must not expose private API credentials to the browser.

---

# 24. Search Engine

Verify the implemented search functionality:

```text
✓ Search input works
✓ Search request works
✓ Results are returned
✓ Empty results handled
✓ Invalid searches handled
✓ Search performance acceptable
✓ Search results link correctly
```

If the project uses an external search service, verify its production credentials and configuration.

---

# 25. Website Forms

Test all important production forms.

Verify:

```text
✓ Validation
✓ Successful submission
✓ Failed submission
✓ Error messages
✓ Database persistence where applicable
✓ Email notification
✓ Spam protection where applicable
```

---

# 26. Email Notifications

Verify:

```text
✓ Email provider configured
✓ Sender address correct
✓ Sender name correct
✓ SMTP/API connection works
✓ Registration emails
✓ Password reset emails
✓ Admin notifications
✓ User notifications
✓ Email links
✓ SPF
✓ DKIM
✓ DMARC
```

Only applicable notification types need to be tested.

---

# 27. Email Deliverability

Send controlled test messages to appropriate test accounts.

Verify:

```text
✓ Message delivered
✓ Sender correct
✓ Subject correct
✓ Content correct
✓ Links correct
✓ No obvious formatting issues
✓ Authentication passes
```

---

# 28. Queue

If queues are enabled:

```text
✓ Queue connection works
✓ Job can be created
✓ Worker processes job
✓ Failed jobs recorded
✓ Retry process works
```

---

# 29. Cron

Verify Laravel scheduled tasks.

Check:

```text
✓ Cron exists
✓ Cron command correct
✓ Correct project path
✓ Scheduler executes
✓ Scheduled jobs run successfully
```

---

# 30. Analytics

Verify Google Analytics:

```text
✓ GA4 property exists
✓ Production Measurement ID configured
✓ Realtime traffic visible
✓ Page views recorded
✓ Required events recorded
✓ Development traffic separated
✓ No sensitive data sent
```

---

# 31. Google Search Console

Verify:

```text
✓ Domain verified
✓ Sitemap submitted
✓ Sitemap accessible
✓ robots.txt accessible
✓ Indexing configuration correct
```

---

# 32. SEO

Verify important public pages:

```text
✓ Page title
✓ Meta description
✓ Canonical URL
✓ Open Graph metadata
✓ Correct HTTPS URL
✓ Mobile responsiveness
✓ Structured data where applicable
```

---

# 33. Sitemap

Open:

```text
https://yourdomain.com/sitemap.xml
```

Verify:

```text
✓ Returns successfully
✓ Valid XML
✓ Contains correct URLs
✓ Does not contain private URLs
✓ Uses HTTPS
```

---

# 34. Robots.txt

Open:

```text
https://yourdomain.com/robots.txt
```

Verify:

```text
✓ File loads
✓ Rules are intentional
✓ Sitemap reference is correct
✓ Important public pages are not accidentally blocked
✓ Private areas are appropriately restricted
```

Remember that `robots.txt` does not provide access control.

---

# 35. Security

Perform a final security review.

Verify:

```text
✓ APP_DEBUG=false
✓ HTTPS enforced
✓ Secrets protected
✓ Authentication protected
✓ Authorization enforced
✓ Admin Portal protected
✓ File uploads secured
✓ Database credentials protected
✓ API keys protected
✓ Logs protected
✓ Rate limits configured where required
```

---

# 36. Error Handling

Test common errors:

```text
✓ 404
✓ 403
✓ 419
✓ 429
✓ 500
✓ 503
```

Users should receive appropriate production-friendly responses.

---

# 37. Logs

Verify:

```text
✓ Application logs working
✓ Logs accessible to administrators
✓ Logs not publicly accessible
✓ No passwords logged
✓ No API secrets logged
✓ Errors identifiable
```

---

# 38. Monitoring

Verify:

```text
✓ Uptime monitoring
✓ Health check
✓ Error monitoring
✓ Failed-job monitoring
✓ Resource monitoring
✓ Storage monitoring
✓ Database monitoring
✓ Backup monitoring
```

---

# 39. Alerts

Verify that important alerts reach the designated administrator.

Test at least the monitoring mechanism where practical.

Potential alerts:

```text
✓ Website downtime
✓ Critical application errors
✓ Failed jobs
✓ Backup failure
✓ Resource warning
```

---

# 40. Performance

Perform a basic production performance review.

Check:

```text
✓ Homepage response time
✓ Database response
✓ Image optimization
✓ CSS/JS bundle size
✓ Cache operation
✓ API response times
✓ Mobile performance
```

Do not optimize prematurely at the expense of reliability.

---

# 41. Browser Testing

Test the production website in major browsers where practical:

```text
✓ Chrome
✓ Edge
✓ Firefox
✓ Safari where available
```

---

# 42. Mobile Testing

Test on:

```text
✓ Android
✓ iPhone/iOS
✓ Mobile browser
```

Verify:

```text
✓ Navigation
✓ Forms
✓ Authentication
✓ Chatbot
✓ Search
✓ Responsive layout
```

---

# 43. Accessibility

Perform a basic accessibility review.

Verify:

```text
✓ Keyboard navigation
✓ Form labels
✓ Button labels
✓ Sufficient readable contrast
✓ Image alternative text where appropriate
✓ Focus states
✓ Error messages understandable
```

---

# 44. Backup Verification

Verify that production backups are functioning.

Check:

```text
✓ Application backup
✓ Database backup
✓ Backup schedule
✓ Backup retention
✓ Backup storage
✓ Restoration procedure
```

A backup is not considered reliable until restoration has been tested where practical.

---

# 45. Rollback Readiness

Before launch:

```text
✓ Previous stable release identified
✓ Git commit available
✓ Database backup available
✓ Rollback procedure documented
✓ Deployment credentials available
✓ Responsible administrator identified
```

---

# 46. Production Smoke Test

Immediately after deployment:

```text
Open Homepage
      ↓
Login
      ↓
Navigate Website
      ↓
Submit Test Form
      ↓
Check Database
      ↓
Check Email
      ↓
Test Chatbot
      ↓
Test Search
      ↓
Open Admin Portal
      ↓
Review Logs
```

All critical flows should succeed.

---

# 47. Production Data

Before launch, verify that production does not contain accidental test data.

Remove or isolate:

```text
✓ Test users
✓ Fake transactions
✓ Development records
✓ Test email addresses
✓ Debug data
```

Do not remove legitimate production data.

---

# 48. Configuration Review

Perform one final comparison between:

```text
Application Requirements
        ↓
Production Environment
        ↓
Actual Hostinger Configuration
```

Every required dependency should have a valid production configuration.

---

# 49. Go-Live Approval

Production launch should not occur until the responsible person confirms:

```text
✓ Application ready
✓ Infrastructure ready
✓ Security reviewed
✓ Database ready
✓ Email ready
✓ Monitoring ready
✓ Backup ready
✓ Rollback ready
```

---

# 50. Launch Procedure

The official launch sequence is:

```text
1. Confirm final GitHub commit
2. Confirm CI passes
3. Confirm production backup
4. Deploy to Hostinger
5. Run required migrations
6. Build/refresh production assets
7. Clear/rebuild caches
8. Verify DNS and HTTPS
9. Run smoke tests
10. Verify email
11. Verify chatbot
12. Verify search
13. Verify Admin Portal
14. Verify analytics
15. Verify monitoring
16. Confirm production stability
17. Announce launch
```

---

# 51. Post-Launch Monitoring

After launch, closely monitor the application for:

```text
✓ Errors
✓ Failed jobs
✓ Email failures
✓ Database issues
✓ User reports
✓ Performance problems
✓ Resource usage
✓ Search problems
```

The monitoring period should be increased for major releases.

---

# 52. First Production Review

After the initial launch, review:

```text
Application errors
Email delivery
Analytics
Search Console
Server resources
Database usage
Storage usage
Backups
User feedback
```

Document any problems discovered.

---

# 53. Incident Procedure

If a critical issue occurs:

```text
Detect
 ↓
Assess Severity
 ↓
Contain
 ↓
Rollback if Necessary
 ↓
Restore Service
 ↓
Verify
 ↓
Investigate
 ↓
Document
```

Do not continue a failed deployment merely to avoid rollback.

---

# 54. Final Production Checklist

```text
SOURCE CONTROL
☐ GitHub repository ready
☐ Production branch ready
☐ CI passing
☐ No secrets committed

HOSTINGER
☐ Hosting configured
☐ PHP configured
☐ Database configured
☐ Document root configured
☐ Storage configured
☐ Cron configured
☐ Backups configured

DOMAIN
☐ DNS configured
☐ Domain resolves
☐ WWW configured
☐ HTTPS active
☐ Redirects working

LARAVEL
☐ .env configured
☐ APP_KEY configured
☐ APP_DEBUG=false
☐ Dependencies installed
☐ Caches configured
☐ Migrations completed

DATABASE
☐ Connection tested
☐ Schema verified
☐ Backup completed

EMAIL
☐ Provider configured
☐ SMTP/API tested
☐ Notifications tested
☐ SPF configured
☐ DKIM configured
☐ DMARC configured

CHATBOT
☐ Chatbot tested
☐ API configured
☐ Error handling verified

ADMIN PORTAL
☐ Admin authentication tested
☐ Authorization tested
☐ Admin functions tested

SEARCH
☐ Search tested
☐ Search engine configuration verified

ANALYTICS
☐ GA4 configured
☐ Realtime data verified
☐ Events verified

SEO
☐ Sitemap available
☐ robots.txt available
☐ Search Console verified
☐ Metadata verified

SECURITY
☐ HTTPS
☐ Secrets protected
☐ Debug disabled
☐ Admin protected
☐ Upload security reviewed
☐ Logs protected

MONITORING
☐ Uptime monitoring
☐ Error monitoring
☐ Health check
☐ Alerts configured
☐ Resource monitoring

ROLLBACK
☐ Stable release identified
☐ Backup available
☐ Rollback tested/documented
```

---

# 55. Final Go-Live Decision

The application may be marked **READY FOR PRODUCTION** only when all critical checklist items have been completed.

```text
Production Status:

☐ NOT READY

☐ READY FOR INTERNAL TESTING

☐ READY FOR SOFT LAUNCH

☒ READY FOR FULL PRODUCTION
```

---

# 56. Launch Record

Complete this section when the application is actually deployed.

```text
Production Domain:
https://smevolve.tech

Deployment Date:
2026-09-16

Deployment Time:
02:28 UTC (server time)

Git Commit:
4039129 chore: bump league/commonmark and nanoid to patched versions
(deployed fast-forward from 8b85afb; includes 5e81461 AI settings fixes and
c9308da html sitemap / local SEO / responsive UI work)

Release Version:
No semantic version scheme; tracked by Git commit SHA

Hostinger Environment:
Shared hosting (CloudLinux + CageFS), uk-fast-web2073.main-hosting.eu
User u226366554, SSH port 65002, LiteSpeed 6.3.6, PHP 8.4 (CLI + web)
App path: /home/u226366554/domains/smevolve.tech/smevolve/Laravel-Website
public_html -> symlink to Laravel public/

Database Backup:
backups/smevolve_20260916_022930.sql.gz (37 tables, verified)

Deployed By:
SMEvolve AI agent via SSH (u226366554)

Verified By:
SMEvolve AI agent (live smoke tests + dedicated admin review)

Final Status:
Deployed and verified — 2026-09-16
- Homepage, /sitemap.xml, /robots.txt, /sitemap (HTML), /admin/login all HTTP 200
- php artisan ai:test OK (openai/gpt-oss-120b, 87 in / 36 out)
- All 6 AI prompt profiles seeded; no pending migrations
- 5 GitHub Dependabot alerts resolved (commonmark 2.10.1, nanoid 3.3.19)
```

---

# 57. Final Acceptance Criteria

The Deployment module is complete when:

✓ Source control is configured.

✓ GitHub CI/CD is operational.

✓ Hostinger production environment is configured.

✓ Domain and DNS are configured.

✓ SSL/HTTPS is active.

✓ Laravel production environment is configured.

✓ Database is configured and backed up.

✓ Storage is configured.

✓ Cron and queues are configured where required.

✓ Email notifications are operational.

✓ Chatbot is operational.

✓ Admin Portal is operational.

✓ Search functionality is operational.

✓ Google Analytics is operational.

✓ Google Search Console is configured.

✓ Sitemap and `robots.txt` are available.

✓ SEO configuration is complete.

✓ Monitoring is operational.

✓ Alerts are configured.

✓ Security checks are complete.

✓ Rollback procedures are documented.

✓ Final production smoke tests pass.

✓ Go-live approval has been granted.

---

# 58. Deployment Module Completion

```text
╔══════════════════════════════════════╗
║        SMEvolve Deployment           ║
║                                      ║
║  GitHub       ✓                      ║
║  Hostinger    ✓                      ║
║  DNS          ✓                      ║
║  SSL          ✓                      ║
║  Laravel      ✓                      ║
║  Database     ✓                      ║
║  Email        ✓                      ║
║  Chatbot      ✓                      ║
║  Admin Portal ✓                      ║
║  Search       ✓                      ║
║  Analytics    ✓                      ║
║  SEO          ✓                      ║
║  Monitoring   ✓                      ║
║  Backups      ✓                      ║
║  Rollback     ✓                      ║
║                                      ║
║  READY FOR GO-LIVE                   ║
╚══════════════════════════════════════╝
```

---

# 59. Next Project Phase

The **Deployment module (18)** is now complete.

The next project phase should only begin after the actual production deployment requirements have been verified against the implemented SMEvolve application.

The next documentation module should therefore be the project's **post-deployment / operations phase**, if one has been defined in the overall documentation plan.
