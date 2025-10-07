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
import type { Especialidad, PaginatedResponse } from '@/types/titulos/especialidad'

defineOptions({
  layout: (h: any, page: any) => h(AppLayout, {
    title: 'Especialidades',
    pageTitle: 'Especialidades',
    navTabs,
    activeTab: 'lista'
  }, () => page)
})

const props = defineProps<{
  especialidades: PaginatedResponse<Especialidad>
  filters: {
    search?: string
  }
}>()

const hasEspecialidades = computed(() => props.especialidades.data.length > 0)
const search = ref(props.filters.search || '')

let searchTimeout: number
const debouncedSearch = () => {
  clearTimeout(searchTimeout)
  searchTimeout = window.setTimeout(() => {
    router.get(route('especialidades.index'), {
      search: search.value || undefined,
    }, {
      preserveState: true,
      replace: true,
    })
  }, 300)
}

const clearSearch = () => {
  search.value = ''
  router.get(route('especialidades.index'), {}, {
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
  <Head title="Especialidades" />
  <div class="space-y-6">
    <Card>
      <CardHeader class="flex flex-row items-center justify-between">
        <div>
          <CardTitle>Lista de Especialidades</CardTitle>
          <CardDescription>
            Gestiona las especialidades registradas en el sistema.
          </CardDescription>
        </div>
        <Link :href="route('especialidades.create')">
          <Button>
            <PlusCircle class="h-4 w-4 mr-2" />
            Registrar Especialidad
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

        <div v-if="hasEspecialidades">
          <Table>
            <TableHeader>
              <TableRow>
                <TableHead>CI</TableHead>
                <TableHead>Nombre Completo</TableHead>
                <TableHead>Mención</TableHead>
                <TableHead>Mención TPN</TableHead>
                <TableHead>Modalidad</TableHead>
                <TableHead>Universidad</TableHead>
                <TableHead>Gestión</TableHead>
                <TableHead>Versión</TableHead>
                <TableHead>Fecha Emisión</TableHead>
                <TableHead>Horas Académicas</TableHead>
                <TableHead>Promedio Final</TableHead>
                <TableHead class="text-right">Acciones</TableHead>
              </TableRow>
            </TableHeader>
            <TableBody>
              <TableRow v-for="especialidad in especialidades.data" :key="especialidad.id">
                <TableCell>
                  <Badge variant="secondary">{{ especialidad.ci }}</Badge>
                </TableCell>
                <TableCell>
                  {{ especialidad.persona?.nombres }} {{ especialidad.persona?.paterno }} {{ especialidad.persona?.materno }}
                </TableCell>
                <TableCell>{{ especialidad.mencion?.nombre || 'Sin mención' }}</TableCell>
                <TableCell>{{ especialidad.mencionTpn?.nombre || 'Sin mención' }}</TableCell>
                <TableCell>{{ especialidad.modalidad?.nombre || 'Sin modalidad' }}</TableCell>
                <TableCell>{{ especialidad.universidad?.nombre || 'Sin universidad' }}</TableCell>
                <TableCell>{{ formatGestion(especialidad.gestion) }}</TableCell>
                <TableCell>{{ especialidad.version ?? 'No especificada' }}</TableCell>
                <TableCell>{{ formatDate(especialidad.fecha_emision) }}</TableCell>
                <TableCell>{{ especialidad.horas_academicas || 'No especificadas' }}</TableCell>
                <TableCell>
                  <Badge :variant="especialidad.promedio_final ? 'default' : 'secondary'" class="text-xs">
                    {{ especialidad.promedio_final ? 'Registrado' : 'No registrado' }}
                  </Badge>
                </TableCell>
                <TableCell class="text-right">
                  <Button variant="ghost" size="icon" as="a" :href="route('especialidades.show', especialidad.id)">
                    <Eye class="h-4 w-4" />
                  </Button>
                </TableCell>
              </TableRow>
            </TableBody>
          </Table>

          <div v-if="especialidades.links.length > 3" class="flex justify-between items-center mt-6">
            <p class="text-sm text-muted-foreground">
              Mostrando {{ especialidades.from }} a {{ especialidades.to }} de {{ especialidades.total }} resultados
            </p>
            <div class="flex space-x-2">
              <Button
                v-for="link in especialidades.links"
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
            <p class="text-lg font-semibold text-foreground">No hay especialidades registradas</p>
            <p class="text-muted-foreground">Comienza registrando una nueva especialidad.</p>
          </div>
          <Button :href="route('especialidades.create')" as="a">
            Registrar Especialidad
          </Button>
        </div>
      </CardContent>
    </Card>
  </div>
</template>
