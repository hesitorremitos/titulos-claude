# Documentación del Sistema de Gestión de Títulos

## Descripción general del proyecto
Aplicación institucional desarrollada con Laravel 12 y Vue 3 + Inertia, orientada a la gestión integral de títulos universitarios de la UATF. El sistema centraliza la carga, verificación y administración de diversos tipos de documentos académicos (diplomas académicos, títulos de provisión nacional, maestrías, diplomados, especialidades y diplomas de bachiller), integra catálogos maestros (facultades, carreras, universidades) y mantiene trazabilidad de usuarios y roles mediante permisos granulares.

## Stack tecnológico
- **Backend:** PHP 8.2, Laravel 12, Inertia.js para vistas de una sola página, Spatie Laravel Permission para autorización, Ziggy para exponer rutas al frontend.
- **Frontend:** Vue 3 con TypeScript, Vite 7, Tailwind CSS 4, Pinia para manejo de estado, TanStack Table, biblioteca UI propia basada en componentes reutilizables y notificaciones con Vue Sonner.
- **Herramientas y calidad:** Composer para dependencias PHP, npm para dependencias JavaScript, ESLint 9, Prettier 3, Pest/PhpUnit para pruebas y scripts de automatización (`composer dev`, `npm run build`, etc.).
- **Datos y archivos:** Base de datos configurable (SQLite por defecto, MySQL y otros compatibles via `.env`), almacenamiento de PDFs en discos configurables (`config/filesystems.php`), importaciones masivas desde CSV.

## Organización del código
- `app/Http/Controllers/` agrupa controladores por dominio (Diplomas, Maestrías, Doctorados, etc.) y catálogos maestros (Facultades, Carreras, Usuarios, Universidades).
- `app/Models/` refleja la estructura modular de los controladores, con modelos Eloquent específicos para cada tipo de título y sus entidades auxiliares.
- `app/Services/Documents/` concentra lógica de generación y servicio de documentos PDF por tipo de título.
- `app/Console/Commands/MigrateTitulosCommand.php` implementa un comando Artisan para migraciones masivas desde CSV.
- `routes/web.php` define rutas públicas y redirige a `routes/web-vue.php`, donde se gestionan todas las vistas protegidas con middleware `auth`.
- `resources/js/` contiene layouts, páginas de Inertia organizadas por módulo, stores de Pinia, biblioteca de componentes UI y utilidades compartidas.
- `database/` incluye migraciones, seeders y archivos CSV de respaldo utilizados para poblar el sistema.
- `specs/` guarda documentación funcional y pautas de diseño que respaldan la implementación.

## Estructura backend destacada
- **Autenticación y sesión:** `App\Http\Controllers\Auth\InertiaLoginController` gestiona login/logout; middleware `EnsureActiveRole` obliga a seleccionar un rol activo; `HandleInertiaRequests` inyecta metadatos comunes a las vistas.
- **Gestión de títulos:** Cada dominio (por ejemplo `DiplomaAcademicoController`, `MaestriaController`, `DiplomadoController`, etc.) expone rutas CRUD, endpoints para servir PDFs y búsquedas específicas (búsqueda de personas, descarga de archivos, etc.).
- **Menciones y modalidades:** Controladores auxiliares por dominio (`MencionController`, `ModalidadController`) administran catálogos asociados a cada tipo de título.
- **Catálogos maestros:** Controladores `FacultadController`, `CarreraController`, `UniversidadController` y `UserController` mantienen datos base reutilizados en los formularios de títulos.
- **Servicios de apoyo:** `UniversityApiService`, `UserHelperService` y los servicios de documentos empaquetan lógica común para la aplicación.

## Estructura frontend destacada
- **Layouts:** `resources/js/Layouts/AppLayout.vue` (entorno autenticado) y `GuestLayout.vue` (páginas públicas).
- **Páginas Inertia:** Directorios por módulo dentro de `resources/js/Pages/`, cada uno con formularios de creación, edición, listados, vistas detalladas y pestañas de navegación (`navtabs.json`).
- **Componentes reutilizables:** Biblioteca en `resources/js/components/ui/` (alertas, tablas, formularios, menús, etc.) y componentes funcionales (`components/forms`, `AppSidebar.vue`, `TopBar.vue`).
- **Stores y utilidades:** Stores Pinia por tipo de título y para datos personales (`resources/js/stores`), `composables` para breadcrumbs y autorización, y helpers en `lib/` para peticiones y utilidades.

## Migraciones principales
- **Infraestructura base:** Migraciones iniciales de Laravel para usuarios, cache y jobs (`0001_...`).
- **Roles y permisos:** `2025_07_31_044918_create_permission_tables.php` crea tablas de Spatie (roles, permisos y relaciones).
- **Catálogos académicos:** `2025_07_31_161649_create_facultades_table.php` (facultades), `2025_07_31_161709_create_carreras_table.php` (carreras con PK alfanumérica), `2025_10_07_225723_create_universidades_table.php` (universidades).
- **Personas y diplomas académicos:** `2025_07_31_191835_create_personas_table.php` define la ficha de personas; `2025_07_31_191902_create_diploma_academicos_table.php` crea `diploma_academicos`, `graduacion_da` y `menciones_da`.
- **Títulos de provisión nacional:** `2025_10_06_011635_create_titulo_provision_nacional_table.php` genera la tabla principal `titulo_provision_nacional` y catálogos `menciones_tpn`, `modalidades_tpn`.
- **Diploma de bachiller:** `2025_10_07_164408_create_diploma_bachiller_table.php` crea `diploma_bachiller` y `menciones_db`.
- **Posgrados:** `2025_10_07_184237_create_maestrias_table.php`, `2025_10_07_194622_create_doctorados_table.php`, `2025_10_07_220952_create_diplomados_table.php` y `2025_10_07_225724_create_especialidades_table.php` definen las tablas principales y catálogos de menciones/modalidades para cada nivel.

## Seeders disponibles
- **Obligatorios para el arranque:**
  - `UserSeeder`: crea usuarios iniciales con credenciales básicas.
  - `RoleSeeder`: registra permisos granulares y roles `Administrador`, `Jefe`, `Personal`.
  - `UserRoleSeeder`: asigna roles a los usuarios creados (incluye usuarios demo por rol).
- **Catálogos maestros:**
  - `FacultadSeeder` y `CarreraSeeder`: cargan datos de `database/csv/facultades.csv` y `database/csv/carreras.csv`.
  - `GraduacionDaSeeder` y `MencionDaSeeder`: poblan menciones y modalidades de diplomas académicos (fuentes en `database/csv/menciones/` y `database/csv/mod_graduacion.csv`).
- **Importación histórica (opcional):**
  - `BackupDataSeeder`: importa personas y diplomas desde `database/backups/persona.csv` y `database/backups/diplomas_academicos.csv`; maneja validaciones, logs y control de llaves foráneas.
  - `DiplomaAcademicoSeeder`: procesa `database/csv/titulos/DIPLOMA_A_todo.csv` para migrar registros masivos (descomentarlo en `DatabaseSeeder` cuando se necesite).
- **Seeder raíz:** `DatabaseSeeder` orquesta el orden y permite habilitar/deshabilitar bloques según el entorno.

## Archivos CSV y respaldos
- Directorio `database/csv/` contiene documentación y datasets para menciones, modalidades, facultades, carreras y títulos (`README_MIGRACIONES.md` y `INSTALACION.md` describen el flujo).
- Directorio `database/backups/` almacena exportaciones completas (personas, diplomas académicos) utilizadas por `BackupDataSeeder`.
- Los procesos de importación generan archivos de errores (`*_errors.csv`) para auditoría.

## Comandos y scripts relevantes
- `php artisan migrate:titulos [--fresh]`: ejecuta migraciones masivas declaradas en `MigrateTitulosCommand`, validando presencia de archivos y mostrando un resumen final.
- `composer dev`: levanta en paralelo el servidor Laravel, escucha la cola (`queue:listen`) y ejecuta Vite (`npm run dev`) mediante `concurrently`.
- Scripts npm: `npm run dev`, `npm run build`, `npm run build:ssr`, `npm run lint`, `npm run format`.
- Pruebas: `composer test` limpia configuración y ejecuta suites con Pest/PhpUnit.

## Almacenamiento de archivos
- El disco por defecto (`public`) apunta a `D:/titulos/V5/storage/app/private` según `config/filesystems.php`.
- Se puede definir un disco alternativo modificando dicho archivo y actualizando la variable `FILESYSTEM_DISK` en `.env`.
- El enlace simbólico `public/storage` se crea mediante `php artisan storage:link` cuando se necesita exponer archivos públicamente.

## Recursos adicionales
- **Especificaciones funcionales:** carpeta `specs/` (flujos de autenticación, CRUD, diseño de UI, etc.).
- **Guías de migración:** `database/csv/README_MIGRACIONES.md` e `INSTALACION.md`.
- **Logs:** ubicación principal `storage/logs/laravel.log` para seguimiento de errores en importaciones y operaciones críticas.
