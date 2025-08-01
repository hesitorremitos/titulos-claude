<?php

namespace App\Http\Controllers;

use App\Models\DiplomaAcademico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DiplomaAcademicoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = DiplomaAcademico::with(['persona', 'mencion.carrera.facultad', 'graduacion', 'createdBy']);

        // Filtros de búsqueda
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('persona', function ($q) use ($search) {
                $q->where('ci', 'like', "%{$search}%")
                    ->orWhere('nombres', 'like', "%{$search}%")
                    ->orWhere('paterno', 'like', "%{$search}%")
                    ->orWhere('materno', 'like', "%{$search}%");
            });
        }

        if ($request->filled('facultad')) {
            $query->whereHas('mencion.carrera', function ($q) use ($request) {
                $q->where('facultad_id', $request->facultad);
            });
        }

        if ($request->filled('estado')) {
            if ($request->estado === 'digitalizado') {
                $query->whereNotNull('file_dir');
            } else {
                $query->whereNull('file_dir');
            }
        }

        // Control de acceso por rol
        if (auth()->user()->hasRole('Personal')) {
            $query->where('created_by', auth()->id());
        }

        $diplomas = $query->latest()->paginate(15)->withQueryString();

        return view('diplomas.index', compact('diplomas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('diplomas.create');
    }

    /**
     * Display the specified resource.
     */
    public function show(DiplomaAcademico $diploma)
    {
        $diploma->load(['persona', 'mencion.carrera.facultad', 'graduacion', 'createdBy', 'updatedBy']);

        // Control de acceso
        $this->checkDiplomaAccess($diploma, 'ver');

        return view('diplomas.show', compact('diploma'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DiplomaAcademico $diploma)
    {
        // Control de acceso
        $this->checkDiplomaAccess($diploma, 'eliminar');

        try {
            // Eliminar archivo PDF si existe
            if ($diploma->file_dir && Storage::disk('public')->exists($diploma->file_dir)) {
                Storage::disk('public')->delete($diploma->file_dir);
            }

            $diploma->delete();

            return redirect()->route('diplomas.index')
                ->with('success', 'Diploma académico eliminado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('diplomas.index')
                ->with('error', 'Error al eliminar el diploma académico: '.$e->getMessage());
        }
    }

    /**
     * Download PDF file
     */
    public function downloadPdf(DiplomaAcademico $diploma)
    {
        // Control de acceso
        $this->checkDiplomaAccess($diploma, 'descargar');

        if (! $diploma->file_dir || ! Storage::disk('public')->exists($diploma->file_dir)) {
            abort(404, 'Archivo no encontrado.');
        }

        return response()->download(Storage::disk('public')->path($diploma->file_dir));
    }

    /**
     * Check if user has access to the diploma
     */
    private function checkDiplomaAccess(DiplomaAcademico $diploma, string $action = 'acceder'): void
    {
        if (auth()->user()->hasRole('Personal') && $diploma->created_by !== auth()->id()) {
            abort(403, "No tienes permisos para {$action} a este diploma académico.");
        }
    }
}
