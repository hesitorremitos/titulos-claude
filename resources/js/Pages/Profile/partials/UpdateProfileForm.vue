<script setup lang="ts">
import { useForm } from '@inertiajs/vue3'
import { Button } from '@/components/ui/button'
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { Icon } from '@iconify/vue'
import { toast } from 'vue-sonner'

interface User {
  id: number
  name: string
  email: string
  ci: string
}

interface Props {
  user: User
}

const props = defineProps<Props>()

const form = useForm({
  name: props.user.name,
  email: props.user.email,
  ci: props.user.ci,
})

const submit = () => {
  form.patch(route('v2.profile.update'), {
    preserveScroll: true,
    onSuccess: () => {
      toast.success("Tu información personal ha sido actualizada correctamente.")
    },
    onError: () => {
      toast.error("Hubo un problema al actualizar tu información. Revisa los campos e intenta nuevamente.")
    }
  })
}
</script>

<template>
  <Card>
    <CardHeader>
      <CardTitle class="flex items-center">
        <Icon icon="material-symbols:person-edit" class="w-5 h-5 mr-2 text-primary" />
        Información Personal
      </CardTitle>
      <CardDescription>
        Actualiza tu información personal básica.
      </CardDescription>
    </CardHeader>
    
    <CardContent>
      <form @submit.prevent="submit" class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <!-- Nombre -->
          <div class="space-y-2">
            <Label for="name" class="flex items-center">
              <Icon icon="material-symbols:person" class="w-4 h-4 mr-1" />
              Nombre Completo
            </Label>
            <Input
              id="name"
              v-model="form.name"
              type="text"
              required
              :class="{ 'border-destructive': form.errors.name }"
            />
            <p v-if="form.errors.name" class="text-sm text-destructive">
              {{ form.errors.name }}
            </p>
          </div>

          <!-- CI -->
          <div class="space-y-2">
            <Label for="ci" class="flex items-center">
              <Icon icon="material-symbols:badge" class="w-4 h-4 mr-1" />
              Carnet de Identidad
            </Label>
            <Input
              id="ci"
              v-model="form.ci"
              type="text"
              required
              :class="{ 'border-destructive': form.errors.ci }"
            />
            <p v-if="form.errors.ci" class="text-sm text-destructive">
              {{ form.errors.ci }}
            </p>
          </div>
        </div>

        <!-- Email -->
        <div class="space-y-2">
          <Label for="email" class="flex items-center">
            <Icon icon="material-symbols:email" class="w-4 h-4 mr-1" />
            Correo Electrónico
          </Label>
          <Input
            id="email"
            v-model="form.email"
            type="email"
            required
            :class="{ 'border-destructive': form.errors.email }"
          />
          <p v-if="form.errors.email" class="text-sm text-destructive">
            {{ form.errors.email }}
          </p>
        </div>

        <div class="flex justify-end pt-4">
          <Button type="submit" :disabled="form.processing">
            <Icon v-if="form.processing" icon="material-symbols:progress-activity" class="animate-spin w-4 h-4 mr-2" />
            <Icon v-else icon="material-symbols:save" class="w-4 h-4 mr-2" />
            {{ form.processing ? 'Guardando...' : 'Guardar Cambios' }}
          </Button>
        </div>
      </form>
    </CardContent>
  </Card>
</template>