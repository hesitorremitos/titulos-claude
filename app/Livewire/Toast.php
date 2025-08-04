<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;

class Toast extends Component
{
    // Propiedades del toast
    public array $toasts = [];

    // Configuración de auto-dismiss
    public int $autoDismissTime = 5000; // 5 segundos por defecto

    /**
     * Escucha el evento 'toast:show' para mostrar un nuevo toast
     * 
     * @param array $data Datos del toast con keys: type, message, duration
     */
    #[On('toast:show')]
    public function showToast($type = 'info', $message = '', $duration = null)
    {
        // Si se pasa un array (desde dispatch), extraer los valores
        if (is_array($type)) {
            $data = $type;
            $type = $data['type'] ?? 'info';
            $message = $data['message'] ?? '';
            $duration = $data['duration'] ?? null;
        }

        $toastId = uniqid();
        
        $toast = [
            'id' => $toastId,
            'type' => $type,
            'title' => $this->getToastTitle($type),
            'message' => $message,
            'duration' => $duration ?? $this->autoDismissTime,
            'timestamp' => time(),
        ];

        $this->toasts[] = $toast;
    }

    /**
     * Escucha múltiples eventos de toast con diferentes tipos
     */
    #[On('toast:success')]
    public function showSuccessToast(array $data = [])
    {
        $message = $data['message'] ?? '';
        $duration = $data['duration'] ?? null;
        $this->showToast('success', $message, $duration);
    }

    #[On('toast:error')]
    public function showErrorToast(array $data = [])
    {
        $message = $data['message'] ?? '';
        $duration = $data['duration'] ?? null;
        $this->showToast('error', $message, $duration);
    }

    #[On('toast:warning')]
    public function showWarningToast(array $data = [])
    {
        $message = $data['message'] ?? '';
        $duration = $data['duration'] ?? null;
        $this->showToast('warning', $message, $duration);
    }

    #[On('toast:info')]
    public function showInfoToast(array $data = [])
    {
        $message = $data['message'] ?? '';
        $duration = $data['duration'] ?? null;
        $this->showToast('info', $message, $duration);
    }

    /**
     * Elimina un toast específico
     */
    public function dismissToast(string $toastId)
    {
        $this->toasts = array_filter($this->toasts, function ($toast) use ($toastId) {
            return $toast['id'] !== $toastId;
        });

        // Reindexar el array para mantener índices secuenciales
        $this->toasts = array_values($this->toasts);
    }

    /**
     * Elimina todos los toasts
     */
    public function clearAllToasts()
    {
        $this->toasts = [];
    }

    /**
     * Obtiene el título estático para cada tipo de toast
     */
    public function getToastTitle(string $type): string
    {
        $titles = [
            'success' => 'Éxito',
            'error' => 'Error',
            'warning' => 'Advertencia',
            'info' => 'Información',
        ];

        return $titles[$type] ?? $titles['info'];
    }

    /**
     * Obtiene las clases CSS para cada tipo de toast
     */
    public function getToastClasses(string $type): string
    {
        $baseClasses = 'flex items-center w-full max-w-xs p-4 mb-4 text-gray-500 bg-white rounded-lg shadow';
        
        $typeClasses = [
            'success' => 'text-green-500 bg-green-50 border border-green-200',
            'error' => 'text-red-500 bg-red-50 border border-red-200',
            'warning' => 'text-yellow-500 bg-yellow-50 border border-yellow-200',
            'info' => 'text-blue-500 bg-blue-50 border border-blue-200',
        ];

        return $baseClasses . ' ' . ($typeClasses[$type] ?? $typeClasses['info']);
    }

    /**
     * Obtiene el ícono SVG para cada tipo de toast
     */
    public function getToastIcon(string $type): string
    {
        $icons = [
            'success' => '<svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                          </svg>',
            'error' => '<svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                          <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z"/>
                        </svg>',
            'warning' => '<svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM10 15a1 1 0 1 1 0-2 1 1 0 0 1 0 2Zm1-4a1 1 0 0 1-2 0V6a1 1 0 0 1 2 0v5Z"/>
                          </svg>',
            'info' => '<svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                         <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                       </svg>',
        ];

        return $icons[$type] ?? $icons['info'];
    }

    public function render()
    {
        return view('livewire.toast');
    }
}
