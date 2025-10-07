<?php

namespace App\Http\Controllers\Diplomado;

use App\Http\Controllers\Controller;
use App\Models\Diplomado\Mencion;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MencionController extends Controller
{
    public function index()
    {
        $menciones = Mencion::withCount('diplomados')
            ->orderByDesc('created_at')
            ->paginate(15);

        return Inertia::render('Diplomados/Menciones', [
            'menciones' => $menciones,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:200|unique:menciones_diplomado,nombre',
            'activo' => 'boolean',
        ]);

        $validated['activo'] = $validated['activo'] ?? true;

        Mencion::create($validated);

        return redirect()
            ->back()
            ->with('success', 'Mención de diplomado creada exitosamente.');
    }

    public function update(Request $request, Mencion $mencion)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:200|unique:menciones_diplomado,nombre,' . $mencion->id,
            'activo' => 'boolean',
        ]);

        $mencion->update($validated);

        return redirect()
            ->back()
            ->with('success', 'Mención de diplomado actualizada exitosamente.');
    }

    public function destroy(Mencion $mencion)
    {
        if ($mencion->diplomados()->exists()) {
            return redirect()
                ->back()
                ->with('error', 'No se puede eliminar la mención porque tiene diplomados asociados.');
        }

        $mencion->delete();

        return redirect()
            ->back()
            ->with('success', 'Mención de diplomado eliminada exitosamente.');
    }
}
