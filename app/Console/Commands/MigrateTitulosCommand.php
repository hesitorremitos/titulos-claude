<?php

namespace App\Console\Commands;

use Database\Seeders\DiplomaAcademicoSeeder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

/**
 * Comando para migrar títulos académicos desde archivos CSV
 * 
 * Uso:
 * php artisan migrate:titulos              # Migración normal (sin confirmación)
 * php artisan migrate:titulos --fresh      # Limpiar datos y migrar desde cero
 * 
 * Características:
 * - Migra todos los tipos de títulos disponibles
 * - Genera archivos de errores automáticamente
 * - Soporte para múltiples tipos: diplomas, títulos universitarios, bachillerato
 * - Arquitectura extensible para nuevos tipos
 */
class MigrateTitulosCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:titulos 
                            {--fresh : Limpiar tablas y migrar desde cero}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migra todos los tipos de títulos académicos desde archivos CSV';

    /**
     * Available migration types
     */
    private array $availableTypes = [
        'diplomas-academicos' => [
            'name' => 'Diplomas Académicos',
            'seeder' => DiplomaAcademicoSeeder::class,
            'csv_file' => 'database/csv/titulos/DIPLOMA_A_todo.csv',
            'description' => 'Migra diplomas académicos desde DIPLOMA_A_todo.csv'
        ],
        // Preparado para futuros tipos de títulos
        'titulos-academicos' => [
            'name' => 'Títulos Académicos',
            'seeder' => null, // Se implementará en el futuro
            'csv_file' => 'database/csv/titulos/TITULO_A_todo.csv',
            'description' => 'Migra títulos académicos universitarios (pendiente de implementación)'
        ],
        'titulos-bachiller' => [
            'name' => 'Títulos de Bachiller',
            'seeder' => null, // Se implementará en el futuro
            'csv_file' => 'database/csv/titulos/BACHILLER_todo.csv',
            'description' => 'Migra títulos de bachillerato (pendiente de implementación)'
        ]
    ];

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $fresh = $this->option('fresh');

        $this->displayHeader();

        // Mostrar información de la migración
        $this->showMigrationInfo($fresh);

        // Limpiar tablas si se usa --fresh
        if ($fresh) {
            $this->truncateTables();
        }

        // Ejecutar migración de todos los tipos disponibles
        return $this->migrateAll();
    }

    private function displayHeader(): void
    {
        $this->info('');
        $this->info('🎓 SISTEMA DE MIGRACIÓN DE TÍTULOS ACADÉMICOS');
        $this->info('=============================================');
        $this->info('');
    }

    private function showAvailableTypes(): void
    {
        $this->info('📋 Tipos de migración disponibles:');
        $this->info('');
        
        foreach ($this->availableTypes as $key => $config) {
            $status = $config['seeder'] ? '✅' : '⏳';
            $this->info("  {$status} {$key} - {$config['description']}");
        }
        
        $this->info('  ✅ all - Migrar todos los tipos disponibles');
        $this->info('');
    }

    private function showMigrationInfo(bool $fresh): void
    {
        if ($fresh) {
            $this->warn('🔥 MODO FRESH ACTIVADO - Se limpiarán todas las tablas antes de migrar');
            $this->info('');
        }

        $this->info('📦 Configurado para migrar TODOS los tipos de títulos disponibles:');
        $this->info('');
        
        foreach ($this->availableTypes as $key => $config) {
            if ($config['seeder']) {
                $this->info("  ✅ {$config['name']} ({$key})");
                $this->info("     📄 Archivo: {$config['csv_file']}");
                
                // Verificar que el archivo existe
                if (!file_exists(base_path($config['csv_file']))) {
                    $this->error("     ❌ Archivo CSV no encontrado");
                }
            } else {
                $this->info("  ⏳ {$config['name']} ({$key}) - Pendiente de implementación");
            }
        }
        
        $this->info('');
    }

    private function truncateTables(): void
    {
        $this->info('🔥 Limpiando tablas de títulos...');
        
        // Para SQLite, desactivar foreign keys temporalmente
        DB::statement('PRAGMA foreign_keys=OFF;');
        
        // Limpiar en orden correcto respetando foreign keys
        DB::table('diploma_academicos')->delete();
        DB::table('personas')->delete();
        
        // Reactivar foreign keys
        DB::statement('PRAGMA foreign_keys=ON;');
        
        $this->info('✅ Tablas limpiadas correctamente');
        $this->info('');
    }

    private function migrateAll(): int
    {
        $this->info('🚀 Iniciando migración de todos los tipos de títulos...');
        $this->info('');
        
        $totalSuccessful = 0;
        $totalFailed = 0;
        
        foreach ($this->availableTypes as $key => $config) {
            if (!$config['seeder']) {
                $this->warn("⏭️  Saltando {$config['name']} - No implementado aún");
                continue;
            }
            
            $this->info("📋 Migrando {$config['name']}...");
            
            $result = $this->migrateSingle($key, false);
            
            if ($result === Command::SUCCESS) {
                $totalSuccessful++;
                $this->info("✅ {$config['name']} migrado exitosamente");
            } else {
                $totalFailed++;
                $this->error("❌ Error migrando {$config['name']}");
            }
            
            $this->info('');
        }
        
        // Mostrar resumen final
        $this->showFinalSummary($totalSuccessful, $totalFailed);
        
        return $totalFailed > 0 ? Command::FAILURE : Command::SUCCESS;
    }

    private function migrateSingle(string $tipo, bool $showMessages = true): int
    {
        $config = $this->availableTypes[$tipo];
        
        if (!$config['seeder']) {
            if ($showMessages) {
                $this->error("❌ Seeder para {$config['name']} no está implementado aún.");
            }
            return Command::FAILURE;
        }
        
        // Verificar que el archivo CSV existe
        if (!file_exists(base_path($config['csv_file']))) {
            if ($showMessages) {
                $this->error("❌ Archivo CSV no encontrado: {$config['csv_file']}");
            }
            return Command::FAILURE;
        }
        

        
        try {
            if ($showMessages) {
                $this->info("🚀 Ejecutando migración de {$config['name']}...");
            }
            
            // Ejecutar el seeder específico
            Artisan::call('db:seed', [
                '--class' => $config['seeder'],
                '--force' => true
            ]);
            
            if ($showMessages) {
                $this->info("✅ Migración de {$config['name']} completada exitosamente");
            }
            
            return Command::SUCCESS;
            
        } catch (\Exception $e) {
            if ($showMessages) {
                $this->error("❌ Error ejecutando migración de {$config['name']}: " . $e->getMessage());
            }
            return Command::FAILURE;
        }
    }

    private function showFinalSummary(int $successful, int $failed): void
    {
        $this->info(str_repeat('=', 50));
        $this->info('📊 RESUMEN FINAL DE MIGRACIONES');
        $this->info(str_repeat('=', 50));
        $this->info("✅ Migraciones exitosas: {$successful}");
        $this->info("❌ Migraciones fallidas: {$failed}");
        $this->info("📋 Total procesadas: " . ($successful + $failed));
        
        if ($failed > 0) {
            $this->warn('⚠️  Revisa los archivos de errores generados para más detalles.');
        }
        
        $this->info(str_repeat('=', 50));
    }
}
