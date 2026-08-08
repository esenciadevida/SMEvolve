# SMEvolve

## Prompt 023 – GitHub Repository Setup & Source Control

**Project:** SMEvolve

**Document Number:** 023

**Module:** GitHub & Source Control

**Purpose:** Prepare, validate, commit, and push the SMEvolve project to GitHub safely.

**Source Control Platform:** GitHub

**Production Hosting:** Hostinger

**Status:** Implementation Instruction

---

# 1. ROLE

You are responsible for preparing the existing SMEvolve project for GitHub source control.

The project has already gone through:

* Documentation.
* Project audit.
* Gap analysis.
* Implementation.
* Testing.

Do not rebuild the application.

Your responsibility in this phase is to:

```text
Inspect
→ Secure
→ Prepare
→ Initialize/verify Git
→ Commit
→ Connect GitHub
→ Push
→ Verify
```

---

# 2. PRIMARY OBJECTIVE

Place the current stable SMEvolve codebase into a properly configured GitHub repository without:

* Losing existing work.
* Overwriting valid code.
* Committing secrets.
* Removing required files.
* Creating unnecessary changes.
* Breaking the application.

GitHub must become the authoritative source-control repository for the project.

---

# 3. IMPORTANT RULE

Do not make unrelated application changes during this phase.

This phase is about:

```text
Git
+
GitHub
+
Repository Security
+
Source Control
```

If an application bug is discovered, document it separately rather than silently modifying unrelated functionality.

---

# 4. BEFORE STARTING

Inspect the project.

Determine:

```text
Current project location
Current Git status
Existing Git repository
Existing remote
Current branch
Existing commits
Existing .gitignore
Project structure
```

Run appropriate Git inspection commands before making changes.

Do not assume Git is uninitialized.

---

# 5. PRESERVE EXISTING WORK

Before Git operations:

```text
✓ Do not delete project files
✓ Do not reset the working directory
✓ Do not discard uncommitted changes
✓ Do not run destructive Git commands
```

Do not use commands such as:

```text
git reset --hard
git clean -fd
```

unless the user explicitly authorizes them.

---

# 6. CHECK CURRENT GIT STATUS

Inspect:

```text
git status
git branch
git remote -v
git log
```

Determine whether the project is already connected to GitHub.

If a remote already exists, inspect it before changing it.

---

# 7. INITIALIZE GIT IF REQUIRED

If the project is not already a Git repository:

```text
git init
```

Then configure the repository appropriately.

Do not initialize a second repository inside an existing repository.

---

# 8. `.gitignore`

Verify that the project has an appropriate `.gitignore`.

For a Laravel application, ensure sensitive and generated files are excluded where appropriate.

At minimum, review:

```text
.env
.env.*
vendor/
node_modules/
storage/framework/
storage/logs/
bootstrap/cache/
```

Do not blindly add exclusions that would remove files required for deployment.

---

# 9. ENVIRONMENT FILES

Production and development secrets must not be committed.

Check for:

```text
.env
.env.production
.env.local
.env.staging
```

and other environment-specific secret files.

Do not commit them.

---

# 10. SECRET SCAN

Before the first push, inspect the repository for potential secrets.

Look for:

```text
API keys
Passwords
Tokens
Private keys
SSH keys
Database credentials
SMTP credentials
Cloud credentials
AI provider credentials
Payment credentials
```

Pay particular attention to:

```text
.env
config/
documentation/
scripts/
tests/
JSON files
YAML files
JavaScript files
PHP files
```

---

# 11. SECRET HANDLING

If a secret is found:

1. Determine whether it is active.
2. Remove it from tracked source where appropriate.
3. Replace it with an environment variable.
4. Add a safe placeholder to `.env.example`.
5. If the secret was previously committed, treat it as potentially exposed.
6. Recommend credential rotation.

Do not assume deleting a secret from the latest file removes it from Git history.

---

# 12. `.env.example`

Create or update:

```text
.env.example
```

The file should contain the required configuration keys without real secrets.

Example:

```text id="5o3e5g"
APP_NAME=
APP_ENV=
APP_KEY=
APP_DEBUG=
APP_URL=

DB_CONNECTION=
DB_HOST=
DB_PORT=
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

```

Only include variables actually used by SMEvolve.

---

# 13. DOCUMENTATION

Project documentation should be committed to GitHub.

This includes the approved documentation under:

```text
Documentation/
```

Do not commit:

```text
Private credentials
Private account information
Passwords
API secrets
Personal security information
```

---

# 14. DEPENDENCY FILES

Ensure required dependency lock files are committed.

For example:

```text
composer.json
composer.lock
package.json
package-lock.json
```

Use the package manager actually used by the project.

Do not delete lock files simply to make dependency installation easier.

---

# 15. BUILD ARTIFACTS

Determine which generated files belong in Git.

Do not commit unnecessary:

```text
node_modules/
vendor/
temporary build output
runtime logs
cache files
temporary uploads
```

unless the project's deployment architecture explicitly requires them.

---

# 16. LARGE FILES

Inspect for unnecessarily large files.

Look for:

```text
Large videos
Large archives
Database dumps
Temporary files
Generated files
Large binary assets
```

Do not upload unnecessary large files to GitHub.

If a required large asset exceeds normal Git usage, identify an appropriate storage strategy rather than forcing it into the repository.

---

# 17. GIT IDENTITY

Verify the Git author configuration.

The AI may inspect:

```text
git config user.name
git config user.email
```

Do not modify the user's global identity without permission.

---

# 18. DEFAULT BRANCH

The primary branch should be:

```text
main
```

If the existing project already uses another approved branch strategy, do not change it unnecessarily.

If a branch rename is required, explain the change before performing it.

---

# 19. INITIAL COMMIT

Before creating the initial commit:

```text
git status
```

Review every staged file.

The AI must understand what is being committed.

Do not blindly run:

```text
git add .
git commit
```

without reviewing the resulting staged files.

---

# 20. COMMIT CONTENT

The initial commit should contain the stable project state.

It should include:

```text
Application source code
Configuration templates
Documentation
Database migrations
Tests
Required assets
Dependency files
```

It should exclude:

```text
Secrets
Generated runtime files
Temporary files
Personal files
Local environment files
```

---

# 21. INITIAL COMMIT MESSAGE

Use a clear commit message.

Recommended:

```text
chore: initialize SMEvolve repository
```

If the repository already has meaningful Git history, preserve that history rather than creating an unnecessary replacement history.

---

# 22. GITHUB REPOSITORY

The GitHub repository should be created as:

```text
SMEvolve
```

or the approved project repository name.

Default recommendation:

```text
Private
```

unless the user explicitly requests a public repository.

---

# 23. README

The GitHub repository should contain a useful `README.md`.

It should explain:

```text
Project name
Project purpose
Technology stack
Installation
Environment configuration
Database setup
Testing
Development commands
Deployment overview
Documentation location
```

Do not place secrets in the README.

---

# 24. DOCUMENTATION LINKAGE

The README should point developers toward:

```text
Documentation/
```

The documentation should remain part of the repository.

---

# 25. GITHUB REMOTE

After the repository is created, connect the local repository to the official GitHub remote.

Use the repository URL supplied by the user or the GitHub environment.

Do not invent a repository URL.

---

# 26. PUSH

Before pushing:

```text
✓ Git status reviewed
✓ Secrets checked
✓ .gitignore checked
✓ Files reviewed
✓ Commit created
✓ Correct branch confirmed
✓ Correct GitHub repository confirmed
```

Then push the approved branch.

---

# 27. VERIFY REMOTE

After pushing, verify:

```text
git remote -v
git branch -vv
git status
```

Confirm that the local branch tracks the intended GitHub branch.

---

# 28. VERIFY GITHUB

Open the GitHub repository and verify:

```text
✓ Source code visible
✓ Documentation visible
✓ README visible
✓ Correct branch visible
✓ No secrets visible
✓ No .env visible
✓ No unnecessary generated files
✓ Commit history correct
```

---

# 29. GITHUB SECURITY

Configure appropriate repository security.

Recommended:

```text
Private repository
Two-factor authentication
Protected main branch
Pull request review
Secret scanning where available
Dependency alerts where available
```

Use the security features available on the selected GitHub plan.

---

# 30. BRANCH PROTECTION

Protect the production/main branch where appropriate.

Recommended rules:

```text
Require pull request before merge
Require status checks
Prevent force pushes
Prevent branch deletion
```

Do not impose rules that prevent the project's actual development workflow.

---

# 31. GITHUB ACTIONS

If CI/CD is part of the project's approved workflow, prepare GitHub Actions.

The initial CI workflow should verify appropriate project requirements such as:

```text
Dependency installation
Application configuration
Automated tests
Code quality checks where configured
Frontend build where required
```

Do not create a deployment workflow to Hostinger yet unless the deployment documentation explicitly requires it at this stage.

---

# 32. CI PRINCIPLE

GitHub should prevent obviously broken code from being treated as production-ready.

The workflow should follow:

```text
Push
 ↓
CI
 ↓
Tests
 ↓
Result
 ↓
Review
 ↓
Merge
```

---

# 33. CI SECRETS

If GitHub Actions requires secrets:

Do not hard-code them.

Use GitHub repository/environment secrets.

Potential examples:

```text
API credentials
Deployment credentials
Testing credentials
Third-party service credentials
```

Only add secrets that are actually required.

---

# 34. PRODUCTION SECRETS

Production secrets should remain outside the repository.

The future Hostinger environment will receive production configuration through the appropriate secure configuration process.

GitHub must not become the storage location for production `.env` credentials.

---

# 35. HOSTINGER RELATIONSHIP

The deployment architecture is:

```text
GitHub
   ↓
Approved Code
   ↓
Hostinger
   ↓
Production
```

GitHub is the source-control system.

Hostinger is the production hosting environment.

Do not confuse source control with production hosting.

---

# 36. DO NOT DEPLOY YET

This prompt prepares GitHub.

Do not perform the final production deployment to Hostinger unless explicitly instructed to move to the deployment stage.

The sequence is:

```text
GitHub Setup
      ↓
GitHub Verification
      ↓
CI
      ↓
Deployment Preparation
      ↓
Hostinger
```

---

# 37. GIT WORKFLOW AFTER INITIAL SETUP

Future development should generally follow:

```text
Create/change code
       ↓
Test locally
       ↓
Review changes
       ↓
Commit
       ↓
Push
       ↓
CI
       ↓
Review
       ↓
Merge
```

---

# 38. COMMIT QUALITY

Each commit should represent a logical change.

Avoid commits containing unrelated changes such as:

```text
Feature
+
Database rewrite
+
Unrelated UI redesign
+
Dependency upgrade
```

unless intentionally performed as one coordinated change.

---

# 39. NO FORCE PUSH

Do not force-push to shared or protected branches.

Do not use:

```text
git push --force
```

unless explicitly authorized and the consequences are understood.

---

# 40. NO DESTRUCTIVE RESET

Do not use destructive Git commands to resolve ordinary conflicts.

If a conflict occurs:

```text
Inspect
→ Understand
→ Resolve
→ Test
→ Commit
```

Do not discard user work.

---

# 41. MERGE CONFLICTS

If a merge conflict occurs:

1. Identify conflicting files.
2. Understand both changes.
3. Preserve intended functionality.
4. Resolve carefully.
5. Run relevant tests.
6. Commit the resolution.

Do not automatically choose one side without understanding the conflict.

---

# 42. UNCOMMITTED USER CHANGES

If the user has uncommitted work:

```text
Do not delete it.
Do not reset it.
Do not overwrite it.
```

Explain the state and proceed safely.

---

# 43. TAGS AND RELEASES

After the project reaches a stable production release, GitHub tags/releases may be used.

Example:

```text
v1.0.0
```

Do not create fake release versions merely to make the repository appear complete.

---

# 44. RELEASE PRINCIPLE

A release should correspond to a meaningful stable state.

Potential release flow:

```text
Development
 ↓
Testing
 ↓
CI
 ↓
Approval
 ↓
Release Tag
 ↓
Hostinger Deployment
```

---

# 45. FINAL SECURITY CHECK

Before declaring GitHub setup complete, verify:

```text
☐ No .env committed
☐ No production password committed
☐ No API key committed
☐ No private key committed
☐ No database dump committed
☐ No unnecessary large files
☐ Documentation committed
☐ README committed
☐ Correct branch
☐ Correct remote
```

---

# 46. FINAL REPOSITORY CHECK

Verify:

```text
☐ Git repository initialized
☐ GitHub repository created
☐ Remote configured
☐ Main branch configured
☐ .gitignore verified
☐ .env.example available
☐ Initial/stable commit created
☐ Code pushed
☐ Documentation pushed
☐ Repository accessible
☐ CI configured where applicable
```

---

# 47. SUCCESS CRITERIA

Prompt 023 is complete when:

```text id="s7w5p0"
Local SMEvolve
      ↓
Clean Git repository
      ↓
Secure Git configuration
      ↓
GitHub repository
      ↓
Code pushed
      ↓
Repository verified
      ↓
CI passing where configured
```

---

# 48. AI COMPLETION REPORT

After completing this task, report using:

```text
GitHub Setup Status:
[Complete / Incomplete]

Repository:
[Repository name]

Branch:
[Branch]

Remote:
[Configured / Not configured]

Commit:
[Commit SHA]

Files Committed:
[Summary]

Secrets Check:
[Passed / Issues Found]

CI:
[Passing / Failing / Not Configured]

Tests:
[Results]

Issues:
[Any unresolved issues]

Next Step:
[Deployment preparation / Other]
```

Do not claim success unless the repository was actually verified.

---

# 49. FINAL INSTRUCTION

The objective is not merely to upload SMEvolve to GitHub.

The objective is to establish a **clean, secure, reproducible, and trustworthy source-control foundation** for the project.

The final architecture must remain:

```text
                 SMEvolve
                    │
                    ▼
              ┌───────────┐
              │  GitHub   │
              │  Source   │
              │  Control  │
              └─────┬─────┘
                    │
              Approved Code
                    │
                    ▼
              ┌───────────┐
              │ Hostinger │
              │ Production│
              └───────────┘
```

Do not expose secrets.

Do not discard existing work.

Do not perform destructive Git operations without authorization.

Do not deploy to production during this phase unless explicitly instructed.

**Complete GitHub setup first. Then proceed to the Hostinger deployment phase.**
