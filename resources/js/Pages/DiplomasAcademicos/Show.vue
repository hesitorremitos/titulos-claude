<template>
  <Head :title="`Diploma Académico - ${diploma.persona?.nombres} ${diploma.persona?.paterno}`" />
    <div class="space-y-6">
      <!-- Header con acciones -->
      <div class="flex justify-between items-start">
        <div>
          <h1 class="text-2xl font-bold text-foreground">
            {{ diploma.persona?.nombres }} {{ diploma.persona?.paterno }} {{ diploma.persona?.materno }}
          </h1>
          <p class="text-muted-foreground">
            CI: {{ diploma.ci }} • Documento N° {{ diploma.nro_documento }}
          </p>
        </div>
        
        <!-- Botones de acción -->
        <div class="flex space-x-3">
          <Button variant="outline" as="a" :href="route('v2.diplomas-academicos.edit', diploma.id)">
            <Edit class="h-4 w-4 mr-2" />
            Editar
          </Button>
          <Button variant="destructive" @click="showDeleteDialog = true">
            <Trash2 class="h-4 w-4 mr-2" />
            Eliminar
          </Button>
        </div>
      </div>

      <!-- Contenido principal en 2 columnas -->
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Columna izquierda: Información del diploma -->
        <div class="space-y-6">
          <!-- Información Personal -->
          <Card>
            <CardHeader>
              <CardTitle class="flex items-center">
                <User class="h-5 w-5 mr-2" />
                Información Personal
              </CardTitle>
            </CardHeader>
            <CardContent class="space-y-3">
              <div class="grid grid-cols-2 gap-4">
                <div>
                  <Label class="text-xs font-medium text-muted-foreground">CI</Label>
                  <p class="text-sm font-medium">{{ diploma.ci }}</p>
                </div>
                <div>
                  <Label class="text-xs font-medium text-muted-foreground">Nombres</Label>
                  <p class="text-sm font-medium">{{ diploma.persona?.nombres }}</p>
                </div>
              </div>
              <div class="grid grid-cols-2 gap-4">
                <div>
                  <Label class="text-xs font-medium text-muted-foreground">Apellido Paterno</Label>
                  <p class="text-sm font-medium">{{ diploma.persona?.paterno }}</p>
                </div>
                <div>
                  <Label class="text-xs font-medium text-muted-foreground">Apellido Materno</Label>
                  <p class="text-sm font-medium">{{ diploma.persona?.materno || 'No especificado' }}</p>
                </div>
              </div>
            </CardContent>
          </Card>

          <!-- Datos del Diploma -->
          <Card>
            <CardHeader>
              <CardTitle class="flex items-center">
                <GraduationCap class="h-5 w-5 mr-2" />
                Datos del Diploma
              </CardTitle>
            </CardHeader>
            <CardContent class="space-y-3">
              <div class="grid grid-cols-2 gap-4">
                <div>
                  <Label class="text-xs font-medium text-muted-foreground">N° Documento</Label>
                  <p class="text-sm font-medium">{{ diploma.nro_documento }}</p>
                </div>
                <div>
                  <Label class="text-xs font-medium text-muted-foreground">Libro</Label>
                  <p class="text-sm font-medium">{{ diploma.libro }}</p>
                </div>
              </div>
              <div class="grid grid-cols-2 gap-4">
                <div>
                  <Label class="text-xs font-medium text-muted-foreground">Fojas</Label>
                  <p class="text-sm font-medium">{{ diploma.fojas }}</p>
                </div>
                <div>
                  <Label class="text-xs font-medium text-muted-foreground">Fecha Emisión</Label>
                  <p class="text-sm font-medium">{{ formatDate(diploma.fecha_emision) }}</p>
                </div>
              </div>
              <div>
                <Label class="text-xs font-medium text-muted-foreground">Mención</Label>
                <p class="text-sm font-medium">{{ diploma.mencion?.nombre }}</p>
              </div>
              <div v-if="diploma.graduacion">
                <Label class="text-xs font-medium text-muted-foreground">Modalidad de Graduación</Label>
                <p class="text-sm font-medium">{{ diploma.graduacion?.medio_graduacion }}</p>
              </div>
              <div v-if="diploma.observaciones">
                <Label class="text-xs font-medium text-muted-foreground">Observaciones</Label>
                <p class="text-sm">{{ diploma.observaciones }}</p>
              </div>
            </CardContent>
          </Card>

          <!-- Metadatos -->
          <Card>
            <CardHeader>
              <CardTitle class="flex items-center">
                <Clock class="h-5 w-5 mr-2" />
                Información del Sistema
              </CardTitle>
            </CardHeader>
            <CardContent class="space-y-3">
              <div class="grid grid-cols-2 gap-4">
                <div>
                  <Label class="text-xs font-medium text-muted-foreground">Registrado por</Label>
                  <p class="text-sm font-medium">{{ diploma.createdBy?.name || 'Sistema' }}</p>
                </div>
                <div>
                  <Label class="text-xs font-medium text-muted-foreground">Fecha de registro</Label>
                  <p class="text-sm font-medium">{{ formatDate(diploma.created_at) }}</p>
                </div>
              </div>
              <div v-if="diploma.updated_at !== diploma.created_at" class="grid grid-cols-2 gap-4">
                <div>
                  <Label class="text-xs font-medium text-muted-foreground">Última modificación</Label>
                  <p class="text-sm font-medium">{{ diploma.updatedBy?.name || 'Sistema' }}</p>
                </div>
                <div>
                  <Label class="text-xs font-medium text-muted-foreground">Fecha modificación</Label>
                  <p class="text-sm font-medium">{{ formatDate(diploma.updated_at) }}</p>
                </div>
              </div>
            </CardContent>
          </Card>
        </div>
        
        <!-- Columna derecha: PDF Viewer -->
        <div>
          <Card class="h-full">
            <CardHeader>
              <CardTitle class="flex items-center">
                <FileText class="h-5 w-5 mr-2" />
                Documento PDF
              </CardTitle>
            </CardHeader>
            <CardContent>
              <div v-if="diploma.file_dir" class="space-y-4">
                <iframe 
                  :src="`/storage/${diploma.file_dir}`" 
                  class="w-full h-[600px] border rounded-md"
                  title="Documento del Diploma Académico"
                ></iframe>
                <div class="flex justify-center">
                  <Button variant="outline" as="a" :href="`/storage/${diploma.file_dir}`" download>
                    <Download class="h-4 w-4 mr-2" />
                    Descargar PDF
                  </Button>
                </div>
              </div>
              <div v-else class="text-center py-16">
                <FileText class="h-16 w-16 text-muted-foreground mx-auto mb-4" />
                <h3 class="text-lg font-medium mb-2">Sin documento PDF</h3>
                <p class="text-muted-foreground">
                  Este diploma no tiene un archivo PDF asociado.
                </p>
              </div>
            </CardContent>
          </Card>
        </div>
      </div>
    </div>

    <!-- Dialog de confirmación para eliminación -->
    <AlertDialog v-model:open="showDeleteDialog">
      <AlertDialogContent>
        <AlertDialogHeader>
          <AlertDialogTitle>¿Eliminar diploma académico?</AlertDialogTitle>
          <AlertDialogDescription>
            Esta acción no se puede deshacer. Se eliminará permanentemente el diploma académico de 
            <strong>{{ diploma.persona?.nombres }} {{ diploma.persona?.paterno }}</strong> 
            (CI: {{ diploma.ci }}).
          </AlertDialogDescription>
        </AlertDialogHeader>
        <AlertDialogFooter>
          <AlertDialogCancel>Cancelar</AlertDialogCancel>
          <AlertDialogAction @click="deleteDiploma" class="bg-destructive text-destructive-foreground hover:bg-destructive/90">
            Eliminar
          </AlertDialogAction>
        </AlertDialogFooter>
      </AlertDialogContent>
    </AlertDialog>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { Head, Link, router } from '@inertiajs/vue3'
import SubLayout from '@/Layouts/titulos/DiplomaAcademico.vue'
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card'
import { Button } from '@/components/ui/button'
import { Label } from '@/components/ui/label'
import { 
  AlertDialog,
  AlertDialogAction,
  AlertDialogCancel,
  AlertDialogContent,
  AlertDialogDescription,
  AlertDialogFooter,
  AlertDialogHeader,
  AlertDialogTitle,
} from '@/components/ui/alert-dialog'
import { 
  User, 
  GraduationCap, 
  Clock, 
  FileText, 
  Edit, 
  Trash2, 
  Download 
} from 'lucide-vue-next'
import type { DiplomaAcademico } from '@/types/models.d'

// Configurar layout persistente
defineOptions({ 
  layout: (h: any, page: any) => h(SubLayout, { 
    title: 'Ver Diploma Académico',
    activeTab: 'lista'
  }, () => page) 
})

// Props
const props = defineProps<{
  diploma: DiplomaAcademico
}>()

// State
const showDeleteDialog = ref(false)

// Function to format date
const formatDate = (dateString: string | undefined) => {
  if (!dateString) return 'No especificada'
  const date = new Date(dateString)
  return date.toLocaleDateString('es-ES', {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
  })
}

// Delete diploma function
const deleteDiploma = () => {
  router.delete(route('v2.diplomas-academicos.destroy', props.diploma.id), {
    onSuccess: () => {
      router.visit(route('v2.diplomas-academicos.index'))
    }
  })
}
</script>