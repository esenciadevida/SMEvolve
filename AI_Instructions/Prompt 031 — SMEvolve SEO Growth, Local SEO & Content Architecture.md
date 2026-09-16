PROJECT: SMEvolve
DOMAIN: https://smevolve.tech
ENVIRONMENT: Production
PROMPT: 031
TITLE: SEO Growth, Local SEO & Content Architecture
MODE: RESEARCH + ARCHITECTURE ONLY

============================================================
1. OBJECTIVE
============================================================

The objective of this prompt is to create a serious, long-term SEO strategy
for SMEvolve.

SMEvolve is a digital solutions company targeting SMEs and businesses,
primarily in Lagos and Nigeria.

Current core services include areas such as:

- Website Development
- E-commerce Development
- Custom Software Development
- Laravel Development
- WordPress Development
- Mobile App Development
- AI Solutions
- AI Chatbots
- Business Automation
- API / Digital Solutions
- Website Maintenance

The goal is to increase SMEvolve's organic visibility and eventually rank
for commercially valuable searches related to these services.

IMPORTANT:

This prompt is RESEARCH + ARCHITECTURE ONLY.

DO NOT immediately implement all recommendations.

DO NOT create dozens of pages.

DO NOT create thin SEO pages.

DO NOT keyword-stuff existing pages.

DO NOT create fake locations.

DO NOT create fake reviews.

DO NOT invent clients.

DO NOT invent statistics.

DO NOT make unsupported "best", "number one", "leading", "award-winning"
or similar claims.

The output of this prompt will become the blueprint for subsequent
implementation prompts.

============================================================
2. PRIMARY SEO GOAL
============================================================

Build SMEvolve into a recognizable search entity around:

PRIMARY MARKET:

Lagos, Nigeria

SECONDARY MARKET:

Nigeria

POTENTIAL FUTURE MARKET:

International clients, only where justified by actual business strategy.

The SEO strategy should focus primarily on commercial and informational
search intent.

The strategy should NOT attempt to rank SMEvolve for every possible
technology keyword.

Focus on terms that can realistically produce:

- Leads
- Quote requests
- Contact submissions
- Business inquiries
- Portfolio visits
- Service-page traffic

============================================================
3. CURRENT PROBLEM
============================================================

Google currently understands SMEvolve generally as a digital-solutions
business.

However, the website does not yet have enough clearly separated topical
authority around its individual commercial services.

The current search presentation is broadly similar to:

"SMEvolve – Digital Solutions for SMEs in Lagos, Nigeria"

with a description around:

"We design high-performing websites, AI chatbots, and automation systems
that help businesses grow, scale, and operate smarter."

This is a reasonable starting point, but the objective is to make Google's
understanding of SMEvolve much more specific.

We want Google to clearly understand:

SMEvolve
→ Digital solutions company
→ Lagos/Nigeria
→ SME-focused
→ Website development
→ Web design
→ E-commerce
→ AI chatbots
→ Business automation
→ Custom software
→ Related digital services

============================================================
4. FIRST TASK — AUDIT THE EXISTING WEBSITE
============================================================

Before recommending anything, inspect the existing application and website.

Audit:

- Homepage
- About
- Services
- Packages
- Portfolio
- FAQ
- Contact
- Quote
- Existing individual service routes
- Existing portfolio routes
- Existing metadata
- Existing sitemap
- robots.txt
- canonical URLs
- structured data
- internal links
- headings
- images
- alt attributes
- page titles
- meta descriptions
- Open Graph
- Twitter/X metadata
- indexability
- noindex directives
- redirects
- broken links
- duplicate content
- thin content
- orphan pages
- pagination if present
- query parameters
- search pages
- quote wizard
- admin pages

Do not assume the current architecture.

Inspect the actual Laravel routes and Blade views.

============================================================
5. TECHNICAL SEO BASELINE
============================================================

Review the work already completed by Prompt 030.

Expected infrastructure includes:

/sitemap.xml

/robots.txt

canonical URLs

Open Graph

Twitter/X metadata

Organization schema

WebSite schema

HSTS

security headers

search noindex

quote wizard noindex

Verify the SEO architecture rather than rebuilding it.

Report:

PASS
WARNING
FAIL

for each area.

Do not make unnecessary technical changes.

============================================================
6. SITEMAP STRATEGY
============================================================

The existing sitemap should be treated as the foundation.

Do NOT simply add every URL to the sitemap.

Design a future sitemap architecture based on:

1. Core commercial pages
2. Service pages
3. Portfolio pages
4. Educational/resource pages
5. Location pages only when genuinely useful

The sitemap should contain only canonical,
indexable, valuable URLs.

Do NOT include:

/admin/*
/api/*
/search
/password/*
/reset-password/*
quote wizard steps
private pages
duplicate URLs
tracking URLs
temporary URLs
thin pages

============================================================
7. KEYWORD RESEARCH
============================================================

Create a keyword research matrix.

Research keyword opportunities around:

WEB DESIGN

WEB DEVELOPMENT

WEBSITE DEVELOPMENT

E-COMMERCE

CUSTOM SOFTWARE

AI CHATBOTS

ARTIFICIAL INTELLIGENCE FOR BUSINESS

BUSINESS AUTOMATION

MOBILE APP DEVELOPMENT

LARAVEL DEVELOPMENT

WORDPRESS DEVELOPMENT

WEBSITE MAINTENANCE

DIGITAL SOLUTIONS

For each keyword/topic determine:

- Primary keyword
- Secondary keywords
- Search intent
- Commercial value
- Geographic relevance
- Recommended page
- Difficulty estimate
- Current SMEvolve ranking if available
- Current SMEvolve page targeting it
- Recommended priority
- Content type

Do not fabricate exact search-volume numbers.

If reliable search-volume data is unavailable,
label the value:

"Not verified"

rather than inventing a number.

============================================================
8. SEARCH INTENT
============================================================

Classify keywords as:

INFORMATIONAL

COMMERCIAL INVESTIGATION

TRANSACTIONAL

NAVIGATIONAL

LOCAL

For example:

"what is an AI chatbot"
→ informational

"best web design company in Lagos"
→ commercial investigation

"web design company Lagos"
→ transactional/local

"SMEvolve"
→ navigational

Prioritize commercial and local-commercial opportunities.

============================================================
9. PRIMARY KEYWORD CLUSTERS
============================================================

Develop clusters around:

CLUSTER A — WEB DESIGN

Examples:

web design company Lagos
web design company Nigeria
website design Lagos
business website design Lagos
SME website design Lagos

CLUSTER B — WEB DEVELOPMENT

web development company Lagos
website development company Lagos
web development company Nigeria
custom website development Lagos

CLUSTER C — E-COMMERCE

ecommerce website development Lagos
ecommerce website design Nigeria
online store development Nigeria
ecommerce development company Lagos

CLUSTER D — AI

AI chatbot development Lagos
AI chatbot for businesses Nigeria
AI solutions for SMEs
AI automation Nigeria
business AI solutions Lagos

CLUSTER E — BUSINESS AUTOMATION

business automation Lagos
business automation Nigeria
SME automation Nigeria
workflow automation Lagos

CLUSTER F — CUSTOM SOFTWARE

custom software development Lagos
software development company Lagos
business software development Nigeria
custom business applications Nigeria

CLUSTER G — MOBILE

mobile app development Lagos
mobile app development Nigeria
business app development Nigeria

CLUSTER H — WEBSITE MAINTENANCE

website maintenance Lagos
website support Nigeria
website management Nigeria

Do not assume every cluster deserves its own page.

Determine which clusters have sufficient business value and content
differentiation.

============================================================
10. KEYWORD CANNIBALIZATION
============================================================

Identify cases where multiple pages would compete for the same keyword.

For example:

/services

/services/website-development

/services/web-design

/packages

/blog/web-design-lagos

Do not create multiple pages targeting the exact same intent without
a strong reason.

Create a keyword-to-URL ownership map.

Every important keyword cluster should have ONE primary target page.

============================================================
11. PROPOSED SITE ARCHITECTURE
============================================================

Develop a recommended architecture.

Potential structure:

/

 /about

 /services

 /services/website-development

 /services/ecommerce-development

 /services/custom-software-development

 /services/ai-solutions

 /services/business-automation

 /services/mobile-app-development

 /services/wordpress-development

 /services/laravel-development

 /services/website-maintenance

 /packages

 /portfolio

 /faq

 /contact

 /quote

 /blog

 /blog/[article]

Do NOT automatically implement all of these.

For every proposed page provide:

- URL
- Page title
- Primary keyword
- Search intent
- Purpose
- Recommended H1
- Supporting topics
- Internal links
- Priority
- Whether page should be created now/later/not at all

============================================================
12. SERVICE PAGE STRATEGY
============================================================

Determine which existing services deserve dedicated SEO landing pages.

A dedicated service page must provide substantial value.

Minimum recommended structure:

H1

Introduction

What the service is

Who it is for

Problems it solves

What SMEvolve provides

Features/capabilities

Process

Benefits

Relevant portfolio examples

Packages/pricing where appropriate

FAQs

CTA

Related services

Contact/quote CTA

Do not duplicate the same text across service pages.

============================================================
13. HOMEPAGE SEO
============================================================

Analyze the current homepage.

Create a recommended SEO structure.

The homepage should clearly communicate:

WHO SMEvolve IS

WHERE SMEvolve OPERATES

WHAT SMEvolve DOES

WHO SMEvolve SERVES

WHY A CUSTOMER SHOULD CONTACT SMEvolve

Consider a positioning such as:

"Web Design, AI & Business Automation for SMEs in Lagos"

but do not blindly use this exact wording.

Provide 3-5 alternative H1/title strategies.

Select one recommended version and explain why.

============================================================
14. LOCAL SEO
============================================================

Create a Lagos/Nigeria local SEO strategy.

Primary geographic target:

Lagos, Nigeria

Secondary:

Nigeria

Do NOT create fake location pages for every Lagos neighborhood.

Do NOT create:

/locations/ikeja
/locations/lekki
/locations/yaba
/locations/ikoyi

unless there is genuine unique content and a legitimate business reason.

Instead determine whether SMEvolve should initially use:

- Lagos service pages
- Nigeria service pages
- One strong Lagos location/about section
- Google Business Profile
- LocalBusiness/Organization schema
- Local citations
- Relevant local backlinks
- Local portfolio/case studies
- Lagos-specific content

============================================================
15. GOOGLE BUSINESS PROFILE
============================================================

Assess whether SMEvolve should have or optimize a Google Business Profile.

Provide:

- Recommended business category
- Business description strategy
- Service categories
- Website URL
- Contact consistency
- Photo strategy
- Review strategy
- Posting strategy

Do not create or claim a Google Business Profile.

This is a future manual action unless an approved integration exists.

============================================================
16. LOCAL BUSINESS ENTITY CONSISTENCY
============================================================

Identify the information that must remain consistent across the web:

Business name

Website

Email

Phone

Business location

Service descriptions

Do not invent missing information.

Create an NAP consistency checklist.

============================================================
17. CONTENT / BLOG STRATEGY
============================================================

Design a content strategy that supports commercial pages.

Do NOT create random blog topics.

Each article must support a service or keyword cluster.

Create content clusters.

Example:

PILLAR:

Web Design for SMEs in Nigeria

SUPPORTING ARTICLES:

How much does a business website cost in Nigeria?

How to choose a web design company in Lagos

What should a small business website contain?

Website vs social media for Nigerian businesses

How long does it take to build a business website?

Each supporting article should link to the relevant commercial page.

============================================================
18. CONTENT PRIORITY
============================================================

Rank proposed articles:

P0 = Critical

P1 = High

P2 = Medium

P3 = Later

Prioritize articles with:

- strong commercial relevance
- realistic ranking potential
- clear user intent
- ability to link to a service
- Nigerian/Lagos relevance where appropriate

============================================================
19. CONTENT QUALITY RULES
============================================================

Every future article must:

- Provide original value
- Answer the actual query
- Use clear headings
- Include relevant examples
- Avoid keyword stuffing
- Avoid generic AI-generated filler
- Include internal links
- Include a useful CTA where appropriate
- Have an author/date policy
- Be factually reviewed

Do not publish AI-generated content automatically.

============================================================
20. E-E-A-T / TRUST
============================================================

Develop a strategy to strengthen trust.

Identify opportunities for:

- About page depth
- Team information
- Company information
- Portfolio
- Case studies
- Client results where verifiable
- Contact information
- Business location
- Author information
- Project methodology
- Security information
- Privacy/legal pages

Do not fabricate testimonials or results.

============================================================
21. PORTFOLIO SEO
============================================================

Audit the existing portfolio.

Determine whether projects should have individual public pages.

If yes, recommend:

/portfolio/project-name

Each project page should potentially contain:

Project name

Client/business type

Industry

Challenge

Solution

Technology

Features

Outcome

Screenshots

Relevant service

CTA

Do not expose confidential client information.

Do not invent results.

============================================================
22. INTERNAL LINKING
============================================================

Create an internal linking architecture.

Example:

Homepage
→ Services

Services
→ Website Development

Website Development
→ Portfolio

Portfolio
→ Quote

Blog article
→ Service page

Service page
→ Related service

About
→ Services

FAQ
→ Services

Contact
→ Quote

Create recommended anchor-text patterns.

Do not over-optimize anchors.

============================================================
23. BREADCRUMBS
============================================================

Determine whether breadcrumbs should be introduced for:

Service pages

Blog articles

Portfolio detail pages

Location pages

If useful, recommend:

Home
→ Services
→ Website Development

Do not implement yet.

============================================================
24. STRUCTURED DATA STRATEGY
============================================================

Audit existing:

Organization

WebSite

structured data.

Determine whether additional schema is appropriate:

Service

BreadcrumbList

Article

FAQPage

LocalBusiness

Portfolio/project-related schema if appropriate

Do not add schema simply for the sake of adding schema.

Only mark up content actually visible on the page.

============================================================
25. IMAGE SEO
============================================================

Audit:

alt attributes

filenames

image dimensions

compression

lazy loading

Open Graph images

portfolio images

service images

Create an image SEO strategy.

Do not add keyword-stuffed alt text.

Alt text should describe the actual image.

============================================================
26. CORE WEB VITALS
============================================================

Create a performance SEO checklist covering:

LCP

INP

CLS

TTFB

image optimization

font loading

JavaScript

CSS

caching

mobile performance

Do not introduce unnecessary dependencies.

============================================================
27. MOBILE SEO
============================================================

Audit mobile usability.

Check:

- responsive layout
- tap targets
- navigation
- forms
- quote wizard
- chatbot
- page speed
- readable typography

============================================================
28. INDEXATION STRATEGY
============================================================

Create an indexation matrix:

URL pattern

Index?

Follow?

Sitemap?

Canonical?

Reason

Include at minimum:

/

 /about

 /services

 /services/*

 /packages

 /portfolio

 /portfolio/*

 /faq

 /contact

 /quote

 /search

 /admin/*

 /api/*

 /password/*

============================================================
29. SEARCH CONSOLE STRATEGY
============================================================

Define the Google Search Console workflow.

Track:

Indexed pages

Excluded pages

Sitemap status

Queries

Impressions

Clicks

CTR

Average position

Core Web Vitals

Page indexing

Manual actions

Security issues

Do not claim access to Search Console unless credentials are available.

============================================================
30. SEO KPI FRAMEWORK
============================================================

Define measurable KPIs.

TECHNICAL:

Index coverage

Sitemap errors

404 errors

Core Web Vitals

Pages indexed

CONTENT:

Organic impressions

Organic clicks

Keyword coverage

Ranking distribution

SERVICE:

Organic visits to service pages

Quote conversions

Contact conversions

Portfolio visits

BLOG:

Organic impressions

Clicks

Engagement

Internal-link clicks

LOCAL:

Lagos-related queries

Nigeria-related queries

Business Profile visibility if available

============================================================
31. CONVERSION SEO
============================================================

SEO should not only generate traffic.

Analyze:

Quote CTA

Contact CTA

WhatsApp if present

Call CTA

Email CTA

Service CTA

Portfolio CTA

The strategy should connect:

Search
→ Landing page
→ Trust
→ Portfolio
→ CTA
→ Quote/contact

============================================================
32. COMPETITOR RESEARCH
============================================================

Research at least 5 relevant Nigerian/Lagos competitors.

Compare:

Homepage positioning

Title tags

H1

Service architecture

Local targeting

Blog strategy

Internal links

Backlinks if reliable data is available

Schema

Portfolio

Pricing

CTAs

Content depth

Technical SEO

Do not copy competitors.

Identify gaps SMEvolve can exploit.

============================================================
33. COMPETITOR GAP ANALYSIS
============================================================

Create:

Competitor advantage

SMEvolve advantage

Competitor weakness

SMEvolve opportunity

Recommended response

Focus on opportunities that SMEvolve can realistically execute.

============================================================
34. BACKLINK STRATEGY
============================================================

Create a legitimate authority-building strategy.

Potential sources:

Nigerian business directories

Local business organizations

Industry associations

Technology communities

Partner businesses

Client websites where appropriate

Local publications

Relevant guest contributions

Case studies

Digital PR

Do NOT recommend:

paid spam links

PBNs

automated backlinks

link farms

comment spam

mass directory submissions

============================================================
35. BRAND SEARCH
============================================================

Develop a strategy to strengthen searches for:

SMEvolve

SMEvolve Lagos

SMEvolve Nigeria

SMEvolve digital solutions

Ensure the brand has consistent identity across:

Website

Social profiles

Business listings

Directories

Portfolio mentions

Do not create fake profiles.

============================================================
36. AI SEARCH / ANSWER ENGINE VISIBILITY
============================================================

Do not optimize solely for traditional Google rankings.

Consider how SMEvolve can become a reliable source for:

AI search systems

Google AI features

Chat-based search

Answer engines

The strategy should focus on:

Clear entity information

Strong service pages

Original content

Structured data

Authoritative references

Consistent business information

Useful FAQs

First-hand project information

Do not attempt to manipulate AI answers.

============================================================
37. CONTENT CALENDAR
============================================================

Create a proposed 90-day SEO content calendar.

Include:

Week

Content title

Target keyword

Search intent

Target page

Content type

Priority

Internal links

CTA

Expected business purpose

Do not automatically publish anything.

============================================================
38. IMPLEMENTATION ROADMAP
============================================================

Divide the eventual implementation into phases.

PHASE 1

Technical SEO corrections

PHASE 2

Homepage optimization

PHASE 3

Core service landing pages

PHASE 4

Portfolio SEO

PHASE 5

Local SEO

PHASE 6

Blog/content system

PHASE 7

Internal linking

PHASE 8

Schema enhancements

PHASE 9

Authority/backlinks

PHASE 10

SEO monitoring

Each phase should become a separate implementation prompt.

============================================================
39. DO NOT IMPLEMENT YET
============================================================

This prompt must NOT:

- create all service pages
- create all blog posts
- create fake location pages
- rewrite the entire website
- change the database unnecessarily
- install SEO packages unnecessarily
- install SEO plugins
- create fake reviews
- create fake backlinks
- change production DNS
- change SMTP
- change AI
- change the admin dashboard

The output is the blueprint.

============================================================
40. REQUIRED FINAL DELIVERABLE
============================================================

Return a comprehensive:

SMEvolve SEO Growth & Content Architecture Report

Include:

1. Current SEO score/baseline

2. Technical SEO findings

3. Current indexed-page strategy

4. Keyword research matrix

5. Keyword clusters

6. Keyword-to-URL ownership map

7. Homepage SEO recommendation

8. Service-page recommendations

9. Portfolio recommendations

10. Local SEO strategy

11. Blog/content clusters

12. 90-day content calendar

13. Internal linking architecture

14. Schema strategy

15. Image SEO strategy

16. Core Web Vitals strategy

17. Competitor analysis

18. Competitor gap analysis

19. Backlink strategy

20. Google Search Console strategy

21. SEO KPI framework

22. Conversion strategy

23. AI-search visibility strategy

24. Recommended sitemap architecture

25. Recommended robots/indexation architecture

26. Implementation roadmap

27. Exact pages that should be created

28. Pages that should NOT be created

29. Priority ranking:

P0
P1
P2
P3

30. Estimated implementation complexity:

Low
Medium
High

============================================================
41. CRITICAL FINAL RULE
============================================================

Do not give generic SEO advice.

Every recommendation must be connected to SMEvolve's actual:

- Website
- Services
- Target market
- Lagos/Nigeria positioning
- Existing routes
- Existing content
- Existing portfolio
- Existing technical implementation

Inspect the actual codebase before making architecture decisions.

Do not fabricate search volume.

Do not fabricate rankings.

Do not fabricate competitor statistics.

Do not fabricate backlinks.

Do not fabricate business information.

If information cannot be verified, explicitly state:

"Not verified"

============================================================
42. OUTPUT FORMAT
============================================================

End the report with:

RECOMMENDED NEXT IMPLEMENTATION PROMPT

Provide ONLY the next phase that should be implemented first.

Do not implement it.

Do not generate the next prompt automatically.

Wait for approval before proceeding.