// Tipos específicos para el módulo de Diplomas Académicos
// Cada tipo de título tiene sus propias modalidades y menciones específicas

import type {
  Persona,
  Carrera,
  Facultad,
  User
} from '../models'

// ============================================================================
// TIPOS DE RESPUESTA HTTP ESPECÍFICOS PARA DIPLOMAS ACADÉMICOS
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
// MODALIDADES DE GRADUACIÓN ESPECÍFICAS PARA DIPLOMAS ACADÉMICOS
// ============================================================================

export interface ModalidadDiplomaAcademico {
  diplomas_count: number
  id: number
  medio_graduacion: string
  created_at?: string
  updated_at?: string

  // Relaciones específicas del módulo
  diplomas_academicos?: DiplomaAcademico[]
  diplomas_academicos_count?: number
}

// ============================================================================
// MENCIONES ACADÉMICAS ESPECÍFICAS PARA DIPLOMAS ACADÉMICOS
// ============================================================================

export interface MencionDiplomaAcademico {
  id: number
  nombre: string
  carrera_id: string
  created_at?: string
  updated_at?: string

  // Relaciones específicas del módulo
  carrera?: Carrera
  diplomas_academicos?: DiplomaAcademico[]
}

// ============================================================================
// TIPO PRINCIPAL: DIPLOMA ACADÉMICO
// ============================================================================

export interface DiplomaAcademico {
  id: number
  ci: string // Foreign key a personas.ci
  nro_documento: number
  fojas: number
  libro: number
  fecha_emision?: string
  mencion_da_id: number // Foreign key a menciones_diploma_academico.id
  graduacion_id?: number // Foreign key a modalidades_diploma_academico.id
  observaciones?: string
  file_dir?: string
  verificado: boolean
  created_by: number
  updated_by?: number
  created_at?: string
  updated_at?: string

  // Relaciones específicas del módulo
  persona?: Persona
  mencion?: MencionDiplomaAcademico
  graduacion?: ModalidadDiplomaAcademico
  createdBy?: User
  updatedBy?: User

  // Atributos computados
  estado?: 'Digitalizado' | 'Pendiente de digitalización'
}

// ============================================================================
// TIPOS COMPUESTOS CON RELACIONES CARGADAS
// ============================================================================

export interface DiplomaAcademicoConRelaciones extends DiplomaAcademico {
  persona: Persona
  mencion: MencionDiplomaAcademico
  graduacion?: ModalidadDiplomaAcademico
  createdBy: User
  updatedBy?: User
}

export interface MencionDiplomaAcademicoConRelaciones extends MencionDiplomaAcademico {
  carrera: Carrera
  diplomas_academicos: DiplomaAcademico[]
}

export interface ModalidadDiplomaAcademicoConRelaciones extends ModalidadDiplomaAcademico {
  diplomas_academicos: DiplomaAcademico[]
}

// ============================================================================
// TIPOS PARA FORMULARIOS
// ============================================================================

export interface DiplomaAcademicoForm {
  ci: string
  nombres: string
  paterno: string
  materno: string
  nro_documento: number
  libro: number
  fojas: number
  fecha_emision?: string
  mencion_da_id: string
  graduacion_id?: string
  observaciones?: string
  file?: File | null
  _method?: 'POST' | 'PUT' | 'PATCH'
}

export interface MencionDiplomaAcademicoForm {
  nombre: string
  carrera_id: string
}

export interface ModalidadDiplomaAcademicoForm {
  medio_graduacion: string
}

// ============================================================================
// TIPOS PARA PAGINACIÓN Y LISTADOS
// ============================================================================

export interface DiplomaAcademicoListProps {
  diplomas: PaginatedResponse<DiplomaAcademico>
  filters: {
    search?: string
  }
}

export interface MencionesDiplomaAcademicoListProps {
  menciones: PaginatedResponse<MencionDiplomaAcademico>
  carreras: Facultad[]
}

export interface ModalidadesDiplomaAcademicoListProps {
  modalidades: PaginatedResponse<ModalidadDiplomaAcademico>
}

// ============================================================================
// TIPOS PARA ESTADOS DE UI Y DIAGLOGOS
// ============================================================================

export interface MencionDiplomaAcademicoDialogState {
  showFormDialog: boolean
  showDeleteDialog: boolean
  editingMencion: MencionDiplomaAcademico | null
  deletingMencion: MencionDiplomaAcademico | null
}

export interface ModalidadDiplomaAcademicoDialogState {
  showFormDialog: boolean
  showDeleteDialog: boolean
  editingModalidad: ModalidadDiplomaAcademico | null
  deletingModalidad: ModalidadDiplomaAcademico | null
}

// ============================================================================
// TIPOS PARA EXPORTACIÓN
// ============================================================================

export interface DiplomaAcademicoExportData {
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

export type DiplomaAcademicoSortField =
  | 'ci'
  | 'nombres'
  | 'nro_documento'
  | 'fecha_emision'
  | 'created_at'

export type DiplomaAcademicoFilter = {
  search?: string
  mencion_id?: number
  modalidad_id?: number
  estado?: 'todos' | 'digitalizado' | 'pendiente'
  fecha_desde?: string
  fecha_hasta?: string
}

export interface DiplomaAcademicoSearchParams {
  page?: number
  per_page?: number
  sort?: DiplomaAcademicoSortField
  order?: 'asc' | 'desc'
  filters?: DiplomaAcademicoFilter
}