# SMEvolve Deployment

## 06 – Database Setup

**Project:** SMEvolve

**Module:** Deployment

**Documentation Path:** `Documentation/18_Deployment/`

**Framework:** Laravel 12

**Database:** MySQL

**Source Control:** GitHub

**Production Hosting:** Hostinger

**Document Version:** 1.0

**Status:** Draft

---

# 1. Purpose

This document defines the production database setup and deployment requirements for SMEvolve.

It covers:

* Hostinger database creation.
* Database credentials.
* MySQL configuration.
* Laravel database connection.
* Character set and collation.
* Migrations.
* Seed data.
* Indexes.
* Database security.
* Backup requirements.
* Migration safety.
* Verification.
* Recovery considerations.

The objective is to ensure that the SMEvolve production database is secure, reliable, maintainable, and correctly connected to the Laravel application.

---

# 2. Database Architecture

The production application will use a dedicated production database.

The architecture is:

```text id="s4s0n2"
                    Hostinger
                       │
                       ▼
                ┌─────────────┐
                │   Laravel   │
                │ Application │
                └──────┬──────┘
                       │
                 Secure DB Connection
                       │
                       ▼
                ┌─────────────┐
                │    MySQL    │
                │  Production │
                │  Database   │
                └─────────────┘
```

The production database must remain separate from development and testing databases.

---

# 3. Database Provider

The initial production database will be hosted through the Hostinger environment.

The exact database hostname, database name, username, and available database management interface must be obtained from the active Hostinger account.

Do not assume these values.

---

# 4. Database Requirements

The production database must support:

* MySQL-compatible Laravel connections.
* UTF-8/Unicode data.
* Transactions.
* Foreign keys.
* Indexes.
* Migrations.
* Appropriate connection limits.
* Reliable backups.

The database version should be verified against the Laravel application's requirements.

---

# 5. Database Creation

Create the production database through the Hostinger database management interface.

The database should have a clear production-specific name.

Example:

```text id="7v9tq1"
smevolve_production
```

The actual Hostinger-generated database name may follow the hosting account's naming convention.

Do not hard-code an assumed database name in deployment documentation.

---

# 6. Database User

A dedicated database user should be used for SMEvolve.

Example:

```text id="q4z8py"
smevolve_app
```

The actual username will depend on Hostinger's database configuration.

Do not use a shared database administrator account for routine application access.

---

# 7. Database Password

The production database password must:

* Be unique.
* Be sufficiently strong.
* Never be committed to GitHub.
* Never appear in documentation.
* Never be included in frontend code.
* Be stored securely.

If the password is exposed, it must be rotated immediately.

---

# 8. Database Privileges

The application database user should have only the privileges required for normal application operation.

Required privileges may include:

* SELECT.
* INSERT.
* UPDATE.
* DELETE.
* CREATE.
* ALTER.
* INDEX.
* REFERENCES.

Migration requirements may temporarily require broader schema privileges depending on the database setup.

The exact privileges must follow Hostinger's available database permissions.

---

# 9. Database Connection

Laravel should connect through environment variables.

Example:

```text id="pl3t8n"
DB_CONNECTION=mysql
DB_HOST=
DB_PORT=3306
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
```

Actual production values must be stored only in the production environment.

---

# 10. Database Host

The database host must be obtained from Hostinger.

It may be a local hostname, server hostname, or provider-specific database endpoint.

Do not assume:

```text id="5f3p1c"
localhost
```

or:

```text id="5l0s7q"
127.0.0.1
```

unless confirmed by Hostinger.

---

# 11. Database Port

The normal MySQL port is:

```text id="6a1s9d"
3306
```

The actual production port must be confirmed against the Hostinger environment.

---

# 12. Database Character Set

The production database should use:

```text id="t0s7k3"
utf8mb4
```

This provides broad Unicode support.

It is appropriate for:

* Customer names.
* Business names.
* User-generated text.
* International characters.
* Multilingual content.

---

# 13. Database Collation

The selected collation should be compatible with:

* MySQL version.
* Laravel.
* Existing migrations.
* Application search requirements.

The final collation should be standardized across the application database rather than mixing incompatible collations unnecessarily.

---

# 14. Laravel Database Configuration

Laravel's database configuration should use the project's existing `config/database.php`.

The deployment should not unnecessarily modify framework configuration when environment variables can provide the required values.

---

# 15. Database Connectivity Test

After configuring the production environment, verify that Laravel can connect to the database.

A suitable Artisan/database test should be used according to the deployed Laravel version.

The verification should confirm:

```text id="b7j1u4"
✓ Database reachable
✓ Credentials valid
✓ Correct database selected
✓ Laravel can execute queries
```

---

# 16. Migrations

The production schema must be created through Laravel migrations.

The deployment process should use:

```text id="f4x3c8"
php artisan migrate --force
```

when executing migrations in production.

The `--force` flag is required for non-interactive production migration execution where supported by Laravel.

---

# 17. Migration Review

Before production migrations are executed:

1. Review all pending migrations.
2. Confirm expected schema changes.
3. Identify destructive operations.
4. Verify indexes.
5. Verify foreign keys.
6. Back up the database.
7. Execute migrations.
8. Verify the resulting schema.

---

# 18. Destructive Migrations

Destructive operations require special review.

Examples include:

```text id="x8k4r2"
DROP TABLE
DROP COLUMN
TRUNCATE
Changing incompatible data types
Removing constraints
```

A destructive migration must not be executed blindly in production.

If existing data may be affected, a migration strategy must be created before deployment.

---

# 19. Migration Ordering

Laravel migration filenames determine migration order.

Do not manually reorder historical migrations after they have already been executed in production.

New schema changes should normally be implemented through new migrations.

---

# 20. Production Migration Rule

Production migrations should follow:

```text id="m3r8p6"
Backup
   ↓
Review
   ↓
Deploy code
   ↓
Run migration
   ↓
Verify
```

Do not run migrations against production before the corresponding application code is ready unless the migration is explicitly designed for backward compatibility.

---

# 21. Backward-Compatible Migrations

Where possible, database changes should support rolling deployments.

For example:

```text id="f9c5m1"
Deploy schema addition
        ↓
Deploy compatible application code
        ↓
Migrate existing data
        ↓
Remove obsolete schema later
```

This reduces deployment risk.

---

# 22. Seeders

Production seeders must be used carefully.

Seeders may be appropriate for:

* Required system settings.
* Default roles.
* Default permissions.
* Required configuration records.

Do not run development/test seeders against production.

---

# 23. Production Seed Data

If SMEvolve requires mandatory initial records, create a dedicated production-safe seeding strategy.

For example:

```text id="z8v3p4"
php artisan db:seed --class=ProductionSeeder
```

Only use this if such a seeder exists and has been specifically designed for production.

---

# 24. Administrative Account

If the Admin Portal requires an initial administrator account, the account creation process must be secure.

Do not hard-code an administrator password into a seeder.

Initial credentials should be created through a secure process and changed after first login where appropriate.

---

# 25. Database Indexes

Production tables must have appropriate indexes for frequently queried fields.

Potential indexed fields may include:

* Email.
* User ID.
* Status.
* Created date.
* Foreign keys.
* Search-related identifiers.

Indexes should be based on actual application queries rather than added indiscriminately.

---

# 26. Foreign Keys

Foreign-key relationships should be enforced where appropriate.

Examples may include:

```text id="j0y7se"
users
   │
   ├── quotes
   ├── notifications
   └── other related records
```

Foreign-key behavior must be explicitly defined.

Use appropriate delete/update behavior based on business requirements.

---

# 27. Data Integrity

The database must protect important business rules where appropriate through:

* Foreign keys.
* Unique constraints.
* Required fields.
* Appropriate data types.
* Validation at application level.

Application validation should not be the only protection for critical uniqueness or relational requirements.

---

# 28. Unique Constraints

Fields that must be unique should have database-level uniqueness where appropriate.

Examples may include:

```text id="t8h1j9"
Email address
Unique business identifier
External transaction identifier
```

The exact constraints must follow SMEvolve's application requirements.

---

# 29. Timestamps

Laravel-managed tables should use appropriate timestamp fields where required.

Typical fields include:

```text id="q5x7n2"
created_at
updated_at
```

Date/time handling must use a consistent application/database strategy.

---

# 30. Timezone

The production application and database should use a documented timezone strategy.

The application should avoid storing ambiguous local times.

Where appropriate, store timestamps consistently and convert them for display.

The production timezone must be explicitly verified during deployment.

---

# 31. Sensitive Data

Sensitive data stored in the database must be handled appropriately.

Examples include:

* Authentication credentials.
* Tokens.
* Private customer information.
* API credentials.

Passwords must never be stored as plaintext.

Laravel's password hashing facilities must be used.

---

# 32. Database Credentials in Logs

Database credentials must never appear in:

* Laravel logs.
* Error messages.
* GitHub Actions logs.
* Screenshots.
* Support tickets.

Connection errors should be logged without exposing credentials.

---

# 33. Database Backups

Production database backups are mandatory.

Backups should be performed:

* Before major deployments.
* Before risky migrations.
* On a regular schedule.
* Before destructive database operations.

---

# 34. Backup Location

Backups should not exist exclusively on the same production server.

Where possible:

```text id="m5k3z7"
Production Database
        ↓
Backup
        ↓
Independent Storage
```

Hostinger's built-in backup capability may be used as an additional recovery layer.

---

# 35. Backup Retention

A documented retention policy should define:

* Daily backups.
* Weekly backups.
* Monthly backups where appropriate.
* Retention duration.

The exact schedule should reflect the project's data volume and business requirements.

---

# 36. Backup Verification

A backup should periodically be restored into a safe non-production environment to verify that it is usable.

A successful backup process should be:

```text id="p2r5d9"
Backup created
      ↓
Backup verified
      ↓
Restore test
      ↓
Recovery confirmed
```

---

# 37. Database Restore

A production restore must be treated as a controlled incident.

Before restoration:

1. Identify the failure.
2. Preserve the current state if possible.
3. Select the correct backup.
4. Confirm the recovery point.
5. Restore to a controlled environment where possible.
6. Verify data integrity.
7. Restore production.
8. Verify the application.

---

# 38. Database Monitoring

Monitor where possible:

* Database size.
* Connection usage.
* Slow queries.
* Errors.
* Storage capacity.
* Backup success.

Hostinger's available monitoring features should be reviewed.

---

# 39. Query Performance

Database performance should be monitored as traffic increases.

Potential issues include:

* Missing indexes.
* N+1 queries.
* Large unbounded queries.
* Inefficient search.
* Excessive joins.
* Repeated queries.

Application-level optimization should be preferred before increasing hosting resources unnecessarily.

---

# 40. Database Transactions

Critical multi-step operations should use database transactions where appropriate.

For example:

```text id="t3z8k5"
Create Quote
   ↓
Create Related Records
   ↓
Commit
```

If an operation fails:

```text id="k8m1v6"
Rollback
```

This prevents partially completed operations.

---

# 41. Database Connection Limits

The Hostinger plan's database connection limits must be reviewed.

The application should avoid unnecessary persistent connections.

Queue workers and scheduled tasks should also be designed with available connection limits in mind.

---

# 42. Database Security

The database must not be exposed unnecessarily to the public internet.

Where Hostinger architecture allows it, database access should remain internal to the hosting environment.

Administrative database tools should be protected by strong authentication.

---

# 43. phpMyAdmin

If Hostinger provides phpMyAdmin or a similar database administration tool, it may be used for:

* Inspection.
* Emergency troubleshooting.
* Manual verification.

It should not replace Laravel migrations as the normal schema-management mechanism.

---

# 44. Manual Database Changes

Manual production database changes should be avoided.

If an emergency change is unavoidable:

1. Document the change.
2. Record the SQL or action performed.
3. Assess its impact.
4. Reproduce the change as a Laravel migration where appropriate.
5. Commit the migration.
6. Verify production consistency.

---

# 45. Database Deployment Sequence

The production database deployment should follow:

```text id="8u6d3c"
Create Database
       ↓
Create User
       ↓
Configure Credentials
       ↓
Test Connection
       ↓
Deploy Application
       ↓
Backup
       ↓
Run Migrations
       ↓
Seed Required Data
       ↓
Verify Tables
       ↓
Verify Application
```

---

# 46. Database Verification

After deployment, verify:

```text id="x4c7s9"
✓ Database connection works
✓ Required tables exist
✓ Migrations completed
✓ Required indexes exist
✓ Foreign keys exist
✓ Required seed data exists
✓ Application can read data
✓ Application can write data
✓ Transactions work
✓ No migration errors
```

---

# 47. Production Database Checklist

```text id="r1m6g8"
✓ Hostinger database created
✓ Database user created
✓ Strong password configured
✓ Database credentials stored securely
✓ Correct DB host verified
✓ Correct DB port verified
✓ utf8mb4 configured
✓ Collation verified
✓ Laravel connection tested
✓ Production migrations reviewed
✓ Database backup completed
✓ Migrations executed
✓ Required seed data created
✓ Indexes verified
✓ Foreign keys verified
✓ Database permissions reviewed
✓ Backup process configured
✓ Restore strategy documented
```

---

# 48. Emergency Database Procedure

If the database becomes unavailable:

```text id="g8v2k4"
Detect Failure
      ↓
Check Hostinger Status
      ↓
Check Credentials
      ↓
Check Connection Limits
      ↓
Check Database Availability
      ↓
Check Application Logs
      ↓
Restore if Required
      ↓
Verify Application
```

Do not immediately restore a backup without identifying whether the issue is actually data corruption.

---

# 49. Data Loss Prevention

To minimize data loss:

* Perform scheduled backups.
* Back up before migrations.
* Use transactions.
* Avoid destructive manual SQL.
* Monitor storage.
* Test restoration.
* Restrict database access.

---

# 50. Acceptance Criteria

This document is complete when:

✓ Hostinger production database architecture is defined.

✓ Database creation is documented.

✓ Database user requirements are documented.

✓ Database credential security is documented.

✓ Laravel connection configuration is defined.

✓ Character set requirements are defined.

✓ Collation requirements are defined.

✓ Migration strategy is defined.

✓ Production migration safety is defined.

✓ Seeder strategy is defined.

✓ Index requirements are defined.

✓ Foreign-key requirements are defined.

✓ Database security requirements are defined.

✓ Backup requirements are defined.

✓ Restore requirements are defined.

✓ Database verification is defined.

✓ Emergency database procedures are defined.

---

# 51. Next Document

The next document is:

```text id="4z7m2p"
07_Laravel_Deployment.md
```

It will define the actual Laravel application deployment process to Hostinger, including retrieving the code from GitHub, Composer installation, `.env` configuration, application permissions, migrations, cache optimization, storage linking, Vite assets, and production verification.
