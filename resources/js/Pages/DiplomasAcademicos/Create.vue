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

      <!-- Formulario de búsqueda de persona -->
      <div class="max-w-2xl">
        <Card>
          <CardHeader>
            <CardTitle class="flex items-center">
              <Search class="h-5 w-5 mr-2" />
              Paso 1: Buscar Persona
            </CardTitle>
            <CardDescription>
              Ingrese el CI para buscar automáticamente los datos de la persona en el sistema universitario
            </CardDescription>
          </CardHeader>
          <CardContent>
            <ApiPersonSearch />
          </CardContent>
        </Card>
      </div>

      <!-- Formulario de datos personales -->
      <div class="max-w-2xl">
        <PersonalDataForm />
      </div>

      <!-- Próximo paso placeholder -->
      <div v-if="selectedPersonData" class="max-w-2xl">
        <Card class="border-dashed">
          <CardHeader>
            <CardTitle class="flex items-center text-muted-foreground">
              <FileText class="h-5 w-5 mr-2" />
              Paso 2: Datos del Diploma
            </CardTitle>
            <CardDescription>
              El formulario de datos del diploma se implementará próximamente
            </CardDescription>
          </CardHeader>
          <CardContent>
            <div class="text-center py-8 text-muted-foreground">
              <FileText class="h-12 w-12 mx-auto mb-3 opacity-50" />
              <p>Próximamente: Formulario de datos del diploma académico</p>
            </div>
          </CardContent>
        </Card>
      </div>
    </div>
  </AppLayout>
</template>

<script setup lang="ts">
import { computed } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import ApiPersonSearch from '@/components/forms/ApiPersonSearch.vue'
import PersonalDataForm from '@/components/forms/PersonalDataForm.vue'
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card'
import { Search, FileText } from 'lucide-vue-next'
import { usePersonalDataStore } from '@/stores/usePersonalDataStore'
import { storeToRefs } from 'pinia'

// Store setup
const personalDataStore = usePersonalDataStore()
const { selectedPersonData } = storeToRefs(personalDataStore)

// Page title for browser tab
defineOptions({
  title: 'Registrar Diploma Académico'
})
</script>