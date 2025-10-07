<?php

namespace App\Http\Controllers\TitulosProvisionNacional;

use App\Http\Controllers\Controller;
use App\Models\TitulosProvisionNacional\Modalidad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ModalidadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $modalidades = Modalidad::withCount('titulos')
            ->latest()
            ->paginate(15);

        return Inertia::render('TitulosProvisionNacional/Modalidades', [
            'modalidades' => $modalidades,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100|unique:modalidades_tpn,nombre',
            'descripcion' => 'nullable|string|max:500',
            'activo' => 'boolean',
        ]);

        $validated['activo'] = $validated['activo'] ?? true;

        Modalidad::create($validated);

        return redirect()
            ->back()
            ->with('success', 'Modalidad creada exitosamente.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Modalidad $modalidad)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100|unique:modalidades_tpn,nombre,' . $modalidad->id,
            'descripcion' => 'nullable|string|max:500',
            'activo' => 'boolean',
        ]);

        $modalidad->update($validated);

        return redirect()
            ->back()
            ->with('success', 'Modalidad actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Modalidad $modalidad)
    {
        // Check if there are related titles
        if ($modalidad->titulos()->count() > 0) {
            return redirect()
                ->back()
                ->with('error', 'No se puede eliminar la modalidad porque tiene títulos asociados.');
        }

        $modalidad->delete();

        return redirect()
            ->back()
            ->with('success', 'Modalidad eliminada exitosamente.');
    }
}