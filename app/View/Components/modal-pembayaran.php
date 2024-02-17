<?php

namespace App\View\Components;

use Illuminate\View\Component;

class modal_pembayaran extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $rekening;
    public function __construct($rekening = null)
    {
        $this->rekening = $rekening;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.modal-pembayaran');
    }
}
