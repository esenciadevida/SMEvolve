# SMEvolve Deployment

## 10 – Email Configuration

**Project:** SMEvolve

**Module:** Deployment

**Documentation Path:** `Documentation/18_Deployment/`

**Framework:** Laravel 12

**Source Control:** GitHub

**Production Hosting:** Hostinger

**Email:** Transactional Email

**Document Version:** 1.0

**Status:** Draft

---

# 1. Purpose

This document defines the production email infrastructure for SMEvolve.

It covers:

* Transactional email.
* Laravel mail configuration.
* Domain-based email.
* SMTP.
* SPF.
* DKIM.
* DMARC.
* Email notifications.
* Email templates.
* Password reset emails.
* Contact notifications.
* Administrative notifications.
* Delivery testing.
* Email security.
* Failure handling.
* Monitoring.

The objective is to ensure that SMEvolve can reliably send professional emails to customers, administrators, and other authorized recipients.

---

# 2. Email Architecture

The production email flow is:

```text
SMEvolve Laravel Application
          │
          ▼
   Mail Configuration
          │
          ▼
 SMTP / Email Provider
          │
          ▼
      Recipient
```

Email should be sent through a proper transactional email service or authenticated SMTP service rather than directly from the application server.

---

# 3. Email Domain

SMEvolve should use an email address associated with the organization's verified production domain.

Example:

```text
noreply@yourdomain.com
```

or:

```text
support@yourdomain.com
```

The actual production domain must be used.

---

# 4. Sender Address

The application should have a consistent sender address.

Example:

```text
MAIL_FROM_ADDRESS=noreply@yourdomain.com
MAIL_FROM_NAME=SMEvolve
```

The sender domain must be authorized by the selected email provider.

---

# 5. Transactional Email

Transactional email refers to emails triggered by application events.

Potential SMEvolve transactional emails include:

* Account verification.
* Password reset.
* Welcome email.
* Contact form notification.
* Quote/request notification.
* Status updates.
* Administrative alerts.
* System notifications.
* Chatbot-related notifications where applicable.

Only implemented features should send emails.

---

# 6. Email Provider

The production provider should be selected based on:

* Deliverability.
* Cost.
* SMTP/API support.
* Domain authentication.
* Sending limits.
* Reliability.
* Laravel compatibility.

Possible providers may include:

* Hostinger Email.
* Resend.
* Mailgun.
* Postmark.
* Amazon SES.
* Brevo.

The final provider must be selected before production credentials are configured.

---

# 7. Recommended Initial Approach

For the initial SMEvolve deployment on Hostinger, use a properly authenticated email service that supports the project's expected sending volume.

If the Hostinger email service provides sufficient transactional-email capabilities, it may be used.

If higher deliverability, analytics, or application-email features are required, a dedicated transactional provider can be introduced.

---

# 8. SMTP Configuration

If SMTP is used, Laravel will require the appropriate production settings.

Example:

```text
MAIL_MAILER=smtp
MAIL_HOST=
MAIL_PORT=
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=
MAIL_FROM_ADDRESS=
MAIL_FROM_NAME=
```

Actual values must be obtained from the selected provider.

---

# 9. SMTP Security

SMTP credentials must:

* Never be committed to GitHub.
* Never appear in frontend code.
* Never be stored in source files.
* Never be included in public documentation.
* Never be exposed in logs.

Credentials must be stored in the production environment.

---

# 10. SMTP Encryption

Use the encryption method required by the selected provider.

Common secure options include:

```text
TLS
STARTTLS
```

Do not disable transport encryption merely to resolve a configuration problem.

---

# 11. Domain Verification

Before production email is enabled, the sending domain should be verified with the email provider.

Domain verification may require DNS records.

Typical records include:

```text
SPF
DKIM
DMARC
```

The exact records must be obtained from the selected provider.

---

# 12. SPF

SPF identifies which mail servers are authorized to send email on behalf of the domain.

A typical SPF record is published as a DNS TXT record.

Example structure:

```text
v=spf1 include:provider.example ~all
```

The actual value must be provided by the email provider.

Do not copy the example into production.

---

# 13. DKIM

DKIM allows outgoing emails to be cryptographically signed.

The email provider normally provides:

* Selector.
* Public key.
* DNS record.

The public DKIM record must be added to the production DNS configuration.

The private signing key remains controlled by the email provider.

---

# 14. DMARC

DMARC defines how receiving mail systems should handle messages that fail authentication checks.

A basic policy may initially be configured in monitoring mode.

Example structure:

```text
v=DMARC1; p=none; rua=mailto:dmarc@yourdomain.com
```

The actual policy must be selected based on the organization's email requirements.

Do not enable an aggressive enforcement policy until legitimate sending sources have been verified.

---

# 15. Email Authentication Flow

The desired authentication architecture is:

```text
SMEvolve
   │
   ▼
Email Provider
   │
   ├── SPF
   ├── DKIM
   └── DMARC
   │
   ▼
Recipient Mail Server
```

---

# 16. DNS Verification

After configuring email DNS records, verify that:

* SPF resolves correctly.
* DKIM resolves correctly.
* DMARC resolves correctly.
* No conflicting SPF records exist.
* The sending provider is authorized.

A domain must generally have one coherent SPF policy rather than multiple independent SPF records.

---

# 17. Laravel Mail Configuration

Laravel mail configuration should be provided through environment variables.

The application should not contain production SMTP credentials directly in:

```text
config/mail.php
```

The configuration file should reference environment variables.

---

# 18. Configuration Cache

After changing production mail environment variables, rebuild Laravel's configuration cache if it is being used.

Example:

```text
php artisan config:clear
php artisan config:cache
```

This ensures Laravel uses the current production configuration.

---

# 19. Email Templates

SMEvolve emails should use standardized templates.

Templates should maintain:

* SMEvolve branding.
* Consistent typography.
* Clear subject lines.
* Responsive layout.
* Professional footer.
* Contact information where required.

---

# 20. Email Content

Emails should clearly communicate:

* Why the recipient received the email.
* What happened.
* What action is required.
* Relevant reference information.
* How to contact support if necessary.

Avoid unnecessarily long emails.

---

# 21. HTML Email

Production transactional emails may use HTML templates.

Important considerations:

* Responsive design.
* Mobile compatibility.
* Simple layouts.
* Accessible text.
* Proper links.
* Plain-text fallback where appropriate.

---

# 22. Plain-Text Fallback

Important transactional emails should provide a readable plain-text version where practical.

This improves compatibility with email clients and accessibility.

---

# 23. Email Links

Production emails must use the production HTTPS domain.

Do not send links pointing to:

```text
localhost
127.0.0.1
staging domains
development domains
```

Example:

```text
https://yourdomain.com/verify
```

The actual SMEvolve production domain must be used.

---

# 24. Password Reset Email

The password reset workflow must:

* Generate secure tokens.
* Use HTTPS links.
* Expire tokens appropriately.
* Avoid exposing passwords.
* Allow users to securely reset their password.

The email must not contain the user's current password.

---

# 25. Account Verification

If email verification is implemented, the verification email should contain:

* Clear verification instructions.
* Secure verification URL.
* Appropriate expiry behavior.
* Support information where required.

---

# 26. Contact Form Notifications

If SMEvolve has a public contact form, submissions may trigger an administrative notification.

Example:

```text
Website
   ↓
Contact Form
   ↓
Laravel
   ↓
Queue
   ↓
Email Notification
   ↓
Admin
```

Where possible, email sending should be queued rather than blocking the user's request.

---

# 27. Customer Notifications

Customer-facing notifications should only be sent for events that require communication.

Potential events include:

* Registration.
* Verification.
* Quote/request submission.
* Status changes.
* Password reset.
* Important account activity.

---

# 28. Administrative Notifications

Administrative emails may notify authorized staff about:

* New customer registration.
* New request.
* New quote.
* Important system events.
* Failed operations.
* Security events.

Administrative notification recipients should be configurable rather than hard-coded throughout the application.

---

# 29. Email Queue

Email sending should use Laravel's queue system where appropriate.

Example:

```text
Application Event
      ↓
Mail Job
      ↓
Queue
      ↓
Worker
      ↓
Email Provider
```

This prevents slow mail-provider responses from unnecessarily delaying web requests.

---

# 30. Email Retry

Temporary email delivery failures may be retried.

Retry configuration should account for:

* Provider downtime.
* Network errors.
* Rate limits.
* Temporary recipient-server failures.

Permanent failures should not be retried indefinitely.

---

# 31. Failed Emails

Failed email jobs should be recorded through Laravel's failed-job system where applicable.

Administrators should be able to identify recurring email failures.

---

# 32. Email Rate Limits

The selected provider's sending limits must be understood.

Consider:

* Messages per minute.
* Messages per hour.
* Daily limits.
* Recipient limits.

The application should not intentionally exceed provider limits.

---

# 33. Email Abuse Prevention

Public forms must be protected against email abuse.

Potential protections include:

* Rate limiting.
* CAPTCHA where appropriate.
* Validation.
* Authentication for sensitive actions.
* Queue controls.

A public contact form should not become an unrestricted email relay.

---

# 34. User-Supplied Email Addresses

User-supplied addresses must be validated.

Do not allow users to manipulate arbitrary email headers.

The application should control:

```text
From
Reply-To
```

according to the intended workflow.

---

# 35. Reply-To Handling

For contact forms, the user's email may be placed in `Reply-To` rather than replacing the verified sender address.

Example concept:

```text
From:
SMEvolve <support@yourdomain.com>

Reply-To:
customer@example.com
```

This maintains domain authentication while allowing administrators to reply conveniently.

---

# 36. Email Privacy

Emails must not expose unnecessary personal information.

Do not include:

* Passwords.
* API keys.
* Database credentials.
* Sensitive internal data.
* Unnecessary customer records.

---

# 37. Email Logging

Email logs should record enough information to troubleshoot delivery without storing unnecessary sensitive content.

Possible metadata:

```text
Message type
Recipient
Timestamp
Status
Provider response
Reference ID
```

Sensitive email contents should not be logged unnecessarily.

---

# 38. Production Email Test

Before launch, perform a controlled test.

Verify:

```text
✓ Application sends email
✓ Provider accepts email
✓ Email arrives
✓ Sender is correct
✓ SPF passes
✓ DKIM passes
✓ DMARC alignment is correct
✓ HTTPS links work
✓ HTML renders correctly
✓ Mobile rendering works
✓ Reply-to works
```

---

# 39. Test Multiple Providers

Where possible, test delivery to more than one major mailbox provider.

For example:

* Gmail.
* Outlook.
* Yahoo.

This can reveal provider-specific rendering or deliverability problems.

---

# 40. Email Deliverability

If messages go to spam:

1. Check SPF.
2. Check DKIM.
3. Check DMARC.
4. Verify sender domain.
5. Review sending reputation.
6. Check provider delivery logs.
7. Review email content.
8. Confirm recipient engagement.

Do not simply increase sending volume to overcome deliverability problems.

---

# 41. Email Bounce Handling

The selected email provider should be reviewed for bounce information.

Hard bounces should not repeatedly receive messages.

Where appropriate, bounced addresses should be marked accordingly.

---

# 42. Unsubscribe Requirements

Transactional emails are different from marketing emails.

If SMEvolve later sends marketing/promotional emails, the project must implement the appropriate unsubscribe and consent mechanisms.

Do not treat promotional email as transactional email simply because it is generated by the application.

---

# 43. Email Monitoring

Production email monitoring should track:

```text
Sent
Delivered
Bounced
Failed
Queued
```

Provider-specific analytics may be used where available.

---

# 44. Email Provider Failure

If the email provider becomes unavailable:

```text
Application
    ↓
Queue
    ↓
Provider unavailable
    ↓
Retry
    ↓
Provider restored
    ↓
Email delivered
```

The application should not crash simply because a non-critical email cannot immediately be sent.

---

# 45. Critical Email Failure

For security-critical emails such as password resets or verification messages, failure should be surfaced appropriately to the user.

The application should provide a useful retry path.

---

# 46. Email Configuration Security

Verify:

```text
✓ SMTP password protected
✓ API keys protected
✓ Production credentials not in GitHub
✓ No secrets in frontend
✓ No secrets in logs
✓ DNS records configured correctly
✓ Domain verified
```

---

# 47. Hostinger Considerations

Because SMEvolve is hosted on Hostinger, verify:

* DNS management location.
* Domain email configuration.
* SMTP connectivity.
* PHP mail configuration.
* Cron/queue compatibility.
* Any Hostinger email restrictions.

Hostinger-specific values must be confirmed from the active hosting account rather than assumed.

---

# 48. Deployment Sequence

The email deployment sequence is:

```text
Select Email Provider
        ↓
Verify Domain
        ↓
Configure SPF
        ↓
Configure DKIM
        ↓
Configure DMARC
        ↓
Create Email Credentials
        ↓
Configure Laravel .env
        ↓
Clear/Rebuild Config Cache
        ↓
Test Email
        ↓
Test Queue
        ↓
Verify Delivery
        ↓
Monitor
```

---

# 49. Email Configuration Checklist

```text
DOMAIN
✓ Production domain confirmed
✓ Sender address confirmed
✓ Domain verified

DNS
✓ SPF configured
✓ DKIM configured
✓ DMARC configured
✓ No conflicting SPF records

LARAVEL
✓ MAIL_MAILER configured
✓ MAIL_HOST configured
✓ MAIL_PORT configured
✓ MAIL_USERNAME configured
✓ MAIL_PASSWORD configured securely
✓ MAIL_ENCRYPTION configured
✓ MAIL_FROM_ADDRESS configured
✓ MAIL_FROM_NAME configured

FUNCTIONALITY
✓ Password reset tested
✓ Verification email tested
✓ Contact notification tested
✓ Administrative notification tested
✓ Queue email tested

SECURITY
✓ Credentials not committed
✓ Credentials not exposed
✓ User input validated
✓ Email abuse protections configured

DELIVERY
✓ Gmail tested
✓ Outlook tested
✓ Delivery confirmed
✓ SPF verified
✓ DKIM verified
✓ DMARC verified
✓ Bounce handling reviewed
```

---

# 50. Acceptance Criteria

This document is complete when:

✓ Production email architecture is defined.

✓ Email provider strategy is defined.

✓ SMTP configuration is defined.

✓ Sender configuration is defined.

✓ SPF requirements are defined.

✓ DKIM requirements are defined.

✓ DMARC requirements are defined.

✓ Laravel configuration is defined.

✓ Email templates are defined.

✓ Password reset email requirements are defined.

✓ Verification email requirements are defined.

✓ Administrative notifications are defined.

✓ Customer notifications are defined.

✓ Queue-based email processing is defined.

✓ Email failure handling is defined.

✓ Deliverability testing is defined.

✓ Email security requirements are defined.

✓ Monitoring requirements are defined.

---

# 51. Next Document

The next document is:

```text
11_Analytics_SEO_And_Search_Engine.md
```

This document will cover **Google Analytics, Google Search Console, SEO, sitemap, robots.txt, metadata, indexing, search-engine configuration, structured data, and production verification**.
