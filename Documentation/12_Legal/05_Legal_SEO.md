# SMEvolve Legal Specification
## Part 5 – Legal SEO

**Project Name:** SMEvolve

**Website:** https://smevolve.tech

**Version:** 1.0

**Document Type:** Legal Pages SEO Specification

---

# Purpose

This document defines the SEO requirements for SMEvolve legal pages.

The objective is to ensure legal documents are discoverable, correctly structured, accessible to search engines, and consistent with the overall SMEvolve SEO architecture.

Legal pages should support trust and transparency rather than compete for commercial search rankings.

---

# AI Implementation Instructions

Before implementing legal SEO:

1. Read the Global SEO Features documentation.
2. Read the Legal Overview.
3. Reuse existing SEO components.
4. Do not create separate SEO logic.

---

# SEO Goals

Legal page SEO should:

- Help search engines understand document purpose.
- Improve website trust signals.
- Provide clear navigation.
- Support brand credibility.

---

# Applicable Pages

SEO applies to:

```
/privacy-policy

/terms

/cookies
```

---

# Metadata Structure

Each legal page requires unique metadata.

---

# Privacy Policy

## Title

```
Privacy Policy | SMEvolve
```

## Description

```
Learn how SMEvolve collects, uses, and protects personal information through our website and services.
```

---

# Terms & Conditions

## Title

```
Terms & Conditions | SMEvolve
```

## Description

```
Read the terms and conditions that guide the use of SMEvolve services and website.
```

---

# Cookie Policy

## Title

```
Cookie Policy | SMEvolve
```

## Description

```
Learn how SMEvolve uses cookies and similar technologies to improve website functionality and user experience.
```

---

# Canonical URLs

Each page must have a canonical URL.

Examples:

```
https://smevolve.tech/privacy-policy

https://smevolve.tech/terms

https://smevolve.tech/cookies
```

---

# Heading Structure

Each legal page should contain:

One H1:

Example:

Privacy Policy

---

Use logical H2 sections.

Avoid:

- Multiple H1 tags.
- Incorrect heading hierarchy.

---

# Structured Data

Implement:

---

## WebPage Schema

Required.

Each legal page represents a webpage document.

---

## BreadcrumbList Schema

Required.

Example:

Home

↓

Privacy Policy

---

## Organization Schema

Reuse global organization schema.

---

# Avoid Commercial Schema

Do not use:

- Product schema
- Offer schema
- Service schema

Legal pages are informational.

---

# Internal Linking

Legal pages should link to:

- Contact page
- Privacy Policy
- Terms
- Cookie Policy

Where relevant.

Example:

Privacy Policy:

→ Cookie Policy

Terms:

→ Contact

---

# Footer SEO

Legal links should always appear in the footer.

Required:

- Privacy Policy
- Terms & Conditions
- Cookie Policy

---

# Indexing Strategy

Legal pages should generally be:

Indexable:

✓ Privacy Policy

✓ Terms & Conditions

✓ Cookie Policy

Do not block them unnecessarily.

---

# Sitemap

Include legal pages in:

XML Sitemap

unless business requirements change.

---

# Performance Requirements

Legal pages should:

- Load quickly.
- Avoid unnecessary scripts.
- Use lightweight rendering.

---

# Accessibility SEO

Ensure:

- Semantic HTML.
- Readable typography.
- Clear headings.
- Accessible navigation.

---

# Analytics

Track:

- Legal page visits.
- Navigation from footer.
- User interaction with legal links.

Avoid collecting unnecessary personal information.

---

# Future Compatibility

The SEO architecture should support future legal pages:

- Refund Policy
- AI Policy
- Data Processing Agreement
- Subscription Terms
- Client Agreement

---

# Acceptance Criteria

Legal SEO is complete when:

✓ Metadata exists.

✓ Canonical URLs are configured.

✓ Structured data is implemented.

✓ Internal links exist.

✓ Footer navigation works.

✓ Pages are accessible.

✓ Sitemap compatibility exists.

---

# Revision Policy

SEO settings should be reviewed whenever new legal documents or business services are introduced.