<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DropdownCuatrimestre extends Component
{
    public $id;
    public $label;
    public $name;
    public $selected;
    public function __construct($label="",$id="",$name="",$selected="")
    {
        $this->id = $id;
        $this->label = $label;
        $this->name = $name;
        $this->selected = $selected;
    }


    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.sistema_cobros.dropdown-cuatrimestre');
    }
}
