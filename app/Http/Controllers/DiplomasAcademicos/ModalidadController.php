<?php

namespace App\Http\Controllers\DiplomasAcademicos;

use App\Http\Controllers\Controller;
use App\Models\DiplomasAcademicos\Modalidad;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ModalidadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('active.role:Administrador|Jefe|Personal')->only('index');
        $this->middleware('active.role:Administrador|Personal')->only(['store', 'update']);
        $this->middleware('active.role:Administrador')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $modalidades = Modalidad::withCount('diplomasAcademicos')
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
            Modalidad::create([
                'medio_graduacion' => $request->medio_graduacion,
            ]);

            return redirect()->back()
                ->with('success', 'Modalidad de graduación creada exitosamente.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Error al crear la modalidad: '.$e->getMessage()]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Modalidad $modalidad)
    {
        $request->validate([
            'medio_graduacion' => 'required|string|max:255|unique:graduacion_da,medio_graduacion,'.$modalidad->id,
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
                ->withErrors(['error' => 'Error al actualizar la modalidad: '.$e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Modalidad $modalidad)
    {
        try {
            // Check if there are diplomas using this modalidad
            $diplomasCount = $modalidad->diplomasAcademicos()->count();

            if ($diplomasCount > 0) {
                return redirect()->back()
                    ->withErrors(['error' => "No se puede eliminar la modalidad '{$modalidad->medio_graduacion}' porque tiene {$diplomasCount} diploma(s) asociado(s)."]);
            }

            $modalidad->delete();

            return redirect()->back()
                ->with('success', 'Modalidad de graduación '.$modalidad->medio_graduacion.' eliminada exitosamente.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Error al eliminar la modalidad: '.$e->getMessage()]);
        }
    }
}
