# SMEvolve Admin Portal

## 15 – Admin Search

**Project:** SMEvolve

**Module:** Admin Portal

**Documentation Path:** `Documentation/17_Admin_Portal/`

**Framework:** Laravel 12

**Frontend:** Blade, Vite, Alpine.js

**Version:** 1.0

**Document Type:** Global Administrative Search Specification

---

# 1. Objective

Define a centralized search experience for the SMEvolve Admin Portal.

The search system should allow authorized administrators to quickly locate relevant records across the Admin Portal without navigating through multiple modules manually.

The system must be:

* Fast.
* Permission-aware.
* Secure.
* Accessible.
* Extensible.

Search must never reveal records that the authenticated administrator is not authorized to access.

---

# 2. Scope

The initial global search should support relevant administrative resources such as:

* Quotes.
* Administrators.
* Notifications.
* Relevant system settings where appropriate.
* Other resources added by future Admin Portal modules.

The search architecture must allow additional searchable resources to be registered without rewriting the entire search system.

---

# 3. Route

Recommended route:

```text id="j5m8x3"
/admin/search
```

Named route:

```text id="r7q2v9"
admin.search
```

An interactive search field may also exist in the global Admin Portal header.

---

# 4. Search Architecture

Recommended flow:

```text id="c8x4m7"
Search Query
      ↓
Search Service
      ↓
Determine Searchable Resources
      ↓
Apply Permissions
      ↓
Execute Efficient Queries
      ↓
Rank Results
      ↓
Return Results
```

---

# 5. Search Service

Search logic should be centralized.

Recommended abstraction:

```text id="n6q3x8"
AdminSearchService
```

The service should coordinate searchable resources rather than containing all resource-specific database logic.

---

# 6. Search Providers

Each resource may provide its own search implementation.

Conceptually:

```text id="v4m8c2"
Search Provider
├── QuoteSearch
├── AdministratorSearch
├── NotificationSearch
└── FutureResourceSearch
```

This allows new resources to be added without modifying unrelated search logic.

---

# 7. Searchable Resources

Initial resources:

| Resource       | Search Fields                                         |
| -------------- | ----------------------------------------------------- |
| Quotes         | Quote reference, customer name/email where authorized |
| Administrators | Name, email                                           |
| Notifications  | Title, message                                        |
| Settings       | Setting name/key where authorized                     |

Customer information must only appear if the administrator has permission to access it.

---

# 8. Quote Search

Quotes should primarily be searchable by:

* Quote reference.
* Customer name.
* Customer email where authorized.
* Relevant project/service information where appropriate.

Quote search must respect Quote Management permissions.

---

# 9. Administrator Search

Administrator search should support:

* Name.
* Email.

It must respect administrator-management permissions.

A user without administrator-management access should not receive unrestricted administrator records through search.

---

# 10. Notification Search

Notifications may be searchable by:

* Title.
* Message.
* Notification type.

Search results must only include notifications belonging to the authenticated administrator.

---

# 11. Settings Search

System settings should only be searchable by administrators authorized to view those settings.

Sensitive configuration values must never be returned as search results.

---

# 12. Search Permissions

Every search provider must apply authorization before returning results.

Conceptually:

```text id="q8m3r6"
Search
 ↓
Authorization
 ↓
Searchable Query
 ↓
Results
```

Do not search broadly and filter unauthorized records afterward if that could expose information through counts, ranking, or metadata.

---

# 13. Search Input

The search field should provide a clear placeholder.

Example:

```text id="x5v9c2"
Search quotes, administrators, settings...
```

The placeholder may be adjusted according to the resources actually enabled.

---

# 14. Minimum Query Length

A minimum query length may be applied to prevent inefficient broad searches.

Recommended:

```text id="m7q4x8"
2–3 characters
```

Resource-specific identifiers may be supported even when shorter.

---

# 15. Search Normalization

Search input should be normalized appropriately.

Consider:

* Leading/trailing whitespace.
* Case-insensitive matching.
* Unicode handling.
* Email normalization.

Do not alter the user's query in a way that changes its intended meaning.

---

# 16. Search Safety

Search input must be treated as untrusted input.

The implementation must use:

* Parameterized database queries.
* Laravel query builder/Eloquent protections.
* Safe output escaping.

Never concatenate raw search input directly into SQL.

---

# 17. Search Ranking

Results should prioritize the most relevant matches.

Recommended priority:

```text id="c4x7m9"
Exact identifier match
        ↓
Exact phrase match
        ↓
Starts-with match
        ↓
Contains match
```

The final ranking should depend on the searchable resource.

---

# 18. Search Result Groups

Results may be grouped by resource.

Example:

```text id="r8m2x5"
Quotes
────────────
SME-2026-000124
SME-2026-000120

Administrators
────────────
John Doe
Jane Smith
```

This makes mixed-resource search easier to understand.

---

# 19. Result Limit

The global search should return a limited number of results initially.

Example:

```text id="v3q8m6"
5 results per resource
```

A "View all results" action may lead to a dedicated search page.

---

# 20. Search Dropdown

The global header may provide an autocomplete-style search.

Example:

```text id="n7x4c2"
Search...

Quotes
SME-2026-000124
SME-2026-000123

Administrators
John Doe

View all results →
```

The dropdown should remain lightweight.

---

# 21. Keyboard Navigation

The search interface should support keyboard navigation.

Recommended:

```text id="p5m8x3"
↑ / ↓    Navigate
Enter    Open
Esc      Close
```

The implementation should follow accessible combobox/listbox patterns where applicable.

---

# 22. Search Shortcut

A keyboard shortcut may be provided for desktop users.

Example:

```text id="q6r2v8"
/
```

or:

```text id="m4x7c9"
Ctrl/Cmd + K
```

The shortcut must not interfere with normal text input.

---

# 23. Mobile Search

On mobile, search may open as a dedicated interface rather than a persistent desktop-style search field.

It should remain easily accessible from Admin navigation.

---

# 24. Search Results Page

The dedicated search page should display:

```text id="x8m3q5"
Search Results
Query: "SME"

[Filters]

Quotes
Results...

Administrators
Results...
```

---

# 25. Result Metadata

Each result should provide only useful information.

Example:

```text id="c7v2m9"
SME-2026-000124
New
Created today
```

Avoid exposing unnecessary private fields.

---

# 26. Result Actions

Search results should link to the corresponding resource.

Example:

```text id="r5q8x3"
SME-2026-000124
→ View Quote
```

The destination must perform normal authorization.

---

# 27. Search Does Not Grant Access

A search result is not an authorization mechanism.

Even if a result is displayed, the destination controller/policy must independently verify access.

---

# 28. Empty State

If no results are found:

```text id="m8x4q7"
No results found for "SME".
```

Where useful, provide a suggestion:

```text id="v3c9n5"
Try a different name, quote reference, or keyword.
```

---

# 29. Initial State

When no search query has been entered, the interface may display:

* Recent searches.
* Suggested resources.
* Frequently used actions.

Recent searches should not be stored unless required by the product.

---

# 30. Recent Searches

Recent searches are not required for the initial implementation.

If introduced later, they must:

* Belong to the current administrator.
* Avoid storing sensitive query content unnecessarily.
* Provide a clear option to clear them.

---

# 31. Search Filters

The initial search page may support resource filters:

```text id="q7m2x8"
All
Quotes
Administrators
Notifications
Settings
```

Only filters relevant to authorized resources should be shown.

---

# 32. Date Filtering

Date filtering is optional for the initial implementation.

It may become useful for:

* Audit records.
* Notifications.
* Quotes.

Resource-specific search pages should handle advanced filtering where appropriate.

---

# 33. Search Performance

Search must be optimized for the expected dataset.

Use:

* Appropriate database indexes.
* Efficient query construction.
* Pagination.
* Result limits.
* Debouncing for autocomplete.
* Search-specific indexing where necessary.

---

# 34. Autocomplete Debouncing

The autocomplete interface should not send a request for every keystroke.

A short debounce should be used.

Example:

```text id="x4r8m3"
User types
      ↓
Wait briefly
      ↓
Search
```

---

# 35. Large Dataset Strategy

If the dataset becomes large, the architecture should support:

* Full-text search.
* Dedicated search indexes.
* Laravel Scout if appropriate.
* External search infrastructure where justified.

The initial implementation should not introduce unnecessary infrastructure.

---

# 36. Search Caching

Search result caching is not required initially.

If caching is introduced later, it must account for:

* User permissions.
* Query.
* Resource scope.

A cached result must never leak data between administrators.

---

# 37. Privacy

Search should follow data minimization.

Do not return sensitive information simply because it matches a search query.

Examples of information that should remain hidden:

* Passwords.
* API keys.
* Authentication tokens.
* Private system secrets.
* Unauthorized customer information.

---

# 38. Search Logging

Search queries do not need to be audited by default.

However, searches involving highly sensitive resources may be logged if required by the security policy.

If search activity is logged, query content must be evaluated for privacy implications.

---

# 39. Error Handling

If search fails:

```text id="p6x3m8"
Search is temporarily unavailable.
Please try again.
```

Do not expose:

* SQL errors.
* Stack traces.
* Internal service details.

---

# 40. Accessibility

The search interface must support:

* Keyboard navigation.
* Screen readers.
* Visible focus states.
* Proper labels.
* Accessible autocomplete behavior.
* Logical result grouping.

ARIA attributes should only be used according to the actual interaction pattern.

---

# 41. Responsive Design

### Desktop

Persistent global search with dropdown suggestions.

### Tablet

Compact search control with responsive results.

### Mobile

Dedicated search interface with large, accessible input.

---

# 42. Security

The search system must enforce:

✓ Authentication.

✓ Authorization.

✓ Parameterized queries.

✓ Output escaping.

✓ Permission-aware providers.

✓ No sensitive values.

✓ No unauthorized result counts.

✓ Secure destination routes.

---

# 43. Controller

Recommended controller:

```text id="c8m5x2"
AdminSearchController
```

Responsibilities:

* Receive search request.
* Validate query.
* Invoke search service.
* Return results.

The controller should remain lightweight.

---

# 44. Request Validation

Search requests should validate:

* Query format.
* Maximum query length.
* Optional resource filter.

Example:

```text id="n4q7v9"
query: required|string|max:100
```

The exact limit should follow project conventions.

---

# 45. Search Service Response

The search service should return structured results.

Conceptually:

```text id="r3x8m5"
[
    {
        type: "quote",
        id: "...",
        title: "...",
        subtitle: "...",
        url: "..."
    }
]
```

The presentation layer should not need to understand database-specific details.

---

# 46. Component Architecture

Recommended reusable components:

```text id="v7m2q4"
components/admin/search/
├── input.blade.php
├── results.blade.php
├── result-item.blade.php
└── empty-state.blade.php
```

The actual naming should follow the project's existing component conventions.

---

# 47. Integration

The search system integrates with:

```text id="x5c9m3"
Quote Management
Administrator Management
Notifications
Settings
Audit Log
Authentication
Authorization
```

Future modules should be able to register searchable resources without redesigning the global search interface.

---

# 48. Acceptance Criteria

The module is accepted when:

✓ Authenticated administrators can search.

✓ Search results respect permissions.

✓ Quotes can be searched.

✓ Administrators can be searched where authorized.

✓ Notifications can be searched where appropriate.

✓ Settings can be searched where authorized.

✓ Unauthorized records never appear.

✓ Search input is validated.

✓ SQL injection protections are maintained.

✓ Results are limited and efficiently retrieved.

✓ Autocomplete is debounced.

✓ Search results are keyboard accessible.

✓ Search works on mobile.

✓ Destination pages independently enforce authorization.

✓ Sensitive information is not exposed.

✓ Empty and error states are handled correctly.

✓ The architecture supports future searchable resources.

---

# 49. Future Recommendations

Potential future enhancements:

* Advanced full-text search.
* Laravel Scout integration.
* Search analytics.
* Recent searches.
* Saved searches.
* Search filters.
* Cross-module advanced search.
* AI-assisted administrative search.

AI-assisted search should only be introduced with strict authorization and privacy controls.

---

# 50. Next Document

The next document is:

```text id="m9x4q7"
Documentation/17_Admin_Portal/16_Admin_Settings.md
```

This will define the Admin Portal settings architecture, including system configuration, general settings, contact information, business settings, integrations, security controls, validation, permissions, audit logging, and configuration boundaries.
