# Copilot Instructions for Rizki Mobil

## Project Overview
This is a Laravel 12 car dealership website for displaying and managing used car inventory. The application features a public-facing inventory page, individual car detail pages, and a contact form.

## Build, Test, and Lint Commands

### Setup
```bash
composer setup
# Runs: composer install, creates .env, generates key, migrates DB, npm install, npm run build
```

### Development
```bash
composer dev
# Starts all services concurrently: Laravel server, queue worker, logs (pail), and Vite dev server

# Or run services individually:
php artisan serve                # Laravel development server
npm run dev                      # Vite dev server for frontend assets
php artisan queue:listen         # Queue worker
php artisan pail                 # Real-time log viewer
```

### Testing
```bash
composer test                    # Run all tests (clears config first)
php artisan test                 # Direct test command
php artisan test --filter=CarTest  # Run specific test
vendor/bin/phpunit tests/Unit/CarTest.php  # Run single test file
```

### Code Quality
```bash
vendor/bin/pint                  # Laravel Pint for code formatting (PSR-12)
vendor/bin/pint --test          # Check formatting without making changes
```

### Frontend
```bash
npm run build                    # Build production assets with Vite
npm run dev                      # Development mode with hot module replacement
```

### Database
```bash
php artisan migrate              # Run migrations
php artisan migrate:fresh --seed # Reset database and seed data
php artisan db:seed              # Run seeders only
```

## Architecture Overview

### Domain Model
- **Car**: Core entity with specifications (make, model, year, mileage, transmission, fuel type, color, seats, body type, etc.)
- **CarImage**: Multiple images per car with primary image flag and sort ordering
- **Location**: Physical location/branch for each car (added via migration)
- **Favorite**: User favorites for cars (table exists but authentication is disabled)
- **User**: Standard Laravel user model (not actively used yet)

### Key Relationships
- Car `hasMany` CarImage (ordered by `sort_order`)
- Car `hasOne` primaryImage (where `is_primary = true`)
- Car `belongsTo` Location
- Car `belongsToMany` User through Favorites (implemented but not in use)

### Controllers
- **HomeController**: Landing page with featured cars
- **CarController**: Inventory listing (with filters) and single car details
- **ContactController**: Contact form (index + store)
- **FavoriteController**: Exists but unused (authentication disabled)

### Views Structure
```
resources/views/
├── layouts/
│   ├── app.blade.php       # Master layout
│   ├── header.blade.php    # Navigation bar
│   └── footer.blade.php    # Footer
├── partials/
│   ├── car-card.blade.php  # Reusable car card component
│   └── hero-carousel.blade.php  # Homepage hero section
├── index.blade.php         # Homepage
├── inventory.blade.php     # Car listing/inventory (implied from controller)
├── car-details.blade.php   # Single car view
└── contact.blade.php       # Contact form
```

### Frontend Stack
- **Tailwind CSS 4.0**: Utility-first CSS framework with custom theme
  - Custom fonts: `Exo 2` (body), `Inter` (display/headings)
  - Uses `@source` directives to scan Blade templates, PHP files for class extraction
- **Vite**: Asset bundling and HMR
  - Entry points: `resources/css/app.css`, `resources/js/app.js`
  - Ignores `storage/framework/views/**` in watch mode
- **Laravel Vite Plugin**: Seamless integration with Laravel
- **Axios**: HTTP client (imported in bootstrap.js)

## Key Conventions

### Car Model Scopes
Use query scopes for common filters:
```php
Car::featured()              // Where featured = true
Car::available()             // Where sold = false
Car::search($make, $model, $priceRange)  // Combined search/filter
```

### Image Handling
- Images are stored relative to `public/` directory (e.g., `images/cars/1.jpg`)
- Use `$car->main_image` accessor to get primary → first → placeholder
- Always eager load images: `->with(['primaryImage'])` or `->with('images')`
- CarImages have `sort_order` and `is_primary` flags

### Price Storage
- Prices stored as **integer** representing rupiah (Indonesian currency)
- Example: 285000000 = Rp 285,000,000
- Use `price` cast in model to ensure integer type

### Enum Fields
Several fields use database enums (not PHP 8.1 enums):
- `transmission`: 'manual', 'automatic'
- `fuel_type`: 'bensin', 'diesel', 'electric', 'hybrid'
- `body_type`: 'suv', 'sedan', 'hatchback', 'mpv', 'pickup', 'van', 'coupe', 'convertible', 'wagon'
- `plate_parity`: 'ganjil', 'genap' (Indonesian odd/even license plate system)

### JSON Fields
- `features` field stores array of feature strings as JSON
- Cast as 'array' in model for automatic serialization

### Date Fields
- `stnk_valid_until`: Vehicle registration expiration date (cast to 'date')

### Controller Patterns
- Inventory page: Always filter by `available()` scope and eager load `primaryImage`
- Use `paginate(12)->withQueryString()` to preserve filters in pagination
- Car makes list is hardcoded array (could be moved to DB/config later)

### Authentication Status
- User authentication routes are commented out in `routes/web.php`
- Favorites functionality exists in code but is disabled
- `$favorites = []` hardcoded in CarController

### Tailwind CSS 4.0 Specifics
- Uses new `@source` directive instead of content array in config
- Custom CSS properties defined in `@theme` block
- Font families defined as CSS variables: `var(--font-body)`, `var(--font-display)`

### Testing Configuration
- PHPUnit uses SQLite in-memory database for tests
- Test environment: `APP_ENV=testing`, DB: `:memory:`
- Disabled in tests: Pulse, Telescope, Nightwatch
- Queue connection: 'sync' (no async in tests)
