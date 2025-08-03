# Technology Stack

## Backend Framework
- **Laravel 12** with PHP 8.2+
- **Authentication:** Laravel's built-in authentication
- **Permissions:** Spatie Laravel Permission for roles and permissions
- **Database:** SQLite (development), designed for PostgreSQL/MySQL (production)
- **Testing:** Pest PHP testing framework

## Frontend Technologies
- **Templates:** Blade templates 
- **Reactivity:** Livewire v3 (^3.6) for specific reactive components
- **CSS Framework:** Tailwind CSS v4 (^4.0.0)
- **JavaScript:** Alpine.js (^3.14.9) with plugins:
  - @alpinejs/collapse (^3.14.9)
  - @alpinejs/persist (^3.14.9)
- **Icons:** Iconify integration (@iconify/tailwind4: ^1.0.6)
- **Build Tool:** Vite (^7.0.4)

## Key Dependencies
- `livewire/livewire`: ^3.6 - For reactive components
- `spatie/laravel-permission`: ^6.21 - Role and permission management
- `@tailwindcss/vite`: ^4.0.0 - Tailwind CSS v4 integration
- `laravel-pint`: ^1.13 - PHP code style fixer
- `pestphp/pest`: ^3.8 - Testing framework

## External Integrations
- **University API:** `https://apititulos.uatf.edu.bo/api/datos?ru={ci}`
- Used for auto-filling personal data during title registration
- Returns array of academic records for given CI number
- Uses POST method per UATF internal requirements

## Architecture Pattern
- **MVC Pattern:** Classic Laravel MVC for most functionality
- **Livewire Components:** Used sparingly for high-reactivity sections only
- **Service Layer:** External integrations and complex business logic
- **Repository Pattern:** Not implemented, uses Eloquent directly