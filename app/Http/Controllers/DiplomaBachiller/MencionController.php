<?php

namespace App\Http\Controllers\DiplomaBachiller;

use App\Http\Controllers\Controller;
use App\Models\DiplomaBachiller\Mencion;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MencionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menciones = Mencion::withCount('diplomas')
            ->latest()
            ->paginate(15);

        return Inertia::render('DiplomaBachiller/Menciones', [
            'menciones' => $menciones,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:200|unique:menciones_db,nombre',
        ]);

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
            'nombre' => 'required|string|max:200|unique:menciones_db,nombre,' . $mencion->id,
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
        if ($mencion->diplomas()->count() > 0) {
            return redirect()
                ->back()
                ->with('error', 'No se puede eliminar la mención porque tiene diplomas asociados.');
        }

        $mencion->delete();

        return redirect()
            ->back()
            ->with('success', 'Mención eliminada exitosamente.');
    }
}
