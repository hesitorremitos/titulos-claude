<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class InertiaLoginController extends Controller
{
    public function create(): Response
    {
        return Inertia::render('Login', [
            'status' => session('status'),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'ci' => 'required|string',
            'password' => 'required|string',
        ], [
            'ci.required' => 'El campo CI es obligatorio.',
            'password.required' => 'El campo contraseña es obligatorio.',
        ]);

        $credentials = $request->only('ci', 'password');
        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            return redirect()->intended(route('v2.dashboard'));
        }

        throw ValidationException::withMessages([
            'ci' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ]);
    }

    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
