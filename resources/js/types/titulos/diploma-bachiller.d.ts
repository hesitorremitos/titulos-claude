import type { Persona, User } from '../models'

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

export interface MencionDiplomaBachiller {
  id: number
  nombre: string
  created_at?: string
  updated_at?: string
  diplomas_count?: number
}

export interface DiplomaBachiller {
  id: number
  ci: string
  nro_documento: number
  fojas: number
  libro: number
  fecha_emision?: string
  mencion_db_id: number
  observaciones?: string
  file_dir?: string
  verificado: boolean
  created_by: number
  updated_by?: number
  created_at?: string
  updated_at?: string
  persona?: Persona
  mencion?: MencionDiplomaBachiller
  createdBy?: User
  updatedBy?: User
  estado?: 'Digitalizado' | 'Pendiente de digitalización'
}

export interface DiplomaBachillerListProps {
  diplomas: PaginatedResponse<DiplomaBachiller>
  filters: {
    search?: string
  }
}

export interface MencionDiplomaBachillerListProps {
  menciones: PaginatedResponse<MencionDiplomaBachiller>
}

export interface DiplomaBachillerForm {
  ci: string
  nombres: string
  paterno: string
  materno: string
  nro_documento: number
  libro: number
  fojas: number
  fecha_emision?: string
  mencion_db_id: string
  observaciones?: string
  file?: File | null
  _method?: 'POST' | 'PUT' | 'PATCH'
}

export interface MencionDiplomaBachillerDialogState {
  showFormDialog: boolean
  showDeleteDialog: boolean
  editingMencion: MencionDiplomaBachiller | null
  deletingMencion: MencionDiplomaBachiller | null
}
