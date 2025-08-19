<script setup lang="ts">
import { computed } from 'vue'
import { Head, Link } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
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
import { Eye, Pencil, Trash2, PlusCircle } from 'lucide-vue-next'
import type { DiplomaAcademico, PaginatedResponse } from '@/types/models'

// Props
const props = defineProps<{
  diplomas: PaginatedResponse<DiplomaAcademico>
}>()

// Navigation tabs
const navTabs = [
    { label: 'Lista', href: route('v2.diplomas-academicos.index'), icon: 'material-symbols:list', value: 'lista' },
    { label: 'Registrar', href: route('v2.diplomas-academicos.create'), icon: 'material-symbols:add', value: 'registrar' },
    { label: 'Menciones', href: route('v2.menciones.index'), icon: 'material-symbols:category', value: 'menciones' },
    { label: 'Modalidades', href: route('v2.modalidades.index'), icon: 'material-symbols:school', value: 'modalidades' },
];

// Breadcrumbs
const breadcrumbs = [{ label: 'Diplomas Académicos', href: null }];

// Computed property to check if there are diplomas
const hasDiplomas = computed(() => props.diplomas.data.length > 0)

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

  <AppLayout
    title="Diplomas Académicos"
    page-title="Diplomas Académicos"
    :breadcrumbs="breadcrumbs"
    :nav-tabs="navTabs"
    active-tab="lista"
  >
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
          <div v-if="hasDiplomas">
            <Table>
              <TableHeader>
                <TableRow>
                  <TableHead>CI</TableHead>
                  <TableHead>Nombre Completo</TableHead>
                  <TableHead>Mención</TableHead>
                  <TableHead>Fecha Emisión</TableHead>
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
                  v-html="link.label"
                  size="sm"
                  :variant="link.active ? 'default' : 'outline'"
                  as="a"
                />
              </div>
            </div>
          </div>

          <!-- Empty State -->
          <div v-else class="text-center py-16">
            <Icon icon="material-symbols:school" class="h-16 w-16 text-muted-foreground mx-auto mb-6" />
            <h3 class="text-xl font-semibold">No hay diplomas académicos</h3>
            <p class="text-muted-foreground mt-2">
              Comienza registrando un nuevo diploma académico.
            </p>
            <Link :href="route('v2.diplomas-academicos.create')" class="mt-6 inline-block">
              <Button>
                <PlusCircle class="h-4 w-4 mr-2" />
                Registrar Primer Diploma
              </Button>
            </Link>
          </div>
        </CardContent>
      </Card>
    </div>
  </AppLayout>
</template>
