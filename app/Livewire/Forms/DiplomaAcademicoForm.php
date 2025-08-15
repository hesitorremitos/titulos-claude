<?php

namespace App\Livewire\Forms;

use App\Models\DiplomaAcademico;
use App\Models\MencionDa;

class DiplomaAcademicoForm extends BaseTituloForm
{
    // Campos específicos de diploma académico
    public ?int $mencion_da_id = null;

    // Cache para menciones
    public array $menciones = [];

    protected function rules(): array
    {
        return array_merge($this->commonRules(), [
            'mencion_da_id' => 'required|exists:menciones_da,id',
        ]);
    }

    protected function messages(): array
    {
        return array_merge($this->commonMessages(), [
            'mencion_da_id.required' => 'La mención es obligatoria',
            'mencion_da_id.exists' => 'La mención seleccionada no existe',
        ]);
    }

    public function loadMenciones(?string $carreraId = null): void
    {
        if ($carreraId) {
            $this->menciones = MencionDa::where('carrera_id', $carreraId)
                ->orderBy('nombre')
                ->get(['id', 'nombre'])
                ->toArray();
        } else {
            $this->menciones = [];
        }

        // Reset mención seleccionada cuando cambia la carrera
        $this->mencion_da_id = null;
    }

    public function checkDuplicates(string $ci): bool
    {
        $exists = DiplomaAcademico::where(function ($query) {
            $query->where('nro_documento', $this->nro_documento)
                ->where('fojas', $this->fojas)
                ->where('libro', $this->libro);
        })->orWhere(function ($query) use ($ci) {
            $query->where('ci', $ci)
                ->where('mencion_da_id', $this->mencion_da_id);
        })->exists();

        return $exists;
    }

    public function store(string $ci, int $userId): DiplomaAcademico
    {
        $this->validate();

        // Verificar duplicados
        if ($this->checkDuplicates($ci)) {
            throw new \Exception('Ya existe un diploma con estos datos de identificación o para esta persona y mención.');
        }

        $diplomaData = array_merge($this->getCommonData($ci, $userId), [
            'mencion_da_id' => $this->mencion_da_id,
        ]);

        // Manejar archivo PDF
        $filePath = $this->handleFileStorage($ci, 'academicos');
        if ($filePath) {
            $diplomaData['file_dir'] = $filePath;
        }

        return DiplomaAcademico::create($diplomaData);
    }

    protected function resetSpecificFields(): void
    {
        $this->mencion_da_id = null;
        $this->menciones = [];
    }
}
