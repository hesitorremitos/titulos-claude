<template>
  <Card :class="cardClasses">
    <CardHeader class="pb-3">
      <CardTitle class="flex items-center justify-between">
        <div class="flex items-center space-x-2">
          <FileText class="h-5 w-5" />
          <span>Documento PDF</span>
        </div>
        <Badge v-if="pdfFile" variant="secondary" class="text-xs">
          {{ fileSize }}
        </Badge>
      </CardTitle>
    </CardHeader>
    <CardContent>
      <!-- Drag & Drop Zone -->
      <div
        v-if="!pdfFile"
        ref="dropZoneRef"
        :class="dropZoneClasses"
        @click="() => openFileDialog()"
      >
        <div class="flex flex-col items-center space-y-4">
          <Upload class="h-8 w-8 text-muted-foreground" />
          <div class="space-y-2">
            <p class="font-medium">Arrastra tu archivo PDF aquí</p>
            <p class="text-sm text-muted-foreground">o haz clic para seleccionar</p>
            <p class="text-xs text-muted-foreground">Solo PDF • Máximo 50MB</p>
          </div>
        </div>
      </div>

      <!-- PDF Viewer con iframe nativo -->
      <div v-if="pdfFile" class="space-y-4">
        <!-- Toolbar -->
        <div class="flex items-center justify-between p-3 bg-accent/30 rounded-lg">
          <div class="flex items-center space-x-2">
            <FileText class="h-4 w-4 text-muted-foreground" />
            <span class="text-sm font-medium truncate max-w-xs">{{ pdfFile.name }}</span>
          </div>
          <Button variant="outline" size="sm" @click="replaceFile">
            <RefreshCw class="h-3 w-3 mr-1" />
            Cambiar
          </Button>
        </div>

        <!-- PDF Viewer nativo -->
        <div class="border rounded-lg overflow-hidden bg-white">
          <iframe
            v-if="pdfUrl"
            :src="pdfUrl"
            :class="viewerClasses"
            frameborder="0"
            title="Visor de PDF"
          ></iframe>
          <div v-else class="flex items-center justify-center h-96 bg-accent/20">
            <div class="text-center space-y-2">
              <AlertCircle class="h-8 w-8 mx-auto text-muted-foreground" />
              <p class="text-sm text-muted-foreground">Error al cargar el PDF</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Error Message -->
      <Alert v-if="error" variant="destructive" class="mt-4">
        <AlertCircle class="h-4 w-4" />
        <AlertDescription>{{ error }}</AlertDescription>
      </Alert>
    </CardContent>
  </Card>
</template>

<script setup lang="ts">
import { ref, computed, watchEffect } from 'vue'
import { useDropZone, useFileDialog, useObjectUrl } from '@vueuse/core'
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card'
import { Button } from '@/components/ui/button'
import { Badge } from '@/components/ui/badge'
import { Alert, AlertDescription } from '@/components/ui/alert'
import { 
  FileText, 
  Upload, 
  RefreshCw, 
  AlertCircle 
} from 'lucide-vue-next'

// Props - simplified without variants
interface Props {}

const props = defineProps<Props>()

// Define model for v-model
const pdfFile = defineModel<File | null>({ default: null })

// Emits agnósticos - sin lógica de negocio específica
const emit = defineEmits<{
  'file-selected': [file: File]
  'file-removed': []
  'filename-changed': [filename: string]
}>()

// State
const error = ref('')

// VueUse composables
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

const pdfUrl = useObjectUrl(pdfFile)

// Computed classes - fixed sizes
const cardClasses = computed(() => 'w-full')
const viewerClasses = computed(() => 'w-full h-[600px]')

const dropZoneClasses = computed(() => {
  const baseClasses = 'border-2 border-dashed rounded-lg p-8 text-center transition-all duration-200 cursor-pointer'
  const stateClasses = isOverDropZone.value 
    ? 'border-primary bg-primary/5' 
    : 'border-border hover:border-primary/50 hover:bg-accent/30'
  return `${baseClasses} ${stateClasses}`
})

// File size display
const fileSize = computed(() => {
  if (!pdfFile.value) return ''
  const size = pdfFile.value.size
  return size < 1024 * 1024 
    ? `${(size / 1024).toFixed(1)} KB` 
    : `${(size / (1024 * 1024)).toFixed(1)} MB`
})

// File handling
const validateFile = (file: File): string => {
  if (file.type !== 'application/pdf') return 'Solo se permiten archivos PDF'
  if (file.size > 50 * 1024 * 1024) return 'El archivo debe ser menor a 50MB'
  return ''
}

const processFile = (file: File) => {
  const validationError = validateFile(file)
  if (validationError) {
    error.value = validationError
    return
  }
  
  error.value = ''
  pdfFile.value = file
  
  // Emit events for external handling
  emit('file-selected', file)
  emit('filename-changed', file.name)
}

const replaceFile = () => {
  pdfFile.value = null
  error.value = ''
  
  // Emit file removal event
  emit('file-removed')
}


// Watch file dialog changes with watchEffect
watchEffect(() => {
  const file = files.value?.[0]
  if (file) {
    processFile(file)
    // Clear files to allow selecting the same file again
    files.value = null
  }
})
</script>