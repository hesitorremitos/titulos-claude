<?php

use App\Http\Controllers\StyleGuideController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/v2/login');
});

// Ruta pública para la guía de estilos
Route::get('/style-guide', [StyleGuideController::class, 'index'])->name('style-guide');

// Incluir las rutas de Vue + Inertia.js definidas en routes/web-vue.php
require base_path('routes/web-vue.php');