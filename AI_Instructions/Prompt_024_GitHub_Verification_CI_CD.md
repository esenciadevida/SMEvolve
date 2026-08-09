# SMEvolve

## Prompt 024 – GitHub Verification & CI/CD Setup

**Project:** SMEvolve

**Document Number:** 024

**Module:** GitHub Verification & Continuous Integration

**Source Control:** GitHub

**Production Hosting:** Hostinger

**Purpose:** Verify the SMEvolve GitHub repository and establish a reliable automated validation workflow before production deployment.

**Status:** Implementation Instruction

---

# 1. OBJECTIVE

The SMEvolve project has already been:

* Documented.
* Audited.
* Gap-analyzed.
* Implemented.
* Tested locally.
* Prepared for GitHub.

The purpose of this phase is to ensure that the GitHub repository is reliable and that changes can be automatically validated before they are considered ready for production.

The workflow should become:

```text
Developer
    ↓
Local Changes
    ↓
Local Testing
    ↓
GitHub Push / Pull Request
    ↓
GitHub Actions
    ↓
Automated Validation
    ↓
Pass / Fail
    ↓
Approved Code
    ↓
Hostinger Deployment
```

---

# 2. IMPORTANT RESTRICTION

Do **not** deploy SMEvolve to Hostinger during this prompt.

This phase is strictly for:

```text
GitHub
+
Repository Verification
+
CI
+
Automated Testing
```

Hostinger deployment begins in a later prompt.

---

# 3. FIRST INSPECT THE REPOSITORY

Before making changes, inspect:

```text
Git status
Current branch
Remote repository
Repository structure
Existing GitHub Actions
Composer configuration
NPM configuration
PHP version
Laravel version
Testing configuration
Environment configuration
```

Do not assume that CI is absent.

If a workflow already exists, review it before creating another.

---

# 4. VERIFY THE GITHUB REMOTE

Confirm that the local project points to the correct SMEvolve GitHub repository.

Verify:

```text
Remote URL
Default branch
Tracking branch
Repository accessibility
```

Do not replace an existing remote without confirming that it is the intended repository.

---

# 5. VERIFY THE MAIN BRANCH

The primary production branch should normally be:

```text
main
```

If the repository already uses an approved alternative, preserve the existing workflow unless there is a documented reason to change it.

---

# 6. VERIFY REPOSITORY CONTENT

Confirm that GitHub contains the expected project files.

At minimum, review:

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
Documentation/
composer.json
composer.lock
package.json
```

The exact structure may differ depending on the approved SMEvolve architecture.

Do not require files that are not part of the project.

---

# 7. VERIFY SECRETS

Before configuring CI, verify that the repository does not contain:

```text
.env
Production credentials
API keys
Database passwords
Mail passwords
Private keys
Payment secrets
AI provider secrets
```

If a secret is discovered, stop and address the exposure before continuing.

---

# 8. VERIFY `.gitignore`

Confirm that the `.gitignore` prevents inappropriate files from entering the repository.

Pay particular attention to:

```text
.env
node_modules/
vendor/
storage/logs/
storage/framework/
bootstrap/cache/
```

Use the project's actual requirements when deciding what should be tracked.

---

# 9. VERIFY DEPENDENCY FILES

Confirm that dependency definitions and required lock files are present.

For PHP:

```text
composer.json
composer.lock
```

For frontend dependencies:

```text
package.json
```

and the appropriate lock file.

Do not regenerate lock files unnecessarily.

---

# 10. VERIFY PHP VERSION

Determine the PHP version required by the SMEvolve project.

Check:

```text
composer.json
Laravel requirements
Hostinger-compatible PHP version
```

The CI environment must use a compatible PHP version.

Do not arbitrarily upgrade PHP during this phase.

---

# 11. VERIFY LARAVEL VERSION

Confirm that the project is running the documented Laravel version.

Expected framework:

```text
Laravel 12
```

CI must test against the version actually specified by the project.

---

# 12. VERIFY NODE VERSION

If SMEvolve requires frontend asset compilation, determine the required Node.js version from:

```text
package.json
package manager configuration
documentation
existing build configuration
```

Use a compatible Node version in CI.

Do not introduce a new Node version without justification.

---

# 13. CREATE GITHUB ACTIONS WORKFLOW

If CI does not already exist, create an appropriate workflow under:

```text
.github/workflows/
```

Recommended workflow name:

```text
ci.yml
```

The workflow should validate the project when appropriate changes are pushed or submitted through a pull request.

---

# 14. CI TRIGGERS

The CI workflow should normally run on:

```text
Push to relevant branches
Pull requests targeting main
```

Avoid unnecessary duplicate workflow executions where practical.

---

# 15. CI OBJECTIVES

The CI pipeline should verify:

```text
PHP environment
Dependency installation
Laravel configuration
Application tests
Frontend dependencies
Frontend build
```

Only include checks that are actually required by SMEvolve.

---

# 16. PHP DEPENDENCY INSTALLATION

CI should install PHP dependencies using the project's lock file.

Prefer:

```text
composer install
```

with appropriate CI-safe options.

Do not modify the dependency versions during CI simply because a newer version exists.

---

# 17. NODE DEPENDENCY INSTALLATION

If the frontend requires Node dependencies, use the project's lock file.

Prefer the appropriate deterministic installation command, such as:

```text
npm ci
```

when the project uses npm and a compatible lock file exists.

Do not use a command that silently changes dependency versions.

---

# 18. APPLICATION ENVIRONMENT

CI requires an application environment suitable for testing.

Do not use production credentials.

Use safe test configuration.

Examples:

```text
APP_ENV=testing
APP_DEBUG=true
```

where appropriate for the project's testing architecture.

---

# 19. APPLICATION KEY

If Laravel tests require an application key, generate or configure a safe testing key within CI.

Never use the production `APP_KEY`.

---

# 20. DATABASE FOR CI

Determine the database requirements of the existing test suite.

If possible, use an isolated CI database.

Common approaches include:

```text
SQLite
MySQL service
PostgreSQL service
```

Use the database technology that is compatible with the SMEvolve test suite.

Do not change the application's production database architecture just to simplify CI.

---

# 21. DATABASE MIGRATIONS

If tests require a database, CI should create the test schema using migrations.

The process may include:

```text
Migration
+
Test database
+
Seed/test data where required
+
Automated tests
```

Do not run production database migrations from GitHub Actions.

---

# 22. TEST EXECUTION

Run the project's appropriate automated test suite.

For Laravel/PHP, this may involve:

```text
php artisan test
```

or the testing command already defined by the project.

Use the project's existing testing configuration.

---

# 23. FRONTEND BUILD

If SMEvolve uses a compiled frontend, CI should verify that the frontend builds successfully.

For example:

```text
npm run build
```

Use the actual project command.

Do not invent a build command if one is already documented.

---

# 24. CODE QUALITY

If SMEvolve already uses tools such as:

```text
PHPStan
Pint
ESLint
Prettier
TypeScript
```

include appropriate checks in CI.

Do not introduce an extensive new code-quality system solely for this prompt unless required.

---

# 25. TEST FAILURES

A failed test must cause the appropriate CI job to fail.

Do not configure CI to ignore genuine application test failures merely to obtain a green pipeline.

---

# 26. BUILD FAILURES

Frontend build failures must be treated as real failures.

Do not suppress errors with commands such as:

```text
|| true
```

unless there is a documented and intentional reason.

---

# 27. SECURITY CHECKS

Where available and appropriate, enable GitHub security features such as:

```text
Dependency alerts
Dependabot
Secret scanning
Code scanning
```

Use features supported by the repository and GitHub plan.

Do not introduce excessive tooling without a clear benefit.

---

# 28. DEPENDENCY ALERTS

Enable dependency monitoring where appropriate.

The goal is to identify:

```text
Known vulnerabilities
Outdated dependencies
Security advisories
```

Do not automatically upgrade dependencies without reviewing compatibility.

---

# 29. SECRET SCANNING

Use GitHub's available secret scanning capabilities where supported.

The objective is to prevent accidental exposure of:

```text
API keys
Tokens
Passwords
Private credentials
```

---

# 30. GITHUB ACTIONS SECRETS

If CI genuinely requires a secret:

Store it using GitHub's secure secrets mechanism.

Never place secrets directly inside:

```text
.github/workflows/*.yml
```

Never hard-code them into scripts.

---

# 31. PRODUCTION SECRETS

Production secrets must remain outside CI unless a specific production deployment workflow later requires them.

Do not add Hostinger production credentials at this stage.

---

# 32. CI PERMISSIONS

GitHub Actions should use the minimum permissions necessary.

Do not grant broad repository write permissions when read-only access is sufficient.

Use explicit permissions where appropriate.

---

# 33. ACTION VERSIONS

Use stable, maintained GitHub Actions.

Avoid blindly using:

```text
@main
```

for critical actions where a stable version can be specified.

Use documented, compatible action versions.

---

# 34. CACHING

Dependency caching may be enabled to improve CI performance.

Caching must not cause stale dependencies to be used incorrectly.

Use cache mechanisms appropriate to:

```text
Composer
npm
```

where applicable.

---

# 35. WORKFLOW PERFORMANCE

CI should be reasonably efficient.

Avoid:

```text
Repeated dependency installation
Unnecessary builds
Duplicate test suites
Unnecessary jobs
```

unless there is a clear reason.

---

# 36. CI OUTPUT

CI logs should make failures understandable.

Avoid hiding errors.

A developer should be able to identify:

```text
Which step failed
Why it failed
Which command failed
```

---

# 37. PULL REQUEST VALIDATION

Pull requests targeting `main` should be validated by CI.

A pull request should not be considered production-ready when required CI checks are failing.

---

# 38. BRANCH PROTECTION

If the project workflow supports it, configure the `main` branch to require appropriate CI checks before merging.

Recommended:

```text
Required status checks
Pull request review
No force pushes
```

Do not create rules that make the normal development process unusable.

---

# 39. FORCE PUSH PROTECTION

The main branch should not be force-pushed during normal development.

Do not use force push as a solution to ordinary problems.

---

# 40. CI AND LOCAL TESTING

CI does not replace local testing.

The expected workflow is:

```text
Local development
      ↓
Local tests
      ↓
Commit
      ↓
Push
      ↓
GitHub CI
      ↓
Review
```

Both local and automated validation are important.

---

# 41. CI MUST NOT DEPLOY

At this stage:

```text
CI ≠ Production Deployment
```

Do not connect CI to Hostinger deployment yet.

The deployment workflow will be established separately.

---

# 42. HOSTINGER PREPARATION

Do not add Hostinger deployment credentials to GitHub during this prompt.

Hostinger will be configured in the deployment phase.

---

# 43. GOOGLE ANALYTICS

Google Analytics remains a separate external service.

Do not add a Google Analytics dashboard to the SMEvolve Admin Portal.

Do not add unnecessary GA configuration to the CI pipeline.

Production Google Analytics configuration will be handled during the appropriate production configuration phase.

---

# 44. EMAIL

Do not use production email credentials in CI.

If email tests are required, use:

```text
Mocking
Test mail driver
Dedicated test credentials
```

depending on the project's existing testing architecture.

---

# 45. CHATBOT

If chatbot tests require external AI services:

Do not automatically use production API credentials.

Prefer:

```text
Mock responses
Test credentials
Dedicated testing configuration
```

where appropriate.

---

# 46. SEARCH

Search tests must use the project's testing configuration.

Do not connect CI to a production search index unless explicitly required.

---

# 47. ADMIN PORTAL

Admin functionality should be tested using appropriate test users and permissions.

Do not use real administrator credentials in CI.

Test:

```text
Authorized access
Unauthorized access
Role restrictions
Protected routes
```

where such tests exist.

---

# 48. DATABASE SAFETY

CI must never connect to the production database.

This is a mandatory rule.

Verify the CI environment before running migrations or destructive test operations.

---

# 49. FILE STORAGE

CI should not use production file storage unless explicitly required.

Use:

```text
Local test storage
Temporary storage
Mock storage
```

where appropriate.

---

# 50. EXTERNAL SERVICES

External services should be mocked or isolated where practical.

CI should remain reliable even when third-party services are unavailable.

---

# 51. TIME AND DATE TESTS

Where application behavior depends on dates or times, use deterministic test configuration.

Do not allow tests to fail randomly because of timezone differences.

The project's documented timezone should be respected.

---

# 52. TEST DATA

Use safe synthetic test data.

Do not copy production customer or user data into CI.

---

# 53. ARTIFACTS

If CI produces useful test reports or build artifacts, retain them where appropriate.

Do not store sensitive information in publicly accessible artifacts.

---

# 54. CI FAILURE POLICY

If CI fails:

```text
Do not merge blindly.
Do not ignore the failure.
Do not disable the failing test.
Do not fake success.
```

Identify and resolve the actual problem.

---

# 55. CI SUCCESS POLICY

A green CI pipeline means the configured automated checks passed.

It does not automatically mean:

```text
Production-ready
Security-audited
Deployed
Fully verified
```

Do not confuse these states.

---

# 56. REVIEW WORKFLOW

The recommended GitHub workflow is:

```text
Feature/change
      ↓
Local testing
      ↓
Commit
      ↓
Push branch
      ↓
Pull Request
      ↓
GitHub Actions
      ↓
Review
      ↓
Merge to main
```

---

# 57. MAIN BRANCH

The `main` branch should represent the stable approved application state.

Avoid using `main` as an experimental development branch.

---

# 58. DOCUMENTATION

If CI architecture introduces new project requirements, update the relevant documentation.

Examples:

```text
Required PHP version
Required Node version
Required CI variables
Testing commands
CI workflow
Branch protection
```

---

# 59. CI README

The README should contain a concise explanation of how developers can run the same major checks locally.

For example:

```text
Install dependencies
Configure environment
Run migrations
Run tests
Build frontend
```

Use the project's actual commands.

---

# 60. DO NOT MODIFY APPLICATION LOGIC

Unless required to make the existing test suite work correctly, do not change application logic during CI setup.

If a test exposes a genuine application defect:

```text
Document it
Identify the affected area
Fix it only if appropriate
Run the tests again
```

Do not hide the failure.

---

# 61. FINAL VERIFICATION

Before declaring Prompt 024 complete, verify:

```text
☐ GitHub repository accessible
☐ Correct main branch
☐ GitHub Actions workflow exists
☐ Dependencies install successfully
☐ Laravel environment initializes
☐ Database tests work
☐ Automated tests pass
☐ Frontend build passes where applicable
☐ No production credentials used
☐ No secrets committed
☐ CI does not access production database
☐ CI does not deploy to Hostinger
```

---

# 62. SUCCESS CRITERIA

Prompt 024 is complete when:

```text
                 GitHub
                    │
                    ▼
             ┌─────────────┐
             │ GitHub CI   │
             └──────┬──────┘
                    │
          ┌─────────┴─────────┐
          ▼                   ▼
       PASS                  FAIL
          │                   │
          ▼                   ▼
   Ready for Review       Fix Problem
          │
          ▼
      Approved Code
          │
          ▼
   Ready for Hostinger
```

---

# 63. COMPLETION REPORT

After completing this prompt, report:

```text
GitHub Verification:
[Passed / Failed]

Repository:
[Repository]

Main Branch:
[Branch]

CI Workflow:
[Configured / Existing / Not Configured]

PHP Check:
[Passed / Failed]

Dependency Installation:
[Passed / Failed]

Database Setup:
[Passed / Failed / Not Required]

Automated Tests:
[Passed / Failed]

Frontend Build:
[Passed / Failed / Not Required]

Security Checks:
[Passed / Issues Found]

GitHub Secrets:
[Configured / Not Required]

Hostinger Deployment:
[Not Started]

Google Analytics:
[Not Configured / Existing Configuration]

Issues:
[List]

Next Step:
[Hostinger Production Setup]
```

---

# 64. FINAL INSTRUCTION

The purpose of Prompt 024 is to establish confidence that the code stored in GitHub can be automatically validated before production deployment.

Do not deploy SMEvolve during this phase.

Do not use production credentials.

Do not connect CI to the production database.

Do not bypass failed tests.

Do not disable security checks merely to obtain a passing pipeline.

When this prompt is successfully completed, SMEvolve should be ready to move from:

```text
GitHub
   ↓
Verified Code
```

to:

```text
Hostinger
   ↓
Production Environment
```

The next phase is **Hostinger Production Setup**.
