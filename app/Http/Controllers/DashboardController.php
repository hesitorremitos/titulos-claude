<?php

namespace App\Http\Controllers;

use App\Models\Carrera;
use App\Models\DiplomasAcademicos\DiplomaAcademico;
use App\Models\Facultad;
use Inertia\Inertia;

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
        $user = auth()->user();

        $diplomasEsteMes = DiplomaAcademico::query()
            ->when($user && $user->activeRoleIs('Personal'), function ($query) {
                return $query->where('created_by', auth()->id());
            })
            ->whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->count();

        return Inertia::render('Dashboard', [
            'stats' => [
                'facultades' => $totalFacultades,
                'carreras' => $totalCarreras,
                'diplomasEsteMes' => $diplomasEsteMes,
            ],
            'user' => [
                'name' => $user->name,
                'role' => $user->activeRole(),
            ],
        ]);
    }
}
