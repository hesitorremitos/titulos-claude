# Graduación "No Registrado" - ID 100

## Implementación
Creado registro especial en la tabla `graduacion_da` para manejar casos donde los diplomas no tienen graduación válida o está vacía.

## Detalles Técnicos
- **ID**: 100 (evita conflictos con datos existentes)
- **Nombre**: "No registrado"
- **Implementación**: GraduacionDaSeeder.php
- **Migración**: default(100) en graduacion_id

## Ubicaciones del Código
1. **GraduacionDaSeeder.php**: Líneas 25-29
   ```php
   GraduacionDa::updateOrCreate(
       ['id' => 100],
       ['medio_graduacion' => 'No registrado']
   );
   ```

2. **Migración**: Línea 40
   ```php
   $table->foreignId('graduacion_id')->default(100)->constrained('graduacion_da', 'id');
   ```

3. **DiplomaAcademicoSeeder.php**: Líneas 195-199
   ```php
   if (empty($data['graduacion_id'])) {
       $data['graduacion_id'] = '100'; // Default: No registrado
   } elseif (!isset($this->graduaciones[$data['graduacion_id']])) {
       $data['graduacion_id'] = '100'; // Si no existe, usar default
   }
   ```

## Lógica de Fallback
1. Si graduacion_id está vacío → usar ID 100
2. Si graduacion_id no existe en tabla → usar ID 100
3. Si graduacion_id es válido → usar el valor original

## Protecciones
- GraduacionDaSeeder salta código 100 para evitar sobrescritura
- Se inserta al inicio del seeder para garantizar existencia
- Validación en DiplomaAcademicoSeeder para uso consistente

## Impacto
- Permite migrar registros con graduación faltante o inválida
- Reduce errores de migración significativamente
- Mantiene integridad referencial de la base de datos