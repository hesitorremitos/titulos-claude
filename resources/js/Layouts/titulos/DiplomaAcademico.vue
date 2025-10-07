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
import navTabsData from '../../Pages/DiplomasAcademicos/navtabs.json'
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

// Navegación unificada de Diplomas Académicos desde JSON
const navTabs = navTabsData

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