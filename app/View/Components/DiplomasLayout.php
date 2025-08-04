<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class DiplomasLayout extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $sectionTitle = 'Diplomas Académicos',
        public ?string $headerExtra = null
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('layouts.diplomas-layout');
    }
}
