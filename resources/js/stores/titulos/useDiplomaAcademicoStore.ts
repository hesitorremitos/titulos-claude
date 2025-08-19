import { defineStore } from 'pinia'
import { usePersonalDataStore } from '../usePersonalDataStore'

interface DiplomaState {
  nro_documento: number | string | undefined
  fojas: number | string | undefined
  libro: number | undefined
  fecha_emision: string
  mencion_da_id: number | undefined
  observaciones: string
  graduacion_id: number | undefined
  file: File | null
}

export const useDiplomaAcademicoStore = defineStore('diplomaAcademico', {
  state: (): DiplomaState => ({
    nro_documento: undefined,
    fojas: undefined,
    libro: undefined,
    fecha_emision: '',
    mencion_da_id: undefined,
    observaciones: '',
    graduacion_id: undefined,
    file: null
  }),

  getters: {
    // Combina datos personales + diploma para envío
    formData(): any {
      const personalStore = usePersonalDataStore()
      
      return {
        // Datos personales
        ci: personalStore.ci,
        nombres: personalStore.nombres,
        paterno: personalStore.paterno,
        materno: personalStore.materno,
        
        // Datos diploma
        nro_documento: this.nro_documento,
        fojas: this.fojas,
        libro: this.libro,
        fecha_emision: this.fecha_emision,
        mencion_da_id: this.mencion_da_id,
        observaciones: this.observaciones,
        graduacion_id: this.graduacion_id,
        file: this.file
      }
    }
  }
})