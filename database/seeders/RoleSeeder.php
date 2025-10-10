<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

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

            // Universidades
            'ver-universidades',
            'crear-universidades',
            'editar-universidades',
            'eliminar-universidades',

            // Usuarios
            'ver-usuarios',
            'crear-usuarios',
            'editar-usuarios',
            'eliminar-usuarios',

            // Documentos académicos
            'ver-documentos',
            'crear-documentos',
            'editar-documentos',
            'eliminar-documentos',
            'editar-documentos-propios',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $adminRole = Role::firstOrCreate(['name' => 'Administrador']);
        $jefeRole = Role::firstOrCreate(['name' => 'Jefe']);
        $personalRole = Role::firstOrCreate(['name' => 'Personal']);

        $adminRole->syncPermissions(Permission::all());

        $jefeRole->syncPermissions([
            'ver-documentos',
            'ver-usuarios',
        ]);

        $personalRole->syncPermissions([
            'ver-documentos',
            'crear-documentos',
            'editar-documentos',
            'editar-documentos-propios',
            'ver-facultades',
            'crear-facultades',
            'editar-facultades',
            'ver-carreras',
            'crear-carreras',
            'editar-carreras',
            'ver-universidades',
            'crear-universidades',
            'editar-universidades',
        ]);
    }
}
