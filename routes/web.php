<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CarreraController;
use App\Http\Controllers\FacultadController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Rutas de autenticación
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Rutas de perfil y configuraciones
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('index');
        Route::put('/update', [ProfileController::class, 'updateProfile'])->name('update');
        Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password');
        Route::delete('/delete', [ProfileController::class, 'delete'])->name('delete');
    });

    // Rutas de gestión de facultades
    Route::prefix('facultades')->name('facultades.')->group(function () {
        // Rutas de solo lectura (disponibles para todos los usuarios autenticados)
        Route::get('/', [FacultadController::class, 'index'])->name('index');
        Route::get('/{facultad}', [FacultadController::class, 'show'])->name('show');

        // Rutas de gestión (solo para usuarios con permisos)
        Route::middleware(['permission:crear-facultades'])->group(function () {
            Route::get('/create', [FacultadController::class, 'create'])->name('create');
            Route::post('/', [FacultadController::class, 'store'])->name('store');
        });

        Route::middleware(['permission:editar-facultades'])->group(function () {
            Route::get('/{facultad}/edit', [FacultadController::class, 'edit'])->name('edit');
            Route::put('/{facultad}', [FacultadController::class, 'update'])->name('update');
        });

        Route::middleware(['permission:eliminar-facultades'])->group(function () {
            Route::delete('/{facultad}', [FacultadController::class, 'destroy'])->name('destroy');
        });
    });

    // Rutas de gestión de carreras
    Route::prefix('carreras')->name('carreras.')->group(function () {
        // Rutas de solo lectura (disponibles para todos los usuarios autenticados)
        Route::get('/', [CarreraController::class, 'index'])->name('index');
        Route::get('/{carrera}', [CarreraController::class, 'show'])->name('show');

        // Rutas de gestión (solo para usuarios con permisos)
        Route::middleware(['permission:crear-carreras'])->group(function () {
            Route::get('/create', [CarreraController::class, 'create'])->name('create');
            Route::post('/', [CarreraController::class, 'store'])->name('store');
        });

        Route::middleware(['permission:editar-carreras'])->group(function () {
            Route::get('/{carrera}/edit', [CarreraController::class, 'edit'])->name('edit');
            Route::put('/{carrera}', [CarreraController::class, 'update'])->name('update');
        });

        Route::middleware(['permission:eliminar-carreras'])->group(function () {
            Route::delete('/{carrera}', [CarreraController::class, 'destroy'])->name('destroy');
        });
    });

    // Rutas de gestión de usuarios
    Route::prefix('usuarios')->name('usuarios.')->group(function () {
        // Rutas de solo lectura (disponibles para usuarios con permiso ver-usuarios)
        Route::middleware(['permission:ver-usuarios'])->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::get('/{user}', [UserController::class, 'show'])->name('show');
        });

        // Rutas de gestión (solo para usuarios con permisos específicos)
        Route::middleware(['permission:crear-usuarios'])->group(function () {
            Route::get('/create', [UserController::class, 'create'])->name('create');
            Route::post('/', [UserController::class, 'store'])->name('store');
        });

        Route::middleware(['permission:editar-usuarios'])->group(function () {
            Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
            Route::put('/{user}', [UserController::class, 'update'])->name('update');
            Route::patch('/{user}/reset-password', [UserController::class, 'resetPassword'])->name('reset-password');
        });

        Route::middleware(['permission:eliminar-usuarios'])->group(function () {
            Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
        });
    });
});
