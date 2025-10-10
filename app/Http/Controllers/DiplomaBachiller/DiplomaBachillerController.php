<?php

namespace App\Http\Controllers\DiplomaBachiller;

use App\Http\Controllers\Controller;
use App\Models\DiplomaBachiller\DiplomaBachiller;
use App\Models\DiplomaBachiller\Mencion;
use App\Models\Persona;
use App\Services\Documents\DiplomaBachillerDocumentService;
use App\Services\UniversityApiService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class DiplomaBachillerController extends Controller
{
    protected UniversityApiService $universityApiService;
    protected DiplomaBachillerDocumentService $documentService;

    public function __construct(
        UniversityApiService $universityApiService,
        DiplomaBachillerDocumentService $documentService
    ) {
        $this->universityApiService = $universityApiService;
        $this->documentService = $documentService;

        $this->middleware('auth');

        $this->middleware('active.role:Administrador|Jefe|Personal')->only([
            'index',
            'show',
            'servePdf',
        ]);

        $this->middleware('active.role:Administrador|Personal')->only([
            'create',
            'store',
            'edit',
            'update',
            'searchPerson',
        ]);

        $this->middleware('active.role:Administrador')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');

        $user = $request->user();

        $diplomas = DiplomaBachiller::with(['persona', 'mencion'])
            ->when($search, function ($query, $search) {
                $query->whereHas('persona', function ($personaQuery) use ($search) {
                    $personaQuery->where('ci', 'like', "%{$search}%")
                        ->orWhere('nombres', 'like', "%{$search}%")
                        ->orWhere('paterno', 'like', "%{$search}%")
                        ->orWhere('materno', 'like', "%{$search}%");
                });
            })
            ->when($user && $user->activeRoleIs('Personal'), function ($query) use ($user) {
                $query->where('created_by', $user->getKey());
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('DiplomaBachiller/Index', [
            'diplomas' => $diplomas,
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
        $menciones = Mencion::orderBy('nombre')->get();
        $dependenciesReady = $menciones->isNotEmpty();

        return Inertia::render('DiplomaBachiller/Create', [
            'menciones' => $menciones,
            'dependenciesReady' => $dependenciesReady,
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
            'fojas' => 'required|integer|min:1',
            'libro' => 'required|integer|min:1',
            'fecha_emision' => 'required|date|before_or_equal:today',
            'mencion_db_id' => 'required|exists:menciones_db,id',
            'observaciones' => 'nullable|string|max:1000',
            'verificado' => 'boolean',
            'file' => 'required|file|mimes:pdf|max:51200',
        ]);

        $validated['verificado'] = array_key_exists('verificado', $validated)
            ? (bool) $validated['verificado']
            : false;

        $persona = $this->upsertPersona($validated);
        $mencion = Mencion::findOrFail($validated['mencion_db_id']);

        $validated['file_dir'] = $this->documentService->store(
            $request->file('file'),
            $this->buildDocumentContext($validated, $persona, $mencion)
        );

        $validated['created_by'] = Auth::id();
        $validated['updated_by'] = Auth::id();

        unset($validated['file'], $validated['nombres'], $validated['paterno'], $validated['materno']);

        $diploma = DiplomaBachiller::create($validated);

        return redirect()
            ->route('diploma-bachiller.show', $diploma->id)
            ->with('success', 'Diploma de Bachiller creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $diploma = DiplomaBachiller::with([
            'persona',
            'mencion',
            'createdBy',
            'updatedBy',
        ])->findOrFail($id);

        $this->authorizeView($diploma);

        return Inertia::render('DiplomaBachiller/Show', [
            'diploma' => $diploma,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $diploma = DiplomaBachiller::with(['persona', 'mencion'])->findOrFail($id);

        $this->authorizeAccess($diploma, 'edit');

        $menciones = Mencion::orderBy('nombre')->get();

        return Inertia::render('DiplomaBachiller/Edit', [
            'diploma' => $diploma,
            'menciones' => $menciones,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $diploma = DiplomaBachiller::findOrFail($id);

        $this->authorizeAccess($diploma, 'update');

        $validated = $request->validate([
            'ci' => 'required|string|min:3|max:255',
            'nombres' => 'required|string|max:255',
            'paterno' => 'required|string|max:255',
            'materno' => 'nullable|string|max:255',
            'nro_documento' => 'required|integer|min:1',
            'fojas' => 'required|integer|min:1',
            'libro' => 'required|integer|min:1',
            'fecha_emision' => 'required|date|before_or_equal:today',
            'mencion_db_id' => 'required|exists:menciones_db,id',
            'observaciones' => 'nullable|string|max:1000',
            'verificado' => 'boolean',
            'file' => 'nullable|file|mimes:pdf|max:51200',
        ]);

        $validated['verificado'] = array_key_exists('verificado', $validated)
            ? (bool) $validated['verificado']
            : $diploma->verificado;

        $persona = $this->upsertPersona($validated);
        $mencion = Mencion::findOrFail($validated['mencion_db_id']);

        if ($request->hasFile('file')) {
            $validated['file_dir'] = $this->documentService->replace(
                $diploma->file_dir,
                $request->file('file'),
                $this->buildDocumentContext($validated, $persona, $mencion)
            );
        }

        $validated['updated_by'] = Auth::id();

        unset($validated['file'], $validated['nombres'], $validated['paterno'], $validated['materno']);

        $diploma->update($validated);

        return redirect()
            ->route('diploma-bachiller.show', $diploma->id)
            ->with('success', 'Diploma de Bachiller actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $diploma = DiplomaBachiller::findOrFail($id);

        $this->authorizeAccess($diploma, 'destroy');

        $this->documentService->delete($diploma->file_dir);

        $diploma->delete();

        return redirect()
            ->route('diploma-bachiller.index')
            ->with('success', 'Diploma de Bachiller eliminado exitosamente.');
    }

    /**
     * Search for person by CI through university API.
     */
    public function searchPerson(string $ci): JsonResponse
    {
        try {
            $personData = $this->universityApiService->searchPersonByCi($ci);

            return response()->json([
                'success' => true,
                'data' => $personData,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'No se encontraron resultados para el CI proporcionado.',
            ], 404);
        }
    }

    /**
     * Serve PDF file with authentication and permission checks.
     */
    public function servePdf(string $id)
    {
        $diploma = DiplomaBachiller::findOrFail($id);

        $this->authorizeView($diploma);

        if (! $diploma->file_dir || ! Storage::disk('public')->exists($diploma->file_dir)) {
            abort(404, 'Archivo PDF no encontrado.');
        }

        $filePath = Storage::disk('public')->path($diploma->file_dir);

        return response()->file($filePath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="diploma_bachiller_' . $diploma->nro_documento . '.pdf"',
        ]);
    }

    private function upsertPersona(array $validated): Persona
    {
        return Persona::updateOrCreate(
            ['ci' => $validated['ci']],
            [
                'nombres' => $validated['nombres'],
                'paterno' => $validated['paterno'],
                'materno' => isset($validated['materno']) && $validated['materno'] !== ''
                    ? $validated['materno']
                    : null,
            ]
        );
    }

    private function buildDocumentContext(array $validated, Persona $persona, Mencion $mencion): array
    {
        return [
            'fecha_emision' => $validated['fecha_emision'] ?? null,
            'mencion' => $mencion->nombre ?? null,
            'ci' => $persona->ci,
            'nombres' => $persona->nombres,
            'paterno' => $persona->paterno,
            'materno' => $persona->materno,
        ];
    }

    /**
     * Authorize access based on user role and ownership.
     */
    private function authorizeAccess(DiplomaBachiller $diploma, string $action): void
    {
        $user = Auth::user();

        if ($user->activeRoleIn(['Administrador', 'Administrator'])) {
            return;
        }

        if ($user->activeRoleIs('Jefe') && in_array($action, ['show', 'servePdf'])) {
            return;
        }

        if ($user->activeRoleIs('Personal') && $diploma->created_by === $user->getKey()) {
            return;
        }

        abort(403, 'No tiene permisos para realizar esta acción.');
    }

    /**
     * Authorize view access (more permissive).
     */
    private function authorizeView(DiplomaBachiller $diploma): void
    {
        $user = Auth::user();

        if ($user->activeRoleIn(['Administrador', 'Administrator'])) {
            return;
        }

        if ($user->activeRoleIs('Jefe')) {
            return;
        }

        if ($user->activeRoleIs('Personal') && $diploma->created_by === $user->getKey()) {
            return;
        }

        abort(403, 'No tiene permisos para acceder a este diploma.');
    }
}
