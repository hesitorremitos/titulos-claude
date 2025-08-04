@props(['sectionTitle' => 'Diplomas Académicos', 'headerExtra' => null])

<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header with Title, Navigation and Actions in one row -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between space-y-4 lg:space-y-0">
                        <!-- Title -->
                        <div class="flex-shrink-0">
                            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                                {{ __('Diplomas Académicos') }}
                                @if($sectionTitle && $sectionTitle !== 'Diplomas Académicos')
                                    <span class="text-gray-500 dark:text-gray-400"> - {{ $sectionTitle }}</span>
                                @endif
                            </h2>
                        </div>

                        <!-- Navigation and Action Buttons -->
                        <div class="flex flex-col sm:flex-row sm:items-center space-y-3 sm:space-y-0 sm:space-x-6">
                            <!-- Quick Navigation -->
                            <nav class="flex space-x-1">
                                <a href="{{ route('diplomas.index') }}" 
                                   class="px-3 py-2 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('diplomas.index') ? 'bg-blue-100 text-blue-700 dark:bg-blue-900 dark:text-blue-300' : 'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                                    Lista
                                </a>
                                <a href="{{ route('diplomas.menciones.index') }}" 
                                   class="px-3 py-2 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('diplomas.menciones.*') ? 'bg-blue-100 text-blue-700 dark:bg-blue-900 dark:text-blue-300' : 'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                                    Menciones
                                </a>
                                <a href="{{ route('diplomas.modalidades.index') }}" 
                                   class="px-3 py-2 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('diplomas.modalidades.*') ? 'bg-blue-100 text-blue-700 dark:bg-blue-900 dark:text-blue-300' : 'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                                    Modalidades
                                </a>
                            </nav>
                            
                            <!-- Action Buttons -->
                            @if($headerExtra)
                                <div class="flex space-x-2">
                                    {{ $headerExtra }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            {{ $slot }}
        </div>
    </div>
</x-app-layout>
