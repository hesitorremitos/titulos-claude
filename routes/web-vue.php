<?php

use App\Http\Controllers\Auth\InertiaLoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DiplomasAcademicos\DiplomaAcademicoController;
use App\Http\Controllers\DiplomasAcademicos\MencionController;
use App\Http\Controllers\DiplomasAcademicos\ModalidadController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\V2\CarreraController;
use App\Http\Controllers\V2\FacultadController;
use App\Http\Controllers\V2\UserController;

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')
    ->middleware('auth');

// Auth
Route::get('/login', [InertiaLoginController::class, 'create'])->name('login')
    ->middleware('guest');
Route::post('/login', [InertiaLoginController::class, 'store'])->name('login.store')
    ->middleware('guest');
Route::post('/logout', [InertiaLoginController::class, 'destroy'])->name('logout')
    ->middleware('auth');

// Profile management
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/password', [ProfileController::class, 'updatePasswordVue'])->name('profile.password');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Facultades CRUD
Route::middleware('auth')->group(function () {
    Route::resource('/facultades', FacultadController::class)->names([
        'index' => 'facultades.index',
        'create' => 'facultades.create',
        'store' => 'facultades.store',
        'show' => 'facultades.show',
        'edit' => 'facultades.edit',
        'update' => 'facultades.update',
        'destroy' => 'facultades.destroy',
    ])->parameters([
        'facultades' => 'facultad',
    ]);
});

// Carreras CRUD
Route::middleware('auth')->group(function () {
    Route::resource('/carreras', CarreraController::class)->names([
        'index' => 'carreras.index',
        'create' => 'carreras.create',
        'store' => 'carreras.store',
        'show' => 'carreras.show',
        'edit' => 'carreras.edit',
        'update' => 'carreras.update',
        'destroy' => 'carreras.destroy',
    ]);
});

// Usuarios CRUD
Route::middleware('auth')->group(function () {
    Route::resource('/usuarios', UserController::class)->names([
        'index' => 'usuarios.index',
        'create' => 'usuarios.create',
        'store' => 'usuarios.store',
        'show' => 'usuarios.show',
        'edit' => 'usuarios.edit',
        'update' => 'usuarios.update',
        'destroy' => 'usuarios.destroy',
    ])->parameters([
        'usuarios' => 'usuario',
    ]);
});

// Diplomas Académicos CRUD - Rutas específicas primero para evitar conflictos
Route::middleware('auth')->group(function () {
    // Menciones CRUD (anidadas bajo diplomas-academicos)
    Route::get('/diplomas-academicos/menciones', [MencionController::class, 'index'])->name('diplomas-academicos.menciones.index');
    Route::post('/diplomas-academicos/menciones', [MencionController::class, 'store'])->name('diplomas-academicos.menciones.store');
    Route::put('/diplomas-academicos/menciones/{mencion}', [MencionController::class, 'update'])->name('diplomas-academicos.menciones.update');
    Route::delete('/diplomas-academicos/menciones/{mencion}', [MencionController::class, 'destroy'])->name('diplomas-academicos.menciones.destroy');

    // Modalidades CRUD (anidadas bajo diplomas-academicos)
    Route::get('/diplomas-academicos/modalidades', [ModalidadController::class, 'index'])->name('diplomas-academicos.modalidades.index');
    Route::post('/diplomas-academicos/modalidades', [ModalidadController::class, 'store'])->name('diplomas-academicos.modalidades.store');
    Route::put('/diplomas-academicos/modalidades/{modalidad}', [ModalidadController::class, 'update'])->name('diplomas-academicos.modalidades.update');
    Route::delete('/diplomas-academicos/modalidades/{modalidad}', [ModalidadController::class, 'destroy'])->name('diplomas-academicos.modalidades.destroy');

    // API endpoint for person search
    Route::get('/api/{ci}', [DiplomaAcademicoController::class, 'searchPerson'])->name('api.search-person');

    // Ruta segura para servir archivos PDF
    Route::get('/diplomas-academicos/{diploma}/pdf', [DiplomaAcademicoController::class, 'servePdf'])
        ->name('diplomas-academicos.pdf');

    // Resource routes (deben ir al final para no capturar rutas específicas)
    Route::resource('/diplomas-academicos', DiplomaAcademicoController::class)->names([
        'index' => 'diplomas-academicos.index',
        'create' => 'diplomas-academicos.create',
        'store' => 'diplomas-academicos.store',
        'show' => 'diplomas-academicos.show',
        'edit' => 'diplomas-academicos.edit',
        'update' => 'diplomas-academicos.update',
        'destroy' => 'diplomas-academicos.destroy',
    ])->parameters([
        'diplomas-academicos' => 'diploma',
    ]);
});

// Incluir las rutas del prototipo CRUD base
require base_path('routes/prototipo.php');