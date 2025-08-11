<?php

namespace App\Http\Controllers\V2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DiplomaAcademicoController extends Controller
{
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
        return Inertia::render('DiplomasAcademicos/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // TODO: Implement diploma creation logic
        return redirect()->route('v2.diplomas-academicos.index')
            ->with('success', 'Diploma académico creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Inertia::render('DiplomasAcademicos/Show', [
            'diploma' => $id // TODO: Load actual diploma data
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return Inertia::render('DiplomasAcademicos/Edit', [
            'diploma' => $id // TODO: Load actual diploma data
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
}