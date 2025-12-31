<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use App\Models\Pedido; 

class PedidoController extends Controller
{
    public function index()
    {
        $pedidos = Pedido::where('UsuarioC_id', Auth::id()) 
                         ->orderBy('created_at', 'desc')
                         ->get();

        return view('client.pedidos.index', compact('pedidos'));
    }
}