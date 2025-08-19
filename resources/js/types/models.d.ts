// Tipos de modelos para Inertia.js
export interface Facultad {
  id: string
  nombre: string
  created_at?: string
  updated_at?: string
}

export interface Carrera {
  id: string
  nombre: string
  facultad_id: string
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
}

export interface GraduacionDa {
  id: number
  medio_graduacion: string
  created_at?: string
  updated_at?: string
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
  ci: string
  nombres?: string
  paterno?: string
  materno?: string
  fecha_nacimiento?: string
  genero?: string
  pais?: string
  departamento?: string
  provincia?: string
  localidad?: string
  created_at?: string
  updated_at?: string
}

export interface DiplomaAcademico {
  id: number
  ci: string
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
  creator?: User
  updater?: User
}

export interface TituloAcademico {
  id: number
  ci: string
  nro_documento: number
  fojas: number
  libro: number
  fecha_emision?: string
  nro_diploma_academico?: string
  observaciones?: string
  file_dir?: string
  verificado: boolean
  created_by: number
  updated_by?: number
  created_at?: string
  updated_at?: string
  
  // Relaciones
  persona?: Persona
  creator?: User
  updater?: User
}

// Props específicas para páginas de diplomas
export interface DiplomaPageProps {
  auth?: {
    user: User
  }
  flash?: {
    success?: string
    error?: string
    warning?: string
    info?: string
  }
  menciones?: MencionDa[]
  graduaciones?: GraduacionDa[]
  facultades?: Facultad[]
  carreras?: Carrera[]
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
