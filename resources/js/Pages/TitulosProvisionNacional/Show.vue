<template>
  <Head :title="`Título Provisional Nacional - ${titulo.persona?.nombres ?? ''} ${titulo.persona?.paterno ?? ''}`" />
  <div class="space-y-6">
    <div class="flex justify-between items-start">
      <div>
        <h1 class="text-2xl font-bold text-foreground">
          {{ titulo.persona?.nombres }} {{ titulo.persona?.paterno }} {{ titulo.persona?.materno }}
        </h1>
        <p class="text-muted-foreground">
          CI: {{ titulo.ci }} • Documento N° {{ titulo.nro_documento }}
        </p>
      </div>
      <div class="flex space-x-3">
        <Button variant="outline" as="a" :href="route('titulos-provision-nacional.edit', titulo.id)">
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
                <p class="text-sm font-medium">{{ titulo.ci }}</p>
              </div>
              <div>
                <Label class="text-xs font-medium text-muted-foreground">Nombres</Label>
                <p class="text-sm font-medium">{{ titulo.persona?.nombres }}</p>
              </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
              <div>
                <Label class="text-xs font-medium text-muted-foreground">Apellido Paterno</Label>
                <p class="text-sm font-medium">{{ titulo.persona?.paterno }}</p>
              </div>
              <div>
                <Label class="text-xs font-medium text-muted-foreground">Apellido Materno</Label>
                <p class="text-sm font-medium">{{ titulo.persona?.materno || 'No especificado' }}</p>
              </div>
            </div>
          </CardContent>
        </Card>

        <Card>
          <CardHeader>
            <CardTitle class="flex items-center">
              <GraduationCap class="h-5 w-5 mr-2" />
              Datos del Título
            </CardTitle>
          </CardHeader>
          <CardContent class="space-y-3">
            <div class="grid grid-cols-2 gap-4">
              <div>
                <Label class="text-xs font-medium text-muted-foreground">N° Documento</Label>
                <p class="text-sm font-medium">{{ titulo.nro_documento }}</p>
              </div>
              <div>
                <Label class="text-xs font-medium text-muted-foreground">Libro</Label>
                <p class="text-sm font-medium">{{ titulo.libro ?? 'No especificado' }}</p>
              </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
              <div>
                <Label class="text-xs font-medium text-muted-foreground">Fojas</Label>
                <p class="text-sm font-medium">{{ titulo.fojas ?? 'No especificado' }}</p>
              </div>
              <div>
                <Label class="text-xs font-medium text-muted-foreground">Fecha Emisión</Label>
                <p class="text-sm font-medium">{{ formatDate(titulo.fecha_emision) }}</p>
              </div>
            </div>
            <div>
              <Label class="text-xs font-medium text-muted-foreground">Mención</Label>
              <p class="text-sm font-medium">{{ titulo.mencion?.nombre || 'No especificada' }}</p>
            </div>
            <div>
              <Label class="text-xs font-medium text-muted-foreground">Modalidad</Label>
              <p class="text-sm font-medium">{{ titulo.modalidad?.nombre || 'No especificada' }}</p>
            </div>
            <div v-if="titulo.observaciones">
              <Label class="text-xs font-medium text-muted-foreground">Observaciones</Label>
              <p class="text-sm">{{ titulo.observaciones }}</p>
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
                <p class="text-sm font-medium">{{ titulo.createdBy?.name || 'Sistema' }}</p>
              </div>
              <div>
                <Label class="text-xs font-medium text-muted-foreground">Fecha de registro</Label>
                <p class="text-sm font-medium">{{ formatDate(titulo.created_at) }}</p>
              </div>
            </div>
            <div v-if="titulo.updated_at && titulo.updated_at !== titulo.created_at" class="grid grid-cols-2 gap-4">
              <div>
                <Label class="text-xs font-medium text-muted-foreground">Última modificación</Label>
                <p class="text-sm font-medium">{{ titulo.updatedBy?.name || 'Sistema' }}</p>
              </div>
              <div>
                <Label class="text-xs font-medium text-muted-foreground">Fecha modificación</Label>
                <p class="text-sm font-medium">{{ formatDate(titulo.updated_at) }}</p>
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
            <div v-if="titulo.file_dir" class="space-y-4">
              <iframe
                :src="route('titulos-provision-nacional.pdf', titulo.id)"
                class="w-full h-[600px] border rounded-md"
                title="Documento del Título Provisional Nacional"
              ></iframe>
              <div class="flex justify-center">
                <Button variant="outline" as="a" :href="route('titulos-provision-nacional.pdf', titulo.id)" download>
                  <Download class="h-4 w-4 mr-2" />
                  Descargar PDF
                </Button>
              </div>
            </div>
            <div v-else class="text-center py-16">
              <FileText class="h-16 w-16 text-muted-foreground mx-auto mb-4" />
              <h3 class="text-lg font-medium mb-2">Sin documento PDF</h3>
              <p class="text-muted-foreground">
                Este título no tiene un archivo PDF asociado.
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
        <AlertDialogTitle>¿Eliminar título provisional nacional?</AlertDialogTitle>
        <AlertDialogDescription>
          Esta acción no se puede deshacer. Se eliminará permanentemente el título de
          <strong>{{ titulo.persona?.nombres }} {{ titulo.persona?.paterno }}</strong>
          (CI: {{ titulo.ci }}).
        </AlertDialogDescription>
      </AlertDialogHeader>
      <AlertDialogFooter>
        <AlertDialogCancel>Cancelar</AlertDialogCancel>
        <AlertDialogAction @click="deleteTitulo" class="bg-destructive text-destructive-foreground hover:bg-destructive/90">
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
import type { TituloProvisionNacional } from '@/types/titulos/titulo-provision-nacional'
import { toast } from 'vue-sonner'

defineOptions({
  layout: (h: any, page: any) => h(AppLayout, {
    title: 'Detalle Título Provisional Nacional',
    pageTitle: 'Detalle Título Provisional Nacional',
    navTabs,
    activeTab: 'lista'
  }, () => page)
})

const props = defineProps<{
  titulo: TituloProvisionNacional
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

const deleteTitulo = () => {
  router.delete(route('titulos-provision-nacional.destroy', props.titulo.id), {
    onSuccess: () => {
      toast.success('Título eliminado correctamente.')
    },
    onError: () => {
      toast.error('No se pudo eliminar el título.')
    }
  })
}
</script>
