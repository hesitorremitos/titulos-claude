<?php

namespace App\Livewire;

use App\Livewire\Forms\DiplomaAcademicoForm as DiplomaForm;

class DiplomaAcademicoFormComponent extends BaseTituloFormComponent
{
    public DiplomaForm $tituloForm;

    protected function handleCarreraSelection(string $carreraId): void
    {
        $this->tituloForm->loadMenciones($carreraId);
    }

    protected function resetTituloSpecificData(): void
    {
        $this->tituloForm->menciones = [];
    }

    protected function getSpecificListeners(): array
    {
        return []; // No hay listeners específicos adicionales para diploma académico
    }

    protected function getSuccessMessage(): string
    {
        return 'Diploma académico registrado exitosamente';
    }

    // Método de compatibilidad para el template existente
    public function saveDiploma()
    {
        $this->saveTitulo();
    }

    public function render()
    {
        return view('livewire.diploma-academico-form');
    }
}
