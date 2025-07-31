<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear permisos
        $permissions = [
            // Facultades
            'ver-facultades',
            'crear-facultades',
            'editar-facultades',
            'eliminar-facultades',

            // Carreras
            'ver-carreras',
            'crear-carreras',
            'editar-carreras',
            'eliminar-carreras',

            // Usuarios (para futura implementación)
            'ver-usuarios',
            'crear-usuarios',
            'editar-usuarios',
            'eliminar-usuarios',

            // Títulos (para futura implementación)
            'ver-titulos',
            'crear-titulos',
            'editar-titulos',
            'eliminar-titulos',
            'editar-titulos-propios', // Solo títulos que el usuario creó
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Crear roles
        $adminRole = Role::create(['name' => 'Administrador']);
        $jefeRole = Role::create(['name' => 'Jefe']);
        $personalRole = Role::create(['name' => 'Personal']);

        // Asignar permisos al Administrador (acceso completo)
        $adminRole->givePermissionTo(Permission::all());

        // Asignar permisos al Jefe (solo visualización)
        $jefeRole->givePermissionTo([
            'ver-facultades',
            'ver-carreras',
            'ver-usuarios',
            'ver-titulos',
        ]);

        // Asignar permisos al Personal (limitado)
        $personalRole->givePermissionTo([
            'ver-facultades',
            'ver-carreras',
            'ver-titulos',
            'crear-titulos',
            'editar-titulos-propios',
        ]);
    }
}
