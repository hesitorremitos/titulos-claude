<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import { Separator } from '@/components/ui/separator'
import { Icon } from '@iconify/vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import UpdateProfileForm from './partials/UpdateProfileForm.vue'
import UpdatePasswordForm from './partials/UpdatePasswordForm.vue'
import DeleteAccountSection from './partials/DeleteAccountSection.vue'

interface User {
  id: number
  name: string
  email: string
  ci: string
}

interface Props {
  user: User
}

defineProps<Props>()
</script>

<template>
  <Head title="Mi Perfil" />

  <AppLayout :breadcrumbs="[{ label: 'Mi Perfil' }]">
    <div class="flex-1 space-y-4 p-4 md:p-8 pt-6">
      <div class="space-y-0.5">
        <h2 class="text-2xl font-bold tracking-tight flex items-center">
          <Icon icon="material-symbols:person" class="w-6 h-6 mr-3 text-primary" />
          Mi Perfil
        </h2>
        <p class="text-muted-foreground">
          Administra tu información personal, contraseña y configuración de cuenta.
        </p>
      </div>
      
      <Separator class="my-6" />
      
      <div class="space-y-6">
        <!-- Información Personal -->
        <UpdateProfileForm :user="user" />
        
        <Separator />
        
        <!-- Cambiar Contraseña -->
        <UpdatePasswordForm />
        
        <Separator />
        
        <!-- Eliminar Cuenta -->
        <DeleteAccountSection />
      </div>
    </div>
  </AppLayout>
</template>