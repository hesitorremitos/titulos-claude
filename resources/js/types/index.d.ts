import type { Config } from 'ziggy-js';

// Importar declaraciones de componentes Vue
/// <reference path="./vue-shims.d.ts" />

export interface Auth {
    user: User;
}

export type AppPageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    name: string;
    quote: { message: string; author: string };
    auth: Auth;
    ziggy: Config & { location: string };
};

export interface User {
    id: number;
    role: string;
    name: string;
    email: string;
    ci: string;
    avatar?: string;
    email_verified_at: string | null;
    created_at: string;
    updated_at: string;
    roles?: string[]; // Array of role names from Spatie
    permissions?: string[]; // Array of permission names from Spatie
}

export interface Role {
    id: number;
    name: string;
    guard_name: string;
    created_at: string;
    updated_at: string;
}

export interface NavTab {
    label: string;
    href?: string;
    icon: string;
    value: string;
}

export interface BreadcrumbItem {
    label: string;
    href: string | null;
}
