<?php

namespace App\Http\Controllers\V2;

use App\Http\Controllers\Controller;
use App\Models\Facultad;
use App\Models\MencionDa;
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
        $menciones = MencionDa::with(['carrera.facultad'])
            ->latest()
            ->paginate(15);

        $carreras = Facultad::with('carreras')->get();

        return Inertia::render('DiplomasAcademicos/Menciones', [
            'menciones' => $menciones,
            'carreras' => $carreras,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:menciones_da,nombre',
            'carrera_id' => 'required|exists:carreras,id',
        ]);

        try {
            MencionDa::create([
                'nombre' => $request->nombre,
                'carrera_id' => $request->carrera_id,
            ]);

            return redirect()->back()
                ->with('success', 'Mención académica creada exitosamente.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Error al crear la mención: ' . $e->getMessage()]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MencionDa $mencion)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:menciones_da,nombre,' . $mencion->id,
            'carrera_id' => 'required|exists:carreras,id',
        ]);

        try {
            $mencion->update([
                'nombre' => $request->nombre,
                'carrera_id' => $request->carrera_id,
            ]);

            return redirect()->back()
                ->with('success', 'Mención académica actualizada exitosamente.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Error al actualizar la mención: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MencionDa $mencion)
    {
        try {
            // Check if there are diplomas using this mención
            $diplomasCount = $mencion->diplomas()->count();
            
            if ($diplomasCount > 0) {
                return redirect()->back()
                    ->withErrors(['error' => "No se puede eliminar la mención '{$mencion->nombre}' porque tiene {$diplomasCount} diploma(s) asociado(s)."]);
            }

            $mencion->delete();

            return redirect()->back()
                ->with('success', 'Mención académica eliminada exitosamente.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Error al eliminar la mención: ' . $e->getMessage()]);
        }
    }
}