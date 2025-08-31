<?php

namespace Database\Seeders;

use App\Models\DiplomaAcademico;
use App\Models\Persona;
use App\Models\MencionDa;
use App\Models\GraduacionDa;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Seeder para migrar diplomas académicos desde CSV
 * 
 * Características:
 * - Validación robusta de datos
 * - Limpieza automática de CI boliviano (remueve extensiones)
 * - Fallback a graduación "No registrado" (ID 100)
 * - Upsert para evitar duplicados
 * - Archivo de errores automático para registros problemáticos
 * - Conversión de fechas Excel a formato Carbon
 * - Parsing inteligente de localidades
 */
class DiplomaAcademicoSeeder extends Seeder
{
    private array $errors = [];
    private int $successCount = 0;
    private int $errorCount = 0;
    private int $duplicateCount = 0;
    private array $menciones = [];
    private array $graduaciones = [];

    public function run(): void
    {
        $this->command->info('🚀 Iniciando migración de diplomas académicos desde CSV...');
        
        // Cargar datos de referencia
        $this->loadReferenceData();
        
        $csvFile = database_path('csv/titulos/DIPLOMA_A_todo.csv');
        $errorFile = database_path('csv/titulos/DIPLOMA_A_todo_errors.csv');
        
        if (!file_exists($csvFile)) {
            $this->command->error("❌ Archivo CSV no encontrado: {$csvFile}");
            return;
        }

        // Crear archivo de errores con encabezados
        $this->initializeErrorFile($errorFile);
        
        $this->command->info("📄 Procesando archivo: {$csvFile}");
        $this->command->info("📝 Archivo de errores: {$errorFile}");
        
        DB::transaction(function () use ($csvFile, $errorFile) {
            $this->processCSV($csvFile, $errorFile);
        });

        // Mostrar resumen final
        $this->showFinalSummary();
    }

    private function loadReferenceData(): void
    {
        $this->command->info('📊 Cargando datos de referencia...');
        
        // Cargar menciones con sus IDs
        $this->menciones = MencionDa::pluck('id', 'id')->toArray();
        
        // Cargar graduaciones con sus IDs
        $this->graduaciones = GraduacionDa::pluck('id', 'id')->toArray();
        
        $this->command->info("✅ Menciones cargadas: " . count($this->menciones));
        $this->command->info("✅ Graduaciones cargadas: " . count($this->graduaciones));
    }

    private function initializeErrorFile(string $errorFile): void
    {
        $errorHeaders = [
            'FILA',
            'PATERNO',
            'MATERNO', 
            'NOMBRE',
            'LOCALIDAD',
            'FECHA_NACIMIENTO',
            'CI',
            'FECHA_EMISION',
            'NRO_DOCUMENTO',
            'FOJAS',
            'LIBRO',
            'MENCION',
            'MENCION_ID',
            'GRADUACION_ID',
            'ERRORES'
        ];
        
        file_put_contents($errorFile, implode(',', $errorHeaders) . "\n");
    }

    private function processCSV(string $csvFile, string $errorFile): void
    {
        $handle = fopen($csvFile, 'r');
        
        if (!$handle) {
            $this->command->error('❌ No se pudo abrir el archivo CSV');
            return;
        }

        // Saltar el encabezado
        $headers = fgetcsv($handle);
        $rowNumber = 1;
        
        $progressBar = $this->command->getOutput()->createProgressBar();
        $progressBar->setFormat('verbose');
        
        while (($row = fgetcsv($handle)) !== false) {
            $rowNumber++;
            
            try {
                $this->processRow($row, $rowNumber, $errorFile);
                $progressBar->advance();
                
                // Mostrar progreso cada 100 registros
                if ($rowNumber % 100 === 0) {
                    $this->command->info("\n📈 Procesados: {$rowNumber} | Éxitos: {$this->successCount} | Errores: {$this->errorCount}");
                }
                
            } catch (Exception $e) {
                $this->handleProcessingError($row, $rowNumber, $e->getMessage(), $errorFile);
            }
        }
        
        $progressBar->finish();
        fclose($handle);
    }

    private function processRow(array $row, int $rowNumber, string $errorFile): void
    {
        // Mapear datos del CSV
        $data = [
            'paterno' => trim($row[0] ?? ''),
            'materno' => trim($row[1] ?? ''),
            'nombre' => trim($row[2] ?? ''),
            'localidad' => trim($row[3] ?? ''),
            'fecha_nacimiento' => trim($row[4] ?? ''),
            'ci' => trim($row[5] ?? ''),
            'fecha_emision' => trim($row[6] ?? ''),
            'nro_documento' => trim($row[7] ?? ''),
            'fojas' => trim($row[8] ?? ''),
            'libro' => trim($row[9] ?? ''),
            'mencion' => trim($row[10] ?? ''),
            'mencion_id' => trim($row[11] ?? ''),
            'graduacion_id' => trim($row[12] ?? ''),
        ];

        // Limpiar y validar datos
        $cleanData = $this->cleanAndValidateData($data, $rowNumber);
        
        if ($cleanData === null) {
            $errors = ['Datos inválidos o faltantes'];
            $this->writeErrorToFile($row, $rowNumber, $errors, $errorFile);
            return;
        }

        // Procesar persona y diploma (con upsert)
        $this->createOrUpdatePersona($cleanData);
        $this->createOrUpdateDiploma($cleanData);
        
        $this->successCount++;
    }

    private function cleanAndValidateData(array $data, int $rowNumber): ?array
    {
        // Limpiar CI removiendo caracteres no numéricos
        if (!empty($data['ci'])) {
            $ciLimpio = preg_replace('/[^0-9]/', '', $data['ci']);
            if (strlen($ciLimpio) >= 4 && strlen($ciLimpio) <= 10) {
                $data['ci'] = $ciLimpio;
            } else {
                return null; // CI inválido
            }
        } else {
            return null; // CI requerido
        }

        // Validar otros campos requeridos
        if (empty($data['nro_documento']) || !is_numeric($data['nro_documento'])) {
            return null;
        }

        if (empty($data['fojas']) || !is_numeric($data['fojas'])) {
            return null;
        }

        if (empty($data['libro']) || !is_numeric($data['libro'])) {
            return null;
        }

        if (empty($data['mencion_id']) || !isset($this->menciones[$data['mencion_id']])) {
            return null;
        }

        // Graduación ID: usar 100 (No registrado) como default si está vacío o no existe
        if (empty($data['graduacion_id'])) {
            $data['graduacion_id'] = '100'; // Default: No registrado
        } elseif (!isset($this->graduaciones[$data['graduacion_id']])) {
            $data['graduacion_id'] = '100'; // Si no existe, usar default
        }

        // Validar que tenga al menos un nombre
        if (empty($data['nombre']) && empty($data['paterno']) && empty($data['materno'])) {
            return null;
        }

        return $data;
    }

    /**
     * Convierte fecha de Excel (número) a Carbon
     * Soporta formato numérico de Excel y fechas estándar
     */
    private function convertExcelDate(string $excelDate): ?Carbon
    {
        try {
            // Si ya está en formato fecha, intentar parsearlo
            if (strpos($excelDate, '/') !== false || strpos($excelDate, '-') !== false) {
                return Carbon::parse($excelDate);
            }
            
            // Convertir desde número de días de Excel (desde 1900-01-01)
            if (is_numeric($excelDate)) {
                $unixTimestamp = ($excelDate - 25569) * 86400;
                return Carbon::createFromTimestamp($unixTimestamp);
            }
            
            return null;
        } catch (Exception $e) {
            return null;
        }
    }

    private function createOrUpdatePersona(array $data): void
    {
        $fechaNacimiento = null;
        if (!empty($data['fecha_nacimiento'])) {
            $fechaNacimiento = $this->convertExcelDate($data['fecha_nacimiento']);
        }

        // Extraer localidad, provincia y departamento
        $locationData = $this->parseLocation($data['localidad']);

        Persona::updateOrCreate(
            ['ci' => $data['ci']],
            [
                'nombres' => $data['nombre'] ?: null,
                'paterno' => $data['paterno'] ?: null,
                'materno' => $data['materno'] ?: null,
                'fecha_nacimiento' => $fechaNacimiento,
                'localidad' => $locationData['localidad'],
                'provincia' => $locationData['provincia'],
                'departamento' => $locationData['departamento'],
                'pais' => 'Bolivia',
            ]
        );
    }

    private function parseLocation(string $location): array
    {
        $parts = array_map('trim', explode('-', $location));
        
        return [
            'localidad' => $parts[0] ?? null,
            'provincia' => $parts[1] ?? null,
            'departamento' => $parts[2] ?? null,
        ];
    }

    private function createOrUpdateDiploma(array $data): void
    {
        $fechaEmision = null;
        if (!empty($data['fecha_emision'])) {
            $fechaEmision = $this->convertExcelDate($data['fecha_emision']);
        }

        // Usar upsert basado en la clave única de la migración (libro, fojas, nro_documento)
        DiplomaAcademico::updateOrCreate(
            [
                'libro' => is_numeric($data['libro']) ? (int)$data['libro'] : null,
                'fojas' => is_numeric($data['fojas']) ? (int)$data['fojas'] : null,
                'nro_documento' => (int)$data['nro_documento'],
            ],
            [
                'ci' => $data['ci'],
                'fecha_emision' => $fechaEmision,
                'mencion_da_id' => (int)$data['mencion_id'],
                'graduacion_id' => (int)$data['graduacion_id'], // Siempre tendrá un valor válido después de cleanAndValidateData
                'verificado' => false,
                'created_by' => 1, // Asumiendo usuario admin con ID 1
                'updated_by' => 1,
            ]
        );
    }

    private function writeErrorToFile(array $row, int $rowNumber, array $errors, string $errorFile): void
    {
        $this->errorCount++;
        
        $errorRow = [
            $rowNumber,
            ...$row,
            implode('; ', $errors)
        ];
        
        // Escapar comillas y campos con comas
        $escapedRow = array_map(function ($field) {
            if (is_string($field) && (strpos($field, ',') !== false || strpos($field, '"') !== false)) {
                return '"' . str_replace('"', '""', $field) . '"';
            }
            return $field;
        }, $errorRow);
        
        file_put_contents($errorFile, implode(',', $escapedRow) . "\n", FILE_APPEND);
    }

    private function handleProcessingError(array $row, int $rowNumber, string $error, string $errorFile): void
    {
        Log::error("Error procesando fila {$rowNumber}: {$error}", ['row' => $row]);
        $this->writeErrorToFile($row, $rowNumber, ["Error crítico: {$error}"], $errorFile);
    }

    private function showFinalSummary(): void
    {
        $this->command->info("\n" . str_repeat('=', 60));
        $this->command->info('📊 RESUMEN DE MIGRACIÓN DE DIPLOMAS ACADÉMICOS');
        $this->command->info(str_repeat('=', 60));
        $this->command->info("✅ Registros procesados exitosamente: {$this->successCount}");
        $this->command->info("❌ Registros con errores: {$this->errorCount}");
        $this->command->info("🔄 Registros duplicados: {$this->duplicateCount}");
        $this->command->info("📝 Total procesado: " . ($this->successCount + $this->errorCount));
        
        if ($this->errorCount > 0) {
            $this->command->warn("⚠️  Revisa el archivo de errores: database/csv/titulos/DIPLOMA_A_todo_errors.csv");
        }
        
        $this->command->info(str_repeat('=', 60));
    }
}

