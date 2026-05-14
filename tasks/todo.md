# Task Plan

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

## Review
- `AGENTS.md` workflow is now operationalized with the required task files.
- For non-trivial tasks, the plan will be written here before implementation and updated as work progresses.
- Added a create-only `Foto Mobil` upload section so new car listings can include images before the first save.
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
