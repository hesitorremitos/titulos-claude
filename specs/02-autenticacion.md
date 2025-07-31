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

### 4. Componente Livewire de Login
- **Archivo**: `app/Livewire/Auth/Login.php`
- **Funcionalidades**:
  - Validación de campos CI y contraseña
  - Autenticación con CI en lugar de email
  - Opción "Recordar sesión"
  - Redirección a dashboard después del login
  - Mensajes de error en español

### 5. Vista de Login
- **Archivo**: `resources/views/livewire/auth/login.blade.php`
- **Características**:
  - Diseño responsive con Tailwind CSS v4
  - Soporte completo para modo oscuro
  - Indicadores de carga
  - Validación en tiempo real
  - Mensajes de error estilizados
  - Formulario accesible con etiquetas y autocompletado

### 6. Layout para Invitados
- **Archivo**: `resources/views/layouts/guest.blade.php`
- **Características**:
  - Layout centrado para páginas de autenticación
  - Branding de la UATF
  - Soporte para modo oscuro
  - Responsive design

### 7. Rutas de Autenticación
- **Archivo**: `routes/web.php`
- **Rutas implementadas**:
  - `/` → Redirección a login
  - `/login` → Formulario de login
  - `/dashboard` → Panel principal (requiere autenticación)
  - `/logout` → Cerrar sesión

### 8. Dashboard Básico
- **Archivo**: `resources/views/dashboard.blade.php`
- **Funcionalidades**:
  - Barra de navegación con branding
  - Saludo personalizado con nombre de usuario
  - Botón de cerrar sesión
  - Diseño preparado para futuras funcionalidades

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
├── Livewire/Auth/Login.php (nuevo)
├── Models/User.php (modificado)
database/
├── migrations/2025_07_31_050132_add_ci_to_users_table.php (nuevo)
├── seeders/UserSeeder.php (nuevo)
resources/
├── css/app.css (modificado)
├── views/
│   ├── layouts/guest.blade.php (nuevo)
│   ├── livewire/auth/login.blade.php (nuevo)
│   └── dashboard.blade.php (nuevo)
routes/
└── web.php (modificado)
```

## Próximos Pasos

1. **Roles y Permisos**: Implementar los roles definidos (Administrador, Jefe, Personal)
2. **Gestión de Usuarios**: CRUD de usuarios con asignación de roles
3. **Módulo de Personas**: Registro y gestión de personas físicas
4. **Catálogos**: Facultades, carreras y tipos de títulos
5. **Registro de Títulos**: Funcionalidad principal del sistema

## Consideraciones Técnicas

- **Seguridad**: Autenticación mediante CI único, passwords hasheados
- **UX**: Formularios responsive con indicadores de carga
- **Accesibilidad**: Etiquetas apropiadas, contraste adecuado
- **Mantenibilidad**: Separación clara de responsabilidades entre Livewire y vistas
- **Escalabilidad**: Base preparada para roles y permisos complejos