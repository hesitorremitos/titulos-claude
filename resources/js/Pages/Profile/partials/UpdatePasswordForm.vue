<script setup lang="ts">
import { useForm } from '@inertiajs/vue3'
import { Button } from '@/components/ui/button'
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { toast } from 'vue-sonner'

const form = useForm({
  current_password: '',
  password: '',
  password_confirmation: '',
})

const submit = () => {
  form.patch(route('v2.profile.password'), {
    preserveScroll: true,
    onSuccess: () => {
      form.reset()
      toast.success("Tu contraseña ha sido cambiada correctamente.")
    },
    onError: () => {
      toast.error("Hubo un problema al cambiar tu contraseña. Verifica los campos e intenta nuevamente.")
    }
  })
}
</script>

<template>
  <Card>
    <CardHeader>
      <CardTitle class="flex items-center">
        <svg class="w-5 h-5 mr-2 text-orange-600" fill="currentColor" viewBox="0 0 24 24">
          <path d="M12,17A2,2 0 0,0 14,15C14,13.89 13.1,13 12,13A2,2 0 0,0 10,15A2,2 0 0,0 12,17M18,8A2,2 0 0,1 20,10V20A2,2 0 0,1 18,22H6A2,2 0 0,1 4,20V10C4,8.89 4.9,8 6,8H7V6A5,5 0 0,1 12,1A5,5 0 0,1 17,6V8H18M12,3A3,3 0 0,0 9,6V8H15V6A3,3 0 0,0 12,3Z"/>
        </svg>
        Cambiar Contraseña
      </CardTitle>
      <CardDescription>
        Asegúrate de usar una contraseña segura para proteger tu cuenta.
      </CardDescription>
    </CardHeader>
    
    <CardContent>
      <form @submit.prevent="submit" class="space-y-4">
        <!-- Contraseña Actual -->
        <div class="space-y-2">
          <Label for="current_password" class="flex items-center">
            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 24 24">
              <path d="M12,17A2,2 0 0,0 14,15C14,13.89 13.1,13 12,13A2,2 0 0,0 10,15A2,2 0 0,0 12,17M18,8A2,2 0 0,1 20,10V20A2,2 0 0,1 18,22H6A2,2 0 0,1 4,20V10C4,8.89 4.9,8 6,8H7V6A5,5 0 0,1 12,1A5,5 0 0,1 17,6V8H18M12,3A3,3 0 0,0 9,6V8H15V6A3,3 0 0,0 12,3Z"/>
            </svg>
            Contraseña Actual
          </Label>
          <Input
            id="current_password"
            v-model="form.current_password"
            type="password"
            required
            autocomplete="current-password"
            :class="{ 'border-destructive': form.errors.current_password }"
          />
          <p v-if="form.errors.current_password" class="text-sm text-destructive">
            {{ form.errors.current_password }}
          </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <!-- Nueva Contraseña -->
          <div class="space-y-2">
            <Label for="password" class="flex items-center">
              <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 24 24">
                <path d="M22,18V22H18V19H15V16H12L9.74,13.74C9.19,13.91 8.61,14 8,14A6,6 0 0,1 2,8A6,6 0 0,1 8,2A6,6 0 0,1 14,8C14,8.61 13.91,9.19 13.74,9.74L22,18M7,5A2,2 0 0,0 5,7A2,2 0 0,0 7,9A2,2 0 0,0 9,7A2,2 0 0,0 7,5Z"/>
              </svg>
              Nueva Contraseña
            </Label>
            <Input
              id="password"
              v-model="form.password"
              type="password"
              required
              autocomplete="new-password"
              :class="{ 'border-destructive': form.errors.password }"
            />
            <p v-if="form.errors.password" class="text-sm text-destructive">
              {{ form.errors.password }}
            </p>
          </div>

          <!-- Confirmar Contraseña -->
          <div class="space-y-2">
            <Label for="password_confirmation" class="flex items-center">
              <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 24 24">
                <path d="M23,12L20.56,9.22L20.9,5.54L17.29,4.72L15.4,1.54L12,3L8.6,1.54L6.71,4.72L3.1,5.53L3.44,9.21L1,12L3.44,14.78L3.1,18.47L6.71,19.29L8.6,22.47L12,21L15.4,22.46L17.29,19.28L20.9,18.46L20.56,14.78L23,12M10,17L6,13L7.41,11.59L10,14.17L16.59,7.58L18,9L10,17Z"/>
              </svg>
              Confirmar Contraseña
            </Label>
            <Input
              id="password_confirmation"
              v-model="form.password_confirmation"
              type="password"
              required
              autocomplete="new-password"
              :class="{ 'border-destructive': form.errors.password_confirmation }"
            />
            <p v-if="form.errors.password_confirmation" class="text-sm text-destructive">
              {{ form.errors.password_confirmation }}
            </p>
          </div>
        </div>

        <div class="flex justify-end pt-4">
          <Button type="submit" variant="secondary" :disabled="form.processing">
            <svg v-if="form.processing" class="animate-spin -ml-1 mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <svg v-else class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
              <path d="M22,18V22H18V19H15V16H12L9.74,13.74C9.19,13.91 8.61,14 8,14A6,6 0 0,1 2,8A6,6 0 0,1 8,2A6,6 0 0,1 14,8C14,8.61 13.91,9.19 13.74,9.74L22,18M7,5A2,2 0 0,0 5,7A2,2 0 0,0 7,9A2,2 0 0,0 9,7A2,2 0 0,0 7,5Z"/>
            </svg>
            {{ form.processing ? 'Cambiando...' : 'Cambiar Contraseña' }}
          </Button>
        </div>
      </form>
    </CardContent>
  </Card>
</template>