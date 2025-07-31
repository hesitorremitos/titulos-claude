# Paso 05: Sistema CRUD para Gestión de Facultades y Carreras

## Descripción
En este paso se implementó un sistema completo CRUD (Create, Read, Update, Delete) para la gestión de Facultades y Carreras académicas, como parte del sistema de digitalización de títulos de la Universidad Autónoma Tomás Frías (UATF). El sistema incluye una interfaz simplificada sin buscadores y una funcionalidad mejorada de creación de carreras desde la vista de facultades.

## Arquitectura Implementada

### 1. Modelos de Datos

#### Modelo Facultad (`app/Models/Facultad.php`)
```php
- Atributos: id, nombre, direccion, created_at, updated_at
- Relaciones: hasMany(Carrera::class)
- Scopes: search() para búsquedas (removido en versión final)
- Accessors: carreras_count para contar carreras
```

#### Modelo Carrera (`app/Models/Carrera.php`)
```php
- Atributos: id (string), programa, facultad_id, created_at, updated_at
- Relaciones: belongsTo(Facultad::class)
- Scopes: search(), byFacultad() (removidos en versión final)
- Configuración: primary key como string para códigos alfanuméricos
```

### 2. Migraciones de Base de Datos

#### Tabla Facultades
```sql
- id: bigint unsigned primary key auto_increment
- nombre: varchar(255) not null
- direccion: varchar(255) nullable
- timestamps
```

#### Tabla Carreras
```sql
- id: varchar(255) primary key (código alfanumérico)
- programa: varchar(255) not null
- facultad_id: bigint unsigned, foreign key references facultades(id)
- timestamps
```

### 3. Controladores

#### FacultadController
- **index()**: Lista paginada simplificada de facultades con conteo de carreras
- **create()**: Formulario de creación
- **store()**: Validación y creación de nueva facultad
- **show()**: Detalle de facultad con carreras asociadas y funcionalidad para agregar nuevas carreras
- **edit()**: Formulario de edición
- **update()**: Validación y actualización
- **destroy()**: Eliminación con protección de integridad referencial

#### CarreraController
- **index()**: Lista paginada simplificada de carreras con facultad
- **create(Request $request)**: Formulario de creación con soporte para pre-selección de facultad via parámetro `facultad_id`
- **store()**: Validación y creación con código alfanumérico único
- **show()**: Detalle de carrera
- **edit()**: Formulario de edición
- **update()**: Validación y actualización
- **destroy()**: Eliminación segura

### 4. Vistas Blade Simplificadas

#### Estructura de Vistas
```
resources/views/
├── facultades/
│   ├── index.blade.php      # Lista simplificada sin buscador
│   ├── create.blade.php     # Formulario de creación
│   ├── edit.blade.php       # Formulario de edición
│   └── show.blade.php       # Detalle con opción de agregar carreras
├── carreras/
│   ├── index.blade.php      # Lista simplificada sin filtros
│   ├── create.blade.php     # Formulario con pre-selección de facultad
│   ├── edit.blade.php       # Formulario de edición
│   └── show.blade.php       # Detalle de carrera
└── components/
    ├── card.blade.php       # Componente de tarjeta (mejorado)
    ├── button.blade.php     # Componente de botón (corregido)
    ├── form-input.blade.php # Componente de input
    └── form-select.blade.php # Componente de select
```

### 5. Sistema de Componentes Reutilizables (Mejorados)

#### Componente Card (Actualizado)
```blade
- Props: title (opcional), description (opcional)
- Slots: header (prioritario), default
- Características: 
  * Estilo consistente, soporte para tema oscuro
  * Soporte para header personalizado via slot
  * Header condicional (solo aparece si hay contenido)
  * Compatibilidad con prop title o slot header
```

#### Componente Button (Corregido)
```blade
- Props: href (opcional, null por defecto), variant, size, icon
- Variantes: primary, secondary, success, danger, warning, outline
- Tamaños: sm, md, lg
- Características:
  * Soporte para iconos Iconify
  * Detección automática de enlace vs botón
  * Validación mejorada de variables
```

#### Componente Form Input
```blade
- Props: label, name, type, placeholder, value, required, icon
- Características: Validación visual, mensajes de error
```

#### Componente Form Select (Con Pre-selección)
```blade
- Props: label, name, placeholder, required, icon
- Slot: options
- Características: 
  * Estilo consistente con inputs
  * Soporte para valores pre-seleccionados
  * Compatibilidad con old() de Laravel
```

### 6. Rutas Configuradas

```php
// Configuración con parámetros personalizados para evitar conflictos
Route::resource('facultades', FacultadController::class)->parameters([
    'facultades' => 'facultad'
]);

Route::resource('carreras', CarreraController::class)->parameters([
    'carreras' => 'carrera'
]);
```

**Rutas generadas:**
- GET `/facultades` - Lista de facultades
- GET `/facultades/create` - Formulario de creación
- POST `/facultades` - Crear facultad
- GET `/facultades/{facultad}` - Ver facultad (con opción de agregar carreras)
- GET `/facultades/{facultad}/edit` - Editar facultad
- PUT/PATCH `/facultades/{facultad}` - Actualizar facultad
- DELETE `/facultades/{facultad}` - Eliminar facultad

**Ruta especial para carreras:**
- GET `/carreras/create?facultad_id={id}` - Crear carrera con facultad pre-seleccionada

### 7. Seeders de Datos

#### FacultadSeeder
Datos de las 7 facultades de la UATF:
1. CIENCIAS PURAS
2. INGENIERIA TECNOLOGICA
3. CIENCIAS ECONOMICAS FINANCIERAS Y ADMINISTRATIVAS
4. CIENCIAS JURIDICAS POLITICAS SOCIALES Y DE LA COMUNICACION
5. CIENCIAS DE LA SALUD
6. CIENCIAS AGRICOLAS Y PECUARIAS
7. ARQUITECTURA Y URBANISMO

#### CarreraSeeder
26 carreras académicas distribuidas por facultades con códigos alfanuméricos únicos:
- Ciencias Puras: 5 carreras (INFR1, MATM1, QUIM1, FISI1, BIOL1)
- Ingeniería Tecnológica: 6 carreras (INMIN, INMET, INMEC, INELE, INMCT, INCIV)
- Ciencias Económicas: 4 carreras (ADMI1, CONT1, ECON1, INGE1)
- Ciencias Jurídicas: 3 carreras (DERE1, COMU1, TRAB1)
- Ciencias de la Salud: 4 carreras (MEDI1, ODON1, ENFE1, BIOM1)
- Ciencias Agrícolas: 3 carreras (AGRO1, ZOOT1, INAL1)
- Arquitectura: 1 carrera (ARQU1)

### 8. Características Técnicas

#### Validación de Datos
- **Facultades**: nombre requerido y único, dirección opcional
- **Carreras**: código alfanumérico único (5 caracteres), programa requerido, facultad_id válida

#### Protección de Integridad
- Eliminación de facultades solo si no tienen carreras asociadas
- Claves foráneas con restricciones
- Validación de entrada en formularios con mensajes personalizados

#### Interfaz Simplificada
- **Sin buscadores**: Eliminación de funcionalidad de búsqueda y filtros
- **Tablas HTML directas**: Reemplazo de componentes complejos por HTML simple
- **Paginación básica**: 10 elementos por página sin conservación de parámetros
- **UX mejorada**: Botones de acción integrados en headers

#### Funcionalidad de Creación Contextual
- **Desde vista de facultad**: Botón "Agregar Carrera" que pre-selecciona la facultad
- **Pre-selección automática**: Al crear carrera desde facultad, se pre-selecciona automáticamente
- **Flujo de usuario optimizado**: Menos clics y menor posibilidad de error
- **Compatibilidad**: Funciona tanto con pre-selección como sin ella

#### Diseño y Accesibilidad
- Diseño responsivo con Tailwind CSS
- Soporte para tema oscuro/claro
- Iconografía consistente con Iconify (Material Design Icons)
- Transiciones y estados hover
- Breadcrumbs de navegación
- Etiquetas aria-label apropiadas
- Estructura semántica HTML
- Contraste de colores adecuado

## Mejoras Implementadas

### 1. Eliminación de Buscadores
**Problema resuelto**: Interfaz sobrecargada con filtros complejos
**Solución**: 
- Eliminación del componente `x-data-table`
- Implementación de tablas HTML directas
- Simplificación de controladores (sin parámetros de búsqueda)
- UX más limpia y directa

### 2. Corrección de Componentes
**Problema resuelto**: Error "Undefined variable $href" y "$title"
**Solución**:
- Props opcionales con valores por defecto (`href => null`, `title => null`)
- Validación mejorada con `isset()` en componentes
- Soporte para slots alternativos en componente Card

### 3. Funcionalidad Contextual
**Problema resuelto**: Creación de carreras desconectada del contexto de facultad
**Solución**:
- Parámetro `facultad_id` en URL de creación
- Pre-selección automática en formulario
- Botones de acción desde vista show de facultad
- Flujo de usuario optimizado

### 4. Configuración de Rutas
**Problema resuelto**: Conflicto entre nombres plurales de rutas y parámetros de modelo
**Solución**:
- Configuración de `parameters()` en resource routes
- Mapeo correcto: `'facultades' => 'facultad'`, `'carreras' => 'carrera'`
- URLs más coherentes y predecibles

## Comandos de Instalación

```bash
# Ejecutar migraciones
php artisan migrate

# Ejecutar seeders
php artisan db:seed

# O específicamente
php artisan db:seed --class=FacultadSeeder
php artisan db:seed --class=CarreraSeeder

# Verificar rutas
php artisan route:list --name=facultades
php artisan route:list --name=carreras
```

## Flujos de Usuario Optimizados

### Flujo 1: Gestión General
1. Dashboard → Facultades/Carreras
2. Lista paginada simple
3. Acciones directas (Ver, Editar, Eliminar)

### Flujo 2: Creación Contextual
1. Dashboard → Facultades → Ver Facultad Específica
2. Click "Agregar Carrera"
3. Formulario con facultad pre-seleccionada
4. Completar código y programa
5. Guardar y regresar

### Flujo 3: Gestión Detallada
1. Ver detalle de facultad
2. Lista de carreras asociadas
3. Acciones en cada carrera (Ver detalle)
4. Navegación fluida entre entidades relacionadas

## Estructura de Archivos Actualizada

### Controladores Simplificados
```php
// FacultadController::index() - Sin parámetros de búsqueda
// CarreraController::create(Request $request) - Con soporte para pre-selección
```

### Vistas Simplificadas
```blade
// facultades/index.blade.php - Tabla HTML directa
// carreras/index.blade.php - Sin filtros
// facultades/show.blade.php - Con botones de acción para carreras
// carreras/create.blade.php - Con pre-selección de facultad
```

### Componentes Corregidos
```blade
// components/card.blade.php - Props opcionales, soporte para slots
// components/button.blade.php - Href opcional, validación mejorada
```

## Próximos Pasos

Este sistema CRUD optimizado forma la base sólida para:
1. **Gestión de estudiantes** por carrera y facultad
2. **Registro de títulos y diplomas** con relaciones definidas
3. **Sistema de aprobación y validación** de documentos
4. **Reportes y estadísticas** académicas por facultad/carrera
5. **Integración con autenticación** y roles de usuario
6. **API REST** para integraciones externas
7. **Exportación de datos** en múltiples formatos

## Notas de Desarrollo

### Decisiones de Diseño
- **Simplicidad sobre funcionalidad**: Se priorizó una interfaz limpia
- **Contextualización**: Creación de carreras desde facultades
- **Consistencia**: Componentes reutilizables y estilo unificado
- **Mantenibilidad**: Código limpio y bien documentado

### Optimizaciones Realizadas
- **Consultas eficientes**: Uso de `with()` para eager loading
- **Validación robusta**: Mensajes personalizados y reglas específicas
- **UX mejorada**: Menos pasos para tareas comunes
- **Código reutilizable**: Componentes modulares y flexibles

### Consideraciones Futuras
- **Búsqueda avanzada**: Reimplementar si el volumen de datos lo requiere
- **Exportación**: Agregar funcionalidad de export a PDF/Excel
- **Historial**: Implementar auditoría de cambios
- **API**: Exponer endpoints para aplicaciones móviles

## Archivos Principales Modificados/Creados

### Modelos
- `app/Models/Facultad.php` - Relaciones y accessors
- `app/Models/Carrera.php` - Primary key string y relaciones

### Controladores
- `app/Http/Controllers/FacultadController.php` - CRUD simplificado
- `app/Http/Controllers/CarreraController.php` - Con pre-selección de facultad

### Migraciones
- `database/migrations/2025_07_31_161649_create_facultades_table.php`
- `database/migrations/2025_07_31_161709_create_carreras_table.php`

### Seeders
- `database/seeders/FacultadSeeder.php` - 7 facultades UATF
- `database/seeders/CarreraSeeder.php` - 26 carreras con códigos únicos
- `database/seeders/DatabaseSeeder.php` - Configuración de seeders

### Vistas Simplificadas
- `resources/views/facultades/index.blade.php` - Lista sin buscador
- `resources/views/facultades/show.blade.php` - Con botones de acción
- `resources/views/carreras/index.blade.php` - Lista simplificada
- `resources/views/carreras/create.blade.php` - Con pre-selección

### Componentes Corregidos
- `resources/views/components/card.blade.php` - Props opcionales
- `resources/views/components/button.blade.php` - Validación mejorada
- `resources/views/components/form-input.blade.php`
- `resources/views/components/form-select.blade.php`

### Rutas
- `routes/web.php` - Resource routes con parámetros personalizados

---

**Versión:** 2.0  
**Fecha:** Julio 2025  
**Estado:** Completado, simplificado y optimizado  
**Cambios principales:** Eliminación de buscadores, corrección de componentes, funcionalidad contextual
