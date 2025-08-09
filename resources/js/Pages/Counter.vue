<template>
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        <div class="container mx-auto px-4 py-8">
            <div class="max-w-md mx-auto bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8">
                <h1 class="text-3xl font-bold text-center mb-8 text-gray-800 dark:text-white">
                    Contador con Inertia.js + Vue
                </h1>
                
                <div class="text-center">
                    <div class="text-6xl font-bold text-blue-600 dark:text-blue-400 mb-6">
                        {{ count }}
                    </div>
                    
                    <div class="space-x-4">
                        <button 
                            @click="decrement"
                            class="px-6 py-3 bg-red-500 hover:bg-red-600 text-white font-semibold rounded-lg transition-colors duration-200"
                            :class="{ 'opacity-50 cursor-not-allowed': count <= 0 }"
                            :disabled="count <= 0"
                        >
                            -
                        </button>
                        
                        <button 
                            @click="increment"
                            class="px-6 py-3 bg-green-500 hover:bg-green-600 text-white font-semibold rounded-lg transition-colors duration-200"
                        >
                            +
                        </button>
                    </div>
                    
                    <div class="mt-6">
                        <button 
                            @click="reset"
                            class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition-colors duration-200 mr-4"
                        >
                            Reiniciar
                        </button>
                        
                        <button 
                            @click="goToLogin"
                            class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition-colors duration-200"
                        >
                            Ir al Login (con Ziggy)
                        </button>
                    </div>
                </div>
                
                <div class="mt-8 text-center text-sm text-gray-600 dark:text-gray-400">
                    <p>🎉 ¡Inertia.js funcionando correctamente con Vue 3!</p>
                    <p class="mt-2">
                        <strong>Valor inicial:</strong> {{ initialCount }} | 
                        <strong>Actual:</strong> {{ count }}
                    </p>
                </div>
                
                <!-- Toggle tema -->
                <div class="mt-6 text-center">
                    <button 
                        id="theme-toggle"
                        @click="toggleTheme"
                        class="px-4 py-2 bg-purple-500 hover:bg-purple-600 text-white rounded-lg transition-colors duration-200"
                        :title="themeTitle"
                    >
                        {{ isDark ? '☀️' : '🌙' }} {{ isDark ? 'Tema Claro' : 'Tema Oscuro' }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { Head } from '@inertiajs/vue3'

// Props del servidor
const props = defineProps({
    initialCount: {
        type: Number,
        default: 0
    }
})

// Estado reactivo
const count = ref(props.initialCount)
const isDark = ref(false)

// Computed properties
const themeTitle = computed(() => 
    isDark.value ? 'Cambiar a tema claro' : 'Cambiar a tema oscuro'
)

// Métodos del contador
const increment = () => {
    count.value++
}

const decrement = () => {
    if (count.value > 0) {
        count.value--
    }
}

const reset = () => {
    count.value = props.initialCount
}

// Método para toggle del tema
const toggleTheme = () => {
    const newTheme = isDark.value ? 'light' : 'dark'
    
    if (newTheme === 'dark') {
        document.documentElement.classList.add('dark')
    } else {
        document.documentElement.classList.remove('dark')
    }
    
    localStorage.setItem('theme', newTheme)
    isDark.value = !isDark.value
}

// Método que usa Ziggy para navegar
const goToLogin = () => {
    // Usando Ziggy para generar la URL de la ruta nombrada 'login'
    const loginUrl = route('login')
    window.location.href = loginUrl
}

// Inicialización del tema
onMounted(() => {
    const theme = localStorage.getItem('theme') || 
                  (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light')
    isDark.value = theme === 'dark'
})
</script>
