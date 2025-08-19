// Tipos para navegación y elementos de UI

import { User } from './models'

// Tipos para navegación y UI
export interface NavTab {
    label: string;
    href: string;
    icon: string;
    value: string;
}

export interface BreadcrumbItem {
    label: string;
    href: string | null;
}

// Props comunes para páginas con autenticación
export interface PageProps {
    auth?: {
        user: User;
    };
    flash?: {
        success?: string;
        error?: string;
        warning?: string;
        info?: string;
    };
    errors?: Record<string, string>;
}

// Props específicas para páginas de diplomas
export interface DiplomaPageProps extends PageProps {
    menciones?: import('./models').MencionDa[]
    graduaciones?: import('./models').GraduacionDa[]
    facultades?: import('./models').Facultad[]
    carreras?: import('./models').Carrera[]
}