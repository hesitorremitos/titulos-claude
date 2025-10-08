<template>
    <AppLayout :title="universidad.nombre">
        <div class="space-y-6">
            <!-- Header -->
            <div class="border-b border-border pb-4">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <div class="mb-2 flex items-center gap-3">
                            <h1 class="text-2xl font-bold tracking-tight">{{ universidad.nombre }}</h1>
                            <Badge v-if="universidad.sigla" variant="secondary" class="px-2 py-1 text-xs">
                                {{ universidad.sigla }}
                            </Badge>
                        </div>
                        <p class="text-muted-foreground">Información detallada de la universidad</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <Button variant="outline" as-child>
                            <Link :href="route('universidades.edit', universidad.id)">
                                <Icon icon="mdi:pencil" class="mr-2 h-4 w-4" />
                                Editar
                            </Link>
                        </Button>
                        <AlertDialog>
                            <AlertDialogTrigger as-child>
                                <Button variant="outline" :disabled="universidad.especialidades.length > 0">
                                    <Icon icon="mdi:trash-can" class="mr-2 h-4 w-4 text-destructive" />
                                    Eliminar
                                </Button>
                            </AlertDialogTrigger>
                            <AlertDialogContent>
                                <AlertDialogHeader>
                                    <AlertDialogTitle>¿Eliminar universidad?</AlertDialogTitle>
                                    <AlertDialogDescription>
                                        Esta acción no se puede deshacer. Se eliminará permanentemente la universidad "{{ universidad.nombre }}".
                                        {{ universidad.especialidades.length > 0 ? 'Esta universidad tiene especialidades asociadas y no se puede eliminar.' : '' }}
                                    </AlertDialogDescription>
                                </AlertDialogHeader>
                                <AlertDialogFooter>
                                    <AlertDialogCancel>Cancelar</AlertDialogCancel>
                                    <AlertDialogAction
                                        @click="deleteUniversidad"
                                        :disabled="universidad.especialidades.length > 0"
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

            <!-- University Info -->
            <div class="grid gap-6 md:grid-cols-2">
                <!-- Basic Information -->
                <Card>
                    <CardHeader>
                        <CardTitle class="flex items-center gap-2">
                            <Icon icon="mdi:graduation-cap" class="h-5 w-5" />
                            Información Básica
                        </CardTitle>
                    </CardHeader>
                    <CardContent class="space-y-4">
                        <div>
                            <Label class="text-sm font-medium text-muted-foreground">Nombre</Label>
                            <p class="text-sm font-medium">{{ universidad.nombre }}</p>
                        </div>
                        <Separator />
                        <div>
                            <Label class="text-sm font-medium text-muted-foreground">Sigla</Label>
                            <p class="text-sm">{{ universidad.sigla || 'No especificada' }}</p>
                        </div>
                        <Separator />
                        <div>
                            <Label class="text-sm font-medium text-muted-foreground">Dirección</Label>
                            <p class="text-sm">{{ universidad.direccion || 'No especificada' }}</p>
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
                                    {{ universidad.especialidades.length }}
                                </p>
                                <p class="text-sm text-blue-600 dark:text-blue-400">Especialidades asociadas</p>
                            </div>
                            <Icon icon="mdi:school" class="h-8 w-8 text-blue-500" />
                        </div>
                    </CardContent>
                </Card>
            </div>

            <!-- Associated Specialties -->
            <Card>
                <CardHeader>
                    <div class="flex items-center justify-between">
                        <div>
                            <CardTitle class="flex items-center gap-2">
                                <Icon icon="mdi:school" class="h-5 w-5" />
                                Especialidades Asociadas
                            </CardTitle>
                            <CardDescription> Lista de especialidades que pertenecen a esta universidad </CardDescription>
                        </div>
                        <!-- Temporarily disabled until especialidades CRUD is implemented -->
                        <!-- Button as-child>
                            <Link :href="route('especialidades.create', { universidad_id: universidad.id })">
                                <Icon icon="mdi:plus" class="mr-2 h-4 w-4" />
                                Nueva Especialidad
                            </Link>
                        </Button -->
                    </div>
                </CardHeader>
                <CardContent>
                    <div v-if="universidad.especialidades.length > 0" class="space-y-4">
                        <Table>
                            <TableHeader>
                                <TableRow>
                                    <TableHead>Nombre</TableHead>
                                    <TableHead>Descripción</TableHead>
                                    <TableHead class="text-right">Acciones</TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                <TableRow v-for="especialidad in universidad.especialidades" :key="especialidad.id">
                                    <TableCell>
                                        <Link :href="route('especialidades.show', especialidad.id)" class="font-medium hover:underline">
                                            {{ especialidad.nombre }}
                                        </Link>
                                    </TableCell>
                                    <TableCell>
                                        <span class="text-muted-foreground">
                                            {{ especialidad.descripcion || 'No especificada' }}
                                        </span>
                                    </TableCell>
                                    <TableCell class="text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <Button variant="ghost" size="sm" as-child>
                                                <Link :href="route('especialidades.show', especialidad.id)">
                                                    <Icon icon="mdi:eye" class="h-4 w-4" />
                                                </Link>
                                            </Button>
                                            <Button variant="ghost" size="sm" as-child>
                                                <Link :href="route('especialidades.edit', especialidad.id)">
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
                        <Icon icon="mdi:school" class="mb-4 h-12 w-12 text-muted-foreground" />
                        <h3 class="text-lg font-medium">No hay especialidades asociadas</h3>
                        <p class="mb-6 text-muted-foreground">Esta universidad aún no tiene especialidades. Crea la primera especialidad para comenzar.</p>
                        <!-- Temporarily disabled until especialidades CRUD is implemented -->
                        <!-- Button as-child>
                            <Link :href="route('especialidades.create', { universidad_id: universidad.id })">
                                <Icon icon="mdi:plus" class="mr-2 h-4 w-4" />
                                Crear Primera Especialidad
                            </Link>
                        </Button -->
                    </div>
                </CardContent>
            </Card>

            <!-- Quick Actions -->
            <Card>
                <CardHeader>
                    <CardTitle class="flex items-center gap-2">
                        <Icon icon="mdi:lightning-bolt" class="h-5 w-5" />
                        Acciones Rápidas
                    </CardTitle>
                    <CardDescription> Operaciones comunes para esta universidad </CardDescription>
                </CardHeader>
                <CardContent>
                    <div class="grid gap-4 md:grid-cols-2">
                        <!-- Create Specialty - Temporarily disabled -->
                        <!-- Card class="p-4 transition-colors hover:bg-accent/50">
                            <Link :href="route('especialidades.create', { universidad_id: universidad.id })" class="block">
                                <div class="flex items-center gap-3">
                                    <div class="rounded-lg bg-green-100 p-2 dark:bg-green-900">
                                        <Icon icon="mdi:school" class="h-5 w-5 text-green-600 dark:text-green-400" />
                                    </div>
                                    <div>
                                        <h3 class="font-medium">Nueva Especialidad</h3>
                                        <p class="text-sm text-muted-foreground">Crear especialidad</p>
                                    </div>
                                    <Icon icon="mdi:arrow-right" class="ml-auto h-4 w-4 text-muted-foreground" />
                                </div>
                            </Link>
                        </Card -->

                        <!-- Edit University -->
                        <Card class="p-4 transition-colors hover:bg-accent/50">
                            <Link :href="route('universidades.edit', universidad.id)" class="block">
                                <div class="flex items-center gap-3">
                                    <div class="rounded-lg bg-orange-100 p-2 dark:bg-orange-900">
                                        <Icon icon="mdi:pencil" class="h-5 w-5 text-orange-600 dark:text-orange-400" />
                                    </div>
                                    <div>
                                        <h3 class="font-medium">Editar Universidad</h3>
                                        <p class="text-sm text-muted-foreground">Modificar información</p>
                                    </div>
                                    <Icon icon="mdi:arrow-right" class="ml-auto h-4 w-4 text-muted-foreground" />
                                </div>
                            </Link>
                        </Card>

                        <!-- View All Specialties - Temporarily disabled -->
                        <!-- Card class="p-4 transition-colors hover:bg-accent/50">
                            <Link :href="route('especialidades.index', { universidad_id: universidad.id })" class="block">
                                <div class="flex items-center gap-3">
                                    <div class="rounded-lg bg-purple-100 p-2 dark:bg-purple-900">
                                        <Icon icon="mdi:format-list-bulleted" class="h-5 w-5 text-purple-600 dark:text-purple-400" />
                                    </div>
                                    <div>
                                        <h3 class="font-medium">Ver Especialidades</h3>
                                        <p class="text-sm text-muted-foreground">Lista completa</p>
                                    </div>
                                    <Icon icon="mdi:arrow-right" class="ml-auto h-4 w-4 text-muted-foreground" />
                                </div>
                            </Link>
                        </Card -->
                    </div>
                </CardContent>
            </Card>

            <!-- Info Card -->
            <Card class="border-blue-200 bg-blue-50 dark:border-blue-800 dark:bg-blue-950">
                <CardContent class="pt-6">
                    <div class="flex items-start gap-3">
                        <Icon icon="mdi:information" class="mt-0.5 h-5 w-5 text-blue-600 dark:text-blue-400" />
                        <div>
                            <h3 class="font-medium text-blue-900 dark:text-blue-100">Información del sistema</h3>
                            <ul class="mt-2 space-y-1 text-sm text-blue-800 dark:text-blue-200">
                                <li>• Esta universidad tiene {{ universidad.especialidades.length }} especialidad(es) asociada(s)</li>
                                <li>• El nombre "{{ universidad.nombre }}" es único en el sistema</li>
                                <li>• {{ universidad.sigla ? `La sigla "${universidad.sigla}" es única` : 'No tiene sigla asignada' }}</li>
                                <li>• Puedes editar la información o agregar especialidades si es necesario</li>
                            </ul>
                        </div>
                    </div>
                </CardContent>
            </Card>

            <!-- Actions -->
            <div class="flex items-center justify-between border-t border-border pt-6">
                <Button variant="outline" as-child>
                    <Link :href="route('universidades.index')">
                        <Icon icon="mdi-arrow-left" class="mr-2 h-4 w-4" />
                        Volver a Universidades
                    </Link>
                </Button>

                <div class="flex items-center gap-2">
                    <Button variant="outline" as-child>
                        <Link :href="route('universidades.edit', universidad.id)">
                            <Icon icon="mdi:pencil" class="mr-2 h-4 w-4" />
                            Editar Universidad
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
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Label } from '@/components/ui/label';
import { Separator } from '@/components/ui/separator';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { Icon } from '@iconify/vue';
import { Link, router } from '@inertiajs/vue3';
import { toast } from 'vue-sonner';

interface Especialidad {
    id: number;
    nombre: string;
    descripcion: string | null;
}

interface Universidad {
    id: number;
    nombre: string;
    sigla: string | null;
    direccion: string | null;
    especialidades: Especialidad[];
}

interface Props {
    universidad: Universidad;
}

const props = defineProps<Props>();

// Methods
const deleteUniversidad = () => {
    router.delete(route('universidades.destroy', props.universidad.id), {
        onSuccess: () => {
            toast.success('Universidad eliminada exitosamente');
        },
        onError: (errors) => {
            const errorMessage = errors.universidad || 'Error al eliminar la universidad';
            toast.error(errorMessage);
        },
    });
};
</script>