# SMEvolve Deployment

## 02 – GitHub Repository Setup

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

This document defines how the SMEvolve application should be organized and managed within GitHub before production deployment to Hostinger.

GitHub will serve as the authoritative source-control repository for the SMEvolve application.

The repository must provide:

* Version control.
* Controlled collaboration.
* Change history.
* Production-ready releases.
* Secure secret handling.
* Deployment traceability.
* Rollback capability.

---

# 2. Repository Strategy

SMEvolve should use a single primary Git repository for the application unless a future architectural requirement justifies splitting the system into separate repositories.

The repository should contain the application source code and required project configuration.

It should not contain production secrets or private credentials.

---

# 3. Repository Structure

The repository should follow the Laravel application structure.

Typical structure:

```text
SMEvolve/
├── app/
├── bootstrap/
├── config/
├── database/
├── public/
├── resources/
├── routes/
├── storage/
├── tests/
├── AI_Instructions/
├── Documentation/
├── .env.example
├── .gitignore
├── artisan
├── composer.json
├── composer.lock
├── package.json
├── package-lock.json
└── vite.config.*
```

The actual repository structure must reflect the implemented SMEvolve codebase.

Do not introduce unnecessary top-level directories.

---

# 4. Repository Name

Use a clear repository name representing the project.

Recommended:

```text
SMEvolve
```

If the repository must use a different naming convention, use the organization's established convention.

---

# 5. Repository Visibility

The repository should remain private unless there is a deliberate decision to make SMEvolve open source.

Because the application may contain:

* Business logic.
* Internal documentation.
* Infrastructure configuration.
* Integration details.

a private repository is recommended.

---

# 6. Git Initialization

If the project has not already been initialized with Git:

```text id="2ghs8m"
git init
git add .
git commit -m "Initial SMEvolve project"
```

The repository should then be connected to the official GitHub repository.

Do not initialize a second Git repository inside an existing Git repository.

---

# 7. Remote Repository

The local project should have GitHub configured as its primary remote.

Conceptually:

```text id="vlx0dd"
Local SMEvolve
      │
      │ git push
      ▼
GitHub SMEvolve Repository
```

The remote URL must use the organization's approved GitHub account and repository.

Do not hardcode personal credentials into the project.

---

# 8. Git User Identity

Developers should configure their Git identity appropriately.

Verify:

```text id="y8x72u"
git config user.name
git config user.email
```

Commits should be attributable to the correct developer or organization account.

---

# 9. Branch Strategy

Use a simple branch structure.

Recommended:

```text id="kq7e1e"
main
│
├── feature/*
├── fix/*
├── refactor/*
└── chore/*
```

### `main`

The `main` branch represents production-ready code.

### Feature branches

Used for new functionality.

Example:

```text id="i4q4kq"
feature/quote-wizard
```

### Fix branches

Used for bug fixes.

Example:

```text id="ykf7p3"
fix/contact-form-validation
```

### Refactor branches

Used for architectural or code-quality changes.

Example:

```text id="psk7t8"
refactor/search-service
```

### Chore branches

Used for maintenance work.

Example:

```text id="4ff3gk"
chore/update-dependencies
```

---

# 10. Main Branch Protection

The `main` branch should be protected where GitHub plan capabilities allow.

Recommended protections:

* Pull requests required for significant changes.
* Required status checks.
* No force pushes.
* No branch deletion.
* Restricted direct pushes.
* Review requirements where appropriate.

The exact protection level should reflect the project's team size.

---

# 11. Pull Requests

Changes should preferably reach `main` through pull requests.

A pull request should communicate:

* What changed.
* Why it changed.
* Affected modules.
* Database changes.
* Configuration changes.
* Testing performed.
* Deployment considerations.

---

# 12. Commit Standards

Commits should be clear and meaningful.

Recommended format:

```text
type: description
```

Examples:

```text
feat: implement quote wizard validation

fix: correct admin permission check

refactor: extract search service

docs: update deployment architecture

chore: update Laravel dependencies
```

Avoid commits such as:

```text
update
changes
fix
stuff
test
```

---

# 13. Commit Scope

A commit should ideally represent one logical change.

Avoid combining unrelated changes such as:

```text
Quote Wizard
Admin Portal
SEO
Deployment
```

in a single commit unless the changes are inherently dependent.

Smaller logical commits improve:

* Review.
* Debugging.
* Rollback.
* Change history.

---

# 14. `.gitignore`

The repository must have an appropriate Laravel `.gitignore`.

It must exclude environment-specific and generated files where appropriate.

Examples:

```text id="m0x8fc"
.env
.env.*
!.env.example

/vendor/
/node_modules/

.phpunit.result.cache

/storage/*.key
/storage/logs/*
/storage/framework/cache/*
/storage/framework/sessions/*
/storage/framework/views/*

/public/build/
```

The final `.gitignore` must be reviewed against the actual SMEvolve application.

---

# 15. Environment Files

Production `.env` files must never be committed.

The repository should contain:

```text id="jyf0oz"
.env.example
```

The example file should document the required configuration keys without containing real credentials.

---

# 16. `.env.example`

The example environment file may contain placeholders such as:

```text id="spx1lo"
APP_NAME=SMEvolve
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=
DB_PORT=3306
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=

MAIL_MAILER=
MAIL_HOST=
MAIL_PORT=
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=
MAIL_FROM_ADDRESS=
MAIL_FROM_NAME=

GOOGLE_ANALYTICS_ID=

AI_API_KEY=
```

Only variables actually required by the application should be included.

Never place real production values into this file.

---

# 17. Secret Protection

The following must never be committed:

* Database passwords.
* API keys.
* SMTP passwords.
* AI credentials.
* Payment credentials.
* Private keys.
* OAuth client secrets.
* Access tokens.
* Session secrets.

If a secret is accidentally committed:

1. Remove it from the repository.
2. Rotate the credential immediately.
3. Assess whether the credential was exposed.
4. Clean repository history if necessary.
5. Update the production environment.

Deleting the file alone is not sufficient if the secret remains in Git history.

---

# 18. GitHub Secrets

Where GitHub Actions or other automated deployment processes require secrets, use GitHub Secrets rather than storing credentials in workflow files.

Potential secrets include:

```text id="f6kg4a"
HOSTINGER_DEPLOY_KEY
HOSTINGER_SSH_KEY
PRODUCTION_API_KEY
OTHER_DEPLOYMENT_SECRET
```

Only secrets actually required by the deployment architecture should be created.

---

# 19. GitHub Authentication

Developers should use secure GitHub authentication.

Recommended:

* SSH keys, or
* GitHub's supported secure authentication mechanisms.

Do not store GitHub passwords inside Git configuration.

Personal access tokens must be protected like passwords.

---

# 20. Two-Factor Authentication

GitHub accounts with access to the SMEvolve repository should use two-factor authentication where available.

This is particularly important for accounts with:

* Repository administration.
* Production deployment access.
* Secrets access.

---

# 21. Repository Access

Use least privilege.

Access should be granted according to responsibility.

Example:

```text id="g9a3gk"
Developer
    ↓
Code access

Maintainer
    ↓
Code + merge access

Administrator
    ↓
Repository + security administration
```

Do not give production-level access to every developer by default.

---

# 22. Production Deployment Relationship

GitHub and Hostinger should be connected through a controlled deployment workflow.

Conceptually:

```text id="4x4w95"
Developer
    ↓
Feature Branch
    ↓
Pull Request
    ↓
Review / Tests
    ↓
main
    ↓
Deployment
    ↓
Hostinger
    ↓
Production
```

The exact Hostinger deployment mechanism will be defined in:

```text
12_GitHub_Hostinger_Deployment_Workflow.md
```

---

# 23. Direct Production Editing

Production application files should not normally be edited directly through the Hostinger file manager.

The preferred workflow is:

```text id="xk0t8b"
Local
 ↓
GitHub
 ↓
Hostinger
```

Direct production edits create configuration drift and make rollback difficult.

Emergency changes may be performed when absolutely necessary but must subsequently be incorporated into the GitHub source of truth.

---

# 24. Configuration Drift

The production environment should not contain undocumented code changes.

If a production change is made manually:

1. Record the change.
2. Reproduce it in the source repository.
3. Commit it.
4. Push it to GitHub.
5. Ensure future deployments do not overwrite the intended configuration.

---

# 25. Dependency Files

The following files should generally be committed:

```text id="9j2fzo"
composer.json
composer.lock
package.json
package-lock.json
```

Lock files should remain synchronized with the project dependencies.

Do not rely on unconstrained dependency versions in production.

---

# 26. Composer Dependencies

Production deployment should install dependencies according to the committed `composer.lock`.

Use production-oriented installation such as:

```text id="9i1f8g"
composer install --no-dev --optimize-autoloader
```

The exact command should be confirmed against the project's deployment environment.

---

# 27. Node Dependencies

The deployment environment should use the committed package lock file.

Where supported:

```text id="a5k4eq"
npm ci
```

should be preferred for reproducible builds.

Then:

```text id="w3a5v4"
npm run build
```

should generate production frontend assets.

---

# 28. Generated Files

Generated files should generally not be committed when they are reproducible during deployment.

Examples include:

```text id="rj0g8u"
/node_modules/
/vendor/
/public/build/
```

However, this must be confirmed against the actual Hostinger deployment workflow.

If Hostinger cannot reliably build frontend assets, an alternative build strategy may be required.

---

# 29. Documentation

The repository should contain the SMEvolve project documentation where appropriate.

For example:

```text id="2h9xdo"
Documentation/
AI_Instructions/
```

Documentation should remain synchronized with the implementation.

---

# 30. AI Instructions

The `AI_Instructions/` directory should be version-controlled.

It may contain:

```text id="7p6cl1"
00_AI_Constitution.md
Prompt_*.md
```

These files form part of the project's controlled development process and should have the same review standards as application code.

---

# 31. GitHub Issues

GitHub Issues may be used for:

* Bugs.
* Feature requests.
* Technical debt.
* Deployment tasks.
* Security issues.

Sensitive security vulnerabilities should not be publicly exposed through normal issue mechanisms if the repository ever becomes public.

---

# 32. Release Tags

Production releases should use Git tags.

Recommended format:

```text id="1wkw5j"
v1.0.0
v1.0.1
v1.1.0
```

Tags provide clear deployment points and simplify rollback.

---

# 33. Versioning

Use semantic versioning where appropriate:

```text id="8u6v0y"
MAJOR.MINOR.PATCH
```

For example:

```text id="hmj54g"
v1.0.0
```

Major releases may represent breaking architectural changes.

Minor releases may introduce functionality.

Patch releases may contain fixes.

---

# 34. Deployment Tags

Where practical, production deployments should correspond to a known:

* Commit.
* Branch.
* Release tag.

This allows production to be traced back to exact source code.

---

# 35. GitHub Actions

GitHub Actions may be used for:

* Automated testing.
* Code quality checks.
* Build verification.
* Deployment automation.

Do not create CI/CD workflows before the Hostinger deployment capabilities have been verified.

---

# 36. CI Requirements

Before production deployment automation is introduced, the project should be capable of running:

```text id="q7k31a"
Composer installation
PHP tests
Laravel tests
Frontend build
```

Additional checks may include:

* Static analysis.
* Formatting.
* Security auditing.

Only checks that provide meaningful value should be enabled.

---

# 37. Pull Request Checks

Where CI is configured, pull requests should ideally verify:

```text id="6tr4p7"
Dependencies install
       ↓
Tests run
       ↓
Frontend builds
       ↓
Checks pass
       ↓
Merge
```

Production deployment should not proceed when required checks fail.

---

# 38. Production Secrets and GitHub

GitHub repository administrators must ensure that secrets are not exposed through:

* Commits.
* Issues.
* Pull requests.
* Actions logs.
* Screenshots.
* Documentation.
* Build artifacts.

Secret values should be masked where supported.

---

# 39. Security Monitoring

GitHub security features should be enabled where available.

Review:

* Dependabot alerts.
* Secret scanning.
* Dependency vulnerabilities.
* Suspicious repository access.
* Actions permissions.

The project should respond to high-risk dependency vulnerabilities promptly.

---

# 40. Dependency Updates

Dependency updates should be controlled.

Before updating:

* Review compatibility.
* Run tests.
* Review breaking changes.
* Test the affected modules.
* Commit the update.

Do not blindly update every dependency immediately before production deployment.

---

# 41. Repository Backup

GitHub should not be considered the only backup of the entire production system.

GitHub protects source code, but it does not replace:

* Database backups.
* Uploaded file backups.
* Production configuration backups where appropriate.

The complete backup strategy is defined in:

```text id="y0qv7w"
13_Backups_Recovery.md
```

---

# 42. Emergency Recovery

If the production environment becomes unavailable, GitHub should provide the source required to reconstruct the application.

Recovery additionally requires:

* Database backup.
* Storage backup.
* Environment configuration.
* Third-party credentials.
* Domain/DNS access.

These must be managed securely.

---

# 43. Repository Checklist

Before connecting GitHub to Hostinger:

```text id="r6k3ks"
✓ Repository created
✓ Repository is private
✓ Local project connected
✓ .gitignore configured
✓ .env excluded
✓ .env.example created
✓ No secrets committed
✓ composer.json committed
✓ composer.lock committed
✓ package.json committed
✓ package-lock.json committed
✓ Documentation committed
✓ AI Instructions committed
✓ Branch strategy defined
✓ main branch defined
✓ Access permissions reviewed
✓ 2FA enabled
✓ GitHub security features reviewed
✓ Production deployment strategy defined
```

---

# 44. Acceptance Criteria

This document is complete when:

✓ SMEvolve has a defined GitHub repository strategy.

✓ Source control is clearly separated from production hosting.

✓ Production secrets are protected.

✓ Branching strategy is defined.

✓ Commit conventions are defined.

✓ Main branch represents production-ready code.

✓ GitHub access is controlled.

✓ Dependency files are managed correctly.

✓ Generated files are handled appropriately.

✓ GitHub-to-Hostinger deployment relationship is defined.

✓ Production code can be traced to a Git commit or release.

✓ Repository security requirements are documented.

✓ Backup responsibilities are clearly separated between source code and production data.

---

# 45. Next Document

The next document is:

```text id="f4t7zq"
03_Hostinger_Environment.md
```

It will define the actual Hostinger production environment required for SMEvolve, including PHP/Laravel compatibility, database, storage, SSH, Composer, Node/Vite considerations, cron, queues, filesystem configuration, and hosting-plan requirements.
