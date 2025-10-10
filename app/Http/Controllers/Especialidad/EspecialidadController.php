<?php

namespace App\Http\Controllers\Especialidad;

use App\Http\Controllers\Controller;
use App\Models\Especialidad\Especialidad;
use App\Models\Especialidad\Mencion;
use App\Models\Especialidad\Modalidad;
use App\Models\Persona;
use App\Models\TitulosProvisionNacional\Mencion as MencionTpn;
use App\Models\Universidad;
use App\Services\Documents\EspecialidadDocumentService;
use App\Services\UniversityApiService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class EspecialidadController extends Controller
{
    public function __construct(
        protected UniversityApiService $universityApiService,
        protected EspecialidadDocumentService $documentService
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

        $especialidades = Especialidad::with(['persona', 'mencion', 'modalidad', 'mencionTpn', 'universidad'])
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

        return Inertia::render('Especialidades/Index', [
            'especialidades' => $especialidades,
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
        $universidades = Universidad::orderBy('nombre')->get();

        return Inertia::render('Especialidades/Create', [
            'menciones' => $menciones,
            'modalidades' => $modalidades,
            'mencionesTpn' => $mencionesTpn,
            'universidades' => $universidades,
            'dependenciesReady' => $dependenciesReady,
        ]);
    }

    public function store(Request $request)
    {
        $this->ensureDependencies();

        $validated = $request->validate($this->rules());
        $validated = $this->normalizeFields($validated);
        $persona = $this->upsertPersona($validated);
        $mencion = $this->resolveMencion($validated['mencion_especialidad_id'] ?? null);
        $mencionTpn = $this->resolveMencionTpn($validated['mencion_tpn_id'] ?? null);
        $universidad = $this->resolveUniversidad($validated['universidad_id']);

        $validated['file_dir'] = $this->documentService->store(
            $request->file('file'),
            $this->buildDocumentContext($validated, $persona, $mencion, $mencionTpn, $universidad)
        );

        $validated['created_by'] = Auth::id();
        $validated['updated_by'] = Auth::id();
        $validated['verificado'] = array_key_exists('verificado', $validated)
            ? (bool) $validated['verificado']
            : false;

        unset($validated['file'], $validated['nombres'], $validated['paterno'], $validated['materno']);

        $especialidad = Especialidad::create($validated);

        return redirect()
            ->route('especialidades.show', $especialidad->id)
            ->with('success', 'Especialidad registrada exitosamente.');
    }

    public function show(string $id)
    {
        $especialidad = Especialidad::with([
            'persona',
            'mencion',
            'modalidad',
            'mencionTpn',
            'universidad',
            'createdBy',
            'updatedBy',
        ])->findOrFail($id);

        $this->authorizeView($especialidad);

        return Inertia::render('Especialidades/Show', [
            'especialidad' => $especialidad,
        ]);
    }

    public function edit(string $id)
    {
        $especialidad = Especialidad::with(['persona', 'mencion', 'modalidad', 'mencionTpn', 'universidad'])->findOrFail($id);

        $this->authorizeAccess($especialidad, 'edit');

        $menciones = Mencion::where('activo', true)->orderBy('nombre')->get();
        $modalidades = Modalidad::where('activo', true)->orderBy('nombre')->get();
        $mencionesTpn = MencionTpn::where('activo', true)->orderBy('nombre')->get();
        $universidades = Universidad::orderBy('nombre')->get();

        return Inertia::render('Especialidades/Edit', [
            'especialidad' => $especialidad,
            'menciones' => $menciones,
            'modalidades' => $modalidades,
            'mencionesTpn' => $mencionesTpn,
            'universidades' => $universidades,
        ]);
    }

    public function update(Request $request, string $id)
    {
        $especialidad = Especialidad::findOrFail($id);

        $this->authorizeAccess($especialidad, 'update');

        $validated = $request->validate($this->rules($especialidad->id));
        $validated = $this->normalizeFields($validated);
        $persona = $this->upsertPersona($validated);
        $mencion = $this->resolveMencion($validated['mencion_especialidad_id'] ?? null);
        $mencionTpn = $this->resolveMencionTpn($validated['mencion_tpn_id'] ?? null);
        $universidad = $this->resolveUniversidad($validated['universidad_id']);

        if ($request->hasFile('file')) {
            $validated['file_dir'] = $this->documentService->replace(
                $especialidad->file_dir,
                $request->file('file'),
                $this->buildDocumentContext($validated, $persona, $mencion, $mencionTpn, $universidad)
            );
        }

        $validated['updated_by'] = Auth::id();
        $validated['verificado'] = array_key_exists('verificado', $validated)
            ? (bool) $validated['verificado']
            : $especialidad->verificado;

        unset($validated['file'], $validated['nombres'], $validated['paterno'], $validated['materno']);

        $especialidad->update($validated);

        return redirect()
            ->route('especialidades.show', $especialidad->id)
            ->with('success', 'Especialidad actualizada exitosamente.');
    }

    public function destroy(string $id)
    {
        $especialidad = Especialidad::findOrFail($id);

        $this->authorizeAccess($especialidad, 'destroy');

        $this->documentService->delete($especialidad->file_dir);
        $especialidad->delete();

        return redirect()
            ->route('especialidades.index')
            ->with('success', 'Especialidad eliminada exitosamente.');
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
        $especialidad = Especialidad::findOrFail($id);
        $this->authorizeView($especialidad);

        if (! $especialidad->file_dir || ! Storage::disk('public')->exists($especialidad->file_dir)) {
            abort(404, 'Archivo PDF no encontrado.');
        }

        $filePath = Storage::disk('public')->path($especialidad->file_dir);

        return response()->file($filePath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="especialidad_' . $especialidad->nro_documento . '.pdf"',
        ]);
    }

    private function rules(?int $id = null): array
    {
        $nroTpnRule = Rule::unique('especialidades', 'nro_tpn');
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
            'mencion_especialidad_id' => 'nullable|exists:menciones_especialidad,id',
            'gestion' => 'nullable|integer|min:1900|max:2100',
            'version' => 'nullable|integer|min:0|max:100',
            'modalidad_especialidad_id' => 'nullable|exists:modalidades_especialidad,id',
            'horas_academicas' => ['nullable', 'string', 'regex:/^\d{1,4}\/\d{1,4}$/'],
            'promedio_final' => 'nullable|boolean',
            'universidad_id' => 'required|exists:universidades,id',
            'verificado' => 'boolean',
            'file' => $id ? 'nullable|file|mimes:pdf|max:51200' : 'required|file|mimes:pdf|max:51200',
        ];
    }

    private function normalizeFields(array $validated): array
    {
        foreach ([
            'mencion_especialidad_id',
            'modalidad_especialidad_id',
            'mencion_tpn_id',
            'universidad_id',
        ] as $field) {
            if (isset($validated[$field]) && $validated[$field] !== null && $validated[$field] !== '') {
                $validated[$field] = (int) $validated[$field];
            } else {
                $validated[$field] = null;
            }
        }

        foreach (['gestion', 'version', 'fojas', 'libro', 'nro_documento'] as $field) {
            if (isset($validated[$field]) && $validated[$field] !== null && $validated[$field] !== '') {
                $validated[$field] = (int) $validated[$field];
            } else {
                $validated[$field] = null;
            }
        }

        if (array_key_exists('promedio_final', $validated)) {
            $validated['promedio_final'] = filter_var($validated['promedio_final'], FILTER_VALIDATE_BOOLEAN);
        } else {
            $validated['promedio_final'] = false;
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

    private function resolveMencionTpn(?int $mencionId): ?MencionTpn
    {
        return $mencionId ? MencionTpn::find($mencionId) : null;
    }

    private function resolveUniversidad(?int $universidadId): ?Universidad
    {
        return $universidadId ? Universidad::find($universidadId) : null;
    }

    private function buildDocumentContext(array $validated, Persona $persona, ?Mencion $mencion, ?MencionTpn $mencionTpn, ?Universidad $universidad): array
    {
        return [
            'gestion' => $validated['gestion'] ?? null,
            'mencion' => $mencion?->nombre,
            'mencion_tpn' => $mencionTpn?->nombre,
            'universidad' => $universidad?->nombre,
            'ci' => $persona->ci,
            'nombres' => $persona->nombres,
            'paterno' => $persona->paterno,
            'materno' => $persona->materno,
            'nro_tpn' => $validated['nro_tpn'] ?? null,
        ];
    }

    private function ensureDependencies(bool $throw = true): bool
    {
        $hasMencion = Mencion::where('activo', true)->exists();
        $hasModalidad = Modalidad::where('activo', true)->exists();
        $hasUniversidad = Universidad::exists();

        if ($hasMencion && $hasModalidad && $hasUniversidad) {
            return true;
        }

        if ($throw) {
            $errors = [];

            if (! $hasMencion) {
                $errors['mencion_especialidad_id'] = 'Debe registrar al menos una mención de especialidad activa antes de crear una especialidad.';
            }

            if (! $hasModalidad) {
                $errors['modalidad_especialidad_id'] = 'Debe registrar al menos una modalidad de especialidad activa antes de crear una especialidad.';
            }

            if (! $hasUniversidad) {
                $errors['universidad_id'] = 'Debe registrar al menos una universidad antes de crear una especialidad.';
            }

            throw ValidationException::withMessages($errors);
        }

        return false;
    }

    private function authorizeAccess(Especialidad $especialidad, string $action): void
    {
        $user = Auth::user();

        if ($user->activeRoleIn(['Administrador', 'Administrator'])) {
            return;
        }

        if ($user->activeRoleIs('Jefe') && in_array($action, ['show', 'servePdf'])) {
            return;
        }

        if ($user->activeRoleIs('Personal') && $especialidad->created_by === $user->getKey()) {
            return;
        }

        abort(403, 'No tiene permisos para realizar esta acción.');
    }

    private function authorizeView(Especialidad $especialidad): void
    {
        $user = Auth::user();

        if ($user->activeRoleIn(['Administrador', 'Administrator'])) {
            return;
        }

        if ($user->activeRoleIs('Jefe')) {
            return;
        }

        if ($user->activeRoleIs('Personal') && $especialidad->created_by === $user->getKey()) {
            return;
        }

        abort(403, 'No tiene permisos para acceder a esta especialidad.');
    }
}
