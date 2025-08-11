<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import AppLayout from '@/Layouts/AppLayout.vue';
import { Icon } from '@iconify/vue';
import { Head } from '@inertiajs/vue3';

// Navigation tabs for Diplomas Académicos section
const navTabs = [
    { label: 'Lista', href: '/v2/diplomas-academicos', icon: 'material-symbols:list', active: true },
    { label: 'Formulario', href: '/v2/diplomas-academicos/create', icon: 'material-symbols:edit-document' },
    { label: 'Menciones', href: '/v2/diplomas-academicos/menciones', icon: 'material-symbols:school' },
    { label: 'Modalidades', href: '/v2/diplomas-academicos/modalidades', icon: 'material-symbols:category' },
];
</script>

<template>
    <Head title="Diplomas Académicos" />

    <AppLayout
        title="Diplomas Académicos"
        page-title="Diplomas Académicos"
        :nav-tabs="navTabs"
        :show-search="true"
        search-placeholder="Buscar por CI, nombre o apellidos..."
    >
        <!-- Contenido principal -->
        <div class="space-y-6">
            <!-- Encabezado de la sección -->
            <div class="rounded-lg bg-card border border-border p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-foreground">Lista de Diplomas Académicos</h2>
                        <p class="text-muted-foreground text-sm mt-1">
                            Registro completo de diplomas académicos del sistema
                        </p>
                    </div>
                    <Button>
                        <Icon icon="material-symbols:add" class="mr-2 h-4 w-4" />
                        CREAR PRIMER DIPLOMA
                    </Button>
                </div>
            </div>

            <!-- Estado vacío -->
            <Card>
                <CardContent class="flex flex-col items-center justify-center py-16">
                    <div class="mb-6">
                        <Icon 
                            icon="material-symbols:school" 
                            class="h-16 w-16 text-muted-foreground"
                        />
                    </div>
                    
                    <CardTitle class="text-xl mb-2">
                        No hay diplomas académicos
                    </CardTitle>
                    
                    <CardDescription class="text-center max-w-md">
                        Comienza creando tu primer diploma académico para gestionar los títulos universitarios.
                    </CardDescription>

                    <Button class="mt-6">
                        <Icon icon="material-symbols:add" class="mr-2 h-4 w-4" />
                        CREAR PRIMER DIPLOMA
                    </Button>
                </CardContent>
            </Card>
        </div>
    </AppLayout>
</template>