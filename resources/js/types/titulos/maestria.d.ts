import type { Persona, User } from '../models'
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

export interface MencionMaestria {
  id: number
  nombre: string
  activo: boolean
  maestrias_count?: number
  created_at?: string
  updated_at?: string
}

export interface ModalidadMaestria {
  id: number
  nombre: string
  activo: boolean
  maestrias_count?: number
  created_at?: string
  updated_at?: string
}

export interface Maestria {
  id: number
  ci: string
  nro_tpn: string
  mencion_tpn_id?: number | null
  nro_documento: number
  fojas?: number | null
  libro?: number | null
  fecha_emision?: string | null
  mencion_maestria_id?: number | null
  gestion_inicial?: number | null
  gestion_final?: number | null
  modalidad_maestria_id?: number | null
  horas_academicas?: number | null
  defensa_final?: number | null
  observaciones?: string | null
  carpeta?: string | null
  file_dir?: string | null
  verificado: boolean
  created_by: number
  updated_by?: number | null
  created_at?: string
  updated_at?: string
  persona?: Persona
  mencion?: MencionMaestria
  modalidad?: ModalidadMaestria
  mencionTpn?: MencionTpn | null
  createdBy?: User
  updatedBy?: User | null
  estado?: 'Digitalizado' | 'Pendiente de digitalización'
}

export interface MaestriaListProps {
  maestrias: PaginatedResponse<Maestria>
  filters: {
    search?: string
  }
}

export interface MaestriaForm {
  ci: string
  nombres: string
  paterno: string
  materno?: string
  nro_tpn: string
  mencion_tpn_id?: string
  nro_documento: number | string
  fojas?: number | string
  libro?: number | string
  fecha_emision?: string
  mencion_maestria_id: string
  gestion_inicial?: number | string
  gestion_final?: number | string
  modalidad_maestria_id: string
  horas_academicas?: number | string
  defensa_final?: number | string
  observaciones?: string
  file?: File | null
  _method?: 'POST' | 'PUT' | 'PATCH'
}

export interface MaestriaPageProps {
  menciones: MencionMaestria[]
  modalidades: ModalidadMaestria[]
  mencionesTpn: MencionTpn[]
}

export interface MaestriaWithRelations extends Maestria {
  persona: Persona
}
