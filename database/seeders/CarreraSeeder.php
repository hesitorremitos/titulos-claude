<?php

namespace Database\Seeders;

use App\Models\Carrera;
use App\Models\Facultad;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CarreraSeeder extends Seeder
{
    public function run(): void
    {
        $csvPath = database_path('csv/carreras.csv');

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

            if (! in_array('id_programa', $header) || ! in_array('programa', $header) || ! in_array('id_facultad', $header)) {
                throw new \Exception('Invalid CSV header format. Expected: id_programa, programa, id_facultad. Found: '.implode(', ', $header));
            }

            $idIndex = array_search('id_programa', $header);
            $programaIndex = array_search('programa', $header);
            $facultadIndex = array_search('id_facultad', $header);

            $processedCount = 0;
            $skippedCount = 0;

            while (($row = fgetcsv($handle)) !== false) {
                if (count($row) < max($idIndex, $programaIndex, $facultadIndex) + 1) {
                    continue;
                }

                $idPrograma = trim($row[$idIndex]);
                $programa = trim($row[$programaIndex]);
                $idFacultad = trim($row[$facultadIndex]);

                if (empty($idPrograma) || empty($programa)) {
                    $skippedCount++;

                    continue;
                }

                $facultad = Facultad::find($idFacultad);
                if (! $facultad) {
                    $this->command->warn("Faculty not found for ID: {$idFacultad} (Program: {$programa})");
                    $skippedCount++;

                    continue;
                }

                Carrera::updateOrCreate(
                    ['id' => $idPrograma],
                    [
                        'programa' => $programa,
                        'facultad_id' => $idFacultad,
                    ]
                );

                $processedCount++;
            }

            fclose($handle);

            $this->command->info("Carreras seeded successfully from CSV backup. Processed: {$processedCount}, Skipped: {$skippedCount}");
        });
    }
}
