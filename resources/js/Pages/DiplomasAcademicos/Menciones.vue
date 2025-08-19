<template>
  <Head title="Menciones Académicas" />
  
  <AppLayout
    title="Menciones Académicas"
    page-title="Menciones Académicas"
    :breadcrumbs="breadcrumbs"
    :nav-tabs="navTabs"
    active-tab="menciones"
  >
    <div class="space-y-6">
      <!-- Header con botón crear -->
      <div class="flex justify-between items-center">
        <div>
          <h1 class="text-2xl font-bold text-foreground">Menciones Académicas</h1>
          <p class="text-muted-foreground">
            Gestione las menciones académicas disponibles para los diplomas
          </p>
        </div>
        <Button @click="openCreateDialog">
          <Plus class="h-4 w-4 mr-2" />
          Nueva Mención
        </Button>
      </div>

      <!-- Tabla de menciones -->
      <Card>
        <CardHeader>
          <CardTitle>Lista de Menciones</CardTitle>
          <CardDescription>
            Total: {{ menciones.data.length }} menciones registradas
          </CardDescription>
        </CardHeader>
        <CardContent>
          <Table>
            <TableHeader>
              <TableRow>
                <TableHead>Nombre</TableHead>
                <TableHead>Carrera</TableHead>
                <TableHead class="text-right">Acciones</TableHead>
              </TableRow>
            </TableHeader>
            <TableBody>
              <TableRow v-for="mencion in menciones.data" :key="mencion.id">
                <TableCell class="font-medium">{{ mencion.nombre }}</TableCell>
                <TableCell>{{ mencion.carrera?.programa }}</TableCell>
                <TableCell class="text-right">
                  <div class="flex justify-end space-x-2">
                    <Button variant="ghost" size="icon" @click="openEditDialog(mencion)">
                      <Edit class="h-4 w-4" />
                    </Button>
                    <Button variant="ghost" size="icon" @click="openDeleteDialog(mencion)">
                      <Trash2 class="h-4 w-4 text-red-500" />
                    </Button>
                  </div>
                </TableCell>
              </TableRow>
            </TableBody>
          </Table>

          <!-- Pagination -->
          <div v-if="menciones.links.length > 3" class="flex justify-between items-center mt-6">
            <p class="text-sm text-muted-foreground">
              Mostrando {{ menciones.from }} a {{ menciones.to }} de {{ menciones.total }} resultados
            </p>
            <div class="flex space-x-2">
              <Button
                v-for="link in menciones.links"
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
      <DialogContent class="sm:max-w-[500px]">
        <DialogHeader>
          <DialogTitle>{{ editingMencion ? 'Editar Mención' : 'Nueva Mención' }}</DialogTitle>
          <DialogDescription>
            {{ editingMencion ? 'Modifique los datos de la mención académica' : 'Complete los datos para crear una nueva mención académica' }}
          </DialogDescription>
        </DialogHeader>
        
        <div class="space-y-4 py-4">
          <div>
            <Label for="nombre">Nombre de la Mención</Label>
            <Input
              id="nombre"
              v-model="form.nombre"
              placeholder="Ej. Sistemas de Información"
              :class="form.errors.nombre ? 'border-red-500' : ''"
            />
            <p v-if="form.errors.nombre" class="text-sm text-red-500 mt-1">
              {{ form.errors.nombre }}
            </p>
          </div>

          <div>
            <Label for="carrera_id">Carrera</Label>
            <Select v-model="form.carrera_id">
              <SelectTrigger :class="form.errors.carrera_id ? 'border-red-500' : ''">
                <SelectValue placeholder="Seleccione una carrera" />
              </SelectTrigger>
              <SelectContent>
                <SelectGroup v-for="facultad in carreras" :key="facultad.id">
                  <SelectLabel>{{ facultad.nombre }}</SelectLabel>
                  <SelectItem 
                    v-for="carrera in facultad.carreras" 
                    :key="carrera.id" 
                    :value="carrera.id"
                  >
                    {{ carrera.programa }}
                  </SelectItem>
                </SelectGroup>
              </SelectContent>
            </Select>
            <p v-if="form.errors.carrera_id" class="text-sm text-red-500 mt-1">
              {{ form.errors.carrera_id }}
            </p>
          </div>
        </div>

        <DialogFooter>
          <Button variant="outline" @click="closeFormDialog">Cancelar</Button>
          <Button @click="submitForm" :disabled="form.processing">
            <span v-if="form.processing">Guardando...</span>
            <span v-else>{{ editingMencion ? 'Actualizar' : 'Crear' }}</span>
          </Button>
        </DialogFooter>
      </DialogContent>
    </Dialog>

    <!-- Dialog Eliminar -->
    <AlertDialog v-model:open="showDeleteDialog">
      <AlertDialogContent>
        <AlertDialogHeader>
          <AlertDialogTitle>¿Eliminar mención?</AlertDialogTitle>
          <AlertDialogDescription>
            Esta acción no se puede deshacer. Se eliminará permanentemente la mención
            <strong>{{ deletingMencion?.nombre }}</strong> y puede afectar a los diplomas asociados.
          </AlertDialogDescription>
        </AlertDialogHeader>
        <AlertDialogFooter>
          <AlertDialogCancel>Cancelar</AlertDialogCancel>
          <AlertDialogAction @click="deleteMencion" class="bg-destructive text-destructive-foreground hover:bg-destructive/90">
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
import {
  Select,
  SelectContent,
  SelectGroup,
  SelectItem,
  SelectLabel,
  SelectTrigger,
  SelectValue,
} from '@/components/ui/select'
import { Plus, Edit, Trash2 } from 'lucide-vue-next'
import { toast } from 'vue-sonner'
import type { MencionDa, Facultad, Carrera, PaginatedResponse } from '@/types/models'
import type { PageProps } from '@/types/ui'

// Props
interface Props extends PageProps {
  menciones: PaginatedResponse<MencionDa>
  carreras: Facultad[]
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
const editingMencion = ref<MencionDa | null>(null)
const deletingMencion = ref<MencionDa | null>(null)

// Form
const form = useForm({
  nombre: '',
  carrera_id: '',
})

// Dialog methods
const openCreateDialog = () => {
  editingMencion.value = null
  form.reset()
  form.clearErrors()
  showFormDialog.value = true
}

const openEditDialog = (mencion: MencionDa) => {
  editingMencion.value = mencion
  form.nombre = mencion.nombre
  form.carrera_id = mencion.carrera_id
  form.clearErrors()
  showFormDialog.value = true
}

const closeFormDialog = () => {
  showFormDialog.value = false
  editingMencion.value = null
  form.reset()
}

const openDeleteDialog = (mencion: MencionDa) => {
  deletingMencion.value = mencion
  showDeleteDialog.value = true
}



// Actions
const submitForm = () => {
  if (editingMencion.value) {
    // Update
    form.put(route('v2.menciones.update', editingMencion.value.id), {
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
    form.post(route('v2.menciones.store'), {
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

const deleteMencion = () => {
  if (deletingMencion.value) {
    router.delete(route('v2.menciones.destroy', deletingMencion.value.id), {
      onSuccess: () => {
        showDeleteDialog.value = false
        deletingMencion.value = null
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