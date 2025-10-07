<?php

namespace App\Http\Controllers\TitulosProvisionNacional;

use App\Http\Controllers\Controller;
use App\Models\TitulosProvisionNacional\TituloProvisionNacional;
use App\Models\TitulosProvisionNacional\Mencion;
use App\Models\TitulosProvisionNacional\Modalidad;
use App\Models\Persona;
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

        $titulos = TituloProvisionNacional::with(['persona', 'mencion', 'modalidad'])
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
        $menciones = Mencion::where('activo', true)
            ->orderBy('nombre')
            ->get();

        $modalidades = Modalidad::where('activo', true)
            ->orderBy('nombre')
            ->get();

        return Inertia::render('TitulosProvisionNacional/Create', [
            'menciones' => $menciones,
            'modalidades' => $modalidades,
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
            'fojas' => 'nullable|integer|min:1',
            'libro' => 'nullable|integer|min:1',
            'fecha_emision' => 'required|date|before_or_equal:today',
              'observaciones' => 'nullable|string|max:1000',
            'mencion_tpn_id' => 'nullable|exists:menciones_tpn,id',
            'modalidad_tpn_id' => 'nullable|exists:modalidades_tpn,id',
            'file_dir' => 'nullable|string|max:500',
            'verificado' => 'boolean',
        ]);

        $validated['created_by'] = Auth::id();
        $validated['updated_by'] = Auth::id();

        $titulo = TituloProvisionNacional::create($validated);

        return redirect()
            ->route('titulos-provision-nacional.show', $titulo->id)
            ->with('success', 'Título Provisional Nacional creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $titulo = TituloProvisionNacional::with([
            'persona',
            'mencion',
            'modalidad',
            'createdBy',
            'updatedBy'
        ])->findOrFail($id);

        $this->authorizeView($titulo);

        return Inertia::render('TitulosProvisionNacional/Show', [
            'titulo' => $titulo,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $titulo = TituloProvisionNacional::findOrFail($id);

        $this->authorizeAccess($titulo, 'edit');

        $menciones = Mencion::where('activo', true)
            ->orderBy('nombre')
            ->get();

        $modalidades = Modalidad::where('activo', true)
            ->orderBy('nombre')
            ->get();

        return Inertia::render('TitulosProvisionNacional/Edit', [
            'titulo' => $titulo,
            'menciones' => $menciones,
            'modalidades' => $modalidades,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $titulo = TituloProvisionNacional::findOrFail($id);

        $this->authorizeAccess($titulo, 'update');

        $validated = $request->validate([
            'ci' => 'required|string|exists:personas,ci',
            'nro_documento' => 'required|integer|min:1',
            'fojas' => 'nullable|integer|min:1',
            'libro' => 'nullable|integer|min:1',
            'fecha_emision' => 'required|date|before_or_equal:today',
              'observaciones' => 'nullable|string|max:1000',
            'mencion_tpn_id' => 'nullable|exists:menciones_tpn,id',
            'modalidad_tpn_id' => 'nullable|exists:modalidades_tpn,id',
            'file_dir' => 'nullable|string|max:500',
            'verificado' => 'boolean',
        ]);

        $validated['updated_by'] = Auth::id();

        $titulo->update($validated);

        return redirect()
            ->route('titulos-provision-nacional.show', $titulo->id)
            ->with('success', 'Título Provisional Nacional actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $titulo = TituloProvisionNacional::findOrFail($id);

        $this->authorizeAccess($titulo, 'destroy');

        $titulo->delete();

        return redirect()
            ->route('titulos-provision-nacional.index')
            ->with('success', 'Título Provisional Nacional eliminado exitosamente.');
    }

    /**
     * Search for person by CI through university API
     */
    public function searchPerson(string $ci): JsonResponse
    {
        try {
            $personData = $this->universityApiService->searchPersonByCi($ci);

            return response()->json([
                'success' => true,
                'data' => $personData
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'No se encontraron resultados para el CI proporcionado.'
            ], 404);
        }
    }

    /**
     * Serve PDF file with authentication and permission checks
     */
    public function servePdf(string $id)
    {
        $titulo = TituloProvisionNacional::findOrFail($id);

        $this->authorizeView($titulo);

        if (!$titulo->file_dir) {
            abort(404, 'Archivo PDF no encontrado.');
        }

        $filePath = storage_path('app/public/' . $titulo->file_dir);

        if (!file_exists($filePath)) {
            abort(404, 'Archivo PDF no encontrado.');
        }

        return response()->file($filePath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="titulo_pn_' . $titulo->nro_titulo_pn . '.pdf"'
        ]);
    }

    /**
     * Authorize access based on user role and ownership
     */
    private function authorizeAccess(TituloProvisionNacional $titulo, string $action): void
    {
        $user = Auth::user();

        // Administrators have full access
        if ($user->hasRole('Administrator')) {
            return;
        }

        // Jefe can only view
        if ($user->hasRole('Jefe') && in_array($action, ['show'])) {
            return;
        }

        // Personal can only access their own titles
        if ($user->hasRole('Personal') && $titulo->created_by === $user->getKey()) {
            return;
        }

        abort(403, 'No tiene permisos para realizar esta acción.');
    }

    /**
     * Authorize view access (more permissive)
     */
    private function authorizeView(TituloProvisionNacional $titulo): void
    {
        $user = Auth::user();

        // Administrators have full access
        if ($user->hasRole('Administrator')) {
            return;
        }

        // Jefe can view all
        if ($user->hasRole('Jefe')) {
            return;
        }

        // Personal can only access their own titles
        if ($user->hasRole('Personal') && $titulo->created_by === $user->getKey()) {
            return;
        }

        abort(403, 'No tiene permisos para acceder a este título.');
    }
}