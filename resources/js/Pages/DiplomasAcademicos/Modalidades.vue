<template>
  <Head title="Modalidades de Graduación" />
  
  <AppLayout
    title="Modalidades de Graduación"
    page-title="Modalidades de Graduación"
    :breadcrumbs="breadcrumbs"
    :nav-tabs="navTabs"
    active-tab="modalidades"
  >
    <div class="space-y-6">
      <!-- Header con botón crear -->
      <div class="flex justify-between items-center">
        <div>
          <h1 class="text-2xl font-bold text-foreground">Modalidades de Graduación</h1>
          <p class="text-muted-foreground">
            Gestione las modalidades de graduación disponibles para los diplomas académicos
          </p>
        </div>
        <Button @click="openCreateDialog">
          <Plus class="h-4 w-4 mr-2" />
          Nueva Modalidad
        </Button>
      </div>

      <!-- Tabla de modalidades -->
      <Card>
        <CardHeader>
          <CardTitle>Lista de Modalidades</CardTitle>
          <CardDescription>
            Total: {{ modalidades.data.length }} modalidades registradas
          </CardDescription>
        </CardHeader>
        <CardContent>
          <Table>
            <TableHeader>
              <TableRow>
                <TableHead>Modalidad de Graduación</TableHead>
                <TableHead>Diplomas Asociados</TableHead>
                <TableHead class="text-right">Acciones</TableHead>
              </TableRow>
            </TableHeader>
            <TableBody>
              <TableRow v-for="modalidad in modalidades.data" :key="modalidad.id">
                <TableCell class="font-medium">{{ modalidad.medio_graduacion }}</TableCell>
                <TableCell>
                  <Badge variant="secondary">
                    {{ modalidad.diplomas_count || 0 }} diplomas
                  </Badge>
                </TableCell>
                <TableCell class="text-right">
                  <div class="flex justify-end space-x-2">
                    <Button variant="ghost" size="icon" @click="openEditDialog(modalidad)">
                      <Edit class="h-4 w-4" />
                    </Button>
                    <Button variant="ghost" size="icon" @click="openDeleteDialog(modalidad)">
                      <Trash2 class="h-4 w-4 text-red-500" />
                    </Button>
                  </div>
                </TableCell>
              </TableRow>
            </TableBody>
          </Table>

          <!-- Pagination -->
          <div v-if="modalidades.links.length > 3" class="flex justify-between items-center mt-6">
            <p class="text-sm text-muted-foreground">
              Mostrando {{ modalidades.from }} a {{ modalidades.to }} de {{ modalidades.total }} resultados
            </p>
            <div class="flex space-x-2">
              <Button
                v-for="link in modalidades.links"
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
        </CardContent>
      </Card>
    </div>

    <!-- Dialog Crear/Editar -->
    <Dialog v-model:open="showFormDialog">
      <DialogContent class="sm:max-w-[400px]">
        <DialogHeader>
          <DialogTitle>{{ editingModalidad ? 'Editar Modalidad' : 'Nueva Modalidad' }}</DialogTitle>
          <DialogDescription>
            {{ editingModalidad ? 'Modifique el nombre de la modalidad de graduación' : 'Ingrese el nombre de la nueva modalidad de graduación' }}
          </DialogDescription>
        </DialogHeader>
        
        <div class="space-y-4 py-4">
          <div>
            <Label for="medio_graduacion">Modalidad de Graduación</Label>
            <Input
              id="medio_graduacion"
              v-model="form.medio_graduacion"
              placeholder="Ej. Tesis de Grado, Proyecto de Grado, etc."
              :class="form.errors.medio_graduacion ? 'border-red-500' : ''"
            />
            <p v-if="form.errors.medio_graduacion" class="text-sm text-red-500 mt-1">
              {{ form.errors.medio_graduacion }}
            </p>
          </div>
        </div>

        <DialogFooter>
          <Button variant="outline" @click="closeFormDialog">Cancelar</Button>
          <Button @click="submitForm" :disabled="form.processing">
            <span v-if="form.processing">Guardando...</span>
            <span v-else>{{ editingModalidad ? 'Actualizar' : 'Crear' }}</span>
          </Button>
        </DialogFooter>
      </DialogContent>
    </Dialog>

    <!-- Dialog Eliminar -->
    <AlertDialog v-model:open="showDeleteDialog">
      <AlertDialogContent>
        <AlertDialogHeader>
          <AlertDialogTitle>¿Eliminar modalidad?</AlertDialogTitle>
          <AlertDialogDescription>
            Esta acción no se puede deshacer. Se eliminará permanentemente la modalidad
            <strong>{{ deletingModalidad?.medio_graduacion }}</strong>
            <span v-if="deletingModalidad?.diplomas_count && deletingModalidad.diplomas_count > 0">
              y puede afectar a {{ deletingModalidad.diplomas_count }} diploma(s) asociado(s).
            </span>
          </AlertDialogDescription>
        </AlertDialogHeader>
        <AlertDialogFooter>
          <AlertDialogCancel>Cancelar</AlertDialogCancel>
          <AlertDialogAction @click="deleteModalidad" class="bg-destructive text-destructive-foreground hover:bg-destructive/90">
            Eliminar
          </AlertDialogAction>
        </AlertDialogFooter>
      </AlertDialogContent>
    </AlertDialog>
  </AppLayout>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { Head, useForm, router, usePage } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { Badge } from '@/components/ui/badge'
import {
  Table,
  TableBody,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from '@/components/ui/table'
import {
  Dialog,
  DialogContent,
  DialogDescription,
  DialogFooter,
  DialogHeader,
  DialogTitle,
} from '@/components/ui/dialog'
import {
  AlertDialog,
  AlertDialogAction,
  AlertDialogCancel,
  AlertDialogContent,
  AlertDialogDescription,
  AlertDialogFooter,
  AlertDialogHeader,
  AlertDialogTitle,
} from '@/components/ui/alert-dialog'
import { Plus, Edit, Trash2 } from 'lucide-vue-next'
import { toast } from 'vue-sonner'
import type { GraduacionDa, PaginatedResponse } from '@/types/models'
import type { PageProps } from '@/types/ui'

// Props
interface Props extends PageProps {
  modalidades: PaginatedResponse<GraduacionDa>
}

const props = defineProps<Props>()
const page = usePage()

// Navigation tabs
const navTabs = [
  { label: 'Lista', href: route('v2.diplomas-academicos.index'), icon: 'material-symbols:list', value: 'lista' },
  { label: 'Registrar', href: route('v2.diplomas-academicos.create'), icon: 'material-symbols:add', value: 'registrar' },
  { label: 'Menciones', href: route('v2.menciones.index'), icon: 'material-symbols:category', value: 'menciones' },
  { label: 'Modalidades', href: route('v2.modalidades.index'), icon: 'material-symbols:school', value: 'modalidades' },
]

// Breadcrumbs
const breadcrumbs = [{ label: 'Diplomas Académicos', href: null }]

// State
const showFormDialog = ref(false)
const showDeleteDialog = ref(false)
const editingModalidad = ref<GraduacionDa | null>(null)
const deletingModalidad = ref<GraduacionDa | null>(null)

// Form
const form = useForm({
  medio_graduacion: '',
})

// Dialog methods
const openCreateDialog = () => {
  editingModalidad.value = null
  form.reset()
  form.clearErrors()
  showFormDialog.value = true
}

const openEditDialog = (modalidad: GraduacionDa) => {
  editingModalidad.value = modalidad
  form.medio_graduacion = modalidad.medio_graduacion
  form.clearErrors()
  showFormDialog.value = true
}

const closeFormDialog = () => {
  showFormDialog.value = false
  editingModalidad.value = null
  form.reset()
}

const openDeleteDialog = (modalidad: GraduacionDa) => {
  deletingModalidad.value = modalidad
  showDeleteDialog.value = true
}


// Actions
const submitForm = () => {
  if (editingModalidad.value) {
    // Update
    form.put(route('v2.modalidades.update', editingModalidad.value.id), {
      onSuccess: () => {
        closeFormDialog()
        toast.success(page.props.flash.success)
      },
      onError: (errors) => {
        toast.error(errors.error)
      }
    })
  } else {
    // Create
    form.post(route('v2.modalidades.store'), {
      onSuccess: () => {
        closeFormDialog()
        toast.success(page.props.flash.success)
      },
      onError: (errors) => {
        toast.error(errors.error)
      }
    })
  }
}

const deleteModalidad = () => {
  if (deletingModalidad.value) {
    router.delete(route('v2.modalidades.destroy', deletingModalidad.value.id), {
      onSuccess: () => {
        showDeleteDialog.value = false
        deletingModalidad.value = null
        toast.success(page.props.flash.success)
      },
      onError: (errors) => {
        showDeleteDialog.value = false
        toast.error(errors.error)
      }
    })
  }
}
</script>