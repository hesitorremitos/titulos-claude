<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class InertiaTestController extends Controller
{
    /**
     * Mostrar la página de contador para probar Inertia.js
     */
    public function counter()
    {
        return Inertia::render('Counter', [
            'initialCount' => 5,
        ]);
    }
}
