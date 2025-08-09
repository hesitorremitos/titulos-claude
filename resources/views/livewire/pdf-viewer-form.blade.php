<div class="w-full h-full">
    <!-- PDF Viewer Section -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 h-full flex flex-col">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4 rounded-t-lg">
            <h3 class="text-lg font-semibold text-white flex items-center">
                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                </svg>
                Visor de PDF
            </h3>
            <p class="text-blue-100 text-sm mt-1">
                @if($currentStep === 1)
                    Sube o selecciona un archivo PDF para visualizar
                @else
                    Vista previa del documento del diploma
                @endif
            </p>
        </div>

        <!-- Content Area -->
        <div class="flex-1 p-6 min-h-0 flex flex-col">
            @if($error)
                <!-- Error State -->
                <div class="flex items-center justify-center h-full">
                    <div class="text-center">
                        <svg class="w-16 h-16 text-red-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Error al cargar PDF</h3>
                        <p class="text-red-600 dark:text-red-400 text-sm">{{ $error }}</p>
                        <button wire:click="removePdf" 
                            class="mt-4 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                            Reintentar
                        </button>
                    </div>
                </div>
            @elseif($isLoading)
                <!-- Loading State -->
                <div class="flex items-center justify-center h-full">
                    <div class="text-center">
                        <svg class="animate-spin w-12 h-12 text-blue-600 mx-auto mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <p class="text-gray-600 dark:text-gray-400">Cargando PDF...</p>
                    </div>
                </div>
            @elseif($pdfUrl && $fileName)
                <!-- PDF Loaded State -->
                <div class="flex flex-col h-full">
                    <!-- File Info Bar -->
                    <div class="flex items-center justify-between mb-4 p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <div class="flex items-center space-x-3">
                            <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                            <div>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $fileName }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ number_format($fileSize / 1024 / 1024, 2) }} MB
                                </p>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-2">
                            <!-- Fullscreen Button -->
                            <button onclick="openFullscreen('pdf-viewer-iframe')" 
                                class="p-2 text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white transition-colors"
                                title="Pantalla completa">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path>
                                </svg>
                            </button>
                            
                            <!-- Remove Button -->
                            <button wire:click="removePdf" 
                                class="p-2 text-gray-600 hover:text-red-600 dark:text-gray-400 dark:hover:text-red-400 transition-colors"
                                title="Quitar archivo">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- PDF Viewer -->
                    <div class="flex-1 min-h-0">
                        <iframe id="pdf-viewer-iframe"
                            src="{{ $pdfUrl }}"
                            class="w-full h-full border border-gray-300 dark:border-gray-600 rounded-lg"
                            title="Visor PDF">
                        </iframe>
                    </div>
                </div>
            @else
                <!-- Empty State - Display Only -->
                <div class="flex items-center justify-center h-full">
                    <div class="text-center max-w-sm mx-auto">
                        <div class="space-y-4">
                            <div>
                                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            
                            <div>
                                <p class="text-lg font-medium text-gray-900 dark:text-white mb-2">
                                    Esperando archivo PDF
                                </p>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                                    @if($currentStep === 1)
                                        Suba un archivo PDF utilizando una de las opciones del formulario
                                    @else
                                        El PDF aparecerá aquí cuando sea seleccionado
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Fullscreen Script -->
<script>
function openFullscreen(iframeId) {
    const iframe = document.getElementById(iframeId);
    if (iframe) {
        if (iframe.requestFullscreen) {
            iframe.requestFullscreen();
        } else if (iframe.webkitRequestFullscreen) { /* Safari */
            iframe.webkitRequestFullscreen();
        } else if (iframe.msRequestFullscreen) { /* IE11 */
            iframe.msRequestFullscreen();
        }
    }
}
</script>