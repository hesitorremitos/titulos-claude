<?php

namespace App\Http\Controllers\V2;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Mostrar lista de usuarios
     */
    public function index(Request $request)
    {
        $query = User::query()->with('roles');

        // Búsqueda
        if ($request->has('search') && $request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%'.$request->search.'%')
                    ->orWhere('ci', 'like', '%'.$request->search.'%')
                    ->orWhere('email', 'like', '%'.$request->search.'%');
            });
        }

        $usuarios = $query->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        // Calcular estadísticas de usuarios
        $stats = [
            'administradores' => User::role('Administrador')->count(),
            'jefes' => User::role('Jefe')->count(),
            'personal' => User::role('Personal')->count(),
            'activos' => User::whereNotNull('email_verified_at')->count(),
            'inactivos' => User::whereNull('email_verified_at')->count(),
        ];

        return inertia('Usuarios/Index', [
            'usuarios' => $usuarios,
            'stats' => $stats,
            'filters' => [
                'search' => $request->search,
            ],
        ]);
    }

    /**
     * Mostrar formulario de creación
     */
    public function create()
    {
        $roles = Role::all();

        return inertia('Usuarios/Create', [
            'roles' => $roles,
        ]);
    }

    /**
     * Guardar nuevo usuario
     */
    public function store(Request $request)
    {
        $request->validate([
            'ci' => 'required|string|unique:users,ci',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'roles' => 'array',
            'roles.*' => 'exists:roles,name',
        ], [
            'ci.required' => 'El CI es obligatorio.',
            'ci.unique' => 'Ya existe un usuario con este CI.',
            'name.required' => 'El nombre es obligatorio.',
            'name.max' => 'El nombre no puede exceder 255 caracteres.',
            'email.required' => 'El email es obligatorio.',
            'email.email' => 'El email debe tener un formato válido.',
            'email.unique' => 'Ya existe un usuario con este email.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'La confirmación de contraseña no coincide.',
            'roles.*.exists' => 'El rol seleccionado no es válido.',
        ]);

        try {
            $user = User::create([
                'ci' => $request->ci,
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            if ($request->has('roles') && is_array($request->roles)) {
                $user->assignRole($request->roles);
            }

            return redirect()->route('v2.usuarios.index');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['usuario' => 'Error al crear el usuario. Por favor, inténtelo nuevamente.']);
        }
    }

    /**
     * Mostrar usuario específico
     */
    public function show(User $usuario)
    {
        $usuario->load('roles');

        return inertia('Usuarios/Show', [
            'usuario' => $usuario,
        ]);
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit(User $usuario)
    {
        $usuario->load('roles');
        $roles = Role::all();

        return inertia('Usuarios/Edit', [
            'usuario' => $usuario,
            'roles' => $roles,
        ]);
    }

    /**
     * Actualizar usuario
     */
    public function update(Request $request, User $usuario)
    {
        $request->validate([
            'ci' => ['required', 'string', Rule::unique('users', 'ci')->ignore($usuario->id)],
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($usuario->id)],
            'roles' => 'array',
            'roles.*' => 'exists:roles,name',
        ], [
            'ci.required' => 'El CI es obligatorio.',
            'ci.unique' => 'Ya existe un usuario con este CI.',
            'name.required' => 'El nombre es obligatorio.',
            'name.max' => 'El nombre no puede exceder 255 caracteres.',
            'email.required' => 'El email es obligatorio.',
            'email.email' => 'El email debe tener un formato válido.',
            'email.unique' => 'Ya existe un usuario con este email.',
            'roles.*.exists' => 'El rol seleccionado no es válido.',
        ]);

        try {
            $usuario->update([
                'ci' => $request->ci,
                'name' => $request->name,
                'email' => $request->email,
            ]);

            // Sincronizar roles
            if ($request->has('roles') && is_array($request->roles)) {
                $usuario->syncRoles($request->roles);
            } else {
                $usuario->syncRoles([]);
            }

            return redirect()->route('v2.usuarios.index')
                ->with('success', 'Usuario actualizado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al actualizar el usuario. Por favor, inténtelo nuevamente.');
        }
    }

    /**
     * Eliminar usuario
     */
    public function destroy(User $usuario)
    {
        try {
            // Evitar que el usuario se elimine a sí mismo
            if ($usuario->id == auth()->id()) {
                return redirect()->route('v2.usuarios.index')->withErrors([
                    'delete' => 'No puedes eliminar tu propio usuario.',
                ]);
            }

            // Verificar si es el único administrador
            $adminRole = Role::where('name', 'Administrador')->first();
            if ($adminRole && $usuario->hasRole('Administrador')) {
                $adminCount = User::role('Administrador')->count();
                if ($adminCount <= 1) {
                    return redirect()->route('v2.usuarios.index')->withErrors([
                        'delete' => 'No se puede eliminar el último administrador del sistema.',
                    ]);
                }
            }

            $userName = $usuario->name;
            $usuario->delete();

            return redirect()->route('v2.usuarios.index')
                ->with('success', "Usuario '{$userName}' eliminado exitosamente.");

        } catch (\Exception $e) {
            return redirect()->route('v2.usuarios.index')->withErrors([
                'delete' => 'Error al eliminar el usuario. Por favor, inténtelo nuevamente.',
            ]);
        }
    }

    /**
     * Restablecer contraseña
     */
    public function resetPassword(Request $request, User $usuario)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ], [
            'password.required' => 'La nueva contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'La confirmación de contraseña no coincide.',
        ]);

        try {
            $usuario->update([
                'password' => Hash::make($request->password),
            ]);

            return redirect()->route('v2.usuarios.edit', $usuario)
                ->with('success', 'Contraseña restablecida exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al restablecer la contraseña. Por favor, inténtelo nuevamente.');
        }
    }
}
