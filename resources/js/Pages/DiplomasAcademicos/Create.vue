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

      <!-- Layout de 2 columnas: Formularios | PDF Viewer -->
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 h-[calc(100vh-200px)]">
        <!-- Columna izquierda: Buscador + Formulario de persona -->
        <div class="space-y-6">
          <!-- Formulario de búsqueda de persona -->
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
          
          <!-- Formulario de datos personales -->
          <PersonalDataForm />
        </div>
        
        <!-- Columna derecha: PDF Viewer -->
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
import { Search } from 'lucide-vue-next'
import { usePersonalDataStore } from '@/stores/usePersonalDataStore'
import { storeToRefs } from 'pinia'

// Store setup
const personalDataStore = usePersonalDataStore()
const { selectedPersonData } = storeToRefs(personalDataStore)

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

// Page title for browser tab
defineOptions({
  title: 'Registrar Diploma Académico'
})
</script>