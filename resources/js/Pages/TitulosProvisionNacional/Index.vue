<script setup lang="ts">
import { computed, ref } from 'vue'
import { Head, Link, router } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import navTabs from './navtabs.json'
import { Icon } from '@iconify/vue'
import {
  Table,
  TableBody,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from '@/components/ui/table'
import { Button } from '@/components/ui/button'
import { Card, CardContent, CardHeader, CardTitle, CardDescription } from '@/components/ui/card'
import { Badge } from '@/components/ui/badge'
import { Input } from '@/components/ui/input'
import { Eye, Search, X, PlusCircle } from 'lucide-vue-next'
import type { TituloProvisionNacional, PaginatedResponse } from '@/types/titulos/titulo-provision-nacional'

// Configurar layout persistente
defineOptions({
  layout: (h: any, page: any) => h(AppLayout, {
    title: 'Títulos Provisional Nacionales',
    pageTitle: 'Títulos Provisional Nacionales',
    navTabs: navTabs,
    activeTab: 'lista'
  }, () => page)
})

// Props
const props = defineProps<{
  titulos: PaginatedResponse<TituloProvisionNacional>
  filters: {
    search?: string
  }
}>()

// Computed property to check if there are titles
const hasTitulos = computed(() => props.titulos.data.length > 0)

// Search functionality
const search = ref(props.filters.search || '')

// We'll use a manual debounce approach instead of watch

let searchTimeout: number
const debouncedSearch = () => {
  clearTimeout(searchTimeout)
  searchTimeout = setTimeout(() => {
    router.get(route('diplomas-academicos.index'), {
      search: search.value || undefined,
    }, {
      preserveState: true,
      replace: true,
    })
  }, 300)
}

// Clear search
const clearSearch = () => {
  search.value = ''
  router.get(route('diplomas-academicos.index'), {}, {
    preserveState: true,
    replace: true,
  })
}

// Function to format date
const formatDate = (dateString: string | undefined) => {
  if (!dateString) return 'No especificada'
  const date = new Date(dateString)
  return date.toLocaleDateString('es-ES', {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
  })
}
</script>

<template>
  <Head title="Títulos Provisional Nacionales" />
    <!-- Content -->
    <div class="space-y-6">
      <Card>
        <CardHeader class="flex flex-row items-center justify-between">
          <div>
            <CardTitle>Lista de Títulos</CardTitle>
            <CardDescription>
              Aquí puedes ver, editar y eliminar los títulos provisionales nacionales.
            </CardDescription>
          </div>
          <Link :href="route('titulos-provision-nacional.create')">
            <Button>
              <PlusCircle class="h-4 w-4 mr-2" />
              Registrar Título
            </Button>
          </Link>
        </CardHeader>
        <CardContent>
          <!-- Buscador -->
          <div class="mb-6">
            <div class="relative max-w-md">
              <Search class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-muted-foreground" />
              <Input
                v-model="search"
                @input="debouncedSearch"
                placeholder="Buscar por CI, nombres o apellidos..."
                class="pl-10 pr-10"
              />
              <Button
                v-if="search"
                variant="ghost"
                size="icon"
                class="absolute right-1 top-1/2 h-6 w-6 -translate-y-1/2 hover:bg-transparent"
                @click="clearSearch"
              >
                <X class="h-4 w-4" />
              </Button>
            </div>
          </div>

          <div v-if="hasTitulos">
            <Table>
              <TableHeader>
                <TableRow>
                  <TableHead>CI</TableHead>
                  <TableHead>Nombre Completo</TableHead>
                  <TableHead>Mención</TableHead>
                  <TableHead>Fecha Emisión</TableHead>
                  <TableHead>Estado Documento</TableHead>
                  <TableHead class="text-right">Acciones</TableHead>
                </TableRow>
              </TableHeader>
              <TableBody>
                <TableRow v-for="titulo in titulos.data" :key="titulo.id">
                  <TableCell>
                    <Badge variant="secondary">{{ titulo.ci }}</Badge>
                  </TableCell>
                  <TableCell>{{ titulo.persona?.nombres }} {{ titulo.persona?.paterno }} {{ titulo.persona?.materno }}</TableCell>
                  <TableCell>{{ titulo.mencion?.nombre }}</TableCell>
                  <TableCell>{{ formatDate(titulo.fecha_emision) }}</TableCell>
                  <TableCell>
                    <Badge
                      :variant="titulo.file_dir ? 'default' : 'destructive'"
                      class="text-xs"
                    >
                      {{ titulo.file_dir ? '✓ Digitalizado' : '✗ Sin documento' }}
                    </Badge>
                  </TableCell>
                  <TableCell class="text-right">
                    <Button variant="ghost" size="icon" as="a" :href="route('titulos-provision-nacional.show', titulo.id)">
                      <Eye class="h-4 w-4" />
                    </Button>
                  </TableCell>
                </TableRow>
              </TableBody>
            </Table>

            <!-- Pagination -->
            <div class="flex justify-between items-center mt-6">
              <p class="text-sm text-muted-foreground">
                Mostrando {{ titulos.from }} a {{ titulos.to }} de {{ titulos.total }} resultados.
              </p>
              <div class="flex space-x-2">
                <Button
                  v-for="link in titulos.links"
                  :key="link.label"
                  :href="link.url"
                  :disabled="!link.url || link.active"
                  size="sm"
                  :variant="link.active ? 'default' : 'outline'"
                  as="a"
                >
                  {{ link.label }}
                </Button>
              </div>
            </div>
          </div>

          <!-- Empty State -->
          <div v-else class="text-center py-16">
            <Icon icon="material-symbols:school" class="h-16 w-16 text-muted-foreground mx-auto mb-6" />
            <h3 class="text-xl font-semibold">
              {{ search ? 'No se encontraron resultados' : 'No hay títulos provisionales nacionales' }}
            </h3>
            <p class="text-muted-foreground mt-2">
              {{ search
                ? `No se encontraron títulos que coincidan con "${search}".`
                : 'Comienza registrando un nuevo título provisional nacional.'
              }}
            </p>
            <div class="mt-6 space-x-3">
              <Button v-if="search" variant="outline" @click="clearSearch">
                Limpiar búsqueda
              </Button>
              <Link :href="route('titulos-provision-nacional.create')">
                <Button>
                  <PlusCircle class="h-4 w-4 mr-2" />
                  {{ search ? 'Registrar Título' : 'Registrar Primer Título' }}
                </Button>
              </Link>
            </div>
          </div>
        </CardContent>
      </Card>
    </div>
</template>
