<template>
  <Head title="Registrar Diploma de Bachiller" />
  <div class="space-y-6">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 h-[calc(100vh-200px)]">
      <div class="space-y-6">
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
            </div>
          </StepperItem>
        </Stepper>

        <div class="space-y-6">
          <div v-if="currentStep === 1" class="space-y-6">
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

            <PersonalDataForm :errors="form.errors" />
          </div>

          <div v-if="currentStep === 2" class="space-y-6">
            <Card>
              <CardHeader>
                <CardTitle class="flex items-center">
                  <GraduationCap class="h-5 w-5 mr-2" />
                  Datos del Diploma de Bachiller
                </CardTitle>
                <CardDescription>
                  Complete los datos específicos del diploma a registrar.
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
                  <Label for="mencion_db_id">Mención</Label>
                  <Select v-model="diplomaStore.mencion_db_id">
                    <SelectTrigger :class="form.errors.mencion_db_id ? 'border-red-500' : ''">
                      <SelectValue placeholder="Seleccione una mención" />
                    </SelectTrigger>
                    <SelectContent>
                      <SelectGroup>
                        <SelectLabel>Menciones</SelectLabel>
                        <SelectItem v-for="mencion in props.menciones" :key="mencion.id" :value="mencion.id.toString()">
                          {{ mencion.nombre }}
                        </SelectItem>
                      </SelectGroup>
                    </SelectContent>
                  </Select>
                  <p v-if="form.errors.mencion_db_id" class="text-sm text-red-500 mt-1">
                    {{ form.errors.mencion_db_id }}
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
            :disabled="form.processing || !canRegister"
            @click="submitForm"
          >
            <span v-if="form.processing">Guardando...</span>
            <span v-else>Registrar Diploma</span>
          </Button>
        </div>
      </div>

      <div class="h-full">
        <PdfViewer class="h-full" store-type="diplomaBachiller" />
        <p v-if="form.errors.file" class="text-sm text-red-500 mt-2">
          {{ form.errors.file }}
        </p>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue'
import { Head, useForm, usePage } from '@inertiajs/vue3'
import ApiPersonSearch from '@/components/forms/ApiPersonSearch.vue'
import PersonalDataForm from '@/components/forms/PersonalDataForm.vue'
import PdfViewer from '@/components/forms/PdfViewer.vue'
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card'
import { Button } from '@/components/ui/button'
import {
  Stepper,
  StepperIndicator,
  StepperItem,
  StepperSeparator,
  StepperTitle,
  StepperTrigger
} from '@/components/ui/stepper'
import { Search, GraduationCap, User } from 'lucide-vue-next'
import { usePersonalDataStore } from '@/stores/usePersonalDataStore'
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
import type { DiplomaBachillerPageProps } from '@/types/ui'
import { useDiplomaBachillerStore } from '@/stores/titulos/useDiplomaBachillerStore'
import AppLayout from '@/Layouts/AppLayout.vue'
import navTabs from './navtabs.json'
import { toast } from 'vue-sonner'

defineOptions({
  layout: (h: any, page: any) => h(AppLayout, {
    title: 'Registrar Diploma de Bachiller',
    pageTitle: 'Registrar Diploma de Bachiller',
    navTabs,
    activeTab: 'registrar'
  }, () => page)
})

const props = defineProps<DiplomaBachillerPageProps>()

const personalDataStore = usePersonalDataStore()
const diplomaStore = useDiplomaBachillerStore()

const form = useForm(diplomaStore.formData)

const canRegister = computed(() => {
  const menciones = props.menciones?.length ?? 0
  return menciones > 0
})

const updateFormData = () => {
  form.clearErrors()
  Object.assign(form, diplomaStore.formData)
}

const page = usePage()

const submitForm = () => {
  if (!canRegister.value) {
    return
  }

  updateFormData()

  form.post(route('diploma-bachiller.store'), {
    forceFormData: true,
    onSuccess: () => {
      personalDataStore.$reset()
      toast.success((page.props as any).flash?.success ?? 'Diploma registrado correctamente.')
      diplomaStore.$reset()
    },
    onError: (errors: any) => {
      console.log('Errores de validación:', errors)
      if (errors.error) {
        toast.error(errors.error)
      }
    }
  })
}

const currentStep = ref(1)

const steps = [
  {
    step: 1,
    title: 'Datos Personales',
    icon: User,
  },
  {
    step: 2,
    title: 'Datos del Diploma',
    icon: GraduationCap,
  }
]

const nextStep = () => {
  if (currentStep.value < steps.length) {
    currentStep.value += 1
  }
}

const previousStep = () => {
  if (currentStep.value > 1) {
    currentStep.value -= 1
  }
}

onMounted(() => {
  if (props.dependenciesReady === false || !canRegister.value) {
    toast.error('Debes registrar al menos una mención de diploma de bachiller antes de crear un diploma.')
  }
})
</script>
