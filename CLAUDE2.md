# PRD — Sistema de Digitalización de Títulos Académicos (Versión Inertia + Vue 3)

Este documento define únicamente los REQUERIMIENTOS (funcionales y no funcionales) y características deseadas para implementar el sistema usando **Laravel + Inertia.js + Vue 3 + TypeScript** (opcional pero recomendado), reemplazando gradualmente Blade/Livewire. No describe estructura de carpetas ni decisiones internas actuales. Sirve como prompt base para recrear el proyecto desde cero.

---
## 1. Objetivo General
Digitalizar, registrar, consultar y administrar Diplomas / Títulos Académicos de la Universidad Autónoma Tomás Frías (UATF), sustituyendo procesos manuales basados en archivos físicos por un flujo web seguro, auditable y eficiente.

---
## 2. Alcance Inicial
Incluye:
- Gestión de personas y sus títulos/diplomas académicos.
- Gestión de catálogos maestros: Facultades, Carreras, Menciones, Modalidades de Graduación.
- Registro y visualización de documentos PDF (diplomas digitalizados).
- Integración con API externa universitaria para autocompletar datos personales mediante CI (Carnet de Identidad).
- Control de acceso por roles/permisos (Administrador, Jefe, Personal).
- Auditoría básica (usuario creador / modificador, timestamps).
- Tema claro/oscuro persistente.

Excluye (fase futura):
- Notificaciones por correo.
- Flujos de firma digital.
- Integración con almacenamiento externo (S3) — se asume storage local inicialmente.

---
## 3. Tipos de Títulos Iniciales
1. Diplomas Académicos (Diplomas Académicos internos).
2. Títulos Profesionales.
3. Diplomas de Bachiller.

Cada tipo puede compartir un modelo base conceptual (atributos comunes: persona, carrera, fecha emisión, estado, PDF, auditoría) y extender campos específicos.

---
## 4. Roles y Permisos
| Rol | Capacidades | Restricciones |
|-----|-------------|---------------|
| Administrador | CRUD completo de todo el sistema, asignar roles | Ninguna |
| Jefe | Lectura global, auditoría visible | No modifica registros |
| Personal | Crear y gestionar SOLO títulos que registra | No ve ni edita títulos ajenos |

Permisos granulares (ejemplos): `facultades.view`, `facultades.create`, `diplomas.create`, `diplomas.update`, `diplomas.view_all`.

---
## 5. Reglas de Negocio Clave
1. Un mismo individuo no debe registrar duplicados conflictivos del mismo tipo y carrera (validación de unicidad lógica configurable).
2. CI (Carnet de Identidad) es identificador único de persona (string exacto, puede contener letras). Validar formato nacional básico.
3. Fechas de emisión no pueden ser futuras.
4. Tamaño máximo de PDF: 50 MB.
5. Estados de un título: 
   - `PENDIENTE_DIGITALIZACION` (sin PDF todavía)
   - `DIGITALIZADO` (PDF adjunto)
6. Campos libro / fojas / número documento (si aplican) únicos por combinación regla institucional.
7. Catálogos (Facultad, Carrera, Mención, Modalidad) deben existir antes de asociar al título.
8. Auditoría obligatoria: `created_by`, `updated_by`, timestamps.
9. Eliminaciones: duras (no soft delete) en fase inicial.
10. Al subir nuevo PDF sustituye el anterior (mantener sólo versión activa).

---
## 6. Flujo de Registro de Diploma / Título (UI)
1. Ingreso de CI → botón “Buscar en API” → llamada a API externa `GET/POST https://apititulos.uatf.edu.bo/api/datos?ru='{ci}'` (CI entre comillas simples) → lista de resultados académicos.
2. Selección de una línea académica (facultad / carrera / plan) para prellenar.
3. Completar/editar campos adicionales (mención, modalidad graduación, número libro, fojas, número documento, fechas, etc.).
4. Adjuntar PDF (arrastrar y soltar o selección). Mostrar vista previa PDF embebida (altura optimizada para tamaño oficio ~850px mínimo).
5. Validaciones en tiempo real (frontend + backend) antes de confirmar.
6. Guardar → estado cambia según existencia de PDF.
7. Mensaje de confirmación / notificación tipo toast.

---
## 7. Integración con API Externa
- Endpoint: `https://apititulos.uatf.edu.bo/api/datos?ru='{ci}'`.
- Respuesta: array de registros académicos (atributos: nombres, apellidos, códigos carrera, programa, etc.).
- Manejo de errores: tiempo de espera, formato inesperado, sin resultados.
- Estrategia caching opcional (memoria 5–10 min) para reducir llamadas consecutivas.

---
## 8. Funcionalidades de Búsqueda y Filtro
- Búsqueda por CI, nombres, carrera, facultad.
- Filtros por estado (digitalizado / pendiente), rango de fechas, tipo de título.
- Ordenación por fecha de emisión descendente por defecto.
- Paginación server-side (Inertia partial reloads / preserve scroll).

---
## 9. UI / UX Requerida
- Stack SPA híbrida: Laravel (routing servidor) + Inertia (sin API REST explícita inicial) + Vue 3 + Composition API.
- Compatibilidad mobile básica (layout responsive, stacking en columnas).
- Tema claro/oscuro persistente usando `localStorage` y `prefers-color-scheme` inicial.
- Componentes base reutilizables: Botón, Card, Tabla, CampoFormulario, Select buscable, Toast, Modal (futuro), PDFViewer.
- Accesibilidad: etiquetas asociadas, focus management en formularios, contraste AA.
- Feedback visual consistente (spinners en llamadas, deshabilitar botones durante envío).

---
## 10. Módulos Funcionales
1. Autenticación (login / logout / protección rutas). 
2. Dashboard simple (resumen: totales digitalizados vs pendientes, últimos registrados por usuario actual). 
3. Gestión catálogos: Facultades, Carreras, Menciones, Modalidades Graduación (CRUD con validaciones básicas). 
4. Gestión Personas (creadas on-demand al registrar título si no existen). 
5. Gestión Diplomas/Títulos (CRUD completo + upload PDF). 
6. Visor PDF incrustado (soporta drag & drop sobre zona designada). 
7. Sistema de permisos basado en roles (Spatie Permission en backend). 
8. Auditoría visible: mostrar creador y última modificación en vista detalle.

---
## 11. Requerimientos Técnicos (Back + Front)
- Laravel 12.x.
- Inertia.js (Laravel Adapter) + Vue 3.
- Vite para bundling (multi entry si se conserva parte Blade durante transición).
- TypeScript recomendado (interfaces para entidades: Persona, Título, etc.).
- Axios para solicitudes adicionales (API externa, acciones custom).
- Validación: Form Requests + feedback Inertia form errors.
- Control de acceso: Middleware + Policies opcionales.
- Manejo de archivos: Storage local `storage/app/public` + symlink a `public/storage`.
- Hash de archivos PDF (opcional) para detectar reemplazos iguales.
- Limitar tamaño de subida con configuración PHP e interceptar en frontend (mostrar error inmediato).

---
## 12. Seguridad
- CSRF estándar Laravel.
- Sanitización de entradas (validador Laravel + escapes en Vue templates).
- Restricción de rutas a roles adecuados.
- Prevención de enumeración de IDs: usar IDs incrementales normales pero siempre filtrar por permisos.
- Validar tipo MIME real del PDF (no sólo extensión).

---
## 13. Rendimiento / Escalabilidad
- Eager loading por defecto en listados (persona, facultad, carrera, mención, modalidad) para evitar N+1.
- Paginación server-side (25 ítems por página configurable).
- Indexes DB: CI persona, combinaciones únicas (persona_id + carrera_id + tipo + año opcional), campos buscados.
- Carga diferida (deferrable props Inertia) para métricas secundarias (si necesario).

---
## 14. Observabilidad / Registro
- Logging de errores críticos (subida fallida, API externa caída).
- Registrar intentos fallidos de subida con tamaño y nombre (debug).
- (Futuro) Métricas: conteo de títulos por estado.

---
## 15. Estados de Error & Mensajes
| Caso | Mensaje amigable | Acción propuesta |
|------|------------------|------------------|
| API externa sin respuesta | "No se pudo obtener datos académicos. Intenta nuevamente." | Botón reintentar | 
| PDF > límite | "El archivo excede el tamaño máximo permitido (50MB)." | Bloquear envío |
| Duplicado lógico | "Ya existe un título similar registrado para esta persona y carrera." | Mostrar enlace a existente |
| Validación de fecha | "La fecha de emisión no puede ser futura." | Resaltar campo |

---
## 16. Consideraciones de Migración (si coexistirá con Blade/Livewire)
- Rutas nuevas podrán convivir con existentes; Inertia devolverá vistas específicas (`app.blade.php` base Inertia).
- Generar layout base único para Inertia (header/sidebar reutilizable) migrando gradualmente componentes.
- Evitar ejecución simultánea conflictiva de Alpine plugins que redefinan propiedades globales (aislar inicialización si se mantiene algo de Alpine temporalmente).

---
## 17. Internacionalización
- Fase inicial solo español (ES). Preparar estructura para futura i18n (strings centralizados en objeto/archivo). 

---
## 18. Métricas de Éxito (Done Criteria)
- Registrar un diploma completo (con PDF) sin errores.
- Autocomplete desde API externa funcional (tiempo < 3s). 
- Búsqueda por CI devuelve resultados correctos. 
- Control de permisos: usuario "Personal" no ve diploma ajeno. 
- Tema oscuro persiste tras recarga y logout/login.
- Archivo PDF visible inline en visor dedicado. 

---
## 19. Roadmap Futuro (Fuera de Alcance Inmediato)
- Versionado de PDFs históricos.
- Exportaciones (CSV / PDF listados). 
- Firma digital y metadatos de validación. 
- Notificaciones (correo / in-app). 
- Módulo de estadísticas gráficas.
- Integración S3 / almacenamiento distribuido.

---
## 20. Resumen Corto Promptable
"Construir aplicación Laravel 12 + Inertia + Vue 3 para registrar y administrar diplomas académicos (personas, facultades, carreras, menciones, modalidades), con roles (Administrador, Jefe, Personal), auditoría, validaciones estrictas (fechas no futuras, PDF ≤50MB, unicidad lógica), integración API externa CI para autocompletar datos, visor PDF arrastrar/soltar, filtros/paginación server-side, tema oscuro persistente y arquitectura escalable sin exponer una API REST pública inicial."

---
## 21. Suposiciones
- Usuarios ya existen o se crearán con seeder inicial.
- API externa permanecerá estable (formato de respuesta consistente).
- Tamaño máximo de archivo configurable vía `.env`.

---
## 22. Riesgos
| Riesgo | Mitigación |
|--------|------------|
| API externa no disponible | Mensaje + reintento + registro log |
| Conflictos migración Livewire → Inertia | Aislar bundles y layouts | 
| PDFs grandes degradan rendimiento | Límite + compresión opcional futura |
| Roles mal configurados generan fuga datos | Tests manuales roles críticos |

---
Fin del PRD.
