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

// Tipos Mencion y Modalidad movidos a: resources/js/types/diplomas-academicos/index.ts
// Ahora cada tipo de título tiene sus propias modalidades y menciones específicas

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
