<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Mueble;
use App\Models\Pedido;
use App\Models\User;
use App\Models\Pago;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // 🔴 SI ES ADMIN O EMPLEADO -> MOSTRAR PANEL ADMINISTRATIVO
        if ($user->role === 'admin' || $user->role === 'employee') {
            
            // Datos para los KPIs
            $kpis = [
                'pedidos'     => Pedido::count(),
                'pagos_total' => Pago::where('Estado', 'Completado')->sum('Monto'),
                'empleados'   => User::whereIn('role', ['admin', 'employee'])->count(),
                'usuarios'    => User::count(),
            ];

            // Alerta de Stock Bajo (menos de 5 unidades)
            $stockBajo = Mueble::whereHas('inventario', function($query) {
                $query->where('Cantidad', '<', 5);
            })->with('inventario')->get();

            $pedidosPorEstado = Pedido::selectRaw('Estado, count(*) as total')
                ->groupBy('Estado')
                ->pluck('total', 'Estado');

            // ✅ CORRECCIÓN 1: Usar 'usuario' en lugar de 'cliente'
            $pedidosRecientes = Pedido::with('usuario')->latest()->take(5)->get();

            // ✅ CORRECCIÓN 2: Usar 'pedido.usuario' para los pagos
            $pagosPendientes = Pago::with('pedido.usuario')->where('Estado', 'Pendiente')->get();

            return view('dashboard', compact('kpis', 'stockBajo', 'pedidosPorEstado', 'pedidosRecientes', 'pagosPendientes'));
        }

        // 🔵 SI ES CLIENTE -> MOSTRAR PANEL DE CLIENTE
        return view('client.dashboard');
    }
}