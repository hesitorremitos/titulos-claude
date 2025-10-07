<?php

namespace App\Http\Controllers\Especialidad;

use App\Http\Controllers\Controller;
use App\Models\Especialidad\Modalidad;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ModalidadController extends Controller
{
    public function index()
    {
        $modalidades = Modalidad::withCount('especialidades')
            ->orderByDesc('created_at')
            ->paginate(15);

        return Inertia::render('Especialidades/Modalidades', [
            'modalidades' => $modalidades,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:150|unique:modalidades_especialidad,nombre',
            'activo' => 'boolean',
        ]);

        $validated['activo'] = $validated['activo'] ?? true;

        Modalidad::create($validated);

        return redirect()
            ->back()
            ->with('success', 'Modalidad de especialidad creada exitosamente.');
    }

    public function update(Request $request, Modalidad $modalidad)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:150|unique:modalidades_especialidad,nombre,' . $modalidad->id,
            'activo' => 'boolean',
        ]);

        $modalidad->update($validated);

        return redirect()
            ->back()
            ->with('success', 'Modalidad de especialidad actualizada exitosamente.');
    }

    public function destroy(Modalidad $modalidad)
    {
        if ($modalidad->especialidades()->exists()) {
            return redirect()
                ->back()
                ->with('error', 'No se puede eliminar la modalidad porque tiene especialidades asociadas.');
        }

        $modalidad->delete();

        return redirect()
            ->back()
            ->with('success', 'Modalidad de especialidad eliminada exitosamente.');
    }
}
