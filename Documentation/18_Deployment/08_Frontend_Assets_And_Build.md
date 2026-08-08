# SMEvolve Deployment

## 08 – Frontend Assets & Build

**Project:** SMEvolve

**Module:** Deployment

**Documentation Path:** `Documentation/18_Deployment/`

**Framework:** Laravel 12

**Frontend Build Tool:** Vite

**Source Control:** GitHub

**Production Hosting:** Hostinger

**Document Version:** 1.0

**Status:** Draft

---

# 1. Purpose

This document defines how SMEvolve's frontend assets are prepared, built, deployed, cached, and verified in production.

It covers:

* Vite.
* Node.js.
* npm.
* JavaScript.
* CSS.
* Static assets.
* Production builds.
* Asset versioning.
* Cache busting.
* Build failures.
* Hostinger deployment.
* Frontend verification.

The objective is to ensure that the production website loads the correct optimized frontend assets and does not depend on development tooling.

---

# 2. Frontend Architecture

SMEvolve uses Laravel with Vite for frontend asset management.

The conceptual architecture is:

```text
Source Code
    │
    ├── JavaScript
    ├── CSS
    └── Static Assets
          │
          ▼
        Vite
          │
          ▼
   Production Build
          │
          ▼
     public/build/
          │
          ▼
       Browser
```

---

# 3. Source Files

Frontend source files should remain in the project's source directories.

Typical locations may include:

```text
resources/
├── css/
├── js/
└── views/
```

The exact structure must follow the implemented SMEvolve project.

---

# 4. Vite Configuration

Vite configuration should be maintained in the project's repository.

Typical file:

```text
vite.config.js
```

or:

```text
vite.config.ts
```

The configuration must correctly identify the SMEvolve frontend entry points.

---

# 5. Package Configuration

Frontend dependencies are defined in:

```text
package.json
```

The repository should also contain the appropriate lock file, such as:

```text
package-lock.json
```

The lock file should be committed to GitHub.

This ensures consistent dependency installation.

---

# 6. Node.js Version

The production build environment must use a Node.js version compatible with:

* Vite.
* Laravel's Vite integration.
* Installed frontend dependencies.

The required version should be documented in the project where possible.

Example:

```text
.nvmrc
```

or an appropriate `package.json` engines declaration may be used if adopted by the project.

---

# 7. npm Installation

When building assets on Hostinger, dependencies should be installed using:

```text
npm ci
```

rather than:

```text
npm install
```

for reproducible production builds.

`npm ci` uses the committed lock file.

---

# 8. Production Build

The production frontend build should be generated with:

```text
npm run build
```

The command should generate optimized production assets.

---

# 9. Development Server

The Vite development server must not be used as the production asset server.

The following is for development:

```text
npm run dev
```

Production should use the generated build:

```text
npm run build
```

---

# 10. Production Asset Directory

Laravel/Vite production assets will normally be generated under:

```text
public/build/
```

The exact output directory must follow the project's Vite configuration.

---

# 11. Asset Manifest

Vite generates an asset manifest used by Laravel to locate compiled files.

The deployment must ensure that the production build and its required manifest are deployed together.

Do not manually rename generated assets.

---

# 12. Cache Busting

Production assets should use Vite's generated versioned filenames where supported.

For example:

```text
app-[hash].js
app-[hash].css
```

The hash ensures that browsers can recognize when a new asset version has been deployed.

---

# 13. Browser Caching

Static production assets may be cached aggressively because Vite generates versioned filenames.

However, HTML responses should still reference the current asset manifest.

After a new deployment:

```text
New source
    ↓
New build
    ↓
New asset hashes
    ↓
Browser receives new files
```

---

# 14. CSS Build

CSS must be compiled as part of the production Vite build.

Verify:

```text
npm run build
```

produces the expected CSS output.

After deployment, verify that:

* Styles load.
* Responsive layouts work.
* No missing CSS files exist.
* No development URLs remain.

---

# 15. JavaScript Build

JavaScript must be compiled into production-ready assets.

Verify that:

* JavaScript loads.
* No development server references remain.
* Browser console contains no critical errors.
* Interactive components function correctly.

---

# 16. Static Assets

Static assets may include:

* Images.
* Icons.
* Fonts.
* Logos.
* Favicons.
* Documents.

They must be stored according to the application's intended architecture.

---

# 17. Public Static Assets

Assets intended to be publicly accessible may be stored under:

```text
public/
```

For example:

```text
public/
├── images/
├── icons/
└── favicon.ico
```

Sensitive files must never be placed in publicly accessible directories.

---

# 18. Uploaded User Files

User-uploaded files must not automatically be treated as static application assets.

They should use Laravel's storage system where appropriate.

The storage strategy is documented separately.

---

# 19. Image Optimization

Production images should be optimized where practical.

Avoid unnecessarily large images because they can increase:

* Page load time.
* Bandwidth consumption.
* Mobile data usage.

Images should be appropriately sized for their intended display.

---

# 20. Font Loading

Production fonts should be reviewed for:

* Correct file paths.
* HTTPS loading.
* Browser compatibility.
* Licensing requirements.
* Performance.

Avoid loading unnecessary font weights.

---

# 21. External Assets

External assets such as:

* Google Fonts.
* CDN JavaScript.
* External images.
* Third-party libraries.

must be reviewed before production deployment.

The project should avoid unnecessary external dependencies.

---

# 22. HTTPS Asset Requirement

All production assets must load through HTTPS.

Avoid:

```text
http://
```

asset URLs on the HTTPS production website.

Mixed-content warnings must be resolved before launch.

---

# 23. Asset URL Configuration

Laravel's asset generation must use the correct production domain and HTTPS configuration.

Verify that generated asset URLs do not point to:

```text
localhost
127.0.0.1
development domains
staging domains
```

---

# 24. Vite Environment Variables

Vite variables exposed to frontend code must be treated as public.

Any variable using Vite's public environment mechanism may become visible in the browser.

Never expose:

```text
Database credentials
SMTP passwords
Private API keys
AI API secrets
Application secrets
```

---

# 25. Public Configuration

Frontend configuration may contain values such as:

```text
Application name
Public API URL
Google Analytics measurement ID
Public feature flags
```

Only values intended to be publicly visible should be included.

---

# 26. Google Analytics

If Google Analytics is included through the frontend, verify that the production build uses the correct measurement ID.

The implementation must not send sensitive customer information as analytics parameters.

Verify:

```text
✓ Correct production measurement ID
✓ Production domain
✓ Page views
✓ Events where configured
✓ No sensitive data
```

---

# 27. Build Environment

The build environment must be consistent.

Where possible, record:

```text
Node.js version
npm version
Vite version
Package lock version
Build date
Git commit
```

This helps reproduce production builds.

---

# 28. Build on Hostinger

If Hostinger is used to build frontend assets, the process should generally be:

```text
GitHub
   ↓
Hostinger
   ↓
npm ci
   ↓
npm run build
   ↓
public/build/
```

The Hostinger environment must have enough resources to complete the build.

---

# 29. Build Outside Hostinger

If Hostinger cannot reliably build the frontend, use an external controlled build environment.

For example:

```text
GitHub
   ↓
CI/CD
   ↓
npm ci
   ↓
npm run build
   ↓
Production artifacts
   ↓
Hostinger
```

The selected strategy should remain consistent across deployments.

---

# 30. Recommended Initial Strategy

For the initial SMEvolve deployment, use the simplest reliable strategy supported by Hostinger.

If Hostinger provides compatible Node.js and sufficient resources:

```text
Build on Hostinger
```

Otherwise:

```text
Build through CI/CD
```

Do not introduce unnecessary infrastructure before it is required.

---

# 31. Build Failure

If:

```text
npm run build
```

fails:

```text
Stop deployment
       ↓
Read build error
       ↓
Identify dependency/source issue
       ↓
Fix in development
       ↓
Commit to GitHub
       ↓
Build again
```

Do not manually modify generated production assets to bypass a build failure.

---

# 32. Dependency Failure

If dependency installation fails:

```text
npm ci
```

verify:

* Node.js version.
* npm version.
* Lock file.
* package.json.
* Available server resources.
* Dependency compatibility.

---

# 33. Production Build Verification

After building:

```text
npm run build
```

verify that the expected build directory exists.

Example:

```text
public/build/
```

Verify that:

* JavaScript exists.
* CSS exists.
* Manifest exists.
* Expected assets exist.

---

# 34. Browser Verification

Open the production site and inspect the browser developer tools.

Check:

```text
Console
Network
Application
```

Look for:

* 404 assets.
* JavaScript errors.
* CSS errors.
* Failed API requests.
* Mixed-content warnings.

---

# 35. Network Verification

The browser network panel should show successful requests for:

```text
.js
.css
images
fonts
API requests
```

Critical frontend assets should not return:

```text
404
403
500
```

---

# 36. JavaScript Verification

Test all major interactive features.

Examples:

```text
Navigation
Forms
Dropdowns
Modals
Authentication
Admin Portal interactions
Notifications
Search
Chatbot interface
```

The exact list should match SMEvolve's implemented features.

---

# 37. Responsive Verification

Test the production frontend on:

* Desktop.
* Tablet.
* Mobile.

At minimum verify:

```text
✓ Navigation
✓ Forms
✓ Tables
✓ Cards
✓ Modals
✓ Buttons
✓ Images
✓ Admin Portal
```

---

# 38. Favicon and Metadata

Verify that production includes:

```text
favicon
page title
meta description where applicable
Open Graph metadata where applicable
```

These assets must use production URLs.

---

# 39. Error Handling

Frontend errors should not expose:

* API keys.
* Database information.
* Internal filesystem paths.
* Server secrets.

Production error messages should be user-friendly.

Detailed diagnostics should remain in protected server logs.

---

# 40. Asset Deployment Sequence

The recommended process is:

```text
Pull GitHub Code
      ↓
Install PHP Dependencies
      ↓
Install Node Dependencies
      ↓
Build Vite Assets
      ↓
Configure Laravel
      ↓
Run Database Migration
      ↓
Cache Configuration
      ↓
Verify public/build
      ↓
Test Website
```

---

# 41. Asset Cleanup

Old generated assets may accumulate over time.

Because Vite uses hashed filenames, cleanup must be performed carefully.

Do not delete the current build while the application is still referencing it.

A controlled deployment should replace or synchronize the build directory safely.

---

# 42. Deployment Cache

If users continue seeing old frontend assets after deployment:

1. Confirm a new Vite build was generated.
2. Confirm the manifest references the new files.
3. Clear Laravel caches if necessary.
4. Check browser cache.
5. Check any CDN/cache layer.
6. Verify the HTML references the current assets.

---

# 43. CDN Consideration

A CDN is not required for the initial Hostinger deployment.

It may be introduced later if traffic or geographic distribution requires it.

If a CDN is introduced, caching rules must be reviewed for:

* HTML.
* JavaScript.
* CSS.
* Images.
* API responses.

---

# 44. Build Security

The build process must not expose secrets.

Review:

```text
package.json
Vite configuration
frontend environment variables
CI/CD logs
```

Do not print secret environment variables during builds.

---

# 45. Frontend Deployment Checklist

```text
✓ package.json committed
✓ package-lock.json committed
✓ Node.js version verified
✓ npm version verified
✓ Vite configuration verified
✓ npm ci successful
✓ npm run build successful
✓ public/build generated
✓ Manifest generated
✓ JavaScript loads
✓ CSS loads
✓ Images load
✓ Fonts load
✓ No mixed-content errors
✓ No critical console errors
✓ No development URLs
✓ No secrets exposed
✓ Mobile layout tested
✓ Admin Portal tested
✓ Chatbot interface tested
```

---

# 46. Acceptance Criteria

This document is complete when:

✓ Vite production build process is defined.

✓ Node.js requirements are defined.

✓ npm dependency installation is defined.

✓ Production build command is defined.

✓ Build-on-Hostinger strategy is defined.

✓ External build strategy is defined.

✓ Static asset handling is defined.

✓ JavaScript deployment is defined.

✓ CSS deployment is defined.

✓ Cache busting is defined.

✓ Frontend environment security is defined.

✓ Google Analytics frontend requirements are defined.

✓ Build failure handling is defined.

✓ Browser verification is defined.

✓ Responsive testing is defined.

✓ Asset deployment checklist is defined.

---

# 47. Next Document

The next document is:

```text
09_Storage_Queues_Scheduler.md
```

This will cover Laravel storage, uploaded files, queues, background jobs, Laravel Scheduler, Hostinger Cron Jobs, worker management, scheduled notifications, and production background processing.
