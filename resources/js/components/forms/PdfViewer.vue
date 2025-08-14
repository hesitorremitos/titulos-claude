<template>
  <Card class="w-full">
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
        @drop.prevent="handleDrop"
        @dragover.prevent="isDragOver = true"
        @dragleave="isDragOver = false"
        :class="[
          'border-2 border-dashed rounded-lg p-8 text-center transition-all duration-200 cursor-pointer',
          isDragOver 
            ? 'border-primary bg-primary/5' 
            : 'border-border hover:border-primary/50 hover:bg-accent/30'
        ]"
        @click="fileInput?.click()"
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
          <div class="flex items-center space-x-2">
            <Button variant="outline" size="sm" @click="downloadFile">
              <Download class="h-3 w-3 mr-1" />
              Descargar
            </Button>
            <Button variant="outline" size="sm" @click="replaceFile">
              <RefreshCw class="h-3 w-3 mr-1" />
              Cambiar
            </Button>
          </div>
        </div>

        <!-- PDF Viewer nativo -->
        <div class="border rounded-lg overflow-hidden bg-white">
          <iframe
            v-if="pdfUrl"
            :src="pdfUrl"
            class="w-full h-[600px]"
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

      <!-- Hidden File Input -->
      <input
        ref="fileInput"
        type="file"
        accept=".pdf"
        @change="handleFileSelect"
        class="hidden"
      />
    </CardContent>
  </Card>
</template>

<script setup lang="ts">
import { ref, computed, watch, onUnmounted } from 'vue'
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card'
import { Button } from '@/components/ui/button'
import { Badge } from '@/components/ui/badge'
import { Alert, AlertDescription } from '@/components/ui/alert'
import { 
  FileText, 
  Upload, 
  Download, 
  RefreshCw, 
  AlertCircle 
} from 'lucide-vue-next'

// Props
interface Props {
  modelValue?: File | null
}

const props = defineProps<Props>()

// Emits
const emit = defineEmits<{
  'update:modelValue': [file: File | null]
}>()

// Refs
const fileInput = ref<HTMLInputElement>()
const isDragOver = ref(false)
const pdfFile = ref<File | null>(props.modelValue || null)
const error = ref('')
const pdfUrl = ref('')

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

const handleFileSelect = (event: Event) => {
  const file = (event.target as HTMLInputElement).files?.[0]
  if (file) processFile(file)
}

const handleDrop = (event: DragEvent) => {
  isDragOver.value = false
  const file = event.dataTransfer?.files[0]
  if (file) processFile(file)
}

const processFile = (file: File) => {
  const validationError = validateFile(file)
  if (validationError) {
    error.value = validationError
    return
  }
  
  error.value = ''
  
  // Cleanup old URL if exists
  if (pdfUrl.value) {
    URL.revokeObjectURL(pdfUrl.value)
  }
  
  // Create new URL
  pdfUrl.value = URL.createObjectURL(file)
  pdfFile.value = file
  emit('update:modelValue', file)
}

const replaceFile = () => {
  // Cleanup old URL
  if (pdfUrl.value) {
    URL.revokeObjectURL(pdfUrl.value)
    pdfUrl.value = ''
  }
  
  pdfFile.value = null
  error.value = ''
  emit('update:modelValue', null)
}

const downloadFile = () => {
  if (pdfFile.value && pdfUrl.value) {
    const a = document.createElement('a')
    a.href = pdfUrl.value
    a.download = pdfFile.value.name
    document.body.appendChild(a)
    a.click()
    document.body.removeChild(a)
  }
}

// Watch for external changes
watch(() => props.modelValue, (newFile) => {
  if (newFile !== pdfFile.value) {
    // Cleanup old URL if exists
    if (pdfUrl.value) {
      URL.revokeObjectURL(pdfUrl.value)
      pdfUrl.value = ''
    }
    
    if (newFile) {
      pdfUrl.value = URL.createObjectURL(newFile)
      pdfFile.value = newFile
    } else {
      pdfFile.value = null
    }
  }
})

// Cleanup on unmount
onUnmounted(() => {
  if (pdfUrl.value) {
    URL.revokeObjectURL(pdfUrl.value)
  }
})
</script>