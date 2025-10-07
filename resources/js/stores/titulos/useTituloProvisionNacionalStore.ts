import { defineStore } from 'pinia'
import { usePersonalDataStore } from '../usePersonalDataStore'

interface TituloProvisionNacionalState {
  nro_documento: number | string | undefined
  fojas: number | string | undefined
  libro: number | undefined
  fecha_emision: string
  mencion_tpn_id: number | undefined
  modalidad_tpn_id: number | undefined
  observaciones: string
  file: File | null
}

export const useTituloProvisionNacionalStore = defineStore('tituloProvisionNacional', {
  state: (): TituloProvisionNacionalState => ({
    nro_documento: undefined,
    fojas: undefined,
    libro: undefined,
    fecha_emision: '',
    mencion_tpn_id: undefined,
    modalidad_tpn_id: undefined,
    observaciones: '',
    file: null
  }),

  getters: {
    // Combina datos personales + título para envío
    formData(): any {
      const personalStore = usePersonalDataStore()

      return {
        // Datos personales
        ci: personalStore.ci,
        nombres: personalStore.nombres,
        paterno: personalStore.paterno,
        materno: personalStore.materno,

        // Datos título provisional nacional
        nro_documento: this.nro_documento,
        fojas: this.fojas,
        libro: this.libro,
        fecha_emision: this.fecha_emision,
        mencion_tpn_id: this.mencion_tpn_id,
        modalidad_tpn_id: this.modalidad_tpn_id,
        observaciones: this.observaciones,
        file: this.file
      }
    }
  }
})