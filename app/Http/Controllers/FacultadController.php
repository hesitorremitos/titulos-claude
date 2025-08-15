<?php

namespace App\Http\Controllers;

use App\Models\Facultad;
use Illuminate\Http\Request;

class FacultadController extends Controller
{
    /**
     * Mostrar lista de facultades
     */
    public function index(Request $request)
    {
        $query = Facultad::query()->with('carreras')->withCount('carreras');

        // Búsqueda
        if ($request->has('search') && $request->search) {
            $query->where('nombre', 'like', '%'.$request->search.'%')
                ->orWhere('direccion', 'like', '%'.$request->search.'%');
        }

        $facultades = $query->orderBy('nombre')
            ->paginate(10)
            ->withQueryString();

        return inertia('Facultades/Index', [
            'facultades' => $facultades,
            'filters' => [
                'search' => $request->search,
            ],
        ]);
    }

    /**
     * Mostrar formulario de creación
     */
    public function create()
    {
        return inertia('Facultades/Create');
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

        try {
            $facultad = Facultad::create($request->all());

            return redirect()->route('v2.facultades.index');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['facultad' => 'Error al crear la facultad. Por favor, inténtelo nuevamente.']);
        }
    }

    /**
     * Mostrar facultad específica
     */
    public function show(Facultad $facultad)
    {
        $facultad->load(['carreras' => function ($query) {
            $query->orderBy('programa');
        }]);

        return inertia('Facultades/Show', [
            'facultad' => $facultad,
        ]);
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit(Facultad $facultad)
    {
        return inertia('Facultades/Edit', [
            'facultad' => $facultad,
        ]);
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

        try {
            $facultad->update($request->all());

            return redirect()->route('v2.facultades.index')
                ->with('success', 'Facultad actualizada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al actualizar la facultad. Por favor, inténtelo nuevamente.');
        }
    }

    /**
     * Eliminar facultad
     */
    public function destroy(Facultad $facultad)
    {
        try {
            // Verificar si tiene carreras asociadas
            $carrerasCount = $facultad->carreras()->count();

            if ($carrerasCount > 0) {
                return response()->json([
                    'message' => "No se puede eliminar la facultad '{$facultad->nombre}' porque tiene {$carrerasCount} carrera(s) asociada(s).",
                ], 422);
            }

            $facultad->delete();

            return response()->json([
                'message' => 'Facultad eliminada exitosamente.',
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al eliminar la facultad. Por favor, inténtelo nuevamente.',
            ], 500);
        }
    }
}
