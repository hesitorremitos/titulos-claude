<div>
    {{-- Contenedor de toasts posicionado de manera fija --}}
    @if(count($toasts) > 0)
        <div id="toast-container" 
             class="fixed top-4 right-4 z-50 space-y-2"
             style="z-index: 9999;">
            
            @foreach($toasts as $toast)
                <div id="toast-{{ $toast['id'] }}"
                     class="{{ $this->getToastClasses($toast['type']) }} toast-item transform transition-all duration-300 ease-in-out"
                     x-data="{ 
                        show: false,
                        toastId: '{{ $toast['id'] }}',
                        duration: {{ $toast['duration'] }}
                     }"
                     x-init="
                        show = true;
                        if (duration > 0) {
                            setTimeout(() => {
                                show = false;
                                setTimeout(() => {
                                    $wire.dismissToast(toastId);
                                }, 300);
                            }, duration);
                        }
                     "
                     x-show="show"
                     x-transition:enter="transform ease-out duration-300 transition"
                     x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
                     x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
                     x-transition:leave="transition ease-in duration-100"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0">
                    
                    {{-- Contenido del toast --}}
                    <div class="flex items-start">
                        {{-- Ícono --}}
                        <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 rounded-lg">
                            {!! $this->getToastIcon($toast['type']) !!}
                        </div>

                        {{-- Contenido del mensaje --}}
                        <div class="ml-3 text-sm font-normal flex-1">
                            <div class="text-sm font-semibold text-gray-900 mb-1">
                                {{ $toast['title'] }}
                            </div>
                            <div class="text-sm text-gray-600">
                                {{ $toast['message'] }}
                            </div>
                        </div>

                        {{-- Botón de cerrar --}}
                        <button type="button"
                                class="ml-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex h-8 w-8"
                                @click="
                                    show = false;
                                    setTimeout(() => {
                                        $wire.dismissToast('{{ $toast['id'] }}');
                                    }, 300);
                                "
                                aria-label="Cerrar">
                            <span class="sr-only">Cerrar</span>
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    {{-- Script para escuchar eventos de toast desde JavaScript --}}
    @script
    <script>
        // Escuchar eventos de toast dispatched desde el frontend
        document.addEventListener('livewire:init', () => {
            // Helper functions para disparar toasts desde JavaScript
            window.showToast = function(type, message, duration = null) {
                Livewire.dispatch('toast:show', {
                    type: type,
                    message: message,
                    duration: duration
                });
            };

            window.showSuccessToast = function(message, duration = null) {
                Livewire.dispatch('toast:success', {
                    message: message,
                    duration: duration
                });
            };

            window.showErrorToast = function(message, duration = null) {
                Livewire.dispatch('toast:error', {
                    message: message,
                    duration: duration
                });
            };

            window.showWarningToast = function(message, duration = null) {
                Livewire.dispatch('toast:warning', {
                    message: message,
                    duration: duration
                });
            };

            window.showInfoToast = function(message, duration = null) {
                Livewire.dispatch('toast:info', {
                    message: message,
                    duration: duration
                });
            };

            // Ya no necesitamos el listener toast:start-timer
            // La duración se maneja directamente en Alpine.js
        });
    </script>
    @endscript
</div>
