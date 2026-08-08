# SMEvolve Admin Portal

## 08 – Quote Management

**Project:** SMEvolve

**Module:** Admin Portal

**Documentation Path:** `Documentation/17_Admin_Portal/`

**Framework:** Laravel 12

**Frontend:** Blade, Vite, Alpine.js

**Version:** 1.0

**Document Type:** Quote Management Functional & Technical Specification

---

# 1. Objective

Define the complete administrative Quote Management system for SMEvolve.

The Quote Management module allows authorized administrators to review, search, filter, manage, and track quote requests submitted through the public website and Quote Wizard.

The module must provide a clear operational workflow while protecting customer information and maintaining a complete history of important administrative actions.

---

# 2. Scope

The module includes:

* Quote listing.
* Quote search.
* Quote filtering.
* Quote sorting.
* Quote details.
* Quote status management.
* Administrative notes where supported.
* Quote activity.
* Quote references.
* Permission enforcement.
* Audit logging.
* Empty and error states.
* Responsive administration.

The module does not define the public Quote Wizard itself.

The Quote Wizard remains a separate feature and will integrate with this administrative system.

---

# 3. Quote Architecture

The high-level flow is:

```text
Public Website
      ↓
Quote Wizard
      ↓
Validation
      ↓
Quote Submission
      ↓
Database
      ↓
Admin Quote Management
      ↓
Review
      ↓
Status Updates
      ↓
Business Follow-up
```

---

# 4. Quote Access

Quote management requires authentication.

Recommended permissions:

```text
quotes.view
quotes.search
quotes.update_status
quotes.add_note
```

Each permission must be independently enforced.

A user who can view quotes must not automatically be allowed to modify them.

---

# 5. Quote Route

Recommended route:

```text
/admin/quotes
```

Named route:

```text
admin.quotes.index
```

Additional routes may include:

```text
/admin/quotes/{quote}
/admin/quotes/{quote}/status
```

The final route structure should follow the application's routing conventions.

---

# 6. Quote Listing

The Quote Management page should provide a structured list of quote requests.

Recommended columns:

| Field     | Description             |
| --------- | ----------------------- |
| Reference | Unique quote identifier |
| Customer  | Customer name           |
| Project   | Project/service summary |
| Status    | Current quote status    |
| Submitted | Submission date         |
| Updated   | Last modification       |
| Action    | View quote              |

The exact columns may be adjusted for responsive layouts.

---

# 7. Quote Reference

Every quote should have a unique human-readable reference.

Example:

```text
SME-2026-000124
```

The reference should be:

* Unique.
* Stable.
* Easy to communicate.
* Safe to expose to customers where required.

Database IDs should not necessarily be used as the public-facing quote reference.

---

# 8. Quote Statuses

The initial quote workflow should support:

```text
New
Under Review
Contacted
Quoted
Accepted
Rejected
Completed
```

The final status list must remain aligned with the Quote Wizard and business workflow.

---

# 9. New

`New` indicates that the quote has been submitted but has not yet been reviewed.

This is the primary status requiring administrative attention.

---

# 10. Under Review

`Under Review` indicates that an administrator is actively evaluating the request.

This may involve:

* Reviewing requirements.
* Checking feasibility.
* Determining service scope.
* Preparing a response.

---

# 11. Contacted

`Contacted` indicates that the customer has been contacted regarding the request.

This does not necessarily mean a quotation has been issued.

---

# 12. Quoted

`Quoted` indicates that SMEvolve has provided a quotation or pricing response to the customer.

The initial Admin Portal does not necessarily need to generate the quotation document itself.

---

# 13. Accepted

`Accepted` indicates that the customer has accepted the quotation.

This status may later integrate with:

* Agreements.
* Payments.
* Project management.

Those systems are outside the initial scope.

---

# 14. Rejected

`Rejected` indicates that the quote request did not proceed.

The reason may optionally be captured through an administrative note or structured field if required.

---

# 15. Completed

`Completed` indicates that the requested service/project associated with the quote has been completed.

This status should only be used where it represents an actual business completion state.

---

# 16. Status Transitions

The system should support controlled status transitions.

Example:

```text
New
 ↓
Under Review
 ↓
Contacted
 ↓
Quoted
 ↓
Accepted
 ↓
Completed
```

Alternative outcomes may include:

```text
Quoted → Rejected
Under Review → Rejected
Contacted → Rejected
```

The implementation should prevent nonsensical transitions where appropriate.

---

# 17. Status History

Every status change should be recorded.

Example:

```text
New
↓
Under Review
↓
Contacted
↓
Quoted
```

The history should record:

* Previous status.
* New status.
* Administrator.
* Timestamp.
* Optional note/reason.

---

# 18. Status Permission

Changing a quote status requires:

```text
quotes.update_status
```

The frontend must hide status controls from users without this permission.

The backend must independently enforce the permission.

---

# 19. Quote Search

The Quote Management page should support searching.

Searchable information may include:

* Quote reference.
* Customer name.
* Customer email.
* Phone number.
* Project/service name.

Search must be performed efficiently at the database level.

---

# 20. Search Behavior

Search should:

* Accept partial matches where appropriate.
* Ignore unnecessary whitespace.
* Handle normal capitalization differences.
* Return useful empty states.
* Preserve the search term during pagination.

Avoid searching across every database field unnecessarily.

---

# 21. Quote Filtering

Administrators should be able to filter quotes by:

* Status.
* Date range.
* Other approved operational criteria.

Example:

```text
Status: New
Date: Last 30 days
```

Filters should be combinable where useful.

---

# 22. Date Filtering

The system should support useful ranges such as:

```text
Today
Last 7 Days
Last 30 Days
This Month
Custom Range
```

The final set may be simplified for the first implementation.

---

# 23. Sorting

The quote list should support predictable sorting.

Default:

```text
Newest first
```

Additional sorting may include:

* Oldest first.
* Recently updated.
* Customer name.
* Status.

Do not introduce excessive sorting controls if they do not improve usability.

---

# 24. Pagination

Quote lists must be paginated.

Do not load every quote into the browser.

The default page size should be appropriate for the interface, for example:

```text
20–25 quotes per page
```

The exact number can be finalized during implementation.

---

# 25. Quote Details

Selecting a quote should open a dedicated detail view.

Recommended structure:

```text
Quote Header
Customer Information
Project Information
Requirements
Additional Information
Status
Status History
Administrative Activity
Actions
```

---

# 26. Quote Header

The quote header should display:

```text
Quote Reference
Customer Name
Current Status
Submission Date
```

The current status should be visually prominent.

---

# 27. Customer Information

Depending on what the Quote Wizard collects, the detail page may display:

* Name.
* Email.
* Phone.
* Company.
* Location.

Only information actually collected should be displayed.

---

# 28. Customer Contact Actions

Where appropriate, contact information may provide actions such as:

```text
Email Customer
Call Customer
```

These should use safe URL schemes and appropriate accessibility labels.

The Admin Portal should not automatically send messages merely because an administrator views a quote.

---

# 29. Project Information

The quote detail page should display relevant project information.

Potential fields:

* Service.
* Project type.
* Scope.
* Requirements.
* Budget.
* Timeline.
* Additional information.

The exact fields depend on the Quote Wizard specification.

---

# 30. Requirements

Customer-provided requirements must be displayed in a readable format.

Long-form text should:

* Wrap correctly.
* Preserve meaningful paragraphs.
* Remain readable on mobile.
* Be safely escaped.

Customer text must never be rendered as arbitrary HTML by default.

---

# 31. Quote Attachments

If the future Quote Wizard supports file attachments, the Admin Portal should be capable of displaying approved attachments.

However, attachment functionality is not required unless explicitly included in the Quote Wizard specification.

---

# 32. Administrative Notes

The system may support internal notes.

Internal notes must be clearly distinguished from customer-provided information.

Example:

```text
Internal Note
Customer requested a revised delivery timeline.
```

Internal notes must never accidentally appear on the public website.

---

# 33. Note Permission

Creating internal notes requires:

```text
quotes.add_note
```

If this permission is not granted, the note interface must not be available.

---

# 34. Quote Activity

The detail page may display relevant administrative activity.

Examples:

```text
Quote created
Status changed
Internal note added
Quote viewed
```

The exact events recorded should follow the audit architecture.

---

# 35. Audit vs Quote History

The Quote Management module may display a simplified quote-specific activity history.

The complete security audit record remains the responsibility of the Audit module.

Do not duplicate the entire audit system inside Quote Management.

---

# 36. Quote Creation

Quotes should normally be created by the public Quote Wizard.

The initial Admin Portal does not require administrators to manually create quotes.

If manual quote creation becomes necessary later, it should use the same validation and business rules as public submissions.

---

# 37. Quote Editing

The initial system should avoid allowing administrators to arbitrarily edit original customer-submitted data.

Customer-submitted information should remain historically accurate.

If corrections are required, the system should preferably record them separately or provide controlled administrative corrections.

---

# 38. Data Integrity

The system must distinguish between:

```text
Original Customer Submission
```

and:

```text
Administrative Changes
```

This protects the integrity of the customer's original request.

---

# 39. Quote Deletion

Permanent quote deletion should not be part of the initial workflow.

Instead, quotes should remain available for historical and audit purposes.

If deletion becomes necessary later, it must consider:

* Audit records.
* Legal requirements.
* Data retention.
* Business requirements.

---

# 40. Quote Archive

An archive mechanism may be introduced later.

For the initial implementation, completed or rejected quotes should remain accessible through filtering.

---

# 41. Sensitive Data

Quote information may contain personal information.

Administrators must only access quotes permitted by their role.

The system should avoid displaying sensitive information unnecessarily.

---

# 42. Authorization on Quote Resources

Resource-level authorization must be enforced.

Example:

```text
Request
 ↓
Authenticated
 ↓
quotes.view
 ↓
Quote exists
 ↓
Resource authorized
 ↓
Display
```

Changing a quote ID in a URL must never bypass authorization.

---

# 43. Validation

Status updates must be validated.

Example:

```text
status = accepted
```

must only be accepted if `accepted` is a valid configured status.

Do not trust client-provided status values.

---

# 44. Status Update Flow

The expected flow is:

```text
Administrator
 ↓
Select new status
 ↓
Authorization
 ↓
Validate status
 ↓
Validate transition
 ↓
Update quote
 ↓
Record history
 ↓
Create audit event
 ↓
Return success
```

The database update and history creation should be transaction-safe.

---

# 45. Concurrent Updates

If two administrators update the same quote simultaneously, the system should avoid silent data corruption.

The implementation should use appropriate database transaction and consistency mechanisms.

Advanced collaborative locking is not required initially.

---

# 46. Quote List Empty State

If no quotes exist:

```text
No quotes yet.
```

If a search/filter returns no results:

```text
No quotes match your search.
```

The interface should distinguish between these states.

---

# 47. Quote Loading State

For asynchronous operations, provide an accessible loading indicator.

Example:

```text
Loading quotes...
```

Do not introduce unnecessary full-page loading animations.

---

# 48. Quote Error State

If the quote list cannot be loaded:

```text
We couldn't load the quotes.
Please try again.
```

The application should log the underlying technical error without exposing implementation details to the administrator.

---

# 49. Responsive Design

### Desktop

Use table-oriented presentation.

### Tablet

Allow horizontal scrolling or responsive restructuring.

### Mobile

Convert complex rows into readable cards or stacked layouts.

Essential actions must remain accessible.

---

# 50. Accessibility

The Quote Management module must provide:

* Semantic headings.
* Accessible tables.
* Keyboard navigation.
* Visible focus states.
* Accessible filters.
* Proper form labels.
* Accessible status indicators.
* Screen-reader-friendly action buttons.
* Accessible pagination.

Status must not be communicated through color alone.

---

# 51. Performance

Quote Management must:

* Use database pagination.
* Use indexed search fields where necessary.
* Avoid N+1 queries.
* Select only required columns for listing pages.
* Load detailed information only on the detail page.
* Avoid unnecessary JavaScript.

---

# 52. Quote Service

Quote business logic should be centralized.

Recommended architecture:

```text
QuoteController
      ↓
QuoteService
      ↓
Quote Model / Repository
      ↓
Database
```

The controller should not contain complex status-transition logic.

---

# 53. Quote Policy

Laravel policies or the application's equivalent authorization architecture should control:

* View.
* Update status.
* Add note.
* Other future quote actions.

Authorization logic should not be duplicated throughout Blade templates and controllers.

---

# 54. Notifications

The initial Quote Management module does not require a complete notification system.

Future notifications may include:

* New quote notification.
* Status change notification.
* Assigned administrator notification.

These should be implemented as a separate notification architecture.

---

# 55. Email Integration

The Admin Portal may later support sending customer emails from quote records.

The initial implementation should not automatically introduce an email composer unless required.

If introduced later, outgoing messages must be clearly distinguished from internal notes.

---

# 56. Export

Quote export is not required for the initial implementation.

If introduced later, exports must:

* Require authorization.
* Respect data access permissions.
* Be audited.
* Protect personal information.

---

# 57. Search Security

Search parameters must be validated and safely passed to database queries.

Do not concatenate raw search input into SQL.

---

# 58. URL State

Search, filters, sorting, and pagination may be represented in query parameters.

Example:

```text
/admin/quotes?status=new&page=2
```

The server must validate all query parameters.

---

# 59. Browser Navigation

Using browser back/forward navigation should not result in unauthorized access to quote information after a user's session expires.

Protected pages must continue to require authentication.

---

# 60. Quote Management Acceptance Criteria

The module is accepted when:

✓ Authorized users can view quotes.

✓ Unauthorized users cannot view quotes.

✓ Quotes can be searched.

✓ Quotes can be filtered.

✓ Quotes can be sorted.

✓ Quotes are paginated.

✓ Quote references are unique.

✓ Quote details display correctly.

✓ Statuses are clearly displayed.

✓ Status changes are authorized.

✓ Invalid status transitions are prevented.

✓ Status history is recorded.

✓ Administrative notes are permission-controlled.

✓ Customer information is protected.

✓ Original submission data is preserved.

✓ Quote deletion is not exposed by default.

✓ Audit events are generated for important actions.

✓ Empty states work.

✓ Error states work.

✓ Mobile layout works.

✓ Accessibility requirements are satisfied.

✓ Database queries are efficient.

---

# 61. Integration Requirements

Quote Management must remain compatible with:

```text
Public Quote Wizard
Admin Dashboard
Audit Log
Notifications
Email System
Database Architecture
Authentication
Authorization
```

The Quote Wizard must create records that the Admin Portal can process without requiring duplicate quote structures.

---

# 62. Next Document

The next document is:

```text
Documentation/17_Admin_Portal/09_Chatbot_Management.md
```

This will define the administrative chatbot management interface, including chatbot status, configuration, AI provider visibility, operational controls, conversation-related administration, security boundaries, and integration with the existing chatbot system.
