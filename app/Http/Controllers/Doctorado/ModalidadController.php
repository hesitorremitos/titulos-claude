<?php

namespace App\Http\Controllers\Doctorado;

use App\Http\Controllers\Controller;
use App\Models\Doctorado\Modalidad;
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
        $modalidades = Modalidad::withCount('doctorados')
            ->orderByDesc('created_at')
            ->paginate(15);

        return Inertia::render('Doctorados/Modalidades', [
            'modalidades' => $modalidades,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:150|unique:modalidades_doctorado,nombre',
            'activo' => 'boolean',
        ]);

        $validated['activo'] = $validated['activo'] ?? true;

        Modalidad::create($validated);

        return redirect()
            ->back()
            ->with('success', 'Modalidad de doctorado creada exitosamente.');
    }

    public function update(Request $request, Modalidad $modalidad)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:150|unique:modalidades_doctorado,nombre,' . $modalidad->id,
            'activo' => 'boolean',
        ]);

        $modalidad->update($validated);

        return redirect()
            ->back()
            ->with('success', 'Modalidad de doctorado actualizada exitosamente.');
    }

    public function destroy(Modalidad $modalidad)
    {
        if ($modalidad->doctorados()->exists()) {
            return redirect()
                ->back()
                ->with('error', 'No se puede eliminar la modalidad porque tiene doctorados asociados.');
        }

        $modalidad->delete();

        return redirect()
            ->back()
            ->with('success', 'Modalidad de doctorado eliminada exitosamente.');
    }
}
