<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Puedes pasar datos relevantes del cliente aquí, como sus pedidos
        return view('client.dashboard'); 
    }
}