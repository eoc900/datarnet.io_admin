<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Select2OnSelect extends Component
{
    public $idSelect2;
    
    public function __construct($idSelect2)
    {
        $this->idSelect2 = $idSelect2;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.sistema_cobros.select2-on-select');
    }
}
