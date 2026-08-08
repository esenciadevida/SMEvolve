# SMEvolve Execution Prompt

## Phase 22 – Search Engine Implementation

**Project:** SMEvolve

**Framework:** Laravel 12

**Frontend:** Blade, Vite, Alpine.js

---

# Objective

Implement the SMEvolve application-wide search architecture.

The search system must provide a secure, scalable, permission-aware search experience across approved SMEvolve resources.

The implementation should begin with the application's existing database and Laravel architecture.

Do **not** introduce an external search engine such as Elasticsearch, Algolia, or Meilisearch unless the existing dataset, performance requirements, or documented architecture demonstrates a clear need for one.

The architecture must allow an external search provider to be introduced later without rebuilding the search interface or application search contracts.

---

# Required Reading

Before implementation, read:

## AI Foundation

```text
AI_Instructions/00_AI_Constitution.md
```

---

## Core Documentation

Read:

```text
Documentation/01_PRD/

Documentation/02_Information_Architecture.md

Documentation/03_Design_System/

Documentation/04_Content_Architecture/
```

---

## Global Features

Read:

```text
Documentation/13_Global_Features/
```

Pay particular attention to:

* Authentication.
* Authorization.
* Navigation.
* SEO.
* Accessibility.
* Security.
* Error handling.
* Global components.

---

## Admin Portal

Read:

```text
Documentation/17_Admin_Portal/
```

Pay particular attention to:

```text
15_Admin_Search.md
```

This document defines the Admin Search requirements and must be treated as the primary specification for administrative search behavior.

---

# Scope

Implement:

* Search service architecture.
* Search provider architecture.
* Searchable-resource registration.
* Global search interface where documented.
* Admin search integration.
* Search result formatting.
* Permission-aware search.
* Search ranking.
* Search validation.
* Search pagination.
* Search autocomplete.
* Search performance optimization.
* Search security.
* Search testing.

---

# Architecture

The search architecture should follow:

```text
User Query
    ↓
Search Interface
    ↓
Search Controller / Endpoint
    ↓
Search Service
    ↓
Search Resource Registry
    ↓
Authorized Search Providers
    ↓
Database / Search Provider
    ↓
Result Normalization
    ↓
Ranking
    ↓
Search Results
```

Keep the layers independent.

---

# Search Service

Create or reuse:

```text
SearchService
```

The service should coordinate searches across registered resources.

It should not contain large amounts of resource-specific database logic.

---

# Search Provider Architecture

Each searchable resource should have an isolated search provider.

Conceptually:

```text
SearchProvider
├── QuoteSearchProvider
├── AdminSearchProvider
├── NotificationSearchProvider
└── FutureSearchProvider
```

The actual implementation should follow existing SMEvolve naming conventions.

---

# Search Resource Registry

Create a central mechanism for registering searchable resources.

Conceptually:

```text
Search Registry
    ↓
Quotes
Administrators
Notifications
Settings
Future Resources
```

A new searchable resource should be addable without rewriting the core search service.

---

# Search Contract

Where appropriate, define a common contract/interface for search providers.

A provider should be responsible for:

* Determining whether the resource is searchable.
* Validating applicable search criteria.
* Building its query.
* Applying authorization.
* Returning normalized results.

---

# Permission-Aware Search

This is a mandatory requirement.

Search must never expose unauthorized records.

The correct architecture is:

```text
User
 ↓
Permission
 ↓
Search Provider
 ↓
Authorized Query
 ↓
Results
```

Do not retrieve unrestricted records and merely hide them in the UI.

---

# Authorization

Search results must respect:

* Authentication.
* Roles.
* Permissions.
* Policies.
* Resource ownership where applicable.

The destination page must also independently enforce authorization.

A search result must never grant access.

---

# Searchable Resources

Initially support the resources documented by SMEvolve.

These may include:

* Quotes.
* Administrators.
* Notifications.
* Settings where appropriate.

Do not automatically make every database table searchable.

A resource must be explicitly registered.

---

# Quote Search

Quote search should support the documented fields, such as:

* Quote reference.
* Customer name.
* Customer email where authorized.
* Relevant quote/project information.

Search should prioritize quote identifiers.

Example:

```text
SME-2026-000124
```

should produce an exact or highly ranked match.

---

# Administrator Search

Administrator search should support:

* Name.
* Email.

Only administrators with appropriate permissions should receive administrator search results.

---

# Notification Search

Where supported, notification search may include:

* Title.
* Message.
* Notification type.

Notifications must remain scoped to the authenticated administrator where applicable.

---

# Settings Search

Only setting names and approved metadata may be searchable.

Never search or index:

* API keys.
* Passwords.
* Tokens.
* Private keys.
* Secrets.
* Environment variables.

---

# Search Input

Validate every search request server-side.

Recommended constraints:

```text
query
required
string
maximum length
```

Use the project's validation conventions.

Do not trust client-side validation.

---

# Query Normalization

Normalize input appropriately.

Handle:

* Leading/trailing spaces.
* Case normalization where appropriate.
* Email formatting.
* Unicode text.

Do not modify the query in a way that changes its intended meaning.

---

# Minimum Query Length

Use a reasonable minimum query length for broad searches.

Recommended:

```text
2–3 characters
```

However, exact identifiers may be supported where appropriate.

The implementation should avoid expensive unrestricted searches.

---

# Maximum Query Length

Limit search input to prevent abusive or inefficient requests.

Use a reasonable application-level maximum based on the project's conventions.

---

# Search Ranking

Implement predictable ranking.

Recommended priority:

```text
Exact identifier
        ↓
Exact phrase
        ↓
Starts with
        ↓
Contains
```

Resource-specific ranking may be implemented where appropriate.

---

# Result Normalization

Search providers should return a common result structure.

Conceptually:

```text
{
    type,
    id,
    title,
    subtitle,
    url,
    metadata
}
```

Do not expose database-specific implementation details to the UI.

---

# Result Limits

Search results must be limited.

Recommended initial behavior:

```text
5 results per resource
```

The exact value should follow the existing Admin Search documentation and UI requirements.

---

# Pagination

Dedicated search results should support pagination where required.

Do not load an unlimited number of records into memory.

Use Laravel's pagination mechanisms where appropriate.

---

# Autocomplete

The global search interface may provide autocomplete.

Autocomplete should:

* Use a short debounce.
* Limit results.
* Avoid unnecessary requests.
* Respect authorization.
* Return quickly.

---

# Debouncing

Do not submit a request for every keystroke.

Use Alpine.js or the existing frontend architecture to implement debouncing.

The exact debounce interval should be selected based on UX and performance testing.

---

# Search UI

Reuse the existing SMEvolve design system.

The search interface should support:

* Search input.
* Loading state.
* Result groups.
* Empty state.
* Error state.
* Keyboard navigation.
* Accessible labels.
* Result links.

Do not create a separate visual language for search.

---

# Keyboard Navigation

The search interface should support:

```text
↑ / ↓
```

for navigating results.

```text
Enter
```

for opening a selected result.

```text
Esc
```

for closing autocomplete.

Follow accessible combobox/listbox patterns where applicable.

---

# Search Empty State

When no results exist:

```text
No results found for "query".
```

Where useful:

```text
Try a different keyword or identifier.
```

---

# Search Loading State

The UI should clearly communicate that search is in progress.

Avoid unnecessary spinners for extremely short operations if they create visual noise.

---

# Search Error State

If search fails:

```text
Search is temporarily unavailable.
Please try again.
```

Never expose:

* SQL errors.
* Stack traces.
* Database details.
* Provider credentials.

---

# Search URLs

Result URLs must use named Laravel routes where possible.

The result destination must independently enforce authorization.

Never place sensitive information into query parameters unnecessarily.

---

# Database Strategy

The initial implementation should use the existing database infrastructure.

Use:

* Eloquent.
* Query Builder.
* Appropriate database indexes.
* Efficient `LIKE`/full-text mechanisms supported by the project's database where appropriate.

Do not introduce a dedicated search server without demonstrated need.

---

# Database Indexing

Inspect searchable database fields.

Add appropriate indexes where beneficial.

Before creating indexes:

1. Inspect existing indexes.
2. Determine query patterns.
3. Avoid redundant indexes.
4. Consider write performance.

---

# Full-Text Search

Use native database full-text capabilities where appropriate and supported.

Do not force full-text indexing onto every searchable field.

Exact identifiers and structured fields may be better handled with ordinary indexed queries.

---

# External Search Engine

Do not install:

```text
Elasticsearch
Algolia
Meilisearch
Typesense
```

as part of the initial implementation unless the existing project requirements clearly justify it.

The search architecture should nevertheless allow future integration.

---

# Future Search Adapter

If an external engine becomes necessary later, the architecture should allow:

```text
SearchService
      ↓
SearchContract
      ↓
DatabaseSearchProvider
      OR
ExternalSearchProvider
```

The UI should not need to know which engine is being used.

---

# Search Caching

Do not add search caching by default.

Search results may depend on:

* User.
* Permissions.
* Resource ownership.
* Data changes.

If caching becomes necessary, cache keys must include the appropriate security scope.

---

# Rate Limiting

Search endpoints should use reasonable rate limiting where applicable.

Especially protect autocomplete endpoints from excessive requests.

Do not introduce aggressive limits that make normal administrative use difficult.

---

# Search Security

The implementation must prevent:

* SQL injection.
* Authorization bypass.
* Information disclosure.
* Sensitive-data indexing.
* Excessive query abuse.

Always use parameterized queries or safe Eloquent/query-builder operations.

---

# Sensitive Data

Never index or return:

* Passwords.
* API keys.
* Access tokens.
* Refresh tokens.
* Private keys.
* Session identifiers.
* Database credentials.
* Environment secrets.

---

# Search Logs

Do not log complete search queries unnecessarily.

If search logging is required for diagnostics, ensure logs do not capture sensitive information.

---

# Privacy

Search must follow data minimization.

Only return the information required to identify the matching resource.

Example:

```text
Quote:
SME-2026-000124
Customer: John Doe
Status: Pending
```

Do not return unnecessary private customer information.

---

# Controller

Use a lightweight search controller where appropriate.

Recommended:

```text
SearchController
```

or an existing Admin Search controller if one already exists.

Responsibilities:

* Receive request.
* Validate query.
* Authorize access.
* Invoke SearchService.
* Return results.

Do not place search algorithms directly in the controller.

---

# API / AJAX Endpoint

If autocomplete requires an endpoint, create the smallest appropriate endpoint.

Example:

```text
/admin/search
```

or:

```text
/admin/search/autocomplete
```

Use existing routing conventions.

Do not create an unnecessary API architecture solely for search.

---

# Response Format

Autocomplete responses should contain only the fields required by the interface.

Avoid returning entire database records.

---

# Search Components

Create or reuse components such as:

```text
components/admin/search/
├── input.blade.php
├── results.blade.php
├── result-item.blade.php
└── empty-state.blade.php
```

Use the actual project's component naming conventions.

---

# Alpine.js

Use Alpine.js for:

* Search dropdown.
* Debouncing.
* Keyboard interaction.
* Loading state.
* Selection.

Do not introduce React/Vue or another frontend framework.

---

# Accessibility

Verify:

* Search input has an accessible label.
* Keyboard navigation works.
* Focus is visible.
* Results are announced appropriately.
* Selected result is distinguishable.
* Escape closes the result interface.
* Screen readers can understand result groups.

---

# Responsive Design

Search must work on:

### Desktop

Global search with autocomplete.

### Tablet

Responsive search control.

### Mobile

Dedicated or expanded search interface.

The interface must not cause horizontal overflow.

---

# Performance

Measure and optimize:

* Search query execution.
* Number of queries.
* Response size.
* Autocomplete response time.
* Database indexing.

Avoid:

* N+1 queries.
* Unbounded result sets.
* Loading complete models unnecessarily.
* Searching every table.
* Repeated identical queries.

---

# Error Handling

Search failures must be handled gracefully.

The system should log technical details internally while presenting safe user-facing messages.

---

# Testing

Implement automated tests for:

## Functional

✓ Search returns matching quotes.

✓ Search returns matching administrators where authorized.

✓ Search returns matching notifications where applicable.

✓ Settings search excludes sensitive values.

✓ Exact matches rank correctly.

✓ Partial matches work.

✓ Empty searches are handled.

✓ No-result searches work.

✓ Pagination works.

✓ Autocomplete works.

---

## Authorization

Test:

✓ Authorized search.

✓ Unauthorized search.

✓ Restricted quote.

✓ Restricted administrator.

✓ Restricted notification.

✓ Direct result URL access.

---

## Security

Test:

✓ SQL injection attempts.

✓ Excessively long queries.

✓ Unauthorized resource discovery.

✓ Sensitive-value exposure.

✓ Search endpoint abuse.

---

## Performance

Verify:

✓ Search queries use appropriate indexes.

✓ No obvious N+1 queries.

✓ Results are limited.

✓ Autocomplete is debounced.

✓ Large datasets do not cause unbounded memory usage.

---

## Accessibility

Verify:

✓ Keyboard navigation.

✓ Screen-reader behavior.

✓ Focus management.

✓ Accessible labels.

✓ Accessible result groups.

---

# Integration Testing

Verify search integration with:

* Admin Portal.
* Authentication.
* Authorization.
* Quotes.
* Notifications.
* Settings.
* Global navigation.
* Existing design system.

Ensure search implementation does not break existing modules.

---

# External Search Readiness

After implementation, document whether the current database search is sufficient.

If an external search engine is not required, explicitly state:

```text
Database search is currently sufficient.
```

If performance testing demonstrates a need for an external engine, document:

* Why.
* Which provider is recommended.
* What migration would be required.

Do not install the external engine automatically.

---

# Deliverables

After implementation provide:

## Summary

Explain the search architecture implemented.

---

## Files Created

List:

* Search services.
* Search contracts.
* Search providers.
* Controllers.
* Components.
* Tests.
* Migrations.

---

## Files Modified

List all modified files and explain why.

---

## Searchable Resources

List every resource registered with the search system.

---

## Database Changes

List:

* Indexes.
* Migrations.
* Full-text indexes if applicable.

---

## Security

Explain:

* Authorization.
* Permission filtering.
* Sensitive-data protection.
* Input validation.
* Rate limiting.
* Query safety.

---

## Testing Results

Provide:

### Functional

Search functionality results.

### Authorization

Permission and access-control results.

### Security

Security testing results.

### Accessibility

Accessibility testing results.

### Performance

Query and response performance results.

---

# Future Recommendations

Potential future upgrades:

* Laravel Scout.
* Meilisearch.
* Typo-tolerant search.
* Advanced relevance ranking.
* Search analytics.
* Saved searches.
* Search suggestions.
* Cross-module advanced search.
* AI-assisted administrative search.

Do not implement these unless explicitly requested or justified by measured requirements.

---

# Stop Condition

Stop after completing the Search Engine implementation.

Do not begin:

* Deployment.
* Server provisioning.
* CI/CD.
* Production infrastructure.

Those will be handled separately.

---

# Final Instruction

Implement the search system as a reusable SMEvolve service rather than as a feature tied exclusively to one Admin Portal page.

The initial search implementation should remain lightweight and database-backed.

Do not introduce unnecessary infrastructure.

Do not expose unauthorized records.

Do not index sensitive information.

Do not duplicate existing SMEvolve functionality.

Use the existing architecture wherever possible.

The final implementation must be ready for a future external search provider without requiring a complete rewrite.

After testing and documenting the implementation, stop.
