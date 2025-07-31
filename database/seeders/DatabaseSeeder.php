<?php

namespace Database\Seeders;

use App\Models\User;
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
        ]);

        // Usuarios y asignación de roles
        $this->call([
            UserRoleSeeder::class,
        ]);
    }
}
