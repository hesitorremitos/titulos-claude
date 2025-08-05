# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

This is a Laravel 12 application for digitalizing academic titles for the Universidad Autónoma Tomás Frías (UATF) Department of Titles in Potosí, Bolivia. The system replaces manual physical file management with a digital system for registering, searching, and managing academic titles.

**Target Title Types:**
- Academic Diplomas (Diplomas Académicos)  
- Professional Titles (Títulos Profesionales) 
- High School Diplomas (Diplomas de Bachiller)

## Development Commands

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
- **University API:** `https://apititulos.uatf.edu.bo/api/datos?ru='{ci}'` (CI parameter must be enclosed in single quotes)
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

## Development Environment
- No testing framework implemented - testing is not required for this project
- Manual execution and verification of functionality

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

### Project Environment
- No testing environment configured - manual verification used
- Development environment uses SQLite database

## Memory Notes

### Progreso del Proyecto
- Todos los requerimientos y los pasos que se van a ir haciendo, se están documentando en `specs/`
- **Paso 08 COMPLETADO**: Sistema CRUD de Diplomas Académicos implementado con integración API universitaria (specs/08-sistema-diplomas-academicos.md)
- **Paso 09 COMPLETADO**: Mejoras UI - Sidebar Collapsible con Alpine.js y Persistencia (specs/09-mejoras-ui-sidebar-collapsible.md)
- **Paso 10 COMPLETADO**: Subsecciones para Diplomas Académicos con arquitectura MVC limpia y layout unificado (specs/10-subsecciones-diplomas-academicos.md)
- Sistema de usuarios y permisos completamente funcional
- Base de datos con facultades, carreras y datos maestros implementados

### Sistema de Diplomas Académicos (Paso 08)
- **Modelo principal**: DiplomaAcademico con relaciones a Persona, MencionDa, GraduacionDa, User
- **API Externa**: https://apititulos.uatf.edu.bo/api/datos?ru='{ci}' (método POST, CI debe ir entre comillas simples)
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

### Limpieza de Componentes (Arquitectura Optimizada)
- **Componentes eliminados**: 13 componentes redundantes o innecesarios
- **Componente unificado**: Creado `x-button` con 4 variantes (primary, secondary, outline, danger)
- **Actualización de vistas**: 6 archivos de vista actualizados con reemplazos HTML directos
- **Guía de estilos**: Completamente actualizada para reflejar nueva arquitectura
- **Navbar mejorada**: Agregado toggle de tema dark/light reemplazando notificaciones
- **Resultado**: Sistema más limpio, mantenible y consistente

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
- `app/Http/Controllers/DiplomasAcademicos/DiplomaAcademicoController.php` - CRUD principal diplomas académicos
- `app/Http/Controllers/DiplomasAcademicos/MencionController.php` - CRUD completo menciones académicas (sin filtros)
- `app/Http/Controllers/DiplomasAcademicos/ModalidadGraduacionController.php` - CRUD completo modalidades graduación (sin filtros)
- `app/Http/Controllers/StyleGuideController.php` - Controlador para la guía de estilos del sistema

### View Components
- `app/View/Components/DiplomasLayout.php` - Componente Laravel para layout unificado de diplomas académicos

### Blade Components (Sistema de Diseño)
- `resources/views/components/breadcrumb.blade.php` - Componente breadcrumb navegacional con iconos
- `resources/views/components/page-header.blade.php` - Header de página con breadcrumbs, título y acciones
- `resources/views/components/page-section.blade.php` - Sección de página con título y descripción opcional
- `resources/views/components/form-field.blade.php` - Campo de formulario con label, error y help text
- `resources/views/components/form-input-icon.blade.php` - Input con icono interno
- `resources/views/components/form-textarea.blade.php` - Textarea estilizado con configuración de filas
- `resources/views/components/button-group.blade.php` - Grupo de botones con variantes de estilo
- `resources/views/components/icon-button.blade.php` - Botón con solo icono y múltiples variantes
- `resources/views/components/danger-button.blade.php` - Botón de acción peligrosa (eliminar)
- `resources/views/components/navigation-tab.blade.php` - Tab de navegación con estado activo
- `resources/views/components/validation-message.blade.php` - Mensaje de validación con iconos por tipo

### Livewire Components
- `app/Livewire/DiplomaAcademicoFormComponent.php` - Componente principal formulario con 2 opciones de registro
- `app/Livewire/PdfAutoUpload.php` - Componente subida automática PDF con extracción CI (index)
- `app/Livewire/PdfAutoUploadForm.php` - Componente subida PDF para formulario registro con búsqueda API automática
- `app/Livewire/Toast.php` - Sistema de notificaciones toast optimizado (eventos como arrays)
- `app/Livewire/ButtonTest.php` - Botón simple que emite eventos con parámetros configurables
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
- `resources/views/layouts/diplomas-layout.blade.php` - Layout unificado para sección diplomas académicos
- `resources/views/diplomas/index.blade.php` - Vista principal con accesos rápidos a subsecciones
- `resources/views/diplomas/create.blade.php` - Formulario creación diploma con layout unificado
- `resources/views/diplomas/show.blade.php` - Ver diploma individual con layout unificado
- `resources/views/diplomas/menciones/index.blade.php` - Lista menciones (sin filtros de búsqueda)
- `resources/views/diplomas/menciones/create.blade.php` - Crear mención con layout unificado
- `resources/views/diplomas/menciones/edit.blade.php` - Editar mención con layout unificado
- `resources/views/diplomas/menciones/show.blade.php` - Ver mención con layout unificado
- `resources/views/diplomas/mod_grad/index.blade.php` - Lista modalidades (sin filtros de búsqueda)
- `resources/views/diplomas/mod_grad/create.blade.php` - Crear modalidad con layout unificado
- `resources/views/diplomas/mod_grad/edit.blade.php` - Editar modalidad con layout unificado
- `resources/views/diplomas/mod_grad/show.blade.php` - Ver modalidad con layout unificado
- `resources/views/livewire/diploma-academico-form.blade.php` - Formulario registro con 2 opciones (API + PDF)
- `resources/views/livewire/pdf-auto-upload.blade.php` - Vista componente subida automática PDF (index)
- `resources/views/livewire/pdf-auto-upload-form.blade.php` - Vista componente subida PDF con drag & drop para formulario registro
- `resources/views/livewire/toast.blade.php` - Vista componente toast optimizada (duración manejada directamente en Alpine.js)
- `resources/views/livewire/button-test.blade.php` - Vista simple de botón que emite eventos
- `resources/views/style-guide.blade.php` - Guía de estilos del sistema con componentes UI principales (solo ejemplos visuales y documentación)

### Blade Components (Arquitectura Optimizada)
- `resources/views/components/button.blade.php` - **Componente unificado** de botones con variantes (primary, secondary, outline, danger), tamaños (sm, md, lg), soporte para iconos y enlaces
- `resources/views/components/form-field.blade.php` - Wrapper para campos de formulario con etiqueta, validación y mensajes de ayuda
- `resources/views/components/data-table.blade.php` - Tabla responsiva con estilos consistentes para mostrar datos
- `resources/views/components/card.blade.php` - Contenedor de tarjeta con header opcional y estilos consistentes
- `resources/views/components/sidebar-section.blade.php` - Componente sidebar collapsible con Alpine.js y persistencia
- `resources/views/components/pdf-viewer.blade.php` - Componente reutilizable de visor PDF con drag & drop y viewer nativo
- `resources/views/components/searchable-select.blade.php` - Componente select buscable con navegación por teclado y accesibilidad completa
- `resources/views/components/primary-button.blade.php` - **Mantenido por compatibilidad** (se recomienda usar `x-button variant="primary"`)
- `resources/views/components/secondary-button.blade.php` - **Mantenido por compatibilidad** (se recomienda usar `x-button variant="secondary"`)

### Componentes Eliminados (Arquitectura Limpia)
**Los siguientes componentes fueron eliminados para simplificar la arquitectura:**
- `x-stat-card` - Reemplazado por HTML directo en vistas (mismo diseño visual)
- `x-danger-button` - Consolidado en `x-button` con `variant="danger"`
- `x-button-group` - Reemplazado por divs con clases Tailwind directas
- `x-page-section` - Reemplazado por HTML directo en vistas
- `x-breadcrumb` - Eliminado (no se usaba en el sistema)
- `x-activity-feed` - Eliminado (no se usaba en el sistema)
- `x-notification` - Reemplazado por sistema toast de Livewire
- `x-quick-action` - Eliminado (no se usaba en el sistema)

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

### Propósito:
- Acceso directo sin búsquedas repetitivas
- Contexto inmediato de cada archivo
- Índice siempre actualizado y confiable

### **RECORDATORIO PERMANENTE**: 
**"CREAR/MODIFICAR ARCHIVO = ACTUALIZAR ÍNDICE INMEDIATAMENTE"**

## development-workflow-rules

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

#NEVER use emojis or emoticons in code, views, or any project files. Keep all content professional and text-based only.
# important-instruction-reminders
Do what has been asked; nothing more, nothing less.
NEVER create files unless they're absolutely necessary for achieving your goal.
ALWAYS prefer editing an existing file to creating a new one.
NEVER proactively create documentation files (*.md) or README files. Only create documentation files if explicitly requested by the User.

## Recomendaciones Adicionales

### Uso del MCP de Serena
- **Recordar siempre usar el MCP de Serena en lo posible durante el desarrollo del sistema**