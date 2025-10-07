<template>
  <Head title="Registrar Maestría" />
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
                  Datos de la Maestría
                </CardTitle>
                <CardDescription>
                  Complete los datos específicos de la maestría.
                </CardDescription>
              </CardHeader>
              <CardContent class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                  <div>
                    <Label for="nro_tpn">N° TPN</Label>
                    <Input
                      id="nro_tpn"
                      v-model="maestriaStore.nro_tpn"
                      placeholder="Ej. 123-2024"
                      :class="form.errors.nro_tpn ? 'border-red-500' : ''"
                    />
                    <p v-if="form.errors.nro_tpn" class="text-sm text-red-500 mt-1">
                      {{ form.errors.nro_tpn }}
                    </p>
                  </div>
                  <div>
                    <Label for="mencion_tpn_id">Mención TPN (opcional)</Label>
                    <Select v-model="maestriaStore.mencion_tpn_id">
                      <SelectTrigger :class="form.errors.mencion_tpn_id ? 'border-red-500' : ''">
                        <SelectValue placeholder="Seleccione una mención de TPN" />
                      </SelectTrigger>
                      <SelectContent>
                        <SelectGroup>
                          <SelectLabel>Menciones</SelectLabel>
                          <SelectItem
                            v-for="mencion in props.mencionesTpn ?? []"
                            :key="mencion.id"
                            :value="mencion.id"
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
                    <Label for="nro_documento">Documento N°</Label>
                    <Input
                      id="nro_documento"
                      v-model="maestriaStore.nro_documento"
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
                      v-model="maestriaStore.libro"
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
                      v-model="maestriaStore.fojas"
                      type="number"
                      :class="form.errors.fojas ? 'border-red-500' : ''"
                    />
                    <p v-if="form.errors.fojas" class="text-sm text-red-500 mt-1">
                      {{ form.errors.fojas }}
                    </p>
                  </div>
                  <div>
                    <Label for="fecha_emision">Fecha de Emisión</Label>
                    <Input
                      id="fecha_emision"
                      v-model="maestriaStore.fecha_emision"
                      type="date"
                      :class="form.errors.fecha_emision ? 'border-red-500' : ''"
                    />
                    <p v-if="form.errors.fecha_emision" class="text-sm text-red-500 mt-1">
                      {{ form.errors.fecha_emision }}
                    </p>
                  </div>
                </div>

                <div>
                  <Label for="mencion_maestria_id">Mención</Label>
                  <Select v-model="maestriaStore.mencion_maestria_id">
                    <SelectTrigger :class="form.errors.mencion_maestria_id ? 'border-red-500' : ''">
                      <SelectValue placeholder="Seleccione una mención" />
                    </SelectTrigger>
                    <SelectContent>
                      <SelectGroup>
                        <SelectLabel>Menciones</SelectLabel>
                        <SelectItem
                          v-for="mencion in props.menciones ?? []"
                          :key="mencion.id"
                          :value="mencion.id"
                        >
                          {{ mencion.nombre }}
                        </SelectItem>
                      </SelectGroup>
                    </SelectContent>
                  </Select>
                  <p v-if="form.errors.mencion_maestria_id" class="text-sm text-red-500 mt-1">
                    {{ form.errors.mencion_maestria_id }}
                  </p>
                </div>

                <div class="grid grid-cols-2 gap-4">
                  <div>
                    <Label for="gestion_inicial">Gestión Inicial</Label>
                    <Input
                      id="gestion_inicial"
                      v-model="maestriaStore.gestion_inicial"
                      type="number"
                      placeholder="Ej. 2023"
                      :class="form.errors.gestion_inicial ? 'border-red-500' : ''"
                    />
                    <p v-if="form.errors.gestion_inicial" class="text-sm text-red-500 mt-1">
                      {{ form.errors.gestion_inicial }}
                    </p>
                  </div>
                  <div>
                    <Label for="gestion_final">Gestión Final</Label>
                    <Input
                      id="gestion_final"
                      v-model="maestriaStore.gestion_final"
                      type="number"
                      placeholder="Ej. 2024"
                      :class="form.errors.gestion_final ? 'border-red-500' : ''"
                    />
                    <p v-if="form.errors.gestion_final" class="text-sm text-red-500 mt-1">
                      {{ form.errors.gestion_final }}
                    </p>
                  </div>
                </div>

                <div>
                  <Label for="modalidad_maestria_id">Modalidad</Label>
                  <Select v-model="maestriaStore.modalidad_maestria_id">
                    <SelectTrigger :class="form.errors.modalidad_maestria_id ? 'border-red-500' : ''">
                      <SelectValue placeholder="Seleccione una modalidad" />
                    </SelectTrigger>
                    <SelectContent>
                      <SelectGroup>
                        <SelectLabel>Modalidades</SelectLabel>
                        <SelectItem
                          v-for="modalidad in props.modalidades ?? []"
                          :key="modalidad.id"
                          :value="modalidad.id"
                        >
                          {{ modalidad.nombre }}
                        </SelectItem>
                      </SelectGroup>
                    </SelectContent>
                  </Select>
                  <p v-if="form.errors.modalidad_maestria_id" class="text-sm text-red-500 mt-1">
                    {{ form.errors.modalidad_maestria_id }}
                  </p>
                </div>

                <div class="grid grid-cols-2 gap-4">
                  <div>
                    <Label for="horas_academicas">Horas Académicas / Créditos</Label>
                    <Input
                      id="horas_academicas"
                      v-model="maestriaStore.horas_academicas"
                      type="number"
                      :class="form.errors.horas_academicas ? 'border-red-500' : ''"
                    />
                    <p v-if="form.errors.horas_academicas" class="text-sm text-red-500 mt-1">
                      {{ form.errors.horas_academicas }}
                    </p>
                  </div>
                  <div>
                    <Label for="defensa_final">Defensa Final (0-100)</Label>
                    <Input
                      id="defensa_final"
                      v-model="maestriaStore.defensa_final"
                      type="number"
                      min="0"
                      max="100"
                      :class="form.errors.defensa_final ? 'border-red-500' : ''"
                    />
                    <p v-if="form.errors.defensa_final" class="text-sm text-red-500 mt-1">
                      {{ form.errors.defensa_final }}
                    </p>
                  </div>
                </div>

                <div>
                  <Label for="observaciones">Observaciones (opcional)</Label>
                  <Input
                    id="observaciones"
                    v-model="maestriaStore.observaciones"
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
            <span v-else>Registrar Maestría</span>
          </Button>
        </div>
      </div>

      <div class="h-full">
        <PdfViewer class="h-full" store-type="maestria" />
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
import type { MaestriaPageProps } from '@/types/ui'
import { useMaestriaStore } from '@/stores/titulos/useMaestriaStore'
import AppLayout from '@/Layouts/AppLayout.vue'
import navTabs from './navtabs.json'
import { toast } from 'vue-sonner'

defineOptions({
  layout: (h: any, page: any) => h(AppLayout, {
    title: 'Registrar Maestría',
    pageTitle: 'Registrar Maestría',
    navTabs,
    activeTab: 'registrar'
  }, () => page)
})

const props = defineProps<MaestriaPageProps>()

const personalDataStore = usePersonalDataStore()
const maestriaStore = useMaestriaStore()

const form = useForm(maestriaStore.formData)

const canRegister = computed(() => {
  const menciones = props.menciones?.length ?? 0
  const modalidades = props.modalidades?.length ?? 0
  return menciones > 0 && modalidades > 0
})

const updateFormData = () => {
  form.clearErrors()
  Object.assign(form, maestriaStore.formData)
}

const page = usePage()

const submitForm = () => {
  if (!canRegister.value) {
    return
  }

  updateFormData()

  form.post(route('maestrias.store'), {
    forceFormData: true,
    onSuccess: () => {
      personalDataStore.$reset()
      maestriaStore.$reset()
      toast.success((page.props as any).flash?.success ?? 'Maestría registrada correctamente.')
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
    title: 'Datos de la Maestría',
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
    toast.error('Debes registrar al menos una mención y una modalidad de maestría activas antes de crear una maestría.')
  }
})
</script>
