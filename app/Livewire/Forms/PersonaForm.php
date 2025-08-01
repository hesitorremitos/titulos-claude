<?php

namespace App\Livewire\Forms;

use App\Models\Persona;
use Livewire\Attributes\Validate;
use Livewire\Form;

class PersonaForm extends Form
{
    #[Validate('required|string|max:20')]
    public string $ci = '';

    #[Validate('required|string|max:100')]
    public string $nombres = '';

    #[Validate('nullable|string|max:50')]
    public string $paterno = '';

    #[Validate('nullable|string|max:50')]
    public string $materno = '';

    #[Validate('nullable|date|before:today')]
    public string $fecha_nacimiento = '';

    #[Validate('nullable|in:M,F,O')]
    public string $genero = '';

    #[Validate('nullable|string|max:50')]
    public string $pais = 'Bolivia';

    #[Validate('nullable|string|max:50')]
    public string $departamento = '';

    #[Validate('nullable|string|max:50')]
    public string $provincia = '';

    #[Validate('nullable|string|max:50')]
    public string $localidad = '';

    protected function rules(): array
    {
        return [
            'ci' => 'required|string|max:20',
            'nombres' => 'required|string|max:100',
            'paterno' => 'nullable|string|max:50',
            'materno' => 'nullable|string|max:50',
            'fecha_nacimiento' => 'nullable|date|before:today',
            'genero' => 'nullable|in:M,F,O',
            'pais' => 'nullable|string|max:50',
            'departamento' => 'nullable|string|max:50',
            'provincia' => 'nullable|string|max:50',
            'localidad' => 'nullable|string|max:50',
        ];
    }

    protected function messages(): array
    {
        return [
            'ci.required' => 'La cédula de identidad es obligatoria',
            'ci.max' => 'La cédula de identidad no puede exceder los 20 caracteres',
            'nombres.required' => 'Los nombres son obligatorios',
            'nombres.max' => 'Los nombres no pueden exceder los 100 caracteres',
            'paterno.max' => 'El apellido paterno no puede exceder los 50 caracteres',
            'materno.max' => 'El apellido materno no puede exceder los 50 caracteres',
            'fecha_nacimiento.date' => 'La fecha de nacimiento debe ser una fecha válida',
            'fecha_nacimiento.before' => 'La fecha de nacimiento debe ser anterior a hoy',
            'genero.in' => 'El género debe ser M (Masculino), F (Femenino) u O (Otro)',
            'pais.max' => 'El país no puede exceder los 50 caracteres',
            'departamento.max' => 'El departamento no puede exceder los 50 caracteres',
            'provincia.max' => 'La provincia no puede exceder los 50 caracteres',
            'localidad.max' => 'La localidad no puede exceder los 50 caracteres',
        ];
    }

    public function fillFromApiData(array $data): void
    {
        $this->ci = $data['ci'];
        $this->nombres = $data['nombres'];
        $this->paterno = $data['paterno'];
        $this->materno = $data['materno'];
        $this->fecha_nacimiento = $data['fecha_nacimiento'];
        $this->genero = $data['genero'];
        $this->pais = $data['pais'] ?? 'Bolivia';
        $this->departamento = $data['departamento'] ?? '';
        $this->provincia = $data['provincia'] ?? '';
        $this->localidad = $data['localidad'] ?? '';
    }

    public function createOrUpdatePerson(): Persona
    {
        $this->validate();

        try {
            return Persona::updateOrCreate(
                ['ci' => $this->ci],
                [
                    'nombres' => $this->nombres,
                    'paterno' => $this->paterno,
                    'materno' => $this->materno,
                    'fecha_nacimiento' => $this->fecha_nacimiento ?: null,
                    'genero' => $this->genero,
                    'pais' => $this->pais,
                    'departamento' => $this->departamento,
                    'provincia' => $this->provincia,
                    'localidad' => $this->localidad,
                ]
            );
        } catch (\Exception $e) {
            throw new \Exception('Error al guardar los datos de la persona: '.$e->getMessage());
        }
    }

    public function isComplete(): bool
    {
        return ! empty($this->ci) && ! empty($this->nombres);
    }

    public function reset(...$properties): void
    {
        $this->ci = '';
        $this->nombres = '';
        $this->paterno = '';
        $this->materno = '';
        $this->fecha_nacimiento = '';
        $this->genero = '';
        $this->pais = 'Bolivia';
        $this->departamento = '';
        $this->provincia = '';
        $this->localidad = '';
    }
}
