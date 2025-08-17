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

      <!-- Formulario de datos personales y visor PDF - Layout de 2 columnas -->
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div>
          <PersonalDataForm />
        </div>
        <div>
          <PdfViewer 
            v-model="pdfFile" 
            @filename-changed="handleFilenameChanged"
            @file-selected="handleFileSelected"
            @file-removed="handleFileRemoved"
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
import { extractCIFromFilename, isValidBolivianCI } from '@/lib/documents'

// Store setup
const personalDataStore = usePersonalDataStore()
const { selectedPersonData } = storeToRefs(personalDataStore)

// PDF handling
const pdfFile = ref<File | null>(null)

// Event handlers for PdfViewer
const handleFilenameChanged = (filename: string) => {
  console.log('Filename changed:', filename)
  
  // Extract CI from filename
  const ci = extractCIFromFilename(filename)
  console.log('Extracted CI:', ci)
  
  if (ci && isValidBolivianCI(ci)) {
    console.log('Valid CI found, searching person...')
    // Trigger automatic person search
    personalDataStore.searchPersonInApi(ci)
  } else {
    console.log('No valid CI found in filename')
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