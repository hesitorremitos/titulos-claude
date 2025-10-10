<script setup lang="ts">
import ThemeToggleButton from '@/components/ThemeToggleButton.vue';

interface Props {
    title?: string;
}
withDefaults(defineProps<Props>(), { title: 'Sistema de Títulos UATF' });
</script>

<template>
    <div class="flex min-h-screen flex-col items-center bg-gradient-to-b from-background via-background/95 to-background px-4 py-10 text-foreground sm:justify-center">
        <div class="mb-6 flex w-full max-w-sm justify-end text-foreground/80">
            <ThemeToggleButton />
        </div>
        <slot />
    </div>
</template>
