import { defineStore } from 'pinia'
import { searchPersonByCi, type ApiPersonResponse } from '@/lib/api'

interface PersonalDataState {
  // Datos personales - estado directo
  ci: string
  nombres: string
  paterno: string
  materno: string
  fecha_nacimiento: string
  genero: string
  pais: string
  departamento: string
  provincia: string
  localidad: string
  programa: string
  facultad: string
  
  // API auxiliar
  results: ApiPersonResponse[]
  selectedIndex: number | null
  loading: boolean
}

export const usePersonalDataStore = defineStore('personalData', {
  state: (): PersonalDataState => ({
    // Datos personales principales
    ci: '',
    nombres: '',
    paterno: '',
    materno: '',
    fecha_nacimiento: '',
    genero: '',
    pais: 'BOLIVIA',
    departamento: '',
    provincia: '',
    localidad: '',
    programa: '',
    facultad: '',
    
    // API auxiliar
    results: [],
    selectedIndex: null,
    loading: false
  }),

  getters: {
    hasResults: (state) => state.results.length > 0,
    isPersonDataComplete: (state) => 
      state.ci.length >= 6 && state.nombres.trim() && state.paterno.trim()
  },

  actions: {
    async search(ci: string) {
      this.ci = ci // Actualiza CI principal
      this.loading = true
      
      const result = await searchPersonByCi(ci)
      
      if (result.success && result.data) {
        this.results = result.data
        // Auto-select first result if only one
        if (result.data.length === 1) {
          this.select(0)
        }
      } else {
        // Si no encuentra, resetea resultados pero mantiene CI para entrada manual
        this.results = []
        this.selectedIndex = null
      }
      
      this.loading = false
      return result
    },

    select(index: number) {
      if (index >= 0 && index < this.results.length) {
        this.selectedIndex = index
        const person = this.results[index]
        
        // Actualiza todos los campos personales
        this.ci = person.nro_dip
        this.nombres = person.nombres
        this.paterno = person.paterno
        this.materno = person.materno
        this.fecha_nacimiento = person.fec_nacimiento
        this.genero = person.genero
        this.pais = person.pais
        this.departamento = person.departamento
        this.provincia = person.provincia
        this.localidad = person.localidad
        this.programa = person.programa
        this.facultad = person.facultad
      }
    },


    reset() {
      this.ci = ''
      this.nombres = ''
      this.paterno = ''
      this.materno = ''
      this.fecha_nacimiento = ''
      this.genero = ''
      this.pais = 'BOLIVIA'
      this.departamento = ''
      this.provincia = ''
      this.localidad = ''
      this.programa = ''
      this.facultad = ''
      this.results = []
      this.selectedIndex = null
    }
  }
})