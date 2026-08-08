# SMEvolve FAQ Specification
## Part 6 – FAQ Content Structure

**Project Name:** SMEvolve

**Website:** https://smevolve.tech

**Version:** 1.0

**Document Type:** FAQ Content Architecture Specification

---

# Purpose

This document defines how FAQ content should be structured, organised, and maintained within the SMEvolve website.

The goal is to create a scalable knowledge base that can support current website needs while allowing future expansion into a full documentation platform, help center, or AI-powered support system.

---

# AI Implementation Instructions

Before creating FAQ content:

1. Read the FAQ System specification.
2. Read the Content Architecture documentation.
3. Follow the SMEvolve brand voice.
4. Avoid technical language that confuses non-technical visitors.

All FAQ content should be clear, concise, and customer-focused.

---

# Content Principles

FAQ answers should be:

- Clear
- Direct
- Helpful
- Professional
- Easy to understand

Avoid:

- Long paragraphs
- Excessive technical terms
- Generic answers
- Marketing exaggeration

---

# FAQ Data Model

Each FAQ entry should contain:

```text
id

question

answer

category

tags

priority

featured

related_pages

status
```

---

# Field Definitions

## ID

Unique identifier.

Example:

pricing-001

---

## Question

The customer-facing question.

Requirements:

- Written from the user's perspective.
- Natural language.
- Search-friendly.

Example:

"How much does a website cost?"

---

## Answer

The response content.

Requirements:

- Answer the question immediately.
- Explain clearly.
- Include relevant links when useful.

Recommended length:

50–200 words.

---

## Category

Primary classification.

Example:

Pricing

Each FAQ should have one main category.

---

## Tags

Additional searchable keywords.

Example:

```
website
cost
pricing
packages
```

A question may have multiple tags.

---

## Priority

Controls display order.

Example:

1 = Most important

10 = Lowest priority

---

## Featured

Determines whether the FAQ appears in highlighted sections.

Example:

Homepage FAQ

---

## Related Pages

Connect FAQ answers to website sections.

Examples:

- Services
- Packages
- Contact
- Quote Wizard

---

## Status

Controls availability.

Values:

Active

Draft

Archived

---

# Recommended FAQ Categories

## General

Purpose:

Questions about SMEvolve and working together.

Examples:

- Who is SMEvolve?
- What services do you provide?

---

## Services

Purpose:

Questions about technology solutions.

Examples:

- Do you build websites?
- Do you develop custom software?

---

## Pricing

Purpose:

Questions about cost and packages.

Examples:

- How much does a website cost?
- Do you offer payment plans?

---

## Development Process

Purpose:

Questions about project workflow.

Examples:

- How does a project start?
- How long does development take?

---

## Support & Maintenance

Purpose:

Questions after delivery.

Examples:

- Do you provide maintenance?
- Can you update my website later?

---

## Technical

Purpose:

Technology-related questions.

Examples:

- What technologies do you use?
- Can you integrate existing systems?

---

## Payments

Purpose:

Financial process questions.

Examples:

- What payment methods do you accept?
- What is the payment structure?

---

## Quote Wizard

Purpose:

Questions about requesting proposals.

Examples:

- How does the quote process work?

---

# Content Writing Guidelines

Answers should:

Start with the direct answer.

Example:

"Yes, SMEvolve provides ongoing website maintenance..."

Then provide explanation.

Avoid starting with:

"It depends..."

unless explaining complexity.

---

# Internal Linking Guidelines

FAQ answers should link naturally to relevant pages.

Examples:

Pricing questions:

→ Packages

Service questions:

→ Services

Project questions:

→ Quote Wizard

General questions:

→ Contact

---

# SEO Considerations

FAQ content should:

- Match search intent.
- Use natural language.
- Include relevant keywords.
- Avoid keyword stuffing.

Questions should resemble real user searches.

---

# Content Review Process

Before publishing:

Check:

✓ Accuracy

✓ Clarity

✓ Brand tone

✓ Links

✓ Grammar

✓ Search usefulness

---

# Future Expansion

The content structure should support:

- Help center articles
- Video tutorials
- AI chatbot training
- Client portal documentation
- Developer documentation

---

# Acceptance Criteria

This document is complete when:

- FAQ fields are defined.
- Categories are established.
- Writing standards are documented.
- SEO requirements are included.
- Future scalability is considered.

---

# Revision Policy

New FAQ content should follow this structure to maintain consistency across the SMEvolve knowledge ecosystem.