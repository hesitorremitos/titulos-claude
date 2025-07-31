# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

This is a Laravel 12 application for digitalizing academic titles for the Universidad Autónoma Tomás Frías (UATF) Department of Titles in Potosí, Bolivia. The system replaces manual physical file management with a digital system for registering, searching, and managing academic titles.

**Target Title Types:**
- Academic Diplomas (Diplomas Académicos)
- Professional Titles (Títulos Profesionales) 
- High School Diplomas (Diplomas de Bachiller)

## Development Commands

### Primary Development Workflow
```bash
# Start development environment (runs server, queue, and vite concurrently)
composer run dev

# Alternative individual commands:
php artisan serve        # Start Laravel server
php artisan queue:listen --tries=1  # Start queue worker
npm run dev             # Start Vite development server
```

### Build and Asset Commands
```bash
npm run build           # Build production assets
npm install             # Install Node.js dependencies
composer install        # Install PHP dependencies
```

### Database Commands
```bash
php artisan migrate          # Run database migrations
php artisan migrate:fresh    # Drop all tables and re-run migrations
php artisan migrate:refresh  # Rollback and re-run migrations
```

### Testing Commands
```bash
composer run test       # Run full test suite (clears config first)
php artisan test        # Alternative test command
./vendor/bin/pest       # Direct Pest test runner
```

### Code Quality
```bash
./vendor/bin/pint       # PHP code style fixer (Laravel Pint)
```

## Architecture Overview

### Technology Stack
- **Backend:** Laravel 12 with PHP 8.2+
- **Frontend:** Blade templates with component system, Tailwind CSS v4, Alpine.js
- **Database:** SQLite (development), designed for PostgreSQL/MySQL (production)
- **Testing:** Pest PHP testing framework
- **Authentication:** Pure Laravel authentication with custom controllers and form requests
- **Icons:** Iconify integration with Tailwind CSS v4 plugin
- **Build Tool:** Vite

### Key Dependencies
- `spatie/laravel-permission`: ^6.21 - Role and permission management
- `@tailwindcss/vite`: ^4.0.0 - Tailwind CSS v4 integration
- `@iconify/tailwind4`: ^1.0.6 - Icon system integration
- `pestphp/pest`: ^3.8 - Modern PHP testing framework

### Component Architecture
The application uses a component-based Blade architecture:
- **UI Components:** `<x-ui.alert>`, `<x-ui.card>`, `<x-ui.stat-card>`, `<x-ui.action-button>`
- **Form Components:** `<x-form.input>`, `<x-form.button>` with validation and state management
- **Layout System:** `guest` layout for authentication, `app` layout for authenticated pages
- **Icon System:** Uses `<span class="icon-[mdi--icon-name]"></span>` syntax with Iconify plugin

### User Roles and Permissions
1. **Administrator:** Full CRUD access, user management, master data management
2. **Jefe (Boss):** View-only access to all titles, can see audit trails
3. **Personal (Staff):** Can only manage titles they registered themselves

### Core Business Entities
- **Personas (People):** Base entity with CI (ID number) as primary key
- **Facultades (Faculties):** Academic faculties
- **Carreras (Careers):** Academic programs belonging to faculties
- **Titles:** Various types (Academic Diplomas, Professional Titles, High School Diplomas)
- **Audit Trail:** Tracks who created/modified records and when

### External Integration
- **University API:** `https://apititulos.uatf.edu.bo/api/datos?ru={ci}`
- Used for auto-filling personal data during title registration
- Returns array of academic records for given CI number

### File Structure Patterns
- Controllers follow standard Laravel structure in `app/Http/Controllers/`
- Form requests in `app/Http/Requests/Auth/` for validation logic
- Models in `app/Models/` with Eloquent relationships
- Blade components in `resources/views/components/` (ui/ and form/ subdirectories)
- Views in `resources/views/` with layout inheritance
- Database migrations follow Laravel conventions
- Specs documentation in `specs/` directory

### Authentication Architecture
- **AuthController:** Handles login/logout with proper session management
- **LoginRequest:** Form request with CI validation and rate limiting (5 attempts)
- **Guest Layout:** Centered design for authentication pages
- **App Layout:** Navigation with user menu for authenticated pages
- **Components:** Reusable form inputs and buttons with Alpine.js integration

### Database Design
- Uses SQLite for development (database/database.sqlite)
- Primary entities: personas, facultades, carreras, titulo types with relationships
- CI (Carnet de Identidad) is the unique identifier for people
- Foreign key relationships between faculties->careers->titles->people
- Audit columns (created_by, updated_by, timestamps) for traceability

### Development Environment
- Uses Laragon (Windows development environment)
- Git repository with main branch
- Environment configured for SQLite database
- Concurrent development setup via composer script

## Important Business Rules

### Data Validation
- CI must follow Bolivian ID format
- One title per type, per person, per career
- Issue dates cannot be in the future
- PDF files limited to 50MB when available
- Faculty-career relationships must exist in catalog

### Permission Logic
- Staff can only access titles they registered
- Jefe can view all titles but cannot modify
- Administrator has full system access
- All modifications tracked with user and timestamp

### Title States
- "Digitalizado" (Digitalized): Has PDF file attached
- "Pendiente de digitalización" (Pending digitalization): Registered without PDF (lost document cases)

## Testing Considerations
- Uses Pest PHP testing framework
- In-memory SQLite database for tests
- Test configuration in phpunit.xml
- Tests located in tests/Feature/ and tests/Unit/

## Key Configuration Files
- `vite.config.js`: Vite build configuration with Tailwind CSS v4
- `composer.json`: PHP dependencies and custom scripts including `composer run dev`
- `package.json`: Node.js dependencies for frontend build
- `config/permission.php`: Spatie permission package configuration
- `resources/css/app.css`: Includes `[x-cloak] { display: none !important; }` for Alpine.js

## Development Patterns
- **Component Usage:** Always use `<x-form.input>` and `<x-form.button>` for consistency
- **Icon Syntax:** Use `<span class="icon-[mdi--icon-name]"></span>` format (not iconify class)
- **Layout Inheritance:** Use `@extends('layouts.guest')` for auth, `@extends('layouts.app')` for dashboard
- **Validation:** Server-side with form requests, client-side with Alpine.js
- **JavaScript:** Vanilla JS in layouts, Alpine.js for component interactivity