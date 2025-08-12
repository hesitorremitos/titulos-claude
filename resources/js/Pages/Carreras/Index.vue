<template>
    <AppLayout title="Carreras" page-title="Carreras" :nav-tabs="navTabs" active-tab="lista">
        <div class="space-y-6">
            <!-- Table -->
            <Card class="overflow-hidden">
                <Table>
                    <TableHeader>
                        <TableRow class="border-b border-border/50">
                            <TableHead class="w-1/6 pl-4">Código</TableHead>
                            <TableHead class="w-2/5">Programa</TableHead>
                            <TableHead class="w-1/4">Facultad</TableHead>
                            <TableHead class="w-1/4 pr-4">Dirección</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow
                            v-for="carrera in carreras.data"
                            :key="carrera.id"
                            class="group cursor-pointer border-b border-border/30 transition-colors duration-150 last:border-0 hover:bg-accent/30 focus-visible:ring-2 focus-visible:ring-ring focus-visible:outline-none active:bg-accent/40"
                            @click="router.visit(route('v2.carreras.show', carrera.id))"
                            @keydown.enter="router.visit(route('v2.carreras.show', carrera.id))"
                            @keydown.space.prevent="router.visit(route('v2.carreras.show', carrera.id))"
                            tabindex="0"
                            :aria-label="`Ver detalles de ${carrera.programa}`"
                            role="button"
                        >
                            <TableCell class="px-4 py-3">
                                <code class="relative rounded bg-muted/60 px-2 py-1 font-mono text-xs font-medium text-foreground">
                                    {{ carrera.id }}
                                </code>
                            </TableCell>
                            <TableCell class="px-3 py-3">
                                <div class="text-sm font-medium text-foreground">
                                    {{ carrera.programa }}
                                </div>
                            </TableCell>
                            <TableCell class="px-3 py-3">
                                <span class="truncate text-sm text-muted-foreground">
                                    {{ carrera.facultad.nombre }}
                                </span>
                            </TableCell>
                            <TableCell class="px-3 py-3 pr-4">
                                <span class="truncate text-sm text-muted-foreground">
                                    {{ carrera.direccion || 'No especificada' }}
                                </span>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                    <TableEmpty v-if="carreras.data.length === 0">
                        <div class="flex flex-col items-center justify-center py-12">
                            <Icon icon="lucide:list-checks" class="mb-4 h-12 w-12 text-muted-foreground" />
                            <h3 class="text-lg font-medium">No se encontraron carreras</h3>
                            <p class="mb-4 max-w-md text-center text-muted-foreground">Comienza creando tu primera carrera académica.</p>
                            <Button as-child>
                                <Link :href="route('v2.carreras.create')">
                                    <Icon icon="lucide:plus-circle" class="mr-2 h-4 w-4" />
                                    Nueva Carrera
                                </Link>
                            </Button>
                        </div>
                    </TableEmpty>
                </Table>
            </Card>

            <!-- Pagination -->
            <div v-if="carreras.last_page > 1" class="flex items-center justify-between">
                <div class="text-sm text-muted-foreground">
                    Mostrando {{ carreras.from || 0 }} a {{ carreras.to || 0 }} de {{ carreras.total }} resultados
                </div>

                <Pagination :total="carreras.total" :items-per-page="carreras.per_page" :default-page="carreras.current_page" @update:page="goToPage">
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
import { Button } from '@/components/ui/button';
import { Card } from '@/components/ui/card';
import { Pagination, PaginationContent, PaginationNext, PaginationPrevious } from '@/components/ui/pagination';
import { Table, TableBody, TableCell, TableEmpty, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { Icon } from '@iconify/vue';
import { Link, router } from '@inertiajs/vue3';

interface Facultad {
    id: number;
    nombre: string;
}

interface Carrera {
    id: string;
    programa: string;
    direccion: string | null;
    facultad: Facultad;
}

interface PaginatedCarreras {
    data: Carrera[];
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
    carreras: PaginatedCarreras;
    facultades: Facultad[];
    filters: {
        search?: string;
        facultad_id?: string;
    };
}

defineProps<Props>();

// Navigation tabs - Solo Lista y Registrar
const navTabs = [
    { label: 'Lista', href: '/v2/carreras', icon: 'lucide:list-checks', value: 'lista' },
    { label: 'Registrar', href: '/v2/carreras/create', icon: 'lucide:plus-circle', value: 'registrar' },
];

// Navigation and pagination methods

const goToPage = (page: number) => {
    const params = new URLSearchParams();
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
