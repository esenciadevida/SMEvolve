# SMEvolve Deployment

## 13 – Domain & DNS Configuration

**Project:** SMEvolve

**Module:** Deployment

**Documentation Path:** `Documentation/18_Deployment/`

**Production Hosting:** Hostinger

**Source Control:** GitHub

**Primary Domain:** `[PRODUCTION-DOMAIN]`

**Document Version:** 1.0

**Status:** Draft

---

# 1. Purpose

This document defines the production domain and DNS configuration required for SMEvolve.

It covers:

* Domain configuration.
* Hostinger DNS.
* A records.
* AAAA records.
* CNAME records.
* MX records.
* SPF.
* DKIM.
* DMARC.
* WWW/non-WWW handling.
* Subdomains.
* SSL-related DNS requirements.
* Email DNS.
* DNS verification.
* DNS troubleshooting.

The objective is to ensure that the SMEvolve website, email services, SSL certificate, analytics, and other production services resolve correctly.

---

# 2. Domain Architecture

The basic production architecture is:

```text
                    Domain
                       │
              ┌────────┴────────┐
              ▼                 ▼
          Website             Email
              │                 │
              ▼                 ▼
          Hostinger        Email Provider
```

Additional services may be connected through DNS as the project grows.

---

# 3. Primary Domain

The project must define one primary production domain.

Example:

```text id="5n3x8q"
https://yourdomain.com
```

Replace the placeholder with the actual SMEvolve domain before production deployment.

---

# 4. Canonical Domain

SMEvolve must select one canonical domain format:

```text id="r4m7p2"
https://yourdomain.com
```

or:

```text id="k8v3s6"
https://www.yourdomain.com
```

The alternative version should redirect to the canonical version.

---

# 5. DNS Provider

The project must identify where DNS is managed.

Possible configurations include:

```text id="g6p2x8"
Domain Registrar
       ↓
Hostinger DNS
```

or:

```text id="m4q9v7"
Domain Registrar
       ↓
External DNS Provider
```

The actual DNS provider must be documented before configuration.

---

# 6. Hostinger DNS

If DNS is managed through Hostinger, DNS records should be configured through the Hostinger DNS management interface.

Only authorized personnel should modify production DNS.

---

# 7. A Record

The primary domain may use an A record to point to the Hostinger server.

Conceptually:

```text id="f8k3n2"
Type: A
Name: @
Value: [HOSTINGER-IP]
```

The actual IP address must be obtained from the active Hostinger hosting account.

Do not use an example IP in production.

---

# 8. WWW Record

The `www` hostname may use a CNAME pointing to the canonical domain.

Example:

```text id="q5m7x9"
Type: CNAME
Name: www
Value: yourdomain.com
```

The actual configuration should match Hostinger's recommended setup.

---

# 9. AAAA Record

If IPv6 is supported and intentionally configured, an AAAA record may be used.

Example:

```text id="z3r8k4"
Type: AAAA
Name: @
Value: [IPV6-ADDRESS]
```

Do not create an AAAA record unless the destination actually supports IPv6.

Incorrect IPv6 configuration can cause some users to experience connectivity problems.

---

# 10. DNS TTL

DNS records have a TTL that determines how long resolvers may cache the record.

During major DNS changes, a lower TTL may be useful before the change.

After the configuration is stable, an appropriate longer TTL can be used.

---

# 11. DNS Propagation

DNS changes may take time to propagate.

After making a change:

```text id="n6v2p8"
DNS Change
    ↓
Resolver Caches
    ↓
Propagation
    ↓
Global Resolution
```

Do not assume that every network will see the new record immediately.

---

# 12. MX Records

MX records determine where email for the domain is delivered.

If SMEvolve uses a separate email provider, the provider will supply the required MX records.

Example structure:

```text id="j7q3m5"
Type: MX
Name: @
Priority: [PROVIDER]
Value: [MAIL-SERVER]
```

The actual records must be obtained from the selected email provider.

---

# 13. MX Record Verification

After configuring email DNS:

```text id="w8k4p2"
✓ MX records exist
✓ Correct priority
✓ Correct destination
✓ No obsolete mail provider records
```

Incorrect MX records can prevent domain email from being delivered.

---

# 14. SPF Record

SPF should be configured as a DNS TXT record.

Example structure:

```text id="m3v7q9"
Type: TXT
Name: @
Value: v=spf1 include:provider.example ~all
```

The actual SPF value must come from the selected email provider.

---

# 15. Multiple SPF Records

Do not create multiple independent SPF TXT records for the same domain.

If multiple services send email from the domain, their authorized sources should be consolidated into one SPF policy where appropriate.

---

# 16. DKIM Records

The email provider should provide the required DKIM DNS records.

Typical structure:

```text id="x5p8n3"
Type: TXT
Name: [SELECTOR]._domainkey
Value: [DKIM-PUBLIC-KEY]
```

The actual selector and key must come from the provider.

---

# 17. DMARC Record

DMARC is normally configured as a TXT record.

Example structure:

```text id="c7m2r8"
Type: TXT
Name: _dmarc
Value: v=DMARC1; p=none; rua=mailto:dmarc@yourdomain.com
```

The actual policy should reflect the project's email security requirements.

---

# 18. DMARC Policy

A cautious initial rollout may use:

```text id="a4k9v6"
p=none
```

This allows monitoring before stricter enforcement.

Once legitimate email sources are confirmed, the project may consider stronger policies such as:

```text id="f8q3m7"
p=quarantine
```

or:

```text id="h5x2n9"
p=reject
```

The final policy must be deliberately selected.

---

# 19. Domain Verification Records

Third-party services may require DNS verification records.

Examples include:

* Google Search Console.
* Email providers.
* Analytics-related services.
* Other SaaS platforms.

These records should be documented when added.

---

# 20. Google Search Console

If DNS verification is used, Google may provide a TXT record similar to:

```text id="y3p7m4"
Type: TXT
Name: @
Value: google-site-verification=[TOKEN]
```

The actual token must come directly from Google Search Console.

---

# 21. Subdomains

Subdomains should only be created when required.

Potential SMEvolve examples include:

```text id="s9k4v2"
www.yourdomain.com
api.yourdomain.com
admin.yourdomain.com
```

The final architecture should avoid unnecessary subdomains.

---

# 22. Admin Subdomain

If the Admin Portal is eventually separated onto a dedicated subdomain, it may use:

```text id="q2m7x5"
admin.yourdomain.com
```

However, a subdomain does not replace authentication or authorization.

The Admin Portal must remain protected.

---

# 23. API Subdomain

If SMEvolve later exposes a separate API host, a subdomain such as:

```text id="v8n3p6"
api.yourdomain.com
```

may be introduced.

The API must have its own security, authentication, rate limiting, and CORS strategy.

---

# 24. DNS and SSL

The domain must resolve correctly before SSL provisioning can complete reliably.

The general flow is:

```text id="k5r9m2"
DNS
 ↓
Hostinger Server
 ↓
SSL Certificate
 ↓
HTTPS
```

---

# 25. SSL DNS Verification

If Hostinger requires DNS-based certificate verification, the required DNS records must be added exactly as provided.

Do not modify provider-generated verification values.

---

# 26. HTTP to HTTPS

After SSL is active:

```text id="j4p8s6"
http://yourdomain.com
          ↓
https://yourdomain.com
```

The production application should use HTTPS as the canonical protocol.

---

# 27. WWW Redirect

If the canonical domain is:

```text id="q7n3x8"
yourdomain.com
```

then:

```text id="m6v2p4"
www.yourdomain.com
```

should redirect appropriately.

If `www` is selected as canonical, the opposite direction should be configured.

---

# 28. DNS Security

DNS access should be restricted to authorized administrators.

A malicious DNS modification can redirect:

* Website traffic.
* Email.
* Verification services.
* API traffic.

Therefore DNS credentials should be treated as production credentials.

---

# 29. DNS Change Management

Before changing a production DNS record:

1. Identify the purpose.
2. Record the current value.
3. Confirm the new value.
4. Identify possible impact.
5. Make the change.
6. Verify DNS resolution.
7. Verify the affected service.

---

# 30. DNS Record Inventory

Maintain a record inventory.

Example:

| Type  | Name          | Purpose       | Destination      | Status |
| ----- | ------------- | ------------- | ---------------- | ------ |
| A     | `@`           | Website       | Hostinger IP     | Active |
| CNAME | `www`         | Website alias | Canonical domain | Active |
| MX    | `@`           | Email         | Email provider   | Active |
| TXT   | `@`           | SPF           | Email provider   | Active |
| TXT   | DKIM selector | DKIM          | Email provider   | Active |
| TXT   | `_dmarc`      | DMARC         | Email policy     | Active |

Actual production values should be entered into the project's secure deployment records.

---

# 31. Sensitive DNS Information

Some DNS information is public by design.

However, administrative credentials and private infrastructure information must not be placed in public documentation.

Do not document:

* Hostinger passwords.
* DNS account passwords.
* Private API keys.
* SMTP passwords.
* Private SSH keys.

---

# 32. DNS Verification

After configuration, verify:

```text id="p9x4m7"
✓ Domain resolves
✓ WWW resolves
✓ HTTPS works
✓ Canonical redirect works
✓ MX records resolve
✓ SPF resolves
✓ DKIM resolves
✓ DMARC resolves
✓ Search Console verification works
```

---

# 33. Website Verification

Open:

```text id="b6k2v8"
https://yourdomain.com
```

Verify:

* Website loads.
* SSL is valid.
* CSS loads.
* JavaScript loads.
* Images load.
* Forms work.
* API requests work where applicable.

---

# 34. Email Verification

Send a controlled test email from the production application.

Verify:

```text id="n5q8r3"
✓ Email sent
✓ MX configuration correct
✓ Email received
✓ SPF passes
✓ DKIM passes
✓ DMARC alignment works
```

---

# 35. Search Engine Verification

Verify:

```text id="x7m3p9"
https://yourdomain.com/robots.txt
https://yourdomain.com/sitemap.xml
```

Then verify that the domain is correctly configured in Google Search Console.

---

# 36. DNS Failure Troubleshooting

If the website does not resolve:

```text id="j8q4v6"
Check A record
     ↓
Check AAAA record
     ↓
Check nameservers
     ↓
Check DNS propagation
     ↓
Check Hostinger configuration
```

---

# 37. Email DNS Troubleshooting

If email fails:

```text id="q6m2x8"
Check MX
  ↓
Check SPF
  ↓
Check DKIM
  ↓
Check DMARC
  ↓
Check SMTP/provider configuration
  ↓
Check provider logs
```

---

# 38. Wrong IPv6 Configuration

If an AAAA record points to an incorrect server, some users may reach the wrong destination even when the A record is correct.

If IPv6 is not intentionally supported, an incorrect AAAA record should be removed.

---

# 39. DNS Cache Issues

If a DNS change appears not to work:

* Check from another network.
* Check using independent DNS lookup tools.
* Verify authoritative DNS.
* Check TTL.
* Wait for propagation where necessary.

Do not repeatedly change records without confirming the authoritative configuration.

---

# 40. Production DNS Checklist

```text
DOMAIN
✓ Primary domain selected
✓ Canonical domain selected
✓ DNS provider identified
✓ Hostinger destination confirmed

WEBSITE
✓ A record configured
✓ AAAA record reviewed
✓ WWW configured
✓ HTTP redirects to HTTPS
✓ HTTPS certificate active

EMAIL
✓ MX configured
✓ SPF configured
✓ DKIM configured
✓ DMARC configured
✓ Email delivery tested

SEARCH
✓ Search Console verified
✓ robots.txt accessible
✓ sitemap.xml accessible

SECURITY
✓ DNS account secured
✓ Access restricted
✓ No credentials documented
✓ DNS changes controlled

VERIFICATION
✓ Website resolves
✓ HTTPS works
✓ Canonical redirects work
✓ Email works
✓ Search services work
```

---

# 41. Acceptance Criteria

This document is complete when:

✓ Primary domain configuration is defined.

✓ Canonical domain strategy is defined.

✓ Hostinger DNS configuration is defined.

✓ A record requirements are defined.

✓ AAAA record requirements are defined.

✓ CNAME requirements are defined.

✓ MX requirements are defined.

✓ SPF requirements are defined.

✓ DKIM requirements are defined.

✓ DMARC requirements are defined.

✓ Subdomain strategy is defined.

✓ SSL DNS requirements are defined.

✓ DNS verification is defined.

✓ DNS troubleshooting is defined.

✓ Website verification is defined.

✓ Email verification is defined.

✓ Search-engine verification is defined.

---

# 42. Next Document

The next document is:

```text
Documentation/18_Deployment/14_Production_Environment_Configuration.md
```

This will define the **complete Hostinger production environment configuration**, including Laravel `.env`, PHP settings, database connection, mail, queues, cache, filesystem, application URLs, third-party services, environment separation, and the final production configuration checklist.
