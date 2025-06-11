<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Search extends Component
{
    public $placeholder;
    public $idInputSearch;
    public $idBotonBuscar;
    public $botonBuscar;
    public $filtrosBusqueda; //Array()
    public $tituloTabla;
    public $value;
    public $urlRoute;
    public function __construct($urlRoute="",$placeholder="",$idInputSearch="",$idBotonBuscar="",$botonBuscar="",$filtrosBusqueda=array(),$tituloTabla="",$value="")
    {
        $this->placeholder = $placeholder;
        $this->idInputSearch = $idInputSearch;
        $this->idBotonBuscar = $idBotonBuscar;
        $this->botonBuscar = $botonBuscar;
        $this->filtrosBusqueda = $filtrosBusqueda;
        $this->tituloTabla = $tituloTabla;
        $this->value = $value;
        $this->urlRoute = $urlRoute;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.sistema_cobros.search');
    }
}
