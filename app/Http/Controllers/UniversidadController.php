<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Universidad;
use App\Models\Especialidad\Especialidad;
use Illuminate\Http\Request;

class UniversidadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('active.role:Administrador|Personal')->only([
            'index',
            'show',
            'create',
            'store',
            'edit',
            'update',
        ]);

        $this->middleware('active.role:Administrador')->only('destroy');
    }

    /**
     * Mostrar lista de universidades
     */
    public function index(Request $request)
    {
        $query = Universidad::query()->with('especialidades')->withCount('especialidades');

        // Búsqueda
        if ($request->has('search') && $request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('nombre', 'like', '%'.$request->search.'%')
                    ->orWhere('sigla', 'like', '%'.$request->search.'%');
            });
        }

        $universidades = $query->orderBy('nombre')
            ->paginate(10)
            ->withQueryString();

        return inertia('Universidades/Index', [
            'universidades' => $universidades,
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
        return inertia('Universidades/Create');
    }

    /**
     * Guardar nueva universidad
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:universidades,nombre',
            'sigla' => 'nullable|string|max:50|unique:universidades,sigla',
        ], [
            'nombre.required' => 'El nombre de la universidad es obligatorio.',
            'nombre.unique' => 'Ya existe una universidad con este nombre.',
            'nombre.max' => 'El nombre no puede exceder 255 caracteres.',
            'sigla.unique' => 'Ya existe una universidad con esta sigla.',
            'sigla.max' => 'La sigla no puede exceder 50 caracteres.',
        ]);

        try {
            $universidad = Universidad::create($request->all());

            return redirect()->route('universidades.index');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['universidad' => 'Error al crear la universidad. Por favor, inténtelo nuevamente.']);
        }
    }

    /**
     * Mostrar universidad específica
     */
    public function show(Universidad $universidad)
    {
        $universidad->load(['especialidades' => function ($query) {
            $query->orderBy('nombre');
        }]);

        return inertia('Universidades/Show', [
            'universidad' => $universidad,
        ]);
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit(Universidad $universidad)
    {
        return inertia('Universidades/Edit', [
            'universidad' => $universidad,
        ]);
    }

    /**
     * Actualizar universidad
     */
    public function update(Request $request, Universidad $universidad)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:universidades,nombre,'.$universidad->id,
            'sigla' => 'nullable|string|max:50|unique:universidades,sigla,'.$universidad->id,
        ], [
            'nombre.required' => 'El nombre de la universidad es obligatorio.',
            'nombre.unique' => 'Ya existe una universidad con este nombre.',
            'nombre.max' => 'El nombre no puede exceder 255 caracteres.',
            'sigla.unique' => 'Ya existe una universidad con esta sigla.',
            'sigla.max' => 'La sigla no puede exceder 50 caracteres.',
        ]);

        try {
            $universidad->update($request->all());

            return redirect()->route('universidades.index')
                ->with('success', 'Universidad actualizada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al actualizar la universidad. Por favor, inténtelo nuevamente.');
        }
    }

    /**
     * Eliminar universidad
     */
    public function destroy(Universidad $universidad)
    {
        try {
            // Verificar si tiene especialidades asociadas
            $especialidadesCount = $universidad->especialidades()->count();

            if ($especialidadesCount > 0) {
                return response()->json([
                    'message' => "No se puede eliminar la universidad '{$universidad->nombre}' porque tiene {$especialidadesCount} especialidad(es) asociada(s).",
                ], 422);
            }

            $universidad->delete();

            return response()->json([
                'message' => 'Universidad eliminada exitosamente.',
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al eliminar la universidad. Por favor, inténtelo nuevamente.',
            ], 500);
        }
    }
}
