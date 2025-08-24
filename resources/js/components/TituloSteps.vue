<template>
  <div class="w-full">
    <!-- Step Indicator -->
    <div class="mb-8">
      <div class="flex items-center justify-between">
        <div class="flex items-center">
          <div
            class="flex h-8 w-8 items-center justify-center rounded-full border-2 text-sm font-medium transition-colors"
            :class="currentStep >= 1 ? 'border-primary bg-primary text-primary-foreground' : 'border-muted-foreground text-muted-foreground'"
          >
            1
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium" :class="currentStep >= 1 ? 'text-foreground' : 'text-muted-foreground'">
              Datos Personales
            </p>
            <p class="text-xs text-muted-foreground">
              Información básica y búsqueda API
            </p>
          </div>
        </div>
        
        <!-- Connector Line -->
        <div 
          class="h-px flex-1 mx-4 transition-colors" 
          :class="currentStep >= 2 ? 'bg-primary' : 'bg-muted'"
        />
        
        <div class="flex items-center">
          <div
            class="flex h-8 w-8 items-center justify-center rounded-full border-2 text-sm font-medium transition-colors"
            :class="currentStep >= 2 ? 'border-primary bg-primary text-primary-foreground' : 'border-muted-foreground text-muted-foreground'"
          >
            2
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium" :class="currentStep >= 2 ? 'text-foreground' : 'text-muted-foreground'">
              Datos del Título
            </p>
            <p class="text-xs text-muted-foreground">
              Información específica y PDF
            </p>
          </div>
        </div>
      </div>
    </div>

    <!-- Step Content -->
    <div class="min-h-[400px]">
      <!-- Paso 1: Datos Personales -->
      <div v-if="currentStep === 1" class="space-y-6">
        <slot name="step1" />
        
        <!-- Navigation -->
        <div class="flex justify-end pt-6 border-t">
          <Button 
            @click="nextStep"
            class="px-6"
          >
            Siguiente
            <ChevronRight class="ml-2 h-4 w-4" />
          </Button>
        </div>
      </div>

      <!-- Paso 2: Datos del Título -->
      <div v-if="currentStep === 2" class="space-y-6">
        <slot name="step2" />
        
        <!-- Navigation -->
        <div class="flex justify-between pt-6 border-t">
          <Button 
            variant="outline" 
            @click="previousStep"
            class="px-6"
          >
            <ChevronLeft class="mr-2 h-4 w-4" />
            Anterior
          </Button>
          
          <slot name="submit-button">
            <Button 
              type="submit"
              :disabled="isSubmitting"
              class="px-6"
            >
              <span v-if="isSubmitting">Guardando...</span>
              <span v-else>Guardar Título</span>
            </Button>
          </slot>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { Button } from '@/components/ui/button'
import { ChevronLeft, ChevronRight } from 'lucide-vue-next'

interface Props {
  isSubmitting?: boolean
}

const props = withDefaults(defineProps<Props>(), {
  isSubmitting: false
})

const emit = defineEmits<{
  stepChanged: [step: number]
}>()

const currentStep = ref(1)

// Navegación entre pasos (solo visual, sin validaciones)
const nextStep = () => {
  if (currentStep.value < 2) {
    currentStep.value++
    emit('stepChanged', currentStep.value)
  }
}

const previousStep = () => {
  if (currentStep.value > 1) {
    currentStep.value--
    emit('stepChanged', currentStep.value)
  }
}

// Exposer currentStep para que el componente padre pueda accederlo
defineExpose({
  currentStep
})
</script>