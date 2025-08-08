<?php

namespace App\Livewire;

use App\Livewire\Forms\PersonaForm;
use App\Livewire\Traits\HandlesTituloOperations;
use App\Services\UserHelperService;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;

abstract class BaseTituloFormComponent extends Component
{
    use WithFileUploads, HandlesTituloOperations;

    // Forms
    public PersonaForm $personaForm;
    
    // Esta propiedad será sobrescrita por las clases hijas
    // Ejemplo: public DiplomaAcademicoForm $tituloForm;

    protected $listeners = [];

    public function mount()
    {
        // Combinar listeners comunes con específicos
        $this->listeners = array_merge($this->commonListeners, $this->getSpecificListeners());
        
        $this->tituloForm->loadGraduaciones();
        $this->personaForm->pais = 'Bolivia'; // Valor por defecto
        
        // Llamar inicialización específica si existe
        $this->mountSpecific();
    }

    public function saveTitulo()
    {
        try {
            // Validar datos de persona
            $this->personaForm->validate();

            if (empty($this->personaForm->ci)) {
                session()->flash('error', 'No se han completado los datos de la persona.');
                return;
            }

            $userId = UserHelperService::getCurrentUserId();

            DB::transaction(function () use ($userId) {
                // Crear o actualizar la persona
                $this->personaForm->createOrUpdatePerson();

                // Guardar el título
                $this->tituloForm->store($this->personaForm->ci, $userId);
            });

            session()->flash('success', $this->getSuccessMessage());

            // Reset del formulario
            $this->resetForm();

        } catch (\Exception $e) {
            session()->flash('error', 'Error al registrar el título: '.$e->getMessage());
        }
    }

    // Métodos abstractos que deben implementar las clases hijas
    abstract protected function getSpecificListeners(): array;
    abstract protected function getSuccessMessage(): string;
    abstract public function render();
    
    // Métodos opcionales que pueden ser sobrescritos
    protected function mountSpecific(): void 
    {
        // Implementación vacía por defecto
    }
}