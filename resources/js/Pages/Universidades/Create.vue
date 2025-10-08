<template>
    <AppLayout
        title="Universidades"
        page-title="Universidades"
        :nav-tabs="navTabs"
        active-tab="registrar"
    >
        <div class="space-y-6">
            <!-- Header -->
            <div class="border-b border-border pb-4">
                <h1 class="text-2xl font-bold tracking-tight">Nueva Universidad</h1>
            </div>

            <!-- Form -->
            <div class="max-w-2xl">
                <Card>
                    <CardContent class="pt-6">
                        <form @submit.prevent="submit" class="space-y-6">
                            <!-- Nombre -->
                            <div class="space-y-2">
                                <Label for="nombre"> Nombre * </Label>
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
                                    <Link :href="route('universidades.index')"> Cancelar </Link>
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
import navTabs from './navtabs.json';
import { Button } from '@/components/ui/button';
import { Card, CardContent } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Link, useForm } from '@inertiajs/vue3';
import { toast } from 'vue-sonner';

interface Props {
    errors: Record<string, string>;
}

const props = defineProps<Props>();

// Form usando useForm
const form = useForm({
    nombre: '',
    sigla: '',
});

const { processing } = form;

// Methods
const submit = () => {
    // Ensure sigla is uppercase before submitting
    form.sigla = form.sigla.toUpperCase();

    form.post(route('universidades.store'), {
        onSuccess: () => {
            toast.success('Universidad creada exitosamente');
        },
        onError: () => {
            toast.error('Por favor corrige los errores en el formulario');
        },
    });
};
</script>