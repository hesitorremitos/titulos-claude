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
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card'
import { Badge } from '@/components/ui/badge'
import { Input } from '@/components/ui/input'
import { Eye, Search, X, PlusCircle } from 'lucide-vue-next'
import type { Doctorado, PaginatedResponse } from '@/types/titulos/doctorado'

defineOptions({
  layout: (h: any, page: any) => h(AppLayout, {
    title: 'Doctorados',
    pageTitle: 'Doctorados',
    navTabs,
    activeTab: 'lista'
  }, () => page)
})

const props = defineProps<{
  doctorados: PaginatedResponse<Doctorado>
  filters: {
    search?: string
  }
}>()

const hasDoctorados = computed(() => props.doctorados.data.length > 0)
const search = ref(props.filters.search || '')

let searchTimeout: number
const debouncedSearch = () => {
  clearTimeout(searchTimeout)
  searchTimeout = window.setTimeout(() => {
    router.get(route('doctorados.index'), {
      search: search.value || undefined,
    }, {
      preserveState: true,
      replace: true,
    })
  }, 300)
}

const clearSearch = () => {
  search.value = ''
  router.get(route('doctorados.index'), {}, {
    preserveState: true,
    replace: true,
  })
}

const formatGestion = (inicial?: number | null, final?: number | null) => {
  if (!inicial && !final) return 'No especificada'
  if (inicial && final) return `${inicial}-${final}`
  return inicial ?? final
}

const formatDate = (dateString?: string | null) => {
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
  <Head title="Doctorados" />
  <div class="space-y-6">
    <Card>
      <CardHeader class="flex flex-row items-center justify-between">
        <div>
          <CardTitle>Lista de Doctorados</CardTitle>
          <CardDescription>
            Gestiona los doctorados registrados en el sistema.
          </CardDescription>
        </div>
        <Link :href="route('doctorados.create')">
          <Button>
            <PlusCircle class="h-4 w-4 mr-2" />
            Registrar Doctorado
          </Button>
        </Link>
      </CardHeader>
      <CardContent>
        <div class="mb-6">
          <div class="relative max-w-md">
            <Search class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-muted-foreground" />
            <Input
              v-model="search"
              @input="debouncedSearch"
              placeholder="Buscar por CI, nombre, N° TPN o documento..."
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

        <div v-if="hasDoctorados">
          <Table>
            <TableHeader>
              <TableRow>
                <TableHead>CI</TableHead>
                <TableHead>Nombre Completo</TableHead>
                <TableHead>Mención</TableHead>
                <TableHead>Gestión</TableHead>
                <TableHead>Versión</TableHead>
                <TableHead>Fecha Emisión</TableHead>
                <TableHead>Estado Documento</TableHead>
                <TableHead class="text-right">Acciones</TableHead>
              </TableRow>
            </TableHeader>
            <TableBody>
              <TableRow v-for="doctorado in doctorados.data" :key="doctorado.id">
                <TableCell>
                  <Badge variant="secondary">{{ doctorado.ci }}</Badge>
                </TableCell>
                <TableCell>
                  {{ doctorado.persona?.nombres }} {{ doctorado.persona?.paterno }} {{ doctorado.persona?.materno }}
                </TableCell>
                <TableCell>{{ doctorado.mencion?.nombre || 'Sin mención' }}</TableCell>
                <TableCell>{{ formatGestion(doctorado.gestion_inicial, doctorado.gestion_final) }}</TableCell>
                <TableCell>{{ doctorado.version ?? 'No especificada' }}</TableCell>
                <TableCell>{{ formatDate(doctorado.fecha_emision) }}</TableCell>
                <TableCell>
                  <Badge :variant="doctorado.file_dir ? 'default' : 'destructive'" class="text-xs">
                    {{ doctorado.file_dir ? '✓ Digitalizado' : '✗ Sin documento' }}
                  </Badge>
                </TableCell>
                <TableCell class="text-right">
                  <Button variant="ghost" size="icon" as="a" :href="route('doctorados.show', doctorado.id)">
                    <Eye class="h-4 w-4" />
                  </Button>
                </TableCell>
              </TableRow>
            </TableBody>
          </Table>

          <div v-if="doctorados.links.length > 3" class="flex justify-between items-center mt-6">
            <p class="text-sm text-muted-foreground">
              Mostrando {{ doctorados.from }} a {{ doctorados.to }} de {{ doctorados.total }} resultados
            </p>
            <div class="flex space-x-2">
              <Button
                v-for="link in doctorados.links"
                :key="link.label"
                :href="link.url || undefined"
                :disabled="!link.url"
                size="sm"
                :variant="link.active ? 'default' : 'outline'"
                as="a"
              >
                {{ link.label }}
              </Button>
            </div>
          </div>
        </div>

        <div v-else class="flex flex-col items-center justify-center py-12 text-center space-y-4">
          <Icon icon="lucide:mortar-board" class="h-12 w-12 text-muted-foreground" />
          <div class="space-y-2">
            <p class="text-lg font-semibold text-foreground">No hay doctorados registrados</p>
            <p class="text-muted-foreground">Comienza registrando un nuevo doctorado.</p>
          </div>
          <Button :href="route('doctorados.create')" as="a">
            Registrar Doctorado
          </Button>
        </div>
      </CardContent>
    </Card>
  </div>
</template>
