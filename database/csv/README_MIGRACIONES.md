# 🎓 Sistema de Migración de Títulos Académicos

Sistema completo para migrar datos de títulos académicos desde archivos CSV hacia la base de datos con validación robusta, manejo de errores inteligente y arquitectura extensible.

## 🎯 Estado Actual
- ✅ **Diplomas Académicos**: Completamente implementado (72.3% éxito de migración)
- ⏳ **Títulos Universitarios**: Pendiente de implementación
- ⏳ **Títulos de Bachillerato**: Pendiente de implementación

## 🚀 Características Principales
- **Validación inteligente**: Limpieza automática de CI boliviano, fechas Excel
- **Fallback automático**: Graduación "No registrado" para datos faltantes
- **Upsert inteligente**: Previene duplicados, actualiza existentes
- **Archivo de errores**: Registro automático de problemas para revisión
- **Arquitectura extensible**: Fácil agregar nuevos tipos de títulos

## 📋 Comando Principal

```bash
php artisan migrate:titulos [opciones]
```

## 🎯 Tipos de Migración Disponibles

### 1. Diplomas Académicos
```bash
php artisan migrate:titulos
```
- **Archivo CSV**: `database/csv/titulos/DIPLOMA_A_todo.csv`
- **Tablas afectadas**: `personas`, `diploma_academicos`
- **Estado**: ✅ Implementado

### 2. Títulos Académicos (Universitarios)
```bash
# Pendiente de implementación
```
- **Archivo CSV**: `database/csv/titulos/TITULO_A_todo.csv`
- **Tablas afectadas**: `personas`, `titulo_academicos`
- **Estado**: ⏳ Pendiente de implementación

### 3. Títulos de Bachiller
```bash
# Pendiente de implementación
```
- **Archivo CSV**: `database/csv/titulos/BACHILLER_todo.csv`
- **Tablas afectadas**: `personas`, `titulo_bachiller`
- **Estado**: ⏳ Pendiente de implementación

## ⚙️ Opciones Disponibles

### `--fresh`
Limpiar tablas y migrar desde cero:
```bash
php artisan migrate:titulos --fresh
```

## 📊 Funcionalidades del Sistema

### ✅ Validaciones Implementadas
- **CI**: Formato numérico (4-10 dígitos)
- **Fechas**: Conversión automática desde formato Excel
- **Referencias**: Validación de IDs de menciones y graduaciones
- **Duplicados**: Prevención de registros duplicados (CI + Nro Documento)
- **Datos requeridos**: Validación de campos obligatorios

### 🔧 Manejo de Errores
- **Archivo de errores**: Se genera automáticamente como `{archivo_original}_errors.csv`
- **Registro detallado**: Cada error incluye número de fila y descripción específica
- **Continuidad**: Los errores no detienen el proceso de migración
- **Log**: Errores críticos se registran en `storage/logs/laravel.log`

### 📈 Reportes de Progreso
- **Progreso en tiempo real**: Barra de progreso durante la migración
- **Estadísticas cada 100 registros**: Conteo de éxitos y errores
- **Resumen final**: Estadísticas completas al finalizar

## 📝 Estructura de Archivos CSV

### Diplomas Académicos (`DIPLOMA_A_todo.csv`)
```
PATERNO,MATERNO,NOMBRE,LOCALIDAD,FECHA_NACIMIENTO,CI,FECHA_EMISION,NRO_DOCUMENTO,FOJAS,LIBRO,MENCION,MENCION_ID,GRADUACION_ID
```

### Campos Requeridos
- `CI`: Cédula de identidad (numérica, 4-10 dígitos)
- `NRO_DOCUMENTO`: Número de documento (numérico)
- `MENCION_ID`: ID de mención (debe existir en `menciones_da`)
- `GRADUACION_ID`: ID de graduación (debe existir en `graduacion_da`)

### Campos Opcionales
- `PATERNO`, `MATERNO`, `NOMBRE`: Al menos uno requerido
- `FECHA_NACIMIENTO`, `FECHA_EMISION`: Formato Excel o fecha estándar
- `FOJAS`, `LIBRO`: Números de fojas y libro
- `LOCALIDAD`: Formato "Localidad- Provincia- Departamento"

## 🚀 Ejemplos de Uso

### Migración completa con confirmación
```bash
php artisan migrate:titulos diplomas-academicos
```

### Migración silenciosa (automatizada)
```bash
php artisan migrate:titulos diplomas-academicos --force
```

### Verificar configuración antes de migrar
```bash
php artisan migrate:titulos diplomas-academicos --dry-run
```

### Migrar todos los tipos disponibles
```bash
php artisan migrate:titulos all --force
```

## 📋 Prerequisitos

### Datos Maestros Requeridos
Antes de ejecutar la migración, asegúrate de que existan:

```bash
# Seeders de datos maestros
php artisan db:seed --class=FacultadSeeder
php artisan db:seed --class=CarreraSeeder
php artisan db:seed --class=GraduacionDaSeeder
php artisan db:seed --class=MencionDaSeeder
```

### Verificar Datos de Referencia
```sql
-- Verificar menciones
SELECT COUNT(*) FROM menciones_da;

-- Verificar graduaciones
SELECT COUNT(*) FROM graduacion_da;
```

## 🛠️ Solución de Problemas

### Error: "Archivo CSV no encontrado"
- Verifica que el archivo exista en la ruta correcta
- Revisa permisos de lectura del archivo

### Error: "Mención ID X no existe"
- Ejecuta `MencionDaSeeder` antes de la migración
- Verifica IDs en el archivo CSV contra la tabla `menciones_da`

### Error: "Graduación ID X no existe"
- Ejecuta `GraduacionDaSeeder` antes de la migración
- Verifica IDs en el archivo CSV contra la tabla `graduacion_da`

### Muchos errores de fecha
- Revisa formato de fechas en el CSV
- Las fechas de Excel se convierten automáticamente

## 📁 Archivos Generados

### Archivos de Error
- `database/csv/titulos/DIPLOMA_A_todo_errors.csv`
- Contiene registros que no pudieron ser procesados
- Incluye descripción detallada de cada error

### Logs del Sistema
- `storage/logs/laravel.log`
- Contiene errores críticos y detalles técnicos

## 📊 Métricas de Diplomas Académicos

| Métrica | Valor | Porcentaje |
|---------|-------|------------|
| **Total registros CSV** | 6,640 | 100% |
| **✅ Migrados exitosamente** | 4,799 | **72.3%** |
| **✅ Personas creadas** | 4,643 | - |
| **❌ Registros con errores** | 1,708 | 25.7% |
| **📁 Archivo de errores** | 410KB | - |

### Análisis de Errores
- **99.5%**: Formato CSV malformado (punto y coma en lugar de coma)
- **0.5%**: Validaciones de campos (campos faltantes, menciones inexistentes)

## 🔄 Próximas Implementaciones

1. **TituloAcademicoSeeder** - Para títulos universitarios
2. **TituloBachillerSeeder** - Para títulos de bachillerato
3. **Migración incremental** - Solo registros nuevos
4. **Validación de archivos PDF** - Verificar existencia de documentos digitalizados
