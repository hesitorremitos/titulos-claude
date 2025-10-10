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
import type { Diplomado, PaginatedResponse } from '@/types/titulos/diplomado'
import { useAuthz } from '@/composables/useAuthz'

defineOptions({
  layout: (h: any, page: any) => h(AppLayout, {
    title: 'Diplomados',
    pageTitle: 'Diplomados',
    navTabs,
    activeTab: 'lista'
  }, () => page)
})

const props = defineProps<{
  diplomados: PaginatedResponse<Diplomado>
  filters: {
    search?: string
  }
}>()

const hasDiplomados = computed(() => props.diplomados.data.length > 0)
const search = ref(props.filters.search || '')
const { hasPermission } = useAuthz()
const canCreateDocuments = computed(() => hasPermission('crear-documentos'))

let searchTimeout: number
const debouncedSearch = () => {
  clearTimeout(searchTimeout)
  searchTimeout = window.setTimeout(() => {
    router.get(route('diplomados.index'), {
      search: search.value || undefined,
    }, {
      preserveState: true,
      replace: true,
    })
  }, 300)
}

const clearSearch = () => {
  search.value = ''
  router.get(route('diplomados.index'), {}, {
    preserveState: true,
    replace: true,
  })
}

const formatGestion = (gestion?: number | null) => {
  if (!gestion) return 'No especificada'
  return gestion
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
  <Head title="Diplomados" />
  <div class="space-y-6">
    <Card>
      <CardHeader class="flex flex-row items-center justify-between">
        <div>
          <CardTitle>Lista de Diplomados</CardTitle>
          <CardDescription>
            Gestiona los diplomados registrados en el sistema.
          </CardDescription>
        </div>
        <Link v-if="canCreateDocuments" :href="route('diplomados.create')">
          <Button>
            <PlusCircle class="h-4 w-4 mr-2" />
            Registrar Diplomado
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

        <div v-if="hasDiplomados">
          <Table>
            <TableHeader>
              <TableRow>
                <TableHead>CI</TableHead>
                <TableHead>Nombre Completo</TableHead>
                <TableHead>Mención</TableHead>
                <TableHead>Mención TPN</TableHead>
                <TableHead>Modalidad</TableHead>
                <TableHead>Gestión</TableHead>
                <TableHead>Versión</TableHead>
                <TableHead>Fecha Emisión</TableHead>
                <TableHead>Estado Documento</TableHead>
                <TableHead class="text-right">Acciones</TableHead>
              </TableRow>
            </TableHeader>
            <TableBody>
              <TableRow v-for="diplomado in diplomados.data" :key="diplomado.id">
                <TableCell>
                  <Badge variant="secondary">{{ diplomado.ci }}</Badge>
                </TableCell>
                <TableCell>
                  {{ diplomado.persona?.nombres }} {{ diplomado.persona?.paterno }} {{ diplomado.persona?.materno }}
                </TableCell>
                <TableCell>{{ diplomado.mencion?.nombre || 'Sin mención' }}</TableCell>
                <TableCell>{{ diplomado.mencionTpn?.nombre || 'Sin mención' }}</TableCell>
                <TableCell>{{ diplomado.modalidad?.nombre || 'Sin modalidad' }}</TableCell>
                <TableCell>{{ formatGestion(diplomado.gestion) }}</TableCell>
                <TableCell>{{ diplomado.version ?? 'No especificada' }}</TableCell>
                <TableCell>{{ formatDate(diplomado.fecha_emision) }}</TableCell>
                <TableCell>
                  <Badge :variant="diplomado.file_dir ? 'default' : 'destructive'" class="text-xs">
                    {{ diplomado.file_dir ? '✓ Digitalizado' : '✗ Sin documento' }}
                  </Badge>
                </TableCell>
                <TableCell class="text-right">
                  <Button variant="ghost" size="icon" as="a" :href="route('diplomados.show', diplomado.id)">
                    <Eye class="h-4 w-4" />
                  </Button>
                </TableCell>
              </TableRow>
            </TableBody>
          </Table>

          <div v-if="diplomados.links.length > 3" class="flex justify-between items-center mt-6">
            <p class="text-sm text-muted-foreground">
              Mostrando {{ diplomados.from }} a {{ diplomados.to }} de {{ diplomados.total }} resultados
            </p>
            <div class="flex space-x-2">
              <Button
                v-for="link in diplomados.links"
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
            <p class="text-lg font-semibold text-foreground">No hay diplomados registrados</p>
            <p class="text-muted-foreground">Comienza registrando un nuevo diplomado.</p>
          </div>
          <Button v-if="canCreateDocuments" :href="route('diplomados.create')" as="a">
            Registrar Diplomado
          </Button>
        </div>
      </CardContent>
    </Card>
  </div>
</template>
