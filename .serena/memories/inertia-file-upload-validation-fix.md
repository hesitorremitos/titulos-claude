# Fix para Validación con Archivos en Inertia.js + Laravel

## Problema Identificado
Los errores de validación ocurrían específicamente cuando se intentaba actualizar un PDF en formularios de edición. Todos los campos required fallaban la validación aunque tuvieran valores válidos.

### Síntomas
```
Error in ci: The ci field is required.
Error in nombres: The nombres field is required.
Error in paterno: The paterno field is required.
Error in nro_documento: The nro documento field is required.
```

## Causa Raíz
Cuando se usa `form.patch()` de Inertia.js con archivos, los datos del formulario no se envían correctamente al backend Laravel. Esto ocurre porque:

1. **HTTP PATCH no soporta multipart/form-data** nativamente
2. **Inertia.js patch()** no maneja archivos correctamente en algunos casos
3. **Laravel espera todos los campos** para validación, pero solo recibe el archivo

## Solución Implementada

### Frontend (Edit.vue)
```js
// 1. Agregar _method al formulario
const form = useForm({
  // ... todos los campos
  _method: 'patch',  // ← Clave para simular PATCH en POST
})

// 2. Usar POST con forceFormData
form.post(route('v2.diplomas-academicos.update', props.diploma.id), {
  forceFormData: true,  // ← Fuerza multipart/form-data
  onSuccess: () => { /* ... */ },
  onError: (errors) => { /* ... */ }
})
```

### Backend (Ya funcionaba correctamente)
```php
// Laravel automáticamente reconoce _method=patch y ruta correctamente
public function update(Request $request, string $id) {
    // Funciona igual que antes
}
```

## Patrón para Futuros Formularios con Archivos

### ✅ Correcto para archivos
```js
const form = useForm({
  // campos normales
  file: null,
  _method: 'patch' // o 'put'
})

form.post(route('modelo.update', id), {
  forceFormData: true
})
```

### ❌ Incorrecto para archivos
```js
form.patch(route('modelo.update', id)) // No maneja archivos bien
```

## Archivos Modificados
- `resources/js/Pages/DiplomasAcademicos/Edit.vue:341` - Agregado `_method: 'patch'`
- `resources/js/Pages/DiplomasAcademicos/Edit.vue:358-360` - Cambiado a `form.post()` con `forceFormData: true`

## Compatibilidad
- ✅ Formularios sin archivos: Siguen funcionando
- ✅ Formularios con archivos: Ahora funcionan correctamente
- ✅ Validaciones Laravel: Reciben todos los campos
- ✅ Rutas Laravel: Reconocen _method correctamente

## Lecciones Aprendidas
1. **Inertia.js patch()** tiene limitaciones con archivos
2. **forceFormData: true** es crucial para formularios con archivos
3. **_method spoofing** es la solución estándar Laravel para PATCH/PUT con archivos
4. **Debugging**: Siempre verificar qué datos llegan al backend cuando hay errores de validación