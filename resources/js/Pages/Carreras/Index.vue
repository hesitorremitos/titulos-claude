<template>
  <AppLayout 
    title="Carreras"
    :breadcrumbs="[
      { label: 'Carreras' }
    ]"
  >
    <div class="space-y-6">
      <!-- Header -->
      <div class="border-b border-border pb-4">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
          <div>
            <h1 class="text-2xl font-bold tracking-tight">Carreras</h1>
            <p class="text-muted-foreground">
              Gestiona las carreras académicas por facultad
            </p>
          </div>
          <Button as-child>
            <Link :href="route('v2.carreras.create')">
              <Icon icon="mdi:plus" class="h-4 w-4 mr-2" />
              Nueva Carrera
            </Link>
          </Button>
        </div>
      </div>

      <!-- Search and Filters -->
      <Card>
        <CardContent class="p-6">
          <div class="flex flex-col gap-4 lg:flex-row lg:items-center">
            <div class="flex-1">
              <div class="flex gap-2">
                <div class="relative flex-1">
                  <Icon 
                    icon="mdi:magnify" 
                    class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-muted-foreground" 
                  />
                  <Input
                    v-model="searchTerm"
                    placeholder="Buscar carreras por código, nombre o dirección..."
                    class="pl-10"
                    @keyup.enter="handleSearch"
                  />
                </div>
                <Button @click="handleSearch" variant="outline">
                  <Icon icon="mdi:magnify" class="h-4 w-4" />
                </Button>
                <Button v-if="searchTerm" @click="clearSearch" variant="ghost" size="sm">
                  <Icon icon="mdi:close" class="h-4 w-4" />
                </Button>
              </div>
            </div>
            <div class="flex items-center gap-4">
              <div class="min-w-[200px]">
                <Select v-model="selectedFacultad" @update:modelValue="handleFacultadFilter">
                  <SelectTrigger>
                    <SelectValue placeholder="Filtrar por facultad" />
                  </SelectTrigger>
                  <SelectContent>
                    <SelectItem value="all">Todas las facultades</SelectItem>
                    <SelectItem 
                      v-for="facultad in facultades" 
                      :key="facultad.id" 
                      :value="facultad.id.toString()"
                    >
                      {{ facultad.nombre }}
                    </SelectItem>
                  </SelectContent>
                </Select>
              </div>
              <div class="flex items-center gap-2">
                <span class="text-sm text-muted-foreground">
                  {{ carreras.total }} carreras
                </span>
              </div>
            </div>
          </div>
        </CardContent>
      </Card>

      <!-- Table -->
      <Card>
        <Table>
          <TableHeader>
            <TableRow>
              <TableHead>Código</TableHead>
              <TableHead>Programa</TableHead>
              <TableHead>Facultad</TableHead>
              <TableHead>Dirección</TableHead>
              <TableHead class="text-right">Acciones</TableHead>
            </TableRow>
          </TableHeader>
          <TableBody>
            <TableRow v-for="carrera in carreras.data" :key="carrera.id" class="group">
              <TableCell>
                <code class="relative rounded bg-muted px-[0.3rem] py-[0.2rem] font-mono text-sm font-medium">
                  {{ carrera.id }}
                </code>
              </TableCell>
              <TableCell>
                <div class="font-medium">
                  {{ carrera.programa }}
                </div>
              </TableCell>
              <TableCell>
                <span class="text-muted-foreground">
                  {{ carrera.facultad.nombre }}
                </span>
              </TableCell>
              <TableCell>
                <span class="text-muted-foreground">
                  {{ carrera.direccion || 'No especificada' }}
                </span>
              </TableCell>
              <TableCell class="text-right">
                <div class="opacity-0 group-hover:opacity-100 transition-opacity">
                  <TooltipProvider>
                    <Tooltip>
                      <TooltipTrigger as-child>
                        <Button variant="ghost" size="sm" as-child>
                          <Link :href="route('v2.carreras.show', carrera.id)">
                            <Icon icon="mdi:eye" class="h-4 w-4" />
                          </Link>
                        </Button>
                      </TooltipTrigger>
                      <TooltipContent>
                        <p>Ver detalles</p>
                      </TooltipContent>
                    </Tooltip>
                  </TooltipProvider>
                </div>
              </TableCell>
            </TableRow>
          </TableBody>
          <TableEmpty v-if="carreras.data.length === 0">
            <div class="flex flex-col items-center justify-center py-8">
              <Icon icon="mdi:book-education" class="h-12 w-12 text-muted-foreground mb-4" />
              <h3 class="text-lg font-medium">No se encontraron carreras</h3>
              <p class="text-muted-foreground mb-4">
                {{ searchTerm || (selectedFacultad && selectedFacultad !== 'all') ? 'Intenta con otros términos de búsqueda o filtros.' : 'Comienza creando tu primera carrera.' }}
              </p>
              <Button as-child v-if="!searchTerm && (!selectedFacultad || selectedFacultad === 'all')">
                <Link :href="route('v2.carreras.create')">
                  <Icon icon="mdi:plus" class="h-4 w-4 mr-2" />
                  Nueva Carrera
                </Link>
              </Button>
            </div>
          </TableEmpty>
        </Table>
      </Card>

      <!-- Pagination -->
      <div v-if="carreras.last_page > 1" class="flex items-center justify-between">
        <div class="text-sm text-muted-foreground">
          Mostrando {{ carreras.from || 0 }} a {{ carreras.to || 0 }} de {{ carreras.total }} resultados
        </div>
        
        <Pagination 
          v-slot="{ page }" 
          :total="carreras.total" 
          :items-per-page="carreras.per_page"
          :default-page="carreras.current_page"
          @update:page="goToPage"
        >
          <PaginationContent>
            <PaginationPrevious />
            <PaginationNext />
          </PaginationContent>
        </Pagination>
      </div>
    </div>
  </AppLayout>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { router, Link } from '@inertiajs/vue3'
import { Icon } from '@iconify/vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { Card, CardContent } from '@/components/ui/card'
import { 
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from '@/components/ui/select'
import { 
  Table, 
  TableBody, 
  TableCell, 
  TableHead, 
  TableHeader, 
  TableRow,
  TableEmpty
} from '@/components/ui/table'
import {
  Pagination,
  PaginationContent,
  PaginationNext,
  PaginationPrevious,
} from '@/components/ui/pagination'
import { 
  Tooltip,
  TooltipContent,
  TooltipProvider,
  TooltipTrigger,
} from '@/components/ui/tooltip'
import { toast } from 'vue-sonner'

interface Facultad {
  id: number
  nombre: string
}

interface Carrera {
  id: string
  programa: string
  direccion: string | null
  facultad: Facultad
}

interface PaginatedCarreras {
  data: Carrera[]
  current_page: number
  last_page: number
  per_page: number
  total: number
  from: number | null
  to: number | null
  prev_page_url: string | null
  next_page_url: string | null
}

interface Props {
  carreras: PaginatedCarreras
  facultades: Facultad[]
  filters: {
    search?: string
    facultad_id?: string
  }
}

const props = defineProps<Props>()

const searchTerm = ref(props.filters.search || '')
const selectedFacultad = ref(props.filters.facultad_id || 'all')

// Methods
const buildQueryParams = () => {
  const params = new URLSearchParams()
  
  if (searchTerm.value) {
    params.set('search', searchTerm.value)
  }
  
  if (selectedFacultad.value && selectedFacultad.value !== 'all') {
    params.set('facultad_id', selectedFacultad.value)
  }
  
  return params
}

const handleSearch = () => {
  const params = buildQueryParams()
  params.delete('page') // Reset to page 1 when searching
  
  const url = `${window.location.pathname}?${params.toString()}`
  
  router.get(url, {}, {
    preserveState: true,
    preserveScroll: true,
  })
}

const handleFacultadFilter = () => {
  const params = buildQueryParams()
  params.delete('page') // Reset to page 1 when filtering
  
  const url = `${window.location.pathname}?${params.toString()}`
  
  router.get(url, {}, {
    preserveState: true,
    preserveScroll: true,
  })
}

const goToPage = (page: number) => {
  const params = buildQueryParams()
  params.set('page', page.toString())
  
  const url = `${window.location.pathname}?${params.toString()}`
  
  router.get(url, {}, {
    preserveState: true,
    preserveScroll: true,
  })
}

const clearSearch = () => {
  searchTerm.value = ''
  handleSearch()
}
</script>