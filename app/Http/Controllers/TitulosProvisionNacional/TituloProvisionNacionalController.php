<?php

namespace App\Http\Controllers\TitulosProvisionNacional;

use App\Http\Controllers\Controller;
use App\Models\TitulosProvisionNacional\TituloProvisionNacional;
use App\Models\TitulosProvisionNacional\Mencion;
use App\Models\TitulosProvisionNacional\Modalidad;
use App\Models\Persona;
use App\Services\Documents\TituloProvisionNacionalDocumentService;
use App\Services\UniversityApiService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class TituloProvisionNacionalController extends Controller
{
    protected UniversityApiService $universityApiService;
    protected TituloProvisionNacionalDocumentService $documentService;

    public function __construct(
        UniversityApiService $universityApiService,
        TituloProvisionNacionalDocumentService $documentService
    ) {
        $this->universityApiService = $universityApiService;
        $this->documentService = $documentService;
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
            'ci' => 'required|string|min:3|max:255',
            'nombres' => 'required|string|max:255',
            'paterno' => 'required|string|max:255',
            'materno' => 'nullable|string|max:255',
            'nro_documento' => 'required|integer|min:1',
            'fojas' => 'nullable|integer|min:1',
            'libro' => 'nullable|integer|min:1',
            'fecha_emision' => 'required|date|before_or_equal:today',
            'observaciones' => 'nullable|string|max:1000',
            'mencion_tpn_id' => 'nullable|exists:menciones_tpn,id',
            'modalidad_tpn_id' => 'nullable|exists:modalidades_tpn,id',
            'verificado' => 'boolean',
            'file' => 'required|file|mimes:pdf|max:51200',
        ]);

        $validated['verificado'] = array_key_exists('verificado', $validated)
            ? (bool) $validated['verificado']
            : false;

        $persona = $this->upsertPersona($validated);
        $mencion = $this->findMencion($validated['mencion_tpn_id'] ?? null);

        $validated['file_dir'] = $this->documentService->store(
            $request->file('file'),
            $this->buildDocumentContext($validated, $persona, $mencion)
        );

        $validated['created_by'] = Auth::id();
        $validated['updated_by'] = Auth::id();

        unset($validated['file'], $validated['nombres'], $validated['paterno'], $validated['materno']);

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
        $titulo = TituloProvisionNacional::with(['persona', 'mencion', 'modalidad'])->findOrFail($id);

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
            'ci' => 'required|string|min:3|max:255',
            'nombres' => 'required|string|max:255',
            'paterno' => 'required|string|max:255',
            'materno' => 'nullable|string|max:255',
            'nro_documento' => 'required|integer|min:1',
            'fojas' => 'nullable|integer|min:1',
            'libro' => 'nullable|integer|min:1',
            'fecha_emision' => 'required|date|before_or_equal:today',
            'observaciones' => 'nullable|string|max:1000',
            'mencion_tpn_id' => 'nullable|exists:menciones_tpn,id',
            'modalidad_tpn_id' => 'nullable|exists:modalidades_tpn,id',
            'verificado' => 'boolean',
            'file' => 'nullable|file|mimes:pdf|max:51200',
        ]);

        $validated['verificado'] = array_key_exists('verificado', $validated)
            ? (bool) $validated['verificado']
            : $titulo->verificado;

        $persona = $this->upsertPersona($validated);
        $mencion = $this->findMencion($validated['mencion_tpn_id'] ?? null);

        if ($request->hasFile('file')) {
            $validated['file_dir'] = $this->documentService->replace(
                $titulo->file_dir,
                $request->file('file'),
                $this->buildDocumentContext($validated, $persona, $mencion)
            );
        }

        $validated['updated_by'] = Auth::id();

        unset($validated['file'], $validated['nombres'], $validated['paterno'], $validated['materno']);

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

        $this->documentService->delete($titulo->file_dir);

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

        if (! $titulo->file_dir || ! Storage::disk('public')->exists($titulo->file_dir)) {
            abort(404, 'Archivo PDF no encontrado.');
        }

        $filePath = Storage::disk('public')->path($titulo->file_dir);

        return response()->file($filePath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="titulo_pn_' . $titulo->nro_titulo_pn . '.pdf"'
        ]);
    }

    private function upsertPersona(array $data): Persona
    {
        return Persona::updateOrCreate(
            ['ci' => $data['ci']],
            [
                'nombres' => $data['nombres'],
                'paterno' => $data['paterno'],
                'materno' => isset($data['materno']) && $data['materno'] !== '' ? $data['materno'] : null,
            ]
        );
    }

    private function findMencion(?int $mencionId): ?Mencion
    {
        return $mencionId ? Mencion::find($mencionId) : null;
    }

    private function buildDocumentContext(array $validated, Persona $persona, ?Mencion $mencion): array
    {
        return [
            'fecha_emision' => $validated['fecha_emision'] ?? null,
            'mencion' => $mencion?->nombre,
            'ci' => $persona->ci,
            'nombres' => $persona->nombres,
            'paterno' => $persona->paterno,
            'materno' => $persona->materno,
        ];
    }

    /**
     * Authorize access based on user role and ownership
     */
    private function authorizeAccess(TituloProvisionNacional $titulo, string $action): void
    {
        $user = Auth::user();

        // Administrators have full access
        if ($user->hasRole('Administrador') || $user->hasRole('Administrator')) {
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
        if ($user->hasRole('Administrador') || $user->hasRole('Administrator')) {
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
