<div class="space-y-4">
    <!-- Área de subida de archivo -->
    <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-6 text-center">
        <div class="space-y-4">
            <!-- Input de archivo -->
            <div>
                <input 
                    type="file" 
                    wire:model.live="pdfFile" 
                    accept=".pdf"
                    class="hidden" 
                    id="pdfFileInput"
                >
                <label 
                    for="pdfFileInput" 
                    class="cursor-pointer inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md transition-colors duration-200"
                >
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                    </svg>
                    Seleccionar PDF
                </label>
            </div>

            <!-- Indicador de carga -->
            <div wire:loading wire:target="pdfFile" class="text-blue-600 dark:text-blue-400">
                <svg class="animate-spin h-5 w-5 mx-auto" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <p class="mt-2 text-sm">Procesando archivo...</p>
            </div>

            <!-- Mensaje de estado -->
            @if($uploadMessage)
                <div class="text-sm p-3 rounded-md {{ str_contains($uploadMessage, '✅') ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">
                    {!! $uploadMessage !!}
                </div>
            @endif

            <!-- Errores de validación -->
            @error('pdfFile')
                <div class="text-sm text-red-600 dark:text-red-400 bg-red-100 dark:bg-red-900 p-3 rounded-md">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>

    <!-- Resultado de la búsqueda -->
    @if($searchPerformed)
        <div class="border rounded-lg p-4 {{ $foundDiploma ? 'border-green-300 bg-green-50 dark:border-green-600 dark:bg-green-900/20' : 'border-orange-300 bg-orange-50 dark:border-orange-600 dark:bg-orange-900/20' }}">
            @if($foundDiploma)
                <div class="flex justify-between items-start">
                    <div class="space-y-2">
                        <h4 class="font-medium text-green-800 dark:text-green-200">
                            Diploma Encontrado y Actualizado
                        </h4>
                        <div class="text-sm text-green-700 dark:text-green-300 space-y-1">
                            <p><strong>Persona:</strong> {{ $foundDiploma->persona->nombre_completo }}</p>
                            <p><strong>CI:</strong> {{ $foundDiploma->persona->ci }}</p>
                            <p><strong>Mención:</strong> {{ $foundDiploma->mencion->nombre }}</p>
                            <p><strong>Carrera:</strong> {{ $foundDiploma->mencion->carrera->programa }}</p>
                            <p><strong>Documento:</strong> Nro. {{ $foundDiploma->nro_documento }}, Libro {{ $foundDiploma->libro }}, Fojas {{ $foundDiploma->fojas }}</p>
                            @if($foundDiploma->fecha_emision)
                                <p><strong>Fecha emisión:</strong> {{ $foundDiploma->fecha_emision->format('d/m/Y') }}</p>
                            @endif
                        </div>
                        <div class="flex space-x-2 mt-3">
                            @can('ver-titulos')
                                <a href="{{ route('diplomas.show', $foundDiploma) }}" 
                                   class="inline-flex items-center px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white text-xs rounded-md transition-colors duration-200">
                                    Ver Diploma
                                </a>
                            @endcan
                            @if($foundDiploma->file_dir)
                                <a href="{{ route('diplomas.download', $foundDiploma) }}" 
                                   class="inline-flex items-center px-3 py-1 bg-green-600 hover:bg-green-700 text-white text-xs rounded-md transition-colors duration-200">
                                    Descargar PDF
                                </a>
                            @endif
                        </div>
                    </div>
                    <button 
                        wire:click="clearSearch" 
                        class="text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-200"
                        title="Cerrar"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            @else
                <div class="flex justify-between items-start">
                    <div>
                        <h4 class="font-medium text-orange-800 dark:text-orange-200 mb-2">
                            No se encontró el diploma
                        </h4>
                        <p class="text-sm text-orange-700 dark:text-orange-300">
                            No existe un diploma académico registrado para el CI extraído del archivo.
                            <br>Verifique que el CI esté correctamente registrado en el sistema.
                        </p>
                    </div>
                    <button 
                        wire:click="clearSearch" 
                        class="text-orange-600 hover:text-orange-800 dark:text-orange-400 dark:hover:text-orange-200"
                        title="Cerrar"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            @endif
        </div>
    @endif
</div>