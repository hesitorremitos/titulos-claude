<template>
    <AppLayout title="Usuarios" :breadcrumbs="[{ label: 'Usuarios' }]">
        <div class="space-y-6">
            <!-- Header -->
            <div class="border-b border-border pb-4">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h1 class="text-2xl font-bold tracking-tight">Usuarios</h1>
                        <p class="text-muted-foreground">Gestiona los usuarios del sistema y sus roles</p>
                    </div>
                    <Button as-child>
                        <Link :href="route('v2.usuarios.create')">
                            <Icon icon="mdi:plus" class="mr-2 h-4 w-4" />
                            Nuevo Usuario
                        </Link>
                    </Button>
                </div>
            </div>

            <!-- Search and Filters -->
            <Card>
                <CardContent class="p-6">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
                        <div class="flex-1">
                            <div class="flex gap-2">
                                <div class="relative flex-1">
                                    <Input v-model="searchTerm" placeholder="Buscar por CI, nombre o email..." @keyup.enter="handleSearch" />
                                </div>
                                <Button @click="handleSearch" variant="outline">
                                    <Icon icon="mdi:magnify" class="h-4 w-4" />
                                </Button>
                                <Button v-if="searchTerm" @click="clearSearch" variant="ghost" size="sm">
                                    <Icon icon="mdi:close" class="h-4 w-4" />
                                </Button>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-sm text-muted-foreground"> {{ usuarios.total }} usuarios </span>
                        </div>
                    </div>
                </CardContent>
            </Card>

            <!-- Table -->
            <Card>
                <Table>
                    <TableHeader>
                        <TableRow>
                            <TableHead>CI</TableHead>
                            <TableHead>Nombre</TableHead>
                            <TableHead>Email</TableHead>
                            <TableHead class="text-center">Roles</TableHead>
                            <TableHead class="text-right">Acciones</TableHead>
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
                                    <Badge 
                                        v-for="role in usuario.roles" 
                                        :key="role.id"
                                        :class="getRoleColor(role.name)"
                                    >
                                        {{ role.name }}
                                    </Badge>
                                </div>
                                <Badge v-else variant="secondary">
                                    Sin rol
                                </Badge>
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

                <Pagination
                    :total="usuarios.total"
                    :items-per-page="usuarios.per_page"
                    :default-page="usuarios.current_page"
                    @update:page="goToPage"
                >
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
import { Input } from '@/components/ui/input';
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
    filters: {
        search?: string;
    };
}

const props = defineProps<Props>();

const searchTerm = ref(props.filters.search || '');

// Methods
const handleSearch = () => {
    const params = new URLSearchParams(window.location.search);

    if (searchTerm.value) {
        params.set('search', searchTerm.value);
    } else {
        params.delete('search');
    }

    // Reset to page 1 when searching
    params.delete('page');

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

const clearSearch = () => {
    searchTerm.value = '';
    handleSearch();
};

const getRoleColor = (roleName: string) => {
    const colors = {
        'Administrador': 'bg-red-100 text-red-800 hover:bg-red-200 dark:bg-red-900 dark:text-red-200',
        'Jefe': 'bg-blue-100 text-blue-800 hover:bg-blue-200 dark:bg-blue-900 dark:text-blue-200',
        'Personal': 'bg-green-100 text-green-800 hover:bg-green-200 dark:bg-green-900 dark:text-green-200',
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