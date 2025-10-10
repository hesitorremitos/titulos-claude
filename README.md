# Guía de Puesta en Marcha

## Requisitos previos
- PHP 8.2 con extensiones recomendadas por Laravel (intl, mbstring, openssl, etc.).
- Composer 2.x.
- Node.js 20+ y npm.
- Motor de base de datos (SQLite por defecto, MySQL/MariaDB y PostgreSQL soportados).
- Acceso de lectura a los CSV ubicados en `database/csv` si se migrarán datos históricos.

## Instalación base
```bash
composer install
npm install
```

## Configuración de entorno
1. Copiar el archivo de entorno y generar la clave de aplicación:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
2. Ajustar la conexión de base de datos en `.env`. Para usar un motor distinto del predeterminado (SQLite), establecer las variables:
   ```dotenv
   DB_CONNECTION=mysql        # mysql, pgsql, sqlsrv, etc.
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=titulos
   DB_USERNAME=usuario
   DB_PASSWORD=secreto
   ```
   Guardar los cambios y ejecutar `php artisan config:clear` si la aplicación ya estaba levantada.
3. Revisar el valor de `FILESYSTEM_DISK`. Si deseas servir documentos desde un disco distinto al configurado por defecto, define aquí el nombre del disco (ver sección siguiente).

## Configuración del almacenamiento de archivos
Los PDFs se entregan desde el disco `public` declarado en `config/filesystems.php`, actualmente apuntando a `D:/titulos/V5/storage/app/private`.

Para utilizar otra unidad o carpeta:
1. Edita `config/filesystems.php` y actualiza la ruta del disco deseado, por ejemplo:
   ```php
   'public' => [
       'driver' => 'local',
       'root' => '/mnt/data/titulos/storage/app/private',
       'serve' => true,
       'throw' => false,
   ],
   ```
2. Si prefieres mantener ambos destinos, crea un disco adicional (por ejemplo `titulos_disco`) y cambia la variable `FILESYSTEM_DISK` en `.env` para apuntar al nuevo disco.
3. Ejecuta `php artisan storage:link` si necesitas exponer el directorio público mediante `public/storage`.

## Migraciones
Ejecuta las migraciones después de ajustar el entorno:
```bash
php artisan migrate
```

## Seeders
Los semilleros de usuarios y roles son obligatorios para poder iniciar sesión en el sistema. Puedes ejecutarlos de forma individual:
```bash
php artisan db:seed --class=UserSeeder
php artisan db:seed --class=RoleSeeder
php artisan db:seed --class=UserRoleSeeder
```

Seeders opcionales (ejecutar según las necesidades del entorno):
- `php artisan db:seed --class=FacultadSeeder`
- `php artisan db:seed --class=CarreraSeeder`
- `php artisan db:seed --class=GraduacionDaSeeder`
- `php artisan db:seed --class=MencionDaSeeder`
- `php artisan db:seed --class=BackupDataSeeder` (importa CSV históricos de personas y diplomas; requiere archivos en `database/backups`)
- `php artisan db:seed --class=DiplomaAcademicoSeeder` (migra `database/csv/titulos/DIPLOMA_A_todo.csv`, revisar documentación antes de ejecutarlo)

Si deseas ejecutar todo el flujo definido en `DatabaseSeeder`, ten presente que incluye `BackupDataSeeder` por defecto. Ajusta esa clase antes de correr `php artisan db:seed` si no necesitas la importación masiva.

## Carga masiva desde CSV (opcional)
El comando personalizado `migrate:titulos` automatiza las importaciones disponibles:
```bash
# Migración incremental
php artisan migrate:titulos

# Reinicia tablas relacionadas y vuelve a importar
php artisan migrate:titulos --fresh
```
Revisa `database/csv/README_MIGRACIONES.md` para conocer la preparación de archivos y métricas esperadas.

## Construcción del frontend
Entorno de desarrollo:
```bash
php artisan serve
npm run dev
```

Compilación de producción:
```bash
npm run build
```

Opcionalmente, `composer dev` levanta servidor PHP, escucha la cola y ejecuta Vite en paralelo mediante `concurrently`.

## Comprobación final
- Verifica que puedes acceder a `http://localhost:8000/login` con las credenciales generadas por los seeders.
