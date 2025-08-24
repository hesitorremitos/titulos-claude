<script setup lang="ts">
import AppSidebar from '@/components/AppSidebar.vue';
import TopBar from '@/components/TopBar.vue';
import { SidebarInset, SidebarProvider } from '@/components/ui/sidebar';
import { Toaster } from '@/components/ui/sonner';
import { Tabs, TabsList, TabsTrigger } from '@/components/ui/tabs';
import { Icon } from '@iconify/vue';
import { Head, router } from '@inertiajs/vue3';
import { useColorMode } from '@vueuse/core';
import { computed } from 'vue';
import type { NavTab } from '@/types';

interface Props {
    title?: string;
    pageTitle?: string;
    navTabs?: NavTab[];
    activeTab?: string;
}

const props = defineProps<Props>();

// Color mode management
const mode = useColorMode({
  selector: 'html',
  attribute: 'class',
  modes: {
    dark: 'dark',
    light: '',
  },
});

const currentNavTabs = computed(() => props.navTabs || []);
const currentActiveTab = computed(() => props.activeTab || (currentNavTabs.value.length > 0 ? currentNavTabs.value[0].value : ''));
</script>

<template>
    <div class="min-h-screen bg-background transition-colors duration-200">
        <Head :title="title" />

        <SidebarProvider>
            <AppSidebar />
            <SidebarInset>
                <!-- TopBar sin props de breadcrumbs -->
                <TopBar />

                <!-s- Navegación por tabs (opcional) -->
                <div v-if="navTabs && navTabs.length > 0" class="border-b border-border/30 bg-gradient-to-r from-card via-card/90 to-card/80">
                    <div class="px-4 py-1">
                        <Tabs :model-value="currentActiveTab" class="w-full">
                            <TabsList class="h-9 w-fit bg-muted/50 p-1">
                                <TabsTrigger
                                    v-for="tab in currentNavTabs"
                                    :key="tab.value"
                                    :value="tab.value"
                                    class="flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium transition-all duration-200 hover:bg-muted/80 data-[state=active]:bg-background data-[state=active]:text-foreground data-[state=active]:shadow-sm"
                                    @click="tab.href && router.visit(tab.href)"
                                >
                                    <Icon :icon="tab.icon" class="h-3.5 w-3.5 transition-colors" />
                                    <span class="font-medium">{{ tab.label }}</span>
                                </TabsTrigger>
                            </TabsList>
                        </Tabs>
                    </div>
                </div>

                <!-- Contenido principal -->
                <main class="flex-1 bg-background">
                    <div class="p-4">
                        <slot />
                    </div>
                </main>
            </SidebarInset>
        </SidebarProvider>

        <!-- Toast notifications -->
        <Toaster position="bottom-right" :duration="4000" :close-button="true" :rich-colors="true" />
    </div>
</template>
