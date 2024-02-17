<?php

namespace App\View\Components;

use Illuminate\View\Component;

class tab_pembicara extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $noPembicara;

    public function __construct($noPembicara = null)
    {
        $this->noPembicara = $noPembicara;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.tab_pembicara');
    }
}
