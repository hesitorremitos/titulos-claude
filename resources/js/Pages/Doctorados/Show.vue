<template>
  <Head :title="`Doctorado - ${doctorado.persona?.nombres ?? ''} ${doctorado.persona?.paterno ?? ''}`" />
  <div class="space-y-6">
    <div class="flex justify-between items-start">
      <div>
        <h1 class="text-2xl font-bold text-foreground">
          {{ doctorado.persona?.nombres }} {{ doctorado.persona?.paterno }} {{ doctorado.persona?.materno }}
        </h1>
        <p class="text-muted-foreground">
          CI: {{ doctorado.ci }} • Documento N° {{ doctorado.nro_documento }}
        </p>
      </div>
      <div class="flex space-x-3">
        <Button variant="outline" as="a" :href="route('doctorados.edit', doctorado.id)">
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
                <p class="text-sm font-medium">{{ doctorado.ci }}</p>
              </div>
              <div>
                <Label class="text-xs font-medium text-muted-foreground">Nombres</Label>
                <p class="text-sm font-medium">{{ doctorado.persona?.nombres }}</p>
              </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
              <div>
                <Label class="text-xs font-medium text-muted-foreground">Apellido Paterno</Label>
                <p class="text-sm font-medium">{{ doctorado.persona?.paterno }}</p>
              </div>
              <div>
                <Label class="text-xs font-medium text-muted-foreground">Apellido Materno</Label>
                <p class="text-sm font-medium">{{ doctorado.persona?.materno || 'No especificado' }}</p>
              </div>
            </div>
          </CardContent>
        </Card>

        <Card>
          <CardHeader>
            <CardTitle class="flex items-center">
              <GraduationCap class="h-5 w-5 mr-2" />
              Datos del Doctorado
            </CardTitle>
          </CardHeader>
          <CardContent class="space-y-3">
            <div class="grid grid-cols-2 gap-4">
              <div>
                <Label class="text-xs font-medium text-muted-foreground">N° TPN</Label>
                <p class="text-sm font-medium">{{ doctorado.nro_tpn }}</p>
              </div>
              <div>
                <Label class="text-xs font-medium text-muted-foreground">Mención TPN</Label>
                <p class="text-sm font-medium">{{ doctorado.mencionTpn?.nombre || 'No especificada' }}</p>
              </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
              <div>
                <Label class="text-xs font-medium text-muted-foreground">Documento N°</Label>
                <p class="text-sm font-medium">{{ doctorado.nro_documento }}</p>
              </div>
              <div>
                <Label class="text-xs font-medium text-muted-foreground">Libro</Label>
                <p class="text-sm font-medium">{{ doctorado.libro ?? 'No especificado' }}</p>
              </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
              <div>
                <Label class="text-xs font-medium text-muted-foreground">Fojas</Label>
                <p class="text-sm font-medium">{{ doctorado.fojas ?? 'No especificado' }}</p>
              </div>
              <div>
                <Label class="text-xs font-medium text-muted-foreground">Fecha Emisión</Label>
                <p class="text-sm font-medium">{{ formatDate(doctorado.fecha_emision) }}</p>
              </div>
            </div>
            <div>
              <Label class="text-xs font-medium text-muted-foreground">Mención</Label>
              <p class="text-sm font-medium">{{ doctorado.mencion?.nombre || 'No especificada' }}</p>
            </div>
            <div>
              <Label class="text-xs font-medium text-muted-foreground">Modalidad</Label>
              <p class="text-sm font-medium">{{ doctorado.modalidad?.nombre || 'No especificada' }}</p>
            </div>
            <div class="grid grid-cols-2 gap-4">
              <div>
                <Label class="text-xs font-medium text-muted-foreground">Gestión</Label>
                <p class="text-sm font-medium">{{ formatGestion(doctorado.gestion_inicial, doctorado.gestion_final) }}</p>
              </div>
              <div>
                <Label class="text-xs font-medium text-muted-foreground">Versión</Label>
                <p class="text-sm font-medium">{{ doctorado.version ?? 'No especificada' }}</p>
              </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
              <div>
                <Label class="text-xs font-medium text-muted-foreground">Horas Académicas / Créditos</Label>
                <p class="text-sm font-medium">{{ doctorado.horas_academicas ?? 'No especificado' }}</p>
              </div>
              <div>
                <Label class="text-xs font-medium text-muted-foreground">Créditos Totales</Label>
                <p class="text-sm font-medium">{{ doctorado.creditos_totales ?? 'No especificado' }}</p>
              </div>
            </div>
            <div v-if="doctorado.observaciones">
              <Label class="text-xs font-medium text-muted-foreground">Observaciones</Label>
              <p class="text-sm">{{ doctorado.observaciones }}</p>
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
                <p class="text-sm font-medium">{{ doctorado.createdBy?.name || 'Sistema' }}</p>
              </div>
              <div>
                <Label class="text-xs font-medium text-muted-foreground">Fecha de registro</Label>
                <p class="text-sm font-medium">{{ formatDate(doctorado.created_at) }}</p>
              </div>
            </div>
            <div v-if="doctorado.updated_at && doctorado.updated_at !== doctorado.created_at" class="grid grid-cols-2 gap-4">
              <div>
                <Label class="text-xs font-medium text-muted-foreground">Última modificación</Label>
                <p class="text-sm font-medium">{{ doctorado.updatedBy?.name || 'Sistema' }}</p>
              </div>
              <div>
                <Label class="text-xs font-medium text-muted-foreground">Fecha modificación</Label>
                <p class="text-sm font-medium">{{ formatDate(doctorado.updated_at) }}</p>
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
            <div v-if="doctorado.file_dir" class="space-y-4">
              <iframe
                :src="route('doctorados.pdf', doctorado.id)"
                class="w-full h-[600px] border rounded-md"
                title="Documento del doctorado"
              ></iframe>
              <div class="flex justify-center">
                <Button variant="outline" as="a" :href="route('doctorados.pdf', doctorado.id)" download>
                  <Download class="h-4 w-4 mr-2" />
                  Descargar PDF
                </Button>
              </div>
            </div>
            <div v-else class="text-center py-16">
              <FileText class="h-16 w-16 text-muted-foreground mx-auto mb-4" />
              <h3 class="text-lg font-medium mb-2">Sin documento PDF</h3>
              <p class="text-muted-foreground">
                Este doctorado no tiene un archivo PDF asociado.
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
        <AlertDialogTitle>¿Eliminar doctorado?</AlertDialogTitle>
        <AlertDialogDescription>
          Esta acción no se puede deshacer. Se eliminará permanentemente el doctorado de
          <strong>{{ doctorado.persona?.nombres }} {{ doctorado.persona?.paterno }}</strong>
          (CI: {{ doctorado.ci }}).
        </AlertDialogDescription>
      </AlertDialogHeader>
      <AlertDialogFooter>
        <AlertDialogCancel>Cancelar</AlertDialogCancel>
        <AlertDialogAction @click="deleteDoctorado" class="bg-destructive text-destructive-foreground hover:bg-destructive/90">
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
import type { Doctorado } from '@/types/titulos/doctorado'
import { toast } from 'vue-sonner'

defineOptions({
  layout: (h: any, page: any) => h(AppLayout, {
    title: 'Detalle Doctorado',
    pageTitle: 'Detalle Doctorado',
    navTabs,
    activeTab: 'lista'
  }, () => page)
})

const props = defineProps<{
  doctorado: Doctorado
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

const formatGestion = (inicial?: number | null, final?: number | null) => {
  if (!inicial && !final) return 'No especificada'
  if (inicial && final) return `${inicial}-${final}`
  return inicial ?? final
}

const deleteDoctorado = () => {
  router.delete(route('doctorados.destroy', props.doctorado.id), {
    onSuccess: () => {
      toast.success('Doctorado eliminado correctamente.')
    },
    onError: () => {
      toast.error('No se pudo eliminar el doctorado.')
    }
  })
}
</script>
