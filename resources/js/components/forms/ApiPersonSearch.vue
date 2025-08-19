<template>
  <div class="w-full space-y-4">
    <!-- Input de búsqueda con botón - Full width -->
    <div class="w-full flex items-center space-x-3">
      <div class="relative flex-1">
        <Input
          v-model="ci"
          placeholder="Ingrese CI"
          :disabled="loading"
          @keydown.enter="handleSearch"
          class="w-full transition-colors duration-150"
        />
        <div v-if="loading" class="absolute right-3 top-1/2 -translate-y-1/2">
          <div class="h-4 w-4 animate-spin rounded-full border-2 border-primary border-t-transparent"></div>
        </div>
      </div>
      <Button 
        @click="handleSearch" 
        :disabled="loading || !ci.trim()"
        class="px-6 transition-all duration-150"
      >
        <Search class="h-4 w-4" />
      </Button>
    </div>

    <!-- Estado de loading -->
    <div v-if="loading" class="w-full space-y-2">
      <Skeleton class="h-4 w-full" />
      <Skeleton class="h-4 w-2/3" />
    </div>

    <!-- Estado de error -->
    <Alert v-if="errorMessage && !loading" variant="destructive" class="w-full">
      <AlertCircle class="h-4 w-4" />
      <AlertDescription>{{ errorMessage }}</AlertDescription>
    </Alert>

    <!-- Resultados con Radio Group mejorado -->
    <div v-if="hasResults && !loading && !errorMessage" class="w-full space-y-3">
      <div class="text-sm text-muted-foreground">
        {{ results.length }} programa(s) encontrado(s):
      </div>
      
      <RadioGroup 
        :model-value="selectedIndex?.toString()" 
        @update:model-value="onPersonSelect"
        class="w-full space-y-2"
      >
        <div v-for="(person, index) in results" :key="index">
          <Label 
            :for="`person-${index}`" 
            class="flex cursor-pointer w-full"
          >
            <Card 
              :class="[
                'w-full px-3 py-2 transition-all duration-200 hover:shadow-sm',
                selectedIndex === index 
                  ? 'border border-primary bg-accent/50' 
                  : 'border hover:bg-accent/30 hover:border-primary/30'
              ]"
            >
              <div class="flex items-center justify-between">
                <div class="flex-1 min-w-0 space-y-0.5">
                  <div class="text-xs font-medium text-foreground">
                    {{ person.programa }}
                  </div>
                  <div class="text-xs text-muted-foreground">
                    {{ person.facultad }}
                  </div>
                  <div class="font-medium text-xs">
                    {{ person.nombres }} {{ person.paterno }} {{ person.materno }}
                  </div>
                  <div class="text-xs text-muted-foreground">
                    CI: {{ person.nro_dip }} • {{ person.pais }}
                  </div>
                </div>
                <RadioGroupItem 
                  :value="index.toString()" 
                  :id="`person-${index}`" 
                  class="shrink-0 ml-3" 
                />
              </div>
            </Card>
          </Label>
        </div>
      </RadioGroup>
    </div>

    <!-- Estado vacío -->
    <Alert v-if="!hasResults && !loading && !errorMessage && ci.length >= 3" class="w-full">
      <AlertCircle class="h-4 w-4" />
      <AlertDescription>
        Sin resultados para este CI. Proceda con registro manual.
      </AlertDescription>
    </Alert>
  </div>
</template>

<script setup lang="ts">
import { ref, watch } from 'vue'
import { Input } from '@/components/ui/input'
import { Button } from '@/components/ui/button'
import { Alert, AlertDescription } from '@/components/ui/alert'
import { Card } from '@/components/ui/card'
import { Skeleton } from '@/components/ui/skeleton'
import { RadioGroup, RadioGroupItem } from '@/components/ui/radio-group'
import { Label } from '@/components/ui/label'
import { Search, AlertCircle } from 'lucide-vue-next'
import { usePersonalDataStore } from '@/stores/usePersonalDataStore'
import { storeToRefs } from 'pinia'

// Store
const personalDataStore = usePersonalDataStore()
const { 
  ci, 
  loading, 
  results, 
  hasResults, 
  selectedIndex 
} = storeToRefs(personalDataStore)

// Estado local para error
const errorMessage = ref('')

// Manual search handler
const handleSearch = async () => {
  if (ci.value && ci.value.trim().length >= 3) {
    errorMessage.value = ''
    const result = await personalDataStore.search(ci.value.trim())
    if (!result.success) {
      errorMessage.value = result.error || 'Error en la búsqueda'
    }
  }
}

// Person selection handler
const onPersonSelect = (value: string) => {
  const index = parseInt(value)
  personalDataStore.select(index)
}

// Watch for clearing the input to reset results
watch(ci, (newValue) => {
  if (newValue.length === 0) {
    personalDataStore.$reset()
    errorMessage.value = ''
  }
})
</script>