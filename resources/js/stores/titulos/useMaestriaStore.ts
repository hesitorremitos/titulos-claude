import { defineStore } from 'pinia'
import { usePersonalDataStore } from '../usePersonalDataStore'

interface MaestriaState {
  nro_tpn: string
  mencion_tpn_id: number | string | undefined
  nro_documento: number | string | undefined
  fojas: number | string | undefined
  libro: number | string | undefined
  fecha_emision: string
  mencion_maestria_id: number | string | undefined
  gestion_inicial: number | string | undefined
  gestion_final: number | string | undefined
  modalidad_maestria_id: number | string | undefined
  horas_academicas: string
  defensa_final: number | string | undefined
  observaciones: string
  file: File | null
}

export const useMaestriaStore = defineStore('maestria', {
  state: (): MaestriaState => ({
    nro_tpn: '',
    mencion_tpn_id: undefined,
    nro_documento: undefined,
    fojas: undefined,
    libro: undefined,
    fecha_emision: '',
    mencion_maestria_id: undefined,
    gestion_inicial: undefined,
    gestion_final: undefined,
    modalidad_maestria_id: undefined,
    horas_academicas: '',
    defensa_final: undefined,
    observaciones: '',
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
        nro_documento: this.nro_documento,
        fojas: this.fojas,
        libro: this.libro,
        fecha_emision: this.fecha_emision,
        mencion_maestria_id: this.mencion_maestria_id,
        gestion_inicial: this.gestion_inicial,
        gestion_final: this.gestion_final,
        modalidad_maestria_id: this.modalidad_maestria_id,
        horas_academicas: this.horas_academicas,
        defensa_final: this.defensa_final,
        observaciones: this.observaciones,
        file: this.file
      }
    }
  }
})
