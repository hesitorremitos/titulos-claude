<?php

namespace App\Http\Controllers\V2;

use App\Http\Controllers\Controller;
use App\Models\DiplomaAcademico;
use App\Models\GraduacionDa;
use App\Models\MencionDa;
use App\Models\Persona;
use App\Services\UniversityApiService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class DiplomaAcademicoController extends Controller
{
    protected UniversityApiService $universityApiService;

    public function __construct(UniversityApiService $universityApiService)
    {
        $this->universityApiService = $universityApiService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('DiplomasAcademicos/Index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $menciones = MencionDa::all();
        $graduaciones = GraduacionDa::all();

        return Inertia::render('DiplomasAcademicos/Create', [
            'menciones' => $menciones,
            'graduaciones' => $graduaciones,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'ci' => 'required|string|max:255',
            'nombres' => 'required|string|max:255',
            'paterno' => 'required|string|max:255',
            'materno' => 'nullable|string|max:255',
            'nro_documento' => 'required|integer|min:1',
            'fojas' => 'required|integer|min:1',
            'libro' => 'required|integer|min:1',
            'fecha_emision' => 'required|date',
            'mencion_da_id' => 'required|exists:menciones_da,id',
            'graduacion_id' => 'nullable|exists:graduacion_da,id',
            'observaciones' => 'nullable|string|max:500',
            'file' => 'required|file|mimes:pdf|max:51200', // 50MB
        ]);

        try {
            // Create or update persona FIRST
            $persona = Persona::updateOrCreate(
                ['ci' => $request->ci],
                [
                    'nombres' => $request->nombres,
                    'paterno' => $request->paterno,
                    'materno' => $request->materno,
                ]
            );

            // Handle file upload using Storage
            $filePath = null;
            if ($request->hasFile('file')) {
                $filePath = $request->file('file')->store('diplomas', 'public');
            }

            // Create diploma academico
            DiplomaAcademico::create([
                'ci' => $persona->ci,
                'nro_documento' => $request->nro_documento,
                'fojas' => $request->fojas,
                'libro' => $request->libro,
                'fecha_emision' => $request->fecha_emision,
                'mencion_da_id' => $request->mencion_da_id,
                'observaciones' => $request->observaciones,
                'graduacion_id' => $request->graduacion_id,
                'file_dir' => $filePath,
                'created_by' => Auth::id(),
            ]);

            return redirect()->route('v2.diplomas-academicos.index')
                ->with('success', 'Diploma académico creado exitosamente.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Error al crear el diploma: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Inertia::render('DiplomasAcademicos/Show', [
            'diploma' => $id, // TODO: Load actual diploma data
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return Inertia::render('DiplomasAcademicos/Edit', [
            'diploma' => $id, // TODO: Load actual diploma data
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // TODO: Implement diploma update logic
        return redirect()->route('v2.diplomas-academicos.index')
            ->with('success', 'Diploma académico actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // TODO: Implement diploma deletion logic
        return redirect()->route('v2.diplomas-academicos.index')
            ->with('success', 'Diploma académico eliminado exitosamente.');
    }

    /**
     * Search person by CI in university API
     */
    public function searchPerson(string $ci): JsonResponse
    {
        try {
            // Validate CI parameter
            if (empty($ci) || strlen($ci) < 3) {
                return response()->json([
                    'success' => false,
                    'message' => 'CI debe tener al menos 3 caracteres',
                    'data' => []
                ], 400);
            }

            // Search person using University API Service
            $result = $this->universityApiService->searchPersonByCi($ci);

            if ($result['success']) {
                // The frontend expects the raw API response format, so we need to make a direct call
                // or modify the service to return the raw data
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
                'data' => []
            ], 500);
        }
    }
}
