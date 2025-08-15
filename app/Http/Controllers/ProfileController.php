<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    /**
     * Mostrar la página de configuraciones del perfil (Blade - Legacy)
     */
    public function index()
    {
        $user = Auth::user();

        return view('profile.index', compact('user'));
    }

    /**
     * Display the user's profile form (Vue + Inertia)
     */
    public function show(Request $request): Response
    {
        return Inertia::render('Profile/Index', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Actualizar la información del perfil (Legacy)
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'ci' => ['required', 'string', 'max:20', Rule::unique('users')->ignore($user->id)],
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'name.max' => 'El nombre no puede exceder 255 caracteres.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico debe ser válido.',
            'email.unique' => 'Este correo electrónico ya está en uso.',
            'ci.required' => 'El CI es obligatorio.',
            'ci.unique' => 'Este CI ya está registrado.',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'ci' => $request->ci,
        ]);

        return redirect()->back()->with('success', 'Información del perfil actualizada correctamente.');
    }

    /**
     * Update the user's profile information (Vue + Inertia)
     */
    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'ci' => ['required', 'string', 'max:20', Rule::unique('users')->ignore($user->id)],
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'name.max' => 'El nombre no puede exceder 255 caracteres.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico debe ser válido.',
            'email.unique' => 'Este correo electrónico ya está en uso.',
            'ci.required' => 'El CI es obligatorio.',
            'ci.unique' => 'Este CI ya está registrado.',
        ]);

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('v2.profile.show');
    }

    /**
     * Actualizar la contraseña (Legacy)
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ], [
            'current_password.required' => 'La contraseña actual es obligatoria.',
            'current_password.current_password' => 'La contraseña actual no es correcta.',
            'password.required' => 'La nueva contraseña es obligatoria.',
            'password.confirmed' => 'La confirmación de contraseña no coincide.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
        ]);

        $user = Auth::user();
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->back()->with('success', 'Contraseña actualizada correctamente.');
    }

    /**
     * Update the user's password (Vue + Inertia)
     */
    public function updatePasswordVue(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ], [
            'current_password.required' => 'La contraseña actual es obligatoria.',
            'current_password.current_password' => 'La contraseña actual no es correcta.',
            'password.required' => 'La nueva contraseña es obligatoria.',
            'password.confirmed' => 'La confirmación de contraseña no coincide.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
        ]);

        $user = $request->user();

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        return Redirect::route('v2.profile.show');
    }

    /**
     * Eliminar cuenta (Legacy)
     */
    public function deleteAccount(Request $request)
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ], [
            'password.required' => 'Debes confirmar tu contraseña para eliminar la cuenta.',
            'password.current_password' => 'La contraseña no es correcta.',
        ]);

        $user = Auth::user();

        // Logout del usuario
        Auth::logout();

        // Eliminar la cuenta
        $user->delete();

        // Invalidar la sesión
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Tu cuenta ha sido eliminada correctamente.');
    }

    /**
     * Delete the user's account (Vue + Inertia)
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'string'],
        ], [
            'password.required' => 'Debes ingresar tu contraseña para confirmar la eliminación.',
        ]);

        $user = $request->user();

        if (! Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'password' => 'La contraseña ingresada es incorrecta.',
            ]);
        }

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
