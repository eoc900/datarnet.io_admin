<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PageBreadcrumb extends Component
{
    public $titulo;
    public $subtitulo;
    public $go_back_link;
    public function __construct($titulo="",$subtitulo="",$go_back_link="#")
    {
        $this->titulo = $titulo;
        $this->subtitulo = $subtitulo;
        $this->go_back_link;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.sistema_cobros.page-breadcrumb');
    }
}
