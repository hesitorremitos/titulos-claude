import { defineStore } from 'pinia'
import { ref } from 'vue'
import axios from 'axios'

export interface ApiResponse {
  paterno: string
  materno: string
  nombres: string
  nro_dip: string
  genero: string
  fec_nacimiento: string
  pais: string
  departamento: string
  provincia: string
  localidad: string
  programa: string
  facultad: string
  decano_nombres: string
  modalidad_graduacion: string
  nota_graduacion: string
  modalidad: string | null
  nota: string | null
  titulo: string | null
  titulo_graduacion: string | null
  grado_academico: string | null
}

export const usePersonalDataStore = defineStore('personalData', () => {
  // State
  const searchCi = ref('')
  const isSearching = ref(false)
  const apiData = ref<ApiResponse[]>([])
  const personFound = ref(false)
  const hasError = ref(false)
  const errorMessage = ref('')
  const selectedPersonIndex = ref<number | null>(null)
  const selectedPersonData = ref<ApiResponse | null>(null)

  // Actions
  const searchPersonInApi = async (ci: string) => {
    if (!ci || ci.length < 3) {
      resetSearchResults()
      return
    }

    try {
      isSearching.value = true
      hasError.value = false
      errorMessage.value = ''

      const response = await axios.get(`/v2/api/${ci}`)
      
      if (response.data && Array.isArray(response.data) && response.data.length > 0) {
        apiData.value = response.data
        personFound.value = true
        // Auto-select first result if only one
        if (response.data.length === 1) {
          selectPerson(0)
        }
      } else {
        resetSearchResults()
      }
    } catch (error) {
      console.error('Error searching person:', error)
      hasError.value = true
      errorMessage.value = 'Error al buscar en la API universitaria'
      resetSearchResults()
    } finally {
      isSearching.value = false
    }
  }

  const selectPerson = (index: number) => {
    if (index >= 0 && index < apiData.value.length) {
      selectedPersonIndex.value = index
      selectedPersonData.value = apiData.value[index]
    }
  }

  const resetSearchResults = () => {
    apiData.value = []
    personFound.value = false
    selectedPersonIndex.value = null
    selectedPersonData.value = null
  }

  const retrySearch = () => {
    if (searchCi.value) {
      searchPersonInApi(searchCi.value)
    }
  }

  const setCiAndSearch = async (ci: string) => {
    if (!ci || ci.length < 3) return
    
    searchCi.value = ci
    await searchPersonInApi(ci)
  }

  return {
    // State
    searchCi,
    isSearching,
    apiData,
    personFound,
    hasError,
    errorMessage,
    selectedPersonIndex,
    selectedPersonData,
    
    // Actions
    searchPersonInApi,
    selectPerson,
    resetSearchResults,
    retrySearch,
    setCiAndSearch
  }
})