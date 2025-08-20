<template>
  <Head title="Registrar Diploma Académico" />
    <div class="space-y-6">

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
              <PersonalDataForm :errors="form.errors" />
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
                <CardContent class="space-y-4">
                  <div class="grid grid-cols-2 gap-4">
                    <div>
                      <Label for="nro_documento">Nro. Documento</Label>
                      <Input 
                        id="nro_documento" 
                        v-model="diplomaStore.nro_documento" 
                        type="number"
                        :class="form.errors.nro_documento ? 'border-red-500' : ''"
                      />
                      <p v-if="form.errors.nro_documento" class="text-sm text-red-500 mt-1">
                        {{ form.errors.nro_documento }}
                      </p>
                    </div>
                    <div>
                      <Label for="libro">Libro</Label>
                      <Input 
                        id="libro" 
                        v-model="diplomaStore.libro" 
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
                      <Label for="fojas">Fojas</Label>
                      <Input 
                        id="fojas" 
                        v-model="diplomaStore.fojas" 
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
                        v-model="diplomaStore.fecha_emision" 
                        type="date"
                        :class="form.errors.fecha_emision ? 'border-red-500' : ''"
                      />
                      <p v-if="form.errors.fecha_emision" class="text-sm text-red-500 mt-1">
                        {{ form.errors.fecha_emision }}
                      </p>
                    </div>
                  </div>
                  <div>
                    <Label for="mencion_da_id">Mención</Label>
                    <Select v-model="diplomaStore.mencion_da_id">
                      <SelectTrigger :class="form.errors.mencion_da_id ? 'border-red-500' : ''">
                        <SelectValue placeholder="Seleccione una mención" />
                      </SelectTrigger>
                      <SelectContent>
                        <SelectGroup>
                          <SelectLabel>Menciones</SelectLabel>
                          <SelectItem v-for="mencion in props.menciones" :key="mencion.id" :value="mencion.id">
                            {{ mencion.nombre }}
                          </SelectItem>
                        </SelectGroup>
                      </SelectContent>
                    </Select>
                    <p v-if="form.errors.mencion_da_id" class="text-sm text-red-500 mt-1">
                      {{ form.errors.mencion_da_id }}
                    </p>
                  </div>
                  <div>
                    <Label for="graduacion_id">Modalidad de Graduación (Opcional)</Label>
                    <Select v-model="diplomaStore.graduacion_id">
                      <SelectTrigger :class="form.errors.graduacion_id ? 'border-red-500' : ''">
                        <SelectValue placeholder="Seleccione una modalidad" />
                      </SelectTrigger>
                      <SelectContent>
                        <SelectGroup>
                          <SelectLabel>Modalidades</SelectLabel>
                          <SelectItem v-for="graduacion in props.graduaciones" :key="graduacion.id" :value="graduacion.id">
                            {{ graduacion.medio_graduacion }}
                          </SelectItem>
                        </SelectGroup>
                      </SelectContent>
                    </Select>
                    <p v-if="form.errors.graduacion_id" class="text-sm text-red-500 mt-1">
                      {{ form.errors.graduacion_id }}
                    </p>
                  </div>
                  <div>
                    <Label for="observaciones">Observaciones (Opcional)</Label>
                    <Input 
                      id="observaciones" 
                      v-model="diplomaStore.observaciones" 
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
              :disabled="form.processing"
              @click="submitForm"
            >
              <span v-if="form.processing">Guardando...</span>
              <span v-else>Registrar Diploma</span>
            </Button>
          </div>
        </div>
        
        <!-- Columna derecha: PDF Viewer (siempre visible) -->
        <div class="h-full">
          <PdfViewer class="h-full" />
          <p v-if="form.errors.file" class="text-sm text-red-500 mt-2">
            {{ form.errors.file }}
          </p>
        </div>
      </div>
    </div>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue'
import { Head, useForm } from '@inertiajs/vue3'
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

import type { DiplomaPageProps } from '@/types/ui'
import { useDiplomaAcademicoStore } from '@/stores/titulos/useDiplomaAcademicoStore'
import SubLayout from '@/Layouts/titulos/DiplomaAcademico.vue'

// Configurar layout persistente
defineOptions({ 
  layout: (h: any, page: any) => h(SubLayout, { 
    title: 'Registrar Diploma Académico',
    activeTab: 'registrar'
  }, () => page) 
})

// Props tipadas
const props = defineProps<DiplomaPageProps>()

// Stores
const personalDataStore = usePersonalDataStore()
const diplomaStore = useDiplomaAcademicoStore()

// Form con Inertia
const form = useForm(diplomaStore.formData)

// Actualizar form data cuando cambien los stores
const updateFormData = () => {
  form.clearErrors()
  Object.assign(form, diplomaStore.formData)
}

// Función para enviar con datos combinados
const submitForm = () => {
  updateFormData()
  
  form.post(route('v2.diplomas-academicos.store'), {
    forceFormData: true,
    onSuccess: () => {
      // Limpiar stores después del éxito
      personalDataStore.$reset()
      diplomaStore.$reset()
    },
    onError: (errors: any) => {
      console.log('Errores de validación:', errors)
    }
  })
}

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

// PDF handling - simplificado ya que PdfViewer maneja todo internamente

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

</script>
