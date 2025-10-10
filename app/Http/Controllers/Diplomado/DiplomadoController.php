<?php

namespace App\Http\Controllers\Diplomado;

use App\Http\Controllers\Controller;
use App\Models\Diplomado\Diplomado;
use App\Models\Diplomado\Mencion;
use App\Models\Diplomado\Modalidad;
use App\Models\Persona;
use App\Models\TitulosProvisionNacional\Mencion as MencionTpn;
use App\Services\Documents\DiplomadoDocumentService;
use App\Services\UniversityApiService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class DiplomadoController extends Controller
{
    public function __construct(
        protected UniversityApiService $universityApiService,
        protected DiplomadoDocumentService $documentService
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

        $diplomados = Diplomado::with(['persona', 'mencion', 'modalidad', 'mencionTpn'])
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

        return Inertia::render('Diplomados/Index', [
            'diplomados' => $diplomados,
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

        return Inertia::render('Diplomados/Create', [
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
        $mencion = $this->resolveMencion($validated['mencion_diplomado_id'] ?? null);
        $mencionTpn = $this->resolveMencionTpn($validated['mencion_tpn_id'] ?? null);

        $validated['file_dir'] = $this->documentService->store(
            $request->file('file'),
            $this->buildDocumentContext($validated, $persona, $mencion, $mencionTpn)
        );

        $validated['created_by'] = Auth::id();
        $validated['updated_by'] = Auth::id();
        $validated['verificado'] = array_key_exists('verificado', $validated)
            ? (bool) $validated['verificado']
            : false;

        unset($validated['file'], $validated['nombres'], $validated['paterno'], $validated['materno']);

        $diplomado = Diplomado::create($validated);

        return redirect()
            ->route('diplomados.show', $diplomado->id)
            ->with('success', 'Diplomado registrado exitosamente.');
    }

    public function show(string $id)
    {
        $diplomado = Diplomado::with([
            'persona',
            'mencion',
            'modalidad',
            'mencionTpn',
            'createdBy',
            'updatedBy',
        ])->findOrFail($id);

        $this->authorizeView($diplomado);

        return Inertia::render('Diplomados/Show', [
            'diplomado' => $diplomado,
        ]);
    }

    public function edit(string $id)
    {
        $diplomado = Diplomado::with(['persona', 'mencion', 'modalidad', 'mencionTpn'])->findOrFail($id);

        $this->authorizeAccess($diplomado, 'edit');

        $menciones = Mencion::where('activo', true)->orderBy('nombre')->get();
        $modalidades = Modalidad::where('activo', true)->orderBy('nombre')->get();
        $mencionesTpn = MencionTpn::where('activo', true)->orderBy('nombre')->get();

        return Inertia::render('Diplomados/Edit', [
            'diplomado' => $diplomado,
            'menciones' => $menciones,
            'modalidades' => $modalidades,
            'mencionesTpn' => $mencionesTpn,
        ]);
    }

    public function update(Request $request, string $id)
    {
        $diplomado = Diplomado::findOrFail($id);

        $this->authorizeAccess($diplomado, 'update');

        $validated = $request->validate($this->rules($diplomado->id));
        $validated = $this->normalizeNumericFields($validated);
        $persona = $this->upsertPersona($validated);
        $mencion = $this->resolveMencion($validated['mencion_diplomado_id'] ?? null);
        $mencionTpn = $this->resolveMencionTpn($validated['mencion_tpn_id'] ?? null);

        if ($request->hasFile('file')) {
            $validated['file_dir'] = $this->documentService->replace(
                $diplomado->file_dir,
                $request->file('file'),
                $this->buildDocumentContext($validated, $persona, $mencion, $mencionTpn)
            );
        }

        $validated['updated_by'] = Auth::id();
        $validated['verificado'] = array_key_exists('verificado', $validated)
            ? (bool) $validated['verificado']
            : $diplomado->verificado;

        unset($validated['file'], $validated['nombres'], $validated['paterno'], $validated['materno']);

        $diplomado->update($validated);

        return redirect()
            ->route('diplomados.show', $diplomado->id)
            ->with('success', 'Diplomado actualizado exitosamente.');
    }

    public function destroy(string $id)
    {
        $diplomado = Diplomado::findOrFail($id);

        $this->authorizeAccess($diplomado, 'destroy');

        $this->documentService->delete($diplomado->file_dir);
        $diplomado->delete();

        return redirect()
            ->route('diplomados.index')
            ->with('success', 'Diplomado eliminado exitosamente.');
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
        $diplomado = Diplomado::findOrFail($id);
        $this->authorizeView($diplomado);

        if (! $diplomado->file_dir || ! Storage::disk('public')->exists($diplomado->file_dir)) {
            abort(404, 'Archivo PDF no encontrado.');
        }

        $filePath = Storage::disk('public')->path($diplomado->file_dir);

        return response()->file($filePath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="diplomado_' . $diplomado->nro_documento . '.pdf"',
        ]);
    }

    private function rules(?int $id = null): array
    {
        $nroTpnRule = Rule::unique('diplomados', 'nro_tpn');
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
            'sexo' => 'nullable|string|max:20',
            'nro_documento' => ['required', 'integer', 'min:1'],
            'fojas' => 'nullable|integer|min:1',
            'libro' => 'nullable|integer|min:1',
            'fecha_emision' => 'nullable|date|before_or_equal:today',
            'mencion_diplomado_id' => 'nullable|exists:menciones_diplomado,id',
            'gestion' => 'nullable|integer|min:1900|max:2100',
            'version' => 'nullable|integer|min:0|max:100',
            'modalidad_diplomado_id' => 'nullable|exists:modalidades_diplomado,id',
            'horas_creditos' => 'nullable|integer|min:0|max:10000',
            'trabajo_final' => 'nullable|boolean',
            'verificado' => 'boolean',
            'file' => $id ? 'nullable|file|mimes:pdf|max:51200' : 'required|file|mimes:pdf|max:51200',
        ];
    }

    private function normalizeNumericFields(array $validated): array
    {
        foreach (['mencion_diplomado_id', 'modalidad_diplomado_id', 'mencion_tpn_id'] as $field) {
            if (isset($validated[$field]) && $validated[$field] !== null && $validated[$field] !== '') {
                $validated[$field] = (int) $validated[$field];
            } else {
                $validated[$field] = null;
            }
        }

        foreach (['gestion', 'version', 'horas_creditos', 'fojas', 'libro', 'nro_documento'] as $field) {
            if (isset($validated[$field]) && $validated[$field] !== null && $validated[$field] !== '') {
                $validated[$field] = (int) $validated[$field];
            } else {
                $validated[$field] = null;
            }
        }

        if (array_key_exists('trabajo_final', $validated)) {
            $validated['trabajo_final'] = filter_var($validated['trabajo_final'], FILTER_VALIDATE_BOOLEAN);
        } else {
            $validated['trabajo_final'] = false;
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

    private function buildDocumentContext(array $validated, Persona $persona, ?Mencion $mencion, ?MencionTpn $mencionTpn): array
    {
        return [
            'gestion' => $validated['gestion'] ?? null,
            'mencion' => $mencion?->nombre,
            'mencion_tpn' => $mencionTpn?->nombre,
            'ci' => $persona->ci,
            'nombres' => $persona->nombres,
            'paterno' => $persona->paterno,
            'materno' => $persona->materno,
            'nro_tpn' => $validated['nro_tpn'] ?? null,
        ];
    }

    private function resolveMencionTpn(?int $mencionId): ?MencionTpn
    {
        return $mencionId ? MencionTpn::find($mencionId) : null;
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
                $errors['mencion_diplomado_id'] = 'Debe registrar al menos una mención de diplomado activa antes de crear un diplomado.';
            }

            if (! $hasModalidad) {
                $errors['modalidad_diplomado_id'] = 'Debe registrar al menos una modalidad de diplomado activa antes de crear un diplomado.';
            }

            throw ValidationException::withMessages($errors);
        }

        return false;
    }

    private function authorizeAccess(Diplomado $diplomado, string $action): void
    {
        $user = Auth::user();

        if ($user->activeRoleIn(['Administrador', 'Administrator'])) {
            return;
        }

        if ($user->activeRoleIs('Jefe') && in_array($action, ['show', 'servePdf'])) {
            return;
        }

        if ($user->activeRoleIs('Personal') && $diplomado->created_by === $user->getKey()) {
            return;
        }

        abort(403, 'No tiene permisos para realizar esta acción.');
    }

    private function authorizeView(Diplomado $diplomado): void
    {
        $user = Auth::user();

        if ($user->activeRoleIn(['Administrador', 'Administrator'])) {
            return;
        }

        if ($user->activeRoleIs('Jefe')) {
            return;
        }

        if ($user->activeRoleIs('Personal') && $diplomado->created_by === $user->getKey()) {
            return;
        }

        abort(403, 'No tiene permisos para acceder a este diplomado.');
    }
}
