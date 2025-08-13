<template>
    <AppLayout 
        title="Usuarios" 
        page-title="Usuarios" 
        :nav-tabs="navTabs" 
        active-tab="lista"
        :breadcrumbs="[
            { label: 'Dashboard', href: '/v2/dashboard' },
            { label: 'Gestión Administrativa', href: null },
            { label: 'Usuarios', href: null }
        ]"
    >
        <div class="space-y-6">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-4">
                <!-- Administradores -->
                <Card>
                    <CardContent class="p-4">
                        <div class="flex items-center gap-3">
                            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-red-100 dark:bg-red-900/20">
                                <Icon icon="lucide:shield-check" class="h-5 w-5 text-red-600 dark:text-red-400" />
                            </div>
                            <div>
                                <p class="text-xs tracking-wider text-muted-foreground uppercase">Administradores</p>
                                <p class="text-lg font-semibold text-foreground">{{ stats.administradores || 0 }}</p>
                            </div>
                        </div>
                    </CardContent>
                </Card>

                <!-- Jefes -->
                <Card>
                    <CardContent class="p-4">
                        <div class="flex items-center gap-3">
                            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-100 dark:bg-blue-900/20">
                                <Icon icon="lucide:user-cog" class="h-5 w-5 text-blue-600 dark:text-blue-400" />
                            </div>
                            <div>
                                <p class="text-xs tracking-wider text-muted-foreground uppercase">Jefes</p>
                                <p class="text-lg font-semibold text-foreground">{{ stats.jefes || 0 }}</p>
                            </div>
                        </div>
                    </CardContent>
                </Card>

                <!-- Personal -->
                <Card>
                    <CardContent class="p-4">
                        <div class="flex items-center gap-3">
                            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-green-100 dark:bg-green-900/20">
                                <Icon icon="lucide:users" class="h-5 w-5 text-green-600 dark:text-green-400" />
                            </div>
                            <div>
                                <p class="text-xs tracking-wider text-muted-foreground uppercase">Personal</p>
                                <p class="text-lg font-semibold text-foreground">{{ stats.personal || 0 }}</p>
                            </div>
                        </div>
                    </CardContent>
                </Card>

                <!-- Estado: Activos/Inactivos -->
                <Card>
                    <CardContent class="p-4">
                        <div class="flex items-center gap-3">
                            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-amber-100 dark:bg-amber-900/20">
                                <Icon icon="lucide:activity" class="h-5 w-5 text-amber-600 dark:text-amber-400" />
                            </div>
                            <div>
                                <p class="text-xs tracking-wider text-muted-foreground uppercase">Activos/Inactivos</p>
                                <p class="text-lg font-semibold text-foreground">
                                    <span class="text-green-600">{{ stats.activos || 0 }}</span>
                                    <span class="mx-1 text-muted-foreground">/</span>
                                    <span class="text-red-500">{{ stats.inactivos || 0 }}</span>
                                </p>
                            </div>
                        </div>
                    </CardContent>
                </Card>
            </div>

            <!-- Table -->
            <Card class="overflow-hidden">
                <Table>
                    <TableHeader>
                        <TableRow class="border-b border-border/50">
                            <TableHead class="w-1/6 pl-4">CI</TableHead>
                            <TableHead class="w-2/5">Nombre</TableHead>
                            <TableHead class="w-1/4">Email</TableHead>
                            <TableHead class="w-1/6 pr-4 text-center">Roles</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-for="usuario in usuarios.data" :key="usuario.id" class="group">
                            <TableCell>
                                <div class="font-medium">
                                    {{ usuario.ci }}
                                </div>
                            </TableCell>
                            <TableCell>
                                <div class="font-medium">
                                    {{ usuario.name }}
                                </div>
                            </TableCell>
                            <TableCell>
                                <span class="text-muted-foreground">
                                    {{ usuario.email }}
                                </span>
                            </TableCell>
                            <TableCell class="text-center">
                                <div v-if="usuario.roles && usuario.roles.length > 0" class="flex flex-wrap justify-center gap-1">
                                    <Badge v-for="role in usuario.roles" :key="role.id" :class="getRoleColor(role.name)">
                                        {{ role.name }}
                                    </Badge>
                                </div>
                                <Badge v-else variant="secondary"> Sin rol </Badge>
                            </TableCell>
                            <TableCell class="text-right">
                                <div class="opacity-0 transition-opacity group-hover:opacity-100">
                                    <div class="flex items-center justify-end gap-2">
                                        <TooltipProvider>
                                            <Tooltip>
                                                <TooltipTrigger as-child>
                                                    <Button variant="ghost" size="sm" as-child>
                                                        <Link :href="route('v2.usuarios.show', usuario.id)">
                                                            <Icon icon="mdi:eye" class="h-4 w-4" />
                                                        </Link>
                                                    </Button>
                                                </TooltipTrigger>
                                                <TooltipContent>
                                                    <p>Ver detalles</p>
                                                </TooltipContent>
                                            </Tooltip>
                                        </TooltipProvider>

                                        <TooltipProvider>
                                            <Tooltip>
                                                <TooltipTrigger as-child>
                                                    <Button variant="ghost" size="sm" as-child>
                                                        <Link :href="route('v2.usuarios.edit', usuario.id)">
                                                            <Icon icon="mdi:pencil" class="h-4 w-4" />
                                                        </Link>
                                                    </Button>
                                                </TooltipTrigger>
                                                <TooltipContent>
                                                    <p>Editar usuario</p>
                                                </TooltipContent>
                                            </Tooltip>
                                        </TooltipProvider>

                                        <TooltipProvider v-if="usuario.id !== $page.props.auth?.user?.id">
                                            <Tooltip>
                                                <TooltipTrigger as-child>
                                                    <Button variant="ghost" size="sm" @click="confirmDelete(usuario)">
                                                        <Icon icon="mdi:delete" class="h-4 w-4" />
                                                    </Button>
                                                </TooltipTrigger>
                                                <TooltipContent>
                                                    <p>Eliminar usuario</p>
                                                </TooltipContent>
                                            </Tooltip>
                                        </TooltipProvider>
                                    </div>
                                </div>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                    <TableEmpty v-if="usuarios.data.length === 0">
                        <div class="flex flex-col items-center justify-center py-8">
                            <Icon icon="mdi:account-multiple" class="mb-4 h-12 w-12 text-muted-foreground" />
                            <h3 class="text-lg font-medium">No se encontraron usuarios</h3>
                            <p class="mb-4 text-muted-foreground">
                                {{ searchTerm ? 'Intenta con otros términos de búsqueda.' : 'Comienza creando tu primer usuario.' }}
                            </p>
                            <Button as-child v-if="!searchTerm">
                                <Link :href="route('v2.usuarios.create')">
                                    <Icon icon="mdi:plus" class="mr-2 h-4 w-4" />
                                    Nuevo Usuario
                                </Link>
                            </Button>
                        </div>
                    </TableEmpty>
                </Table>
            </Card>

            <!-- Pagination -->
            <div v-if="usuarios.last_page > 1" class="flex items-center justify-between">
                <div class="text-sm text-muted-foreground">
                    Mostrando {{ usuarios.from || 0 }} a {{ usuarios.to || 0 }} de {{ usuarios.total }} resultados
                </div>

                <Pagination :total="usuarios.total" :items-per-page="usuarios.per_page" :default-page="usuarios.current_page" @update:page="goToPage">
                    <PaginationContent>
                        <PaginationPrevious />
                        <PaginationNext />
                    </PaginationContent>
                </Pagination>
            </div>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from '@/Layouts/AppLayout.vue';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent } from '@/components/ui/card';
import { Pagination, PaginationContent, PaginationNext, PaginationPrevious } from '@/components/ui/pagination';
import { Table, TableBody, TableCell, TableEmpty, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { Tooltip, TooltipContent, TooltipProvider, TooltipTrigger } from '@/components/ui/tooltip';
import { Icon } from '@iconify/vue';
import { Link, router } from '@inertiajs/vue3';
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

interface PaginatedUsuarios {
    data: Usuario[];
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
    from: number | null;
    to: number | null;
    prev_page_url: string | null;
    next_page_url: string | null;
}

interface Props {
    usuarios: PaginatedUsuarios;
    stats: {
        administradores: number;
        jefes: number;
        personal: number;
        activos: number;
        inactivos: number;
    };
    filters: {
        search?: string;
    };
}

const props = defineProps<Props>();

// Navigation tabs - Solo Lista y Registrar
const navTabs = [
    { label: 'Lista', href: '/v2/usuarios', icon: 'lucide:users', value: 'lista' },
    { label: 'Registrar', href: '/v2/usuarios/create', icon: 'lucide:user-plus', value: 'registrar' },
];

const searchTerm = ref(props.filters.search || '');

// Methods
const goToPage = (page: number) => {
    const params = new URLSearchParams(window.location.search);
    params.set('page', page.toString());

    const url = `${window.location.pathname}?${params.toString()}`;

    router.get(
        url,
        {},
        {
            preserveState: true,
            preserveScroll: true,
        },
    );
};

const getRoleColor = (roleName: string) => {
    const colors = {
        Administrador: 'bg-red-100 text-red-800 hover:bg-red-200 dark:bg-red-900 dark:text-red-200',
        Jefe: 'bg-blue-100 text-blue-800 hover:bg-blue-200 dark:bg-blue-900 dark:text-blue-200',
        Personal: 'bg-green-100 text-green-800 hover:bg-green-200 dark:bg-green-900 dark:text-green-200',
    };

    return colors[roleName as keyof typeof colors] || 'bg-gray-100 text-gray-800 hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-200';
};

const confirmDelete = (usuario: Usuario) => {
    if (confirm(`¿Estás seguro de que quieres eliminar el usuario "${usuario.name}"?`)) {
        router.delete(route('v2.usuarios.destroy', usuario.id), {
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
