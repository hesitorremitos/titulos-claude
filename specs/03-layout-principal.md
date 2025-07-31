# 03 - Layout Principal de la Aplicación

## Resumen
Implementación del layout principal del sistema de digitalización de títulos UATF. El layout incluye una estructura moderna y responsive con navbar, sidebar navegable y área de contenido principal, con soporte completo para modo claro y oscuro.

## Características Implementadas

### 1. Layout Principal
- **Archivo**: `resources/views/layouts/app.blade.php`
- **Estructura**:
  - Navbar superior de ancho completo
  - Sidebar lateral colapsible
  - Área de contenido principal
  - Sistema de alertas integrado
  - Soporte para headers personalizados por página
- **Características**:
  - Responsive design completo
  - Overlay para menú móvil
  - Soporte para modo claro/oscuro
  - Integración con sistema de autenticación
  - Stack de scripts personalizable

### 2. Navbar Superior
- **Archivo**: `resources/views/layouts/partials/navbar.blade.php`
- **Posicionamiento**: El título comienza desde el inicio del navbar (alineado arriba del aside)
- **Estructura**: Navbar de ancho completo con max-width centrado
- **Elementos**:
  - Logo y título "Departamento de Títulos UATF"
  - Toggle para modo oscuro/claro
  - Información del usuario autenticado
  - Botón de cerrar sesión
  - Botón de menú móvil (responsive)
- **Iconos implementados**:
  - `mdi--certificate`: Logo del departamento
  - `mdi--white-balance-sunny` / `mdi--moon-waning-crescent`: Toggle tema
  - `mdi--account-circle`: Usuario
  - `mdi--logout`: Cerrar sesión
  - `mdi--menu`: Menú móvil

### 3. Sidebar de Navegación
- **Archivo**: `resources/views/layouts/partials/sidebar.blade.php`
- **Secciones simplificadas**:

#### **Dashboard**
- Panel principal del sistema

#### **Catálogos**
- Facultades: Gestión de facultades UATF
- Carreras: Administración de carreras académicas
## Estructura Visual

### Layout Container
- **Sin márgenes**: Layout ocupa todo el ancho de pantalla
- **Estructura clean**: Sin contenedores adicionales con sombras
- **Diseño simple**: Enfoque en funcionalidad

### Alineación Navbar-Sidebar
- **Navbar de ancho completo**: Ocupa toda la pantalla
- **Título desde inicio**: Comienza desde el borde izquierdo (arriba del aside)
- **Max-width centrado**: Contenido centrado con `max-w-7xl mx-auto`
- **Responsive**: En móvil mantiene la estructura pero con menú hamburguesa

### Navegación Simplificada
- **Dashboard**: Panel principal del sistema
- **Facultades**: Gestión de facultades UATF  
- **Carreras**: Administración de carreras académicas
- **Sin elementos innecesarios**: Solo funcionalidades core

## Componentes Reutilizables

### 1. Sidebar Link Component
- **Archivo**: `resources/views/components/sidebar-link.blade.php`
- **Props**: `href`, `icon`, `active`, `mobile`
- **Funcionalidad**: Renderiza enlaces del sidebar con estados activos
- **Beneficios**: Código consistente y mantenible

### 2. Sidebar Section Component  
- **Archivo**: `resources/views/components/sidebar-section.blade.php`
- **Props**: `title`
- **Funcionalidad**: Agrupa enlaces en secciones con títulos
- **Beneficios**: Estructura organizada y reutilizable

### 3. Stat Card Component
- **Archivo**: `resources/views/components/stat-card.blade.php`
- **Props**: `icon`, `iconColor`, `title`, `value`, `href`
- **Funcionalidad**: Tarjetas de estadísticas en el dashboard
- **Beneficios**: Consistencia visual y fácil personalización

### 4. Quick Action Component
- **Archivo**: `resources/views/components/quick-action.blade.php`
- **Props**: `href`, `icon`, `iconColor`, `title`, `description`
- **Funcionalidad**: Botones de acciones rápidas
- **Beneficios**: Interacción uniforme y escalable

## Iconografía del Sistema (Simplificada)

### Navegación Principal
- `mdi--view-dashboard`: Dashboard principal
- `mdi--certificate`: Logo del departamento
- `mdi--account-circle`: Usuario
- `mdi--logout`: Cerrar sesión

### Catálogos
- `mdi--school`: Facultades
- `mdi--book-education`: Carreras

### Alertas y Estados
- `mdi--check-circle`: Éxito
- `mdi--alert-circle`: Error
- `mdi--alert`: Advertencia
- `mdi--information`: Información

### Interfaz
- `mdi--white-balance-sunny`: Modo claro
- `mdi--moon-waning-crescent`: Modo oscuro
- `mdi--menu`: Menú móvil
- `mdi--close`: Cerrar

### Dashboard
- `mdi--calendar-month`: Estadísticas temporales

## Responsive Design

### Breakpoints
- **Mobile**: < 768px
  - Sidebar colapsado en overlay
  - Navbar compacto sin espaciado
  - Grid adaptativo
- **Tablet**: 768px - 1024px
  - Sidebar visible
  - Navegación completa
- **Desktop**: > 1024px
  - Layout completo
  - Sidebar fijo
  - Máximo aprovechamiento del espacio

### Funcionalidades Móviles
- Menú hamburguesa
- Sidebar overlay con backdrop
- Navegación táctil optimizada
- Botones de tamaño adecuado para touch

## Modo Oscuro

### Implementación
- Clases Tailwind CSS dark mode con variant personalizado
- Configuración específica para Tailwind CSS v4: `@custom-variant dark (&:where(.dark, .dark *));`
- Persistencia en localStorage
- Control manual independiente del sistema operativo
- Toggle explícito en navbar con feedback visual
- Tema claro como predeterminado

### Configuración Técnica
```css
@custom-variant dark (&:where(.dark, .dark *));
```
Esta configuración es esencial para que el modo oscuro funcione correctamente con Tailwind CSS v4.

### Elementos Adaptados
- Colores de fondo y texto
- Bordes y sombras
- Estados hover y focus
- Iconos y elementos gráficos
- Títulos dinámicos en controles

## Estructura de Archivos Creados/Modificados

```
resources/
├── views/
│   ├── layouts/
│   │   ├── app.blade.php (nuevo)
│   │   └── partials/
│   │       ├── navbar.blade.php (nuevo)
│   │       ├── sidebar.blade.php (nuevo - simplificado)
│   │       └── alert.blade.php (nuevo)
│   ├── components/
│   │   ├── sidebar-link.blade.php (nuevo)
│   │   ├── sidebar-section.blade.php (nuevo)
│   │   ├── stat-card.blade.php (nuevo)
│   │   └── quick-action.blade.php (nuevo)
│   └── dashboard.blade.php (modificado - con componentes)
├── js/
│   └── app.js (modificado)
```

## Consideraciones de UX/UI

### Principios Aplicados
- **Simplicidad**: Navegación enfocada en lo esencial
- **Consistencia**: Iconografía y estilos uniformes con componentes
- **Accesibilidad**: Contrastes adecuados, navegación por teclado
- **Responsividad**: Adaptación a todos los dispositivos
- **Feedback Visual**: Estados hover, active y focus claros
- **Componetización**: Elementos reutilizables y mantenibles

### Navegación Intuitiva
- Menú simplificado enfocado en catálogos
- Estados activos claramente identificables
- Componentes consistentes en toda la aplicación
- Acciones rápidas específicas al contexto

### Performance
- CSS optimizado con Tailwind
- JavaScript mínimo y eficiente
- Iconos vectoriales ligeros
- Componentes reutilizables que reducen redundancia
- Carga condicional de elementos

## Próximos Pasos

1. **Implementar Módulos**: Crear las páginas para cada sección del sidebar
2. **Sistema de Permisos**: Integrar control de acceso granular
3. **Breadcrumbs**: Añadir navegación contextual
4. **Búsqueda Global**: Implementar búsqueda en el navbar
5. **Notificaciones**: Sistema de notificaciones en tiempo real
6. **Favoritos**: Permitir guardar accesos rápidos
7. **Personalización**: Configuración de layout por usuario

## Comandos de Desarrollo

### Compilar assets
```bash
npm run build
```

### Desarrollo con watch
```bash
npm run dev
```

### Verificar rutas
```bash
php artisan route:list
```

## Características Técnicas

- **Framework**: Laravel con Blade templating
- **CSS**: Tailwind CSS v4 con modo oscuro
- **Iconos**: Iconify con Material Design Icons
- **JavaScript**: Vanilla JS para interactividad básica
- **Responsive**: Mobile-first design
- **Accesibilidad**: ARIA labels y navegación por teclado
- **Performance**: CSS y JS optimizados para producción
