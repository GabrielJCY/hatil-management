<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth; 

// Controladores de Empleado
use App\Http\Controllers\Employee\MuebleController; 
use App\Http\Controllers\Employee\CategoriaController; 
use App\Http\Controllers\Employee\PedidoController as EmployeePedidoController; 
use App\Http\Controllers\Employee\ProveedorController;
use App\Http\Controllers\Employee\StockController; 
use App\Http\Controllers\Employee\UserController;
use App\Http\Controllers\Employee\PagoController; 

// Controladores de Cliente / Catálogo
use App\Http\Controllers\CatalogoController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Client\DashboardController as ClientDashboardController;
use App\Http\Controllers\Client\PedidoController as ClientPedidoController; 

use App\Models\Mueble; 
use App\Models\Pedido;
use App\Models\Pago;
use App\Models\User;

// Redirección inicial al catálogo
Route::get('/', [CatalogoController::class, 'index'])->name('home');

/**
 * RUTAS DE CLIENTE (Públicas y Privadas)
 */
Route::name('client.')->group(function () {
    
    // Catálogo y Carrito (Acceso Público)
    Route::get('/catalogo', [CatalogoController::class, 'index'])->name('catalogo.index'); 
    Route::get('/muebles/{mueble}', [CatalogoController::class, 'show'])->name('muebles.show');
    Route::get('/carrito', [CarritoController::class, 'index'])->name('carrito.index');
    Route::post('/carrito/add/{mueble}', [CarritoController::class, 'add'])->name('carrito.add');
    Route::patch('/carrito/update/{mueble}', [CarritoController::class, 'update'])->name('carrito.update');
    Route::delete('/carrito/remove/{mueble}', [CarritoController::class, 'remove'])->name('carrito.remove');

    // Rutas protegidas para el Cliente
    Route::middleware(['auth'])->group(function () {
        Route::get('/client/dashboard', [ClientDashboardController::class, 'index'])->name('dashboard');
        Route::get('/mis-pedidos', [ClientPedidoController::class, 'index'])->name('misPedidos'); 
        Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
        Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    });
});

/**
 * Redirección automática por 'rol_type'
 */
Route::get('/dashboard', function () {
    $user = Auth::user();
    
    if ($user->rol_type === 'admin' || $user->rol_type === 'employee') {
        return redirect()->route('employee.dashboard');
    }

    return redirect()->route('client.dashboard');
})->middleware(['auth'])->name('dashboard');


Route::middleware(['auth'])->group(function () {
    
    // --- PERFIL ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // --- DASHBOARD DE EMPLEADO ---
    Route::get('/employee/dashboard', function () {
        $stockBajo = Mueble::whereHas('inventario', function ($query) {
            $query->where('Cantidad', '<', 5);
        })->with('inventario')->get();

        $kpis = [
            'pedidos'     => Pedido::count(),
            'pagos_total' => Pago::where('Estado', 'Completado')->sum('Monto'),
            'empleados'   => User::where('rol_type', 'admin')->count(),
            'usuarios'    => User::count(),
        ];

        $pedidosPorEstado = Pedido::selectRaw('Estado, count(*) as total')
            ->groupBy('Estado')
            ->pluck('total', 'Estado');

        // CORRECCIÓN AQUÍ: Se cambió 'cliente' por 'usuario' para coincidir con el Modelo Pedido
        $pedidosRecientes = Pedido::with('usuario')->latest()->take(5)->get();
        $pagosPendientes = Pago::with('pedido.usuario')->where('Estado', 'Pendiente')->get();

        return view('employee.dashboard', compact(
            'stockBajo', 'kpis', 'pedidosPorEstado', 'pedidosRecientes', 'pagosPendientes'
        )); 
    })->name('employee.dashboard');

    // --- MANTENIMIENTOS ADMIN/EMPLOYEE ---
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('muebles', MuebleController::class);
        Route::resource('pagos', PagoController::class);
        Route::resource('users', UserController::class); 
        Route::get('pedidos/{pedido}/pdf', [EmployeePedidoController::class, 'generatePdf'])->name('pedidos.pdf');
        Route::resource('pedidos', EmployeePedidoController::class); 
        Route::resource('categorias', CategoriaController::class); 
        Route::resource('proveedores', ProveedorController::class)->parameters(['proveedores' => 'Proveedor_id']);
        Route::resource('stock', StockController::class); 
    });
});

require __DIR__.'/auth.php';