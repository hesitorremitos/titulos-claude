<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\DiplomaAcademico;
use App\Models\Facultad;
use App\Models\Carrera;

class DashboardController extends Controller
{
    /**
     * Mostrar el dashboard principal
     */
    public function index()
    {
        // Obtener estadísticas básicas
        $totalFacultades = Facultad::count();
        $totalCarreras = Carrera::count();
        
        // Conteo de diplomas del mes actual (solo los que puede ver el usuario según su rol)
        $diplomasEsteMes = DiplomaAcademico::query()
            ->when(auth()->user()->hasRole('Personal'), function($query) {
                return $query->where('created_by', auth()->id());
            })
            ->whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->count();

        // Obtener usuario actual
        $user = auth()->user();
        $userRole = $user->getRoleNames()->first();

        return Inertia::render('Dashboard', [
            'stats' => [
                'facultades' => $totalFacultades,
                'carreras' => $totalCarreras,
                'diplomasEsteMes' => $diplomasEsteMes,
            ],
            'user' => [
                'name' => $user->name,
                'role' => $userRole,
            ],
        ]);
    }
}