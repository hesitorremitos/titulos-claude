<template>
    <AppLayout :title="facultad.nombre" :breadcrumbs="[{ label: 'Facultades', href: route('v2.facultades.index') }, { label: facultad.nombre, href: null }]">
        <div class="space-y-6">
            <!-- Header -->
            <div class="border-b border-border pb-4">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h1 class="text-2xl font-bold tracking-tight">{{ facultad.nombre }}</h1>
                        <p class="text-muted-foreground">Información detallada de la facultad</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <Button variant="outline" as-child>
                            <Link :href="route('v2.facultades.edit', facultad.id)">
                                <Icon icon="mdi:pencil" class="mr-2 h-4 w-4" />
                                Editar
                            </Link>
                        </Button>
                        <AlertDialog>
                            <AlertDialogTrigger as-child>
                                <Button variant="outline" :disabled="facultad.carreras.length > 0">
                                    <Icon icon="mdi:trash-can" class="mr-2 h-4 w-4 text-destructive" />
                                    Eliminar
                                </Button>
                            </AlertDialogTrigger>
                            <AlertDialogContent>
                                <AlertDialogHeader>
                                    <AlertDialogTitle>¿Eliminar facultad?</AlertDialogTitle>
                                    <AlertDialogDescription>
                                        Esta acción no se puede deshacer. Se eliminará permanentemente la facultad "{{ facultad.nombre }}".
                                        {{ facultad.carreras.length > 0 ? 'Esta facultad tiene carreras asociadas y no se puede eliminar.' : '' }}
                                    </AlertDialogDescription>
                                </AlertDialogHeader>
                                <AlertDialogFooter>
                                    <AlertDialogCancel>Cancelar</AlertDialogCancel>
                                    <AlertDialogAction
                                        @click="deleteFacultad"
                                        :disabled="facultad.carreras.length > 0"
                                        class="bg-destructive text-destructive-foreground hover:bg-destructive/90"
                                    >
                                        Eliminar
                                    </AlertDialogAction>
                                </AlertDialogFooter>
                            </AlertDialogContent>
                        </AlertDialog>
                    </div>
                </div>
            </div>

            <!-- Faculty Info -->
            <div class="grid gap-6 md:grid-cols-2">
                <!-- Basic Information -->
                <Card>
                    <CardHeader>
                        <CardTitle class="flex items-center gap-2">
                            <Icon icon="mdi:school" class="h-5 w-5" />
                            Información Básica
                        </CardTitle>
                    </CardHeader>
                    <CardContent class="space-y-4">
                        <div>
                            <Label class="text-sm font-medium text-muted-foreground">Nombre</Label>
                            <p class="text-sm font-medium">{{ facultad.nombre }}</p>
                        </div>
                        <Separator />
                        <div>
                            <Label class="text-sm font-medium text-muted-foreground">Dirección</Label>
                            <p class="text-sm">{{ facultad.direccion || 'No especificada' }}</p>
                        </div>
                    </CardContent>
                </Card>

                <!-- Statistics -->
                <Card>
                    <CardHeader>
                        <CardTitle class="flex items-center gap-2">
                            <Icon icon="mdi:chart-bar" class="h-5 w-5" />
                            Estadísticas
                        </CardTitle>
                    </CardHeader>
                    <CardContent>
                        <div class="flex items-center justify-between rounded-lg bg-blue-50 p-4 dark:bg-blue-950">
                            <div>
                                <p class="text-2xl font-bold text-blue-700 dark:text-blue-300">
                                    {{ facultad.carreras.length }}
                                </p>
                                <p class="text-sm text-blue-600 dark:text-blue-400">Carreras asociadas</p>
                            </div>
                            <Icon icon="mdi:book-education" class="h-8 w-8 text-blue-500" />
                        </div>
                    </CardContent>
                </Card>
            </div>

            <!-- Associated Careers -->
            <Card>
                <CardHeader>
                    <div class="flex items-center justify-between">
                        <div>
                            <CardTitle class="flex items-center gap-2">
                                <Icon icon="mdi:book-education" class="h-5 w-5" />
                                Carreras Asociadas
                            </CardTitle>
                            <CardDescription> Lista de carreras que pertenecen a esta facultad </CardDescription>
                        </div>
                        <Button as-child>
                            <Link :href="route('v2.carreras.create', { facultad_id: facultad.id })">
                                <Icon icon="mdi:plus" class="mr-2 h-4 w-4" />
                                Nueva Carrera
                            </Link>
                        </Button>
                    </div>
                </CardHeader>
                <CardContent>
                    <div v-if="facultad.carreras.length > 0" class="space-y-4">
                        <Table>
                            <TableHeader>
                                <TableRow>
                                    <TableHead>Código</TableHead>
                                    <TableHead>Programa</TableHead>
                                    <TableHead>Dirección</TableHead>
                                    <TableHead class="text-right">Acciones</TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                <TableRow v-for="carrera in facultad.carreras" :key="carrera.id">
                                    <TableCell>
                                        <code class="relative rounded bg-muted px-[0.3rem] py-[0.2rem] font-mono text-sm">
                                            {{ carrera.id }}
                                        </code>
                                    </TableCell>
                                    <TableCell>
                                        <Link :href="route('v2.carreras.show', carrera.id)" class="font-medium hover:underline">
                                            {{ carrera.programa }}
                                        </Link>
                                    </TableCell>
                                    <TableCell>
                                        <span class="text-muted-foreground">
                                            {{ carrera.direccion || 'No especificada' }}
                                        </span>
                                    </TableCell>
                                    <TableCell class="text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <Button variant="ghost" size="sm" as-child>
                                                <Link :href="route('v2.carreras.show', carrera.id)">
                                                    <Icon icon="mdi:eye" class="h-4 w-4" />
                                                </Link>
                                            </Button>
                                            <Button variant="ghost" size="sm" as-child>
                                                <Link :href="route('v2.carreras.edit', carrera.id)">
                                                    <Icon icon="mdi:pencil" class="h-4 w-4" />
                                                </Link>
                                            </Button>
                                        </div>
                                    </TableCell>
                                </TableRow>
                            </TableBody>
                        </Table>
                    </div>

                    <!-- Empty State -->
                    <div v-else class="flex flex-col items-center justify-center py-12 text-center">
                        <Icon icon="mdi:book-education" class="mb-4 h-12 w-12 text-muted-foreground" />
                        <h3 class="text-lg font-medium">No hay carreras asociadas</h3>
                        <p class="mb-6 text-muted-foreground">Esta facultad aún no tiene carreras. Crea la primera carrera para comenzar.</p>
                        <Button as-child>
                            <Link :href="route('v2.carreras.create', { facultad_id: facultad.id })">
                                <Icon icon="mdi:plus" class="mr-2 h-4 w-4" />
                                Crear Primera Carrera
                            </Link>
                        </Button>
                    </div>
                </CardContent>
            </Card>

            <!-- Actions -->
            <div class="flex items-center justify-between border-t border-border pt-6">
                <Button variant="outline" as-child>
                    <Link :href="route('v2.facultades.index')">
                        <Icon icon="mdi:arrow-left" class="mr-2 h-4 w-4" />
                        Volver a Facultades
                    </Link>
                </Button>

                <div class="flex items-center gap-2">
                    <Button variant="outline" as-child>
                        <Link :href="route('v2.facultades.edit', facultad.id)">
                            <Icon icon="mdi:pencil" class="mr-2 h-4 w-4" />
                            Editar Facultad
                        </Link>
                    </Button>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from '@/Layouts/AppLayout.vue';
import {
    AlertDialog,
    AlertDialogAction,
    AlertDialogCancel,
    AlertDialogContent,
    AlertDialogDescription,
    AlertDialogFooter,
    AlertDialogHeader,
    AlertDialogTitle,
    AlertDialogTrigger,
} from '@/components/ui/alert-dialog';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Label } from '@/components/ui/label';
import { Separator } from '@/components/ui/separator';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { Icon } from '@iconify/vue';
import { Link, router } from '@inertiajs/vue3';
import { toast } from 'vue-sonner';

interface Carrera {
    id: string;
    programa: string;
    direccion: string | null;
}

interface Facultad {
    id: number;
    nombre: string;
    direccion: string | null;
    carreras: Carrera[];
}

interface Props {
    facultad: Facultad;
}

const props = defineProps<Props>();

// Methods
const deleteFacultad = () => {
    router.delete(route('v2.facultades.destroy', props.facultad.id), {
        onSuccess: () => {
            toast.success('Facultad eliminada exitosamente');
        },
        onError: (errors) => {
            const errorMessage = errors.facultad || 'Error al eliminar la facultad';
            toast.error(errorMessage);
        },
    });
};
</script>
