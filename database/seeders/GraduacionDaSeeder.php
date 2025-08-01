<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\GraduacionDa;
use Illuminate\Support\Facades\DB;

class GraduacionDaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvPath = database_path('csv/mod_graduacion.csv');
        
        if (!file_exists($csvPath)) {
            $this->command->error('CSV file not found: ' . $csvPath);
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
            $header = array_map(function($value) {
                return str_replace("\xEF\xBB\xBF", '', $value);
            }, $header);
            
            if (!in_array('Medio de Graduación', $header) || !in_array('Codigo', $header)) {
                throw new \Exception('Invalid CSV header format. Expected: Medio de Graduación, Codigo. Found: ' . implode(', ', $header));
            }

            $medioIndex = array_search('Medio de Graduación', $header);
            $codigoIndex = array_search('Codigo', $header);

            while (($row = fgetcsv($handle)) !== false) {
                if (count($row) < max($medioIndex, $codigoIndex) + 1) {
                    continue;
                }

                $medio = trim($row[$medioIndex]);
                $codigo = trim($row[$codigoIndex]);

                if (empty($medio)) {
                    continue;
                }

                GraduacionDa::updateOrCreate(
                    ['id' => $codigo],
                    [
                        'medio_graduacion' => $medio,
                    ]
                );
            }

            fclose($handle);
        });

        $this->command->info('Modalidades de graduación seeded successfully from CSV.');
    }
}
