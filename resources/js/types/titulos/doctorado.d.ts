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

export interface MencionDoctorado {
  id: number
  nombre: string
  activo: boolean
  doctorados_count?: number
  created_at?: string
  updated_at?: string
}

export interface ModalidadDoctorado {
  id: number
  nombre: string
  activo: boolean
  doctorados_count?: number
  created_at?: string
  updated_at?: string
}

export interface Doctorado {
  id: number
  ci: string
  nro_tpn: string
  mencion_tpn_id?: number | null
  nro_documento: number
  fojas?: number | null
  libro?: number | null
  fecha_emision?: string | null
  mencion_doctorado_id?: number | null
  gestion_inicial?: number | null
  gestion_final?: number | null
  version?: number | null
  modalidad_doctorado_id?: number | null
  horas_academicas?: number | null
  creditos_totales?: number | null
  observaciones?: string | null
  file_dir?: string | null
  verificado: boolean
  created_by: number
  updated_by?: number | null
  created_at?: string
  updated_at?: string
  persona?: Persona
  mencion?: MencionDoctorado
  modalidad?: ModalidadDoctorado
  mencionTpn?: MencionTpn | null
  createdBy?: User
  updatedBy?: User | null
  estado?: 'Digitalizado' | 'Pendiente de digitalización'
}

export interface DoctoradoListProps {
  doctorados: PaginatedResponse<Doctorado>
  filters: {
    search?: string
  }
}

export interface DoctoradoForm {
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
  mencion_doctorado_id: string
  gestion_inicial?: number | string
  gestion_final?: number | string
  version?: number | string
  modalidad_doctorado_id: string
  horas_academicas?: number | string
  creditos_totales?: number | string
  observaciones?: string
  file?: File | null
  _method?: 'POST' | 'PUT' | 'PATCH'
}

export interface DoctoradoPageProps {
  menciones: MencionDoctorado[]
  modalidades: ModalidadDoctorado[]
  mencionesTpn: MencionTpn[]
}

export interface DoctoradoWithRelations extends Doctorado {
  persona: Persona
}
