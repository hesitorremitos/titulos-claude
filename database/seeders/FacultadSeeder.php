<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FacultadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $facultades = [
            [
                'nombre' => 'CIENCIAS PURAS',
                'direccion' => 'Av. Civic s/n - Ciudad Universitaria',
            ],
            [
                'nombre' => 'INGENIERIA TECNOLOGICA',
                'direccion' => 'Av. Civic s/n - Ciudad Universitaria',
            ],
            [
                'nombre' => 'CIENCIAS ECONOMICAS FINANCIERAS Y ADMINISTRATIVAS',
                'direccion' => 'Calle Bolívar esquina Quijarro',
            ],
            [
                'nombre' => 'CIENCIAS JURIDICAS POLITICAS SOCIALES Y DE LA COMUNICACION',
                'direccion' => 'Calle Cobija s/n',
            ],
            [
                'nombre' => 'CIENCIAS DE LA SALUD',
                'direccion' => 'Av. Serrudo s/n',
            ],
            [
                'nombre' => 'CIENCIAS AGRICOLAS Y PECUARIAS',
                'direccion' => 'Km 5 Carretera Potosí - Sucre',
            ],
            [
                'nombre' => 'ARQUITECTURA Y URBANISMO',
                'direccion' => 'Av. Civic s/n - Ciudad Universitaria',
            ],
        ];

        foreach ($facultades as $facultad) {
            \App\Models\Facultad::create($facultad);
        }
    }
}
