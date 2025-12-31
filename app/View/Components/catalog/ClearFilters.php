<?php

namespace App\View\Components\Catalog;

use Illuminate\View\Component;

class ClearFilters extends Component
{
    /**
     * Create a new component instance.
     *
     * Este componente no necesita lógica en el constructor
     * ya que la ruta de limpieza es fija.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): \Illuminate\Contracts\View\View
    {
        return view('components.catalog.clear-filters');
    }
}