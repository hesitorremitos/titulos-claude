# Requerimientos del Sistema de Digitalización de Títulos
## Universidad Autónoma Tomás Frías - Departamento de Títulos

---

## 1. Descripción del Proyecto

**Contexto:** Sistema web para digitalizar títulos académicos del Departamento de Títulos de la UATF, Potosí, Bolivia.

**Propósito:** Reemplazar el sistema manual de archivo físico por un sistema digital que permita registro, búsqueda y gestión eficiente de títulos académicos.

**Tipos de Títulos a Digitalizar:**
- Diplomas Académicos
- Títulos Profesionales  
- Diplomas de Bachiller

**Nota:** Implementación inicial para estos 3 tipos. El sistema debe ser escalable para añadir posteriormente maestrías, doctorados y otros tipos de títulos de posgrado.

---

## 2. Usuarios del Sistema

**Administrador:**
- Acceso completo: crear, leer, actualizar, eliminar todo
- Gestión de usuarios y datos maestros (facultades, carreras)

**Jefe:**
- Visualización de todos los títulos
- Puede ver quién registró cada título
- No puede modificar datos

**Personal:**
- Solo puede gestionar títulos que él mismo registró
- CRUD completo sobre sus propios registros

---

## 3. Alcance del Proyecto

### Funcionalidades Incluidas
- Autenticación por CI y contraseña
- Sistema de roles (Administrador, Jefe, Personal)
- Registro manual de títulos
- Registro de personas sin título digitalizado (casos de pérdida)
- Búsqueda por: CI, nombre, medio de graduación, sexo, carrera, facultad
- Integración con API universitaria para agilizar llenado de datos personales
- Visualizador de PDF integrado
- Trazabilidad: registro de quién y cuándo se creó/modificó cada título
- Gestión de datos maestros del sistema
- Estadísticas avanzadas del sistema

### Funcionalidades Excluidas
- Portal público para estudiantes
- Emisión de nuevos títulos físicos
- Notificaciones automáticas
- App móvil

### Trabajos Posteriores (Post-implementación)
- Migración automática de PDFs existentes (CI como nombre de archivo)
- Proceso de carga masiva de documentos históricos

---

## 4. Requerimientos Funcionales

### RF001 - Autenticación
- Login con CI y contraseña
- Validación contra base de datos local
- Manejo de sesiones seguras

### RF002 - Registro y Gestión de Títulos
**Campos comunes (datos personales):**
- Datos personales obtenidos desde API universitaria

**Campos específicos por tipo de título:**
- Varían según el tipo de título seleccionado
- Incluyen: facultad, carrera, mención, medio de graduación, fecha de emisión, etc.
- Configurables según catálogo de cada tipo

**Campos del sistema:**
- Archivo PDF asociado (opcional para casos de pérdida)
- Estado: "Digitalizado" o "Pendiente de digitalización"

**Operaciones:**
- Crear, editar, eliminar (según permisos de rol)
- Visualizar según permisos
- Registrar personas sin documento físico disponible (casos de pérdida)

**Escalabilidad:** El sistema debe permitir agregar nuevos tipos de títulos (maestrías, doctorados) modificando el código fuente cuando sea necesario expandir funcionalidades.

### RF003 - Sistema de Búsqueda
- Búsqueda exacta por CI
- Búsqueda parcial por nombre (insensible a mayúsculas)
- Filtros: medio de graduación, sexo, facultad, carrera, tipo de título
- Combinación de múltiples filtros

### RF004 - Integración con API Universitaria
- Consulta de datos personales por CI para agilizar llenado de formularios
- Manejo de CI no encontrado
- Uso exclusivo para acelerar proceso de digitalización y registro manual
- Los demás campos del título se llenan manualmente según tipo específico

### RF005 - Visualizador de PDF
- Visualización integrada en interfaz web
- Disponible durante el proceso de registro de títulos (pre-guardado)
- Disponible después del registro para títulos almacenados en el sistema
- Zoom, navegación de páginas
- Descarga de documento original

### RF006 - Trazabilidad
- Registro de usuario creador y fecha/hora
- Registro de usuario modificador y fecha/hora
- Historial visible para administrador y jefe

### RF007 - Gestión de Datos Maestros
- Gestión integral de catálogos del sistema
- Incluye: usuarios, roles, permisos, tipos de títulos, facultades, carreras, menciones
- Configuración de campos específicos por tipo de título
- Solo accesible por administrador

### RF008 - Estadísticas Avanzadas
**Para Administrador y Jefe:**
- Total de títulos por facultad y carrera
- Distribución por tipo de título
- Títulos digitalizados vs pendientes de digitalización
- Estadísticas por medio de graduación
- Títulos registrados por período de tiempo
- Productividad por usuario (títulos registrados)
- Casos de títulos perdidos registrados
- Presentación en formato tabular

---

## 5. Reglas de Negocio

### RN001 - Unicidad
- Un título por tipo, por persona, por carrera
- CI único por persona

### RN002 - Validaciones
- CI formato boliviano válido
- Fechas de emisión no futuras
- Archivos PDF máximo 50MB (cuando disponible)
- Facultad-carrera deben corresponder según catálogo
- Tipo de título debe existir en catálogo de tipos configurables
- Estado "Pendiente" permitido sin archivo PDF para casos de pérdida

### RN003 - Permisos
- Personal: solo títulos que él registró
- Jefe: visualización completa, sin modificación
- Administrador: acceso completo

---

## 6. Restricciones Técnicas

### Consideraciones Técnicas Generales
- Sistema web accesible desde navegadores
- Persistencia de datos confiable
- Sistema de autenticación y autorización robusto
- Almacenamiento seguro de archivos
- Interfaz de usuario accesible y fácil de usar

### Integración Externa
- API Universitaria REST para consulta exclusiva de datos personales
- Uso específico: agilizar llenado de formularios de registro
- Disponible durante desarrollo

Ej de retorno de la api, peticion POST a https://apititulos.uatf.edu.bo/api/datos?ru='8631891':
```json
[
  {
    "paterno": "CONDORI",
    "materno": "CHAMBI",
    "nombres": "HECTOR JOSUE",
    "nro_dip": "8631891",
    "genero": "M",
    "fec_nacimiento": "2000-09-21",
    "pais": "BOLIVIA",
    "departamento": "POTOSI",
    "provincia": "CORNELIO SAAVEDRA",
    "localidad": "NEGRO TAMBO",
    "programa": "INGENIERIA MECATRONICA",
    "facultad": "INGENIERIA TECNOLOGICA",
    "decano_nombres": "M.Sc. Ing. JUAN CARLOS, DIAZ MARTINEZ",
    "modalidad_graduacion": "SIN DATOS",
    "nota_graduacion": "0",
    "modalidad": null,
    "nota": null,
    "titulo": null,
    "titulo_graduacion": null,
    "grado_academico": null
  },
  {
    "paterno": "CONDORI",
    "materno": "CHAMBI",
    "nombres": "HECTOR JOSUE",
    "nro_dip": "8631891",
    "genero": "M",
    "fec_nacimiento": "2000-09-21",
    "pais": "BOLIVIA",
    "departamento": "POTOSI",
    "provincia": "CORNELIO SAAVEDRA",
    "localidad": "NEGRO TAMBO",
    "programa": "INGENIERIA INFORMATICA",
    "facultad": "CIENCIAS PURAS",
    "decano_nombres": "M.Sc. Lic. GONZALO MIGUEL, POOL GARCIA",
    "modalidad_graduacion": "SIN DATOS",
    "nota_graduacion": "0",
    "modalidad": null,
    "nota": null,
    "titulo": null,
    "titulo_graduacion": null,
    "grado_academico": null
  }
]
```

### Datos Existentes
- Base de datos de facultades y carreras disponible
- Documentos PDF digitalizados disponibles para migración posterior
- Implementación inicial para 3 tipos de títulos con arquitectura preparada para escalabilidad

### Arquitectura del Sistema (Diagrama)
```
┌─────────────────┐                    ┌──────────────────┐
│     Sistema     │                    │  API Universitaria│
│  Digitalización │◄──────────────────►│   (Externa)      │
│     Títulos     │                    └──────────────────┘
└─────────────────┘
```
---

## 7. Criterios de Aceptación

### Mínimos para producción:
1. Autenticación funcionando con 3 roles
2. CRUD completo de títulos según permisos
3. Registro de títulos pendientes de digitalización
4. Búsqueda por todos los criterios especificados
5. Integración con API universitaria para datos personales
6. Visualizador de PDF integrado
7. Trazabilidad completa implementada
8. Gestión de datos maestros operativa
9. Módulo de estadísticas avanzadas funcionando



## Diseño de la base de datos
Se tienen las siguientes migraciones, pueden ser modificadas si es necesario:`

Las facultades tiene carreras
```php
    Schema::create('facultades', function (Blueprint $table) {
      $table->id();
      $table->string('nombre');
      $table->string('direccion')->nullable();
      $table->timestamps();
    });
```

Carreras  a los que pertenece Diploma Académico, Título Profesional
```php
    Schema::create('carreras', function (Blueprint $table) {
      $table->char('id', 5)->primary();
      $table->string('programa');
      $table->string('direccion')->nullable();
      $table->foreignId('facultad_id')->constrained('facultades', 'id');
      $table->timestamps();
    });
```

Las personas tienen títulos, esta migracion no debe ser modificada.
```php
   Schema::create('personas', function (Blueprint $table) {
      $table->string('ci')->primary();
      $table->string('nombres');
      $table->string('paterno')->nullable();
      $table->string('materno')->nullable();
      $table->date('fecha_nacimiento')->nullable();

      // Genero de persona, puede ser M (masculino), F (femenino) u O (otro)
      $table->enum('genero', ['M', 'F', 'O'])->nullable();

      $table->string('pais', 50)->nullable();
      $table->string('departamento', 50)->nullable();
      $table->string('provincia', 50)->nullable();
      $table->string('localidad', 50)->nullable();
      $table->timestamps();
});
```

Diplomas Academidos, tienen sus menciones, y modalidades de graduación
```php
     Schema::create('menciones_da', function (Blueprint $table) {
      $table->id();
      $table->string('nombre');
      $table->char('carrera_id', 5);
      $table->foreign('carrera_id')->references('id')->on('carreras');
      $table->timestamps();
    });
    Schema::create('diploma_academicos', function (Blueprint $table) {
      $table->id();
      $table->string('ci');
      $table->unsignedInteger('nro_documento');
      $table->unsignedInteger('fojas');
      $table->unsignedInteger('libro');
      $table->date('fecha_emision')->nullable();
      $table->foreignId('mencion_da_id')->constrained('menciones_da', 'id');
      $table->string('observaciones')->nullable();
      $table->foreignId('graduacion_id')->constrained('graduacion_da','id')->nullable();
      $table->string('file_dir', 500)->nullable();
      $table->boolean('verificado')->default(false);
      $table->timestamps();
      // Llave foranea para ci con la tabla personas
      $table->foreign('ci')->references('ci')->on('personas');
      $table->unique(['libro', 'fojas', 'nro_documento']);
    });
      Schema::create('graduacion_da', function(Blueprint $table){
        $table->id();
        $table->string('medio_graduacion');
      });
```