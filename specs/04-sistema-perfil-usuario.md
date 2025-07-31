# Sistema de Gestión de Perfil de Usuario

## Descripción General
Este sistema permite a los usuarios gestionar su perfil personal, incluyendo la actualización de información básica, cambio de contraseña y configuraciones de cuenta.

## Componentes Implementados

### 1. Controlador de Perfil (`ProfileController.php`)
- **Ubicación**: `app/Http/Controllers/ProfileController.php`
- **Métodos implementados**:
  - `index()`: Muestra la página de configuraciones
  - `updateProfile()`: Actualiza información personal (nombre, email, CI)
  - `updatePassword()`: Cambio de contraseña con validación
  - `deleteAccount()`: Eliminación de cuenta (opcional)

### 2. Rutas del Sistema
```php
Route::prefix('profile')->name('profile.')->group(function () {
    Route::get('/', [ProfileController::class, 'index'])->name('index');
    Route::put('/update', [ProfileController::class, 'updateProfile'])->name('update');
    Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password');
    Route::delete('/delete', [ProfileController::class, 'delete'])->name('delete');
});
```

### 3. Vista Principal (`profile/index.blade.php`)
- **Ubicación**: `resources/views/profile/index.blade.php`
- **Secciones**:
  - **Información Personal**: Edición de nombre, email y CI
  - **Cambio de Contraseña**: Formulario seguro con validaciones
  - **Zona de Peligro**: Opción para eliminar cuenta

### 4. Dropdown de Usuario en Navbar
- **Funcionalidad**: Click en perfil muestra menú desplegable
- **Opciones**:
  - **Configuraciones**: Enlace a la página de perfil
  - **Cerrar sesión**: Logout del sistema
- **Características**:
  - Responsive design
  - Accesibilidad completa (ARIA labels)
  - Cierre automático con click fuera o tecla Escape

## Características de Seguridad

### Validaciones de Formularios
- **Información Personal**:
  - Nombre: requerido, máximo 255 caracteres
  - Email: requerido, formato válido, único en la base de datos
  - CI: requerido, máximo 20 caracteres, único en la base de datos

- **Cambio de Contraseña**:
  - Contraseña actual: verificación obligatoria
  - Nueva contraseña: mínimo 8 caracteres
  - Confirmación: debe coincidir con la nueva contraseña

### Mensajes de Error Personalizados
```php
[
    'name.required' => 'El nombre es obligatorio.',
    'email.unique' => 'Este correo electrónico ya está en uso.',
    'current_password.current_password' => 'La contraseña actual no es correcta.',
    'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
]
```

## Interfaz de Usuario

### Iconografía Utilizada
- `mdi--account-cog`: Configuraciones principales
- `mdi--account-edit`: Edición de información personal
- `mdi--lock-reset`: Cambio de contraseña
- `mdi--alert`: Zona de peligro
- `mdi--content-save`: Guardar cambios
- `mdi--chevron-down`: Indicador de dropdown

### Estilos y Colores
- **Información Personal**: Colores primary (azul)
- **Cambio de Contraseña**: Colores orange (naranja)
- **Zona de Peligro**: Colores red (rojo)
- **Modo Oscuro**: Soporte completo con variantes dark

### Responsive Design
- **Desktop**: Formularios en grid de 2 columnas donde corresponde
- **Móvil**: Formularios en columna única
- **Dropdown**: Se ajusta automáticamente al viewport

## JavaScript Interactivo

### Dropdown del Usuario
```javascript
// Toggle del dropdown
userMenuButton.addEventListener('click', function(e) {
    e.stopPropagation();
    const isHidden = userMenu.classList.contains('hidden');
    
    if (isHidden) {
        userMenu.classList.remove('hidden');
        userMenuButton.setAttribute('aria-expanded', 'true');
    } else {
        userMenu.classList.add('hidden');
        userMenuButton.setAttribute('aria-expanded', 'false');
    }
});
```

### Modal de Eliminación de Cuenta
- **Confirmación doble**: Modal + contraseña
- **Prevención de acciones accidentales**
- **Funciones JavaScript**:
  - `openDeleteModal()`: Abre el modal
  - `closeDeleteModal()`: Cierra y limpia el modal

## Flujo de Trabajo

### Actualización de Perfil
1. Usuario hace click en su nombre (dropdown)
2. Selecciona "Configuraciones"
3. Modifica los campos deseados
4. Click en "Guardar Cambios"
5. Validación del servidor
6. Mensaje de confirmación o errores

### Cambio de Contraseña
1. Ingresa contraseña actual
2. Define nueva contraseña
3. Confirma nueva contraseña
4. Validación de seguridad
5. Hash de nueva contraseña
6. Actualización en base de datos

### Eliminación de Cuenta
1. Click en "Eliminar Cuenta"
2. Modal de confirmación
3. Ingreso de contraseña actual
4. Confirmación final
5. Logout automático
6. Eliminación de datos
7. Redirección a login

## Integración con el Sistema

### Middleware de Autenticación
- Todas las rutas protegidas con middleware `auth`
- Verificación automática de usuario logueado
- Redirección a login si no autenticado

### Sistema de Alertas
- Integración con `session()->with('success', 'mensaje')`
- Alertas automáticas en el layout principal
- Soporte para múltiples tipos: success, error, warning, info

### Base de Datos
- Utiliza el modelo `User` existente
- Validaciones con `Rule::unique()` que ignoran el usuario actual
- Hash automático de contraseñas con `Hash::make()`

## Próximas Mejoras

### Funcionalidades Adicionales
- **Avatar de usuario**: Upload y gestión de imágenes
- **Preferencias**: Configuraciones adicionales del sistema
- **Historial de accesos**: Log de sesiones del usuario
- **Verificación por email**: Al cambiar email
- **Autenticación de dos factores**: Mayor seguridad

### Configuraciones Avanzadas
- **Notificaciones**: Preferencias de alertas
- **Tema**: Guardar preferencia de modo oscuro/claro por usuario
- **Idioma**: Soporte multiidioma
- **Zona horaria**: Configuración regional

## Comandos Útiles

### Limpiar Cache de Rutas
```bash
php artisan route:clear
php artisan route:cache
```

### Verificar Rutas
```bash
php artisan route:list --name=profile
```

### Compilar Assets
```bash
npm run build          # Producción
npm run dev            # Desarrollo
```

## Notas de Desarrollo

### Consideraciones de Seguridad
- Nunca mostrar contraseñas en formularios
- Validar siempre en servidor además del cliente
- Usar CSRF tokens en todos los formularios
- Hash de contraseñas con algoritmos seguros

### Experiencia de Usuario
- Mensajes claros de error y éxito
- Confirmación para acciones destructivas
- Loading states durante procesos largos
- Accesibilidad completa (ARIA, keyboard navigation)

### Mantenimiento
- Logs de cambios importantes (contraseña, email)
- Backup automático antes de eliminaciones
- Validaciones consistentes en toda la aplicación
