<template>
    <AppLayout
        title="Universidades"
        page-title="Universidades"
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
                            <TableHead class="w-1/5">Sigla</TableHead>
                            <TableHead class="w-1/4">Dirección</TableHead>
                            <TableHead class="w-1/5 pr-4 text-center">Especialidades</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow
                            v-for="universidad in universidades.data"
                            :key="universidad.id"
                            class="group cursor-pointer border-b border-border/30 transition-colors duration-150 last:border-0 hover:bg-accent/30 focus-visible:ring-2 focus-visible:ring-ring focus-visible:outline-none active:bg-accent/40"
                            @click="router.visit(route('universidades.show', universidad.id))"
                            @keydown.enter="router.visit(route('universidades.show', universidad.id))"
                            @keydown.space.prevent="router.visit(route('universidades.show', universidad.id))"
                            tabindex="0"
                            :aria-label="`Ver detalles de ${universidad.nombre}`"
                            role="button"
                        >
                            <TableCell class="px-4 py-3">
                                <div class="text-sm font-medium text-foreground">
                                    {{ universidad.nombre }}
                                </div>
                            </TableCell>
                            <TableCell class="px-3 py-3">
                                <Badge v-if="universidad.sigla" variant="secondary" class="px-2 py-1 text-xs">
                                    {{ universidad.sigla }}
                                </Badge>
                                <span v-else class="text-sm text-muted-foreground">
                                    No especificada
                                </span>
                            </TableCell>
                            <TableCell class="px-3 py-3">
                                <span class="truncate text-sm text-muted-foreground">
                                    {{ universidad.sigla || 'No especificada' }}
                                </span>
                            </TableCell>
                            <TableCell class="px-3 py-3 pr-4 text-center">
                                <Badge variant="outline" class="px-2 py-1 text-xs">
                                    {{ universidad.especialidades_count }}
                                </Badge>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                    <TableEmpty v-if="universidades.data.length === 0">
                        <div class="flex flex-col items-center justify-center py-12">
                            <Icon icon="lucide:graduation-cap" class="mb-4 h-12 w-12 text-muted-foreground" />
                            <h3 class="text-lg font-medium">No se encontraron universidades</h3>
                            <p class="mb-4 max-w-md text-center text-muted-foreground">
                                Comienza creando tu primera universidad para organizar las especialidades académicas.
                            </p>
                            <Button as-child>
                                <Link :href="route('universidades.create')">
                                    <Icon icon="lucide:plus-circle" class="mr-2 h-4 w-4" />
                                    Nueva Universidad
                                </Link>
                            </Button>
                        </div>
                    </TableEmpty>
                </Table>
            </Card>

            <!-- Pagination -->
            <div v-if="universidades.last_page > 1" class="flex items-center justify-between">
                <div class="text-sm text-muted-foreground">
                    Mostrando {{ universidades.from || 0 }} a {{ universidades.to || 0 }} de {{ universidades.total }} resultados
                </div>

                <Pagination
                    :total="universidades.total"
                    :items-per-page="universidades.per_page"
                    :default-page="universidades.current_page"
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
import navTabs from './navtabs.json';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card } from '@/components/ui/card';
import { Pagination, PaginationContent, PaginationNext, PaginationPrevious } from '@/components/ui/pagination';
import { Table, TableBody, TableCell, TableEmpty, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { Icon } from '@iconify/vue';
import { Link, router } from '@inertiajs/vue3';

interface Universidad {
    id: number;
    nombre: string;
    sigla: string | null;
    direccion: string | null;
    especialidades_count: number;
}

interface PaginatedUniversidades {
    data: Universidad[];
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
    universidades: PaginatedUniversidades;
    filters: {
        search?: string;
    };
}

defineProps<Props>();

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