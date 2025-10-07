<?php

use App\Http\Controllers\Auth\InertiaLoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Maestria\MaestriaController;
use App\Http\Controllers\Maestria\MencionController as MaestriaMencionController;
use App\Http\Controllers\Maestria\ModalidadController as MaestriaModalidadController;
use App\Http\Controllers\Doctorado\DoctoradoController;
use App\Http\Controllers\Doctorado\MencionController as DoctoradoMencionController;
use App\Http\Controllers\Doctorado\ModalidadController as DoctoradoModalidadController;
use App\Http\Controllers\DiplomaBachiller\DiplomaBachillerController;
use App\Http\Controllers\DiplomaBachiller\MencionController as MencionDBController;
use App\Http\Controllers\DiplomasAcademicos\DiplomaAcademicoController;
use App\Http\Controllers\DiplomasAcademicos\MencionController;
use App\Http\Controllers\DiplomasAcademicos\ModalidadController;
use App\Http\Controllers\TitulosProvisionNacional\TituloProvisionNacionalController;
use App\Http\Controllers\TitulosProvisionNacional\MencionController as TPNMencionController;
use App\Http\Controllers\TitulosProvisionNacional\ModalidadController as TPNModalidadController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CarreraController;
use App\Http\Controllers\FacultadController;
use App\Http\Controllers\UserController;

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

    // Títulos Provisional Nacionales
    // Menciones CRUD (anidadas bajo titulos-provision-nacional)
    Route::get('/titulos-provision-nacional/menciones', [TPNMencionController::class, 'index'])->name('titulos-provision-nacional.menciones.index');
    Route::post('/titulos-provision-nacional/menciones', [TPNMencionController::class, 'store'])->name('titulos-provision-nacional.menciones.store');
    Route::put('/titulos-provision-nacional/menciones/{mencion}', [TPNMencionController::class, 'update'])->name('titulos-provision-nacional.menciones.update');
    Route::delete('/titulos-provision-nacional/menciones/{mencion}', [TPNMencionController::class, 'destroy'])->name('titulos-provision-nacional.menciones.destroy');

    // Modalidades CRUD (anidadas bajo titulos-provision-nacional)
    Route::get('/titulos-provision-nacional/modalidades', [TPNModalidadController::class, 'index'])->name('titulos-provision-nacional.modalidades.index');
    Route::post('/titulos-provision-nacional/modalidades', [TPNModalidadController::class, 'store'])->name('titulos-provision-nacional.modalidades.store');
    Route::put('/titulos-provision-nacional/modalidades/{modalidad}', [TPNModalidadController::class, 'update'])->name('titulos-provision-nacional.modalidades.update');
    Route::delete('/titulos-provision-nacional/modalidades/{modalidad}', [TPNModalidadController::class, 'destroy'])->name('titulos-provision-nacional.modalidades.destroy');

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

// Títulos Provisional Nacionales CRUD
Route::middleware('auth')->group(function () {
    // API endpoint for person search (reutiliza el mismo de diplomas)
    Route::get('/api/{ci}', [DiplomaAcademicoController::class, 'searchPerson'])->name('api.search-person');

    // Ruta segura para servir archivos PDF
    Route::get('/titulos-provision-nacional/{titulo}/pdf', [TituloProvisionNacionalController::class, 'servePdf'])
        ->name('titulos-provision-nacional.pdf');

    // Resource routes (deben ir al final para no capturar rutas específicas)
    Route::resource('/titulos-provision-nacional', TituloProvisionNacionalController::class)->names([
        'index' => 'titulos-provision-nacional.index',
        'create' => 'titulos-provision-nacional.create',
        'store' => 'titulos-provision-nacional.store',
        'show' => 'titulos-provision-nacional.show',
        'edit' => 'titulos-provision-nacional.edit',
        'update' => 'titulos-provision-nacional.update',
        'destroy' => 'titulos-provision-nacional.destroy',
    ])->parameters([
        'titulos-provision-nacional' => 'titulo',
    ]);
});

// Maestrías CRUD
Route::middleware('auth')->group(function () {
    Route::get('/maestrias/menciones', [MaestriaMencionController::class, 'index'])->name('maestrias.menciones.index');
    Route::post('/maestrias/menciones', [MaestriaMencionController::class, 'store'])->name('maestrias.menciones.store');
    Route::put('/maestrias/menciones/{mencion}', [MaestriaMencionController::class, 'update'])->name('maestrias.menciones.update');
    Route::delete('/maestrias/menciones/{mencion}', [MaestriaMencionController::class, 'destroy'])->name('maestrias.menciones.destroy');

    Route::get('/maestrias/modalidades', [MaestriaModalidadController::class, 'index'])->name('maestrias.modalidades.index');
    Route::post('/maestrias/modalidades', [MaestriaModalidadController::class, 'store'])->name('maestrias.modalidades.store');
    Route::put('/maestrias/modalidades/{modalidad}', [MaestriaModalidadController::class, 'update'])->name('maestrias.modalidades.update');
    Route::delete('/maestrias/modalidades/{modalidad}', [MaestriaModalidadController::class, 'destroy'])->name('maestrias.modalidades.destroy');

    Route::get('/maestrias/personas/{ci}', [MaestriaController::class, 'searchPerson'])->name('maestrias.search-person');
    Route::get('/maestrias/{maestria}/pdf', [MaestriaController::class, 'servePdf'])->name('maestrias.pdf');

    Route::resource('/maestrias', MaestriaController::class)->names([
        'index' => 'maestrias.index',
        'create' => 'maestrias.create',
        'store' => 'maestrias.store',
        'show' => 'maestrias.show',
        'edit' => 'maestrias.edit',
        'update' => 'maestrias.update',
        'destroy' => 'maestrias.destroy',
    ])->parameters([
        'maestrias' => 'maestria',
    ]);
});

// Doctorados CRUD
Route::middleware('auth')->group(function () {
    Route::get('/doctorados/menciones', [DoctoradoMencionController::class, 'index'])->name('doctorados.menciones.index');
    Route::post('/doctorados/menciones', [DoctoradoMencionController::class, 'store'])->name('doctorados.menciones.store');
    Route::put('/doctorados/menciones/{mencion}', [DoctoradoMencionController::class, 'update'])->name('doctorados.menciones.update');
    Route::delete('/doctorados/menciones/{mencion}', [DoctoradoMencionController::class, 'destroy'])->name('doctorados.menciones.destroy');

    Route::get('/doctorados/modalidades', [DoctoradoModalidadController::class, 'index'])->name('doctorados.modalidades.index');
    Route::post('/doctorados/modalidades', [DoctoradoModalidadController::class, 'store'])->name('doctorados.modalidades.store');
    Route::put('/doctorados/modalidades/{modalidad}', [DoctoradoModalidadController::class, 'update'])->name('doctorados.modalidades.update');
    Route::delete('/doctorados/modalidades/{modalidad}', [DoctoradoModalidadController::class, 'destroy'])->name('doctorados.modalidades.destroy');

    Route::get('/doctorados/personas/{ci}', [DoctoradoController::class, 'searchPerson'])->name('doctorados.search-person');
    Route::get('/doctorados/{doctorado}/pdf', [DoctoradoController::class, 'servePdf'])->name('doctorados.pdf');

    Route::resource('/doctorados', DoctoradoController::class)->names([
        'index' => 'doctorados.index',
        'create' => 'doctorados.create',
        'store' => 'doctorados.store',
        'show' => 'doctorados.show',
        'edit' => 'doctorados.edit',
        'update' => 'doctorados.update',
        'destroy' => 'doctorados.destroy',
    ])->parameters([
        'doctorados' => 'doctorado',
    ]);
});

// Diplomas de Bachiller CRUD
Route::middleware('auth')->group(function () {
    // Menciones CRUD
    Route::get('/diploma-bachiller/menciones', [MencionDBController::class, 'index'])->name('diploma-bachiller.menciones.index');
    Route::post('/diploma-bachiller/menciones', [MencionDBController::class, 'store'])->name('diploma-bachiller.menciones.store');
    Route::put('/diploma-bachiller/menciones/{mencion}', [MencionDBController::class, 'update'])->name('diploma-bachiller.menciones.update');
    Route::delete('/diploma-bachiller/menciones/{mencion}', [MencionDBController::class, 'destroy'])->name('diploma-bachiller.menciones.destroy');

    // Ruta segura para servir archivos PDF
    Route::get('/diploma-bachiller/{diploma}/pdf', [DiplomaBachillerController::class, 'servePdf'])
        ->name('diploma-bachiller.pdf');

    // Resource routes
    Route::resource('/diploma-bachiller', DiplomaBachillerController::class)->names([
        'index' => 'diploma-bachiller.index',
        'create' => 'diploma-bachiller.create',
        'store' => 'diploma-bachiller.store',
        'show' => 'diploma-bachiller.show',
        'edit' => 'diploma-bachiller.edit',
        'update' => 'diploma-bachiller.update',
        'destroy' => 'diploma-bachiller.destroy',
    ])->parameters([
        'diploma-bachiller' => 'diploma',
    ]);
});

// Incluir las rutas del prototipo CRUD base
// require base_path('routes/prototipo.php');
