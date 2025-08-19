# CRUD Menciones y Modalidades - Vue + Inertia.js

## Arquitectura implementada

### 1. Patrón de implementación
- **Dialog-based CRUD**: Toda la funcionalidad en modales, sin páginas separadas
- **Tabla principal**: Lista con botones de acción inline
- **Navegación unificada**: Tabs de navegación entre Lista/Registrar/Menciones/Modalidades
- **Sistema de toasts**: Notificaciones inmediatas con vue-sonner

### 2. Archivos principales

#### Frontend (Vue + Inertia)
- `resources/js/Pages/DiplomasAcademicos/Menciones.vue`
- `resources/js/Pages/DiplomasAcademicos/Modalidades.vue`

#### Backend (Laravel Controllers)
- `app/Http/Controllers/V2/MencionController.php`
- `app/Http/Controllers/V2/ModalidadController.php`

#### Tipos TypeScript
- `resources/js/types/models.d.ts`: Interfaces de MencionDa, GraduacionDa
- `resources/js/types/ui.d.ts`: Tipos de UI (PageProps, etc.)

### 3. Estructura de componentes Vue

#### Menciones.vue
```vue
<template>
  <AppLayout :nav-tabs="navTabs" active-tab="menciones">
    <!-- Tabla con acciones inline -->
    <Table>
      <TableRow v-for="mencion in menciones.data">
        <TableCell>{{ mencion.nombre }}</TableCell>
        <TableCell>{{ mencion.carrera?.programa }}</TableCell>
        <TableCell class="text-right">
          <Button @click="openEditDialog(mencion)">
          <Button @click="openDeleteDialog(mencion)">
        </TableCell>
      </TableRow>
    </Table>

    <!-- Dialog Crear/Editar -->
    <Dialog v-model:open="showFormDialog">
      <!-- Form con Select de carreras agrupadas por facultad -->
    </Dialog>

    <!-- Dialog Eliminar con confirmación -->
    <AlertDialog v-model:open="showDeleteDialog">
    </AlertDialog>
  </AppLayout>
</template>
```

#### Setup y lógica
```js
const page = usePage()

// State management
const showFormDialog = ref(false)
const showDeleteDialog = ref(false)
const editingMencion = ref<MencionDa | null>(null)

// Form handling
const form = useForm({
  nombre: '',
  carrera_id: '',
})

// CRUD operations con toasts directos
const submitForm = () => {
  if (editingMencion.value) {
    form.put(route('v2.menciones.update', editingMencion.value.id), {
      onSuccess: () => {
        closeFormDialog()
        toast.success(page.props.flash.success)
      },
      onError: (errors) => {
        toast.error(errors.error)
      }
    })
  } else {
    form.post(route('v2.menciones.store'), {
      onSuccess: () => {
        closeFormDialog()
        toast.success(page.props.flash.success)
      },
      onError: (errors) => {
        toast.error(errors.error)
      }
    })
  }
}
```

### 4. Controllers Laravel

#### MencionController.php
```php
class MencionController extends Controller
{
    public function index()
    {
        $menciones = MencionDa::with(['carrera.facultad'])
            ->latest()
            ->paginate(15);

        $carreras = Facultad::with('carreras')->get();

        return Inertia::render('DiplomasAcademicos/Menciones', [
            'menciones' => $menciones,
            'carreras' => $carreras,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:menciones_da,nombre',
            'carrera_id' => 'required|exists:carreras,id',
        ]);

        MencionDa::create([
            'nombre' => $request->nombre,
            'carrera_id' => $request->carrera_id,
        ]);

        return redirect()->back()
            ->with('success', 'Mención académica creada exitosamente.');
    }

    public function update(Request $request, MencionDa $mencion)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:menciones_da,nombre,' . $mencion->id,
            'carrera_id' => 'required|exists:carreras,id',
        ]);

        $mencion->update([
            'nombre' => $request->nombre,
            'carrera_id' => $request->carrera_id,
        ]);

        return redirect()->back()
            ->with('success', 'Mención académica actualizada exitosamente.');
    }

    public function destroy(MencionDa $mencion)
    {
        // Verificación de integridad referencial
        $diplomasCount = $mencion->diplomas()->count();
        
        if ($diplomasCount > 0) {
            return redirect()->back()
                ->withErrors(['error' => "No se puede eliminar la mención '{$mencion->nombre}' porque tiene {$diplomasCount} diploma(s) asociado(s)."]);
        }

        $mencion->delete();

        return redirect()->back()
            ->with('success', 'Mención académica eliminada exitosamente.');
    }
}
```

### 5. Características implementadas

#### Menciones
- **Tabla**: Nombre, Carrera (programa), Acciones
- **Create**: Nombre + Select de carreras agrupadas por facultad
- **Update**: Edición inline en modal
- **Delete**: Confirmación con verificación de diplomas asociados
- **Validación**: Unicidad de nombre, existencia de carrera

#### Modalidades  
- **Tabla**: Modalidad, Count de diplomas, Acciones
- **Create**: Solo campo medio_graduacion
- **Update**: Edición inline en modal
- **Delete**: Confirmación con verificación de diplomas asociados
- **Validación**: Unicidad de medio_graduacion

### 6. Select de carreras agrupadas
```vue
<Select v-model="form.carrera_id">
  <SelectContent>
    <SelectGroup v-for="facultad in carreras" :key="facultad.id">
      <SelectLabel>{{ facultad.nombre }}</SelectLabel>
      <SelectItem 
        v-for="carrera in facultad.carreras" 
        :key="carrera.id" 
        :value="carrera.id"
      >
        {{ carrera.programa }}
      </SelectItem>
    </SelectGroup>
  </SelectContent>
</Select>
```

### 7. Navegación unificada
```js
const navTabs = [
  { label: 'Lista', href: route('v2.diplomas-academicos.index'), icon: 'material-symbols:list', value: 'lista' },
  { label: 'Registrar', href: route('v2.diplomas-academicos.create'), icon: 'material-symbols:add', value: 'registrar' },
  { label: 'Menciones', href: route('v2.menciones.index'), icon: 'material-symbols:category', value: 'menciones' },
  { label: 'Modalidades', href: route('v2.modalidades.index'), icon: 'material-symbols:school', value: 'modalidades' },
]
```

### 8. Rutas implementadas
```php
// routes/web-vue.php
Route::prefix('v2')->name('v2.')->group(function () {
    Route::resource('menciones', MencionController::class)
        ->only(['index', 'store', 'update', 'destroy']);
    Route::resource('modalidades', ModalidadController::class)
        ->only(['index', 'store', 'update', 'destroy']);
});
```

### 9. Sistema de toasts simplificado
- **Success**: `toast.success(page.props.flash.success)` directamente
- **Error**: `toast.error(errors.error)` sin verificaciones
- **Middleware**: HandleInertiaRequests comparte flash messages globalmente

### 10. Tipos TypeScript
```typescript
export interface MencionDa {
  id: number
  nombre: string
  carrera_id: string
  carrera?: Carrera
  created_at?: string
  updated_at?: string
  diplomas?: DiplomaAcademico[]
}

export interface GraduacionDa {
  id: number
  medio_graduacion: string
  created_at?: string
  updated_at?: string
  diplomas?: DiplomaAcademico[]
  diplomas_count?: number
}
```

### 11. Beneficios del patrón implementado
- **UX fluida**: Sin cambios de página, todo en modales
- **Código limpio**: Patrón consistente entre ambos CRUDs  
- **Validación robusta**: Integridad referencial + validaciones Laravel
- **Toasts inmediatos**: Feedback instantáneo al usuario
- **Navegación unificada**: Coherencia en toda la sección de diplomas

## Resultado
CRUD completo y funcional para Menciones y Modalidades con patrón dialog-based, navegación unificada y sistema de toasts simplificado.