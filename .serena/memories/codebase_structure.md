# Codebase Structure Overview

## Main Directory Structure
```
├── app/
│   ├── Http/Controllers/           # MVC Controllers
│   │   ├── DiplomasAcademicos/    # Diploma-related controllers
│   │   └── *.php                  # Other controllers (Auth, User, etc.)
│   ├── Livewire/                  # Livewire components (used sparingly)
│   │   ├── Forms/                 # Form validation classes
│   │   └── *.php                  # Main reactive components
│   ├── Models/                    # Eloquent models
│   ├── Services/                  # External integrations and helpers
│   └── Providers/                 # Service providers
├── database/
│   ├── csv/                       # Master data for seeders
│   ├── migrations/                # Database schema
│   └── seeders/                   # Data population
├── resources/
│   ├── views/                     # Blade templates
│   │   ├── components/            # Reusable UI components
│   │   ├── diplomas/              # Diploma-related views
│   │   ├── layouts/               # Layout templates
│   │   └── livewire/              # Livewire component views
│   ├── css/                       # Stylesheets
│   └── js/                        # JavaScript files
├── routes/
│   └── web.php                    # Web routes definition
├── specs/                         # Project documentation
└── tests/                         # Pest PHP tests
```

## Key Business Modules

### Diplomas Académicos (Main Module)
- **Models:** DiplomaAcademico, Persona, MencionDa, GraduacionDa
- **Controllers:** DiplomaAcademicoController, MencionController, ModalidadGraduacionController
- **Services:** UniversityApiService for external API integration
- **Views:** Multi-section interface with Pills navigation (Lista, Formulario, Menciones, Modalidades)

### User Management
- **Models:** User with Spatie Roles/Permissions
- **Controllers:** UserController, AuthController
- **Roles:** Administrador, Jefe, Personal with specific permissions

### Master Data
- **Models:** Facultad, Carrera with hierarchical relationships
- **Controllers:** FacultadController, CarreraController
- **Data:** Populated from CSV files in database/csv/

## Data Flow Patterns

### Title Registration Process
1. API call to University system for person data
2. Form validation through Livewire Form classes
3. File handling with temporary storage
4. Database persistence with audit trails
5. Permission-based access control

### Navigation Architecture
- Main layout with collapsible sidebar (Alpine.js + persistence)
- Pills-based navigation for subsections
- Role-based menu visibility
- Breadcrumb navigation patterns

## Testing Structure
- **Feature tests:** End-to-end functionality testing
- **Unit tests:** Individual component testing
- **Database:** In-memory SQLite for isolation
- **Environment:** Separate test configuration in phpunit.xml

## Configuration Files
- **vite.config.js:** Frontend build configuration
- **composer.json:** PHP dependencies and custom scripts
- **package.json:** Node.js dependencies
- **phpunit.xml:** Testing configuration
- **CLAUDE.md:** Project instructions and file index