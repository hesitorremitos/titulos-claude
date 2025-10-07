import { defineStore } from 'pinia'
import { usePersonalDataStore } from '../usePersonalDataStore'

interface DiplomaBachillerState {
  nro_documento: number | string | undefined
  fojas: number | string | undefined
  libro: number | string | undefined
  fecha_emision: string
  mencion_db_id: number | string | undefined
  observaciones: string
  file: File | null
}

export const useDiplomaBachillerStore = defineStore('diplomaBachiller', {
  state: (): DiplomaBachillerState => ({
    nro_documento: undefined,
    fojas: undefined,
    libro: undefined,
    fecha_emision: '',
    mencion_db_id: undefined,
    observaciones: '',
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

        // Datos diploma bachiller
        nro_documento: this.nro_documento,
        fojas: this.fojas,
        libro: this.libro,
        fecha_emision: this.fecha_emision,
        mencion_db_id: this.mencion_db_id,
        observaciones: this.observaciones,
        file: this.file
      }
    }
  }
})
