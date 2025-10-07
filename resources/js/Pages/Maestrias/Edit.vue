<template>
  <Head :title="`Editar Maestría - ${maestria.persona?.nombres ?? ''} ${maestria.persona?.paterno ?? ''}`" />
  <div class="space-y-6">
    <div class="border-b pb-4">
      <h1 class="text-2xl font-semibold text-foreground">
        Editar: {{ maestria.persona?.nombres }} {{ maestria.persona?.paterno }}
      </h1>
      <p class="text-muted-foreground mt-1">
        CI: {{ maestria.ci }} • Documento N° {{ maestria.nro_documento }}
      </p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
      <div class="space-y-6">
        <Card>
          <CardHeader>
            <CardTitle class="flex items-center">
              <User class="h-5 w-5 mr-2" />
              Información Personal
            </CardTitle>
            <CardDescription>Modifique los datos personales si es necesario.</CardDescription>
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

        <Card>
          <CardHeader>
            <CardTitle class="flex items-center">
              <GraduationCap class="h-5 w-5 mr-2" />
              Datos de la Maestría
            </CardTitle>
            <CardDescription>Modifique los datos específicos de la maestría.</CardDescription>
          </CardHeader>
          <CardContent class="space-y-4">
            <div class="grid grid-cols-2 gap-4">
              <div>
                <Label for="nro_tpn">N° TPN</Label>
                <Input
                  id="nro_tpn"
                  v-model="form.nro_tpn"
                  :class="form.errors.nro_tpn ? 'border-red-500' : ''"
                />
                <p v-if="form.errors.nro_tpn" class="text-sm text-red-500 mt-1">
                  {{ form.errors.nro_tpn }}
                </p>
              </div>
              <div>
                <Label for="mencion_tpn_id">Mención TPN (opcional)</Label>
                <Select v-model="form.mencion_tpn_id">
                  <SelectTrigger :class="form.errors.mencion_tpn_id ? 'border-red-500' : ''">
                    <SelectValue placeholder="Seleccione una mención" />
                  </SelectTrigger>
                  <SelectContent>
                    <SelectGroup>
                      <SelectLabel>Menciones</SelectLabel>
                      <SelectItem
                        v-for="mencion in mencionesTpn"
                        :key="mencion.id"
                        :value="String(mencion.id)"
                      >
                        {{ mencion.nombre }}
                      </SelectItem>
                    </SelectGroup>
                  </SelectContent>
                </Select>
                <p v-if="form.errors.mencion_tpn_id" class="text-sm text-red-500 mt-1">
                  {{ form.errors.mencion_tpn_id }}
                </p>
              </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
              <div>
                <Label for="nro_documento">Documento N°</Label>
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
                <Label for="libro">Libro (opcional)</Label>
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
                <Label for="fojas">Fojas (opcional)</Label>
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
              <Label for="mencion_maestria_id">Mención</Label>
              <Select v-model="form.mencion_maestria_id">
                <SelectTrigger :class="form.errors.mencion_maestria_id ? 'border-red-500' : ''">
                  <SelectValue placeholder="Seleccione una mención" />
                </SelectTrigger>
                <SelectContent>
                  <SelectGroup>
                    <SelectLabel>Menciones</SelectLabel>
                    <SelectItem
                      v-for="mencion in menciones"
                      :key="mencion.id"
                      :value="String(mencion.id)"
                    >
                      {{ mencion.nombre }}
                    </SelectItem>
                  </SelectGroup>
                </SelectContent>
              </Select>
              <p v-if="form.errors.mencion_maestria_id" class="text-sm text-red-500 mt-1">
                {{ form.errors.mencion_maestria_id }}
              </p>
            </div>

            <div class="grid grid-cols-2 gap-4">
              <div>
                <Label for="gestion_inicial">Gestión Inicial</Label>
                <Input
                  id="gestion_inicial"
                  v-model="form.gestion_inicial"
                  type="number"
                  :class="form.errors.gestion_inicial ? 'border-red-500' : ''"
                />
                <p v-if="form.errors.gestion_inicial" class="text-sm text-red-500 mt-1">
                  {{ form.errors.gestion_inicial }}
                </p>
              </div>
              <div>
                <Label for="gestion_final">Gestión Final</Label>
                <Input
                  id="gestion_final"
                  v-model="form.gestion_final"
                  type="number"
                  :class="form.errors.gestion_final ? 'border-red-500' : ''"
                />
                <p v-if="form.errors.gestion_final" class="text-sm text-red-500 mt-1">
                  {{ form.errors.gestion_final }}
                </p>
              </div>
            </div>

            <div>
              <Label for="modalidad_maestria_id">Modalidad</Label>
              <Select v-model="form.modalidad_maestria_id">
                <SelectTrigger :class="form.errors.modalidad_maestria_id ? 'border-red-500' : ''">
                  <SelectValue placeholder="Seleccione una modalidad" />
                </SelectTrigger>
                <SelectContent>
                  <SelectGroup>
                    <SelectLabel>Modalidades</SelectLabel>
                    <SelectItem
                      v-for="modalidad in modalidades"
                      :key="modalidad.id"
                      :value="String(modalidad.id)"
                    >
                      {{ modalidad.nombre }}
                    </SelectItem>
                  </SelectGroup>
                </SelectContent>
              </Select>
              <p v-if="form.errors.modalidad_maestria_id" class="text-sm text-red-500 mt-1">
                {{ form.errors.modalidad_maestria_id }}
              </p>
            </div>

            <div class="grid grid-cols-2 gap-4">
              <div>
                <Label for="horas_academicas">Horas Académicas / Créditos</Label>
                <Input
                  id="horas_academicas"
                  v-model="form.horas_academicas"
                  type="number"
                  :class="form.errors.horas_academicas ? 'border-red-500' : ''"
                />
                <p v-if="form.errors.horas_academicas" class="text-sm text-red-500 mt-1">
                  {{ form.errors.horas_academicas }}
                </p>
              </div>
              <div>
                <Label for="defensa_final">Defensa Final (0-100)</Label>
                <Input
                  id="defensa_final"
                  v-model="form.defensa_final"
                  type="number"
                  min="0"
                  max="100"
                  :class="form.errors.defensa_final ? 'border-red-500' : ''"
                />
                <p v-if="form.errors.defensa_final" class="text-sm text-red-500 mt-1">
                  {{ form.errors.defensa_final }}
                </p>
              </div>
            </div>

            <div>
              <Label for="observaciones">Observaciones (opcional)</Label>
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

      <div class="space-y-6">
        <Card class="flex-1">
          <CardHeader>
            <CardTitle class="flex items-center">
              <FileText class="h-5 w-5 mr-2" />
              Vista Previa del Documento
            </CardTitle>
          </CardHeader>
          <CardContent>
            <div v-if="maestria.file_dir" class="space-y-4">
              <iframe
                :src="route('maestrias.pdf', maestria.id)"
                class="w-full h-[500px] border rounded-md"
                title="Documento de la maestría"
              ></iframe>
              <p class="text-xs text-muted-foreground text-center">
                Documento actual. Si sube uno nuevo, este será reemplazado.
              </p>
            </div>
            <div v-else class="text-center py-16">
              <FileText class="h-16 w-16 text-muted-foreground mx-auto mb-4" />
              <h3 class="text-lg font-medium mb-2">Sin documento PDF</h3>
              <p class="text-muted-foreground text-sm">
                Esta maestría no tiene un archivo PDF. Puede subir uno usando el formulario.
              </p>
            </div>
          </CardContent>
        </Card>

        <Card>
          <CardHeader>
            <CardTitle class="flex items-center">
              <FileText class="h-5 w-5 mr-2" />
              Actualizar Documento PDF
            </CardTitle>
            <CardDescription>Opcional: arrastra un nuevo archivo o haz clic para seleccionar.</CardDescription>
          </CardHeader>
          <CardContent>
            <div v-if="!newPdfFile" class="space-y-4">
              <div
                ref="dropZoneRef"
                :class="dropZoneClasses"
                @click="() => openFileDialog()"
              >
                <div class="flex flex-col items-center space-y-3">
                  <Upload class="h-12 w-12 text-muted-foreground" />
                  <div class="space-y-1 text-center">
                    <p class="font-medium">Arrastra tu archivo PDF aquí</p>
                    <p class="text-sm text-muted-foreground">o haz clic para seleccionar</p>
                    <p class="text-xs text-muted-foreground">Solo PDF • Máximo 50MB</p>
                  </div>
                </div>
              </div>
              <p class="text-xs text-muted-foreground text-center">
                Si no seleccionas un archivo, se mantendrá el documento actual.
              </p>
            </div>

            <div v-if="newPdfFile" class="space-y-4">
              <div class="flex items-center justify-between p-4 bg-accent/30 rounded-lg border">
                <div class="flex items-center space-x-3">
                  <FileText class="h-8 w-8 text-primary" />
                  <div>
                    <p class="font-medium text-sm">{{ newPdfFile.name }}</p>
                    <p class="text-xs text-muted-foreground">{{ formatFileSize(newPdfFile.size) }}</p>
                  </div>
                </div>
                <div class="flex space-x-2">
                  <Button variant="outline" size="sm" @click="replaceFile">
                    <RefreshCw class="h-3 w-3 mr-1" />
                    Cambiar
                  </Button>
                  <Button variant="outline" size="sm" @click="removeFile">
                    <X class="h-3 w-3 mr-1" />
                    Quitar
                  </Button>
                </div>
              </div>

              <div v-if="newPdfUrl" class="border rounded-lg overflow-hidden">
                <iframe
                  :src="newPdfUrl"
                  class="w-full h-[300px]"
                  title="Vista previa del nuevo archivo PDF"
                ></iframe>
              </div>
            </div>

            <div v-if="fileError" class="mt-4">
              <div class="flex items-center space-x-2 text-red-600 bg-red-50 p-3 rounded-lg">
                <AlertCircle class="h-4 w-4" />
                <p class="text-sm">{{ fileError }}</p>
              </div>
            </div>

            <p v-if="form.errors.file" class="text-sm text-red-500 mt-2">
              {{ form.errors.file }}
            </p>
          </CardContent>
        </Card>
      </div>
    </div>

    <div class="flex justify-between pt-6 border-t">
      <Button variant="outline" as="a" :href="route('maestrias.show', maestria.id)">
        <X class="h-4 w-4 mr-2" />
        Cancelar
      </Button>

      <Button
        type="submit"
        :disabled="form.processing"
        @click="updateMaestria"
      >
        <span v-if="form.processing">Guardando...</span>
        <span v-else>
          <Save class="h-4 w-4 mr-2" />
          Guardar Cambios
        </span>
      </Button>
    </div>
  </div>
</template>

<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3'
import { ref, computed, watchEffect } from 'vue'
import { useDropZone, useFileDialog, useObjectUrl } from '@vueuse/core'
import AppLayout from '@/Layouts/AppLayout.vue'
import navTabs from './navtabs.json'
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
  Save,
  Upload,
  RefreshCw,
  AlertCircle
} from 'lucide-vue-next'
import type {
  Maestria,
  MencionMaestria,
  ModalidadMaestria
} from '@/types/titulos/maestria'
import type { MencionTpn } from '@/types/titulos/titulo-provision-nacional'
import { toast } from 'vue-sonner'

defineOptions({
  layout: (h: any, page: any) => h(AppLayout, {
    title: 'Editar Maestría',
    pageTitle: 'Editar Maestría',
    navTabs,
    activeTab: 'lista'
  }, () => page)
})

const props = defineProps<{
  maestria: Maestria
  menciones: MencionMaestria[]
  modalidades: ModalidadMaestria[]
  mencionesTpn: MencionTpn[]
}>()

const form = useForm({
  ci: props.maestria.ci ?? '',
  nombres: props.maestria.persona?.nombres ?? '',
  paterno: props.maestria.persona?.paterno ?? '',
  materno: props.maestria.persona?.materno ?? '',
  nro_tpn: props.maestria.nro_tpn ?? '',
  mencion_tpn_id: props.maestria.mencion_tpn_id ? String(props.maestria.mencion_tpn_id) : '',
  nro_documento: props.maestria.nro_documento ?? '',
  fojas: props.maestria.fojas ?? '',
  libro: props.maestria.libro ?? '',
  fecha_emision: props.maestria.fecha_emision ?? '',
  mencion_maestria_id: props.maestria.mencion_maestria_id ? String(props.maestria.mencion_maestria_id) : '',
  gestion_inicial: props.maestria.gestion_inicial ?? '',
  gestion_final: props.maestria.gestion_final ?? '',
  modalidad_maestria_id: props.maestria.modalidad_maestria_id ? String(props.maestria.modalidad_maestria_id) : '',
  horas_academicas: props.maestria.horas_academicas ?? '',
  defensa_final: props.maestria.defensa_final ?? '',
  observaciones: props.maestria.observaciones ?? '',
  file: null as File | null,
  _method: 'patch'
})

const newPdfFile = ref<File | null>(null)
const fileError = ref('')
const dropZoneRef = ref<HTMLElement>()

const { isOverDropZone } = useDropZone(dropZoneRef, {
  onDrop: (files) => {
    const file = files?.[0]
    if (file) processFile(file)
  }
})

const { files, open: openFileDialog } = useFileDialog({
  accept: '.pdf',
  multiple: false
})

const newPdfUrl = useObjectUrl(newPdfFile)

const dropZoneClasses = computed(() => {
  const base = 'border-2 border-dashed rounded-lg p-8 text-center transition-all duration-200 cursor-pointer min-h-[160px] flex items-center justify-center'
  const state = isOverDropZone.value
    ? 'border-primary bg-primary/5'
    : 'border-border hover:border-primary/50 hover:bg-accent/30'
  return `${base} ${state}`
})

const validateFile = (file: File): string => {
  if (file.type !== 'application/pdf') return 'Solo se permiten archivos PDF'
  if (file.size > 50 * 1024 * 1024) return 'El archivo debe ser menor a 50MB'
  return ''
}

const formatFileSize = (bytes: number): string => {
  return bytes < 1024 * 1024
    ? `${(bytes / 1024).toFixed(1)} KB`
    : `${(bytes / (1024 * 1024)).toFixed(1)} MB`
}

const processFile = (file: File) => {
  const validationError = validateFile(file)
  if (validationError) {
    fileError.value = validationError
    return
  }

  fileError.value = ''
  newPdfFile.value = file
  form.file = file
}

const replaceFile = () => {
  openFileDialog()
}

const removeFile = () => {
  newPdfFile.value = null
  fileError.value = ''
  form.file = null
}

const normalizePayload = (data: Record<string, any>) => {
  const payload = { ...data }
  const numericFields = [
    'mencion_tpn_id',
    'mencion_maestria_id',
    'modalidad_maestria_id',
    'gestion_inicial',
    'gestion_final',
    'horas_academicas',
    'defensa_final',
    'fojas',
    'libro',
    'nro_documento'
  ]

  numericFields.forEach((field) => {
    if (payload[field] === '' || payload[field] === null || payload[field] === undefined) {
      payload[field] = null
    } else {
      payload[field] = Number(payload[field])
    }
  })

  return payload
}

const updateMaestria = () => {
  form
    .transform((data) => normalizePayload(data))
    .post(route('maestrias.update', props.maestria.id), {
      forceFormData: true,
      onSuccess: () => {
        toast.success('Maestría actualizada exitosamente.')
      },
      onError: (errors) => {
        console.log('Validation errors:', errors)
        toast.error('Error al actualizar la maestría. Revise los campos marcados.')
      }
    })
}

watchEffect(() => {
  const file = files.value?.[0]
  if (file) {
    processFile(file)
    files.value = null
  }
})
</script>
