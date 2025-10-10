<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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
            $adminUser->syncRoles(['Administrador']);
        }

        // Crear o actualizar usuarios de ejemplo para cada rol
        $jefeUser = User::updateOrCreate(
            ['email' => 'jefe@uatf.edu.bo'],
            [
                'name' => 'Jefe de Títulos',
                'ci' => '12345679',
                'password' => Hash::make('password'),
            ]
        );
        $jefeUser->syncRoles(['Jefe']);

        $personalUser = User::updateOrCreate(
            ['email' => 'personal@uatf.edu.bo'],
            [
                'name' => 'Personal de Títulos',
                'ci' => '12345680',
                'password' => Hash::make('password'),
            ]
        );
        $personalUser->syncRoles(['Personal']);
    }
}
