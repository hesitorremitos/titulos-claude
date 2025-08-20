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
- **Frontend:** Vue 3 + Composition API + Inertia.js + Shadcn/vue + TypeScript
- **UI Framework:** Shadcn/vue with Tailwind CSS v4
- **Database:** SQLite (development), designed for PostgreSQL/MySQL (production)
- **Authentication:** Laravel's built-in authentication with Spatie Laravel Permission
- **Icons:** Lucide Icons + Radix Icons via Shadcn/vue
- **Build Tool:** Vite with Vue 3 support
- **State Management:** Vue 3 Composables + Pinia

### Key Dependencies
- `@inertiajs/vue3`: ^2.0.17 - SPA-like navigation
- `vue`: ^3.5.18 - Frontend framework
- `shadcn/vue`: Complete UI component library
- `spatie/laravel-permission`: ^6.21 - Role and permission management
- `@tailwindcss/vite`: ^4.0.0 - Tailwind CSS v4 integration
- `@iconify/vue`: ^5.0.0 - Icon system
- `ziggy-js`: ^2.4.2 - Laravel routes in Vue
- `vue-sonner`: ^2.0.2 - Toast notifications

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
- **Controllers:** Standard Laravel structure in `app/Http/Controllers/`
- **Models:** `app/Models/` with Eloquent relationships
- **Vue Pages:** `resources/js/Pages/` for Inertia.js routes
- **Vue Components:** `resources/js/components/` for reusable components
- **UI Components:** `resources/js/components/ui/` for Shadcn/vue components
- **Layouts:** `resources/js/Layouts/` for Vue layouts
- **Types:** `resources/js/types/` for TypeScript definitions
- **Database migrations:** Follow Laravel conventions
- **Specs:** `specs/` directory for documentation

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
- Hot module replacement (HMR) with Vite for Vue development
- TypeScript support for better development experience

## Key Configuration Files
- `vite.config.js`: Vite build configuration with Vue 3 and Tailwind CSS v4
- `composer.json`: PHP dependencies and custom scripts
- `package.json`: Vue 3, Inertia.js, and Shadcn/vue dependencies
- `tsconfig.json`: TypeScript configuration
- `components.json`: Shadcn/vue components configuration
- `eslint.config.js`: ESLint configuration for Vue + TypeScript
- `config/permission.php`: Spatie permission package configuration

## Development Guidelines

### Code Style and Patterns
- Follow existing Laravel conventions and patterns observed in the codebase
- Use Eloquent relationships consistently (seen in models like Carrera, Facultad)
- Vue 3 Composition API for reactive components
- Shadcn/vue components for consistent UI elements
- TypeScript for better type safety (optional but recommended)
- Audit trail pattern: created_by, updated_by fields for traceability

### File Naming Conventions
- **Controllers:** PascalCase with Controller suffix (e.g., DiplomaAcademicoController)
- **Models:** Singular PascalCase (e.g., DiplomaAcademico, Persona)
- **Vue Pages:** PascalCase (e.g., Index.vue, Create.vue, Dashboard.vue)
- **Vue Components:** PascalCase (e.g., AppSidebar.vue, ThemeToggle.vue)
- **Migrations:** Laravel timestamp format with descriptive names
- **Routes:** `/v2/*` prefix for Vue + Inertia routes

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

## Estado Actual del Proyecto (2025-08-14)

### Migración Vue + Inertia.js COMPLETADA
- **✅ Dashboard**: Completamente migrado con Shadcn/vue components
- **✅ Autenticación**: Sistema completo de login/logout con Inertia
- **✅ Gestión de Perfil**: Actualización de datos, cambio de contraseña, eliminación de cuenta
- **✅ CRUD Facultades**: Index, Create, Edit, Show con navegación centralizada y tablas optimizadas
- **✅ CRUD Carreras**: Index, Create, Edit, Show con navegación centralizada y tablas optimizadas
- **✅ CRUD Usuarios**: Index, Create, Edit, Show con navegación centralizada, tablas optimizadas y estadísticas específicas
- **✅ Sistema de Rutas**: Patrón `/v2/*` para todas las rutas Vue + Inertia
- **✅ Componentes UI**: Sistema completo de Shadcn/vue components
- **✅ Layout System**: AppLayout centralizado con tabs de navegación optimizados
- **✅ Theme System**: Dark/Light mode con persistencia
- **✅ TypeScript**: Configuración completa y tipado de componentes
- **✅ Formularios Diplomas**: Componentes Vue para búsqueda API y registro de diplomas (Fase 1)

### Funcionalidades Migradas
1. **Dashboard Principal**: Estadísticas, accesos rápidos, navegación
2. **Sistema de Autenticación**: Login, logout, gestión de sesiones
3. **Gestión de Perfil**: Actualización de datos personales y contraseña
4. **Facultades CRUD**: Operaciones completas con validación y tablas clickeables
5. **Carreras CRUD**: Operaciones completas con validación y tablas clickeables
6. **Usuarios CRUD**: Operaciones completas con validación, tablas clickeables y estadísticas por rol
7. **Navegación Centralizada**: Tabs optimizados con componentes shadcn/vue nativos
8. **Sistema de Temas**: Toggle dark/light persistente
9. **Búsqueda API Personas**: Integración con API universitaria para auto-fill datos
10. **Formularios Reactivos**: Componentes Vue 3 con Pinia state management
11. **Visor PDF**: Componente drag & drop con iframe nativo para documentos académicos

### Arquitectura Implementada
- **Frontend**: Vue 3 + Composition API + TypeScript
- **Routing**: Inertia.js con server-side routing de Laravel
- **UI Components**: Shadcn/vue con Tailwind CSS v4
- **State**: Vue 3 composables + reactive properties
- **Forms**: Validation con Laravel backend + Vue frontend
- **Notifications**: Vue Sonner para toasts
- **Icons**: Lucide + Radix via Shadcn/vue

### Próximas Fases de Migración

**En progreso (Vue + Inertia)**:
1. **✅ Fase 1 - Base Diplomas**: Búsqueda API, formulario datos personales, visor PDF
2. **🔄 Fase 2 - Formulario Completo**: Campos específicos diploma, validaciones, guardado
3. **⏳ Fase 3 - Lista y Gestión**: Index, edición, eliminación diplomas

**Pendiente de migración (Legacy Blade + Livewire)**:
1. **Títulos Académicos**: CRUD de títulos con validaciones especiales  
2. **Menciones y Modalidades**: Gestión de catálogos especializados
3. **Reportes y Estadísticas**: Visualización avanzada de datos

**Prioridades de migración**:
1. **Alta**: Completar formulario diplomas Vue (Fase 2-3)
2. **Media**: Catálogos y reportes
3. **Completado**: ✅ Páginas administrativas + Base formularios diplomas

### Sistema de Diplomas Académicos (Paso 08) - UI Mejorada
- **Modelo principal**: DiplomaAcademico con relaciones a Persona, MencionDa, GraduacionDa, User
- **API Externa**: https://apititulos.uatf.edu.bo/api/datos?ru='{ci}' (método POST, CI debe ir entre comillas simples)
- **Componente Livewire**: DiplomaAcademicoFormComponent (renombrado para evitar colisión de nombres)
- **Mejoras UI Implementadas** (2025-08-09):
  - Opciones de selección de programa aparecen directamente debajo del buscador
  - Visor PDF con altura optimizada para documentos tamaño oficio (min-height: 850px)
  - Componente PDF upload mejorado siguiendo guía de estilos:
    - Input con diseño consistente (border, iconos, colores primary)
    - Texto reducido y conciso
    - Iconos apropiados de Iconify (mdi--file-pdf-box, mdi--card-account-details)
    - Estados de carga y error mejorados
    - Instrucciones con iconos visuales mejoradas
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

### Patrones Vue + Inertia Establecidos (2025-08-12)
- **Tablas Clickeables**: Patrón `@click="router.visit(route())"` en TableRow completas
- **Navegación por Teclado**: `@keydown.enter` y `@keydown.space.prevent` en elementos interactivos
- **Estados Hover**: `hover:bg-accent/30` con `transition-colors duration-150` para feedback visual
- **Accesibilidad**: `tabindex="0"`, `aria-label`, `role="button"` en elementos clickeables
- **Stats Cards**: Solo mostrar cuando aporten valor de negocio (ej: usuarios por rol)
- **Iconos Específicos**: Usar lucide icons representativos por contexto (building-2, users, list-checks)
- **Componentes Shadcn**: Preferir componentes nativos (Tabs, TabsList, TabsTrigger) sobre custom
- **Props Typing**: Definir interfaces TypeScript claras con datos opcionales (`|| 0` fallbacks)
- **Layout Responsive**: Grid con breakpoints `md:grid-cols-2 lg:grid-cols-4` para cards
- **Remove Redundancy**: Eliminar breadcrumbs, search bars y filtros innecesarios por sección

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
- `database/migrations/2025_08_08_create_titulo_academicos_table.php` - **NUEVO** Migración para títulos académicos con campo nro_diploma_academico

### Modelos
- `app/Models/DiplomaAcademico.php` - Modelo diplomas académicos (con campo mencion_da_id)
- `app/Models/TituloAcademico.php` - **NUEVO** Modelo títulos académicos (con campo nro_diploma_academico)
- `app/Models/MencionDa.php` - Modelo menciones académicas con relación diplomas()
- `app/Models/GraduacionDa.php` - Modelo modalidades graduación con relación diplomas()
- `app/Models/Persona.php` - Modelo personas (CI como PK)
- `app/Models/Carrera.php` - Modelo carreras académicas
- `app/Models/Facultad.php` - Modelo facultades
- `app/Models/User.php` - Modelo usuarios del sistema

### Controllers (Vue + Inertia)
- `app/Http/Controllers/StyleGuideController.php` - Controlador para la guía de estilos del sistema
- `app/Http/Controllers/ProfileController.php` - Gestión de perfil con métodos Vue/Inertia
- `app/Http/Controllers/DashboardController.php` - Dashboard para Vue + Inertia
- `app/Http/Controllers/Auth/InertiaLoginController.php` - Autenticación para Vue + Inertia
- `app/Http/Controllers/V2/UserController.php` - CRUD usuarios con estadísticas por rol
- `app/Http/Controllers/V2/FacultadController.php` - CRUD facultades Vue + Inertia con tablas optimizadas
- `app/Http/Controllers/V2/CarreraController.php` - CRUD carreras Vue + Inertia con tablas optimizadas
- `app/Http/Controllers/V2/DiplomaAcademicoController.php` - CRUD diplomas académicos Vue + Inertia
- `app/Http/Controllers/V2/MencionController.php` - CRUD menciones académicas Vue + Inertia
- `app/Http/Controllers/V2/ModalidadController.php` - CRUD modalidades graduación Vue + Inertia

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

### Vue Pages & Components (Inertia)
- `resources/js/Layouts/AppLayout.vue` - **ACTUALIZADO** Layout principal Vue con Shadcn/vue Tabs nativos y sin breadcrumbs
- `resources/js/components/AppSidebar.vue` - **ACTUALIZADO** Sidebar Vue con logout funcional y navegación a perfil
- `resources/js/Pages/Dashboard.vue` - Dashboard principal Vue + Inertia
- `resources/js/Pages/Login.vue` - Página de login Vue + Inertia
- `resources/js/Pages/Profile/Index.vue` - **NUEVO** Página principal de gestión de perfil
- `resources/js/Pages/Profile/partials/UpdateProfileForm.vue` - **NUEVO** Formulario actualización datos personales
- `resources/js/Pages/Profile/partials/UpdatePasswordForm.vue` - **NUEVO** Formulario cambio de contraseña
- `resources/js/Pages/Profile/partials/DeleteAccountSection.vue` - **NUEVO** Sección eliminación de cuenta con modal
- `resources/js/Pages/Facultades/Index.vue` - **OPTIMIZADO** Tabla clickeable sin columna acciones, sin stats cards
- `resources/js/Pages/Facultades/Create.vue` - **OPTIMIZADO** Con tabs de navegación shadcn/vue
- `resources/js/Pages/Carreras/Index.vue` - **OPTIMIZADO** Tabla clickeable sin columna acciones, sin stats/filtros
- `resources/js/Pages/Carreras/Create.vue` - **OPTIMIZADO** Con tabs de navegación shadcn/vue
- `resources/js/Pages/Usuarios/Index.vue` - **OPTIMIZADO** Tabla clickeable + stats cards específicas por rol
- `resources/js/Pages/Usuarios/Create.vue` - **OPTIMIZADO** Con tabs de navegación shadcn/vue
- `resources/js/Pages/DiplomasAcademicos/Create.vue` - **NUEVO** Formulario 2 pasos para registro diplomas con API search + visor PDF

### Vue Components (Formularios y Utilidades)
- `resources/js/components/forms/ApiPersonSearch.vue` - **NUEVO** Componente búsqueda de personas por CI con API universitaria
- `resources/js/components/forms/PersonalDataForm.vue` - **NUEVO** Formulario datos personales con auto-fill desde API
- `resources/js/components/forms/PdfViewer.vue` - **NUEVO** Visor PDF con drag & drop, iframe nativo y controles de descarga
- `resources/js/stores/usePersonalDataStore.ts` - **NUEVO** Store Pinia para manejo de búsqueda API y datos personales

### Routes (Vue + Inertia)
- `routes/web-vue.php` - Rutas Vue + Inertia con sistema completo de autenticación y gestión de perfil
- `routes/web.php` - Rutas legacy mínimas (solo style guide y redirección)

### Style Guide (Solo para documentación)
- `resources/views/style-guide/index.blade.php` - Página principal guía de estilos modular
- `resources/views/style-guide/partials/` - Componentes de layout compartidos (header, navigation, footer, scripts)
- `resources/views/style-guide/sections/` - Secciones individuales de componentes (buttons, cards, colors, forms, etc.)


### CSV Data  
- `database/csv/graduacion_da.csv` - 32 modalidades graduación
- `database/csv/menciones_da.csv` - 73 menciones académicas
- `database/csv/facultades.csv` - Facultades UATF
- `database/csv/carreras.csv` - 77 carreras académicas

## PDF Upload System Consolidation (2025-08-09)

### Problem Fixed: Multiple PDF Upload Inputs
**Issue:** The system had multiple PDF upload inputs causing confusion and duplicate functionality:
- `PdfViewerForm` had its own file upload input (redundant)
- `PdfAutoUploadForm` handled uploads in step 1
- Manual upload existed in step 2 in the main form
- Missing event handlers between components

### Solution Implemented: Single PDF Upload System
**Consolidated Architecture:**
1. **Step 1 Upload:** `PdfAutoUploadForm` component handles automatic CI extraction and API lookup
2. **Step 2 Upload:** Manual file upload in main diploma form (fallback option)
3. **PDF Viewer:** `PdfViewerForm` is now display-only, no upload functionality
4. **Event Flow:** Proper event handling between all components

**Key Changes Made:**
- **`PdfViewerForm.php`:** Removed `WithFileUploads` trait and upload methods, kept only display functionality
- **`pdf-viewer-form.blade.php`:** Removed drag & drop upload UI, kept only viewer and empty state
- **`DiplomaAcademicoFormComponent.php`:** Added missing event handlers (`pdf-uploaded-with-success`, `pdf-uploaded-manual-entry`) 
- **`BaseTituloFormComponent.php`:** Fixed listener merging with `getListeners()` method
- **Event Flow:** `PdfAutoUploadForm` → `DiplomaAcademicoFormComponent` → `PdfViewerForm` (display only)

**Result:** Clean, single-responsibility PDF upload system with proper event handling and no duplicate functionality.

## Frontend Corrections 2025

### Layout Consolidation Completed
- **Main Layout**: `resources/views/layouts/app-layout.blade.php` with component `app/View/Components/AppLayout.php`
- **Diplomas Layout**: `resources/views/layouts/diplomas-layout.blade.php` with component `app/View/Components/DiplomasLayout.php`
- **Removed**: Duplicate layout `resources/views/layouts/app.blade.php`
- **Theme Toggle**: Functional in `resources/views/layouts/partials/navbar.blade.php` with `id="theme-toggle"`

### Route Naming Fixed for Modalidades
- **URL**: `/diplomas/mod_grad` (was `/diplomas/modalidades`)
- **Routes**: `diplomas.mod_grad.*` in `routes/web.php`
- **Controller**: `ModalidadGraduacionController.php` updated
- **Views**: Located in `resources/views/diplomas/mod_grad/`

### JavaScript Optimized
- **File**: `resources/js/app.js` reduced from 109 to 46 lines
- **Removed**: Redundant mobile menu and user dropdown code
- **Handled by**: Alpine.js manages UI interactivity

## UI/UX Optimizations (2025-08-12)

### Table Design Improvements
**Problem Solved:** Tablas con diseño ineficiente, desperdicio de espacio y botones de acción poco óptimos.

**Solution Implemented:**
- **✅ Filas Completamente Clickeables**: Patrón UX recomendado - toda la fila es clickeable
- **✅ Eliminación Columna Acciones**: 30% menos anchura, mejor uso del espacio
- **✅ Diseño Compacto**: Altura de fila reducida de ~60px a ~48px (20% menos espacio)
- **✅ Estados Hover/Focus**: Transiciones suaves con feedback visual inmediato
- **✅ Navegación por Teclado**: Enter/Space + ARIA labels para accesibilidad completa
- **✅ Tipografía Optimizada**: `text-sm` para mayor densidad sin sacrificar legibilidad

### Navigation Tabs Enhancement
**Upgraded to Shadcn/Vue Native Components:**
- **✅ Tabs, TabsList, TabsTrigger**: Componentes nativos con estados automáticos
- **✅ Iconos Actualizados**: Lucide icons más específicos y representativos
  - Facultades: `lucide:building-2` (lista), `lucide:plus-circle` (registrar)
  - Carreras: `lucide:list-checks` (lista), `lucide:plus-circle` (registrar)  
  - Usuarios: `lucide:users` (lista), `lucide:user-plus` (registrar)
- **✅ Accesibilidad Mejorada**: Focus rings, keyboard navigation, ARIA attributes
- **✅ Transiciones Suaves**: 200ms duration para todas las interacciones

### Stats Cards Optimization
**Targeted User Statistics Implementation:**
- **✅ Facultades/Carreras**: Cards de stats completamente removidas (no necesarias)
- **✅ Usuarios**: Cards específicas con datos de negocio relevantes:
  - 🔴 Administradores (con icono `lucide:shield-check`)
  - 🔵 Jefes (con icono `lucide:user-cog`)
  - 🟢 Personal (con icono `lucide:users`)
  - 🟡 Activos/Inactivos (con icono `lucide:activity`)
- **✅ Backend Integration**: Controlador actualizado con cálculos de estadísticas usando Spatie Permission

### Accessibility & User Experience
- **✅ Click Targets**: Área de clic 3x más grande (toda la fila vs botón pequeño)
- **✅ Keyboard Navigation**: Tab, Enter, Space para navegación completa
- **✅ Screen Reader Support**: `aria-label`, `role="button"`, descripciones contextual
- **✅ Focus Indicators**: Rings visibles con `focus-visible:ring-2`
- **✅ Loading States**: Transiciones y feedback durante navegación

### Code Architecture Improvements
**Vue/Inertia Pattern Consistency:**
- **✅ Clickeable Rows**: `@click="router.visit(route())"` patrón unificado
- **✅ Responsive Design**: Grid layouts con breakpoints `md:grid-cols-2 lg:grid-cols-4`
- **✅ Component Reusability**: Badge variants, Card layouts, Icon systems
- **✅ TypeScript Integration**: Interface Props con stats typing
- **✅ Error Handling**: Props validation y fallbacks (`|| 0` para stats)

**Key Benefits Achieved:**
1. **Space Efficiency**: 30% reducción en altura de tablas
2. **Better UX**: Click targets 3x más grandes
3. **Visual Hierarchy**: Mejor contraste y organización de información
4. **Performance**: Menos DOM elements, event handlers optimizados
5. **Accessibility**: Cumple WCAG guidelines para navegación por teclado
6. **Consistency**: Patrón unificado en todas las secciones administrativas

## development-workflow-rules

### Arquitectura Vue + Inertia.js (Post-Migración)
**REGLA CRÍTICA**: Sistema completamente migrado de Livewire + Blade a Vue 3 + Inertia.js

**Stack Tecnológico Actual:**
- **Frontend**: Vue 3 + Composition API + TypeScript
- **Routing**: Inertia.js con server-side routing de Laravel
- **UI Components**: Shadcn/vue con Tailwind CSS v4
- **State Management**: Vue 3 composables + Pinia stores
- **Backend**: Laravel 12 con controladores en `/V2/`

**Patrón Establecido:**
1. **Frontend**: Vue 3 pages en `resources/js/Pages/`
2. **Componentes**: Shadcn/vue + componentes personalizados
3. **Backend**: Controladores en `app/Http/Controllers/V2/`
4. **Rutas**: Definidas en `routes/web-vue.php`
5. **Legacy**: Eliminado completamente (Livewire + Blade legacy)

## Recordatorios Importantes

### Reglas de Código
- NO usar emojis o emoticones en código, vistas, o archivos del proyecto
- Mantener todo el contenido profesional y basado en texto
- Hacer exactamente lo que se pide, ni más ni menos
- NUNCA crear archivos a menos que sean absolutamente necesarios
- SIEMPRE preferir editar un archivo existente antes que crear uno nuevo
- NUNCA crear archivos de documentación proactivamente

### Actualización Automática del Índice
**REGLA CRÍTICA**: Cada cambio en estructura de archivos debe actualizar el índice inmediatamente
- Crear/modificar archivos = actualizar índice OBLIGATORIO
- Mantener organización por categorías
- Incluir descripción funcional actualizada
- Nunca omitir este paso - es tan importante como el cambio mismo


## Recomendaciones Adicionales

### Uso del MCP de Serena
- **Recordar siempre usar el MCP de Serena en lo posible durante el desarrollo del sistema**