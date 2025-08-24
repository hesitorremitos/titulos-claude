<script setup lang="ts">
import { Separator } from '@/components/ui/separator';
import AppLayout from '@/Layouts/AppLayout.vue';
import { Icon } from '@iconify/vue';
import { Head } from '@inertiajs/vue3';
import DeleteAccountSection from './partials/DeleteAccountSection.vue';
import UpdatePasswordForm from './partials/UpdatePasswordForm.vue';
import UpdateProfileForm from './partials/UpdateProfileForm.vue';

interface User {
    id: number;
    name: string;
    email: string;
    ci: string;
}

interface Props {
    user: User;
}

defineProps<Props>();
</script>

<template>
    <Head title="Mi Perfil" />

    <AppLayout>
        <div class="flex-1 space-y-4 p-4 pt-6 md:p-8">
            <div class="space-y-0.5">
                <h2 class="flex items-center text-2xl font-bold tracking-tight">
                    <Icon icon="material-symbols:person" class="mr-3 h-6 w-6 text-primary" />
                    Mi Perfil
                </h2>
                <p class="text-muted-foreground">Administra tu información personal, contraseña y configuración de cuenta.</p>
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
