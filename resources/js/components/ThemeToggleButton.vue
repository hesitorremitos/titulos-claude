<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { cn } from '@/lib/utils';
import { Moon, Sun } from 'lucide-vue-next';
import { onMounted, ref } from 'vue';

interface Props {
    buttonClass?: string;
}

const props = withDefaults(defineProps<Props>(), {
    buttonClass: '',
});

const isDark = ref(false);

const applyTheme = (dark: boolean) => {
    if (dark) {
        document.documentElement.classList.add('dark');
        localStorage.setItem('theme', 'dark');
    } else {
        document.documentElement.classList.remove('dark');
        localStorage.setItem('theme', 'light');
    }
};

onMounted(() => {
    const savedTheme = localStorage.getItem('theme');
    const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

    isDark.value = savedTheme === 'dark' || (!savedTheme && systemPrefersDark);
    applyTheme(isDark.value);
});

const toggleTheme = () => {
    isDark.value = !isDark.value;
    applyTheme(isDark.value);
};
</script>

<template>
    <Button
        variant="ghost"
        size="icon"
        :class="
            cn(
                'h-7 w-7 rounded-md transition-colors duration-200 hover:bg-accent hover:text-accent-foreground',
                props.buttonClass,
            )
        "
        @click="toggleTheme"
        :aria-label="isDark ? 'Cambiar a tema claro' : 'Cambiar a tema oscuro'"
    >
        <Sun v-if="isDark" class="h-3.5 w-3.5 transition-transform duration-200" />
        <Moon v-else class="h-3.5 w-3.5 transition-transform duration-200" />
    </Button>
</template>
