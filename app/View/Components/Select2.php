<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Select2 extends Component
{
    public $placeholder;
    public $id;
    public $name;
    public function __construct($placeholder="", $id="",$name="")
    {
        $this->placeholder = $placeholder;
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.sistema_cobros.select2');
    }
}
