<?php
use App\Http\Controllers\InertiaTestController;

// Ruta de prueba para Inertia.js
Route::get('/counter', [InertiaTestController::class, 'counter'])->name('counter');
