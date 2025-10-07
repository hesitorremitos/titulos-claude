<?php

namespace Database\Seeders;

use App\Models\DiplomasAcademicos\DiplomaAcademico;
use App\Models\DiplomasAcademicos\Mencion;
use App\Models\DiplomasAcademicos\Modalidad;
use App\Models\Persona;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BackupDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Iniciando importación de datos de respaldo...');

        // Deshabilitar verificaciones de claves foráneas temporalmente
        $this->disableForeignKeyChecks();

        try {
            // Importar personas primero
            $this->importPersonas();

            // Importar diplomas académicos
            $this->importDiplomasAcademicos();

            $this->command->info('Importación completada exitosamente.');
        } catch (\Exception $e) {
            $this->command->error('Error durante la importación: '.$e->getMessage());
            Log::error('Error en BackupDataSeeder: '.$e->getMessage());
        } finally {
            // Rehabilitar verificaciones de claves foráneas
            $this->enableForeignKeyChecks();
        }
    }

    private function importPersonas(): void
    {
        $this->command->info('Importando personas...');

        $csvFile = database_path('backups/persona.csv');

        if (! file_exists($csvFile)) {
            $this->command->warn('Archivo persona.csv no encontrado en: '.$csvFile);

            return;
        }

        $handle = fopen($csvFile, 'r');

        if ($handle === false) {
            $this->command->error('No se pudo abrir el archivo persona.csv');

            return;
        }

        // Leer encabezados
        $headers = fgetcsv($handle);
        $importedCount = 0;
        $errorCount = 0;

        while (($data = fgetcsv($handle)) !== false) {
            try {
                // Mapear datos del CSV
                $personaData = array_combine($headers, $data);

                // Limpiar y convertir datos
                $ci = trim($personaData['ci'], '"');
                $nombres = trim($personaData['nombres'], '"');
                $paterno = trim($personaData['paterno'], '"') ?: null;
                $materno = trim($personaData['materno'], '"') ?: null;
                $fechaNacimientoRaw = trim($personaData['fecha_nacimiento'], '"');
                $fechaNacimiento = $this->convertirFecha($fechaNacimientoRaw);
                $genero = trim($personaData['genero'], '"') ?: null;

                // Si la fecha no se pudo convertir, logear pero continuar con null
                if (! $fechaNacimiento && ! empty($fechaNacimientoRaw)) {
                    Log::warning('Fecha de nacimiento no válida para persona', [
                        'ci' => $ci,
                        'fecha_original' => $fechaNacimientoRaw,
                    ]);
                }

                // Parsear localidad que viene en formato: "Ciudad- Provincia- Departamento"
                $localidadCompleta = trim($personaData['Localidad'], '"');
                $ubicacion = $this->parsearUbicacion($localidadCompleta);

                // Preparar datos de la persona
                $personaUpdateData = [
                    'nombres' => $nombres,
                    'paterno' => $paterno,
                    'materno' => $materno,
                    'genero' => $genero,
                    'pais' => $ubicacion['pais'],
                    'departamento' => $ubicacion['departamento'],
                    'provincia' => $ubicacion['provincia'],
                    'localidad' => $ubicacion['localidad'],
                ];

                // Solo agregar fecha_nacimiento si es válida
                if ($fechaNacimiento !== null) {
                    $personaUpdateData['fecha_nacimiento'] = $fechaNacimiento;
                }

                // Crear registro de persona
                Persona::updateOrCreate(['ci' => $ci], $personaUpdateData);

                $importedCount++;
            } catch (\Exception $e) {
                $errorCount++;
                Log::warning('Error importando persona: '.$e->getMessage(), [
                    'data' => $data ?? [],
                ]);
            }
        }

        fclose($handle);

        $this->command->info("Personas importadas: {$importedCount}");
        if ($errorCount > 0) {
            $this->command->warn("Errores durante importación de personas: {$errorCount}");
        }
    }

    private function importDiplomasAcademicos(): void
    {
        $this->command->info('Importando diplomas académicos...');

        $csvFile = database_path('backups/diplomas_academicos.csv');

        if (! file_exists($csvFile)) {
            $this->command->warn('Archivo diplomas_academicos.csv no encontrado en: '.$csvFile);

            return;
        }

        $handle = fopen($csvFile, 'r');

        if ($handle === false) {
            $this->command->error('No se pudo abrir el archivo diplomas_academicos.csv');

            return;
        }

        // Leer encabezados
        $headers = fgetcsv($handle);
        $importedCount = 0;
        $errorCount = 0;

        // Obtener primer usuario para asignar como created_by
        $defaultUserId = DB::table('users')->first()?->id ?? 1;

        while (($data = fgetcsv($handle)) !== false) {
            try {
                // Mapear datos del CSV
                $diplomaData = array_combine($headers, $data);

                // Limpiar y convertir datos
                $ci = trim($diplomaData['ci'], '"');
                $nroDocumento = (int) trim($diplomaData['nro_documento'], '"');
                $fojas = (int) trim($diplomaData['fojas'], '"');
                $libro = (int) trim($diplomaData['libro'], '"');
                $fechaEmisionRaw = trim($diplomaData['fecha_emision'], '"');
                $fechaEmision = $this->convertirFecha($fechaEmisionRaw);
                $mencionDaId = (int) trim($diplomaData['mencion_da_id'], '"');
                $observaciones = trim($diplomaData['observaciones'], '"') ?: null;
                $graduacionId = (int) trim($diplomaData['graduacion_id'], '"');
                $fileDir = trim($diplomaData['file_dir'], '"') ?: null;
                $verificado = (bool) (int) trim($diplomaData['verificado'], '"');

                // Si la fecha no se pudo convertir, logear pero continuar con null
                if (! $fechaEmision && ! empty($fechaEmisionRaw)) {
                    Log::warning('Fecha no válida para diploma', [
                        'ci' => $ci,
                        'fecha_original' => $fechaEmisionRaw,
                    ]);
                }

                // Verificar que exista la persona
                if (! Persona::where('ci', $ci)->exists()) {
                    throw new \Exception("Persona con CI {$ci} no existe");
                }

                // Verificar que exista la mención
                if (! Mencion::find($mencionDaId)) {
                    throw new \Exception("Mención con ID {$mencionDaId} no existe");
                }

                // Verificar que exista la graduación
                if (! Modalidad::find($graduacionId)) {
                    throw new \Exception("Graduación con ID {$graduacionId} no existe");
                }

                // Crear registro de diploma académico
                $diplomaAttributes = [
                    'ci' => $ci,
                    'nro_documento' => $nroDocumento,
                    'libro' => $libro,
                    'fojas' => $fojas,
                ];

                $diplomaData = [
                    'mencion_da_id' => $mencionDaId,
                    'observaciones' => $observaciones,
                    'graduacion_id' => $graduacionId,
                    'file_dir' => $fileDir,
                    'verificado' => $verificado,
                    'created_by' => $defaultUserId,
                    'updated_by' => $defaultUserId,
                ];

                // Solo agregar fecha_emision si es válida
                if ($fechaEmision !== null) {
                    $diplomaData['fecha_emision'] = $fechaEmision;
                }

                DiplomaAcademico::updateOrCreate($diplomaAttributes, $diplomaData);

                $importedCount++;
            } catch (\Exception $e) {
                $errorCount++;
                Log::warning('Error importando diploma académico: '.$e->getMessage(), [
                    'data' => $data ?? [],
                ]);
            }
        }

        fclose($handle);

        $this->command->info("Diplomas académicos importados: {$importedCount}");
        if ($errorCount > 0) {
            $this->command->warn("Errores durante importación de diplomas: {$errorCount}");
        }
    }

    /**
     * Convierte fecha del formato DD/MM/YYYY a formato Y-m-d
     */
    private function convertirFecha(?string $fecha): ?string
    {
        if (! $fecha || $fecha === '""' || empty(trim($fecha))) {
            return null;
        }

        // Limpiar la fecha de comillas y espacios
        $fecha = trim($fecha, '"');

        if (empty($fecha)) {
            return null;
        }

        // Parsear manualmente el formato DD/MM/YYYY
        if (preg_match('/^(\d{1,2})\/(\d{1,2})\/(\d{4})$/', $fecha, $matches)) {
            $dia = (int) $matches[1];
            $mes = (int) $matches[2];
            $anio = (int) $matches[3];

            // Validar que la fecha sea válida
            if (checkdate($mes, $dia, $anio)) {
                return sprintf('%04d-%02d-%02d', $anio, $mes, $dia);
            }
        }

        // Si no coincide con el patrón esperado, intentar con Carbon como fallback
        try {
            $carbon = Carbon::parse($fecha);

            return $carbon->format('Y-m-d');
        } catch (\Exception $e) {
            Log::warning("No se pudo convertir fecha: {$fecha}", ['error' => $e->getMessage()]);

            return null;
        }
    }

    /**
     * Parsea la ubicación del formato "Ciudad- Provincia- Departamento"
     */
    private function parsearUbicacion(string $ubicacion): array
    {
        $resultado = [
            'pais' => 'Bolivia',
            'departamento' => null,
            'provincia' => null,
            'localidad' => null,
        ];

        if (empty($ubicacion)) {
            return $resultado;
        }

        // Dividir por guiones
        $partes = array_map('trim', explode('-', $ubicacion));

        if (count($partes) >= 3) {
            $resultado['localidad'] = $partes[0];
            $resultado['provincia'] = $partes[1];
            $resultado['departamento'] = $partes[2];
        } elseif (count($partes) == 2) {
            $resultado['localidad'] = $partes[0];
            $resultado['departamento'] = $partes[1];
        } elseif (count($partes) == 1) {
            $resultado['localidad'] = $partes[0];
        }

        // Detectar si es de otro país
        if (stripos($ubicacion, 'argentina') !== false) {
            $resultado['pais'] = 'Argentina';
        }

        return $resultado;
    }

    /**
     * Deshabilita las verificaciones de claves foráneas según el driver de BD
     */
    private function disableForeignKeyChecks(): void
    {
        $driver = DB::connection()->getDriverName();

        switch ($driver) {
            case 'mysql':
                DB::statement('SET FOREIGN_KEY_CHECKS=0;');
                break;
            case 'sqlite':
                DB::statement('PRAGMA foreign_keys=OFF;');
                break;
            case 'pgsql':
                // PostgreSQL no necesita deshabilitar FKs para este caso
                break;
        }
    }

    /**
     * Habilita las verificaciones de claves foráneas según el driver de BD
     */
    private function enableForeignKeyChecks(): void
    {
        $driver = DB::connection()->getDriverName();

        switch ($driver) {
            case 'mysql':
                DB::statement('SET FOREIGN_KEY_CHECKS=1;');
                break;
            case 'sqlite':
                DB::statement('PRAGMA foreign_keys=ON;');
                break;
            case 'pgsql':
                // PostgreSQL no necesita rehabilitar FKs para este caso
                break;
        }
    }
}
