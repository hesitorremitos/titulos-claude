# 02 - Sistema de Autenticación

## Resumen
Implementación del sistema de login para el proyecto de digitalización de títulos UATF. El sistema permite la autenticación de usuarios usando su Carnet de Identidad (CI) como identificador único.

## Características Implementadas

### 1. Modelo de Usuario
- **Archivo**: `app/Models/User.php`
- **Campos principales**:
  - `id`: Clave primaria autoincremental (Laravel estándar)
  - `ci`: Carnet de Identidad (único, no clave primaria)
  - `name`: Nombre completo del usuario
  - `email`: Correo electrónico
  - `password`: Contraseña hasheada
- **Integración con Spatie Permissions**: Preparado para roles y permisos

### 2. Migración de Base de Datos
- **Archivo**: `database/migrations/2025_07_31_050132_add_ci_to_users_table.php`
- **Acción**: Añade campo `ci` como string único a la tabla users
- **Reversible**: Incluye método `down()` para rollback

### 3. Configuración de Colores Tailwind
- **Archivo**: `resources/css/app.css`
- **Colores definidos**:
  - **Primary (Rojo)**: Gradaciones del 50 al 900
  - **Secondary (Azul)**: Gradaciones del 50 al 900
- **Soporte para modo oscuro**: Variables CSS configuradas

### 4. Controlador de Autenticación
- **Archivo**: `app/Http/Controllers/AuthController.php`
- **Funcionalidades**:
  - Mostrar formulario de login
  - Validación de campos CI y contraseña
  - Autenticación con CI en lugar de email
  - Opción "Recordar sesión"
  - Redirección a dashboard después del login
  - Cerrar sesión con invalidación de sesión
  - Mensajes de error en español

### 5. Vista de Login
- **Archivo**: `resources/views/auth/login.blade.php`
- **Características**:
  - Diseño responsive con Tailwind CSS v4
  - Soporte completo para modo oscuro
  - Iconos de Iconify integrados con Tailwind
  - Validación de errores del servidor
  - Formulario accesible con etiquetas y autocompletado
  - Mensajes de error estilizados con iconos

### 6. Layout para Invitados
- **Archivo**: `resources/views/layouts/guest.blade.php`
- **Características**:
  - Layout centrado para páginas de autenticación
  - Branding de la UATF
  - Soporte para modo oscuro
  - Responsive design
  - Uso de `@yield('content')` para compatibilidad con Blade

### 7. Rutas de Autenticación
- **Archivo**: `routes/web.php`
- **Rutas implementadas**:
  - `/` → Redirección a login
  - `GET /login` → Formulario de login
  - `POST /login` → Procesamiento de autenticación
  - `/dashboard` → Panel principal (requiere autenticación)
  - `POST /logout` → Cerrar sesión

### 8. Dashboard Básico
- **Archivo**: `resources/views/dashboard.blade.php`
- **Funcionalidades**:
  - Barra de navegación con branding e iconos
  - Saludo personalizado con nombre de usuario e icono
  - Botón de cerrar sesión con icono
  - Iconos de Iconify integrados
  - Diseño preparado para futuras funcionalidades

## Iconos Implementados

El sistema utiliza el plugin de Iconify para Tailwind CSS v4 con los siguientes iconos:

### Iconos de Autenticación
- `icon-[mdi--card-account-details-outline]`: Campo CI
- `icon-[mdi--lock-outline]`: Campo contraseña  
- `icon-[mdi--checkbox-marked-circle-outline]`: Checkbox recordar sesión
- `icon-[mdi--login]`: Botón de inicio de sesión
- `icon-[mdi--alert-circle-outline]`: Mensajes de error

### Iconos del Dashboard
- `icon-[mdi--school]`: Logo del sistema en header
- `icon-[mdi--account-circle]`: Saludo de usuario
- `icon-[mdi--logout]`: Botón cerrar sesión
- `icon-[mdi--view-dashboard]`: Icono central del dashboard

## Usuarios de Prueba

Se crearon usuarios de prueba mediante seeder:

### Usuario Administrador
- **CI**: 12345678
- **Contraseña**: password
- **Nombre**: Administrador

### Usuario Test
- **CI**: 87654321
- **Contraseña**: 123456
- **Nombre**: Usuario Test

**Comando para crear usuarios**: `php artisan db:seed --class=UserSeeder`

## Comandos de Desarrollo

### Migración
```bash
php artisan migrate
```

### Crear usuarios de prueba
```bash
php artisan db:seed --class=UserSeeder
```

### Iniciar desarrollo
```bash
composer run dev
```

## Estructura de Archivos Creados/Modificados

```
app/
├── Http/Controllers/AuthController.php (nuevo)
├── Models/User.php (modificado)
database/
├── migrations/2025_07_31_050132_add_ci_to_users_table.php (nuevo)
├── seeders/UserSeeder.php (nuevo)
resources/
├── css/app.css (modificado)
├── views/
│   ├── layouts/guest.blade.php (modificado)
│   ├── auth/login.blade.php (nuevo)
│   └── dashboard.blade.php (modificado)
routes/
└── web.php (modificado)
```

## Próximos Pasos

1. **Roles y Permisos**: Implementar los roles definidos (Administrador, Jefe, Personal)
2. **Gestión de Usuarios**: CRUD de usuarios con asignación de roles
3. **Módulo de Personas**: Registro y gestión de personas físicas
4. **Catálogos**: Facultades, carreras y tipos de títulos
5. **Registro de Títulos**: Funcionalidad principal del sistema

## Cambios en la Refactorización (v2.0)

### Migración de Livewire a Blade Puro
- **Motivo**: Simplificación del sistema de autenticación al no requerir interactividad compleja
- **Beneficios**:
  - Mejor rendimiento (menos JavaScript)
  - Menor complejidad del código
  - Validación tradicional del lado del servidor
  - Mantenimiento más sencillo

### Integración de Iconos Iconify
- **Plugin**: `@iconify/tailwind4` con `@iconify/json`
- **Implementación**: Clases CSS nativas de Tailwind
- **Conjunto de iconos**: Material Design Icons (mdi)
- **Beneficios**:
  - Iconos vectoriales optimizados
  - Integración nativa con Tailwind CSS
  - Sistema consistente de iconografía
  - Soporte completo para modo oscuro

## Consideraciones Técnicas

- **Seguridad**: Autenticación mediante CI único, passwords hasheados
- **UX**: Formularios responsive con iconos informativos
- **Accesibilidad**: Etiquetas apropiadas, contraste adecuado, iconos con aria-hidden
- **Mantenibilidad**: Separación clara entre controlador, vistas y rutas
- **Escalabilidad**: Base preparada para roles y permisos complejos
- **Performance**: Eliminación de Livewire para casos simples sin interactividad compleja
- **Iconografía**: Sistema consistente de iconos con Iconify y Tailwind CSS