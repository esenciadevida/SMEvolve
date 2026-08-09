# SMEvolve

# Prompt 027 — Post-Deployment Monitoring & Hardening

**Document:** `Prompt_027_Post_Deployment_Monitoring_Hardening.md`

**Project:** SMEvolve

**Environment:** Production — Hostinger

**Domain:** `smevolve.tech`

**Repository deployment:** Approved production commit already deployed

---

# 1. OBJECTIVE

Perform the complete post-deployment monitoring, verification, security hardening, and production-readiness review of the SMEvolve Laravel application.

The application has already been deployed to Hostinger.

Do NOT redeploy the application unnecessarily.

Do NOT introduce unrelated features.

The purpose of this prompt is to:

1. Verify the production deployment.
2. Identify incomplete production configuration.
3. Harden the application.
4. Verify security.
5. Verify email infrastructure readiness.
6. Verify AI configuration readiness.
7. Verify backups and rollback readiness.
8. Verify logging and monitoring.
9. Identify outstanding production tasks.
10. Produce a final post-deployment report.

---

# 2. IMPORTANT EXISTING ARCHITECTURE

The application is:

```text
Laravel
+
Hostinger
+
Namecheap domain
+
Zoho Mail
+
Brevo SMTP
+
Groq AI
+
GitHub
```

Current domain:

```text
https://smevolve.tech
```

The production website is hosted on Hostinger.

The domain is registered through Namecheap.

Zoho is used for mailbox functionality.

Brevo is intended for transactional email delivery.

Groq is intended for AI functionality.

---

# 3. DO NOT CHANGE DNS UNNECESSARILY

The domain DNS is managed through Namecheap.

Do not:

* Change nameservers unnecessarily.
* Replace the entire DNS zone.
* Remove existing Zoho MX records.
* Remove Brevo authentication records.
* Modify unrelated DNS records.

Only modify DNS when there is a clearly documented production requirement.

---

# 4. PRODUCTION ENVIRONMENT VERIFICATION

Verify:

```env
APP_ENV=production
APP_DEBUG=false
```

Confirm:

* Production URL is correct.
* Application key exists.
* HTTPS is enabled.
* Secure cookies are enabled where appropriate.
* Production configuration is loaded correctly.

Never expose the contents of `.env`.

Do not print secrets in the final report.

---

# 5. PHP VERSION

Verify the PHP CLI and web PHP versions.

Record the versions.

Ensure the deployed Laravel application is compatible with the configured PHP version.

Do not change PHP versions unless there is a demonstrated compatibility problem.

---

# 6. DOCUMENT ROOT

Verify that the Hostinger document root points to:

```text
Laravel/public
```

The public directory must be the web-accessible directory.

The Laravel application root must not expose:

```text
.env
vendor/
storage/
bootstrap/
config/
database/
```

directly through HTTP.

---

# 7. STORAGE

Verify:

```bash
php artisan storage:link
```

or equivalent functionality.

Confirm publicly required uploaded assets are accessible.

Do not expose private files unnecessarily.

---

# 8. DATABASE

Verify the production database connection.

Run safe checks only.

Confirm:

* Connection works.
* Migrations are applied.
* No unexpected pending migrations exist.

Do not run destructive commands.

Never execute:

```bash
php artisan migrate:fresh
```

or equivalent destructive operations in production.

---

# 9. DATABASE BACKUP

Determine whether a production database backup exists.

If not, create a production database backup using the safest available Hostinger/database mechanism.

Do not expose the database password.

Record:

```text
Backup date
Database name
Backup location
Backup status
```

---

# 10. ROLLBACK READINESS

Identify:

```text
Current production commit
Previous known-good commit
Database backup
Application backup
```

Document the rollback procedure.

Do not execute a rollback unless explicitly required.

---

# 11. GITHUB SECURITY

Verify that sensitive files are not committed.

At minimum ensure:

```text
.env
.env.*
production secrets
SMTP credentials
GROQ API keys
database credentials
private keys
```

are excluded appropriately.

Inspect `.gitignore`.

Do not print secret contents.

---

# 12. LARAVEL CACHE

Verify production caches.

Where appropriate:

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

Do not cache configuration before verifying the production `.env` is correct.

---

# 13. LOGGING

Verify Laravel production logging.

Confirm:

```env
LOG_CHANNEL=stack
LOG_LEVEL=...
```

is appropriate for production.

Do not leave excessive debug logging enabled unnecessarily.

Production must not expose stack traces to visitors.

---

# 14. ERROR HANDLING

Test a controlled invalid route.

Expected:

```text
404
```

not:

```text
Laravel stack trace
Debug page
Environment variables
Database details
File paths
```

Confirm:

```env
APP_DEBUG=false
```

---

# 15. SECURITY HEADERS

Verify appropriate security headers are present.

Check at minimum:

```text
X-Content-Type-Options
X-Frame-Options
Content-Security-Policy where configured
Referrer-Policy
Strict-Transport-Security where appropriate
```

Do not blindly add headers that break existing application functionality.

---

# 16. HTTPS

Verify:

```text
http://smevolve.tech
```

redirects appropriately to:

```text
https://smevolve.tech
```

Confirm the production site does not generate mixed-content errors.

---

# 17. AUTHENTICATION

Test:

```text
/admin/login
```

Verify:

* Login works.
* Invalid credentials fail.
* Logout works.
* Session is invalidated correctly.
* Unauthorized users cannot access admin routes.

Do not record passwords in logs.

---

# 18. ADMIN SESSION SECURITY

Verify:

```text
Secure cookies
HttpOnly cookies
SameSite configuration
Session regeneration
Logout invalidation
```

Do not weaken the existing Laravel authentication configuration.

---

# 19. ADMIN AUTHORIZATION

Verify that administrative routes are protected by the existing authorization system.

Test:

```text
Unauthenticated user
Authenticated administrator
Super administrator
Restricted administrator where applicable
```

Do not bypass authorization to make pages easier to access.

---

# 20. LOGIN RATE LIMITING

Verify that administrator authentication has reasonable rate limiting.

Do not implement aggressive limits that could lock out legitimate administrators.

Confirm repeated failed login attempts are controlled.

---

# 21. AUDIT LOG BASELINE

Inspect the existing Audit Log implementation.

Determine whether the application currently records:

```text
Login
Logout
Failed login
Administrator changes
Role changes
Permission changes
Important system changes
```

Do not rewrite the audit system during this prompt unless a security defect is discovered.

Record missing capabilities for a later implementation task.

---

# 22. SECURITY EVENT BASELINE

Identify which security information is currently captured:

```text
Timestamp
Administrator
Action
IP
User agent
Browser
OS
Device
Location
Success/failure
```

Do not add external geolocation calls during this prompt unless already configured.

For location, the planned architecture is:

```env
GEOLOCATION_ENABLED=false
```

by default.

If geolocation is not configured, record:

```text
Not determined
```

Do not block authentication because location is unavailable.

---

# 23. EMAIL CONFIGURATION

Inspect the current Laravel mail configuration.

Current intended provider:

```text
Brevo SMTP
```

The expected production configuration is conceptually:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp-relay.brevo.com
MAIL_PORT=587
MAIL_USERNAME=...
MAIL_PASSWORD=...
MAIL_FROM_ADDRESS=hello@smevolve.tech
MAIL_FROM_NAME=SMEvolve
```

Do not print the SMTP password/key.

---

# 24. SMTP SECURITY

If the existing SMTP credential was previously exposed or compromised:

Do NOT reuse it.

Require a newly generated Brevo SMTP credential.

Do not request the secret to be pasted into chat.

---

# 25. SMTP TEST

If SMTP is configured:

Send a controlled test email.

Verify:

```text
SMTP connection
Message acceptance
Delivery
Sender
Recipient
Subject
Reply-to behavior
```

If SMTP is still configured as:

```env
MAIL_MAILER=log
```

do not falsely report email as working.

Report:

```text
Email delivery: NOT CONFIGURED
```

and identify it as a remaining task.

---

# 26. EMAIL FROM ADDRESS

The intended sender is:

```text
hello@smevolve.tech
```

Verify that the sender domain has been authenticated through Brevo.

Do not create unnecessary additional sender identities.

---

# 27. EMAIL NOTIFICATIONS

Determine whether security email notifications are currently implemented.

Expected future events include:

```text
Successful administrator login
Failed/suspicious login
Password change
Password reset
New administrator
Role change
Permission change
Administrator disabled
```

Do not claim these are implemented unless the code confirms they exist and tests pass.

If missing, record:

```text
Security email notifications: Pending implementation
```

---

# 28. ZOHO MAIL

Do not modify Zoho mailbox configuration during this prompt unless required.

Confirm that the domain's email records remain intact.

Do not remove Zoho MX records.

---

# 29. BREVO DOMAIN AUTHENTICATION

Verify the domain authentication status if accessible.

Expected:

```text
smevolve.tech
```

must be authenticated for transactional email.

Do not modify unrelated DNS records.

---

# 30. GROQ AI

Inspect whether:

```env
GROQ_API_KEY
```

is configured in production.

Do not print its value.

Possible statuses:

```text
Configured
Not configured
Invalid
Unavailable
```

---

# 31. AI FUNCTIONALITY

If a valid production Groq key exists, test the existing AI functionality.

Test:

```text
AI Assistant
Quote AI
```

Do not rewrite the AI implementation during this prompt.

If AI is not configured, report it clearly.

---

# 32. AI ADMIN ARCHITECTURE

The desired architecture is:

```text
Main Admin Portal
       ↓
AI Management
```

There must not be a separate AI authentication system.

If the existing application still has a separate AI admin login/dashboard, record it as a required follow-up task.

Do not perform the full AI dashboard redesign during this hardening prompt unless specifically instructed.

---

# 33. WEBSITE FUNCTIONALITY

Verify the primary public pages:

```text
/
 /about
 /contact
 /services
 /packages
 /portfolio
 /faq
 /search
 /quote
 /privacy
 /terms
 /cookies
```

Confirm expected HTTP responses.

Do not report success merely because the server responds.

Confirm the actual SMEvolve application is being served.

---

# 34. SEARCH

Verify:

* Search page loads.
* Search request works.
* Autocomplete works if implemented.
* No unexpected server errors occur.

Do not introduce a new search engine during this prompt.

---

# 35. QUOTE SYSTEM

Test the quote workflow.

Verify:

```text
Quote page
Form validation
Submission
Database persistence
Admin visibility
```

Do not create fake production quotes unless explicitly identified as test data and removed afterward.

---

# 36. CHATBOT

Verify the existing chatbot.

Check:

```text
Widget loads
Request works
Error handling works
```

Do not expose API credentials.

---

# 37. PORTFOLIO

Verify:

```text
Portfolio listing
Project detail
Images/assets
Admin management
```

where applicable.

---

# 38. PERFORMANCE BASELINE

Inspect:

```text
Page load
Laravel response time
Database queries where relevant
Asset loading
Caching
```

Do not perform destructive load testing against production.

---

# 39. LITESPEED CACHE

Verify the Hostinger/LiteSpeed cache state.

If stale content is detected, instruct the user to purge the appropriate cache through hPanel.

Do not repeatedly issue unsupported purge commands over SSH.

---

# 40. CRON / SCHEDULED TASKS

Determine whether SMEvolve currently requires scheduled Laravel jobs.

If the application does not currently require them:

```text
No scheduled task required
```

Do not create unnecessary cron jobs.

---

# 41. QUEUE

Current intended configuration:

```env
QUEUE_CONNECTION=sync
```

Do not introduce Redis solely for this hardening task.

If future notification volume requires queues, document Redis/queue infrastructure as a future scaling task.

---

# 42. REDIS

Do not configure Redis unless the application currently requires it.

The presence of:

```env
REDIS_HOST
REDIS_PORT
REDIS_CLIENT
```

does not mean Redis must be enabled.

Record Redis as:

```text
Not required for current production configuration
```

unless application inspection proves otherwise.

---

# 43. AWS / S3

Do not configure AWS/S3 solely because AWS variables exist in `.env`.

Current intended storage remains:

```env
FILESYSTEM_DISK=local
```

unless the application requires external object storage.

---

# 44. TRAFFIC ANALYTICS

Determine whether the application currently has page-view tracking.

If no page-view tracking exists:

Do not fabricate traffic statistics.

Record:

```text
Traffic analytics: Not yet connected
```

The planned implementation is:

```text
Privacy-conscious server-side page views
```

with:

* Bot filtering
* Rate limiting
* Anonymous visitor identification
* Aggregation
* No unnecessary raw IP storage

---

# 45. GOOGLE ANALYTICS

Do not require GA4 for this post-deployment hardening task.

If GA4 is not configured:

```text
GA4: Not configured
```

This is not a deployment failure.

---

# 46. DASHBOARD ANALYTICS

Do not display fake metrics.

If the dashboard currently has charts but no real data source:

Display an appropriate empty/not-connected state.

Do not present illustrative values as production statistics.

---

# 47. CHART DEPENDENCIES

Do not add Chart.js solely during this hardening task.

The approved dashboard approach is:

```text
Inline SVG/CSS charts
```

unless a later implementation requirement justifies a chart library.

---

# 48. FILE PERMISSIONS

Verify production file permissions.

Laravel writable directories should remain writable by the web process.

Do not make the entire application world-writable.

Avoid:

```bash
chmod -R 777
```

---

# 49. ENVIRONMENT FILE PROTECTION

Verify that `.env` cannot be accessed over HTTP.

A request such as:

```text
https://smevolve.tech/.env
```

must not expose environment variables.

---

# 50. DEBUG FILE EXPOSURE

Check that common sensitive files/directories cannot be accessed publicly.

Examples:

```text
.env
.git/
storage/framework/
vendor/
composer.json where inappropriate
composer.lock where inappropriate
```

Do not break required application functionality while blocking sensitive resources.

---

# 51. SECURITY SCANNING

Perform safe application-level checks.

Do not run aggressive penetration testing or destructive scans against production.

Identify:

```text
Unexpected exposed files
Weak configuration
Debug mode
Authentication issues
Authorization issues
Missing security headers
```

---

# 52. DEPENDENCIES

Inspect Laravel dependency status.

Identify known outdated or vulnerable dependencies where practical.

Do not blindly run:

```bash
composer update
npm update
```

on production.

Any dependency upgrade should be tested and deployed through GitHub.

---

# 53. NPM / BUILD

Verify that production frontend assets are built correctly.

Do not introduce unnecessary frontend dependencies.

---

# 54. LOG REVIEW

Inspect recent Laravel/application logs for:

```text
Exceptions
Database errors
Authentication errors
Mail errors
AI errors
404 patterns
500 errors
```

Do not expose sensitive log contents in the final report.

Summarize findings.

---

# 55. 404 / 500 MONITORING

Determine whether the application has a way to monitor:

```text
404 errors
500 errors
Authentication failures
AI failures
Email failures
```

If monitoring is absent, record it as a future improvement.

---

# 56. BACKUP STRATEGY

Confirm:

```text
Database backup
Application backup where appropriate
Hostinger backup availability
Recovery procedure
```

Do not claim backups exist without verification.

---

# 57. RECOVERY TEST

If safe and practical, verify that the backup can be identified and is usable.

Do not restore production over itself during this task.

A documented recovery procedure is sufficient if a full restore test is not appropriate.

---

# 58. PRODUCTION CREDENTIALS

The following credentials must be rotated if they have been exposed:

```text
Admin passwords
AI admin credentials if obsolete
Database password
Brevo SMTP credential
GROQ API key if exposed
Other production secrets
```

Do not print old or new credentials.

---

# 59. SECRET MANAGEMENT

Production secrets must exist only in secure environment/configuration storage.

Do not put secrets into:

```text
GitHub
README
Documentation
JavaScript
Blade templates
Public APIs
Screenshots
```

---

# 60. GITHUB

Verify the current production commit.

Record:

```text
Commit
Branch
Deployment date
```

Do not automatically pull unapproved code into production.

---

# 61. DEPLOYMENT CHANGE CONTROL

Any new changes identified during this prompt should be classified as:

```text
Required security fix
Required production fix
Follow-up feature
Optional improvement
```

Do not expand this prompt into unrelated feature development.

---

# 62. FINAL PRODUCTION CHECKLIST

Verify:

```text
☐ Domain
☐ HTTPS
☐ Laravel production mode
☐ APP_DEBUG=false
☐ PHP
☐ Database
☐ Migrations
☐ Storage
☐ Document root
☐ Authentication
☐ Authorization
☐ Session security
☐ Security headers
☐ Error handling
☐ File permissions
☐ .env protection
☐ GitHub secret protection
☐ Logs
☐ Backups
☐ Rollback readiness
☐ Email configuration
☐ Brevo authentication
☐ SMTP test
☐ AI configuration
☐ AI test
☐ Search
☐ Quote
☐ Chatbot
☐ Portfolio
☐ Cache
☐ Traffic analytics status
☐ Google Analytics status
```

---

# 63. DO NOT IMPLEMENT THESE FEATURES IN PROMPT 027

The following are planned follow-up implementation work and should not be silently added to Prompt 027:

```text
Dashboard + Analytics redesign
Server-side page-view analytics implementation
Advanced SVG chart system
AI Admin Portal redesign
Advanced AI analytics
Enhanced audit metadata
Security notification engine
Optional geolocation provider
Notification center
```

Instead, identify their current status and list them as follow-up work.

---

# 64. EXPECTED OUTPUT

At the end of execution, provide a concise production status report.

Use:

```text
SMEvolve Post-Deployment Status

Deployment:
PASS / WARNING / FAIL

Domain:
PASS / WARNING / FAIL

HTTPS:
PASS / WARNING / FAIL

Laravel:
PASS / WARNING / FAIL

Database:
PASS / WARNING / FAIL

Authentication:
PASS / WARNING / FAIL

Security:
PASS / WARNING / FAIL

Email:
PASS / WARNING / FAIL / NOT CONFIGURED

Brevo:
PASS / WARNING / FAIL / NOT CONFIGURED

AI:
PASS / WARNING / FAIL / NOT CONFIGURED

Search:
PASS / WARNING / FAIL

Quotes:
PASS / WARNING / FAIL

Chatbot:
PASS / WARNING / FAIL

Portfolio:
PASS / WARNING / FAIL

Analytics:
PASS / WARNING / NOT CONNECTED

Backups:
PASS / WARNING / FAIL

Rollback:
PASS / WARNING / FAIL

Outstanding Issues:
[List]

Required Manual Actions:
[List]

Recommended Follow-up Prompts:
[List]
```

---

# 65. CRITICAL RULE

Do not declare SMEvolve "production complete" simply because the website loads.

Production completion requires:

```text
Application
+
Security
+
Email
+
Backups
+
Monitoring
+
Configuration
+
Recovery readiness
```

to be assessed.

If something is not configured, explicitly say:

```text
NOT CONFIGURED
```

rather than assuming it works.

---

# 66. FINAL INSTRUCTION

Execute this post-deployment hardening and monitoring assessment against the existing SMEvolve production deployment.

Preserve existing working functionality.

Do not introduce unnecessary infrastructure.

Do not expose secrets.

Do not make destructive production changes.

Do not fabricate analytics, backups, email delivery, AI functionality, or monitoring results.

At the end, provide the exact remaining tasks required before SMEvolve can be considered fully production-ready.
