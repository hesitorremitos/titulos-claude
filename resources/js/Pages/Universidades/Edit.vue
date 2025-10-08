<template>
    <AppLayout :title="`Editar ${universidad.nombre}`">
        <div class="space-y-6">
            <!-- Header -->
            <div class="border-b border-border pb-4">
                <h1 class="text-2xl font-bold tracking-tight">Editar Universidad</h1>
                <p class="text-muted-foreground">Modifica la información de "{{ universidad.nombre }}"</p>
            </div>

            <!-- Form -->
            <div class="max-w-2xl">
                <Card>
                    <CardHeader>
                        <CardTitle>Información de la Universidad</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <form @submit.prevent="submit" class="space-y-6">
                            <!-- Nombre -->
                            <div class="space-y-2">
                                <Label for="nombre"> Nombre de la Universidad * </Label>
                                <Input
                                    id="nombre"
                                    v-model="form.nombre"
                                    type="text"
                                    placeholder="Universidad Mayor de San Andrés"
                                    :class="{ 'border-destructive': props.errors.nombre }"
                                    required
                                />
                                <p v-if="props.errors.nombre" class="text-sm text-destructive">
                                    {{ props.errors.nombre }}
                                </p>
                            </div>

                            <!-- Sigla -->
                            <div class="space-y-2">
                                <Label for="sigla"> Sigla </Label>
                                <Input
                                    id="sigla"
                                    v-model="form.sigla"
                                    type="text"
                                    placeholder="UMSA"
                                    maxlength="50"
                                    :class="{ 'border-destructive': props.errors.sigla }"
                                    class="uppercase font-mono"
                                />
                                <p v-if="props.errors.sigla" class="text-sm text-destructive">
                                    {{ props.errors.sigla }}
                                </p>
                            </div>

                            <!-- Actions -->
                            <div class="flex items-center gap-3 pt-4">
                                <Button type="submit" :disabled="processing">
                                    {{ processing ? 'Guardando...' : 'Guardar' }}
                                </Button>
                                <Button variant="outline" type="button" as-child>
                                    <Link :href="route('universidades.show', universidad.id)"> Cancelar </Link>
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
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Link, useForm } from '@inertiajs/vue3';
import { toast } from 'vue-sonner';

interface Universidad {
    id: number;
    nombre: string;
    sigla: string | null;
    direccion: string | null;
}

interface Props {
    universidad: Universidad;
    errors: Record<string, string>;
}

const props = defineProps<Props>();

// Form usando useForm
const form = useForm({
    nombre: props.universidad.nombre,
    sigla: props.universidad.sigla || '',
});

const { processing } = form;

// Methods
const submit = () => {
    // Ensure sigla is uppercase before submitting
    form.sigla = form.sigla.toUpperCase();

    form.put(route('universidades.update', props.universidad.id), {
        onSuccess: () => {
            toast.success('Universidad actualizada exitosamente');
        },
        onError: () => {
            toast.error('Por favor corrige los errores en el formulario');
        },
    });
};
</script>