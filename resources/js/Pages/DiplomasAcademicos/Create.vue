<template>
  <AppLayout>
    <div class="space-y-6">
      <!-- Header -->
      <div class="border-b pb-4">
        <h1 class="text-2xl font-semibold text-foreground">Registrar Diploma Académico</h1>
        <p class="text-muted-foreground mt-1">
          Complete el formulario para registrar un nuevo diploma académico
        </p>
      </div>

      <!-- Layout de 2 columnas: Stepper Form | PDF Viewer -->
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 h-[calc(100vh-200px)]">
        <!-- Columna izquierda: Formulario con Stepper -->
        <div class="space-y-6">
          <!-- Stepper Navigation -->
          <Stepper v-model="currentStep" class="w-full">
            <StepperItem
              v-for="step in steps"
              :key="step.step"
              :step="step.step"
              class="relative flex w-full flex-col items-center justify-center"
            >
              <StepperTrigger>
                <StepperIndicator v-slot="{ step: stepNumber }" class="bg-muted">
                  <component v-if="step.icon" :is="step.icon" class="w-4 h-4" />
                  <span v-else>{{ stepNumber }}</span>
                </StepperIndicator>
              </StepperTrigger>
              <StepperSeparator
                v-if="step.step !== steps[steps.length - 1].step"
                class="absolute left-[calc(50%+20px)] right-[calc(-50%+10px)] top-5 block h-0.5 shrink-0 rounded-full bg-muted group-data-[state=completed]:bg-primary"
              />
              <div class="flex flex-col items-center">
                <StepperTitle>{{ step.title }}</StepperTitle>
                <StepperDescription>{{ step.description }}</StepperDescription>
              </div>
            </StepperItem>
          </Stepper>

          <!-- Step Content -->
          <div class="space-y-6">
            <!-- Paso 1: Datos Personales -->
            <div v-if="currentStep === 1" class="space-y-6">
              <!-- Formulario de búsqueda de persona -->
              <Card>
                <CardHeader>
                  <CardTitle class="flex items-center">
                    <Search class="h-5 w-5 mr-2" />
                    Buscar Persona
                  </CardTitle>
                  <CardDescription>
                    Ingrese el CI para buscar automáticamente los datos de la persona
                  </CardDescription>
                </CardHeader>
                <CardContent>
                  <ApiPersonSearch />
                </CardContent>
              </Card>
              
              <!-- Formulario de datos personales -->
              <PersonalDataForm />
            </div>

            <!-- Paso 2: Datos del Diploma -->
            <div v-if="currentStep === 2" class="space-y-6">
              <Card>
                <CardHeader>
                  <CardTitle class="flex items-center">
                    <GraduationCap class="h-5 w-5 mr-2" />
                    Datos del Diploma Académico
                  </CardTitle>
                  <CardDescription>
                    Complete los datos específicos del diploma académico
                  </CardDescription>
                </CardHeader>
                <CardContent>
                  <!-- TODO: Agregar campos del diploma académico -->
                  <p class="text-muted-foreground">Formulario de datos del diploma pendiente...</p>
                </CardContent>
              </Card>
            </div>
          </div>

          <!-- Navigation Buttons -->
          <div class="flex justify-between pt-4">
            <Button 
              v-if="currentStep > 1"
              variant="outline" 
              @click="previousStep"
            >
              Anterior
            </Button>
            <div v-else></div>
            
            <Button 
              v-if="currentStep < steps.length"
              @click="nextStep"
            >
              Siguiente
            </Button>
            <Button 
              v-else
              type="submit"
              class="bg-primary"
            >
              Registrar Diploma
            </Button>
          </div>
        </div>
        
        <!-- Columna derecha: PDF Viewer (siempre visible) -->
        <div class="h-full">
          <PdfViewer 
            v-model="pdfFile" 
            @filename-changed="handleFilenameChanged"
            @file-selected="handleFileSelected"
            @file-removed="handleFileRemoved"
            class="h-full"
          />
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import ApiPersonSearch from '@/components/forms/ApiPersonSearch.vue'
import PersonalDataForm from '@/components/forms/PersonalDataForm.vue'
import PdfViewer from '@/components/forms/PdfViewer.vue'
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card'
import { Button } from '@/components/ui/button'
import { 
  Stepper, 
  StepperDescription, 
  StepperIndicator, 
  StepperItem, 
  StepperSeparator, 
  StepperTitle, 
  StepperTrigger 
} from '@/components/ui/stepper'
import { Search, GraduationCap, User } from 'lucide-vue-next'
import { usePersonalDataStore } from '@/stores/usePersonalDataStore'
import { storeToRefs } from 'pinia'

// Store setup
const personalDataStore = usePersonalDataStore()
const { selectedPersonData } = storeToRefs(personalDataStore)

// Stepper state
const currentStep = ref(1)

// Steps configuration
const steps = [
  {
    step: 1,
    title: 'Datos Personales',
    description: 'Buscar y completar información personal',
    icon: User,
  },
  {
    step: 2,
    title: 'Datos del Diploma',
    description: 'Información específica del diploma académico',
    icon: GraduationCap,
  }
]

// PDF handling
const pdfFile = ref<File | null>(null)

// Event handlers for PdfViewer
const handleFilenameChanged = (filename: string) => {
  // Extract CI from filename using regex pattern
  const ciMatch = filename.match(/\b(\d{6,10})\b/)
  const extractedCi = ciMatch ? ciMatch[1] : null
  
  if (extractedCi && extractedCi.length >= 6) {
    personalDataStore.setCiAndSearch(extractedCi)
  }
}

const handleFileSelected = (file: File) => {
  console.log('File selected:', file.name, file.size)
}

const handleFileRemoved = () => {
  console.log('File removed')
  // Optionally clear person data when PDF is removed
  // personalDataStore.clearData()
}

// Stepper navigation
const nextStep = () => {
  if (currentStep.value < steps.length) {
    currentStep.value++
  }
}

const previousStep = () => {
  if (currentStep.value > 1) {
    currentStep.value--
  }
}

// Page title for browser tab
defineOptions({
  title: 'Registrar Diploma Académico'
})
</script>