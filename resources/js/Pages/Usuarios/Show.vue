<template>
    <AppLayout title="Detalle Usuario" :breadcrumbs="[{ label: 'Usuarios', href: route('v2.usuarios.index') }, { label: usuario.name }]">
        <div class="space-y-6">
            <!-- Header -->
            <div class="border-b border-border pb-4">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h1 class="text-2xl font-bold tracking-tight">{{ usuario.name }}</h1>
                        <p class="text-muted-foreground">Información detallada del usuario</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <Button variant="outline" as-child>
                            <Link :href="route('v2.usuarios.edit', usuario.id)">
                                <Icon icon="mdi:pencil" class="mr-2 h-4 w-4" />
                                Editar
                            </Link>
                        </Button>
                        <Button variant="outline" as-child>
                            <Link :href="route('v2.usuarios.index')">
                                <Icon icon="mdi:arrow-left" class="mr-2 h-4 w-4" />
                                Volver
                            </Link>
                        </Button>
                    </div>
                </div>
            </div>

            <!-- User Information -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Información Personal -->
                <Card>
                    <CardHeader>
                        <div class="flex items-center">
                            <Icon icon="mdi:account-details" class="mr-2 h-5 w-5 text-primary" />
                            <CardTitle>Información Personal</CardTitle>
                        </div>
                    </CardHeader>
                    <CardContent class="space-y-4">
                        <div class="grid grid-cols-1 gap-4">
                            <div class="flex items-center space-x-3">
                                <div class="flex h-12 w-12 items-center justify-center rounded-full bg-primary/10">
                                    <Icon icon="mdi:account" class="h-6 w-6 text-primary" />
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-muted-foreground">Nombre Completo</p>
                                    <p class="text-lg font-semibold">{{ usuario.name }}</p>
                                </div>
                            </div>

                            <div class="flex items-center space-x-3">
                                <div class="flex h-12 w-12 items-center justify-center rounded-full bg-primary/10">
                                    <Icon icon="mdi:card-account-details" class="h-6 w-6 text-primary" />
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-muted-foreground">CI (Carnet de Identidad)</p>
                                    <p class="text-lg font-semibold">{{ usuario.ci }}</p>
                                </div>
                            </div>

                            <div class="flex items-center space-x-3">
                                <div class="flex h-12 w-12 items-center justify-center rounded-full bg-primary/10">
                                    <Icon icon="mdi:email" class="h-6 w-6 text-primary" />
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-muted-foreground">Correo Electrónico</p>
                                    <p class="text-lg font-semibold">{{ usuario.email }}</p>
                                </div>
                            </div>
                        </div>
                    </CardContent>
                </Card>

                <!-- Roles y Permisos -->
                <Card>
                    <CardHeader>
                        <div class="flex items-center">
                            <Icon icon="mdi:shield-account" class="mr-2 h-5 w-5 text-primary" />
                            <CardTitle>Roles y Permisos</CardTitle>
                        </div>
                    </CardHeader>
                    <CardContent>
                        <div v-if="usuario.roles && usuario.roles.length > 0" class="space-y-3">
                            <div v-for="role in usuario.roles" :key="role.id" class="flex items-center space-x-3 p-3 rounded-lg border">
                                <Icon :icon="getRoleIcon(role.name)" class="h-6 w-6" :class="getRoleIconColor(role.name)" />
                                <div class="flex-1">
                                    <p class="font-medium">{{ role.name }}</p>
                                    <p class="text-sm text-muted-foreground">{{ getRoleDescription(role.name) }}</p>
                                </div>
                                <Badge :class="getRoleColor(role.name)">
                                    {{ role.name }}
                                </Badge>
                            </div>
                        </div>
                        <div v-else class="text-center py-6">
                            <Icon icon="mdi:shield-off" class="mx-auto h-12 w-12 text-muted-foreground mb-3" />
                            <h3 class="text-lg font-medium">Sin roles asignados</h3>
                            <p class="text-muted-foreground">Este usuario no tiene roles asignados actualmente.</p>
                            <Button class="mt-4" variant="outline" as-child>
                                <Link :href="route('v2.usuarios.edit', usuario.id)">
                                    <Icon icon="mdi:shield-plus" class="mr-2 h-4 w-4" />
                                    Asignar Roles
                                </Link>
                            </Button>
                        </div>
                    </CardContent>
                </Card>
            </div>

            <!-- Información del Sistema -->
            <Card>
                <CardHeader>
                    <div class="flex items-center">
                        <Icon icon="mdi:information" class="mr-2 h-5 w-5 text-primary" />
                        <CardTitle>Información del Sistema</CardTitle>
                    </div>
                </CardHeader>
                <CardContent>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="space-y-2">
                            <p class="text-sm font-medium text-muted-foreground">ID del Usuario</p>
                            <p class="text-lg font-semibold">{{ usuario.id }}</p>
                        </div>
                        
                        <div class="space-y-2">
                            <p class="text-sm font-medium text-muted-foreground">Fecha de Registro</p>
                            <p class="text-lg font-semibold">{{ formatDate(usuario.created_at) }}</p>
                        </div>
                        
                        <div class="space-y-2">
                            <p class="text-sm font-medium text-muted-foreground">Estado</p>
                            <div class="flex items-center space-x-2">
                                <div class="h-2 w-2 rounded-full bg-green-500"></div>
                                <span class="text-lg font-semibold text-green-600">Activo</span>
                            </div>
                        </div>
                    </div>
                </CardContent>
            </Card>

            <!-- Actions Section -->
            <Card>
                <CardHeader>
                    <div class="flex items-center">
                        <Icon icon="mdi:cog" class="mr-2 h-5 w-5 text-primary" />
                        <CardTitle>Acciones</CardTitle>
                    </div>
                </CardHeader>
                <CardContent>
                    <div class="flex flex-wrap gap-3">
                        <Button as-child>
                            <Link :href="route('v2.usuarios.edit', usuario.id)">
                                <Icon icon="mdi:pencil" class="mr-2 h-4 w-4" />
                                Editar Usuario
                            </Link>
                        </Button>
                        
                        <Button variant="outline">
                            <Icon icon="mdi:lock-reset" class="mr-2 h-4 w-4" />
                            Restablecer Contraseña
                        </Button>
                        
                        <Button variant="destructive" v-if="usuario.id !== $page.props.auth?.user?.id" @click="confirmDelete">
                            <Icon icon="mdi:delete" class="mr-2 h-4 w-4" />
                            Eliminar Usuario
                        </Button>
                    </div>
                </CardContent>
            </Card>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from '@/Layouts/AppLayout.vue';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Icon } from '@iconify/vue';
import { Link, router } from '@inertiajs/vue3';
import { toast } from 'vue-sonner';

interface Role {
    id: number;
    name: string;
}

interface Usuario {
    id: number;
    ci: string;
    name: string;
    email: string;
    roles: Role[];
    created_at: string;
}

interface Props {
    usuario: Usuario;
}

const props = defineProps<Props>();

// Methods
const getRoleIcon = (roleName: string) => {
    const icons = {
        'Administrador': 'mdi:shield-crown',
        'Jefe': 'mdi:shield-star',
        'Personal': 'mdi:shield-account',
    };
    
    return icons[roleName as keyof typeof icons] || 'mdi:shield';
};

const getRoleIconColor = (roleName: string) => {
    const colors = {
        'Administrador': 'text-red-500',
        'Jefe': 'text-blue-500',
        'Personal': 'text-green-500',
    };
    
    return colors[roleName as keyof typeof colors] || 'text-gray-500';
};

const getRoleColor = (roleName: string) => {
    const colors = {
        'Administrador': 'bg-red-100 text-red-800 hover:bg-red-200 dark:bg-red-900 dark:text-red-200',
        'Jefe': 'bg-blue-100 text-blue-800 hover:bg-blue-200 dark:bg-blue-900 dark:text-blue-200',
        'Personal': 'bg-green-100 text-green-800 hover:bg-green-200 dark:bg-green-900 dark:text-green-200',
    };
    
    return colors[roleName as keyof typeof colors] || 'bg-gray-100 text-gray-800 hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-200';
};

const getRoleDescription = (roleName: string) => {
    const descriptions = {
        'Administrador': 'Acceso completo al sistema, gestión de usuarios y configuraciones',
        'Jefe': 'Visualización de todos los títulos y reportes del sistema',
        'Personal': 'Gestión de títulos propios y operaciones básicas',
    };
    
    return descriptions[roleName as keyof typeof descriptions] || 'Rol del sistema';
};

const formatDate = (dateString: string) => {
    return new Date(dateString).toLocaleDateString('es-ES', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
};

const confirmDelete = () => {
    if (confirm(`¿Estás seguro de que quieres eliminar el usuario "${props.usuario.name}"?`)) {
        router.delete(route('v2.usuarios.destroy', props.usuario.id), {
            onSuccess: (page: any) => {
                const successMessage = page.props.flash?.success || 'Usuario eliminado exitosamente';
                toast.success(successMessage);
            },
            onError: (errors: any) => {
                const errorMessage = errors.delete || errors.usuario || 'Error al eliminar el usuario';
                toast.error(errorMessage);
            },
        });
    }
};
</script>