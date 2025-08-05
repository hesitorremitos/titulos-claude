<?php

namespace App\Http\Controllers\DiplomasAcademicos;

use App\Http\Controllers\Controller;
use App\Models\Carrera;
use App\Models\DiplomaAcademico;
use App\Models\MencionDa;
use Illuminate\Http\Request;

class MencionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('ver-titulos');

        $menciones = MencionDa::with(['carrera.facultad'])
            ->withCount('diplomas')
            ->orderBy('nombre')
            ->paginate(15);

        return view('diplomas.menciones.index', compact('menciones'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('crear-titulos');
        
        $carrerasCollection = Carrera::with('facultad')->orderBy('programa')->get();
        $carreras = $carrerasCollection->mapWithKeys(function ($carrera) {
            return [$carrera->id => $carrera->programa . ' - ' . $carrera->facultad->nombre];
        });
        
        return view('diplomas.menciones.create', compact('carreras'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('crear-titulos');

        $request->validate([
            'nombre' => 'required|string|max:255',
            'carrera_id' => 'required|exists:carreras,id',
        ]);

        try {
            MencionDa::create([
                'nombre' => $request->nombre,
                'carrera_id' => $request->carrera_id,
            ]);

            return redirect()->route('diplomas.menciones.index')
                ->with('success', 'Mención creada exitosamente.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al crear la mención: '.$e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(MencionDa $mencion)
    {
        $this->authorize('ver-titulos');

        $mencion->load('carrera.facultad');
        $diplomasCount = $mencion->diplomas()->count();

        return view('diplomas.menciones.show', compact('mencion', 'diplomasCount'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MencionDa $mencion)
    {
        $this->authorize('editar-titulos');
        $carreras = Carrera::with('facultad')->orderBy('programa')->get();
        return view('diplomas.menciones.edit', compact('mencion', 'carreras'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MencionDa $mencion)
    {
        $this->authorize('editar-titulos');

        $request->validate([
            'nombre' => 'required|string|max:255',
            'carrera_id' => 'required|exists:carreras,id',
        ]);

        try {
            $mencion->update([
                'nombre' => $request->nombre,
                'carrera_id' => $request->carrera_id,
            ]);

            return redirect()->route('diplomas.menciones.index')
                ->with('success', 'Mención actualizada exitosamente.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al actualizar la mención: '.$e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MencionDa $mencion)
    {
        $this->authorize('eliminar-titulos');

        try {
            // Check referential integrity
            $diplomasCount = $mencion->diplomas()->count();

            if ($diplomasCount > 0) {
                return redirect()->route('diplomas.menciones.index')
                    ->with('error', "No se puede eliminar la mención '{$mencion->nombre}' porque está siendo utilizada por {$diplomasCount} diploma(s) académico(s).");
            }

            $mencion->delete();

            return redirect()->route('diplomas.menciones.index')
                ->with('success', 'Mención eliminada exitosamente.');

        } catch (\Exception $e) {
            return redirect()->route('diplomas.menciones.index')
                ->with('error', 'Error al eliminar la mención: '.$e->getMessage());
        }
    }
}
