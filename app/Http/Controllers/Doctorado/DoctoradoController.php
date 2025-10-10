<?php

namespace App\Http\Controllers\Doctorado;

use App\Http\Controllers\Controller;
use App\Models\Doctorado\Doctorado;
use App\Models\Doctorado\Mencion;
use App\Models\Doctorado\Modalidad;
use App\Models\Persona;
use App\Models\TitulosProvisionNacional\Mencion as MencionTpn;
use App\Services\Documents\DoctoradoDocumentService;
use App\Services\UniversityApiService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class DoctoradoController extends Controller
{
    public function __construct(
        protected UniversityApiService $universityApiService,
        protected DoctoradoDocumentService $documentService
    ) {
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

    public function index(Request $request)
    {
        $search = $request->get('search');

        $user = $request->user();

        $doctorados = Doctorado::with(['persona', 'mencion', 'modalidad', 'mencionTpn'])
            ->when($search, function ($query, $search) {
                $query->where('ci', 'like', "%{$search}%")
                    ->orWhere('nro_tpn', 'like', "%{$search}%")
                    ->orWhere('nro_documento', 'like', "%{$search}%")
                    ->orWhereHas('persona', function ($personaQuery) use ($search) {
                        $personaQuery->where('nombres', 'like', "%{$search}%")
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

        return Inertia::render('Doctorados/Index', [
            'doctorados' => $doctorados,
            'filters' => [
                'search' => $search,
            ],
        ]);
    }

    public function create()
    {
        $dependenciesReady = $this->ensureDependencies(false);

        $menciones = Mencion::where('activo', true)->orderBy('nombre')->get();
        $modalidades = Modalidad::where('activo', true)->orderBy('nombre')->get();
        $mencionesTpn = MencionTpn::where('activo', true)->orderBy('nombre')->get();

        return Inertia::render('Doctorados/Create', [
            'menciones' => $menciones,
            'modalidades' => $modalidades,
            'mencionesTpn' => $mencionesTpn,
            'dependenciesReady' => $dependenciesReady,
        ]);
    }

    public function store(Request $request)
    {
        $this->ensureDependencies();

        $validated = $request->validate($this->rules());
        $validated = $this->normalizeNumericFields($validated);
        $persona = $this->upsertPersona($validated);
        $mencion = $this->resolveMencion($validated['mencion_doctorado_id'] ?? null);

        $validated['file_dir'] = $this->documentService->store(
            $request->file('file'),
            $this->buildDocumentContext($validated, $persona, $mencion)
        );

        $validated['created_by'] = Auth::id();
        $validated['updated_by'] = Auth::id();
        $validated['verificado'] = array_key_exists('verificado', $validated)
            ? (bool) $validated['verificado']
            : false;

        unset($validated['file'], $validated['nombres'], $validated['paterno'], $validated['materno']);

        $doctorado = Doctorado::create($validated);

        return redirect()
            ->route('doctorados.show', $doctorado->id)
            ->with('success', 'Doctorado registrado exitosamente.');
    }

    public function show(string $id)
    {
        $doctorado = Doctorado::with([
            'persona',
            'mencion',
            'modalidad',
            'mencionTpn',
            'createdBy',
            'updatedBy',
        ])->findOrFail($id);

        $this->authorizeView($doctorado);

        return Inertia::render('Doctorados/Show', [
            'doctorado' => $doctorado,
        ]);
    }

    public function edit(string $id)
    {
        $doctorado = Doctorado::with(['persona', 'mencion', 'modalidad', 'mencionTpn'])->findOrFail($id);

        $this->authorizeAccess($doctorado, 'edit');

        $menciones = Mencion::where('activo', true)->orderBy('nombre')->get();
        $modalidades = Modalidad::where('activo', true)->orderBy('nombre')->get();
        $mencionesTpn = MencionTpn::where('activo', true)->orderBy('nombre')->get();

        return Inertia::render('Doctorados/Edit', [
            'doctorado' => $doctorado,
            'menciones' => $menciones,
            'modalidades' => $modalidades,
            'mencionesTpn' => $mencionesTpn,
        ]);
    }

    public function update(Request $request, string $id)
    {
        $doctorado = Doctorado::findOrFail($id);

        $this->authorizeAccess($doctorado, 'update');

        $validated = $request->validate($this->rules($doctorado->id));
        $validated = $this->normalizeNumericFields($validated);
        $persona = $this->upsertPersona($validated);
        $mencion = $this->resolveMencion($validated['mencion_doctorado_id'] ?? null);

        if ($request->hasFile('file')) {
            $validated['file_dir'] = $this->documentService->replace(
                $doctorado->file_dir,
                $request->file('file'),
                $this->buildDocumentContext($validated, $persona, $mencion)
            );
        }

        $validated['updated_by'] = Auth::id();
        $validated['verificado'] = array_key_exists('verificado', $validated)
            ? (bool) $validated['verificado']
            : $doctorado->verificado;

        unset($validated['file'], $validated['nombres'], $validated['paterno'], $validated['materno']);

        $doctorado->update($validated);

        return redirect()
            ->route('doctorados.show', $doctorado->id)
            ->with('success', 'Doctorado actualizado exitosamente.');
    }

    public function destroy(string $id)
    {
        $doctorado = Doctorado::findOrFail($id);

        $this->authorizeAccess($doctorado, 'destroy');

        $this->documentService->delete($doctorado->file_dir);
        $doctorado->delete();

        return redirect()
            ->route('doctorados.index')
            ->with('success', 'Doctorado eliminado exitosamente.');
    }

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

    public function servePdf(string $id)
    {
        $doctorado = Doctorado::findOrFail($id);
        $this->authorizeView($doctorado);

        if (! $doctorado->file_dir || ! Storage::disk('public')->exists($doctorado->file_dir)) {
            abort(404, 'Archivo PDF no encontrado.');
        }

        $filePath = Storage::disk('public')->path($doctorado->file_dir);

        return response()->file($filePath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="doctorado_' . $doctorado->nro_documento . '.pdf"',
        ]);
    }

    private function rules(?int $id = null): array
    {
        $nroTpnRule = Rule::unique('doctorados', 'nro_tpn');
        if ($id) {
            $nroTpnRule = $nroTpnRule->ignore($id);
        }

        return [
            'ci' => 'required|string|min:3|max:255',
            'nombres' => 'required|string|max:255',
            'paterno' => 'required|string|max:255',
            'materno' => 'nullable|string|max:255',
            'nro_tpn' => ['required', 'string', 'max:50', 'regex:/^[A-Za-z0-9]+-\d{4}$/', $nroTpnRule],
            'mencion_tpn_id' => 'nullable|exists:menciones_tpn,id',
            'nro_documento' => ['required', 'integer', 'min:1'],
            'fojas' => 'nullable|integer|min:1',
            'libro' => 'nullable|integer|min:1',
            'fecha_emision' => 'nullable|date|before_or_equal:today',
            'mencion_doctorado_id' => 'required|exists:menciones_doctorado,id',
            'gestion_inicial' => 'nullable|integer|min:1900|max:2100',
            'gestion_final' => 'nullable|integer|min:1900|max:2100',
            'version' => 'nullable|integer|min:0|max:100',
            'modalidad_doctorado_id' => 'required|exists:modalidades_doctorado,id',
            'horas_creditos' => ['nullable', 'string', 'regex:/^\d{1,6}\/\d{4}$/'],
            'observaciones' => 'nullable|string|max:1000',
            'verificado' => 'boolean',
            'file' => $id ? 'nullable|file|mimes:pdf|max:51200' : 'required|file|mimes:pdf|max:51200',
        ];
    }

    private function normalizeNumericFields(array $validated): array
    {
        foreach (['mencion_tpn_id', 'mencion_doctorado_id', 'modalidad_doctorado_id'] as $field) {
            if (isset($validated[$field]) && $validated[$field] !== null) {
                $validated[$field] = (int) $validated[$field];
            }
        }

        foreach (['gestion_inicial', 'gestion_final', 'version', 'fojas', 'libro', 'nro_documento'] as $field) {
            if (isset($validated[$field]) && $validated[$field] !== null && $validated[$field] !== '') {
                $validated[$field] = (int) $validated[$field];
            } else {
                $validated[$field] = null;
            }
        }

        if (
            $validated['gestion_inicial'] !== null &&
            $validated['gestion_final'] !== null &&
            $validated['gestion_final'] < $validated['gestion_inicial']
        ) {
            throw ValidationException::withMessages([
                'gestion_final' => 'La gestión final debe ser mayor o igual a la gestión inicial.',
            ]);
        }

        return $validated;
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

    private function resolveMencion(?int $mencionId): ?Mencion
    {
        return $mencionId ? Mencion::find($mencionId) : null;
    }

    private function buildDocumentContext(array $validated, Persona $persona, ?Mencion $mencion): array
    {
        return [
            'gestion_inicial' => $validated['gestion_inicial'] ?? null,
            'gestion_final' => $validated['gestion_final'] ?? null,
            'mencion' => $mencion?->nombre,
            'ci' => $persona->ci,
            'nombres' => $persona->nombres,
            'paterno' => $persona->paterno,
            'materno' => $persona->materno,
        ];
    }

    private function ensureDependencies(bool $throw = true): bool
    {
        $hasMencion = Mencion::where('activo', true)->exists();
        $hasModalidad = Modalidad::where('activo', true)->exists();

        if ($hasMencion && $hasModalidad) {
            return true;
        }

        if ($throw) {
            $errors = [];

            if (! $hasMencion) {
                $errors['mencion_doctorado_id'] = 'Debe registrar al menos una mención de doctorado activa antes de crear un doctorado.';
            }

            if (! $hasModalidad) {
                $errors['modalidad_doctorado_id'] = 'Debe registrar al menos una modalidad de doctorado activa antes de crear un doctorado.';
            }

            throw ValidationException::withMessages($errors);
        }

        return false;
    }

    private function authorizeAccess(Doctorado $doctorado, string $action): void
    {
        $user = Auth::user();

        if ($user->activeRoleIn(['Administrador', 'Administrator'])) {
            return;
        }

        if ($user->activeRoleIs('Jefe') && in_array($action, ['show', 'servePdf'])) {
            return;
        }

        if ($user->activeRoleIs('Personal') && $doctorado->created_by === $user->getKey()) {
            return;
        }

        abort(403, 'No tiene permisos para realizar esta acción.');
    }

    private function authorizeView(Doctorado $doctorado): void
    {
        $user = Auth::user();

        if ($user->activeRoleIn(['Administrador', 'Administrator'])) {
            return;
        }

        if ($user->activeRoleIs('Jefe')) {
            return;
        }

        if ($user->activeRoleIs('Personal') && $doctorado->created_by === $user->getKey()) {
            return;
        }

        abort(403, 'No tiene permisos para acceder a este doctorado.');
    }
}
