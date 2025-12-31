<?php

namespace App\View\Components\Catalog;

use Illuminate\View\Component;
use App\Models\Mueble; // Asegúrate de importar tu modelo Mueble

class ProductCard extends Component
{
    // Define la propiedad pública que recibirá el objeto Mueble
    public Mueble $mueble; 

    /**
     * El constructor recibe la variable que se le pasa desde la vista
     * y la asigna a la propiedad pública.
     */
    public function __construct(Mueble $mueble)
    {
        $this->mueble = $mueble;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): \Illuminate\Contracts\View\View
    {
        return view('components.catalog.product-card');
    }
}