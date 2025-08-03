# Code Style and Conventions

## File Naming Conventions
- **Controllers:** PascalCase with Controller suffix (e.g., DiplomaAcademicoController)
- **Models:** Singular PascalCase (e.g., DiplomaAcademico, Persona)
- **Migrations:** Laravel timestamp format with descriptive names
- **Views:** snake_case matching controller actions
- **Livewire:** PascalCase for class, kebab-case for view

## Database Conventions
- **Primary keys:** 'id' for auto-increment, 'ci' for personas (string)
- **Foreign keys:** Follow Laravel naming (model_id)
- **Unique constraints:** On business logic fields (libro, fojas, nro_documento)
- **Soft deletes:** Not implemented - uses hard deletes
- **CI (Carnet de Identidad):** Business identifier for people
- **Audit columns:** created_by, updated_by, timestamps for traceability

## Laravel Patterns Established
- **Eager loading:** Always include complete relationships like 'mencion.carrera.facultad' to avoid N+1
- **Error handling:** Use try-catch in critical database operations
- **Validations:** Use rules() method instead of duplicate #[Validate] attributes
- **Authorization:** Private checkDiplomaAccess() methods for DRY principle
- **Storage:** Use Storage::disk('public')->path() instead of direct concatenation
- **Livewire Forms:** Separate logic in dedicated Form classes

## Architecture Patterns
- **MVC First:** Prefer classic Laravel MVC over Livewire components
- **Livewire Usage:** Only for high-reactivity sections requiring real-time updates
- **Service Layer:** For external integrations (UniversityApiService) and helpers
- **Directory Structure:**
  - Controllers: app/Http/Controllers/ (with subdirectories for modules)
  - Models: app/Models/ with Eloquent relationships
  - Livewire: app/Livewire/ (main components), app/Livewire/Forms/ (form logic)
  - Services: app/Services/
  - Views: resources/views/ with Blade templating

## CSS and Frontend
- **Tailwind CSS v4:** Use utility classes following v4 conventions
- **Dark mode:** Support included in component classes
- **Alpine.js:** For interactive behavior, with persistence plugins
- **Icons:** Iconify system with span.icon-[name] format

## Testing Conventions
- **Framework:** Pest PHP with Laravel plugin
- **Database:** In-memory SQLite for test isolation
- **Location:** tests/Feature/ and tests/Unit/
- **Configuration:** phpunit.xml with test environment variables

## Code Quality
- **Formatting:** Laravel Pint for PHP code style
- **No comments rule:** Do not add comments unless explicitly requested
- **Error handling:** Robust try-catch blocks for external API calls and critical operations