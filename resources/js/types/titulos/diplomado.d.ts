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

export interface MencionDiplomado {
  id: number
  nombre: string
  activo: boolean
  diplomados_count?: number
  created_at?: string
  updated_at?: string
}

export interface ModalidadDiplomado {
  id: number
  nombre: string
  activo: boolean
  diplomados_count?: number
  created_at?: string
  updated_at?: string
}

export interface Diplomado {
  id: number
  ci: string
  nro_tpn: string
  mencion_tpn_id?: number | null
  sexo?: string | null
  nro_documento: number
  fojas?: number | null
  libro?: number | null
  fecha_emision?: string | null
  mencion_diplomado_id?: number | null
  gestion?: number | null
  version?: number | null
  modalidad_diplomado_id?: number | null
  horas_creditos?: number | null
  trabajo_final?: boolean | null
  file_dir?: string | null
  verificado: boolean
  created_by: number
  updated_by?: number | null
  created_at?: string
  updated_at?: string
  persona?: Persona
  mencion?: MencionDiplomado
  modalidad?: ModalidadDiplomado
  mencionTpn?: MencionTpn | null
  createdBy?: User
  updatedBy?: User | null
  estado?: 'Digitalizado' | 'Pendiente de digitalización'
}

export interface DiplomadoListProps {
  diplomados: PaginatedResponse<Diplomado>
  filters: {
    search?: string
  }
}

export interface DiplomadoForm {
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
  mencion_diplomado_id?: string
  gestion?: number | string
  version?: number | string
  modalidad_diplomado_id?: string
  horas_creditos?: number | string
  trabajo_final?: boolean
  file?: File | null
  _method?: 'POST' | 'PUT' | 'PATCH'
}

export interface DiplomadoPageProps {
  menciones: MencionDiplomado[]
  modalidades: ModalidadDiplomado[]
  mencionesTpn: MencionTpn[]
  dependenciesReady?: boolean
}
