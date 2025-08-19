<template>
  <Head :title="`Editar Diploma - ${diploma.persona?.nombres} ${diploma.persona?.paterno}`" />
  
  <AppLayout
    title="Editar Diploma Académico"
    page-title="Editar Diploma Académico"
    :breadcrumbs="breadcrumbs"
    :nav-tabs="navTabs"
    active-tab="lista"
  >
    <div class="space-y-6">
      <!-- Header -->
      <div class="border-b pb-4">
        <h1 class="text-2xl font-semibold text-foreground">
          Editar: {{ diploma.persona?.nombres }} {{ diploma.persona?.paterno }}
        </h1>
        <p class="text-muted-foreground mt-1">
          CI: {{ diploma.ci }} • Documento N° {{ diploma.nro_documento }}
        </p>
      </div>

      <!-- Layout de 2 columnas: Formulario | PDF Viewer -->
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Columna izquierda: Formulario -->
        <div class="space-y-6">
          <!-- Información Personal (Editable) -->
          <Card>
            <CardHeader>
              <CardTitle class="flex items-center">
                <User class="h-5 w-5 mr-2" />
                Información Personal
              </CardTitle>
              <CardDescription>Modifique los datos personales si es necesario</CardDescription>
            </CardHeader>
            <CardContent class="space-y-4">
              <div class="grid grid-cols-2 gap-4">
                <div>
                  <Label for="ci">CI</Label>
                  <Input 
                    id="ci" 
                    v-model="form.ci" 
                    :class="form.errors.ci ? 'border-red-500' : ''"
                  />
                  <p v-if="form.errors.ci" class="text-sm text-red-500 mt-1">
                    {{ form.errors.ci }}
                  </p>
                </div>
                <div>
                  <Label for="nombres">Nombres</Label>
                  <Input 
                    id="nombres" 
                    v-model="form.nombres" 
                    :class="form.errors.nombres ? 'border-red-500' : ''"
                  />
                  <p v-if="form.errors.nombres" class="text-sm text-red-500 mt-1">
                    {{ form.errors.nombres }}
                  </p>
                </div>
              </div>
              <div class="grid grid-cols-2 gap-4">
                <div>
                  <Label for="paterno">Apellido Paterno</Label>
                  <Input 
                    id="paterno" 
                    v-model="form.paterno" 
                    :class="form.errors.paterno ? 'border-red-500' : ''"
                  />
                  <p v-if="form.errors.paterno" class="text-sm text-red-500 mt-1">
                    {{ form.errors.paterno }}
                  </p>
                </div>
                <div>
                  <Label for="materno">Apellido Materno</Label>
                  <Input 
                    id="materno" 
                    v-model="form.materno" 
                    :class="form.errors.materno ? 'border-red-500' : ''"
                  />
                  <p v-if="form.errors.materno" class="text-sm text-red-500 mt-1">
                    {{ form.errors.materno }}
                  </p>
                </div>
              </div>
            </CardContent>
          </Card>

          <!-- Datos del Diploma (Editables) -->
          <Card>
            <CardHeader>
              <CardTitle class="flex items-center">
                <GraduationCap class="h-5 w-5 mr-2" />
                Datos del Diploma
              </CardTitle>
              <CardDescription>Modifique los datos específicos del diploma académico</CardDescription>
            </CardHeader>
            <CardContent class="space-y-4">
              <div class="grid grid-cols-2 gap-4">
                <div>
                  <Label for="nro_documento">Nro. Documento</Label>
                  <Input 
                    id="nro_documento" 
                    v-model="form.nro_documento" 
                    type="number"
                    :class="form.errors.nro_documento ? 'border-red-500' : ''"
                  />
                  <p v-if="form.errors.nro_documento" class="text-sm text-red-500 mt-1">
                    {{ form.errors.nro_documento }}
                  </p>
                </div>
                <div>
                  <Label for="libro">Libro</Label>
                  <Input 
                    id="libro" 
                    v-model="form.libro" 
                    type="number"
                    :class="form.errors.libro ? 'border-red-500' : ''"
                  />
                  <p v-if="form.errors.libro" class="text-sm text-red-500 mt-1">
                    {{ form.errors.libro }}
                  </p>
                </div>
              </div>
              <div class="grid grid-cols-2 gap-4">
                <div>
                  <Label for="fojas">Fojas</Label>
                  <Input 
                    id="fojas" 
                    v-model="form.fojas" 
                    type="number"
                    :class="form.errors.fojas ? 'border-red-500' : ''"
                  />
                  <p v-if="form.errors.fojas" class="text-sm text-red-500 mt-1">
                    {{ form.errors.fojas }}
                  </p>
                </div>
                <div>
                  <Label for="fecha_emision">Fecha Emisión</Label>
                  <Input 
                    id="fecha_emision" 
                    v-model="form.fecha_emision" 
                    type="date"
                    :class="form.errors.fecha_emision ? 'border-red-500' : ''"
                  />
                  <p v-if="form.errors.fecha_emision" class="text-sm text-red-500 mt-1">
                    {{ form.errors.fecha_emision }}
                  </p>
                </div>
              </div>
              <div>
                <Label for="mencion_da_id">Mención</Label>
                <Select v-model="form.mencion_da_id">
                  <SelectTrigger :class="form.errors.mencion_da_id ? 'border-red-500' : ''">
                    <SelectValue placeholder="Seleccione una mención" />
                  </SelectTrigger>
                  <SelectContent>
                    <SelectGroup>
                      <SelectLabel>Menciones</SelectLabel>
                      <SelectItem v-for="mencion in menciones" :key="mencion.id" :value="mencion.id.toString()">
                        {{ mencion.nombre }}
                      </SelectItem>
                    </SelectGroup>
                  </SelectContent>
                </Select>
                <p v-if="form.errors.mencion_da_id" class="text-sm text-red-500 mt-1">
                  {{ form.errors.mencion_da_id }}
                </p>
              </div>
              <div>
                <Label for="graduacion_id">Modalidad de Graduación (Opcional)</Label>
                <Select v-model="form.graduacion_id">
                  <SelectTrigger :class="form.errors.graduacion_id ? 'border-red-500' : ''">
                    <SelectValue placeholder="Seleccione una modalidad" />
                  </SelectTrigger>
                  <SelectContent>
                    <SelectGroup>
                      <SelectLabel>Modalidades</SelectLabel>
                      <SelectItem v-for="graduacion in graduaciones" :key="graduacion.id" :value="graduacion.id.toString()">
                        {{ graduacion.medio_graduacion }}
                      </SelectItem>
                    </SelectGroup>
                  </SelectContent>
                </Select>
                <p v-if="form.errors.graduacion_id" class="text-sm text-red-500 mt-1">
                  {{ form.errors.graduacion_id }}
                </p>
              </div>
              <div>
                <Label for="observaciones">Observaciones (Opcional)</Label>
                <Input 
                  id="observaciones" 
                  v-model="form.observaciones" 
                  type="text"
                  :class="form.errors.observaciones ? 'border-red-500' : ''"
                />
                <p v-if="form.errors.observaciones" class="text-sm text-red-500 mt-1">
                  {{ form.errors.observaciones }}
                </p>
              </div>
            </CardContent>
          </Card>

        </div>
        
        <!-- Columna derecha: PDF Viewer -->
        <div class="space-y-6">
          <!-- Actualizar PDF (Opcional) -->
          <Card>
            <CardHeader>
              <CardTitle class="flex items-center">
                <FileText class="h-5 w-5 mr-2" />
                Actualizar Documento PDF
              </CardTitle>
              <CardDescription>Opcional: Subir un nuevo archivo PDF</CardDescription>
            </CardHeader>
            <CardContent>
              <div class="space-y-4">
                <Label for="file">Archivo PDF (Opcional)</Label>
                <Input 
                  id="file" 
                  type="file" 
                  accept=".pdf"
                  @change="handleFileChange"
                  :class="form.errors.file ? 'border-red-500' : ''"
                />
                <p v-if="form.errors.file" class="text-sm text-red-500">
                  {{ form.errors.file }}
                </p>
                <p class="text-xs text-muted-foreground">
                  Tamaño máximo: 50MB. Si no selecciona un archivo, se mantendrá el actual.
                </p>
              </div>
            </CardContent>
          </Card>

          <!-- Vista Previa del Documento -->
          <Card class="flex-1">
            <CardHeader>
              <CardTitle class="flex items-center">
                <FileText class="h-5 w-5 mr-2" />
                Vista Previa del Documento
              </CardTitle>
            </CardHeader>
            <CardContent>
              <div v-if="diploma.file_dir" class="space-y-4">
                <iframe 
                  :src="`/storage/${diploma.file_dir}`" 
                  class="w-full h-[500px] border rounded-md"
                  title="Documento del Diploma Académico"
                ></iframe>
                <p class="text-xs text-muted-foreground text-center">
                  Documento actual. Si sube uno nuevo, este será reemplazado.
                </p>
              </div>
              <div v-else class="text-center py-16">
                <FileText class="h-16 w-16 text-muted-foreground mx-auto mb-4" />
                <h3 class="text-lg font-medium mb-2">Sin documento PDF</h3>
                <p class="text-muted-foreground text-sm">
                  Este diploma no tiene un archivo PDF. Puede subir uno usando el formulario.
                </p>
              </div>
            </CardContent>
          </Card>
        </div>
      </div>

      <!-- Botones de acción -->
      <div class="flex justify-between pt-6 border-t">
        <Button variant="outline" as="a" :href="route('v2.diplomas-academicos.show', diploma.id)">
          <X class="h-4 w-4 mr-2" />
          Cancelar
        </Button>
        
        <Button 
          type="submit"
          :disabled="form.processing"
          @click="updateDiploma"
        >
          <span v-if="form.processing">Guardando...</span>
          <span v-else>
            <Save class="h-4 w-4 mr-2" />
            Guardar Cambios
          </span>
        </Button>
      </div>
    </div>
  </AppLayout>
</template>

<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card'
import { Button } from '@/components/ui/button'
import { Label } from '@/components/ui/label'
import { Input } from '@/components/ui/input'
import {
  Select,
  SelectContent,
  SelectGroup,
  SelectItem,
  SelectLabel,
  SelectTrigger,
  SelectValue,
} from '@/components/ui/select'
import { 
  User, 
  GraduationCap, 
  FileText, 
  X, 
  Save 
} from 'lucide-vue-next'
import type { DiplomaAcademico, MencionDa, GraduacionDa } from '@/types/models'

// Props
const props = defineProps<{
  diploma: DiplomaAcademico
  menciones: MencionDa[]
  graduaciones: GraduacionDa[]
}>()

// Navigation tabs
const navTabs = [
    { label: 'Lista', href: route('v2.diplomas-academicos.index'), icon: 'material-symbols:list', value: 'lista' },
    { label: 'Registrar', href: route('v2.diplomas-academicos.create'), icon: 'material-symbols:add', value: 'registrar' },
    { label: 'Menciones', href: route('v2.menciones.index'), icon: 'material-symbols:category', value: 'menciones' },
    { label: 'Modalidades', href: route('v2.modalidades.index'), icon: 'material-symbols:school', value: 'modalidades' },
]

// Breadcrumbs
const breadcrumbs = [{ label: 'Diplomas Académicos', href: null }]

// Form
const form = useForm({
  ci: props.diploma.ci,
  nombres: props.diploma.persona?.nombres || '',
  paterno: props.diploma.persona?.paterno || '',
  materno: props.diploma.persona?.materno || '',
  nro_documento: props.diploma.nro_documento,
  libro: props.diploma.libro,
  fojas: props.diploma.fojas,
  fecha_emision: props.diploma.fecha_emision,
  mencion_da_id: props.diploma.mencion_da_id?.toString() || '',
  graduacion_id: props.diploma.graduacion_id?.toString() || '',
  observaciones: props.diploma.observaciones || '',
  file: null as File | null,
})

// Handle file change
const handleFileChange = (event: Event) => {
  const target = event.target as HTMLInputElement
  if (target.files && target.files.length > 0) {
    form.file = target.files[0]
  }
}

// Update diploma
const updateDiploma = () => {
  console.log('Form data being sent:', form.data())
  form.patch(route('v2.diplomas-academicos.update', props.diploma.id), {
    onSuccess: () => {
      // Redirect to show page on success
    },
    onError: (errors) => {
      console.log('Validation errors:', errors)
    }
  })
}
</script>