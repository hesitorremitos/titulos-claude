<template>
  <div class="max-w-6xl mx-auto p-6 space-y-6">
    <!-- Progress Stepper -->
    <Card class="w-full">
      <CardContent class="p-6">
        <Stepper v-model="currentStep" class="w-full">
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
                <StepperDescription>Información específica del título académico</StepperDescription>
              </div>
            </StepperTrigger>
          </StepperItem>
        </Stepper>
      </CardContent>
    </Card>

    <!-- Alert Messages -->
    <Alert v-if="successMessage" class="border-green-200 bg-green-50">
      <CheckCircle :size="16" class="text-green-600" />
      <AlertTitle class="text-green-800">¡Éxito!</AlertTitle>
      <AlertDescription class="text-green-700">{{ successMessage }}</AlertDescription>
    </Alert>

    <Alert v-if="errorMessage" variant="destructive">
      <AlertCircle :size="16" />
      <AlertTitle>Error</AlertTitle>
      <AlertDescription>{{ errorMessage }}</AlertDescription>
    </Alert>

    <form @submit.prevent="handleSubmit" class="space-y-6">
      <!-- Step 1: Personal Data -->
      <Card v-if="currentStep === 1" class="transition-all duration-300 ease-in-out">
        <CardHeader>
          <CardTitle class="flex items-center gap-2">
            <User :size="20" />
            Paso 1: Datos Personales
          </CardTitle>
          <CardDescription>
            Busque persona en API universitaria o ingrese manualmente
          </CardDescription>
        </CardHeader>
        
        <CardContent class="space-y-6">
          <!-- Option 1: PDF Upload with Auto-extraction -->
          <Card class="border-blue-200 bg-blue-50/50">
            <CardHeader>
              <CardTitle class="text-lg flex items-center gap-2 text-blue-900">
                <Upload :size="20" />
                Opción 1: Cargar PDF (Recomendado)
              </CardTitle>
              <CardDescription class="text-blue-700">
                Suba el archivo PDF del título para extraer automáticamente el CI y consultar datos
              </CardDescription>
            </CardHeader>
            <CardContent>
              <div class="border-2 border-dashed border-blue-300 rounded-lg p-8 text-center hover:border-blue-400 transition-colors">
                <input
                  ref="pdfFileInput"
                  type="file"
                  accept=".pdf"
                  @change="handlePdfUpload"
                  class="hidden"
                  :disabled="isUploading"
                />
                
                <div v-if="!uploadedFile && !isUploading" class="space-y-4">
                  <div class="mx-auto w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <FileUp :size="24" class="text-blue-600" />
                  </div>
                  <div>
                    <p class="text-sm font-medium text-gray-900">Seleccione archivo PDF</p>
                    <p class="text-xs text-gray-500">PDF, máximo 50MB</p>
                  </div>
                  <Button 
                    type="button" 
                    variant="outline" 
                    @click="triggerFileInput"
                    class="border-blue-300 text-blue-700 hover:bg-blue-50"
                  >
                    <FileUp :size="16" class="mr-2" />
                    Seleccionar archivo
                  </Button>
                </div>

                <div v-if="isUploading" class="space-y-4">
                  <div class="mx-auto w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <Loader2 :size="24" class="text-blue-600 animate-spin" />
                  </div>
                  <div>
                    <p class="text-sm font-medium text-gray-900">Procesando archivo...</p>
                    <Progress :model-value="uploadProgress" class="w-full mt-2" />
                    <p class="text-xs text-gray-500 mt-1">{{ uploadProgress }}% completado</p>
                  </div>
                </div>

                <div v-if="uploadedFile && !isUploading" class="space-y-4">
                  <div class="mx-auto w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <CheckCircle :size="24" class="text-green-600" />
                  </div>
                  <div>
                    <p class="text-sm font-medium text-green-900">Archivo cargado exitosamente</p>
                    <p class="text-xs text-gray-600">{{ uploadedFile.name }}</p>
                  </div>
                  <Button 
                    type="button" 
                    variant="outline" 
                    size="sm"
                    @click="removeFile"
                    class="border-red-300 text-red-700 hover:bg-red-50"
                  >
                    <X :size="16" class="mr-2" />
                    Remover archivo
                  </Button>
                </div>
              </div>
            </CardContent>
          </Card>

          <!-- Option 2: Manual CI Search -->
          <Card class="border-gray-200 bg-gray-50/50">
            <CardHeader>
              <CardTitle class="text-lg flex items-center gap-2 text-gray-900">
                <Search :size="20" />
                Opción 2: Búsqueda por CI
              </CardTitle>
            </CardHeader>
            <CardContent>
              <div class="flex gap-3">
                <div class="flex-1">
                  <Label for="search-ci">Carnet de Identidad</Label>
                  <div class="relative mt-1">
                    <Input
                      id="search-ci"
                      v-model="searchCi"
                      placeholder="Ingrese CI para buscar"
                      class="pr-10"
                      :disabled="isSearching"
                    />
                    <IdCard :size="16" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400" />
                  </div>
                </div>
                <div class="flex items-end">
                  <Button 
                    type="button" 
                    @click="searchPersonInApi"
                    :disabled="isSearching || !searchCi.trim()"
                    variant="secondary"
                  >
                    <Loader2 v-if="isSearching" :size="16" class="mr-2 animate-spin" />
                    <Search v-else :size="16" class="mr-2" />
                    {{ isSearching ? 'Buscando...' : 'Buscar' }}
                  </Button>
                </div>
              </div>
            </CardContent>
          </Card>

          <!-- Personal Data Form -->
          <Card>
            <CardHeader>
              <CardTitle class="text-lg">Información Personal</CardTitle>
            </CardHeader>
            <CardContent>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-2">
                  <Label for="ci">Carnet de Identidad *</Label>
                  <Input
                    id="ci"
                    v-model="personalData.ci"
                    placeholder="Ingrese CI"
                    readonly
                    class="bg-gray-50"
                  />
                  <p v-if="validationErrors.ci" class="text-sm text-red-600">{{ validationErrors.ci }}</p>
                </div>

                <div class="space-y-2">
                  <Label for="nombres">Nombres Completos *</Label>
                  <Input
                    id="nombres"
                    v-model="personalData.nombres"
                    placeholder="Nombres completos"
                  />
                  <p v-if="validationErrors.nombres" class="text-sm text-red-600">{{ validationErrors.nombres }}</p>
                </div>

                <div class="space-y-2">
                  <Label for="apellido-paterno">Apellido Paterno *</Label>
                  <Input
                    id="apellido-paterno"
                    v-model="personalData.apellidoPaterno"
                    placeholder="Apellido paterno"
                  />
                  <p v-if="validationErrors.apellidoPaterno" class="text-sm text-red-600">{{ validationErrors.apellidoPaterno }}</p>
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
                  />
                  <p v-if="validationErrors.pais" class="text-sm text-red-600">{{ validationErrors.pais }}</p>
                </div>
              </div>
            </CardContent>
          </Card>

          <!-- Academic Programs Selection (if found in API) -->
          <Card v-if="apiResults.length > 0" class="border-green-200 bg-green-50/50">
            <CardHeader>
              <CardTitle class="text-lg flex items-center gap-2 text-green-900">
                <GraduationCap :size="20" />
                Programas Académicos Encontrados
              </CardTitle>
              <CardDescription class="text-green-700">
                Seleccione el programa académico correspondiente
              </CardDescription>
            </CardHeader>
            <CardContent>
              <RadioGroup v-model="selectedProgram" class="space-y-3">
                <div
                  v-for="(programa, index) in apiResults"
                  :key="index"
                  class="flex items-center space-x-3 p-3 border rounded-lg hover:bg-green-100/50 transition-colors"
                  :class="{ 'border-green-500 bg-green-100/50': selectedProgram === programa }"
                >
                  <RadioGroupItem :value="programa" />
                  <div class="flex-1">
                    <Label class="text-sm font-medium cursor-pointer">{{ programa.programa }}</Label>
                    <p class="text-xs text-gray-600">{{ programa.facultad || 'Sin facultad' }}</p>
                  </div>
                </div>
              </RadioGroup>
            </CardContent>
          </Card>
        </CardContent>

        <CardFooter class="justify-end">
          <Button 
            type="button" 
            @click="nextStep"
            :disabled="!isStep1Valid"
            class="min-w-32"
          >
            Continuar
            <ArrowRight :size="16" class="ml-2" />
          </Button>
        </CardFooter>
      </Card>

      <!-- Step 2: Title Data -->
      <Card v-if="currentStep === 2" class="transition-all duration-300 ease-in-out">
        <CardHeader>
          <CardTitle class="flex items-center gap-2">
            <FileText :size="20" />
            Paso 2: Datos del Título Académico
          </CardTitle>
          <CardDescription>
            Complete los datos específicos del título académico
          </CardDescription>
        </CardHeader>
        
        <CardContent class="space-y-6">
          <!-- Document Numbers -->
          <Card>
            <CardHeader>
              <CardTitle class="text-lg">Numeración del Documento</CardTitle>
            </CardHeader>
            <CardContent>
              <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="space-y-2">
                  <Label for="nro-documento">Número de Documento *</Label>
                  <Input
                    id="nro-documento"
                    v-model="titleData.nroDocumento"
                    type="number"
                    min="1"
                    placeholder="Ej: 123"
                  />
                  <p v-if="validationErrors.nroDocumento" class="text-sm text-red-600">{{ validationErrors.nroDocumento }}</p>
                </div>

                <div class="space-y-2">
                  <Label for="fojas">Fojas *</Label>
                  <Input
                    id="fojas"
                    v-model="titleData.fojas"
                    type="number"
                    min="1"
                    placeholder="Ej: 45"
                  />
                  <p v-if="validationErrors.fojas" class="text-sm text-red-600">{{ validationErrors.fojas }}</p>
                </div>

                <div class="space-y-2">
                  <Label for="libro">Libro *</Label>
                  <Input
                    id="libro"
                    v-model="titleData.libro"
                    type="number"
                    min="1"
                    placeholder="Ej: 2"
                  />
                  <p v-if="validationErrors.libro" class="text-sm text-red-600">{{ validationErrors.libro }}</p>
                </div>
              </div>
            </CardContent>
          </Card>

          <!-- Academic Diploma Number -->
          <Card>
            <CardHeader>
              <CardTitle class="text-lg">Diploma Académico</CardTitle>
            </CardHeader>
            <CardContent>
              <div class="space-y-2">
                <Label for="nro-diploma">Número de Diploma Académico *</Label>
                <Input
                  id="nro-diploma"
                  v-model="titleData.nroDiplomaAcademico"
                  placeholder="Ej: DA-2024-001"
                />
                <p v-if="validationErrors.nroDiplomaAcademico" class="text-sm text-red-600">{{ validationErrors.nroDiplomaAcademico }}</p>
              </div>
            </CardContent>
          </Card>

          <!-- Graduation Details -->
          <Card>
            <CardHeader>
              <CardTitle class="text-lg">Detalles de Graduación</CardTitle>
            </CardHeader>
            <CardContent>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-2">
                  <Label for="modalidad">Modalidad de Graduación *</Label>
                  <Select v-model="titleData.graduacionId">
                    <SelectTrigger>
                      <SelectValue placeholder="Seleccione modalidad" />
                    </SelectTrigger>
                    <SelectContent>
                      <SelectGroup>
                        <SelectLabel>Modalidades</SelectLabel>
                        <SelectItem
                          v-for="modalidad in graduacionOptions"
                          :key="modalidad.id"
                          :value="modalidad.id.toString()"
                        >
                          {{ modalidad.medioGraduacion }}
                        </SelectItem>
                      </SelectGroup>
                    </SelectContent>
                  </Select>
                  <p v-if="validationErrors.graduacionId" class="text-sm text-red-600">{{ validationErrors.graduacionId }}</p>
                </div>

                <div class="space-y-2">
                  <Label for="fecha-emision">Fecha de Emisión</Label>
                  <Input
                    id="fecha-emision"
                    v-model="titleData.fechaEmision"
                    type="date"
                    :max="todayDate"
                  />
                  <p v-if="validationErrors.fechaEmision" class="text-sm text-red-600">{{ validationErrors.fechaEmision }}</p>
                </div>
              </div>
            </CardContent>
          </Card>

          <!-- Observations -->
          <Card>
            <CardHeader>
              <CardTitle class="text-lg">Observaciones</CardTitle>
            </CardHeader>
            <CardContent>
              <div class="space-y-2">
                <Label for="observaciones">Observaciones Adicionales</Label>
                <Textarea
                  id="observaciones"
                  v-model="titleData.observaciones"
                  placeholder="Observaciones adicionales (opcional)"
                  :rows="4"
                  maxlength="500"
                />
                <div class="flex justify-between text-xs text-gray-500">
                  <span>Campo opcional</span>
                  <span>{{ titleData.observaciones?.length || 0 }}/500</span>
                </div>
              </div>
            </CardContent>
          </Card>

          <!-- PDF File Upload -->
          <Card>
            <CardHeader>
              <CardTitle class="text-lg">Archivo PDF del Título</CardTitle>
            </CardHeader>
            <CardContent>
              <div v-if="titleData.pdfFile" class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg">
                <div class="flex items-center text-green-700">
                  <CheckCircle :size="20" class="mr-2" />
                  <span class="text-sm font-medium">Archivo cargado: </span>
                  <span class="text-sm ml-1">{{ titleData.pdfFile.name }}</span>
                </div>
              </div>
              
              <input
                ref="titlePdfInput"
                type="file"
                accept=".pdf"
                @change="handleTitlePdfUpload"
                class="hidden"
              />
              
              <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-gray-400 transition-colors">
                <div class="space-y-4">
                  <div class="mx-auto w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
                    <FileText :size="24" class="text-gray-600" />
                  </div>
                  <div>
                    <p class="text-sm font-medium text-gray-900">Seleccione archivo PDF del título</p>
                    <p class="text-xs text-gray-500">PDF, máximo 50MB</p>
                  </div>
                  <Button 
                    type="button" 
                    variant="outline" 
                    @click="triggerTitlePdfInput"
                  >
                    <FileUp :size="16" class="mr-2" />
                    Seleccionar archivo
                  </Button>
                </div>
              </div>
              <p v-if="validationErrors.pdfFile" class="text-sm text-red-600 mt-2">{{ validationErrors.pdfFile }}</p>
            </CardContent>
          </Card>
        </CardContent>

        <CardFooter class="justify-between">
          <Button 
            type="button" 
            variant="outline"
            @click="previousStep"
          >
            <ArrowLeft :size="16" class="mr-2" />
            Anterior
          </Button>
          
          <Button 
            type="submit"
            :disabled="isSubmitting || !isStep2Valid"
            class="min-w-32"
          >
            <Loader2 v-if="isSubmitting" :size="16" class="mr-2 animate-spin" />
            <Save v-else :size="16" class="mr-2" />
            {{ isSubmitting ? 'Guardando...' : 'Registrar Título' }}
          </Button>
        </CardFooter>
      </Card>
    </form>
  </div>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue'
import {
  Card,
  CardContent,
  CardDescription,
  CardFooter,
  CardHeader,
  CardTitle,
} from '@/components/ui/card'
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
  Alert,
  AlertDescription,
  AlertTitle,
} from '@/components/ui/alert'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { Textarea } from '@/components/ui/textarea'
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
  RadioGroup,
  RadioGroupItem,
} from '@/components/ui/radio-group'
import { Progress } from '@/components/ui/progress'
import {
  User,
  FileText,
  Upload,
  FileUp,
  Search,
  IdCard,
  CheckCircle,
  AlertCircle,
  Loader2,
  X,
  ArrowRight,
  ArrowLeft,
  Save,
  GraduationCap,
} from 'lucide-vue-next'

// --- Type definitions ---
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
  pdfFile: File | null
}

interface ApiResult {
  programa: string
  facultad?: string
}

interface GraduacionOption {
  id: number
  medioGraduacion: string
}

// --- Props & Events ---
defineProps<{
  initialData?: Partial<PersonalData & TitleData>
}>()

defineEmits<{
  submit: [data: PersonalData & TitleData]
}>()
const graduacionOptions: GraduacionOption[] = [
  { id: 1, medioGraduacion: 'Tesis de Grado' },
  { id: 2, medioGraduacion: 'Proyecto de Grado' },
  { id: 3, medioGraduacion: 'Trabajo Dirigido' },
  { id: 4, medioGraduacion: 'Examen de Grado' },
  { id: 5, medioGraduacion: 'Adscripción' },
]

// --- Component Logic ---
const currentStep = ref(1)
const successMessage = ref('')
const errorMessage = ref('')

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
  pdfFile: null,
})

const searchCi = ref('')
const isSearching = ref(false)
const isUploading = ref(false)
const uploadProgress = ref(0)
const uploadedFile = ref<File | null>(null)
const apiResults = ref<ApiResult[]>([])
const selectedProgram = ref<ApiResult | null>(null)
const isSubmitting = ref(false)
const validationErrors = ref<Record<string, string>>({})

const pdfFileInput = ref<HTMLInputElement>()
const titlePdfInput = ref<HTMLInputElement>()

// Computed properties
const todayDate = computed(() => new Date().toISOString().split('T')[0])

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
const triggerFileInput = () => {
  pdfFileInput.value?.click()
}

const triggerTitlePdfInput = () => {
  titlePdfInput.value?.click()
}

const handlePdfUpload = (event: Event) => {
  const target = event.target as HTMLInputElement
  const file = target.files?.[0]
  
  if (file && file.type === 'application/pdf') {
    isUploading.value = true
    uploadProgress.value = 0
    
    // Simulate upload progress
    const interval = setInterval(() => {
      uploadProgress.value += 10
      if (uploadProgress.value >= 100) {
        clearInterval(interval)
        uploadedFile.value = file
        isUploading.value = false
        personalData.value.ci = '12345678'
        searchPersonInApi()
      }
    }, 200)
  }
}

const handleTitlePdfUpload = (event: Event) => {
  const target = event.target as HTMLInputElement
  const file = target.files?.[0]
  
  if (file) {
    titleData.value.pdfFile = file
  }
}

const removeFile = () => {
  uploadedFile.value = null
  personalData.value.ci = ''
  apiResults.value = []
  selectedProgram.value = null
  if (pdfFileInput.value) {
    pdfFileInput.value.value = ''
  }
}

const searchPersonInApi = () => {
  if (!searchCi.value.trim() && !personalData.value.ci) return
  
  isSearching.value = true
  
  // Simulate API call
  setTimeout(() => {
    apiResults.value = [
      { programa: 'Ingeniería de Sistemas', facultad: 'Facultad de Ciencias y Tecnología' },
      { programa: 'Ingeniería Informática', facultad: 'Facultad de Ciencias y Tecnología' },
    ]
    
    personalData.value = {
      ci: searchCi.value || personalData.value.ci,
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

const handleSubmit = () => {
  isSubmitting.value = true
  
  setTimeout(() => {
    successMessage.value = 'Título académico registrado exitosamente'
    isSubmitting.value = false
    
    setTimeout(() => {
      currentStep.value = 1
      personalData.value = { ci: '', nombres: '', apellidoPaterno: '', apellidoMaterno: '', pais: 'Bolivia' }
      titleData.value = { nroDocumento: '', fojas: '', libro: '', nroDiplomaAcademico: '', graduacionId: '', fechaEmision: '', observaciones: '', pdfFile: null }
      successMessage.value = ''
      apiResults.value = []
      selectedProgram.value = null
      uploadedFile.value = null
    }, 3000)
  }, 2000)
}
</script>