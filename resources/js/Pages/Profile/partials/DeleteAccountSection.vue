<script setup lang="ts">
import { ref } from 'vue'
import { useForm } from '@inertiajs/vue3'
import { Button } from '@/components/ui/button'
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { AlertDialog, AlertDialogAction, AlertDialogCancel, AlertDialogContent, AlertDialogDescription, AlertDialogFooter, AlertDialogHeader, AlertDialogTitle, AlertDialogTrigger } from '@/components/ui/alert-dialog'
import { Icon } from '@iconify/vue'
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
        <Icon icon="material-symbols:cancel" class="w-5 h-5 mr-2" />
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
          <Icon icon="material-symbols:info" class="w-5 h-5 text-destructive mr-3 mt-0.5 flex-shrink-0" />
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
              <Icon icon="material-symbols:person-remove" class="w-4 h-4 mr-2" />
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
                <Icon v-if="form.processing" icon="material-symbols:progress-activity" class="animate-spin w-4 h-4 mr-2" />
                {{ form.processing ? 'Eliminando...' : 'Eliminar Cuenta' }}
              </AlertDialogAction>
            </AlertDialogFooter>
          </AlertDialogContent>
        </AlertDialog>
      </div>
    </CardContent>
  </Card>
</template>