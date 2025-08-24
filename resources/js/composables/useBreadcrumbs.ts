import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import type { BreadcrumbItem } from '@/types'

// Registry configuration for breadcrumb hierarchy
interface BreadcrumbConfig {
  label: string
  parent?: string
  dynamic?: (props: any) => string
  href?: (props: any) => string
}

// Global registry for all breadcrumb configurations
const breadcrumbRegistry: Record<string, BreadcrumbConfig> = {
  // Dashboard
  'v2.dashboard': {
    label: 'Dashboard'
  },

  // Diplomas Académicos
  'v2.diplomas-academicos.index': {
    label: 'Lista',
    parent: 'diplomas-academicos'
  },
  'v2.diplomas-academicos.create': {
    label: 'Registrar',
    parent: 'diplomas-academicos'
  },
  'v2.diplomas-academicos.show': {
    label: 'Ver',
    parent: 'diplomas-academicos',
    dynamic: (props) => `Ver: ${props.diploma?.ci || props.diploma?.persona?.nombres || 'Diploma'}`,
    href: (props) => props.diploma ? route('v2.diplomas-academicos.show', props.diploma.id) : null
  },
  'v2.diplomas-academicos.edit': {
    label: 'Editar',
    parent: 'v2.diplomas-academicos.show',
    dynamic: (props) => `Editar: ${props.diploma?.ci || props.diploma?.persona?.nombres || 'Diploma'}`,
  },

  // Menciones
  'v2.menciones.index': {
    label: 'Menciones',
    parent: 'diplomas-academicos'
  },

  // Modalidades
  'v2.modalidades.index': {
    label: 'Modalidades',
    parent: 'diplomas-academicos'
  },

  // Facultades
  'v2.facultades.index': {
    label: 'Lista',
    parent: 'facultades'
  },
  'v2.facultades.create': {
    label: 'Registrar',
    parent: 'facultades'
  },
  'v2.facultades.show': {
    label: 'Ver',
    parent: 'facultades',
    dynamic: (props) => `Ver: ${props.facultad?.nombre || 'Facultad'}`,
    href: (props) => props.facultad ? route('v2.facultades.show', props.facultad.id) : null
  },
  'v2.facultades.edit': {
    label: 'Editar',
    parent: 'v2.facultades.show',
    dynamic: (props) => `Editar: ${props.facultad?.nombre || 'Facultad'}`,
  },

  // Carreras
  'v2.carreras.index': {
    label: 'Lista',
    parent: 'carreras'
  },
  'v2.carreras.create': {
    label: 'Registrar',
    parent: 'carreras'
  },
  'v2.carreras.show': {
    label: 'Ver',
    parent: 'carreras',
    dynamic: (props) => `Ver: ${props.carrera?.programa || 'Carrera'}`,
    href: (props) => props.carrera ? route('v2.carreras.show', props.carrera.id) : null
  },
  'v2.carreras.edit': {
    label: 'Editar',
    parent: 'v2.carreras.show',
    dynamic: (props) => `Editar: ${props.carrera?.programa || 'Carrera'}`,
  },

  // Usuarios
  'v2.usuarios.index': {
    label: 'Lista',
    parent: 'usuarios'
  },
  'v2.usuarios.create': {
    label: 'Registrar',
    parent: 'usuarios'
  },
  'v2.usuarios.show': {
    label: 'Ver',
    parent: 'usuarios',
    dynamic: (props) => `Ver: ${props.usuario?.name || 'Usuario'}`,
    href: (props) => props.usuario ? route('v2.usuarios.show', props.usuario.id) : null
  },
  'v2.usuarios.edit': {
    label: 'Editar',
    parent: 'v2.usuarios.show',
    dynamic: (props) => `Editar: ${props.usuario?.name || 'Usuario'}`,
  },

  // Profile
  'profile.index': {
    label: 'Mi Perfil',
    parent: 'v2.dashboard'
  },

  // Parent categories (virtual breadcrumb levels)
  'diplomas-academicos': {
    label: 'Diplomas Académicos',
    parent: 'v2.dashboard',
    href: () => route('v2.diplomas-academicos.index')
  },
  'facultades': {
    label: 'Facultades',
    parent: 'v2.dashboard',
    href: () => route('v2.facultades.index')
  },
  'carreras': {
    label: 'Carreras',
    parent: 'v2.dashboard',
    href: () => route('v2.carreras.index')
  },
  'usuarios': {
    label: 'Usuarios',
    parent: 'v2.dashboard',
    href: () => route('v2.usuarios.index')
  },
}

export function useBreadcrumbs(overrideBreadcrumbs?: BreadcrumbItem[]) {
  const page = usePage()

  // Get current route name using Ziggy
  const getCurrentRoute = (): string | null => {
    try {
      return route().current()
    } catch (e) {
      return null
    }
  }

  // Build breadcrumb trail recursively
  const buildBreadcrumbTrail = (routeName: string, pageProps: any = {}): BreadcrumbItem[] => {
    const config = breadcrumbRegistry[routeName]
    if (!config) return []

    const trail: BreadcrumbItem[] = []

    // Add parent breadcrumbs recursively
    if (config.parent) {
      trail.push(...buildBreadcrumbTrail(config.parent, pageProps))
    }

    // Generate label (dynamic or static)
    const label = config.dynamic ? config.dynamic(pageProps) : config.label

    // Generate href (if function provided, otherwise null for current page)
    let href: string | null = null
    if (config.href) {
      try {
        href = config.href(pageProps)
      } catch (e) {
        href = null
      }
    }

    // Add current breadcrumb
    trail.push({ label, href })

    return trail
  }

  // Generate breadcrumbs automatically
  const breadcrumbs = computed(() => {
    // If override breadcrumbs provided, use them
    if (overrideBreadcrumbs) {
      return overrideBreadcrumbs
    }

    const currentRoute = getCurrentRoute()
    if (!currentRoute) {
      // Fallback breadcrumb
      return [{ label: 'Dashboard', href: null }]
    }

    // Extract page props for dynamic breadcrumbs
    const pageProps = page.props as any

    // Build trail from current route
    return buildBreadcrumbTrail(currentRoute, pageProps)
  })

  // Helper to register new breadcrumb routes dynamically
  const registerBreadcrumb = (routeName: string, config: BreadcrumbConfig) => {
    breadcrumbRegistry[routeName] = config
  }

  // Helper to register multiple breadcrumb routes at once
  const registerBreadcrumbs = (configs: Record<string, BreadcrumbConfig>) => {
    Object.assign(breadcrumbRegistry, configs)
  }

  return {
    breadcrumbs,
    registerBreadcrumb,
    registerBreadcrumbs,
    currentRoute: computed(() => getCurrentRoute())
  }
}