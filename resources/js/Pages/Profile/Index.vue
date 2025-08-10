<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import { Separator } from '@/components/ui/separator'
import { Breadcrumb, BreadcrumbItem, BreadcrumbLink, BreadcrumbList, BreadcrumbPage, BreadcrumbSeparator } from '@/components/ui/breadcrumb'
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

  <AppLayout>
    <div class="flex-1 space-y-4 p-4 md:p-8 pt-6">
      <div class="space-y-0.5">
        <div class="flex items-center space-x-1 text-sm text-muted-foreground mb-4">
          <Breadcrumb>
            <BreadcrumbList>
              <BreadcrumbItem>
                <BreadcrumbLink :href="route('v2.dashboard')">Dashboard</BreadcrumbLink>
              </BreadcrumbItem>
              <BreadcrumbSeparator />
              <BreadcrumbItem>
                <BreadcrumbPage>Mi Perfil</BreadcrumbPage>
              </BreadcrumbItem>
            </BreadcrumbList>
          </Breadcrumb>
        </div>

        <h2 class="text-2xl font-bold tracking-tight flex items-center">
          <svg class="w-6 h-6 mr-3 text-primary" fill="currentColor" viewBox="0 0 24 24">
            <path d="M12 2C13.1 2 14 2.9 14 4C14 5.1 13.1 6 12 6C10.9 6 10 5.1 10 4C10 2.9 10.9 2 12 2ZM21 9V7L15 1H5C3.89 1 3 1.89 3 3V21C3 22.1 3.89 23 5 23H11V21H5V3H14V8H21ZM19 19V17.5L13.5 12L12 13.5L19 19Z"/>
          </svg>
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