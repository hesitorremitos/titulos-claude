<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import AppLayout from '@/Layouts/AppLayout.vue';
import { Icon } from '@iconify/vue';
import { Head } from '@inertiajs/vue3';

// Navigation tabs for Diplomas Académicos section - Solo Lista y Registrar
const navTabs = [
    { label: 'Lista', href: '/v2/diplomas-academicos', icon: 'material-symbols:list', value: 'lista' },
    { label: 'Registrar', href: '/v2/diplomas-academicos/create', icon: 'material-symbols:add', value: 'registrar' },
];

// Breadcrumbs for navigation
const breadcrumbs = [
    { label: 'Diplomas Académicos' }
];
</script>

<template>
    <Head title="Diplomas Académicos" />

    <AppLayout
        title="Diplomas Académicos"
        page-title="Diplomas Académicos"
        :breadcrumbs="breadcrumbs"
        :nav-tabs="navTabs"
        active-tab="lista"
        :show-search="true"
        search-placeholder="Buscar por CI, nombre o apellidos..."
    >
        <!-- Contenido principal -->
        <div class="space-y-6">

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

                    <Button class="mt-6" @click="$inertia.visit('/v2/diplomas-academicos/create')">
                        <Icon icon="material-symbols:add" class="mr-2 h-4 w-4" />
                        CREAR PRIMER DIPLOMA
                    </Button>
                </CardContent>
            </Card>
        </div>
    </AppLayout>
</template>