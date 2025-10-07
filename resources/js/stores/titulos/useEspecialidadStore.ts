import { defineStore } from 'pinia'
import { usePersonalDataStore } from '../usePersonalDataStore'

interface EspecialidadState {
  nro_tpn: string
  mencion_tpn_id: number | string | undefined
  sexo: string
  nro_documento: number | string | undefined
  fojas: number | string | undefined
  libro: number | string | undefined
  fecha_emision: string
  mencion_especialidad_id: number | string | undefined
  gestion: number | string | undefined
  version: number | string | undefined
  modalidad_especialidad_id: number | string | undefined
  horas_academicas: string
  promedio_final: boolean
  universidad_id: number | string | undefined
  file: File | null
}

export const useEspecialidadStore = defineStore('especialidad', {
  state: (): EspecialidadState => ({
    nro_tpn: '',
    mencion_tpn_id: undefined,
    sexo: '',
    nro_documento: undefined,
    fojas: undefined,
    libro: undefined,
    fecha_emision: '',
    mencion_especialidad_id: undefined,
    gestion: undefined,
    version: undefined,
    modalidad_especialidad_id: undefined,
    horas_academicas: '',
    promedio_final: false,
    universidad_id: '',
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
        mencion_especialidad_id: this.mencion_especialidad_id,
        gestion: this.gestion,
        version: this.version,
        modalidad_especialidad_id: this.modalidad_especialidad_id,
        horas_academicas: this.horas_academicas,
        promedio_final: this.promedio_final,
        universidad_id: this.universidad_id,
        file: this.file
      }
    }
  }
})
