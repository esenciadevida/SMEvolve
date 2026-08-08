# SMEvolve Deployment

## 15 – GitHub Repository & CI/CD

**Project:** SMEvolve

**Module:** Deployment

**Documentation Path:** `Documentation/18_Deployment/`

**Framework:** Laravel 12

**Source Control:** GitHub

**Production Hosting:** Hostinger

**Deployment Method:** GitHub → Hostinger

**Document Version:** 1.0

**Status:** Draft

---

# 1. Purpose

This document defines how SMEvolve source code is managed in GitHub and how changes are prepared, tested, deployed, and rolled back in production.

It covers:

* GitHub repository structure.
* Branch strategy.
* Commit conventions.
* `.gitignore`.
* Pull requests.
* Code review.
* GitHub Actions.
* CI/CD.
* Hostinger deployment.
* Deployment secrets.
* Production deployment.
* Rollback.
* Deployment verification.

The objective is to provide a controlled and repeatable path from code changes to the production environment.

---

# 2. Deployment Architecture

The intended deployment flow is:

```text
Developer
    │
    ▼
Local Development
    │
    ▼
GitHub Repository
    │
    ▼
CI / Automated Checks
    │
    ▼
Production Deployment
    │
    ▼
Hostinger
    │
    ▼
SMEvolve Production
```

GitHub is the source of truth for application code.

Hostinger is the production runtime environment.

---

# 3. Repository

The SMEvolve project should have a dedicated GitHub repository.

Example:

```text
github.com/[organization-or-user]/smevolve
```

The actual repository URL must be recorded once the repository is created.

---

# 4. Repository Visibility

The repository should remain private unless the project owner explicitly decides that it should be public.

A private repository is recommended because the application may contain:

* Business logic.
* Internal documentation.
* Configuration structure.
* Proprietary code.
* Development information.

---

# 5. Repository Structure

The repository should maintain a clean structure.

Example:

```text
smevolve/
├── app/
├── bootstrap/
├── config/
├── database/
├── public/
├── resources/
├── routes/
├── storage/
├── tests/
├── Documentation/
├── .env.example
├── .gitignore
├── composer.json
├── composer.lock
├── package.json
├── package-lock.json
└── README.md
```

The actual structure must follow the implemented application.

---

# 6. Gitignore

The repository must exclude sensitive and generated files.

Important examples include:

```text
.env
.env.*
vendor/
node_modules/
storage/logs/
storage/framework/cache/
storage/framework/sessions/
storage/framework/views/
```

The exact `.gitignore` should be based on Laravel's recommended configuration and the project's requirements.

---

# 7. Environment Files

The repository may contain:

```text
.env.example
```

but must not contain:

```text
.env
```

Production secrets must never be committed.

---

# 8. Secret Management

Secrets must be stored outside the Git repository.

Examples include:

* Database passwords.
* SMTP passwords.
* API keys.
* Laravel `APP_KEY`.
* Deployment credentials.
* Hostinger SSH credentials.

GitHub Actions secrets should be used for CI/CD secrets where applicable.

---

# 9. Branch Strategy

The initial branch structure should remain simple.

Recommended:

```text
main
 │
 ├── feature/*
 ├── fix/*
 └── chore/*
```

`main` represents production-ready code.

---

# 10. Main Branch

The `main` branch should contain code that is suitable for production deployment.

Direct pushes to `main` should be restricted where practical.

Changes should preferably enter through a pull request.

---

# 11. Feature Branches

New functionality should be developed using feature branches.

Example:

```text
feature/admin-dashboard
feature/search-engine
feature/email-notifications
```

Feature branches should be merged into `main` only after required checks have passed.

---

# 12. Fix Branches

Bug fixes should use appropriately named branches.

Example:

```text
fix/login-validation
fix/email-delivery
fix/mobile-navigation
```

---

# 13. Commit Messages

Commits should clearly describe the change.

Examples:

```text
feat: add admin user management
fix: correct email notification failure
refactor: simplify dashboard service
docs: update deployment instructions
chore: update Laravel dependencies
```

---

# 14. Pull Requests

Pull requests should contain:

* Summary of the change.
* Reason for the change.
* Important implementation details.
* Testing performed.
* Potential deployment considerations.

Large unrelated changes should not be bundled into the same pull request unnecessarily.

---

# 15. Code Review

Where multiple developers are involved, important changes should receive code review before merging.

Review should consider:

* Functionality.
* Security.
* Performance.
* Database changes.
* Tests.
* Configuration changes.
* Deployment impact.

---

# 16. Required Checks

Before merging into `main`, the project should run appropriate automated checks.

Potential checks include:

```text
PHP syntax
Laravel tests
PHP static analysis
JavaScript checks
Frontend build
Dependency/security checks
```

The exact checks should reflect the implemented project.

---

# 17. Continuous Integration

CI should verify that the project can successfully build and test outside the developer's local machine.

Typical flow:

```text
Pull Request
     ↓
GitHub Actions
     ↓
Install Dependencies
     ↓
Run Tests
     ↓
Build Frontend
     ↓
Report Result
```

---

# 18. GitHub Actions

GitHub Actions may be used for automated CI/CD.

Workflow files should be stored under:

```text
.github/workflows/
```

Example:

```text
.github/
└── workflows/
    ├── tests.yml
    └── deploy.yml
```

---

# 19. CI Workflow

The CI workflow should generally:

1. Check out the repository.
2. Install the required PHP version.
3. Install Composer dependencies.
4. Configure the test environment.
5. Run migrations where required.
6. Run Laravel tests.
7. Install frontend dependencies.
8. Build frontend assets.
9. Report success/failure.

---

# 20. Test Database

CI should use an isolated test database.

It must never connect to the production database during normal testing.

Example:

```text
CI
 ↓
Test Database
 ↓
Tests
```

not:

```text
CI
 ↓
Production Database
```

---

# 21. Production Deployment Trigger

Production deployment should occur only after code has been successfully merged into the production branch.

Recommended:

```text
Pull Request
      ↓
Review
      ↓
Merge to main
      ↓
CI
      ↓
Deploy
      ↓
Hostinger
```

---

# 22. Deployment Options

The project may deploy to Hostinger using an appropriate supported method.

Potential approaches include:

* SSH.
* Git deployment.
* SFTP/FTP.
* Hostinger Git integration.
* GitHub Actions deployment.

The final method should be selected based on the Hostinger plan and available features.

---

# 23. Recommended Deployment Method

Where supported, SSH-based deployment is preferred over manually uploading the entire application for every release.

A controlled automated process reduces:

* Human error.
* Inconsistent deployments.
* Missing files.
* Forgotten build steps.

---

# 24. Hostinger Deployment

The deployment process should ultimately transfer the approved application version from GitHub to Hostinger.

Conceptually:

```text
GitHub main
    ↓
GitHub Actions
    ↓
Hostinger
    ↓
Laravel Application
```

---

# 25. Deployment Credentials

Deployment credentials must be stored securely.

If GitHub Actions connects to Hostinger through SSH, the SSH private key should be stored as an encrypted GitHub Actions secret.

Example secret names:

```text
HOSTINGER_HOST
HOSTINGER_USER
HOSTINGER_SSH_KEY
```

Actual credentials must never appear in the workflow file.

---

# 26. Hostinger Environment Secrets

Application secrets such as:

```text
APP_KEY
DB_PASSWORD
MAIL_PASSWORD
API_KEYS
```

should remain on the production server rather than being committed to GitHub.

CI/CD should not expose them unnecessarily.

---

# 27. Deployment Preparation

Before deployment:

```text
✓ CI passes
✓ Pull request approved
✓ main branch updated
✓ Production backup available
✓ Deployment target available
✓ Required migrations reviewed
```

---

# 28. Deployment Process

A typical deployment should follow:

```text
1. Pull approved code
2. Install/update Composer dependencies
3. Build frontend assets
4. Run required migrations
5. Clear/rebuild Laravel caches
6. Update application
7. Restart required workers
8. Verify application
```

The exact order should be adjusted to minimize downtime and avoid inconsistent application states.

---

# 29. Database Migrations

Database migrations require special attention.

A deployment containing migrations should not be considered complete until:

```text
Migration
   ↓
Database verification
   ↓
Application verification
```

has succeeded.

---

# 30. Zero-Downtime Considerations

The initial SMEvolve deployment may not require a complex zero-downtime deployment system.

However, deployments should avoid leaving the application in a partially updated state.

As traffic increases, a more advanced deployment strategy may be introduced.

---

# 31. Frontend Build

The production frontend should be built during deployment or through CI.

Typical command:

```text
npm run build
```

The generated assets must be available to the Laravel application.

---

# 32. Composer Installation

Production PHP dependencies should be installed using:

```text
composer install --no-dev --optimize-autoloader
```

The `composer.lock` file should be used to maintain dependency consistency.

---

# 33. Laravel Cache

After deployment, configuration and application caches should be refreshed where required.

Typical commands may include:

```text
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

These should be tested against the application's actual configuration.

---

# 34. Queue Workers

If the application uses queue workers, the deployment must account for worker processes.

After a deployment, workers may need to be restarted so they load the latest application code.

---

# 35. Scheduled Tasks

Laravel scheduled tasks must continue functioning after deployment.

Verify the Hostinger cron configuration after major deployment changes.

---

# 36. Deployment Verification

After deployment:

```text
Production
    ↓
Homepage
    ↓
Authentication
    ↓
Database
    ↓
Admin Portal
    ↓
Forms
    ↓
Email
    ↓
Chatbot
    ↓
Search
```

Critical application functionality must be checked.

---

# 37. Smoke Tests

A basic production smoke test should verify:

```text
✓ Homepage loads
✓ Login works
✓ Registration works where applicable
✓ Database queries work
✓ Admin Portal loads
✓ Forms submit
✓ Email notifications work
✓ Chatbot works
✓ Search works
✓ Static assets load
```

---

# 38. Deployment Logs

Every production deployment should have enough information to determine:

* When deployment occurred.
* Which commit was deployed.
* Whether CI passed.
* Whether deployment succeeded.
* Whether migrations ran.
* Whether rollback occurred.

---

# 39. Version Identification

The production application should make it possible to identify the deployed version.

A useful identifier is:

```text
Git commit SHA
```

For example:

```text
Release: a1b2c3d
```

This makes troubleshooting and rollback easier.

---

# 40. Rollback

If a deployment causes a serious problem:

```text
Current Release
      ↓
Identify Problem
      ↓
Select Known-Good Commit
      ↓
Rollback Application
      ↓
Verify
```

---

# 41. Database Rollback

Application rollback and database rollback are not always equivalent.

If a migration changed the database structure, reverting the application code alone may not restore compatibility.

Before destructive migrations:

```text
✓ Database backup
✓ Migration review
✓ Recovery plan
```

must exist.

---

# 42. Emergency Rollback

An emergency rollback should prioritize restoring service safely.

The process may involve:

1. Identify the failed release.
2. Stop further deployments.
3. Identify the last known-good release.
4. Restore application code.
5. Restore database only if required.
6. Verify critical functionality.
7. Monitor production.

---

# 43. Failed Deployment

If deployment fails before completion:

```text
Deployment Failure
       ↓
Determine Stage
       ↓
Restore Consistent State
       ↓
Review Logs
       ↓
Fix Cause
       ↓
Redeploy
```

Do not repeatedly redeploy without understanding the failure.

---

# 44. CI/CD Security

GitHub Actions workflows should follow least privilege.

Workflows should request only the permissions they need.

Production deployment should not expose application secrets to arbitrary pull requests.

---

# 45. Pull Request Security

Production secrets must never be made available to untrusted pull-request workflows.

This is particularly important when workflows execute code supplied by contributors.

---

# 46. Dependency Security

CI should periodically check dependencies for known security vulnerabilities.

The project should review:

```text
composer.lock
package-lock.json
```

and update dependencies when appropriate.

---

# 47. Deployment Notifications

The deployment pipeline may send notifications when a production deployment:

* Succeeds.
* Fails.
* Is rolled back.

Possible channels include:

* Email.
* Slack.
* Other project notification systems.

The notification method can be added when the project's operational requirements justify it.

---

# 48. Deployment Documentation

Each significant production deployment should be traceable to:

```text
GitHub Commit
     +
Pull Request
     +
CI Result
     +
Deployment Result
```

This creates an audit trail for production changes.

---

# 49. Branch Protection

The `main` branch should use appropriate GitHub branch protection.

Recommended controls may include:

```text
✓ Pull request required
✓ CI checks required
✓ Direct push restricted
✓ Force push restricted
✓ Branch deletion restricted
```

The exact configuration should reflect the team's size and workflow.

---

# 50. Release Tags

For major production releases, Git tags may be used.

Example:

```text
v1.0.0
v1.1.0
v1.2.0
```

Tags provide stable references for released versions.

---

# 51. Deployment Checklist

```text
BEFORE MERGE
✓ Feature complete
✓ Tests pass
✓ Code reviewed
✓ Security reviewed where necessary
✓ Database changes reviewed

BEFORE DEPLOYMENT
✓ main updated
✓ CI passes
✓ Production backup available
✓ Deployment credentials available
✓ Hostinger available

DEPLOYMENT
✓ Code deployed
✓ Composer dependencies installed
✓ Frontend built
✓ Migrations completed
✓ Cache rebuilt
✓ Queue workers restarted if required
✓ Cron verified

AFTER DEPLOYMENT
✓ Homepage tested
✓ Authentication tested
✓ Database tested
✓ Admin Portal tested
✓ Forms tested
✓ Email tested
✓ Chatbot tested
✓ Search tested
✓ Logs reviewed

ROLLBACK
✓ Known-good commit identified
✓ Backup available
✓ Rollback procedure understood
```

---

# 52. Acceptance Criteria

This document is complete when:

✓ GitHub repository requirements are defined.

✓ Repository structure is defined.

✓ Branch strategy is defined.

✓ Commit conventions are defined.

✓ Pull-request workflow is defined.

✓ Code-review requirements are defined.

✓ CI requirements are defined.

✓ GitHub Actions structure is defined.

✓ Hostinger deployment strategy is defined.

✓ Deployment credentials are defined.

✓ Production secrets are protected.

✓ Deployment process is defined.

✓ Database migration handling is defined.

✓ Queue and cron deployment considerations are defined.

✓ Deployment verification is defined.

✓ Rollback strategy is defined.

✓ Emergency recovery is defined.

✓ Deployment security is defined.

✓ Production deployment checklist is defined.

---

# 53. Next Document

The next document is:

```text
Documentation/18_Deployment/16_Email_Notifications_And_Monitoring.md
```

This will cover **SMEvolve website email notifications, Hostinger/email-provider configuration, transactional emails, SMTP/API delivery, email templates, failed-email handling, application monitoring, uptime monitoring, error monitoring, alerts, and operational notifications**.
