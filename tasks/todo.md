# Task Plan

## Current Task: Add Header Brand Promise And Cap Credit Tenor
- [x] Add the requested brand promise text under the RMI logo without crowding the header
- [x] Make credit simulator tenor stop at a configurable maximum of 5 years
- [x] Update regression coverage, verify rendered header/simulator behavior, build assets, and document results

### Review: Add Header Brand Promise And Cap Credit Tenor
- Added the requested three-line sales promise directly under the RMI logo in the shared header: quality used cars, cash/credit, and Indonesia-wide processing.
- Moved the credit simulator tenor cap into `config/rizki.php` and wired the detail-page simulator loop to that value, defaulting to a maximum of 5 years.
- Added regression coverage for the new header copy and the simulator loop contract.
- Browser QA confirmed the header promise renders on desktop and mobile without horizontal overflow, and the credit simulator now renders 5 result cards with no `6 Tahun` card.
- Verification passed: `php artisan view:cache`, `npm run build`, `php artisan test`, `git diff --check`, `php artisan config:cache`, then `php artisan optimize:clear`.

## Current Task: Rebalance Mobile Hero Vehicle Visibility
- [x] Locate the mobile hero typography, overlay, chip, and CTA rules
- [x] Reduce mobile text dominance while preserving premium first-viewport hierarchy
- [x] Verify rendered mobile hero/search rhythm, rebuild assets, and document results

### Review: Rebalance Mobile Hero Vehicle Visibility
- Reduced only the mobile hero text scale, model scale, price scale, spec chip height, and CTA height so the vehicle photo remains the visual focus.
- Kept the desktop hero unchanged and preserved the same carousel/CTA structure.
- Browser DOM QA at 390px and 430px confirmed no horizontal overflow, compact mobile typography, 44px spec chips, 48px CTA buttons, and the search panel still following the hero cleanly.
- CTA proof passed by reading the active `View Details` link and loading its detail page successfully with no console warnings/errors.
- Browser screenshot capture timed out in the in-app Browser CDP path, so visual proof relied on the provided reference image plus computed render metrics/DOM checks.
- Verification passed: `php artisan view:cache`, `npm run build`, `php artisan test`, and `git diff --check`.

## Current Task: Polish Closing CTA Image Accents
- [x] Identify the line collision source in the closing CTA media panel
- [x] Replace the full-width scan line with a cleaner image accent that does not collide with surrounding dividers
- [x] Verify desktop/mobile rendering, rebuild assets, and document results

### Review: Polish Closing CTA Image Accents
- Removed the hard left border from the closing CTA media panel and replaced it with a soft vertical fade separator.
- Reworked the long scan line into a shorter angled accent with a small glow point, so it no longer visually collides with the panel divider or cuts across the full image.
- Added a mobile-specific treatment that keeps the image separator subtle and the scan accent short.
- Browser DOM QA confirmed no horizontal overflow at desktop/mobile widths, with the scan line starting away from the media edge instead of connecting to surrounding borders.
- Verification passed: `php artisan view:cache`, `npm run build`, `php artisan test`, and `git diff --check`.

## Current Task: Improve Mobile Responsiveness Across Storefront
- [x] Audit homepage hero/search, shared header/footer, inventory, detail, saved, account, and contact responsive patterns
- [x] Redesign the mobile hero image/text/action rhythm so the first viewport is readable and not crowded
- [x] Make the homepage "Temukan Mobil Impian Anda" search panel larger, clearer, and touch-friendly on mobile
- [x] Add targeted shared responsive safeguards for key storefront pages without broad layout rewrites
- [x] Run build/tests, inspect mobile rendering where possible, and document review results

### Review
- Mobile homepage hero was trimmed and rebalanced so the photo/copy area no longer pushes the search card too far down on 390px screens.
- Homepage search controls now use stable 58px mobile touch targets, 16px text, custom select affordances, and a larger 60px search button.
- Browser QA confirmed no horizontal overflow on home, inventory, car detail, contact, login, register, saved, and account routes at 390px, 430px, and 768px widths.
- Final 390px homepage metrics: `scrollWidth/clientWidth = 390/390`, search inputs `58px`, search button `60px`, and the search button remains the top clickable element instead of the floating WhatsApp CTA.
- `php artisan view:cache`, `npm run build`, `php artisan test`, and `git diff --check` passed.

## Current Task: Clarify Credit Simulator Readonly Fields
- [x] Mark fixed vehicle context fields as readonly with clear visual treatment
- [x] Keep only user-decision fields editable in the credit simulator
- [x] Remove obsolete editable-price JavaScript behavior
- [x] Update regression coverage and run deploy-safe verification

### Review: Clarify Credit Simulator Readonly Fields
- Changed the simulator's fixed unit context fields and OTR price to readonly, visually locked fields so customers do not think they can edit listing data.
- Kept only the true customer inputs active: DP amount, DP percent, insurance, region, and protection.
- Removed the obsolete editable-price JavaScript handler now that OTR comes from the listing.
- Added regression coverage for the readonly OTR contract and removed `syncCreditPrice` from the rendered page.
- Verification passed: `php artisan view:cache`, `php artisan test tests/Feature/CarDetailTest.php`, full `php artisan test`, `npm run build`, `php artisan config:cache`, `git diff --check`, then `php artisan optimize:clear`.
- Browser rendered verification was attempted through the in-app Browser path, but the local app database connection is currently refused on MySQL `127.0.0.1:3306`, so no reliable local detail page could be rendered without changing environment data.

## Current Task: Fix Credit Simulator TDP And Minimum DP
- [x] Make displayed TDP match the entered down payment amount
- [x] Add configurable minimum down payment rules
- [x] Enforce minimum DP in amount and percent inputs with clear feedback
- [x] Update coverage and run deploy-safe verification

### Review: Fix Credit Simulator TDP And Minimum DP
- Changed simulator results so `TDP` equals the validated down payment amount entered by the user, instead of silently adding admin/protection/insurance costs and creating a confusing mismatch.
- Added configurable minimum DP rules in `config/rizki.php`: default minimum is 20% of OTR, with optional fixed nominal override through `RIZKI_FINANCING_MIN_DP_AMOUNT`.
- Added inline minimum-DP helper/error text; amount and percentage inputs now clamp to the allowed minimum before rendering results.
- Verification passed: PHP syntax checks, `php artisan view:cache`, `php artisan test tests/Feature/CarDetailTest.php`, full `php artisan test`, `npm run build`, `php artisan config:cache`, `git diff --check`, then cache clears.

## Current Task: Rebalance Car Detail Price Layout
- [x] Move unit location content into the left detail column to reduce dead whitespace
- [x] Redesign the price estimate block so numbers do not wrap awkwardly
- [x] Remove BCA Finance branding from the price card and credit simulator
- [x] Update tests and run deploy-safe verification

### Review: Rebalance Car Detail Price Layout
- Moved `Lokasi Unit` from the right sidebar to the left content column under `Tentang Kendaraan Ini`, so short descriptions no longer leave the left side feeling empty while the right side keeps stacking cards.
- Reworked `Estimasi Biaya` into a compact two-metric summary with clear TDP and monthly installment values, avoiding the previous three narrow boxes that made currency wrap badly.
- Removed BCA Finance branding from both the price card and credit simulator modal, replacing it with neutral financing copy.
- Verification passed: `php artisan view:cache`, `php artisan test tests/Feature/CarDetailTest.php`, full `php artisan test`, `npm run build`, `php artisan config:cache`, `git diff --check`, then cache clears.

## Current Task: Replace Budget WhatsApp CTA With Credit Simulator
- [x] Review existing financing estimate block and car-detail scripts
- [x] Replace `Sesuaikan Budget` WhatsApp link with an in-page credit simulator modal
- [x] Add responsive simulator form, reset, calculate behavior, and 1-6 year result cards
- [x] Update coverage and run deploy-safe verification

### Review: Replace Budget WhatsApp CTA With Credit Simulator
- Changed `Sesuaikan Budget` from an outbound WhatsApp link into an in-page `Simulasi Kredit` modal on the car detail page.
- Added prefilled vehicle fields, OTR price, editable down payment in Rupiah and percent, insurance/region/protection controls, reset, calculate, BCA Finance treatment, and result cards for 1-6 year tenors.
- Moved simulator assumptions into `config/rizki.php` so down-payment, interest, admin fee, protection, insurance, and region multipliers can be tuned without rewriting the Blade.
- Updated car detail regression coverage to confirm the simulator UI is rendered and the old budget WhatsApp query is gone.
- Verification passed: `php artisan view:cache`, `php artisan test tests/Feature/CarDetailTest.php`, full `php artisan test`, `npm run build`, `php artisan config:cache`, `git diff --check`, then cache clears.

## Current Task: Add Financing Estimate To Car Detail Price
- [x] Locate the car-detail price block, formatting helpers, and current available car data
- [x] Add a clean financing estimate UI under the price for every car detail page
- [x] Keep the estimate deterministic from car price and responsive with the current detail layout
- [x] Add/adjust regression coverage and run deploy-safe verification

### Review: Add Financing Estimate To Car Detail Price
- Added a config-driven financing estimate to every car detail price card: 5-year tenor, TDP, monthly installment estimate, BCA Finance wordmark treatment, and a `Sesuaikan Budget` WhatsApp CTA.
- Kept calculation logic in the `Car` model and rates in `config/rizki.php`, so the Blade stays focused on presentation and the estimate can be tuned later without changing markup.
- Added regression coverage to confirm the car detail page renders the financing estimate under the price.
- Verification passed: PHP syntax checks, `php artisan view:cache`, `php artisan test tests/Feature/CarDetailTest.php`, full `php artisan test`, `npm run build`, `php artisan config:cache`, `git diff --check`, then cache clears.

## Current Task
- [x] Read the latest `AGENTS.md`
- [x] Create `tasks/todo.md`
- [x] Create `tasks/lessons.md`
- [x] Confirm the workflow will be used for subsequent tasks

## Current Task: Add Image Upload On Create Car
- [x] Review the existing create/edit car flow, image relation manager, and `car_images` schema
- [x] Add a create-only image upload field to the car form with the same upload constraints as edit
- [x] Persist uploaded images as `CarImage` records after a new `Car` is created
- [x] Verify the new flow with syntax checks and document the review result

## Current Task: Add Back To Index Admin Action
- [x] Review the current create/edit car admin pages and choose the minimal place to add index navigation
- [x] Add a header action on the create and edit car admin pages that links back to the index page
- [x] Verify syntax and document the review result

## Current Task: Add Store Index Shortcut From Admin
- [x] Confirm which frontend route renders `index.blade.php`
- [x] Add a header action on the create and edit car admin pages that links to the frontend store homepage
- [x] Verify syntax and document the review result

## Current Task: Move Store Shortcut To Global Admin Header
- [x] Inspect the Filament panel setup and choose the correct global topbar hook
- [x] Remove the page-specific store shortcut from create/edit pages
- [x] Add a global admin-header store shortcut that is available from anywhere in the panel
- [x] Verify syntax and document the review result

## Current Task: Add Testimonial Section To Homepage
- [x] Review the homepage Blade, controller data, and existing design language
- [x] Add testimonial/rating data to the homepage controller in a way that keeps the view clean
- [x] Implement an elegant testimonial section on `index.blade.php` that matches the site theme
- [x] Verify syntax and document the review result

## Current Task: Reorder Homepage Story Sections
- [x] Review the current homepage section order and available local imagery for the introduction block
- [x] Move the testimonial section below `Mengapa Memilih Rizki Mobil`
- [x] Add a theme-matching Rizki Mobil introduction section below testimonials
- [x] Verify syntax and document the review result

## Current Task: Refine Rizki Mobil Intro Section
- [x] Review the current about-section copy and layout to identify why it feels too long and less elegant
- [x] Shorten the Rizki Mobil intro copy and improve information hierarchy
- [x] Redesign the section layout for a cleaner, more elegant presentation
- [x] Verify syntax and document the review result

## Current Task: Elevate Rizki Mobil Intro Elegance
- [x] Review the refined about-section and identify the remaining visual heaviness
- [x] Simplify the left-side hierarchy and supporting highlights for a more editorial look
- [x] Refine the right-side brand panel to feel lighter and more premium
- [x] Verify syntax and document the review result

## Current Task: Align Why Choose Background With Testimonials
- [x] Review the visual break between the `Mengapa Memilih Rizki Mobil` and testimonial sections
- [x] Update the `Mengapa Memilih Rizki Mobil` background to match the testimonial tone and transition
- [x] Verify Blade compilation and document the review result

## Current Task: Merge Why Choose And Testimonials Background
- [x] Review the remaining visual seam between the `Mengapa Memilih Rizki Mobil` and testimonial sections
- [x] Refactor the homepage markup/CSS so both sections share one continuous background wrapper
- [x] Verify Blade compilation and document the review result

## Current Task: Add Homepage FAQ Section
- [x] Review the homepage structure, CTA placement, and the cleanest source for FAQ content
- [x] Add curated FAQ data and implement a theme-matching FAQ section above the final CTA
- [x] Verify Blade compilation and document the review result

## Current Task: Move Car Search To Global Header
- [x] Inspect the header layout, inventory filtering flow, and the cleanest suggestion data source for available stock
- [x] Add a global header search with live suggestions sourced from available cars
- [x] Remove redundant visible search inputs from the homepage and inventory page while preserving query behavior
- [x] Verify Blade/controller changes and document the review result

## Current Task: Convert Mileage Filter To Preset Buttons
- [x] Inspect the current mileage filter UI and request handling in the inventory page
- [x] Replace mileage min/max inputs with theme-matching preset buttons for desktop and mobile
- [x] Verify the filter behavior and document the review result

## Current Task: Split Search UX Between Home And Inventory
- [x] Inspect the current header search and homepage layout to choose a clean route-based split
- [x] Restore the homepage floating search card while keeping the inventory header search pattern
- [x] Verify Blade/controller changes and document the review result

## Current Task: Merge About And FAQ Background
- [x] Inspect the current About Rizki Mobil and FAQ section backgrounds and markup
- [x] Refactor the homepage markup/CSS so About and FAQ share one continuous background wrapper
- [x] Verify Blade compilation and document the review result

## Current Task: Upgrade Admin Dashboard Visualization
- [x] Review `AGENTS.md` and `tasks/lessons.md` before starting this non-trivial task
- [x] Audit the current Filament dashboard widgets, theme, and available admin data
- [x] Redesign the dashboard information hierarchy so the most important admin insights are easier to scan
- [x] Add relevant dashboard visualizations for lead trend, stock distribution, and inventory health
- [x] Refine the admin dashboard theme/layout so it feels more polished and professional
- [x] Verify syntax/view compilation and document the review result

## Current Task: Refocus Admin Dashboard On Sales
- [x] Read `AGENTS.md` and relevant `tasks/lessons.md` notes before implementation
- [x] Audit the current dashboard data model and identify available sales signals
- [x] Replace lead-focused dashboard widgets with sales/inventory performance widgets
- [x] Verify syntax/build behavior and document the review result

## Current Task: Align Admin Dashboard Theme With Storefront
- [x] Review the current Filament theme CSS and storefront red/black/white visual language
- [x] Replace amber/slate admin styling with red gradients for dark and light mode
- [x] Verify CSS build/view behavior and document the review result

## Current Task: Make Footer Content More Relevant
- [x] Review the existing footer, routes, and available contact/inventory links
- [x] Replace placeholder footer content with showroom-relevant navigation, services, and contact CTAs
- [x] Verify Blade compilation/tests and document the review result

## Current Task: Simplify Footer To Useful Essentials
- [x] Capture the correction that the previous footer was too busy
- [x] Reduce footer content to only the most useful buyer actions
- [x] Verify Blade compilation/tests and document the review result

## Current Task: Redesign Contact Page UI
- [x] Review contact route, controller validation, and current Blade form fields
- [x] Replace the plain contact page with a polished Rizki Mobil contact experience
- [x] Verify Blade/controller syntax and tests, then document the review result

## Current Task: Add Long-Term Dashboard Performance
- [x] Review `AGENTS.md`, `tasks/lessons.md`, and existing sales dashboard widgets
- [x] Expand sales performance visualization beyond the current monthly/short-range view
- [x] Adjust dashboard copy/KPI framing so admins can read long-term sales performance clearly
- [x] Verify syntax, view compilation, and tests, then document the review result

## Current Task: Redesign Homepage About Section
- [x] Review `AGENTS.md`, `tasks/lessons.md`, and the existing homepage About/FAQ visual flow
- [x] Redesign the `Tentang Rizki Mobil` section to feel more premium, intriguing, and aligned with the red/black/white showroom mood
- [x] Keep the change scoped to the homepage section and preserve the shared About/FAQ background continuity
- [x] Verify Blade compilation/build behavior and inspect the rendered section before documenting results

## Current Task: Redesign Homepage FAQ Section
- [x] Review `AGENTS.md`, `tasks/lessons.md`, and current FAQ/CTA markup
- [x] Replace the flat FAQ card grid with a more premium decision-desk layout aligned to the showroom dossier mood
- [x] Keep the change scoped to the homepage FAQ area while preserving the CTA and shared About/FAQ background continuity
- [x] Verify Blade compilation/build behavior and inspect desktop/mobile render before documenting results

## Current Task: Redesign Homepage Closing CTA
- [x] Review `AGENTS.md`, `tasks/lessons.md`, and current closing CTA markup
- [x] Replace the flat red CTA bar with a more premium showroom-style closing section that matches the homepage dossier mood
- [x] Preserve the existing inventory/contact actions while improving hierarchy, visual interest, and responsive behavior
- [x] Verify Blade compilation/build behavior and inspect desktop/mobile render before documenting results

## Current Task: Reduce Homepage Section Redundancy
- [x] Review `AGENTS.md`, `tasks/lessons.md`, and the three repeated About/FAQ/CTA compositions
- [x] Replace repeated dark cards and redundant warm/grid backgrounds with clearer section rhythm: editorial About, open FAQ ledger, and full-bleed closing CTA
- [x] Preserve the same content, routes, and brand mood while reducing nested cards and duplicated visual devices
- [x] Verify Blade compilation/build behavior and inspect desktop/mobile render before documenting results

## Current Task: Redesign Contact Page
- [x] Review `AGENTS.md`, `tasks/lessons.md`, and the current contact page/form structure
- [x] Replace the ordinary contact composition with a more premium concierge-style contact experience
- [x] Preserve the existing contact form route, validation fields, WhatsApp path, and brand mood
- [x] Verify Blade/build/test behavior and inspect desktop/mobile render before documenting results

## Current Task: Remove Repeated Vehicle Imagery
- [x] Review current image reuse across About, closing CTA, and Contact visual sections
- [x] Give each section a distinct vehicle image role so repeated page moments no longer look copy-pasted
- [x] Preserve section content, routes, and brand mood while changing only the visual assets/crops needed
- [x] Verify Blade/build/test behavior and inspect the affected rendered sections before documenting results

## Current Task: Redesign Header And Footer
- [x] Review the current layout header/footer partials and shared navigation behavior
- [x] Redesign header into a more premium showroom command bar while preserving nav, login/admin, stock CTA, and inventory search behavior
- [x] Redesign footer into a stronger closing band with clearer brand/action hierarchy and concise useful links
- [x] Verify Blade/build/test behavior and inspect desktop/mobile render before documenting results

## Current Task: Smoke Test User And Admin
- [ ] Run server-side syntax/build/test checks to catch Laravel, Vite, and PHPUnit errors
- [ ] Render user-facing pages and exercise key interactions for console/HTTP/UI errors
- [ ] Render admin login/dashboard routes and verify Filament surfaces for visible/runtime errors
- [ ] Document findings, fixes if needed, and remaining risk

## Current Task: Optimize Inventory Scalability
- [x] Review inventory, car image accessors, admin car table, and database indexes for 200+ stock readiness
- [x] Add focused eager-loading/image-query improvements so user and admin lists avoid avoidable N+1 queries
- [x] Add practical database indexes for common stock filters and sort paths
- [x] Verify syntax, migrations, view/build/test behavior, and document the performance result

## Current Task: Harden Inventory Filter Contract
- [x] Review current homepage/header/inventory filter parameters and identify inconsistent query names
- [x] Unify keyword search around `search` while keeping legacy `model` links compatible
- [x] Harden filter parsing for price range, arrays, numeric ranges, and sort values
- [x] Verify filter behavior with syntax, view cache, build/tests, and targeted query checks

## Current Task: Simplify Contact Page UI
- [x] Review the current contact page structure and identify stacked/overdesigned areas
- [x] Redesign the contact page into a simpler clean layout while preserving form fields, WhatsApp CTA, and routes
- [x] Remove visual clutter and tighten responsive behavior
- [x] Verify Blade/build/tests and inspect the rendered contact page on desktop/mobile

## Current Task: Right-Size Footer
- [x] Review current footer hierarchy and identify why it feels like an oversized section
- [x] Refactor footer into a compact premium closing band while preserving brand, nav, WhatsApp, stock CTA, and legal copy
- [x] Tighten desktop/mobile spacing so the footer feels useful without dominating the page
- [x] Verify Blade/build/tests and inspect the rendered footer on desktop/mobile

## Current Task: Improve Trust And Testimonials Section
- [x] Review the current `Mengapa Memilih Rizki Mobil` and testimonial section structure
- [x] Redesign benefit cards and testimonial layout so the section feels more premium and less repetitive
- [x] Preserve existing copy/data/routes while improving hierarchy, spacing, and responsive behavior
- [x] Verify Blade/build/tests and inspect the rendered section on desktop/mobile

## Current Task: Add User And Admin Account Creation
- [x] Review current auth routes, `User` model/admin gate, header login behavior, and Filament resource patterns
- [x] Add public customer registration/login/logout routes and Blade views
- [x] Update storefront header so visitors can register/login and authenticated users can logout or access admin when eligible
- [x] Add a Filament `Users` resource so admins can create/edit customer or admin accounts safely
- [x] Add feature coverage for registration/login/admin protection and verify syntax/build/tests

## Current Task: Implement Saved Cars Flow
- [x] Review existing favorite model/table/API, car detail save placeholder, and header navigation
- [x] Add authenticated web routes for saving/unsaving cars and viewing saved cars
- [x] Replace the detail-page alert with a real save/login-gated action
- [x] Add a clean saved-cars page and header access point
- [x] Add feature coverage and verify syntax/build/browser behavior

## Current Task: Limit Admin Car Photo Upload Size
- [x] Review the create-car and edit-car image upload fields
- [x] Lower admin car photo uploads to 2 MB per file
- [x] Verify PHP syntax, view compilation, tests, and diff hygiene

### Review: Limit Admin Car Photo Upload Size
- Create-car bulk photo upload now rejects images above 2 MB per file.
- Edit-car `Tambah Foto` upload now uses the same 2 MB limit and helper text.
- `php -l`, `php artisan view:cache`, `php artisan test`, and `git diff --check` passed.

## Current Task: Add Account Info And Password Management
- [x] Review current auth/register/header account surfaces
- [x] Add phone storage and require phone during public registration
- [x] Add authenticated account page for viewing account info and changing password
- [x] Update header so the current account is visible and clickable from the right side
- [x] Add tests for phone/password validation and password update, then verify build/browser behavior

## Current Task: Improve Account Settings Best Practice
- [x] Review the current account page and identify why it feels read-only/landing-like
- [x] Add editable profile information for the signed-in user
- [x] Redesign account page into a compact settings layout with profile, security, and saved-car access
- [x] Add tests for profile update and validation
- [x] Verify syntax, routes, Blade, build, tests, and browser behavior

## Current Task: Fix Responsive Layout Across Pages
- [x] Review the mobile overflow shown on the car detail page and identify reusable layout risks
- [x] Patch global and page-level responsive constraints without changing unrelated behavior
- [x] Check adjacent public pages for obvious mobile overflow hotspots
- [x] Verify Blade/build/test behavior and run mobile browser smoke checks

## Current Task: Fix Deployed Admin 403
- [x] Trace the admin authorization path that can produce 403 after login
- [x] Move admin access to the Filament user contract and keep middleware aligned with the authenticated request user
- [x] Add a safe CLI command to promote/demote admin users in production
- [x] Add tests for admin access, non-admin rejection, and the production admin command
- [x] Verify syntax, route behavior, and test suite

## Current Task: Fix Hosted Admin Dashboard Blank Widgets
- [x] Inspect the dashboard widget rendering path shown as empty skeleton cards in production
- [x] Disable lazy widget loading for dashboard widgets so content is server-rendered on first response
- [x] Add regression coverage that an admin dashboard response contains real widget copy
- [x] Verify syntax, Blade cache, and tests

## Current Task: Diagnose Hosted Admin CRUD Failure
- [x] Review repo workflow, previous admin-access lessons, and current dirty worktree
- [x] Trace Filament resource CRUD authorization and hosting-sensitive request paths
- [x] Reproduce or add regression coverage for admin create/edit/delete access
- [x] Apply the minimal root-cause fix if local evidence confirms one
- [x] Verify syntax, route behavior, test suite, and document deployment notes

### Review: Diagnose Hosted Admin CRUD Failure
- Local Filament CRUD regression coverage now proves admins can create and update cars through the actual Filament Livewire pages.
- Added hosting hardening for proxy/HTTPS handling so Filament and Livewire admin actions behave correctly behind shared hosting, reverse proxies, or SSL termination.
- Added `location_id` to the car model fillable contract so branch/location data from the admin form is explicitly persisted.
- Added user-account delete actions while preventing admins from deleting their currently signed-in account.
- `php -l`, `php artisan view:cache`, `php artisan route:cache`, `php artisan test`, and `git diff --check` passed; local caches were cleared afterward with `php artisan optimize:clear`.
- Browser smoke fallback was attempted, but the Browser skill cache path was unavailable and the local Node environment does not have Playwright installed; verification relied on Laravel/Livewire regression tests instead.

## Current Task: Fix Hosted Edit Car Photo Relation
- [x] Compare local vs hosted symptom and inspect Filament relation manager loading behavior
- [x] Disable lazy loading for the car photos relation manager so rows render on initial edit response
- [x] Add regression coverage for the non-lazy relation manager behavior
- [x] Verify syntax, Blade cache, route behavior, tests, and document deployment notes

### Review: Fix Hosted Edit Car Photo Relation
- Root cause is consistent with Filament relation managers being lazy by default; hosting was rendering the placeholder but not hydrating the relation manager table.
- `ImagesRelationManager` now has `protected static bool $isLazy = false`, so the photo table renders directly in the edit car response like the local screenshot.
- Added regression coverage that asserts the photo relation manager no longer sends the `lazy` property and that the edit page response contains the photo table copy.
- `php -l`, `php artisan view:cache`, `php artisan route:cache`, `php artisan test`, and `git diff --check` passed; local caches were cleared afterward with `php artisan optimize:clear`.

## Current Task: Fix Hosted Admin Edit Save Action
- [x] Identify that edit-page rendering now works but the save action still depends on Livewire update requests
- [x] Move Livewire update requests to an admin-scoped endpoint to avoid hosting/cPanel root Livewire route issues
- [x] Add regression coverage that admin pages advertise the new update endpoint
- [x] Verify syntax, route cache, view cache, tests, and document deployment notes

### Review: Fix Hosted Admin Edit Save Action
- Edit pages now still render normally, and Livewire update actions use `POST /admin/livewire/update` instead of relying on the root `/livewire/update` endpoint that can be blocked or mishandled in hosting.
- Added regression coverage that confirms `Livewire::getUpdateUri()` returns `/admin/livewire/update` and the admin route is registered.
- Route checks show both the new admin-scoped update route and the default Livewire routes are available; Livewire chooses the admin-scoped route for page actions.
- `php -l`, `php artisan view:cache`, `php artisan route:cache`, `php artisan test`, and `git diff --check` passed; local caches were cleared afterward with `php artisan optimize:clear`.

## Current Task: Verify Admin Location And User CRUD
- [x] Review current Filament location and user create/edit/delete surfaces
- [x] Tighten location and user forms for operational best practice
- [x] Add Filament Livewire regression coverage for location create/update and user create/update
- [x] Verify syntax, route behavior, view cache, tests, and document deployment notes

### Review: Verify Admin Location And User CRUD
- Location admin CRUD is now covered through Filament Livewire create/update flows; the active toggle defaults to true and can be saved as inactive.
- User admin CRUD is now covered through Filament Livewire create/update flows; phone/WhatsApp is required for admin-created accounts, password remains required only on create, and blank edit-password does not overwrite the existing password.
- Location form fields now have clearer labels and practical validation for URL, phone, and max lengths.
- `php -l`, `php artisan view:cache`, `php artisan route:cache`, `php artisan test`, and `git diff --check` passed; local caches were cleared afterward with `php artisan optimize:clear`.

## Current Task: Balance Homepage About Selection Rail
- [x] Review the screenshot feedback and locate the About/RMI selection system markup
- [x] Reduce the right rail bottom whitespace while preserving the current clean visual direction
- [x] Verify Blade compilation and basic diff hygiene

### Review: Balance Homepage About Selection Rail
- Adjusted the About section so the right-side RMI selection rail stretches with the two-column composition instead of ending too early.
- Added a small `RMI / verified flow` closing note below the three selection steps to turn the empty lower area into a purposeful visual anchor.
- Verification passed: `php -l app/Http/Controllers/HomeController.php`, `php artisan view:cache`, and `git diff --check`; compiled views were cleared afterward for local development.

## Current Task: Balance Homepage FAQ Intro Rail
- [x] Review the screenshot feedback and locate the active FAQ editorial CSS
- [x] Lower the left FAQ intro on desktop so the column feels vertically balanced with the question ledger
- [x] Verify Blade compilation and diff hygiene

### Review: Balance Homepage FAQ Intro Rail
- Added a desktop-only offset to the sticky FAQ intro rail so the left copy sits lower and balances the taller question ledger on the right.
- Kept the mobile FAQ flow unchanged so users still see the section heading immediately on small screens.
- Verification passed: `php artisan view:cache` and `git diff --check`; compiled views were cleared afterward for local development.

## Current Task: Update WhatsApp Contact Number
- [x] Search source files for hardcoded WhatsApp/contact numbers
- [x] Centralize the public WhatsApp number and point all public WhatsApp CTAs to `081555307307`
- [x] Verify Blade/config compilation and diff hygiene

### Review: Update WhatsApp Contact Number
- Added `config/rizki.php` so the public WhatsApp number is centralized as `081555307307` and the `wa.me` number as `6281555307307`.
- Updated contact page, car detail CTA, footer CTA, floating WhatsApp button, and default location seeder WhatsApp fields to use the centralized number.
- Verified old hardcoded WhatsApp numbers no longer appear in `app`, `config`, `database`, `resources`, `routes`, or `tests`.
- Verification passed: PHP syntax checks for the new config and seeder, `php artisan view:cache`, `php artisan config:cache`, and `git diff --check`; Blade/config caches were cleared afterward.

## Current Task: Harden Admin User CRUD
- [x] Audit current Filament user create/edit form, table, pages, model, and tests
- [ ] Add safer create/edit UX: password confirmation, edit context, and reset-password action
- [ ] Add server-side guards for self/last-admin demotion or deletion
- [ ] Add regression coverage and run hosting-safe verification

## Current Task: Add Mini To Car Make Options
- [x] Locate all car make option sources for admin, inventory, and homepage search
- [x] Centralize car make options and add `Mini`
- [x] Verify syntax, Blade/config compilation, and diff hygiene

### Review: Add Mini To Car Make Options
- Added centralized `car_makes` config in `config/rizki.php`, including `Mini`.
- Updated homepage search options, public inventory make filter, admin car create/edit make select, and admin car table make filter to read from the centralized list.
- Added regression coverage that `Mini` appears on the homepage search and inventory make filter.
- Verification passed: PHP syntax checks, targeted homepage/inventory tests, full `php artisan test` (`28 passed`), `php artisan view:cache`, `php artisan config:cache`, and `git diff --check`; Blade/config caches were cleared afterward.

## Current Task: Add Car Detail Location Card
- [x] Review car detail layout, `Car` location relation, and available `locations` fields
- [x] Eager-load the car location and render a clean right-column location card from database data
- [x] Add regression coverage and run hosting-safe verification

### Review: Add Car Detail Location Card
- Eager-loaded `location` on the car detail controller so outlet data is available without extra lazy-loading surprises.
- Added a right-column `Lokasi Unit` card that shows outlet name, address, city/province, maps link, and outlet WhatsApp when the car has a location.
- Added a fallback location note when a car has no assigned outlet yet, so the right column still answers the user flow honestly.
- Added regression coverage for rendering location data from the database on the car detail page.
- Verification passed: PHP syntax checks, targeted `CarDetailTest`, full `php artisan test` (`29 passed`), `php artisan view:cache`, and `git diff --check`; Blade cache was cleared afterward.

## Current Task: Add City And LCGC Body Types
- [x] Locate body type sources in database schema, admin form/filter, inventory filter, and dashboard labels
- [x] Add `city` and `lcgc` to the shared body type options and database enum
- [x] Update public labels so `LCGC` renders correctly
- [x] Add/adjust regression coverage and run hosting-safe verification

## Review
- Added `city` and `lcgc` body types to the shared Rizki Mobil config so admin car forms, admin table filters, and public inventory filters use one source of truth.
- Added a production-safe migration to expand the MySQL `cars.body_type` enum, while keeping the original create-table migration aligned for fresh installs.
- Updated public inventory labels and dashboard chart labels so `LCGC` displays in uppercase instead of as a generic capitalized value.
- Added regression coverage for the inventory filter options and admin car creation with the new body type.
- Verification passed: `php artisan test`, targeted inventory/admin CRUD tests, `php artisan view:cache`, `php artisan config:cache`, and `git diff --check`.
- `AGENTS.md` workflow is now operationalized with the required task files.
- For non-trivial tasks, the plan will be written here before implementation and updated as work progresses.
- Added a create-only `Foto Mobil` upload section so new car listings can include images before the first save.
- Fixed the responsive overflow pattern on the car detail page by constraining grid/flex children, thumbnail rails, price text, CTA rows, and shared page wrappers.
- Extended the same responsive guardrails to inventory cards, saved cars, contact, auth, account, and the app shell so public pages are less likely to exceed mobile viewport width.
- Verification passed: `php artisan view:clear`, `php artisan view:cache`, `npm run build`, `php artisan test`, `git diff --check`, plus Browser mobile/desktop smoke checks on home, inventory, car detail, contact, login, register, and guest saved redirect.
- Fixed deployed admin 403 by moving panel authorization into the `FilamentUser` contract on `User`, keeping the custom middleware aligned to `$request->user()->isAdmin()`, and adding `php artisan user:admin {email}` for production role repair.
- Preserved existing production admin passwords in `AdminUserSeeder` while still ensuring `admin@rizkimobil.com` is promoted when seeded.
- Verification passed: PHP syntax checks, `php artisan test tests/Feature/AuthFlowTest.php`, full `php artisan test`, `php artisan view:cache`, `php artisan route:list --path=admin`, `php artisan list user`, and `git diff --check`.
- Fixed hosted admin dashboard blank skeletons by disabling lazy loading for all dashboard widgets so stats, charts, and tables are present in the initial server response.
- Added regression coverage that `/admin` renders real widget copy (`Snapshot Penjualan`, `Performa Penjualan`, `Mix Stok Siap Jual`, `Stok Siap Didorong`) for admin users.
- Verification passed: widget PHP syntax checks, `php artisan test tests/Feature/AuthFlowTest.php`, `php artisan test --filter=dashboard`, full `php artisan test`, `php artisan view:cache`, and Livewire route listing.
- The create page now removes uploaded image paths from the car payload, then creates ordered `CarImage` records after the `Car` record exists.
- Added public customer auth at `/register` and `/login`, plus logout, while keeping admin access separated behind `is_admin`.
- Added the Filament `/admin/users` resource so authorized admins can create/edit customer accounts or admin accounts without exposing admin creation publicly.
- Verified account creation with PHP syntax checks, Blade cache, route registration, Vite build, full PHPUnit suite, and Browser desktop/mobile smoke checks.
- Replaced the car-detail save placeholder alert with a real favorite toggle for authenticated users and a login-gated save link for guests.
- Added the `/saved` page behind auth, plus `Tersimpan` navigation in desktop/mobile header so users can return to saved cars.
- Added `SavedCarsTest` coverage for guest login gates, save, saved-list rendering, and unsave; full PHPUnit, Vite build, Blade cache, route checks, diff checks, and Browser guest/mobile smoke checks passed.
- Added `phone` to users with a local migration, required phone on public registration, and added explicit password minimum hints/HTML constraints.
- Added `/account` for viewing current account details and changing password, with the current user name shown as the rightmost authenticated header action.
- Added account/password tests covering page visibility, successful password change, current-password validation, phone-required registration, and password minimum validation.
- `php artisan migrate`, `php artisan view:cache`, `php artisan test`, `npm run build`, and `git diff --check` passed; Browser DOM smoke confirmed register shows phone, password rule, and `Tersimpan` without console errors. Screenshot capture timed out in the Browser runtime, so visual proof relied on DOM/browser health plus automated tests.
- Reworked `/account` into a compact account settings page rather than a marketing-style hero: summary rail, editable profile form, security/password form, saved-car count, and quick actions.
- Added `account.profile.update` so signed-in users can edit their own name, email, and WhatsApp number; email uniqueness and phone length are validated.
- Added profile update tests for successful save and invalid/duplicate contact data; `php -l`, route list, Blade cache, targeted account tests, full PHPUnit suite, Vite build, and `git diff --check` passed.
- Browser smoke confirmed unauthenticated `/account` still redirects to `/login` without console errors; logged-in account rendering and updates are covered by server-side feature tests because the Browser runtime has unreliable email-input filling in this environment.
- Refined the create-page uploader placement and behavior so the photo section sits at the bottom of the form and is optimized for batch uploads instead of single-image editing.
- Syntax checks passed for `app/Filament/Resources/Cars/Schemas/CarForm.php` and `app/Filament/Resources/Cars/Pages/CreateCar.php`.
- Added a `Kembali ke Daftar` header action on the create and edit car admin pages so it is easy to return to the index after making changes.
- Syntax checks passed for `app/Filament/Resources/Cars/Pages/CreateCar.php` and `app/Filament/Resources/Cars/Pages/EditCar.php`.
- Confirmed that `routes/web.php` maps `/` to `HomeController@index`, which renders `resources/views/index.blade.php`.
- Added a `Lihat Store` header action on the create and edit car admin pages so the storefront can be checked directly after changes.
- Syntax checks passed for `app/Filament/Resources/Cars/Pages/CreateCar.php` and `app/Filament/Resources/Cars/Pages/EditCar.php` after adding the storefront shortcut.
- Moved the storefront shortcut out of page-specific actions and into the global Filament topbar so it is available from anywhere in admin.
- Removed the page-specific `Lihat Store` action from the car create/edit pages to avoid duplication.
- Syntax checks passed for `app/Providers/Filament/AdminPanelProvider.php`, `app/Filament/Resources/Cars/Pages/CreateCar.php`, and `app/Filament/Resources/Cars/Pages/EditCar.php`.
- `php artisan view:cache` completed successfully, confirming the new topbar Blade view compiles.
- Added curated testimonial/rating data in the homepage controller so the Blade section stays presentational and easy to extend later.
- Added a dark, theme-matching testimonial section after the featured cars block with subtle red glow accents, rating chips, and responsive card layout.
- Syntax checks passed for `app/Http/Controllers/HomeController.php`.
- `php artisan view:cache` completed successfully after the homepage Blade changes, confirming the new testimonial section compiles.
- Reordered the homepage story flow so `Mengapa Memilih Rizki Mobil` now leads into testimonials, matching the narrative sequence requested by the user.
- Added an introduction section for Rizki Mobil below testimonials with a refined two-column layout, warm light background, brand-led copy, and a visual panel built from local brand assets.
- Syntax checks passed for `app/Http/Controllers/HomeController.php` after adding the homepage introduction data.
- `php artisan view:cache` completed successfully after the section reorder and the new company-introduction block.
- Simplified the contact page from an image-heavy concierge hero into a direct two-column contact surface with concise copy, primary WhatsApp action, secondary stock action, two short guidance notes, and a single clean form.
- Hid the floating WhatsApp CTA on the contact page only, because the page already has a primary WhatsApp action and the floating button was visually competing with the form.
- Fixed the Blade variable setup after HTTP verification exposed a contact-page 500, then re-ran view compilation, asset build, tests, HTTP checks, and desktop/mobile browser QA successfully.
- Right-sized the footer from a large hero-like closing section into a compact premium footer band with smaller type, shorter vertical spacing, no proof strip, no oversized CTA card, and a cleaner command block for WhatsApp/stock actions.
- Verified the compact footer with Blade syntax, view cache, Vite build, PHPUnit, and desktop/mobile browser screenshots with no console errors.
- Improved the homepage trust/testimonial section by replacing centered empty benefit cards with compact dossier-style proof cards, adding section texture/anchoring, and reshaping testimonials into a lighter review-ledger layout.
- Fixed a desktop QA issue where benefit card titles were clipped by the first grid layout; final card anatomy now stacks icon, title, and copy reliably.
- Verified the section with Blade syntax, view cache, Vite build, PHPUnit, server-rendered HTML checks, and Browser desktop/mobile DOM checks; desktop visual QA confirmed the corrected benefit cards.
- Refined the Rizki Mobil introduction section by shortening the headline and supporting copy so the composition feels lighter and more controlled.
- Reworked the right-side visual into a calmer brand card with restrained hierarchy and cleaner stat presentation, replacing the heavier oversized layout.
- Syntax checks passed for `app/Http/Controllers/HomeController.php` after refining the homepage introduction content.
- `php artisan view:cache` completed successfully after the refined Rizki Mobil intro redesign.
- Further elevated the Rizki Mobil intro by replacing boxed highlight cards with a more editorial list treatment and loosening the left-column hierarchy.
- Lightened the right-side brand panel with softer gradients, slimmer badge/stats treatment, and more breathing room so the section feels more premium.
- `php artisan view:cache` completed successfully after the final elegance pass on the Rizki Mobil intro.
- Aligned the `Mengapa Memilih Rizki Mobil` section background, glow accents, and divider treatment with the testimonial block so the transition reads as one continuous visual story.
- `php artisan view:cache` completed successfully after the homepage background alignment update.
- Replaced the duplicated dark section backgrounds with one shared `trust-story-section` wrapper so `Mengapa Memilih Rizki Mobil` and `Ulasan Pelanggan` now read as a single continuous canvas.
- `php artisan view:cache` completed successfully after merging the homepage background wrapper.
- Added curated FAQ content in `HomeController` and inserted a light, brand-accented FAQ section above the final CTA so common buyer questions are answered before the conversion block.
- `php -l app/Http/Controllers/HomeController.php` and `php artisan view:cache` both completed successfully after the FAQ section was added.
- Moved car search into the global header with a live suggestion dropdown backed by available inventory, including direct links to matching car detail pages and a fallback path to filtered inventory results.
- Removed the old homepage floating search block and the visible inventory-page search fields, while preserving the `search` query through inventory filter forms via hidden inputs.
- `php -l` passed for `app/Http/Controllers/HomeController.php`, `app/Http/Controllers/InventoryController.php`, and `app/Models/Car.php`; `php artisan route:list --name=inventory.suggestions` and `php artisan view:cache` also completed successfully.
- Replaced the inventory mileage min/max inputs with preset buttons such as `< 10k KM` and `10 - 30k KM`, styled to match the existing filter system while still submitting the same `mileage_min` and `mileage_max` parameters.
- Added the same mileage preset interaction to the mobile filter sheet, with toggle behavior and desktop AJAX refresh support so the filter stays fast and consistent across breakpoints.
- `php -l app/Http/Controllers/InventoryController.php` and `php artisan view:cache` completed successfully after the mileage-filter redesign.
- Split the search experience by route: the homepage now uses a floating discovery search card again, while the inventory page keeps the global header search with live suggestions.
- Restored homepage search support data in `HomeController` and aligned the floating form parameters with the current inventory filters so the handoff remains consistent.
- `php -l app/Http/Controllers/HomeController.php` and `php artisan view:cache` completed successfully after the search UX split.
- Merged the `Tentang Rizki Mobil` and `FAQ` sections under one shared `about-faq-section` wrapper so the light brand background now flows continuously without a visible seam.
- `php artisan view:cache` completed successfully after the About/FAQ background merge.
- `php artisan test` still fails in the existing `Tests\Feature\ExampleTest` because the test homepage hits `HomeController` before a `cars` table exists in the in-memory sqlite test database; this appears unrelated to the create-image change.
- Replaced the default admin dashboard page with a custom Filament dashboard layout that uses a 12-column grid, clearer page hierarchy, and a stronger operational summary for admin users.
- Upgraded the overview area with sharper KPI framing and added three relevant visualizations: lead trend over time, available-stock composition by body type, and active-stock price-band distribution.
- Refined the operational tables so lead follow-up and STNK-priority inventory feel more intentional, easier to scan, and more aligned with the upgraded dashboard structure.
- Elevated the shared admin theme with darker premium surfaces, softer gradients, better widget separation, and more polished card/table presentation so the panel feels closer to a professional admin dashboard.
- `php -l` passed for `app/Filament/Pages/Dashboard.php`, `app/Filament/Widgets/StatsOverview.php`, `app/Filament/Widgets/LeadsTrendChart.php`, `app/Filament/Widgets/InventoryBodyTypeChart.php`, `app/Filament/Widgets/InventoryPriceBandChart.php`, `app/Filament/Widgets/LatestContactsWidget.php`, `app/Filament/Widgets/LatestCarsWidget.php`, and `app/Providers/Filament/AdminPanelProvider.php`.
- `php artisan view:cache` completed successfully after the dashboard refactor.
- `npm run build` completed successfully, including the updated Filament admin theme bundle.
- Refocused the admin dashboard away from leads and toward sales: KPI cards now show estimated sold revenue, units sold this month, active stock value, and sell-through ratio.
- Added a real `sold_at` timestamp so sales charts use a stable sale date instead of relying on generic listing updates; existing sold units were backfilled from `updated_at` during migration.
- Replaced the lead trend/table widgets with `SalesTrendChart` and `SoldCarsWidget`, then adjusted stock widgets to support sales prioritization.
- Updated the car admin form/table so admins can see or adjust the sale date when a unit is marked sold.
- Fixed the existing homepage feature test setup with `RefreshDatabase` and made the car card partial tolerate the homepage fallback mock cars.
- Applied the new migration locally with `php artisan migrate`.
- `php -l` passed for the changed dashboard widgets, car model/form/table, new migration, test, and car-card partial.
- `php artisan view:cache` completed successfully after the sales-dashboard refactor.
- `php artisan test` passed: 2 tests, 2 assertions.
- Rebuilt the public header as a premium dark command bar with a centered pill navigation rail, stronger stock/admin actions, responsive mobile menu, and preserved inventory live-search shelf.
- Rebuilt the footer as a stronger showroom closing band with brand-led messaging, concise proof points, a glass action panel, useful footer navigation, and clearer copyright/status treatment.
- Tightened the mobile footer by restoring container gutters, reducing mobile title/action sizing, and shrinking the floating WhatsApp button to an icon-only control on small screens so it no longer covers footer content.
- `php -l` passed for `resources/views/layouts/app.blade.php`, `resources/views/layouts/header.blade.php`, and `resources/views/layouts/footer.blade.php`.
- `php artisan view:cache`, `npm run build`, and `php artisan test` passed after the header/footer redesign.
- Browser QA confirmed desktop and mobile render without horizontal overflow, the mobile menu opens correctly, and the inventory header search shelf/form remains available.
- Aligned the Filament admin theme with the storefront palette by changing the panel primary color from amber to red.
- Updated admin light mode to use white surfaces with soft red radial gradients, red-tinted borders, and a restrained red hover state.
- Updated admin dark mode to use near-black surfaces with the same red glow language as the public homepage trust/testimonial sections.
- Neutralized the admin gray scale so it no longer reads as slate-blue, and made the logo only invert in dark mode.
- Removed leftover amber/orange/slate dashboard theme references from the admin CSS.
- `php -l app/Providers/Filament/AdminPanelProvider.php`, `php artisan view:cache`, and `npm run build` completed successfully after the theme alignment.
- Replaced the old footer placeholder content with showroom-relevant sections for stock browsing, buyer services, and support.
- Removed dummy address/email/phone/social links and centered the footer contact flow around the real WhatsApp number already used across the site.
- Added practical inventory footer links for all stock, Toyota, Honda, MPV, SUV, and units under Rp 100 juta.
- Added homepage anchors for `Tentang Rizki Mobil` and `FAQ` so footer support links jump to meaningful sections.
- `php -l resources/views/layouts/footer.blade.php`, `php -l resources/views/index.blade.php`, `php artisan view:cache`, and `php artisan test` completed successfully after the footer update.
- Simplified the footer after user correction so it now contains only brand copy, primary WhatsApp CTA, stock CTA, three support links, and a short stock/price disclaimer.
- Removed the previous directory-style stock/service/support link groups because they made the footer feel noisy instead of useful.
- `php -l resources/views/layouts/footer.blade.php`, `php artisan view:cache`, and `php artisan test` completed successfully after simplifying the footer.
- Replaced the plain `Contact Us` page with a polished Rizki Mobil contact layout using a dark brand hero, vehicle imagery, WhatsApp CTA, and a clean white form panel.
- Removed the unused `subject` field from the contact form and aligned visible inputs with the backend validation fields: name, email, phone, and message.
- Updated contact form success/error copy in `ContactController` to Indonesian so it matches the rest of the storefront.
- `php -l resources/views/contact.blade.php`, `php -l app/Http/Controllers/ContactController.php`, `php artisan view:cache`, and `php artisan test` completed successfully after the contact UI redesign.
- Expanded the sales dashboard chart from short daily ranges to selectable 30-day, 90-day, 12-month, and all-time views.
- Changed the default sales performance view to 12 months and added a revenue line in juta Rupiah beside the sold-unit bars.
- Reframed the KPI card from `Terjual Bulan Ini` to `Terjual 12 Bulan`, while still mentioning this month's unit count in the description.
- `php -l` passed for the changed dashboard files, `php artisan view:cache` completed successfully, and `php artisan test` passed with 2 tests.
- Direct chart data verification passed for all dashboard filters: 30 labels for 30 days, 13 labels for 90 days, 12 labels for 12 months, and yearly labels for all-time.
- Reworked the homepage `Tentang Rizki Mobil` section from a large text/card layout into a more premium editorial dossier with cinematic vehicle imagery, a dark inspection overlay, proof stats, and a cleaner process rail.
- Preserved the shared About/FAQ wrapper so the section still flows into FAQ without a harsh background break.
- Added the existing `bmw13.jpg` vehicle image to the about data and kept the brand logo asset in the dossier overlay.
- `php -l app/Http/Controllers/HomeController.php`, `php artisan view:cache`, and `npm run build` completed successfully after the redesign.
- Visual QA used local Chrome DevTools Protocol screenshots after the default headless screenshot path rendered blank; desktop and mobile renders were inspected, and mobile layout metrics confirmed no horizontal overflow (`scrollWidth` 390, `clientWidth` 390).
- Redesigned the homepage FAQ area from a flat three-card grid into a premium decision-desk layout with a dark consultation panel, proof rows, a `Tanya Admin` action, and large decision rows for each FAQ.
- Kept the FAQ inside the shared About/FAQ visual background and preserved the existing CTA section below it.
- `php artisan view:cache` and `npm run build` completed successfully after the FAQ redesign.
- Visual QA used local Chrome DevTools Protocol screenshots for desktop and mobile because the standard headless screenshot path is unreliable in this environment; both renders were inspected for hierarchy, spacing, color alignment, and mobile fit.
- Replaced the flat red closing CTA bar with a premium showroom handover panel using dark surfaces, vehicle imagery, a scan-line motif, proof points, and stronger action hierarchy.
- Preserved the existing `inventory` and `contact` routes while making `Lihat Inventori` the primary action and `Hubungi Kami` the secondary action.
- `php artisan view:cache` and `npm run build` completed successfully after the CTA redesign.
- Visual QA used local Chrome DevTools Protocol screenshots for desktop and mobile; desktop render showed the full closing panel with vehicle/media card, and mobile metrics confirmed no horizontal overflow (`scrollWidth` 390, `clientWidth` 390).
- Reduced the repeated About/FAQ/CTA rhythm by making About an open editorial section with a separate image band, FAQ a white decision ledger without cards, and the closing CTA a full-bleed dark handover band.
- Removed duplicated dark card language from the About and FAQ sequence while preserving the red/black/white showroom mood and existing `inventory`/`contact` actions.
- `php artisan view:cache`, `npm run build`, and `php artisan test` completed successfully after the rhythm refresh.
- Visual QA inspected desktop screenshots for `#tentang`, `#faq`, and `.closing-cta-section`; mobile viewport screenshots were re-captured after the first clip method produced blank images, and mobile metrics confirmed no horizontal overflow (`scrollWidth` 390, `clientWidth` 390).
- Reworked the contact page from a conventional dark hero plus form card into a premium concierge experience with a cinematic vehicle panel, direct WhatsApp/stock actions, contact-route guidance, and a stronger purchase-brief form.
- Preserved the existing `contact.store` form fields (`name`, `phone`, `email`, `message`) and WhatsApp route while adding quick message prompts that fill and focus the message textarea.
- `php -l resources/views/contact.blade.php`, `php artisan view:cache`, `npm run build`, `php artisan test`, and `git diff --check` completed successfully after the redesign.
- Visual QA captured desktop and mobile contact-page screenshots via local Chrome DevTools Protocol; desktop/mobile metrics confirmed no horizontal overflow (`1440/1440` and `390/390`), and the quick-prompt click test returned the expected textarea value.
- Split repeated vehicle imagery into distinct roles: About keeps `bmw13.jpg` for the dossier band, closing CTA now uses `bmw1.jpg` for the handover/action moment, and Contact now uses `fer1.jpg` for the concierge visual.
- Added a dedicated `handover_image` key to the homepage about data so future CTA imagery does not accidentally reuse the About dossier image.
- `php -l` passed for the changed controller and Blade files, and `php artisan view:cache`, `npm run build`, `php artisan test`, and `git diff --check` completed successfully after separating the images.
- Visual QA verified the rendered image sources and desktop screenshots for About, closing CTA, and Contact; desktop and mobile metrics confirmed no horizontal overflow (`1440/1440` and `390/390`).
- Added a `fallbackImage` one-of-many relation so public/admin listing views can load a single fallback image without eager-loading every gallery image.
- Updated public inventory, header suggestions, homepage featured cars, admin car table, and dashboard stock/sold widgets to eager-load `primaryImage` plus `fallbackImage`, avoiding per-card image queries while keeping the first-image fallback behavior.
- Limited public inventory, search suggestions, and homepage featured car queries to the listing columns actually rendered in cards/hero areas, reducing payload per result.
- Added database indexes for common available-stock filters/sorts on `cars` and image lookup indexes on `car_images`, then applied the migration locally.
- Query verification confirmed accessing `main_image` after eager loading added `0` extra image queries for the current inventory page.
- `php -l`, `php artisan view:cache`, `php artisan migrate`, `php artisan migrate:status`, `npm run build`, `php artisan test`, and `git diff --check` completed successfully after the optimization.
- Unified inventory keyword search so homepage, header, and inventory filtering now use the canonical `search` parameter, with old `model` URLs redirected to `search` for compatibility.
- Hardened inventory filter parsing for search strings, price range format, positive numeric ranges, allowed checkbox arrays, and supported sort values so malformed query parameters no longer affect the query shape.
- Changed inventory make options to come from available stock first, with the old static brand list kept only as a fallback when the database has no stock.
- Added targeted feature tests covering legacy `model` redirect, search filtering, and malformed filter parameters.
- `php -l`, `php artisan view:cache`, `npm run build`, `php artisan test --filter=InventoryFilterTest`, full `php artisan test`, and `git diff --check` completed successfully after hardening the filter contract.
