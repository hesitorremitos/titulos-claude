<?php

namespace App\Http\Controllers\Especialidad;

use App\Http\Controllers\Controller;
use App\Models\Especialidad\Mencion;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MencionController extends Controller
{
    public function index()
    {
        $menciones = Mencion::withCount('especialidades')
            ->orderByDesc('created_at')
            ->paginate(15);

        return Inertia::render('Especialidades/Menciones', [
            'menciones' => $menciones,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:200|unique:menciones_especialidad,nombre',
            'activo' => 'boolean',
        ]);

        $validated['activo'] = $validated['activo'] ?? true;

        Mencion::create($validated);

        return redirect()
            ->back()
            ->with('success', 'Mención de especialidad creada exitosamente.');
    }

    public function update(Request $request, Mencion $mencion)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:200|unique:menciones_especialidad,nombre,' . $mencion->id,
            'activo' => 'boolean',
        ]);

        $mencion->update($validated);

        return redirect()
            ->back()
            ->with('success', 'Mención de especialidad actualizada exitosamente.');
    }

    public function destroy(Mencion $mencion)
    {
        if ($mencion->especialidades()->exists()) {
            return redirect()
                ->back()
                ->with('error', 'No se puede eliminar la mención porque tiene especialidades asociadas.');
        }

        $mencion->delete();

        return redirect()
            ->back()
            ->with('success', 'Mención de especialidad eliminada exitosamente.');
    }
}
