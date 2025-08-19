// Tipos de modelos Laravel para Inertia.js
export interface Facultad {
  id: number
  nombre: string
  direccion?: string
  created_at?: string
  updated_at?: string
  carreras?: Carrera[]
  carreras_count?: number
}

export interface Carrera {
  id: string // char(5) primary key
  programa: string
  direccion?: string
  facultad_id: number
  facultad?: Facultad
  created_at?: string
  updated_at?: string
}

export interface MencionDa {
  id: number
  nombre: string
  carrera_id: string
  carrera?: Carrera
  created_at?: string
  updated_at?: string
  diplomas?: DiplomaAcademico[]
}

export interface GraduacionDa {
  id: number
  medio_graduacion: string
  created_at?: string
  updated_at?: string
  diplomas?: DiplomaAcademico[]
  diplomas_count?: number
}

export interface User {
  id: number
  name: string
  email: string
  email_verified_at?: string
  created_at?: string
  updated_at?: string
}

export interface Persona {
  ci: string // Primary key
  nombres: string
  paterno?: string
  materno?: string
  fecha_nacimiento?: string
  genero?: 'M' | 'F' | 'O' // enum
  pais?: string
  departamento?: string
  provincia?: string
  localidad?: string
  created_at?: string
  updated_at?: string
}

export interface DiplomaAcademico {
  id: number
  ci: string // Foreign key to personas.ci
  nro_documento: number
  fojas: number
  libro: number
  fecha_emision?: string
  mencion_da_id: number
  observaciones?: string
  graduacion_id?: number
  file_dir?: string
  verificado: boolean
  created_by: number
  updated_by?: number
  created_at?: string
  updated_at?: string
  
  // Relaciones
  persona?: Persona
  mencion?: MencionDa
  graduacion?: GraduacionDa
  createdBy?: User
  updatedBy?: User
  // Computed attributes
  estado?: string
}

export interface TituloAcademico {
  id: number
  ci: string // Foreign key to personas.ci
  nro_documento: number
  fojas: number
  libro: number
  fecha_emision?: string
  nro_diploma_academico: string // Campo específico para este tipo de título
  observaciones?: string
  graduacion_id?: number
  file_dir?: string
  verificado: boolean
  created_by: number
  updated_by?: number
  created_at?: string
  updated_at?: string
  
  // Relaciones
  persona?: Persona
  graduacion?: GraduacionDa
  createdBy?: User
  updatedBy?: User
}

export interface PaginatedResponse<T> {
    data: T[];
    links: {
        url: string | null;
        label: string;
        active: boolean;
    }[];
    from: number;
    to: number;
    total: number;
    current_page: number;
    last_page: number;
    first_page_url: string;
    last_page_url: string;
    next_page_url: string | null;
    prev_page_url: string | null;
    path: string;
    per_page: number;
}
