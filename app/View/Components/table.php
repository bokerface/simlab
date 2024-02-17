<?php

namespace App\View\Components;

use Illuminate\View\Component;

class table extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $kolom;
    public $isi;

    public function __construct($kolom, $isi)
    {
        $this->kolom = $kolom;
        $this->isi = $isi;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.table');
    }
}
