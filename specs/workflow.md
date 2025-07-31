# Workflow de Desarrollo - Sistema de Digitalización de Títulos UATF

## Modalidad de Trabajo

Este documento establece la metodología de desarrollo para el Sistema de Digitalización de Títulos de la Universidad Autónoma Tomás Frías (UATF).

---

## 1. Estructura de Trabajo

### Fase Preparatoria
1. **Lectura de Requerimientos Mínimos**
   - Revisar `specs/requerimientos.md` para entender el alcance completo del proyecto
   - Identificar funcionalidades críticas y reglas de negocio
   - Comprender la arquitectura técnica y restricciones

2. **Análisis de Pasos Realizados**
   - Examinar archivos numerados en `specs/` (01-, 02-, etc.)
   - Identificar funcionalidades ya implementadas
   - Evaluar el estado actual del desarrollo

### Fase de Desarrollo
3. **Ejecución de Tareas del Usuario**
   - Implementar las solicitudes específicas del usuario
   - Mantener coherencia con la arquitectura existente
   - Seguir las convenciones establecidas en el proyecto

4. **Consulta a Agentes Especializados**
   - Utilizar el **Los agentes del proyecto** para:
     - Decisiones de arquitectura Laravel
     - Implementación de mejores prácticas
     - Optimización de código
     - Resolución de problemas técnicos

5. **Documentación de Progreso**
   - Crear un nuevo archivo numerado en `specs/` (03-, 04-, etc.)
   - Documentar todo lo implementado en el paso actual
   - Incluir archivos creados/modificados
   - Registrar comandos ejecutados y configuraciones

---

## 2. Estado Actual del Proyecto

### Pasos Completados

#### **01-preparacion.md** ✅
- Configuración inicial del proyecto Laravel 12
- Instalación de dependencias (Tailwind CSS v4, Livewire, Spatie Permissions)
- Configuración de base de datos SQLite
- Estructura básica del proyecto

#### **02-autenticacion.md** ✅
- Sistema de login con CI (Carnet de Identidad)
- Modelo de Usuario extendido
- Componente Livewire de autenticación
- Dashboard básico con navegación
- Usuarios de prueba creados
- Layout para invitados

### Arquitectura Establecida
- **Backend:** Laravel 12 con PHP 8.2+
- **Frontend:** Blade + Livewire v3 + Tailwind CSS v4 + Alpine.js
- **Base de Datos:** SQLite (desarrollo)
- **Testing:** Pest PHP
- **Roles:** Spatie Laravel Permission

---

## 3. Próximos Pasos Identificados

### Funcionalidades Pendientes (según requerimientos)
1. **Sistema de Roles y Permisos**
   - Implementar roles: Administrador, Jefe, Personal
   - Configurar permisos específicos por rol
   - Middleware de autorización

2. **Gestión de Personas**
   - CRUD de personas (tabla `personas`)
   - Integración con API universitaria para auto-llenado
   - Validación de CI boliviano

3. **Catálogos del Sistema**
   - Gestión de facultades y carreras
   - Tipos de títulos configurables
   - Menciones y modalidades de graduación

4. **Registro de Títulos**
   - CRUD de títulos según tipo
   - Subida y gestión de PDFs
   - Visualizador de documentos integrado

5. **Sistema de Búsqueda**
   - Búsqueda por múltiples criterios
   - Filtros avanzados
   - Interface de resultados

6. **Módulo de Estadísticas**
   - Dashboard de métricas
   - Reportes por facultad/carrera
   - Análisis de productividad

---

## 4. Metodología de Implementación

### Para Cada Nueva Funcionalidad:

1. **Análisis**
   - Revisar requerimientos específicos en `specs/requerimientos.md`
   - Identificar reglas de negocio aplicables
   - Evaluar dependencias con funcionalidades existentes

2. **Diseño**
   - Consultar con Laravel 12 Expert Agent para arquitectura
   - Definir estructura de base de datos si es necesario
   - Planificar componentes Livewire requeridos

3. **Implementación**
   - Crear migraciones de base de datos
   - Desarrollar modelos con relaciones Eloquent
   - Implementar componentes Livewire
   - Crear vistas con Tailwind CSS
   - Añadir rutas y middleware

4. **Documentación**
   - Crear archivo `0X-[nombre-funcionalidad].md` en `specs/`
   - Documentar archivos creados/modificados
   - Incluir comandos de configuración
   - Registrar usuarios/datos de prueba si aplica

---

## 5. Comandos de Desarrollo Estándar

```bash
# Desarrollo
composer run dev          # Inicia servidor, queue y vite concurrentemente

# Base de datos
php artisan migrate       # Ejecutar migraciones
php artisan db:seed      # Ejecutar seeders

# Testing y calidad
composer run test        # Suite completa de pruebas
./vendor/bin/pint       # Corrección de estilo de código

# Assets
npm run build           # Build de producción
npm run dev            # Desarrollo de assets
```

---

## 6. Convenciones del Proyecto

### Estructura de Archivos
- **Modelos:** `app/Models/`
- **Controladores:** `app/Http/Controllers/`
- **Livewire:** `app/Livewire/`
- **Vistas:** `resources/views/`
- **Migraciones:** `database/migrations/`
- **Seeders:** `database/seeders/`

### Estándares de Código
- **PSR-12** para PHP (aplicado automáticamente con Pint)
- **Tailwind CSS v4** para estilos
- **Alpine.js** para interactividad menor
- **Livewire v3** para componentes reactivos

### Base de Datos
- **CI como clave primaria** para personas
- **IDs autoincrement** para otras entidades
- **Campos de auditoría** (created_by, updated_by) en títulos
- **Foreign keys** con constraints apropiadas

---

## 7. Recursos y Referencias

- **Documentación Laravel 12:** https://laravel.com/docs/12.x
- **Livewire v3:** https://livewire.laravel.com/docs/quickstart
- **Tailwind CSS v4:** https://tailwindcss.com/docs
- **Spatie Permissions:** https://spatie.be/docs/laravel-permission
- **API Universitaria:** `https://apititulos.uatf.edu.bo/api/datos?ru={ci}`

---

*Este workflow debe ser seguido consistentemente para mantener la calidad y coherencia del desarrollo del sistema.*