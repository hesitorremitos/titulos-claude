<?php

namespace App\Http\Controllers\DiplomasAcademicos;

use App\Http\Controllers\Controller;
use App\Models\DiplomaAcademico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DiplomaAcademicoController extends Controller
{
    /**
     * Display a listing of diplomas.
     */
    public function index(Request $request)
    {
        $this->authorize('ver-titulos');

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
        $this->authorize('crear-titulos');

        return view('diplomas.create');
    }

    /**
     * Display the specified resource.
     */
    public function show(DiplomaAcademico $diploma)
    {
        $this->authorize('ver-titulos');
        $this->checkDiplomaAccess($diploma);

        $diploma->load(['persona', 'mencion.carrera.facultad', 'graduacion', 'createdBy', 'updatedBy']);

        return view('diplomas.show', compact('diploma'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DiplomaAcademico $diploma)
    {
        $this->authorize('eliminar-titulos');
        $this->checkDiplomaAccess($diploma);

        try {
            // Delete associated file if exists
            if ($diploma->file_dir && Storage::disk('public')->exists($diploma->file_dir)) {
                Storage::disk('public')->delete($diploma->file_dir);
            }

            $diploma->delete();

            return redirect()->route('diplomas.index')
                ->with('success', 'Diploma eliminado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al eliminar el diploma: '.$e->getMessage());
        }
    }

    /**
     * Download the PDF file of the diploma.
     */
    public function downloadPdf(DiplomaAcademico $diploma)
    {
        $this->authorize('ver-titulos');
        $this->checkDiplomaAccess($diploma);

        if (! $diploma->file_dir || ! Storage::disk('public')->exists($diploma->file_dir)) {
            return redirect()->back()->with('error', 'Archivo no encontrado.');
        }

        $filePath = Storage::disk('public')->path($diploma->file_dir);
        $fileName = "diploma_{$diploma->nro_documento}.pdf";

        return response()->download($filePath, $fileName);
    }

    /**
     * Check diploma access permissions.
     */
    private function checkDiplomaAccess(DiplomaAcademico $diploma): void
    {
        if (auth()->user()->hasRole('Personal') && $diploma->created_by !== auth()->id()) {
            abort(403, 'No tienes permiso para acceder a este diploma.');
        }
    }
}
