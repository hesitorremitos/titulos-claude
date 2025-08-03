<?php

namespace App\Http\Controllers\DiplomasAcademicos;

use App\Http\Controllers\Controller;
use App\Models\GraduacionDa;
use App\Models\DiplomaAcademico;
use Illuminate\Http\Request;

class ModalidadGraduacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('ver-titulos');
        
        $query = GraduacionDa::query();
        
        if ($request->filled('search')) {
            $query->where('nombre', 'like', '%' . $request->search . '%');
        }
        
        if ($request->filled('activo')) {
            $query->where('activo', $request->activo === '1');
        }
        
        $modalidades = $query->orderBy('nombre')->paginate(15)->withQueryString();
        
        return view('diplomas.modalidades.index', compact('modalidades'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('crear-titulos');
        
        return view('diplomas.modalidades.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('crear-titulos');
        
        $request->validate([
            'nombre' => 'required|string|max:255|unique:graduacion_da,nombre',
            'activo' => 'boolean'
        ]);
        
        try {
            GraduacionDa::create([
                'nombre' => $request->nombre,
                'activo' => $request->boolean('activo', true)
            ]);
            
            return redirect()->route('diplomas.modalidades.index')
                ->with('success', 'Modalidad de graduación creada exitosamente.');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al crear la modalidad de graduación: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(GraduacionDa $modalidad)
    {
        $this->authorize('ver-titulos');
        
        $diplomasCount = $modalidad->diplomaAcademicos()->count();
        
        return view('diplomas.modalidades.show', compact('modalidad', 'diplomasCount'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GraduacionDa $modalidad)
    {
        $this->authorize('editar-titulos');
        
        return view('diplomas.modalidades.edit', compact('modalidad'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, GraduacionDa $modalidad)
    {
        $this->authorize('editar-titulos');
        
        $request->validate([
            'nombre' => 'required|string|max:255|unique:graduacion_da,nombre,' . $modalidad->id,
            'activo' => 'boolean'
        ]);
        
        try {
            $modalidad->update([
                'nombre' => $request->nombre,
                'activo' => $request->boolean('activo', true)
            ]);
            
            return redirect()->route('diplomas.modalidades.index')
                ->with('success', 'Modalidad de graduación actualizada exitosamente.');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al actualizar la modalidad de graduación: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GraduacionDa $modalidad)
    {
        $this->authorize('eliminar-titulos');
        
        try {
            // Check referential integrity
            $diplomasCount = DiplomaAcademico::where('graduacion_da_id', $modalidad->id)->count();
            
            if ($diplomasCount > 0) {
                return redirect()->route('diplomas.modalidades.index')
                    ->with('error', "No se puede eliminar la modalidad '{$modalidad->nombre}' porque está siendo utilizada por {$diplomasCount} diploma(s) académico(s).");
            }
            
            $modalidad->delete();
            
            return redirect()->route('diplomas.modalidades.index')
                ->with('success', 'Modalidad de graduación eliminada exitosamente.');
                
        } catch (\Exception $e) {
            return redirect()->route('diplomas.modalidades.index')
                ->with('error', 'Error al eliminar la modalidad de graduación: ' . $e->getMessage());
        }
    }
}