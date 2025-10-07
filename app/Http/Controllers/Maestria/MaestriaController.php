<?php

namespace App\Http\Controllers\Maestria;

use App\Http\Controllers\Controller;
use App\Models\Maestria\Maestria;
use App\Models\Maestria\Mencion;
use App\Models\Maestria\Modalidad;
use App\Models\Persona;
use App\Models\TitulosProvisionNacional\Mencion as MencionTpn;
use App\Services\Documents\MaestriaDocumentService;
use App\Services\UniversityApiService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class MaestriaController extends Controller
{
    public function __construct(
        protected UniversityApiService $universityApiService,
        protected MaestriaDocumentService $documentService
    ) {
    }

    public function index(Request $request)
    {
        $search = $request->get('search');

        $maestrias = Maestria::with(['persona', 'mencion', 'modalidad', 'mencionTpn'])
            ->when($search, function ($query, $search) {
                $query->where('ci', 'like', "%{$search}%")
                    ->orWhere('nro_tpn', 'like', "%{$search}%")
                    ->orWhereHas('persona', function ($personaQuery) use ($search) {
                        $personaQuery->where('nombres', 'like', "%{$search}%")
                            ->orWhere('paterno', 'like', "%{$search}%")
                            ->orWhere('materno', 'like', "%{$search}%");
                    });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Maestrias/Index', [
            'maestrias' => $maestrias,
            'filters' => [
                'search' => $search,
            ],
        ]);
    }

    public function create()
    {
        $dependenciesReady = $this->ensureDependencies(false);

        $menciones = Mencion::where('activo', true)
            ->orderBy('nombre')
            ->get();

        $modalidades = Modalidad::where('activo', true)
            ->orderBy('nombre')
            ->get();

        $mencionesTpn = MencionTpn::where('activo', true)
            ->orderBy('nombre')
            ->get();

        return Inertia::render('Maestrias/Create', [
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

        $mencion = $this->resolveMencion($validated['mencion_maestria_id'] ?? null);

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

        $maestria = Maestria::create($validated);

        return redirect()
            ->route('maestrias.show', $maestria->id)
            ->with('success', 'Maestría registrada exitosamente.');
    }

    public function show(string $id)
    {
        $maestria = Maestria::with([
            'persona',
            'mencion',
            'modalidad',
            'mencionTpn',
            'createdBy',
            'updatedBy',
        ])->findOrFail($id);

        $this->authorizeView($maestria);

        return Inertia::render('Maestrias/Show', [
            'maestria' => $maestria,
        ]);
    }

    public function edit(string $id)
    {
        $maestria = Maestria::with(['persona', 'mencion', 'modalidad', 'mencionTpn'])->findOrFail($id);

        $this->authorizeAccess($maestria, 'edit');

        $menciones = Mencion::where('activo', true)->orderBy('nombre')->get();
        $modalidades = Modalidad::where('activo', true)->orderBy('nombre')->get();

        $mencionesTpn = MencionTpn::where('activo', true)
            ->orderBy('nombre')
            ->get();

        return Inertia::render('Maestrias/Edit', [
            'maestria' => $maestria,
            'menciones' => $menciones,
            'modalidades' => $modalidades,
            'mencionesTpn' => $mencionesTpn,
        ]);
    }

    public function update(Request $request, string $id)
    {
        $maestria = Maestria::findOrFail($id);

        $this->authorizeAccess($maestria, 'update');

        $validated = $request->validate($this->rules($maestria->id));
        $validated = $this->normalizeNumericFields($validated);
        $persona = $this->upsertPersona($validated);
        $mencion = $this->resolveMencion($validated['mencion_maestria_id'] ?? null);

        if ($request->hasFile('file')) {
            $validated['file_dir'] = $this->documentService->replace(
                $maestria->file_dir,
                $request->file('file'),
                $this->buildDocumentContext($validated, $persona, $mencion)
            );
        }

        $validated['updated_by'] = Auth::id();
        $validated['verificado'] = array_key_exists('verificado', $validated)
            ? (bool) $validated['verificado']
            : $maestria->verificado;

        unset($validated['file'], $validated['nombres'], $validated['paterno'], $validated['materno']);

        $maestria->update($validated);

        return redirect()
            ->route('maestrias.show', $maestria->id)
            ->with('success', 'Maestría actualizada exitosamente.');
    }

    public function destroy(string $id)
    {
        $maestria = Maestria::findOrFail($id);

        $this->authorizeAccess($maestria, 'destroy');

        $this->documentService->delete($maestria->file_dir);
        $maestria->delete();

        return redirect()
            ->route('maestrias.index')
            ->with('success', 'Maestría eliminada exitosamente.');
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
        $maestria = Maestria::findOrFail($id);
        $this->authorizeView($maestria);

        if (! $maestria->file_dir || ! Storage::disk('public')->exists($maestria->file_dir)) {
            abort(404, 'Archivo PDF no encontrado.');
        }

        $filePath = Storage::disk('public')->path($maestria->file_dir);

        return response()->file($filePath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="maestria_' . $maestria->nro_documento . '.pdf"',
        ]);
    }

    private function rules(?int $id = null): array
    {
        $nroTpnRule = Rule::unique('maestrias', 'nro_tpn');
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
            'mencion_maestria_id' => 'required|exists:menciones_maestria,id',
            'gestion_inicial' => 'nullable|integer|min:1900|max:2100',
            'gestion_final' => 'nullable|integer|min:1900|max:2100',
            'modalidad_maestria_id' => 'required|exists:modalidades_maestria,id',
            'horas_academicas' => 'nullable|integer|min:0|max:10000',
            'defensa_final' => 'nullable|integer|min:0|max:100',
            'observaciones' => 'nullable|string|max:1000',
            'verificado' => 'boolean',
            'file' => $id ? 'nullable|file|mimes:pdf|max:51200' : 'required|file|mimes:pdf|max:51200',
        ];
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

    private function normalizeNumericFields(array $validated): array
    {
        foreach (['mencion_tpn_id', 'mencion_maestria_id', 'modalidad_maestria_id'] as $field) {
            if (isset($validated[$field]) && $validated[$field] !== null) {
                $validated[$field] = (int) $validated[$field];
            }
        }

        foreach (['gestion_inicial', 'gestion_final', 'horas_academicas', 'defensa_final', 'fojas', 'libro', 'nro_documento'] as $field) {
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
                $errors['mencion_maestria_id'] = 'Debe registrar al menos una mención de maestría activa antes de crear una maestría.';
            }

            if (! $hasModalidad) {
                $errors['modalidad_maestria_id'] = 'Debe registrar al menos una modalidad de maestría activa antes de crear una maestría.';
            }

            throw ValidationException::withMessages($errors);
        }

        return false;
    }

    private function authorizeAccess(Maestria $maestria, string $action): void
    {
        $user = Auth::user();

        if ($user->hasRole('Administrador') || $user->hasRole('Administrator')) {
            return;
        }

        if ($user->hasRole('Jefe') && in_array($action, ['show'])) {
            return;
        }

        if ($user->hasRole('Personal') && $maestria->created_by === $user->getKey()) {
            return;
        }

        abort(403, 'No tiene permisos para realizar esta acción.');
    }

    private function authorizeView(Maestria $maestria): void
    {
        $user = Auth::user();

        if ($user->hasRole('Administrador') || $user->hasRole('Administrator')) {
            return;
        }

        if ($user->hasRole('Jefe')) {
            return;
        }

        if ($user->hasRole('Personal') && $maestria->created_by === $user->getKey()) {
            return;
        }

        abort(403, 'No tiene permisos para acceder a esta maestría.');
    }
}
