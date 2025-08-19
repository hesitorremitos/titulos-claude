export interface Persona {
    nombres: string;
    paterno: string;
    materno: string | null;
}

export interface Mencion {
    nombre: string;
}

export interface DiplomaAcademico {
    id: number;
    ci: string;
    fecha_emision: string;
    persona: Persona;
    mencion: Mencion;
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
