<?php
use App\Http\Controllers\InertiaTestController;
use App\Http\Controllers\Auth\InertiaLoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;

// Ruta de prueba para Inertia.js
//Definicion de rutas version 2
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
});
