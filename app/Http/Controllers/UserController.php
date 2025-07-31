<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->paginate(10);

        return view('usuarios.index', compact('users'));
    }

    public function show(User $user)
    {
        $user->load('roles');

        return view('usuarios.show', compact('user'));
    }

    public function create()
    {
        $roles = Role::all();

        return view('usuarios.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'ci' => 'required|string|unique:users,ci',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'roles' => 'array',
            'roles.*' => 'exists:roles,name',
        ]);

        $user = User::create([
            'ci' => $validated['ci'],
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        if (isset($validated['roles'])) {
            $user->assignRole($validated['roles']);
        }

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario creado exitosamente.');
    }

    public function edit(User $user)
    {
        $user->load('roles');
        $roles = Role::all();

        return view('usuarios.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'ci' => ['required', 'string', Rule::unique('users', 'ci')->ignore($user->id)],
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'roles' => 'array',
            'roles.*' => 'exists:roles,name',
        ]);

        $user->update([
            'ci' => $validated['ci'],
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        // Sincronizar roles
        if (isset($validated['roles'])) {
            $user->syncRoles($validated['roles']);
        } else {
            $user->syncRoles([]);
        }

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario actualizado exitosamente.');
    }

    public function destroy(User $user)
    {
        // Evitar que el usuario se elimine a sí mismo
        if ($user->id === auth()->id()) {
            return redirect()->route('usuarios.index')
                ->with('error', 'No puedes eliminar tu propio usuario.');
        }

        $user->delete();

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario eliminado exitosamente.');
    }

    public function resetPassword(Request $request, User $user)
    {
        $validated = $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('usuarios.edit', $user)
            ->with('success', 'Contraseña restablecida exitosamente.');
    }
}
