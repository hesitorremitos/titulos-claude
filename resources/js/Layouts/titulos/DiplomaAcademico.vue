<template>
  <AppLayout 
    :title="pageTitle"
    :page-title="pageTitle"
    :nav-tabs="navTabs"
    :active-tab="activeTab"
  >
    <slot />
  </AppLayout>
</template>

<script setup lang="ts">
import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'
import { toast } from 'vue-sonner'
import AppLayout from '../AppLayout.vue'

interface Props {
  title?: string
  activeTab: string
}

const props = withDefaults(defineProps<Props>(), {
  title: 'Diplomas Académicos'
})

const page = usePage()

// Título de la página
const pageTitle = computed(() => props.title)

// Navegación unificada de Diplomas Académicos
const navTabs = computed(() => [
  { 
    label: 'Lista', 
    href: route('v2.diplomas-academicos.index'), 
    icon: 'material-symbols:list', 
    value: 'lista' 
  },
  { 
    label: 'Registrar', 
    href: route('v2.diplomas-academicos.create'), 
    icon: 'material-symbols:add', 
    value: 'registrar' 
  },
  { 
    label: 'Menciones', 
    href: route('v2.menciones.index'), 
    icon: 'material-symbols:category', 
    value: 'menciones' 
  },
  { 
    label: 'Modalidades', 
    href: route('v2.modalidades.index'), 
    icon: 'material-symbols:school', 
    value: 'modalidades' 
  },
])

// Breadcrumbs ahora son automáticos via BreadcrumbManager

// Función global para mostrar toasts de éxito
const showSuccessToast = () => {
  const flash = page.props.flash as any
  toast.success(flash.success)
}

// Función global para mostrar toasts de error  
const showErrorToast = (error: string) => {
  toast.error(error)
}

// Exponer funciones para que las páginas hijas las puedan usar
defineExpose({
  showSuccessToast,
  showErrorToast
})
</script>