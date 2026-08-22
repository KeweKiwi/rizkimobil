# Rizki Mobil - Car Dealership Website

A modern car dealership website built with Laravel 12 and Filament v4 admin panel for managing used car inventory.

## Features

### Public Website
- Browse car inventory with advanced filtering
- View detailed car specifications and images
- Contact form for inquiries
- Featured cars showcase on homepage
- Responsive design with Tailwind CSS 4.0

### Admin Panel
- **Dashboard**: Real-time statistics including total sales, available cars, inventory value, and recent inquiries
- **Car Management**: Full CRUD operations with image uploads, specifications, pricing, and status management
- **Location Management**: Manage dealership branches/locations
- **Contact Inquiries**: View and manage customer inquiries
- **Image Management**: Upload multiple images per car with primary image selection and drag-to-reorder functionality

## Tech Stack

- **Framework**: Laravel 12
- **Admin Panel**: Filament v4
- **Frontend**: Tailwind CSS 4.0, Vite
- **Database**: MySQL
- **PHP**: 8.3+

## Installation

### Prerequisites
- PHP 8.3 or higher
- Composer
- Node.js & npm
- MySQL database
- XAMPP (or similar local server environment)

### Setup Instructions

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd rizkimobil
   ```

2. **Install dependencies and set up**
   ```bash
   composer setup
   ```
   This command will:
   - Install PHP dependencies
   - Create `.env` file
   - Generate application key
   - Run migrations
   - Install npm packages
   - Build frontend assets

3. **Configure database**
   - Start XAMPP (Apache + MySQL)
   - Create a database named `rizkimobildb`
   - Update `.env` file if needed:
     ```
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=rizkimobildb
     DB_USERNAME=rizkimobil_app
     DB_PASSWORD=<local-development-password>
     ```

4. **Run migrations**
   ```bash
   php artisan migrate
   ```

5. **Create an administrator explicitly**
   ```bash
   php artisan make:filament-user
   ```
   Follow the interactive prompts and use a unique password. The application does not ship with default administrator credentials.

## Running the Application

### Development Mode
```bash
composer dev
```
This starts all development services concurrently:
- Laravel development server (http://localhost:8000)
- Vite dev server with HMR
- Queue worker
- Real-time log viewer (Pail)

### Individual Services
```bash
php artisan serve              # Laravel server
npm run dev                    # Vite dev server
php artisan queue:listen       # Queue worker
php artisan pail               # Log viewer
```

## Admin Panel Access

**URL**: http://localhost:8000/admin

Create each administrator explicitly with `php artisan make:filament-user`. Never publish or reuse default credentials.

### Admin Panel Features

#### Dashboard
View key metrics at a glance:
- Total sales value from sold cars
- Number of available cars
- Total inventory value
- Recent customer inquiries (last 30 days)

#### Managing Cars
1. Navigate to **Cars** in the sidebar
2. Click **New Car** to add inventory
3. Fill in all required fields:
   - Basic info (make, model, year, variant)
   - Specifications (transmission, fuel type, mileage, etc.)
   - Pricing and location
   - Description and features
   - Mark as featured or sold
4. Upload images in the **Images** tab
   - Set one image as primary (shown in listings)
   - Reorder images by dragging
5. Save and publish

#### Managing Locations
Add dealership branches or showroom locations to associate with cars.

#### Viewing Contact Inquiries
- View all customer inquiries
- See which car they're interested in (if applicable)
- Contact details are copyable
- Delete inquiries when resolved

## Testing

```bash
composer test                    # Run all tests
php artisan test --filter=CarTest  # Run specific test
vendor/bin/pint                  # Code formatting check
vendor/bin/pint --test          # Dry-run formatting check
```

## Database Structure

### Key Models
- **Car**: Vehicle listings with specifications
- **CarImage**: Multiple images per car
- **Location**: Dealership branches
- **Contact**: Customer inquiries
- **User**: Admin users

### Car Specifications
- Make, Model, Variant, Year
- Mileage, Transmission, Fuel Type
- Body Type, Color, Seats
- Price (Indonesian Rupiah)
- Features (JSON array)
- STNK validity, VIN, Plate parity
- Featured & Sold status

## File Upload Configuration

Images are stored in `storage/app/public/images/cars/`. 

To enable public access, create a symbolic link:
```bash
php artisan storage:link
```

## Security

- Admin panel protected by authentication middleware
- Only users with `is_admin = true` can access admin panel
- CSRF protection enabled
- All user inputs are validated and sanitized

## Contributing

This is a private project. For issues or feature requests, please contact the development team.

## License

Proprietary - All rights reserved.

---

**Support**: For technical support, contact the development team.
