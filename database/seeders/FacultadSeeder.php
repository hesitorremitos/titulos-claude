<?php

namespace Database\Seeders;

use App\Models\Facultad;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FacultadSeeder extends Seeder
{
    public function run(): void
    {
        $csvPath = database_path('csv/facultades.csv');

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

            if (! in_array('id_facultad', $header) || ! in_array('facultad', $header)) {
                throw new \Exception('Invalid CSV header format. Expected: id_facultad, facultad. Found: '.implode(', ', $header));
            }

            $idIndex = array_search('id_facultad', $header);
            $nombreIndex = array_search('facultad', $header);

            while (($row = fgetcsv($handle)) !== false) {
                if (count($row) < max($idIndex, $nombreIndex) + 1) {
                    continue;
                }

                $idFacultad = trim($row[$idIndex]);
                $nombre = trim($row[$nombreIndex]);

                if (empty($nombre) || $nombre === 'NINGUNO') {
                    continue;
                }

                Facultad::updateOrCreate(
                    ['id' => $idFacultad],
                    [
                        'nombre' => $nombre,
                    ]
                );
            }

            fclose($handle);
        });

        $this->command->info('Facultades seeded successfully from CSV backup.');
    }
}
