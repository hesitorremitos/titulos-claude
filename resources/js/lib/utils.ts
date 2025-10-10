import type { ClassValue } from 'clsx';
import { clsx } from 'clsx';
import { twMerge } from 'tailwind-merge';

export function cn(...inputs: ClassValue[]) {
    return twMerge(clsx(inputs));
}

export function formatHorasCreditos(value: string): string {
    const sanitized = value.replace(/[^0-9/]/g, '');

    const [rawHoras = '', rawYear = ''] = sanitized.split('/');
    const horas = rawHoras.slice(0, 6);
    const year = rawYear.slice(0, 4);
    const hasSlash = sanitized.includes('/') && (rawHoras.length > 0 || rawYear.length > 0);

    if (hasSlash) {
        return `${horas}/${year}`;
    }

    return horas;
}
