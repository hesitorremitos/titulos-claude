import { defineStore } from 'pinia'
import { usePersonalDataStore } from '../usePersonalDataStore'

interface DiplomadoState {
  nro_tpn: string
  mencion_tpn_id: number | string | undefined
  sexo: string
  nro_documento: number | string | undefined
  fojas: number | string | undefined
  libro: number | string | undefined
  fecha_emision: string
  mencion_diplomado_id: number | string | undefined
  gestion: number | string | undefined
  version: number | string | undefined
  modalidad_diplomado_id: number | string | undefined
  horas_creditos: number | string | undefined
  trabajo_final: boolean
  file: File | null
}

export const useDiplomadoStore = defineStore('diplomado', {
  state: (): DiplomadoState => ({
    nro_tpn: '',
    mencion_tpn_id: undefined,
    sexo: '',
    nro_documento: undefined,
    fojas: undefined,
    libro: undefined,
    fecha_emision: '',
    mencion_diplomado_id: undefined,
    gestion: undefined,
    version: undefined,
    modalidad_diplomado_id: undefined,
    horas_creditos: undefined,
    trabajo_final: false,
    file: null
  }),

  getters: {
    formData(): any {
      const personalStore = usePersonalDataStore()

      return {
        ci: personalStore.ci,
        nombres: personalStore.nombres,
        paterno: personalStore.paterno,
        materno: personalStore.materno,
        nro_tpn: this.nro_tpn,
        mencion_tpn_id: this.mencion_tpn_id,
        sexo: this.sexo,
        nro_documento: this.nro_documento,
        fojas: this.fojas,
        libro: this.libro,
        fecha_emision: this.fecha_emision,
        mencion_diplomado_id: this.mencion_diplomado_id,
        gestion: this.gestion,
        version: this.version,
        modalidad_diplomado_id: this.modalidad_diplomado_id,
        horas_creditos: this.horas_creditos,
        trabajo_final: this.trabajo_final,
        file: this.file
      }
    }
  }
})
