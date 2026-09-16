# SMEvolve SEO Growth & Content Architecture Report

**Project:** SMEvolve  
**Domain:** https://smevolve.tech  
**Date:** August 2026  
**Mode:** Research + Architecture Only  
**Prompt:** 031

---

## Table of Contents

1. [Current SEO Score / Baseline](#1-current-seo-score--baseline)
2. [Technical SEO Findings](#2-technical-seo-findings)
3. [Current Indexed-Page Strategy](#3-current-indexed-page-strategy)
4. [Keyword Research Matrix](#4-keyword-research-matrix)
5. [Keyword Clusters](#5-keyword-clusters)
6. [Keyword-to-URL Ownership Map](#6-keyword-to-url-ownership-map)
7. [Homepage SEO Recommendation](#7-homepage-seo-recommendation)
8. [Service-Page Recommendations](#8-service-page-recommendations)
9. [Portfolio Recommendations](#9-portfolio-recommendations)
10. [Local SEO Strategy](#10-local-seo-strategy)
11. [Blog / Content Clusters](#11-blog--content-clusters)
12. [90-Day Content Calendar](#12-90-day-content-calendar)
13. [Internal Linking Architecture](#13-internal-linking-architecture)
14. [Schema Strategy](#14-schema-strategy)
15. [Image SEO Strategy](#15-image-seo-strategy)
16. [Core Web Vitals Strategy](#16-core-web-vitals-strategy)
17. [Competitor Analysis](#17-competitor-analysis)
18. [Competitor Gap Analysis](#18-competitor-gap-analysis)
19. [Backlink Strategy](#19-backlink-strategy)
20. [Google Search Console Strategy](#20-google-search-console-strategy)
21. [SEO KPI Framework](#21-seo-kpi-framework)
22. [Conversion Strategy](#22-conversion-strategy)
23. [AI-Search Visibility Strategy](#23-ai-search-visibility-strategy)
24. [Recommended Sitemap Architecture](#24-recommended-sitemap-architecture)
25. [Recommended Robots / Indexation Architecture](#25-recommended-robots--indexation-architecture)
26. [Implementation Roadmap](#26-implementation-roadmap)
27. [Exact Pages That Should Be Created](#27-exact-pages-that-should-be-created)
28. [Pages That Should NOT Be Created](#28-pages-that-should-not-be-created)
29. [Priority Ranking](#29-priority-ranking)
30. [Estimated Implementation Complexity](#30-estimated-implementation-complexity)

---

## 1. Current SEO Score / Baseline

### Overall Assessment: 7/10

SMEvolve has a **strong technical foundation** from Prompt 030. The SEO infrastructure is above average for a Lagos-based SME-focused company. The primary gap is **content depth and topical authority** — the site has excellent service pages but lacks supporting content, local SEO signals, and blog content.

### Baseline Scores

| Area | Score | Status |
|------|-------|--------|
| Technical SEO | 8/10 | Strong foundation |
| On-Page SEO | 7/10 | Good, needs refinement |
| Content Depth | 5/10 | Service pages strong, no blog |
| Local SEO | 4/10 | Minimal local signals |
| Schema Markup | 7/10 | Good coverage, missing LocalBusiness |
| Mobile SEO | 8/10 | Responsive, needs CWV audit |
| Internal Linking | 6/10 | Basic, needs architecture |
| Backlink Profile | 2/10 | No strategy in place |
| Brand Signals | 3/10 | Limited online presence |

---

## 2. Technical SEO Findings

### 2.1 Technical SEO Audit Results

| Area | Status | Detail |
|------|--------|--------|
| `/sitemap.xml` | **PASS** | Dynamic XML sitemap via `SitemapController`, cached with configurable TTL |
| `/robots.txt` | **PASS** | Allows all public routes, blocks `/admin/`, `/api/`, `/search`, `/storage/`, `/vendor/` |
| Canonical URLs | **PASS** | Implemented in `app.blade.php` layout, auto-generated from request path |
| Open Graph | **PASS** | Full OG tags: `og:site_name`, `og:locale`, `og:type`, `og:title`, `og:url`, `og:description`, `og:image` (1200x630) |
| Twitter/X Metadata | **PASS** | `twitter:card` (summary_large_image), `twitter:title`, `twitter:description`, `twitter:image` |
| Organization Schema | **PASS** | On homepage: `@type: Organization` with name, url, logo, description, email |
| WebSite Schema | **PASS** | On homepage: `@type: WebSite` with name, url |
| Service Schema | **PASS** | On individual service pages: `@type: Service` with name, description, url, provider |
| HSTS Headers | **PASS** | Via `SecurityHeaders` middleware |
| Security Headers | **PASS** | CSP, X-Frame-Options, etc. via middleware |
| Search noindex | **PASS** | `robots="noindex, follow"` on `/search` |
| Quote Wizard noindex | **PASS** | `robots="noindex, follow"` on `/quote` and wizard steps |
| Breadcrumbs Component | **PASS** | `components/breadcrumbs.blade.php` with `BreadcrumbList` schema support |
| FAQ Schema | **PASS** | On `/faq` and `/contact` pages: `@type: FAQPage` |
| ItemList Schema | **PASS** | On `/services` and `/portfolio` index pages |
| ContactPage Schema | **PASS** | On `/contact`: `@type: ContactPage` with Organization entity |
| CreativeWork Schema | **PASS** | On portfolio detail pages: `@type: CreativeWork` |
| HTML Sitemap | **PASS** | `/sitemap` route with human-readable page |
| Skip-to-content link | **PASS** | Accessibility skip link in layout |
| Font preloading | **PASS** | Inter font preloaded with `crossorigin` |

### 2.2 Issues Found

| Issue | Severity | Detail |
|-------|----------|--------|
| Organization schema incomplete | **Medium** | Missing `telephone`, `address`, `social` profiles, `logo` URL (logo is set to `null` in `config/seo.php`) |
| No `LocalBusiness` schema | **Medium** | Should extend Organization with `@type: LocalBusiness` for local SEO |
| No `hreflang` tag | **Low** | Not needed yet, but should be added when international targeting begins |
| Company phone is placeholder | **High** | `+234 800 000 0000` — must be real number before SEO launch |
| Company address is null | **High** | All address fields (`street`, `city`, `state`, `country`, `formatted`) are `null` |
| Map embed URL is null | **Medium** | `maps.embed_url` and `maps.directions_url` are `null` |
| No `sameAs` in Organization schema | **Medium** | Missing social media profile links |
| robots.txt missing `/quote/*` | **Low** | Quote wizard is noindexed via meta tag, but could also be blocked in robots.txt |

### 2.3 Verdict

**The Prompt 030 technical SEO implementation is solid.** The foundation is in place. The main issues are **incomplete business information** (phone, address, social profiles) and **missing LocalBusiness schema**. These should be addressed in Phase 1.

---

## 3. Current Indexed-Page Strategy

### Current Sitemap Architecture

The sitemap (`SitemapController`) includes:

**Static routes** (from `config/seo.php`):
- `/` (home)
- `/about`
- `/services`
- `/packages`
- `/portfolio`
- `/faq`
- `/contact`

**Dynamic routes:**
- `/services/{slug}` — 10 service pages
- `/portfolio/category/{slug}` — portfolio categories with projects > 0
- `/portfolio/{slug}` — all published portfolio projects

**Total estimated sitemap entries:** ~20-25 URLs

### Excluded from Sitemap

| URL Pattern | Reason |
|-------------|--------|
| `/quote` | Lead-generation wizard, noindex |
| `/quote/{uuid}/*` | Dynamic wizard steps, noindex |
| `/search` | Internal search, noindex |
| `/admin/*` | Authenticated admin panel |
| `/api/*` | API endpoints |
| `/password/*` | Password reset flows |
| `/reset-password/*` | Password reset flows |
| `/privacy-policy` | Legal page (consider adding) |
| `/terms` | Legal page (consider adding) |
| `/cookies` | Legal page (consider adding) |

### Recommendation

The legal pages (`/privacy-policy`, `/terms`, `/cookies`) should be added to the sitemap. They are indexable, canonical, and provide trust signals. They are currently missing from `seo.sitemap.static_routes`.

---

## 4. Keyword Research Matrix

> **Note:** Exact search volume data is not verified. Rankings marked "Not verified" are estimated based on competitive analysis. SMEvolve does not currently rank on page 1 for any commercial keywords.

### CLUSTER A — WEB DESIGN

| Primary Keyword | Secondary Keywords | Intent | Commercial Value | Geo Relevance | Target Page | Difficulty | Current Ranking | Priority | Content Type |
|----------------|-------------------|--------|-----------------|---------------|-------------|------------|-----------------|----------|-------------|
| web design company Lagos | website design Lagos, web design agency Lagos, SME website design Lagos | Commercial/Local | High | Lagos | /services/website-development | Medium | Not ranked | P0 | Service page |
| web design company Nigeria | website design Nigeria, web design agency Nigeria | Commercial | High | Nigeria | /services/website-development | Medium | Not ranked | P1 | Service page |
| business website design Lagos | company website design Lagos, professional website Lagos | Commercial/Local | High | Lagos | /services/website-development | Low | Not ranked | P0 | Service page |
| how much does a website cost in Nigeria | website cost Lagos, business website price Nigeria | Informational | Medium | Nigeria | /blog/website-cost-nigeria | Low | Not ranked | P1 | Blog article |
| best web design company in Lagos | top web design company Lagos, affordable web design Lagos | Commercial Investigation | High | Lagos | /blog/best-web-design-lagos | Medium | Not ranked | P1 | Blog article |

### CLUSTER B — WEB DEVELOPMENT

| Primary Keyword | Secondary Keywords | Intent | Commercial Value | Geo Relevance | Target Page | Difficulty | Current Ranking | Priority | Content Type |
|----------------|-------------------|--------|-----------------|---------------|-------------|------------|-----------------|----------|-------------|
| web development company Lagos | website development company Lagos, web dev agency Lagos | Commercial/Local | High | Lagos | /services/website-development | Medium | Not ranked | P0 | Service page |
| web development company Nigeria | website development Nigeria, web dev company Nigeria | Commercial | High | Nigeria | /services/website-development | Medium | Not ranked | P1 | Service page |
| custom website development Lagos | bespoke website Lagos, tailor-made website Nigeria | Commercial/Local | High | Lagos | /services/website-development | Low | Not ranked | P1 | Service page |

### CLUSTER C — E-COMMERCE

| Primary Keyword | Secondary Keywords | Intent | Commercial Value | Geo Relevance | Target Page | Difficulty | Current Ranking | Priority | Content Type |
|----------------|-------------------|--------|-----------------|---------------|-------------|------------|-----------------|----------|-------------|
| ecommerce website development Lagos | online store development Lagos, ecommerce design Nigeria | Commercial/Local | High | Lagos | /services/ecommerce-development | Medium | Not ranked | P0 | Service page |
| ecommerce website design Nigeria | online store Nigeria, sell online Nigeria | Commercial | High | Nigeria | /services/ecommerce-development | Medium | Not ranked | P1 | Service page |
| ecommerce development company Lagos | ecommerce agency Lagos, shopify developer Lagos | Commercial/Local | High | Lagos | /services/ecommerce-development | Medium | Not ranked | P1 | Service page |
| how to sell products online Nigeria | start ecommerce business Nigeria, online selling Nigeria | Informational | Medium | Nigeria | /blog/sell-online-nigeria | Low | Not ranked | P2 | Blog article |

### CLUSTER D — AI

| Primary Keyword | Secondary Keywords | Intent | Commercial Value | Geo Relevance | Target Page | Difficulty | Current Ranking | Priority | Content Type |
|----------------|-------------------|--------|-----------------|---------------|-------------|------------|-----------------|----------|-------------|
| AI chatbot development Lagos | chatbot developer Nigeria, AI chatbot company Lagos | Commercial/Local | High | Lagos | /services/ai-solutions | Low | Not ranked | P0 | Service page |
| AI chatbot for businesses Nigeria | business chatbot Lagos, AI customer service Nigeria | Commercial | High | Nigeria | /services/ai-solutions | Low | Not ranked | P1 | Service page |
| AI solutions for SMEs | artificial intelligence small business, AI for SME Nigeria | Commercial | High | Nigeria | /services/ai-solutions | Low | Not ranked | P1 | Service page |
| business AI solutions Lagos | AI automation Lagos, artificial intelligence company Nigeria | Commercial/Local | High | Lagos | /services/ai-solutions | Low | Not ranked | P1 | Service page |
| what is an AI chatbot | how do AI chatbots work, AI chatbot benefits | Informational | Medium | Global | /blog/what-is-ai-chatbot | Low | Not ranked | P2 | Blog article |

### CLUSTER E — BUSINESS AUTOMATION

| Primary Keyword | Secondary Keywords | Intent | Commercial Value | Geo Relevance | Target Page | Difficulty | Current Ranking | Priority | Content Type |
|----------------|-------------------|--------|-----------------|---------------|-------------|------------|-----------------|----------|-------------|
| business automation Lagos | workflow automation Lagos, business process automation Nigeria | Commercial/Local | High | Lagos | /services/business-automation | Low | Not ranked | P0 | Service page |
| business automation Nigeria | SME automation Nigeria, automation solutions Nigeria | Commercial | High | Nigeria | /services/business-automation | Low | Not ranked | P1 | Service page |
| workflow automation Lagos | process automation Lagos, automate business Lagos | Commercial/Local | Medium | Lagos | /services/business-automation | Low | Not ranked | P1 | Service page |

### CLUSTER F — CUSTOM SOFTWARE

| Primary Keyword | Secondary Keywords | Intent | Commercial Value | Geo Relevance | Target Page | Difficulty | Current Ranking | Priority | Content Type |
|----------------|-------------------|--------|-----------------|---------------|-------------|------------|-----------------|----------|-------------|
| custom software development Lagos | software development company Lagos, bespoke software Nigeria | Commercial/Local | High | Lagos | /services/custom-software | Medium | Not ranked | P0 | Service page |
| software development company Lagos | app development company Lagos, software house Nigeria | Commercial/Local | High | Lagos | /services/custom-software | Medium | Not ranked | P1 | Service page |
| business software development Nigeria | custom business applications Nigeria, enterprise software Nigeria | Commercial | High | Nigeria | /services/custom-software | Medium | Not ranked | P1 | Service page |

### CLUSTER G — MOBILE

| Primary Keyword | Secondary Keywords | Intent | Commercial Value | Geo Relevance | Target Page | Difficulty | Current Ranking | Priority | Content Type |
|----------------|-------------------|--------|-----------------|---------------|-------------|------------|-----------------|----------|-------------|
| mobile app development Lagos | app developer Lagos, mobile app company Nigeria | Commercial/Local | High | Lagos | /services/mobile-app-development | Medium | Not ranked | P0 | Service page |
| mobile app development Nigeria | Android developer Lagos, iOS developer Nigeria | Commercial | High | Nigeria | /services/mobile-app-development | Medium | Not ranked | P1 | Service page |
| business app development Nigeria | enterprise mobile app Lagos, business application Nigeria | Commercial | High | Nigeria | /services/mobile-app-development | Medium | Not ranked | P2 | Service page |

### CLUSTER H — WEBSITE MAINTENANCE

| Primary Keyword | Secondary Keywords | Intent | Commercial Value | Geo Relevance | Target Page | Difficulty | Current Ranking | Priority | Content Type |
|----------------|-------------------|--------|-----------------|---------------|-------------|------------|-----------------|----------|-------------|
| website maintenance Lagos | website support Lagos, website management Nigeria | Commercial/Local | Medium | Lagos | /services/website-maintenance | Low | Not ranked | P1 | Service page |
| website support Nigeria | website upkeep Nigeria, website updates Nigeria | Commercial | Medium | Nigeria | /services/website-maintenance | Low | Not ranked | P2 | Service page |

### CLUSTER I — LARAVEL / WORDPRESS (Technology-Specific)

| Primary Keyword | Secondary Keywords | Intent | Commercial Value | Geo Relevance | Target Page | Difficulty | Current Ranking | Priority | Content Type |
|----------------|-------------------|--------|-----------------|---------------|-------------|------------|-----------------|----------|-------------|
| Laravel developer Lagos | Laravel development company Nigeria, hire Laravel developer | Commercial/Local | High | Lagos | /services/laravel-development | Low | Not ranked | P1 | Service page |
| WordPress developer Lagos | WordPress development company Nigeria, hire WordPress developer | Commercial/Local | High | Lagos | /services/wordpress-development | Medium | Not ranked | P1 | Service page |

---

## 5. Keyword Clusters

### Cluster Architecture

```
CLUSTER A — WEB DESIGN (Primary)
├── /services/website-development (PILLAR)
├── /blog/website-cost-nigeria (SUPPORTING)
├── /blog/best-web-design-lagos (SUPPORTING)
├── /blog/what-should-business-website-contain (SUPPORTING)
└── /blog/website-vs-social-media-nigeria (SUPPORTING)

CLUSTER B — WEB DEVELOPMENT (Merged with A)
└── /services/website-development (SHARED PILLAR)

CLUSTER C — E-COMMERCE
├── /services/ecommerce-development (PILLAR)
├── /blog/sell-online-nigeria (SUPPORTING)
└── /blog/ecommerce-vs-social-commerce (SUPPORTING)

CLUSTER D — AI
├── /services/ai-solutions (PILLAR)
├── /blog/what-is-ai-chatbot (SUPPORTING)
├── /blog/ai-customer-service-nigeria (SUPPORTING)
└── /blog/ai-automation-small-business (SUPPORTING)

CLUSTER E — BUSINESS AUTOMATION
├── /services/business-automation (PILLAR)
├── /blog/workflow-automation-benefits (SUPPORTING)
└── /blog/automate-repetitive-tasks (SUPPORTING)

CLUSTER F — CUSTOM SOFTWARE
├── /services/custom-software (PILLAR)
├── /blog/custom-software-vs-off-the-shelf (SUPPORTING)
└── /blog/when-business-needs-custom-software (SUPPORTING)

CLUSTER G — MOBILE
├── /services/mobile-app-development (PILLAR)
└── /blog/native-vs-cross-platform (SUPPORTING)

CLUSTER H — WEBSITE MAINTENANCE
├── /services/website-maintenance (PILLAR)
└── /blog/why-website-maintenance-matters (SUPPORTING)

CLUSTER I — TECHNOLOGY
├── /services/laravel-development (PILLAR)
├── /services/wordpress-development (PILLAR)
└── /blog/laravel-vs-wordpress (SUPPORTING)
```

### Cannibalization Avoidance

- **Web Design + Web Development** → Merged into single pillar: `/services/website-development`. Both keyword sets target the same user intent and same service.
- **AI Chatbots + AI Solutions** → Merged into single pillar: `/services/ai-solutions`. AI chatbots are a feature within the broader AI solutions offering.
- **Laravel + WordPress** → Separate pages (different technology, different audience), but cross-linked.

---

## 6. Keyword-to-URL Ownership Map

Every important keyword cluster has ONE primary target page:

| Keyword Cluster | Primary Target URL | Secondary URLs |
|----------------|-------------------|----------------|
| web design Lagos / Nigeria | `/services/website-development` | Homepage, /blog/* |
| web development Lagos / Nigeria | `/services/website-development` | Homepage |
| ecommerce development Lagos / Nigeria | `/services/ecommerce-development` | Homepage |
| AI chatbot Lagos / Nigeria | `/services/ai-solutions` | Homepage |
| AI solutions SMEs | `/services/ai-solutions` | Homepage |
| business automation Lagos / Nigeria | `/services/business-automation` | Homepage |
| custom software Lagos / Nigeria | `/services/custom-software` | Homepage |
| mobile app Lagos / Nigeria | `/services/mobile-app-development` | Homepage |
| website maintenance Lagos / Nigeria | `/services/website-maintenance` | Homepage |
| Laravel development Lagos | `/services/laravel-development` | Homepage |
| WordPress development Lagos | `/services/wordpress-development` | Homepage |
| API development Lagos | `/services/api-development` | Homepage |
| digital solutions Lagos / Nigeria | Homepage (`/`) | /about, /services |
| SMEvolve (brand) | Homepage (`/`) | /about |
| pricing / packages | `/packages` | Homepage |
| portfolio | `/portfolio` | /portfolio/{slug} |
| FAQ | `/faq` | Service page FAQs |
| contact | `/contact` | Homepage footer |

---

## 7. Homepage SEO Recommendation

### Current Analysis

**Current Title:** `SMEvolve | Digital Solutions for SMEs in Lagos, Nigeria`  
**Current H1:** `Building Digital Solutions That Help Businesses Grow`  
**Current Description:** `SMEvolve helps businesses build modern websites, custom software, mobile applications, and automation solutions designed around their unique goals.`

### Issues

1. H1 does not mention Lagos/Nigeria (local SEO signal)
2. H1 is generic — does not differentiate from competitors
3. Title tag has good local signals but could be stronger
4. Description is service-focused but lacks geographic anchor

### H1/Title Strategy Alternatives

| Option | Title Tag | H1 | Pros | Cons |
|--------|-----------|-----|------|------|
| A | SMEvolve \| Web Design, AI & Software Development in Lagos | Web Design, AI & Software Development for Lagos Businesses | Strong local + service signals, clear positioning | Slightly long |
| B | SMEvolve \| Digital Solutions for Lagos & Nigerian Businesses | Digital Solutions That Help Lagos Businesses Grow | Good local focus, broad service coverage | Less specific on services |
| C | SMEvolve \| Web Design, AI Chatbots & Automation in Lagos | Build Smarter Websites, Software & AI Solutions in Lagos | Differentiated, mentions AI chatbots | "Build" may confuse |
| D | SMEvolve \| Website Development & AI Solutions in Lagos Nigeria | Website Development, AI & Business Automation for Lagos | Clear service list, strong local | Missing some services |

### Recommended: Option A

**Title:** `SMEvolve \| Web Design, AI & Software Development in Lagos`  
**H1:** `Web Design, AI & Software Development for Lagos Businesses`

**Why:** This is the strongest balance of:
- **Primary services** mentioned (Web Design, AI, Software Development)
- **Geographic anchor** (Lagos) in both title and H1
- **Differentiation** from competitors who only say "digital solutions"
- **Search intent match** for the highest-value commercial queries
- **Length** within recommended limits (~55-60 chars for title)

### Homepage Structure Recommendation

```
H1: Web Design, AI & Software Development for Lagos Businesses
├── Hero section (current, refined)
├── Services overview (current, refined)
├── Why choose SMEvolve (current)
├── Industries served (current)
├── Process section (current)
├── Portfolio preview (current)
├── FAQ preview (current)
├── Final CTA (current)
└── NEW: Client trust section (testimonials when available)
└── NEW: Lagos/Nigeria positioning section
```

### Recommended Internal Links from Homepage

- Homepage → /services (all 10 services)
- Homepage → /portfolio
- Homepage → /packages
- Homepage → /contact
- Homepage → /quote
- Homepage → /about
- Homepage → Key blog articles (future)

---

## 8. Service-Page Recommendations

### Current Service Pages (10 total)

All service pages are dynamically rendered from `ServicesData.php` with rich, unique content.

| Service | Slug | Meta Title | Meta Description | Content Quality | SEO Score |
|---------|------|------------|------------------|-----------------|-----------|
| Website Development | website-development | Website Development Services | Professional website development for growing businesses... | Excellent (169 lines of content) | 7/10 |
| E-commerce Development | ecommerce-development | E-commerce Development Services | Custom e-commerce solutions that help you sell online... | Excellent (273 lines) | 7/10 |
| Custom Software | custom-software | Custom Software Development Services | Custom software built around your business... | Excellent (376 lines) | 7/10 |
| Laravel Development | laravel-development | Laravel Development Services | Professional Laravel development... | Excellent (479 lines) | 7/10 |
| WordPress Development | wordpress-development | WordPress Development Services | Professional WordPress websites built for business growth... | Excellent (582 lines) | 7/10 |
| Mobile App Development | mobile-app-development | Mobile App Development Services | Mobile apps that help your business grow... | Excellent (685 lines) | 7/10 |
| AI Solutions | ai-solutions | AI Solutions for Business | Practical AI solutions for modern businesses... | Excellent (787 lines) | 7/10 |
| Business Automation | business-automation | Business Automation Services | Automate repetitive work and improve business efficiency... | Excellent (891 lines) | 7/10 |
| API Development | api-development | API Development & System Integration | Secure API development and system integration... | Excellent (993 lines) | 7/10 |
| Website Maintenance | website-maintenance | Website Maintenance Services | Keep your website secure, fast and up to date... | Excellent (1097 lines) | 7/10 |

### Issues with Current Service Pages

1. **Missing local SEO in meta titles** — Titles say "Website Development Services" not "Website Development Services in Lagos"
2. **Missing local SEO in descriptions** — No mention of Lagos/Nigeria
3. **Missing breadcrumb schema** — Service pages do not emit BreadcrumbList structured data
4. **Missing FAQ schema** — Each service has FAQs but no FAQPage schema
5. **No pricing signals** — No indication of cost or packages (competitors like DientWeb include pricing ranges)

### Recommended Meta Updates

| Service | Recommended Title | Recommended Description |
|---------|------------------|----------------------|
| Website Development | Website Development Services in Lagos \| SMEvolve | Professional website development for businesses in Lagos and Nigeria. Fast, responsive, SEO-friendly websites built around your business goals. |
| E-commerce Development | E-commerce Development Services in Lagos \| SMEvolve | Custom e-commerce solutions for businesses in Lagos and Nigeria. Secure, scalable online stores with a great shopping experience. |
| Custom Software | Custom Software Development in Lagos \| SMEvolve | Custom software built around your business in Lagos and Nigeria. Secure, scalable applications designed around your workflows. |
| AI Solutions | AI Solutions for Business in Lagos \| SMEvolve | Practical AI solutions for businesses in Lagos and Nigeria. Automate routine work, improve customer interactions, and grow smarter. |

### Service Page Content Structure

Each service page already has excellent structure:

```
H1 (hero heading)
├── Overview section
├── Problems We Solve
├── Our Solution
├── Key Features
├── Business Benefits
├── Technologies We Use
├── Process section (shared component)
├── FAQs (with items)
├── Related Services
└── Final CTA
```

**Recommendation:** This structure is already well-aligned with the prompt's requirements. No changes needed to content structure. Only metadata and schema enhancements required.

---

## 9. Portfolio Recommendations

### Current Portfolio System

- **Data source:** Database (`PortfolioProject` model) with fallback to code-based providers
- **Routes:** `/portfolio`, `/portfolio/category/{slug}`, `/portfolio/{slug}`
- **Content:** Rich project data including challenge, solution, features, outcome, technologies, gallery
- **Schema:** `CreativeWork` on detail pages, `ItemList` on index

### Current Portfolio Projects (Code-Based Fallback)

1. `sample-inventory-system` — Sample Inventory System
2. `concept-clinic-website` — Concept Clinic Website
3. `concept-retail-store` — Concept Retail Store

### Issues

1. **All projects are sample/concept** — No real client projects published yet
2. **No real case studies** — Need actual projects to build trust
3. **Missing breadcrumb schema** on portfolio pages
4. **Portfolio projects don't link to services** strongly enough (related services exist but could be more prominent)

### Recommendations

1. **Add real portfolio projects** — As SMEvolve completes client work, add real projects with real outcomes (with client permission)
2. **Enhance portfolio SEO per project:**
   - Each project should have unique `meta.title` and `meta.description`
   - Include industry-specific keywords in project titles
   - Link back to the relevant service page
3. **Add breadcrumb schema** to portfolio index and detail pages
4. **Create portfolio category descriptions** that include target keywords

### Portfolio Page SEO Structure

| Page | Title | Description | Schema |
|------|-------|-------------|--------|
| /portfolio | Portfolio \| SMEvolve Lagos | Explore our portfolio of websites, software, and AI solutions built for businesses in Lagos and Nigeria. | ItemList |
| /portfolio/{slug} | {Project Title} \| SMEvolve Portfolio | {Project summary with service and industry context} | CreativeWork |
| /portfolio/category/{slug} | {Category Name} Projects \| SMEvolve | Browse our {category} projects for businesses in Lagos and Nigeria. | ItemList |

---

## 10. Local SEO Strategy

### Primary Geographic Target: Lagos, Nigeria
### Secondary: Nigeria

### 10.1 Current Local Signals

| Signal | Status | Detail |
|--------|--------|--------|
| Title tags with Lagos | Partial | Homepage title has "Lagos, Nigeria" |
| H1 with Lagos | No | Homepage H1 does not mention Lagos |
| Body content with Lagos | Minimal | Contact page mentions Nigeria |
| NAP consistency | Incomplete | Phone is placeholder, address is null |
| Google Business Profile | Unknown | Not verified |
| LocalBusiness schema | Missing | Organization schema exists but not LocalBusiness |
| Local citations | None | No directory listings found |
| Local backlinks | None | No local link building |
| Map on contact page | Missing | `maps.embed_url` is null |

### 10.2 Local SEO Strategy

**Phase 1: NAP Foundation**

Before any local SEO work, the following must be completed:
- Real phone number in `config/company.php` (`contact.phone`)
- Real address in `config/company.php` (`address.*`)
- Real WhatsApp number
- Google Business Profile claimed and verified
- Consistent NAP across all platforms

**Phase 2: Schema Enhancement**

Add `LocalBusiness` schema extending the existing `Organization` schema:

```json
{
  "@context": "https://schema.org",
  "@type": "LocalBusiness",
  "name": "SMEvolve",
  "url": "https://smevolve.tech",
  "telephone": "+234 XXX XXX XXXX",
  "address": {
    "@type": "PostalAddress",
    "streetAddress": "...",
    "addressLocality": "Lagos",
    "addressRegion": "Lagos State",
    "addressCountry": "NG"
  },
  "geo": {
    "@type": "GeoCoordinates",
    "latitude": "...",
    "longitude": "..."
  },
  "openingHoursSpecification": [...],
  "areaServed": ["Lagos", "Nigeria"],
  "sameAs": [...]
}
```

**Phase 3: On-Page Local Signals**

- Add Lagos/Nigeria mentions in service page meta titles and descriptions
- Add "Serving businesses in Lagos and Nigeria" section on homepage
- Add Lagos map embed on contact page
- Add local phone number prominently

**Phase 4: Local Content**

- Blog articles targeting Lagos-specific searches
- Lagos business case studies
- Nigeria-focused content (not neighborhood-specific)

### 10.3 What NOT to Do

- Do NOT create `/locations/ikeja`, `/locations/lekki`, etc.
- Do NOT create fake location pages
- Do NOT create fake reviews
- Do NOT keyword-stuff Lagos into every page

### 10.4 Google Business Profile Recommendations

| Element | Recommendation |
|---------|---------------|
| **Category** | Primary: "Web Design" or "Software Company". Secondary: "E-Commerce Agency", "Information Technology Company" |
| **Description** | SMEvolve helps businesses in Lagos and Nigeria build modern websites, custom software, AI chatbots, and automation solutions. We design and develop digital products that help growing businesses work smarter and reach more customers. |
| **Services** | Website Development, E-Commerce Development, Custom Software, AI Solutions, Business Automation, Mobile App Development, Laravel Development, WordPress Development, API Development, Website Maintenance |
| **Website** | https://smevolve.tech |
| **Contact** | Match NAP exactly with website |
| **Photos** | Office photos, team photos, project screenshots, logo |
| **Reviews** | Request reviews from satisfied clients (never fake) |
| **Posts** | Weekly posts about services, blog articles, project highlights |

---

## 11. Blog / Content Clusters

### Content Strategy

Every blog article must support a commercial service page. No random topics.

### PILLAR + SUPPORTING ARTICLES

#### Cluster A: Web Design for SMEs in Nigeria

**PILLAR:** `/services/website-development` (existing service page)

| Article Title | Target Keyword | Intent | Links To |
|--------------|---------------|--------|----------|
| How Much Does a Business Website Cost in Nigeria? | website cost Nigeria | Informational | /services/website-development |
| How to Choose a Web Design Company in Lagos | choose web design company Lagos | Commercial Investigation | /services/website-development |
| What Should a Small Business Website Contain? | small business website features | Informational | /services/website-development |
| Website vs Social Media for Nigerian Businesses | website vs social media Nigeria | Informational | /services/website-development |
| How Long Does It Take to Build a Business Website? | website development timeline | Informational | /services/website-development |

#### Cluster B: E-Commerce in Nigeria

**PILLAR:** `/services/ecommerce-development` (existing service page)

| Article Title | Target Keyword | Intent | Links To |
|--------------|---------------|--------|----------|
| How to Start Selling Online in Nigeria | sell online Nigeria | Informational | /services/ecommerce-development |
| E-Commerce Website Features Your Store Needs | ecommerce features | Informational | /services/ecommerce-development |
| Choosing the Right Payment Gateway for Your Nigerian Store | payment gateway Nigeria | Informational | /services/ecommerce-development |

#### Cluster C: AI for Business

**PILLAR:** `/services/ai-solutions` (existing service page)

| Article Title | Target Keyword | Intent | Links To |
|--------------|---------------|--------|----------|
| What Is an AI Chatbot and How Can It Help Your Business? | what is AI chatbot | Informational | /services/ai-solutions |
| How AI Customer Service Can Grow Your Nigerian Business | AI customer service Nigeria | Informational | /services/ai-solutions |
| 5 Ways Small Businesses Can Use AI Today | AI for small business | Informational | /services/ai-solutions |

#### Cluster D: Business Automation

**PILLAR:** `/services/business-automation` (existing service page)

| Article Title | Target Keyword | Intent | Links To |
|--------------|---------------|--------|----------|
| Workflow Automation: A Simple Guide for Small Businesses | workflow automation guide | Informational | /services/business-automation |
| Signs Your Business Needs Automation | business needs automation | Informational | /services/business-automation |

#### Cluster E: Custom Software

**PILLAR:** `/services/custom-software` (existing service page)

| Article Title | Target Keyword | Intent | Links To |
|--------------|---------------|--------|----------|
| Custom Software vs Off-the-Shelf: Which Is Right for Your Business? | custom vs off-the-shelf software | Informational | /services/custom-software |
| When Does a Business Need Custom Software? | when need custom software | Informational | /services/custom-software |

#### Cluster F: Technology Decisions

**PILLAR:** `/services/laravel-development`, `/services/wordpress-development`

| Article Title | Target Keyword | Intent | Links To |
|--------------|---------------|--------|----------|
| Laravel vs WordPress: Which Should You Choose? | Laravel vs WordPress | Commercial Investigation | /services/laravel-development, /services/wordpress-development |
| Why Laravel Is Great for Business Applications | Laravel benefits | Informational | /services/laravel-development |

#### Cluster G: Website Maintenance

**PILLAR:** `/services/website-maintenance` (existing service page)

| Article Title | Target Keyword | Intent | Links To |
|--------------|---------------|--------|----------|
| Why Website Maintenance Matters for Your Business | website maintenance importance | Informational | /services/website-maintenance |
| How Often Should You Update Your Website? | website update frequency | Informational | /services/website-maintenance |

---

## 12. 90-Day Content Calendar

### Month 1 (Weeks 1-4): Foundation

| Week | Title | Target Keyword | Intent | Target Page | Type | Priority | Internal Links | CTA | Purpose |
|------|-------|---------------|--------|-------------|------|----------|----------------|-----|---------|
| 1 | How Much Does a Business Website Cost in Nigeria? | website cost Nigeria | Informational | /services/website-development | Blog | P0 | → /services/website-development, /packages, /quote | Get a Quote | Capture cost-research traffic |
| 2 | What Is an AI Chatbot and How Can It Help Your Business? | what is AI chatbot | Informational | /services/ai-solutions | Blog | P0 | → /services/ai-solutions, /contact | Book a Consultation | Introduce AI offering |
| 3 | How to Choose a Web Design Company in Lagos | choose web design company Lagos | Commercial Investigation | /services/website-development | Blog | P0 | → /services/website-development, /portfolio, /quote | Get a Free Quote | Capture comparison traffic |
| 4 | Custom Software vs Off-the-Shelf: Which Is Right for Your Business? | custom vs off-the-shelf | Informational | /services/custom-software | Blog | P1 | → /services/custom-software, /contact | Talk to Us | Educate on custom software |

### Month 2 (Weeks 5-8): Expansion

| Week | Title | Target Keyword | Intent | Target Page | Type | Priority | Internal Links | CTA | Purpose |
|------|-------|---------------|--------|-------------|------|----------|----------------|-----|---------|
| 5 | How to Start Selling Online in Nigeria | sell online Nigeria | Informational | /services/ecommerce-development | Blog | P1 | → /services/ecommerce-development, /packages | Get a Quote | E-commerce education |
| 6 | 5 Ways Small Businesses Can Use AI Today | AI for small business | Informational | /services/ai-solutions | Blog | P1 | → /services/ai-solutions, /services/business-automation | Book a Consultation | AI awareness |
| 7 | What Should a Small Business Website Contain? | small business website features | Informational | /services/website-development | Blog | P1 | → /services/website-development, /portfolio | View Our Portfolio | Website education |
| 8 | Workflow Automation: A Simple Guide for Small Businesses | workflow automation guide | Informational | /services/business-automation | Blog | P1 | → /services/business-automation, /contact | Talk to Us | Automation awareness |

### Month 3 (Weeks 9-12): Depth

| Week | Title | Target Keyword | Intent | Target Page | Type | Priority | Internal Links | CTA | Purpose |
|------|-------|---------------|--------|-------------|------|----------|----------------|-----|---------|
| 9 | Laravel vs WordPress: Which Should You Choose? | Laravel vs WordPress | Commercial Investigation | /services/laravel-development | Blog | P1 | → /services/laravel-development, /services/wordpress-development | Get a Quote | Technology decision |
| 10 | Signs Your Business Needs Automation | business needs automation | Informational | /services/business-automation | Blog | P2 | → /services/business-automation, /quote | Get a Quote | Automation trigger |
| 11 | How AI Customer Service Can Grow Your Nigerian Business | AI customer service Nigeria | Informational | /services/ai-solutions | Blog | P2 | → /services/ai-solutions, /contact | Book a Consultation | AI local relevance |
| 12 | Why Website Maintenance Matters for Your Business | website maintenance importance | Informational | /services/website-maintenance | Blog | P2 | → /services/website-maintenance, /packages | Get a Quote | Maintenance upsell |

---

## 13. Internal Linking Architecture

### Link Hierarchy

```
Homepage (/)
├── /about
├── /services (all 10 services linked)
│   ├── /services/website-development
│   │   ├── → /portfolio (related projects)
│   │   ├── → /packages
│   │   ├── → /services/website-maintenance (related)
│   │   ├── → /services/wordpress-development (related)
│   │   ├── → /services/laravel-development (related)
│   │   ├── → /services/api-development (related)
│   │   └── → /quote (CTA)
│   ├── /services/ecommerce-development
│   │   ├── → /portfolio
│   │   ├── → /services/website-development (related)
│   │   ├── → /services/api-development (related)
│   │   ├── → /services/business-automation (related)
│   │   └── → /quote (CTA)
│   ├── /services/custom-software
│   │   ├── → /portfolio
│   │   ├── → /services/business-automation (related)
│   │   ├── → /services/api-development (related)
│   │   ├── → /services/laravel-development (related)
│   │   ├── → /services/ai-solutions (related)
│   │   └── → /quote (CTA)
│   └── (similar pattern for all services)
├── /packages → /quote, /services/*
├── /portfolio
│   ├── /portfolio/category/{slug}
│   └── /portfolio/{slug} → /services/* (related services), /quote
├── /faq → /services/*, /contact, /quote
├── /contact → /quote, /services/*
├── /blog/{article} → /services/* (pillar), /quote
└── /sitemap → all pages
```

### Anchor Text Patterns

**Natural, varied anchor text:**

| Pattern | Example |
|---------|---------|
| Branded | "SMEvolve web development services" |
| Descriptive | "our website development services" |
| Contextual | "learn more about how we build websites" |
| CTA-based | "get a free quote for your project" |
| Partial match | "our e-commerce development solutions" |
| URL-based | (naked URL in some contexts) |

**Do NOT:**
- Over-optimize with exact-match anchors
- Use "click here" repeatedly
- Force keyword-rich anchors in every link

### Cross-Linking Rules

1. Every service page links to 3-4 related services
2. Every blog article links to its pillar service page
3. Portfolio projects link to related service pages
4. FAQ answers link to relevant service pages
5. Homepage links to all service pages, portfolio, packages
6. Footer links to all 10 services
7. Breadcrumbs provide hierarchy links

---

## 14. Schema Strategy

### Current Schema Implementation

| Schema Type | Where | Status |
|-------------|-------|--------|
| Organization | Homepage | Implemented |
| WebSite | Homepage | Implemented |
| Service | Service detail pages | Implemented |
| ItemList | /services, /portfolio | Implemented |
| CreativeWork | Portfolio detail pages | Implemented |
| FAQPage | /faq, /contact | Implemented |
| ContactPage | /contact | Implemented |
| BreadcrumbList | Via `Breadcrumbs::schema()` | Available, used on some pages |

### Recommended Additional Schema

| Schema Type | Where | Priority | Reason |
|-------------|-------|----------|--------|
| LocalBusiness | Homepage, About | P0 | Critical for local SEO |
| BreadcrumbList | All service pages, portfolio pages | P0 | Helps Google understand hierarchy |
| FAQPage | All service pages (they have FAQs) | P1 | Rich results for service FAQs |
| Article | Blog articles (future) | P1 | Blog rich results |
| HowTo | Process sections | P2 | How-to rich results |
| AggregateRating | When reviews exist | P2 | Star ratings in search |

### Schema Implementation Rules

1. Only mark up content actually visible on the page
2. Never fabricate reviews or ratings
3. Never add schema for hidden content
4. Test all schema with Google Rich Results Test
5. Keep schema updated when content changes

---

## 15. Image SEO Strategy

### Current Image Implementation

| Area | Status | Detail |
|------|--------|--------|
| Alt attributes | Partial | `x-media.image` component exists, some images use descriptive alt |
| Filenames | Mixed | Some use descriptive names, some use hashes |
| Lazy loading | Implemented | Via `x-media.image` component |
| OG images | Implemented | Default `og-default.png` at 1200x630 |
| Image dimensions | Unknown | Needs audit |
| Compression | Unknown | Needs audit |

### Image SEO Rules

1. **Alt text:** Describe the actual image content. Do NOT keyword-stuff.
   - Good: "Screenshot of an e-commerce website built by SMEvolve"
   - Bad: "best web design company Lagos ecommerce website development"

2. **Filenames:** Use descriptive, hyphenated names
   - Good: `ecommerce-website-concept-clinic.jpg`
   - Bad: `IMG_20240101.jpg` or `image1.png`

3. **Compression:** Use WebP format where possible, compress to <200KB for most images

4. **Dimensions:** Specify width/height to prevent CLS

5. **Lazy loading:** Already implemented via component

6. **Portfolio images:** Each project screenshot should have descriptive alt text mentioning the project name and type

### Image SEO Checklist

- [ ] Audit all existing images for alt text quality
- [ ] Rename image files to descriptive names
- [ ] Ensure all images have width/height attributes
- [ ] Compress images to optimal size
- [ ] Use WebP format for new images
- [ ] Create OG images for each service page (not just default)
- [ ] Ensure portfolio images have descriptive alt text

---

## 16. Core Web Vitals Strategy

### Performance SEO Checklist

| Metric | Target | Current Status | Action |
|--------|--------|---------------|--------|
| **LCP** (Largest Contentful Paint) | < 2.5s | Unknown — needs audit | Audit hero image loading, font preload |
| **INP** (Interaction to Next Paint) | < 200ms | Unknown — needs audit | Audit Alpine.js interactions, chat widget |
| **CLS** (Cumulative Layout Shift) | < 0.1 | Unknown — needs audit | Ensure all images have dimensions |
| **TTFB** (Time to First Byte) | < 800ms | Likely good (Laravel + caching) | Verify with production metrics |

### Performance Recommendations

1. **Images:** Lazy load below-fold images, preload hero image
2. **Fonts:** Already preloading Inter font — good
3. **JavaScript:** Alpine.js is lightweight — verify no heavy JS added
4. **CSS:** Tailwind CSS purges unused styles — good
5. **Caching:** Sitemap cached, verify page caching is configured
6. **Mobile:** Responsive layout confirmed via viewport meta
7. **Chat Widget:** Load AI chat widget lazily (currently conditional — good)

### Do NOT

- Install unnecessary performance packages
- Add heavy JS libraries
- Use render-blocking resources
- Add third-party scripts without async/defer

---

## 17. Competitor Analysis

### Direct Competitors Researched

| # | Company | URL | Overlap | Threat Level |
|---|---------|-----|---------|-------------|
| 1 | CKDigital | ckdigital.com | Web design, e-commerce, SEO | Medium |
| 2 | Talosmart | talosmart.com | Web dev, mobile apps, 60+ services | Medium |
| 3 | Techsly | techsly.com.ng | Web design, SEO, Lagos-focused | Low |
| 4 | DientWeb | dientweb.net | Web dev, Laravel, custom software, mobile | **High** |
| 5 | WebDesigns.ng | webdesigns.ng | Web design, SEO, strong local SEO | Medium |
| 6 | Gsoft Interactive | gsoftinteractive.com | Custom software, AI, mobile apps | **High** |
| 7 | Techzoid Innovation | techzoidinnovation.com | Custom software, AI, automation, SaaS | **High** |

### Competitor Comparison

| Factor | CKDigital | Talosmart | Techsly | DientWeb | WebDesigns.ng | Gsoft | Techzoid |
|--------|-----------|-----------|---------|----------|---------------|-------|----------|
| Web Design | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ |
| E-Commerce | ✅ | ✅ | ✅ | ✅ | ✅ | ❌ | ❌ |
| Custom Software | ❌ | ✅ | ❌ | ✅ | ❌ | ✅ | ✅ |
| AI Chatbots | ❌ | ❌ | ❌ | ❌ | ❌ | ✅ | ✅ |
| Business Automation | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ✅ |
| Mobile Apps | ❌ | ✅ | ❌ | ✅ | ❌ | ✅ | ✅ |
| Laravel | ❌ | ❌ | ❌ | ✅ | ✅ | ✅ | ❌ |
| WordPress | ✅ | ✅ | ✅ | ✅ | ✅ | ❌ | ❌ |
| Blog | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ |
| Case Studies | ✅ | ✅ | ⚠️ | ✅ | ⚠️ | ✅ | ✅ |
| Schema | ✅ | ❌ | ❌ | ❌ | ✅ | ❌ | ❌ |
| Content Depth | Deep | Deep | Shallow | Deep | Very Deep | Deep | Very Deep |

---

## 18. Competitor Gap Analysis

| Competitor Advantage | SMEvolve Advantage | Competitor Weakness | SMEvolve Opportunity | Recommended Response |
|---------------------|-------------------|--------------------|--------------------|---------------------|
| CKDigital: Established brand since 2011, premium client portfolio | SMEvolve: AI + automation + full-stack (Laravel + WordPress) | CKDigital: No AI, no automation, blog appears dated | Position as the modern alternative with AI capabilities | Create AI-focused content CKDigital doesn't have |
| DientWeb: Strong local SEO, pricing transparency, Laravel focus | SMEvolve: Broader service range (AI + automation + mobile) | DientWeb: No AI, no business automation | Own the "AI + development" positioning in Lagos | Blog articles on AI for business |
| WebDesigns.ng: Best local SEO, exact-match domain, active blog | SMEvolve: Deeper technical services, AI capabilities | WebDesigns.ng: No custom software, no AI, no mobile apps | Target "AI chatbot Lagos", "business automation Lagos" keywords | Create content targeting AI keywords WebDesigns.ng doesn't cover |
| Techzoid: Strongest AI positioning, own SaaS products | SMEvolve: WordPress + Laravel + SME focus | Techzoid: Premium pricing, less local SEO focus | Target the SME segment Techzoid prices out | Create affordable package content for SMEs |
| Gsoft: AI + custom software, enterprise focus | SMEvolve: WordPress + broader SME focus | Gsoft: Less WordPress, smaller visible portfolio | Target SMEs who need WordPress + AI combination | Portfolio showcasing SME projects |
| Talosmart: Massive service breadth (60+ pages) | SMEvolve: Quality over quantity, AI differentiation | Talosmart: May lack depth per page, no AI | Create fewer, deeper, better-targeted pages | Focus on 10 excellent service pages vs 60 thin ones |

---

## 19. Backlink Strategy

### Legitimate Authority-Building Sources

| Source Type | Examples | Priority | Method |
|-------------|---------|----------|--------|
| Nigerian business directories | Nigeria Business Directory, VConnect, BusinessList.com.ng | P0 | Submit accurate NAP listing |
| Local business organizations | Lagos Chamber of Commerce, SMEDAN | P1 | Join and get listed |
| Technology communities | Laravel Nigeria, WordPress Lagos, Techpoint Africa | P1 | Contribute articles, get mentioned |
| Partner businesses | Hosting providers, designers, marketers | P1 | Mutual referrals, partner pages |
| Client websites | "Built by SMEvolve" footer links (with permission) | P0 | Request link from completed projects |
| Local publications | TechCabal, Nairametrics, BellaNaija | P2 | Digital PR, expert commentary |
| Industry associations | NIIT, Computer Village association | P2 | Membership listings |
| Case studies | Published on own blog, shared on LinkedIn | P1 | Create shareable content |
| Guest contributions | Write for tech blogs, business publications | P2 | Expert articles with author bio |

### What NOT to Do

- No paid spam links
- No PBNs (Private Blog Networks)
- No automated backlinks
- No link farms
- No comment spam
- No mass directory submissions
- No link exchanges at scale

---

## 20. Google Search Console Strategy

### Setup Requirements

1. Verify domain ownership via DNS TXT record
2. Submit sitemap: `https://smevolve.tech/sitemap.xml`
3. Set preferred domain: `https://smevolve.tech`

### Monitoring Workflow

| Area | What to Track | Frequency |
|------|--------------|-----------|
| **Indexed pages** | Pages indexed vs submitted | Weekly |
| **Excluded pages** | Why pages are excluded, fix issues | Weekly |
| **Sitemap status** | Errors, warnings, coverage | Weekly |
| **Queries** | Search terms driving impressions | Bi-weekly |
| **Impressions** | Growing impression count | Monthly |
| **Clicks** | Organic clicks to site | Monthly |
| **CTR** | Click-through rate by query | Monthly |
| **Average position** | Ranking changes over time | Monthly |
| **Core Web Vitals** | LCP, INP, CLS by URL | Monthly |
| **Page indexing** | Coverage issues | Weekly |
| **Manual actions** | Any penalties | Monthly |
| **Security issues** | Hacking, malware | Monthly |

### Key Metrics to Watch

- Which service pages get the most impressions
- Which queries have high impressions but low clicks (optimize titles/descriptions)
- Which pages rank on page 2-3 (quick wins to push to page 1)
- Local queries (Lagos, Nigeria) performance
- Brand search volume over time

---

## 21. SEO KPI Framework

### Technical KPIs

| KPI | Target | Measurement |
|-----|--------|-------------|
| Index coverage | 95%+ of target pages indexed | Search Console |
| Sitemap errors | 0 errors | Search Console |
| 404 errors | < 5/month | Search Console |
| Core Web Vitals | All "Good" | Search Console CWV report |
| Pages indexed | Growing month-over-month | Search Console |

### Content KPIs

| KPI | Target | Measurement |
|-----|--------|-------------|
| Organic impressions | +20% month-over-month | Search Console |
| Organic clicks | +15% month-over-month | Search Console |
| Keyword coverage | Ranking for 50+ target keywords | Search Console + Ahrefs/SEMrush |
| Ranking distribution | 10+ keywords on page 1 | Search Console |

### Service KPIs

| KPI | Target | Measurement |
|-----|--------|-------------|
| Organic visits to service pages | +25% month-over-month | Analytics |
| Quote conversions from organic | Track source/medium | Analytics + Quote system |
| Contact conversions from organic | Track source/medium | Analytics + Contact system |
| Portfolio visits from organic | Growing | Analytics |

### Blog KPIs

| KPI | Target | Measurement |
|-----|--------|-------------|
| Organic impressions per article | Growing after 3 months | Search Console |
| Clicks per article | Growing after 3 months | Search Console |
| Engagement time | > 2 minutes average | Analytics |
| Internal link clicks | Users clicking to service pages | Analytics events |

### Local KPIs

| KPI | Target | Measurement |
|-----|--------|-------------|
| Lagos-related queries | Growing | Search Console (filter by "Lagos") |
| Nigeria-related queries | Growing | Search Console (filter by "Nigeria") |
| Business Profile visibility | Impressions, actions | Google Business Profile insights |

---

## 22. Conversion Strategy

### Conversion Funnel

```
Search Query
→ Landing Page (service/blog/homepage)
→ Trust Signals (portfolio, FAQ, about)
→ CTA (quote/contact/WhatsApp)
→ Quote Wizard or Contact Form
→ Submission
→ Lead Notification
```

### CTA Strategy by Page

| Page | Primary CTA | Secondary CTA | Supporting CTA |
|------|-------------|---------------|----------------|
| Homepage | Get a Free Quote | View Our Services | Contact Us |
| Service pages | Get a Free Quote | View Our Portfolio | Book a Consultation |
| Blog articles | Get a Free Quote (contextual) | Related Service Page | Contact Us |
| Portfolio | Get a Free Quote | Contact Us | View Related Services |
| Packages | Start Quote Wizard | Talk to an Expert | Compare Packages |
| FAQ | Start Quote Wizard | Contact Our Team | View Services |
| Contact | Send Message | Chat on WhatsApp | Get a Free Quote |

### Quote Wizard CTA Optimization

The quote wizard is the primary conversion mechanism. It already has:
- `noindex, follow` (correct — not for search indexing)
- AI assistance for feature suggestions and description improvement
- Multi-step wizard with progress tracking
- Confirmation page with reference number

**Recommendations:**
1. Add tracking events for quote start, step completion, and submission
2. Track which service pages lead to quote submissions
3. Add a "Save and continue later" option (email-based)
4. Consider adding live chat/WhatsApp CTA on quote steps

---

## 23. AI-Search Visibility Strategy

### How AI Search Engines Understand SMEvolve

AI search systems (Google AI Overviews, ChatGPT, Perplexity, etc.) look for:
- Clear entity information (Organization schema, consistent NAP)
- Original, authoritative content
- Structured data that confirms facts
- Consistent information across sources
- First-hand project information
- Useful FAQs that directly answer questions

### SMEvolve's AI-Search Readiness

| Factor | Status | Action |
|--------|--------|--------|
| Organization schema | ✅ Present | Enhance with LocalBusiness, sameAs |
| Service pages | ✅ Rich content | Already excellent for AI comprehension |
| FAQs | ✅ Present on service pages | Add FAQPage schema to service pages |
| Structured data | ✅ Good coverage | Add LocalBusiness, BreadcrumbList |
| Consistent business info | ⚠️ Incomplete | Complete NAP, add social profiles |
| Original content | ✅ Unique per service | No generic AI filler |
| Author information | ❌ Missing | Add author/team info to blog |
| First-hand project info | ⚠️ Sample projects only | Add real case studies |

### AI-Search Optimization Rules

1. Write clear, factual content that directly answers questions
2. Use structured data to confirm key facts
3. Keep business information consistent everywhere
4. Create content that demonstrates first-hand experience
5. Include specific details (technologies used, process steps, outcomes)
6. Do NOT attempt to manipulate AI answers
7. Do NOT create content specifically for AI at the expense of humans

---

## 24. Recommended Sitemap Architecture

### Current Sitemap

Dynamically generated by `SitemapController` with caching.

### Recommended Future Sitemap

```
/sitemap.xml
├── Static routes
│   ├── / (home)
│   ├── /about
│   ├── /services (index)
│   ├── /packages
│   ├── /portfolio (index)
│   ├── /faq
│   ├── /contact
│   ├── /privacy-policy (ADD)
│   ├── /terms (ADD)
│   └── /cookies (ADD)
├── Service pages (dynamic)
│   ├── /services/website-development
│   ├── /services/ecommerce-development
│   ├── /services/custom-software
│   ├── /services/laravel-development
│   ├── /services/wordpress-development
│   ├── /services/mobile-app-development
│   ├── /services/ai-solutions
│   ├── /services/business-automation
│   ├── /services/api-development
│   └── /services/website-maintenance
├── Portfolio (dynamic)
│   ├── /portfolio/category/{slug} (with projects > 0)
│   └── /portfolio/{slug} (all published)
└── Blog (future, dynamic)
    └── /blog/{slug} (all published)
```

### Sitemap Rules

1. Only canonical, indexable, valuable URLs
2. No admin, API, search, password, quote wizard URLs
3. No duplicate URLs
4. No thin pages
5. Include `lastmod` for portfolio and blog articles
6. Do NOT include `changefreq` or `priority` (not useful)

---

## 25. Recommended Robots / Indexation Architecture

### Indexation Matrix

| URL Pattern | Index? | Follow? | Sitemap? | Canonical? | Reason |
|-------------|--------|---------|----------|------------|--------|
| `/` | YES | YES | YES | Self | Homepage — primary landing page |
| `/about` | YES | YES | YES | Self | Trust/authority page |
| `/services` | YES | YES | YES | Self | Service index page |
| `/services/*` | YES | YES | YES | Self | Individual service pages — commercial value |
| `/packages` | YES | YES | YES | Self | Pricing — commercial value |
| `/portfolio` | YES | YES | YES | Self | Portfolio index |
| `/portfolio/*` | YES | YES | YES | Self | Individual project pages |
| `/faq` | YES | YES | YES | Self | FAQ — trust and long-tail traffic |
| `/contact` | YES | YES | YES | Self | Contact — conversion page |
| `/privacy-policy` | YES | YES | YES (ADD) | Self | Legal trust page |
| `/terms` | YES | YES | YES (ADD) | Self | Legal trust page |
| `/cookies` | YES | YES | YES (ADD) | Self | Legal trust page |
| `/quote` | NO | YES | NO | Self | noindex — wizard, not for search |
| `/quote/*` | NO | YES | NO | Self | noindex — dynamic wizard steps |
| `/search` | NO | YES | NO | Self | noindex — internal search |
| `/admin/*` | NO | YES | NO | Self | Blocked in robots.txt — admin panel |
| `/api/*` | NO | YES | NO | Self | Blocked in robots.txt — API endpoints |
| `/password/*` | NO | YES | NO | Self | Auth flows |
| `/sitemap` | YES | YES | NO | Self | HTML sitemap for users |

### robots.txt Recommendation

Current robots.txt is correct. Consider adding:

```
Disallow: /quote/
```

But the current noindex meta tag approach is sufficient and preferred.

---

## 26. Implementation Roadmap

### Phase 1: Technical SEO Corrections
**Complexity:** Low | **Duration:** 1-2 days

- Complete company phone number in `config/company.php`
- Complete company address in `config/company.php`
- Add social media profile URLs to config
- Add `LocalBusiness` schema to homepage
- Add `sameAs` links to Organization schema
- Add legal pages to sitemap static routes
- Add breadcrumb schema to service pages
- Add FAQPage schema to service pages

### Phase 2: Homepage Optimization
**Complexity:** Low | **Duration:** 1 day

- Update homepage H1 and title tag
- Add local positioning section
- Enhance Organization/LocalBusiness schema
- Add Lagos map embed to contact page

### Phase 3: Core Service Landing Pages
**Complexity:** Low | **Duration:** 1-2 days

- Update meta titles with Lagos/Nigeria modifiers
- Update meta descriptions with local keywords
- Add BreadcrumbList schema to all service pages
- Add FAQPage schema to all service pages
- Ensure internal cross-links between related services

### Phase 4: Portfolio SEO
**Complexity:** Low | **Duration:** 1 day

- Add breadcrumb schema to portfolio pages
- Enhance portfolio meta titles/descriptions
- Add real portfolio projects as they become available
- Ensure portfolio projects link to service pages

### Phase 5: Local SEO
**Complexity:** Medium | **Duration:** 2-3 days

- Claim and optimize Google Business Profile
- Submit to Nigerian business directories
- Create NAP consistency across web
- Add local content mentions throughout site
- Create first local-focused blog articles

### Phase 6: Blog / Content System
**Complexity:** High | **Duration:** 5-7 days

- Design blog system (routes, controller, views, models)
- Create blog index page with categories
- Create blog article template with Article schema
- Create first 4 P0 blog articles
- Implement blog RSS feed

### Phase 7: Internal Linking
**Complexity:** Low | **Duration:** 1-2 days

- Audit existing internal links
- Add contextual internal links to service pages
- Add blog-to-service linking
- Add portfolio-to-service linking
- Verify footer links cover all services

### Phase 8: Schema Enhancements
**Complexity:** Low | **Duration:** 1 day

- Add HowTo schema to process sections (where applicable)
- Add Article schema to blog posts (future)
- Validate all schema with Google Rich Results Test
- Monitor for schema errors in Search Console

### Phase 9: Authority / Backlinks
**Complexity:** Medium | **Duration:** Ongoing

- Submit to Nigerian business directories
- Join Lagos business organizations
- Request client website links
- Create shareable content for link building
- Begin digital PR outreach

### Phase 10: SEO Monitoring
**Complexity:** Low | **Duration:** Ongoing

- Set up Google Search Console
- Set up Google Analytics 4
- Create monthly SEO reporting template
- Track KPIs defined in Section 21
- Monthly content performance review

---

## 27. Exact Pages That Should Be Created

### Immediate (Phase 1-3)

| Page | URL | Reason | Priority |
|------|-----|--------|----------|
| LocalBusiness schema | ( enhancement to `/`) | Critical for local SEO | P0 |
| Breadcrumb schema | All service pages | Helps Google understand hierarchy | P0 |
| FAQ schema | All service pages | Rich results opportunity | P1 |

### Short-Term (Phase 4-6)

| Page | URL | Reason | Priority |
|------|-----|--------|----------|
| Blog index | `/blog` | Content hub for SEO | P0 |
| Blog article template | `/blog/{slug}` | Article publishing system | P0 |
| Blog: Website cost Nigeria | `/blog/website-cost-nigeria` | High-value informational keyword | P0 |
| Blog: AI chatbot explained | `/blog/what-is-ai-chatbot` | AI keyword cluster | P0 |
| Blog: Choose web design Lagos | `/blog/choose-web-design-lagos` | Commercial investigation keyword | P0 |
| Blog: Custom vs off-the-shelf | `/blog/custom-vs-off-the-shelf-software` | Software keyword cluster | P1 |
| Blog: Sell online Nigeria | `/blog/sell-online-nigeria` | E-commerce keyword cluster | P1 |
| Blog: AI for small business | `/blog/ai-for-small-business` | AI keyword cluster | P1 |

### Medium-Term (Phase 7-10)

| Page | URL | Reason | Priority |
|------|-----|--------|----------|
| Blog: Laravel vs WordPress | /blog/laravel-vs-wordpress | Technology decision keyword | P1 |
| Blog: Small business website features | /blog/small-business-website-features | Informational keyword | P1 |
| Blog: Workflow automation guide | /blog/workflow-automation-guide | Automation keyword cluster | P1 |
| Blog: Website maintenance matters | /blog/website-maintenance-matters | Maintenance keyword cluster | P2 |
| Blog: Payment gateway Nigeria | /blog/payment-gateway-nigeria | E-commerce supporting | P2 |
| Blog: AI customer service Nigeria | /blog/ai-customer-service-nigeria | AI local keyword | P2 |

---

## 28. Pages That Should NOT Be Created

| Page | Reason |
|------|--------|
| `/locations/ikeja` | Fake location page — no unique content justification |
| `/locations/lekki` | Fake location page — no unique content justification |
| `/locations/yaba` | Fake location page — no unique content justification |
| `/locations/ikoyi` | Fake location page — no unique content justification |
| `/locations/victoria-island` | Fake location page — no unique content justification |
| `/services/web-design` | Cannibalizes `/services/website-development` — same intent |
| `/services/chatbot-development` | Cannibalizes `/services/ai-solutions` — chatbots are a feature, not separate service |
| `/services/seo` | SMEvolve does not offer SEO as a service — do not create a page for it |
| `/services/digital-marketing` | Not a current service offering |
| `/industries/` (individual pages) | Insufficient content to justify separate pages — use homepage industries section |
| `/pricing` | Already covered by `/packages` — do not duplicate |
| Thin SEO pages | Do not create pages with <300 words of unique content |
| Doorway pages | Do not create multiple pages targeting slight keyword variations |
| Fake testimonials page | Do not fabricate reviews |
| `/blog/category/` pages | Not needed initially — use tags or inline filtering |

---

## 29. Priority Ranking

### P0 — Critical (Implement First)

| Item | Phase | Complexity |
|------|-------|-----------|
| Complete business NAP (phone, address, social) | 1 | Low |
| Add LocalBusiness schema | 1 | Low |
| Add legal pages to sitemap | 1 | Low |
| Add breadcrumb schema to service pages | 1 | Low |
| Add FAQPage schema to service pages | 1 | Low |
| Update homepage H1/title | 2 | Low |
| Update service meta titles with Lagos/Nigeria | 3 | Low |
| Blog system design and build | 6 | High |
| First 4 blog articles (P0) | 6 | Medium |

### P1 — High (Implement Next)

| Item | Phase | Complexity |
|------|-------|-----------|
| Add breadcrumb schema to portfolio pages | 4 | Low |
| Google Business Profile setup | 5 | Medium |
| Nigerian directory submissions | 9 | Medium |
| Blog articles 5-8 | 6 | Medium |
| Internal linking audit and enhancement | 7 | Low |
| Portfolio meta title/description enhancement | 4 | Low |

### P2 — Medium (Implement After P0/P1)

| Item | Phase | Complexity |
|------|-------|-----------|
| Blog articles 9-12 | 6 | Medium |
| HowTo schema on process sections | 8 | Low |
| Local business organization memberships | 9 | Medium |
| Client website link requests | 9 | Low |
| Image SEO audit and optimization | 15 | Medium |
| Core Web Vitals audit | 16 | Medium |

### P3 — Later (Ongoing)

| Item | Phase | Complexity |
|------|-------|-----------|
| Digital PR outreach | 9 | High |
| Industry association memberships | 9 | Medium |
| Advanced schema (AggregateRating when reviews exist) | 8 | Low |
| International SEO (hreflang) | Future | High |
| Content expansion (50+ blog articles) | Ongoing | Medium |

---

## 30. Estimated Implementation Complexity

| Phase | Description | Complexity | Estimated Duration |
|-------|-------------|-----------|-------------------|
| Phase 1 | Technical SEO corrections | **Low** | 1-2 days |
| Phase 2 | Homepage optimization | **Low** | 1 day |
| Phase 3 | Core service landing pages | **Low** | 1-2 days |
| Phase 4 | Portfolio SEO | **Low** | 1 day |
| Phase 5 | Local SEO | **Medium** | 2-3 days |
| Phase 6 | Blog / content system | **High** | 5-7 days |
| Phase 7 | Internal linking | **Low** | 1-2 days |
| Phase 8 | Schema enhancements | **Low** | 1 day |
| Phase 9 | Authority / backlinks | **Medium** | Ongoing |
| Phase 10 | SEO monitoring | **Low** | Ongoing |

**Total estimated active implementation time:** 15-22 days  
**Ongoing work:** Content creation, link building, monitoring

---

## Summary

SMEvolve has a **strong technical SEO foundation** and **excellent service page content**. The primary gaps are:

1. **Incomplete business information** (phone, address, social profiles)
2. **Missing LocalBusiness schema**
3. **No blog/content system**
4. **Weak local SEO signals**
5. **No backlink strategy**
6. **No real portfolio projects** (only samples/concepts)

The competitive landscape shows that **AI chatbots and business automation are SMEvolve's biggest differentiators** — only 2 of 7 competitors offer these services. The recommended strategy is to own the "AI + web development for Lagos SMEs" positioning through targeted content and strong local SEO.

The service pages are already well-structured and need only metadata and schema enhancements. The blog system is the most complex addition but provides the highest long-term SEO value.

---

## RECOMMENDED NEXT IMPLEMENTATION PROMPT

**Phase 1: Technical SEO Corrections**

This is the smallest, most impactful change that should be implemented first:
- Complete business NAP in config
- Add LocalBusiness schema
- Add legal pages to sitemap
- Add breadcrumb schema to service pages
- Add FAQPage schema to service pages

**Estimated complexity:** Low  
**Estimated duration:** 1-2 days  
**Impact:** High — foundation for all subsequent SEO work

**Do not proceed to Phase 2 until Phase 1 is complete and verified.**
