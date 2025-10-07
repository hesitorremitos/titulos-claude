<template>
  <Head :title="`Especialidad - ${especialidad.persona?.nombres ?? ''} ${especialidad.persona?.paterno ?? ''}`" />
  <div class="space-y-6">
    <div class="flex justify-between items-start">
      <div>
        <h1 class="text-2xl font-bold text-foreground">
          {{ especialidad.persona?.nombres }} {{ especialidad.persona?.paterno }} {{ especialidad.persona?.materno }}
        </h1>
        <p class="text-muted-foreground">
          CI: {{ especialidad.ci }} • Documento N° {{ especialidad.nro_documento }}
        </p>
      </div>
      <div class="flex space-x-3">
        <Button variant="outline" as="a" :href="route('especialidades.edit', especialidad.id)">
          <Edit class="h-4 w-4 mr-2" />
          Editar
        </Button>
        <Button variant="destructive" @click="showDeleteDialog = true">
          <Trash2 class="h-4 w-4 mr-2" />
          Eliminar
        </Button>
      </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
      <div class="space-y-6">
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
                <p class="text-sm font-medium">{{ especialidad.ci }}</p>
              </div>
              <div>
                <Label class="text-xs font-medium text-muted-foreground">Nombres</Label>
                <p class="text-sm font-medium">{{ especialidad.persona?.nombres }}</p>
              </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
              <div>
                <Label class="text-xs font-medium text-muted-foreground">Apellido Paterno</Label>
                <p class="text-sm font-medium">{{ especialidad.persona?.paterno }}</p>
              </div>
              <div>
                <Label class="text-xs font-medium text-muted-foreground">Apellido Materno</Label>
                <p class="text-sm font-medium">{{ especialidad.persona?.materno || 'No especificado' }}</p>
              </div>
            </div>
          </CardContent>
        </Card>

        <Card>
          <CardHeader>
            <CardTitle class="flex items-center">
              <GraduationCap class="h-5 w-5 mr-2" />
              Datos de la Especialidad
            </CardTitle>
          </CardHeader>
          <CardContent class="space-y-3">
            <div class="grid grid-cols-2 gap-4">
              <div>
                <Label class="text-xs font-medium text-muted-foreground">N° TPN</Label>
                <p class="text-sm font-medium">{{ especialidad.nro_tpn }}</p>
              </div>
              <div>
                <Label class="text-xs font-medium text-muted-foreground">Mención TPN</Label>
                <p class="text-sm font-medium">{{ especialidad.mencionTpn?.nombre || 'No especificada' }}</p>
              </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
              <div>
                <Label class="text-xs font-medium text-muted-foreground">Sexo</Label>
                <p class="text-sm font-medium">{{ especialidad.sexo || 'No especificado' }}</p>
              </div>
              <div>
                <Label class="text-xs font-medium text-muted-foreground">Fecha Emisión</Label>
                <p class="text-sm font-medium">{{ formatDate(especialidad.fecha_emision) }}</p>
              </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
              <div>
                <Label class="text-xs font-medium text-muted-foreground">Documento N°</Label>
                <p class="text-sm font-medium">{{ especialidad.nro_documento }}</p>
              </div>
              <div>
                <Label class="text-xs font-medium text-muted-foreground">Libro</Label>
                <p class="text-sm font-medium">{{ especialidad.libro ?? 'No especificado' }}</p>
              </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
              <div>
                <Label class="text-xs font-medium text-muted-foreground">Fojas</Label>
                <p class="text-sm font-medium">{{ especialidad.fojas ?? 'No especificado' }}</p>
              </div>
              <div>
                <Label class="text-xs font-medium text-muted-foreground">Mención</Label>
                <p class="text-sm font-medium">{{ especialidad.mencion?.nombre || 'No especificada' }}</p>
              </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
              <div>
                <Label class="text-xs font-medium text-muted-foreground">Modalidad</Label>
                <p class="text-sm font-medium">{{ especialidad.modalidad?.nombre || 'No especificada' }}</p>
              </div>
              <div>
                <Label class="text-xs font-medium text-muted-foreground">Gestión</Label>
                <p class="text-sm font-medium">{{ especialidad.gestion ?? 'No especificada' }}</p>
              </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
              <div>
                <Label class="text-xs font-medium text-muted-foreground">Versión</Label>
                <p class="text-sm font-medium">{{ especialidad.version ?? 'No especificada' }}</p>
              </div>
              <div>
                <Label class="text-xs font-medium text-muted-foreground">Horas Académicas</Label>
                <p class="text-sm font-medium">{{ especialidad.horas_academicas || 'No especificadas' }}</p>
              </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
              <div>
                <Label class="text-xs font-medium text-muted-foreground">Promedio Final</Label>
                <p class="text-sm font-medium">{{ especialidad.promedio_final ? 'Registrado' : 'No registrado' }}</p>
              </div>
              <div>
                <Label class="text-xs font-medium text-muted-foreground">Universidad</Label>
                <p class="text-sm font-medium">{{ especialidad.universidad?.nombre || 'No especificada' }}</p>
              </div>
            </div>
          </CardContent>
        </Card>

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
                <p class="text-sm font-medium">{{ especialidad.createdBy?.name || 'Sistema' }}</p>
              </div>
              <div>
                <Label class="text-xs font-medium text-muted-foreground">Fecha de registro</Label>
                <p class="text-sm font-medium">{{ formatDate(especialidad.created_at) }}</p>
              </div>
            </div>
            <div v-if="especialidad.updated_at && especialidad.updated_at !== especialidad.created_at" class="grid grid-cols-2 gap-4">
              <div>
                <Label class="text-xs font-medium text-muted-foreground">Última modificación</Label>
                <p class="text-sm font-medium">{{ especialidad.updatedBy?.name || 'Sistema' }}</p>
              </div>
              <div>
                <Label class="text-xs font-medium text-muted-foreground">Fecha modificación</Label>
                <p class="text-sm font-medium">{{ formatDate(especialidad.updated_at) }}</p>
              </div>
            </div>
          </CardContent>
        </Card>
      </div>

      <div>
        <Card class="h-full">
          <CardHeader>
            <CardTitle class="flex items-center">
              <FileText class="h-5 w-5 mr-2" />
              Documento PDF
            </CardTitle>
          </CardHeader>
          <CardContent>
            <div v-if="especialidad.file_dir" class="space-y-4">
              <iframe
                :src="route('especialidades.pdf', especialidad.id)"
                class="w-full h-[600px] border rounded-md"
                title="Documento de la especialidad"
              ></iframe>
              <div class="flex justify-center">
                <Button variant="outline" as="a" :href="route('especialidades.pdf', especialidad.id)" download>
                  <Download class="h-4 w-4 mr-2" />
                  Descargar PDF
                </Button>
              </div>
            </div>
            <div v-else class="text-center py-16">
              <FileText class="h-16 w-16 text-muted-foreground mx-auto mb-4" />
              <h3 class="text-lg font-medium mb-2">Sin documento PDF</h3>
              <p class="text-muted-foreground">
                Esta especialidad no tiene un archivo PDF asociado.
              </p>
            </div>
          </CardContent>
        </Card>
      </div>
    </div>
  </div>

  <AlertDialog v-model:open="showDeleteDialog">
    <AlertDialogContent>
      <AlertDialogHeader>
        <AlertDialogTitle>¿Eliminar especialidad?</AlertDialogTitle>
        <AlertDialogDescription>
          Esta acción no se puede deshacer. Se eliminará permanentemente la especialidad de
          <strong>{{ especialidad.persona?.nombres }} {{ especialidad.persona?.paterno }}</strong>
          (CI: {{ especialidad.ci }}).
        </AlertDialogDescription>
      </AlertDialogHeader>
      <AlertDialogFooter>
        <AlertDialogCancel>Cancelar</AlertDialogCancel>
        <AlertDialogAction @click="deleteEspecialidad" class="bg-destructive text-destructive-foreground hover:bg-destructive/90">
          Eliminar
        </AlertDialogAction>
      </AlertDialogFooter>
    </AlertDialogContent>
  </AlertDialog>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { Head, router } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import navTabs from './navtabs.json'
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
  AlertDialogTitle
} from '@/components/ui/alert-dialog'
import {
  User,
  GraduationCap,
  FileText,
  Download,
  Trash2,
  Edit,
  Clock
} from 'lucide-vue-next'
import type { Especialidad } from '@/types/titulos/especialidad'
import { toast } from 'vue-sonner'

defineOptions({
  layout: (h: any, page: any) => h(AppLayout, {
    title: 'Detalle Especialidad',
    pageTitle: 'Detalle Especialidad',
    navTabs,
    activeTab: 'lista'
  }, () => page)
})

const props = defineProps<{
  especialidad: Especialidad
}>()

const showDeleteDialog = ref(false)

const formatDate = (dateString?: string | null) => {
  if (!dateString) return 'No especificada'
  const date = new Date(dateString)
  return date.toLocaleDateString('es-ES', {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
  })
}

const deleteEspecialidad = () => {
  router.delete(route('especialidades.destroy', props.especialidad.id), {
    onSuccess: () => {
      toast.success('Especialidad eliminada correctamente.')
    },
    onError: () => {
      toast.error('No se pudo eliminar la especialidad.')
    }
  })
}
</script>
