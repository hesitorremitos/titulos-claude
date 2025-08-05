<?php

namespace App\Livewire;

use Livewire\Component;

class ButtonTest extends Component
{
    // Propiedades del botón
    public string $event = 'toast:success';

    public string $label = 'Probar Toast';

    public string $message = 'Mensaje de prueba';

    public array $eventData = [];

    /**
     * Emite el evento configurado con los parámetros especificados
     */
    public function emitEvent()
    {
        // Preparar los datos del evento
        $data = array_merge([
            'message' => $this->message,
        ], $this->eventData);

        // Emitir el evento
        $this->dispatch($this->event, $data);
    }

    public function render()
    {
        return view('livewire.button-test');
    }
}
