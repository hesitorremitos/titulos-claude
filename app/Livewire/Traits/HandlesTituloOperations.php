<?php

namespace App\Livewire\Traits;

use App\Services\UniversityApiService;
use App\Models\Carrera;

trait HandlesTituloOperations
{
    // Control de pasos
    public int $currentStep = 1;

    // Búsqueda de persona
    public string $searchCi = '';
    public bool $isSearching = false;
    public array $apiData = [];
    public bool $personFound = false;
    public ?int $selectedProgramIndex = null;
    public ?string $selectedProgramName = null;
    public ?string $selectedCarreraId = null;

    protected $commonListeners = [
        'carrera-selected' => 'handleCarreraSelected',
        'pdf-uploaded-with-success' => 'handlePdfUploadedWithSuccess',
        'pdf-uploaded-manual-entry' => 'handlePdfUploadedManualEntry',
    ];

    public function searchPersonInApi()
    {
        $this->validate(['searchCi' => 'required|string|min:6|max:20']);

        $this->isSearching = true;
        $this->resetPersonData();

        try {
            $apiService = new UniversityApiService;
            $result = $apiService->searchPersonByCi($this->searchCi);

            if ($result['success']) {
                $this->fillFromApiData($result['data']);
                $this->personFound = true;
                session()->flash('message', $result['message']);
            } else {
                $this->personaForm->ci = $this->searchCi;
                $this->personFound = false;
                session()->flash('error', $result['message']);
            }
        } catch (\Exception $e) {
            $this->personaForm->ci = $this->searchCi;
            $this->personFound = false;
            session()->flash('error', 'Error inesperado al consultar la API: '.$e->getMessage());
        } finally {
            $this->isSearching = false;
        }
    }

    public function selectProgram(int $index)
    {
        if (! isset($this->apiData['programas'][$index])) {
            return;
        }

        $programa = $this->apiData['programas'][$index];
        $this->selectedProgramIndex = $index;
        $this->selectedProgramName = $programa['programa'];

        // Buscar carrera correspondiente
        $carrera = Carrera::where('programa', $programa['programa'])->first();
        $this->selectedCarreraId = $carrera ? $carrera->id : null;

        // Llamar método específico del título para cargar datos relacionados
        if ($this->selectedCarreraId) {
            $this->handleCarreraSelection($this->selectedCarreraId);
        }

        // Crear o actualizar persona
        $this->personaForm->createOrUpdatePerson();
    }

    public function handleCarreraSelected($carreraId)
    {
        $this->selectedCarreraId = $carreraId;
        $this->handleCarreraSelection($carreraId);
    }

    public function handlePdfUploadedWithSuccess($data)
    {
        // Llenar datos desde PDF y API
        $this->searchCi = $data['ci'];
        $this->fillFromApiData($data['apiData']);

        // Guardar información del archivo
        $this->tituloForm->tempFilePath = $data['tempFilePath'];
        $this->tituloForm->originalFileName = $data['originalFileName'];

        $this->personFound = true;
        session()->flash('message', 'Datos cargados automáticamente desde PDF y API universitaria.');
    }

    public function handlePdfUploadedManualEntry($data)
    {
        // Configurar para entrada manual
        $this->searchCi = $data['ci'];
        $this->personaForm->ci = $data['ci'];

        // Guardar información del archivo
        $this->tituloForm->tempFilePath = $data['tempFilePath'];
        $this->tituloForm->originalFileName = $data['originalFileName'];

        $this->personFound = false;
        session()->flash('message', 'CI extraído del PDF. Complete los datos personales manualmente.');
    }

    public function nextStep()
    {
        if ($this->currentStep === 1) {
            if (! $this->personaForm->isComplete()) {
                session()->flash('error', 'Complete los datos personales obligatorios.');
                return;
            }

            // Si encontró persona en API, debe seleccionar un programa
            if ($this->personFound && ! empty($this->apiData['programas']) && $this->selectedProgramIndex === null) {
                session()->flash('error', 'Debe seleccionar un programa académico para continuar.');
                return;
            }

            $this->currentStep = 2;
        }
    }

    public function previousStep()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }

    public function getPersonDataComplete(): bool
    {
        $personaComplete = $this->personaForm->isComplete();

        // Si encontró persona en API, debe seleccionar un programa
        if ($this->personFound && ! empty($this->apiData['programas'])) {
            return $personaComplete && $this->selectedProgramIndex !== null;
        }

        // Si no encontró en API, solo necesita datos de persona completos
        return $personaComplete;
    }

    private function fillFromApiData(array $data): void
    {
        $this->apiData = $data;
        $this->personaForm->fillFromApiData($data);

        // Auto-seleccionar si solo hay un programa
        if (count($data['programas']) === 1) {
            $this->selectProgram(0);
        }
    }

    private function resetPersonData(): void
    {
        $this->apiData = [];
        $this->personFound = false;
        $this->selectedProgramIndex = null;
        $this->selectedProgramName = null;
        $this->selectedCarreraId = null;
        $this->personaForm->reset();
        
        // Llamar método específico para resetear datos del título
        $this->resetTituloSpecificData();
    }

    protected function resetForm(): void
    {
        $this->currentStep = 1;
        $this->searchCi = '';
        $this->resetPersonData();
        $this->tituloForm->reset();
    }

    // Métodos abstractos que deben implementar las clases hijas
    abstract protected function handleCarreraSelection(string $carreraId): void;
    abstract protected function resetTituloSpecificData(): void;
}