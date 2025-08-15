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
      <!-- Drop Zone -->
      <div
        ref="dropZoneRef"
        v-if="!pdfFile"
        :class="[
          'border-2 border-dashed rounded-lg p-8 text-center transition-all duration-200 cursor-pointer',
          isOverDropZone
            ? 'border-primary bg-primary/5'
            : 'border-border hover:border-primary/50 hover:bg-accent/30',
        ]"
        @click="open"
      >
        <div class="flex flex-col items-center space-y-4">
          <Upload class="h-8 w-8 text-muted-foreground" />
          <div class="space-y-2">
            <p class="font-medium">Arrastra tu archivo PDF aquí</p>
            <p class="text-sm text-muted-foreground">
              o haz clic para seleccionar
            </p>
            <p class="text-xs text-muted-foreground">Solo PDF • Máximo 50MB</p>
          </div>
        </div>
      </div>

      <!-- PDF Viewer -->
      <div v-else class="space-y-4">
        <!-- Toolbar -->
        <div class="flex items-center justify-between p-3 bg-accent/30 rounded-lg">
          <div class="flex items-center space-x-2">
            <FileText class="h-4 w-4 text-muted-foreground" />
            <span class="text-sm font-medium truncate max-w-xs">{{ pdfFile.name }}</span>
          </div>
          <div class="flex items-center space-x-4">
            <div class="text-sm font-medium">
              Página {{ currentPage }} / {{ numPages }}
            </div>
            <div class="flex items-center space-x-2">
              <Button variant="outline" size="sm" @click="replaceFile">
                <RefreshCw class="h-3 w-3 mr-1" />
                Cambiar
              </Button>
            </div>
          </div>
        </div>

        <!-- PDF.js Renderer -->
        <div
          ref="viewerContainerRef"
          class="border rounded-lg overflow-auto bg-gray-200 h-[600px] cursor-grab active:cursor-grabbing"
          style="touch-action: none;"
        >
          <div class="space-y-4 p-4">
            <canvas
              v-for="pageNumber in numPages"
              :key="pageNumber"
              :ref="el => setCanvasRef(el, pageNumber)"
              class="mx-auto"
            ></canvas>
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
import { ref, computed, watch, onUnmounted } from 'vue'
import { useDropZone, useFileDialog, usePointerPan, useIntersectionObserver } from '@vueuse/core'
import * as pdfjsLib from 'pdfjs-dist'
import pdfjsWorker from 'pdfjs-dist/build/pdf.worker.min.mjs?url'

import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card'
import { Button } from '@/components/ui/button'
import { Badge } from '@/components/ui/badge'
import { Alert, AlertDescription } from '@/components/ui/alert'
import { FileText, Upload, RefreshCw, AlertCircle } from 'lucide-vue-next'

// Set PDF.js worker
pdfjsLib.GlobalWorkerOptions.workerSrc = pdfjsWorker

// Props & Emits
interface Props {
  modelValue?: File | null
}
const props = defineProps<Props>()
const emit = defineEmits<{
  'update:modelValue': [file: File | null]
}>()

// Refs for UI elements
const dropZoneRef = ref<HTMLDivElement>()
const viewerContainerRef = ref<HTMLDivElement>()
const canvasRefs = new Map<number, HTMLCanvasElement>()
const intersectionObserverMap = new Map<number, () => void>()

// State
const pdfFile = ref<File | null>(props.modelValue || null)
const error = ref('')
const pdfDoc = ref<pdfjsLib.PDFDocumentProxy | null>(null)
const numPages = ref(0)
const currentPage = ref(1)
const renderedPages = new Set<number>()

// useVueUse hooks
const { open, onChange } = useFileDialog({ accept: '.pdf' })
const { isOverDropZone } = useDropZone(dropZoneRef, { onDrop: handleFiles })

usePointerPan(viewerContainerRef, {
  onPan(e) {
    if (!viewerContainerRef.value) return
    viewerContainerRef.value.scrollTop -= e.y
    viewerContainerRef.value.scrollLeft -= e.x
  },
})

// Computed properties
const fileSize = computed(() => {
  if (!pdfFile.value) return ''
  const size = pdfFile.value.size
  return size < 1024 * 1024
    ? `${(size / 1024).toFixed(1)} KB`
    : `${(size / (1024 * 1024)).toFixed(1)} MB`
})

// File Handling
function handleFiles(files: File[] | null) {
  if (!files || files.length === 0) return
  processFile(files[0])
}

onChange((files) => {
  if (files && files.length > 0) {
    processFile(files[0])
  }
})

const validateFile = (file: File): string => {
  if (file.type !== 'application/pdf') return 'Solo se permiten archivos PDF'
  if (file.size > 50 * 1024 * 1024) return 'El archivo debe ser menor a 50MB'
  return ''
}

const resetState = () => {
  pdfFile.value = null
  pdfDoc.value = null
  numPages.value = 0
  currentPage.value = 1

  // Stop and clear observers
  intersectionObserverMap.forEach(stop => stop());
  intersectionObserverMap.clear();

  canvasRefs.clear()
  renderedPages.clear()
}

const processFile = async (file: File) => {
  resetState()
  const validationError = validateFile(file)
  if (validationError) {
    error.value = validationError
    return
  }
  error.value = ''
  pdfFile.value = file
  emit('update:modelValue', file)

  try {
    const arrayBuffer = await file.arrayBuffer()
    const loadingTask = pdfjsLib.getDocument(arrayBuffer)
    pdfDoc.value = await loadingTask.promise
    numPages.value = pdfDoc.value.numPages
  } catch (e) {
    console.error('Error loading PDF:', e)
    error.value = 'No se pudo cargar el archivo PDF. Puede que esté dañado.'
    resetState()
    emit('update:modelValue', null)
  }
}

const replaceFile = () => {
  resetState()
  emit('update:modelValue', null)
}

const setCanvasRef = (el: Element | null, pageNumber: number) => {
  if (el instanceof HTMLCanvasElement) {
    canvasRefs.set(pageNumber, el)

    const { stop } = useIntersectionObserver(
      el,
      ([{ isIntersecting }]) => {
        if (isIntersecting) {
          renderPage(pageNumber)
          currentPage.value = pageNumber
        }
      },
      { root: viewerContainerRef.value }
    )
    intersectionObserverMap.set(pageNumber, stop);
  }
}

const renderPage = async (pageNumber: number) => {
  if (!pdfDoc.value || renderedPages.has(pageNumber)) return
  const canvas = canvasRefs.get(pageNumber)
  if (!canvas) return

  renderedPages.add(pageNumber)

  try {
    const page = await pdfDoc.value.getPage(pageNumber)
    const viewport = page.getViewport({ scale: 1.5 })
    
    canvas.height = viewport.height
    canvas.width = viewport.width
    canvas.style.height = `${Math.floor(viewport.height)}px`
    canvas.style.width = `${Math.floor(viewport.width)}px`
    canvas.style.backgroundColor = 'white'

    const context = canvas.getContext('2d')
    if (!context) return

    const renderContext = {
      canvasContext: context,
      viewport: viewport,
    }
    await page.render(renderContext).promise
  } catch (e) {
    console.error(`Error rendering page ${pageNumber}:`, e)
  }
}

// Watch for external changes to modelValue
watch(() => props.modelValue, (newFile, oldFile) => {
  if (newFile && newFile !== oldFile) {
    processFile(newFile)
  } else if (!newFile && oldFile) {
    replaceFile()
  }
})

onUnmounted(() => {
  resetState();
})

// Initial load if modelValue is present
if (props.modelValue) {
  processFile(props.modelValue)
}
</script>