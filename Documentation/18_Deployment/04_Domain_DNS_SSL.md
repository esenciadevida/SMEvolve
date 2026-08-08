# SMEvolve Deployment

## 04 – Domain, DNS & SSL Configuration

**Project:** SMEvolve

**Module:** Deployment

**Documentation Path:** `Documentation/18_Deployment/`

**Framework:** Laravel 12

**Source Control:** GitHub

**Production Hosting:** Hostinger

**Document Version:** 1.0

**Status:** Draft

---

# 1. Purpose

This document defines the domain, DNS, HTTPS, and SSL requirements for deploying SMEvolve to production.

It covers:

* Production domain configuration.
* DNS records.
* Hostinger domain configuration.
* SSL certificate.
* HTTPS enforcement.
* Email-related DNS records.
* SPF.
* DKIM.
* DMARC.
* Canonical domain configuration.
* Redirects.
* DNS verification.
* SSL verification.

The objective is to ensure that SMEvolve is securely accessible through its official production domain and that related services such as email and analytics can operate correctly.

---

# 2. Domain Architecture

The production architecture should use the official SMEvolve domain.

Conceptually:

```text
https://www.example.com
          │
          ▼
       Hostinger
          │
          ▼
     SMEvolve Laravel
```

The actual SMEvolve domain will be inserted during production configuration.

---

# 3. Canonical Domain

SMEvolve must have one canonical public domain.

For example:

```text
https://example.com
```

or:

```text
https://www.example.com
```

The project must select one canonical version and redirect the alternative.

For example, if the canonical domain is:

```text
https://example.com
```

then:

```text
http://example.com
http://www.example.com
https://www.example.com
```

should redirect appropriately to:

```text
https://example.com
```

The final canonical domain must be consistent across:

* Laravel.
* SEO metadata.
* Sitemap.
* Canonical URLs.
* Google Analytics.
* Search Console.
* Email links.
* Social sharing metadata.

---

# 4. DNS Provider

The DNS provider may be:

* Hostinger.
* The domain registrar.
* Cloudflare.
* Another approved DNS provider.

The DNS provider must be identified before production deployment.

Only one authoritative DNS configuration should be maintained.

---

# 5. DNS Records

The production domain may require records such as:

```text
A
AAAA
CNAME
MX
TXT
```

Only records actually required by the infrastructure should be created.

Avoid unnecessary DNS records.

---

# 6. A Record

The primary domain should resolve to the production hosting environment.

Conceptually:

```text
example.com
      ↓
A
      ↓
Hostinger Server IP
```

The actual IP address must be obtained from the Hostinger environment.

Do not place a placeholder IP into production DNS.

---

# 7. WWW Configuration

If the canonical domain is the root domain:

```text
example.com
```

the `www` hostname may use:

```text
www.example.com
      ↓
CNAME
      ↓
example.com
```

The exact configuration depends on Hostinger's recommended DNS setup.

---

# 8. Subdomains

Subdomains should only be created when required.

Possible future examples:

```text
www.example.com
admin.example.com
api.example.com
staging.example.com
```

The current SMEvolve architecture should avoid unnecessary subdomains.

If the Admin Portal is part of the main Laravel application, it should normally remain under the main application domain unless there is a specific architectural reason to separate it.

---

# 9. Staging Environment

If a staging environment is introduced, it should use a separate hostname.

Example:

```text
staging.example.com
```

The staging environment must never use production credentials or production customer data unless explicitly authorized and secured.

---

# 10. DNS Propagation

DNS changes may take time to propagate.

After making changes, verify the records from multiple locations where practical.

Do not assume that a DNS change is immediately visible everywhere.

---

# 11. DNS Verification

Before production deployment, verify:

```text
✓ Root domain resolves
✓ WWW hostname resolves if used
✓ Correct IP/CNAME is returned
✓ No conflicting records exist
✓ DNS changes have propagated
```

The exact DNS values must be confirmed against Hostinger.

---

# 12. SSL Certificate

SMEvolve production traffic must use a valid SSL/TLS certificate.

The certificate should cover the canonical production domain and any required hostname such as:

```text
example.com
www.example.com
```

The certificate should be issued and managed through Hostinger or the selected certificate provider.

---

# 13. HTTPS

All production traffic must use:

```text
https://
```

The application should not rely on plain HTTP for normal public access.

---

# 14. HTTP to HTTPS Redirect

HTTP requests should redirect to HTTPS.

Example:

```text
http://example.com
        ↓
https://example.com
```

The redirect should use a permanent redirect where appropriate.

---

# 15. WWW to Non-WWW Redirect

If the canonical domain is non-WWW:

```text
https://www.example.com
        ↓
https://example.com
```

If the canonical domain is WWW:

```text
https://example.com
        ↓
https://www.example.com
```

Only one canonical hostname should remain indexable.

---

# 16. Laravel URL Configuration

The production environment must use the canonical HTTPS URL.

Example:

```text
APP_URL=https://example.com
```

The actual domain must replace the placeholder.

---

# 17. Secure Cookies

Production cookies should be configured to use secure transport.

The application should ensure authentication/session cookies are not unnecessarily transmitted over HTTP.

---

# 18. Trusted Proxies

If Hostinger's infrastructure places a proxy or load balancer in front of Laravel, the application must correctly recognize HTTPS requests.

This prevents issues where Laravel incorrectly believes an HTTPS request is HTTP.

The trusted proxy configuration must follow the actual Hostinger infrastructure.

---

# 19. HSTS

Once HTTPS is confirmed to be stable, SMEvolve may implement HTTP Strict Transport Security.

Conceptually:

```text
Strict-Transport-Security
```

HSTS should only be enabled after confirming that all intended production traffic supports HTTPS.

Do not enable aggressive HSTS settings before validating the domain configuration.

---

# 20. Mixed Content

After enabling HTTPS, verify that the application does not load insecure:

```text
http://
```

resources such as:

* JavaScript.
* CSS.
* Images.
* Fonts.
* API requests.

All production resources should use HTTPS or relative/secure URLs.

---

# 21. Email DNS

Email delivery requires additional DNS configuration.

Depending on the selected email provider, SMEvolve may require:

```text
MX
SPF
DKIM
DMARC
```

These records must be configured according to the provider's official instructions.

---

# 22. MX Records

MX records determine where email for the domain is delivered.

Example:

```text
example.com
     ↓
MX
     ↓
Email Provider
```

The exact MX records depend on the selected email provider.

Do not invent MX records.

---

# 23. SPF

SPF identifies which servers are authorized to send email on behalf of the SMEvolve domain.

The final SPF record must be supplied by the selected email provider.

There should normally be **one authoritative SPF TXT record** for the domain.

Multiple separate SPF records can cause SPF validation problems.

---

# 24. DKIM

DKIM provides cryptographic authentication for outgoing email.

The selected email provider will provide:

* DKIM selector.
* DNS hostname.
* Public key.

The public key must be added to DNS exactly as instructed by the provider.

The private DKIM key must never be exposed publicly.

---

# 25. DMARC

DMARC defines how receiving mail systems should handle messages that fail authentication.

A staged implementation is recommended.

Example progression:

```text
Monitoring
   ↓
Stricter policy
   ↓
Enforcement
```

The actual DMARC policy should be selected after SPF and DKIM are confirmed to work correctly.

---

# 26. Email Subdomain

If appropriate, SMEvolve may use a dedicated email subdomain.

For example:

```text
mail.example.com
```

or a provider-specific sending domain.

This can help separate application email infrastructure from the main website domain.

The decision should be based on the selected email provider.

---

# 27. Email Sender Domain

Production transactional email should use an approved SMEvolve sender identity.

Example:

```text
notifications@example.com
```

or:

```text
hello@example.com
```

The actual sender address should be defined in the Email Configuration document.

---

# 28. DNS and Google Services

Google services may require DNS verification.

For example, Google Search Console may provide a TXT record similar to:

```text
google-site-verification=...
```

The exact value must be obtained directly from Google.

Do not create a fabricated verification value.

---

# 29. Google Analytics

Google Analytics does not normally require a special DNS record for ordinary website tracking.

However, the production domain must be correctly configured in the analytics property.

Analytics configuration must use the production domain rather than localhost or staging.

---

# 30. Search Console

Google Search Console should be configured against the production domain.

Recommended approach:

```text
Google Search Console
        ↓
Domain Property
        ↓
SMEvolve Domain
```

Domain verification may use DNS.

The verification record must be copied exactly from Google.

---

# 31. Sitemap

The production sitemap should be available over HTTPS.

Example:

```text
https://example.com/sitemap.xml
```

The exact route depends on SMEvolve's SEO implementation.

The sitemap URL should be submitted to Google Search Console.

---

# 32. Robots.txt

The production robots file should be accessible over HTTPS.

Example:

```text
https://example.com/robots.txt
```

It must be reviewed carefully before launch.

Do not accidentally block:

```text
/
```

unless the entire site is intentionally excluded from indexing.

---

# 33. Canonical URLs

All public pages should use the correct HTTPS canonical URL.

Example:

```html
<link rel="canonical" href="https://example.com/page">
```

Canonical URLs must not reference:

* Localhost.
* Staging domains.
* HTTP versions.
* Alternate hostnames.

---

# 34. Social Metadata

Production Open Graph and social metadata should reference the canonical HTTPS domain.

Verify:

* `og:url`
* Image URLs.
* Twitter/X card URLs where used.
* Canonical page URLs.

---

# 35. DNS Security

DNS access should be restricted to authorized administrators.

Recommended controls include:

* Strong account passwords.
* Two-factor authentication.
* Limited administrative access.
* Change monitoring where available.

DNS credentials must never be committed to GitHub.

---

# 36. DNS Changes

Every production DNS change should be documented.

Record:

* Date.
* Record type.
* Hostname.
* Purpose.
* Previous value where appropriate.
* New value.
* Reason for change.

This improves troubleshooting and recovery.

---

# 37. DNS TTL

DNS TTL values should be appropriate for the deployment stage.

During initial configuration or migration, shorter TTL values may be useful.

Once the configuration is stable, TTL values may be increased where appropriate.

Do not change TTL values unnecessarily.

---

# 38. Domain Expiration

The production domain must have:

* Valid registration.
* Accurate ownership information.
* Renewal protection where available.
* Payment method monitoring.
* Renewal reminders.

Domain expiration could make the entire production application inaccessible.

---

# 39. SSL Renewal

SSL certificates must remain valid.

If Hostinger manages certificate renewal automatically, verify that automatic renewal is enabled.

Monitor for:

* Expiration.
* Renewal failures.
* Domain validation failures.

---

# 40. SSL Verification

After configuration, verify:

```text
✓ HTTPS loads
✓ Certificate is valid
✓ Certificate matches domain
✓ Certificate is not expired
✓ HTTP redirects to HTTPS
✓ WWW redirects correctly
✓ No mixed-content warnings
✓ Authentication works over HTTPS
✓ Forms work over HTTPS
```

---

# 41. DNS and SSL Deployment Sequence

The recommended sequence is:

```text
Domain
   ↓
DNS
   ↓
Hostinger
   ↓
SSL
   ↓
HTTPS
   ↓
Canonical Redirects
   ↓
Laravel APP_URL
   ↓
Email DNS
   ↓
Google Verification
   ↓
Production Testing
```

---

# 42. Pre-Launch Checklist

Before the application is publicly launched:

```text
✓ Domain configured
✓ Root DNS configured
✓ WWW configuration confirmed
✓ DNS propagated
✓ Hostinger domain connected
✓ SSL issued
✓ HTTPS working
✓ HTTP redirects to HTTPS
✓ Canonical hostname configured
✓ Laravel APP_URL configured
✓ Secure cookies verified
✓ No mixed-content errors
✓ Email MX records configured if required
✓ SPF configured
✓ DKIM configured
✓ DMARC configured
✓ Google Search Console verified
✓ Google Analytics production property configured
✓ Sitemap accessible
✓ Robots.txt reviewed
✓ Canonical URLs verified
```

---

# 43. Troubleshooting

### Domain does not resolve

Check:

* DNS records.
* Nameservers.
* Propagation.
* Hostinger domain configuration.

### SSL is not active

Check:

* Domain points correctly.
* Certificate status.
* DNS propagation.
* Certificate coverage.

### HTTP does not redirect

Check:

* Hostinger redirect configuration.
* Laravel/application configuration.
* Web-server rules.

### Email fails authentication

Check:

* SPF.
* DKIM.
* DMARC.
* Sender domain.
* Email provider configuration.

### Google Search Console verification fails

Check:

* DNS TXT record.
* Correct hostname.
* DNS propagation.
* Verification method.

---

# 44. Acceptance Criteria

This document is complete when:

✓ The production domain strategy is defined.

✓ Canonical hostname strategy is defined.

✓ DNS requirements are documented.

✓ Hostinger DNS requirements are documented.

✓ SSL requirements are documented.

✓ HTTPS requirements are documented.

✓ HTTP-to-HTTPS redirect is defined.

✓ WWW canonicalization is defined.

✓ Email DNS requirements are defined.

✓ SPF requirements are defined.

✓ DKIM requirements are defined.

✓ DMARC requirements are defined.

✓ Google Search Console verification is defined.

✓ Google Analytics domain configuration is defined.

✓ Sitemap requirements are defined.

✓ Robots requirements are defined.

✓ DNS security requirements are defined.

✓ SSL verification requirements are defined.

✓ Pre-launch DNS/SSL checklist is defined.

---

# 45. Next Document

The next document is:

```text
05_Environment_Configuration.md
```

This document will define SMEvolve's production environment variables, `.env` management, application secrets, database credentials, mail configuration, analytics configuration, API credentials, security settings, and the separation between development and production configuration.
