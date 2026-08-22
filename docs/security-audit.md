# Rizki Mobil Security Audit

**Audit date:** 22 August 2026  
**Production target:** `https://rizkimobil.com`  
**Audit branch:** `codex/security-rizki-mobil-hardening`  
**Baseline:** OWASP ASVS 5.0 and OWASP Top 10  
**Scope:** Laravel source, authentication, authorization, input/output handling, uploads, dependencies, repository history, deployment assumptions, and low-impact production checks.

## 1. Executive Verdict

**Overall assessment: HIGH RISK until the P0 actions are completed.**

The most dangerous confirmed issue is an administrator bootstrap credential that was committed to Git history and was automatically seeded by the application. The password is intentionally not reproduced in this report. The source path has been removed on the hardening branch, but the production administrator password and all active sessions must be rotated because removing a secret from the latest source does not invalidate a previously exposed credential. The dependency baseline also started with 48 Composer advisories affecting 16 packages and 10 npm advisories; the branch now resolves to zero known advisories in both lockfiles. Vehicle image uploads previously derived their stored extension from client-controlled file data, which could become an executable-upload risk on a permissive shared-hosting configuration; the branch now derives extensions from server-observed MIME, uses randomized ULIDs, and adds an Apache no-execute rule. Authentication, server-side admin authorization, CSRF, Blade escaping, query whitelisting, and favorite ownership did not reveal a confirmed bypass, SQL injection, XSS, IDOR, SSRF, command injection, or open redirect. Production remains incompletely verifiable because an OpenResty challenge intercepts normal responses and the four canonical URL variants currently return `200` instead of redirecting to one HTTPS origin. The site should not be called hardened until credentials are rotated, this branch is deployed, and the cPanel/OpenResty checks in `docs/cpanel-security-hardening.md` pass.

## 2. Security Score

This score represents the observed production posture before this branch is deployed, not a guarantee of security.

| Area | Score |
| --- | ---: |
| Framework & Dependencies | 10 / 15 |
| Authentication | 4 / 10 |
| Authorization | 15 / 15 |
| Input & Output Security | 13 / 15 |
| Deployment & Secrets | 4 / 15 |
| HTTP/TLS | 4 / 10 |
| Session & Cookies | 5 / 10 |
| File/Upload Security | 4 / 5 |
| Logging/Monitoring | 3 / 5 |
| **Total** | **62 / 100** |

Main deductions are the committed administrator credential, unknown production session-cookie attributes, missing canonical redirects and edge headers, a tracked legacy `vendor.zip`, unrestricted trusted-proxy configuration, and server controls that could not be inspected behind the OpenResty challenge. After credential rotation, deployment of this branch, and completion of the P1 cPanel actions, a reasonable target is approximately **81 / 100**. A new production verification is required before assigning that score.

## 3. Findings

| ID | Severity | Finding | Evidence | Status |
| --- | --- | --- | --- | --- |
| SEC-001 | CRITICAL | Administrator credential committed and automatically seeded | Deleted `database/seeders/AdminUserSeeder.php`; history commit `38124be`; prior call removed from `DatabaseSeeder.php` | Source fixed; production rotation open |
| SEC-002 | HIGH | Known vulnerable Composer and npm dependency baseline | Initial audits: 48 Composer advisories / 16 packages and 10 npm advisories; final audits: zero | Fixed in branch; deploy pending |
| SEC-003 | HIGH | Upload storage name trusted client-associated extension and public execution depended on server behavior | `CarImageUpload.php:12-28`, `CarForm.php:214-230`, `ImagesRelationManager.php:36-48` | Application fixed; OpenResty action open |
| SEC-004 | HIGH (conditional) | All reverse proxies are trusted | `bootstrap/app.php:16` | Open |
| SEC-005 | MEDIUM | Abuse-sensitive endpoints lacked explicit rate limits | `AppServiceProvider.php:42-63`, `routes/web.php:28-63` | Fixed in branch |
| SEC-006 | MEDIUM | Password changes did not revoke remembered sessions; email changes lacked re-authentication | `AccountController.php:19-56`, `EditUser.php:25-55`, `routes/web.php:36-46` | Fixed in branch; email verification is residual |
| SEC-007 | MEDIUM | HTTPS canonicalization and browser security headers were absent at the observed edge response | Production HEAD checks and `SecurityHeaders.php:15-27` | Application fixed; edge action open |
| SEC-008 | MEDIUM | Legacy dependency archive is tracked in Git | `vendor.zip` is tracked and contains an obsolete dependency tree | Open |
| SEC-009 | MEDIUM | Contact database exceptions could disclose submitted PII in logs | `ContactController.php:37-44` and regression test | Fixed in branch |
| SEC-010 | LOW | Exact OpenResty version is disclosed | Observed `Server: openresty/1.31.1.1` | Open |
| SEC-011 | LOW | Existing image library contains oversized and MIME/extension-mismatched files | Local media inventory: 27 of 42 files over 2 MB; 25 mismatches | Open maintenance item |
| SEC-012 | LOW | Password baseline is 8 characters and no MFA is enforced for administrators | Authentication and Filament account flows | Open hardening item |

### SEC-001 - Administrator Credential In Git History

**Severity:** CRITICAL  
**Affected component:** Database seeders and Git history  
**Evidence:** The deleted `database/seeders/AdminUserSeeder.php` contained a deterministic administrator identity and password and was called by `database/seeders/DatabaseSeeder.php`. Git history shows the seeder in commit `38124be`. The credential value is redacted by design.  
**Attack scenario:** Anyone with repository or archive access could try the known credential against `/admin`. If it is still active, this can become full administrator takeover.  
**Impact:** Inventory, locations, users, customer inquiries, and all Filament administration functions may be exposed or modified.  
**Fix:** The hardening branch deletes the credential seeder and removes the automatic administrator seed call. Administrator provisioning must be an explicit operational action with a unique password.  
**Verification:** `DatabaseSeederSecurityTest` proves that seeding cannot create or promote the formerly implied administrator. Repository scans no longer find a plaintext administrator password in the working tree.  
**Status:** Source fixed. Rotate all affected production administrator passwords immediately, inspect administrators for unknown accounts, and invalidate active sessions. History rewrite is secondary and must happen only after credential rotation.

### SEC-002 - Vulnerable Dependency Baseline

**Severity:** HIGH  
**Affected component:** `composer.lock`, `package-lock.json`, framework and frontend dependencies  
**Evidence:** Before update, `composer audit` returned 48 advisories affecting 16 packages, including framework-adjacent packages, while `npm audit` returned 2 critical, 7 high, and 1 moderate advisory.  
**Attack scenario:** Exploitability depends on whether each vulnerable code path is reached, but a public Laravel application and privileged Filament panel expose enough framework surface that leaving known advisories unresolved is not acceptable.  
**Impact:** Depending on advisory, impact can include request handling bypasses, denial of service, XSS, or server-side behavior compromise.  
**Fix:** Dependencies were updated within compatible major versions and the lockfiles were regenerated. PHP was pinned to a production-compatible 8.3 platform and Node 24 LTS was recorded in `.nvmrc`.  
**Verification:** `composer audit --locked --no-dev` and `npm audit` both report zero known advisories. `composer validate --strict` and `composer check-platform-reqs --no-dev` pass.  
**Status:** Fixed in branch. Do not deploy or extract the old `vendor.zip`.

### SEC-003 - Vehicle Upload Naming And Execution Boundary

**Severity:** HIGH  
**Affected component:** Filament car create/edit image uploads and public media directory  
**Evidence:** Upload validation limited browser-facing MIME and size, but the stored extension followed file-provided information. The runtime disk writes to `public/images/cars`, where executable-content prevention depends on the web server.  
**Attack scenario:** A polyglot or misleading file could receive a dangerous extension and, on a permissive PHP handler, be executed from the public upload directory.  
**Impact:** Potential remote code execution and complete application/server compromise.  
**Fix:** `app/Support/CarImageUpload.php:12-28` maps only server-observed `image/jpeg`, `image/png`, and `image/webp` to canonical extensions and uses a ULID name. Both upload forms use it, retain the 2 MB limit, and allow at most 13 files. `public/images/cars/.htaccess:1-5` disables indexing and denies PHP/PHTML/PHAR.  
**Verification:** Unit tests verify allowlisted MIME mappings and rejection of unsupported MIME. Feature tests verify the Apache rule is present.  
**Status:** Application fixed. OpenResty does not read `.htaccess`; cPanel/provider must add an equivalent no-execute rule.

### SEC-004 - Wildcard Trusted Proxy

**Severity:** HIGH if the origin is directly reachable or forwarded headers are not overwritten; otherwise MEDIUM  
**Affected component:** `bootstrap/app.php:16`, OpenResty-to-origin boundary  
**Evidence:** `trustProxies(at: '*')` accepts forwarded client/protocol data from every source. The real OpenResty CIDR is not available in the repository.  
**Attack scenario:** A direct origin caller supplies a forged `X-Forwarded-For` to rotate apparent IP addresses, weakening IP-based login/contact limits, or spoofs scheme/host-derived behavior.  
**Impact:** Brute-force and abuse controls may be bypassed; generated secure/canonical URLs can become inconsistent.  
**Fix:** Block direct origin access, have OpenResty replace forwarded headers, and replace `*` with provider-confirmed proxy IP/CIDR values.  
**Verification:** Requires provider configuration and a post-deploy request test from both edge and blocked direct origin.  
**Status:** Open. It was not changed blindly because an incorrect allowlist would break all traffic behind the proxy.

### SEC-005 - Missing Endpoint Rate Limits

**Severity:** MEDIUM  
**Affected component:** Login, registration, contact, inventory suggestions, favorites, account password  
**Evidence:** The routes previously lacked explicit throttles.  
**Attack scenario:** Automated clients submit credentials, create accounts, spam inquiries, or generate expensive searches at high frequency.  
**Impact:** Credential stuffing, inbox/data spam, resource exhaustion, and degraded availability.  
**Fix:** Named rate limiters were added in `AppServiceProvider.php:42-63` and attached in `routes/web.php:28-63`: login 5/min per email+IP, registration 5/hour/IP, contact 5/10 min/IP, suggestions 60/min/IP, favorites 30/min/user, account security 5/min/user.  
**Verification:** Feature tests prove the sixth login/contact request returns `429`; route listing confirms middleware placement.  
**Status:** Fixed in branch, subject to the trusted-proxy server action in SEC-004.

### SEC-006 - Sensitive Account Changes Did Not Revoke Sessions

**Severity:** MEDIUM  
**Affected component:** Customer password/profile updates and admin password reset  
**Evidence:** Password updates changed the hash but did not rotate `remember_token`; profile email could change without asking for the current password.  
**Attack scenario:** A stolen remembered login remains usable after the legitimate owner changes a password, or an unattended authenticated browser changes the login email.  
**Impact:** Persistent account access and account recovery disruption.  
**Fix:** Authenticated account routes use `auth.session`; password changes rotate the remember token and regenerate the current session. Admin resets do the same. Email changes require `current_password` and clear `email_verified_at`.  
**Verification:** `AccountPasswordTest` covers session rotation, current-password checks, and email-change behavior.  
**Status:** Fixed in branch. A complete pending-email verification workflow remains recommended before treating email as a verified identity factor.

### SEC-007 - Missing Canonical Redirects And Edge Security Headers

**Severity:** MEDIUM  
**Affected component:** OpenResty/cPanel TLS edge and Laravel HTML responses  
**Evidence:** On 22 August 2026, all of `http://rizkimobil.com`, `https://rizkimobil.com`, `http://www.rizkimobil.com`, and `https://www.rizkimobil.com` returned `200`; none redirected to one canonical HTTPS URL. The observed challenge response omitted HSTS, CSP, X-Content-Type-Options, clickjacking protection, Referrer-Policy, and Permissions-Policy.  
**Attack scenario:** Users may remain on HTTP; browsers do not receive defense-in-depth against framing, MIME confusion, or unnecessary capability access.  
**Impact:** Increased downgrade/session exposure risk and reduced mitigation for frontend injection/clickjacking classes.  
**Fix:** `SecurityHeaders.php:15-27` adds safe baseline application headers and HSTS only for secure production requests. cPanel/OpenResty must enforce HTTP and `www` redirects and add/retain headers at the edge.  
**Verification:** Feature tests verify application headers and conditional HSTS. Production must be retested after deployment past the challenge page.  
**Status:** Application fixed; edge/canonical configuration open.

### SEC-008 - Tracked Legacy `vendor.zip`

**Severity:** MEDIUM  
**Affected component:** Git repository and cPanel deployment workflow  
**Evidence:** `vendor.zip` is a tracked archive of an old dependency tree and includes development packages. The current `.gitignore` blocks future archives but cannot untrack an existing file.  
**Attack scenario:** The archive is deployed into or extracted under the web root, reintroducing vulnerable packages or allowing its contents to be downloaded.  
**Impact:** Dependency rollback, source disclosure, and avoidable public artifact exposure.  
**Fix:** Stop using the archive. Deploy with `composer install --no-dev` from the updated lockfile, then remove `vendor.zip` from Git and all deployed copies after confirming the new deployment path.  
**Verification:** `git ls-files vendor.zip` currently confirms the residual risk.  
**Status:** Open. Deletion was intentionally not forced because it may be part of the owner's current cPanel deployment process.

### SEC-009 - Contact PII In Exception Logs

**Severity:** MEDIUM  
**Affected component:** `ContactController.php:37-44`  
**Evidence:** Logging the raw database exception message can include SQL bindings containing contact name, email, phone, or message.  
**Attack scenario:** A database failure writes customer PII into logs that are retained, backed up, or viewed by more operators than the contact table.  
**Impact:** Unnecessary personal-data exposure and larger breach scope if logs are accessed.  
**Fix:** Log only a generic event, exception class, and code. Do not log request payload or raw exception message.  
**Verification:** A regression test injects sentinel PII, forces a database error, and proves the sentinel is absent from logged context.  
**Status:** Fixed in branch.

### SEC-010 - Server Version Disclosure

**Severity:** LOW  
**Affected component:** OpenResty response headers  
**Evidence:** Production returns `Server: openresty/1.31.1.1`.  
**Attack scenario:** An attacker can quickly correlate the exact product version with public advisories.  
**Impact:** Reconnaissance aid; not an exploit by itself.  
**Fix:** Configure the edge to suppress the version token and keep OpenResty patched.  
**Verification:** HEAD responses should no longer include an exact version.  
**Status:** Open cPanel/provider action.

### SEC-011 - Legacy Image Quality And Size Drift

**Severity:** LOW  
**Affected component:** Existing `public/images/cars` media  
**Evidence:** A passive local file inventory found 27 of 42 images larger than 2 MB and 25 MIME/extension mismatches. These are existing files, not newly accepted uploads.  
**Attack scenario:** Primarily operational: oversized media increases bandwidth and mismatches can create inconsistent caching/content handling.  
**Impact:** Performance, storage, and maintainability degradation.  
**Fix:** Normalize and recompress legacy images offline, preserve backups outside web root, and keep canonical extensions for new uploads.  
**Verification:** Re-run MIME and size inventory after maintenance.  
**Status:** Open maintenance item.

### SEC-012 - Administrator Authentication Assurance

**Severity:** LOW  
**Affected component:** Customer/admin password policy and Filament authentication  
**Evidence:** Passwords are securely hashed by Laravel and require at least 8 characters, but administrator MFA is not enforced.  
**Attack scenario:** A reused or phished administrator password is enough to access the panel.  
**Impact:** Administrator account takeover.  
**Fix:** Require unique long passphrases now and add Filament MFA/recovery-code support as a staged feature. Consider increasing the new-password baseline to 12 characters for administrators.  
**Verification:** Add MFA enrollment and recovery tests when implemented.  
**Status:** Open hardening item.

## 4. Changes Made

### Security Source Changes

| File | Change | Security reason |
| --- | --- | --- |
| `.env.example` | Marked local-only and documented session defaults | Prevent unsafe production copy/paste |
| `.gitignore` | Added archive, dump, SQLite, and backup patterns | Reduce accidental sensitive artifact commits |
| `.nvmrc` | Pins Node 24 | Use supported LTS build runtime instead of local Node 25 |
| `app/Support/CarImageUpload.php` | New canonical MIME-to-extension ULID naming helper | Do not trust client-associated extension |
| `app/Filament/Resources/Cars/Schemas/CarForm.php` | Applies hardened naming and 2 MB/JPEG-PNG-WebP constraints | Secure create upload |
| `app/Filament/Resources/Cars/RelationManagers/ImagesRelationManager.php` | Applies hardened naming to edit upload | Secure update upload |
| `app/Filament/Resources/Users/Pages/EditUser.php` | Rotates remember token on admin reset; protects admin lifecycle | Revoke remembered sessions and avoid admin lockout |
| `app/Http/Controllers/AccountController.php` | Re-authenticates email change; rotates tokens/session on password change | Protect sensitive account changes |
| `app/Http/Controllers/ContactController.php` | Removes raw exception messages and request PII from logs | Data minimization |
| `app/Http/Middleware/SecurityHeaders.php` | New baseline browser security headers and conditional HSTS | Browser defense in depth |
| `app/Providers/AppServiceProvider.php` | Adds named endpoint rate limiters and secure production URL forcing | Abuse and scheme protection |
| `bootstrap/app.php` | Enables trusted-host validation, proxy handling, and security middleware | Host/header hardening |
| `config/logging.php` | Uses warning-level production defaults and 14-day daily retention option | Limit sensitive/noisy production logs |
| `config/session.php` | Defaults production session cookie to Secure | Protect cookie transport |
| `database/seeders/AdminUserSeeder.php` | Deleted hardcoded administrator bootstrap | Remove credential and automatic privileged user creation |
| `database/seeders/DatabaseSeeder.php` | Removed administrator seeder call | Prevent privilege creation during seed |
| `public/.htaccess` | Disables indexing and blocks common backup/dump extensions | Reduce public artifact exposure on Apache |
| `public/images/cars/.htaccess` | Disables indexing and denies script extensions | Prevent upload execution on Apache |
| `resources/views/account/show.blade.php` | Adds current-password field for email changes | Support sensitive-change re-authentication |
| `routes/web.php` | Adds `auth.session` and named throttles | Revoke invalid sessions and rate-limit abuse |

### Dependencies And Generated Assets

| File or generated group | Change | Security reason |
| --- | --- | --- |
| `composer.json` | Requires PHP 8.3+, records PHP 8.3 deployment platform | Deterministic supported runtime |
| `composer.lock` | Updates Laravel/Filament and transitive packages | Resolve known advisories |
| `package-lock.json` | Updates npm dependency graph | Resolve known advisories |
| `public/build/manifest.json` | Regenerated Vite manifest | Reference updated hashed bundles |
| `public/build/assets/app-DIuewKhF.js`, `app-K5WLcWyA.css`, `theme-BpWibJRl.css` | Removed stale hashed bundles | Avoid serving obsolete build output |
| `public/build/assets/app-DUr89oQr.js`, `app-DJ15-YYV.css`, `theme-CKbHIMwk.css` | Added rebuilt bundles | Deploy audited frontend graph |
| `public/css/filament/filament/app.css` | Republished by Filament update | Keep panel assets aligned with package version |
| `public/fonts/filament/filament/inter/index.css` and four new Inter WOFF2 files | Republished by Filament update | Keep package asset set complete |
| `public/js/filament/actions/actions.js` | Republished by Filament update | Keep admin runtime aligned |
| `public/js/filament/filament/app.js`, `echo.js` | Republished by Filament update | Keep admin runtime aligned |
| `public/js/filament/forms/components/checkbox-list.js`, `code-editor.js`, `color-picker.js`, `date-time-picker.js`, `file-upload.js`, `key-value.js`, `markdown-editor.js`, `rich-editor.js`, `select.js`, `slider.js`, `tags-input.js`, `textarea.js` | Republished by Filament update | Keep form runtime aligned |
| `public/js/filament/notifications/notifications.js` | Republished by Filament update | Keep admin runtime aligned |
| `public/js/filament/schemas/components/actions.js`, `tabs.js`, `wizard.js`, and `public/js/filament/schemas/schemas.js` | Republished by Filament update | Keep schema runtime aligned |
| `public/js/filament/support/support.js` | Republished by Filament update | Keep support runtime aligned |
| `public/js/filament/tables/components/columns/checkbox.js`, `select.js`, `text-input.js`, `toggle.js`, and `public/js/filament/tables/tables.js` | Republished by Filament update | Keep table runtime aligned |
| `public/js/filament/widgets/components/chart.js`, `stats-overview/stat/chart.js` | Republished by Filament update | Keep widget runtime aligned |

### Regression Tests And Documentation

| File | Change | Security reason |
| --- | --- | --- |
| `tests/Feature/AccountPasswordTest.php` | Adds sensitive-change and session-revocation coverage | Prevent account regression |
| `tests/Feature/DatabaseSeederSecurityTest.php` | Proves seeding cannot create/promote a default admin | Prevent credential reintroduction |
| `tests/Feature/SecurityHardeningTest.php` | Covers headers, rate limits, PII logging, and `.htaccess` controls | Security regression suite |
| `tests/Unit/CarImageUploadTest.php` | Covers MIME allowlist and canonical naming | Upload regression suite |
| `docs/cpanel-security-hardening.md` | Adds exact owner/provider deployment checklist | Close controls outside the repository |
| `docs/security-audit.md` | This evidence-based audit report | Preserve findings, status, and actions |
| `tasks/todo.md` | Tracks audit execution and review | Repository workflow requirement |

## 5. Dependency Audit

| Component | Audited version | Status |
| --- | --- | --- |
| Laravel | 12.67.0 | Supported for security fixes until 24 February 2027 |
| Filament | 4.12.6 | Supported for security fixes until 15 January 2028 |
| PHP local CLI | 8.5.3 | Development runtime; production version remains unknown |
| PHP project/platform | `^8.3` / 8.3.0 | Use PHP 8.3 or 8.4 on cPanel and check extensions |
| Composer | 2.9.5 | Audit tooling current locally |
| Vite | 7.3.6 | Updated, zero npm advisories |
| Axios | 1.19.0 | Updated, zero npm advisories |
| Tailwind CSS | 4.3.3 | Updated, zero npm advisories |

The source was already on Laravel 12, not Laravel 10. A rushed Laravel 13 upgrade is not required for immediate incident containment. Laravel 12 is in security-only maintenance and should be upgraded through staging before 24 February 2027. Filament 4 remains supported beyond that date, but Laravel 13 and Filament compatibility must be tested before the major upgrade. Sources: `https://laravel.com/docs/12.x/releases` and `https://filamentphp.com/docs/5.x/introduction/version-support-policy`.

Direct outdated-package inspection shows major versions are available for Laravel (13), Filament (5), Tinker (3), PHPUnit (12), Vite (8), the Laravel Vite plugin (3), and concurrently (10). These are planned compatibility upgrades rather than unpatched advisories. Keep the current patched major versions for this incident deployment, then test the major upgrades together in staging.

Initial Composer audit: **48 advisories affecting 16 packages**. Final Composer audit: **0 advisories**.  
Initial npm audit: **10 advisories (2 critical, 7 high, 1 moderate)**. Final npm audit: **0 advisories**.

## 6. External Security Controls

Observed on 22 August 2026. The OpenResty challenge intercepted application responses, so controls that require the real Laravel response or session cookie are marked `UNKNOWN`.

| Control | Status | Evidence |
| --- | --- | --- |
| HTTPS redirect | **FAIL** | HTTP and HTTPS variants all returned `200`; no canonical redirect |
| TLS certificate | **PASS** | Valid Let's Encrypt certificate for apex and wildcard; valid 14 July to 12 October 2026 |
| TLS 1.2 / 1.3 | **PASS** | Both modern protocol versions negotiated during passive checks |
| HSTS | **FAIL at observed edge** | Header absent from challenge response |
| CSP | **FAIL at observed edge** | Header absent from challenge response |
| X-Content-Type-Options | **FAIL at observed edge** | Header absent from challenge response |
| Clickjacking protection | **FAIL at observed edge** | Neither X-Frame-Options nor CSP frame-ancestors observed |
| Referrer-Policy | **FAIL at observed edge** | Header absent from challenge response |
| Permissions-Policy | **FAIL at observed edge** | Header absent from challenge response |
| Session Secure | **UNKNOWN** | Laravel session cookie was not issued through the challenge response |
| Session HttpOnly | **UNKNOWN** | Laravel session cookie was not issued through the challenge response |
| SameSite | **UNKNOWN** | Laravel session cookie was not issued through the challenge response |
| Server version leakage | **FAIL** | Exact OpenResty version disclosed |
| `.env` inaccessible | **UNKNOWN** | Sensitive path returned challenge/soft `200`, not source content and not definitive `403/404` |
| `.git` inaccessible | **UNKNOWN** | Sensitive path returned challenge/soft `200` |
| Laravel logs inaccessible | **UNKNOWN** | Sensitive path returned challenge/soft `200` |
| Directory listing disabled | **UNKNOWN production** | Apache rules added in branch; OpenResty behavior not confirmed |

No sensitive file contents were observed. A challenge page returning `200` is not accepted as proof that the origin path is protected.

## 7. Tests Performed

### Source And Architecture Review

- Enumerated Laravel routes, middleware, Filament panel access, controllers, models, upload forms, storage disks, account flows, favorites, contact flow, inventory filters, queue/mail configuration, and public assets.
- Traced state-changing routes through Laravel web/CSRF middleware and server-side authorization.
- Reviewed Eloquent fillable/guarded behavior and searched for risky SQL, raw Blade output, unvalidated redirects, filesystem paths, shell/process calls, deserialization, server-side HTTP requests, and user-controlled query identifiers.
- Confirmed no exploitable SQL injection, XSS, IDOR, CSRF bypass, command injection, SSRF, path traversal, unsafe deserialization, or open redirect in the reviewed first-party code.
- Reviewed repository and Git history for credentials, private keys, environment files, dumps, and archives without printing discovered secret values.

### Automated Verification

- Full Laravel feature/unit test suite.
- Focused account, upload, rate-limit, security-header, logging, and seeder regression tests.
- `composer audit --locked --no-dev`.
- `npm audit`.
- `composer validate --strict`.
- `composer check-platform-reqs --no-dev`.
- `vendor/bin/pint --dirty`.
- `php artisan route:list`, `php artisan view:cache`, and Vite production build.
- `git diff --check` and post-fix secret/sink scans.

### Production Passive Checks

- Low-rate HEAD requests to apex/`www`, HTTP/HTTPS, selected error/sensitive paths, and normal public routes.
- TLS certificate, hostname, validity, and protocol negotiation inspection.
- Manual browser observation of the OpenResty verification challenge.
- No brute force, form spam, malicious upload, destructive database test, load test, or active OWASP ZAP scan was run against production.

## 8. Remaining Risks

1. Production administrator passwords and existing sessions cannot be rotated from this source checkout.
2. `vendor.zip` remains tracked and may still exist in deployed locations.
3. OpenResty canonical redirects, security headers, no-execute upload policy, direct-origin blocking, and forwarded-header sanitation are not verifiable from the repository.
4. The proxy IP/CIDR allowlist is unknown, so `trustProxies('*')` remains.
5. Production PHP version/extensions, `display_errors`, `expose_php`, file permissions, and MySQL privileges are unknown.
6. Real Laravel session cookie attributes are hidden behind the challenge response.
7. Sensitive-path responses are challenge/soft-200 and require origin-side verification after deployment.
8. Runtime uploads still live under a Git-managed public directory. Object storage or persistent `storage/app/public` is the preferred longer-term design.
9. Existing large/mismatched media requires offline normalization.
10. Administrator MFA and security event alerting are not yet implemented.
11. Email changes clear verification state, but the application does not yet provide a complete email-verification lifecycle.
12. No production database contents, backups, DNS zone, CDN/WAF console, or cPanel configuration were accessed during this audit.

## 9. Priority Action Plan

### P0 - Fix Immediately

1. Rotate every production administrator password associated with the former bootstrap credential. Use unique long passphrases.
2. Invalidate existing administrator sessions and remember tokens; inspect the administrator list and recent changes for unauthorized activity.
3. Deploy this hardening branch using the updated lockfiles. Do not deploy or extract `vendor.zip`.

### P1 - Fix Before Considering The Site Hardened

1. Point the domain document root to Laravel `public/` only and verify sensitive paths return `403/404`.
2. Configure HTTP and `www` to redirect permanently to `https://rizkimobil.com` without loops.
3. Add/retain security headers at OpenResty and verify the final Laravel HTML response, not only the challenge.
4. Block direct origin access, sanitize forwarded headers, obtain the OpenResty CIDR, and replace wildcard proxy trust.
5. Add an OpenResty no-execute rule for `/images/cars/` and disable directory indexes.
6. Set `APP_ENV=production`, `APP_DEBUG=false`, secure session values, warning-level daily logs, and PHP 8.3/8.4 as documented.

### P2 - Recommended Hardening

1. Remove `vendor.zip` from Git and deployment artifacts once the Composer-based deployment is confirmed.
2. Move runtime media to persistent Laravel storage or object storage/CDN.
3. Add administrator MFA with recovery codes and a 12+ character admin password policy.
4. Implement a complete verified-email change workflow.
5. Add centralized alerting for failed admin logins, account-role changes, bursts of `429`, and repeated `5xx` responses.

### P3 - Maintenance

1. Normalize/compress existing vehicle images and correct MIME/extension mismatches.
2. Schedule Composer/npm audits and automated tests for every deployment.
3. Test a Laravel 13 upgrade in staging well before Laravel 12 security support ends.
4. Test database/media restore procedures and keep encrypted backups outside the document root.

## Final Answers

1. **Is the site safe enough to remain online?** Not while the previously committed administrator credential might still be active. Rotate it immediately. After rotation, the site can remain online during a controlled hardening deployment with close monitoring, but it should not be described as hardened until P1 verification passes.
2. **What is the most dangerous confirmed issue?** A deterministic administrator credential was committed to Git history and automatically seeded, creating a plausible administrator-takeover path.
3. **What needs to be fixed immediately?** Rotate admin credentials, revoke sessions, inspect admin accounts/activity, deploy the updated lockfiles and source, and stop using `vendor.zip`.
4. **What did you already fix?** The branch removes the admin seeder, updates vulnerable dependencies, hardens uploads, adds throttling/security headers, protects sensitive account changes, minimizes contact logs, tightens session/log defaults, and adds regression tests.
5. **What still requires server/cPanel action?** Canonical HTTPS redirects, document root isolation, sensitive-path checks, OpenResty headers/no-execute rule, proxy CIDR/origin protection, production cookie/PHP verification, permissions, database privilege review, and backup/monitoring configuration.
6. **Should Laravel be upgraded now?** Not as an emergency major upgrade. The app is already on Laravel 12.67.0, which receives security fixes until 24 February 2027. Plan and test Laravel 13 in staging before that date.
7. **Final risk rating:** **HIGH RISK** until P0 and P1 actions are complete and retested.
8. **Final security score:** **62 / 100** for observed production before deployment; target approximately **81 / 100** after branch deployment and verified cPanel hardening.

# Production Security Verification

**Verification date:** 22 August 2026

**Branch:** `codex/security-rizki-mobil-hardening`

**Verification boundary:** Local source and low-impact public HTTP checks only. No authenticated cPanel, database, OpenResty, or production-shell access was available, so server-side controls remain `OPEN` unless independently evidenced below.

## Deployment Gate

The complete local pre-deployment gate passed: 46 Laravel tests with 208 assertions, zero Composer advisories, all production Composer platform requirements satisfied, zero npm advisories, successful Vite production build, and a clean `git diff --check`. A fresh temporary checkout also completed `composer install --no-dev --prefer-dist --optimize-autoloader --classmap-authoritative`; its Composer audit and platform check passed. This proves the lockfile-based deployment is reproducible without `vendor.zip`.

| Finding / Control | Status | Evidence |
| --- | --- | --- |
| Admin credential rotated | **OPEN** | No authenticated production access or operator evidence was available. The old value is not reproduced. |
| Old sessions revoked | **OPEN** | Production sessions, remember tokens, and old-session access to `/admin` could not be inspected. |
| Hardening branch deployed | **OPEN** | No repository deployment workflow, `.cpanel.yml`, or authenticated cPanel deployment path was available. Local/remote branch state is not production-deployment evidence. |
| Dependencies clean | **MITIGATED** | Local and fresh-install checks report zero Composer/npm advisories and all production platform requirements pass; production package installation is unverified. |
| `vendor.zip` removed | **MITIGATED** | Removed from the deployable repository and ignored; Composer-only installation was reproduced. Production/public copies remain unverified. |
| Document root correct | **OPEN** | Sensitive and normal URLs are intercepted by the same OpenResty soft/challenge `200`; origin layout cannot be inferred. |
| Sensitive files inaccessible | **OPEN** | No file contents were observed, but each tested sensitive path returned generic HTML `200`, not the required real `403/404`. |
| HTTP -> HTTPS | **OPEN** | `http://rizkimobil.com/` returned `200`, not a permanent redirect. |
| `www` -> apex | **OPEN** | HTTP and HTTPS `www` variants returned `200`, not a permanent redirect to the apex host. |
| Security headers | **OPEN** | HSTS, CSP/frame protection, `X-Content-Type-Options`, `Referrer-Policy`, and `Permissions-Policy` were absent from the observed edge response. Application middleware is covered locally only. |
| Trusted proxy restricted | **OPEN** | `trustProxies('*')` remains because the real provider CIDR is unknown and must not be guessed. |
| Forwarded headers sanitized | **OPEN** | Requires OpenResty/provider configuration evidence and a benign forged-header verification. |
| Direct origin protected | **OPEN** | Origin address/access policy is unavailable from the public edge and repository. |
| Upload execution blocked | **MITIGATED** | Laravel canonical MIME/ULID storage and Apache no-execute rules are tested locally; equivalent OpenResty behavior is unverified. |
| Secure cookies | **OPEN** | The edge challenge did not issue a verifiable customer/admin Laravel session cookie. |
| PHP production config | **OPEN** | PHP version, `display_errors`, `log_errors`, and `expose_php` require cPanel/server inspection. |
| DB least privilege | **OPEN** | Production database user and grants were not accessed; no credentials were printed. |

## Finding Reclassification

| Finding | Status | Verification conclusion |
| --- | --- | --- |
| SEC-001 | **OPEN** | Seeder removal is verified, but production credential rotation, account inspection, and session invalidation are not. |
| SEC-002 | **MITIGATED** | Clean audited lockfiles and reproducible no-dev install are verified locally; production deployment is not. |
| SEC-003 | **MITIGATED** | Application upload controls and Apache rule are tested; OpenResty no-execute enforcement remains open. |
| SEC-004 | **OPEN** | Provider proxy CIDR, forwarded-header replacement, and origin blocking remain unknown. |
| SEC-005 | **MITIGATED** | Named throttles and regression tests pass locally; production depends on deployment and SEC-004. |
| SEC-006 | **MITIGATED** | Sensitive-change/session protections pass local tests; production deployment is unverified. |
| SEC-007 | **OPEN** | Laravel middleware is implemented, but the observed production edge still lacks canonical redirects and headers. |
| SEC-008 | **MITIGATED** | The archive is removed from the deployable repository and Composer-only deployment is reproducible; production removal remains open. |
| SEC-009 | **MITIGATED** | PII-minimized exception logging passes regression coverage; production deployment is unverified. |
| SEC-010 | **OPEN** | Production still discloses `openresty/1.31.1.1`. |
| SEC-011 | **OPEN** | Legacy media normalization remains a maintenance task. |
| SEC-012 | **OPEN** | Administrator MFA and the stronger administrator password baseline are not implemented. |

No finding is marked `CLOSED`: production evidence does not yet satisfy closure criteria. No finding has been owner-accepted as residual risk.

## Verification Answers

1. **Is Rizki Mobil safe enough to remain online?** Not yet at an acceptable hardened-production threshold. Because SEC-001 remains open, production should be treated as an urgent incident-containment case until all affected administrator credentials are rotated, sessions are invalidated, and accounts are inspected. If the site must remain online, restrict and monitor admin access while completing those actions immediately.
2. **Is the old admin credential fully neutralized?** No. The source bootstrap path is removed, but there is no production evidence for credential rotation or old-session revocation.
3. **Which findings remain OPEN?** SEC-001, SEC-004, SEC-007, SEC-010, SEC-011, and SEC-012. SEC-002, SEC-003, SEC-005, SEC-006, SEC-008, and SEC-009 are mitigated in the branch but not production-closed.
4. **Which items still require manual cPanel/provider action?** Deploy the branch and audited dependencies; rotate admins/revoke sessions; remove every production `vendor.zip`; verify the `/public` document root and real sensitive-path `403/404`; configure canonical redirects, edge headers, trusted proxy CIDR, forwarded-header replacement, direct-origin blocking, and upload no-execute; verify environment/PHP/cookies/permissions/database grants; then run authenticated smoke tests.
5. **Did any security change break existing functionality?** No regression was found locally: all 46 tests, asset build, dependency checks, and fresh production-style Composer install passed. Production functionality after deployment is still unverified.
6. **Updated risk rating:** **HIGH**. The CRITICAL finding remains operationally open, although its source bootstrap mechanism is removed.
7. **Updated security score:** **62 / 100** for the currently observed production state. The score is intentionally unchanged until P0 and security-critical P1 controls are verified in production.

Completion criteria are **not yet met**. All P0 findings and security-critical P1 controls must be verified in production before this verification can be considered complete. The site is not claimed to be 100% secure.
