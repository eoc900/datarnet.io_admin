<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ListaMensajes extends Component
{
    public $mensajes;
    public function __construct($mensajes=null)
    {
        $this->mensajes = $mensajes;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.sistema_cobros.lista-mensajes');
    }
}
