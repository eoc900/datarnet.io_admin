<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DropdownFormulario extends Component
{
     public $id;
    public $label;
    public $options; // ['key1'=>'val1','key2'=>'val2']
    public $valueKey;
    public $optionKey;
    public $simpleArray;
    public $name;
    public $activo;
    public $extras;
    public $selected;
    public function __construct($label,$id="dropdown",$options=array(),$valueKey="",$optionKey="",$simpleArray=false, $name="",$selected="",$activo=null,$extras=null)
    {   
        $this->label = $label;
        $this->id = $id;
        $this->options = $options;
        $this->valueKey =$valueKey;
        $this->optionKey = $optionKey;
        $this->simpleArray = $simpleArray;
        $this->name = $name;
        $this->activo= $activo;
        $this->extras = $extras;
        $this->selected = $selected;
    }

    public function render(): View|Closure|string
    {
        return view('components.sistema_cobros.dropdown-formulario');
    }
}
