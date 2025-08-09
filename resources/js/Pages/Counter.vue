<template>
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        <div class="container mx-auto px-4 py-8">
            <div class="mx-auto max-w-md rounded-lg bg-white p-8 shadow-lg dark:bg-gray-800">
                <h1 class="mb-8 text-center text-3xl font-bold text-gray-800 dark:text-white">Contador con Inertia.js + Vue</h1>

                <div class="text-center">
                    <div class="mb-6 text-6xl font-bold text-blue-600 dark:text-blue-400">
                        {{ count }}
                    </div>

                    <div class="space-x-4">
                        <button
                            @click="decrement"
                            class="rounded-lg bg-red-500 px-6 py-3 font-semibold text-white transition-colors duration-200 hover:bg-red-600"
                            :class="{ 'cursor-not-allowed opacity-50': count <= 0 }"
                            :disabled="count <= 0"
                        >
                            -
                        </button>

                        <button
                            @click="increment"
                            class="rounded-lg bg-green-500 px-6 py-3 font-semibold text-white transition-colors duration-200 hover:bg-green-600"
                        >
                            +
                        </button>
                    </div>

                    <div class="mt-6">
                        <button
                            @click="reset"
                            class="mr-4 rounded-lg bg-gray-500 px-4 py-2 text-white transition-colors duration-200 hover:bg-gray-600"
                        >
                            Reiniciar
                        </button>

                        <button
                            @click="goToLogin"
                            class="rounded-lg bg-blue-500 px-4 py-2 text-white transition-colors duration-200 hover:bg-blue-600"
                        >
                            Ir al Login (con Ziggy)
                        </button>
                    </div>
                </div>

                <div class="mt-8 text-center text-sm text-gray-600 dark:text-gray-400">
                    <p>🎉 ¡Inertia.js funcionando correctamente con Vue 3!</p>
                    <p class="mt-2"><strong>Valor inicial:</strong> {{ initialCount }} | <strong>Actual:</strong> {{ count }}</p>
                </div>

                <!-- Toggle tema -->
                <div class="mt-6 text-center">
                    <button
                        id="theme-toggle"
                        @click="toggleTheme"
                        class="rounded-lg bg-purple-500 px-4 py-2 text-white transition-colors duration-200 hover:bg-purple-600"
                        :title="themeTitle"
                    >
                        {{ isDark ? '☀️' : '🌙' }} {{ isDark ? 'Tema Claro' : 'Tema Oscuro' }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { computed, onMounted, ref } from 'vue';

// Props del servidor
const props = defineProps({
    initialCount: {
        type: Number,
        default: 0,
    },
});

// Estado reactivo
const count = ref(props.initialCount);
const isDark = ref(false);

// Computed properties
const themeTitle = computed(() => (isDark.value ? 'Cambiar a tema claro' : 'Cambiar a tema oscuro'));

// Métodos del contador
const increment = () => {
    count.value++;
};

const decrement = () => {
    if (count.value > 0) {
        count.value--;
    }
};

const reset = () => {
    count.value = props.initialCount;
};

// Método para toggle del tema
const toggleTheme = () => {
    const newTheme = isDark.value ? 'light' : 'dark';

    if (newTheme === 'dark') {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }

    localStorage.setItem('theme', newTheme);
    isDark.value = !isDark.value;
};

// Método que usa Ziggy para navegar
const goToLogin = () => {
    // Usando Ziggy para generar la URL de la ruta nombrada 'login'
    const loginUrl = route('login');
    window.location.href = loginUrl;
};

// Inicialización del tema
onMounted(() => {
    const theme = localStorage.getItem('theme') || (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
    isDark.value = theme === 'dark';
});
</script>
