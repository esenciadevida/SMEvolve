PROJECT: SMEvolve
DOMAIN: https://smevolve.tech
PROMPT: 032
TITLE: Technical SEO Corrections & Business Entity Foundation
ENVIRONMENT: Production

============================================================
1. OBJECTIVE
============================================================

Implement the first approved SEO phase from Prompt 031.

This phase focuses ONLY on:

- Correct business information
- Business entity consistency
- Organization schema improvements
- Service schema improvements
- Breadcrumb navigation/schema where appropriate
- FAQ schema where appropriate
- Legal-page sitemap/indexation review
- Service-page local relevance
- Sitemap refinement
- robots/indexation verification

DO NOT implement the full blog system.

DO NOT create location landing pages.

DO NOT create fake portfolio projects.

DO NOT create fake reviews.

DO NOT create a Google Business Profile.

DO NOT create social profiles.

DO NOT create backlinks.

DO NOT perform broad content rewriting.

DO NOT implement all future SEO phases.

============================================================
2. VERIFIED BUSINESS INFORMATION
============================================================

Use ONLY the following verified information:

Business name:

SMEvolve

Phone:

+2347041252965

Email:

hello@smevolve.tech

Website:

https://smevolve.tech

Business model:

ONLINE-ONLY DIGITAL BUSINESS

Physical office:

NONE

Primary market:

Lagos, Nigeria

Secondary market:

Nigeria

Social profiles:

NONE currently available

Google Business Profile:

NONE currently available

Do not invent any address.

Do not invent a street location.

Do not invent a postal address.

Do not invent coordinates.

Do not invent opening hours.

Do not invent social-media URLs.

Do not invent a Google Business Profile URL.

============================================================
3. IMPORTANT LOCAL SEO RULE
============================================================

SMEvolve does NOT currently operate from a publicly listed physical office.

Therefore:

DO NOT add a fake physical address.

DO NOT add a fake LocalBusiness address.

DO NOT create LocalBusiness structured data that implies SMEvolve has
a physical location when it does not.

DO NOT claim that customers can visit an SMEvolve office.

The local SEO strategy should instead communicate that SMEvolve provides
digital services to businesses in Lagos and across Nigeria.

============================================================
4. STRUCTURED DATA STRATEGY
============================================================

Review the existing Organization schema.

Maintain:

Organization

WebSite

Service

where appropriate.

Improve the Organization entity using verified information.

Potential properties include:

name

url

email

telephone

description

areaServed

sameAs ONLY when verified social profiles actually exist

Do NOT add:

streetAddress

postalCode

geo

openingHours

priceRange

fake reviews

aggregateRating

unless verified information genuinely becomes available.

============================================================
5. ORGANIZATION SCHEMA
============================================================

The Organization schema should represent:

SMEvolve

as an online digital solutions business.

Use:

name:
SMEvolve

url:
https://smevolve.tech

email:
hello@smevolve.tech

telephone:
+2347041252965

description:
A concise, accurate description based on the actual SMEvolve services.

areaServed:

Lagos, Nigeria

Nigeria

Do not represent Lagos as the company's physical address.

The schema should communicate SERVICE AREA rather than PHYSICAL LOCATION.

============================================================
6. SAMEAS
============================================================

There are currently no verified social-media profiles.

Therefore:

Do NOT include empty sameAs arrays if unnecessary.

Do NOT invent:

Facebook

Instagram

LinkedIn

X/Twitter

TikTok

YouTube

Google Business Profile

Do not create placeholder social URLs.

When verified profiles are created in the future, they can be added.

============================================================
7. BUSINESS INFORMATION CONSISTENCY
============================================================

Review the website for business contact information.

Ensure the following are consistent wherever the business contact
information is displayed:

SMEvolve

+2347041252965

hello@smevolve.tech

https://smevolve.tech

Do not place the phone number or email in irrelevant locations.

Use proper clickable links:

tel:+2347041252965

mailto:hello@smevolve.tech

where appropriate.

============================================================
8. FOOTER
============================================================

Review the website footer.

Ensure the footer contains appropriate business identity/contact information.

Suggested structure:

SMEvolve

Digital solutions for businesses and SMEs.

Lagos, Nigeria / Serving businesses across Nigeria

+2347041252965

hello@smevolve.tech

Do NOT write a physical address.

Do NOT imply there is an office customers can visit.

============================================================
9. CONTACT PAGE
============================================================

Review:

/contact

Ensure the page clearly communicates how customers can contact SMEvolve.

Include, where appropriate:

Phone

Email

Contact form

Service area

Response expectations if already supported

Do not invent office hours.

Do not invent a physical address.

============================================================
10. ABOUT PAGE
============================================================

Review:

/about

Ensure the page clearly explains:

Who SMEvolve is

What SMEvolve does

Who SMEvolve serves

Primary geographic market

Digital/online service model

Core services

Do not claim:

"based in Lagos"

unless this is factually correct and the business wants to state it.

It is acceptable to communicate:

"Serving businesses in Lagos and across Nigeria"

if accurate.

============================================================
11. SERVICE PAGE LOCAL SIGNALS
============================================================

Review all existing public service pages.

Improve geographic relevance naturally.

Where appropriate, communicate:

- Lagos businesses
- Nigerian SMEs
- Businesses across Nigeria

Do NOT insert "Lagos" into every heading.

Do NOT repeat:

"Web Design Lagos"

"Web Design Company Lagos"

in unnatural ways.

Local relevance must come from useful content and context.

============================================================
12. SERVICE SCHEMA
============================================================

Review existing Service structured data.

Ensure each Service schema:

- Matches the visible page
- Uses the correct service name
- Uses the correct URL
- Has an accurate description
- Does not contain fabricated information

Where appropriate, connect the service to the SMEvolve Organization entity.

Do not create Service schema for services that do not have corresponding
public content.

============================================================
13. BREADCRUMBS
============================================================

Determine whether breadcrumbs improve the user experience.

Recommended structure for deeper pages:

Home
→ Services
→ Website Development

or:

Home
→ Services
→ AI Solutions

If breadcrumbs are implemented:

1. They must be visibly rendered.
2. They must be clickable where appropriate.
3. BreadcrumbList structured data must match the visible breadcrumb.
4. URLs must be canonical.
5. Do not create breadcrumbs for pages where they add no value.

Do not add breadcrumb schema without visible breadcrumbs.

============================================================
14. FAQ SCHEMA
============================================================

Review existing FAQ content.

If the FAQ page contains genuine visible questions and answers,
determine whether FAQPage structured data is appropriate.

Only mark up content that is actually visible.

Do NOT create additional questions simply to increase schema.

Do NOT create hidden FAQ content.

Do NOT duplicate FAQ content across multiple pages.

============================================================
15. LEGAL PAGES
============================================================

Review existing:

/privacy

/terms

/cookies

Determine:

- Indexable or noindex
- Sitemap inclusion
- Canonical URL
- Navigation placement

Legal pages may remain indexable if they contain useful public legal
information, but do not force them into the sitemap solely for SEO.

The sitemap should prioritize meaningful public business pages.

Do not remove legal pages.

Do not rewrite legal policy content unless technically necessary.

============================================================
16. SITEMAP
============================================================

Review:

https://smevolve.tech/sitemap.xml

Ensure it contains only:

- Canonical URLs
- Public URLs
- Indexable URLs
- Useful pages

At minimum evaluate:

/

 /about

 /services

 /services/*

 /packages

 /portfolio

 /portfolio/*

 /faq

 /contact

Potentially:

/privacy

/terms

/cookies

depending on the final indexation strategy.

Do NOT include:

/admin/*

/api/*

/search

/password/*

/reset-password/*

quote wizard steps

temporary pages

duplicate pages

query-parameter URLs

non-canonical URLs

============================================================
17. QUOTE PAGE
============================================================

Review:

/quote

The quote wizard should remain:

noindex, follow

if that was the approved strategy from Prompt 030.

Do not add the individual wizard steps to the sitemap.

Do not change the quote functionality.

============================================================
18. SEARCH PAGE
============================================================

Review:

/search

Maintain:

noindex, follow

if already implemented.

Do not add search-result pages to the sitemap.

Do not attempt to rank internal search results.

============================================================
19. ADMIN
============================================================

Ensure:

/admin/*
/admin/login

remain excluded from search indexing.

Do not modify admin functionality.

Do not modify authentication.

Do not modify the admin dashboard.

============================================================
20. ROBOTS.TXT
============================================================

Review:

https://smevolve.tech/robots.txt

Ensure it correctly references:

Sitemap: https://smevolve.tech/sitemap.xml

Do not use robots.txt as a security mechanism.

Do not block assets required for rendering.

Do not unnecessarily block public pages.

============================================================
21. CANONICALS
============================================================

Review canonical URLs on all affected pages.

Ensure production canonical URLs use:

https://smevolve.tech

Never:

http://smevolve.tech

www.smevolve.tech

localhost

127.0.0.1

development URLs

Canonical URLs must match the sitemap URLs.

============================================================
22. META TITLES
============================================================

Review titles for:

Homepage

About

Services

Each important service page

Packages

Portfolio

FAQ

Contact

Do not rewrite every title unnecessarily.

Ensure each title:

- Is unique
- Describes the page
- Is relevant to search intent
- Uses natural language
- Does not keyword-stuff

============================================================
23. META DESCRIPTIONS
============================================================

Review descriptions.

Ensure they accurately communicate the page.

Do not use the same description everywhere.

Do not stuff geographic keywords.

============================================================
24. NAP TERMINOLOGY

IMPORTANT:

Traditional NAP means:

Name
Address
Phone

SMEvolve has no public physical address.

Therefore use an appropriate:

NAME + PHONE + EMAIL + WEBSITE + SERVICE AREA

entity-consistency model.

Do NOT fabricate an address simply because traditional local SEO
normally expects one.

============================================================
25. LOCALBUSINESS SCHEMA DECISION
============================================================

DO NOT implement LocalBusiness schema at this stage.

Reason:

SMEvolve is currently an online-only business without a public
physical office.

Use Organization structured data instead.

If SMEvolve obtains a legitimate public physical business location
in the future, revisit this decision.

Document this decision in the final report.

============================================================
26. GOOGLE BUSINESS PROFILE
============================================================

Do not create a Google Business Profile during this implementation.

Document:

"Not currently available."

If future business operations satisfy Google's eligibility requirements,
this can be reviewed separately.

Do not create a fake listing.

============================================================
27. SOCIAL PROFILES
============================================================

No verified social profiles currently exist.

Do not add social links to schema or footer.

Document:

"Not currently available."

Social profile integration can be added later.

============================================================
28. MOBILE
============================================================

Verify that any changes to:

Footer

Contact information

Breadcrumbs

SEO content

do not break mobile layouts.

============================================================
29. PERFORMANCE
============================================================

Do not add unnecessary JavaScript.

Breadcrumbs should be lightweight.

Structured data should not require additional client-side libraries.

============================================================
30. TESTING
============================================================

Run appropriate automated tests.

At minimum verify:

Homepage → 200

About → 200

Services → 200

Packages → 200

Portfolio → 200

FAQ → 200

Contact → 200

Quote → expected response

Sitemap → 200

robots.txt → 200

Privacy → expected response

Terms → expected response

Cookies → expected response

Admin login → expected response

Search → expected response

============================================================
31. SEO TESTS
============================================================

Verify:

Organization schema valid

WebSite schema valid

Service schema valid

Breadcrumb schema valid where implemented

FAQ schema valid where implemented

Canonical URLs valid

No localhost URLs

No fake social URLs

No fake addresses

No placeholder phone number

Correct phone:

+2347041252965

Correct email:

hello@smevolve.tech

============================================================
32. SITEMAP TESTS
============================================================

Verify:

No duplicate URLs

No admin URLs

No API URLs

No search URLs

No password URLs

No quote wizard step URLs

No localhost URLs

No HTTP URLs

No non-canonical URLs

No fake pages

============================================================
33. GOOGLE SEARCH CONSOLE
============================================================

Do not claim that pages are indexed.

Do not claim ranking improvements.

Do not claim Search Console access unless actually available.

Provide the final sitemap URL:

https://smevolve.tech/sitemap.xml

for later manual submission/verification.

============================================================
34. GIT SECURITY
============================================================

Ensure no:

.env

SMTP credentials

API keys

database credentials

backup files

SQL dumps

private credentials

are committed.

============================================================
35. IMPLEMENTATION LIMITS
============================================================

This prompt must NOT:

- Build a blog
- Build location pages
- Create social accounts
- Create Google Business Profile
- Create backlinks
- Create fake reviews
- Create fake portfolio projects
- Rewrite the entire website
- Install SEO packages unnecessarily
- Install a WordPress SEO plugin
- Change SMTP
- Change AI
- Change Redis
- Change AWS
- Redesign the Admin Dashboard

============================================================
36. FINAL REPORT
============================================================

Return:

SMEvolve Prompt 032 Implementation Report

BUSINESS ENTITY
----------------

Business name:
PASS

Phone:
PASS

Email:
PASS

Physical address:
NONE — ONLINE ONLY

Service area:
Lagos, Nigeria
Nigeria


STRUCTURED DATA
----------------

Organization:
PASS / FAIL

WebSite:
PASS / FAIL

Service:
PASS / FAIL

LocalBusiness:
NOT IMPLEMENTED — INTENTIONAL

BreadcrumbList:
PASS / FAIL / NOT APPLICABLE

FAQPage:
PASS / FAIL / NOT APPLICABLE


SEO
----------------

Canonical:
PASS / FAIL

Meta titles:
PASS / FAIL

Meta descriptions:
PASS / FAIL

Sitemap:
PASS / FAIL

robots.txt:
PASS / FAIL

Indexation:
PASS / FAIL


CONTACT
----------------

Phone:
+2347041252965

Email:
hello@smevolve.tech


SOCIAL
----------------

Google Business Profile:
NOT AVAILABLE

Facebook:
NOT AVAILABLE

Instagram:
NOT AVAILABLE

LinkedIn:
NOT AVAILABLE

X/Twitter:
NOT AVAILABLE


TESTING
----------------

Tests:
[NUMBER]

Assertions:
[NUMBER]

Failures:
[NUMBER]


FILES CHANGED
----------------

[List exact files]


GIT
----------------

Commit:
[HASH]


MANUAL ACTIONS
----------------

[List]


============================================================
37. FINAL RULE
============================================================

Do not claim SMEvolve has a physical Lagos office.

Do not add a fake Lagos address.

Do not use LocalBusiness schema merely because the business wants
to rank in Lagos.

Use accurate service-area positioning.

The objective is sustainable SEO based on accurate business information,
not manipulating Google's local results.

============================================================
38. NEXT PHASE
============================================================

At the end of the report, recommend ONLY the next implementation phase.

Do not implement the next phase.

The expected next major phase after this one is:

CORE SERVICE SEO LANDING PAGES

However, only recommend this if Prompt 032 confirms that the technical
SEO foundation is functioning correctly.