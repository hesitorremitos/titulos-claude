/**
 * Utilidades para manejo de documentos bolivianos
 * Funciones específicas para CI, títulos académicos, etc.
 */

/**
 * Extrae el Carnet de Identidad (CI) boliviano de un string
 * @param text - String del cual extraer el CI (ej: nombre de archivo)
 * @param minLength - Longitud mínima del CI (por defecto 4)
 * @returns CI extraído o null si no se encuentra
 */
export function extractCIFromString(text: string, minLength: number = 4): string | null {
  // Busca secuencia de dígitos al inicio, permitiendo espacios después
  const ciMatch = text.match(/^(\d+)(?:\s|$|-)/);
  
  if (ciMatch && ciMatch[1].length >= minLength && ciMatch[1].length <= 10) {
    return ciMatch[1];
  }
  
  return null;
}

/**
 * Extrae CI específicamente de un nombre de archivo
 * @param filename - Nombre del archivo
 * @param minLength - Longitud mínima del CI (por defecto 4)
 * @returns CI extraído o null si no se encuentra
 */
export function extractCIFromFilename(filename: string, minLength: number = 4): string | null {
  // Remover extensión del archivo antes de procesar
  const nameWithoutExtension = filename.replace(/\.[^/.]+$/, '');
  return extractCIFromString(nameWithoutExtension, minLength);
}

/**
 * Valida si un CI tiene formato boliviano válido
 * @param ci - CI a validar
 * @param minLength - Longitud mínima del CI (por defecto 4)
 * @returns true si el formato es válido
 */
export function isValidBolivianCI(ci: string, minLength: number = 4): boolean {
  // CI boliviano: dígitos numéricos con longitud configurable
  return /^\d+$/.test(ci) && ci.length >= minLength && ci.length <= 10;
}

/**
 * Formatea un CI para mostrar (agregar separadores si es necesario)
 * @param ci - CI a formatear
 * @returns CI formateado para display
 */
export function formatCIForDisplay(ci: string): string {
  // Por ahora devuelve el CI sin formato adicional
  // Se puede extender en el futuro si se necesita formateo específico
  return ci;
}

/**
 * Extrae número de diploma de un string
 * @param text - String del cual extraer el número
 * @returns Número de diploma o null si no se encuentra
 */
export function extractDiplomaNumber(text: string): string | null {
  // Busca patrones como "DIP123456" o "DIPLOMA-123456"
  const diplomaMatch = text.match(/(?:DIP|DIPLOMA)[\-_]?(\d+)/i);
  return diplomaMatch ? diplomaMatch[1] : null;
}