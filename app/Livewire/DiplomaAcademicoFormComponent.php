<?php

namespace App\Livewire;

use App\Livewire\Forms\DiplomaAcademicoForm as DiplomaForm;
use App\Livewire\Forms\PersonaForm;
use App\Models\Carrera;
use App\Services\UniversityApiService;
use App\Services\UserHelperService;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;

class DiplomaAcademicoFormComponent extends Component
{
    use WithFileUploads;

    // Forms
    public PersonaForm $personaForm;

    public DiplomaForm $diplomaForm;

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

    protected $listeners = [
        'carrera-selected' => 'handleCarreraSelected',
        'pdf-uploaded-with-success' => 'handlePdfUploadedWithSuccess',
        'pdf-uploaded-manual-entry' => 'handlePdfUploadedManualEntry',
    ];

    public function mount()
    {
        $this->diplomaForm->loadGraduaciones();
        $this->personaForm->pais = 'Bolivia'; // Valor por defecto
    }

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

        // Buscar carrera correspondiente - datos verificados como iguales entre API y BD
        $carrera = Carrera::where('programa', $programa['programa'])->first();

        $this->selectedCarreraId = $carrera ? $carrera->id : null;

        // Cargar menciones si se encontró la carrera
        if ($this->selectedCarreraId) {
            $this->diplomaForm->loadMenciones($this->selectedCarreraId);
        }

        // Crear o actualizar persona
        $this->personaForm->createOrUpdatePerson();
    }

    public function handleCarreraSelected($carreraId)
    {
        $this->selectedCarreraId = $carreraId;
        $this->diplomaForm->loadMenciones($carreraId);
    }

    public function handlePdfUploadedWithSuccess($data)
    {
        // Llenar datos desde PDF y API
        $this->searchCi = $data['ci'];
        $this->fillFromApiData($data['apiData']);

        // Guardar información del archivo
        $this->diplomaForm->tempFilePath = $data['tempFilePath'];
        $this->diplomaForm->originalFileName = $data['originalFileName'];

        $this->personFound = true;
        session()->flash('message', 'Datos cargados automáticamente desde PDF y API universitaria.');
    }

    public function handlePdfUploadedManualEntry($data)
    {
        // Configurar para entrada manual
        $this->searchCi = $data['ci'];
        $this->personaForm->ci = $data['ci'];

        // Guardar información del archivo
        $this->diplomaForm->tempFilePath = $data['tempFilePath'];
        $this->diplomaForm->originalFileName = $data['originalFileName'];

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

    public function saveDiploma()
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

                // Guardar el diploma
                $this->diplomaForm->store($this->personaForm->ci, $userId);
            });

            session()->flash('success', 'Diploma académico registrado exitosamente');

            // Reset del formulario
            $this->resetForm();

        } catch (\Exception $e) {
            session()->flash('error', 'Error al registrar el diploma académico: '.$e->getMessage());
        }
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
        $this->diplomaForm->menciones = [];
    }

    private function resetForm(): void
    {
        $this->currentStep = 1;
        $this->searchCi = '';
        $this->resetPersonData();
        $this->diplomaForm->reset();
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

    public function render()
    {
        return view('livewire.diploma-academico-form');
    }
}
