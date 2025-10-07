<script setup lang="ts">
import { computed, ref } from 'vue'
import { Head, Link, router } from '@inertiajs/vue3'
import SubLayout from '@/Layouts/titulos/DiplomaAcademico.vue'
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
import type { DiplomaAcademico, PaginatedResponse } from '@/types/models.d'

// Configurar layout persistente
defineOptions({ 
  layout: (h: any, page: any) => h(SubLayout, { 
    title: 'Diplomas Académicos',
    activeTab: 'lista'
  }, () => page) 
})

// Props
const props = defineProps<{
  diplomas: PaginatedResponse<DiplomaAcademico>
  filters: {
    search?: string
  }
}>()

// Computed property to check if there are diplomas
const hasDiplomas = computed(() => props.diplomas.data.length > 0)

// Search functionality
const search = ref(props.filters.search || '')

// We'll use a manual debounce approach instead of watch

let searchTimeout: number
const debouncedSearch = () => {
  clearTimeout(searchTimeout)
  searchTimeout = setTimeout(() => {
    router.get(route('v2.diplomas-academicos.index'), {
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
  router.get(route('v2.diplomas-academicos.index'), {}, {
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
  <Head title="Diplomas Académicos" />
    <!-- Content -->
    <div class="space-y-6">
      <Card>
        <CardHeader class="flex flex-row items-center justify-between">
          <div>
            <CardTitle>Lista de Diplomas</CardTitle>
            <CardDescription>
              Aquí puedes ver, editar y eliminar los diplomas académicos.
            </CardDescription>
          </div>
          <Link :href="route('v2.diplomas-academicos.create')">
            <Button>
              <PlusCircle class="h-4 w-4 mr-2" />
              Registrar Diploma
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

          <div v-if="hasDiplomas">
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
                <TableRow v-for="diploma in diplomas.data" :key="diploma.id">
                  <TableCell>
                    <Badge variant="secondary">{{ diploma.ci }}</Badge>
                  </TableCell>
                  <TableCell>{{ diploma.persona?.nombres }} {{ diploma.persona?.paterno }} {{ diploma.persona?.materno }}</TableCell>
                  <TableCell>{{ diploma.mencion?.nombre }}</TableCell>
                  <TableCell>{{ formatDate(diploma.fecha_emision) }}</TableCell>
                  <TableCell>
                    <Badge 
                      :variant="diploma.file_dir ? 'default' : 'destructive'"
                      class="text-xs"
                    >
                      {{ diploma.file_dir ? '✓ Digitalizado' : '✗ Sin documento' }}
                    </Badge>
                  </TableCell>
                  <TableCell class="text-right">
                    <Button variant="ghost" size="icon" as="a" :href="route('v2.diplomas-academicos.show', diploma.id)">
                      <Eye class="h-4 w-4" />
                    </Button>
                  </TableCell>
                </TableRow>
              </TableBody>
            </Table>

            <!-- Pagination -->
            <div class="flex justify-between items-center mt-6">
              <p class="text-sm text-muted-foreground">
                Mostrando {{ diplomas.from }} a {{ diplomas.to }} de {{ diplomas.total }} resultados.
              </p>
              <div class="flex space-x-2">
                <Button
                  v-for="link in diplomas.links"
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
              {{ search ? 'No se encontraron resultados' : 'No hay diplomas académicos' }}
            </h3>
            <p class="text-muted-foreground mt-2">
              {{ search 
                ? `No se encontraron diplomas que coincidan con "${search}".` 
                : 'Comienza registrando un nuevo diploma académico.' 
              }}
            </p>
            <div class="mt-6 space-x-3">
              <Button v-if="search" variant="outline" @click="clearSearch">
                Limpiar búsqueda
              </Button>
              <Link :href="route('v2.diplomas-academicos.create')">
                <Button>
                  <PlusCircle class="h-4 w-4 mr-2" />
                  {{ search ? 'Registrar Diploma' : 'Registrar Primer Diploma' }}
                </Button>
              </Link>
            </div>
          </div>
        </CardContent>
      </Card>
    </div>
</template>
