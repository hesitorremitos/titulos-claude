<?php

namespace App\Http\Controllers;

class StyleGuideController extends Controller
{
    /**
     * Display the style guide page.
     * This is a public route that showcases all UI components
     * for design consistency and development reference.
     */
    public function index()
    {
        return view('style-guide.index');
    }
}
