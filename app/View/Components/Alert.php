<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Alert extends Component
{
    public $error;
    public $success;

    public function __construct($error=null,$success=null)
    {
        $this->error = $error;
        $this->success = $success;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.sistema_cobros.alert');
    }
}
