<template>
    <AppLayout title="Editar Usuario" :breadcrumbs="[{ label: 'Usuarios', href: route('v2.usuarios.index') }, { label: 'Editar Usuario', href: null }]">
        <div class="space-y-6">
            <!-- Header -->
            <div class="border-b border-border pb-4">
                <h1 class="text-2xl font-bold tracking-tight">Editar Usuario</h1>
                <p class="text-muted-foreground">Modifica la información del usuario {{ usuario.name }}</p>
            </div>

            <!-- Form -->
            <div class="max-w-2xl">
                <Card>
                    <CardContent class="pt-6">
                        <form @submit.prevent="submit" class="space-y-6">
                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                <!-- Información Personal -->
                                <div class="space-y-4">
                                    <div class="mb-4 flex items-center">
                                        <Icon icon="mdi:account-details" class="mr-2 h-5 w-5 text-primary" />
                                        <h3 class="text-lg font-medium">Información Personal</h3>
                                    </div>

                                    <!-- CI -->
                                    <div class="space-y-2">
                                        <Label for="ci">CI (Carnet de Identidad) *</Label>
                                        <Input
                                            id="ci"
                                            v-model="form.ci"
                                            type="text"
                                            placeholder="Ingrese el CI"
                                            :class="{ 'border-destructive': props.errors.ci }"
                                            required
                                            autofocus
                                        />
                                        <p v-if="props.errors.ci" class="text-sm text-destructive">
                                            {{ props.errors.ci }}
                                        </p>
                                    </div>

                                    <!-- Nombre -->
                                    <div class="space-y-2">
                                        <Label for="name">Nombre Completo *</Label>
                                        <Input
                                            id="name"
                                            v-model="form.name"
                                            type="text"
                                            placeholder="Ingrese el nombre completo"
                                            :class="{ 'border-destructive': props.errors.name }"
                                            required
                                        />
                                        <p v-if="props.errors.name" class="text-sm text-destructive">
                                            {{ props.errors.name }}
                                        </p>
                                    </div>

                                    <!-- Email -->
                                    <div class="space-y-2">
                                        <Label for="email">Correo Electrónico *</Label>
                                        <Input
                                            id="email"
                                            v-model="form.email"
                                            type="email"
                                            placeholder="ejemplo@uatf.edu.bo"
                                            :class="{ 'border-destructive': props.errors.email }"
                                            required
                                        />
                                        <p v-if="props.errors.email" class="text-sm text-destructive">
                                            {{ props.errors.email }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Roles y Opciones -->
                                <div class="space-y-4">
                                    <div class="mb-4 flex items-center">
                                        <Icon icon="mdi:shield-account" class="mr-2 h-5 w-5 text-primary" />
                                        <h3 class="text-lg font-medium">Roles y Permisos</h3>
                                    </div>

                                    <!-- Roles -->
                                    <div class="space-y-2">
                                        <Label>Roles del Usuario</Label>
                                        <div class="space-y-3 rounded-lg bg-muted/30 p-4">
                                            <div v-for="role in roles" :key="role.id" class="flex items-center space-x-3">
                                                <input
                                                    :id="`role-${role.id}`"
                                                    v-model="form.roles"
                                                    :value="role.name"
                                                    type="checkbox"
                                                    class="h-4 w-4 rounded border-gray-300 text-primary focus:ring-primary focus:ring-offset-0"
                                                />
                                                <Label :for="`role-${role.id}`" class="flex items-center text-sm font-normal">
                                                    <Icon :icon="getRoleIcon(role.name)" class="mr-2 h-4 w-4" :class="getRoleIconColor(role.name)" />
                                                    {{ role.name }}
                                                </Label>
                                            </div>
                                        </div>
                                        <p v-if="props.errors.roles" class="text-sm text-destructive">
                                            {{ props.errors.roles }}
                                        </p>
                                    </div>

                                    <!-- Información adicional -->
                                    <div class="space-y-2">
                                        <Label class="text-sm font-medium text-muted-foreground">Información del Usuario</Label>
                                        <div class="space-y-1 text-sm text-muted-foreground">
                                            <p><strong>Creado:</strong> {{ formatDate(usuario.created_at) }}</p>
                                            <p><strong>ID:</strong> {{ usuario.id }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Password Reset Section -->
                            <div class="border-t border-border pt-6">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="text-lg font-medium">Restablecer Contraseña</h3>
                                        <p class="text-sm text-muted-foreground">La contraseña actual se mantendrá si no se especifica una nueva</p>
                                    </div>
                                    <Button type="button" variant="outline" @click="showPasswordReset = !showPasswordReset">
                                        <Icon icon="mdi:lock-reset" class="mr-2 h-4 w-4" />
                                        {{ showPasswordReset ? 'Cancelar' : 'Cambiar Contraseña' }}
                                    </Button>
                                </div>

                                <div v-if="showPasswordReset" class="mt-4 grid grid-cols-1 gap-4 md:grid-cols-2">
                                    <!-- Nueva Contraseña -->
                                    <div class="space-y-2">
                                        <Label for="password">Nueva Contraseña</Label>
                                        <Input
                                            id="password"
                                            v-model="form.password"
                                            type="password"
                                            placeholder="Mínimo 8 caracteres"
                                            :class="{ 'border-destructive': props.errors.password }"
                                        />
                                        <p v-if="props.errors.password" class="text-sm text-destructive">
                                            {{ props.errors.password }}
                                        </p>
                                    </div>

                                    <!-- Confirmar Nueva Contraseña -->
                                    <div class="space-y-2">
                                        <Label for="password_confirmation">Confirmar Nueva Contraseña</Label>
                                        <Input
                                            id="password_confirmation"
                                            v-model="form.password_confirmation"
                                            type="password"
                                            placeholder="Confirme la nueva contraseña"
                                            :class="{ 'border-destructive': props.errors.password_confirmation }"
                                        />
                                        <p v-if="props.errors.password_confirmation" class="text-sm text-destructive">
                                            {{ props.errors.password_confirmation }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="flex items-center gap-3 border-t border-border pt-4">
                                <Button type="submit" :disabled="processing">
                                    <Icon v-if="processing" icon="mdi:loading" class="mr-2 h-4 w-4 animate-spin" />
                                    <Icon v-else icon="mdi:content-save" class="mr-2 h-4 w-4" />
                                    {{ processing ? 'Guardando...' : 'Guardar Cambios' }}
                                </Button>
                                <Button variant="outline" type="button" as-child>
                                    <Link :href="route('v2.usuarios.index')">
                                        <Icon icon="mdi:arrow-left" class="mr-2 h-4 w-4" />
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
import AppLayout from '@/Layouts/AppLayout.vue';
import { Button } from '@/components/ui/button';
import { Card, CardContent } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Icon } from '@iconify/vue';
import { Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
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
    errors: Record<string, string>;
    usuario: Usuario;
    roles: Role[];
}

const props = defineProps<Props>();

const showPasswordReset = ref(false);

// Form usando useForm - inicializar con datos existentes
const form = useForm({
    ci: props.usuario.ci,
    name: props.usuario.name,
    email: props.usuario.email,
    password: '',
    password_confirmation: '',
    roles: props.usuario.roles.map((role) => role.name),
});

const { processing } = form;

// Methods
const submit = () => {
    form.put(route('v2.usuarios.update', props.usuario.id), {
        onSuccess: () => {
            toast.success('Usuario actualizado exitosamente');
            showPasswordReset.value = false;
            form.password = '';
            form.password_confirmation = '';
        },
        onError: () => {
            toast.error('Por favor corrige los errores en el formulario');
        },
    });
};

const getRoleIcon = (roleName: string) => {
    const icons = {
        Administrador: 'mdi:shield-crown',
        Jefe: 'mdi:shield-star',
        Personal: 'mdi:shield-account',
    };

    return icons[roleName as keyof typeof icons] || 'mdi:shield';
};

const getRoleIconColor = (roleName: string) => {
    const colors = {
        Administrador: 'text-red-500',
        Jefe: 'text-blue-500',
        Personal: 'text-green-500',
    };

    return colors[roleName as keyof typeof colors] || 'text-gray-500';
};

const formatDate = (dateString: string) => {
    return new Date(dateString).toLocaleDateString('es-ES', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
    });
};
</script>
