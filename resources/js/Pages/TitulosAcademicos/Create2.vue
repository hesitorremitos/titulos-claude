<template>
  <div class="container mx-auto p-6 max-w-7xl">
    <!-- Header Steps using Stepper component -->
    <div class="mb-8 flex justify-center">
      <Stepper v-model="currentStep" class="w-full max-w-md">
        <StepperItem :step="1" class="w-full">
          <StepperTrigger class="w-full">
            <StepperIndicator>
              <User :size="16" />
            </StepperIndicator>
            <div class="flex flex-col text-left">
              <StepperTitle>Datos Personales</StepperTitle>
              <StepperDescription>Información del graduado</StepperDescription>
            </div>
          </StepperTrigger>
          <StepperSeparator />
        </StepperItem>
        
        <StepperItem :step="2" class="w-full">
          <StepperTrigger class="w-full">
            <StepperIndicator>
              <FileText :size="16" />
            </StepperIndicator>
            <div class="flex flex-col text-left">
              <StepperTitle>Datos del Título</StepperTitle>
              <StepperDescription>Información del título académico</StepperDescription>
            </div>
          </StepperTrigger>
        </StepperItem>
      </Stepper>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
      <!-- Left Column: Form Content -->
      <div class="lg:col-span-2 space-y-6">
        
        <!-- Step 1: Personal Data -->
        <Card v-if="currentStep === 1" class="px-6">
          <!-- CI Search Section -->
          <div class="space-y-4">
            <h3 class="text-lg font-semibold">Buscador por CI</h3>
            <div class="flex gap-3">
              <div class="flex-1">
                <Label for="search-ci">Carnet de Identidad</Label>
                <Input
                  id="search-ci"
                  v-model="searchCi"
                  placeholder="Ingrese CI para buscar"
                  class="mt-1"
                />
              </div>
              <div class="flex items-end">
                <Button 
                  @click="searchPersonInApi"
                  :disabled="!searchCi.trim() || isSearching"
                  variant="secondary"
                >
                  <SearchIcon v-if="!isSearching" class="h-4 w-4 mr-2" />
                  <Loader2 v-else class="h-4 w-4 mr-2 animate-spin" />
                  {{ isSearching ? 'Buscando...' : 'Buscar' }}
                </Button>
              </div>
            </div>
          </div>

          <Separator class="my-6" />

          <!-- Career Selection using RadioGroup -->
          <div v-if="apiResults.length > 0" class="space-y-4">
            <h3 class="text-lg font-semibold">Carreras Encontradas</h3>
            <RadioGroup v-model="selectedProgramValue" class="space-y-2">
              <div 
                v-for="(programa, index) in apiResults" 
                :key="index"
                class="flex items-center space-x-3 p-3 border rounded-md cursor-pointer hover:bg-accent/50 transition-colors"
                :class="selectedProgramValue === index.toString() ? 'border-primary bg-accent/30' : ''"
              >
                <RadioGroupItem :value="index.toString()" :id="`programa-${index}`" />
                <Label :for="`programa-${index}`" class="flex-1 cursor-pointer">
                  <div>
                    <p class="font-medium">{{ programa.programa }}</p>
                    <p class="text-sm text-muted-foreground">{{ programa.facultad || 'Sin facultad' }}</p>
                  </div>
                </Label>
              </div>
            </RadioGroup>
          </div>

          <div v-else class="space-y-4">
            <h3 class="text-lg font-semibold">Información Personal</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div class="space-y-2">
                <Label for="ci">Carnet de Identidad *</Label>
                <Input
                  id="ci"
                  v-model="personalData.ci"
                  placeholder="Ingrese CI"
                />
              </div>
              <div class="space-y-2">
                <Label for="nombres">Nombres Completos *</Label>
                <Input
                  id="nombres"
                  v-model="personalData.nombres"
                  placeholder="Nombres completos"
                />
              </div>
              <div class="space-y-2">
                <Label for="apellido-paterno">Apellido Paterno *</Label>
                <Input
                  id="apellido-paterno"
                  v-model="personalData.apellidoPaterno"
                  placeholder="Apellido paterno"
                />
              </div>
              <div class="space-y-2">
                <Label for="apellido-materno">Apellido Materno</Label>
                <Input
                  id="apellido-materno"
                  v-model="personalData.apellidoMaterno"
                  placeholder="Apellido materno"
                />
              </div>
              <div class="space-y-2">
                <Label for="pais">País *</Label>
                <Input
                  id="pais"
                  v-model="personalData.pais"
                  placeholder="País"
                  value="Bolivia"
                />
              </div>
            </div>
          </div>

          <div class="flex justify-end pt-6">
            <Button 
              @click="nextStep"
              :disabled="!isStep1Valid"
            >
              Continuar
              <ArrowRight class="h-4 w-4 ml-2" />
            </Button>
          </div>
        </Card>

        <!-- Step 2: Title Data -->
        <Card v-if="currentStep === 2" class="px-6">
          <div class="space-y-6">
            <h3 class="text-lg font-semibold">Datos del Título Académico</h3>
            
            <!-- Document Numbers -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
              <div class="space-y-2">
                <Label for="nro-documento">Número de Documento *</Label>
                <Input
                  id="nro-documento"
                  v-model="titleData.nroDocumento"
                  type="number"
                  placeholder="Ej: 123"
                />
              </div>
              <div class="space-y-2">
                <Label for="fojas">Fojas *</Label>
                <Input
                  id="fojas"
                  v-model="titleData.fojas"
                  type="number"
                  placeholder="Ej: 45"
                />
              </div>
              <div class="space-y-2">
                <Label for="libro">Libro *</Label>
                <Input
                  id="libro"
                  v-model="titleData.libro"
                  type="number"
                  placeholder="Ej: 2"
                />
              </div>
            </div>

            <!-- Academic Diploma Number -->
            <div class="space-y-2">
              <Label for="nro-diploma">Número de Diploma Académico *</Label>
              <Input
                id="nro-diploma"
                v-model="titleData.nroDiplomaAcademico"
                placeholder="Ej: DA-2024-001"
              />
            </div>

            <!-- Graduation Details -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div class="space-y-2">
                <Label for="modalidad">Modalidad de Graduación *</Label>
                <Select v-model="titleData.graduacionId">
                  <SelectTrigger>
                    <SelectValue placeholder="Seleccione modalidad" />
                  </SelectTrigger>
                  <SelectContent>
                    <SelectItem
                      v-for="modalidad in graduacionOptions"
                      :key="modalidad.id"
                      :value="modalidad.id.toString()"
                    >
                      {{ modalidad.medioGraduacion }}
                    </SelectItem>
                  </SelectContent>
                </Select>
              </div>
              <div class="space-y-2">
                <Label>Fecha de Emisión</Label>
                <Popover>
                  <PopoverTrigger as-child>
                    <Button
                      variant="outline"
                      class="w-full justify-start text-left font-normal"
                      :class="!titleData.fechaEmision && 'text-muted-foreground'"
                    >
                      <CalendarIcon class="mr-2 h-4 w-4" />
                      {{ titleData.fechaEmision ? new Date(titleData.fechaEmision).toLocaleDateString('es-ES') : 'Seleccione fecha' }}
                    </Button>
                  </PopoverTrigger>
                  <PopoverContent class="w-auto p-0">
                    <Calendar
                      v-model="selectedDate"
                      :max="todayValue"
                      @update:model-value="handleDateSelect"
                    />
                  </PopoverContent>
                </Popover>
              </div>
            </div>

            <!-- Observations -->
            <div class="space-y-2">
              <Label for="observaciones">Observaciones</Label>
              <Textarea
                id="observaciones"
                v-model="titleData.observaciones"
                placeholder="Observaciones adicionales (opcional)"
                rows="3"
              />
            </div>
          </div>

          <div class="flex justify-between pt-6">
            <Button 
              variant="outline"
              @click="previousStep"
            >
              <ArrowLeft class="h-4 w-4 mr-2" />
              Anterior
            </Button>
            <Button 
              @click="handleSubmit"
              :disabled="!isStep2Valid || isSubmitting"
            >
              <Save v-if="!isSubmitting" class="h-4 w-4 mr-2" />
              <Loader2 v-else class="h-4 w-4 mr-2 animate-spin" />
              {{ isSubmitting ? 'Guardando...' : 'Registrar Título' }}
            </Button>
          </div>
        </Card>
      </div>

      <!-- Right Column: PDF Upload & Viewer -->
      <div class="lg:col-span-1">
        <Card class="sticky top-6 px-6">
          <div class="space-y-4">
            <h3 class="text-lg font-semibold">Archivo PDF</h3>
            
            <!-- PDF Upload Area -->
            <div 
              class="border-2 border-dashed rounded-md p-6 text-center transition-colors hover:border-primary/50"
              :class="pdfFile ? 'border-primary bg-primary/5' : 'border-border'"
              @drop="handleDrop"
              @dragover.prevent
              @dragenter.prevent
            >
              <input
                ref="fileInput"
                type="file"
                accept=".pdf"
                @change="handleFileSelect"
                class="hidden"
              />
              
              <div v-if="!pdfFile && !isUploading" class="space-y-3">
                <div class="mx-auto w-12 h-12 bg-muted rounded-md flex items-center justify-center">
                  <Upload class="h-6 w-6 text-muted-foreground" />
                </div>
                <div>
                  <p class="text-sm font-medium">Arrastra el PDF aquí</p>
                  <p class="text-xs text-muted-foreground">o haz clic para seleccionar</p>
                </div>
                <Button 
                  variant="outline" 
                  size="sm"
                  @click="triggerFileInput"
                >
                  Seleccionar archivo
                </Button>
              </div>

              <div v-else-if="isUploading" class="space-y-3">
                <Loader2 class="h-8 w-8 mx-auto animate-spin text-primary" />
                <p class="text-sm font-medium">Cargando...</p>
              </div>

              <div v-else class="space-y-3">
                <div class="mx-auto w-12 h-12 bg-primary/10 rounded-md flex items-center justify-center">
                  <FileText class="h-6 w-6 text-primary" />
                </div>
                <div>
                  <p class="text-sm font-medium text-primary">{{ pdfFile.name }}</p>
                  <p class="text-xs text-muted-foreground">{{ formatFileSize(pdfFile.size) }}</p>
                </div>
                <Button 
                  variant="outline" 
                  size="sm"
                  @click="removeFile"
                >
                  <X class="h-4 w-4 mr-1" />
                  Remover
                </Button>
              </div>
            </div>

            <!-- PDF Viewer -->
            <div v-if="pdfUrl" class="mt-4">
              <iframe 
                :src="pdfUrl" 
                class="w-full h-96 border rounded-md"
                frameborder="0"
              ></iframe>
            </div>
          </div>
        </Card>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue'
import { Card } from '@/components/ui/card'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { Textarea } from '@/components/ui/textarea'
import { Separator } from '@/components/ui/separator'
import {
  Stepper,
  StepperDescription,
  StepperIndicator,
  StepperItem,
  StepperSeparator,
  StepperTitle,
  StepperTrigger,
} from '@/components/ui/stepper'
import {
  RadioGroup,
  RadioGroupItem,
} from '@/components/ui/radio-group'
import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from '@/components/ui/select'
import {
  Popover,
  PopoverContent,
  PopoverTrigger,
} from '@/components/ui/popover'
import { Calendar } from '@/components/ui/calendar'
import {
  SearchIcon,
  Loader2,
  ArrowRight,
  ArrowLeft,
  Save,
  Upload,
  FileText,
  X,
  User,
  CalendarIcon,
} from 'lucide-vue-next'

// Types
interface PersonalData {
  ci: string
  nombres: string
  apellidoPaterno: string
  apellidoMaterno: string
  pais: string
}

interface TitleData {
  nroDocumento: string
  fojas: string
  libro: string
  nroDiplomaAcademico: string
  graduacionId: string
  fechaEmision: string
  observaciones: string
}

interface ApiResult {
  programa: string
  facultad?: string
}

interface GraduacionOption {
  id: number
  medioGraduacion: string
}

// Reactive data
const currentStep = ref(1)
const searchCi = ref('')
const isSearching = ref(false)
const isUploading = ref(false)
const isSubmitting = ref(false)
const selectedProgram = ref<number | null>(null)
const selectedProgramValue = ref<string>('')
const selectedDate = ref<Date | null>(null)
const pdfFile = ref<File | null>(null)
const pdfUrl = ref<string | null>(null)
const fileInput = ref<HTMLInputElement>()

const personalData = ref<PersonalData>({
  ci: '',
  nombres: '',
  apellidoPaterno: '',
  apellidoMaterno: '',
  pais: 'Bolivia',
})

const titleData = ref<TitleData>({
  nroDocumento: '',
  fojas: '',
  libro: '',
  nroDiplomaAcademico: '',
  graduacionId: '',
  fechaEmision: '',
  observaciones: '',
})

const apiResults = ref<ApiResult[]>([])

const graduacionOptions: GraduacionOption[] = [
  { id: 1, medioGraduacion: 'Tesis de Grado' },
  { id: 2, medioGraduacion: 'Proyecto de Grado' },
  { id: 3, medioGraduacion: 'Trabajo Dirigido' },
  { id: 4, medioGraduacion: 'Examen de Grado' },
  { id: 5, medioGraduacion: 'Adscripción' },
]

// Computed
const todayDate = computed(() => new Date().toISOString().split('T')[0])
const todayValue = computed(() => new Date())

const isStep1Valid = computed(() => {
  return personalData.value.ci.trim() !== '' &&
         personalData.value.nombres.trim() !== '' &&
         personalData.value.apellidoPaterno.trim() !== '' &&
         personalData.value.pais.trim() !== ''
})

const isStep2Valid = computed(() => {
  return titleData.value.nroDocumento.trim() !== '' &&
         titleData.value.fojas.trim() !== '' &&
         titleData.value.libro.trim() !== '' &&
         titleData.value.nroDiplomaAcademico.trim() !== '' &&
         titleData.value.graduacionId !== ''
})

// Methods
const searchPersonInApi = () => {
  if (!searchCi.value.trim()) return
  
  isSearching.value = true
  
  // Simulate API call
  setTimeout(() => {
    apiResults.value = [
      { programa: 'Ingeniería de Sistemas', facultad: 'Facultad de Ciencias y Tecnología' },
      { programa: 'Ingeniería Informática', facultad: 'Facultad de Ciencias y Tecnología' },
    ]
    
    personalData.value = {
      ci: searchCi.value,
      nombres: 'Juan Carlos',
      apellidoPaterno: 'Pérez',
      apellidoMaterno: 'López',
      pais: 'Bolivia',
    }
    
    isSearching.value = false
  }, 1500)
}

const nextStep = () => {
  if (currentStep.value < 2 && isStep1Valid.value) {
    currentStep.value++
  }
}

const previousStep = () => {
  if (currentStep.value > 1) {
    currentStep.value--
  }
}

const triggerFileInput = () => {
  fileInput.value?.click()
}

const handleFileSelect = (event: Event) => {
  const target = event.target as HTMLInputElement
  const file = target.files?.[0]
  if (file) {
    processFile(file)
  }
}

const handleDrop = (event: DragEvent) => {
  event.preventDefault()
  const file = event.dataTransfer?.files[0]
  if (file && file.type === 'application/pdf') {
    processFile(file)
  }
}

const processFile = (file: File) => {
  isUploading.value = true
  
  // Simulate upload
  setTimeout(() => {
    pdfFile.value = file
    pdfUrl.value = URL.createObjectURL(file)
    isUploading.value = false
  }, 1000)
}

const removeFile = () => {
  pdfFile.value = null
  if (pdfUrl.value) {
    URL.revokeObjectURL(pdfUrl.value)
    pdfUrl.value = null
  }
  if (fileInput.value) {
    fileInput.value.value = ''
  }
}

const formatFileSize = (bytes: number) => {
  if (bytes === 0) return '0 Bytes'
  const k = 1024
  const sizes = ['Bytes', 'KB', 'MB', 'GB']
  const i = Math.floor(Math.log(bytes) / Math.log(k))
  return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i]
}

const handleDateSelect = (date: Date | null) => {
  if (date) {
    selectedDate.value = date
    titleData.value.fechaEmision = date.toISOString().split('T')[0]
  }
}

const handleSubmit = () => {
  isSubmitting.value = true
  
  setTimeout(() => {
    // Reset form
    currentStep.value = 1
    personalData.value = { ci: '', nombres: '', apellidoPaterno: '', apellidoMaterno: '', pais: 'Bolivia' }
    titleData.value = { nroDocumento: '', fojas: '', libro: '', nroDiplomaAcademico: '', graduacionId: '', fechaEmision: '', observaciones: '' }
    apiResults.value = []
    selectedProgram.value = null
    selectedProgramValue.value = ''
    selectedDate.value = null
    removeFile()
    searchCi.value = ''
    isSubmitting.value = false
  }, 2000)
}
</script>