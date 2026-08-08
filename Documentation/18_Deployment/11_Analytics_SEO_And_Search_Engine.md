# SMEvolve Deployment

## 11 – Analytics, SEO & Search Engine

**Project:** SMEvolve

**Module:** Deployment

**Documentation Path:** `Documentation/18_Deployment/`

**Framework:** Laravel 12

**Frontend:** Vite

**Source Control:** GitHub

**Production Hosting:** Hostinger

**Analytics:** Google Analytics

**Search Engine:** Google Search

**Document Version:** 1.0

**Status:** Draft

---

# 1. Purpose

This document defines the production configuration for website analytics, search-engine visibility, SEO, indexing, and search-engine monitoring.

It covers:

* Google Analytics.
* Google Search Console.
* Sitemap.
* robots.txt.
* Page metadata.
* Canonical URLs.
* Open Graph metadata.
* Structured data.
* Search-engine indexing.
* SEO verification.
* Analytics privacy.
* Search-engine troubleshooting.

The objective is to ensure SMEvolve can measure website usage and be correctly discovered and indexed by search engines.

---

# 2. Analytics Architecture

The production analytics flow is:

```text
Website Visitor
      │
      ▼
SMEvolve Website
      │
      ▼
Google Analytics
      │
      ▼
Analytics Reports
```

Analytics must only be enabled on the production website using the approved production measurement configuration.

---

# 3. Google Analytics

SMEvolve should use Google Analytics 4 where analytics tracking is required.

The production website must use the correct GA4 measurement ID.

Example format:

```text id="x6d4k1"
G-XXXXXXXXXX
```

The actual measurement ID must be stored in the project's approved configuration.

---

# 4. Analytics Environment

Analytics should distinguish production from development environments.

Development and local testing should not unintentionally pollute production analytics data.

The production measurement ID should only be enabled according to the application's environment configuration.

---

# 5. Analytics Configuration

If the measurement ID is exposed through frontend configuration, it must be treated as public information.

A Google Analytics measurement ID is not a secret.

However, the application must never expose:

```text id="2c9p7x"
Private API keys
Service-account credentials
Database credentials
SMTP passwords
```

through frontend configuration.

---

# 6. Analytics Events

SMEvolve may track meaningful user interactions.

Potential events include:

* Page views.
* Registration.
* Login.
* Contact form submission.
* Quote/request submission.
* Search.
* CTA clicks.
* Important conversion actions.

Only events that provide useful business insight should be implemented.

---

# 7. Event Naming

Analytics event names should be consistent and descriptive.

Example:

```text id="0n8w3a"
contact_form_submit
registration_complete
search
```

Avoid creating multiple event names for the same action.

---

# 8. Conversion Tracking

Important business actions may be marked as conversions in Google Analytics.

Potential examples:

```text id="6m5j2q"
Registration completed
Contact request submitted
Quote request submitted
Lead generated
```

The final conversion list must match SMEvolve's business objectives.

---

# 9. Sensitive Information

Analytics must not collect sensitive personal information.

Do not intentionally send:

* Passwords.
* Authentication tokens.
* Database information.
* Private medical information.
* Payment credentials.
* API keys.
* Full private messages.

URLs and event parameters must also be reviewed to ensure they do not contain sensitive information.

---

# 10. User Privacy

Analytics implementation must comply with applicable privacy requirements and the project's privacy policy.

The website should clearly communicate the use of analytics where required.

If consent management is required for the target audience or jurisdiction, it must be implemented before analytics tracking that requires consent is activated.

---

# 11. Google Search Console

SMEvolve should be registered with Google Search Console.

Search Console provides information about:

* Search indexing.
* Search queries.
* Search impressions.
* Search clicks.
* Search performance.
* Indexing problems.
* Sitemap processing.
* Core web-related signals where applicable.

---

# 12. Domain Verification

The production domain must be verified in Google Search Console.

The verification method may use:

* DNS.
* HTML file.
* HTML meta tag.
* Google Analytics.
* Google Tag Manager.

DNS verification is generally preferable when the organization controls the domain.

---

# 13. Production Domain

Search Console must use the real production domain.

Example:

```text id="w5f7m9"
https://yourdomain.com
```

The actual SMEvolve domain must replace the example.

---

# 14. HTTPS

The canonical production website should use HTTPS.

All important SEO URLs should resolve to HTTPS.

HTTP requests should redirect to the preferred HTTPS version where appropriate.

---

# 15. Canonical Domain

SMEvolve should define one preferred production domain.

For example:

```text id="2f9h6k"
https://yourdomain.com
```

or:

```text id="7m4q8x"
https://www.yourdomain.com
```

The project must choose one canonical form and apply it consistently.

---

# 16. Canonical URLs

Important indexable pages should have appropriate canonical URLs.

Example:

```text id="v3s6p8"
<link rel="canonical" href="https://yourdomain.com/example">
```

Canonical URLs should use the preferred HTTPS domain.

---

# 17. Duplicate Content

The application should avoid unnecessary duplicate URLs for the same content.

Potential sources include:

* Query parameters.
* Duplicate routes.
* HTTP/HTTPS versions.
* www/non-www versions.
* Trailing-slash variations.

The canonical strategy should clearly identify the preferred URL.

---

# 18. Sitemap

SMEvolve should provide a sitemap for indexable pages.

Typical URL:

```text id="k7m2s4"
https://yourdomain.com/sitemap.xml
```

The sitemap should contain only valid, indexable production URLs.

---

# 19. Sitemap Requirements

The sitemap should not intentionally contain:

* 404 URLs.
* Redirect URLs.
* Login pages.
* Private Admin Portal URLs.
* Duplicate URLs.
* Development URLs.
* Staging URLs.

---

# 20. Dynamic Sitemap

If SMEvolve contains dynamic public content, the sitemap may be generated dynamically.

The sitemap implementation should remain efficient and should not require expensive database processing for every request.

Caching may be used where appropriate.

---

# 21. robots.txt

The production website should expose:

```text id="0g8x3n"
https://yourdomain.com/robots.txt
```

The file should provide search engines with appropriate crawling instructions.

---

# 22. robots.txt Example

A basic public website configuration may look like:

```text id="5s2m9k"
User-agent: *
Allow: /

Sitemap: https://yourdomain.com/sitemap.xml
```

The actual rules must reflect SMEvolve's routes.

---

# 23. Private Routes

Sensitive application areas should not be exposed for indexing.

Examples may include:

```text id="n6q4t2"
/admin/
/dashboard/
/login/
/account/
```

However, `robots.txt` must not be treated as an access-control mechanism.

Authentication and authorization must protect these routes.

---

# 24. Admin Portal

The SMEvolve Admin Portal must not be publicly indexable.

Access should require appropriate authentication and authorization.

Search-engine visibility must never be relied upon to hide administrative functionality.

---

# 25. Login Pages

Login pages may be accessible to users but generally do not need to appear in search results.

The final SEO implementation should determine whether these pages should be indexed or marked appropriately.

---

# 26. Page Titles

Every important public page should have a meaningful title.

Example:

```text id="x7n3k9"
SMEvolve – Business Management Solutions
```

Titles should:

* Describe the page.
* Be unique where appropriate.
* Avoid keyword stuffing.
* Clearly represent the actual content.

---

# 27. Meta Descriptions

Important public pages should have useful meta descriptions.

The description should accurately summarize the page.

Do not create misleading descriptions solely to improve click-through rate.

---

# 28. Heading Structure

Public pages should use a logical heading hierarchy.

Generally:

```text id="k9p4d6"
H1
 ├── H2
 │    └── H3
 └── H2
```

There should normally be a clear primary page topic.

---

# 29. Image SEO

Images should use meaningful alternative text when appropriate.

Example:

```text id="a4m7z2"
<img alt="SMEvolve business dashboard">
```

Decorative images should not receive misleading descriptions.

---

# 30. Open Graph Metadata

Public pages should support Open Graph metadata where social sharing is important.

Potential fields include:

```text id="e5c8q1"
og:title
og:description
og:image
og:url
og:type
```

This improves how pages appear when shared on supported platforms.

---

# 31. Social Sharing Image

The project should maintain an appropriate social sharing image.

The image should:

* Represent SMEvolve branding.
* Have appropriate dimensions.
* Be publicly accessible.
* Use HTTPS.
* Not contain sensitive information.

---

# 32. Structured Data

Where applicable, SMEvolve may use Schema.org structured data.

Potential types depend on the actual website content.

Examples may include:

* Organization.
* WebSite.
* WebPage.
* BreadcrumbList.
* LocalBusiness where appropriate.

Structured data must accurately describe the page.

---

# 33. Structured Data Validation

Before launch, structured data should be tested with an appropriate validation tool.

Errors should be reviewed and corrected where they affect eligibility or accuracy.

Do not add structured data for information that is not visible or supported by the website.

---

# 34. Internal Links

Public pages should have logical internal links.

Internal linking helps:

* Users navigate.
* Search engines discover pages.
* Important pages receive appropriate internal authority.

Avoid creating unnecessary or artificial links.

---

# 35. Broken Links

Before production launch, scan public pages for broken links.

Check for:

```text id="j4m8q2"
404 responses
Incorrect redirects
Broken images
Broken internal links
Broken external links
```

---

# 36. Redirects

When URLs change, appropriate redirects should be configured.

Permanent URL changes should normally use an appropriate permanent redirect.

Avoid chains such as:

```text id="y8c5m1"
URL A
 ↓
URL B
 ↓
URL C
```

Prefer:

```text id="q3w6n9"
URL A
 ↓
URL C
```

---

# 37. Page Speed

SEO and user experience can be affected by page performance.

Verify:

* JavaScript size.
* CSS size.
* Image size.
* Server response time.
* Caching.
* Mobile performance.

The Vite production build should be used rather than development assets.

---

# 38. Mobile SEO

Verify the production website on mobile devices.

Check:

```text id="n2f8r5"
✓ Responsive layout
✓ Readable text
✓ Usable buttons
✓ Navigation
✓ Forms
✓ Images
✓ Page performance
```

---

# 39. Search Engine Indexing

After launch:

```text id="3p6k8v"
Production Website
       ↓
robots.txt
       ↓
sitemap.xml
       ↓
Google Search Console
       ↓
Google Crawling
       ↓
Indexing
```

Indexing is not guaranteed immediately.

---

# 40. Search Console Sitemap Submission

Submit the production sitemap through Google Search Console.

Verify that Google can:

* Fetch the sitemap.
* Read the URLs.
* Process the sitemap successfully.

---

# 41. Indexing Verification

After sufficient time has passed, check Search Console for:

* Indexed pages.
* Excluded pages.
* Crawl errors.
* Sitemap errors.
* Search impressions.

Do not expect indexing to occur instantly after deployment.

---

# 42. Search Engine Testing

Search for the production domain and important page names after indexing begins.

The goal is to confirm that:

* Correct pages are appearing.
* Incorrect/private pages are not appearing.
* Titles are correct.
* Descriptions are reasonable.
* Canonical URLs are correct.

---

# 43. Analytics Verification

After deployment, verify that Google Analytics receives a controlled visit.

Check:

```text id="h5v8k3"
✓ Page view
✓ Correct hostname
✓ Correct measurement ID
✓ Expected event
```

The analytics report may not update instantly in every reporting view.

---

# 44. Analytics Debugging

If analytics is not receiving data:

1. Check the measurement ID.
2. Check browser console errors.
3. Check network requests.
4. Verify the production environment.
5. Verify the analytics script.
6. Check consent configuration where applicable.
7. Check Google Analytics configuration.

---

# 45. Search Engine Security

SEO configuration must never weaken application security.

Do not:

* Expose private pages for indexing.
* Put secrets in metadata.
* Put credentials in URLs.
* Use robots.txt to protect private resources.
* Expose internal API endpoints unnecessarily.

---

# 46. Admin and Private Content

The following should remain protected by application authorization:

```text id="t7q4p9"
Admin Portal
User dashboard
Private files
Account information
Internal reports
Administrative APIs
```

Search-engine configuration does not replace authentication.

---

# 47. Environment Separation

SEO and analytics settings must distinguish:

```text id="f9x3k6"
Development
Staging
Production
```

Development/staging sites should not accidentally appear in search results.

---

# 48. Production Launch Configuration

Before launch verify:

```text id="m8p2z4"
✓ Production domain configured
✓ HTTPS active
✓ Canonical domain selected
✓ Sitemap active
✓ robots.txt active
✓ Metadata configured
✓ Analytics configured
✓ Search Console verified
✓ Structured data tested
```

---

# 49. SEO Deployment Checklist

```text id="c5n7r1"
DOMAIN
✓ Production domain confirmed
✓ HTTPS enabled
✓ Canonical domain selected

ANALYTICS
✓ Google Analytics configured
✓ Production measurement ID configured
✓ Important events configured
✓ Conversion events configured
✓ No sensitive data tracked

SEARCH CONSOLE
✓ Property verified
✓ Sitemap submitted
✓ Indexing monitored

SEO
✓ Page titles
✓ Meta descriptions
✓ H1 headings
✓ Canonical URLs
✓ Internal links
✓ Image alt text
✓ Open Graph metadata
✓ Structured data

CRAWLING
✓ robots.txt available
✓ Sitemap available
✓ Private routes protected
✓ Admin Portal protected
✓ No staging URLs exposed

PERFORMANCE
✓ Vite production build
✓ Images optimized
✓ Mobile tested
✓ Broken links checked
```

---

# 50. Acceptance Criteria

This document is complete when:

✓ Google Analytics configuration is defined.

✓ Analytics event strategy is defined.

✓ Privacy considerations are defined.

✓ Google Search Console configuration is defined.

✓ Domain verification is defined.

✓ Sitemap requirements are defined.

✓ robots.txt requirements are defined.

✓ Canonical URL strategy is defined.

✓ SEO metadata requirements are defined.

✓ Open Graph metadata is defined.

✓ Structured data requirements are defined.

✓ Admin/private route protection is defined.

✓ Search-engine indexing workflow is defined.

✓ Analytics verification is defined.

✓ Search Console monitoring is defined.

✓ Production SEO checklist is defined.

---

# 51. Next Document

The next document is:

```text
Documentation/18_Deployment/12_Security_SSL_Backups.md
```

This will cover **HTTPS/SSL on Hostinger, application security, production secrets, firewall/security settings, database backups, file backups, backup retention, restoration testing, and disaster recovery**.
