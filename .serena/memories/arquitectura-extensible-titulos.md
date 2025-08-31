# Arquitectura Extensible del Sistema de Títulos

## Diseño del Sistema
El sistema está diseñado para soportar múltiples tipos de títulos académicos con una arquitectura común y reutilizable.

## Estructura Implementada

### MigrateTitulosCommand.php
```php
private array $availableTypes = [
    'diplomas-academicos' => [
        'name' => 'Diplomas Académicos',
        'seeder' => DiplomaAcademicoSeeder::class,
        'csv_file' => 'database/csv/titulos/DIPLOMA_A_todo.csv',
        'description' => 'Migra diplomas académicos desde DIPLOMA_A_todo.csv'
    ],
    'titulos-academicos' => [
        'name' => 'Títulos Académicos',
        'seeder' => null, // Pendiente: TituloAcademicoSeeder::class
        'csv_file' => 'database/csv/titulos/TITULO_A_todo.csv',
        'description' => 'Migra títulos académicos universitarios'
    ],
    'titulos-bachiller' => [
        'name' => 'Títulos de Bachiller',
        'seeder' => null, // Pendiente: TituloBachillerSeeder::class
        'csv_file' => 'database/csv/titulos/BACHILLER_todo.csv',
        'description' => 'Migra títulos de bachillerato'
    ]
];
```

## Patrones Establecidos

### 1. Estructura de Seeder
- Validación de datos con `cleanAndValidateData()`
- Conversión de fechas Excel con `convertExcelDate()`
- Parsing de localidades con `parseLocation()`
- Upsert inteligente para evitar duplicados
- Archivo de errores automático
- Progreso en tiempo real

### 2. Validaciones Comunes
- CI boliviano (limpieza automática)
- Fechas en formato Excel numérico
- Referencias a foreign keys
- Campos requeridos vs opcionales
- Fallbacks automáticos

### 3. Manejo de Errores
- Archivo CSV con sufijo `_errors.csv`
- Headers descriptivos
- Número de fila para trazabilidad
- Descripción específica de cada error
- Continuidad del proceso (errores no bloquean)

## Implementaciones Futuras

### TituloAcademicoSeeder
```php
// database/seeders/TituloAcademicoSeeder.php
class TituloAcademicoSeeder extends Seeder
{
    // Misma estructura que DiplomaAcademicoSeeder
    // Adaptado para tabla titulo_academicos
    // CSV: database/csv/titulos/TITULO_A_todo.csv
}
```

### TituloBachillerSeeder
```php
// database/seeders/TituloBachillerSeeder.php  
class TituloBachillerSeeder extends Seeder
{
    // Misma estructura que DiplomaAcademicoSeeder
    // Adaptado para tabla titulo_bachiller
    // CSV: database/csv/titulos/BACHILLER_todo.csv
}
```

## Beneficios de la Arquitectura

1. **Código Reutilizable**: Patrones comunes aplicables
2. **Mantenimiento Fácil**: Cambios centralizados en comando
3. **Escalabilidad**: Agregar tipos sin modificar arquitectura base
4. **Consistencia**: Mismo UX y manejo de errores
5. **Documentación**: Automática en comando y README

## Comando Unificado
Un solo comando maneja todos los tipos:
```bash
php artisan migrate:titulos        # Migra todos los tipos disponibles
php artisan migrate:titulos --fresh # Limpia y migra todos
```

## Estado Actual
- ✅ **DiplomaAcademicoSeeder**: Implementado y funcional
- ⏳ **TituloAcademicoSeeder**: Pendiente (estructura preparada)
- ⏳ **TituloBachillerSeeder**: Pendiente (estructura preparada)

La base está lista para implementar los tipos restantes siguiendo el patrón establecido.