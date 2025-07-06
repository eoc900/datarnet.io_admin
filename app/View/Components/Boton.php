<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Boton extends Component
{
    public $nombreBoton;
    public $type;
    public $classes;
    public $parentClass;
    public function __construct($nombreBoton="Ingresar",$type="button",$classes="",$parentClass="col-12 float-end mt-3")
    {
        $this->nombreBoton = $nombreBoton;
        $this->type = $type;
        $this->classes = $classes;
        $this->parentClass = $parentClass;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.sistema_cobros.boton');
    }
}
