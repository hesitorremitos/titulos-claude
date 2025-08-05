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
