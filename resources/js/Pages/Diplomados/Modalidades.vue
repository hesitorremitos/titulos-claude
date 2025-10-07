<template>
  <Head title="Modalidades de Diplomado" />
  <div class="space-y-6">
    <div class="flex justify-between items-center">
      <div>
        <h1 class="text-2xl font-bold text-foreground">Modalidades de Diplomado</h1>
        <p class="text-muted-foreground">
          Administra las modalidades disponibles para los diplomados.
        </p>
      </div>
      <Button @click="openCreateDialog">
        <Plus class="h-4 w-4 mr-2" />
        Nueva Modalidad
      </Button>
    </div>

    <Card>
      <CardHeader>
        <CardTitle>Lista de Modalidades</CardTitle>
        <CardDescription>
          Total: {{ modalidades.total }} modalidades registradas
        </CardDescription>
      </CardHeader>
      <CardContent>
        <Table>
          <TableHeader>
            <TableRow>
              <TableHead>Nombre</TableHead>
              <TableHead>Estado</TableHead>
              <TableHead>Diplomados asociados</TableHead>
              <TableHead class="text-right">Acciones</TableHead>
            </TableRow>
          </TableHeader>
          <TableBody>
            <TableRow v-for="modalidad in modalidades.data" :key="modalidad.id">
              <TableCell class="font-medium">{{ modalidad.nombre }}</TableCell>
              <TableCell>
                <Badge :variant="modalidad.activo ? 'default' : 'secondary'">
                  {{ modalidad.activo ? 'Activa' : 'Inactiva' }}
                </Badge>
              </TableCell>
              <TableCell>{{ modalidad.diplomados_count ?? 0 }}</TableCell>
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

        <div v-if="modalidades.links.length > 3" class="flex justify-between items-center mt-6">
          <p class="text-sm text-muted-foreground">
            Mostrando {{ modalidades.from }} a {{ modalidades.to }} de {{ modalidades.total }} resultados
          </p>
          <div class="flex space-x-2">
            <Button
              v-for="link in modalidades.links"
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
      </CardContent>
    </Card>
  </div>

  <Dialog v-model:open="showFormDialog">
    <DialogContent class="sm:max-w-[420px]">
      <DialogHeader>
        <DialogTitle>{{ editingModalidad ? 'Editar Modalidad' : 'Nueva Modalidad' }}</DialogTitle>
        <DialogDescription>
          {{ editingModalidad ? 'Modifique los datos de la modalidad seleccionada.' : 'Registre una nueva modalidad para los diplomados.' }}
        </DialogDescription>
      </DialogHeader>

      <div class="space-y-4 py-4">
        <div>
          <Label for="nombre">Nombre de la Modalidad</Label>
          <Input
            id="nombre"
            v-model="form.nombre"
            placeholder="Ej. Semipresencial"
            :class="form.errors.nombre ? 'border-red-500' : ''"
          />
          <p v-if="form.errors.nombre" class="text-sm text-red-500 mt-1">
            {{ form.errors.nombre }}
          </p>
        </div>
        <div class="flex items-center space-x-2">
          <Switch id="activo" v-model:checked="form.activo" />
          <Label for="activo">Modalidad activa</Label>
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

  <AlertDialog v-model:open="showDeleteDialog">
    <AlertDialogContent>
      <AlertDialogHeader>
        <AlertDialogTitle>¿Eliminar modalidad?</AlertDialogTitle>
        <AlertDialogDescription>
          Esta acción no se puede deshacer. Se eliminará la modalidad
          <strong>{{ deletingModalidad?.nombre }}</strong>.
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
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { Head, router, useForm, usePage } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import navTabs from './navtabs.json'
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
import { Badge } from '@/components/ui/badge'
import { Switch } from '@/components/ui/switch'
import { Plus, Edit, Trash2 } from 'lucide-vue-next'
import type { ModalidadDiplomado, PaginatedResponse } from '@/types/titulos/diplomado'
import { toast } from 'vue-sonner'

defineOptions({
  layout: (h: any, page: any) => h(AppLayout, {
    title: 'Modalidades Diplomado',
    pageTitle: 'Modalidades Diplomado',
    navTabs,
    activeTab: 'modalidades'
  }, () => page)
})

const props = defineProps<{
  modalidades: PaginatedResponse<ModalidadDiplomado>
}>()

const page = usePage()
const showFormDialog = ref(false)
const showDeleteDialog = ref(false)
const editingModalidad = ref<ModalidadDiplomado | null>(null)
const deletingModalidad = ref<ModalidadDiplomado | null>(null)

const form = useForm({
  nombre: '',
  activo: true,
})

const openCreateDialog = () => {
  editingModalidad.value = null
  form.reset()
  form.clearErrors()
  form.activo = true
  showFormDialog.value = true
}

const openEditDialog = (modalidad: ModalidadDiplomado) => {
  editingModalidad.value = modalidad
  form.reset()
  form.clearErrors()
  form.nombre = modalidad.nombre
  form.activo = modalidad.activo
  showFormDialog.value = true
}

const closeFormDialog = () => {
  showFormDialog.value = false
  form.reset()
  form.clearErrors()
  editingModalidad.value = null
}

const submitForm = () => {
  if (editingModalidad.value) {
    form.put(route('diplomados.modalidades.update', editingModalidad.value.id), {
      onSuccess: () => {
        toast.success((page.props.flash as any)?.success ?? 'Modalidad actualizada correctamente.')
        closeFormDialog()
      },
      onError: (errors: any) => {
        toast.error(errors.nombre ?? 'Revisa los datos ingresados.')
      }
    })
  } else {
    form.post(route('diplomados.modalidades.store'), {
      onSuccess: () => {
        toast.success((page.props.flash as any)?.success ?? 'Modalidad creada correctamente.')
        closeFormDialog()
      },
      onError: (errors: any) => {
        toast.error(errors.nombre ?? 'Revisa los datos ingresados.')
      }
    })
  }
}

const openDeleteDialog = (modalidad: ModalidadDiplomado) => {
  deletingModalidad.value = modalidad
  showDeleteDialog.value = true
}

const deleteModalidad = () => {
  if (!deletingModalidad.value) return

  router.delete(route('diplomados.modalidades.destroy', deletingModalidad.value.id), {
    onSuccess: () => {
      const flash = (page.props.flash as any)
      if (flash?.error) {
        toast.error(flash.error)
      } else {
        toast.success(flash?.success ?? 'Modalidad eliminada correctamente.')
      }
      showDeleteDialog.value = false
      deletingModalidad.value = null
    },
    onError: (errors) => {
      toast.error(errors.error ?? 'No se pudo eliminar la modalidad.')
      showDeleteDialog.value = false
    }
  })
}
</script>
