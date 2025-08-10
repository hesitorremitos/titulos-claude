<?php
use App\Http\Controllers\InertiaTestController;
use App\Http\Controllers\Auth\InertiaLoginController;

// Ruta de prueba para Inertia.js
//Definicion de rutas version 2
Route::group(['prefix' => 'v2'], function () {

    Route::get('/counter', [InertiaTestController::class, 'counter'])->name('counter');
    // Auth
    Route::get('/login', [InertiaLoginController::class, 'create'])->name('login')
        ->middleware('guest');
    Route::post('/login', [InertiaLoginController::class, 'store'])->name('login.store')
        ->middleware('guest');
    Route::post('/logout', [InertiaLoginController::class, 'destroy'])->name('logout')
        ->middleware('auth');
});
