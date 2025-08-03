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
php artisan db:seed          # Run database seeders
php artisan migrate:fresh --seed  # Fresh migration with seeders
```

### Testing Commands
```bash
composer run test       # Run full test suite (clears config first)
php artisan test        # Alternative test command
./vendor/bin/pest       # Direct Pest test runner
./vendor/bin/pest --filter=TestName  # Run specific test
```

### Code Quality
```bash
./vendor/bin/pint       # PHP code style fixer (Laravel Pint)
```

## Architecture Overview

### Technology Stack
- **Backend:** Laravel 12 with PHP 8.2+
- **Frontend:** Blade templates with Livewire v3, Tailwind CSS v4, Alpine.js
- **Database:** SQLite (development), designed for PostgreSQL/MySQL (production)
- **Testing:** Pest PHP testing framework
- **Authentication:** Laravel's built-in authentication with Spatie Laravel Permission for roles
- **Icons:** Iconify integration
- **Build Tool:** Vite

### Key Dependencies
- `livewire/livewire`: ^3.6 - For reactive components
- `spatie/laravel-permission`: ^6.21 - Role and permission management
- `@tailwindcss/vite`: ^4.0.0 - Tailwind CSS v4 integration
- `@iconify/tailwind4`: ^1.0.6 - Icon system integration

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
- Models in `app/Models/` with Eloquent relationships
- Livewire components expected in `app/Livewire/`
- Views in `resources/views/` with Blade templating
- Database migrations follow Laravel conventions
- Specs documentation in `specs/` directory

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
- `composer.json`: PHP dependencies and custom scripts
- `package.json`: Node.js dependencies for frontend build
- `config/livewire.php`: Livewire configuration
- `config/permission.php`: Spatie permission package configuration

## Development Guidelines

### Code Style and Patterns
- Follow existing Laravel conventions and patterns observed in the codebase
- Use Eloquent relationships consistently (seen in models like Carrera, Facultad)
- Livewire components for reactive UI interactions (app/Livewire/)
- Blade components for reusable UI elements (resources/views/components/)
- Audit trail pattern: created_by, updated_by fields for traceability

### File Naming Conventions
- Controllers: PascalCase with Controller suffix (e.g., DiplomaAcademicoController)
- Models: Singular PascalCase (e.g., DiplomaAcademico, Persona)
- Migrations: Laravel timestamp format with descriptive names
- Views: snake_case matching controller actions
- Livewire: PascalCase for class, kebab-case for view

### Database Conventions
- Primary keys: 'id' for auto-increment, 'ci' for personas (string)
- Foreign keys: Follow Laravel naming (model_id)
- Unique constraints on business logic fields (libro, fojas, nro_documento)
- Soft deletes not implemented - uses hard deletes
- CI (Carnet de Identidad) is the business identifier for people

### CSV Data Import Structure
- Faculty and career data available in database/csv/
- Seeders use CSV files for initial data population
- Import structure: FacultadSeeder, CarreraSeeder, etc.

### Testing Environment
- Uses in-memory SQLite database for tests (phpunit.xml configuration)
- Pest testing framework with Laravel plugin
- Test environment variables configured in phpunit.xml
- Test database automatically uses `:memory:` SQLite for isolation

## Memory Notes

### Progreso del Proyecto
- Todos los requerimientos y los pasos que se van a ir haciendo, se están documentando en `specs/`
- **Paso 08 COMPLETADO**: Sistema CRUD de Diplomas Académicos implementado con integración API universitaria (specs/08-sistema-diplomas-academicos.md)
- **Paso 09 COMPLETADO**: Mejoras UI - Sidebar Collapsible con Alpine.js y Persistencia (specs/09-mejoras-ui-sidebar-collapsible.md)
- Sistema de usuarios y permisos completamente funcional
- Base de datos con facultades, carreras y datos maestros implementados

### Sistema de Diplomas Académicos (Paso 08)
- **Modelo principal**: DiplomaAcademico con relaciones a Persona, MencionDa, GraduacionDa, User
- **API Externa**: https://apititulos.uatf.edu.bo/api/datos?ru={ci} (método POST por requerimientos internos UATF)
- **Componente Livewire**: DiplomaAcademicoFormComponent (renombrado para evitar colisión de nombres)
- **Archivos implementados**:
  - Controllers: DiplomaAcademicoController
  - Models: DiplomaAcademico, Persona (CI como PK)
  - Livewire: DiplomaAcademicoFormComponent, Forms/DiplomaAcademicoForm, Forms/PersonaForm
  - Services: UniversityApiService, UserHelperService
  - Views: diplomas/index, create, show con componentes primary-button, secondary-button
- **Seeders con datos reales**: GraduacionDaSeeder (32 registros), MencionDaSeeder (73 registros) desde CSV
- **Control de acceso**: Personal (solo propios), Jefe (view-only), Administrador (full access)

### Patrones de Código Establecidos
- **Eager loading completo**: siempre incluir 'mencion.carrera.facultad' para evitar N+1
- **Manejo de errores**: try-catch en operaciones críticas de BD
- **Validaciones**: usar método rules() en lugar de atributos #[Validate] duplicados
- **Autorización**: método privado checkDiplomaAccess() para DRY
- **Storage**: usar Storage::disk('public')->path() en lugar de concatenación directa
- **Forms Livewire**: separar lógica en Form classes dedicadas

### Arquitectura de Archivos
- **Livewire Components**: app/Livewire/ (clases principales)
- **Livewire Forms**: app/Livewire/Forms/ (validación y lógica de datos)
- **Services**: app/Services/ (integraciones externas y helpers)
- **CSV Data**: database/csv/ (datos maestros para seeders)
- **Specs**: specs/ (documentación de pasos de implementación)

### Correcciones de Código Aplicadas
- Eliminadas colisiones de nombres en Livewire
- Corregidas rutas con barras iniciales incorrectas
- Agregados imports faltantes (User model)
- Refactorizada lógica de autorización repetida
- Optimizadas consultas de base de datos
- Implementado manejo robusto de errores

## Índice de Archivos del Sistema

### Migraciones Consolidadas
- `database/migrations/2025_07_31_191902_create_diploma_academicos_table.php` - Migración consolidada que incluye graduacion_da, menciones_da y diploma_academicos

### Modelos
- `app/Models/DiplomaAcademico.php` - Modelo principal diplomas académicos
- `app/Models/MencionDa.php` - Modelo menciones académicas con relación diplomas()
- `app/Models/GraduacionDa.php` - Modelo modalidades graduación con relación diplomas()
- `app/Models/Persona.php` - Modelo personas (CI como PK)
- `app/Models/Carrera.php` - Modelo carreras académicas
- `app/Models/Facultad.php` - Modelo facultades
- `app/Models/User.php` - Modelo usuarios del sistema

### Controllers
- `app/Http/Controllers/DiplomaAcademicoController.php` - CRUD diplomas académicos con sistema de navegación Pills (Lista, Formulario, Menciones, Modalidades)

### Livewire Components
- `app/Livewire/DiplomaAcademicoFormComponent.php` - Componente principal formulario con 2 opciones de registro
- `app/Livewire/PdfAutoUpload.php` - Componente subida automática PDF con extracción CI (index)
- `app/Livewire/PdfAutoUploadForm.php` - Componente subida PDF para formulario registro con búsqueda API automática
- `app/Livewire/MencionesCrud.php` - CRUD simple para gestión de menciones académicas con validación de integridad referencial
- `app/Livewire/ModalidadesGraduacionCrud.php` - CRUD simple para modalidades de graduación con validación de integridad referencial
- `app/Livewire/Forms/DiplomaAcademicoForm.php` - Form class validación diplomas con manejo archivos temporales
- `app/Livewire/Forms/PersonaForm.php` - Form class validación personas

### Services
- `app/Services/UniversityApiService.php` - Integración API universitaria
- `app/Services/UserHelperService.php` - Helpers para usuarios

### Seeders
- `database/seeders/DatabaseSeeder.php` - Seeder principal
- `database/seeders/GraduacionDaSeeder.php` - Modalidades graduación
- `database/seeders/MencionDaSeeder.php` - Menciones académicas
- `database/seeders/FacultadSeeder.php` - Facultades
- `database/seeders/CarreraSeeder.php` - Carreras
- `database/seeders/UserSeeder.php` - Usuarios sistema
- `database/seeders/RoleSeeder.php` - Roles y permisos
- `database/seeders/UserRoleSeeder.php` - Asignación roles

### Views
- `resources/views/components/diplomas/layout.blade.php` - Componente Blade sublayout unificado para Diplomas Académicos con navegación Pills integrada y título combinado
- `resources/views/diplomas/index.blade.php` - Vista principal actualizada que usa el nuevo sublayout
- `resources/views/diplomas/sections/lista.blade.php` - Sección lista diplomas con filtros y tabla (MVC clásico)
- `resources/views/diplomas/sections/menciones.blade.php` - Sección gestión menciones con CRUD (MVC clásico)  
- `resources/views/diplomas/sections/modalidades.blade.php` - Sección gestión modalidades graduación con CRUD (MVC clásico)
- `resources/views/diplomas/show.blade.php` - Ver diploma individual actualizado con sublayout
- `resources/views/diplomas/create.blade.php` - Formulario crear diploma actualizado con sublayout
- `resources/views/diplomas/menciones.blade.php` - Vista wrapper para sección menciones que usa componente
- `resources/views/diplomas/modalidades.blade.php` - Vista wrapper para sección modalidades que usa componente
- `resources/views/livewire/diploma-academico-form.blade.php` - Formulario registro con 2 opciones (API + PDF), paso 2 con manejo inteligente archivos
- `resources/views/livewire/menciones-crud.blade.php` - CRUD completo menciones con modal y validación integridad
- `resources/views/livewire/modalidades-graduacion-crud.blade.php` - CRUD completo modalidades con modal y validación integridad
- `resources/views/livewire/pdf-auto-upload.blade.php` - Vista componente subida automática PDF (index)
- `resources/views/livewire/pdf-auto-upload-form.blade.php` - Vista componente subida PDF con drag & drop para formulario registro
- `resources/views/components/primary-button.blade.php` - Botón primario
- `resources/views/components/secondary-button.blade.php` - Botón secundario
- `resources/views/components/sidebar-section.blade.php` - Componente sidebar collapsible con Alpine.js y persistencia

### CSV Data
- `database/csv/graduacion_da.csv` - 32 modalidades graduación
- `database/csv/menciones_da.csv` - 73 menciones académicas
- `database/csv/facultades.csv` - Facultades UATF
- `database/csv/carreras.csv` - 77 carreras académicas

## Mantenimiento Automático del Índice

**REGLA CRÍTICA ABSOLUTA**: Cada vez que se realice cualquier cambio en la estructura de archivos, **OBLIGATORIAMENTE** actualizar el "Índice de Archivos del Sistema" en este mismo archivo CLAUDE.md:

### Casos que requieren actualización del índice:
1. **Crear nuevos archivos** (modelos, controllers, views, migraciones, etc.)
2. **Modificar archivos existentes** con nuevas funcionalidades significativas
3. **Eliminar archivos existentes** 
4. **Mover/renombrar archivos**
5. **Crear nuevas carpetas** o reorganizar estructura
6. **Agregar nuevos seeders, services, components**

### Proceso automático OBLIGATORIO:
1. Realizar el cambio solicitado
2. **INMEDIATAMENTE después**, actualizar la sección "Índice de Archivos del Sistema"
3. Agregar/eliminar/modificar las rutas correspondientes
4. Incluir descripción funcional actualizada del archivo
5. Mantener organización por categorías
6. **NUNCA omitir este paso** - es tan importante como el cambio mismo

### Beneficios:
- ✅ Acceso directo sin búsquedas repetitivas
- ✅ Contexto inmediato de cada archivo
- ✅ Índice siempre actualizado y confiable
- ✅ Eficiencia máxima en desarrollo
- ✅ Memoria del proyecto siempre sincronizada

### **RECORDATORIO PERMANENTE**: 
**"CREAR/MODIFICAR ARCHIVO = ACTUALIZAR ÍNDICE INMEDIATAMENTE"**

## development-workflow-rules
**REGLA CRÍTICA**: Antes de realizar cualquier cambio de código en el proyecto, SIEMPRE consultar la documentación actualizada de Context7 para:
- Verificar mejores prácticas actuales de la tecnología a usar
- Consultar patrones de implementación recomendados
- Validar que el enfoque planteado es el más apropiado
- Buscar ejemplos de código actualizados y optimizados

### Flujo obligatorio para cambios de código:
1. **Consultar Context7** para la tecnología específica (Laravel, Livewire, Alpine.js, Tailwind CSS, etc.)
2. **Revisar mejores prácticas** y patrones recomendados
3. **Implementar** siguiendo las prácticas documentadas
4. **Validar** que el código sigue los estándares actuales

Esta regla aplica especialmente para:
- Componentes Livewire v3
- Alpine.js con plugins 
- Tailwind CSS v4
- Integraciones Laravel
- Patrones de arquitectura y diseño

**Excepción**: Cambios menores de styling o correcciones obvias no requieren consulta previa.

### Uso Restringido de Componentes Livewire
**REGLA CRÍTICA**: Minimizar el uso de componentes Livewire y usar plantillas Blade normales siempre que sea posible.

**Usar Livewire SOLO cuando:**
- La sección requiere alta reactividad en tiempo real
- Se necesita interactividad compleja sin recarga de página
- Manejo de estados complejos que requieren sincronización servidor-cliente

**Preferir Blade Templates para:**
- Navegación estática y layouts
- Listas y vistas de solo lectura
- Formularios simples que pueden usar submit tradicional
- Cualquier interfaz que no requiera reactividad inmediata

**Patrón recomendado:**
1. **Primera opción**: Controller + Blade templates
2. **Segunda opción**: Livewire solo para secciones específicas reactivas
3. **Evitar**: Livewire para navegación, layouts, o vistas estáticas

## important-instruction-reminders
Do what has been asked; nothing more, nothing less.
NEVER create files unless they're absolutely necessary for achieving your goal.
ALWAYS prefer editing an existing file to creating a new one.
NEVER proactively create documentation files (*.md) or README files. Only create documentation files if explicitly requested by the User.
# important-instruction-reminders
Do what has been asked; nothing more, nothing less.
NEVER create files unless they're absolutely necessary for achieving your goal.
ALWAYS prefer editing an existing file to creating a new one.
NEVER proactively create documentation files (*.md) or README files. Only create documentation files if explicitly requested by the User.