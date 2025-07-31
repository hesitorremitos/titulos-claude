<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['ci' => '12345678'],
            [
                'name' => 'Administrador',
                'email' => 'admin@uatf.edu.bo',
                'password' => Hash::make('password'),
            ]
        );

        User::updateOrCreate(
            ['ci' => '87654321'],
            [
                'name' => 'Usuario Test',
                'email' => 'test@uatf.edu.bo',
                'password' => Hash::make('123456'),
            ]
        );
    }
}
