<script setup lang="ts">
import { ref } from 'vue'
import { useForm } from '@inertiajs/vue3'
import { Button } from '@/components/ui/button'
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { AlertDialog, AlertDialogAction, AlertDialogCancel, AlertDialogContent, AlertDialogDescription, AlertDialogFooter, AlertDialogHeader, AlertDialogTitle, AlertDialogTrigger } from '@/components/ui/alert-dialog'
import { toast } from 'vue-sonner'

const confirmingUserDeletion = ref(false)

const form = useForm({
  password: '',
})

const confirmUserDeletion = () => {
  confirmingUserDeletion.value = true
  form.reset()
}

const deleteUser = () => {
  form.delete(route('v2.profile.destroy'), {
    preserveScroll: true,
    onSuccess: () => {
      confirmingUserDeletion.value = false
      toast.success("Tu cuenta ha sido eliminada permanentemente.")
    },
    onError: () => {
      toast.error("Hubo un problema al eliminar tu cuenta. Verifica tu contraseña e intenta nuevamente.")
    },
    onFinish: () => form.reset(),
  })
}
</script>

<template>
  <Card class="border-destructive/50">
    <CardHeader>
      <CardTitle class="flex items-center text-destructive">
        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
          <path d="M12,2C17.53,2 22,6.47 22,12C22,17.53 17.53,22 12,22C6.47,22 2,17.53 2,12C2,6.47 6.47,2 12,2M15.59,7L12,10.59L8.41,7L7,8.41L10.59,12L7,15.59L8.41,17L12,13.41L15.59,17L17,15.59L13.41,12L17,8.41L15.59,7Z"/>
        </svg>
        Eliminar Cuenta
      </CardTitle>
      <CardDescription>
        Una vez eliminada tu cuenta, todos sus recursos y datos serán eliminados permanentemente.
        Antes de eliminar tu cuenta, descarga cualquier dato o información que desees conservar.
      </CardDescription>
    </CardHeader>
    
    <CardContent>
      <div class="bg-destructive/5 border border-destructive/10 rounded-md p-4">
        <div class="flex items-start">
          <svg class="w-5 h-5 text-destructive mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
            <path d="M13,13H11V7H13M13,17H11V15H13M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2Z"/>
          </svg>
          <div class="flex-1">
            <h4 class="text-sm font-medium text-destructive">
              Advertencia sobre la eliminación de cuenta
            </h4>
            <p class="text-sm text-destructive/80 mt-1">
              Esta acción no se puede deshacer. Se eliminarán permanentemente todos los títulos y datos asociados a tu cuenta.
            </p>
          </div>
        </div>
      </div>

      <div class="mt-6">
        <AlertDialog :open="confirmingUserDeletion" @update:open="confirmingUserDeletion = $event">
          <AlertDialogTrigger as-child>
            <Button variant="destructive" @click="confirmUserDeletion">
              <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12,2C13.1,2 14,2.9 14,4C14,5.1 13.1,6 12,6C10.9,6 10,5.1 10,4C10,2.9 10.9,2 12,2ZM13,7H11C8.8,7 7,8.8 7,11V16H9V22H11V16H13V22H15V16H17V11C17,8.8 15.2,7 13,7Z"/>
              </svg>
              Eliminar Cuenta
            </Button>
          </AlertDialogTrigger>

          <AlertDialogContent>
            <AlertDialogHeader>
              <AlertDialogTitle>¿Estás seguro de que quieres eliminar tu cuenta?</AlertDialogTitle>
              <AlertDialogDescription>
                Esta acción no se puede deshacer. Se eliminarán permanentemente tu cuenta y todos los datos asociados a ella.
              </AlertDialogDescription>
            </AlertDialogHeader>
            
            <div class="py-4">
              <div class="space-y-2">
                <Label for="delete_password">
                  Confirma tu contraseña para continuar:
                </Label>
                <Input
                  id="delete_password"
                  v-model="form.password"
                  type="password"
                  placeholder="Ingresa tu contraseña"
                  autocomplete="current-password"
                  required
                  :class="{ 'border-destructive': form.errors.password }"
                  @keyup.enter="deleteUser"
                />
                <p v-if="form.errors.password" class="text-sm text-destructive">
                  {{ form.errors.password }}
                </p>
              </div>
            </div>

            <AlertDialogFooter>
              <AlertDialogCancel @click="confirmingUserDeletion = false">
                Cancelar
              </AlertDialogCancel>
              <AlertDialogAction
                @click="deleteUser"
                :disabled="form.processing"
                class="bg-destructive text-destructive-foreground hover:bg-destructive/90"
              >
                <svg v-if="form.processing" class="animate-spin -ml-1 mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                {{ form.processing ? 'Eliminando...' : 'Eliminar Cuenta' }}
              </AlertDialogAction>
            </AlertDialogFooter>
          </AlertDialogContent>
        </AlertDialog>
      </div>
    </CardContent>
  </Card>
</template>