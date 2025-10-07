<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\GraduacionDa;
use App\Models\TituloProvisionNacional;
use App\Services\UniversityApiService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class TituloProvisionNacionalController extends Controller
{
    protected UniversityApiService $universityApiService;

    public function __construct(UniversityApiService $universityApiService)
    {
        $this->universityApiService = $universityApiService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');

        $titulos = TituloProvisionNacional::with(['persona', 'graduacion'])
            ->when($search, function ($query, $search) {
                $query->whereHas('persona', function ($personaQuery) use ($search) {
                    $personaQuery->where('ci', 'like', "%{$search}%")
                        ->orWhere('nombres', 'like', "%{$search}%")
                        ->orWhere('paterno', 'like', "%{$search}%")
                        ->orWhere('materno', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('TitulosProvisionNacional/Index', [
            'titulos' => $titulos,
            'filters' => [
                'search' => $search,
            ],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $graduaciones = GraduacionDa::orderBy('nombre')->get();

        return Inertia::render('TitulosProvisionNacional/Create', [
            'graduaciones' => $graduaciones,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'ci' => 'required|string|exists:personas,ci',
            'nro_documento' => 'required|integer|min:1',
            'fojas' => 'required|integer|min:1',
            'libro' => 'required|integer|min:1',
            'fecha_emision' => 'nullable|date|before_or_equal:today',
            'nro_titulo_pn' => 'required|string|max:50',
            'observaciones' => 'nullable|string|max:1000',
            'graduacion_id' => 'nullable|exists:graduacion_da,id',
            'file_dir' => 'nullable|file|mimes:pdf|max:51200', // 50MB
        ]);

        // Upload PDF if provided
        if ($request->hasFile('file_dir')) {
            $file = $request->file('file_dir');
            $filename = 'tpn_'.$validated['ci'].'_'.time().'.pdf';
            $validated['file_dir'] = $file->storeAs('titulos-provision-nacional', $filename, 'public');
        }

        $validated['created_by'] = Auth::id();
        $validated['updated_by'] = Auth::id();

        TituloProvisionNacional::create($validated);

        return redirect()
            ->route('titulos-provision-nacional.index')
            ->with('success', 'Título de Provisión Nacional registrado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(TituloProvisionNacional $titulo)
    {
        $titulo->load(['persona', 'graduacion', 'createdBy', 'updatedBy']);

        // Check access permissions
        $this->checkTituloAccess($titulo);

        return Inertia::render('TitulosProvisionNacional/Show', [
            'titulo' => $titulo,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TituloProvisionNacional $titulo)
    {
        $titulo->load(['persona', 'graduacion']);
        $graduaciones = GraduacionDa::orderBy('nombre')->get();

        // Check access permissions
        $this->checkTituloAccess($titulo, true);

        return Inertia::render('TitulosProvisionNacional/Edit', [
            'titulo' => $titulo,
            'graduaciones' => $graduaciones,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TituloProvisionNacional $titulo)
    {
        // Check access permissions
        $this->checkTituloAccess($titulo, true);

        $validated = $request->validate([
            'nro_documento' => 'required|integer|min:1',
            'fojas' => 'required|integer|min:1',
            'libro' => 'required|integer|min:1',
            'fecha_emision' => 'nullable|date|before_or_equal:today',
            'nro_titulo_pn' => 'required|string|max:50',
            'observaciones' => 'nullable|string|max:1000',
            'graduacion_id' => 'nullable|exists:graduacion_da,id',
            'file_dir' => 'nullable|file|mimes:pdf|max:51200', // 50MB
        ]);

        // Handle PDF update
        if ($request->hasFile('file_dir')) {
            // Delete old file if exists
            if ($titulo->file_dir) {
                Storage::disk('public')->delete($titulo->file_dir);
            }

            $file = $request->file('file_dir');
            $filename = 'tpn_'.$titulo->ci.'_'.time().'.pdf';
            $validated['file_dir'] = $file->storeAs('titulos-provision-nacional', $filename, 'public');
        }

        $validated['updated_by'] = Auth::id();

        $titulo->update($validated);

        return redirect()
            ->route('titulos-provision-nacional.show', $titulo)
            ->with('success', 'Título de Provisión Nacional actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TituloProvisionNacional $titulo)
    {
        // Check access permissions
        $this->checkTituloAccess($titulo, true);

        // Delete PDF file if exists
        if ($titulo->file_dir) {
            Storage::disk('public')->delete($titulo->file_dir);
        }

        $titulo->delete();

        return redirect()
            ->route('titulos-provision-nacional.index')
            ->with('success', 'Título de Provisión Nacional eliminado exitosamente.');
    }

    /**
     * Serve PDF file for download/viewing.
     */
    public function servePdf(TituloProvisionNacional $titulo)
    {
        if (! $titulo->file_dir) {
            abort(404, 'PDF no disponible');
        }

        $filePath = Storage::disk('public')->path($titulo->file_dir);

        // Return file response with appropriate headers
        return response()->file($filePath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="tpn_'.$titulo->ci.'.pdf"',
        ]);
    }

    /**
     * Search person by CI in university API.
     */
    public function searchPerson(string $ci): JsonResponse
    {
        try {
            // Validate CI parameter
            if (empty($ci) || strlen($ci) < 3) {
                return response()->json([
                    'success' => false,
                    'message' => 'CI debe tener al menos 3 caracteres',
                    'data' => [],
                ], 400);
            }

            // Search person using University API Service
            $result = $this->universityApiService->searchPersonByCi($ci);

            if ($result['success']) {
                // The frontend expects the raw API response format
                $response = Http::timeout(10)->post("https://apititulos.uatf.edu.bo/api/datos?ru='{$ci}'");

                if ($response->successful()) {
                    return response()->json($response->json());
                }
            }

            return response()->json([], 404);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error interno del servidor',
                'data' => [],
            ], 500);
        }
    }

    /**
     * Check if user has access to the titulo.
     */
    private function checkTituloAccess(TituloProvisionNacional $titulo, bool $requireEditPermission = false): void
    {
        $user = Auth::user();

        // Administrators can access all
        if ($user->hasRole('Administrador')) {
            return;
        }

        // Jefe can view but not edit
        if ($user->hasRole('Jefe')) {
            if ($requireEditPermission) {
                abort(403, 'No tienes permiso para editar títulos.');
            }

            return;
        }

        // Personal can only access their own titulos
        if ($user->hasRole('Personal')) {
            if ($titulo->created_by !== $user->id) {
                abort(403, 'No tienes permiso para acceder a este título.');
            }

            return;
        }

        abort(403, 'No tienes permiso para acceder a esta sección.');
    }
}
