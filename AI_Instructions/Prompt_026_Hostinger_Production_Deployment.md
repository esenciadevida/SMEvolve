# SMEvolve

## Prompt 026 – Hostinger Production Deployment

**Project:** SMEvolve

**Document Number:** 026

**Module:** Production Deployment

**Source Control:** GitHub

**Production Hosting:** Hostinger

**Purpose:** Deploy the verified SMEvolve application from GitHub to the prepared Hostinger production environment in a controlled and reversible manner.

**Status:** Implementation Instruction

---

# 1. OBJECTIVE

Deploy the stable SMEvolve version from GitHub to Hostinger.

The deployment flow must be:

```text
GitHub
   ↓
Verified Commit
   ↓
Hostinger
   ↓
Production Configuration
   ↓
Database
   ↓
Application
   ↓
Internal Verification
   ↓
DNS / Domain
   ↓
SSL
   ↓
Production
```

Do not skip verification steps.

---

# 2. IMPORTANT RULE

Do not deploy unverified code.

The deployment must use:

* The approved GitHub repository.
* The approved branch.
* A known stable commit.
* Passing CI checks.
* The production configuration prepared for Hostinger.

Do not deploy directly from an untested local copy.

---

# 3. PRE-DEPLOYMENT CHECK

Before deployment, verify:

```text
☐ GitHub repository is correct
☐ Main branch is correct
☐ Latest intended commit identified
☐ CI is passing
☐ Local tests passed
☐ Hostinger environment is prepared
☐ Production database strategy confirmed
☐ Production backup strategy confirmed
☐ Environment variables identified
☐ Domain strategy confirmed
☐ SSL strategy confirmed
```

If any critical item fails, stop and resolve it.

---

# 4. SELECT DEPLOYMENT COMMIT

Identify the exact Git commit being deployed.

Record:

```text
Commit SHA:
Branch:
Commit message:
Deployment date:
```

Do not simply deploy "whatever is currently on the server."

The production version must be traceable to a Git commit.

---

# 5. BACKUP BEFORE DEPLOYMENT

If the Hostinger environment already contains an existing SMEvolve production installation:

Create/verify:

```text
Application backup
Database backup
Important uploaded files backup
```

Do not overwrite existing production data without confirming the backup.

If this is a brand-new installation, document that no existing application data exists.

---

# 6. CONNECT TO HOSTINGER

Use the approved Hostinger deployment method.

Possible methods include:

```text
SSH
Git
Hostinger Git integration
Approved deployment workflow
```

Use the method supported by the actual Hostinger plan.

Do not invent server credentials or paths.

---

# 7. CLONE/PULL CODE

Retrieve the approved GitHub code.

If cloning for the first time:

```text
Clone repository
```

If the application already exists:

```text
Verify current commit
Fetch approved changes
Deploy approved commit
```

Do not use destructive commands that could erase important server data.

---

# 8. PRODUCTION DIRECTORY

Confirm that the application is located in the intended directory.

Example:

```text
/home/account/smevolve/
```

Use the actual Hostinger path.

---

# 9. DOCUMENT ROOT

The public document root must point to:

```text
smevolve/public
```

not the project root.

The server must not expose:

```text
.env
app/
config/
database/
resources/
storage/
vendor/
```

---

# 10. INSTALL PHP DEPENDENCIES

Install production dependencies using the locked versions.

Use the project's Composer configuration.

Prefer production-safe installation options such as:

```text
composer install --no-dev --optimize-autoloader
```

only when compatible with the application's deployment requirements.

Do not run dependency upgrades during deployment.

---

# 11. INSTALL FRONTEND DEPENDENCIES

Determine whether frontend assets need to be built on Hostinger.

If assets are already built during CI/deployment preparation, do not unnecessarily install Node dependencies on production.

If Hostinger must build the assets, use the documented Node version and lock file.

---

# 12. BUILD FRONTEND

If required, run the project's production build command.

Example:

```text
npm run build
```

Use the actual SMEvolve build command.

Verify that the generated production assets exist.

---

# 13. PRODUCTION `.ENV`

Create/configure the production `.env` on Hostinger.

It must contain the actual production configuration.

It must never be committed to GitHub.

---

# 14. CORE APPLICATION SETTINGS

Configure appropriate production values:

```text
APP_ENV=production
APP_DEBUG=false
APP_URL=https://YOUR-DOMAIN
```

Use the real production domain when available.

---

# 15. APPLICATION KEY

Ensure the production application has a valid secure `APP_KEY`.

Do not use:

* Development key.
* Testing key.
* Another application's key.

Do not regenerate the key on every deployment.

Changing the production key can invalidate encrypted application data and sessions.

---

# 16. DATABASE CONFIGURATION

Configure the production database:

```text
DB_CONNECTION=
DB_HOST=
DB_PORT=
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
```

Use the actual Hostinger database credentials.

Do not place these credentials in GitHub.

---

# 17. DATABASE SAFETY

Before running migrations, confirm that:

```text
Database = SMEvolve production database
```

Do not accidentally run production migrations against:

```text
Development database
Testing database
Another application
```

---

# 18. DATABASE BACKUP

If the database already contains production data:

Create/verify a backup immediately before migrations.

Do not skip this step.

---

# 19. RUN MIGRATIONS

Run the project's production migrations using the approved Laravel migration process.

Use:

```text
php artisan migrate --force
```

only after confirming the correct production database and backup status.

Do not run migrations blindly.

---

# 20. SEEDING

Do not run development seeders against production.

Only run production-safe seed operations that have been explicitly designed for production.

If an initial administrator must be created, use a secure documented process.

---

# 21. ADMIN ACCOUNT

Create the initial production administrator using the approved secure procedure.

Do not:

* Hard-code a default password.
* Commit administrator credentials.
* Use an easily guessable password.
* Display credentials in logs.

The administrator should change any temporary credential immediately.

---

# 22. STORAGE LINK

If SMEvolve uses Laravel public storage:

Ensure the required storage link exists.

Verify:

```text
public/storage
```

points correctly to the intended storage directory.

---

# 23. FILE PERMISSIONS

Verify appropriate permissions for:

```text
storage/
bootstrap/cache/
```

Do not make the entire project writable.

Avoid:

```text
chmod -R 777
```

---

# 24. PRODUCTION CACHING

After configuration is complete, apply appropriate Laravel production optimization.

Depending on the project, this may include:

```text
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

Only run commands compatible with the actual application.

---

# 25. CACHE SAFETY

Before caching configuration:

Confirm that production environment values are correct.

Do not cache an incorrect `.env` configuration and then assume the application is using the latest values.

---

# 26. CLEAR STALE CACHE

When appropriate, clear old caches before rebuilding them.

Do not blindly run destructive cache commands against unrelated applications.

---

# 27. APPLICATION BOOT TEST

After deployment, verify that Laravel can boot successfully.

Check:

```text
Application starts
Configuration loads
Database connection works
Routes load
Views load
```

---

# 28. INTERNAL SERVER TEST

Before changing public DNS, test the application through an appropriate Hostinger/server-level URL where possible.

The goal is to verify the deployment before public traffic is directed to it.

---

# 29. HTTP ROUTING

Test important routes:

```text
/
Login
Registration if applicable
Password reset
Admin login
Admin dashboard
Search
Chatbot
Contact forms
```

Use the routes actually implemented by SMEvolve.

---

# 30. ADMIN PORTAL TEST

Verify:

```text
Admin login
Authentication
Authorization
Dashboard
User management
Relevant admin functions
Logout
```

Confirm that unauthorized users cannot access protected areas.

---

# 31. CHATBOT TEST

Verify:

```text
Chatbot loads
User can submit a message
Response is returned
Errors are handled
API credentials work
Rate limits/errors are handled appropriately
```

Do not expose AI provider credentials in the browser.

---

# 32. SEARCH TEST

Verify:

```text
Search page loads
Search requests work
Results appear
No-result behavior works
Invalid queries are handled
```

Confirm production search configuration is being used.

---

# 33. EMAIL TEST

Verify production email functionality.

Test at least:

```text
Contact notification
Password reset
Important system notification
Admin notification where applicable
```

Use controlled test recipients.

Do not send large numbers of test emails.

---

# 34. FILE UPLOAD TEST

If SMEvolve supports uploads, verify:

```text
Upload works
File is stored correctly
File can be retrieved
Invalid files are rejected
Permissions are correct
```

Do not upload sensitive real customer information during testing.

---

# 35. DATABASE TEST

Verify:

```text
Create record
Read record
Update record
Delete record
```

only where those operations are part of the application.

Confirm database writes are reaching the correct production database.

---

# 36. SESSION TEST

Verify:

```text
Login
Logout
Session persistence
Session expiration
Protected routes
```

Production sessions must not use insecure configuration.

---

# 37. SECURITY TEST

Confirm:

```text
APP_DEBUG=false
HTTPS
Protected admin routes
CSRF protection
Authentication
Authorization
Secure cookies
No exposed .env
No exposed stack traces
```

---

# 38. ERROR TEST

Trigger safe test errors and confirm users receive a proper production error page.

The response must not reveal:

```text
File paths
Database credentials
Stack traces
Environment variables
Internal server configuration
```

---

# 39. LOG TEST

Verify application errors are being logged appropriately.

Logs must not be publicly accessible.

Check that sensitive information is not being written unnecessarily to logs.

---

# 40. CRON

If SMEvolve requires scheduled tasks, configure the Hostinger cron job according to the approved architecture.

Verify the scheduled command executes successfully.

Do not create unnecessary cron jobs.

---

# 41. QUEUES

If SMEvolve uses queues, verify the production queue system.

Test:

```text
Job dispatch
Job processing
Failure handling
Retry behavior
```

Use a Hostinger-compatible worker strategy.

---

# 42. EMAIL QUEUES

If emails are queued, verify that queued email jobs are actually processed.

A successful request should not be considered complete if the email remains permanently stuck in the queue.

---

# 43. DOMAIN CONFIGURATION

Once the application has been successfully verified on Hostinger, configure the production domain.

Do not change DNS before the application is ready.

Use the DNS records provided by Hostinger.

---

# 44. DNS

Update only the required records.

Do not modify unrelated DNS entries.

Verify:

```text
A record
AAAA record if applicable
CNAME where applicable
MX records
TXT records
```

Do not remove existing email-related DNS records unnecessarily.

---

# 45. EMAIL DNS

If the domain uses email, preserve/configure appropriate:

```text
MX
SPF
DKIM
DMARC
```

records according to the selected email provider.

Do not delete existing working email records without understanding their purpose.

---

# 46. SSL

After DNS is correctly pointing to Hostinger, activate/verify SSL.

Confirm:

```text
https://domain
```

works.

---

# 47. HTTPS REDIRECT

Verify:

```text
http://domain
```

redirects correctly to:

```text
https://domain
```

Ensure there is no redirect loop.

---

# 48. CANONICAL DOMAIN

Choose the official canonical version:

```text
https://domain
```

or:

```text
https://www.domain
```

Configure redirects consistently.

Do not allow multiple competing canonical versions.

---

# 49. GOOGLE ANALYTICS

Configure the production Google Analytics 4 Measurement ID if it has already been created.

Important:

Google Analytics remains **outside the Admin Portal**.

The architecture is:

```text
Public SMEvolve Website
        ↓
      GA4
        ↓
Google Analytics Dashboard
```

Do not create an Analytics dashboard inside SMEvolve's Admin Portal.

---

# 50. ANALYTICS VERIFICATION

After the production site is live:

Verify that:

```text
Page views
Sessions
Relevant configured events
```

are reaching Google Analytics.

Do not send:

```text
Passwords
API keys
Private messages
Sensitive personal information
```

to analytics.

---

# 51. SEO

Verify basic production SEO:

```text
Page titles
Meta descriptions
Canonical URLs
robots.txt
sitemap
Open Graph metadata where applicable
```

Do not accidentally block the production site from search engines unless that is intentional.

---

# 52. ROBOTS

Confirm the production `robots.txt` is appropriate.

Development/staging restrictions should not accidentally remain in production.

---

# 53. SITEMAP

If SMEvolve provides a sitemap, verify:

```text
/sitemap.xml
```

or the actual configured sitemap URL.

Verify that URLs are correct and use HTTPS.

---

# 54. PERFORMANCE

Perform a basic production performance check.

Review:

```text
Initial page load
Asset loading
Images
Database response
API requests
Chatbot response
Search response
```

Do not optimize blindly based on one test.

---

# 55. MOBILE TEST

Test the live application on:

```text
Desktop
Mobile
Tablet where applicable
```

Verify responsive behavior.

---

# 56. BROWSER TEST

Test at least:

```text
Chrome
Safari where available
Firefox where available
Mobile browser
```

Focus on critical user journeys.

---

# 57. CRITICAL USER JOURNEYS

Verify the complete user flows implemented by SMEvolve.

Examples:

```text
Visitor
 ↓
Landing page
 ↓
Search
 ↓
Content
 ↓
Chatbot
 ↓
Contact

Administrator
 ↓
Login
 ↓
Admin Portal
 ↓
Management action
 ↓
Logout
```

Use the actual application flows.

---

# 58. PRODUCTION DATA SAFETY

Do not use real sensitive information for deployment testing.

Use controlled test data.

---

# 59. SECURITY SCAN

After the site is live, perform a basic security review.

Check for:

```text
Exposed .env
Directory listing
Debug output
Unexpected public files
Weak admin access
Mixed content
HTTP resources
```

---

# 60. MIXED CONTENT

All production assets should load over HTTPS.

Check:

```text
Images
CSS
JavaScript
Fonts
APIs
External resources
```

There should be no unnecessary HTTP resources on the HTTPS site.

---

# 61. BACKUP AFTER DEPLOYMENT

Once the production deployment is confirmed stable, create/verify a fresh backup.

Record:

```text
Application version
Git commit
Database backup
Deployment date
```

---

# 62. ROLLBACK PLAN

Record the deployed commit.

If the deployment fails:

```text
Identify failure
 ↓
Stop further changes
 ↓
Restore previous stable version
 ↓
Restore database if necessary
 ↓
Verify
```

Do not perform a database rollback automatically unless required and understood.

---

# 63. DATABASE ROLLBACK WARNING

Application rollback and database rollback are different.

A newer migration may have changed the database schema.

Never assume that reverting application code automatically reverses database changes.

---

# 64. DEPLOYMENT LOG

Maintain a deployment record:

```text
Deployment:
SMEvolve Production

Date:
[Date]

Git Commit:
[SHA]

Host:
Hostinger

Database Migration:
[Status]

Environment:
Production

Domain:
[Domain]

Result:
[Success/Failure]
```

---

# 65. FINAL PRODUCTION CHECKLIST

Before declaring the deployment successful:

```text
☐ GitHub commit verified
☐ Hostinger deployment successful
☐ Correct document root
☐ PHP version correct
☐ Composer dependencies installed
☐ Frontend assets built
☐ Production .env configured
☐ APP_DEBUG=false
☐ APP_KEY configured
☐ Database connected
☐ Migrations completed
☐ Storage configured
☐ Permissions verified
☐ Cache configured
☐ Admin login tested
☐ Public pages tested
☐ Search tested
☐ Chatbot tested
☐ Email tested
☐ File uploads tested where applicable
☐ Domain configured
☐ SSL active
☐ HTTP redirects to HTTPS
☐ Google Analytics verified
☐ SEO basics verified
☐ No exposed secrets
☐ Backup verified
☐ Rollback commit recorded
```

---

# 66. SUCCESS CRITERIA

The deployment is successful only when:

```text
GitHub
   ↓
Verified Commit
   ↓
Hostinger
   ↓
Production Environment
   ↓
Database
   ↓
Application
   ↓
Domain
   ↓
SSL
   ↓
Functional Verification
   ↓
Backup
```

all complete successfully.

---

# 67. DO NOT CLAIM SUCCESS PREMATURELY

Do not report:

```text
"Deployment successful"
```

until the production site has actually been tested.

If a step fails, report the exact failure.

---

# 68. COMPLETION REPORT

After completing the deployment, report:

```text
Deployment Status:
[Successful / Failed / Partial]

Git Commit:
[SHA]

Hostinger:
[Configured / Issue]

Domain:
[Domain]

HTTPS:
[Working / Issue]

SSL:
[Active / Issue]

Database:
[Connected / Issue]

Migrations:
[Passed / Failed]

Storage:
[Passed / Failed]

Admin Portal:
[Passed / Failed]

Search:
[Passed / Failed]

Chatbot:
[Passed / Failed]

Email:
[Passed / Failed]

Google Analytics:
[Verified / Not Verified]

SEO:
[Verified / Issues]

Backup:
[Verified / Not Verified]

Rollback Version:
[Commit SHA]

Issues:
[List]

Next Step:
[Post-Deployment Monitoring / Fixes]
```

---

# 69. FINAL INSTRUCTION

Deploy SMEvolve carefully from the verified GitHub repository to Hostinger.

Never:

* Commit production secrets.
* Expose `.env`.
* Use production credentials in GitHub.
* Deploy untested code.
* Delete production data.
* Run unsafe migrations.
* Enable production debug mode.
* Change unrelated DNS.
* Remove working email DNS records.
* Claim deployment success without verification.

The final target is:

```text
                 SMEvolve

                   GitHub
                     │
                     ▼
              Verified Commit
                     │
                     ▼
                Hostinger
                     │
          ┌──────────┴──────────┐
          ▼                     ▼
     Application             Database
          │
          ▼
       HTTPS/SSL
          │
          ▼
       Live Domain
          │
     ┌────┼─────┐
     ▼    ▼     ▼
   Users Search Chatbot
```

After this deployment is successfully verified, proceed to the **post-deployment monitoring, security, backup, email, analytics, SEO, and production hardening phase**.
