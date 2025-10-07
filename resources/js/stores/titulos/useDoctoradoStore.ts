import { defineStore } from 'pinia'
import { usePersonalDataStore } from '../usePersonalDataStore'

interface DoctoradoState {
  nro_tpn: string
  mencion_tpn_id: number | string | undefined
  nro_documento: number | string | undefined
  fojas: number | string | undefined
  libro: number | string | undefined
  fecha_emision: string
  mencion_doctorado_id: number | string | undefined
  gestion_inicial: number | string | undefined
  gestion_final: number | string | undefined
  version: number | string | undefined
  modalidad_doctorado_id: number | string | undefined
  horas_academicas: number | string | undefined
  creditos_totales: number | string | undefined
  observaciones: string
  file: File | null
}

export const useDoctoradoStore = defineStore('doctorado', {
  state: (): DoctoradoState => ({
    nro_tpn: '',
    mencion_tpn_id: undefined,
    nro_documento: undefined,
    fojas: undefined,
    libro: undefined,
    fecha_emision: '',
    mencion_doctorado_id: undefined,
    gestion_inicial: undefined,
    gestion_final: undefined,
    version: undefined,
    modalidad_doctorado_id: undefined,
    horas_academicas: undefined,
    creditos_totales: undefined,
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
        mencion_doctorado_id: this.mencion_doctorado_id,
        gestion_inicial: this.gestion_inicial,
        gestion_final: this.gestion_final,
        version: this.version,
        modalidad_doctorado_id: this.modalidad_doctorado_id,
        horas_academicas: this.horas_academicas,
        creditos_totales: this.creditos_totales,
        observaciones: this.observaciones,
        file: this.file
      }
    }
  }
})
