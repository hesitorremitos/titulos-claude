<script setup lang="ts">
import AppSidebar from '@/components/AppSidebar.vue';
import ThemeToggle from '@/components/ThemeToggle.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Separator } from '@/components/ui/separator';
import { SidebarInset, SidebarProvider, SidebarTrigger } from '@/components/ui/sidebar';
import { Toaster } from '@/components/ui/sonner';
import { Icon } from '@iconify/vue';
import { Head, router } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

interface NavTab {
    label: string;
    href: string;
    icon: string;
    active?: boolean;
}

interface Props {
    title?: string;
    pageTitle?: string;
    navTabs?: NavTab[];
    showSearch?: boolean;
    searchPlaceholder?: string;
}

const props = defineProps<Props>();

// Search functionality
const searchQuery = ref('');
const selectedFilter = ref('');

// Default nav tabs for the main sections
const defaultNavTabs: NavTab[] = [
    { label: 'Lista', href: '#', icon: 'material-symbols:list', active: true },
    { label: 'Formulario', href: '#', icon: 'material-symbols:edit-document' },
    { label: 'Menciones', href: '#', icon: 'material-symbols:school' },
    { label: 'Modalidades', href: '#', icon: 'material-symbols:category' },
];

const currentNavTabs = computed(() => props.navTabs || defaultNavTabs);

const handleSearch = () => {
    console.log('Searching for:', searchQuery.value, 'with filter:', selectedFilter.value);
};

const handleRefresh = () => {
    router.reload();
};
</script>

<template>
    <div class="dark min-h-screen bg-background">
        <Head :title="title" />

        <SidebarProvider>
            <AppSidebar />
            <SidebarInset>
                <!-- Header superior con título de página -->
                <header class="border-b border-border bg-card">
                    <!-- Primera fila: Trigger, título y user profile -->
                    <div class="flex h-16 items-center gap-4 px-6">
                        <SidebarTrigger class="-ml-1 text-muted-foreground hover:text-foreground" />
                        <Separator orientation="vertical" class="h-4" />
                        
                        <!-- Título de la página -->
                        <div class="flex items-center gap-2">
                            <h1 class="text-xl font-semibold text-foreground">
                                {{ pageTitle || title || 'UATF Títulos' }}
                            </h1>
                        </div>

                        <!-- User Profile y Theme Toggle al final -->
                        <div class="ml-auto flex items-center gap-3">
                            <ThemeToggle />
                            <!-- User Profile Button -->
                            <div class="flex items-center gap-2">
                                <div class="h-8 w-8 rounded-full bg-secondary flex items-center justify-center">
                                    <Icon icon="material-symbols:person" class="h-4 w-4 text-secondary-foreground" />
                                </div>
                                <div class="hidden sm:block">
                                    <p class="text-sm font-medium text-foreground">Administrador</p>
                                    <p class="text-xs text-muted-foreground">Administrador</p>
                                </div>
                                <Icon icon="material-symbols:keyboard-arrow-down" class="h-4 w-4 text-muted-foreground" />
                            </div>
                        </div>
                    </div>

                    <!-- Segunda fila: Navegación por tabs -->
                    <div v-if="navTabs" class="border-t border-border">
                        <nav class="flex px-6">
                            <div class="flex space-x-8">
                                <button
                                    v-for="tab in currentNavTabs"
                                    :key="tab.label"
                                    :class="[
                                        'flex items-center gap-2 border-b-2 px-1 py-3 text-sm font-medium transition-colors',
                                        tab.active
                                            ? 'border-primary text-primary'
                                            : 'border-transparent text-muted-foreground hover:border-accent hover:text-foreground'
                                    ]"
                                    @click="router.visit(tab.href)"
                                >
                                    <Icon :icon="tab.icon" class="h-4 w-4" />
                                    {{ tab.label }}
                                </button>
                            </div>
                        </nav>
                    </div>

                    <!-- Tercera fila: Búsqueda y filtros (opcional) -->
                    <div v-if="showSearch" class="border-t border-border px-6 py-4">
                        <div class="flex items-center gap-4">
                            <!-- Barra de búsqueda -->
                            <div class="relative flex-1 max-w-lg">
                                <Icon 
                                    icon="material-symbols:search" 
                                    class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-muted-foreground" 
                                />
                                <Input
                                    v-model="searchQuery"
                                    :placeholder="searchPlaceholder || 'Buscar por CI, nombre o apellidos...'"
                                    class="pl-10 h-10"
                                    @keyup.enter="handleSearch"
                                />
                            </div>

                            <!-- Filtro de selección -->
                            <Select v-model="selectedFilter">
                                <SelectTrigger class="w-56 h-10">
                                    <SelectValue placeholder="Seleccione una opción..." />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectItem value="all">
                                        Todas las opciones
                                    </SelectItem>
                                    <SelectItem value="active">
                                        Activos
                                    </SelectItem>
                                    <SelectItem value="inactive">
                                        Inactivos
                                    </SelectItem>
                                </SelectContent>
                            </Select>

                            <!-- Botones de acción -->
                            <Button 
                                @click="handleSearch"
                                class="h-10 px-4"
                            >
                                <Icon icon="material-symbols:search" class="mr-2 h-4 w-4" />
                                Buscar
                            </Button>
                            
                            <Button 
                                @click="handleRefresh"
                                variant="outline"
                                class="h-10"
                            >
                                <Icon icon="material-symbols:refresh" class="h-4 w-4" />
                            </Button>
                        </div>
                    </div>
                </header>

                <!-- Contenido principal -->
                <main class="flex-1 bg-background">
                    <div class="p-6">
                        <slot />
                    </div>
                </main>
            </SidebarInset>
        </SidebarProvider>

        <!-- Toast notifications -->
        <Toaster position="bottom-right" :duration="4000" :close-button="true" :rich-colors="true" />
    </div>
</template>
