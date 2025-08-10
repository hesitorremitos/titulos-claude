<template>
  <AppLayout 
    title="Nueva Facultad"
    :breadcrumbs="[
      { label: 'Facultades', href: route('v2.facultades.index') },
      { label: 'Nueva Facultad' }
    ]"
  >
    <div class="space-y-6">
      <!-- Header -->
      <div class="border-b border-border pb-4">
        <h1 class="text-2xl font-bold tracking-tight">Nueva Facultad</h1>
      </div>

      <!-- Form -->
      <div class="max-w-2xl">
        <Card>
          <CardContent class="pt-6">
            <form @submit.prevent="submit" class="space-y-6">
              <!-- Nombre -->
              <div class="space-y-2">
                <Label for="nombre">
                  Nombre *
                </Label>
                <Input
                  id="nombre"
                  v-model="form.nombre"
                  type="text"
                  placeholder="Facultad de Ingeniería"
                  :class="{ 'border-destructive': props.errors.nombre }"
                  required
                />
                <p v-if="props.errors.nombre" class="text-sm text-destructive">
                  {{ props.errors.nombre }}
                </p>
              </div>

              <!-- Dirección -->
              <div class="space-y-2">
                <Label for="direccion">
                  Dirección
                </Label>
                <Input
                  id="direccion"
                  v-model="form.direccion"
                  type="text"
                  placeholder="Av. del Estudiante #123"
                  :class="{ 'border-destructive': props.errors.direccion }"
                />
                <p v-if="props.errors.direccion" class="text-sm text-destructive">
                  {{ props.errors.direccion }}
                </p>
              </div>

              <!-- Actions -->
              <div class="flex items-center gap-3 pt-4">
                <Button type="submit" :disabled="processing">
                  {{ processing ? 'Guardando...' : 'Guardar' }}
                </Button>
                <Button variant="outline" type="button" as-child>
                  <Link :href="route('v2.facultades.index')">
                    Cancelar
                  </Link>
                </Button>
              </div>
            </form>
          </CardContent>
        </Card>
      </div>
    </div>
  </AppLayout>
</template>

<script setup lang="ts">
import { useForm, Link } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card'
import { toast } from 'vue-sonner'

interface Props {
  errors: Record<string, string>
}

const props = defineProps<Props>()

// Form usando useForm
const form = useForm({
  nombre: '',
  direccion: '',
})

const { processing } = form

// Methods
const submit = () => {
  form.post(route('v2.facultades.store'), {
    onSuccess: () => {
      toast.success('Facultad creada exitosamente')
    },
    onError: () => {
      toast.error('Por favor corrige los errores en el formulario')
    }
  })
}
</script>