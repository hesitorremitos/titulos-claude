<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Separator } from '@/components/ui/separator';
import { SidebarTrigger } from '@/components/ui/sidebar';
import BreadcrumbNavigation from '@/components/BreadcrumbNavigation.vue';
import { Moon, Sun } from 'lucide-vue-next';
import { onMounted, ref } from 'vue';
import type { BreadcrumbItem as BreadcrumbItemType } from '@/types';

// Props
interface Props {
    breadcrumbs: BreadcrumbItemType[];
}

const props = defineProps<Props>();

// Theme management
const isDark = ref(false);

// Check current theme on mount
onMounted(() => {
    // Check if theme is already set
    const savedTheme = localStorage.getItem('theme');
    const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    
    isDark.value = savedTheme === 'dark' || (!savedTheme && systemPrefersDark);
    
    // Apply theme to document
    if (isDark.value) {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }
});

// Toggle theme function
const toggleTheme = () => {
    isDark.value = !isDark.value;
    
    if (isDark.value) {
        document.documentElement.classList.add('dark');
        localStorage.setItem('theme', 'dark');
    } else {
        document.documentElement.classList.remove('dark');
        localStorage.setItem('theme', 'light');
    }
};
</script>

<template>
    <header class="sticky top-0 z-50 flex h-12 items-center justify-between border-b border-border bg-background/95 backdrop-blur supports-[backdrop-filter]:bg-background/60 px-4">
        <!-- Left section: Sidebar trigger + Breadcrumb -->
        <div class="flex items-center gap-3">
            <!-- Sidebar trigger -->
            <SidebarTrigger class="h-7 w-7" />
            
            <!-- Separator -->
            <Separator orientation="vertical" class="h-3" />
            
            <!-- Breadcrumb navigation -->
            <BreadcrumbNavigation :items="props.breadcrumbs" />
        </div>

        <!-- Right section: Theme toggle -->
        <div class="flex items-center gap-2">
            <!-- Theme toggle button -->
            <Button
                variant="ghost"
                size="icon"
                class="h-7 w-7 rounded-md transition-colors duration-200 hover:bg-accent hover:text-accent-foreground"
                @click="toggleTheme"
                :aria-label="isDark ? 'Cambiar a tema claro' : 'Cambiar a tema oscuro'"
            >
                <Sun 
                    v-if="isDark" 
                    class="h-3.5 w-3.5 transition-all duration-200 rotate-0 scale-100 dark:-rotate-90 dark:scale-0" 
                />
                <Moon 
                    v-else 
                    class="h-3.5 w-3.5 transition-all duration-200 rotate-90 scale-0 dark:rotate-0 dark:scale-100" 
                />
            </Button>
        </div>
    </header>
</template>