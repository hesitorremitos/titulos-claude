import type { Persona, User, UniversidadModel } from '../models'
import type { MencionTpn } from './titulo-provision-nacional'

export interface PaginatedResponse<T> {
  data: T[]
  links: {
    url: string | null
    label: string
    active: boolean
  }[]
  from: number
  to: number
  total: number
  current_page: number
  last_page: number
  first_page_url: string
  last_page_url: string
  next_page_url: string | null
  prev_page_url: string | null
  path: string
  per_page: number
}

export interface MencionEspecialidad {
  id: number
  nombre: string
  activo: boolean
  especialidades_count?: number
  created_at?: string
  updated_at?: string
}

export interface ModalidadEspecialidad {
  id: number
  nombre: string
  activo: boolean
  especialidades_count?: number
  created_at?: string
  updated_at?: string
}

export type Universidad = UniversidadModel

export interface Especialidad {
  id: number
  ci: string
  nro_tpn: string
  mencion_tpn_id?: number | null
  sexo?: string | null
  nro_documento: number
  fojas?: number | null
  libro?: number | null
  fecha_emision?: string | null
  mencion_especialidad_id?: number | null
  gestion?: number | null
  version?: number | null
  modalidad_especialidad_id?: number | null
  horas_academicas?: string | null
  promedio_final?: boolean | null
  universidad_id: number
  file_dir?: string | null
  verificado: boolean
  created_by: number
  updated_by?: number | null
  created_at?: string
  updated_at?: string
  persona?: Persona
  mencion?: MencionEspecialidad
  modalidad?: ModalidadEspecialidad
  mencionTpn?: MencionTpn | null
  universidad?: Universidad | null
  createdBy?: User
  updatedBy?: User | null
  estado?: 'Digitalizado' | 'Pendiente de digitalización'
}

export interface EspecialidadListProps {
  especialidades: PaginatedResponse<Especialidad>
  filters: {
    search?: string
  }
}

export interface EspecialidadForm {
  ci: string
  nombres: string
  paterno: string
  materno?: string
  nro_tpn: string
  mencion_tpn_id?: string
  sexo?: string
  nro_documento: number | string
  fojas?: number | string
  libro?: number | string
  fecha_emision?: string
  mencion_especialidad_id?: string
  gestion?: number | string
  version?: number | string
  modalidad_especialidad_id?: string
  horas_academicas?: string
  promedio_final?: boolean
  universidad_id: string
  file?: File | null
  _method?: 'POST' | 'PUT' | 'PATCH'
}

export interface EspecialidadPageData {
  menciones: MencionEspecialidad[]
  modalidades: ModalidadEspecialidad[]
  mencionesTpn: MencionTpn[]
  universidades: Universidad[]
  dependenciesReady?: boolean
}
