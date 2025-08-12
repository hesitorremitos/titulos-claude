<script setup lang="ts">
import AppSidebar from '@/components/AppSidebar.vue';
import ThemeToggle from '@/components/ThemeToggle.vue';
import { Separator } from '@/components/ui/separator';
import { SidebarInset, SidebarProvider, SidebarTrigger } from '@/components/ui/sidebar';
import { Tabs, TabsList, TabsTrigger } from '@/components/ui/tabs';
import { Toaster } from '@/components/ui/sonner';
import { Icon } from '@iconify/vue';
import { Head, router } from '@inertiajs/vue3';
import { useColorMode } from '@vueuse/core';
import { computed } from 'vue';


interface NavTab {
    label: string;
    href: string;
    icon: string;
    value: string;
}

interface Props {
    title?: string;
    pageTitle?: string;
    navTabs?: NavTab[];
    activeTab?: string;
}

const props = defineProps<Props>();

// Color mode management
const mode = useColorMode();

const currentNavTabs = computed(() => props.navTabs || []);
const currentActiveTab = computed(() => props.activeTab || (currentNavTabs.value.length > 0 ? currentNavTabs.value[0].value : ''));
</script>

<template>
    <div :class="[mode === 'dark' ? 'dark' : '', 'min-h-screen bg-background transition-colors duration-200']">
        <Head :title="title" />

        <SidebarProvider>
            <AppSidebar />
            <SidebarInset>
                <!-- Header superior unificado con diseño cohesivo -->
                <header class="border-b border-border/40 bg-card shadow-sm backdrop-blur-sm">
                    <!-- Primera fila: Trigger, título y user profile -->
                    <div class="flex h-16 items-center gap-4 px-6 border-b border-border/20 bg-card">
                        <SidebarTrigger class="-ml-1 text-muted-foreground hover:text-foreground transition-colors duration-200" />
                        <Separator orientation="vertical" class="h-4" />
                        
                        <!-- Título de la página -->
                        <div class="flex items-center gap-2">
                            <h1 class="text-lg font-semibold text-foreground">
                                {{ pageTitle || title || 'UATF Títulos' }}
                            </h1>
                        </div>

                        <!-- User Profile y Theme Toggle al final -->
                        <div class="ml-auto flex items-center gap-3">
                            <ThemeToggle />
                        </div>
                    </div>
                    
                    <!-- Navegación por tabs usando shadcn -->
                    <div v-if="navTabs && navTabs.length > 0" class="border-b border-border/30 bg-gradient-to-r from-card via-card/90 to-card/80">
                        <div class="px-6 py-4">
                            <Tabs :model-value="currentActiveTab" class="w-full">
                                <TabsList class="bg-muted/50 h-11 p-1 w-fit">
                                    <TabsTrigger 
                                        v-for="tab in currentNavTabs"
                                        :key="tab.value"
                                        :value="tab.value"
                                        class="flex items-center gap-2 px-4 py-2 text-sm font-medium transition-all duration-200 data-[state=active]:bg-background data-[state=active]:text-foreground data-[state=active]:shadow-sm hover:bg-muted/80"
                                        @click="router.visit(tab.href)"
                                    >
                                        <Icon 
                                            :icon="tab.icon" 
                                            class="h-4 w-4 transition-colors" 
                                        />
                                        <span class="font-medium">{{ tab.label }}</span>
                                    </TabsTrigger>
                                </TabsList>
                            </Tabs>
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
