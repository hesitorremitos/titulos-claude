<?php

namespace App\Http\Controllers;

use App\Models\Facultad;
use Illuminate\Http\Request;

class FacultadController extends Controller
{
    /**
     * Mostrar lista de facultades
     */
    public function index()
    {
        $facultades = Facultad::with('carreras')
            ->withCount('carreras')
            ->orderBy('nombre')
            ->paginate(10);

        return view('facultades.index', compact('facultades'));
    }

    /**
     * Mostrar formulario de creación
     */
    public function create()
    {
        return view('facultades.create');
    }

    /**
     * Guardar nueva facultad
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:facultades,nombre',
            'direccion' => 'nullable|string|max:255',
        ], [
            'nombre.required' => 'El nombre de la facultad es obligatorio.',
            'nombre.unique' => 'Ya existe una facultad con este nombre.',
            'nombre.max' => 'El nombre no puede exceder 255 caracteres.',
            'direccion.max' => 'La dirección no puede exceder 255 caracteres.',
        ]);

        $facultad = Facultad::create($request->all());

        return redirect()->route('facultades.index')
            ->with('success', 'Facultad creada exitosamente.');
    }

    /**
     * Mostrar facultad específica
     */
    public function show(Facultad $facultad)
    {
        $facultad->load(['carreras' => function ($query) {
            $query->orderBy('programa');
        }]);

        return view('facultades.show', compact('facultad'));
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit(Facultad $facultad)
    {
        return view('facultades.edit', compact('facultad'));
    }

    /**
     * Actualizar facultad
     */
    public function update(Request $request, Facultad $facultad)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:facultades,nombre,'.$facultad->id,
            'direccion' => 'nullable|string|max:255',
        ], [
            'nombre.required' => 'El nombre de la facultad es obligatorio.',
            'nombre.unique' => 'Ya existe una facultad con este nombre.',
            'nombre.max' => 'El nombre no puede exceder 255 caracteres.',
            'direccion.max' => 'La dirección no puede exceder 255 caracteres.',
        ]);

        $facultad->update($request->all());

        return redirect()->route('facultades.index')
            ->with('success', 'Facultad actualizada exitosamente.');
    }

    /**
     * Eliminar facultad
     */
    public function destroy(Facultad $facultad)
    {
        // Verificar si tiene carreras asociadas
        if ($facultad->carreras()->count() > 0) {
            return redirect()->route('facultades.index')
                ->with('error', 'No se puede eliminar la facultad porque tiene carreras asociadas.');
        }

        $facultad->delete();

        return redirect()->route('facultades.index')
            ->with('success', 'Facultad eliminada exitosamente.');
    }
}
