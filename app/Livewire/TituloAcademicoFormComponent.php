<?php

namespace App\Livewire;

use App\Livewire\Forms\TituloAcademicoForm;

class TituloAcademicoFormComponent extends BaseTituloFormComponent
{
    public TituloAcademicoForm $tituloForm;

    protected function handleCarreraSelection(string $carreraId): void
    {
        // Los títulos académicos no requieren menciones específicas
        // Solo se necesita la carrera para la API
    }

    protected function resetTituloSpecificData(): void
    {
        // No hay datos específicos adicionales que resetear
    }

    protected function getSpecificListeners(): array
    {
        return []; // No hay listeners específicos adicionales
    }

    protected function getSuccessMessage(): string
    {
        return 'Título académico registrado exitosamente';
    }

    public function render()
    {
        return view('livewire.titulo-academico-form');
    }
}
