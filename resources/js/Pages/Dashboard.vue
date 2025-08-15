<script setup lang="ts">
import AppLayout from '@/Layouts/AppLayout.vue';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Icon } from '@iconify/vue';

interface Props {
    stats: {
        facultades: number;
        carreras: number;
        diplomasEsteMes: number;
    };
    user: {
        name: string;
        role: string;
    };
}

defineProps<Props>();
</script>

<template>
    <AppLayout 
        title="Dashboard"
        :breadcrumbs="[{ label: 'Dashboard', href: null }]"
    >
        <div class="mx-auto max-w-7xl space-y-8">
            <!-- Card de Bienvenida -->
            <Card class="col-span-full">
                <CardHeader class="border-b">
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0">
                            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-secondary">
                                <Icon icon="material-symbols:person" class="h-6 w-6 text-secondary-foreground" />
                            </div>
                        </div>
                        <div>
                            <CardTitle class="text-xl"> ¡Bienvenido, {{ user.name }}! </CardTitle>
                            <CardDescription> Sistema de Gestión de Títulos Académicos - UATF </CardDescription>
                        </div>
                    </div>
                </CardHeader>
                <CardContent class="pt-6">
                    <p class="text-muted-foreground">
                        Desde este panel podrás gestionar las facultades y carreras de la Universidad Autónoma Tomás Frías.
                    </p>
                </CardContent>
            </Card>

            <!-- Estadísticas Rápidas -->
            <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                <!-- Total Facultades -->
                <Card>
                    <CardContent class="p-6">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <div class="flex h-8 w-8 items-center justify-center rounded-full bg-secondary">
                                    <Icon icon="material-symbols:account-balance" class="h-4 w-4 text-secondary-foreground" />
                                </div>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-muted-foreground">Total Facultades</p>
                                <p class="text-2xl font-semibold text-foreground">{{ stats.facultades }}</p>
                            </div>
                        </div>
                    </CardContent>
                </Card>

                <!-- Total Carreras -->
                <Card>
                    <CardContent class="p-6">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <div class="flex h-8 w-8 items-center justify-center rounded-full bg-accent">
                                    <Icon icon="material-symbols:school" class="h-4 w-4 text-accent-foreground" />
                                </div>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-muted-foreground">Total Carreras</p>
                                <p class="text-2xl font-semibold text-foreground">{{ stats.carreras }}</p>
                            </div>
                        </div>
                    </CardContent>
                </Card>

                <!-- Diplomas Este Mes -->
                <Card>
                    <CardContent class="p-6">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <div class="flex h-8 w-8 items-center justify-center rounded-full bg-primary">
                                    <Icon icon="material-symbols:calendar-month" class="h-4 w-4 text-primary-foreground" />
                                </div>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-muted-foreground">Este Mes</p>
                                <p class="text-2xl font-semibold text-foreground">{{ stats.diplomasEsteMes }}</p>
                            </div>
                        </div>
                    </CardContent>
                </Card>
            </div>

            <!-- Acciones Rápidas -->
            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                <Card class="group cursor-pointer transition-shadow hover:shadow-lg">
                    <CardContent class="p-6">
                        <div class="flex items-center space-x-4">
                            <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-primary">
                                <Icon icon="material-symbols:school" class="h-6 w-6 text-primary-foreground" />
                            </div>
                            <div class="flex-1">
                                <CardTitle class="text-sm font-medium"> Diplomas Académicos </CardTitle>
                                <CardDescription class="text-xs"> Gestionar títulos académicos </CardDescription>
                            </div>
                        </div>
                    </CardContent>
                </Card>

                <Card class="group cursor-pointer transition-shadow hover:shadow-lg">
                    <CardContent class="p-6">
                        <div class="flex items-center space-x-4">
                            <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-secondary">
                                <Icon icon="material-symbols:account-balance" class="h-6 w-6 text-secondary-foreground" />
                            </div>
                            <div class="flex-1">
                                <CardTitle class="text-sm font-medium"> Gestionar Facultades </CardTitle>
                                <CardDescription class="text-xs"> Ver y administrar facultades </CardDescription>
                            </div>
                        </div>
                    </CardContent>
                </Card>

                <Card class="group cursor-pointer transition-shadow hover:shadow-lg">
                    <CardContent class="p-6">
                        <div class="flex items-center space-x-4">
                            <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-accent">
                                <Icon icon="material-symbols:school" class="h-6 w-6 text-accent-foreground" />
                            </div>
                            <div class="flex-1">
                                <CardTitle class="text-sm font-medium"> Gestionar Carreras </CardTitle>
                                <CardDescription class="text-xs"> Ver y administrar carreras </CardDescription>
                            </div>
                        </div>
                    </CardContent>
                </Card>
            </div>
        </div>
    </AppLayout>
</template>
