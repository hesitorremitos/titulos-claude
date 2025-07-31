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
    public function index()
    {
        $carreras = Carrera::with('facultad')
            ->orderBy('programa')
            ->paginate(10);

        return view('carreras.index', compact('carreras'));
    }

    /**
     * Mostrar formulario de creación
     */
    public function create(Request $request)
    {
        $facultades = Facultad::orderBy('nombre')->get();
        $facultadSeleccionada = $request->get('facultad_id');

        return view('carreras.create', compact('facultades', 'facultadSeleccionada'));
    }

    /**
     * Guardar nueva carrera
     */
    public function store(Request $request)
    {
        $request->validate([
            'id' => 'required|string|size:5|unique:carreras,id|regex:/^[A-Z0-9]+$/',
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

        $carrera = Carrera::create($request->all());

        return redirect()->route('carreras.index')
            ->with('success', 'Carrera creada exitosamente.');
    }

    /**
     * Mostrar carrera específica
     */
    public function show(Carrera $carrera)
    {
        $carrera->load('facultad');

        return view('carreras.show', compact('carrera'));
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit(Carrera $carrera)
    {
        $facultades = Facultad::orderBy('nombre')->get();

        return view('carreras.edit', compact('carrera', 'facultades'));
    }

    /**
     * Actualizar carrera
     */
    public function update(Request $request, Carrera $carrera)
    {
        $request->validate([
            'id' => 'required|string|size:5|unique:carreras,id,'.$carrera->id.',id|regex:/^[A-Z0-9]+$/',
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

        $carrera->update($request->all());

        return redirect()->route('carreras.index')
            ->with('success', 'Carrera actualizada exitosamente.');
    }

    /**
     * Eliminar carrera
     */
    public function destroy(Carrera $carrera)
    {
        // Aquí podrías verificar si tiene títulos asociados cuando implementes esas tablas
        // Por ahora, permitimos eliminar directamente

        $carrera->delete();

        return redirect()->route('carreras.index')
            ->with('success', 'Carrera eliminada exitosamente.');
    }
}
