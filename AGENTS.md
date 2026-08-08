# SMEvolve — Agent Instructions

These instructions govern all AI coding and development work on SMEvolve.
The full master instruction is the source of truth: `Documentation/21_AI_Instructions/01_AI_Master_Instructions.md`.

## Project

- **Framework:** Laravel 12 (app lives in `Laravel-Website/`)
- **Frontend:** Blade + Tailwind CSS v4 + Alpine.js (no separate SPA framework)
- **Source control:** GitHub
- **Production hosting:** Hostinger
- **Documentation is the specification.** Read the relevant `Documentation/` docs before implementing.

## Mandatory workflow

For every task:

```
User Request → Relevant Documentation → Existing Code → Impact → Plan → Implement → Test → Security Review → Report
```

Never jump straight to code. Check what already exists and what depends on it. Prefer the smallest secure, documented, maintainable change that solves the requirement without breaking existing functionality.

## Priorities (in order)

1. Explicit current user instruction
2. Latest approved project decision
3. Relevant feature documentation
4. Architecture documentation
5. Master AI instructions (`21_AI_Instructions`)
6. Existing implementation
7. AI assumptions

Never silently override an explicit user decision. If requirements genuinely conflict and the correct choice is unclear, stop and ask before making a potentially destructive change.

## Non-negotiable rules

- **Security first:** treat all client input as untrusted; validate server-side; protect auth, authorization, IDOR, CSRF, XSS, SQLi, sessions, file uploads, and API abuse. Never trust user-supplied IDs without explicit authorization.
- **Admin Portal is security-sensitive:** a normal user must never gain admin privileges via URL/request/ID/frontend manipulation.
- **Secrets stay server-side:** never commit `.env`, API keys, passwords, or credentials; never expose them in frontend JS, logs, analytics, or error messages. Rotate any secret that appears in source/history.
- **Database changes use migrations only.** Never hand-edit production data; confirm backups before destructive production changes.
- **Never delete or overwrite production data** without explicit authorization.
- **Do not reset user work:** preserve uncommitted changes; do not delete files/features without a documented reason.
- **Frontend must stay responsive** (desktop/tablet/mobile) and consistent with the existing design system and accessible patterns.
- **External APIs can fail:** use timeouts, error handling, retries where appropriate, user feedback, and fallbacks.
- **Rate-limit public/expensive operations:** login, password reset, chatbot, search, contact forms, public APIs.
- **Email:** credentials server-side only; define trigger, recipient, subject, template, queue, and failure behavior for each notification.
- **Analytics:** track meaningful, documented events only; never transmit confidential data.

## Testing

- Every meaningful feature change includes appropriate tests (unit/feature/integration/API).
- Distinguish **implemented / tested / verified / deployed**. Never claim a test ran if it did not.
- If the environment prevents testing, say so explicitly.

## Git & delivery

- Commit only when asked. Use concise, accurate messages (`feat:`, `fix:`, `refactor:`, `test:`, `docs:`).
- Review changes for secrets and unintended modifications before committing.
- Respect the documented branch strategy and CI/CD; a failed CI pipeline must not be ignored.
- Before production deployment: backup → impact → migration → rollback → monitoring → smoke test.

## Completion standard

When reporting a task as complete, state clearly:

```
Implemented:  what changed
Files:        important files changed
Testing:      what was actually tested
Documentation: what was updated
Remaining:     any unresolved issues (be honest)
```

**The goal is not just to generate code. It is to keep SMEvolve secure, reliable, maintainable, and production-ready.**
