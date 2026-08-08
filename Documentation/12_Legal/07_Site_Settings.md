# SMEvolve Admin Portal

## 07 – Site Settings

**Project:** SMEvolve

**Module:** Admin Portal

**Documentation Path:** `Documentation/17_Admin_Portal/`

**Framework:** Laravel 12

**Frontend:** Blade, Vite, Alpine.js

**Version:** 1.0

**Document Type:** Site Settings Architecture & Functional Specification

---

# 1. Objective

Define the architecture and requirements for centralized SMEvolve website settings managed through the Admin Portal.

The Site Settings system should allow authorized administrators to update important public-facing business information without modifying application code.

The system must provide a single, reliable source for approved website-wide information.

---

# 2. Purpose

The Site Settings system exists to prevent important business information from being hardcoded throughout the application.

Instead of:

```text
Header → hardcoded phone
Footer → hardcoded phone
Contact page → hardcoded phone
Chatbot → hardcoded phone
```

the application should use:

```text
Admin Portal
      ↓
Site Settings
      ↓
Public Website
```

This ensures that a change made by an authorized administrator can propagate consistently throughout the website.

---

# 3. Settings Architecture

The high-level architecture is:

```text id="y7q3m8"
Administrator
      ↓
Admin Portal
      ↓
Settings Controller
      ↓
Settings Service
      ↓
Settings Repository / Model
      ↓
Database
      ↓
Settings Cache
      ↓
Public Website
```

The exact persistence implementation should follow the existing SMEvolve architecture.

---

# 4. Setting Categories

The initial settings system should support:

```text id="m5k8p2"
General
Contact
Business
Social
Website
```

Future categories can be added without redesigning the settings system.

---

# 5. General Settings

General settings may include:

* Company name.
* Company short name.
* Company description.
* Website name.
* Logo configuration where supported.
* Favicon configuration where supported.

Only approved fields should be exposed.

---

# 6. Company Name

The company name should be centrally managed.

Example:

```text id="c8x4r1"
Company Name
SMEvolve
```

The value may be used by:

* Header.
* Footer.
* SEO defaults.
* Contact pages.
* Legal pages.
* Emails where appropriate.

---

# 7. Company Description

The system may support a short public company description.

The description should have:

* Maximum length.
* Appropriate validation.
* Safe output escaping.

It must not accept arbitrary unsafe HTML by default.

---

# 8. Contact Settings

Contact settings should include:

```text id="j6p2v9"
Primary Phone
Secondary Phone
Primary Email
Secondary Email
Business Address
```

Only fields that are actually required should be displayed.

---

# 9. Primary Phone

The primary phone number is the main public contact number.

It may appear in:

* Header.
* Footer.
* Contact page.
* Quote Wizard.
* Chatbot.
* Other approved communication components.

The value must be validated before storage.

---

# 10. Secondary Phone

A secondary phone number may be configured when required.

If no secondary phone exists:

```text id="n3x7k5"
Do not display an empty phone field.
```

Public components should gracefully handle missing optional settings.

---

# 11. Primary Email

The primary email is the main public contact address.

It may be used by:

* Contact page.
* Footer.
* Quote Wizard.
* Chatbot.
* Business communications where appropriate.

It must be validated as a valid email address.

---

# 12. Secondary Email

The system may support an optional secondary email address.

If empty, public components should omit the secondary email rather than display an empty value.

---

# 13. Business Address

The business address should be stored as structured information where practical.

Possible fields:

```text id="b8q4x6"
Address Line 1
Address Line 2
City
State
Country
Postal Code
```

The exact structure should follow the existing SMEvolve business requirements.

---

# 14. Business Information

Business settings may include:

* Business hours.
* Service availability.
* Public business description.
* Location information.
* Other approved operational information.

These fields should remain focused on information that genuinely needs administrative management.

---

# 15. Business Hours

Business hours should support clear public presentation.

Potential structure:

```text id="p5v9k2"
Monday
Tuesday
Wednesday
Thursday
Friday
Saturday
Sunday
```

Each day may contain:

* Open time.
* Close time.
* Closed state.

The UI should make closed days explicit.

---

# 16. Social Links

The system should support approved social media platforms.

Potential platforms:

```text id="w7c3m5"
Facebook
Instagram
LinkedIn
X
```

Each social link should contain:

* Platform.
* URL.
* Active state where appropriate.

---

# 17. Social URL Validation

Social URLs must be validated as URLs.

Where appropriate, the system may also validate that the URL corresponds to the expected platform.

Do not rely solely on frontend validation.

---

# 18. Website Settings

Website settings may include:

* Website URL.
* Public site name.
* Footer text.
* Other approved global website values.

Settings that affect SEO should remain compatible with the global SEO architecture.

---

# 19. Legal Settings Boundary

Legal documents should remain under the Legal module.

The Admin Portal should not independently create a second legal content system.

If legal settings are later made administratively configurable, the Legal module should remain responsible for their business logic and structure.

---

# 20. SEO Boundary

Global SEO configuration should remain under the existing SEO architecture.

The Site Settings system may provide basic values such as:

* Company name.
* Website name.
* Website URL.

It should not duplicate the SEO service.

---

# 21. Setting Data Model

A flexible settings architecture should be used.

A conceptual structure could be:

```text id="h3q7m1"
settings
--------
id
key
value
type
group
description
is_public
created_at
updated_at
```

The exact database schema should be finalized in:

```text id="6v9p2x"
14_Database_Architecture.md
```

---

# 22. Setting Keys

Setting keys should be predictable and namespaced.

Examples:

```text id="r8x5k3"
site.company_name
site.company_description

contact.primary_phone
contact.secondary_phone

contact.primary_email
contact.secondary_email

business.address
business.hours

social.facebook
social.instagram
social.linkedin
social.x
```

The final naming convention must remain consistent.

---

# 23. Setting Types

The settings architecture should support appropriate value types.

Potential types:

```text id="y4m7p2"
string
text
email
phone
url
boolean
json
time
```

The system should not store everything as unrestricted text if stronger typing is useful.

---

# 24. Public vs Private Settings

Each setting should have a clear visibility classification.

### Public

Examples:

```text id="c5r9x1"
Company name
Phone
Public email
Business hours
Social links
```

### Private

Examples:

```text id="j8q3m6"
Internal configuration
Operational secrets
Private administrative information
```

Private values must not be exposed to public website requests.

---

# 25. Secrets Boundary

The settings system must not be used as a replacement for environment configuration.

Never store or expose:

```text id="m6v2p8"
APP_KEY
GROQ_API_KEY
DATABASE_PASSWORD
MAIL_PASSWORD
Server credentials
Encryption secrets
```

through ordinary website settings.

---

# 26. Settings Access

Administrators require:

```text id="z3x7c5"
settings.view
settings.update
```

Viewing and updating should be separate permissions.

---

# 27. Settings UI

The Site Settings interface should group fields logically.

Recommended layout:

```text id="n4k8p2"
Site Settings

[General]
Company Name
Company Description

[Contact]
Primary Phone
Secondary Phone
Primary Email
Secondary Email
Address

[Business]
Business Hours

[Social]
Facebook
Instagram
LinkedIn
X

[Website]
Website URL
Footer Information
```

---

# 28. Form Design

Forms should:

* Use clear labels.
* Explain fields where necessary.
* Mark required fields.
* Display validation errors.
* Preserve valid submitted values.
* Provide save/cancel actions.
* Confirm successful updates.

---

# 29. Validation

Every setting must have appropriate validation.

Examples:

```text id="s7m2q9"
Company Name → required, length limit
Email → valid email
Phone → valid phone
URL → valid URL
Boolean → true/false
Time → valid time
```

---

# 30. Sanitization

Text settings must be safely handled.

Unless a setting explicitly requires formatted HTML:

```text id="b3x9v6"
Input
 ↓
Validation
 ↓
Safe storage
 ↓
Escaped output
```

Do not render administrator-entered values as raw HTML by default.

---

# 31. Update Flow

The expected update flow is:

```text id="f8q4m2"
Administrator
      ↓
Edit Setting
      ↓
Submit
      ↓
Authorization
      ↓
Validation
      ↓
Settings Service
      ↓
Database
      ↓
Audit Log
      ↓
Cache Invalidation
      ↓
Success Response
```

---

# 32. Audit Requirements

Changes to important site settings must be audited.

Example:

```text id="w2k6r9"
Administrator: Admin User
Action: Updated setting
Setting: contact.primary_phone
Old Value: [protected]
New Value: [protected]
Time: ...
```

Sensitive values should not necessarily be stored in full in the audit record.

---

# 33. Audit Privacy

Audit logs must not expose sensitive information unnecessarily.

For example, if a setting contains private data, the audit record may record:

```text id="q6m3x8"
contact.primary_phone updated
```

rather than storing the entire old and new values.

---

# 34. Cache Strategy

Public settings may be cached for performance.

Example:

```text id="v5n8p1"
Request
 ↓
Settings Cache
 ↓
Value
```

If a setting is updated:

```text id="j3x7m9"
Update
 ↓
Database
 ↓
Invalidate cache
 ↓
Next request loads current value
```

---

# 35. Cache Consistency

Administrators must not need to manually clear application caches after changing routine website settings.

The settings service should handle cache invalidation automatically.

---

# 36. Public Website Consumption

Public components should access settings through a centralized service/helper.

Avoid:

```text id="k7r2x5"
Blade → direct database query
```

Prefer:

```text id="p9m4c6"
Blade
 ↓
Settings Service / Shared Data
 ↓
Cached Settings
```

This reduces duplicate logic and unnecessary database queries.

---

# 37. Shared View Data

Frequently used public settings may be made available through the application's existing global view/data architecture.

Examples:

* Company name.
* Phone.
* Email.
* Social links.

The implementation should avoid injecting large amounts of unnecessary data into every request.

---

# 38. Missing Settings

The application must gracefully handle missing optional settings.

For example:

```text id="x4q8m2"
Secondary Phone = null
```

should result in the secondary phone being omitted from the UI.

It must not cause an application error.

---

# 39. Default Values

Critical public settings may have safe defaults where appropriate.

However, defaults must not conceal a required production configuration problem.

For example:

```text id="n7p3c9"
Company Name
```

may have a configured application default during development, while production validation should ensure the correct value exists.

---

# 40. Setting Dependencies

Some settings may depend on others.

Example:

```text id="r6m2x8"
Secondary Phone Enabled
        ↓
Secondary Phone
```

The UI should make such relationships clear.

Avoid complicated conditional settings unless required.

---

# 41. Transaction Safety

Updates involving multiple related settings should use appropriate transactional behavior.

For example, updating structured business information should not leave the system partially updated if one required operation fails.

---

# 42. Concurrency

The settings system should handle simultaneous administrator updates predictably.

The initial implementation does not require advanced collaborative editing.

However, updates should not silently corrupt data.

---

# 43. Change Confirmation

For ordinary settings:

```text id="q8x3m6"
Save
 ↓
Success message
```

For highly consequential settings, additional confirmation may be appropriate.

Do not add confirmation dialogs to every field.

---

# 44. Website Verification

After updating public settings, administrators should be able to verify the result through the public website.

For example:

```text id="w5m7p2"
Change phone
 ↓
Save
 ↓
Open public website
 ↓
Verify phone
```

---

# 45. Responsive Design

The Site Settings interface must work on:

* Desktop.
* Tablet.
* Mobile.

Forms should stack naturally on smaller screens.

---

# 46. Accessibility

The Site Settings interface must provide:

* Proper labels.
* Field descriptions where required.
* Keyboard navigation.
* Visible focus.
* Accessible validation errors.
* Accessible success messages.
* Logical grouping.

---

# 47. Security

Site Settings must enforce:

* Authentication.
* Authorization.
* CSRF protection.
* Server-side validation.
* Output escaping.
* Audit logging.

---

# 48. Performance

The implementation should:

* Cache public settings where appropriate.
* Avoid repeated database queries.
* Load only required settings.
* Avoid unnecessary JavaScript.

---

# 49. Future Settings

The architecture should support future additions such as:

* WhatsApp contact.
* Google Maps location.
* Additional social platforms.
* Support hours.
* Emergency contact.
* Additional business locations.

New settings must follow the same validation, authorization, audit, and caching architecture.

---

# 50. Acceptance Criteria

The Site Settings module is accepted when:

✓ Authorized administrators can view settings.

✓ Authorized administrators can update settings.

✓ Unauthorized administrators cannot update settings.

✓ Company information is centralized.

✓ Phone numbers are centralized.

✓ Email addresses are centralized.

✓ Business information is centralized.

✓ Social links are centralized.

✓ Settings are validated.

✓ Settings are safely stored.

✓ Public values are safely consumed by the website.

✓ Cache invalidation works.

✓ Important changes are audited.

✓ Secrets are not exposed.

✓ Missing optional values are handled gracefully.

✓ Mobile and desktop layouts work.

✓ Accessibility requirements are satisfied.

---

# 51. Next Document

The next document is:

```text id="q2m7x5"
Documentation/17_Admin_Portal/08_Quote_Management.md
```

This will define the complete administrative Quote Management system, including quote listing, search, filtering, quote details, statuses, administrative actions, data protection, and workflows.
