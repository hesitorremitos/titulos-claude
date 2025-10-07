import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import type { BreadcrumbItem } from '@/types'

// Registry configuration for breadcrumb hierarchy
interface BreadcrumbConfig {
  label: string
  parent?: string
  dynamic?: (props: any) => string
  href?: (props: any) => string | null
}

// Global registry for all breadcrumb configurations
const breadcrumbRegistry: Record<string, BreadcrumbConfig> = {
  // Dashboard
  'dashboard': {
    label: 'Dashboard'
  },

  // Diplomas Académicos
  'diplomas-academicos.index': {
    label: 'Lista',
    parent: 'diplomas-academicos'
  },
  'diplomas-academicos.create': {
    label: 'Registrar',
    parent: 'diplomas-academicos'
  },
  'diplomas-academicos.show': {
    label: 'Ver',
    parent: 'diplomas-academicos',
    dynamic: (props) => `Ver: ${props.diploma?.ci || props.diploma?.persona?.nombres || 'Diploma'}`,
    href: (props) => props.diploma ? route('diplomas-academicos.show', props.diploma.id) : null
  },
  'diplomas-academicos.edit': {
    label: 'Editar',
    parent: 'diplomas-academicos.show',
    dynamic: (props) => `Editar: ${props.diploma?.ci || props.diploma?.persona?.nombres || 'Diploma'}`,
  },

  // Menciones
  'diplomas-academicos.menciones.index': {
    label: 'Menciones',
    parent: 'diplomas-academicos'
  },

  // Modalidades
  'diplomas-academicos.modalidades.index': {
    label: 'Modalidades',
    parent: 'diplomas-academicos'
  },

  // Diplomas Bachiller
  'diploma-bachiller.index': {
    label: 'Lista',
    parent: 'diploma-bachiller'
  },
  'diploma-bachiller.create': {
    label: 'Registrar',
    parent: 'diploma-bachiller'
  },
  'diploma-bachiller.show': {
    label: 'Ver',
    parent: 'diploma-bachiller',
    dynamic: (props) => `Ver: ${props.diploma?.ci || props.diploma?.persona?.nombres || 'Diploma'}`,
    href: (props) => props.diploma ? route('diploma-bachiller.show', props.diploma.id) : null
  },
  'diploma-bachiller.edit': {
    label: 'Editar',
    parent: 'diploma-bachiller.show',
    dynamic: (props) => `Editar: ${props.diploma?.ci || props.diploma?.persona?.nombres || 'Diploma'}`,
  },

  'diploma-bachiller.menciones.index': {
    label: 'Menciones',
    parent: 'diploma-bachiller'
  },

  // Facultades
  'facultades.index': {
    label: 'Lista',
    parent: 'facultades'
  },
  'facultades.create': {
    label: 'Registrar',
    parent: 'facultades'
  },
  'facultades.show': {
    label: 'Ver',
    parent: 'facultades',
    dynamic: (props) => `Ver: ${props.facultad?.nombre || 'Facultad'}`,
    href: (props) => props.facultad ? route('facultades.show', props.facultad.id) : null
  },
  'facultades.edit': {
    label: 'Editar',
    parent: 'facultades.show',
    dynamic: (props) => `Editar: ${props.facultad?.nombre || 'Facultad'}`,
  },

  // Carreras
  'carreras.index': {
    label: 'Lista',
    parent: 'carreras'
  },
  'carreras.create': {
    label: 'Registrar',
    parent: 'carreras'
  },
  'carreras.show': {
    label: 'Ver',
    parent: 'carreras',
    dynamic: (props) => `Ver: ${props.carrera?.programa || 'Carrera'}`,
    href: (props) => props.carrera ? route('carreras.show', props.carrera.id) : null
  },
  'carreras.edit': {
    label: 'Editar',
    parent: 'carreras.show',
    dynamic: (props) => `Editar: ${props.carrera?.programa || 'Carrera'}`,
  },

  // Usuarios
  'usuarios.index': {
    label: 'Lista',
    parent: 'usuarios'
  },
  'usuarios.create': {
    label: 'Registrar',
    parent: 'usuarios'
  },
  'usuarios.show': {
    label: 'Ver',
    parent: 'usuarios',
    dynamic: (props) => `Ver: ${props.usuario?.name || 'Usuario'}`,
    href: (props) => props.usuario ? route('usuarios.show', props.usuario.id) : null
  },
  'usuarios.edit': {
    label: 'Editar',
    parent: 'usuarios.show',
    dynamic: (props) => `Editar: ${props.usuario?.name || 'Usuario'}`,
  },

  // Profile
  'profile.index': {
    label: 'Mi Perfil',
    parent: 'dashboard'
  },

  // Parent categories (virtual breadcrumb levels)
  'diplomas-academicos': {
    label: 'Diplomas Académicos',
    parent: 'dashboard',
    href: () => route('diplomas-academicos.index')
  },
  'diploma-bachiller': {
    label: 'Diplomas Bachiller',
    parent: 'dashboard',
    href: () => route('diploma-bachiller.index')
  },
  'facultades': {
    label: 'Facultades',
    parent: 'dashboard',
    href: () => route('facultades.index')
  },
  'carreras': {
    label: 'Carreras',
    parent: 'dashboard',
    href: () => route('carreras.index')
  },
  'usuarios': {
    label: 'Usuarios',
    parent: 'dashboard',
    href: () => route('usuarios.index')
  },
}

export function useBreadcrumbs(overrideBreadcrumbs?: BreadcrumbItem[]) {
  const page = usePage()

  // Get current route name using Ziggy
  const getCurrentRoute = (): string | null => {
    try {
      const current = route().current()
      return typeof current === 'string' ? current : null
    } catch {
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
      } catch {
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
