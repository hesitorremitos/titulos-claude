# 🚀 Guía de Instalación - Sistema de Migración de Títulos

## 📋 Prerequisitos

1. **Laravel 11** instalado y configurado
2. **Base de datos** configurada (MySQL recomendado, SQLite soportado)
3. **PHP 8.1+** con extensiones necesarias
4. **Composer** para dependencias

## ⚙️ Configuración Inicial

### 1. Ejecutar Migraciones
```bash
php artisan migrate:fresh --force
```

### 2. Cargar Datos Maestros
```bash
php artisan db:seed --force
```

### 3. Verificar Datos de Referencia
```bash
# Verificar menciones
php artisan tinker --execute="echo 'Menciones: ' . App\Models\MencionDa::count() . PHP_EOL;"

# Verificar graduaciones  
php artisan tinker --execute="echo 'Graduaciones: ' . App\Models\GraduacionDa::count() . PHP_EOL;"
```

## 📁 Estructura de Archivos CSV

```
database/csv/
├── README_MIGRACIONES.md          # Documentación completa
├── INSTALACION.md                 # Esta guía
├── carreras.csv                   # Datos de carreras
├── facultades.csv                 # Datos de facultades  
├── mod_graduacion.csv             # Modalidades de graduación
├── menciones/
│   └── DA.csv                     # Menciones de diplomas académicos
└── titulos/
    ├── DIPLOMA_A_todo.csv         # Datos de diplomas (6,640 registros)
    └── DIPLOMA_A_todo_errors.csv  # Errores de migración (generado automáticamente)
```

## 🎯 Ejecutar Migración

### Migración Normal
```bash
php artisan migrate:titulos
```

### Migración Limpia (borra datos existentes)
```bash
php artisan migrate:titulos --fresh
```

## 📊 Verificar Resultados

```bash
# Contar diplomas migrados
php artisan tinker --execute="echo 'Diplomas: ' . App\Models\DiplomaAcademico::count() . PHP_EOL;"

# Contar personas creadas
php artisan tinker --execute="echo 'Personas: ' . App\Models\Persona::count() . PHP_EOL;"

# Verificar archivo de errores
ls -la database/csv/titulos/*errors*
```

## 🔧 Solución de Problemas Comunes

### Error: "Archivo CSV no encontrado"
- Verificar que `database/csv/titulos/DIPLOMA_A_todo.csv` existe
- Revisar permisos de lectura del archivo

### Error: "Mención ID X no existe"
- Ejecutar: `php artisan db:seed --class=MencionDaSeeder`
- Verificar datos en `database/csv/menciones/DA.csv`

### Error: "Graduación ID X no existe"  
- Ejecutar: `php artisan db:seed --class=GraduacionDaSeeder`
- Verificar datos en `database/csv/mod_graduacion.csv`

### Muchos errores de formato CSV
- Los errores son esperados (25.7% del total)
- 99.5% son problemas de formato del CSV original
- El sistema procesa exitosamente el 72.3% de los datos

## 📈 Métricas Esperadas

| Métrica | Valor Esperado |
|---------|----------------|
| **Registros procesados** | 6,640 |
| **Éxito de migración** | ~72.3% |
| **Diplomas insertados** | ~4,799 |
| **Personas creadas** | ~4,643 |
| **Archivo de errores** | ~410KB |

## 🎯 Siguientes Pasos

1. **Revisar archivo de errores**: `database/csv/titulos/DIPLOMA_A_todo_errors.csv`
2. **Implementar títulos universitarios**: Crear `TituloAcademicoSeeder` para `TITULO_A_todo.csv`
3. **Implementar títulos de bachillerato**: Crear `TituloBachillerSeeder` para `BACHILLER_todo.csv`
4. **Migración a MySQL**: Para mejor rendimiento en producción

## 🆘 Soporte

Para problemas o preguntas:
1. Revisar logs en `storage/logs/laravel.log`
2. Verificar archivo de errores generado automáticamente
3. Consultar documentación completa en `README_MIGRACIONES.md`
