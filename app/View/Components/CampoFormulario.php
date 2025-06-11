<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CampoFormulario extends Component
{
    public $label;
    public $id;
    public $name;
    public $type;
    public $value;
    public $placeholder;
    public $required;
    public $parentClass;
    public $readOnly;
    public $disabled;
    public function __construct($name,$label="",$id="documento",$placeholder="",$value=null,$type="email",$required=false,$parentClass="",$readOnly="false",$disabled="false")
    {
        $this->label = $label;
        $this->id = $id;
        $this->name = $name;
        $this->type = $type;
        $this->value = $value;
        $this->placeholder = $placeholder;
        $this->required = $required;
        $this->parentClass = $parentClass;
        $this->readOnly = $readOnly;
        $this->disabled = $disabled;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.sistema_cobros.campo-formulario');
    }
}

