<?php

namespace App\Http\Controllers\DiplomasAcademicos;

use App\Http\Controllers\Controller;
use App\Models\GraduacionDa;
use Illuminate\Http\Request;

class ModalidadGraduacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('ver-titulos');

        $modalidades = GraduacionDa::withCount('diplomas')
            ->orderBy('nombre')
            ->paginate(15);

        return view('diplomas.mod_grad.index', compact('modalidades'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('crear-titulos');

        return view('diplomas.mod_grad.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('crear-titulos');

        $request->validate([
            'medio_graduacion' => 'required|string|max:255',
        ]);

        try {
            GraduacionDa::create([
                'medio_graduacion' => $request->medio_graduacion,
            ]);

            return redirect()->route('diplomas.mod_grad.index')
                ->with('success', 'Modalidad creada exitosamente.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al crear la modalidad: '.$e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(GraduacionDa $graduacion_da)
    {
        $this->authorize('ver-titulos');

        $diplomasCount = $graduacion_da->diplomas()->count();
        $modalidad = $graduacion_da; // Para mantener compatibilidad con vista

        return view('diplomas.mod_grad.show', compact('modalidad', 'diplomasCount'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GraduacionDa $graduacion_da)
    {
        $this->authorize('editar-titulos');
        $modalidad = $graduacion_da; // Para mantener compatibilidad con vista

        return view('diplomas.mod_grad.edit', compact('modalidad'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, GraduacionDa $graduacion_da)
    {
        $this->authorize('editar-titulos');

        $request->validate([
            'medio_graduacion' => 'required|string|max:255',
        ]);

        try {
            $graduacion_da->update([
                'medio_graduacion' => $request->medio_graduacion,
            ]);

            return redirect()->route('diplomas.mod_grad.index')
                ->with('success', 'Modalidad actualizada exitosamente.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al actualizar la modalidad: '.$e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GraduacionDa $graduacion_da)
    {
        $this->authorize('eliminar-titulos');

        try {
            // Check referential integrity
            $diplomasCount = $graduacion_da->diplomas()->count();

            if ($diplomasCount > 0) {
                return redirect()->route('diplomas.mod_grad.index')
                    ->with('error', "No se puede eliminar la modalidad '{$graduacion_da->nombre}' porque está siendo utilizada por {$diplomasCount} diploma(s) académico(s).");
            }

            $graduacion_da->delete();

            return redirect()->route('diplomas.mod_grad.index')
                ->with('success', 'Modalidad eliminada exitosamente.');

        } catch (\Exception $e) {
            return redirect()->route('diplomas.mod_grad.index')
                ->with('error', 'Error al eliminar la modalidad: '.$e->getMessage());
        }
    }
}
