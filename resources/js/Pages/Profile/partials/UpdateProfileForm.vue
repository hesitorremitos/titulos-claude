<script setup lang="ts">
import { useForm } from '@inertiajs/vue3'
import { Button } from '@/components/ui/button'
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
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
        <svg class="w-5 h-5 mr-2 text-primary" fill="currentColor" viewBox="0 0 24 24">
          <path d="M12 2C13.1 2 14 2.9 14 4C14 5.1 13.1 6 12 6C10.9 6 10 5.1 10 4C10 2.9 10.9 2 12 2ZM21 9V7L15 1H5C3.89 1 3 1.89 3 3V21C3 22.1 3.89 23 5 23H11V21H5V3H14V8H21Z"/>
        </svg>
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
              <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12,4A4,4 0 0,1 16,8A4,4 0 0,1 12,12A4,4 0 0,1 8,8A4,4 0 0,1 12,4M12,14C16.42,14 20,15.79 20,18V20H4V18C4,15.79 7.58,14 12,14Z"/>
              </svg>
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
              <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 24 24">
                <path d="M20,3H4A2,2 0 0,0 2,5V19A2,2 0 0,0 4,21H20A2,2 0 0,0 22,19V5A2,2 0 0,0 20,3M20,19H4V5H20V19M18,17V15.5L12.5,10L11,11.5L18,17M7,13H9V15H7V13M15,7H17V9H15V7M7,7H13V11H7V7"/>
              </svg>
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
            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 24 24">
              <path d="M20,8L12,13L4,8V6L12,11L20,6M20,4H4C2.89,4 2,4.89 2,6V18A2,2 0 0,0 4,20H20A2,2 0 0,0 22,18V6C22,4.89 21.1,4 20,4Z"/>
            </svg>
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
            <svg v-if="form.processing" class="animate-spin -ml-1 mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <svg v-else class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
              <path d="M15,9H5V5H15M12,19A3,3 0 0,1 9,16A3,3 0 0,1 12,13A3,3 0 0,1 15,16A3,3 0 0,1 12,19M17,3H5C3.89,3 3,3.9 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V7L17,3Z"/>
            </svg>
            {{ form.processing ? 'Guardando...' : 'Guardar Cambios' }}
          </Button>
        </div>
      </form>
    </CardContent>
  </Card>
</template>