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
    menciones?: import('./models').Mencion[]
    graduaciones?: import('./models').Modalidad[]
    facultades?: import('./models').Facultad[]
    carreras?: import('./models').Carrera[]
}

// Props específicas para páginas de títulos provisionales nacionales
export interface TituloProvisionNacionalPageProps extends PageProps {
    menciones?: import('./titulos/titulo-provision-nacional').MencionTpn[]
    modalidades?: import('./titulos/titulo-provision-nacional').ModalidadTpn[]
}

export interface DiplomaBachillerPageProps extends PageProps {
    menciones?: import('./titulos/diploma-bachiller').MencionDiplomaBachiller[]
}

export interface MaestriaPageProps extends PageProps {
    menciones?: import('./titulos/maestria').MencionMaestria[]
    modalidades?: import('./titulos/maestria').ModalidadMaestria[]
    mencionesTpn?: import('./titulos/titulo-provision-nacional').MencionTpn[]
}

export interface DoctoradoPageProps extends PageProps {
    menciones?: import('./titulos/doctorado').MencionDoctorado[]
    modalidades?: import('./titulos/doctorado').ModalidadDoctorado[]
    mencionesTpn?: import('./titulos/titulo-provision-nacional').MencionTpn[]
    dependenciesReady?: boolean
}
