<?php

namespace App\Http\Controllers\V2;

use App\Http\Controllers\Controller;
use App\Models\GraduacionDa;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ModalidadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $modalidades = GraduacionDa::withCount('diplomas')
            ->latest()
            ->paginate(15);

        return Inertia::render('DiplomasAcademicos/Modalidades', [
            'modalidades' => $modalidades,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'medio_graduacion' => 'required|string|max:255|unique:graduacion_da,medio_graduacion',
        ]);

        try {
            GraduacionDa::create([
                'medio_graduacion' => $request->medio_graduacion,
            ]);

            return redirect()->back()
                ->with('success', 'Modalidad de graduación creada exitosamente.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Error al crear la modalidad: ' . $e->getMessage()]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, GraduacionDa $modalidad)
    {
        $request->validate([
            'medio_graduacion' => 'required|string|max:255|unique:graduacion_da,medio_graduacion,' . $modalidad->id,
        ]);

        try {
            $modalidad->update([
                'medio_graduacion' => $request->medio_graduacion,
            ]);

            return redirect()->back()
                ->with('success', 'Modalidad de graduación actualizada exitosamente.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Error al actualizar la modalidad: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GraduacionDa $modalidad)
    {
        try {
            // Check if there are diplomas using this modalidad
            $diplomasCount = $modalidad->diplomas()->count();
            
            if ($diplomasCount > 0) {
                return redirect()->back()
                    ->withErrors(['error' => "No se puede eliminar la modalidad '{$modalidad->medio_graduacion}' porque tiene {$diplomasCount} diploma(s) asociado(s)."]);
            }

            $modalidad->delete();

            return redirect()->back()
                ->with('success', 'Modalidad de graduación eliminada exitosamente.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Error al eliminar la modalidad: ' . $e->getMessage()]);
        }
    }
}