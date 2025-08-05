<!DOCTYPE html>
<html lang="es" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Guía de Estilos - Sistema de Títulos UATF</title>
    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- No external PDF library needed - using native browser viewer -->
</head>
<body class="bg-gray-50 dark:bg-gray-900 font-sans antialiased min-h-full">
    <div class="min-h-screen">
        <!-- Header -->
        <header class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="py-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                                Guía de Estilos
                            </h1>
                            <p class="text-gray-600 dark:text-gray-400 mt-1">
                                Sistema de Títulos - Universidad Autónoma Tomás Frías
                            </p>
                        </div>
                        <div class="flex space-x-3">
                            <a href="/login" class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-md font-medium text-sm text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors">
                                <span class="icon-[mdi--login] w-4 h-4 mr-2"></span>
                                Acceder al Sistema
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Navigation -->
        <nav class="bg-gray-100 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 sticky top-0 z-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between py-3">
                    <div class="flex space-x-6 flex-wrap gap-y-2">
                        <a href="#colors" class="whitespace-nowrap text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400">Colores</a>
                        <a href="#typography" class="whitespace-nowrap text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400">Tipografía</a>
                        <a href="#buttons" class="whitespace-nowrap text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400">Botones</a>
                        <a href="#forms" class="whitespace-nowrap text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400">Formularios</a>
                        <a href="#dashboard" class="whitespace-nowrap text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400">Dashboard</a>
                        <a href="#complete-form" class="whitespace-nowrap text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400">Formulario Completo</a>
                        <a href="#cards" class="whitespace-nowrap text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400">Cards</a>
                        <a href="#navigation" class="whitespace-nowrap text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400">Navegación</a>
                        <a href="#icons" class="whitespace-nowrap text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400">Iconos</a>
                        <a href="#toasts" class="whitespace-nowrap text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400">Notificaciones Toast</a>
                    <a href="#searchable-select" class="whitespace-nowrap text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400">Select Buscable</a>
                    <a href="#pdf-viewer" class="whitespace-nowrap text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400">Visor PDF</a>
                    <a href="#feedback" class="whitespace-nowrap text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400">Feedback</a>
                    </div>
                    
                    <!-- Dark Mode Toggle with Alpine.js -->
                    <div x-data="darkModeToggle()" class="ml-4">
                        <button @click="toggle()" 
                                class="flex items-center justify-center p-2 bg-gray-200 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-300 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-primary-500 transition-colors"
                                :aria-label="isDark ? 'Cambiar a modo claro' : 'Cambiar a modo oscuro'">
                            <span :class="isDark ? 'icon-[mdi--weather-night] w-5 h-5' : 'icon-[mdi--weather-sunny] w-5 h-5'" aria-hidden="true"></span>
                        </button>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Paleta de Colores -->
            <section id="colors" class="mb-16">
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Paleta de Colores</h2>
                    <p class="text-gray-600 dark:text-gray-400">Sistema de colores unificado para la Universidad Autónoma Tomás Frías</p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                    <!-- Colores Primarios -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Colores Primarios (Rojo UATF)</h3>
                        <div class="grid grid-cols-3 gap-3">
                            <div class="text-center">
                                <div class="w-full h-16 bg-primary-50 rounded-lg border mb-2"></div>
                                <p class="text-xs font-mono text-gray-900 dark:text-white">primary-50</p>
                            </div>
                            <div class="text-center">
                                <div class="w-full h-16 bg-primary-100 rounded-lg border mb-2"></div>
                                <p class="text-xs font-mono text-gray-900 dark:text-white">primary-100</p>
                            </div>
                            <div class="text-center">
                                <div class="w-full h-16 bg-primary-200 rounded-lg border mb-2"></div>
                                <p class="text-xs font-mono text-gray-900 dark:text-white">primary-200</p>
                            </div>
                            <div class="text-center">
                                <div class="w-full h-16 bg-primary-500 rounded-lg mb-2"></div>
                                <p class="text-xs font-mono text-white">primary-500</p>
                            </div>
                            <div class="text-center">
                                <div class="w-full h-16 bg-primary-600 rounded-lg mb-2"></div>
                                <p class="text-xs font-mono text-white">primary-600</p>
                            </div>
                            <div class="text-center">
                                <div class="w-full h-16 bg-primary-700 rounded-lg mb-2"></div>
                                <p class="text-xs font-mono text-white">primary-700</p>
                            </div>
                        </div>
                    </div>

                    <!-- Colores Secundarios -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Colores Secundarios (Azul UATF)</h3>
                        <div class="grid grid-cols-3 gap-3">
                            <div class="text-center">
                                <div class="w-full h-16 bg-secondary-50 rounded-lg border mb-2"></div>
                                <p class="text-xs font-mono text-gray-900 dark:text-white">secondary-50</p>
                            </div>
                            <div class="text-center">
                                <div class="w-full h-16 bg-secondary-100 rounded-lg border mb-2"></div>
                                <p class="text-xs font-mono text-gray-900 dark:text-white">secondary-100</p>
                            </div>
                            <div class="text-center">
                                <div class="w-full h-16 bg-secondary-200 rounded-lg border mb-2"></div>
                                <p class="text-xs font-mono text-gray-900 dark:text-white">secondary-200</p>
                            </div>
                            <div class="text-center">
                                <div class="w-full h-16 bg-secondary-500 rounded-lg mb-2"></div>
                                <p class="text-xs font-mono text-white">secondary-500</p>
                            </div>
                            <div class="text-center">
                                <div class="w-full h-16 bg-secondary-600 rounded-lg mb-2"></div>
                                <p class="text-xs font-mono text-white">secondary-600</p>
                            </div>
                            <div class="text-center">
                                <div class="w-full h-16 bg-secondary-700 rounded-lg mb-2"></div>
                                <p class="text-xs font-mono text-white">secondary-700</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                    <!-- Colores Neutros -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Colores Neutros</h3>
                        <div class="grid grid-cols-3 gap-3">
                            <div class="text-center">
                                <div class="w-full h-16 bg-gray-50 rounded-lg border mb-2"></div>
                                <p class="text-xs font-mono text-gray-900 dark:text-white">gray-50</p>
                            </div>
                            <div class="text-center">
                                <div class="w-full h-16 bg-gray-200 rounded-lg border mb-2"></div>
                                <p class="text-xs font-mono text-gray-900 dark:text-white">gray-200</p>
                            </div>
                            <div class="text-center">
                                <div class="w-full h-16 bg-gray-300 rounded-lg border mb-2"></div>
                                <p class="text-xs font-mono text-gray-900 dark:text-white">gray-300</p>
                            </div>
                            <div class="text-center">
                                <div class="w-full h-16 bg-gray-600 rounded-lg mb-2"></div>
                                <p class="text-xs font-mono text-white">gray-600</p>
                            </div>
                            <div class="text-center">
                                <div class="w-full h-16 bg-gray-700 rounded-lg mb-2"></div>
                                <p class="text-xs font-mono text-white">gray-700</p>
                            </div>
                            <div class="text-center">
                                <div class="w-full h-16 bg-gray-800 rounded-lg mb-2"></div>
                                <p class="text-xs font-mono text-white">gray-800</p>
                            </div>
                        </div>
                    </div>

                    <!-- Combinación de Colores UATF -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Combinación UATF</h3>
                        <div class="space-y-3">
                            <div class="flex h-12 rounded-lg overflow-hidden">
                                <div class="flex-1 bg-primary-600 flex items-center justify-center">
                                    <p class="text-white text-sm font-medium">Rojo Primario</p>
                                </div>
                                <div class="flex-1 bg-secondary-600 flex items-center justify-center">
                                    <p class="text-white text-sm font-medium">Azul Secundario</p>
                                </div>
                            </div>
                            <div class="text-center text-sm text-gray-600 dark:text-gray-400">
                                Combinación oficial Universidad Autónoma Tomás Frías
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Colores Semánticos -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Colores Semánticos</h3>
                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                        <div class="text-center">
                            <div class="w-full h-16 bg-success-500 rounded-lg mb-2"></div>
                            <p class="text-xs font-mono text-gray-900 dark:text-white">Success (success-500)</p>
                        </div>
                        <div class="text-center">
                            <div class="w-full h-16 bg-warning-500 rounded-lg mb-2"></div>
                            <p class="text-xs font-mono text-gray-900 dark:text-white">Warning (warning-500)</p>
                        </div>
                        <div class="text-center">
                            <div class="w-full h-16 bg-error-500 rounded-lg mb-2"></div>
                            <p class="text-xs font-mono text-gray-900 dark:text-white">Error (error-500)</p>
                        </div>
                        <div class="text-center">
                            <div class="w-full h-16 bg-info-500 rounded-lg mb-2"></div>
                            <p class="text-xs font-mono text-gray-900 dark:text-white">Info (info-500)</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Tipografía -->
            <section id="typography" class="mb-16">
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Tipografía</h2>
                    <p class="text-gray-600 dark:text-gray-400">Escala tipográfica y jerarquía de texto</p>
                </div>

                <div class="space-y-6">
                    <div class="flex items-center space-x-6">
                        <div class="w-20 text-sm text-gray-500 dark:text-gray-400 font-mono">text-xs</div>
                        <div class="text-xs text-gray-900 dark:text-white">The quick brown fox jumps over the lazy dog</div>
                    </div>
                    <div class="flex items-center space-x-6">
                        <div class="w-20 text-sm text-gray-500 dark:text-gray-400 font-mono">text-sm</div>
                        <div class="text-sm text-gray-900 dark:text-white">The quick brown fox jumps over the lazy dog</div>
                    </div>
                    <div class="flex items-center space-x-6">
                        <div class="w-20 text-sm text-gray-500 dark:text-gray-400 font-mono">text-base</div>
                        <div class="text-base text-gray-900 dark:text-white">The quick brown fox jumps over the lazy dog</div>
                    </div>
                    <div class="flex items-center space-x-6">
                        <div class="w-20 text-sm text-gray-500 dark:text-gray-400 font-mono">text-lg</div>
                        <div class="text-lg text-gray-900 dark:text-white">The quick brown fox jumps over the lazy dog</div>
                    </div>
                    <div class="flex items-center space-x-6">
                        <div class="w-20 text-sm text-gray-500 dark:text-gray-400 font-mono">text-xl</div>
                        <div class="text-xl text-gray-900 dark:text-white">The quick brown fox jumps over the lazy dog</div>
                    </div>
                    <div class="flex items-center space-x-6">
                        <div class="w-20 text-sm text-gray-500 dark:text-gray-400 font-mono">text-2xl</div>
                        <div class="text-2xl text-gray-900 dark:text-white">The quick brown fox jumps over the lazy dog</div>
                    </div>
                    <div class="flex items-center space-x-6">
                        <div class="w-20 text-sm text-gray-500 dark:text-gray-400 font-mono">text-3xl</div>
                        <div class="text-3xl text-gray-900 dark:text-white">The quick brown fox jumps over the lazy dog</div>
                    </div>
                </div>

                <!-- Pesos de Fuente -->
                <div class="mt-8">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Pesos de Fuente</h3>
                    <div class="space-y-3">
                        <div class="flex items-center space-x-6">
                            <div class="w-24 text-sm text-gray-500 dark:text-gray-400 font-mono">normal</div>
                            <div class="font-normal text-gray-900 dark:text-white">Este texto usa font-normal (400)</div>
                        </div>
                        <div class="flex items-center space-x-6">
                            <div class="w-24 text-sm text-gray-500 dark:text-gray-400 font-mono">medium</div>
                            <div class="font-medium text-gray-900 dark:text-white">Este texto usa font-medium (500)</div>
                        </div>
                        <div class="flex items-center space-x-6">
                            <div class="w-24 text-sm text-gray-500 dark:text-gray-400 font-mono">semibold</div>
                            <div class="font-semibold text-gray-900 dark:text-white">Este texto usa font-semibold (600)</div>
                        </div>
                        <div class="flex items-center space-x-6">
                            <div class="w-24 text-sm text-gray-500 dark:text-gray-400 font-mono">bold</div>
                            <div class="font-bold text-gray-900 dark:text-white">Este texto usa font-bold (700)</div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Botones -->
            <section id="buttons" class="mb-16">
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Botones</h2>
                    <p class="text-gray-600 dark:text-gray-400">Componente unificado de botones con múltiples variantes</p>
                </div>

                <div class="space-y-8">
                    <!-- Botones por Variante -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Variantes de Botones</h3>
                        <div class="flex flex-wrap gap-4">
                            <x-button variant="primary">Botón Primario</x-button>
                            <x-button variant="secondary">Botón Secundario</x-button>
                            <x-button variant="outline">Botón Outline</x-button>
                            <x-button variant="danger">Botón Peligroso</x-button>
                        </div>
                        <div class="mt-4 p-4 bg-gray-100 dark:bg-gray-800 rounded-lg">
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Código:</p>
                            <code class="text-xs font-mono text-gray-800 dark:text-gray-200">&lt;x-button variant="primary"&gt;Botón Primario&lt;/x-button&gt;</code>
                        </div>
                    </div>

                    <!-- Tamaños de Botones -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Tamaños de Botones</h3>
                        <div class="flex flex-wrap items-center gap-4">
                            <x-button size="sm">Pequeño</x-button>
                            <x-button size="md">Mediano</x-button>
                            <x-button size="lg">Grande</x-button>
                        </div>
                        <div class="mt-4 p-4 bg-gray-100 dark:bg-gray-800 rounded-lg">
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Código:</p>
                            <code class="text-xs font-mono text-gray-800 dark:text-gray-200">&lt;x-button size="sm"&gt;Pequeño&lt;/x-button&gt;</code>
                        </div>
                    </div>

                    <!-- Botones con Iconos -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Botones con Iconos</h3>
                        <div class="flex flex-wrap gap-4">
                            <x-button variant="primary" icon="icon-[mdi--plus]">Crear Nuevo</x-button>
                            <x-button variant="secondary" icon="icon-[mdi--pencil]">Editar</x-button>
                            <x-button variant="outline" icon="icon-[mdi--download]">Descargar</x-button>
                            <x-button variant="danger" icon="icon-[mdi--delete]">Eliminar</x-button>
                        </div>
                        <div class="mt-4 p-4 bg-gray-100 dark:bg-gray-800 rounded-lg">
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Código:</p>
                            <code class="text-xs font-mono text-gray-800 dark:text-gray-200">&lt;x-button variant="primary" icon="icon-[mdi--plus]"&gt;Crear Nuevo&lt;/x-button&gt;</code>
                        </div>
                    </div>

                    <!-- Estados de Botones -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Estados de Botones</h3>
                        <div class="flex flex-wrap gap-4">
                            <x-button variant="primary">Normal</x-button>
                            <x-button variant="primary" disabled>Deshabilitado</x-button>
                        </div>
                        <div class="mt-4 p-4 bg-gray-100 dark:bg-gray-800 rounded-lg">
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Código:</p>
                            <code class="text-xs font-mono text-gray-800 dark:text-gray-200">&lt;x-button variant="primary" disabled&gt;Deshabilitado&lt;/x-button&gt;</code>
                        </div>
                    </div>

                    <!-- Botones como Enlaces -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Botones como Enlaces</h3>
                        <div class="flex flex-wrap gap-4">
                            <x-button variant="primary" href="/ejemplo">Enlace Primario</x-button>
                            <x-button variant="outline" href="/ejemplo">Enlace Outline</x-button>
                        </div>
                        <div class="mt-4 p-4 bg-gray-100 dark:bg-gray-800 rounded-lg">
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Código:</p>
                            <code class="text-xs font-mono text-gray-800 dark:text-gray-200">&lt;x-button variant="primary" href="/ejemplo"&gt;Enlace Primario&lt;/x-button&gt;</code>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Formularios -->
            <section id="forms" class="mb-16">
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Formularios</h2>
                    <p class="text-gray-600 dark:text-gray-400">Componentes de formularios del sistema</p>
                </div>

                <div class="space-y-8">
                    <!-- Inputs de Texto -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Campos de Texto</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="nombre" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Nombre Completo <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="nombre" name="nombre" 
                                       placeholder="Ingrese su nombre completo"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white placeholder-gray-400 dark:placeholder-gray-500"
                                       required>
                            </div>
                            <div>
                                <label for="ci" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Carnet de Identidad
                                </label>
                                <div class="relative">
                                    <span class="icon-[mdi--card-account-details] w-5 h-5 absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></span>
                                    <input type="text" id="ci" name="ci" 
                                           placeholder="1234567 LP"
                                           class="w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white placeholder-gray-400 dark:placeholder-gray-500">
                                </div>
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Email
                                </label>
                                <div class="relative">
                                    <span class="icon-[mdi--email] w-5 h-5 absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></span>
                                    <input type="email" id="email" name="email" 
                                           placeholder="usuario@correo.com"
                                           class="w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white placeholder-gray-400 dark:placeholder-gray-500">
                                </div>
                            </div>
                            <div>
                                <label for="error_field" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Campo con Error
                                </label>
                                <input type="text" id="error_field" name="error_field" 
                                       value="Valor incorrecto"
                                       class="w-full px-3 py-2 border border-red-300 dark:border-red-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:text-white placeholder-gray-400 dark:placeholder-gray-500">
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">Este campo contiene un error de validación</p>
                            </div>
                        </div>
                    </div>

                    <!-- Select -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Selectores</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="facultad" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Facultad <span class="text-red-500">*</span>
                                </label>
                                <select id="facultad" name="facultad" required
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white">
                                    <option value="">Seleccione una facultad</option>
                                    <option value="1">Facultad de Ingeniería</option>
                                    <option value="2">Facultad de Ciencias Económicas</option>
                                    <option value="3">Facultad de Medicina</option>
                                </select>
                            </div>
                            <div>
                                <label for="carrera" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Carrera
                                </label>
                                <select id="carrera" name="carrera"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white">
                                    <option value="">Seleccione una carrera</option>
                                    <option value="1">Ingeniería de Sistemas</option>
                                    <option value="2">Ingeniería Civil</option>
                                    <option value="3">Ingeniería Industrial</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Estados de Validación -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Estados de Validación</h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Campo Válido</label>
                                <input type="text" value="Dato correcto" class="w-full px-3 py-2 border border-green-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white">
                                <p class="text-green-600 dark:text-green-400 text-sm mt-1">Campo validado correctamente</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Campo con Error</label>
                                <input type="text" value="Dato incorrecto" class="w-full px-3 py-2 border border-red-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:text-white">
                                <p class="text-red-600 dark:text-red-400 text-sm mt-1">Este campo es requerido</p>
                            </div>
                        </div>
                    </div>

                    <!-- Componente Form Field -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Componente Form Field</h3>
                        <div class="space-y-6">
                            <x-form-field label="Nombre Completo" name="nombre" required>
                                <input type="text" id="nombre" name="nombre" 
                                       placeholder="Ingrese su nombre completo"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white placeholder-gray-400 dark:placeholder-gray-500">
                            </x-form-field>

                            <x-form-field label="Email" name="email" required help="Introduzca un email válido para recibir notificaciones">
                                <input type="email" id="email" name="email" 
                                       placeholder="usuario@ejemplo.com"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white placeholder-gray-400 dark:placeholder-gray-500">
                            </x-form-field>

                            <x-form-field label="Contraseña" name="password" required error="La contraseña debe tener al menos 8 caracteres">
                                <input type="password" id="password" name="password" 
                                       class="w-full px-3 py-2 border border-red-300 dark:border-red-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:text-white">
                            </x-form-field>
                        </div>
                        <div class="mt-4 p-4 bg-gray-100 dark:bg-gray-800 rounded-lg">
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Código:</p>
                            <code class="text-xs font-mono text-gray-800 dark:text-gray-200">
                                &lt;x-form-field label="Nombre" name="nombre" required&gt;...&lt;/x-form-field&gt;
                            </code>
                        </div>
                    </div>

                    <!-- Componente Data Table -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Componente Data Table</h3>
                        <x-data-table>
                            <x-slot name="header">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        Nombre
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        Email
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        Rol
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        Estado
                                    </th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        Acciones
                                    </th>
                                </tr>
                            </x-slot>
                            <x-slot name="body">
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                        Juan Pérez
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        juan.perez@uatf.edu.bo
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        Administrador
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                            Activo
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end space-x-2">
                                            <x-button variant="outline" size="sm" icon="icon-[mdi--pencil]">
                                                Editar
                                            </x-button>
                                            <x-button variant="danger" size="sm" icon="icon-[mdi--delete]">
                                                Eliminar
                                            </x-button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                        María García
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        maria.garcia@uatf.edu.bo
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        Editor
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                            Pendiente
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end space-x-2">
                                            <x-button variant="outline" size="sm" icon="icon-[mdi--pencil]">
                                                Editar
                                            </x-button>
                                            <x-button variant="danger" size="sm" icon="icon-[mdi--delete]">
                                                Eliminar
                                            </x-button>
                                        </div>
                                    </td>
                                </tr>
                            </x-slot>
                        </x-data-table>
                        <div class="mt-4 p-4 bg-gray-100 dark:bg-gray-800 rounded-lg">
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Código:</p>
                            <code class="text-xs font-mono text-gray-800 dark:text-gray-200">
                                &lt;x-data-table&gt;&lt;x-slot name="header"&gt;...&lt;/x-slot&gt;&lt;x-slot name="body"&gt;...&lt;/x-slot&gt;&lt;/x-data-table&gt;
                            </code>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Dashboard Simulation -->
            <section id="dashboard" class="mb-16">
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Simulación de Dashboard</h2>
                    <p class="text-gray-600 dark:text-gray-400">Layout completo del sistema con sidebar, header y contenido principal</p>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden" style="height: 600px;">
                    <div class="flex h-full">
                        <!-- Sidebar -->
                        <aside class="w-64 bg-gray-50 dark:bg-gray-900 border-r border-gray-200 dark:border-gray-700 flex-shrink-0">
                            <!-- Logo/Header del Sidebar -->
                            <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 bg-primary-600 rounded-lg flex items-center justify-center">
                                        <span class="icon-[mdi--school] w-5 h-5 text-white"></span>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-gray-900 dark:text-white text-sm">UATF Títulos</h3>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Universidad</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Navegación del Sidebar -->
                            <nav class="p-4 space-y-2" x-data="{ mainOpen: true, adminOpen: true }">
                                <!-- Grupo: Menú Principal -->
                                <div class="mb-4">
                                    <button @click="mainOpen = !mainOpen" class="flex items-center w-full text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3 hover:text-gray-700 dark:hover:text-gray-300 transition-colors">
                                        <span class="icon-[mdi--chevron-down] w-4 h-4 mr-1 transition-transform duration-200" :class="{ 'rotate-180': !mainOpen }"></span>
                                        Menú Principal
                                    </button>
                                    
                                    <div x-show="mainOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2" class="space-y-1">
                                        <a href="#" class="flex items-center space-x-3 px-3 py-2 rounded-md bg-primary-100 text-primary-700 dark:bg-primary-900/50 dark:text-primary-300">
                                            <span class="icon-[mdi--view-dashboard] w-5 h-5"></span>
                                            <span class="text-sm font-medium">Dashboard</span>
                                        </a>
                                        
                                        <a href="#" class="flex items-center space-x-3 px-3 py-2 rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">
                                            <span class="icon-[mdi--school] w-5 h-5"></span>
                                            <span class="text-sm">Diplomas Académicos</span>
                                        </a>
                                        
                                        <a href="#" class="flex items-center space-x-3 px-3 py-2 rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">
                                            <span class="icon-[mdi--certificate] w-5 h-5"></span>
                                            <span class="text-sm">Títulos Profesionales</span>
                                        </a>
                                        
                                        <a href="#" class="flex items-center space-x-3 px-3 py-2 rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">
                                            <span class="icon-[mdi--account-school] w-5 h-5"></span>
                                            <span class="text-sm">Bachiller</span>
                                        </a>
                                    </div>
                                </div>

                                <!-- Grupo: Administración -->
                                <div class="mb-4">
                                    <button @click="adminOpen = !adminOpen" class="flex items-center w-full text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3 hover:text-gray-700 dark:hover:text-gray-300 transition-colors">
                                        <span class="icon-[mdi--chevron-down] w-4 h-4 mr-1 transition-transform duration-200" :class="{ 'rotate-180': !adminOpen }"></span>
                                        Administración
                                    </button>
                                    
                                    <div x-show="adminOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2" class="space-y-1">
                                        <a href="#" class="flex items-center space-x-3 px-3 py-2 rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">
                                            <span class="icon-[mdi--account-multiple] w-5 h-5"></span>
                                            <span class="text-sm">Usuarios</span>
                                        </a>
                                        
                                        <a href="#" class="flex items-center space-x-3 px-3 py-2 rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">
                                            <span class="icon-[mdi--cog] w-5 h-5"></span>
                                            <span class="text-sm">Configuración</span>
                                        </a>
                                    </div>
                                </div>
                            </nav>
                        </aside>

                        <!-- Contenido Principal -->
                        <div class="flex-1 flex flex-col overflow-hidden">
                            <!-- Header -->
                            <header class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                                <!-- Top Navigation Bar -->
                                <div class="px-6 py-4">
                                    <div class="flex items-center justify-between">
                                        <!-- Page Title and Description -->
                                        <div class="flex-1 min-w-0">
                                            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Diplomas Académicos</h1>
                                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Gestión de títulos académicos universitarios</p>
                                        </div>

                                        <!-- User Actions -->
                                        <div class="flex items-center space-x-4">
                                            <!-- Notificaciones -->
                                            <button class="relative p-2 text-gray-400 hover:text-gray-500 dark:hover:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
                                                <span class="icon-[mdi--bell] w-5 h-5"></span>
                                                <span class="absolute top-1 right-1 w-2 h-2 bg-primary-500 rounded-full"></span>
                                            </button>
                                            
                                            <!-- Usuario Profile Dropdown -->
                                            <div x-data="{ menuIsOpen: false }" x-on:keydown.esc.window="menuIsOpen = false" class="relative">
                                                <button 
                                                    type="button" 
                                                    class="flex items-center space-x-3 px-3 py-2 rounded-lg transition-colors hover:bg-gray-50 dark:hover:bg-gray-700"
                                                    :class="menuIsOpen ? 'bg-primary-50 dark:bg-primary-900/20' : ''" 
                                                    aria-haspopup="true" 
                                                    x-on:click="menuIsOpen = ! menuIsOpen" 
                                                    :aria-expanded="menuIsOpen">
                                                    
                                                    <div class="w-8 h-8 bg-secondary-500 rounded-full flex items-center justify-center">
                                                        <span class="icon-[mdi--account] w-5 h-5 text-white"></span>
                                                    </div>
                                                    
                                                    <div class="text-sm text-left">
                                                        <p class="font-medium text-gray-900 dark:text-white">Juan Pérez</p>
                                                        <p class="text-gray-500 dark:text-gray-400">Administrador</p>
                                                    </div>
                                                    
                                                    <span class="icon-[mdi--chevron-down] w-4 h-4 text-gray-400 transition-transform duration-200" :class="{ 'rotate-180': menuIsOpen }"></span>
                                                </button>
                                                
                                                <!-- Dropdown Menu -->
                                                <div 
                                                    x-cloak 
                                                    x-show="menuIsOpen" 
                                                    x-on:click.outside="menuIsOpen = false" 
                                                    x-transition:enter="transition ease-out duration-200" 
                                                    x-transition:enter-start="opacity-0 scale-95" 
                                                    x-transition:enter-end="opacity-100 scale-100" 
                                                    x-transition:leave="transition ease-in duration-150" 
                                                    x-transition:leave-start="opacity-100 scale-100" 
                                                    x-transition:leave-end="opacity-0 scale-95" 
                                                    x-trap="menuIsOpen"
                                                    class="absolute right-0 mt-2 w-56 bg-white dark:bg-gray-800 rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 border border-gray-200 dark:border-gray-700 z-50">
                                                    
                                                    <!-- Profile Section -->
                                                    <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                                                        <a href="#" class="flex items-center space-x-3 hover:bg-gray-50 dark:hover:bg-gray-700 px-2 py-2 rounded-md transition-colors" role="menuitem">
                                                            <span class="icon-[mdi--account] w-5 h-5 text-gray-500 dark:text-gray-400"></span>
                                                            <span class="text-sm font-medium text-gray-900 dark:text-white">Mi Perfil</span>
                                                        </a>
                                                    </div>
                                                    
                                                    <!-- Settings Section -->
                                                    <div class="py-1">
                                                        <a href="#" class="flex items-center space-x-3 px-6 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors" role="menuitem">
                                                            <span class="icon-[mdi--cog] w-5 h-5 text-gray-500 dark:text-gray-400"></span>
                                                            <span>Configuración</span>
                                                        </a>
                                                        <a href="#" class="flex items-center space-x-3 px-6 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors" role="menuitem">
                                                            <span class="icon-[mdi--shield-account] w-5 h-5 text-gray-500 dark:text-gray-400"></span>
                                                            <span>Seguridad</span>
                                                        </a>
                                                        <a href="#" class="flex items-center space-x-3 px-6 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors" role="menuitem">
                                                            <span class="icon-[mdi--help-circle] w-5 h-5 text-gray-500 dark:text-gray-400"></span>
                                                            <span>Ayuda</span>
                                                        </a>
                                                    </div>
                                                    
                                                    <!-- Sign Out Section -->
                                                    <div class="py-1 border-t border-gray-200 dark:border-gray-700">
                                                        <a href="#" class="flex items-center space-x-3 px-6 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors" role="menuitem">
                                                            <span class="icon-[mdi--logout] w-5 h-5"></span>
                                                            <span>Cerrar Sesión</span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Sub Navigation Tabs -->
                                <div class="px-6 py-0 bg-white dark:bg-gray-800">
                                    <nav class="-mb-px flex space-x-8" aria-label="Sub Navigation">
                                        <!-- Lista Activa -->
                                        <a href="#" class="border-b-2 border-primary-500 text-primary-600 dark:text-primary-400 whitespace-nowrap py-3 px-1 font-medium text-sm flex items-center">
                                            <span class="icon-[mdi--format-list-bulleted] w-4 h-4 mr-2"></span>
                                            Lista Activa
                                        </a>
                                        
                                        <!-- Menciones -->
                                        <a href="#" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-200 dark:hover:border-gray-600 whitespace-nowrap py-3 px-1 border-b-2 font-medium text-sm flex items-center transition-colors">
                                            <span class="icon-[mdi--medal] w-4 h-4 mr-2"></span>
                                            Menciones
                                        </a>
                                        
                                        <!-- Modalidades -->
                                        <a href="#" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-200 dark:hover:border-gray-600 whitespace-nowrap py-3 px-1 border-b-2 font-medium text-sm flex items-center transition-colors">
                                            <span class="icon-[mdi--school] w-4 h-4 mr-2"></span>
                                            Modalidades
                                        </a>
                                        
                                        <!-- Estadísticas -->
                                        <a href="#" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-200 dark:hover:border-gray-600 whitespace-nowrap py-3 px-1 border-b-2 font-medium text-sm flex items-center transition-colors">
                                            <span class="icon-[mdi--chart-line] w-4 h-4 mr-2"></span>
                                            Estadísticas
                                        </a>
                                        
                                        <!-- Configuración -->
                                        <a href="#" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-200 dark:hover:border-gray-600 whitespace-nowrap py-3 px-1 border-b-2 font-medium text-sm flex items-center transition-colors">
                                            <span class="icon-[mdi--cog] w-4 h-4 mr-2"></span>
                                            Configuración
                                        </a>
                                    </nav>
                                </div>
                            </header>

                            <!-- Main Content -->
                            <main class="flex-1 overflow-y-auto p-6 bg-gray-50 dark:bg-gray-900">
                                <!-- Stats Cards -->
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                                    <div class="bg-white dark:bg-gray-800 rounded-lg p-6 border border-gray-200 dark:border-gray-700">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0">
                                                <span class="icon-[mdi--school] w-8 h-8 text-primary-500"></span>
                                            </div>
                                            <div class="ml-4">
                                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Diplomas</p>
                                                <p class="text-2xl font-semibold text-gray-900 dark:text-white">1,234</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="bg-white dark:bg-gray-800 rounded-lg p-6 border border-gray-200 dark:border-gray-700">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0">
                                                <span class="icon-[mdi--clock-outline] w-8 h-8 text-warning-500"></span>
                                            </div>
                                            <div class="ml-4">
                                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Pendientes</p>
                                                <p class="text-2xl font-semibold text-gray-900 dark:text-white">45</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="bg-white dark:bg-gray-800 rounded-lg p-6 border border-gray-200 dark:border-gray-700">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0">
                                                <span class="icon-[mdi--check-circle] w-8 h-8 text-success-500"></span>
                                            </div>
                                            <div class="ml-4">
                                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Digitalizados</p>
                                                <p class="text-2xl font-semibold text-gray-900 dark:text-white">1,189</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="bg-white dark:bg-gray-800 rounded-lg p-6 border border-gray-200 dark:border-gray-700">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0">
                                                <span class="icon-[mdi--account-multiple] w-8 h-8 text-secondary-500"></span>
                                            </div>
                                            <div class="ml-4">
                                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Usuarios Activos</p>
                                                <p class="text-2xl font-semibold text-gray-900 dark:text-white">12</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Contenido adicional -->
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                    <!-- Tabla de actividad reciente -->
                                    <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Actividad Reciente</h3>
                                        </div>
                                        <div class="p-6">
                                            <div class="space-y-4">
                                                <div class="flex items-center space-x-3">
                                                    <div class="w-2 h-2 bg-success-500 rounded-full"></div>
                                                    <div class="flex-1">
                                                        <p class="text-sm text-gray-900 dark:text-white">Diploma registrado - Juan Carlos Mamani</p>
                                                        <p class="text-xs text-gray-500 dark:text-gray-400">Hace 2 minutos</p>
                                                    </div>
                                                </div>
                                                <div class="flex items-center space-x-3">
                                                    <div class="w-2 h-2 bg-warning-500 rounded-full"></div>
                                                    <div class="flex-1">
                                                        <p class="text-sm text-gray-900 dark:text-white">Documento pendiente de validación</p>
                                                        <p class="text-xs text-gray-500 dark:text-gray-400">Hace 15 minutos</p>
                                                    </div>
                                                </div>
                                                <div class="flex items-center space-x-3">
                                                    <div class="w-2 h-2 bg-primary-500 rounded-full"></div>
                                                    <div class="flex-1">
                                                        <p class="text-sm text-gray-900 dark:text-white">Usuario creado - María López</p>
                                                        <p class="text-xs text-gray-500 dark:text-gray-400">Hace 1 hora</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Acciones rápidas -->
                                    <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Acciones Rápidas</h3>
                                        </div>
                                        <div class="p-6">
                                            <div class="grid grid-cols-2 gap-4">
                                                <button class="flex flex-col items-center p-4 border border-gray-200 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                                    <span class="icon-[mdi--plus] w-8 h-8 text-primary-500 mb-2"></span>
                                                    <span class="text-sm font-medium text-gray-900 dark:text-white">Nuevo Diploma</span>
                                                </button>
                                                <button class="flex flex-col items-center p-4 border border-gray-200 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                                    <span class="icon-[mdi--upload] w-8 h-8 text-secondary-500 mb-2"></span>
                                                    <span class="text-sm font-medium text-gray-900 dark:text-white">Subir PDF</span>
                                                </button>
                                                <button class="flex flex-col items-center p-4 border border-gray-200 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                                    <span class="icon-[mdi--search] w-8 h-8 text-success-500 mb-2"></span>
                                                    <span class="text-sm font-medium text-gray-900 dark:text-white">Buscar Título</span>
                                                </button>
                                                <button class="flex flex-col items-center p-4 border border-gray-200 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                                    <span class="icon-[mdi--download] w-8 h-8 text-warning-500 mb-2"></span>
                                                    <span class="text-sm font-medium text-gray-900 dark:text-white">Reportes</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </main>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Formulario Completo -->
            <section id="complete-form" class="mb-16">
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Formulario Completo</h2>
                    <p class="text-gray-600 dark:text-gray-400">Ejemplo de formulario completo para registro de diplomas académicos</p>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-8">
                    <form class="space-y-8">
                        <!-- Header del Formulario -->
                        <div class="border-b border-gray-200 dark:border-gray-700 pb-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Registro de Diploma Académico</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Complete la información del diploma académico a registrar</p>
                        </div>

                        <!-- Información Personal -->
                        <div>
                            <h4 class="text-base font-medium text-gray-900 dark:text-white mb-4">Información Personal</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="ci2" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Carnet de Identidad <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <span class="icon-[mdi--card-account-details] w-5 h-5 absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></span>
                                        <input type="text" id="ci2" name="ci" placeholder="1234567 LP" required
                                               class="w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white placeholder-gray-400 dark:placeholder-gray-500">
                                    </div>
                                </div>
                                <div>
                                    <label for="nombres" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Nombres <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="nombres" name="nombres" placeholder="Juan Carlos" required
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white placeholder-gray-400 dark:placeholder-gray-500">
                                </div>
                                <div>
                                    <label for="apellido_paterno" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Apellido Paterno <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="apellido_paterno" name="apellido_paterno" placeholder="Mamani" required
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white placeholder-gray-400 dark:placeholder-gray-500">
                                </div>
                                <div>
                                    <label for="apellido_materno" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Apellido Materno
                                    </label>
                                    <input type="text" id="apellido_materno" name="apellido_materno" placeholder="Condori"
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white placeholder-gray-400 dark:placeholder-gray-500">
                                </div>
                                <div>
                                    <label for="fecha_nacimiento" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Fecha de Nacimiento <span class="text-red-500">*</span>
                                    </label>
                                    <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" required
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white">
                                </div>
                                <div>
                                    <label for="lugar_nacimiento" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Lugar de Nacimiento
                                    </label>
                                    <input type="text" id="lugar_nacimiento" name="lugar_nacimiento" placeholder="Potosí, Bolivia"
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white placeholder-gray-400 dark:placeholder-gray-500">
                                </div>
                            </div>
                        </div>

                        <!-- Información Académica -->
                        <div>
                            <h4 class="text-base font-medium text-gray-900 dark:text-white mb-4">Información Académica</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="facultad_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Facultad <span class="text-red-500">*</span>
                                    </label>
                                    <select id="facultad_id" name="facultad_id" required
                                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white">
                                        <option value="">Seleccione una facultad</option>
                                        <option value="1">Facultad de Ingeniería</option>
                                        <option value="2">Facultad de Ciencias Económicas</option>
                                        <option value="3">Facultad de Medicina</option>
                                        <option value="4">Facultad de Derecho</option>
                                    </select>
                                </div>
                                
                                <div>
                                    <label for="carrera_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Carrera <span class="text-red-500">*</span>
                                    </label>
                                    <select id="carrera_id" name="carrera_id" required
                                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white">
                                        <option value="">Seleccione una carrera</option>
                                        <option value="1">Ingeniería de Sistemas</option>
                                        <option value="2">Ingeniería Civil</option>
                                        <option value="3">Ingeniería Industrial</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="mencion_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Mención
                                    </label>
                                    <select id="mencion_id" name="mencion_id"
                                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white">
                                        <option value="">Sin mención específica</option>
                                        <option value="1">Sistemas de Información</option>
                                        <option value="2">Redes y Telecomunicaciones</option>
                                        <option value="3">Desarrollo de Software</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="graduacion_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Modalidad de Graduación <span class="text-red-500">*</span>
                                    </label>
                                    <select id="graduacion_id" name="graduacion_id" required
                                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white">
                                        <option value="">Seleccione modalidad</option>
                                        <option value="1">Tesis de Grado</option>
                                        <option value="2">Proyecto de Grado</option>
                                        <option value="3">Trabajo Dirigido</option>
                                        <option value="4">Examen de Grado</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Información del Diploma -->
                        <div>
                            <h4 class="text-base font-medium text-gray-900 dark:text-white mb-4">Información del Diploma</h4>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label for="libro" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Número de Libro <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="libro" name="libro" placeholder="001" required
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white placeholder-gray-400 dark:placeholder-gray-500">
                                </div>
                                <div>
                                    <label for="fojas" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Número de Fojas <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="fojas" name="fojas" placeholder="123" required
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white placeholder-gray-400 dark:placeholder-gray-500">
                                </div>
                                <div>
                                    <label for="nro_documento" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Número de Documento <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="nro_documento" name="nro_documento" placeholder="D-2024-001" required
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white placeholder-gray-400 dark:placeholder-gray-500">
                                </div>
                                <div>
                                    <label for="fecha_emision" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Fecha de Emisión <span class="text-red-500">*</span>
                                    </label>
                                    <input type="date" id="fecha_emision" name="fecha_emision" required
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white">
                                </div>
                                <div>
                                    <label for="gestion" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Gestión Académica <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="gestion" name="gestion" placeholder="2024" required
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white placeholder-gray-400 dark:placeholder-gray-500">
                                </div>
                                <div>
                                    <label for="estado" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Estado <span class="text-red-500">*</span>
                                    </label>
                                    <select id="estado" name="estado" required
                                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white">
                                        <option value="">Seleccione estado</option>
                                        <option value="digitalizado">Digitalizado</option>
                                        <option value="pendiente">Pendiente de digitalización</option>
                                    </select>
                                </div>
                            </div>
                        </div>


                        <!-- Observaciones -->
                        <div>
                            <label for="observaciones" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Observaciones
                            </label>
                            <textarea 
                                id="observaciones" 
                                name="observaciones" 
                                rows="4" 
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white placeholder-gray-400 dark:placeholder-gray-500"
                                placeholder="Ingrese cualquier observación adicional sobre el diploma..."
                            ></textarea>
                        </div>

                        <!-- Botones de Acción -->
                        <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                            <x-button variant="outline" type="button" icon="icon-[mdi--close]">
                                Cancelar
                            </x-button>
                            <x-button variant="secondary" type="button" icon="icon-[mdi--content-save]">
                                Guardar Borrador
                            </x-button>
                            <x-button variant="primary" type="submit" icon="icon-[mdi--check]">
                                Registrar Diploma
                            </x-button>
                        </div>
                    </form>
                </div>
            </section>

            <!-- Cards -->
            <section id="cards" class="mb-16">
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Cards y Contenedores</h2>
                    <p class="text-gray-600 dark:text-gray-400">Componentes de tarjetas y contenedores</p>
                </div>

                <div class="space-y-8">
                    <!-- Card Básica -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Card Básica</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <x-card title="Título de la Card" description="Descripción breve de la tarjeta">
                                <p class="text-gray-600 dark:text-gray-400">
                                    Contenido de la tarjeta. Este es un ejemplo de cómo se ve el contenido principal dentro de una card básica.
                                </p>
                                <div class="flex space-x-2 mt-4">
                                    <x-button variant="primary" size="sm">Acción Principal</x-button>
                                    <x-button variant="secondary" size="sm">Acción Secundaria</x-button>
                                </div>
                            </x-card>

                            <x-card>
                                <x-slot name="header">
                                    <div class="flex items-center justify-between">
                                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Header Personalizado</h3>
                                        <span class="text-sm text-gray-500 dark:text-gray-400">Badge</span>
                                    </div>
                                </x-slot>
                                <p class="text-gray-600 dark:text-gray-400">
                                    Card con header slot personalizado. Permite mayor flexibilidad en el diseño del encabezado.
                                </p>
                            </x-card>
                        </div>
                    </div>

                    <!-- Tarjetas de Estadísticas -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Tarjetas de Estadísticas</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                            <!-- Stat Card 1 -->
                            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                                <div class="p-5">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <span class="icon-[mdi--school] w-8 h-8 text-blue-500"></span>
                                        </div>
                                        <div class="ml-5 w-0 flex-1">
                                            <dl>
                                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                                                    Total Diplomas
                                                </dt>
                                                <dd class="text-lg font-medium text-gray-900 dark:text-white">
                                                    1,234
                                                </dd>
                                            </dl>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Stat Card 2 -->
                            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                                <div class="p-5">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <span class="icon-[mdi--clock-outline] w-8 h-8 text-yellow-500"></span>
                                        </div>
                                        <div class="ml-5 w-0 flex-1">
                                            <dl>
                                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                                                    Pendientes
                                                </dt>
                                                <dd class="text-lg font-medium text-gray-900 dark:text-white">
                                                    45
                                                </dd>
                                            </dl>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Stat Card 3 -->
                            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                                <div class="p-5">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <span class="icon-[mdi--check-circle] w-8 h-8 text-green-500"></span>
                                        </div>
                                        <div class="ml-5 w-0 flex-1">
                                            <dl>
                                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                                                    Digitalizados
                                                </dt>
                                                <dd class="text-lg font-medium text-gray-900 dark:text-white">
                                                    1,189
                                                </dd>
                                            </dl>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Stat Card 4 -->
                            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                                <div class="p-5">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <span class="icon-[mdi--account-multiple] w-8 h-8 text-purple-500"></span>
                                        </div>
                                        <div class="ml-5 w-0 flex-1">
                                            <dl>
                                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                                                    Usuarios Activos
                                                </dt>
                                                <dd class="text-lg font-medium text-gray-900 dark:text-white">
                                                    12
                                                </dd>
                                            </dl>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 p-4 bg-gray-100 dark:bg-gray-800 rounded-lg">
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Código HTML directo:</p>
                            <code class="text-xs font-mono text-gray-800 dark:text-gray-200">
                                &lt;div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg"&gt;...&lt;/div&gt;
                            </code>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Navegación -->
            <section id="navigation" class="mb-16">
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Navegación</h2>
                    <p class="text-gray-600 dark:text-gray-400">Componentes de navegación del sistema</p>
                </div>

                <div class="space-y-8">
                    <!-- Navigation Tabs -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Navigation Tabs</h3>
                        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg border border-gray-200 dark:border-gray-700">
                            <nav class="-mb-px flex space-x-8" aria-label="Sub Navigation">
                                <!-- Lista Activa -->
                                <a href="#" class="border-b-2 border-primary-500 text-primary-600 dark:text-primary-400 whitespace-nowrap py-3 px-1 font-medium text-sm flex items-center">
                                    <span class="icon-[mdi--format-list-bulleted] w-4 h-4 mr-2"></span>
                                    Lista Activa
                                </a>
                                
                                <!-- Menciones -->
                                <a href="#" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-200 dark:hover:border-gray-600 whitespace-nowrap py-3 px-1 border-b-2 font-medium text-sm flex items-center transition-colors">
                                    <span class="icon-[mdi--medal] w-4 h-4 mr-2"></span>
                                    Menciones
                                </a>
                                
                                <!-- Modalidades -->
                                <a href="#" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-200 dark:hover:border-gray-600 whitespace-nowrap py-3 px-1 border-b-2 font-medium text-sm flex items-center transition-colors">
                                    <span class="icon-[mdi--school] w-4 h-4 mr-2"></span>
                                    Modalidades
                                </a>
                            </nav>
                        </div>
                    </div>

                    <!-- Breadcrumbs -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Breadcrumbs</h3>
                        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                            <div class="px-6 py-2 bg-gray-50 dark:bg-gray-800/50 border-t border-gray-100 dark:border-gray-700/50">
                                <nav class="flex" aria-label="Breadcrumb">
                                    <ol class="flex items-center space-x-1 text-xs">
                                        <li>
                                            <a href="#" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 flex items-center">
                                                <span class="icon-[mdi--home] w-3 h-3 mr-1"></span>
                                                Dashboard
                                            </a>
                                        </li>
                                        <li class="flex items-center">
                                            <span class="icon-[mdi--chevron-right] w-3 h-3 text-gray-400 dark:text-gray-500 mx-1"></span>
                                            <a href="#" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">Diplomas Académicos</a>
                                        </li>
                                        <li class="flex items-center">
                                            <span class="icon-[mdi--chevron-right] w-3 h-3 text-gray-400 dark:text-gray-500 mx-1"></span>
                                            <span class="text-gray-900 dark:text-white font-medium">Menciones</span>
                                        </li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Iconos -->
            <section id="icons" class="mb-16">
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Iconos</h2>
                    <p class="text-gray-600 dark:text-gray-400">Sistema de iconos Iconify implementado</p>
                </div>

                <div class="space-y-6">
                    <!-- Iconos Comunes -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Iconos Frecuentes</h3>
                        <div class="grid grid-cols-4 sm:grid-cols-6 lg:grid-cols-8 gap-4">
                            <div class="text-center p-4 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                                <span class="icon-[mdi--plus] w-6 h-6 mx-auto text-gray-600 dark:text-gray-400"></span>
                                <p class="text-xs mt-2 font-mono text-gray-900 dark:text-white">mdi--plus</p>
                            </div>
                            <div class="text-center p-4 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                                <span class="icon-[mdi--pencil] w-6 h-6 mx-auto text-gray-600 dark:text-gray-400"></span>
                                <p class="text-xs mt-2 font-mono text-gray-900 dark:text-white">mdi--pencil</p>
                            </div>
                            <div class="text-center p-4 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                                <span class="icon-[mdi--delete] w-6 h-6 mx-auto text-gray-600 dark:text-gray-400"></span>
                                <p class="text-xs mt-2 font-mono text-gray-900 dark:text-white">mdi--delete</p>
                            </div>
                            <div class="text-center p-4 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                                <span class="icon-[mdi--eye] w-6 h-6 mx-auto text-gray-600 dark:text-gray-400"></span>
                                <p class="text-xs mt-2 font-mono text-gray-900 dark:text-white">mdi--eye</p>
                            </div>
                            <div class="text-center p-4 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                                <span class="icon-[mdi--download] w-6 h-6 mx-auto text-gray-600 dark:text-gray-400"></span>
                                <p class="text-xs mt-2 font-mono text-gray-900 dark:text-white">mdi--download</p>
                            </div>
                            <div class="text-center p-4 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                                <span class="icon-[mdi--search] w-6 h-6 mx-auto text-gray-600 dark:text-gray-400"></span>
                                <p class="text-xs mt-2 font-mono text-gray-900 dark:text-white">mdi--search</p>
                            </div>
                            <div class="text-center p-4 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                                <span class="icon-[mdi--school] w-6 h-6 mx-auto text-gray-600 dark:text-gray-400"></span>
                                <p class="text-xs mt-2 font-mono text-gray-900 dark:text-white">mdi--school</p>
                            </div>
                            <div class="text-center p-4 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                                <span class="icon-[mdi--account] w-6 h-6 mx-auto text-gray-600 dark:text-gray-400"></span>
                                <p class="text-xs mt-2 font-mono text-gray-900 dark:text-white">mdi--account</p>
                            </div>
                        </div>
                    </div>

                    <!-- Diferentes Tamaños -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Tamaños de Iconos</h3>
                        <div class="flex items-center space-x-6">
                            <div class="text-center">
                                <span class="icon-[mdi--heart] w-4 h-4 text-red-500"></span>
                                <p class="text-xs mt-1 font-mono text-gray-900 dark:text-white">w-4 h-4</p>
                            </div>
                            <div class="text-center">
                                <span class="icon-[mdi--heart] w-5 h-5 text-red-500"></span>
                                <p class="text-xs mt-1 font-mono text-gray-900 dark:text-white">w-5 h-5</p>
                            </div>
                            <div class="text-center">
                                <span class="icon-[mdi--heart] w-6 h-6 text-red-500"></span>
                                <p class="text-xs mt-1 font-mono text-gray-900 dark:text-white">w-6 h-6</p>
                            </div>
                            <div class="text-center">
                                <span class="icon-[mdi--heart] w-8 h-8 text-red-500"></span>
                                <p class="text-xs mt-1 font-mono text-gray-900 dark:text-white">w-8 h-8</p>
                            </div>
                            <div class="text-center">
                                <span class="icon-[mdi--heart] w-12 h-12 text-red-500"></span>
                                <p class="text-xs mt-1 font-mono text-gray-900 dark:text-white">w-12 h-12</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Select Buscable -->
            <section id="searchable-select" class="mb-16">
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Select Buscable con Alpine.js</h2>
                    <p class="text-gray-600 dark:text-gray-400">Componente select con búsqueda integrada, navegación por teclado y accesibilidad completa</p>
                </div>

                <div class="space-y-8">
                    <!-- Ejemplo Básico -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Ejemplo Básico</h3>
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                            <div class="max-w-md">
                                @php
                                $careers = [
                                    ['id' => 1, 'name' => 'Ingeniería de Sistemas'],
                                    ['id' => 2, 'name' => 'Ingeniería Civil'],
                                    ['id' => 3, 'name' => 'Medicina'],
                                    ['id' => 4, 'name' => 'Derecho'],
                                    ['id' => 5, 'name' => 'Arquitectura'],
                                    ['id' => 6, 'name' => 'Ingeniería Industrial'],
                                    ['id' => 7, 'name' => 'Psicología'],
                                    ['id' => 8, 'name' => 'Contaduría Pública']
                                ];
                                @endphp
                                
                                <x-searchable-select 
                                    :options="$careers"
                                    label="Seleccionar Carrera"
                                    placeholder="Seleccionar una carrera..."
                                    search-placeholder="Buscar carrera..."
                                    name="career_id"
                                    :required="true"
                                />
                            </div>
                        </div>
                    </div>

                    <!-- Ejemplo con Datos Personalizados -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Con Claves Personalizadas</h3>
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                            <div class="max-w-md">
                                @php
                                $customOptions = [
                                    ['codigo' => 'ING-SIS', 'descripcion' => 'Ingeniería de Sistemas'],
                                    ['codigo' => 'ING-CIV', 'descripcion' => 'Ingeniería Civil'],
                                    ['codigo' => 'MED', 'descripcion' => 'Medicina'],
                                    ['codigo' => 'DER', 'descripcion' => 'Derecho']
                                ];
                                @endphp
                                
                                <x-searchable-select 
                                    :options="$customOptions"
                                    label="Seleccionar con Claves Personalizadas"
                                    placeholder="Seleccionar opción..."
                                    value-key="codigo"
                                    label-key="descripcion"
                                    name="custom_field"
                                />
                            </div>
                        </div>
                    </div>

                    <!-- Parámetros del Componente -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Parámetros del Componente</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full">
                                <thead>
                                    <tr class="border-b border-gray-200 dark:border-gray-700">
                                        <th class="text-left py-2 px-3 text-sm font-medium text-gray-900 dark:text-white">Parámetro</th>
                                        <th class="text-left py-2 px-3 text-sm font-medium text-gray-900 dark:text-white">Tipo</th>
                                        <th class="text-left py-2 px-3 text-sm font-medium text-gray-900 dark:text-white">Por Defecto</th>
                                        <th class="text-left py-2 px-3 text-sm font-medium text-gray-900 dark:text-white">Descripción</th>
                                    </tr>
                                </thead>
                                <tbody class="text-sm">
                                    <tr class="border-b border-gray-100 dark:border-gray-700">
                                        <td class="py-2 px-3 font-mono text-primary-600 dark:text-primary-400">options</td>
                                        <td class="py-2 px-3 text-gray-600 dark:text-gray-400">array</td>
                                        <td class="py-2 px-3 text-gray-600 dark:text-gray-400">[]</td>
                                        <td class="py-2 px-3 text-gray-600 dark:text-gray-400">Array de opciones disponibles</td>
                                    </tr>
                                    <tr class="border-b border-gray-100 dark:border-gray-700">
                                        <td class="py-2 px-3 font-mono text-primary-600 dark:text-primary-400">selected</td>
                                        <td class="py-2 px-3 text-gray-600 dark:text-gray-400">mixed</td>
                                        <td class="py-2 px-3 text-gray-600 dark:text-gray-400">null</td>
                                        <td class="py-2 px-3 text-gray-600 dark:text-gray-400">Opción preseleccionada</td>
                                    </tr>
                                    <tr class="border-b border-gray-100 dark:border-gray-700">
                                        <td class="py-2 px-3 font-mono text-primary-600 dark:text-primary-400">placeholder</td>
                                        <td class="py-2 px-3 text-gray-600 dark:text-gray-400">string</td>
                                        <td class="py-2 px-3 text-gray-600 dark:text-gray-400">'Seleccionar opción'</td>
                                        <td class="py-2 px-3 text-gray-600 dark:text-gray-400">Texto cuando no hay selección</td>
                                    </tr>
                                    <tr class="border-b border-gray-100 dark:border-gray-700">
                                        <td class="py-2 px-3 font-mono text-primary-600 dark:text-primary-400">label</td>
                                        <td class="py-2 px-3 text-gray-600 dark:text-gray-400">string</td>
                                        <td class="py-2 px-3 text-gray-600 dark:text-gray-400">null</td>
                                        <td class="py-2 px-3 text-gray-600 dark:text-gray-400">Etiqueta del campo</td>
                                    </tr>
                                    <tr class="border-b border-gray-100 dark:border-gray-700">
                                        <td class="py-2 px-3 font-mono text-primary-600 dark:text-primary-400">name</td>
                                        <td class="py-2 px-3 text-gray-600 dark:text-gray-400">string</td>
                                        <td class="py-2 px-3 text-gray-600 dark:text-gray-400">null</td>
                                        <td class="py-2 px-3 text-gray-600 dark:text-gray-400">Nombre del campo para formularios</td>
                                    </tr>
                                    <tr class="border-b border-gray-100 dark:border-gray-700">
                                        <td class="py-2 px-3 font-mono text-primary-600 dark:text-primary-400">required</td>
                                        <td class="py-2 px-3 text-gray-600 dark:text-gray-400">boolean</td>
                                        <td class="py-2 px-3 text-gray-600 dark:text-gray-400">false</td>
                                        <td class="py-2 px-3 text-gray-600 dark:text-gray-400">Campo obligatorio</td>
                                    </tr>
                                    <tr class="border-b border-gray-100 dark:border-gray-700">
                                        <td class="py-2 px-3 font-mono text-primary-600 dark:text-primary-400">value-key</td>
                                        <td class="py-2 px-3 text-gray-600 dark:text-gray-400">string</td>
                                        <td class="py-2 px-3 text-gray-600 dark:text-gray-400">'id'</td>
                                        <td class="py-2 px-3 text-gray-600 dark:text-gray-400">Clave para el valor de cada opción</td>
                                    </tr>
                                    <tr>
                                        <td class="py-2 px-3 font-mono text-primary-600 dark:text-primary-400">label-key</td>
                                        <td class="py-2 px-3 text-gray-600 dark:text-gray-400">string</td>
                                        <td class="py-2 px-3 text-gray-600 dark:text-gray-400">'name'</td>
                                        <td class="py-2 px-3 text-gray-600 dark:text-gray-400">Clave para la etiqueta de cada opción</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Uso del Componente -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Uso del Componente</h3>
                            <p class="text-gray-600 dark:text-gray-400 mt-1">Sintaxis para usar el componente Select Buscable</p>
                        </div>
                        <div class="bg-gray-900 p-6 overflow-x-auto">
                            <pre class="text-green-400 text-sm"><code>&lt;!-- Uso básico --&gt;
&lt;x-searchable-select 
    :options="$options"
    label="Seleccionar Opción"
    name="field_name"
    :required="true"
/&gt;

&lt;!-- Con claves personalizadas --&gt;
&lt;x-searchable-select 
    :options="$customOptions"
    label="Campo Personalizado"
    placeholder="Elegir una opción..."
    value-key="codigo"
    label-key="descripcion"
    name="custom_field"
/&gt;

&lt;!-- Con valor preseleccionado --&gt;
&lt;x-searchable-select 
    :options="$options"
    :selected="$selectedOption"
    label="Con Preselección"
    name="preselected_field"
/&gt;

&lt;!-- Escuchar cambios con Alpine.js --&gt;
&lt;div @select-changed="handleSelectChange($event.detail)"&gt;
    &lt;x-searchable-select :options="$options" /&gt;
&lt;/div&gt;</code></pre>
                        </div>
                    </div>

                    <!-- Funcionalidades -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Funcionalidades</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h4 class="font-medium text-gray-900 dark:text-white mb-2">Interacción</h4>
                                <ul class="text-sm text-gray-600 dark:text-gray-400 space-y-1">
                                    <li>• Búsqueda en tiempo real</li>
                                    <li>• Navegación por teclado (↑↓)</li>
                                    <li>• Selección con Enter</li>
                                    <li>• Cerrar con Escape</li>
                                    <li>• Click outside para cerrar</li>
                                    <li>• Focus automático en búsqueda</li>
                                </ul>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-900 dark:text-white mb-2">Características</h4>
                                <ul class="text-sm text-gray-600 dark:text-gray-400 space-y-1">
                                    <li>• Totalmente accesible</li>
                                    <li>• Compatible con formularios</li>
                                    <li>• Validación integrada</li>
                                    <li>• Eventos personalizados</li>
                                    <li>• Claves configurables</li>
                                    <li>• Responsive design</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Visor PDF -->
            <section id="pdf-viewer" class="mb-16">
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Visor PDF con Drag & Drop</h2>
                    <p class="text-gray-600 dark:text-gray-400">Componente para visualizar PDFs con carga por arrastrar y soltar usando el viewer nativo del navegador</p>
                </div>

                <div class="space-y-8">
                    <!-- Ejemplo Visual -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Ejemplo Interactivo</h3>
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                            <x-pdf-viewer 
                                height="400px" 
                                :max-file-size="50" 
                                :show-progress="true" 
                                :show-file-list="true" 
                            />
                        </div>
                    </div>

                    <!-- Parámetros del Componente -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Parámetros del Componente</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full">
                                <thead>
                                    <tr class="border-b border-gray-200 dark:border-gray-700">
                                        <th class="text-left py-2 px-3 text-sm font-medium text-gray-900 dark:text-white">Parámetro</th>
                                        <th class="text-left py-2 px-3 text-sm font-medium text-gray-900 dark:text-white">Tipo</th>
                                        <th class="text-left py-2 px-3 text-sm font-medium text-gray-900 dark:text-white">Por Defecto</th>
                                        <th class="text-left py-2 px-3 text-sm font-medium text-gray-900 dark:text-white">Descripción</th>
                                    </tr>
                                </thead>
                                <tbody class="text-sm">
                                    <tr class="border-b border-gray-100 dark:border-gray-700">
                                        <td class="py-2 px-3 font-mono text-primary-600 dark:text-primary-400">height</td>
                                        <td class="py-2 px-3 text-gray-600 dark:text-gray-400">string</td>
                                        <td class="py-2 px-3 text-gray-600 dark:text-gray-400">'400px'</td>
                                        <td class="py-2 px-3 text-gray-600 dark:text-gray-400">Altura del visor PDF</td>
                                    </tr>
                                    <tr class="border-b border-gray-100 dark:border-gray-700">
                                        <td class="py-2 px-3 font-mono text-primary-600 dark:text-primary-400">max-file-size</td>
                                        <td class="py-2 px-3 text-gray-600 dark:text-gray-400">number</td>
                                        <td class="py-2 px-3 text-gray-600 dark:text-gray-400">50</td>
                                        <td class="py-2 px-3 text-gray-600 dark:text-gray-400">Tamaño máximo de archivo en MB</td>
                                    </tr>
                                    <tr class="border-b border-gray-100 dark:border-gray-700">
                                        <td class="py-2 px-3 font-mono text-primary-600 dark:text-primary-400">show-progress</td>
                                        <td class="py-2 px-3 text-gray-600 dark:text-gray-400">boolean</td>
                                        <td class="py-2 px-3 text-gray-600 dark:text-gray-400">true</td>
                                        <td class="py-2 px-3 text-gray-600 dark:text-gray-400">Mostrar barra de progreso</td>
                                    </tr>
                                    <tr>
                                        <td class="py-2 px-3 font-mono text-primary-600 dark:text-primary-400">show-file-list</td>
                                        <td class="py-2 px-3 text-gray-600 dark:text-gray-400">boolean</td>
                                        <td class="py-2 px-3 text-gray-600 dark:text-gray-400">true</td>
                                        <td class="py-2 px-3 text-gray-600 dark:text-gray-400">Mostrar lista de archivos</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Uso del Componente -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Uso del Componente</h3>
                            <p class="text-gray-600 dark:text-gray-400 mt-1">Sintaxis para usar el componente PDF Viewer</p>
                        </div>
                        <div class="bg-gray-900 p-6 overflow-x-auto">
                            <pre class="text-green-400 text-sm"><code>&lt;x-pdf-viewer 
    height="400px" 
    :max-file-size="50" 
    :show-progress="true" 
    :show-file-list="true" 
/&gt;

&lt;!-- Ejemplo con parámetros personalizados --&gt;
&lt;x-pdf-viewer 
    height="300px" 
    :max-file-size="25" 
    :show-progress="false" 
    :show-file-list="false" 
/&gt;</code></pre>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Notificaciones Toast -->
            <section id="toasts" class="mb-16">
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Sistema de Notificaciones Toast</h2>
                    <p class="text-gray-600 dark:text-gray-400">Notificaciones no intrusivas con diferentes variantes y configuraciones</p>
                </div>

                <div class="space-y-8">
                    <!-- Descripción del Sistema -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 border border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Características del Sistema</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h4 class="font-medium text-gray-900 dark:text-white mb-2">Tipos de Notificación</h4>
                                <ul class="text-sm text-gray-600 dark:text-gray-400 space-y-1">
                                    <li>• Éxito (Success) - Operaciones completadas</li>
                                    <li>• Error - Errores del sistema o validación</li>
                                    <li>• Advertencia (Warning) - Atención requerida</li>
                                    <li>• Información (Info) - Mensajes informativos</li>
                                </ul>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-900 dark:text-white mb-2">Funcionalidades</h4>
                                <ul class="text-sm text-gray-600 dark:text-gray-400 space-y-1">
                                    <li>• Auto-dismiss configurable</li>
                                    <li>• Cierre manual por usuario</li>
                                    <li>• Stack automático para múltiples toasts</li>
                                    <li>• Animaciones suaves de entrada/salida</li>
                                    <li>• Posicionamiento fijo (esquina superior derecha)</li>
                                    <li>• Títulos estáticos por tipo de notificación</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Componente de Prueba del Toast -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Botón de Prueba Simple</h3>
                            <p class="text-gray-600 dark:text-gray-400 mt-1">
                                Un botón simple que emite eventos con parámetros configurables
                            </p>
                        </div>
                        <div class="p-6 space-y-6">
                            <!-- Ejemplo básico -->
                            <div>
                                <h4 class="text-md font-medium text-gray-900 dark:text-white mb-3">Ejemplo Básico</h4>
                                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                    <livewire:button-test />
                                </div>
                            </div>

                            <!-- Ejemplos con parámetros -->
                            <div>
                                <h4 class="text-md font-medium text-gray-900 dark:text-white mb-3">Ejemplos con Parámetros</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <!-- Toast de éxito -->
                                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Toast de Éxito:</p>
                                        <livewire:button-test 
                                            event="toast:success" 
                                            label="Éxito" 
                                            message="¡Operación completada!" />
                                    </div>

                                    <!-- Toast de error -->
                                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Toast de Error:</p>
                                        <livewire:button-test 
                                            event="toast:error" 
                                            label="Error" 
                                            message="Algo salió mal" />
                                    </div>

                                    <!-- Toast de advertencia -->
                                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Toast de Advertencia:</p>
                                        <livewire:button-test 
                                            event="toast:warning" 
                                            label="Advertencia" 
                                            message="Atención requerida" />
                                    </div>

                                    <!-- Toast de información -->
                                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Toast de Información:</p>
                                        <livewire:button-test 
                                            event="toast:info" 
                                            label="Info" 
                                            message="Información útil" />
                                    </div>
                                </div>
                            </div>

                            <!-- Código de ejemplo -->
                            <div>
                                <h4 class="text-md font-medium text-gray-900 dark:text-white mb-3">Código de Ejemplo</h4>
                                <div class="bg-gray-900 rounded-lg p-4">
                                    <pre class="text-green-400 text-sm"><code>{{-- Uso básico --}}
&lt;livewire:button-test /&gt;

{{-- Con parámetros personalizados --}}
&lt;livewire:button-test 
    event="toast:success" 
    label="Guardar" 
    message="Datos guardados correctamente" /&gt;

{{-- Evento personalizado con datos extra --}}
&lt;livewire:button-test 
    event="custom-event" 
    label="Acción" 
    message="Evento disparado"
    :event-data="['extra' => 'data']" /&gt;</code></pre>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Documentación de Uso -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 border border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Implementación</h3>
                        
                        <div class="space-y-6">
                            <!-- Uso desde Livewire -->
                            <div>
                                <h4 class="font-medium text-gray-900 dark:text-white mb-3">Desde Componentes Livewire</h4>
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                    <pre class="text-sm text-gray-800 dark:text-gray-200"><code>// Notificación de éxito
$this->dispatch('toast:success', [
    'message' => 'Operación completada exitosamente',
    'duration' => 5000
]);

// Notificación de error
$this->dispatch('toast:error', [
    'message' => 'Error al procesar la solicitud'
]);

// Notificación persistente (sin auto-dismiss)
$this->dispatch('toast:info', [
    'message' => 'Información importante',
    'duration' => 0
]);</code></pre>
                                </div>
                            </div>

                            <!-- Uso desde JavaScript -->
                            <div>
                                <h4 class="font-medium text-gray-900 dark:text-white mb-3">Desde JavaScript</h4>
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                    <pre class="text-sm text-gray-800 dark:text-gray-200"><code>// Funciones globales disponibles
showSuccessToast('Mensaje de éxito');
showErrorToast('Mensaje de error', 8000);
showWarningToast('Advertencia', 3000);
showInfoToast('Información');

// Función genérica
showToast('success', 'Mensaje', 5000);</code></pre>
                                </div>
                            </div>

                            <!-- Eventos Disponibles -->
                            <div>
                                <h4 class="font-medium text-gray-900 dark:text-white mb-3">Eventos Livewire</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="space-y-2">
                                        <div class="bg-green-50 dark:bg-green-900/20 p-3 rounded border border-green-200 dark:border-green-800">
                                            <code class="text-sm font-mono text-green-700 dark:text-green-300">toast:success</code>
                                        </div>
                                        <div class="bg-red-50 dark:bg-red-900/20 p-3 rounded border border-red-200 dark:border-red-800">
                                            <code class="text-sm font-mono text-red-700 dark:text-red-300">toast:error</code>
                                        </div>
                                    </div>
                                    <div class="space-y-2">
                                        <div class="bg-yellow-50 dark:bg-yellow-900/20 p-3 rounded border border-yellow-200 dark:border-yellow-800">
                                            <code class="text-sm font-mono text-yellow-700 dark:text-yellow-300">toast:warning</code>
                                        </div>
                                        <div class="bg-blue-50 dark:bg-blue-900/20 p-3 rounded border border-blue-200 dark:border-blue-800">
                                            <code class="text-sm font-mono text-blue-700 dark:text-blue-300">toast:info</code>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Parámetros -->
                            <div>
                                <h4 class="font-medium text-gray-900 dark:text-white mb-3">Parámetros</h4>
                                <div class="overflow-x-auto">
                                    <table class="min-w-full text-sm">
                                        <thead class="bg-gray-50 dark:bg-gray-700">
                                            <tr>
                                                <th class="px-4 py-3 text-left font-medium text-gray-900 dark:text-white">Parámetro</th>
                                                <th class="px-4 py-3 text-left font-medium text-gray-900 dark:text-white">Tipo</th>
                                                <th class="px-4 py-3 text-left font-medium text-gray-900 dark:text-white">Requerido</th>
                                                <th class="px-4 py-3 text-left font-medium text-gray-900 dark:text-white">Descripción</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                                            <tr>
                                                <td class="px-4 py-3 font-mono text-gray-900 dark:text-white">message</td>
                                                <td class="px-4 py-3 text-gray-600 dark:text-gray-400">string</td>
                                                <td class="px-4 py-3 text-green-600 dark:text-green-400">Sí</td>
                                                <td class="px-4 py-3 text-gray-600 dark:text-gray-400">Contenido del mensaje</td>
                                            </tr>
                                            <tr>
                                                <td class="px-4 py-3 font-mono text-gray-900 dark:text-white">duration</td>
                                                <td class="px-4 py-3 text-gray-600 dark:text-gray-400">int|null</td>
                                                <td class="px-4 py-3 text-gray-500 dark:text-gray-500">No</td>
                                                <td class="px-4 py-3 text-gray-600 dark:text-gray-400">Duración en ms (0 = persistente)</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Mejores Prácticas -->
                    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-blue-900 dark:text-blue-200 mb-4">Mejores Prácticas</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h4 class="font-medium text-blue-900 dark:text-blue-200 mb-2">Cuándo Usar</h4>
                                <ul class="text-sm text-blue-800 dark:text-blue-300 space-y-1">
                                    <li>• Confirmación de acciones exitosas</li>
                                    <li>• Notificación de errores de validación</li>
                                    <li>• Alertas de proceso en curso</li>
                                    <li>• Información contextual no crítica</li>
                                </ul>
                            </div>
                            <div>
                                <h4 class="font-medium text-blue-900 dark:text-blue-200 mb-2">Consideraciones</h4>
                                <ul class="text-sm text-blue-800 dark:text-blue-300 space-y-1">
                                    <li>• Mensajes claros y concisos</li>
                                    <li>• Duración apropiada según importancia</li>
                                    <li>• No abusar de toasts persistentes</li>
                                    <li>• Evitar múltiples toasts simultáneos</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Feedback -->
            <section id="feedback" class="mb-16">`
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Estados de Feedback</h2>
                    <p class="text-gray-600 dark:text-gray-400">Componentes para mostrar estados y notificaciones</p>
                </div>

                <div class="space-y-6">
                    <!-- Alertas -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Alertas</h3>
                        <div class="space-y-4">
                            <div class="p-4 bg-success-50 border border-success-200 rounded-md dark:bg-success-900/50 dark:border-success-800">
                                <div class="flex items-center">
                                    <span class="icon-[mdi--check-circle] w-5 h-5 text-success-500 mr-3"></span>
                                    <div>
                                        <h4 class="text-sm font-medium text-success-800 dark:text-success-200">Operación Exitosa</h4>
                                        <p class="text-sm text-success-700 dark:text-success-300 mt-1">El diploma académico se ha guardado correctamente.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="p-4 bg-warning-50 border border-warning-200 rounded-md dark:bg-warning-900/50 dark:border-warning-800">
                                <div class="flex items-center">
                                    <span class="icon-[mdi--alert] w-5 h-5 text-warning-500 mr-3"></span>
                                    <div>
                                        <h4 class="text-sm font-medium text-warning-800 dark:text-warning-200">Advertencia</h4>
                                        <p class="text-sm text-warning-700 dark:text-warning-300 mt-1">Algunos campos requieren verificación adicional.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="p-4 bg-error-50 border border-error-200 rounded-md dark:bg-error-900/50 dark:border-error-800">
                                <div class="flex items-center">
                                    <span class="icon-[mdi--alert-circle] w-5 h-5 text-error-500 mr-3"></span>
                                    <div>
                                        <h4 class="text-sm font-medium text-error-800 dark:text-error-200">Error</h4>
                                        <p class="text-sm text-error-700 dark:text-error-300 mt-1">No se pudo procesar la solicitud. Verifique los datos ingresados.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="p-4 bg-info-50 border border-info-200 rounded-md dark:bg-info-900/50 dark:border-info-800">
                                <div class="flex items-center">
                                    <span class="icon-[mdi--information] w-5 h-5 text-info-500 mr-3"></span>
                                    <div>
                                        <h4 class="text-sm font-medium text-info-800 dark:text-info-200">Información</h4>
                                        <p class="text-sm text-info-700 dark:text-info-300 mt-1">Recuerde que puede descargar una copia del diploma en formato PDF.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Estados de Carga -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Estados de Carga</h3>
                        <div class="space-y-4">
                            <div class="flex items-center space-x-3">
                                <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-primary-600"></div>
                                <span class="text-sm text-gray-600 dark:text-gray-400">Cargando datos...</span>
                            </div>
                            <div class="flex items-center space-x-3">
                                <div class="flex space-x-1">
                                    <div class="w-2 h-2 bg-primary-600 rounded-full animate-bounce"></div>
                                    <div class="w-2 h-2 bg-primary-600 rounded-full animate-bounce" style="animation-delay: 0.1s"></div>
                                    <div class="w-2 h-2 bg-primary-600 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                                </div>
                                <span class="text-sm text-gray-600 dark:text-gray-400">Procesando archivo...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Footer -->
            <footer class="border-t border-gray-200 dark:border-gray-700 pt-8">
                <div class="text-center">
                    <p class="text-gray-600 dark:text-gray-400 text-sm">
                        Guía de Estilos - Sistema de Títulos UATF
                    </p>
                    <p class="text-gray-500 dark:text-gray-500 text-xs mt-1">
                        Universidad Autónoma Tomás Frías, Potosí - Bolivia
                    </p>
                </div>
            </footer>
        </main>
    </div>

    <!-- Toast Manager Component -->
    @php

    @endphp

    <!-- Scripts para navegación suave y modo oscuro -->
    <script>
        // Navegación suave para los enlaces de la guía
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Resaltar sección activa en navegación
        const sections = document.querySelectorAll('section[id]');
        const navLinks = document.querySelectorAll('nav a[href^="#"]');

        window.addEventListener('scroll', () => {
            let current = '';
            sections.forEach(section => {
                const sectionTop = section.offsetTop;
                const sectionHeight = section.clientHeight;
                if (scrollY >= sectionTop - 200) {
                    current = section.getAttribute('id');
                }
            });

            navLinks.forEach(link => {
                link.classList.remove('text-primary-600', 'dark:text-primary-400');
                link.classList.add('text-gray-700', 'dark:text-gray-300');
                if (link.getAttribute('href') === `#${current}`) {
                    link.classList.remove('text-gray-700', 'dark:text-gray-300');
                    link.classList.add('text-primary-600', 'dark:text-primary-400');
                }
            });
        });

        // Dark Mode con Alpine.js (Esperando que Alpine esté listo)
        // Función Alpine.js para Dark Mode Toggle
        function darkModeToggle() {
            return {
                isDark: false,
                
                init() {
                    // Inicializar tema basado en preferencia guardada o sistema
                    const savedTheme = localStorage.getItem('theme');
                    const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                    
                    this.isDark = savedTheme === 'dark' || (!savedTheme && systemPrefersDark);
                    this.applyTheme();
                    
                    // Escuchar cambios en preferencia del sistema
                    window.matchMedia('(prefers-color-scheme: dark)')
                          .addEventListener('change', (e) => {
                        if (!localStorage.getItem('theme')) {
                            this.isDark = e.matches;
                            this.applyTheme();
                        }
                    });
                },
                
                toggle() {
                    this.isDark = !this.isDark;
                    this.applyTheme();
                    localStorage.setItem('theme', this.isDark ? 'dark' : 'light');
                },
                
                applyTheme() {
                    document.documentElement.classList.toggle('dark', this.isDark);
                }
            }
        }
    </script>
    


    <!-- Toast Component - Global para el style guide -->
    <livewire:toast />
    
    @livewireScriptConfig
</body>
</html>