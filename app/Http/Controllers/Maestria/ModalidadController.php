<?php

namespace App\Http\Controllers\Maestria;

use App\Http\Controllers\Controller;
use App\Models\Maestria\Modalidad;
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

    public function index()
    {
        $modalidades = Modalidad::withCount('maestrias')
            ->orderByDesc('created_at')
            ->paginate(15);

        return Inertia::render('Maestrias/Modalidades', [
            'modalidades' => $modalidades,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:150|unique:modalidades_maestria,nombre',
            'activo' => 'boolean',
        ]);

        $validated['activo'] = $validated['activo'] ?? true;

        Modalidad::create($validated);

        return redirect()
            ->back()
            ->with('success', 'Modalidad de maestría creada exitosamente.');
    }

    public function update(Request $request, Modalidad $modalidad)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:150|unique:modalidades_maestria,nombre,' . $modalidad->id,
            'activo' => 'boolean',
        ]);

        $modalidad->update($validated);

        return redirect()
            ->back()
            ->with('success', 'Modalidad de maestría actualizada exitosamente.');
    }

    public function destroy(Modalidad $modalidad)
    {
        if ($modalidad->maestrias()->exists()) {
            return redirect()
                ->back()
                ->with('error', 'No se puede eliminar la modalidad porque tiene maestrías asociadas.');
        }

        $modalidad->delete();

        return redirect()
            ->back()
            ->with('success', 'Modalidad de maestría eliminada exitosamente.');
    }
}
