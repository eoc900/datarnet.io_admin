<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TagFormulario extends Component
{
    public $name;
    public $value;
    public function __construct($name,$value)
    {
        $this->value = $value;
        $this->name = $name;
    
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.sistema_cobros.tag-formulario');
    }
}
