# Reorganización de Tipos TypeScript - Agosto 2025

## Cambio arquitectural realizado

### Problema identificado
- Archivo `models.d.ts` mezclaba tipos de modelos Laravel con tipos de UI/navegación
- Inconsistencias entre nombres de campos de TypeScript y Laravel
- Código poco mantenible y confuso

### Solución implementada

#### 1. Separación de archivos
**Antes**: Todo en `resources/js/types/models.d.ts`
**Ahora**: 
- `resources/js/types/models.d.ts` - Solo tipos de modelos Laravel
- `resources/js/types/ui.d.ts` - Tipos de navegación y UI

#### 2. Corrección de campos de modelos
```typescript
// Antes (incorrecto)
export interface Facultad {
  nombre_facultad: string  // ❌ No existe en Laravel
  nombre: string          // ❌ Duplicado
}

export interface Carrera {
  nombre_carrera: string  // ❌ No existe en Laravel
}

// Ahora (correcto)
export interface Facultad {
  id: number
  nombre: string          // ✅ Coincide con migración Laravel
  direccion?: string
}

export interface Carrera {
  id: string             // ✅ char(5) primary key
  programa: string       // ✅ Coincide con migración Laravel
  direccion?: string
  facultad_id: number
}
```

#### 3. Archivo models.d.ts final
```typescript
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
  createdBy?: User
  updatedBy?: User
  estado?: string
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
```

#### 4. Archivo ui.d.ts creado
```typescript
// Tipos para navegación y elementos de UI
import { User } from './models'

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

export interface DiplomaPageProps extends PageProps {
    menciones?: import('./models').MencionDa[]
    graduaciones?: import('./models').GraduacionDa[]
    facultades?: import('./models').Facultad[]
    carreras?: import('./models').Carrera[]
}
```

#### 5. Archivos actualizados
- `resources/js/Pages/DiplomasAcademicos/Create.vue`: Import actualizado
- `resources/js/Pages/DiplomasAcademicos/Menciones.vue`: Import actualizado  
- `resources/js/Pages/DiplomasAcademicos/Modalidades.vue`: Import actualizado

### Beneficios obtenidos

1. **Separación de responsabilidades**: Modelos vs UI claramente divididos
2. **Consistencia con Laravel**: Campos TypeScript coinciden exactamente con migraciones
3. **Mantenibilidad**: Más fácil ubicar y actualizar tipos específicos
4. **Imports más claros**: `from '@/types/models'` vs `from '@/types/ui'`
5. **Corrección de bugs**: Select de carreras ahora muestra datos correctos
6. **Escalabilidad**: Arquitectura preparada para crecimiento del proyecto

### Archivos de referencia Laravel verificados
- `database/migrations/2025_07_31_161649_create_facultades_table.php`
- `database/migrations/2025_07_31_161709_create_carreras_table.php`
- `app/Models/DiplomaAcademico.php`
- `app/Models/Carrera.php`
- `app/Models/Facultad.php`

## Resultado
Sistema de tipos TypeScript completamente reorganizado, consistente con Laravel y mantenible a largo plazo.