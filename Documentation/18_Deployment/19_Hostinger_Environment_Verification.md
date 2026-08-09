# SMEvolve Deployment

## 19 – Hostinger Environment Verification

**Project:** SMEvolve

**Module:** Deployment

**Documentation Path:** `Documentation/18_Deployment/`

**Framework:** Laravel 12

**Source Control:** GitHub

**Production Hosting:** Hostinger

**Environment:** Production

**Document Version:** 1.0

**Status:** Verified (2026-08-08)

---

# 1. Purpose

This document records the verified Hostinger production environment for SMEvolve.

It fulfils the requirement of `Prompt_025_Hostinger_Production_Setup.md` to inspect the Hostinger account and record the relevant environment details before final deployment.

Only facts verified through direct SSH inspection and live DNS/HTTP checks are recorded here.

---

# 2. Verification Method

The environment was verified by:

* SSH access (ed25519 key, port `65002`) to the production server.
* Read-only inspection of the server environment.
* Live DNS and HTTPS checks for the production domain.

No destructive changes were performed.

No production credentials were exposed, committed, or documented.

---

# 3. Hosting Environment

```text
Provider:      Hostinger
Environment:   Shared hosting (CloudLinux + CageFS jailshell)
Server:        uk-fast-web2073.main-hosting.eu
SSH User:      u226366554
SSH Port:      65002
Web Server:    LiteSpeed 6.3.6
Shell:         /bin/bash (jailed)
```

The server is a shared Hostinger node with generous aggregate resources.

---

# 4. Existing Account Content

The Hostinger account contains the following domains:

```text
smevolve.tech       -> SMEvolve production (this project)
wikimediayoruba.org -> Existing website (DO NOT MODIFY)
```

`wikimediayoruba.org` is an unrelated existing website on the account. It must never be modified, moved, or affected by SMEvolve work.

---

# 5. Domain and DNS

The SMEvolve production domain is:

```text
https://smevolve.tech
```

Verified state:

```text
A record:     smevolve.tech -> Hostinger CDN front (verified 2026-08-08)
www:          www.smevolve.tech -> CNAME cdn.hstgr.net (Hostinger CDN)
HTTP:         http://smevolve.tech -> 301 redirect to HTTPS
HTTPS:        https://smevolve.tech -> 200 (server: hcdn)
SSL:          Active (Hostinger-managed certificate)
MX:           mx1.hostinger.com (5) / mx2.hostinger.com (10)
Nameservers:  artemis.dns-parking.com / hermes.dns-parking.com
SPF/DMARC:    Not yet published
```

The domain is attached to the hosting account and serves the Hostinger placeholder page. DNS and SSL are functional. No DNS changes are required before deployment.

---

# 6. Application Directory

The application directory for SMEvolve is:

```text
/home/u226366554/domains/smevolve.tech/
```

Current content:

```text
public_html/   -> currently contains the Hostinger placeholder (default.php)
DO_NOT_UPLOAD_HERE
```

The production document root must point to the Laravel `public/` directory. The Laravel project itself must not be exposed as a public web root.

---

# 7. PHP Environment

Verified PHP versions available on the server (CloudLinux alt-php):

```text
PHP 8.2.30
PHP 8.3.30   -> default (used by Composer)
PHP 8.4.19
```

Other legacy versions (5.2 - 8.1) are available but irrelevant to Laravel 12.

Laravel 12 requires PHP ^8.2. **PHP 8.3.30 is recommended** (default and stable) or **PHP 8.4.19** if preferred.

Required PHP extensions are all present:

```text
bcmath  ctype  curl  dom  fileinfo  json  mbstring  openssl
PDO     pdo_mysql  tokenizer  xml
```

Additional extensions available: redis, intl, gd, imagick, mysqli, sqlite3, zip, opcache, igbinary, imap, soap, sockets, xsl, etc.

CLI PHP limits (web limits may differ; tune through hPanel if required):

```text
memory_limit          1536M
max_execution_time    0
upload_max_filesize   1536M
post_max_size         1536M
max_input_vars        5000
```

---

# 8. Tooling

```text
Composer:  2.9.8 (runs on PHP 8.3.30)
Git:       2.47.3
Node.js:   NOT AVAILABLE on the server
npm:       NOT AVAILABLE on the server
```

Because Node.js is not available on the server, frontend assets must be built **before** deployment (Option B in `03_Hostinger_Environment.md`), for example in the GitHub Actions CI build.

---

# 9. Database

```text
Engine:  MariaDB (client 11.8.8)
Access:  Database creation and credentials are managed through hPanel
         (Websites -> smevolve.tech -> Databases)
```

The server-side `mysql` command cannot access the database without the hPanel-created credentials. A dedicated database and dedicated database user must be created through hPanel during deployment.

Database character set must be Unicode-compatible (`utf8mb4`).

---

# 10. Storage

```text
Disk:   Shared server volume, 15 TB available at verification time
Uploads: Local disk via Laravel default public storage (FILESYSTEM_DISK=local)
```

Laravel storage requirements:

```text
storage/         writable
bootstrap/cache/ writable
public/storage   symlink -> storage/app/public (via php artisan storage:link)
```

File permissions must be as restrictive as possible; broad `777` permissions must be avoided.

---

# 11. Cron, Scheduler, and Queues

```text
Cron:      Managed through hPanel (Advanced -> Cron Jobs).
           The `crontab` command is not available in the jailed SSH shell.
Scheduler: Not required yet - no custom scheduled tasks are defined
           (routes/console.php contains only the default `inspire` command).
Queues:    Not required yet - no queued jobs or queued mailables are used.
```

Cron and queue infrastructure should be configured only when the application requires it.

---

# 12. SSL and HTTPS

```text
SSL:        Active and verified (https://smevolve.tech returns 200)
Certificate: Hostinger-managed (automatic issuance/renewal)
Redirect:    http -> https (301) verified
```

No SSL configuration work is required before deployment.

---

# 13. Backups and Monitoring

```text
Backups:   Managed through Hostinger hPanel (Websites -> smevolve.tech -> Backups).
           Frequency/retention depend on the hosting plan. Restoration must be
           tested before the production launch.
Monitoring: Hostinger hPanel resource/uptime monitoring plus Laravel logs.
           Uptime/error monitoring should be confirmed before go-live.
```

A backup is not considered reliable until restoration has been tested.

---

# 14. Resource Limits

Verified relevant limits:

```text
Open files:        8192
Stack size:        8192 KB
Max locked memory: 8192 KB
CPU time:          unlimited
Virtual memory:    unlimited
```

Aggregate server resources (verified at inspection):

```text
CPU:  64 cores (shared)
RAM:  ~503 GB total (shared)
```

Shared-hosting limits (entry processes, IO, memory ceilings) are enforced by the plan and should be reviewed in hPanel.

---

# 15. Deployment Architecture Decision

Based on verified Hostinger capabilities, the recommended deployment approach is:

```text
GitHub main (CI green)
        |
        | CI: composer install --no-dev --optimize-autoloader
        | CI: npm ci && npm run build   (assets built here - no Node on server)
        v
    Git deployment to Hostinger (SSH)
        |
        v
/ home/u226366554/domains/smevolve.tech/   (Laravel project root)
        |
        +-- public_html -> symlink to public/
        +-- .env (production values, never committed)
        +-- vendor/
        +-- storage/
        |
        v
    php artisan migrate --force   (after backup, reviewed)
    php artisan storage:link
    php artisan config:cache / route:cache / view:cache
```

This matches `03_Hostinger_Environment.md` **Option B** (build before deployment) and keeps the Laravel project outside the public web root.

The final deployment mechanism is implemented in the next phase (`Prompt_026_Hostinger_Production_Deployment.md`). Do not create a CI/CD pipeline directly to production in this phase.

---

# 16. Production Environment Variable Checklist

The production `.env` must be created on Hostinger only. It must never be committed to GitHub or reproduced in documentation.

The complete SMEvolve variable inventory (from `.env.example`):

```text
APPLICATION
  APP_NAME                    No
  APP_ENV                     No        = production
  APP_KEY                     YES
  APP_DEBUG                   No        = false
  APP_URL                     No        = https://smevolve.tech
  APP_LOCALE                  No
  APP_FALLBACK_LOCALE         No
  APP_FAKER_LOCALE            No
  APP_MAINTENANCE_DRIVER      No
  BCRYPT_ROUNDS               No

LOGGING
  LOG_CHANNEL                 No
  LOG_STACK                   No
  LOG_DEPRECATIONS_CHANNEL    No
  LOG_LEVEL                   No        = production (error/warning)

DATABASE
  DB_CONNECTION               No        = mysql
  DB_HOST                     No        = localhost (or hPanel host)
  DB_PORT                     No        = 3306
  DB_DATABASE                 Sensitive
  DB_USERNAME                 Sensitive
  DB_PASSWORD                 YES

ADMIN PORTAL
  ADMIN_NAME                  No
  ADMIN_EMAIL                 No
  ADMIN_PASSWORD              YES       (set via secure seeder/deployment)
  ADMIN_SESSION_LIFETIME_MINUTES No
  ADMIN_LOGIN_RATE_LIMIT      No

AI / CHATBOT
  AI_PROVIDER                 No
  GROQ_API_KEY                YES
  GROQ_BASE_URL               No
  GROQ_MODEL                  No
  GROQ_TIMEOUT                No
  AI_ASSISTANT_ENABLED        No
  AI_QUOTE_ENABLED            No
  AI_WELCOME_MESSAGE          No
  AI_ADMIN_ENABLED            No
  AI_ADMIN_EMAIL              No
  AI_ADMIN_PASSWORD           YES

SESSION
  SESSION_DRIVER              No        = file (or database)
  SESSION_LIFETIME            No
  SESSION_ENCRYPT             No
  SESSION_PATH                No
  SESSION_DOMAIN              No        = .smevolve.tech
  SESSION_SECURE_COOKIE       No        = true

CACHE / QUEUE / BROADCAST
  CACHE_STORE                 No        = file
  QUEUE_CONNECTION            No        = database (if queues enabled later)
  BROADCAST_CONNECTION        No        = log (default)
  MEMCACHED_HOST/REDIS_*      No        (only if used)

FILESYSTEM
  FILESYSTEM_DISK             No        = local
  AWS_*                       YES       (only if object storage used later)

MAIL
  MAIL_MAILER                 No        = smtp (or transactional provider)
  MAIL_SCHEME                 No
  MAIL_HOST                   No
  MAIL_PORT                   No
  MAIL_USERNAME               Sensitive
  MAIL_PASSWORD               YES
  MAIL_FROM_ADDRESS           No        = notifications@ or no-reply@smevolve.tech
  MAIL_FROM_NAME              No        = SMEvolve

FRONTEND
  VITE_APP_NAME               No
```

Required production values to be provided during deployment (Prompt 026):

```text
APP_KEY                     (generate fresh on production; never reuse dev key)
DB_DATABASE / DB_USERNAME / DB_PASSWORD
MAIL_*                      (dedicated application email account)
GROQ_API_KEY                (production key, not development)
ADMIN_PASSWORD / AI_ADMIN_PASSWORD
```

---

# 17. Hostinger Setup Checklist (Prompt 025, section 64)

```text
☑ Correct Hostinger account
☑ Correct hosting plan (verified via server capabilities)
☑ Correct domain (smevolve.tech, attached, DNS + SSL live)
☑ Application directory prepared (domains/smevolve.tech)
☑ Document root identified (must point to Laravel public/)
☑ PHP version confirmed (8.3.30 default; 8.2/8.3/8.4 available)
☑ Required PHP extensions confirmed (all present)
☑ Composer availability checked (2.9.8)
☑ Node requirement determined (not available; build assets before deployment)
☑ Database compatibility confirmed (MariaDB via hPanel)
☑ SSL capability confirmed (active, verified HTTPS)
☑ SSH capability checked (port 65002, ed25519)
☑ Cron requirement identified (not required yet; hPanel-managed)
☑ Queue requirement identified (not required yet)
☑ Storage requirement identified (local disk, storage:link)
☑ Email requirement identified (dedicated provider, credentials in Prompt 026)
☐ Backup capability checked (hPanel-managed; restoration not yet tested)
☑ Resource limits reviewed
```

---

# 18. Acceptance Criteria

Prompt 025 is considered satisfied when:

```text
✓ Correct hosting environment identified and verified
✓ Correct PHP environment confirmed
✓ Correct application directory identified
✓ Database capability confirmed
✓ SSL capability confirmed
✓ SSH/Git capability confirmed
✓ Email capability identified
✓ Cron/queue requirements identified
✓ Backup capability identified
✓ Resource limits reviewed
✓ No destructive production changes performed
```

---

# 19. Next Step

The next phase is the controlled production deployment to Hostinger:

```text
Prompt_026_Hostinger_Production_Deployment.md
```

Covering the Git deployment, production `.env` creation, database creation, migrations, storage link, caches, and production verification.
