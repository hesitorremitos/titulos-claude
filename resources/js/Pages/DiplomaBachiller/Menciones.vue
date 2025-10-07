<template>
  <Head title="Menciones de Diploma" />
  <div class="space-y-6">
    <div class="flex justify-between items-center">
      <div>
        <h1 class="text-2xl font-bold text-foreground">Menciones</h1>
        <p class="text-muted-foreground">
          Administra las menciones disponibles para los diplomas de bachiller.
        </p>
      </div>
      <Button @click="openCreateDialog">
        <Plus class="h-4 w-4 mr-2" />
        Nueva Mención
      </Button>
    </div>

    <Card>
      <CardHeader>
        <CardTitle>Lista de Menciones</CardTitle>
        <CardDescription>
          Total: {{ menciones.total }} menciones registradas
        </CardDescription>
      </CardHeader>
      <CardContent>
        <Table>
          <TableHeader>
            <TableRow>
              <TableHead>Nombre</TableHead>
              <TableHead>Diplomas asociados</TableHead>
              <TableHead class="text-right">Acciones</TableHead>
            </TableRow>
          </TableHeader>
          <TableBody>
            <TableRow v-for="mencion in menciones.data" :key="mencion.id">
              <TableCell class="font-medium">{{ mencion.nombre }}</TableCell>
              <TableCell>{{ mencion.diplomas_count ?? 0 }}</TableCell>
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

        <div v-if="menciones.links.length > 3" class="flex justify-between items-center mt-6">
          <p class="text-sm text-muted-foreground">
            Mostrando {{ menciones.from }} a {{ menciones.to }} de {{ menciones.total }} resultados
          </p>
          <div class="flex space-x-2">
            <Button
              v-for="link in menciones.links"
              :key="link.label"
              :href="link.url || undefined"
              :disabled="!link.url || link.active"
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
        <DialogTitle>{{ editingMencion ? 'Editar Mención' : 'Nueva Mención' }}</DialogTitle>
        <DialogDescription>
          {{ editingMencion ? 'Actualiza el nombre de la mención seleccionada.' : 'Registra una nueva mención para los diplomas.' }}
        </DialogDescription>
      </DialogHeader>

      <div class="space-y-4 py-4">
        <div>
          <Label for="nombre">Nombre de la Mención</Label>
          <Input
            id="nombre"
            v-model="form.nombre"
            placeholder="Ej. Ciencias Sociales"
            :class="form.errors.nombre ? 'border-red-500' : ''"
          />
          <p v-if="form.errors.nombre" class="text-sm text-red-500 mt-1">
            {{ form.errors.nombre }}
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

  <AlertDialog v-model:open="showDeleteDialog">
    <AlertDialogContent>
      <AlertDialogHeader>
        <AlertDialogTitle>¿Eliminar mención?</AlertDialogTitle>
        <AlertDialogDescription>
          Esta acción no se puede deshacer. Se eliminará la mención
          <strong>{{ deletingMencion?.nombre }}</strong>.
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
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { Head, useForm, router, usePage } from '@inertiajs/vue3'
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
import { Plus, Edit, Trash2 } from 'lucide-vue-next'
import { toast } from 'vue-sonner'
import type { MencionDiplomaBachiller, PaginatedResponse } from '@/types/titulos/diploma-bachiller'

defineOptions({
  layout: (h: any, page: any) => h(AppLayout, {
    title: 'Menciones Diploma Bachiller',
    pageTitle: 'Menciones Diploma Bachiller',
    navTabs,
    activeTab: 'menciones'
  }, () => page)
})

// eslint-disable-next-line @typescript-eslint/no-unused-vars
const props = defineProps<{
  menciones: PaginatedResponse<MencionDiplomaBachiller>
}>()

const page = usePage()
const showFormDialog = ref(false)
const showDeleteDialog = ref(false)
const editingMencion = ref<MencionDiplomaBachiller | null>(null)
const deletingMencion = ref<MencionDiplomaBachiller | null>(null)

const form = useForm({
  nombre: '',
})

const openCreateDialog = () => {
  editingMencion.value = null
  form.reset()
  form.clearErrors()
  showFormDialog.value = true
}

const openEditDialog = (mencion: MencionDiplomaBachiller) => {
  editingMencion.value = mencion
  form.reset()
  form.clearErrors()
  form.nombre = mencion.nombre
  showFormDialog.value = true
}

const closeFormDialog = () => {
  showFormDialog.value = false
  form.reset()
  form.clearErrors()
  editingMencion.value = null
}

const submitForm = () => {
  if (editingMencion.value) {
    form.put(route('diploma-bachiller.menciones.update', editingMencion.value.id), {
      onSuccess: () => {
        const flash = (page.props.flash as any)
        toast.success(flash?.success ?? 'Mención actualizada correctamente.')
        closeFormDialog()
      },
      onError: (errors) => {
        toast.error(errors.error ?? 'Revisa los datos ingresados.')
      }
    })
  } else {
    form.post(route('diploma-bachiller.menciones.store'), {
      onSuccess: () => {
        const flash = (page.props.flash as any)
        toast.success(flash?.success ?? 'Mención creada correctamente.')
        closeFormDialog()
      },
      onError: (errors) => {
        toast.error(errors.error ?? 'Revisa los datos ingresados.')
      }
    })
  }
}

const openDeleteDialog = (mencion: MencionDiplomaBachiller) => {
  deletingMencion.value = mencion
  showDeleteDialog.value = true
}

const deleteMencion = () => {
  if (!deletingMencion.value) return

  router.delete(route('diploma-bachiller.menciones.destroy', deletingMencion.value.id), {
    onSuccess: () => {
      const flash = (page.props.flash as any)
      if (flash?.error) {
        toast.error(flash.error)
      } else {
        toast.success(flash?.success ?? 'Mención eliminada correctamente.')
      }
      showDeleteDialog.value = false
      deletingMencion.value = null
    },
    onError: (errors) => {
      toast.error(errors.error ?? 'No se pudo eliminar la mención.')
      showDeleteDialog.value = false
      deletingMencion.value = null
    }
  })
}
</script>
