<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
        ]);
        // Primero crear roles y permisos
        $this->call([
            RoleSeeder::class,
        ]);

        // Seeders para datos maestros
        $this->call([
            FacultadSeeder::class,
            CarreraSeeder::class,
            GraduacionDaSeeder::class,
            MencionDaSeeder::class,
        ]);

        // Usuarios y asignación de roles
        $this->call([
            UserRoleSeeder::class,
        ]);

        // Migración de datos desde CSV (ejecutar solo cuando sea necesario)
        // $this->call([
        //     DiplomaAcademicoSeeder::class,
        // ]);
    }
}
