# Implementación Formulario Stepper para Diplomas Académicos

## Fecha: 2025-08-17

### Funcionalidad Implementada
Formulario de registro de diplomas académicos con stepper de 2 pasos y sincronización automática PDF-API.

### Cambios Realizados

#### 1. Sincronización PDF-API Automática
**Archivos modificados:**
- `resources/js/stores/usePersonalDataStore.ts`
- `resources/js/Pages/DiplomasAcademicos/Create.vue`

**Funcionalidad:**
- Método `setCiAndSearch()` en store para setear CI en input y ejecutar búsqueda automática
- Extracción de CI desde nombre de archivo PDF usando regex `\b(\d{6,10})\b`
- Al subir PDF con CI en nombre (ej: `12345678.pdf`), automáticamente llena input y ejecuta API

#### 2. Formulario Stepper de 2 Pasos
**Componente instalado:**
```bash
npx shadcn-vue@latest add stepper
```

**Estructura implementada:**
```
Layout 2 columnas:
├── Columna izquierda: Stepper Form
│   ├── Navegación visual stepper
│   ├── Paso 1: Datos Personales
│   │   ├── Búsqueda API por CI
│   │   └── Formulario datos personales
│   ├── Paso 2: Datos Diploma (placeholder)
│   └── Botones navegación (Anterior/Siguiente/Registrar)
└── Columna derecha: PDF Viewer (siempre visible)
```

#### 3. Configuración de Pasos
```typescript
const steps = [
  {
    step: 1,
    title: 'Datos Personales',
    description: 'Buscar y completar información personal',
    icon: User,
  },
  {
    step: 2, 
    title: 'Datos del Diploma',
    description: 'Información específica del diploma académico',
    icon: GraduationCap,
  }
]
```

### Componentes Shadcn/Vue Utilizados
- `Stepper, StepperDescription, StepperIndicator, StepperItem`
- `StepperSeparator, StepperTitle, StepperTrigger`
- Iconos: `User` (paso 1), `GraduationCap` (paso 2)

### Navegación Implementada
- Botón "Anterior" (visible desde paso 2)
- Botón "Siguiente" (pasos 1 a n-1)
- Botón "Registrar Diploma" (paso final)
- Estado reactivo `currentStep` para controlar visibilidad

### Funciones de Navegación
```typescript
const nextStep = () => {
  if (currentStep.value < steps.length) {
    currentStep.value++
  }
}

const previousStep = () => {
  if (currentStep.value > 1) {
    currentStep.value--
  }
}
```

### Estado Actual
- ✅ Paso 1: Búsqueda API + datos personales completamente funcional
- ✅ PDF Viewer sincronizado con búsqueda automática
- ⏳ Paso 2: Pendiente implementación campos específicos diploma
- ✅ Navegación stepper funcional
- ✅ Layout responsivo 2 columnas

### Próximos Pasos
1. Implementar campos del diploma académico en paso 2
2. Validaciones entre pasos
3. Integración con backend para guardado
4. Manejo de estados de carga y errores

### Archivos Principales
- `resources/js/Pages/DiplomasAcademicos/Create.vue` - Componente principal
- `resources/js/stores/usePersonalDataStore.ts` - Store con setCiAndSearch()
- `resources/js/components/forms/ApiPersonSearch.vue` - Búsqueda API
- `resources/js/components/forms/PersonalDataForm.vue` - Datos personales
- `resources/js/components/forms/PdfViewer.vue` - Visor PDF con eventos