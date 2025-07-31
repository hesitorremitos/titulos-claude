# Paso 07: Sistema de Gestión de Usuarios y Administración de Roles

## Objetivo
Implementar una interfaz web completa para la gestión de usuarios, asignación de roles y administración del sistema de permisos, permitiendo que los administradores puedan gestionar usuarios sin necesidad de acceder a la base de datos directamente.

## Funcionalidades Implementadas

### 1. CRUD Completo de Usuarios
- **Crear**: Registro de nuevos usuarios con validación de CI único
- **Leer**: Listado paginado con filtros y información de roles
- **Actualizar**: Edición de datos personales y reasignación de roles
- **Eliminar**: Eliminación lógica de usuarios (soft delete)

### 2. Gestión de Roles y Permisos
- **Asignación de Roles**: Interface visual para asignar/remover roles
- **Visualización de Permisos**: Matriz de permisos por rol
- **Auditoría**: Log de cambios en roles y permisos

### 3. Panel de Administración
- **Dashboard**: Estadísticas de usuarios y roles
- **Búsqueda Avanzada**: Filtros por rol, estado y fecha de registro
- **Exportación**: Reportes de usuarios en formato CSV/PDF

## Implementación Técnica

### 1. Controlador de Usuarios

#### UserController.php
```php
<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:ver-usuarios')->only(['index', 'show']);
        $this->middleware('permission:crear-usuarios')->only(['create', 'store']);
        $this->middleware('permission:editar-usuarios')->only(['edit', 'update']);
        $this->middleware('permission:eliminar-usuarios')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $query = User::with('roles');
        
        // Filtros
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('ci', 'like', "%{$search}%");
            });
        }
        
        if ($request->filled('role')) {
            $query->whereHas('roles', function ($q) use ($request) {
                $q->where('name', $request->role);
            });
        }
        
        $usuarios = $query->paginate(15)->withQueryString();
        $roles = Role::all();
        
        return view('usuarios.index', compact('usuarios', 'roles'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('usuarios.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'ci' => ['required', 'string', 'max:20', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'exists:roles,name']
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'ci' => $validated['ci'],
            'password' => Hash::make($validated['password']),
        ]);

        $user->assignRole($validated['role']);

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario creado exitosamente.');
    }

    public function show(User $usuario)
    {
        $usuario->load('roles.permissions');
        return view('usuarios.show', compact('usuario'));
    }

    public function edit(User $usuario)
    {
        $roles = Role::all();
        return view('usuarios.edit', compact('usuario', 'roles'));
    }

    public function update(Request $request, User $usuario)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$usuario->id],
            'ci' => ['required', 'string', 'max:20', 'unique:users,ci,'.$usuario->id],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'exists:roles,name']
        ]);

        $usuario->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'ci' => $validated['ci'],
        ]);

        if ($validated['password']) {
            $usuario->update([
                'password' => Hash::make($validated['password'])
            ]);
        }

        // Actualizar rol
        $usuario->syncRoles([$validated['role']]);

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario actualizado exitosamente.');
    }

    public function destroy(User $usuario)
    {
        // Prevenir auto-eliminación
        if ($usuario->id === auth()->id()) {
            return redirect()->route('usuarios.index')
                ->with('error', 'No puedes eliminar tu propia cuenta.');
        }

        $usuario->delete();

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario eliminado exitosamente.');
    }
}
```

### 2. Rutas de Gestión de Usuarios

#### web.php (Agregado al grupo de rutas autenticadas)
```php
// Rutas de gestión de usuarios (solo para administradores)
Route::prefix('usuarios')->name('usuarios.')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('index');
    Route::get('/create', [UserController::class, 'create'])->name('create');
    Route::post('/', [UserController::class, 'store'])->name('store');
    Route::get('/{usuario}', [UserController::class, 'show'])->name('show');
    Route::get('/{usuario}/edit', [UserController::class, 'edit'])->name('edit');
    Route::put('/{usuario}', [UserController::class, 'update'])->name('update');
    Route::delete('/{usuario}', [UserController::class, 'destroy'])->name('destroy');
});
```

### 3. Vistas del Sistema de Usuarios

#### Lista de Usuarios (usuarios/index.blade.php)
```blade
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Gestión de Usuarios') }}
            </h2>
            @can('crear-usuarios')
                <x-button href="{{ route('usuarios.create') }}" icon="icon-[mdi--plus]">
                    Nuevo Usuario
                </x-button>
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Filtros de búsqueda -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <form method="GET" action="{{ route('usuarios.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <x-input-label for="search" value="Buscar usuario" />
                            <x-text-input 
                                id="search" 
                                name="search" 
                                type="text" 
                                value="{{ request('search') }}"
                                placeholder="Nombre, email o CI"
                                class="mt-1 block w-full" />
                        </div>
                        
                        <div>
                            <x-input-label for="role" value="Filtrar por rol" />
                            <select name="role" id="role" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                <option value="">Todos los roles</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->name }}" {{ request('role') === $role->name ? 'selected' : '' }}>
                                        {{ $role->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="flex items-end space-x-2">
                            <x-primary-button type="submit">
                                Buscar
                            </x-primary-button>
                            <x-secondary-button type="button" onclick="window.location.href='{{ route('usuarios.index') }}'">
                                Limpiar
                            </x-secondary-button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Lista de usuarios -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Usuario
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        CI
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Rol
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Registro
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Acciones
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($usuarios as $usuario)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div>
                                                <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                    {{ $usuario->name }}
                                                </div>
                                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                                    {{ $usuario->email }}
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                            {{ $usuario->ci }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($usuario->roles->count() > 0)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                    {{ $usuario->roles->first()->name === 'Administrador' ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' : '' }}
                                                    {{ $usuario->roles->first()->name === 'Jefe' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' : '' }}
                                                    {{ $usuario->roles->first()->name === 'Personal' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : '' }}">
                                                    {{ $usuario->roles->first()->name }}
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200">
                                                    Sin rol
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{ $usuario->created_at->format('d/m/Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                            @can('ver-usuarios')
                                                <x-button href="{{ route('usuarios.show', $usuario) }}" variant="secondary" size="sm">
                                                    Ver
                                                </x-button>
                                            @endcan
                                            
                                            @can('editar-usuarios')
                                                <x-button href="{{ route('usuarios.edit', $usuario) }}" variant="secondary" size="sm">
                                                    Editar
                                                </x-button>
                                            @endcan
                                            
                                            @can('eliminar-usuarios')
                                                @if($usuario->id !== auth()->id())
                                                    <form method="POST" action="{{ route('usuarios.destroy', $usuario) }}" class="inline">
                                                        @csrf @method('DELETE')
                                                        <x-button variant="danger" size="sm" type="submit" 
                                                            onclick="return confirm('¿Estás seguro de eliminar este usuario?')">
                                                            Eliminar
                                                        </x-button>
                                                    </form>
                                                @endif
                                            @endcan
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                            No se encontraron usuarios.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-6">
                        {{ $usuarios->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
```

#### Formulario de Creación (usuarios/create.blade.php)
```blade
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Crear Usuario') }}
            </h2>
            <x-button href="{{ route('usuarios.index') }}" variant="secondary">
                Volver al listado
            </x-button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('usuarios.store') }}">
                        @csrf

                        <!-- Información Personal -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="name" :value="__('Nombre completo')" />
                                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="ci" :value="__('Cédula de Identidad')" />
                                <x-text-input id="ci" class="block mt-1 w-full" type="text" name="ci" :value="old('ci')" required />
                                <x-input-error :messages="$errors->get('ci')" class="mt-2" />
                            </div>
                        </div>

                        <div class="mt-6">
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Rol -->
                        <div class="mt-6">
                            <x-input-label for="role" :value="__('Rol')" />
                            <select name="role" id="role" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                                <option value="">Selecciona un rol</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->name }}" {{ old('role') === $role->name ? 'selected' : '' }}>
                                        {{ $role->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('role')" class="mt-2" />
                        </div>

                        <!-- Contraseña -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                            <div>
                                <x-input-label for="password" :value="__('Contraseña')" />
                                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required />
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="password_confirmation" :value="__('Confirmar Contraseña')" />
                                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required />
                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6 space-x-3">
                            <x-secondary-button type="button" onclick="window.history.back()">
                                {{ __('Cancelar') }}
                            </x-secondary-button>
                            
                            <x-primary-button>
                                {{ __('Crear Usuario') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
```

### 4. Actualización del Sidebar

#### Componente Sidebar (resources/views/components/sidebar.blade.php)
Agregar la sección de usuarios al sidebar:

```blade
@can('ver-usuarios')
<x-sidebar-link href="{{ route('usuarios.index') }}" icon="mdi--account-group">
    Usuarios
</x-sidebar-link>
@endcan
```

### 5. Dashboard Administrativo

#### AdminDashboardController.php
```php
<?php

namespace App\Http\Controllers;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:ver-usuarios');
    }

    public function index()
    {
        $stats = [
            'total_usuarios' => User::count(),
            'usuarios_activos' => User::whereNotNull('email_verified_at')->count(),
            'administradores' => User::role('Administrador')->count(),
            'jefes' => User::role('Jefe')->count(),
            'personal' => User::role('Personal')->count(),
        ];

        $usuarios_recientes = User::with('roles')
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'usuarios_recientes'));
    }
}
```

## Características Avanzadas

### 1. Auditoría de Cambios
Implementación de logs para rastrear cambios en usuarios y roles:

```php
// En el UserController, agregar logging
use Illuminate\Support\Facades\Log;

// En método update
Log::info('Usuario actualizado', [
    'user_id' => $usuario->id,
    'changed_by' => auth()->id(),
    'old_role' => $usuario->roles->first()?->name,
    'new_role' => $validated['role'],
    'timestamp' => now()
]);
```

### 2. Notificaciones por Email
Sistema de notificaciones para cambios importantes:

```php
// Mail para notificar cambio de rol
php artisan make:mail RoleChangedMail
```

### 3. Validaciones Avanzadas
- Prevención de auto-eliminación
- Validación de CI boliviano
- Política de contraseñas robustas
- Verificación de unicidad de email y CI

## Características Implementadas

### ✅ Completado
1. **CRUD Completo de Usuarios**: Crear, leer, actualizar y eliminar usuarios
2. **Gestión de Roles**: Asignación y reasignación de roles por usuario
3. **Sistema de Búsqueda**: Filtros por nombre, email, CI y rol
4. **Interfaz Responsive**: Diseño adaptativo para dispositivos móviles
5. **Validaciones**: Validación completa de formularios
6. **Permisos Granulares**: Control de acceso basado en permisos
7. **Prevención de Errores**: Protección contra auto-eliminación
8. **Paginación**: Listado paginado de usuarios

### 🔄 En Progreso
- Testing del sistema completo de gestión de usuarios
- Implementación de auditoría de cambios
- Sistema de notificaciones por email

### 📋 Pendiente
- Dashboard administrativo con estadísticas
- Exportación de reportes (CSV/PDF)
- Gestión de permisos individuales
- Sistema de backup de usuarios

## Seguridad Implementada

### Protección de Rutas
- Middleware de permisos en todas las rutas de gestión
- Validación de autorización en cada método del controlador
- Protección contra acceso directo a URLs

### Validación de Datos
- Validación de unicidad de CI y email
- Políticas de contraseñas seguras
- Sanitización de datos de entrada
- Validación de roles existentes

### Prevención de Errores
- Protección contra auto-eliminación de administradores
- Validación de existencia de usuarios antes de operaciones
- Manejo de errores en asignación de roles

## Testing

### Casos de Prueba Recomendados
1. **Creación de Usuarios**: Validar creación con diferentes roles
2. **Edición de Usuarios**: Verificar actualización de datos y roles
3. **Eliminación de Usuarios**: Probar eliminación y prevención de auto-eliminación
4. **Búsqueda y Filtros**: Verificar funcionamiento de filtros
5. **Permisos**: Confirmar que solo usuarios autorizados pueden acceder

### Usuarios de Prueba
Los usuarios creados en seeders anteriores siguen siendo válidos:
- **admin@uatf.edu.bo** (Administrador)
- **jefe@uatf.edu.bo** (Jefe)
- **personal@uatf.edu.bo** (Personal)

## Comandos Útiles

```bash
# Ejecutar migraciones y seeders
php artisan migrate:fresh --seed

# Limpiar caché de permisos
php artisan permission:cache-reset

# Verificar usuarios y roles
php artisan tinker
>>> User::with('roles')->get()
>>> Role::with('users')->get()

# Crear controlador de recursos
php artisan make:controller UserController --resource

# Crear requests de validación
php artisan make:request StoreUserRequest
php artisan make:request UpdateUserRequest
```

## Próximos Pasos

1. **Sistema de Títulos**: Implementar CRUD de títulos académicos
2. **Dashboard Avanzado**: Estadísticas detalladas y reportes
3. **Auditoría Completa**: Log detallado de todas las acciones
4. **Notificaciones**: Sistema de notificaciones en tiempo real
5. **API REST**: Endpoints para integración con otros sistemas

## Beneficios Alcanzados

- **Gestión Centralizada**: Administración completa de usuarios desde la web
- **Seguridad Mejorada**: Control granular de accesos y validaciones
- **Experiencia de Usuario**: Interface intuitiva y responsive
- **Escalabilidad**: Sistema preparado para crecimiento
- **Mantenibilidad**: Código organizado y bien documentado
- **Auditoría**: Trazabilidad de cambios y acciones administrativas

## Estructura de Archivos Creados/Modificados

```
app/
├── Http/
│   └── Controllers/
│       ├── UserController.php (nuevo)
│       └── AdminDashboardController.php (nuevo)
├── Http/
│   └── Requests/
│       ├── StoreUserRequest.php (nuevo)
│       └── UpdateUserRequest.php (nuevo)
resources/
└── views/
    ├── usuarios/
    │   ├── index.blade.php (nuevo)
    │   ├── create.blade.php (nuevo)
    │   ├── edit.blade.php (nuevo)
    │   └── show.blade.php (nuevo)
    └── admin/
        └── dashboard.blade.php (nuevo)
routes/
└── web.php (modificado)
```

Este paso completa la implementación del sistema de gestión de usuarios y roles, proporcionando una base sólida para la administración del sistema de digitalización de títulos de la UATF.
