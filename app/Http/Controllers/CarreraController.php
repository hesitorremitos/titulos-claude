<?php

namespace App\Http\Controllers;

use App\Models\Carrera;
use App\Models\Facultad;
use Illuminate\Http\Request;

class CarreraController extends Controller
{
    /**
     * Mostrar lista de carreras
     */
    public function index(Request $request)
    {
        $query = Carrera::query()->with('facultad');

        // Búsqueda
        if ($request->has('search') && $request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('programa', 'like', '%'.$request->search.'%')
                    ->orWhere('id', 'like', '%'.$request->search.'%')
                    ->orWhere('direccion', 'like', '%'.$request->search.'%');
            });
        }

        // Filtro por facultad
        if ($request->has('facultad_id') && $request->facultad_id) {
            $query->where('facultad_id', $request->facultad_id);
        }

        $carreras = $query->orderBy('programa')
            ->paginate(10)
            ->withQueryString();

        // Obtener facultades para el filtro
        $facultades = Facultad::orderBy('nombre')->get();

        return inertia('Carreras/Index', [
            'carreras' => $carreras,
            'facultades' => $facultades,
            'filters' => [
                'search' => $request->search,
                'facultad_id' => $request->facultad_id,
            ],
        ]);
    }

    /**
     * Mostrar formulario de creación
     */
    public function create(Request $request)
    {
        $facultades = Facultad::orderBy('nombre')->get();
        $facultadSeleccionada = $request->get('facultad_id');

        return inertia('Carreras/Create', [
            'facultades' => $facultades,
            'facultadSeleccionada' => $facultadSeleccionada,
        ]);
    }

    /**
     * Guardar nueva carrera
     */
    public function store(Request $request)
    {
        $request->validate([
            'id' => 'required|string|min:1|max:5|unique:carreras,id|regex:/^[A-Z0-9]+$/',
            'programa' => 'required|string|max:255',
            'direccion' => 'nullable|string|max:255',
            'facultad_id' => 'required|exists:facultades,id',
        ], [
            'id.required' => 'El código de la carrera es obligatorio.',
            'id.size' => 'El código debe tener exactamente 5 caracteres.',
            'id.unique' => 'Ya existe una carrera con este código.',
            'id.regex' => 'El código solo puede contener letras mayúsculas y números.',
            'programa.required' => 'El nombre del programa es obligatorio.',
            'programa.max' => 'El nombre del programa no puede exceder 255 caracteres.',
            'direccion.max' => 'La dirección no puede exceder 255 caracteres.',
            'facultad_id.required' => 'Debe seleccionar una facultad.',
            'facultad_id.exists' => 'La facultad seleccionada no es válida.',
        ]);

        try {
            $carrera = Carrera::create($request->all());

            return redirect()->route('v2.carreras.index');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['carrera' => 'Error al crear la carrera. Por favor, inténtelo nuevamente.']);
        }
    }

    /**
     * Mostrar carrera específica
     */
    public function show(Carrera $carrera)
    {
        $carrera->load('facultad');

        return inertia('Carreras/Show', [
            'carrera' => $carrera,
        ]);
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit(Carrera $carrera)
    {
        $facultades = Facultad::orderBy('nombre')->get();

        return inertia('Carreras/Edit', [
            'carrera' => $carrera,
            'facultades' => $facultades,
        ]);
    }

    /**
     * Actualizar carrera
     */
    public function update(Request $request, Carrera $carrera)
    {
        $request->validate([
            'id' => 'required|string|min:1|max:5|unique:carreras,id,'.$carrera->id.',id|regex:/^[A-Z0-9]+$/',
            'programa' => 'required|string|max:255',
            'direccion' => 'nullable|string|max:255',
            'facultad_id' => 'required|exists:facultades,id',
        ], [
            'id.required' => 'El código de la carrera es obligatorio.',
            'id.size' => 'El código debe tener exactamente 5 caracteres.',
            'id.unique' => 'Ya existe una carrera con este código.',
            'id.regex' => 'El código solo puede contener letras mayúsculas y números.',
            'programa.required' => 'El nombre del programa es obligatorio.',
            'programa.max' => 'El nombre del programa no puede exceder 255 caracteres.',
            'direccion.max' => 'La dirección no puede exceder 255 caracteres.',
            'facultad_id.required' => 'Debe seleccionar una facultad.',
            'facultad_id.exists' => 'La facultad seleccionada no es válida.',
        ]);

        try {
            $carrera->update($request->all());

            return redirect()->route('v2.carreras.index');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['carrera' => 'Error al actualizar la carrera. Por favor, inténtelo nuevamente.']);
        }
    }

    /**
     * Eliminar carrera
     */
    public function destroy(Carrera $carrera)
    {
        try {
            // Verificar si tiene menciones asociadas
            $mencionesCount = \App\Models\MencionDa::where('carrera_id', $carrera->id)->count();

            if ($mencionesCount > 0) {
                return redirect()->back()->withErrors([
                    'carrera' => "No se puede eliminar la carrera '{$carrera->programa}' porque tiene {$mencionesCount} mención(es) académica(s) asociada(s).",
                ]);
            }

            $carrera->delete();

            return redirect()->route('v2.carreras.index');

        } catch (\Exception $e) {
            return redirect()->back()->withErrors([
                'carrera' => 'Error al eliminar la carrera. Por favor, inténtelo nuevamente.',
            ]);
        }
    }
}
