# SMEvolve Global Features Specification
## Part 10 – Global SEO Features

**Project Name:** SMEvolve

**Website:** https://smevolve.tech

**Version:** 1.0

**Document Type:** Global SEO Features Specification

---

# Purpose

This document defines the global Search Engine Optimization (SEO) features and technical requirements that apply across the SMEvolve website.

Unlike page-specific SEO guidance, this document establishes the shared SEO infrastructure, metadata standards, structured data, and search engine best practices that every page should follow.

---

# AI Implementation Instructions

Before implementing SEO functionality:

1. Read the AI Constitution.
2. Read the PRD.
3. Read the Information Architecture.
4. Read the Design System.
5. Read the Content Architecture.
6. Read the Global Features Overview.
7. Follow this specification exactly.

Never generate duplicate metadata or conflicting canonical URLs.

---

# Business Goals

Global SEO should:

- Improve search visibility.
- Support long-term organic growth.
- Increase qualified traffic.
- Strengthen SMEvolve's online authority.
- Provide a solid technical SEO foundation.

---

# Scope

This specification applies to every public page including:

- Homepage
- About
- Services
- Individual Service Pages
- Packages
- Portfolio
- Project Pages
- Blog
- Blog Articles
- FAQ
- Contact
- Legal Pages

---

# Metadata Standards

Every page should provide:

- Unique Page Title
- Unique Meta Description
- Canonical URL
- Open Graph Title
- Open Graph Description
- Open Graph Image
- Twitter Card Metadata

Metadata should accurately describe each page without duplication.

---

# Canonical URLs

Every public page must define a canonical URL.

Canonical URLs should:

- Use HTTPS.
- Avoid duplicate variations.
- Match the preferred public URL.

---

# Open Graph

Support:

- og:title
- og:description
- og:image
- og:url
- og:type
- og:site_name

Default site name:

SMEvolve

---

# Twitter Cards

Support:

- summary_large_image
- title
- description
- image

---

# Structured Data

Implement structured data where appropriate.

Recommended schema types include:

## Organization

Used site-wide.

Include:

- Business Name
- Website
- Logo
- Contact Information
- Social Profiles (when available)

---

## WebSite

Include:

- Website URL
- Name

Reserve support for future SearchAction.

---

## BreadcrumbList

Use wherever breadcrumbs are displayed.

---

## Service

Use on service pages.

---

## Article

Use on blog articles.

---

## FAQPage

Use on FAQ pages where appropriate.

---

## WebPage

Apply to general content pages.

---

# XML Sitemap

Generate an XML sitemap containing:

- Public Pages
- Services
- Portfolio Projects
- Blog Articles
- Categories

Exclude:

- Admin
- Authentication
- Search Results
- Error Pages

---

# Robots.txt

Allow indexing of public content.

Block:

- Admin routes
- Private files
- Development resources

Reference the XML sitemap.

---

# Heading Hierarchy

Maintain:

- One H1 per page.
- Logical H2–H6 structure.
- No skipped heading levels where practical.

Headings should describe content naturally.

---

# Internal Linking

Every page should include meaningful internal links where appropriate.

Prioritize links to:

- Services
- Portfolio
- About
- Packages
- Blog
- Contact
- Quote

Avoid excessive linking.

---

# Images

Every image should include:

- Descriptive alt text.
- Optimized file size.
- Responsive delivery.
- Modern formats where supported.

Decorative images should use empty alt attributes.

---

# URLs

URLs should be:

- Short
- Readable
- Descriptive
- Lowercase
- Hyphen-separated

Avoid unnecessary parameters.

---

# Performance

SEO implementation should support:

- Fast page loads.
- Optimized assets.
- Lazy-loaded images.
- Minimal layout shift.
- Strong Core Web Vitals.

---

# Accessibility

SEO and accessibility should work together.

Requirements include:

- Semantic HTML.
- Descriptive links.
- Accessible navigation.
- Proper landmarks.
- Meaningful image alternatives.

---

# Analytics

Support future integration with:

- Google Analytics 4
- Google Search Console
- Microsoft Clarity (optional)

Track:

- Organic traffic
- Landing pages
- CTA conversions
- Scroll depth
- Internal link usage

---

# Components

Suggested reusable components:

- SEO Metadata
- Open Graph Metadata
- Structured Data Generator
- Breadcrumb Schema
- Canonical Tag

Avoid duplicating metadata across Blade templates.

---

# Acceptance Criteria

Global SEO implementation is complete when:

- Every public page supports unique metadata.
- Canonical URLs are defined.
- Structured data is implemented where appropriate.
- XML sitemap is generated.
- robots.txt is configured.
- Internal linking follows best practices.
- Performance targets remain achievable.

---

# Revision Policy

Future SEO enhancements should extend this specification while maintaining consistency with the SMEvolve architecture and evolving search engine best practices.