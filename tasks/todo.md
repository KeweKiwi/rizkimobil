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

## Review
- `AGENTS.md` workflow is now operationalized with the required task files.
- For non-trivial tasks, the plan will be written here before implementation and updated as work progresses.
- Added a create-only `Foto Mobil` upload section so new car listings can include images before the first save.
- The create page now removes uploaded image paths from the car payload, then creates ordered `CarImage` records after the `Car` record exists.
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
- Aligned the Filament admin theme with the storefront palette by changing the panel primary color from amber to red.
- Updated admin light mode to use white surfaces with soft red radial gradients, red-tinted borders, and a restrained red hover state.
- Updated admin dark mode to use near-black surfaces with the same red glow language as the public homepage trust/testimonial sections.
- Neutralized the admin gray scale so it no longer reads as slate-blue, and made the logo only invert in dark mode.
- Removed leftover amber/orange/slate dashboard theme references from the admin CSS.
- `php -l app/Providers/Filament/AdminPanelProvider.php`, `php artisan view:cache`, and `npm run build` completed successfully after the theme alignment.
