Preparación del Proyecto

---


### Tecnologías Utilizadas
- **Framework:** Laravel 12 (última versión)
- **Frontend:** 
    - Tailwind CSS 4 (última versión)
    - Iconify (última versión)
    - Alpine.js (última versión)
- **Base de Datos:** SQLite (entorno de desarrollo)
- **Testing:** Pest (incluido en Laravel 12) 
- **Roles y Permisos:** Spatie laravel-permission

### Configuración Inicial Completada
- ✅ Proyecto Laravel 12 creado
- ✅ Tailwind CSS 4 configurado
- ✅ Configuración de base de datos preparada
- ✅ Archivos de configuración básicos

### Dependencias Instaladas
- **Laravel 12:** Framework principal
- **Tailwind CSS 4:** Framework CSS para el frontend
- **Iconify:** Biblioteca de iconos
- **Alpine.js:** Por defecto en livewire
- **Spatie laravel-permission:** Gestión de roles y permisos
- **Livewire:** Interactividad en el frontend
- **Pest:** Framework de testing

---

## Configuración del Entorno

### Variables de Entorno Requeridas
```env
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
```

### Pendiente
Se debe añadir la URL de la api externa a las variables de entorno:
```env
API_URL=https://apititulos.uatf.edu.bo/api/
```

### Comandos de Configuración
```bash
# Instalar dependencias
composer install
npm install

# Configurar base de datos
php artisan migrate

# Ejecutar proyecto
composer run dev
```