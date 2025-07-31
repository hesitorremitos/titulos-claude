<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CarreraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Primero obtenemos las facultades
        $facultades = [
            'CIENCIAS PURAS' => \App\Models\Facultad::where('nombre', 'CIENCIAS PURAS')->first()->id,
            'INGENIERIA TECNOLOGICA' => \App\Models\Facultad::where('nombre', 'INGENIERIA TECNOLOGICA')->first()->id,
            'CIENCIAS ECONOMICAS FINANCIERAS Y ADMINISTRATIVAS' => \App\Models\Facultad::where('nombre', 'CIENCIAS ECONOMICAS FINANCIERAS Y ADMINISTRATIVAS')->first()->id,
            'CIENCIAS JURIDICAS POLITICAS SOCIALES Y DE LA COMUNICACION' => \App\Models\Facultad::where('nombre', 'CIENCIAS JURIDICAS POLITICAS SOCIALES Y DE LA COMUNICACION')->first()->id,
            'CIENCIAS DE LA SALUD' => \App\Models\Facultad::where('nombre', 'CIENCIAS DE LA SALUD')->first()->id,
            'CIENCIAS AGRICOLAS Y PECUARIAS' => \App\Models\Facultad::where('nombre', 'CIENCIAS AGRICOLAS Y PECUARIAS')->first()->id,
            'ARQUITECTURA Y URBANISMO' => \App\Models\Facultad::where('nombre', 'ARQUITECTURA Y URBANISMO')->first()->id,
        ];

        $carreras = [
            // CIENCIAS PURAS
            ['id' => 'INFR1', 'programa' => 'INGENIERIA INFORMATICA', 'facultad_id' => $facultades['CIENCIAS PURAS']],
            ['id' => 'MATM1', 'programa' => 'LICENCIATURA EN MATEMATICAS', 'facultad_id' => $facultades['CIENCIAS PURAS']],
            ['id' => 'QUIM1', 'programa' => 'LICENCIATURA EN QUIMICA', 'facultad_id' => $facultades['CIENCIAS PURAS']],
            ['id' => 'FISI1', 'programa' => 'LICENCIATURA EN FISICA', 'facultad_id' => $facultades['CIENCIAS PURAS']],
            ['id' => 'BIOL1', 'programa' => 'LICENCIATURA EN BIOLOGIA', 'facultad_id' => $facultades['CIENCIAS PURAS']],

            // INGENIERIA TECNOLOGICA
            ['id' => 'INMIN', 'programa' => 'INGENIERIA DE MINAS', 'facultad_id' => $facultades['INGENIERIA TECNOLOGICA']],
            ['id' => 'INMET', 'programa' => 'INGENIERIA METALURGICA', 'facultad_id' => $facultades['INGENIERIA TECNOLOGICA']],
            ['id' => 'INMEC', 'programa' => 'INGENIERIA MECANICA', 'facultad_id' => $facultades['INGENIERIA TECNOLOGICA']],
            ['id' => 'INELE', 'programa' => 'INGENIERIA ELECTRICA', 'facultad_id' => $facultades['INGENIERIA TECNOLOGICA']],
            ['id' => 'INMCT', 'programa' => 'INGENIERIA MECATRONICA', 'facultad_id' => $facultades['INGENIERIA TECNOLOGICA']],
            ['id' => 'INCIV', 'programa' => 'INGENIERIA CIVIL', 'facultad_id' => $facultades['INGENIERIA TECNOLOGICA']],

            // CIENCIAS ECONOMICAS
            ['id' => 'ADMI1', 'programa' => 'LICENCIATURA EN ADMINISTRACION DE EMPRESAS', 'facultad_id' => $facultades['CIENCIAS ECONOMICAS FINANCIERAS Y ADMINISTRATIVAS']],
            ['id' => 'CONT1', 'programa' => 'LICENCIATURA EN CONTADURIA PUBLICA', 'facultad_id' => $facultades['CIENCIAS ECONOMICAS FINANCIERAS Y ADMINISTRATIVAS']],
            ['id' => 'ECON1', 'programa' => 'LICENCIATURA EN ECONOMIA', 'facultad_id' => $facultades['CIENCIAS ECONOMICAS FINANCIERAS Y ADMINISTRATIVAS']],
            ['id' => 'INGE1', 'programa' => 'INGENIERIA COMERCIAL', 'facultad_id' => $facultades['CIENCIAS ECONOMICAS FINANCIERAS Y ADMINISTRATIVAS']],

            // CIENCIAS JURIDICAS
            ['id' => 'DERE1', 'programa' => 'LICENCIATURA EN DERECHO', 'facultad_id' => $facultades['CIENCIAS JURIDICAS POLITICAS SOCIALES Y DE LA COMUNICACION']],
            ['id' => 'COMU1', 'programa' => 'LICENCIATURA EN COMUNICACION SOCIAL', 'facultad_id' => $facultades['CIENCIAS JURIDICAS POLITICAS SOCIALES Y DE LA COMUNICACION']],
            ['id' => 'TRAB1', 'programa' => 'LICENCIATURA EN TRABAJO SOCIAL', 'facultad_id' => $facultades['CIENCIAS JURIDICAS POLITICAS SOCIALES Y DE LA COMUNICACION']],

            // CIENCIAS DE LA SALUD
            ['id' => 'MEDI1', 'programa' => 'MEDICINA', 'facultad_id' => $facultades['CIENCIAS DE LA SALUD']],
            ['id' => 'ODON1', 'programa' => 'ODONTOLOGIA', 'facultad_id' => $facultades['CIENCIAS DE LA SALUD']],
            ['id' => 'ENFE1', 'programa' => 'LICENCIATURA EN ENFERMERIA', 'facultad_id' => $facultades['CIENCIAS DE LA SALUD']],
            ['id' => 'BIOM1', 'programa' => 'LICENCIATURA EN BIOQUIMICA', 'facultad_id' => $facultades['CIENCIAS DE LA SALUD']],

            // CIENCIAS AGRICOLAS
            ['id' => 'AGRO1', 'programa' => 'INGENIERIA AGRONOMICA', 'facultad_id' => $facultades['CIENCIAS AGRICOLAS Y PECUARIAS']],
            ['id' => 'ZOOT1', 'programa' => 'LICENCIATURA EN ZOOTECNIA', 'facultad_id' => $facultades['CIENCIAS AGRICOLAS Y PECUARIAS']],
            ['id' => 'INAL1', 'programa' => 'INGENIERIA EN ALIMENTOS', 'facultad_id' => $facultades['CIENCIAS AGRICOLAS Y PECUARIAS']],

            // ARQUITECTURA
            ['id' => 'ARQU1', 'programa' => 'ARQUITECTURA', 'facultad_id' => $facultades['ARQUITECTURA Y URBANISMO']],
        ];

        foreach ($carreras as $carrera) {
            \App\Models\Carrera::create($carrera);
        }
    }
}
