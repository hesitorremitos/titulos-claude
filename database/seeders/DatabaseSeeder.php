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
        // Seeders para datos maestros
        $this->call([
            FacultadSeeder::class,
            CarreraSeeder::class,
        ]);

        // Usuario de prueba
        User::factory()->create([
            'name' => 'Administrador',
            'email' => 'admin@uatf.edu.bo',
            'ci' => '12345678',
        ]);
    }
}
