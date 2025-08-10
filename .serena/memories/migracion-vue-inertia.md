# Migración a Vue + Inertia.js

## Contexto de la Migración

Estamos migrando gradualmente el proyecto de **Blade + Livewire** hacia **Vue 3 + Inertia.js** debido a las siguientes razones principales:

### Razones de la Migración
1. **Alta Interactividad en Formularios**: Los formularios complejos (especialmente el de registro de diplomas académicos) requieren mucha interactividad en tiempo real, drag & drop de PDFs, validaciones dinámicas, y múltiples pasos.

2. **Dificultad de Mantenimiento con Livewire**: El mantenimiento del código con solo Livewire + Alpine.js se ha vuelto complejo, especialmente en:
   - Manejo de estados complejos
   - Comunicación entre componentes
   - Reactividad avanzada
   - Integración con librerías externas

3. **Mejor Experiencia de Usuario**: Vue 3 + Inertia nos permite crear interfaces más fluidas y responsivas.

## Arquitectura de Migración

### Stack Tecnológico
- **Backend**: Laravel 12 (mantenido)
- **Frontend**: Vue 3 + Composition API + TypeScript
- **Routing**: Inertia.js (SPA híbrida)
- **UI Components**: Shadcn/vue
- **Build Tool**: Vite
- **Estado**: Composables de Vue 3

### Componentes Migrados - Dashboard (2025-08-10)

#### 1. Estructura de Archivos Creados
```
app/Http/Controllers/DashboardController.php
routes/web-vue.php (rutas v2)
resources/js/components/AppSidebar.vue
resources/js/Layouts/AppLayout.vue (actualizado)
resources/js/Pages/Dashboard.vue (actualizado)
```

#### 2. Componentes Shadcn/vue Instalados
- **Sidebar**: Completo sistema de navegación con `SidebarProvider`, `SidebarContent`, `SidebarMenu`, etc.
- **Breadcrumb**: Navegación contextual
- **Card**: Para estadísticas y acciones rápidas
- **Avatar**: Perfil de usuario
- **Switch**: Toggle de tema dark/light
- **DropdownMenu**: Menú de usuario
- **Button**: Sistema de botones unificado

#### 3. Funcionalidades Implementadas
- **Sidebar Collapsible**: Usando componentes nativos de Shadcn/vue (sin Alpine.js)
- **Theme Toggle**: Persistencia en localStorage con Switch component
- **Dashboard Stats**: Cards con estadísticas reales desde la base de datos
- **Breadcrumb Navigation**: Navegación contextual integrada
- **User Profile Menu**: Dropdown con opciones de usuario
- **Responsive Layout**: Adaptación automática a dispositivos móviles

#### 4. Mejoras de UX Implementadas
- **Sin Alpine.js**: Toda la interactividad manejada por Vue 3
- **Persistencia de Estado**: El sidebar recuerda su estado colapsado
- **Transiciones Suaves**: Animaciones nativas de los componentes
- **Accesibilidad**: Focus management y ARIA labels incluidos
- **Theme Detection**: Detección automática de preferencias del sistema

### Patrón de Rutas
- **Rutas Legacy**: `/` (Blade + Livewire) - Mantenidas
- **Rutas V2**: `/v2/*` (Vue + Inertia) - Nuevas

### Convivencia de Sistemas
- Ambos sistemas coexisten durante la migración gradual
- Layouts separados para evitar conflictos
- Assets independientes gestionados por Vite

## Próximos Pasos de Migración
1. Formulario de Diplomas Académicos (alta prioridad por complejidad)
2. Páginas de listados con filtros avanzados
3. Formularios de catálogos maestros
4. Sistema de autenticación completo

## Beneficios Observados
- **Código más limpio y mantenible**
- **Mejor rendimiento en interacciones**
- **Desarrollo más ágil con componentes reutilizables**
- **TypeScript opcional para mayor robustez**
- **Mejor experiencia del desarrollador**