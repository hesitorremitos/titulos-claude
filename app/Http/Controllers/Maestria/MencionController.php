<?php

namespace App\Http\Controllers\Maestria;

use App\Http\Controllers\Controller;
use App\Models\Maestria\Mencion;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MencionController extends Controller
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
        $menciones = Mencion::withCount('maestrias')
            ->orderByDesc('created_at')
            ->paginate(15);

        return Inertia::render('Maestrias/Menciones', [
            'menciones' => $menciones,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:200|unique:menciones_maestria,nombre',
            'activo' => 'boolean',
        ]);

        $validated['activo'] = $validated['activo'] ?? true;

        Mencion::create($validated);

        return redirect()
            ->back()
            ->with('success', 'Mención de maestría creada exitosamente.');
    }

    public function update(Request $request, Mencion $mencion)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:200|unique:menciones_maestria,nombre,' . $mencion->id,
            'activo' => 'boolean',
        ]);

        $mencion->update($validated);

        return redirect()
            ->back()
            ->with('success', 'Mención de maestría actualizada exitosamente.');
    }

    public function destroy(Mencion $mencion)
    {
        if ($mencion->maestrias()->exists()) {
            return redirect()
                ->back()
                ->with('error', 'No se puede eliminar la mención porque tiene maestrías asociadas.');
        }

        $mencion->delete();

        return redirect()
            ->back()
            ->with('success', 'Mención de maestría eliminada exitosamente.');
    }
}
