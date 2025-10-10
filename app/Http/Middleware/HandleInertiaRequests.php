<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use Spatie\Permission\Models\Role;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $user = $request->user();
        $activeRole = $user?->activeRole();
        $roles = $user ? $user->getRoleNames()->toArray() : [];

        $permissions = [];
        if ($user) {
            if ($activeRole) {
                try {
                    $roleModel = Role::findByName($activeRole);
                    $permissions = $roleModel->permissions->pluck('name')->toArray();
                } catch (\Throwable $e) {
                    $permissions = $user->getAllPermissions()->pluck('name')->toArray();
                }
            } else {
                $permissions = $user->getAllPermissions()->pluck('name')->toArray();
            }
        }

        return [
            ...parent::share($request),
            'auth' => [
                'user' => $user ? [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'ci' => $user->ci,
                    'role' => $activeRole ?? $user->role ?? 'Personal',
                    'activeRole' => $activeRole,
                    'roles' => $roles,
                    'permissions' => $permissions,
                ] : null,
            ],
            'flash' => [
                'success' => $request->session()->get('success'),
                'error' => $request->session()->get('error'), 
                'warning' => $request->session()->get('warning'),
                'info' => $request->session()->get('info'),
            ],
        ];
    }
}
