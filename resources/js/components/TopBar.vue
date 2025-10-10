<script setup lang="ts">
import { Separator } from '@/components/ui/separator';
import { SidebarTrigger } from '@/components/ui/sidebar';
import BreadcrumbManager from '@/components/BreadcrumbManager.vue';
import ThemeToggleButton from '@/components/ThemeToggleButton.vue';
</script>

<template>
    <header class="sticky top-0 z-50 flex h-12 items-center justify-between border-b border-border bg-background/95 backdrop-blur supports-[backdrop-filter]:bg-background/60 px-4">
        <!-- Left section: Sidebar trigger + Breadcrumb -->
        <div class="flex items-center gap-3">
            <!-- Sidebar trigger -->
            <SidebarTrigger class="h-7 w-7" />
            
            <!-- Separator -->
            <Separator orientation="vertical" class="h-3" />
            
            <!-- Breadcrumb navigation automática -->
            <BreadcrumbManager />
        </div>

        <!-- Right section: Theme toggle -->
        <div class="flex items-center gap-2">
            <ThemeToggleButton />
        </div>
    </header>
</template>
