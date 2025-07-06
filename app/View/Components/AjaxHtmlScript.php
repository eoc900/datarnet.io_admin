<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AjaxHtmlScript extends Component
{
    /**
     * Create a new component instance.
     */
    public $renderSectionID;
    public $routeAjaxName;
    public $ajaxCallSuffix;
    public $idCuenta;
    public $classOnChange;
    public function __construct($renderSectionID="",$routeAjaxName="",$ajaxCallSuffix="",$idCuenta="",$classOnChange="")
    {
        $this->renderSectionID = $renderSectionID;
        $this->routeAjaxName = $routeAjaxName;
        $this->ajaxCallSuffix = $ajaxCallSuffix;
        $this->idCuenta = $idCuenta;
        $this->classOnChange = $classOnChange;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.sistema_cobros.snippets.ajax-html-script');
    }
}
