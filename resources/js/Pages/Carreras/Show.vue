<template>
  <AppLayout 
    :title="`${carrera.programa} - ${carrera.id}`"
    :breadcrumbs="[
      { label: 'Carreras', href: route('v2.carreras.index') },
      { label: carrera.programa }
    ]"
  >
    <div class="space-y-6">
      <!-- Header -->
      <div class="border-b border-border pb-4">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
          <div>
            <div class="flex items-center gap-3 mb-2">
              <h1 class="text-2xl font-bold tracking-tight">{{ carrera.programa }}</h1>
              <code class="relative rounded bg-muted px-[0.3rem] py-[0.2rem] font-mono text-sm font-medium">
                {{ carrera.id }}
              </code>
            </div>
            <p class="text-muted-foreground">
              Información detallada de la carrera académica
            </p>
          </div>
          <div class="flex items-center gap-2">
            <Button variant="outline" as-child>
              <Link :href="route('v2.carreras.edit', carrera.id)">
                <Icon icon="mdi:pencil" class="h-4 w-4 mr-2" />
                Editar
              </Link>
            </Button>
            <AlertDialog>
              <AlertDialogTrigger as-child>
                <Button variant="outline">
                  <Icon icon="mdi:trash-can" class="h-4 w-4 mr-2 text-destructive" />
                  Eliminar
                </Button>
              </AlertDialogTrigger>
              <AlertDialogContent>
                <AlertDialogHeader>
                  <AlertDialogTitle>¿Eliminar carrera?</AlertDialogTitle>
                  <AlertDialogDescription>
                    Esta acción no se puede deshacer. Se eliminará permanentemente la carrera "{{ carrera.programa }}" ({{ carrera.id }}).
                  </AlertDialogDescription>
                </AlertDialogHeader>
                <AlertDialogFooter>
                  <AlertDialogCancel>Cancelar</AlertDialogCancel>
                  <AlertDialogAction 
                    @click="deleteCarrera"
                    class="bg-destructive text-destructive-foreground hover:bg-destructive/90"
                  >
                    Eliminar
                  </AlertDialogAction>
                </AlertDialogFooter>
              </AlertDialogContent>
            </AlertDialog>
          </div>
        </div>
      </div>

      <!-- Career Info -->
      <div class="grid gap-6 md:grid-cols-2">
        <!-- Basic Information -->
        <Card>
          <CardHeader>
            <CardTitle class="flex items-center gap-2">
              Información Básica
            </CardTitle>
          </CardHeader>
          <CardContent class="space-y-4">
            <div>
              <Label class="text-sm font-medium text-muted-foreground">Código</Label>
              <p class="text-sm">
                <code class="relative rounded bg-muted px-[0.3rem] py-[0.2rem] font-mono text-sm font-medium">
                  {{ carrera.id }}
                </code>
              </p>
            </div>
            <Separator />
            <div>
              <Label class="text-sm font-medium text-muted-foreground">Programa</Label>
              <p class="text-sm font-medium">{{ carrera.programa }}</p>
            </div>
            <Separator />
            <div>
              <Label class="text-sm font-medium text-muted-foreground">Dirección</Label>
              <p class="text-sm">{{ carrera.direccion || 'No especificada' }}</p>
            </div>
          </CardContent>
        </Card>

        <!-- Faculty Information -->
        <Card>
          <CardHeader>
            <CardTitle class="flex items-center gap-2">
              <Icon icon="mdi:school" class="h-5 w-5" />
              Facultad
            </CardTitle>
          </CardHeader>
          <CardContent class="space-y-4">
            <div class="p-4 bg-blue-50 dark:bg-blue-950 rounded-lg">
              <div class="flex items-start gap-3">
                <Icon icon="mdi-school" class="h-6 w-6 text-blue-500 mt-1" />
                <div class="flex-1">
                  <Link 
                    :href="route('v2.facultades.show', carrera.facultad.id)"
                    class="text-lg font-medium text-blue-700 hover:text-blue-800 dark:text-blue-300 dark:hover:text-blue-200"
                  >
                    {{ carrera.facultad.nombre }}
                  </Link>
                  <p v-if="carrera.facultad.direccion" class="text-sm text-blue-600 dark:text-blue-400 mt-1">
                    📍 {{ carrera.facultad.direccion }}
                  </p>
                </div>
                <Button variant="outline" size="sm" as-child>
                  <Link :href="route('v2.facultades.show', carrera.facultad.id)">
                    <Icon icon="mdi:arrow-right" class="h-4 w-4" />
                  </Link>
                </Button>
              </div>
            </div>
          </CardContent>
        </Card>
      </div>

      <!-- Quick Actions -->
      <Card>
        <CardHeader>
          <CardTitle class="flex items-center gap-2">
            <Icon icon="mdi:lightning-bolt" class="h-5 w-5" />
            Acciones Rápidas
          </CardTitle>
          <CardDescription>
            Operaciones comunes para esta carrera
          </CardDescription>
        </CardHeader>
        <CardContent>
          <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
            <!-- View Faculty -->
            <Card class="p-4 hover:bg-accent/50 transition-colors">
              <Link :href="route('v2.facultades.show', carrera.facultad.id)" class="block">
                <div class="flex items-center gap-3">
                  <div class="p-2 bg-blue-100 dark:bg-blue-900 rounded-lg">
                    <Icon icon="mdi:school" class="h-5 w-5 text-blue-600 dark:text-blue-400" />
                  </div>
                  <div>
                    <h3 class="font-medium">Ver Facultad</h3>
                    <p class="text-sm text-muted-foreground">{{ carrera.facultad.nombre }}</p>
                  </div>
                  <Icon icon="mdi:arrow-right" class="h-4 w-4 ml-auto text-muted-foreground" />
                </div>
              </Link>
            </Card>

            <!-- View All Careers from Faculty -->
            <Card class="p-4 hover:bg-accent/50 transition-colors">
              <Link :href="route('v2.carreras.index', { facultad_id: carrera.facultad.id })" class="block">
                <div class="flex items-center gap-3">
                  <div class="p-2 bg-green-100 dark:bg-green-900 rounded-lg">
                    <Icon icon="mdi:book-multiple" class="h-5 w-5 text-green-600 dark:text-green-400" />
                  </div>
                  <div>
                    <h3 class="font-medium">Carreras de la Facultad</h3>
                    <p class="text-sm text-muted-foreground">Ver todas las carreras</p>
                  </div>
                  <Icon icon="mdi:arrow-right" class="h-4 w-4 ml-auto text-muted-foreground" />
                </div>
              </Link>
            </Card>

            <!-- Edit Career -->
            <Card class="p-4 hover:bg-accent/50 transition-colors">
              <Link :href="route('v2.carreras.edit', carrera.id)" class="block">
                <div class="flex items-center gap-3">
                  <div class="p-2 bg-orange-100 dark:bg-orange-900 rounded-lg">
                    <Icon icon="mdi:pencil" class="h-5 w-5 text-orange-600 dark:text-orange-400" />
                  </div>
                  <div>
                    <h3 class="font-medium">Editar Carrera</h3>
                    <p class="text-sm text-muted-foreground">Modificar información</p>
                  </div>
                  <Icon icon="mdi-arrow-right" class="h-4 w-4 ml-auto text-muted-foreground" />
                </div>
              </Link>
            </Card>
          </div>
        </CardContent>
      </Card>

      <!-- Info Card -->
      <Card class="border-blue-200 bg-blue-50 dark:border-blue-800 dark:bg-blue-950">
        <CardContent class="pt-6">
          <div class="flex items-start gap-3">
            <Icon icon="mdi:information" class="h-5 w-5 text-blue-600 dark:text-blue-400 mt-0.5" />
            <div>
              <h3 class="font-medium text-blue-900 dark:text-blue-100">
                Información del sistema
              </h3>
              <ul class="mt-2 text-sm text-blue-800 dark:text-blue-200 space-y-1">
                <li>• Esta carrera pertenece a la facultad "{{ carrera.facultad.nombre }}"</li>
                <li>• El código "{{ carrera.id }}" es único en el sistema</li>
                <li>• Puedes editar la información o cambiar de facultad si es necesario</li>
              </ul>
            </div>
          </div>
        </CardContent>
      </Card>

      <!-- Actions -->
      <div class="flex items-center justify-between pt-6 border-t border-border">
        <Button variant="outline" as-child>
          <Link :href="route('v2.carreras.index')">
            <Icon icon="mdi-arrow-left" class="h-4 w-4 mr-2" />
            Volver a Carreras
          </Link>
        </Button>
        
        <div class="flex items-center gap-2">
          <Button variant="outline" as-child>
            <Link :href="route('v2.carreras.edit', carrera.id)">
              <Icon icon="mdi-pencil" class="h-4 w-4 mr-2" />
              Editar Carrera
            </Link>
          </Button>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup lang="ts">
import { router, Link } from '@inertiajs/vue3'
import { Icon } from '@iconify/vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import { Button } from '@/components/ui/button'
import { Label } from '@/components/ui/label'
import { Separator } from '@/components/ui/separator'
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card'
import { 
  AlertDialog,
  AlertDialogAction,
  AlertDialogCancel,
  AlertDialogContent,
  AlertDialogDescription,
  AlertDialogFooter,
  AlertDialogHeader,
  AlertDialogTitle,
  AlertDialogTrigger,
} from '@/components/ui/alert-dialog'
import { toast } from 'vue-sonner'

interface Facultad {
  id: number
  nombre: string
  direccion: string | null
}

interface Carrera {
  id: string
  programa: string
  direccion: string | null
  facultad: Facultad
}

interface Props {
  carrera: Carrera
}

const props = defineProps<Props>()

// Methods
const deleteCarrera = () => {
  router.delete(route('v2.carreras.destroy', props.carrera.id), {
    onSuccess: () => {
      toast.success('Carrera eliminada exitosamente')
    },
    onError: (errors) => {
      const errorMessage = errors.carrera || 'Error al eliminar la carrera'
      toast.error(errorMessage)
    }
  })
}
</script>