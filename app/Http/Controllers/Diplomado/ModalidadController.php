<?php

namespace App\Http\Controllers\Diplomado;

use App\Http\Controllers\Controller;
use App\Models\Diplomado\Modalidad;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ModalidadController extends Controller
{
    public function index()
    {
        $modalidades = Modalidad::withCount('diplomados')
            ->orderByDesc('created_at')
            ->paginate(15);

        return Inertia::render('Diplomados/Modalidades', [
            'modalidades' => $modalidades,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:150|unique:modalidades_diplomado,nombre',
            'activo' => 'boolean',
        ]);

        $validated['activo'] = $validated['activo'] ?? true;

        Modalidad::create($validated);

        return redirect()
            ->back()
            ->with('success', 'Modalidad de diplomado creada exitosamente.');
    }

    public function update(Request $request, Modalidad $modalidad)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:150|unique:modalidades_diplomado,nombre,' . $modalidad->id,
            'activo' => 'boolean',
        ]);

        $modalidad->update($validated);

        return redirect()
            ->back()
            ->with('success', 'Modalidad de diplomado actualizada exitosamente.');
    }

    public function destroy(Modalidad $modalidad)
    {
        if ($modalidad->diplomados()->exists()) {
            return redirect()
                ->back()
                ->with('error', 'No se puede eliminar la modalidad porque tiene diplomados asociados.');
        }

        $modalidad->delete();

        return redirect()
            ->back()
            ->with('success', 'Modalidad de diplomado eliminada exitosamente.');
    }
}
