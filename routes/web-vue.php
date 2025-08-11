<?php

use App\Http\Controllers\Auth\InertiaLoginController;
use App\Http\Controllers\CarreraController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FacultadController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\V2\DiplomaAcademicoController;
use App\Http\Controllers\V2\UserController;

// Ruta de prueba para Inertia.js
// Definicion de rutas version 2
Route::group(['prefix' => 'v2'], function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('v2.dashboard')
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
        Route::get('/profile', [ProfileController::class, 'show'])->name('v2.profile.show');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('v2.profile.update');
        Route::patch('/profile/password', [ProfileController::class, 'updatePasswordVue'])->name('v2.profile.password');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('v2.profile.destroy');
    });

    // Facultades CRUD
    Route::middleware('auth')->group(function () {
        Route::resource('/facultades', FacultadController::class)->names([
            'index' => 'v2.facultades.index',
            'create' => 'v2.facultades.create',
            'store' => 'v2.facultades.store',
            'show' => 'v2.facultades.show',
            'edit' => 'v2.facultades.edit',
            'update' => 'v2.facultades.update',
            'destroy' => 'v2.facultades.destroy',
        ])->parameters([
            'facultades' => 'facultad'
        ]);
    });

    // Carreras CRUD
    Route::middleware('auth')->group(function () {
        Route::resource('/carreras', CarreraController::class)->names([
            'index' => 'v2.carreras.index',
            'create' => 'v2.carreras.create',
            'store' => 'v2.carreras.store',
            'show' => 'v2.carreras.show',
            'edit' => 'v2.carreras.edit',
            'update' => 'v2.carreras.update',
            'destroy' => 'v2.carreras.destroy',
        ]);
    });

    // Usuarios CRUD
    Route::middleware('auth')->group(function () {
        Route::resource('/usuarios', UserController::class)->names([
            'index' => 'v2.usuarios.index',
            'create' => 'v2.usuarios.create',
            'store' => 'v2.usuarios.store',
            'show' => 'v2.usuarios.show',
            'edit' => 'v2.usuarios.edit',
            'update' => 'v2.usuarios.update',
            'destroy' => 'v2.usuarios.destroy',
        ])->parameters([
            'usuarios' => 'usuario'
        ]);
    });

    // Diplomas Académicos CRUD
    Route::middleware('auth')->group(function () {
        Route::resource('/diplomas-academicos', DiplomaAcademicoController::class)->names([
            'index' => 'v2.diplomas-academicos.index',
            'create' => 'v2.diplomas-academicos.create',
            'store' => 'v2.diplomas-academicos.store',
            'show' => 'v2.diplomas-academicos.show',
            'edit' => 'v2.diplomas-academicos.edit',
            'update' => 'v2.diplomas-academicos.update',
            'destroy' => 'v2.diplomas-academicos.destroy',
        ])->parameters([
            'diplomas-academicos' => 'diploma'
        ]);
    });
});
