<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureActiveRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (! $user) {
            abort(403, 'No tienes permisos para acceder a esta sección.');
        }

        $activeRole = $user->activeRole();
        $allowedRoles = collect($roles)
            ->flatMap(function ($role) {
                return preg_split('/[|,]/', $role);
            })
            ->filter()
            ->map(fn ($role) => trim($role))
            ->toArray();

        if ($activeRole && empty($allowedRoles)) {
            return $next($request);
        }

        if ($activeRole && in_array($activeRole, $allowedRoles, true)) {
            return $next($request);
        }

        abort(403, 'No tienes permisos para acceder con el rol activo seleccionado.');
    }
}
