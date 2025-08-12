<template>
    <AppLayout 
        title="Facultades" 
        page-title="Facultades"
        :nav-tabs="navTabs"
        active-tab="lista"
    >
        <div class="space-y-6">
            <!-- Table -->
            <Card class="overflow-hidden">
                <Table>
                    <TableHeader>
                        <TableRow class="border-b border-border/50">
                            <TableHead class="w-2/5 pl-4">Nombre</TableHead>
                            <TableHead class="w-2/5">Dirección</TableHead>
                            <TableHead class="w-1/5 text-center pr-4">Carreras</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow 
                            v-for="facultad in facultades.data" 
                            :key="facultad.id" 
                            class="group cursor-pointer transition-colors duration-150 hover:bg-accent/30 active:bg-accent/40 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring border-b border-border/30 last:border-0"
                            @click="router.visit(route('v2.facultades.show', facultad.id))"
                            @keydown.enter="router.visit(route('v2.facultades.show', facultad.id))"
                            @keydown.space.prevent="router.visit(route('v2.facultades.show', facultad.id))"
                            tabindex="0"
                            :aria-label="`Ver detalles de ${facultad.nombre}`"
                            role="button"
                        >
                            <TableCell class="px-4 py-3">
                                <div class="font-medium text-foreground text-sm">
                                    {{ facultad.nombre }}
                                </div>
                            </TableCell>
                            <TableCell class="px-3 py-3">
                                <span class="text-sm text-muted-foreground truncate">
                                    {{ facultad.direccion || 'No especificada' }}
                                </span>
                            </TableCell>
                            <TableCell class="px-3 py-3 text-center pr-4">
                                <Badge variant="secondary" class="text-xs px-2 py-1">
                                    {{ facultad.carreras_count }}
                                </Badge>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                    <TableEmpty v-if="facultades.data.length === 0">
                        <div class="flex flex-col items-center justify-center py-12">
                            <Icon icon="lucide:building-2" class="mb-4 h-12 w-12 text-muted-foreground" />
                            <h3 class="text-lg font-medium">No se encontraron facultades</h3>
                            <p class="mb-4 text-muted-foreground text-center max-w-md">
                                Comienza creando tu primera facultad para organizar las carreras académicas.
                            </p>
                            <Button as-child>
                                <Link :href="route('v2.facultades.create')">
                                    <Icon icon="lucide:plus-circle" class="mr-2 h-4 w-4" />
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

// Navigation tabs - Solo Lista y Registrar
const navTabs = [
    { label: 'Lista', href: '/v2/facultades', icon: 'lucide:building-2', value: 'lista' },
    { label: 'Registrar', href: '/v2/facultades/create', icon: 'lucide:plus-circle', value: 'registrar' },
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
</script>
