<script setup lang="ts">

interface Props {
    title?: string;
}
withDefaults(defineProps<Props>(), { title: 'Sistema de Títulos UATF' });
</script>

<template>
    <div class="flex min-h-screen flex-col items-center bg-background px-4 py-8 text-foreground sm:justify-center">
        <slot />
    </div>
</template>
