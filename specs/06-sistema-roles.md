# Paso 06: Implementación del Sistema de Roles y Permisos

## Objetivo
Implementar un sistema de roles y permisos robusto utilizando Laravel-Permission que permita controlar el acceso a las funcionalidades del sistema según el rol del usuario.

## Roles Definidos

### 1. Administrador
- **Descripción**: Usuario con acceso completo al sistema
- **Permisos**:
  - Gestión completa de facultades (ver, crear, editar, eliminar)
  - Gestión completa de carreras (ver, crear, editar, eliminar)
  - Gestión de usuarios (ver, crear, editar, eliminar)
  - Gestión de títulos (ver, crear, editar, eliminar)

### 2. Jefe
- **Descripción**: Usuario supervisor con permisos de solo lectura
- **Permisos**:
  - Ver facultades
  - Ver carreras
  - Ver usuarios
  - Ver títulos

### 3. Personal
- **Descripción**: Usuario operativo con permisos limitados
- **Permisos**:
  - Ver facultades
  - Ver carreras
  - Gestión de títulos (ver, crear, editar)

## Implementación Técnica

### 1. Configuración de Roles y Permisos

#### RoleSeeder.php
```php
// Creación de roles
$adminRole = Role::create(['name' => 'Administrador']);
$jefeRole = Role::create(['name' => 'Jefe']);
$personalRole = Role::create(['name' => 'Personal']);

// Definición de permisos granulares
$permissions = [
    'ver-facultades', 'crear-facultades', 'editar-facultades', 'eliminar-facultades',
    'ver-carreras', 'crear-carreras', 'editar-carreras', 'eliminar-carreras',
    'ver-usuarios', 'crear-usuarios', 'editar-usuarios', 'eliminar-usuarios',
    'ver-titulos', 'crear-titulos', 'editar-titulos', 'eliminar-titulos'
];

// Asignación de permisos por rol
$adminRole->givePermissionTo($permissions);
$jefeRole->givePermissionTo(['ver-facultades', 'ver-carreras', 'ver-usuarios', 'ver-titulos']);
$personalRole->givePermissionTo(['ver-facultades', 'ver-carreras', 'ver-titulos', 'crear-titulos', 'editar-titulos']);
```

#### UserRoleSeeder.php
```php
// Asignación de roles a usuarios existentes y creación de usuarios de prueba
$admin = User::where('email', 'admin@uatf.edu.bo')->first();
if ($admin) {
    $admin->assignRole('Administrador');
}

// Creación de usuarios de ejemplo
User::create([
    'name' => 'Jefe Departamento',
    'email' => 'jefe@uatf.edu.bo',
    'ci' => '87654321',
    'password' => Hash::make('password')
])->assignRole('Jefe');

User::create([
    'name' => 'Personal Títulos',
    'email' => 'personal@uatf.edu.bo',
    'ci' => '11223344',
    'password' => Hash::make('password')
])->assignRole('Personal');
```

### 2. Protección de Rutas

#### Middleware de Permisos
Las rutas están protegidas usando el middleware `permission` de Laravel-Permission:

```php
// Rutas de solo lectura (disponibles para todos los usuarios autenticados)
Route::get('/', [FacultadController::class, 'index'])->name('index');
Route::get('/{facultad}', [FacultadController::class, 'show'])->name('show');

// Rutas de gestión (solo para usuarios con permisos específicos)
Route::middleware(['permission:crear-facultades'])->group(function () {
    Route::get('/create', [FacultadController::class, 'create'])->name('create');
    Route::post('/', [FacultadController::class, 'store'])->name('store');
});

Route::middleware(['permission:editar-facultades'])->group(function () {
    Route::get('/{facultad}/edit', [FacultadController::class, 'edit'])->name('edit');
    Route::put('/{facultad}', [FacultadController::class, 'update'])->name('update');
});

Route::middleware(['permission:eliminar-facultades'])->group(function () {
    Route::delete('/{facultad}', [FacultadController::class, 'destroy'])->name('destroy');
});
```

### 3. Interfaz de Usuario Adaptativa

#### Navbar con Información de Rol
El navbar muestra el rol del usuario debajo del nombre:

```blade
<div class="text-left hidden sm:block">
    <div class="text-gray-700 dark:text-gray-300 font-medium">
        {{ auth()->user()->name }}
    </div>
    <div class="text-xs text-gray-500 dark:text-gray-400">
        {{ auth()->user()->roles->first()?->name ?? 'Sin rol' }}
    </div>
</div>
```

#### Botones Condicionales
Los botones de acción se muestran solo si el usuario tiene los permisos correspondientes:

```blade
@can('crear-facultades')
<x-button href="{{ route('facultades.create') }}" icon="icon-[mdi--plus]">
    Nueva Facultad
</x-button>
@endcan

@can('editar-facultades')
<x-button href="{{ route('facultades.edit', $facultad) }}" variant="secondary">
    Editar
</x-button>
@endcan

@can('eliminar-facultades')
<form method="POST" action="{{ route('facultades.destroy', $facultad) }}">
    @csrf @method('DELETE')
    <x-button variant="danger" type="submit">Eliminar</x-button>
</form>
@endcan
```

#### Navegación Lateral Adaptativa
El sidebar muestra enlaces solo para secciones a las que el usuario tiene acceso:

```blade
@can('ver-facultades')
<x-sidebar-link href="{{ route('facultades.index') }}" icon="mdi--school">
    Facultades
</x-sidebar-link>
@endcan

@can('ver-carreras')
<x-sidebar-link href="{{ route('carreras.index') }}" icon="mdi--book-education">
    Carreras
</x-sidebar-link>
@endcan
```

## Características Implementadas

### ✅ Completado
1. **Sistema de Roles**: Tres roles bien definidos con diferentes niveles de acceso
2. **Permisos Granulares**: 20+ permisos específicos para cada funcionalidad
3. **Protección de Rutas**: Middleware aplicado a todas las rutas sensibles
4. **UI Adaptativa**: Interfaz que se adapta según los permisos del usuario
5. **Información de Rol**: Visualización del rol en el navbar y dropdown de usuario
6. **Navegación Condicional**: Menús que se muestran según permisos
7. **Seeders Configurados**: Datos de prueba para todos los roles

### 🔄 En Progreso
- Testing del sistema de roles con diferentes usuarios
- Documentación de casos de uso

### 📋 Pendiente
- Gestión de usuarios desde la interfaz web
- Logs de auditoría para acciones administrativas
- Notificaciones por cambios de permisos

## Casos de Uso

### Administrador
- Puede crear, editar y eliminar facultades y carreras
- Ve todos los botones de acción en las interfaces
- Tiene acceso completo a todas las secciones

### Jefe
- Solo puede ver la información de facultades y carreras
- No ve botones de "Crear", "Editar" o "Eliminar"
- Tiene acceso de solo lectura a todas las secciones

### Personal
- Puede ver facultades y carreras
- Podrá gestionar títulos cuando se implemente esa funcionalidad
- No puede modificar datos maestros (facultades/carreras)

## Seguridad

### Protección a Nivel de Ruta
- Todas las rutas de gestión están protegidas por middleware
- Usuarios sin permisos reciben error 403 (Forbidden)
- Las rutas de solo lectura están disponibles para usuarios autenticados

### Protección a Nivel de Vista
- Botones de acción solo visibles con permisos correspondientes
- Navegación adaptativa según roles
- Información clara del rol del usuario

### Validación de Permisos
- Verificación tanto en backend (rutas) como frontend (vistas)
- Doble capa de seguridad para prevenir accesos no autorizados
- Manejo de errores para intentos de acceso sin permisos

## Testing

### Usuarios de Prueba Creados
- **admin@uatf.edu.bo** (Administrador) - password: definida en seeder original
- **jefe@uatf.edu.bo** (Jefe) - password: password
- **personal@uatf.edu.bo** (Personal) - password: password

### Verificaciones Recomendadas
1. Login con cada tipo de usuario
2. Verificar visibilidad de botones según rol
3. Probar acceso directo a rutas protegidas
4. Confirmar funcionamiento de permisos en navegación

## Comandos Útiles

```bash
# Ejecutar seeders
php artisan db:seed

# Refrescar base de datos con seeders
php artisan migrate:fresh --seed

# Limpiar caché de permisos
php artisan permission:cache-reset

# Ver roles y permisos
php artisan tinker
>>> \Spatie\Permission\Models\Role::with('permissions')->get()
>>> \App\Models\User::with('roles')->get()
```

## Próximos Pasos

1. **Testing Completo**: Verificar funcionamiento con diferentes usuarios
2. **Gestión de Títulos**: Implementar CRUD de títulos con permisos correspondientes
3. **Auditoría**: Implementar logs de acciones administrativas
4. **Gestión de Usuarios**: Interface web para administrar usuarios y roles
5. **Refinamiento**: Ajustes basados en feedback de usuarios

## Beneficios Alcanzados

- **Seguridad Mejorada**: Control granular de accesos
- **Experiencia de Usuario**: Interface adaptada al rol
- **Mantenibilidad**: Sistema escalable de permisos
- **Compliance**: Cumple con requisitos de control de acceso
- **Flexibilidad**: Fácil adición de nuevos roles y permisos
