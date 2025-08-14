<template>
  <Card class="w-full">
    <CardHeader>
      <CardTitle class="flex items-center justify-between">
        <span>Datos Personales</span>
        <Badge v-if="hasApiData" variant="secondary">
          <CheckCircle class="h-3 w-3 mr-1" />
          Datos de API
        </Badge>
        <Badge v-else variant="outline">
          Entrada Manual
        </Badge>
      </CardTitle>
      <CardDescription>
        Complete la información personal de la persona
      </CardDescription>
    </CardHeader>
    <CardContent>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <!-- CI - Campo completo -->
        <div class="md:col-span-2">
          <Label for="ci">Carnet de Identidad *</Label>
          <Input
            id="ci"
            v-model="formData.ci"
            placeholder="Ingrese CI"
            :disabled="hasApiData"
            class="mt-1"
          />
        </div>

        <!-- Nombres - Campo completo -->
        <div class="md:col-span-2">
          <Label for="nombres">Nombres *</Label>
          <Input
            id="nombres"
            v-model="formData.nombres"
            placeholder="Ingrese nombres completos"
            class="mt-1"
          />
        </div>

        <!-- Apellidos - Lado a lado -->
        <div>
          <Label for="paterno">Apellido Paterno *</Label>
          <Input
            id="paterno"
            v-model="formData.paterno"
            placeholder="Apellido paterno"
            class="mt-1"
          />
        </div>

        <div>
          <Label for="materno">Apellido Materno</Label>
          <Input
            id="materno"
            v-model="formData.materno"
            placeholder="Apellido materno"
            class="mt-1"
          />
        </div>

        <!-- Fecha de Nacimiento -->
        <div>
          <Label for="fecha-nacimiento">Fecha de Nacimiento</Label>
          <Input
            id="fecha-nacimiento"
            v-model="formData.fecha_nacimiento"
            type="date"
            :max="new Date().toISOString().split('T')[0]"
            class="mt-1"
          />
        </div>

        <!-- País -->
        <div>
          <Label for="pais">País</Label>
          <Select v-model="formData.pais">
            <SelectTrigger class="mt-1">
              <SelectValue placeholder="Seleccione país" />
            </SelectTrigger>
            <SelectContent>
              <SelectItem value="BOLIVIA">Bolivia</SelectItem>
              <SelectItem value="ARGENTINA">Argentina</SelectItem>
              <SelectItem value="BRASIL">Brasil</SelectItem>
              <SelectItem value="CHILE">Chile</SelectItem>
              <SelectItem value="PERU">Perú</SelectItem>
              <SelectItem value="COLOMBIA">Colombia</SelectItem>
              <SelectItem value="ECUADOR">Ecuador</SelectItem>
              <SelectItem value="OTRO">Otro</SelectItem>
            </SelectContent>
          </Select>
        </div>

        <!-- Género - Radio Group -->
        <div class="md:col-span-2">
          <Label>Género</Label>
          <RadioGroup v-model="formData.genero" class="flex space-x-6 mt-2">
            <div class="flex items-center space-x-2">
              <RadioGroupItem value="M" id="masculino" />
              <Label for="masculino" class="cursor-pointer">Masculino</Label>
            </div>
            <div class="flex items-center space-x-2">
              <RadioGroupItem value="F" id="femenino" />
              <Label for="femenino" class="cursor-pointer">Femenino</Label>
            </div>
            <div class="flex items-center space-x-2">
              <RadioGroupItem value="O" id="otro" />
              <Label for="otro" class="cursor-pointer">Otro</Label>
            </div>
          </RadioGroup>
        </div>

        <!-- Ubicación - Campos opcionales -->
        <div>
          <Label for="departamento">Departamento</Label>
          <Input
            id="departamento"
            v-model="formData.departamento"
            placeholder="Departamento"
            class="mt-1"
          />
        </div>

        <div>
          <Label for="provincia">Provincia</Label>
          <Input
            id="provincia"
            v-model="formData.provincia"
            placeholder="Provincia"
            class="mt-1"
          />
        </div>

        <div class="md:col-span-2">
          <Label for="localidad">Localidad</Label>
          <Input
            id="localidad"
            v-model="formData.localidad"
            placeholder="Localidad"
            class="mt-1"
          />
        </div>
      </div>
    </CardContent>
  </Card>
</template>

<script setup lang="ts">
import { ref, reactive, computed, watch } from 'vue'
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { Badge } from '@/components/ui/badge'
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select'
import { RadioGroup, RadioGroupItem } from '@/components/ui/radio-group'
import { CheckCircle } from 'lucide-vue-next'
import { usePersonalDataStore } from '@/stores/usePersonalDataStore'
import { storeToRefs } from 'pinia'

// Store
const personalDataStore = usePersonalDataStore()
const { selectedPersonData } = storeToRefs(personalDataStore)

// Form data
const formData = reactive({
  ci: '',
  nombres: '',
  paterno: '',
  materno: '',
  fecha_nacimiento: '',
  genero: '',
  pais: 'BOLIVIA',
  departamento: '',
  provincia: '',
  localidad: ''
})

// Computed
const hasApiData = computed(() => !!selectedPersonData.value)

// Fill form data from API
const fillFromApiData = (apiData: any) => {
  formData.ci = apiData.nro_dip || ''
  formData.nombres = apiData.nombres || ''
  formData.paterno = apiData.paterno || ''
  formData.materno = apiData.materno || ''
  formData.fecha_nacimiento = apiData.fec_nacimiento || ''
  formData.genero = apiData.genero || ''
  formData.pais = apiData.pais || 'BOLIVIA'
  formData.departamento = apiData.departamento || ''
  formData.provincia = apiData.provincia || ''
  formData.localidad = apiData.localidad || ''
}

// Reset form data
const resetFormData = () => {
  formData.ci = ''
  formData.nombres = ''
  formData.paterno = ''
  formData.materno = ''
  formData.fecha_nacimiento = ''
  formData.genero = ''
  formData.pais = 'BOLIVIA'
  formData.departamento = ''
  formData.provincia = ''
  formData.localidad = ''
}

// Watch for API data changes
watch(selectedPersonData, (newData) => {
  if (newData) {
    fillFromApiData(newData)
  } else {
    resetFormData()
  }
}, { immediate: true })
</script>