import axios from 'axios'

export interface ApiPersonResponse {
  paterno: string
  materno: string
  nombres: string
  nro_dip: string
  genero: string
  fec_nacimiento: string
  pais: string
  departamento: string
  provincia: string
  localidad: string
  programa: string
  facultad: string
}

export interface ApiSearchResult {
  success: boolean
  data?: ApiPersonResponse[]
  error?: string
}

/**
 * Busca personas en la API universitaria por CI
 * El controlador ya maneja todas las validaciones
 */
export async function searchPersonByCi(ci: string): Promise<ApiSearchResult> {
  try {
    const response = await axios.get(`/v2/api/${ci}`)
    
    // Si la respuesta es exitosa y tiene datos
    if (response.status === 200 && Array.isArray(response.data) && response.data.length > 0) {
      return { success: true, data: response.data }
    } else {
      return { success: false, error: 'No se encontraron resultados' }
    }
  } catch (error: any) {
    // El controlador retorna errores estructurados
    if (error.response?.data?.message) {
      return { success: false, error: error.response.data.message }
    } else {
      return { success: false, error: 'Error al buscar en la API universitaria' }
    }
  }
}