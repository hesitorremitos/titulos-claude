<!-- Sidebar -->
<aside class="w-64 bg-gray-50 dark:bg-gray-900 border-r border-gray-200 dark:border-gray-700 flex-shrink-0">
    <!-- Logo/Header del Sidebar -->
    <x-sidebar-header />

    <!-- Navegación del Sidebar -->
    <nav class="p-4 space-y-2">
        <!-- Sección: Menú Principal -->
        <x-sidebar-group title="Menú Principal" :default-open="true">
            <x-sidebar-link 
                href="{{ route('dashboard') }}" 
                icon="mdi--view-dashboard" 
                route-pattern="dashboard"
            >
                Dashboard
            </x-sidebar-link>
            
            <x-sidebar-link 
                href="{{ route('diplomas.index') }}" 
                icon="mdi--school" 
                route-pattern="diplomas.*"
            >
                Diplomas Académicos
            </x-sidebar-link>
            
            <x-sidebar-link 
                href="#" 
                icon="mdi--certificate"
            >
                Títulos Profesionales
            </x-sidebar-link>
            
            <x-sidebar-link 
                href="#" 
                icon="mdi--account-school"
            >
                Bachiller
            </x-sidebar-link>
        </x-sidebar-group>

        <!-- Sección: Administración -->
        <x-sidebar-group title="Administración" :default-open="true">
            <x-sidebar-link 
                href="{{ route('usuarios.index') }}" 
                icon="mdi--account-multiple" 
                route-pattern="usuarios.*"
            >
                Usuarios
            </x-sidebar-link>
            
            <x-sidebar-link 
                href="#" 
                icon="mdi--cog"
            >
                Configuración
            </x-sidebar-link>
        </x-sidebar-group>
    </nav>
</aside>