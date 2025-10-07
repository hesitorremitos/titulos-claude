// Tipos específicos para el módulo de Títulos Provisional Nacionales
// Cada tipo de título tiene sus propias modalidades y menciones específicas

import type {
  Persona,
  User
} from '../models'

// ============================================================================
// TIPOS DE RESPUESTA HTTP ESPECÍFICOS PARA TÍTULOS PROVISIONAL NACIONALES
// ============================================================================

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

// ============================================================================
// MODALIDADES ESPECÍFICAS PARA TÍTULOS PROVISIONAL NACIONALES
// ============================================================================

export interface ModalidadTpn {
  titulos_count: number
  id: number
  nombre: string
  descripcion?: string
  activo: boolean
  created_at?: string
  updated_at?: string

  // Relaciones específicas del módulo
  titulos?: TituloProvisionNacional[]
  titulos_count?: number
}

// ============================================================================
// MENCIONES ESPECÍFICAS PARA TÍTULOS PROVISIONAL NACIONALES
// ============================================================================

export interface MencionTpn {
  id: number
  nombre: string
  descripcion?: string
  activo: boolean
  carrera_id?: string
  created_at?: string
  updated_at?: string

  // Relaciones específicas del módulo
  titulos?: TituloProvisionNacional[]
  titulos_count?: number
  carrera?: import('../models').Carrera
}

// ============================================================================
// TIPO PRINCIPAL: TÍTULO PROVISIONAL NACIONAL
// ============================================================================

export interface TituloProvisionNacional {
  id: number
  ci: string // Foreign key a personas.ci
  nro_documento: number
  fojas: number
  libro: number
  fecha_emision?: string
  observaciones?: string
  mencion_tpn_id?: number // Foreign key a menciones_tpn.id
  modalidad_tpn_id?: number // Foreign key a modalidades_tpn.id
  file_dir?: string
  verificado: boolean
  created_by: number
  updated_by?: number
  created_at?: string
  updated_at?: string

  // Relaciones específicas del módulo
  persona?: Persona
  mencion?: MencionTpn
  modalidad?: ModalidadTpn
  createdBy?: User
  updatedBy?: User

  // Atributos computados
  estado?: 'Digitalizado' | 'Pendiente de digitalización'
}

// ============================================================================
// TIPOS COMPUESTOS CON RELACIONES CARGADAS
// ============================================================================

export interface TituloProvisionNacionalConRelaciones extends TituloProvisionNacional {
  persona: Persona
  mencion?: MencionTpn
  modalidad?: ModalidadTpn
  createdBy: User
  updatedBy?: User
}

export interface MencionTpnConRelaciones extends MencionTpn {
  titulos: TituloProvisionNacional[]
}

export interface ModalidadTpnConRelaciones extends ModalidadTpn {
  titulos: TituloProvisionNacional[]
}

// ============================================================================
// TIPOS PARA FORMULARIOS
// ============================================================================

export interface TituloProvisionNacionalForm {
  ci: string
  nombres: string
  paterno: string
  materno: string
  nro_documento: number
  libro: number
  fojas: number
  fecha_emision?: string
  mencion_tpn_id?: string
  modalidad_tpn_id?: string
  observaciones?: string
  file?: File | null
  _method?: 'POST' | 'PUT' | 'PATCH'
}

export interface MencionTpnForm {
  nombre: string
  descripcion?: string
  activo: boolean
}

export interface ModalidadTpnForm {
  nombre: string
  descripcion?: string
  activo: boolean
}

// ============================================================================
// TIPOS PARA PAGINACIÓN Y LISTADOS
// ============================================================================

export interface TituloProvisionNacionalListProps {
  titulos: PaginatedResponse<TituloProvisionNacional>
  filters: {
    search?: string
  }
}

export interface MencionesTpnListProps {
  menciones: PaginatedResponse<MencionTpn>
}

export interface ModalidadesTpnListProps {
  modalidades: PaginatedResponse<ModalidadTpn>
}

// ============================================================================
// TIPOS PARA ESTADOS DE UI Y DIAGLOGOS
// ============================================================================

export interface MencionTpnDialogState {
  showFormDialog: boolean
  showDeleteDialog: boolean
  editingMencion: MencionTpn | null
  deletingMencion: MencionTpn | null
}

export interface ModalidadTpnDialogState {
  showFormDialog: boolean
  showDeleteDialog: boolean
  editingModalidad: ModalidadTpn | null
  deletingModalidad: ModalidadTpn | null
}

// ============================================================================
// TIPOS PARA EXPORTACIÓN
// ============================================================================

export interface TituloProvisionNacionalExportData {
  id: number
  ci: string
  nombres_completos: string
  nro_documento: number
  libro: number
  fojas: number
  fecha_emision: string
  mencion: string
  modalidad: string
  estado: string
  fecha_registro: string
}

// ============================================================================
// UTILIDADES Y TIPOS AUXILIARES
// ============================================================================

export type TituloProvisionNacionalSortField =
  | 'ci'
  | 'nombres'
  | 'nro_documento'
  | 'fecha_emision'
  | 'created_at'

export type TituloProvisionNacionalFilter = {
  search?: string
  mencion_id?: number
  modalidad_id?: number
  estado?: 'todos' | 'digitalizado' | 'pendiente'
  fecha_desde?: string
  fecha_hasta?: string
}

export interface TituloProvisionNacionalSearchParams {
  page?: number
  per_page?: number
  sort?: TituloProvisionNacionalSortField
  order?: 'asc' | 'desc'
  filters?: TituloProvisionNacionalFilter
}