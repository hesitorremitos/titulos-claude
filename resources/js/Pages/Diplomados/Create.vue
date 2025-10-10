<template>
  <Head title="Registrar Diplomado" />
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
                  Ingrese el CI para buscar automáticamente los datos de la persona.
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
                  Datos del Diplomado
                </CardTitle>
                <CardDescription>
                  Complete los datos específicos del diplomado.
                </CardDescription>
              </CardHeader>
              <CardContent class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                  <div>
                    <Label for="nro_tpn">N° TPN</Label>
                    <Input
                      id="nro_tpn"
                      v-model="diplomadoStore.nro_tpn"
                      placeholder="Ej. 123-2024"
                      :class="form.errors.nro_tpn ? 'border-red-500' : ''"
                    />
                    <p v-if="form.errors.nro_tpn" class="text-sm text-red-500 mt-1">
                      {{ form.errors.nro_tpn }}
                    </p>
                  </div>
                  <div>
                    <Label for="mencion_tpn_id">Mención TPN (opcional)</Label>
                    <Combobox
                      v-model="diplomadoStore.mencion_tpn_id"
                      :options="mencionTpnOptions"
                      placeholder="Seleccione una mención de TPN"
                      search-placeholder="Buscar mención..."
                      :class="form.errors.mencion_tpn_id ? 'border-red-500 focus:ring-red-500' : ''"
                    />
                    <p v-if="form.errors.mencion_tpn_id" class="text-sm text-red-500 mt-1">
                      {{ form.errors.mencion_tpn_id }}
                    </p>
                  </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                  <div>
                    <Label for="sexo">Sexo</Label>
                    <Select v-model="diplomadoStore.sexo">
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
                    <Label for="fecha_emision">Fecha de Emisión</Label>
                    <Input
                      id="fecha_emision"
                      v-model="diplomadoStore.fecha_emision"
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
                      v-model="diplomadoStore.nro_documento"
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
                      v-model="diplomadoStore.libro"
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
                      v-model="diplomadoStore.fojas"
                      type="number"
                      :class="form.errors.fojas ? 'border-red-500' : ''"
                    />
                    <p v-if="form.errors.fojas" class="text-sm text-red-500 mt-1">
                      {{ form.errors.fojas }}
                    </p>
                  </div>
                  <div>
                    <Label for="mencion_diplomado_id">Mención</Label>
                    <Combobox
                      v-model="diplomadoStore.mencion_diplomado_id"
                      :options="mencionDiplomadoOptions"
                      placeholder="Seleccione una mención"
                      search-placeholder="Buscar mención..."
                      :class="form.errors.mencion_diplomado_id ? 'border-red-500 focus:ring-red-500' : ''"
                    />
                    <p v-if="form.errors.mencion_diplomado_id" class="text-sm text-red-500 mt-1">
                      {{ form.errors.mencion_diplomado_id }}
                    </p>
                  </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                  <div>
                    <Label for="gestion">Gestión</Label>
                    <Input
                      id="gestion"
                      v-model="diplomadoStore.gestion"
                      type="number"
                      placeholder="Ej. 2024"
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
                      v-model="diplomadoStore.version"
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
                    <Label for="modalidad_diplomado_id">Modalidad</Label>
                    <Select v-model="diplomadoStore.modalidad_diplomado_id">
                      <SelectTrigger :class="form.errors.modalidad_diplomado_id ? 'border-red-500' : ''">
                        <SelectValue placeholder="Seleccione una modalidad" />
                      </SelectTrigger>
                      <SelectContent>
                        <SelectGroup>
                          <SelectLabel>Modalidades</SelectLabel>
                          <SelectItem
                            v-for="modalidad in props.modalidades ?? []"
                            :key="modalidad.id"
                            :value="String(modalidad.id)"
                          >
                            {{ modalidad.nombre }}
                          </SelectItem>
                        </SelectGroup>
                      </SelectContent>
                    </Select>
                    <p v-if="form.errors.modalidad_diplomado_id" class="text-sm text-red-500 mt-1">
                      {{ form.errors.modalidad_diplomado_id }}
                    </p>
                  </div>
                  <div>
                    <Label for="horas_creditos">Horas Académicas / Créditos</Label>
                    <Input
                      id="horas_creditos"
                      v-model="diplomadoStore.horas_creditos"
                      type="number"
                      :class="form.errors.horas_creditos ? 'border-red-500' : ''"
                    />
                    <p v-if="form.errors.horas_creditos" class="text-sm text-red-500 mt-1">
                      {{ form.errors.horas_creditos }}
                    </p>
                  </div>
                </div>

                <div class="flex items-center space-x-2">
                  <Switch id="trabajo_final" v-model:checked="diplomadoStore.trabajo_final" />
                  <Label for="trabajo_final">Trabajo final presentado</Label>
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
            <span v-else>Registrar Diplomado</span>
          </Button>
        </div>
      </div>

      <div class="h-full">
        <PdfViewer class="h-full" store-type="diplomado" />
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
import { Combobox } from '@/components/ui/combobox'
import { Switch } from '@/components/ui/switch'
import type { DiplomadoPageProps } from '@/types/ui'
import { useDiplomadoStore } from '@/stores/titulos/useDiplomadoStore'
import AppLayout from '@/Layouts/AppLayout.vue'
import navTabs from './navtabs.json'
import { toast } from 'vue-sonner'

defineOptions({
  layout: (h: any, page: any) => h(AppLayout, {
    title: 'Registrar Diplomado',
    pageTitle: 'Registrar Diplomado',
    navTabs,
    activeTab: 'registrar'
  }, () => page)
})

const props = defineProps<DiplomadoPageProps>()

const personalDataStore = usePersonalDataStore()
const diplomadoStore = useDiplomadoStore()

const form = useForm(diplomadoStore.formData)

const canRegister = computed(() => {
  const menciones = props.menciones?.length ?? 0
  const modalidades = props.modalidades?.length ?? 0
  return menciones > 0 && modalidades > 0
})

const mencionTpnOptions = computed(() =>
  (props.mencionesTpn ?? []).map((mencion) => ({
    label: mencion.nombre,
    value: String(mencion.id),
  })),
)

const mencionDiplomadoOptions = computed(() =>
  (props.menciones ?? []).map((mencion) => ({
    label: mencion.nombre,
    value: String(mencion.id),
  })),
)

const updateFormData = () => {
  form.clearErrors()
  Object.assign(form, diplomadoStore.formData)
}

const page = usePage()

const submitForm = () => {
  if (!canRegister.value) {
    return
  }

  updateFormData()

  form.post(route('diplomados.store'), {
    forceFormData: true,
    onSuccess: () => {
      personalDataStore.$reset()
      diplomadoStore.$reset()
      toast.success((page.props as any).flash?.success ?? 'Diplomado registrado correctamente.')
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
    title: 'Datos del Diplomado',
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
    toast.error('Debes registrar al menos una mención y una modalidad de diplomado activas antes de crear un diplomado.')
  }
})
</script>
