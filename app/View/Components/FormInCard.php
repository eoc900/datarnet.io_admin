<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FormInCard extends Component
{
    public $titulo;
    public $route;
    public $accion;
    public $id;
    public $obj;
    public function __construct($titulo="",$route="",$accion="alta",$id="",$obj="")
    {
        $this->titulo = $titulo;
        $this->route = $route;
        $this->accion = $accion;
        $this->id = $id;
        $this->obj = $obj;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.sistema_cobros.form-in-card');
    }
}
