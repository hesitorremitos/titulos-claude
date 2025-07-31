<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Asignar rol de Administrador al usuario existente
        $adminUser = User::where('email', 'admin@uatf.edu.bo')->first();
        if ($adminUser) {
            $adminUser->assignRole('Administrador');
        }

        // Crear usuarios de ejemplo para cada rol
        $jefeUser = User::create([
            'name' => 'Jefe de Títulos',
            'email' => 'jefe@uatf.edu.bo',
            'ci' => '12345679',
            'password' => bcrypt('password'),
        ]);
        $jefeUser->assignRole('Jefe');

        $personalUser = User::create([
            'name' => 'Personal de Títulos',
            'email' => 'personal@uatf.edu.bo',
            'ci' => '12345680',
            'password' => bcrypt('password'),
        ]);
        $personalUser->assignRole('Personal');
    }
}
