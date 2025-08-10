<template>
    <AppLayout title="Facultades" :breadcrumbs="[{ label: 'Facultades' }]">
        <div class="space-y-6">
            <!-- Header -->
            <div class="border-b border-border pb-4">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h1 class="text-2xl font-bold tracking-tight">Facultades</h1>
                        <p class="text-muted-foreground">Gestiona las facultades de la Universidad</p>
                    </div>
                    <Button as-child>
                        <Link :href="route('v2.facultades.create')">
                            <Icon icon="mdi:plus" class="mr-2 h-4 w-4" />
                            Nueva Facultad
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
                                    <Input v-model="searchTerm" placeholder="Buscar facultades..." @keyup.enter="handleSearch" />
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
                            <span class="text-sm text-muted-foreground"> {{ facultades.total }} facultades </span>
                        </div>
                    </div>
                </CardContent>
            </Card>

            <!-- Table -->
            <Card>
                <Table>
                    <TableHeader>
                        <TableRow>
                            <TableHead>Nombre</TableHead>
                            <TableHead>Dirección</TableHead>
                            <TableHead class="text-center">Carreras</TableHead>
                            <TableHead class="text-right">Acciones</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-for="facultad in facultades.data" :key="facultad.id" class="group">
                            <TableCell>
                                <div class="font-medium">
                                    {{ facultad.nombre }}
                                </div>
                            </TableCell>
                            <TableCell>
                                <span class="text-muted-foreground">
                                    {{ facultad.direccion || 'No especificada' }}
                                </span>
                            </TableCell>
                            <TableCell class="text-center">
                                <Badge variant="secondary">
                                    {{ facultad.carreras_count }}
                                </Badge>
                            </TableCell>
                            <TableCell class="text-right">
                                <div class="opacity-0 transition-opacity group-hover:opacity-100">
                                    <TooltipProvider>
                                        <Tooltip>
                                            <TooltipTrigger as-child>
                                                <Button variant="ghost" size="sm" as-child>
                                                    <Link :href="route('v2.facultades.show', facultad.id)">
                                                        <p>VER</p>
                                                        <Icon icon="mdi:eye" class="h-4 w-4" />
                                                    </Link>
                                                </Button>
                                            </TooltipTrigger>
                                            <TooltipContent>
                                                <p>Ver detalles</p>
                                            </TooltipContent>
                                        </Tooltip>
                                    </TooltipProvider>
                                </div>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                    <TableEmpty v-if="facultades.data.length === 0">
                        <div class="flex flex-col items-center justify-center py-8">
                            <Icon icon="mdi:school" class="mb-4 h-12 w-12 text-muted-foreground" />
                            <h3 class="text-lg font-medium">No se encontraron facultades</h3>
                            <p class="mb-4 text-muted-foreground">
                                {{ searchTerm ? 'Intenta con otros términos de búsqueda.' : 'Comienza creando tu primera facultad.' }}
                            </p>
                            <Button as-child v-if="!searchTerm">
                                <Link :href="route('v2.facultades.create')">
                                    <Icon icon="mdi:plus" class="mr-2 h-4 w-4" />
                                    Nueva Facultad
                                </Link>
                            </Button>
                        </div>
                    </TableEmpty>
                </Table>
            </Card>

            <!-- Pagination -->
            <div v-if="facultades.last_page > 1" class="flex items-center justify-between">
                <div class="text-sm text-muted-foreground">
                    Mostrando {{ facultades.from || 0 }} a {{ facultades.to || 0 }} de {{ facultades.total }} resultados
                </div>

                <Pagination
                    :total="facultades.total"
                    :items-per-page="facultades.per_page"
                    :default-page="facultades.current_page"
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

interface Facultad {
    id: number;
    nombre: string;
    direccion: string | null;
    carreras_count: number;
}

interface PaginatedFacultades {
    data: Facultad[];
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
    facultades: PaginatedFacultades;
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
</script>
