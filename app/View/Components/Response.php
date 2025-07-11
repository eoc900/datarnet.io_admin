<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Response extends Component
{
    /**
     * Create a new component instance.
     */
    public $texto;
    public function __construct($texto="")
    {
        $this->texto = $texto;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.response');
    }
}
