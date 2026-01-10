<?php

namespace App\View\Components\Catalog;

use Illuminate\View\Component;
use App\Models\Mueble; 

class ProductCard extends Component
{
    public Mueble $mueble; 

   
    public function __construct(Mueble $mueble)
    {
        $this->mueble = $mueble;
    }

    
    public function render(): \Illuminate\Contracts\View\View
    {
        return view('components.catalog.product-card');
    }
}