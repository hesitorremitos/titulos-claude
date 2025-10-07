<template>
  <Head :title="`Editar Especialidad - ${especialidad.persona?.nombres ?? ''} ${especialidad.persona?.paterno ?? ''}`" />
  <div class="space-y-6">
    <div class="border-b pb-4">
      <h1 class="text-2xl font-semibold text-foreground">
        Editar: {{ especialidad.persona?.nombres }} {{ especialidad.persona?.paterno }}
      </h1>
      <p class="text-muted-foreground mt-1">
        CI: {{ especialidad.ci }} • Documento N° {{ especialidad.nro_documento }}
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
              Datos de la Especialidad
            </CardTitle>
            <CardDescription>Modifique los datos específicos de la especialidad.</CardDescription>
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
                    <SelectValue placeholder="Seleccione una mención de TPN" />
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
                <Label for="sexo">Sexo</Label>
                <Select v-model="form.sexo">
                  <SelectTrigger :class="form.errors.sexo ? 'border-red-500' : ''">
                    <SelectValue placeholder="Seleccione sexo" />
                  </SelectTrigger>
                  <SelectContent>
                    <SelectGroup>
                      <SelectItem value="Femenino">Femenino</SelectItem>
                      <SelectItem value="Masculino">Masculino</SelectItem>
                      <SelectItem value="Otro">Otro</SelectItem>
                    </SelectGroup>
                  </SelectContent>
                </Select>
                <p v-if="form.errors.sexo" class="text-sm text-red-500 mt-1">
                  {{ form.errors.sexo }}
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
                <Label for="mencion_especialidad_id">Mención</Label>
                <Select v-model="form.mencion_especialidad_id">
                  <SelectTrigger :class="form.errors.mencion_especialidad_id ? 'border-red-500' : ''">
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
                <p v-if="form.errors.mencion_especialidad_id" class="text-sm text-red-500 mt-1">
                  {{ form.errors.mencion_especialidad_id }}
                </p>
              </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
              <div>
                <Label for="gestion">Gestión</Label>
                <Input
                  id="gestion"
                  v-model="form.gestion"
                  type="number"
                  :class="form.errors.gestion ? 'border-red-500' : ''"
                />
                <p v-if="form.errors.gestion" class="text-sm text-red-500 mt-1">
                  {{ form.errors.gestion }}
                </p>
              </div>
              <div>
                <Label for="version">Versión (opcional)</Label>
                <Input
                  id="version"
                  v-model="form.version"
                  type="number"
                  :class="form.errors.version ? 'border-red-500' : ''"
                />
                <p v-if="form.errors.version" class="text-sm text-red-500 mt-1">
                  {{ form.errors.version }}
                </p>
              </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
              <div>
                <Label for="modalidad_especialidad_id">Modalidad</Label>
                <Select v-model="form.modalidad_especialidad_id">
                  <SelectTrigger :class="form.errors.modalidad_especialidad_id ? 'border-red-500' : ''">
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
                <p v-if="form.errors.modalidad_especialidad_id" class="text-sm text-red-500 mt-1">
                  {{ form.errors.modalidad_especialidad_id }}
                </p>
              </div>
              <div>
                <Label for="horas_academicas">Horas Académicas</Label>
                <Input
                  id="horas_academicas"
                  v-model="form.horas_academicas"
                  placeholder="Formato: 120/240"
                  @input="onHorasInput"
                  :class="form.errors.horas_academicas ? 'border-red-500' : ''"
                />
                <p class="text-xs text-muted-foreground mt-1">Usa el formato horas cursadas/horas totales.</p>
                <p v-if="form.errors.horas_academicas" class="text-sm text-red-500 mt-1">
                  {{ form.errors.horas_academicas }}
                </p>
              </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
              <div>
                <Label for="universidad_id">Universidad</Label>
                <Select v-model="form.universidad_id">
                  <SelectTrigger :class="form.errors.universidad_id ? 'border-red-500' : ''">
                    <SelectValue placeholder="Seleccione una universidad" />
                  </SelectTrigger>
                  <SelectContent>
                    <SelectGroup>
                      <SelectLabel>Universidades</SelectLabel>
                      <SelectItem
                        v-for="universidad in universidades"
                        :key="universidad.id"
                        :value="String(universidad.id)"
                      >
                        {{ universidad.sigla ? `${universidad.sigla} - ${universidad.nombre}` : universidad.nombre }}
                      </SelectItem>
                    </SelectGroup>
                  </SelectContent>
                </Select>
                <p v-if="form.errors.universidad_id" class="text-sm text-red-500 mt-1">
                  {{ form.errors.universidad_id }}
                </p>
              </div>
              <div class="flex items-center space-x-2 pt-6">
                <Switch id="promedio_final" v-model:checked="form.promedio_final" />
                <Label for="promedio_final">Promedio final registrado</Label>
              </div>
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
            <div v-if="especialidad.file_dir" class="space-y-4">
              <iframe
                :src="route('especialidades.pdf', especialidad.id)"
                class="w-full h-[500px] border rounded-md"
                title="Documento de la especialidad"
              ></iframe>
              <p class="text-xs text-muted-foreground text-center">
                Documento actual. Si sube uno nuevo, este será reemplazado.
              </p>
            </div>
            <div v-else class="text-center py-16">
              <FileText class="h-16 w-16 text-muted-foreground mx-auto mb-4" />
              <h3 class="text-lg font-medium mb-2">Sin documento PDF</h3>
              <p class="text-muted-foreground text-sm">
                Esta especialidad no tiene un archivo PDF. Puede subir uno usando el formulario.
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
          </CardContent>
        </Card>
      </div>
    </div>

    <div class="flex justify-between pt-6 border-t">
      <Button variant="outline" as="a" :href="route('especialidades.show', especialidad.id)">
        <X class="h-4 w-4 mr-2" />
        Cancelar
      </Button>

      <Button
        type="submit"
        :disabled="form.processing"
        @click="updateEspecialidad"
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
  Especialidad,
  MencionEspecialidad,
  ModalidadEspecialidad,
  Universidad
} from '@/types/titulos/especialidad'
import type { MencionTpn } from '@/types/titulos/titulo-provision-nacional'
import { Switch } from '@/components/ui/switch'
import { toast } from 'vue-sonner'

defineOptions({
  layout: (h: any, page: any) => h(AppLayout, {
    title: 'Editar Especialidad',
    pageTitle: 'Editar Especialidad',
    navTabs,
    activeTab: 'lista'
  }, () => page)
})

const props = defineProps<{
  especialidad: Especialidad
  menciones: MencionEspecialidad[]
  modalidades: ModalidadEspecialidad[]
  mencionesTpn: MencionTpn[]
  universidades: Universidad[]
}>()

const form = useForm({
  ci: props.especialidad.ci ?? '',
  nombres: props.especialidad.persona?.nombres ?? '',
  paterno: props.especialidad.persona?.paterno ?? '',
  materno: props.especialidad.persona?.materno ?? '',
  nro_tpn: props.especialidad.nro_tpn ?? '',
  mencion_tpn_id: props.especialidad.mencion_tpn_id ? String(props.especialidad.mencion_tpn_id) : '',
  sexo: props.especialidad.sexo ?? '',
  nro_documento: props.especialidad.nro_documento ?? '',
  fojas: props.especialidad.fojas ?? '',
  libro: props.especialidad.libro ?? '',
  fecha_emision: props.especialidad.fecha_emision ?? '',
  mencion_especialidad_id: props.especialidad.mencion_especialidad_id ? String(props.especialidad.mencion_especialidad_id) : '',
  gestion: props.especialidad.gestion ?? '',
  version: props.especialidad.version ?? '',
  modalidad_especialidad_id: props.especialidad.modalidad_especialidad_id ? String(props.especialidad.modalidad_especialidad_id) : '',
  horas_academicas: props.especialidad.horas_academicas ?? '',
  promedio_final: props.especialidad.promedio_final ?? false,
  universidad_id: props.especialidad.universidad_id ? String(props.especialidad.universidad_id) : '',
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

const onHorasInput = (event: Event) => {
  const input = event.target as HTMLInputElement
  const value = input.value
  const sanitized = value.replace(/[^0-9/]/g, '')
  const parts = sanitized.split('/').slice(0, 2)
  const limited = parts
    .map((part) => part.slice(0, 4))
    .join(parts.length > 1 ? '/' : '')
  form.horas_academicas = limited
  if (input.value !== limited) {
    input.value = limited
  }
}

const normalizePayload = (data: Record<string, any>) => {
  const payload = { ...data }
  const numericFields = [
    'mencion_especialidad_id',
    'modalidad_especialidad_id',
    'mencion_tpn_id',
    'gestion',
    'version',
    'fojas',
    'libro',
    'nro_documento',
    'universidad_id'
  ]

  numericFields.forEach((field) => {
    if (payload[field] === '' || payload[field] === null || payload[field] === undefined) {
      payload[field] = null
    } else {
      payload[field] = Number(payload[field])
    }
  })

  payload.promedio_final = ['1', 1, 'true', true, 'on'].includes(payload.promedio_final)

  return payload
}

const updateEspecialidad = () => {
  form
    .transform((data) => normalizePayload(data))
    .post(route('especialidades.update', props.especialidad.id), {
      forceFormData: true,
      onSuccess: () => {
        toast.success('Especialidad actualizada exitosamente.')
      },
      onError: (errors) => {
        console.log('Validation errors:', errors)
        toast.error('Error al actualizar la especialidad. Revise los campos marcados.')
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
