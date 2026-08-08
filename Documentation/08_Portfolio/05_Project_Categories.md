# SMEvolve Portfolio Specification
## Part 5 – Project Categories

**Project Name:** SMEvolve

**Website:** https://smevolve.tech

**Version:** 1.0

**Document Type:** Portfolio Categories Specification

---

# Purpose

This document defines the official project categories used throughout the SMEvolve Portfolio module.

These categories provide a consistent structure for organizing, filtering, searching, and presenting portfolio projects.

All portfolio projects must belong to one primary category.

Secondary categories or tags may be introduced in future versions.

---

# AI Implementation Instructions

Before implementing project categories:

1. Read the Portfolio Master Specification.
2. Read the Portfolio Listing Page specification.
3. Read the Project Detail Page specification.
4. Follow this document exactly.

Do not invent additional categories unless approved.

---

# Category Objectives

Project categories should:

- Help visitors quickly find relevant work.
- Improve portfolio organization.
- Support future filtering and search.
- Improve SEO.
- Scale as the portfolio grows.

---

# Official Categories

## Website Development

### Description

Business websites, corporate websites, landing pages, informational websites, and service websites.

### Examples

- Corporate Website
- School Website
- Hospital Website
- NGO Website

---

## E-commerce Development

### Description

Online stores and digital commerce platforms.

### Examples

- Fashion Store
- Pharmacy
- Electronics Store
- Grocery Store

---

## Custom Software

### Description

Business systems developed specifically for client requirements.

### Examples

- ERP
- CRM
- Inventory System
- Laboratory Management System

---

## Mobile Applications

### Description

Native and cross-platform mobile applications.

### Examples

- Android Applications
- iOS Applications
- Cross-platform Apps

---

## AI Solutions

### Description

Projects that use Artificial Intelligence to improve business operations or customer experiences.

### Examples

- AI Chatbot
- Knowledge Assistant
- AI Content Assistant
- AI Search

---

## Business Automation

### Description

Workflow automation and process optimization projects.

### Examples

- Approval Workflows
- Email Automation
- Reporting Automation
- Customer Onboarding

---

## API Development

### Description

Projects focused primarily on integrations and software communication.

### Examples

- Payment Gateway Integration
- Third-party API
- CRM Integration
- ERP Integration

---

# Category Metadata

Each category should support:

- Name
- Slug
- Description
- Hero Image (future)
- SEO Title
- SEO Description
- Featured Status
- Display Order

This structure should be suitable for future database storage.

---

# URL Structure

Categories should support URLs such as:

```text
/portfolio/category/websites

/portfolio/category/ecommerce

/portfolio/category/custom-software

/portfolio/category/mobile-apps

/portfolio/category/ai-solutions

/portfolio/category/business-automation

/portfolio/category/api-development
```

---

# Portfolio Filters

The Portfolio page should support filtering by:

- All Projects
- Website Development
- E-commerce
- Custom Software
- Mobile Applications
- AI Solutions
- Business Automation
- API Development

Filtering should preserve accessibility and degrade gracefully if JavaScript is unavailable.

---

# Display Order

Recommended order:

1. Website Development
2. E-commerce Development
3. Custom Software
4. Mobile Applications
5. AI Solutions
6. Business Automation
7. API Development

---

# Future Expansion

Future versions may introduce:

- Industry filters
- Technology filters
- Project size
- Completion year
- Featured projects
- Client sectors

The architecture should allow these additions without redesign.

---

# SEO

Each category should support:

- Unique title
- Meta description
- Canonical URL
- Introductory content
- Internal linking

Avoid creating thin or duplicate category pages.

---

# Accessibility

Ensure:

- Keyboard-accessible filters
- Proper labels
- Semantic navigation
- Screen reader support
- Visible focus indicators

---

# Acceptance Criteria

The category system is complete when:

- All official categories are defined.
- URL structure is standardized.
- Filters are documented.
- Metadata requirements are established.
- Future expansion is supported.

---

# Revision Policy

New categories should only be introduced when they represent a significant new service offering or project type approved by SMEvolve.