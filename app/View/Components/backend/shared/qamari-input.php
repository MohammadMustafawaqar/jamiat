<?php

namespace App\View\Components\backend\shared;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class qamari-input extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.backend.shared.qamari-input');
    }
}
