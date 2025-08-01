<?php

namespace App\Services;

use App\Models\User;

class UserHelperService
{
    /**
     * Obtiene el ID del usuario actual con fallback robusto
     */
    public static function getCurrentUserId(): int
    {
        $authId = auth()->id();

        // Intentar obtener usuario por ID directo
        if ($authId) {
            $user = User::find($authId);

            // Si no se encuentra por ID, intentar por CI
            if (! $user) {
                $user = User::where('ci', $authId)->first();
            }

            if ($user) {
                return $user->id;
            }
        }

        // Fallback: obtener el primer administrador
        $adminUser = User::whereHas('roles', function ($query) {
            $query->where('name', 'Administrador');
        })->first();

        return $adminUser ? $adminUser->id : 1;
    }

    /**
     * Obtiene el usuario actual completo
     */
    public static function getCurrentUser(): ?User
    {
        $userId = self::getCurrentUserId();

        return User::find($userId);
    }

    /**
     * Verifica si el usuario actual tiene un rol específico
     */
    public static function hasRole(string $roleName): bool
    {
        $user = self::getCurrentUser();

        if (! $user) {
            return false;
        }

        return $user->hasRole($roleName);
    }

    /**
     * Verifica si el usuario actual puede acceder a un recurso específico
     *
     * @param  mixed  $resource
     */
    public static function canAccess($resource, string $action = 'view'): bool
    {
        $user = self::getCurrentUser();

        if (! $user) {
            return false;
        }

        // Si es administrador, puede acceder a todo
        if ($user->hasRole('Administrador')) {
            return true;
        }

        // Si es jefe, solo puede ver
        if ($user->hasRole('Jefe') && $action === 'view') {
            return true;
        }

        // Si es personal, solo puede acceder a sus propios recursos
        if ($user->hasRole('Personal')) {
            if (is_object($resource) && property_exists($resource, 'created_by')) {
                return $resource->created_by === $user->id;
            }
        }

        return false;
    }
}
