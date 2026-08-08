# SMEvolve Deployment

## 09 – Storage, Queues & Scheduler

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

This document defines the production configuration for Laravel storage, queued jobs, background processing, and scheduled tasks.

It covers:

* Laravel filesystem storage.
* Public and private files.
* User uploads.
* Storage links.
* Queues.
* Queue workers.
* Failed jobs.
* Laravel Scheduler.
* Hostinger Cron Jobs.
* Scheduled notifications.
* Maintenance tasks.
* Monitoring and recovery.

The objective is to ensure that background processing and scheduled operations continue reliably after deployment.

---

# 2. Storage Architecture

SMEvolve should separate publicly accessible files from private application storage.

Conceptually:

```text id="q6p9z1"
                    SMEvolve
                       │
             ┌─────────┴─────────┐
             ▼                   ▼
       Public Files         Private Files
             │                   │
             ▼                   ▼
        public/              storage/
```

Public files may include assets intentionally made available through the website.

Private files should not be directly accessible through a public URL.

---

# 3. Laravel Storage

Laravel storage should be configured through:

```text id="f1n8m2"
config/filesystems.php
```

The application should use Laravel's filesystem abstraction rather than hard-coding server filesystem paths throughout the application.

---

# 4. Storage Disks

The application may use disks such as:

```text id="b8v4k0"
local
public
```

The exact disks must match the implemented SMEvolve application.

Do not create unnecessary storage disks.

---

# 5. Local Storage

Private application files may use:

```text id="7c3x1a"
storage/app/
```

These files should not automatically be exposed to the public internet.

Examples may include:

* Private documents.
* Internal reports.
* Temporary files.
* Application-generated files.

---

# 6. Public Storage

Files intended to be publicly accessible may use Laravel's public disk.

The standard Laravel structure is:

```text id="n5d8x2"
storage/app/public/
```

with a symbolic link:

```text id="v7m3p9"
public/storage
```

---

# 7. Storage Link

Create the symbolic link with:

```text id="j9f2k5"
php artisan storage:link
```

After creation, verify:

```text id="4g7s1n"
public/storage
```

points to the intended storage directory.

---

# 8. File Permissions

Laravel must be able to write to required storage directories.

Verify:

```text id="5w1r8q"
storage/
bootstrap/cache/
```

are writable by the appropriate application user/process.

Do not make the entire Laravel project writable.

---

# 9. User Uploads

If SMEvolve accepts uploads, all uploaded files must be validated.

Validation should consider:

* MIME type.
* File extension.
* Maximum size.
* Filename.
* Storage location.
* User authorization.
* Malware/security considerations.

Never trust a filename or extension supplied by a user.

---

# 10. Upload Security

Uploaded files must not automatically be executable.

Where appropriate:

* Store uploads outside executable directories.
* Generate safe filenames.
* Validate MIME types.
* Restrict file types.
* Restrict file size.
* Enforce authorization.

---

# 11. File Naming

Application-generated filenames should avoid directly trusting user-provided names.

A generated identifier may be used.

Example:

```text id="s2m6h7"
generated-unique-file-id.pdf
```

The original filename may be retained separately as metadata if required.

---

# 12. Private Files

Private files should be served through authorized application routes when users need access.

Example flow:

```text id="f0v3k6"
User
 ↓
Authentication
 ↓
Authorization
 ↓
Laravel
 ↓
Private File
```

Do not expose private storage through a predictable public URL.

---

# 13. Storage Capacity

Monitor Hostinger storage usage.

Storage requirements may grow due to:

* User uploads.
* Logs.
* Generated reports.
* Backups.
* Temporary files.

Storage limits should be reviewed regularly.

---

# 14. Temporary Files

Temporary files should not accumulate indefinitely.

Scheduled cleanup should be implemented where necessary.

---

# 15. Queue Architecture

Queued jobs allow SMEvolve to perform background work without making users wait for long-running operations.

Conceptually:

```text id="f7q3z9"
User Request
     │
     ▼
Laravel
     │
     ▼
Queue
     │
     ▼
Worker
     │
     ▼
Background Job
```

---

# 16. Suitable Queue Tasks

Potential queued operations include:

* Email notifications.
* Report generation.
* Large data processing.
* External API calls.
* Chatbot-related background tasks where applicable.
* Administrative notifications.
* Scheduled maintenance operations.

Only operations that benefit from asynchronous processing should be queued.

---

# 17. Queue Connection

The queue connection must be configured through the production environment.

Example:

```text id="k8j4m0"
QUEUE_CONNECTION=
```

The selected queue driver must be compatible with Hostinger.

---

# 18. Database Queue

If the database queue driver is selected, the application must have the required jobs table.

The migration can be generated using Laravel's queue tooling where required.

The resulting migration must be committed to GitHub.

---

# 19. Redis Queue

Redis may be used if:

* Hostinger supports it appropriately.
* The project requires higher-performance queue processing.
* The infrastructure can maintain Redis reliably.

Redis should not be introduced solely because it is available.

---

# 20. Synchronous Queue

The synchronous driver may be appropriate for simple operations during development.

However, long-running production operations should not automatically execute synchronously because they can increase web request time.

---

# 21. Queue Worker

A production queue worker must continuously process queued jobs where asynchronous processing is required.

Conceptually:

```text id="y3j8v6"
Queue
  │
  ▼
Worker
  │
  ├── Job 1
  ├── Job 2
  ├── Job 3
  └── Job 4
```

---

# 22. Hostinger Worker Strategy

The exact queue worker strategy must be based on Hostinger's available process-management capabilities.

Possible approaches include:

* Persistent process where supported.
* Supervisor/process manager where supported.
* Cron-based queue processing.
* Database queue with controlled execution.
* External queue worker.

The simplest reliable strategy should be selected for the initial deployment.

---

# 23. Queue Worker Memory

Long-running workers can accumulate memory depending on application behavior.

Workers should be restarted periodically or according to Laravel's recommended worker lifecycle strategy.

---

# 24. Queue Restart After Deployment

When new application code is deployed, existing workers may still contain old application code in memory.

Workers should therefore be instructed to restart gracefully after deployments where required.

A deployment procedure should include the appropriate Laravel queue restart mechanism.

---

# 25. Failed Jobs

Production queued jobs must be monitored for failure.

Laravel's failed-job functionality should be enabled where appropriate.

A failed job should record enough information to investigate the failure without exposing secrets.

---

# 26. Failed Job Recovery

A failed job should follow:

```text id="j6t4p8"
Job fails
   ↓
Failure recorded
   ↓
Investigate
   ↓
Correct cause
   ↓
Retry
   ↓
Verify
```

Do not repeatedly retry a job that is failing because of a permanent application error.

---

# 27. Queue Retry Strategy

Jobs should have appropriate:

* Retry count.
* Timeout.
* Backoff.
* Failure handling.

These settings should be based on the type of operation.

External API requests may require longer backoff periods than simple database operations.

---

# 28. Queue Timeouts

Queue timeouts must account for the actual task duration.

A timeout that is too short may repeatedly terminate legitimate jobs.

A timeout that is too long may cause workers to remain occupied unnecessarily.

---

# 29. Laravel Scheduler

SMEvolve may use Laravel's Scheduler for recurring tasks.

Conceptually:

```text id="j7v2m6"
Laravel Scheduler
       │
       ├── Daily Tasks
       ├── Hourly Tasks
       ├── Notifications
       ├── Cleanup
       └── Maintenance
```

---

# 30. Scheduler Configuration

Scheduled tasks should be defined using Laravel's supported scheduling mechanism.

The exact implementation must follow the Laravel 12 project structure.

---

# 31. Hostinger Cron

Hostinger must execute Laravel's scheduler at the required frequency.

The preferred pattern is a cron invocation that triggers Laravel's scheduler.

Conceptually:

```text id="8s4c9k"
Hostinger Cron
      ↓
Laravel Scheduler
      ↓
Scheduled Tasks
```

The exact cron command must use the actual production project path.

---

# 32. Scheduler Frequency

The scheduler should run frequently enough to support the application's scheduled tasks.

A typical Laravel deployment uses a scheduler invocation every minute.

The exact Hostinger cron expression must be configured according to Hostinger's cron interface.

---

# 33. Scheduled Email Notifications

If SMEvolve sends scheduled notifications, they should be handled through Laravel's scheduler and/or queues.

Example:

```text id="3c7w1p"
Scheduler
   ↓
Create notification job
   ↓
Queue
   ↓
Worker
   ↓
Email Provider
   ↓
Recipient
```

This prevents scheduled email operations from unnecessarily blocking web requests.

---

# 34. Scheduled Cleanup

The scheduler may perform cleanup operations such as:

* Temporary file cleanup.
* Expired records.
* Old logs where appropriate.
* Old application data according to retention rules.

Deletion tasks must have clearly defined retention periods.

---

# 35. Scheduled Reports

If SMEvolve generates periodic reports, the recommended architecture is:

```text id="y8g5k2"
Scheduler
   ↓
Queue Report Job
   ↓
Worker
   ↓
Generate Report
   ↓
Store / Send
```

Large reports should not be generated inside a normal web request.

---

# 36. Scheduled API Operations

If the application periodically communicates with external services, these operations should use controlled jobs.

The implementation should account for:

* API rate limits.
* Network failures.
* Retries.
* Authentication failures.
* Timeouts.

---

# 37. Scheduler Idempotency

Scheduled tasks should be designed so that accidental duplicate execution does not cause serious problems.

For example:

```text id="x7v9p1"
Check whether task already completed
        ↓
If completed → Skip
If not → Execute
```

This is particularly important when jobs may overlap.

---

# 38. Preventing Overlapping Jobs

Long-running scheduled tasks should use Laravel's supported mechanisms to prevent overlapping executions where appropriate.

Example scenario:

```text id="c8m4t6"
10:00 → Job starts
10:01 → Previous job still running
10:01 → New execution should not duplicate it
```

---

# 39. Scheduler Monitoring

Verify that scheduled tasks are actually executing.

Monitor:

* Expected job output.
* Queue activity.
* Logs.
* Email delivery.
* Database changes.
* Failed jobs.

---

# 40. Cron Verification

After configuring Hostinger Cron, verify that:

```text id="n2g7w5"
✓ Cron is active
✓ Laravel scheduler executes
✓ Scheduled tasks run
✓ No repeated errors
✓ Queue jobs are created
```

---

# 41. Queue Monitoring

Monitor:

```text id="z6k3r9"
Pending jobs
Processing jobs
Failed jobs
Repeated failures
Worker availability
```

The exact monitoring method depends on the selected Hostinger architecture.

---

# 42. Log Monitoring

Queue and scheduler errors should be visible through Laravel logs.

Common location:

```text id="5y9j2m"
storage/logs/
```

Logs must be protected from public access.

---

# 43. Storage Backup

Important uploaded files should be included in the backup strategy.

A database backup alone is not sufficient if SMEvolve stores important documents or files on the server.

---

# 44. File Recovery

If user files are lost:

```text id="c4f7k1"
Identify missing files
       ↓
Identify backup
       ↓
Restore files
       ↓
Verify permissions
       ↓
Verify application access
```

---

# 45. Queue Incident Procedure

If queued jobs stop processing:

```text id="w5h3s7"
Check queue connection
        ↓
Check worker
        ↓
Check failed jobs
        ↓
Check application logs
        ↓
Check database/Redis
        ↓
Restart worker
        ↓
Retry jobs
```

---

# 46. Scheduler Incident Procedure

If scheduled tasks stop running:

```text id="e6j9q3"
Check Hostinger Cron
        ↓
Check Laravel scheduler
        ↓
Check application logs
        ↓
Check server path
        ↓
Run scheduler manually
        ↓
Correct configuration
        ↓
Verify next scheduled execution
```

---

# 47. Production Storage Security

Verify:

```text id="u3n8m5"
✓ Private files are not public
✓ Upload validation exists
✓ Storage permissions are correct
✓ .env is protected
✓ Logs are protected
✓ Executable uploads are prevented
✓ Storage usage is monitored
```

---

# 48. Deployment Sequence

After application deployment:

```text id="x9v5r2"
Deploy Code
    ↓
Install Dependencies
    ↓
Configure Storage
    ↓
Run Migrations
    ↓
Configure Queue
    ↓
Configure Scheduler
    ↓
Restart Workers
    ↓
Run Scheduler Test
    ↓
Process Test Job
    ↓
Verify
```

---

# 49. Production Test Job

Before considering the queue operational, execute a controlled test job.

The test should confirm:

```text id="g4w7k9"
✓ Job enters queue
✓ Worker receives job
✓ Job executes
✓ Expected result occurs
✓ No failure recorded
```

---

# 50. Production Scheduler Test

Execute a controlled scheduled task or verify the next scheduled execution.

Confirm:

```text id="m8c2q5"
✓ Cron triggers
✓ Laravel scheduler executes
✓ Task is detected
✓ Task completes
✓ Logs show expected activity
```

---

# 51. Resource Considerations

Queues and scheduled jobs consume:

* CPU.
* Memory.
* Database connections.
* Storage.
* Network resources.

The Hostinger plan must be monitored to ensure background processing does not interfere with normal website traffic.

---

# 52. Scaling

If SMEvolve outgrows the initial Hostinger configuration, background processing may be separated into dedicated infrastructure.

Potential future architecture:

```text id="v4r7s2"
Hostinger Web Application
          │
          ▼
       Queue
          │
          ▼
Dedicated Worker
          │
          ▼
External Services
```

This is a future scaling option and is not required for the initial deployment.

---

# 53. Acceptance Criteria

This document is complete when:

✓ Laravel storage architecture is defined.

✓ Public/private storage is defined.

✓ File-upload security is defined.

✓ Storage permissions are defined.

✓ Storage backup requirements are defined.

✓ Queue architecture is defined.

✓ Queue worker strategy is defined.

✓ Failed-job handling is defined.

✓ Queue retry strategy is defined.

✓ Worker restart requirements are defined.

✓ Laravel Scheduler is defined.

✓ Hostinger Cron requirements are defined.

✓ Scheduled notifications are defined.

✓ Scheduled cleanup is defined.

✓ Scheduled report processing is defined.

✓ Scheduler monitoring is defined.

✓ Queue monitoring is defined.

✓ Incident procedures are defined.

✓ Production queue and scheduler tests are defined.

---

# 54. Next Document

The next document is:

```text id="2s8m4v"
10_Email_Configuration.md
```

This will define SMEvolve's production email infrastructure, SMTP/transactional email provider, domain authentication, SPF, DKIM, DMARC, email notifications, Laravel mail configuration, templates, testing, delivery monitoring, and failure handling.
