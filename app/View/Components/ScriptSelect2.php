<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ScriptSelect2 extends Component
{
    public $select2;
    public $idSelect2;
    public function __construct($select2="",$idSelect2="")
    {
        $this->select2 = $select2;
        $this->idSelect2 = $idSelect2;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.sistema_cobros.script-select2');
    }
}
