<?php

namespace App\Http\Controllers\TitulosProvisionNacional;

use App\Http\Controllers\Controller;
use App\Models\TitulosProvisionNacional\Mencion;
use App\Models\Carrera;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class MencionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menciones = Mencion::withCount('titulos')
            ->with('carrera')
            ->latest()
            ->paginate(15);

        $carreras = Carrera::orderBy('programa')
            ->get();

        return Inertia::render('TitulosProvisionNacional/Menciones', [
            'menciones' => $menciones,
            'carreras' => $carreras,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:200|unique:menciones_tpn,nombre',
            'carrera_id' => 'required|string|exists:carreras,id',
            'descripcion' => 'nullable|string|max:500',
            'activo' => 'boolean',
        ]);

        $validated['activo'] = $validated['activo'] ?? true;

        Mencion::create($validated);

        return redirect()
            ->back()
            ->with('success', 'Mención creada exitosamente.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mencion $mencion)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:200|unique:menciones_tpn,nombre,' . $mencion->id,
            'carrera_id' => 'required|string|exists:carreras,id',
            'descripcion' => 'nullable|string|max:500',
            'activo' => 'boolean',
        ]);

        $mencion->update($validated);

        return redirect()
            ->back()
            ->with('success', 'Mención actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mencion $mencion)
    {
        // Check if there are related titles
        if ($mencion->titulos()->count() > 0) {
            return redirect()
                ->back()
                ->with('error', 'No se puede eliminar la mención porque tiene títulos asociados.');
        }

        $mencion->delete();

        return redirect()
            ->back()
            ->with('success', 'Mención eliminada exitosamente.');
    }
}