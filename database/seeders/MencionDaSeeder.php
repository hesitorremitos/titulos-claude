<?php

namespace Database\Seeders;

use App\Models\Carrera;
use App\Models\MencionDa;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MencionDaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvPath = database_path('csv/menciones/DA.csv');

        if (! file_exists($csvPath)) {
            $this->command->error('CSV file not found: '.$csvPath);

            return;
        }

        DB::transaction(function () use ($csvPath) {
            $handle = fopen($csvPath, 'r');

            if ($handle === false) {
                throw new \Exception('Could not open CSV file');
            }

            $header = fgetcsv($handle);

            if ($header === false) {
                throw new \Exception('Could not read CSV header');
            }

            // Remove BOM if present
            $header = array_map(function ($value) {
                return str_replace("\xEF\xBB\xBF", '', $value);
            }, $header);

            if (! in_array('id_mencion', $header) || ! in_array('mencion', $header) || ! in_array('id_carrera', $header)) {
                throw new \Exception('Invalid CSV header format. Expected: id_mencion, mencion, id_carrera. Found: '.implode(', ', $header));
            }

            $idIndex = array_search('id_mencion', $header);
            $mencionIndex = array_search('mencion', $header);
            $carreraIndex = array_search('id_carrera', $header);

            while (($row = fgetcsv($handle)) !== false) {
                if (count($row) < max($idIndex, $mencionIndex, $carreraIndex) + 1) {
                    continue;
                }

                $idMencion = trim($row[$idIndex]);
                $mencion = trim($row[$mencionIndex]);
                $carreraId = trim($row[$carreraIndex]);

                if (empty($mencion) || empty($carreraId)) {
                    continue;
                }

                // Verificar que la carrera existe antes de crear la mención
                $carreraExists = Carrera::where('id', $carreraId)->exists();
                if (! $carreraExists) {
                    $this->command->warn("Carrera {$carreraId} no encontrada para la mención: {$mencion}");

                    continue;
                }

                MencionDa::updateOrCreate(
                    ['id' => $idMencion],
                    [
                        'nombre' => $mencion,
                        'carrera_id' => $carreraId,
                    ]
                );
            }

            fclose($handle);
        });

        $this->command->info('Menciones de DA seeded successfully from CSV.');
    }
}
