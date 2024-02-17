<?php

namespace App\View\Components;

use Illuminate\View\Component;

class edit_tab_pembicara extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $noPembicara;
    public $data;

    public function __construct($noPembicara, $data)
    {
        $this->noPembicara = $noPembicara;
        $this->data = $data;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.edit-tab-pembicara');
    }
}
