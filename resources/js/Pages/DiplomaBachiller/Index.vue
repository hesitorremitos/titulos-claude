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
import type { DiplomaBachiller, PaginatedResponse } from '@/types/titulos/diploma-bachiller'

defineOptions({
  layout: (h: any, page: any) => h(AppLayout, {
    title: 'Diplomas de Bachiller',
    pageTitle: 'Diplomas de Bachiller',
    navTabs,
    activeTab: 'lista'
  }, () => page)
})

const props = defineProps<{
  diplomas: PaginatedResponse<DiplomaBachiller>
  filters: {
    search?: string
  }
}>()

const hasDiplomas = computed(() => props.diplomas.data.length > 0)

const search = ref(props.filters.search || '')

let searchTimeout: number
const debouncedSearch = () => {
  clearTimeout(searchTimeout)
  searchTimeout = setTimeout(() => {
    router.get(route('diploma-bachiller.index'), {
      search: search.value || undefined,
    }, {
      preserveState: true,
      replace: true,
    })
  }, 300)
}

const clearSearch = () => {
  search.value = ''
  router.get(route('diploma-bachiller.index'), {}, {
    preserveState: true,
    replace: true,
  })
}

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
  <Head title="Diplomas de Bachiller" />
  <div class="space-y-6">
    <Card>
      <CardHeader class="flex flex-row items-center justify-between">
        <div>
          <CardTitle>Lista de Diplomas</CardTitle>
          <CardDescription>
            Gestiona los diplomas de bachiller registrados en el sistema.
          </CardDescription>
        </div>
        <Link :href="route('diploma-bachiller.create')">
          <Button>
            <PlusCircle class="h-4 w-4 mr-2" />
            Registrar Diploma
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
                  <Button variant="ghost" size="icon" as="a" :href="route('diploma-bachiller.show', diploma.id)">
                    <Eye class="h-4 w-4" />
                  </Button>
                </TableCell>
              </TableRow>
            </TableBody>
          </Table>
        </div>

        <div v-else class="flex flex-col items-center justify-center py-12 text-center space-y-4">
          <Icon icon="lucide:graduation-cap" class="h-12 w-12 text-muted-foreground" />
          <div class="space-y-2">
            <p class="text-lg font-semibold text-foreground">No hay diplomas registrados</p>
            <p class="text-muted-foreground">Comienza registrando un nuevo diploma de bachiller.</p>
          </div>
          <Button :href="route('diploma-bachiller.create')" as="a">
            Registrar Diploma
          </Button>
        </div>
      </CardContent>
    </Card>
  </div>
</template>
