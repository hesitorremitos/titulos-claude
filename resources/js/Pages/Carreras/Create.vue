<template>
    <AppLayout title="Crear Carrera" page-title="Carreras" :nav-tabs="navTabs" active-tab="registrar">
        <div class="space-y-6">
            <!-- Header -->
            <div class="border-b border-border pb-4">
                <h1 class="text-2xl font-bold tracking-tight">Nueva Carrera</h1>
            </div>

            <!-- Form -->
            <div class="max-w-2xl">
                <Card>
                    <CardContent class="pt-6">
                        <form @submit.prevent="submit" class="space-y-6">
                            <!-- Código -->
                            <div class="space-y-2">
                                <Label for="id"> Código * </Label>
                                <Input
                                    id="id"
                                    v-model="form.id"
                                    type="text"
                                    placeholder="ING01"
                                    maxlength="5"
                                    :class="{ 'border-destructive': props.errors.id }"
                                    class="font-mono uppercase"
                                    required
                                />
                                <p v-if="props.errors.id" class="text-sm text-destructive">
                                    {{ props.errors.id }}
                                </p>
                            </div>

                            <!-- Programa -->
                            <div class="space-y-2">
                                <Label for="programa"> Programa * </Label>
                                <Input
                                    id="programa"
                                    v-model="form.programa"
                                    type="text"
                                    placeholder="Ingeniería de Sistemas"
                                    :class="{ 'border-destructive': props.errors.programa }"
                                    required
                                />
                                <p v-if="props.errors.programa" class="text-sm text-destructive">
                                    {{ props.errors.programa }}
                                </p>
                            </div>

                            <!-- Facultad -->
                            <div class="space-y-2">
                                <Label for="facultad_id"> Facultad * </Label>
                                <Select v-model="form.facultad_id" required>
                                    <SelectTrigger :class="{ 'border-destructive': props.errors.facultad_id }">
                                        <SelectValue placeholder="Selecciona una facultad" />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectItem v-for="facultad in facultades" :key="facultad.id" :value="facultad.id.toString()">
                                            {{ facultad.nombre }}
                                        </SelectItem>
                                    </SelectContent>
                                </Select>
                                <p v-if="props.errors.facultad_id" class="text-sm text-destructive">
                                    {{ props.errors.facultad_id }}
                                </p>
                            </div>

                            <!-- Dirección -->
                            <div class="space-y-2">
                                <Label for="direccion"> Dirección </Label>
                                <Input
                                    id="direccion"
                                    v-model="form.direccion"
                                    type="text"
                                    placeholder="Edificio Central, Piso 2"
                                    :class="{ 'border-destructive': props.errors.direccion }"
                                />
                                <p v-if="props.errors.direccion" class="text-sm text-destructive">
                                    {{ props.errors.direccion }}
                                </p>
                            </div>

                            <!-- Actions -->
                            <div class="flex items-center gap-3 pt-4">
                                <Button type="submit" :disabled="processing">
                                    {{ processing ? 'Guardando...' : 'Guardar' }}
                                </Button>
                                <Button variant="outline" type="button" as-child>
                                    <Link :href="route('v2.carreras.index')"> Cancelar </Link>
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
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Link, useForm } from '@inertiajs/vue3';
import { toast } from 'vue-sonner';

interface Facultad {
    id: number;
    nombre: string;
    direccion: string | null;
}

interface Props {
    facultades: Facultad[];
    facultadSeleccionada?: string;
    errors: Record<string, string>;
}

const props = defineProps<Props>();

// Navigation tabs - Solo Lista y Registrar
const navTabs = [
    { label: 'Lista', href: '/v2/carreras', icon: 'lucide:list-checks', value: 'lista' },
    { label: 'Registrar', href: '/v2/carreras/create', icon: 'lucide:plus-circle', value: 'registrar' },
];

// Form usando useForm
const form = useForm({
    id: '',
    programa: '',
    direccion: '',
    facultad_id: props.facultadSeleccionada || '',
});

const { processing } = form;

// Methods
const submit = () => {
    // Ensure ID is uppercase before submitting
    form.id = form.id.toUpperCase();

    form.post(route('v2.carreras.store'), {
        onSuccess: () => {
            toast.success('Carrera creada exitosamente');
        },
        onError: () => {
            toast.error('Por favor corrige los errores en el formulario');
        },
    });
};
</script>
