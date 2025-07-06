<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SnippetOnChange extends Component
{
    /**
     * Create a new component instance.
     */
    public $idChange;
    public function __construct($idChange="")
    {
        $this->idChange = $idChange;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.sistema_cobros.snippets.snippet-on-change');
    }
}
